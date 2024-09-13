@extends('layouts.app')

@section('content_header')
    <h1>Dashboard</h1> 
@stop

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<div class="container-fluid">
    <div class="row">

            <div class="col-lg-3 " >
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$total}}</h3>
            
                        <p>Total All Stock</p>
                    </div>
                    <div class="icon">
                      <i class="fas fa-warehouse"></i>
                    </div>
                    <a href="iteminv" class="small-box-footer" style="height: 35px">All Items <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div> 

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{$totalin}}</h3>
    
                    <p>Total Stock In</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-arrow-circle-down"></i>
                  </div>
                  <a href="{{ route('ob.stockin') }}" class="small-box-footer" style="height: 35px">Stock In <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{$totalout}}</h3>
    
                    <p>Total Stock Out</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-arrow-circle-up"></i>
                  </div>
                  <a href="{{ route('ob.stockout') }}" class="small-box-footer" style="height: 35px">Stock Out <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>  

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{$balance}}</h3>
    
                    <p>Balance</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-clipboard-list"></i>
                  </div>  
                  <a href="{{ route('report.monthly', ['month' => date('m')]) }}" class="small-box-footer" style="height: 35px">Transaction Report {{ date('F') }} <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
    </div>
</div>
{{-- <div>
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
</div> --}}

<div class="column d-flex" style="gap: 13px">

    <div class="card" style="width: 60%; height: 100%">
            <div class="row-md-7">
                <p class="text-center">
                  <strong> Report Period: {{ date('M 1, Y') }} - {{ date('M t, Y') }}</strong>
                </p>
    
                <div class="chart">
                  <!-- Sales Chart Canvas -->
                  <canvas id="stockChart" height="180" style="padding: 13px"></canvas>
                </div>
                
            </div>
        
    </div>
    
    <div class="card" style="width: 40%; height: 100%">
        <div class="row-md-7">
            <canvas id="chart" width="70%" height="63.9%" ></canvas>

        </div>
    </div>
    
</div>




<div class="card shadow p-3 mb-5 bg-white rounded" style="width: 50%; height: 100%">
        <h4><i class="fas "></i> Today's Market Summary</h4>

        <br>
                
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Item</th>
                        <th scope="col">Department</th>
                        <th scope="col">Transaction Type</th>
                        <th scope="col">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($todaytransactions as $key => $trans)
                
                <tr>
                    <td>{{ $key +1 }}</td>
                    <td>{{ $trans->item->description }}</td>
                    <td>{{ $trans->order->department }}</td>
                    <td>{{ $trans->transaction_type	}}</td>
                    <td>{{ $trans->qty }}</td>
                </tr>
                
                </tbody>

                @empty
            <div class="alert alert-danger">
               Tidak Ada data Terisi.
            </div>
            @endforelse 
            </table>
        </div>

</div>
                

    </div>
