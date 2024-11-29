@extends('layouts-old.main')
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
                        <li class="breadcrumb-item active">Payment Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
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

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h2 class="text-center">{{ $student['name'] }}</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Payment Month Selection -->
                      <form action="/payments" method="POST">
    <input type="hidden" name="student_id" value="{{ $student['id'] }}">
    <input type="hidden" name="user_id" value="2">
    
    <!-- Hidden field for course_id -->
    <input type="hidden" name="course_id" id="selected_course_id">

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
            <!-- Other months... -->
        </select>
    </div>

     <div class="form-group">
        <label>Type</label>
        <select name="type" class="form-control select2" style="width: 100%;">
            <option selected="selected" value="Pembayaran SPP">Pembayaran SPP</option>
            <option value="Modul">Modul</option>
            <option value="Pendaftaran">Pendaftaran</option>
        </select>
    </div>



    <!-- General Payment Rate Selection -->
    <div class="form-group">
        <label>General Payment Rate</label>
        <select name="general_rate" id="generalRate" class="form-control select2" style="width: 100%;">
            <option value="">Select Class</option>
            @foreach ($student['active_courses'] as $row)
                <option value="{{ $row['id'] }}" data-payment-rate="{{ $row['payment_rate'] }}">
                    {{ $row['alias'] }} || Rp. {{ number_format($row['payment_rate'], 0, ',', '.') }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Custom Payment Rate Selection -->
    <div class="form-group">
        <label>Custom Payment Rate</label>
        <select name="custom_rate" id="customRate" class="form-control select2" style="width: 100%;">
            <option value="">Select Class</option>
            @foreach ($student['active_courses'] as $row)
                <option value="{{ $row['id'] }}" data-custom-rate="{{ $row['pivot']['custom_payment_rate'] ?? '0' }}">
                    {{ $row['alias'] }} || 
                    @if ($row['pivot']['custom_payment_rate'])
                        Rp. {{ number_format($row['pivot']['custom_payment_rate'], 0, ',', '.') }}
                    @else
                        No custom payment rate
                    @endif
                </option>
            @endforeach
        </select>
    </div>

    <!-- Payment Amount -->
    <div class="form-group">
        <label>Payment Amount</label>
        <input type="number" name="payment_amount" class="form-control" placeholder="Enter payment amount" required>
    </div>

    <input type="submit" class="btn btn-primary" value="Submit Payment">
    @csrf
</form>

                        </div>
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
    document.getElementById('customRate').addEventListener('change', function() {
        const [courseId, customPaymentRate] = this.value.split('|');
        document.getElementById('custom_course_id').value = courseId;
        document.getElementById('custom_payment_rate').value = customPaymentRate;
    });

    document.getElementById('generalRate').addEventListener('change', function() {
        const [courseId, paymentRate] = this.value.split('|');
        document.getElementById('course_id').value = courseId;
        document.getElementById('payment_rate').value = paymentRate;
    });

    document.addEventListener('DOMContentLoaded', function() {
        const generalRate = document.getElementById('generalRate');
        const customRate = document.getElementById('customRate');

        generalRate.addEventListener('change', function() {
            customRate.disabled = this.value ? true : false;
        });

        customRate.addEventListener('change', function() {
            generalRate.disabled = this.value ? true : false;
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
    const generalRate = document.getElementById('generalRate');
    const customRate = document.getElementById('customRate');
    const paymentAmount = document.querySelector('input[name="payment_amount"]');

    // Function to extract and format payment rate
    function extractPaymentRate(value) {
        if (!value) return '';
        const [, rate] = value.split('|');
        // Handle "No custom payment rate" text for custom rates
        if (rate === 'No custom payment rate') return '';
        // Convert rate to number and return
        return rate;
    }

    // Function to update payment amount
    function updatePaymentAmount(value) {
        const rate = extractPaymentRate(value);
        paymentAmount.value = rate;
    }

    // Event listener for general rate selection
    generalRate.addEventListener('change', function() {
        if (this.value) {
            customRate.disabled = true;
            updatePaymentAmount(this.value);
        } else {
            customRate.disabled = false;
            paymentAmount.value = '';
        }
    });

    // Event listener for custom rate selection
    customRate.addEventListener('change', function() {
        if (this.value) {
            generalRate.disabled = true;
            updatePaymentAmount(this.value);
        } else {
            generalRate.disabled = false;
            paymentAmount.value = '';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const generalRate = document.getElementById('generalRate');
    const customRate = document.getElementById('customRate');
    const paymentAmount = document.querySelector('input[name="payment_amount"]');

    // Function to update payment amount based on selected course
    function updatePaymentAmount(rate) {
        paymentAmount.value = rate;
    }

    // Event listener for general rate selection
    generalRate.addEventListener('change', function() {
        if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const paymentRate = selectedOption.getAttribute('data-payment-rate');
            customRate.disabled = true; // Disable custom rate selection
            updatePaymentAmount(paymentRate); // Update payment amount
        } else {
            customRate.disabled = false; // Enable custom rate selection
            paymentAmount.value = ''; // Clear payment amount
        }
    });

    // Event listener for custom rate selection
    customRate.addEventListener('change', function() {
        if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const customPaymentRate = selectedOption.getAttribute('data-custom-rate');
            generalRate.disabled = true; // Disable general rate selection
            updatePaymentAmount(customPaymentRate); // Update payment amount
        } else {
            generalRate.disabled = false; // Enable general rate selection
            paymentAmount.value = ''; // Clear payment amount
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const generalRate = document.getElementById('generalRate');
    const customRate = document.getElementById('customRate');
    const paymentAmount = document.querySelector('input[name="payment_amount"]');
    const selectedCourseId = document.getElementById('selected_course_id');

    function updatePaymentAmountAndCourseId(rate, courseId) {
        paymentAmount.value = rate;
        selectedCourseId.value = courseId;
    }

    // Event listener for general rate selection
    generalRate.addEventListener('change', function() {
        if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const paymentRate = selectedOption.getAttribute('data-payment-rate');
            customRate.disabled = true; // Disable custom rate selection
            updatePaymentAmountAndCourseId(paymentRate, this.value); // Update payment amount and course_id
        } else {
            customRate.disabled = false; // Enable custom rate selection
            paymentAmount.value = ''; // Clear payment amount
            selectedCourseId.value = ''; // Clear course_id
        }
    });

    // Event listener for custom rate selection
    customRate.addEventListener('change', function() {
        if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const customPaymentRate = selectedOption.getAttribute('data-custom-rate');
            generalRate.disabled = true; // Disable general rate selection
            updatePaymentAmountAndCourseId(customPaymentRate, this.value); // Update payment amount and course_id
        } else {
            generalRate.disabled = false; // Enable general rate selection
            paymentAmount.value = ''; // Clear payment amount
            selectedCourseId.value = ''; // Clear course_id
        }
    });
});

</script>

@endsection
