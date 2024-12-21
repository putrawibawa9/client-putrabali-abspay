{{-- @dd($students) --}}
@extends('layouts-old.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Advanced Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Search and Select Student</h3>
                </div>

                <div class="card-body">
                    <!-- Search Form -->
                    <form id="searchForm" method="POST" action="/students/payment/search" class="mb-3">
                        @csrf
                        <div class="form-group">
                            <label for="studentSearch">Search Student</label>
                            <input name="search" type="text" id="studentSearch" class="form-control" placeholder="Enter student name or NIM...">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>

                    <!-- Student Selection -->
                    <form method="POST" action="/students/payment/select">
                        @csrf
                        <div class="form-group">
                            <label>Select a Student</label>
                            <div class="student-list border p-3 rounded" style="max-height: 300px; overflow-y: auto;">
                                @foreach ($students as $student)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="id" id="student{{ $student['id'] }}" value="{{ $student['id'] }}">
                                        <label class="form-check-label" for="student{{ $student['id'] }}">
                                            {{ $student['name'] }} (NIS: {{ $student['nis'] }})
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Select Student</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
