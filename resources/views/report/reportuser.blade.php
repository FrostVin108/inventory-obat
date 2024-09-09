@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"><i class="fas fa-file-alt"></i> Report</h1>
@stop

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="card">
    <div class="card-body" style="padding: 47px">
        <input type="text" id="search-input" placeholder="Search..." class="form-control-border" >
        <button id="search-btn" class="btn btn-success">Search</button>
        <button id="clear-btn" class="btn btn-warning">Clear</button>
    
        <div id="search-results">
            @foreach($data as $order)
                <div class="department-container">
                    <h2>Department: {{ $order['department'] }}</h2>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Item Description</th>
                                <th>Transaction Type</th>
                                <th>Quantity</th>
                                <th>Date Added</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
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
                    <table class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Transaction Type</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>IN</td>
                                <td>{{ count($order['in_transactions']) }}</td>
                            </tr>
                            <tr>
                                <td>OUT</td>
                                <td>{{ count($order['out_transactions']) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
            @endforeach
        </div>
    </div>
</div>

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
                    var transactionType = $(this).find('td:nth-child(2)').text().toLowerCase();
                    if (itemDesc.indexOf(searchTerm) !== -1 || transactionType.indexOf(searchTerm) !== -1) {
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
@endsection