@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px">Report</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Bar Chart</h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>
@endsection