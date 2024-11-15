{{-- @dd($paymentRecap) --}}
@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Revenue Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Revenue Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Current Month Summary</h3>
                </div>

                <div class="card-body">
                    <!-- Display Revenue Summary -->
                    <div id="revenueSummary" class="mt-3">
                        <h4>Revenue Summary:</h4>
                        <p>Total Payment This Month: Rp. {{ number_format($paymentRecap['totalPembayaran'], 0, ',', '.') }}</p>
                        <p>New Enrollments This Month: {{ $studentRecap['sum'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
