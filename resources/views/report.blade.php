@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"><i class="	fas fa-file-alt"></i> Report</h1>
@stop

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
aaaa
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
                <p class="text-center">
                  <strong>Sales: {{ date('M 1, Y', strtotime('first day of last month')) }} - {{ date('M t, Y', strtotime('last day of last month')) }}</strong>
                </p>

                <div class="chart">
                  <!-- Sales Chart Canvas -->
                  <canvas id="stockChart" height="180" style="height: 180px;"></canvas>
                </div>

                <table id="transactions">
                  <tr>
                    <th>Stock In</th>
                    <th>Stock Out</th>
                  </tr>
                  <tr>
                    <td>10</td>
                    <td>5</td>
                  </tr>
                  <tr>
                    <td>20</td>
                    <td>10</td>
                  </tr>
                  <!-- ... more rows ... -->
                </table>

                <!-- /.chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <p class="text-center">
                  <strong>Goal Completion</strong>
                </p>

                <div class="progress-group">
                  Add Products to Cart
                  <span class="float-right"><b>160</b>/200</span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: 80%"></div>
                  </div>
                </div>
                <!-- /.progress-group -->

                <div class="progress-group">
                  Complete Purchase
                  <span class="float-right"><b>310</b>/400</span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-danger" style="width: 75%"></div>
                  </div>
                </div>

                <!-- /.progress-group -->
                <div class="progress-group">
                  <span class="progress-text">Visit Premium Page</span>
                  <span class="float-right"><b>480</b>/800</span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-success" style="width: 60%"></div>
                  </div>
                </div>

                <!-- /.progress-group -->
                <div class="progress-group">
                  Send Inquiries
                  <span class="float-right"><b>250</b>/500</span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-warning" style="width: 50%"></div>
                  </div>
                </div>
                <!-- /.progress-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- ./card-body -->


          <div class="card-footer">
            <div class="row">
              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                  <h5 class="description-header">$24,813.53</h5>
                  <span class="description-text">Stocik in</span>
                </div>
                <!-- /.description-block -->
              </div>



              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block">
                  <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                  <h5 class="description-header">1200</h5>
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
  // Fetch data from database using Laravel's Eloquent ORM
  const transactions = <?php echo json_encode(App\Models\Transaction::where('created_at', '>=', now()->startOfMonth())->where('created_at', '<=', now()->endOfMonth())->get()); ?>;

  // Define the chart data
  const labels = [];
const stockInData = [];
const stockOutData = [];

transactions.forEach((transaction) => {
  const date = moment(transaction.created_at).format('YYYY-MM-DD');
  const index = labels.indexOf(date);
  if (index === -1) {
    labels.push(date);
    stockInData.push(0);
    stockOutData.push(0);
  }
  if (transaction.transaction_type === 'IN') {
    stockInData[index] += transaction.qty; // Update this line to use "qty" instead of "quantity"
  } else {
    stockOutData[index] += transaction.qty; // Update this line to use "qty" instead of "quantity"
  }
});

// Create the chart
const ctx = document.getElementById('stockChart').getContext('2d');
const chart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{
      label: 'Stock In',
      data: stockInData,
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
      borderColor: 'rgba(75, 192, 192, 1)',
      borderWidth: 1,
      stack: 'combined'
    }, {
      label: 'Stock Out',
      data: stockOutData,
      backgroundColor: 'rgba(255, 99, 132, 0.2)',
      borderColor: 'rgba(255, 99, 132, 1)',
      borderWidth: 1,
      stack: 'combined'
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
        max: 130
      }
    },
    plugins: {
      title: {
        display: true,
        text: 'Stock In/Out Chart'
      }
    }
  }
});
</script>
@endsection