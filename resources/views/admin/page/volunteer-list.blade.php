@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    @include('templates.admin.side-navigation')

    <div class="col-md-10">
        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="col-md-4 col-md-offset-4">
                    <input id="volunteer-search" class="form form-control" type="text" placeholder="Search...">
                </div>
                <br><br>
            </div>



            <div class="panel-body">
                @include('templates.admin.volunteer-table')
            </div>
        </div>
    </div>

    <script type="text/javascript">





        // The function for searching the vollunteer list and narrowing it down
        $(document).ready(function() {
            // Write on keyup event of keyword input element
            $("#volunteer-search").keyup(function(){
                search = this;
                // Show only matching TR, hide rest of them
                $.each($("#volunteer-table .vol-row"), function() {
                    if($(this).text().toLowerCase().indexOf($(search).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });

        });
    </script>

@endsection