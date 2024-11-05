@extends('layouts.main')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Students</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Students</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
 <div class="container table-container">

        <h1>{{ $data['alias'] }}</h1>
        <a href="/students/create" class="btn btn-primary">Add New Student</a>
        <table id="table" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Whatsapp</th>
                    <th>Gender</th>
                    <th>School</th>
                    <th>Enroll Date</th>
                    <th>Edit</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($data['students'] as $row)
                  <tr>
                    <td>{{ $row['name'] }}</td>
                    <td><a href="https://wa.me/{{ $row['wa_number'] }}">{{ $row['wa_number'] }}</a></td>
                    <td>{{ $row['gender'] }}</td>
                    <td>{{ $row['school'] }}</td>
                    <td>{{ $row['enroll_date'] }}</td>
                    <td><a href="/students/{{ $row['id'] }}">Edit</a></td>
                    <td><a href="/student/payment/{{ $row['id'] }}">Show</a></td>
                  </tr>
                 @endforeach
                  </tbody>
        </table>
    </div>
    </section>
    <!-- /.content -->
  </div>

  

@endsection