<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Medicine User REPORT</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <style type="text/css">
        .pdf-margin {
            margin: 20px;
        }

        table {
            width: 100%;
        }

        table,
        th,
        tr,
        td {
            border-collapse: collapse;
            border: solid 2px black;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="pdf-margin">
        <h1 style="margin-top: 10px">Out Report For {{ date('F', mktime(0, 0, 0, $month, 1)) }}</h1>
        <br>
        <br>

        @foreach ($data as $order)
            <table>
                <thead>
                    <tr>
                        <th scope="colgroup" colspan="5" style="height: 20px" >
                            <h3>Department: {{ $order['department'] }}</h3>
                        </th>
                    </tr>
                    <tr style="background-color:rgba(168, 168, 168, 0.486);">
                        <th scope="col" style="width: 5%">No</th>
                        <th scope="col">Item Description</th>
                        <th scope="col" style="width: 21%">Transaction Type</th>
                        <th scope="col" style="width: 14%">Quantity</th>
                        <th scope="col" style="width: 25%">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order['out_transactions'] as $transaction)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $transaction['item_description'] }}</td>
                            <td class="text-center">{{ $transaction['transaction_type'] }}</td>
                            <td class="text-center">{{ $transaction['qty'] }}</td>
                            <td class="text-center">{{ $transaction['created_at'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <br>
        @endforeach
    </div>
</body>

</html>
