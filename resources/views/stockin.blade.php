@extends('layouts.app')

@section('content_header')
    <h1>Transaction</h1>
  
@stop

@section('content')
<div class="card">
    <div class="card-body">
            <h2>Stock In</h2>

                <form method="POST" action="{{ route('ob.cstockin') }}">
                    @csrf
                    @method('post')
                        <div class="form-group" >
                            <label for="exampleInputEmail1">Choose Item Code</label>
                            <select name="item_id" class="form-control @error('item_code') is-invalid @enderror">
                                @foreach ($item as $ic)
                                    <option value="{{$ic->id}}">{{$ic->item_code}}</option>
                                @endforeach
                        </select>
                        </div>
                        @error('item_code')
                        <div class="alert alert-danger mt-2">
                                {{ $message }}
                        </div>
                        @enderror

                        <div class="form-froup">
                            <label for="exampleInputEmail">How Many Quantity</label>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" name="qty">
                            @error('qty')
                            <div class="alert alert-danger mt-2">
                                    {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Sumbit</button>
                        <a href="{{ route('ob.home') }}" ><button class="btn btn-warning">Return</button></a>
                <form>
           

    </div>
</div>
@stop