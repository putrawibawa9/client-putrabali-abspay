@extends('layouts.main')

@section('content')
<h2>Generate Semester Schedule</h2>

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <script>alert("{{ session('success') }}");</script>
@endif

{{-- ERROR MESSAGE --}}
@if(session('error'))
    <script>alert("{{ session('error') }}");</script>
@endif

{{-- VALIDATION ERRORS --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('schedule.generate.submit') }}">
    @csrf

    {{-- course iteration --}}
    <label>Course</label>
    <select name="course_id" required>
        @foreach($courses as $course)
            <option value="{{ $course['id'] }}">{{ $course['alias'] }}</option>
        @endforeach
    </select>

    <label>Start Date</label>
    <input type="date" name="start_date" required>

    <label>End Date</label>
    <input type="date" name="end_date" required>

    <h4>Weekly Schedule</h4>
    <small>Bisa menambahkan hingga 4 hari berbeda</small>

    <div id="schedule-area">

        {{-- DEFAULT: Sunday --}}
        <div class="schedule-block" data-day="Sunday">
            <h5>Schedule #1</h5>

            <label>Day</label>
            <select name="schedule[Sunday][day]" class="day-select" required>
                @foreach(["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"] as $d)
                    <option value="{{ $d }}" {{ $d === 'Sunday' ? 'selected' : '' }}>
                        {{ $d }}
                    </option>
                @endforeach
            </select>

            <label>Time</label>
            <input type="time" name="schedule[Sunday][time]" required>

            <label>Teacher</label>
            <select name="schedule[Sunday][teacher_id]" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}</option>
                @endforeach
            </select>

            <label>Location</label>
            <input type="text" name="schedule[Sunday][location]">
        </div>

    </div>

    <button type="button" onclick="addDay()">+ Add Another Day</button>

    <br><br>
    <button type="submit">Generate</button>
</form>

<script>
let count = 1;
const maxDays = 4;

// Valid days
const validDays = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];

function getUsedDays() {
    const selects = document.querySelectorAll('.day-select');
    return Array.from(selects).map(sel => sel.value);
}

function addDay() {
    if (count >= maxDays) {
        alert("Maksimal 4 hari dalam seminggu.");
        return;
    }

    const usedDays = getUsedDays();
    const availableDays = validDays.filter(d => !usedDays.includes(d));

    if (availableDays.length === 0) {
        alert("Semua hari sudah dipilih.");
        return;
    }

    const day = availableDays[0]; // pilih hari pertama yang belum dipakai

    count++;

    const html = `
        <div class="schedule-block" data-day="${day}">
            <h5>Schedule #${count}</h5>

            <label>Day</label>
            <select name="schedule[${day}][day]" class="day-select" required>
                ${validDays.map(d => `
                    <option value="${d}" ${d === day ? 'selected' : ''}>${d}</option>
                `).join('')}
            </select>

            <label>Time</label>
            <input type="time" name="schedule[${day}][time]" required>

            <label>Teacher</label>
            <select name="schedule[${day}][teacher_id]" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}</option>
                @endforeach
            </select>

            <label>Location</label>
            <input type="text" name="schedule[${day}][location]">
        </div>
    `;

    document.getElementById("schedule-area").insertAdjacentHTML("beforeend", html);
}
</script>

@endsection
