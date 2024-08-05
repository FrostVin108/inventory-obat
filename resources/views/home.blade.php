@extends('layouts.app')

@section('content_header')
    <h1>Dashboard</h1> 
@stop

@section('content')
<div class="card shadow p-3 mb-5 bg-white rounded">
    <div class="card-body">

        {{-- row1 --}}
        <div class="row">
            <hr>
            <a class="col-md-3 info-box bg-info" href="{{ route('ob.stockin') }}">
                <span class="info-box-icon "><i class="fas fa-arrow-circle-down"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Stock In</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">Total:all item</span>
                </div>
            </a>
        <hr>

            <a class="col-md-3 info-box bg-info" href="{{ route('ob.stockout') }}">
                <span class="info-box-icon "><i class="fas fa-arrow-circle-up"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Stock Out</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">Total:all item</span>
                </div>
            </a>
        <hr>

            <a class="col-md-3 info-box bg-info" href="iteminv">
                <span class="info-box-icon "><i class="fas fa-warehouse"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Item Warehouse</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">Total:all item</span>
                </div>
            </a><hr>           
        </div>

        {{-- row2 --}}
        <div class="row">
            <hr>
            <a class="col-md-3 info-box bg-dark" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>
            
            <a class="col-md-3 info-box bg-danger" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>

            <a class="col-md-3 info-box bg-warning" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>
        </div>

        {{-- row3 --}}
        <div class="row">
            <hr>
            <a class="col-md-3 info-box bg-danger" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>
            
            <a class="col-md-3 info-box bg-danger" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>

            <a class="col-md-3 info-box bg-danger" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>
        </div>

        {{-- row4 --}}
        <div class="row">
            <hr>
            <a class="col-md-3 info-box bg-danger" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>
            
            <a class="col-md-3 info-box bg-danger" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>

            <a class="col-md-3 info-box bg-warning" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>
        </div>
        
        {{-- row5 --}}
        <div class="row">
            <hr>
            <a class="col-md-3 info-box bg-warning" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>
            
            <a class="col-md-3 info-box bg-danger" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>
            
            <a class="col-md-3 info-box bg-danger" href="">
                <span class="info-box-icon "><i class="	fas fa-wrench"></i></span>
                <div class="info-box-content ">
                    <span class="info-box-tex text-left">Coming Soon</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="text-left info-box-number ">? :coming soon</span>
                </div>
            </a><hr>
    </div>
        
    </div>
</div>
@stop