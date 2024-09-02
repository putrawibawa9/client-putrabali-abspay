{{-- @dd($data) --}}
@extends('layouts.main')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Enrollment Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Advanced Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Pilih Murid dan Kelas</h3>
            <form action="{{ Route('enrollments.store') }}" method="POST">
              @csrf
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
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama Siswa</label>
                  <select name="student_id" class="form-control select2" style="width: 100%;">
                    @foreach ($data['students'] as $row )
                    <option  value="{{ $row['id'] }}"> {{ $row['name'] }}</option>
                    @endforeach
                   
                  </select>
                </div>
                <div class="form-group">
                  <label>Custom Payment Rate</label>
                  <input type="number" name="custom_payment_rate" class="form-control select2" style="width: 100%;" >
                </div>

                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama Kelas</label>
                  <select name="course_id" class="select2" multiple="multiple" data-placeholder="Select a Class" style="width: 100%;">
                    @foreach ($data['courses'] as $row )
                    <option value=" {{ $row['id'] }} ">{{ $row['name'] }}</option>
                    @endforeach
                  </select>
                </div>
  
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

         
            <!-- /.row -->
          </div>
              <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
        </div>
        <!-- /.card -->

        <!-- /.row -->
    
      </div>
      <!-- /.container-fluid -->
    </section>
   
@endsection