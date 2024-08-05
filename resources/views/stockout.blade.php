@extends('layouts.app')

@section('content_header')
    <h1>Transaction</h1>
  
@stop

@section('content')
<div class="card">
    <div class="card-body">
            <h2>Stock Out</h2>
            
            <a href="{{ route('ob.home') }}" ><button class="btn btn-warning">Return</button></a>
    </div>
</div>
@stop