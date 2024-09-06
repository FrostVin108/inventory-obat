@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"><i class="fas fa-file-alt"></i> Report</h1>
@stop

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="card-body">
        @foreach($data as $order)
            <h2>Order ID: {{ $order['order_id'] }}</h2>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Description</th>
                        <th>Transaction Type</th>
                        <th>Quantity</th>
                        <th>Date Added</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order['in_transactions'] as $transaction)
                        <tr>
                            <td>{{ $transaction['item_id'] }}</td>
                            <td>{{ $transaction['item_description'] }}</td>
                            <td>IN</td>
                            <td>{{ $transaction['qty'] }}</td>
                            <td>{{ date('Y-m-d H:i:s', strtotime($transaction['created_at'])) }}</td>
                        </tr>
                    @endforeach
                    @foreach($order['out_transactions'] as $transaction)
                        <tr>
                            <td>{{ $transaction['item_id'] }}</td>
                            <td>{{ $transaction['item_description'] }}</td>
                            <td>OUT</td>
                            <td>{{ $transaction['qty'] }}</td>
                            <td>{{ date('Y-m-d H:i:s', strtotime($transaction['created_at'])) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
        @endforeach
    </div>
@endsection