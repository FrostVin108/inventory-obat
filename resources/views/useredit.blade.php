@extends('layouts.app')

@section('content_header')
    <h1>Registered User</h1> 
@stop

@section('content')
<div class="card" style="width: 50vw">
    <div class="card-body">
        <h3>Create User</h3>
        <br>

        <form method="POST" action="{{ route('user.update', $useredit->id)}}" >
            @csrf
            @method('put')
            <div class="form-group">
                <label for="exampleInputEmail1">Add Users Name</label>
                <input type="text" class="form-control" placeholder="add name" name="name" value="{{ old('name', $useredit->name) }}">

                <label for="exampleInputEmail1">Add Users Email</label>
                <input type="email" class="form-control" placeholder="add email" name="email" value="{{ old('name', $useredit->email) }}">

                <label for="exampleInputEmail1">Add Users Password</label>
                <input type="password" class="form-control" placeholder="add password" name="password" autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-success"> <i class="fas fa-file-upload"></i> Submit</button>
              
            <a href="{{ route('users') }}" class="btn btn-warning"><i class="fas fa-reply"></i> Return</a>
        </form>
    </div>
</div>
@endsection