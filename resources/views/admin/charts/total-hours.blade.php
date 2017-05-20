@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    @include('templates.admin.side-navigation')

    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">RMSC Admin - Total Hours</div>
            <div class="panel-body">

                <style>
                    #totalHours {
                        height: 750px;
                    }
                </style>

                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <div id="totalHours"></div>

            </div>





        </div>
    </div>


    <script>
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawBasic);

        function drawBasic() {

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Date');
            data.addColumn('number', 'Total Hours');

            data.addRows([

                @foreach ($totalHours as $day)
                    [
                        new Date({{ substr($day->day, 0, 4) }}, {{ substr($day->day, 5, 2) - 1 }}, {{substr($day->day, 8, 2) }}),
                        {{ $day->hours }}
                    ],
                @endforeach

            ]);

            var options = {
                title: 'Total Volunteer Hours',
                width: 1550,
                bar: { groupWidth: "90%" },
                hAxis: {
                    title: 'Date'
                },
                vAxis: {
                    title: 'Total Hours',
                    minValue: 0
                }
            };

            var chart = new google.visualization.ColumnChart(
                document.getElementById('totalHours'));

            chart.draw(data, options);
        }
    </script>

@endsection