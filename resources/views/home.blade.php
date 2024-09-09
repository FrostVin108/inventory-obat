@extends('layouts.app')

@section('content_header')
    <h1>Dashboard</h1> 
@stop

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<div class="card shadow p-3 mb-5 bg-white rounded">
    <div class="card-body">
        <div class="side-by-side">
            {{-- row1 --}}
            {{-- border: solid 2px yellow; --}}
                <div class="column" style="height: 340px;  width: 300px;">
                    
                    <a class=" info-box bg-info" href="iteminv">
                        <span class="info-box-icon "><i class="fas fa-warehouse"></i></span>
                        <div class="info-box-content ">
                            <span class="info-box-tex text-left">Item Obat</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="text-left info-box-number ">Total: {{$total}}</span>
                        </div>
                    </a> 
                    <a class=" info-box bg-info" href="{{ route('ob.stockout') }}">
                        <span class="info-box-icon "><i class="fas fa-arrow-circle-up"></i></span>
                        <div class="info-box-content ">
                            <span class="info-box-tex text-left">Stock Out</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="text-left info-box-number ">Total: {{$totalout}}</span>
                        </div>
                    </a>                       
                    <a class="info-box bg-info" href="{{ route('ob.stockin') }}">
                        <span class="info-box-icon "><i class="fas fa-arrow-circle-down"></i></span>
                        <div class="info-box-content ">
                            <span class="info-box-tex text-left">Stock In</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="text-left info-box-number ">Total: {{$totalin}}</span>
                        </div>
                    </a>
                </div>  
            
            {{-- row2 --}}
                <div class="row">
                    <div class="donut-chart">
                        <div id="chart-container" style="width: 1000px; height: 80%;">
                            <canvas id="chart" width="80%" height="80%" ></canvas>
                        </div>
                    </div>
                </div>
        </div>
        <br>
        <br>
                {{-- row3 --}}
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
                            text: 'Quantity Semua Obat yang ada',
                            fontsize: 40
                         },
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                fontColor: 'rgba(0, 0, 0, 10)'
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
        width: 450px;
        border-bottom: solid 4px red;
        border-top: solid 10px red;
        display: flex;
        justify-content: center;
        /* margin-left: 30vw; */
    }

    .side-by-side{
        display: flex;
        justify-content: space-between;

    }

</style>

@stop