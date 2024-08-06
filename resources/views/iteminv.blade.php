@extends('layouts.app')

@section('content_header')
    <h1>Item Warehouse</h1>
  
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <a href="citem" class="btn btn-success">Create</a>
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Item Code</th>
                <th scope="col">Description</th>
                <th scope="col">UOM</th>
                <th scope="col">Stock</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                @forelse ($obatitem as $key => $obi)
                <tr>
                    <td>{{ $key +1 }}</td>
                    <td>{{ $obi->item_code }}</td>
                    <td>{{ $obi->description }}</td>
                    <td>{{ $obi->Uom->unit_of_measurement}}</td>
                    {{-- <td>{{ $stock[$key]->first()->qty }}</td> --}}
                    {{-- <td>{{ $stock->where('item_id', $obi->id)->first()->qty }}</td> --}}
                        @foreach ($stock as $s)
                        <td>{{ $s->qty }}</td>
                        @endforeach
                        
                    
                        <form method="POST" onsubmit="return confirm('Apakah Anda Yakin?');" action="{{ route('ob.itemdel', $obi->id) }}">
                            <a href="{{ route('ob.edititem', $obi->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>    
                        </form>
                    </td>
                </tr>
            </tbody>
          
           

            @empty
            <div class="alert alert-danger">
                Data Belum Terisi. 
            </div>
            @endforelse 
        </table>
    </div>
</div>
@stop