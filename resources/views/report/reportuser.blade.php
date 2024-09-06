@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"><i class="fas fa-file-alt"></i> Report</h1>
@stop

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="card-body">
    <input type="text" id="search-input" placeholder="Search...">
    <button id="search-btn">Search</button>
    <button id="clear-btn">Clear</button>

    <div id="search-results">
        @foreach($data as $order)
            <h2>Department: {{ $order['department'] }}</h2>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Item Description</th>
                        <th>Transaction Type</th>
                        <th>Quantity</th>
                        <th>Date Added</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach($order['in_transactions'] as $transaction)
                        <tr>
                            <td>{{ $transaction['item_description'] }}</td>
                            <td>IN</td>
                            <td>{{ $transaction['qty'] }}</td>
                            <td>{{ date('Y-m-d H:i:s', strtotime($transaction['created_at'])) }}</td>
                        </tr>
                    @endforeach
                    @foreach($order['out_transactions'] as $transaction)
                        <tr>
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
</div>

<script>
    $(document).ready(function() {
        $('#search-btn').on('click', function() {
            var searchTerm = $('#search-input').val().toLowerCase();
            $('#table-body tr').each(function() {
                var itemDesc = $(this).find('td:first').text().toLowerCase();
                var transactionType = $(this).find('td:nth-child(2)').text().toLowerCase();
                if (itemDesc.indexOf(searchTerm) === -1 && transactionType.indexOf(searchTerm) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });

        $('#clear-btn').on('click', function() {
            $('#search-input').val('');
            $('#table-body tr').show();
        });
    });
</script>
@endsection