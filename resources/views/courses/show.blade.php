{{-- @dd($data) --}}
@extends('layouts-old.main')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Course</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Courses</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- /.row -->
        <!-- Main row -->
      <div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
       
  
        <!-- Filter form -->
        <form action="/courses/search" method="POST">
          @csrf <!-- Don't forget to include the CSRF token for POST requests -->
          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 500px;">

              <!-- Filter by Level -->
              <input type="text" name="level" class="form-control float-right" placeholder="Level" value="{{ request('level') }}">

              <!-- Filter by Section -->
              <input type="text" name="section" class="form-control float-right mx-2" placeholder="Section" value="{{ request('section') }}">

              <!-- Filter by Subject -->
              <input type="text" name="subject" class="form-control float-right" placeholder="Subject" value="{{ request('subject') }}">

     
              
            </div>
            <button  type="submit" class="btn btn-primary"> search
             
            </button>
          </div>
        </form>
              <h1>{{ $data['alias'] }}</h1>
      </div>
      <!-- /.card-header -->

      <div class="card-body table-responsive p-0">
 <table class="table table-hover text-nowrap display" id="table">
    <thead>
        <tr>
            <th>Nis</th>
            <th>Name</th>
            <th>Wa Number</th>
            <th>Gender</th>
            <th>School</th>
            <th>Enroll Date</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['students'] as $row)
            @if (is_string($row)) {{-- Check if $row is a string --}}
                <tr>
                    <td colspan="6">Classes not found</td> {{-- Display the string in one row --}}
                </tr>
            @else {{-- Otherwise, display row data as usual --}}
                <tr>
                    <td>{{ $row['nis'] }}</td>
                    <td>{{ $row['name'] }}</td>
                    <td>{{ $row['wa_number'] }}</td>
                    <td>{{ $row['gender'] }}</td>
                    <td>{{ $row['school'] }}</td>
                    <td>{{ $row['enroll_date'] }}</td>
                    <td><a class="btn btn-secondary" href="/students/{{ $row['id'] }}">Show</a></td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>


      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>

        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>

@endsection