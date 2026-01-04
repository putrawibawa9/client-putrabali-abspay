@extends('layouts.main')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-2 fw-bold">Generate Semester Schedule</h2>
            <p class="text-muted mb-4">Create weekly schedules for your course semester</p>

            {{-- ERRORS --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
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
                    <h5 class="fw-semibold mb-3">Basic Information</h5>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Course</label>
                            <select name="course_id" class="form-select" required>
                                <option value="">-- Select Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course['id'] }}">{{ $course['alias'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- WEEKLY SCHEDULE --}}
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-semibold mb-0">Weekly Schedule</h5>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addDay()">Add Day</button>
                    </div>

                    <div id="schedule-area">

                        {{-- DEFAULT BLOCK (Sunday) --}}
                        <div class="schedule-block border rounded p-3 mb-3" data-day="Sunday">
                            <h6 class="fw-semibold mb-3">Schedule #1</h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Day</label>
                                    <select class="form-select day-select" required>
                                        @foreach(["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"] as $d)
                                            <option value="{{ $d }}" {{ $d === 'Sunday' ? 'selected' : '' }}>
                                                {{ $d }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Time</label>
                                    <input type="time" class="form-control time-input"
                                           name="schedule[Sunday][time]" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Teacher</label>
                                    <select class="form-select teacher-input"
                                            name="schedule[Sunday][teacher_id]" required>
                                        <option value="">-- Select Teacher --</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Location</label>
                                    <input type="text" class="form-control location-input"
                                           name="schedule[Sunday][location]">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <hr>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        Generate Schedule
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- STYLE --}}
<style>
.schedule-block { background:#f8f9fa; }
</style>

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
        <div class="schedule-block border rounded p-3 mb-3" data-day="${day}">
            <div class="d-flex justify-content-between mb-3">
                <h6 class="fw-semibold">Schedule #${count}</h6>
                <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.schedule-block').remove()">Remove</button>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Day</label>
                    <select class="form-select day-select" required>
                        ${days.map(d => `<option value="${d}" ${d===day?'selected':''}>${d}</option>`).join('')}
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Time</label>
                    <input type="time" class="form-control time-input"
                           name="schedule[${day}][time]" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Teacher</label>
                    <select class="form-select teacher-input"
                            name="schedule[${day}][teacher_id]" required>
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control location-input"
                           name="schedule[${day}][location]">
                </div>
            </div>
        </div>
    `);
}

// 🔑 CORE LOGIC: sync DAY → name[]
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

    block.querySelector('.time-input').name      = `schedule[${newDay}][time]`;
    block.querySelector('.teacher-input').name   = `schedule[${newDay}][teacher_id]`;
    block.querySelector('.location-input').name  = `schedule[${newDay}][location]`;
});
</script>
@endsection
