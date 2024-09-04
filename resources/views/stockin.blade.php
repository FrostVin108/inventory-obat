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
                                    <option value="{{$ic->id}}">{{$ic->item_code}} | {{$ic->description}}</option>
                                @endforeach
                        </select>
                        </div>
                        @error('item_code')
                        <div class="alert alert-danger mt-2">
                                {{ $message }}
                        </div>
                        @enderror

                        <div class="form-group">
                            <label for="exampleInputEmail">How Many Quantity</label>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" name="qty">
                            @error('qty')
                            <div class="alert alert-danger mt-2">
                                    {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group stockin" >
                            <input type="checkbox"  class="form-control @error('transaction_type') is-invalid @enderror" name="transaction_type" value="IN" style="width: 25px;">
                            Apakah Anda Mau Stockin?
                            @error('transaction_type')
                            <div class="alert alert-danger mt-2">
                                    {{ $message }}
                            </div>
                            @enderror
                        </div>
        
                        <button type="submit" class="btn btn-success">Sumbit</button>
                        <form>
                    <a href="{{ route('ob.home') }}" class="btn btn-warning">Return</a>
           

    </div>
</div>

<style>
    .stockin{
        margin-left: 20px;
        /* border: solid 2px yellow; */
        width: 300px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>
@stop