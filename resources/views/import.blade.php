@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('content_header')
    <h1 class="m-0 text-dark">Import CSV</h1>
@stop

@section('content')
   
    <div class="row">
        <div class="col-md-10">
          <div class="card card-primary">
            @if(count($errors) > 0)
              <div class="alert alert-danger">
                <ul>
                  @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              @if(\Session::has('success'))
              <div class="alert alert-success">
                  <p>{{ \Session::get('success')}}</p>
              </div>
              @endif
              &nbsp;
              <div class="card-header">
                <h3 class="card-title">Form</h3>
              </div>
              <p>{{ session('status') }}</p>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" class="form-horizontal" method="POST" action="{{ route('import_csv') }}" enctype="multipart/form-data">
                 {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="broadcast_name">Broadcast Name</label>
                    <input type="text" name="broadcast_name" class="form-control" id="broadcast_name" placeholder="Enter Broadcast Name">
                  </div>
                  <div class="custom-file">
                      <input type="file" name="inputfile" class="custom-file-input" id="inputfile">
                      <label class="custom-file-label" for="inputfile">Choose file</label>
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
    
@stop

@section('css')
<!-- Custome css add karvi hoy to -->
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
<!-- bs-custom-file-input -->
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- custom js add karvi hoy to -->
    <!-- <script> console.log('Hi!'); </script> -->
@stop
