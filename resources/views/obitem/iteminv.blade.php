@extends('layouts.app')

@section('content_header')
        <h1 style="font-size: 27px"> <i class="fas fa-warehouse" style="font-size: 30px"></i> Item Obat</h1>
        
@stop

@section('content')
<script>
    setTimeout(function() {
        document.getElementById("error-alert").classList.add("fade-out");
        setTimeout(function() {
            document.getElementById("error-alert").remove();
        }, 500);
    }, 4500);
</script>

<div class="card">
    <div class="card-body">
        <div class="form-control mb-4" style="border: none;padding:0px;">
            <a href="citem" class="btn btn-success" > <i class="fas fa-plus-square"></i> Create</a>
            <a href="{{route('home')}}" class="btn btn-info"> <i class="	fas fa-reply"></i> Go Back</a>
        </div>
        @if(session('error'))
        <div class="alert alert-danger" id="error-alert">
            {{ session('error') }}
        </div>
    @endif
        <table id="example2" class="table table-bordered table-hover ">
        
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
                @forelse ($obatitem as $key => $obi )
                
                <tr>
                    <td>{{ $key +1 }}</td>
                    <td>{{ $obi->item_code }}</td>
                    <td>{{ $obi->description }}</td>
                    <td>{{ $obi->Uom->unit_of_measurement}}</td>
                    <td>{{ $obi->stock->qty }}</td>
                    <td>
                    <form method="POST" onsubmit="return confirm('Apakah Anda Yakin?');" action="{{ route('ob.itemdel', $obi->id) }}">
                        <a href="{{ route('ob.edititem', $obi->id) }}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i> Edit</a>
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>    
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="alert alert-danger">
                        Data Belum Terisi. 
                    </div>
                </td>
            </tr>
            @endforelse 
            </tbody>
        </table>
    </div>
</div>


<style>
    .logo-setting{
        display: flex;
        flex-direction: row;
        gap: 10px;
    }
    
</style>
<style>
    .fade-out {
        animation: fadeOut 1s;
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }
</style>

@stop