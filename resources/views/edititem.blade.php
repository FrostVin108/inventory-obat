@extends('layouts.app')

@section('content_header')
    <h1>Item</h1> 
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('ob.updateitem', $edititem->id) }}">
            @csrf
            @method('post')
            <div class="form-group" >
                <label for="exampleInputEmail1">Insert Item Description</label>
                <input type="text" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description" name="description" value="{{ old('description', $edititem->description) }}">
              </div>
              @error('description')
              <div class="alert alert-danger mt-2">
                  {{ $message }}
              </div>
              @enderror

              <div class="form-group" >
                <label for="exampleInputEmail1">Insert Item Code</label>
                <input type="number" class="form-control @error('item_code') is-invalid @enderror" placeholder="Enter Item Code" name="item_code" value="{{ old('item_code', $edititem->item_code) }}">
              </div>
              @error('item_code')
              <div class="alert alert-danger mt-2">
                  {{ $message }}
              </div>
              @enderror

                <div class="form-group" >
                    <label for="exampleInputEmail1">Insert Uom</label>
                    <select name="unit_of_measurement_id" class="form-control @error('uom') is-invalid @enderror"  value="{{ old('unit_of_measurement_id', $edititem->unit_of_measurement_id) }}">
                        <option value="{{ old('unit_of_measurement_id', $edititem->unit_of_measurement_id) }}">{{ old('unit_of_measurement', $edititem->unit_of_measurement) }}</option>
                        @foreach ($uom as $uom)
                            <option value="{{$uom->id}}">{{$uom->unit_of_measurement}}</option>
                        @endforeach
                    </select>
                </div>
                @error('uom')
                <div class="alert alert-danger mt-2">
                        {{ $message }}
                </div>
                @enderror

                <div class="form-group" >
                    <label for="exampleInputEmail1">Insert Item Quantity</label>
                    <input type="number" class="form-control @error('qty') is-invalid @enderror" placeholder="Enter Item Quantity" name="qty" value="{{ old('qty', $stock->qty) }}">
                  </div>
                  @error('qty')
                  <div class="alert alert-danger mt-2">
                      {{ $message }}
                  </div>
                  @enderror
                

              <button type="submit" class="btn btn-success">Submit</button>
              <a href="{{ route('wh.iteminv') }}" class="btn btn-warning">Return</a> 
            </form>
    </div>
</div>
@stop