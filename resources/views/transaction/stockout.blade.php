@extends('layouts.app')

@section('content_header')
    <h1> <i class="fas fa-clipboard-list"></i> Transaction</h1>
  
@stop

@section('content')
<div class="card">
    <div class="card-body">
            <h2>Stock Out</h2>
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('ob.cstockout') }}">
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

                    <div class="form-group" >
                        <label for="exampleInputEmail1">Pilih Department </label>
                        <select name="order_id" class="form-control @error('order_id') is-invalid @enderror">
                            @foreach ($order as $or)
                                <option value="{{$or->id}}">{{$or->department}}</option>
                            @endforeach
                    </select>
                    </div>
                    @error('order_id')
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

                    <div class="form-group stockout" >
                        <input type="checkbox"  class="form-control @error('transaction_type') is-invalid @enderror" name="transaction_type" value="OUT" style="width: 25px;">
                        Apakah Anda Mau Stockout?
                        @error('transaction_type')
                        <div class="alert alert-danger mt-2">
                                {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success"> <i class="fas fa-file-upload"></i> Sumbit</button>
                    <a href="{{ route('ob.home') }}" class="btn btn-warning"> <i class="fas fa-reply"></i> Return</a>
                </form>   
    </div>
</div>

<style>
    .stockout{
        margin-left: 20px;
        /* border: solid 2px yellow; */
        width: 3000px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

@stop