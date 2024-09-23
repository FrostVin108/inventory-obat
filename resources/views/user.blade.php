@extends('layouts.app')

@section('content_header')
    <h1>Registered User</h1> 
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h2>All Registered users</h2>
        <br>
        <a href="{{ route('add.user')}}"><h4>Add More Users</h4></a>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" style="width: 5%">No</th>
                    <th scope="col" style="width: 15%">Name</th>
                    <th scope="col" style="width: 25%">Email</th>
                    <th scope="col" style="width: 40%">Password</th>
                    <th scope="col" style="width: 20%">Action</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ( $users as $key => $usr )
                    <tr>
                        <td>{{ $key +1 }}</td>
                        <td>{{ $usr->name }}</td>
                        <td>{{ $usr->email }}</td>
                        <td>{{ $usr->password }}</td>
                        <td>
                            {{-- action="{{ route('destroy.user', $usr->id)}}" {{ route('edit.user', $usr->id)}} --}}
                            <form method="POST" class="action"  onsubmit="return confirm('Apakah Anda Yakin?');">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger">Delete</button>
                                <a href="" class="btn btn-primary">Edit</a>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        
    </div>
</div>
@stop