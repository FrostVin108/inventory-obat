@extends('layouts.app')

@section('content_header')
    <h1>Uom / Unit Of Measurement</h1>
  
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('ob.cuom') }}">
            @csrf
            @method('post')
            <div class="form-group" >
                <label for="exampleInputEmail1">Insert Unit Of Measurement / UOM</label>
                <input type="text" class="form-control @error('unit_of_measurement') is-invalid @enderror" placeholder="Enter UOM" name="unit_of_measurement">
              </div>
              @error('unit_of_measurement')
              <div class="alert alert-danger mt-2">
                  {{ $message }}
              </div>
              @enderror
              <button type="submit" class="btn btn-success">Submit</button>
              
              <a href="{{ route('wh.uominv') }}" class="btn btn-warning">Return</a>
            </form>    
    </div>
</div>
@stop