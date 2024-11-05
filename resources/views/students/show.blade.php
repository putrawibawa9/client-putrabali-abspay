{{-- @dd($student); --}}
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Student Payment Records</h1>
            <h2>{{ $payment['student']['name'] }}</h2>
        </div>
    </section>

    <!-- Courses the student is enrolled in -->
    <section class="content">
        <div class="container-fluid mb-4">
            <h3>Classes Enrolled</h3>
            <ul class="list-group">
                @foreach ($student['active_courses'] as $course)
                    <li class="list-group-item">{{ $course['alias'] }} - {{ $course['subject'] }}</li>
                @endforeach
            </ul>
        </div>
        <a href="/formPembayaran/print/{{ $student['id'] }}" class="btn btn-primary">Print Payment Form</a>
        <!-- Payment records for each course -->
        <div class="container-fluid">
            <h3 class="mt-4">Payment Records by Class</h3>
            @foreach ($payment['course_payments'] as $coursePayment)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title m-0">Class: {{ $coursePayment['course']['alias'] }} - {{ $coursePayment['course']['subject'] }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Payment Month</th>
                                    <th>Payment Amount</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($coursePayment['payments'] as $payment)
                                    <tr>
                                        <td>{{ $payment['payment_month'] }}</td>
                                        <td>{{ number_format($payment['payment_amount'], 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($payment['created_at'])->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No payments recorded for this class.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
