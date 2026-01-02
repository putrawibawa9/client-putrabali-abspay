@extends('layouts.main')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row">
        <div class="col-12">
            
            {{-- Header Section --}}
            <div class="mb-4">
                <h2 class="mb-2 fw-bold text-dark">Generate Semester Schedule</h2>
                <p class="text-muted mb-0">Create weekly schedules for your course semester</p>
            </div>

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
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-start">
                        <strong>Please correct the following errors:</strong>
                    </div>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Main Form --}}
            <form method="POST" action="{{ route('schedule.generate.submit') }}">
                @csrf

                {{-- Basic Information Section --}}
                <div class="mb-4">
                    <h5 class="mb-3 fw-semibold">Basic Information</h5>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Course <span class="text-danger">*</span></label>
                            <select name="course_id" class="form-select" required>
                                <option value="">-- Select Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course['id'] }}">{{ $course['alias'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Weekly Schedule Section --}}
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-1 fw-semibold">Weekly Schedule</h5>
                            <small class="text-muted">You can add up to 4 different days per week</small>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="addDay()">
                            Add Day
                        </button>
                    </div>

                    <div id="schedule-area">
                        {{-- DEFAULT: Sunday --}}
                        <div class="schedule-block mb-3 p-3 border rounded" data-day="Sunday">
                            <h6 class="mb-3 fw-semibold">Schedule #1</h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Day <span class="text-danger">*</span></label>
                                    <select name="schedule[Sunday][day]" class="form-select day-select" required>
                                        @foreach(["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"] as $d)
                                            <option value="{{ $d }}" {{ $d === 'Sunday' ? 'selected' : '' }}>
                                                {{ $d }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Time <span class="text-danger">*</span></label>
                                    <input type="time" name="schedule[Sunday][time]" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Teacher <span class="text-danger">*</span></label>
                                    <select name="schedule[Sunday][teacher_id]" class="form-select" required>
                                        <option value="">-- Select Teacher --</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="schedule[Sunday][location]" class="form-control" placeholder="e.g., Room 101">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Action Buttons --}}
                <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        Generate Schedule
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<style>
.schedule-block {
    background-color: #f8f9fa;
    transition: all 0.2s ease;
}

.schedule-block:hover {
    background-color: #e9ecef;
}

.form-control,
.form-select {
    border: 1px solid #dee2e6;
}

.form-control:focus,
.form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>

<script>
let count = 1;
const maxDays = 4;

// Valid days
const validDays = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];

function getUsedDays() {
    const selects = document.querySelectorAll('.day-select');
    return Array.from(selects).map(sel => sel.value);
}

function removeScheduleBlock(button) {
    const block = button.closest('.schedule-block');
    block.remove();
    count--;
    updateScheduleNumbers();
}

function updateScheduleNumbers() {
    const blocks = document.querySelectorAll('.schedule-block');
    blocks.forEach((block, index) => {
        const header = block.querySelector('h6');
        if (header) {
            header.textContent = `Schedule #${index + 1}`;
        }
    });
    count = blocks.length;
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

    const day = availableDays[0];
    count++;

    const html = `
        <div class="schedule-block mb-3 p-3 border rounded" data-day="${day}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 fw-semibold">Schedule #${count}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeScheduleBlock(this)">
                    Remove
                </button>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Day <span class="text-danger">*</span></label>
                    <select name="schedule[${day}][day]" class="form-select day-select" required>
                        ${validDays.map(d => `
                            <option value="${d}" ${d === day ? 'selected' : ''}>${d}</option>
                        `).join('')}
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Time <span class="text-danger">*</span></label>
                    <input type="time" name="schedule[${day}][time]" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Teacher <span class="text-danger">*</span></label>
                    <select name="schedule[${day}][teacher_id]" class="form-select" required>
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" name="schedule[${day}][location]" class="form-control" placeholder="e.g., Room 101">
                </div>
            </div>
        </div>
    `;

    document.getElementById("schedule-area").insertAdjacentHTML("beforeend", html);
}
</script>

@endsection