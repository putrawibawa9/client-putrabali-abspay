<div class="mt-4">
    <h4>Filtered Data for {{ request('month') }}:</h4>

    <!-- Check if there is filtered data -->
    @if (!empty($data))
        <div class="row">
            <!-- Paid Students Table -->
            @if (!empty($data['paidStudents']) && count($data['paidStudents']) > 0)
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
                                        <th>Name</th>
                                        <th>Payment Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['paidStudents'] as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->payment_date }}</td>
                                            <td>Rp. {{ number_format($student->amount, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Unpaid Students Table -->
            @if (!empty($data['unpaidStudents']) && count($data['unpaidStudents']) > 0)
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
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['unpaidStudents'] as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->class }}</td>
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
    @else
        <p>No data available for the selected month.</p>
    @endif
</div>
