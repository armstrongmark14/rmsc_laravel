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
                <table id="volunteer-table" class="table table-bordered table-striped">
                    <tr>
                        <th>Badge</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Email</th>
                    </tr>

                    @foreach($oldVols as $vol)
                        <tr class="vol-row">
                            <td>{{ $vol->badge }}</td>
                            <td><a href="/admin/old-system/volunteer/{{ $vol->id }}">{{ $vol->first_name . ' ' . $vol->last_name }}</a></td>
                            <td>{{ $vol->department }}</td>
                            <td>{{ $vol->email }}</td>
                        </tr>
                    @endforeach


                </table>

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