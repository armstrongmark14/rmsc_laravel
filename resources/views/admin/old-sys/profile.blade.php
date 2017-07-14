@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    @include('templates.admin.side-navigation')

    <div class="col-md-10">
        <div class="panel panel-default">

            <div class="panel-heading">
                <b>Profile for:</b> {{ $vol->first_name . ' ' . $vol->last_name }}

                <span class="align-right">
                    <a href="/admin/old-system">
                        <button class="btn btn-success">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            Old System List
                        </button>
                    </a>
                </span>
            </div>

            <div class="panel-body">
                <table id="volunteer-table" class="table table-bordered table-striped">

                    @foreach($attributes as $attr => $value)
                        <tr>
                            <th>{{ $attr }}</th>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach

                </table>

            </div>
        </div>
    </div>

@endsection