<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Course Price</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

    <div class="container">
        <h2>📘 Daftar Harga Kursus per Bulan</h2>

        @if(session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mt-2">
                {{ implode(', ', $errors->all()) }}
            </div>
        @endif

        <form method="POST" action="{{ route('course-prices.store') }}" class="mt-4">
            @csrf
            <div class="row g-2">
                <div class="col-md-2">
                    <input type="number" name="course_id" class="form-control" placeholder="Course ID" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="year" value="{{ now()->year }}" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="month" value="{{ now()->month }}" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="price" placeholder="Harga" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="note" placeholder="Catatan (opsional)" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course ID</th>
                    <th>Tahun</th>
                    <th>Bulan</th>
                    <th>Harga</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coursePrices as $price)
                    <tr>
                        <td>{{ $price['id'] }}</td>
                        <td>{{ $price['course_id'] }}</td>
                        <td>{{ $price['year'] }}</td>
                        <td>{{ $price['month'] }}</td>
                        <td>{{ number_format($price['price'], 0, ',', '.') }}</td>
                        <td>{{ $price['note'] ?? '-' }}</td>
                        <td>
                            <form method="POST" action="{{ route('course-prices.update', $price['id']) }}" class="d-flex gap-1">
                                @csrf
                                @method('PUT')
                                <input type="number" name="price" value="{{ $price['price'] }}" class="form-control form-control-sm w-50">
                                <input type="text" name="note" value="{{ $price['note'] }}" class="form-control form-control-sm w-50">
                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>
</html>
