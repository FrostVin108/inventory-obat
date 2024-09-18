@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"><i class="fas fa-file-alt"></i> Report</h1>
@stop

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- CDNJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- jsDelivr -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <div class="card">
            <button id="back-to-top" title="Back to Top" style="width:55px; height:55px; fontsize:30px;">
                <i class="fas fa-arrow-up"></i>
            </button>
            <button id="combine-btn" title="Combine The Same Data" style="width:55px; height:55px; fontsize:30px;"><i class="fas fa-object-group"></i></button>
            <button id="uncombine-btn" title="Uncombine The Same Data" style="width:55px; height:55px; fontsize:30px; display: none;"><i class="fas fa-object-ungroup"></i></button>
            
            <script>
                $('#combine-btn').on('click', function() {
                    $(this).toggle();
                    $('#uncombine-btn').toggle();
                    // Combine data functionality here
                });
                
                $('#uncombine-btn').on('click', function() {
                    $(this).toggle();
                    $('#combine-btn').toggle();
                    // Uncombine data functionality here
                });
            </script>
                
        <div class="card-body" style="padding: 47px;">
            <div class="d-flex input-group">
                <div class="col-md-6 search-post">
                    <input type="text" id="search-input" placeholder="Search..." class="form-control" style="width: 44%">
                    <button id="search-btn" class="btn btn-success">Search</button>
                    <button id="clear-btn" class="btn btn-warning">Clear</button>

                    {{-- <button id="combine-btn" class="btn btn-info">Combine</button> --}}
                    {{-- <button id="uncombine-btn" class="btn btn-danger">Uncombine</button> --}}
                </div>

                <div class="col-md-6 input-group" style="gap: 5px;">
                    <select id="month" class="form-control-border ml-auto">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ session('month') == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                        @endfor
                    </select>
                    <button class="btn btn-primary btn-sm" id="change-month"><i class="fas fa-sync"></i> Change</button>
                </div>
            </div>
            <br>
            <br>


            <div id="search-results">
                @foreach ($data as $order)
                <div class="department-container">
                    <h2>Department: {{ $order['department'] }}</h2>
            
                    <canvas id="department-chart-{{ $order['department'] }}" width="400" height="200"></canvas>
                    <br>
                    <br>
            
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Item Description</th>
                                <th>Transaction Type</th>
                                <th>Quantity</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $currentMonthTransactions = [];
                                foreach ($order['out_transactions'] as $transaction) {
                                    if (date('m', strtotime($transaction['created_at'])) == date('m')) {
                                        $currentMonthTransactions[] = $transaction;
                                    }
                                }
                            @endphp
                            @foreach ($currentMonthTransactions as $key => $transaction)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $transaction['item_description'] }}</td>
                                    <td>{{ $transaction['transaction_type'] }}</td>
                                    <td>{{ $transaction['qty'] }}</td>
                                    <td>{{ date('Y-m-d H:i:s', strtotime($transaction['created_at'])) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            
                    @php
                        $itemDescriptions = [];
                        foreach ($order['out_transactions'] as $transaction) {
                            $itemDescriptions[$transaction['item_description']][] = $transaction['qty'];
                        }
                    @endphp
            
            <script>
                var ctx = document.getElementById('department-chart-{{ $order['department'] }}').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            @foreach ($itemDescriptions as $item => $quantities)
                                '{{ $item }}',
                            @endforeach
                        ],
                        datasets: [{
                            label: 'Current Month',
                            data: [
                                @foreach ($itemDescriptions as $item => $quantities)
                                    @php
                                        $currentMonthQty = 0;
                                        foreach ($order['out_transactions'] as $transaction) {
                                            if (date('m', strtotime($transaction['created_at'])) == date('m') && $transaction['transaction_type'] == 'OUT' && $transaction['item_description'] == $item) {
                                                $currentMonthQty += $transaction['qty'];
                                            }
                                        }
                                    @endphp
                                    {{ $currentMonthQty }},
                                @endforeach
                            ],
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Previous Month',
                            data: [
                                @foreach ($itemDescriptions as $item => $quantities)
                                    @php
                                        $previousMonthQty = 0;
                                        $previousMonth = date('m', strtotime('-1 month'));
                                        foreach ($order['out_transactions'] as $transaction) {
                                            if (date('m', strtotime($transaction['created_at'])) == $previousMonth && $transaction['transaction_type'] == 'OUT' && $transaction['item_description'] == $item) {
                                                $previousMonthQty += $transaction['qty'];
                                            }
                                        }
                                    @endphp
                                    {{ $previousMonthQty }},
                                @endforeach
                            ],
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
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
                </div>
            @endforeach
            </div>
        </div>
    </div>

    <style>
        .search-post {
            display: flex;
            flex-direction: row;
            gap: 3px;
        }

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

        #combine-btn {
            position: fixed;
            bottom: 80px;
            right: 20px;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            background-color: rgb(34, 178, 65);
            color: white;
        }

        #combine-btn:hover{
            background-color: rgb(63, 216, 43);
        }

        #uncombine-btn {
            position: fixed;
            bottom: 80px;
            right: 20px;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            background-color: rgb(178, 34, 34);
            color: white;
        }

        #uncombine-btn:hover{
            background-color: rgb(216, 43, 43);
        }

    </style>

    <script>
        $(document).ready(function() {
            $('#search-btn').on('click', function() {
                var searchTerm = $('#search-input').val().toLowerCase();
                $('.department-container').each(function() {
                    var department = $(this).find('h2').text().toLowerCase();
                    var found = false;
                    if (department.indexOf(searchTerm) !== -1) {
                        found = true;
                        $(this).find('.table-body tr').show();
                    } else {
                        $(this).find('.table-body tr').each(function() {
                            var itemDesc = $(this).find('td:first').text().toLowerCase();
                            var transactionType = $(this).find('td:nth-child(2)').text()
                                .toLowerCase();
                            if (itemDesc.indexOf(searchTerm) !== -1 || transactionType
                                .indexOf(searchTerm) !== -1) {
                                found = true;
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    }
                    if (found) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('#clear-btn').on('click', function() {
                $('#search-input').val('');
                $('.department-container').show();
                $('.table-body tr').show();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#change-month').on('click', function() {
                var month = $('#month').val();
                var url = '{{ route('report.user.in', ':month') }}'.replace(':month', month);
                window.location.href = url;
            });
        });

        $(document).ready(function() {
            $('#back-to-top').on('click', function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
            });
        });
    </script>

@endsection
