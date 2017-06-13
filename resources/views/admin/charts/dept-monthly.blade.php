@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    @include('templates.admin.side-navigation')

    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">RMSC Admin - Total Hours for: <b>{{ $totalHours[0]->department }}</b></div>
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
            data.addColumn('date', 'Month');
            data.addColumn('number', 'Total Hours');

            data.addRows([

                    @foreach ($totalHours as $month)
                [
                    new Date({{ $month->year }}, {{ $month->month }}),
                    {{ $month->hours }}
                ],
                @endforeach

            ]);

            var options = {
                title: '{{ "Total volunteer hours for: " . $totalHours[0]->department }}',
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