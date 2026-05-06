@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Devices /</span> List
    </h4>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Device List</h5>
        </div>

        <div class="card-datatable text-nowrap">
            <table class="table table-bordered" id="mytable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Device Name</th>
                        <th>Device ID</th>
                        <th>Platform</th>
                        <th>IP Address</th>
                        <th>Status</th>
                        <th>Last Seen</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($devices as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->device_name }}</td>
                        <td>{{ $row->device_id }}</td>
                        <td>{{ $row->platform }}</td>
                        <td>{{ $row->ip_address }}</td>

                        <td>
                            @if($row->status == 'Online')
                                <span style="color:green;font-weight:600;">Online</span>
                            @else
                                <span style="color:red;font-weight:600;">Offline</span>
                            @endif
                        </td>

                        <td>{{ $row->last_seen ?? '-' }}</td>

                        <td>
                            <a href="{{ route('device.app', $row->id) }}" onclick="showLoading()">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                            </a>
                            <a href="{{ route('device.destroy', $row->id) }}"
                               style="color:red;"
                               onclick="return confirm('Delete this device?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3">No devices found</td>
                        </tr>
                    @endforelse
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