@extends('layouts.app')

@section('content')
<h2>Update Meeting #{{ $meeting['id'] }}</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('schedule.meeting.update', $meeting['id']) }}" method="POST">
    @csrf

    <label>Teacher</label>
    <input type="number" name="teacher_id" value="{{ $meeting['teacher_id'] }}">

    <label>Date</label>
    <input type="date" name="date" value="{{ $meeting['date'] }}">

    <label>Time</label>
    <input type="time" name="time" value="{{ $meeting['time'] }}">

    <label>Location</label>
    <input type="text" name="location" value="{{ $meeting['location'] }}">

    <button type="submit">Update</button>
</form>
@endsection
