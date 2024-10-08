@dd($students)
@extends('layouts.main')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Courses</h1>
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

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <div class="col-12">
 <div class="card">

    
    <!-- /.card-header -->
    <div class="card-body">
<!-- Bootstrap Dropdown -->
<div class="dropdown">
  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Select Course
  </a>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
      @foreach ($courses as $course)
        <a class="dropdown-item" href="/students-courses/{{ $course['alias'] }}">{{ $course['name'] }}</a><br>
    @endforeach  
  </div>
</div>
<div>
  @if (isset($courseWithStudents['name']))
  <h1 class="text-center">{{ $courseWithStudents['name'] }}</h1>
  @endif
</div>

        <table id="example1" class="table table-bordered table-striped">
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
                @if(isset($courseWithStudents)&& count($courseWithStudents['students']) > 0)
                    @foreach ($courseWithStudents['students'] as $row)
                        <tr>
                            <td>{{ $row['name'] }}</td>
                            <td><a href="https://wa.me/{{ $row['wa_number'] }}">{{ $row['wa_number'] }}</a></td>
                            <td>{{ $row['gender'] }}</td>
                            <td>{{ $row['school'] }}</td>
                            <td>{{ $row['enroll_date'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">No students available for this class.</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Whatsapp</th>
                    <th>Gender</th>
                    <th>School</th>
                    <th>Enroll Date</th>
                </tr>
            </tfoot>
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

@endsection