@dd($student)
@extends('layouts-old.main')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Student Payment Records for {{ $data['student']['name']}}</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @foreach ($data['course_payments'] as $coursePayment)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Class: {{ $coursePayment['course']['alias'] }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Payment Month</th>
                                    <th>Payment Amount</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                    {{-- @dd($data) --}}

                                @forelse ($coursePayment['payments'] as $payment)
                                    <tr>
                                        <td>{{ $payment['payment_month'] }}</td>
                                        <td>{{ $payment['payment_amount']}}</td>
                                        <td>{{ $payment['created_at'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No payments recorded for this class.</td>
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
