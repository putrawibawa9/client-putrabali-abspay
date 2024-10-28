@extends('layouts.main')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Student</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Student Data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="/students/{{ $student['id'] }}" method="POST">
                <input type="hidden" name="enroll_date" placeholder="{{ $student['enroll_date'] }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">NIS</label>
                    <input name="nis" type="text" class="form-control" id="exampleInputEmail1" readonly placeholder="{{ $student['nis'] }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Name</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="name" placeholder="{{ $student['name'] }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">WA</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="wa_number" placeholder="{{ $student['wa_number'] }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Gender</label>
                    <input type="text" name="gender" class="form-control" id="exampleInputPassword1" readonly placeholder="{{ $student['gender'] }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">School</label>
                    <input name="school" type="text" class="form-control" id="exampleInputPassword1" placeholder="{{ $student['school'] }}">
                  </div>
               
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          

          </div>
      
        </div>
     
      </div><!-- /.container-fluid -->
    </section>

  </div>

@endsection