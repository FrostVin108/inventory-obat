@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"><i class="	fas fa-file-alt"></i> Report</h1>
@stop

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="card">
  <div class="card-body">


    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Monthly Recap Report</h5>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <div class="btn-group">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                  <i class="fas fa-wrench"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                  <a href="#" class="dropdown-item">Action</a>
                  <a href="#" class="dropdown-item">Another action</a>
                  <a href="#" class="dropdown-item">Something else here</a>
                  <a class="dropdown-divider"></a>
                  <a href="#" class="dropdown-item">Separated link</a>
                </div>
              </div>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                {{-- <p class="text-center">
                  <strong>Sales: {{ date('M 1, Y', strtotime('first day of last month')) }} - {{ date('M t, Y', strtotime('last day of last month')) }}</strong>
                </p> --}}

                <p class="text-center">
                  <strong>Sales: {{ date('M 1, Y') }} - {{ date('M t, Y') }}</strong>
                </p>

                <div class="chart">
                  <!-- Sales Chart Canvas -->
                  <canvas id="stockChart" height="180" style="height: 180px;"></canvas>
                </div>
                
                <table>

                </table>

                <!-- /.chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <p class="text-center">
                  <strong>All Item </strong>
                </p>
            

                <!-- all month items -->
                <table class="table table-hover">
                  <thead>
                    <tr>
                        <th scope="col">Nama Obat</th>
                        <th scope="col">In</th>
                        <th scope="col">out</th>
                        <th scope="col">balance</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        
                        
                          <tr>
                            <td>panadol</td>
                            <td>56</td>
                            <td>34</td>
                            <td>22</td>
                          </tr>
                </table>


                
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- ./card-body -->


          <div class="card-footer ">

            <div class="row ">
              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                  <h5 class="description-header">56</h5>
                  <span class="description-text">Stock in</span>
                </div>
                <!-- /.description-block -->
              </div>

              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 52%</span>
                  <h5 class="description-header">140</h5>
                  <span class="description-text">Balance</span>
                </div>
                <!-- /.description-block -->
              </div>

              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block">
                  <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                  <h5 class="description-header">34</h5>
                  <span class="description-text">Stock out</span>
                </div>
                <!-- /.description-block -->
              </div>
            </div>
            <!-- /.row -->

          </div>

          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
              {{-- All Button --}}

              <div class="row">
                <button class="btn btn-app">aaaaaaaaaa</button>
              </div>
  </div>
</div>

<script>
  console.log('Chart data:', {!! json_encode($labels) !!}, {!! json_encode($inQuantities) !!}, {!! json_encode($outQuantities) !!});

  const ctx = document.getElementById('stockChart').getContext('2d');
  const chart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: {!! json_encode($labels) !!},
          datasets: [{
              label: 'IN',
              data: {!! json_encode($inQuantities) !!},
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1
          },
          {
              label: 'OUT',
              data: {!! json_encode($outQuantities) !!},
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true
                  
              }
          }
      }
  });
</script>
@endsection

{{-- just make make me a line chart showing for monthly stock which is start from the first day of the month until the last day of the month, for the line chart it self will be following the database table named "transaction", the chart will be having an stacked line first line is the "IN" its will filtering the qty on table  transaction, where its gonna be  --}}
