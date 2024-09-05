@extends('layouts.app')

@section('content_header')
    <h1>Uom Type</h1>
  
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <a href="uom" class="btn btn-success">Create</a>

        <br>
        <br>
        <table class="table table-bordered">
            
            <thead>
            <tr>
                <th width="5%" scope="col">id</th>
                <th  scope="col">UOM</th>
                <th width="20%" scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                @forelse ($obatuom as $key => $obuom)
                <tr>
                    <td>{{ $key +1 }}</td>
                    <td>{{ $obuom->unit_of_measurement}}</td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Apakah Anda Yakin?');" action="{{ route('ob.uomdel', $obuom->id) }}">
                            <a href="{{ route('ob.edituom', $obuom->id) }}" class="btn btn-sm btn-primary">EDIT</a>
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