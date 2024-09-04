
       @extends('layouts.main')
@section('content')
       <!-- SELECT2 EXAMPLE -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Payment Form</h1>
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
                 <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Select Student
            </a>
         <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
         @foreach ($students as $student)
           <a class="dropdown-item" href="/payments/{{ $student['id'] }}">{{ $student['name'] }}</a><br>
       @endforeach  
     </div>
     </div>
          
            

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
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Payment Month</label>
                  <select name="payment_month" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                  </select>
                </div>

                            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Tanggal</label>
                  <input value="<?php echo date('Y-m-d'); ?>" type="date" class="form-control select2 select2-danger" >
                </div>
                <!-- /.form-group -->
 
            </div>
            <!-- /.row -->
          </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Kelas</label>
                  <select class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                    <option>Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select>
                </div>
 
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->


          <!-- /.card-body -->
 
        </div>
        <!-- /.card -->




      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
        @endsection