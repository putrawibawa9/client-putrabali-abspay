@extends('layouts.app')

@section('content')
<h2>Update Recurring Schedule for Course {{ $courseId }}</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('schedule.recurring.update', $courseId) }}">
    @csrf

    <label>Old Day</label>
    <input type="text" name="old_day" placeholder="Sunday">

    <label>New Day</label>
    <input type="text" name="new_day" placeholder="Wednesday">

    <label>New Time</label>
    <input type="time" name="new_time">

    <label>Effective From</label>
    <input type="date" name="effective_from">

    <label>New Teacher (optional)</label>
    <input type="number" name="teacher_id">

    <label>Location (optional)</label>
    <input type="text" name="location">

    <button type="submit">Apply Recurring Change</button>
</form>
@endsection
