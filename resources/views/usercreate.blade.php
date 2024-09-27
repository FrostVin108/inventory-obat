@extends('layouts.app')

@section('content_header')
    <h1>Registered User</h1> 
@stop

@section('content')
<div class="card" style="width: 50vw">
    <div class="card-body">
        <h3>Create User</h3>
        <br>

        <form method="POST" action="{{ route('user.create.add')}}" >
            @csrf
            @method('post')
            <div class="form-group">
                <label for="exampleInputEmail1">Add Users Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="add name" name="name">
                @error('name')
                <div class="alert alert-danger mt-2">
                        {{ $message }}
                </div>
                @enderror

                <label for="exampleInputEmail1">Add Users Role</label>
                <select name="role" class="form-control @error('role') is-invalid @enderror">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                @error('role')
                <div class="alert alert-danger mt-2">
                        {{ $message }}
                </div>
                @enderror

                <label for="exampleInputEmail1">Add Users Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="add email" name="email">
                @error('email')
                <div class="alert alert-danger mt-2">
                        {{ $message }}
                </div>
                @enderror

                <label for="exampleInputEmail1">Add Users Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="add password" name="password">
                @error('password')
                <div class="alert alert-danger mt-2">
                        {{ $message }}
                </div>
                @enderror

            </div>

            <button type="submit" class="btn btn-success"> <i class="fas fa-file-upload"></i> Submit</button>
              
            <a href="{{ route('users') }}" class="btn btn-warning"><i class="fas fa-reply"></i> Return</a>
        </form>
    </div>
</div>
@endsection