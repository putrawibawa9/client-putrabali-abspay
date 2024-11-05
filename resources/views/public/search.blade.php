{{-- @dd($students) --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Payment Details</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .results {
            margin-top: 20px;
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

        .no-data {
            text-align: center;
            color: #666;
            padding: 20px;
        }

        .status-paid {
            color: green;
        }

        .status-due {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Check Payment Details</h2>
        <form id="searchForm" method="POST" action="/public/search">
            @csrf
            <label for="name">Enter Student's Name:</label>
            <input type="text" id="search" name="search" required value="{{ old('search') }}">
            <button type="submit">Search</button>
        </form>
        
        <div class="results" id="results">
            <h3>Payment Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nis</th>
                        <th>Name</th>
                        <th>Check</th>
                    </tr>
                </thead>
                <tbody id="resultsBody">
                 @if (count($students) > 0)
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student['nis'] }}</td>
                            <td>{{ $student['name'] }}</td>
                            <td><a href="/public/payments/{{ $student['id'] }}">Check</a></td>
                        </tr>
                    @endforeach 
                 @else
                    <tr class="no-data">
                        <td colspan="5">No payment records available.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
