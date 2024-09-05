@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"> <i class="fas fa-download" style="font-size: 30px"></i> Department</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{route('depart.create')}}" class="btn btn-link" style="font-size: 20px;"><i class="fas fa-user-plus"></i> Add More Department</a>

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Department</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                @forelse ($users as $key => $usr)
                
                <tr>
                    <td>{{ $key +1 }}</td>
                    <td>{{ $usr->department }}</td>
        
                    <td style="height: 40px">
                        <form method="POST" class="action"  onsubmit="return confirm('Apakah Anda Yakin?');" action="{{ route('depart.delete', $usr->id) }}">
                            <a href="{{ route('depart.edit', $usr->id) }}" class="btn btn-primary">Edit</a>
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>    
                        </form>
                    </td>
                </tr>
                
            </tbody>
            
            @empty
            <div class="alert alert-danger">
               Belum ada Department Yang Terdaftar.
            </div>
            @endforelse 
            
        </table>
    </div>
</div>
@endsection