<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jQuery Table Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container table-container">
        <h1 class="my-4">jQuery Table Example</h1>
        <input type="text" id="search" class="form-control mb-3" placeholder="Search...">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Whatsapp</th>
                    <th>Gender</th>
                    <th>School</th>
                    <th>Enroll Date</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($students as $row)
                  <tr>
                    <td>{{ $row['name'] }}</td>
                    <td><a href="https://wa.me/{{ $row['wa_number'] }}">{{ $row['wa_number'] }}</a></td>
                    <td>{{ $row['gender'] }}</td>
                    <td>{{ $row['school'] }}</td>
                    <td>{{ $row['enroll_date'] }}</td>
                  </tr>
                 @endforeach
                  </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>
</html>
