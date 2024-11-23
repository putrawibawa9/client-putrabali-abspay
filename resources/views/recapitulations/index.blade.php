@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Revenue Report</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <h4>Current Month Summary:</h4>
            <p>Total Payment This Month: Rp. {{ number_format($paymentRecap['totalPembayaran'], 0, ',', '.') }}</p>
            <p>New Enrollments This Month: {{ $studentRecap['sum'] }}</p>

            <!-- Filter Form -->
            <form method="GET" action="/recapitulations" class="form-inline mb-3">
                @csrf
                <label for="month" class="mr-2">Search for paid or unpaid students:</label>
                <input type="month" name="month" class="form-control mr-2" value="{{ request('month') }}">
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
            {{-- @dd($data) --}}
            <!-- Display Filtered Data -->
            {{-- @dd($data) --}}
            @if ($data)
                <div class="mt-4">
                    <h4>Filtered Data for {{ request('month') }}:</h4>
                            <div class="row">
                                {{-- @dd($data) --}}
            <!-- Paid Students Table -->
            @if (!empty($data['paid_students']) && count($data['paid_students']) > 0)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Paid Students</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nis</th>
                                        <th>Name</th>
   
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['paid_students'] as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student['nis'] }}</td>
                                            <td>{{ $student['name'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Unpaid Students Table -->
            @if (!empty($data['unpaid_students']) && count($data['unpaid_students']) > 0)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Unpaid Students</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nis</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['unpaid_students'] as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student['nis'] }}</td>
                                            <td>{{ $student['name'] }}</td>
                                            <td>Unpaid</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
                </div>
            @else
                <div class="mt-4">
                    <h4>No filtered data available</h4>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
