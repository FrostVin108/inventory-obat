@extends('layouts.app')

@section('content_header')
    <h1 style="font-size: 27px"><i class="fas fa-file-alt"></i> Report</h1>
@stop

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- CDNJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- jsDelivr -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <div class="card">
        <div id="ghostframe" style="width:105px; height:105px; fontsize:30px;">
            <button id="back-to-top" title="Back to Top" style="width:55px; height:55px; fontsize:30px;">
                <i class="fas fa-arrow-up"></i>
            </button>
        </div>

        <a href="{{ route('export.excel.report') }}"><button id="generate-excel-btn" title="Convert to Excel" style="width:55px; height:55px; fontsize:30px;"  ><i
            class="fas fa-file-excel"></i></button></a> 

        <button id="combine-btn" title="Combine The Same Data" style="width:55px; height:55px; fontsize:30px;"><i
                class="fas fa-object-group"></i></button>


        <button id="uncombine-btn" title="Uncombine The Same Data"
            style="width:55px; height:55px; fontsize:30px; display: none;"><i class="fas fa-object-ungroup"></i></button>

            
        <button id="generate-pdf-btn" title="Convert pdf" 
            style="width:55px; height:55px; fontsize:30px;"><i class="far fa-file-pdf"></i></button>

        <div class="card-body" style="padding: 47px;">
            <div class="d-flex input-group">
                <div class="col-md-6 search-post">
                    <input type="text" name="search" id="search-input" placeholder="Search..."class="form-control input-search" style="width: 44%">
                    <button id="search-btn" class="btn btn-success"><i class="fas fa-search"></i> Search</button>
                    <button id="clear-btn" class="btn btn-warning"> <i class="	fas fa-undo"></i></button>
                    

                    {{-- <button id="combine-btn" class="btn btn-info">Combine</button> --}}
                    {{-- <button id="uncombine-btn" class="btn btn-danger">Uncombine</button> --}}
                </div>


                <script>
                    $(document).ready(function() {
                        $('#generate-pdf-btn').on('click', function() {
                            var month = '<?php echo session('month') ?>';
                            window.location.href = '{{ route('user.report.print', ':month') }}'.replace(':month', month);
                        });
                    });
                </script>

                

                <div class="col-md-6 input-group" style="gap: 5px;">
                    <select id="month" class="form-control-border ml-auto">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ session('month') == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                        @endfor
                    </select>
                    <button class="btn btn-primary btn-sm" id="change-month"><i class="fas fa-sync"></i> Change</button>
                </div>
            </div>
            <br>
            <br>


            <div id="search-results">
                @forelse ($data as $order)
                    <div class="department-container">
                        <h2>Department: {{ $order['department'] }}</h2>

                        <canvas id="department-chart-{{ $order['department'] }}"
                            style="width: 100%; height: 400px;"></canvas>
                        <br>
                        <br>

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Item Description</th>
                                    <th>Transaction Type</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentMonthTransactions = [];
                                    foreach ($order['out_transactions'] as $transaction) {
                                        if (date('m', strtotime($transaction['created_at'])) == session('month')) {
                                            $currentMonthTransactions[] = $transaction;
                                        }
                                    }
                                @endphp
                                @foreach ($currentMonthTransactions as $key => $transaction)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $transaction['item_description'] }}</td>
                                        <td>{{ $transaction['transaction_type'] }}</td>
                                        <td>{{ $transaction['qty'] }}</td>
                                        <td>{{ date('Y-m-d H:i:s', strtotime($transaction['created_at'])) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @php
                            $itemDescriptions = [];
                            foreach ($order['out_transactions'] as $transaction) {
                                $itemDescriptions[$transaction['item_description']][] = $transaction['qty'];
                            }
                        @endphp

<script>
    var ctx = document.getElementById('department-chart-{{ $order['department'] }}').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach ($itemDescriptions as $item => $quantities)
                    '{{ $item }}',
                @endforeach
            ],
            datasets: [{
                label: '{{ date('F', mktime(0, 0, 0, session('month'), 1)) }}', // Current month
                data: [
                    @foreach ($itemDescriptions as $item => $quantities)
                        @php
                            $currentMonthQty = 0;
                            foreach ($order['out_transactions'] as $transaction) {
                                if (date('m', strtotime($transaction['created_at'])) == session('month') && $transaction['transaction_type'] == 'OUT' && $transaction['item_description'] == $item) {
                                    $currentMonthQty += $transaction['qty'];
                                }
                            }
                        @endphp
                        {{ $currentMonthQty }},
                    @endforeach
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: '{{ date('F', mktime(0, 0, 0, session('month') - 1, 1)) }}', // Previous month
                data: [
                    @php
                        $previousMonth = session('month') - 1;
                        if ($previousMonth == 0) {
                            $previousMonth = 12;
                        }
                    @endphp
                    @foreach ($itemDescriptions as $item => $quantities)
                        @php
                            $previousMonthQty = 0;
                            foreach ($order['out_transactions'] as $transaction) {
                                if (date('m', strtotime($transaction['created_at'])) == $previousMonth && $transaction['transaction_type'] == 'OUT' && $transaction['item_description'] == $item) {
                                    $previousMonthQty += $transaction['qty'];
                                }
                            }
                        @endphp
                        {{ $previousMonthQty }},
                    @endforeach
                ],
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
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
                    </div>
                    <br>
                    @empty
                    <p class="bg-danger" style="font-size: 18px; padding: 15px 20px; border-radius:5px;">Sorry, But on {{ date('F', mktime(0, 0, 0, session('month'), 1)) }} Doesn't Have Any Transaction Log Found</p>

                @endforelse
            </div>
        </div>
    </div>

    <style>
        .search-post {
            display: flex;
            flex-direction: row;
            gap: 3px;
        }

        #ghostframe{
            position: fixed;
            bottom: 20px;
            right: 20px;
            /* border: solid 2px; */
        }

        #back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #back-to-top:hover {
            background-color: #555;
        }

        #combine-btn {
            position: fixed;
            bottom: 85px;
            right: 20px;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            background-color: rgb(34, 178, 65);
            color: white;
        }

        #combine-btn:hover {
            background-color: rgb(63, 216, 43);
        }

        #uncombine-btn {
            position: fixed;
            bottom: 85px;
            right: 20px;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            background-color: rgb(178, 34, 34);
            color: white;
        }

        #uncombine-btn:hover {
            background-color: rgb(216, 43, 43);
        }

        #generate-pdf-btn{
            position: fixed;
            bottom: 20px;
            right: 85px;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            background-color: rgb(178, 152, 34);
            color: white;
        }

        #generate-pdf-btn:hover{
            background-color: rgb(216, 152, 43);
        }

        #generate-excel-btn{
            position: fixed;
            bottom: 80px;
            right: 80px;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            background-color: rgb(34, 178, 36);
            color: white;
        }

        #generate-excel-btn:hover{
            background-color: rgb(34, 152, 43);
        }
    </style>

