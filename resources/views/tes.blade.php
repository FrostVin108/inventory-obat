{{-- <p>My cat is <strong>very grumpy.</p></strong>
<br>

<h1>Welcome to example.com!</h1>
<div id="placeholder">
  <p>Learn more about <a href="#/products">our products</a> and <a href="#/services">our services</p>
</div>
<script>
    function goToPage(event) {
      event.preventDefault(); // stop the browser from navigating to the destination URL.
      const hrefUrl = event.target.getAttribute('href');
      const pageToLoad = hrefUrl.slice(1); // remove the leading slash
      document.getElementById('placeholder').innerHTML = load(pageToLoad);
      window.history.pushState({}, window.title, hrefUrl) // Update URL as well as browser history.
    }
    
    // Enable client-side routing for all links on the page
    document.querySelectorAll('a').forEach(link => link.addEventListener('click', goToPage));
    
    </script>

    <kbd    ></kbd> --}}


{{-- <button id="showDialog">Show Modal</button>

<dialog id="myModal">
  <p>This is a modal dialog. Enjoy!</p>
  <button id="closeDialog">Close</button>
</dialog>

<script>
  const showDialogButton = document.getElementById('showDialog');
  const myModal = document.getElementById('myModal');
  const closeDialogButton = document.getElementById('closeDialog');
  
  showDialogButton.addEventListener('click', () => {
    myModal.showModal();
  });
  
  closeDialogButton.addEventListener('click', () => {
    myModal.close();
  });
</script> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAILY BUNDLE IN REPORT</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <style type="text/css">
        @page {
            margin: 1cm 0.4cm;
        }

        .table-bundle-in-report td,
        .table-bundle-in-report th {
            padding: 0.25rem;
            vertical-align: middle;
        }

        .title-bundle-in-report {
            clear: left;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        .subtitle-bundle-in-report {
            font-size: 12px;
        }

        .header-main {
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .company-name {
            float: left;
            text-align: left;
            font-size: 12px;
        }

        .created-by-and-date {
            float: right;
            text-align: right;
            font-size: 10px;
        }

        .table-bundle-in-report {
            clear: left;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .serial-number-qr {
            float: right;
            text-align: right;
            font-size: 12px;
        }

        .table-bundle-in-report {
            border: 2px solid black;
        }

        .table-bundle-in-report thead th {
            border: solid black;
            border-width: 1px;
            vertical-align: middle;
            text-align: center;
            font-size: 8pt;
            padding: 0;
        }

        .table-bundle-in-report tbody td {
            border: 1px solid black;
            vertical-align: middle;
            text-align: center;
            font-weight: bold;
            font-size: 8pt;
            padding: 2px 0.3px;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="">
        <div class="header-main">
            <div class="company-name">
                PT. GHIMLI INDONESIA
            </div>
            <div class="created-by-and-date">
                Print By : | Date :
            </div>
            <div class="title-bundle-in-report">
                DAILY BUNDLE IN REPORT
                <br>
                <div class="subtitle-bundle-in-report">date_filter</div>
            </div>

        </div>

        <div>
            <table class="table table-bundle-in-report">
                <thead>
                    <tr>
                        <th width="7%">GL Number</th>
                        <th>Style</th>
                        <th>Color</th>
                        <th width="4%">Lot</th>
                        <th width="10%">Total Bundle</th>
                        <th width="13%">Total Bundle In per day</th>
                        <th width="15%">Accumulation Bundle In</th>
                        <th width="6%">Completed</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>

                        <td>laying_planning->gl_number</td>


                        <td>laying_planning->style</td>


                        <td style="text-align: left; padding-left: 4 !important;">laying_planning->color </td>

                        <td>'table_number'</td>
                        <td>'total_bundle'</td>
                        <td>'total_bundle_in_per_day'</td>
                        <td>'total_bundle_in'</td>
                        <td>'total_percentage'</td>
                    </tr>

                    <tr class="table-secondary" style="border:2px solid black;">
                        <td colspan="4">Total</td>
                        <td>totalAllBundle </td>
                        <td>totalAllBundleInPerDay </td>
                        <td>totalAllBundleIn </td>
                        <td>percentageTotalAllBundleIn </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
