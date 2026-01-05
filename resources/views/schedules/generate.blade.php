@extends('layouts.main')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="row">
        <div class="col-12">

            <h2 class="mb-2 fw-bold text-gray-900 dark:text-gray-100">
                BUAT JADWAL 
            </h2>

            <p class="mb-4 text-gray-600 dark:text-gray-400">
               Buat jadwal guru dan siswa untuk semester atau periode tertentu.
            </p>

            {{-- ERRORS --}}
            @if($errors->any())
                <div class="mb-4 rounded-lg p-4
                            bg-red-100 text-red-800
                            dark:bg-red-900 dark:text-red-200">
                    <ul class="mb-0 list-disc ps-4">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('schedule.generate.submit') }}">
                @csrf

                {{-- BASIC INFO --}}
                <div class="mb-4">
                    <h5 class="fw-semibold mb-3 text-gray-900 dark:text-gray-100">
                        INFORMASI DASAR
                    </h5>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-gray-700 dark:text-gray-300">
                              KELAS
                            </label>
                            <select name="course_id" required
                                class="form-select bg-white text-gray-900
                                       dark:bg-gray-700 dark:text-gray-100
                                       dark:border-gray-600">
                                <option value="">-- Select Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course['id'] }}">
                                        {{ $course['alias'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-gray-700 dark:text-gray-300">
                                Awal Periode
                            </label>
                            <input type="date" name="start_date" required
                                   class="form-control bg-white text-gray-900
                                          dark:bg-gray-700 dark:text-gray-100
                                          dark:border-gray-600">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-gray-700 dark:text-gray-300">
                                Akhir Periode
                            </label>
                            <input type="date" name="end_date" required
                                   class="form-control bg-white text-gray-900
                                          dark:bg-gray-700 dark:text-gray-100
                                          dark:border-gray-600">
                        </div>
                    </div>
                </div>

                <hr class="dark:border-gray-700">

                {{-- WEEKLY SCHEDULE --}}
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-semibold mb-0 text-white-900 dark:text-gray-100">
                         TENTUKAN HARI
                        </h5>
                    <button type="button"
        onclick="addDay()"
        class="px-4 py-2 rounded-lg text-sm font-semibold
               bg-blue-600 text-white
               hover:bg-blue-700
               focus:outline-none focus:ring-2 focus:ring-blue-400
               dark:bg-blue-500 dark:hover:bg-blue-600
               dark:focus:ring-blue-300">
    Tambah Hari
</button>

                    </div>

                    <div id="schedule-area">

                        {{-- DEFAULT BLOCK --}}
                        <div class="schedule-block border rounded-lg p-3 mb-3
                                    bg-white text-gray-900
                                    dark:bg-gray-800 dark:text-gray-100
                                    dark:border-gray-700"
                             data-day="Sunday">

                            <h6 class="fw-semibold mb-3">
                                Jadwal #1
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Hari</label>
                                    <select class="form-select day-select
                                                   bg-white text-gray-900
                                                   dark:bg-gray-700 dark:text-gray-100
                                                   dark:border-gray-600"
                                            required>
                                        @foreach(["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"] as $d)
                                            <option value="{{ $d }}" {{ $d === 'Sunday' ? 'selected' : '' }}>
                                                {{ $d }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jam</label>
                                    <input type="time"
                                           name="schedule[Sunday][time]"
                                           required
                                           class="form-control time-input
                                                  bg-white text-gray-900
                                                  dark:bg-gray-700 dark:text-gray-100
                                                  dark:border-gray-600">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Guru</label>
                                    <select name="schedule[Sunday][teacher_id]"
                                            required
                                            class="form-select teacher-input
                                                   bg-white text-gray-900
                                                   dark:bg-gray-700 dark:text-gray-100
                                                   dark:border-gray-600">
                                        <option value="">-- Select Teacher --</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher['id'] }}">
                                                {{ $teacher['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Ruang</label>
                                    <input type="text"
                                           name="schedule[Sunday][location]"
                                           class="form-control location-input
                                                  bg-white text-gray-900
                                                  dark:bg-gray-700 dark:text-gray-100
                                                  dark:border-gray-600">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <hr class="dark:border-gray-700">

                <div class="text-end">
                 <button type="submit"
       class="px-4 py-2 rounded-lg text-sm font-semibold
               bg-blue-600 text-white
               hover:bg-blue-700
               focus:outline-none focus:ring-2 focus:ring-blue-400
               dark:bg-blue-500 dark:hover:bg-blue-600
               dark:focus:ring-blue-300">
               
    Generate Schedule
</button>

                </div>

            </form>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
let count = 1;
const maxDays = 4;
const days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];

function getUsedDays() {
    return Array.from(document.querySelectorAll('.schedule-block'))
        .map(b => b.dataset.day);
}

function addDay() {
    if (count >= maxDays) {
        alert("Max 4 days per week");
        return;
    }

    const available = days.filter(d => !getUsedDays().includes(d));
    if (!available.length) return;

    const day = available[0];
    count++;

    document.getElementById('schedule-area').insertAdjacentHTML('beforeend', `
        <div class="schedule-block border rounded-lg p-3 mb-3
                    bg-white text-gray-900
                    dark:bg-gray-800 dark:text-gray-100
                    dark:border-gray-700"
             data-day="${day}">

            <div class="d-flex justify-content-between mb-3">
                <h6 class="fw-semibold">Schedule #${count}</h6>
                <button type="button"
                        class="btn btn-sm btn-danger"
                        onclick="this.closest('.schedule-block').remove()">
                    Remove
                </button>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Day</label>
                    <select class="form-select day-select
                                   bg-white text-gray-900
                                   dark:bg-gray-700 dark:text-gray-100
                                   dark:border-gray-600"
                            required>
                        ${days.map(d => `<option value="${d}" ${d===day?'selected':''}>${d}</option>`).join('')}
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Time</label>
                    <input type="time"
                           name="schedule[${day}][time]"
                           required
                           class="form-control time-input
                                  bg-white text-gray-900
                                  dark:bg-gray-700 dark:text-gray-100
                                  dark:border-gray-600">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Teacher</label>
                    <select name="schedule[${day}][teacher_id]"
                            required
                            class="form-select teacher-input
                                   bg-white text-gray-900
                                   dark:bg-gray-700 dark:text-gray-100
                                   dark:border-gray-600">
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text"
                           name="schedule[${day}][location]"
                           class="form-control location-input
                                  bg-white text-gray-900
                                  dark:bg-gray-700 dark:text-gray-100
                                  dark:border-gray-600">
                </div>
            </div>
        </div>
    `);
}

document.addEventListener('change', function(e) {
    if (!e.target.classList.contains('day-select')) return;

    const block = e.target.closest('.schedule-block');
    const oldDay = block.dataset.day;
    const newDay = e.target.value;

    if (getUsedDays().includes(newDay) && newDay !== oldDay) {
        alert(`Day ${newDay} already used`);
        e.target.value = oldDay;
        return;
    }

    block.dataset.day = newDay;
    block.querySelector('.time-input').name     = `schedule[${newDay}][time]`;
    block.querySelector('.teacher-input').name  = `schedule[${newDay}][teacher_id]`;
    block.querySelector('.location-input').name = `schedule[${newDay}][location]`;
});
</script>
@endsection
