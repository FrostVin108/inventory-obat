<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Medicine User REPORT</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    
    <style type="text/css">
        @page {
            margin: 1cm 0.4cm;
        }

        .table-bundle-in-report td, .table-bundle-in-report th {
            padding: 0.25rem;
            vertical-align: middle;
        }
        
        .title-bundle-in-report {
            clear: left;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        .subtitle-bundle-in-report {
            font-size: 12px;
        }

        .header-main { 
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .company-name {
            float: left;
            text-align: left;
            font-size: 12px;
        }

        .created-by-and-date{
            float: right;
            text-align: right;
            font-size: 10px;
        }

        .table-bundle-in-report {
            clear: left;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .serial-number-qr {
            float: right;
            text-align: right;
            font-size: 12px;
        }

        .table-bundle-in-report {
            border: 2px solid black;
        }

        .table-bundle-in-report thead th {
            border: solid black;
            border-width: 1px;
            vertical-align: middle;
            text-align: center;
            font-size: 8pt;
            padding: 0;
        }
        
        .table-bundle-in-report tbody td {
            border: 1px solid black;
            vertical-align: middle;
            text-align: center;
            font-weight: bold;
            font-size: 8pt;
            padding: 2px 0.3px;
            white-space: nowrap;
        }
        
	</style>
</head>
<body>
    @foreach ($data as $order)
    <div class="">
        <div class="header-main">
            <h2>Department: {{ $order['department'] }}</h2>
        </div>

         <div>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
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
                                        if (date('m', strtotime($transaction['created_at'])) == session('month')) {
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
        </div>
    </div>
    @endforeach
</body>
</html>