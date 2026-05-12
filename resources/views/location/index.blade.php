@extends('layouts.app')

@section('content')

@php

$locations = [
    (object)[
        'id' => 1,
        'device' => 'Samsung Galaxy S23',
        'user' => 'John Doe',
        'lat' => '3.1390',
        'lng' => '101.6869',
        'address' => 'Kuala Lumpur City Centre, KL',
        'accuracy' => '5m',
        'recorded_at' => '2026-05-06 09:15 AM'
    ],
    (object)[
        'id' => 2,
        'device' => 'iPhone 15 Pro',
        'user' => 'Jane Smith',
        'lat' => '1.5533',
        'lng' => '110.3592',
        'address' => 'Kuching Waterfront, Sarawak',
        'accuracy' => '3m',
        'recorded_at' => '2026-05-06 09:45 AM'
    ],
    (object)[
        'id' => 3,
        'device' => 'Xiaomi 14',
        'user' => 'Ali Hassan',
        'lat' => '3.0738',
        'lng' => '101.5183',
        'address' => 'Subang Jaya, Selangor',
        'accuracy' => '8m',
        'recorded_at' => '2026-05-06 10:00 AM'
    ],
    (object)[
        'id' => 4,
        'device' => 'OnePlus 12',
        'user' => 'Siti Rahimah',
        'lat' => '5.4141',
        'lng' => '100.3288',
        'address' => 'Georgetown, Penang',
        'accuracy' => '6m',
        'recorded_at' => '2026-05-06 10:30 AM'
    ],
];

$stats = [
    (object)['label' => 'Total Devices Tracked', 'value' => '24', 'icon' => 'fa-mobile-screen', 'color' => 'primary'],
    (object)['label' => 'Active Now',             'value' => '8',  'icon' => 'fa-location-dot',  'color' => 'success'],
    (object)['label' => 'Last Hour Updates',      'value' => '61', 'icon' => 'fa-clock',          'color' => 'info'],
    (object)['label' => 'Offline Devices',        'value' => '3',  'icon' => 'fa-circle-xmark',   'color' => 'danger'],
];

@endphp

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Location /</span> Tracker
    </h4>

    {{-- Stat Cards --}}
    <div class="row mb-4">
        @foreach($stats as $stat)
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fa-solid {{ $stat->icon }} fa-2x text-{{ $stat->color }} mb-2"></i>
                    <h3 class="mb-0">{{ $stat->value }}</h3>
                    <small class="text-muted">{{ $stat->label }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Map Placeholder + Last Known --}}
    <div class="row mb-4">
        <div class="col-md-8 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa-solid fa-map me-2"></i>Live Map View</h5>
                </div>
                <div class="card-body p-0">
                    {{-- Replace with real map (Leaflet.js / Google Maps) --}}
                    <div style="background:#e9ecef; height:320px; display:flex; align-items:center; justify-content:center; border-radius:0 0 8px 8px;">
                        <div class="text-center text-muted">
                            <i class="fa-solid fa-map-location-dot fa-4x mb-3"></i>
                            <p class="mb-0">Map renders here (Leaflet.js / Google Maps)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa-solid fa-list me-2"></i>Active Devices</h5>
                </div>
                <div class="card-body p-2">
                    @foreach($locations as $loc)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <span class="badge bg-{{ $loop->index < 2 ? 'success' : 'secondary' }} rounded-pill p-2">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size:0.85rem;">{{ $loc->device }}</div>
                            <small class="text-muted">{{ $loc->address }}</small><br>
                            <small class="text-muted">{{ $loc->recorded_at }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Location History Table --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Location History</h5>
            <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-download me-1"></i> Export</button>
        </div>
        <div class="card-datatable text-nowrap">
            <table class="table table-bordered" id="mytable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Device</th>
                        <th>User</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Address</th>
                        <th>Accuracy</th>
                        <th>Recorded At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($locations as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->device }}</td>
                        <td>{{ $row->user }}</td>
                        <td>{{ $row->lat }}</td>
                        <td>{{ $row->lng }}</td>
                        <td>{{ $row->address }}</td>
                        <td><span class="badge bg-info">{{ $row->accuracy }}</span></td>
                        <td>{{ $row->recorded_at }}</td>
                        <td>
                            <a href="#" class="me-2"><i class="fa-solid fa-map-pin"></i></a>
                            <a href="#" style="color:red;"><i class="fa-solid fa-trash"></i></a>
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