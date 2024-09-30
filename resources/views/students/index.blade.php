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
        <input type="text" id="search" class="form-control mb-3" placeholder="Search...">
        <table id="table" class="table table-striped">
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
    </section>
    <!-- /.content -->
  </div>

  

@endsection