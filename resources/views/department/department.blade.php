@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"> <i class="fas fa-hard-hat" style="font-size: 30px"></i> Department</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{route('depart.create')}}" class="btn btn-link" style="font-size: 20px;"><i class="fas fa-user-plus"></i> Add More Department</a>
        @if(session('error'))
        <div class="alert alert-danger" id="error-alert">
            {{ session('error') }}
        </div>
    @endif

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
                            <a href="{{ route('depart.edit', $usr->id) }}" class="btn btn-primary"> <i class="far fa-edit"></i> Edit</a>
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"> <i class="fas fa-trash"></i> Delete</button>    
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="alert alert-danger">
                            No That Been Department Registered.
                        </div>
                    </td>
                </tr>
            </tbody>
            @endforelse 
            
        </table>
    </div>
</div>
<script>
    setTimeout(function() {
        document.getElementById("error-alert").classList.add("fade-out");
        setTimeout(function() {
            document.getElementById("error-alert").remove();
        }, 500);
    }, 4500);
</script>
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
@endsection