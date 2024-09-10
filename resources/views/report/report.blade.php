@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"><i class="	fas fa-file-alt"></i> Report</h1>
@stop

@section('content')




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="card">
  <div class="card-body">


    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Monthly Recap Report</h5>

            <div class="card-tools">
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
 <!-- Add a select box to choose the month -->
 <div class="input-group">
  <select id="month" class="form-control">
    @for ($i = 1; $i <= 12; $i++)
      <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
    @endfor
  </select>
  <div class="input-group-append">
    <button class="btn btn-primary" id="change-month">Change Month</button>
  </div>
</div>

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
                  <strong>Report Date From: {{ date('M 1, Y') }} - {{ date('M t, Y') }}</strong>
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
                  <strong>{{ date('M 1, Y') }} - {{ date('M t, Y') }} | Item In and Out </strong>
                </p>
            

                <!-- all month items -->
                <table class="table table-hover">
                  <thead>
                      <tr>
                          <th scope="col">Item Name</th>
                          <th scope="col">In</th>
                          <th scope="col">Out</th>
                          <th scope="col">Balance</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($data as $item)
                          <tr>
                              <td>{{ $item['item'] }}</td>
                              <td>{{ $item['in'] }}</td>
                              <td>{{ $item['out'] }}</td>
                              <td>{{ $item['balance'] }}</td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>

                
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- ./card-body -->


          <div class="card-footer ">

            <div class="card-footer">
            <div class="row">
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  <h5 class="description-header">Stock In</h5>
                  <span class="description-text text-md">Stock In <br> </span>
                  <span class="text-sm">({{ date('M 1, Y') }} - {{ date('M t, Y') }})</span>
                  @if(is_array($stockIn) || is_object($stockIn))
                    <ul>
                      @foreach($stockIn as $item)
                        <li>{{ $item['quantity'] }}</li>
                      @endforeach
                    </ul>
                  @else
                    <p>No stock in data available.</p>
                  @endif
                </div>
              </div>
          
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  <h5 class="description-header">Stock Out</h5>
                  <span class="description-text text-md">Stock Out <br> </span>
                  <span class="text-sm"> ({{ date('M 1, Y') }} - {{ date('M t, Y') }})</span>
                  @if(is_array($stockOut) || is_object($stockOut))
                    <ul>
                      @foreach($stockOut as $item)
                        <li>{{ $item['quantity'] }}</li>
                      @endforeach
                    </ul>
                  @else
                    <p>No stock out data available.</p>
                  @endif
                </div>
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

    <div>
      <table class="table table-hover">
        
      </table>
    </div>



  </div>
</div>
<br>
{{-- table click --}}
<div class="card">
  <div class="card-body">

    @foreach($transactions as $date => $transactionGroup)
      <h5>Date : {{ $date }}</h5>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Item Name</th>
            <th scope="col">Order By</th>
            <th scope="col">Transaction Type</th>
            <th scope="col">Quantity</th>
          </tr>
        </thead>
        <tbody>
          @foreach($transactionGroup as $transaction)
            <tr>
              <td>{{ $transaction->item->description }}</td>
              <td>{{ $transaction->order->department }}</td>
              <td>{{ $transaction->transaction_type }}</td>
              <td>{{ $transaction->qty }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <hr style="border: solid 1px black">
    @endforeach


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
              label: ' Total IN',
              data: {!! json_encode($inQuantities) !!},
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1
          },
          {
              label: 'Total OUT',
              data: {!! json_encode($outQuantities) !!},
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              y: {
                type: 'linear',
                display: true,
                position: 'left',
                  beginAtZero: true
                  
              }
              
          }
      }
  });
</script>

<script>
$(document).ready(function() {
    $('#change-month').on('click', function() {
        var month = $('#month').val();
        var year = '{{ date('Y') }}';
        var url = '{{ route('report.monthly', ['month' => ':month']) }}'.replace(':month', month);
        window.location.href = url;
    });
});
</script>
@endsection
