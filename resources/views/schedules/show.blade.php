{{-- @dd($schedules['schedules'][0]) --}}
@extends('layouts.main')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Search Schedule</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Input form -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Find Your Schedule</h3>
              </div>
              <div class="card-body">
                <!-- Form to submit NIS -->
                <form action="{{ url('/students-schedules') }}" method="GET">
                  <div class="form-group">
                    <label for="nis">Enter Your NIS</label>
                    <input type="text" id="nis" name="nis" class="form-control" placeholder="Enter your NIS" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Search Schedule</button>
                </form>

                @if(isset($schedules))
                  <div class="mt-4">
                   
                    <h3>{{ $schedules['studentName'] }}</h3>
                    @if(empty($schedules))
                      <p>No schedule found for this NIS.</p>
                    @else
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Course Name</th>
                            <th>Schedule</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($schedules['schedules'] as $course)
                            <tr>
                              <td>{{ $course['course_name'] }}</td>
                              <td>
                                @foreach($course['schedules'] as $row)
                                  Day: {{ $row['day'] }}, Time: {{ $row['start'] }}<br>
                                @endforeach
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    @endif
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
