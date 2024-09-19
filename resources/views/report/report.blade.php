@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"><i class="	fas fa-file-alt"></i> Monthly Report</h1>
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
                                <select id="month" class=".form-select-sm example">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ session('month') == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                    @endfor
                                </select>
                                <div class="input-group-append ">
                                    <button class="btn btn-primary btn-sm" id="change-month"><i class="	fas fa-sync"></i>
                                        Change</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Report Period: From {{ $firstDayOfMonth }} - {{ $lastDayOfMonth }}</strong>
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
                            <div>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
                                <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
                                <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
                            </div>

                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>{{ $firstDayOfMonth }} - {{ $lastDayOfMonth }} | Monthly Item Overview</strong>
                                </p>


                                <!-- all month items -->
                                <table class="table table-hover" id="item-overview">
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
                                                <td>{{ $item->item }}</td>
                                                <td>{{ $item->total_in }}</td>
                                                <td>{{ $item->total_out }}</td>
                                                <td>{{ $item->balance }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- Display pagination links --}}
                                {{ $data->links() }}

                                {{-- <script>
                                    $(document).ready(function() {
                                        $('#item-overview').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            ajax: '{{ route('reportitem.overview.data' ,['month' => date('m')]) }}',
                                            columns: [
                                                { data: 'item', name: 'item' },
                                                { data: 'in', name: 'in' },
                                                { data: 'out', name: 'out' },
                                                { data: 'balance', name: 'balance' },
                                            ]
                                        });
                                    });
                                </script> --}}
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
                                        <span class="text-md">
                                            <h5>{{ $stockin }}</h5>
                                        </span>
                                        <h5 class="description-text ">Stock In</h5>
                                        <span class="text-sm">({{ $firstDayOfMonth }} - {{ $lastDayOfMonth }})</span>
                                    </div>
                                </div>

                                <div class="col-sm-4 col-6">
                                    <div class="description-block border-right">
                                        <span class=" text-md">
                                            <h5>{{ $stockout }}</h5>
                                        </span>
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
$previousMonthIn = DB::table('transactions')
    ->whereMonth('created_at', $previousMonth)
    ->whereYear('created_at', $previousYear)
    ->where('transaction_type', 'in')
    ->sum('qty');

$previousMonthOut = DB::table('transactions')
    ->whereMonth('created_at', $previousMonth)
    ->whereYear('created_at', $previousYear)
    ->where('transaction_type', 'out')
    ->sum('qty');

// retrieve current month's "in" and "out" transactions
                                                $currentMonthIn = DB::table('transactions')
                                                    ->whereMonth('created_at', $selectedMonth)
                                                    ->whereYear('created_at', $currentYear)
                                                    ->where('transaction_type', 'in')
                                                    ->sum('qty');

                                                $currentMonthOut = DB::table('transactions')
                                                    ->whereMonth('created_at', $selectedMonth)
                                                    ->whereYear('created_at', $currentYear)
                                                    ->where('transaction_type', 'out')
                                                    ->sum('qty');

                                                // calculate the balance
                                                $newBalance =
                                                    $previousMonthIn -
                                                    $previousMonthOut +
                                                    ($currentMonthIn - $currentMonthOut);

                                                // calculate the profit/loss
                                                $profitLoss =
                                                    $previousMonthIn -
                                                    $previousMonthOut +
                                                    ($currentMonthIn - $currentMonthOut);
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

                            <!-- /.card-footer -->
                        </div>
                        <!-- /.col -->
                    </div>
                    {{-- All Button --}}





                </div>
            </div>
        </div>
        <br>


        <div class="card-body">
            <h3>IN Transactions Log</h3>
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
                                <td>{{ $key + 1 }}</td>
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
            <h3>OUT Transactions Log</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">Item Name</th>
                        {{-- <th scope="col">Order By</th> --}}
                        <th scope="col">UOM</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inuom as $key => $item)
                        @if (isset($item['out']) && $item['out'] > 0)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item['description'] }}</td>
                                {{-- <td>{{ $item['department'] }}</td> --}}
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
    {{-- 
        @foreach ($products as $product)
        {{ $product->product_name}} --}}




    {{-- table click --}}
    <div class="card">
        <div class="card-body">
            <button id="back-to-top" title="Back to Top">
                <i class="fas fa-arrow-up"></i>
            </button>
            <h3>Month’s Daily Log</h3>

            <!-- Pagination Links -->


        

<!-- Search bar for month's daily log -->
<div class="search-position">
    <form method="GET" action="{{ route('report.monthly', ['month' => $month]) }}" class="input-button">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by date, item name, or department" class="form-control input-search" style="width: 60%">
        <div>
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>
        





            @foreach ($transactions as $date => $transactionGroup)
                <h5>Date : {{ $date }}</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 25%">Item Name</th>
                            <th scope="col" style="width: 20%;">Order By</th>
                            <th scope="col" style="width: 16%;">Transaction Type</th>
                            <th scope="col" style="width: 10%;">Quantity</th>
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

            <div class="column w-20 pagination-post">
                {{ $transactions->appends(request()->query())->links() }}
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

        $(window).scrollTop(localStorage.getItem('scrollPosition') || 0);

        $(window).on('scroll', function() {
            localStorage.setItem('scrollPosition', $(window).scrollTop());
        });


        $(document).ready(function() {
            $('#back-to-top').on('click', function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
            });
        });
    </script>

    <style>
        #back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #back-to-top:hover {
            background-color: #555;
        }

        /* Custom pagination styles */
        .pagination {
            justify-content: center;
            font-size: 21px
        }

        .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .page-link {
            border-radius: 0.375rem;
        }

        .page-link {
            padding: 0.5rem 1rem;
            margin: 0 0.125rem;
            border: 1px solid #ddd;
            color: #007bff;
            text-decoration: none;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #ddd;
        }




        .pagination.post {
            display: flex;
            justify-content: center;
        }

        svg {
            width: 20px;
        }

        .search-position {
            /* border: solid 3px black; */
            display: flex;
            width: 98%
        }

        .input-search {
            width: 100%
        }

        .input-button {
            display: flex;
            align-content: center;
            margin-left: auto;
            gap: 5px;
            width: 22%;
        }
    </style>
@endsection
