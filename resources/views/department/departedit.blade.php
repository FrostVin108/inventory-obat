@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"> <i class="fas fa-download" style="font-size: 30px"></i> Editing Department</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('depart.update', $editdepart->id) }}">
            @csrf
            @method('put')
            <div class="form-group" >
                <label for="exampleInputEmail1">Edit Department</label>
                <input type="text" class="form-control @error('department') is-invalid @enderror" placeholder="enter department" name="department" value="{{ old('department', $editdepart->department) }}">

              </div>
              @error('department')
              <div class="alert alert-danger mt-2">
                  {{ $message }}
              </div>
              @enderror
              <button type="submit" class="btn btn-success">Submit</button>
              <a href="{{ route('department.list') }}" class="btn btn-warning">Return</a>
            </form>    
    </div>
</div>
@endsection