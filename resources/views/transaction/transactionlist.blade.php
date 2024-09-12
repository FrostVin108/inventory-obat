@extends('layouts.app')

@section('content_header')
   <h1> <i class="fas fa-clipboard-list"></i> Transaction List</h1>
@stop

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<div class="card-body">
    <div class="card" style="padding: 30px">
        <table class="table table-bordered data-table" id="trans">
            <thead>
            <tr>
                {{-- <th scope="col">No</th> --}}
                <th scope="col">Item</th>
                <th scope="col">Department</th>
                <th scope="col">Transaction Type</th>
                <th scope="col">Quantity</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
                {{-- @forelse ($translist as $key => $trans)
                
                <tr>
                    <td>{{ $key +1 }}</td>
                    <td>{{ $trans->item->description }}</td>
                    <td>{{ $trans->order->department }}</td>
                    <td>{{ $trans->transaction_type	}}</td>
                    <td>{{ $trans->qty }}</td>
                    <td>{{ $trans->created_at }}</td>
                </tr>
                 --}}
            </tbody>
{{--             
            @empty
            <div class="alert alert-danger">
               Tidak Ada Ram Terisi.
            </div>
            @endforelse  --}}
            
        </table>
    </div>
</div>

<style>
    .table-bordered th, .table-bordered td {
    box-shadow: none;
}

.dataTables_length {
    margin-bottom: 20px;
}

.dataTables_length label {
    font-weight: normal;
}

.dataTables_length select {
    width: 70px !important;
    height: 30px !important;
    padding: 5px !important;
    border: 1px solid #ccc !important;
    border-radius: 4px !important;
}

.dt-button {
    background-color: #337ab7 !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 4px !important;
    padding: 5px 10px !important;
    font-size: 12px !important;
    cursor: pointer !important;
    box-shadow: none !important; /* Add this to remove the thick black shadow */
}


.dt-button:hover {
    background-color: #ffffff;
    cursor: pointer !important;
    box-shadow: none !important; 
    border: none !important; /* Add this to remove the border */
}

</style>
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#trans').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('trans.list.data') }}',
            columns: [
                
                { data: 'item.description', name: 'item.description' },
                { data: 'order.department', name: 'order.department' },
                { data: 'transaction_type', name: 'transaction_type' },
                { data: 'qty', name: 'qty' },
                { data: 'created_at', name: 'created_at' }
            ]
        });
    });
</script>
@endpush