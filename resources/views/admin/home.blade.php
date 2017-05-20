@extends('layouts.volunteer-page')

@section('content')

    @include('templates.admin.side-navigation')

    @include('templates.errors.error-messages')

    <style>
        .admin-homepage-panel span, .admin-homepage-panel i {
            font-size: 40px;
            font-weight: bold;
            font-color: #666;
        }

        .admin-homepage-panel {
            text-align: center;
        }

    </style>

    <div class="col-md-4">
        <div class="col-md-6">
            <div class="admin-homepage-panel panel panel-default">
                <div class="panel-heading">Volunteers Today</div>
                <div class="panel-body">
                    <i class="fa fa-user admin-home-icon"></i>&nbsp;&nbsp;
                    <span><span id="current-count"></span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="admin-homepage-panel panel panel-default">
                <div class="panel-heading">Hours Today</div>
                <div class="panel-body">
                    <i class="fa fa-clock-o admin-home-icon"></i>&nbsp;&nbsp;
                    <span id="todays-hours"></span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="admin-homepage-panel panel panel-default">
                <div class="panel-heading">Total Logins</div>
                <div class="panel-body">
                    <i class="fa fa-users admin-home-icon"></i>&nbsp;&nbsp;
                    <span id="total-logins"></span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="admin-homepage-panel panel panel-default">
                <div class="panel-heading">Total Hours</div>
                <div class="panel-body">
                    <i class="fa fa-history admin-home-icon"></i>&nbsp;&nbsp;
                    <span id="total-hours"></span>
                </div>
            </div>
        </div>


    </div>

    <div class="col-md-6">
        <div class="admin-homepage-panel panel panel-default">
            <div class="panel-heading">Last 7 Days</div>
            <div class="panel-body">
                <div id="week-hours"></div>
            </div>
        </div>
    </div>




    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <script>
        function blankAJAXRequest(elementId, location) {
            // getting the element we'll fill
            var target = document.getElementById(elementId);
            var location = 'http://localhost/laravel/rmsc/public/admin/homepage/' + elementId;

            // Making the request
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    target.innerHTML = request.responseText;
//                    alert(request.responseText);
                }
            }

            request.open('GET', location, true);
            request.send();
        }





        function getCurrentCount() {
            blankAJAXRequest('current-count');
        }

        function getTodaysHours() {
            blankAJAXRequest('todays-hours');
        }

        function getTotalLogins() {
            blankAJAXRequest('total-logins');
        }

        function getTotalHours() {
            blankAJAXRequest('total-hours');
        }

        // Calling them all when page loads
        getCurrentCount();
        getTodaysHours();
        getTotalLogins();
        getTotalHours();

        // Calling these ones to update faster than the grand totals
        setInterval(function() {
            getCurrentCount();
            getTodaysHours();

        }, 15000); // Should update every 15 seconds

        // These grand totals will update much slower than the smaller queries
        setInterval(function() {
            getTotalHours();
            getTotalLogins();
        }, 180000); // Should update every 3 minutes




        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawBasic);

        function drawBasic() {

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Date');
            data.addColumn('number', 'Total Hours');

            data.addRows([

                    @foreach ($weekHours as $day)
                [
                    new Date({{ substr($day->day, 0, 4) }}, {{ substr($day->day, 5, 2) - 1 }}, {{substr($day->day, 8, 2) }}),
                    {{ $day->hours }}
                ],
                @endforeach

            ]);

            var options = {
                height: 234,
                vAxis: {
                    title: 'Hours',
                    minValue: 0
                },
                hAxis: {
                    gridlines: { color: "transparent" }
                },
                legend: { position: "none" }
            };

            var chart = new google.visualization.ColumnChart(
                document.getElementById('week-hours'));

            chart.draw(data, options);
        }
    </script>

@endsection