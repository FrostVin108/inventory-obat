@extends('layouts.app')

@section('content_header')
    <h1>Registered User</h1> 
@stop

@section('content')
<div class="card" style="width: 50vw">
    <div class="card-body">
        <h3>Create User</h3>
        <br>

        <form method="POST" action="{{ route('add.create.user')}}" >
            @csrf
            @method('post')
            <div class="form-group">
                <label for="exampleInputEmail1">Add Users Name</label>
                <input type="text" class="form-control" placeholder="add name" name="name">

                <label for="exampleInputEmail1">Add Users Email</label>
                <input type="email" class="form-control" placeholder="add email" name="email">

                <label for="exampleInputEmail1">Add Users Password</label>
                <input type="password" class="form-control" placeholder="add password" name="password">

            </div>

            <button type="submit" class="btn btn-success"> <i class="fas fa-file-upload"></i> Submit</button>
              
            <a href="{{ route('users') }}" class="btn btn-warning"><i class="fas fa-reply"></i> Return</a>
        </form>
    </div>
</div>
@endsection