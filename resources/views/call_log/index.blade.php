@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Call Logs /</span> List
    </h4>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Call Logs List</h5>
        </div>

        <div class="card-datatable text-nowrap">
            <table class="table table-bordered" id="mytable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Contact Name</th>
                        <th>contact Number</th>
                        <th>Duration (seconds)</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($call_log as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->phoneNumber }}</td>
                            <td>{{ $row->duration }}</td>
                            <td>{{ $row->timestamp }}</td>

                            {{-- Actions --}}
                            <td>
                                {{-- VIEW --}}
                                <a href="{{ route('user.view', $row->id) }}" onclick="showLoading()">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                {{-- DELETE --}}
                                <a style="color:red"
                                   href="{{ route('call_log.destroy', $row->id) }}"
                                   onclick="return confirm('Delete this call log?')">
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