</div>
<script>
    console.log('Chart data:', {!! json_encode($labels) !!}, {!! json_encode($inQuantities) !!}, {!! json_encode($outQuantities) !!});
  
    const ctx = document.getElementById('stockChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: ' Total IN',
                data: {!! json_encode($inQuantities) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Total OUT',
                data: {!! json_encode($outQuantities) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                    
                }
            }
        }
    });
  </script>

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
                                'rgba(0, 0, 128, 0.9)',
                                'rgba(0, 0, 255, 0.9)',
                                'rgba(0, 128, 0, 0.9)',
                                'rgba(255, 99, 132, 0.9)',
                                'rgba(0, 139, 139, 0.9)',
                                'rgba(0, 191, 255, 0.9)',
                                'rgba(0, 250, 154, 0.9)',
                                'rgba(0, 255, 0, 0.9)',
                                'rgba(0, 255, 255, 0.9)',
                                'rgba(0, 255, 255, 0.9)',
                                'rgba(105, 105, 105, 0.9)',
                                'rgba(127, 255, 0, 0.9)',
                                'rgba(128, 0, 128, 0.9)',
                                'rgba(128, 128, 0, 0.9)',
                                'rgba(139, 0, 139, 0.9)',
                                'rgba(139, 69, 19, 0.9)',
                                'rgba(139, 69, 19, 0.9)',
                                'rgba(153, 50, 204, 0.9)',
                                'rgba(186, 85, 211, 0.9)',
                                'rgba(186, 85, 211, 0.9)',
                                'rgba(186, 85, 211, 0.9)',
                                'rgba(210, 105, 30, 0.9)',
                                'rgba(210, 180, 140, 0.9)',
                                'rgba(218, 165, 32, 0.9)',
                                'rgba(220, 20, 60, 0.9)',
                                'rgba(240, 248, 255, 0.9)',
                                'rgba(244, 164, 96, 0.9)',
                                'rgba(255, 0, 0, 0.9)',
                                'rgba(255, 0, 255, 0.9)',
                                'rgba(255, 105, 180, 0.9)',
                                'rgba(255, 105, 180, 0.9)',
                                'rgba(255, 140, 0, 0.9)',
                                'rgba(255, 165, 0, 0.9)',
                                'rgba(255, 192, 203, 0.9)',
                                'rgba(255, 20, 147, 0.9)',
                                'rgba(255, 20, 147, 0.9)',
                                'rgba(255, 228, 225, 0.9)',
                                'rgba(255, 228, 225, 0.9)',
                                'rgba(255, 240, 245, 0.9)',
                                'rgba(255, 69, 0, 0.9)',
                                'rgba(255, 69, 0, 0.9)',
                                'rgba(255, 69, 0, 0.9)',
                                'rgba(30, 144, 255, 0.9)',
                                'rgba(32, 178, 170, 0.9)',
                                'rgba(70, 130, 180, 0.9)',
                                'rgba(72, 61, 139, 0.9)',



                            ],
                            borderColor: [
                                'rgba(0, 0, 128, 0.7)',
                                'rgba(0, 0, 255, 0.7)',
                                'rgba(0, 128, 0, 0.7)',
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(0, 139, 139, 0.7)',
                                'rgba(0, 191, 255, 0.7)',
                                'rgba(0, 250, 154, 0.7)',
                                'rgba(0, 255, 0, 0.7)',
                                'rgba(0, 255, 255, 0.7)',
                                'rgba(0, 255, 255, 0.7)',
                                'rgba(105, 105, 105, 0.7)',
                                'rgba(127, 255, 0, 0.7)',
                                'rgba(128, 0, 128, 0.7)',
                                'rgba(128, 128, 0, 0.7)',
                                'rgba(139, 0, 139, 0.7)',
                                'rgba(139, 69, 19, 0.7)',
                                'rgba(139, 69, 19, 0.7)',
                                'rgba(153, 50, 204, 0.7)',
                                'rgba(186, 85, 211, 0.7)',
                                'rgba(186, 85, 211, 0.7)',
                                'rgba(186, 85, 211, 0.7)',
                                'rgba(210, 105, 30, 0.7)',
                                'rgba(210, 180, 140, 0.7)',
                                'rgba(218, 165, 32, 0.7)',
                                'rgba(220, 20, 60, 0.7)',
                                'rgba(240, 248, 255, 0.7)',
                                'rgba(244, 164, 96, 0.7)',
                                'rgba(255, 0, 0, 0.7)',
                                'rgba(255, 0, 255, 0.7)',
                                'rgba(255, 105, 180, 0.7)',
                                'rgba(255, 105, 180, 0.7)',
                                'rgba(255, 140, 0, 0.7)',
                                'rgba(255, 165, 0, 0.7)',
                                'rgba(255, 192, 203, 0.7)',
                                'rgba(255, 20, 147, 0.7)',
                                'rgba(255, 20, 147, 0.7)',
                                'rgba(255, 228, 225, 0.7)',
                                'rgba(255, 228, 225, 0.7)',
                                'rgba(255, 240, 245, 0.7)',
                                'rgba(255, 69, 0, 0.7)',
                                'rgba(255, 69, 0, 0.7)',
                                'rgba(255, 69, 0, 0.7)',
                                'rgba(30, 144, 255, 0.7)',
                                'rgba(32, 178, 170, 0.7)',
                                'rgba(70, 130, 180, 0.7)',
                                'rgba(72, 61, 139, 0.7)',


                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Medicine Inventory and Stock Details',
                            fontsize: 100
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
        justify-content: space-around;
    }

    .side-by-side > .column{
        align-self: center;
    }

</style>

@stop