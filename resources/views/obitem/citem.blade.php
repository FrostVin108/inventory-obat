@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"> <i class="fas fa-download" style="font-size: 30px"></i> Insert Item</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('ob.citem') }}">
            @csrf
            @method('post')
            <div class="form-group" >
                <label for="exampleInputEmail1">Insert Item Description</label>
                <input type="text" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description" name="description">
              </div>
              @error('description')
              <div class="alert alert-danger mt-2">
                  {{ $message }}
              </div>
              @enderror

              <div class="form-group" >
                <label for="exampleInputEmail1">Insert Item Code</label>
                <input type="number" class="form-control @error('item_code') is-invalid @enderror" placeholder="Enter Item Code" name="item_code" id="item_code">
                <span id="item_code-count">0/14</span> <!-- display character count -->
                <i id="item_code-icon" style="font-size: 18px;"></i> <!-- icon -->
            </div>
              @error('item_code')
              <div class="alert alert-danger mt-2">
                  {{ $message }}
              </div>
              @enderror

                <div class="form-group" >
                    <label for="exampleInputEmail1">Insert Uom</label>
                    <select name="unit_of_measurement_id" class="form-control @error('uom') is-invalid @enderror">

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
                    <label for="exampleInputEmail1">Insert Quantity</label>
                    <input type="number" class="form-control @error('qty') is-invalid @enderror" placeholder="Enter Item Quantity" name="qty">  
                </div>
                @error('qty')
                <div class="alert alert-danger mt-2">
                        {{ $message }}
                </div>
                @enderror
                

              <button type="submit" class="btn btn-success"> <i class="	fas fa-plus-square"></i> Submit</button>
              <a href="{{ route('wh.iteminv') }}" class="btn btn-warning"> <i  class="fas fa-reply"></i>  Return</a> 
            </form>
                
    </div>
</div>

<script>
    const itemCodeInput = document.getElementById('item_code');

    itemCodeInput.addEventListener('input', function() {
        const itemCodeCount = this.value.length;
        const itemCountSpan = document.getElementById('item_code-count');
        const itemCodeIcon = document.getElementById('item_code-icon');
        itemCountSpan.innerText = `${itemCodeCount}/14`;
        if (itemCodeCount <= 13) {
            itemCountSpan.style.color = 'red';
            itemCodeIcon.className = 'fas fa-exclamation-circle';
            itemCodeIcon.style.color = 'red';
        } else {
            itemCountSpan.style.color = 'green';
            itemCodeIcon.className = 'fas fa-check-circle ';
            itemCodeIcon.style.color = 'green';
        }
    });
</script>
@stop