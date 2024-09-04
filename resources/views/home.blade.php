@extends('layouts.app')

@section('content_header')
    <h1>Dashboard</h1> 
@stop

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
        <div class="card-body donut-chart">
            <div id="chart-container" style="width: 400px; height: 400px;">
                <canvas id="chart" width="400" height="400"></canvas>
            </div>
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
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            type: 'GET',
            url: '{{route('supliesqty')}}',
            dataType: 'json',
            success: function(data) {
                var labels = data.map(function(item) {
                    return item.label;
                });
                var qty = data.map(function(item) {
                    return item.qty;
                });
                var ctx = document.getElementById('chart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Quantity',
                            data: qty,
                            backgroundColor: [
                                'rgba(255, 99, 132, 3)',
                                'rgba(54, 162, 235, 3)',
                                'rgba(255, 206, 86, 3)',
                                'rgba(75, 192, 192, 3)',
                                'rgba(153, 102, 255, 3)',
                                'rgba(255, 159, 64, 3)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 10)',
                                'rgba(54, 162, 235, 10)',
                                'rgba(255, 206, 86, 10)',
                                'rgba(75, 192, 192, 10)',
                                'rgba(153, 102, 255, 10)',
                                'rgba(255, 159, 64, 10)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Quantity Semua Obat yang ada'
                         },
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                fontColor: 'rgba(0, 0, 0, 1)'
                            }
                        },
                        cutoutPercentage: 60,
                        animation: {
                            duration: 2000,
                            easing: 'easeInOutQuart'
                        }
                                        
                    }
                });
            }
        });
    });
</script>

<style>
    .donut-chart{
        /* border: solid 2px; */
        width: 45%;
        border-bottom: solid 4px red;
        border-top: solid 10px red;
        display: flex;
        justify-content: center;
    }
</style>

@stop