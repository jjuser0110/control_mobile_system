```php
@extends('layouts.app')

@section('content')

@php

$sessions = [
    (object)[
        'id' => 1,
        'session_code' => 'RXA-2231',
        'host' => 'Office-PC',
        'client' => 'MacBook',
        'duration' => '15 mins',
        'status' => 'Ended',
        'started_at' => '2026-05-06 09:00 AM'
    ],
    (object)[
        'id' => 2,
        'session_code' => 'ABE-9981',
        'host' => 'Gaming-PC',
        'client' => 'Android Phone',
        'duration' => 'Active',
        'status' => 'Active',
        'started_at' => '2026-05-06 10:10 AM'
    ],
];

@endphp

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Remote Sessions /</span> List
    </h4>

    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">Remote Session List</h5>
        </div>

        <div class="card-datatable text-nowrap">

            <table class="table table-bordered" id="mytable">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Session Code</th>
                        <th>Host Device</th>
                        <th>Client Device</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Started At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($sessions as $row)

                    <tr>

                        <td>{{ $row->id }}</td>
                        <td>{{ $row->session_code }}</td>
                        <td>{{ $row->host }}</td>
                        <td>{{ $row->client }}</td>
                        <td>{{ $row->duration }}</td>

                        <td>
                            @if($row->status == 'Active')
                                <span style="color:green;">Active</span>
                            @else
                                <span style="color:red;">Ended</span>
                            @endif
                        </td>

                        <td>{{ $row->started_at }}</td>

                        <td>

                            <a href="#">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="#" style="color:red;">
                                <i class="fa-solid fa-trash"></i>
                            </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script>

$(function () {

    $('#mytable').DataTable({
        pageLength: 10,
        ordering: false,
        lengthMenu: [5, 10, 25, 50, 100],
        dom: '<"row"<"col-md-6"l><"col-md-6"f>>t<"row"<"col-md-6"i><"col-md-6"p>>'
    });

});

</script>

@endsection