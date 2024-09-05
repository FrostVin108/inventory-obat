{{-- @extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"><i class="	fas fa-file-alt"></i> Report</h1>
@stop

@section('content')


<div class="card">
  <div class="card-body">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Item</th>
            <th scope="col">Department</th>
            <th scope="col">Transaction Type</th>
            <th scope="col">Quantity</th>
            <th scope="col">Date</th>
        </tr>
        </thead>
        <tbody>
            @forelse ($stockInData as $key => $trans)
            
            <tr>
                <td>{{ $key +1 }}</td>
                <td>{{ $trans->item->description }}</td>
                <td>{{ $trans->order->department }}</td>
                <td>{{ $trans->transaction_type	}}</td>
                <td>{{ $trans->qty }}</td>
                <td>{{ $trans->created_at }}</td>
            </tr>
            
        </tbody>
        
        @empty
        <div class="alert alert-danger">
           Tidak Ada Ram Terisi.
        </div>
        @endforelse 
        
    </table>
    </div>
</div>
@endsection --}}