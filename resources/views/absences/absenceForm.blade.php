@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Record Attendance</h1>
            <h1>{{ $data['alias'] }}</h1>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="/absences/store"  method="POST">
                                @csrf
                                
                                <!-- Additional fields for day, date, time, teacher, and course -->
                            

                                <div class="form-group">
                                    <label>Date:</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                                    <div class="form-group">
                                    <label>Day:</label>
                                    <input type="text" name="day" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Time:</label>
                                    <select name="time" class="form-control" required>
                                        <option value="14:30">14:30</option>
                                        <option value="15:45">15:45</option>
                                        <option value="17:15">17:15</option>
                                        <option value="18:30">18:30</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Teacher:</label>
                                    <select name="teacher_id" class="form-control" required>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden" name="course_id" value="{{ $data['id'] }}">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No Siswa</th>
                                            <th>Nama Siswa</th>
                                            <th>Attendance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['students'] as $student)
                                            <tr>
                                                <td>{{ $student['nis'] }}</td>
                                                <td>{{ $student['name'] }}</td>
                                                <td>
                                                    <input type="hidden" name="attendances[{{ $loop->index }}][students_courses_id]" value="{{ $student['pivot']['id'] }}">
                                                    <select name="attendances[{{ $loop->index }}][status]" class="form-control">
                                                        <option value="present">Present</option>
                                                        <option value="absent">Absent</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-primary mt-3">Submit Attendance</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    document.querySelector('input[name="date"]').addEventListener('change', function() {
        const date = new Date(this.value);
        const options = { weekday: 'long' };
        const day = date.toLocaleDateString('en-US', options);
        document.querySelector('input[name="day"]').value = day;
    });
</script>

@endsection
