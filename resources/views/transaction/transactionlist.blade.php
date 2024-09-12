@extends('layouts.app')

@section('content_header')
   <h1> <i class="fas fa-clipboard-list"></i> Transaction List</h1>
@stop

@section('content')

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

.dataTables_length select {
    width: 70px !important;
    height: 30px !important;
    padding: 5px !important;
    border: 1px solid #ccc !important;
    border-radius: 4px !important;
}

</style>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
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
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        return moment(data).format('YYYY-MM-DD HH:mm:ss');
                    }
                }
            ]
        });
    });
</script>
@endpush