<script>
    $(document).ready(function() {
        $('#search-btn').on('click', function() {
            var searchTerm = $('#search-input').val().toLowerCase();
            $('.department-container').each(function() {
                var found = false;
                $(this).find('table tbody tr').each(function() {
                    var dateCell = $(this).find('td:eq(4)').text(); // assuming the date column is the 5th column
                    var datePart = dateCell.split(' ')[0]; // extract the date part (e.g., "2022-01-01")
                    var department = $(this).closest('.department-container').find('h2').text(); // get the department name
                    var itemDesc = $(this).find('td:eq(1)').text(); // assuming the item description column is the 2nd column

                    if (datePart.toLowerCase().indexOf(searchTerm) !== -1 ||
                        department.toLowerCase().indexOf(searchTerm) !== -1 ||
                        itemDesc.toLowerCase().indexOf(searchTerm) !== -1) {
                        found = true;
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                if (found) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $("#search-input").focus();
        });

        $('#clear-btn').on('click', function() {
            $('#search-input').val('');
            $('.department-container').each(function() {
                $(this).show(); // show all department containers
                $(this).find('table tbody tr').show(); // show all table rows
                $(this).find('table').replaceWith($(this).data('original-table-data')); // restore original table data
            });
            $('#combine-btn').show(); // show combine button
            $('#uncombine-btn').hide(); // hide uncombine button
        });
    });
</script>

    <script>
        $(document).ready(function() {
            $('#change-month').on('click', function() {
                var month = $('#month').val();
                var url = '{{ route('report.user.in', ':month') }}'.replace(':month', month);
                window.location.href = url;
            });
        });

        $(document).ready(function() {
            $('#back-to-top').on('click', function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 'fast');
            });
        });

        $(document).ready(function() {
    // Hide the buttons when the page loads
    $('#combine-btn, #generate-pdf-btn, #generate-excel-btn').hide();

    var timeoutId;

    // Show the buttons when the "Back to Top" button is hovered
    $('#ghostframe').on('mouseover', function() {
        $('#combine-btn, #generate-pdf-btn, #generate-excel-btn').fadeIn ();
        clearTimeout(timeoutId);
    });

    // Hide the buttons when you move your mouse out of the ghostframe
    $('#ghostframe').on('mouseout', function() {
        timeoutId = setTimeout(function() {
            $('#combine-btn, #generate-pdf-btn, #generate-excel-btn').fadeOut();
        }, 1000);
    });

    // Keep the buttons visible when you hover over them
    $('#combine-btn, #generate-pdf-btn, #generate-excel-btn').on('mouseover', function() {
        clearTimeout(timeoutId);
    });

    // Hide the buttons when you move your mouse out of them
    $('#combine-btn, #generate-pdf-btn, #generate-excel-btn').on('mouseout', function() {
        timeoutId = setTimeout(function() {
            $('#combine-btn, #generate-pdf-btn, #generate-excel-btn').fadeOut();
        }, 1000);
    });
});
        

    </script>

    <script>
        $(document).ready(function() {
            $('#combine-btn').on('click', function() {
                // Get all the department containers
                var departmentContainers = $('.department-container');

                // Loop through each department container
                departmentContainers.each(function() {
                    var department = $(this).find('h2').text();
                    var items = {};

                    // Loop through each table row in the department
                    $(this).find('table tbody tr').each(function() {
                        var itemDesc = $(this).find('td:eq(1)').text();
                        var qty = parseInt($(this).find('td:eq(3)').text());

                        // Add the quantity to the item in the department
                        if (items[itemDesc]) {
                            items[itemDesc] += qty;
                        } else {
                            items[itemDesc] = qty;
                        }
                    });

                    // Create a new table to display the combined data
                    var combinedTable =
                        '<table class="table table-striped table-bordered table-hover">';
                    combinedTable +=
                        '<thead><tr><th>No</th><th>Item Description</th><th>Transaction Type</th><th>Quantity</th></tr></thead>';
                    combinedTable += '<tbody>';

                    // Loop through each item in the department and add a row to the table
                    $.each(items, function(item, qty) {
                        combinedTable += '<tr><td></td><td>' + item +
                            '</td><td>OUT</td><td>' + qty + '</td></tr>';
                    });

                    combinedTable += '</tbody></table>';

                    // Replace the original table with the combined table
                    $(this).find('table').replaceWith(combinedTable);
                });

                // Show the uncombine button and hide the combine button
                $('#uncombine-btn').show();
                $('#combine-btn').hide();
            });

            // Add a script to handle the uncombine button click
            $('#uncombine-btn').on('click', function() {
                // Get all the department containers
                var departmentContainers = $('.department-container');

                // Loop through each department container
                departmentContainers.each(function() {
                    // Get the original table data
                    var originalTableData = $(this).data('original-table-data');

                    // Replace the combined table with the original table
                    $(this).find('table').replaceWith(originalTableData);
                });

                // Hide the uncombine button and show the combine button
                $('#uncombine-btn').hide();
                $('#combine-btn').show();
            });

            // Store the original table data in a data attribute
            $('.department-container').each(function() {
                var originalTableData = $(this).find('table').clone();
                $(this).data('original-table-data', originalTableData);
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $('#convert-to-excel-btn').on('click', function() {
    var csvData = [];

    $('.department-container').each(function() {
        var departmentName = $(this).find('h2').text();
        csvData.push('"' + departmentName + '"'); // add department name as header

        var headers = [];
        $(this).find('table thead tr th').each(function() {
            headers.push($(this).text());
        });
        csvData.push(headers.join('\t')); // add headers with tabs

        csvData.push(''); // add a blank line

        $(this).find('table tbody tr').each(function() {
            var columns = [];
            $(this).find('td').each(function() {
                columns.push($(this).text());
            });
            csvData.push(columns.join('\t'));
        });

        csvData.push(''); // add a blank line between departments
    });

    var csvString = csvData.join('\n');
    var blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
    var link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'report.csv';
    link.click();
});
});
</script>
@endsection
