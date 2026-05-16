<?php

namespace App\Http\Controllers\Schedule;

use App\Services\RecurringScheduleService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class ScheduleController extends Controller
{
    protected Client $client;
    protected string $baseUrl;
    protected RecurringScheduleService $recurringScheduleService;

    public function __construct(Client $client, RecurringScheduleService $recurringScheduleService)
    {
        $this->client = $client;
        $this->baseUrl = rtrim(config('services.api.base_url'), '/');
        $this->recurringScheduleService = $recurringScheduleService;
    }


    /* ===============================
        1. GENERATE SEMESTER
    ================================ */

    public function showGenerateForm()
    {

        $courses = $this->client->get($this->baseUrl . '/courses');
        $courses = json_decode($courses->getBody(), true);
        $courses = $courses['data'];
   
        $teachers = $this->client->get($this->baseUrl . '/teachers');
        $teachers = json_decode($teachers->getBody(), true);    
        $teachers = $teachers['data'];
  

        $activeRoute    = 'generate-semester';
        return view('schedules.generate', compact('activeRoute', 'courses', 'teachers'));
    }

    public function showRecurringCreateForm()
    {
        [$courses, $teachers] = $this->getScheduleFormOptions();

        return view('schedules.recurring-create', [
            'activeRoute' => 'recurring-schedule-create',
            'courses' => $courses,
            'teachers' => $teachers,
            'schedule' => $this->defaultRecurringSchedule(),
            'frequencyOptions' => $this->frequencyOptions(),
            'dayOptions' => $this->dayOptions(),
            'impactMode' => old('impact_mode', 'update_future'),
        ]);
    }

    public function recurringIndex(Request $request)
    {
        [$courses, $teachers] = $this->getScheduleFormOptions();
        $filters = $request->only(['teacher_id', 'course_id', 'is_active', 'frequency']);

        try {
            $response = $this->recurringScheduleService->list($filters);
        } catch (RuntimeException $e) {
            return view('schedules.recurring-index', [
                'activeRoute' => 'recurring-schedules',
                'courses' => $courses,
                'teachers' => $teachers,
                'schedules' => collect(),
                'filters' => $filters,
                'summary' => $this->emptyRecurringSummary(),
                'frequencyOptions' => $this->frequencyOptions(),
                'dayOptions' => $this->dayOptions(),
                'loadError' => $e->getMessage(),
            ]);
        }

        $schedules = collect($response['data'] ?? [])
            ->map(fn ($schedule) => $this->transformRecurringSchedule($schedule))
            ->values();

        return view('schedules.recurring-index', [
            'activeRoute' => 'recurring-schedules',
            'courses' => $courses,
            'teachers' => $teachers,
            'schedules' => $schedules,
            'filters' => $filters,
            'summary' => $this->buildRecurringSummary($schedules),
            'frequencyOptions' => $this->frequencyOptions(),
            'dayOptions' => $this->dayOptions(),
            'loadError' => null,
        ]);
    }

    public function storeRecurringSchedule(Request $request)
    {
        $payload = $this->sanitizeRecurringPayload($this->validateRecurringSchedule($request));

        try {
            $response = $this->recurringScheduleService->create($payload);
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('schedule.recurring.index')
            ->with('success', $response['message'] ?? 'Recurring schedule berhasil dibuat.');
    }

    public function updateRecurringScheduleV2(Request $request, int $scheduleId)
    {
        $payload = $this->sanitizeRecurringPayload($this->validateRecurringSchedule($request));

        try {
            $response = $this->recurringScheduleService->update($scheduleId, $payload);
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('schedule.recurring.index', $request->only(['teacher_id', 'course_id', 'is_active', 'frequency']))
            ->with('success', $response['message'] ?? 'Recurring schedule berhasil diperbarui.');
    }

    public function destroyRecurringSchedule(Request $request, int $scheduleId)
    {
        $validated = $request->validate([
            'effective_from' => ['required', 'date'],
            'end_behavior' => ['nullable', 'in:deactivate,delete'],
            'impact_mode' => ['nullable', 'in:update_future,keep_existing,delete_future'],
        ], [
            'effective_from.required' => 'Tanggal efektif wajib diisi.',
        ]);

        $payload = [
            'effective_from' => $validated['effective_from'],
            'end_behavior' => $validated['end_behavior'] ?? 'deactivate',
            'impact_mode' => $validated['impact_mode'] ?? 'update_future',
        ];

        try {
            $response = $this->recurringScheduleService->deleteOrDeactivate($scheduleId, $payload);
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('schedule.recurring.index', $request->only(['teacher_id', 'course_id', 'is_active', 'frequency']))
            ->with('success', $response['message'] ?? 'Recurring schedule berhasil diperbarui statusnya.');
    }

 public function generateSemester(Request $request)
{
    try {

        $payload = [
            'course_id'   => $request->course_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'schedule'    => $request->schedule
        ];
     
        // coba test uri yang benar
// dd($payload);
     
        $response = $this->client->post($this->baseUrl . '/scheduling/generateSemester', [
            'headers' => [
                    'Accept' => 'application/json',
                ],
            'json' => $payload
        ]);
     
        $data = json_decode($response->getBody(), true);

        return back()->with('success', $data['message']);

    } catch (\GuzzleHttp\Exception\ClientException $e) {

        $response = $e->getResponse();
        $body = json_decode($response->getBody()->getContents(), true);

        /** ------------------------------
         *  HANDLE VALIDATION ERROR (422)
         * ------------------------------ */
        if ($response->getStatusCode() === 422) {

            // PRIORITAS: gunakan message singkat bawaan BE
            $mainMessage = $body['message'] ?? 'Terjadi kesalahan validasi.';

            return back()
                ->with('error', $mainMessage)
                ->withErrors($body['errors'] ?? [])
                ->withInput();
        }

        /** ------------------------------
         *  HANDLE ERROR LAIN
         * ------------------------------ */
        return back()->with('error', 'Server Error.')->withInput();
    }
}






    /* ===============================
        2. UPDATE SINGLE MEETING
    ================================ */

    public function showUpdateForm($id)
    {

        $response = $this->client->get($this->baseUrl . '/scheduling/meeting/' . "$id");
      
        $meeting = json_decode($response->getBody(), true);
       $activeRoute    = 'update-meeting';

        return view('schedules.update-meeting', compact('meeting', 'activeRoute'));
    }

    public function updateMeeting(Request $request, $id)
    {
        $payload = $request->only(['teacher_id', 'date', 'time', 'location']);

        $response = $this->api->post("meeting/$id/update", [
            'json' => $payload
        ]);

        $data = json_decode($response->getBody(), true);

        return redirect()->back()->with('success', $data['message']);
    }


    /* ===============================
        3. UPDATE RECURRING SCHEDULE
    ================================ */

    public function showRecurringForm($courseId)
    {
        return view('schedule.update-recurring', compact('courseId'));
    }

    public function updateRecurringSchedule(Request $request, $courseId)
    {
        $payload = [
            'old_day'        => $request->old_day,
            'new_day'        => $request->new_day,
            'new_time'       => $request->new_time,
            'effective_from' => $request->effective_from,
            'teacher_id'     => $request->teacher_id,
            'location'       => $request->location
        ];

        $response = $this->api->post("course/$courseId/change-recurring-schedule", [
            'json' => $payload
        ]);

        $data = json_decode($response->getBody(), true);

        return redirect()->back()->with('success', $data['message']);
    }


     public function index($id, Request $req)
    {
      
        $type = $req->type ?? 'future';

        $base = env('API_BASE_URL', 'http://localhost:8000/api');
   

        $url = "{$base}/scheduling/schedule";
// dd($url);
        $response = Http::get($url, [
            'teacher_id' => $id,
            'type'       => $type
        ]);
        // dd($response->json());

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil jadwal guru.');
        }

        $schedule = $response->json();

        return view('schedules.teacher-schedules', [
            'activeRoute' => 'teacher-schedule',
            'teacherId' => $id,
            'type'      => $type,
            'schedule'  => $schedule['data'] ?? [],
            'count'     => $schedule['count'] ?? 0,
        ]);
    }


    public function getAllSchedules(){
        $response = $this->client->get($this->baseUrl . '/scheduling/all-schedules');
        // dd($response);
        $schedules = json_decode($response->getBody(), true);
        $schedules = $schedules['data'];
// dd($schedules);

$teachers = $this->client->get($this->baseUrl . '/teachers');
// dd($teachers);
$teachers = json_decode($teachers->getBody(), true);    
$teachers = $teachers['data'];
// dd($teachers);
$courses = $this->client->get($this->baseUrl . '/courses');
$courses = json_decode($courses->getBody(), true);    
$courses = $courses['data'];
// dd($courses);
        $activeRoute    = 'all-schedules';
        return view('schedules.all-schedule', compact('activeRoute', 'schedules', 'teachers', 'courses') );
    }

    protected function getScheduleFormOptions(): array
    {
        $courses = $this->client->get($this->baseUrl . '/courses');
        $courses = json_decode($courses->getBody(), true);

        $teachers = $this->client->get($this->baseUrl . '/teachers');
        $teachers = json_decode($teachers->getBody(), true);

        return [
            $courses['data'] ?? [],
            $teachers['data'] ?? [],
        ];
    }

    protected function validateRecurringSchedule(Request $request): array
    {
        $validated = $request->validate([
            'course_id' => ['required', 'integer'],
            'teacher_id' => ['required', 'integer'],
            'frequency' => ['required', 'in:weekly,monthly'],
            'day_of_week' => ['nullable', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'day_of_month' => ['nullable', 'integer', 'between:1,31'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'time' => ['required', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:time'],
            'location' => ['nullable', 'string', 'max:255'],
        ], [
            'course_id.required' => 'Kelas wajib dipilih.',
            'teacher_id.required' => 'Guru wajib dipilih.',
            'frequency.required' => 'Frekuensi wajib dipilih.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'time.required' => 'Jam mulai wajib diisi.',
            'end_time.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        if ($validated['frequency'] === 'weekly' && empty($validated['day_of_week'])) {
            throw ValidationException::withMessages([
                'day_of_week' => 'Hari wajib dipilih untuk jadwal mingguan.',
            ]);
        }

        if ($validated['frequency'] === 'monthly' && empty($validated['day_of_month'])) {
            throw ValidationException::withMessages([
                'day_of_month' => 'Tanggal bulanan wajib diisi untuk jadwal bulanan.',
            ]);
        }

        if ($validated['frequency'] === 'weekly') {
            $validated['day_of_month'] = null;
        }

        if ($validated['frequency'] === 'monthly') {
            $validated['day_of_week'] = null;
        }

        return $validated;
    }

    protected function sanitizeRecurringPayload(array $validated): array
    {
        $payload = [
            'course_id' => (int) $validated['course_id'],
            'teacher_id' => (int) $validated['teacher_id'],
            'frequency' => $validated['frequency'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'time' => $validated['time'],
        ];

        if (!empty($validated['end_time'])) {
            $payload['end_time'] = $validated['end_time'];
        }

        if (!empty($validated['location'])) {
            $payload['location'] = trim($validated['location']);
        }

        if ($validated['frequency'] === 'weekly') {
            $payload['day_of_week'] = $validated['day_of_week'];
        }

        if ($validated['frequency'] === 'monthly') {
            $payload['day_of_month'] = (int) $validated['day_of_month'];
        }

        return $payload;
    }

    protected function transformRecurringSchedule(array $schedule): array
    {
        $course = $schedule['course'] ?? [];
        $teacher = $schedule['teacher'] ?? [];
        $startDate = $schedule['start_date'] ?? null;
        $endDate = $schedule['end_date'] ?? null;
        $frequency = $schedule['frequency'] ?? 'weekly';
        $teacherLabel = $schedule['teacher_name'] ?? null;
        $teacherLabel = is_string($teacherLabel) && $teacherLabel !== '' ? $teacherLabel : null;
        $teacherValue = $schedule['teacher'] ?? null;
        $teacherLabel = $teacherLabel
            ?? (is_string($teacherValue) && $teacherValue !== '' ? $teacherValue : null)
            ?? ($teacher['name'] ?? '-');
        $courseLabel = $schedule['course_alias']
            ?? $schedule['course_name']
            ?? $course['alias']
            ?? $course['name']
            ?? '-';

        return [
            'id' => $schedule['id'] ?? null,
            'course_id' => $schedule['course_id'] ?? $course['id'] ?? null,
            'teacher_id' => $schedule['teacher_id'] ?? $teacher['id'] ?? null,
            'course_label' => $courseLabel,
            'teacher_label' => $teacherLabel,
            'frequency' => $frequency,
            'day_of_week' => $schedule['day_of_week'] ?? null,
            'day_of_month' => $schedule['day_of_month'] ?? null,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'time' => $schedule['time'] ?? null,
            'end_time' => $schedule['end_time'] ?? null,
            'location' => $schedule['location'] ?? null,
            'is_active' => (bool) ($schedule['is_active'] ?? false),
            'future_meetings_count' => $schedule['future_meetings_count']
                ?? $schedule['upcoming_meetings_count']
                ?? $schedule['future_count']
                ?? null,
            'recurrence_label' => $this->buildRecurrenceLabel($frequency, $schedule),
            'period_label' => $this->buildPeriodLabel($startDate, $endDate),
            'status_label' => ($schedule['is_active'] ?? false) ? 'Aktif' : 'Nonaktif',
        ];
    }

    protected function buildRecurrenceLabel(string $frequency, array $schedule): string
    {
        if ($frequency === 'monthly') {
            $dayOfMonth = $schedule['day_of_month'] ?? '-';
            return "Bulanan - tanggal {$dayOfMonth}";
        }

        $dayOfWeek = $schedule['day_of_week'] ?? '-';
        return "Mingguan - {$dayOfWeek}";
    }

    protected function buildPeriodLabel(?string $startDate, ?string $endDate): string
    {
        $start = $startDate ? Carbon::parse($startDate)->translatedFormat('d M Y') : '-';
        $end = $endDate ? Carbon::parse($endDate)->translatedFormat('d M Y') : 'Tanpa batas';

        return "{$start} - {$end}";
    }

    protected function buildRecurringSummary(Collection $schedules): array
    {
        return [
            'total' => $schedules->count(),
            'active' => $schedules->where('is_active', true)->count(),
            'inactive' => $schedules->where('is_active', false)->count(),
            'weekly' => $schedules->where('frequency', 'weekly')->count(),
            'monthly' => $schedules->where('frequency', 'monthly')->count(),
        ];
    }

    protected function emptyRecurringSummary(): array
    {
        return [
            'total' => 0,
            'active' => 0,
            'inactive' => 0,
            'weekly' => 0,
            'monthly' => 0,
        ];
    }

    protected function defaultRecurringSchedule(): array
    {
        return [
            'course_id' => old('course_id'),
            'teacher_id' => old('teacher_id'),
            'frequency' => old('frequency', 'weekly'),
            'day_of_week' => old('day_of_week', 'Monday'),
            'day_of_month' => old('day_of_month', 1),
            'start_date' => old('start_date', now()->toDateString()),
            'end_date' => old('end_date'),
            'time' => old('time'),
            'end_time' => old('end_time'),
            'location' => old('location'),
        ];
    }

    protected function frequencyOptions(): array
    {
        return [
            'weekly' => 'Mingguan',
            'monthly' => 'Bulanan',
        ];
    }

    protected function dayOptions(): array
    {
        return [
            'Monday' => 'Monday',
            'Tuesday' => 'Tuesday',
            'Wednesday' => 'Wednesday',
            'Thursday' => 'Thursday',
            'Friday' => 'Friday',
            'Saturday' => 'Saturday',
            'Sunday' => 'Sunday',
        ];
    }
}
