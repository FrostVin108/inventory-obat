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
                    
                        <div class="card-header">
                            <h5 class="card-title">Monthly Recap Report</h5>

                            <div class="card-tools">
                                <!-- Add a select box to choose the month -->
                                <div class="input-group" style="gap: 5px; margin-right: 60px;">  
                                    
                                    <i class="fas fa-calendar-alt " style="font-size: 28px;"></i>
                                    <select id="month" class=".form-select-sm example" >
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ (session('month') == $i) ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                    <div class="input-group-append ">
                                        <button class="btn btn-primary btn-sm" id="change-month"><i class="	fas fa-sync"></i> Change</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="text-center">
                                        <strong>Report Date From: {{ $firstDayOfMonth }} - {{ $lastDayOfMonth }}</strong>
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
                                        <strong>{{ $firstDayOfMonth }} - {{ $lastDayOfMonth }} | Item In and Out </strong>
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
                                            @foreach ($data as $item)
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

                          <div class="card-footer ">
                            <div class="row">
                                <div class="col-sm-4 col-6">
                                    <div class="description-block border-right">
                                      <span class="text-md"><h5>{{ $stockin }}</h5> </span>
                                        <h5 class="description-text ">Stock In</h5>
                                        <span class="text-sm">({{ $firstDayOfMonth }} - {{ $lastDayOfMonth }})</span>
                                    </div>
                                </div>
                        
                                <div class="col-sm-4 col-6">
                                    <div class="description-block border-right">
                                      <span class=" text-md"> <h5>{{ $stockout }}</h5> </span>
                                        <h5 class="description-text ">Stock Out</h5>
                                        <span class="text-sm">({{ $firstDayOfMonth }} - {{ $lastDayOfMonth }})</span>
                                    </div>
                                </div>
                        
                                <div class="col-sm-4 col-6">
                                    <div class="description-block">
                                        <span class=" text-md"> 
                                            @php
                                            $selectedMonth = session('month'); // get the selected month from the session
                                            $currentYear = date('Y'); // current year
                    
                                            // calculate the previous month and year based on the selected month
                                            if ($selectedMonth == 1) {
                                                $previousMonth = 12; // December
                                                $previousYear = $currentYear - 1; // previous year
                                            } else {
                                                $previousMonth = $selectedMonth - 1; // previous month
                                                $previousYear = $currentYear; // current year
                                            }
                    
                                            // retrieve previous month's "in" and "out" transactions
                                            $previousMonthIn = DB::table('Transactions')
                                                ->whereMonth('created_at', $previousMonth)
                                                ->whereYear('created_at', $previousYear)
                                                ->where('transaction_type', 'in')
                                                ->sum('qty');
                    
                                            $previousMonthOut = DB::table('Transactions')
                                                ->whereMonth('created_at', $previousMonth)
                                                ->whereYear('created_at', $previousYear)
                                                ->where('transaction_type', 'out')
                                                ->sum('qty');
                    
                                            // retrieve current month's "in" and "out" transactions
                                            $currentMonthIn = DB::table('Transactions')
                                                ->whereMonth('created_at', $selectedMonth)
                                                ->whereYear('created_at', $currentYear)
                                                ->where('transaction_type', 'in')
                                                ->sum('qty');
                    
                                            $currentMonthOut = DB::table('Transactions')
                                                ->whereMonth('created_at', $selectedMonth)
                                                ->whereYear('created_at', $currentYear)
                                                ->where('transaction_type', 'out')
                                                ->sum('qty');
                    
                                            // calculate the balance
                                            $newBalance = ($previousMonthIn - $previousMonthOut) + ($currentMonthIn - $currentMonthOut);
                    
                                            // calculate the profit/loss
                                            $profitLoss = ($previousMonthIn - $previousMonthOut) + ($currentMonthIn - $currentMonthOut);
                                        @endphp

                                            <!-- display the balance -->
                                            <h5>{{ $newBalance }}</h5>
                                        </span>
                                        <h5 class="description-text ">Balance</h5>
                                        <span class="text-sm">({{ $firstDayOfMonth }} - {{ $lastDayOfMonth }})</span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card-footer shadow-lg" style="#202020 ">
                              <div class="row">
                                  <div class="col-sm-12">
                                      <div class="description-block">
                                          <h6 class="description-text"><i class="	fas fa-balance-scale"></i><i> Profit/Loss</i> </h6>
                                         <!-- display the profit/loss -->
                                            {{-- @if ($profitLoss > 0)
                                                <span class="text-success"><h4> <i class=" fas fa-caret-up"></i> {{ $profitLoss }}</h4></span>
                                            @elseif ($profitLoss < 0)
                                                <span class="text-danger"><h4> <i class=" fas fa-caret-down"></i> {{ abs($profitLoss) }}</h4></span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif --}}
                                            <span class="text-muted">under progress</span>
                                        <h5 class="description-text ">Profit/Loss</h5>
                                        <span class="text-sm">({{ $firstDayOfMonth }} - {{ $lastDayOfMonth }})</span>
                                  </div>
                              </div>
                          </div>

                        </div>

                            <!-- /.card-footer -->
                      </div>
                    <!-- /.col -->
                </div>
                {{-- All Button --}}





            </div>
        </div>
      </div>
      <br>

      <div class="card">
        <div class="card-body">
             <h3>Table for IN transactions</h3> 
             <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">UOM</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inuom as $key => $item)
                        @if (isset($item['in']) && $item['in'] > 0)
                            <tr>
                                <td>{{ $key +1 }}</td>
                                <td>{{ $item['description'] }}</td>
                                <td>{{ $item['uom'] }}</td>
                                <td>{{ $item['in'] }}</td>
                                <td>{{ $item['created_at'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total IN:</th>
                        <th>{{ $totalIn }}</th>
                    </tr>
                </tfoot>
            </table>
<br>
<br>
                 <h3>Table for OUT transactions </h3>
                 <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">UOM</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inuom as $key => $item)
                            @if (isset($item['out']) && $item['out'] > 0)
                                <tr>
                                    <td>{{ $key +1 }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td>{{ $item['uom'] }}</td>
                                    <td>{{ $item['out'] }}</td>
                                    <td>{{ $item['created_at'] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total OUT:</th>
                            <th>{{ $totalOut }}</th>
                        </tr>
                    </tfoot>
                </table>
        </div>
      </div>

        <br>
        {{-- table click --}}
        <div class="card">
            <div class="card-body">
                <h3>List Item Per day </h3>

                @foreach ($transactions as $date => $transactionGroup)
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
                            @foreach ($transactionGroup as $transaction)
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
                    <br>
                    <br>
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
                        }
                    ]
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
