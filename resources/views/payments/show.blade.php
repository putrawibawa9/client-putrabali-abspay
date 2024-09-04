{{-- @dd($student) --}}
@extends('layouts.main')
@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->

            <div class="card card-default">
                <div class="card-header">
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Select Student
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach ($allStudents as $row)
                                <a class="dropdown-item" href="/payments/{{ $row['student']['id'] }}">{{ $row['student']['name'] }}</a>
                            @endforeach
                        </div>
                        
                    </div>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
  <!-- Display Student Name -->

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h2 class="text-center">{{ $student[0]['student_name'] }}</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Payment Month Selection -->
                        <form action="/payments" method="POST">
                            <div class="form-group">
                                <label>Payment Month</label>
                                <select name="payment_month" class="form-control select2" style="width: 100%;">
                                    <option selected="selected" value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>

                            <!-- Date Selection -->
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" class="form-control select2 select2-danger" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="col-md-6">
                            <!-- General Payment Rate Selection -->
                            <div class="form-group">
                                <label>General Payment Rate</label>
                                <select id="generalRate" class="form-control select2" style="width: 100%;">
                                    <option value="">Select Class</option>
                                    @foreach ($student as $row)
                                        <option value="{{ $row['payment_rate'] }}">
                                            {{ $row['course_name'] }} || Rp. {{ number_format($row['payment_rate'], 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Custom Payment Rate Selection -->
                            <div class="form-group">
                                <label>Custom Payment Rate</label>
                                <select id="customRate" class="form-control select2" style="width: 100%;">
                                    <option value="">Select Class</option>
                                    @foreach ($student as $row)
                                        <option value="{{ $row['custom_payment_rate'] }}">
                                            {{ $row['course_name'] }} || 
                                            @if ($row['custom_payment_rate'])
                                                Rp. {{ number_format($row['custom_payment_rate'], 0, ',', '.') }}
                                            @else
                                                No custom payment rate
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary">
                    </form>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const generalRate = document.getElementById('generalRate');
        const customRate = document.getElementById('customRate');

        generalRate.addEventListener('change', function() {
            if (this.value) {
                customRate.disabled = true;
            } else {
                customRate.disabled = false;
            }
        });

        customRate.addEventListener('change', function() {
            if (this.value) {
                generalRate.disabled = true;
            } else {
                generalRate.disabled = false;
            }
        });
    });
</script>

        @endsection