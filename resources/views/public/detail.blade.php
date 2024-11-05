<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Payment Status</title>
    <style>
        /* Basic styling for the content */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .content-wrapper {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .card {
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
        }

        .card-header {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
        }

        .card-title {
            font-size: 18px;
        }

        .card-body {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }

        .status-due {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Student Payment Status for {{ $data['student']['name'] }}</h1>
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
                                    <th>Month</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Define all months
                                    $months = [
                                        'January', 'February', 'March', 'April', 'May', 'June',
                                        'July', 'August', 'September', 'October', 'November', 'December'
                                    ];

                                    // Map paid months for this course
                                    $paidMonths = collect($coursePayment['payments'])->pluck('payment_month')->toArray();
                                @endphp

                                @foreach ($months as $month)
                                    <tr>
                                        <td>{{ $month }}</td>
                                        <td class="{{ in_array($month, $paidMonths) ? 'status-paid' : 'status-due' }}">
                                            {{ in_array($month, $paidMonths) ? 'Paid' : 'Not Paid' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
</body>
</html>
