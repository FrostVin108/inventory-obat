@extends('layouts.app')

@section('content_header')
    <h6>How To Use This Website</h6>
  
@stop

@section('content')
    {{-- <div class="card">
        <div class="card-body">
            Just For Your Information On How To Use This Web Or What This Web Use For<br>
            <br>
            1. Open Uom Page And Make The Uom<br>
            2. Open Home Page And Choose The Item Warehouse<br>
                Item Warehouse Is The Place for all of the item Information<br>
            3. Press insert item button for make or insert it to the Warehouse Page<br>
            <br>
            and your done thats the tutorial how to insert your item to warehouse or see the item<br>
            that you are already put in and see all of the Information about it.
 
        </div>
    </div> --}}















<div>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">


    

    <!-- Content Wrapper. Contains page content -->
    
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 404</h2>

            <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href="{{ route('ob.home') }}">return to dashboard</a> or try using the search form.
            </p>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
        </section>
        <!-- /.content -->
    



    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
</div>

@stop
