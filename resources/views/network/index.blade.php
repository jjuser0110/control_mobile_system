@extends('layouts.app')

@section('content')

@php

$networks = [
    (object)['id'=>1, 'device'=>'Samsung Galaxy S23', 'user'=>'John Doe',     'type'=>'WiFi',   'ssid'=>'HomeNet_5G',     'ip'=>'192.168.1.101', 'signal'=>92, 'data_up'=>'1.2 GB', 'data_down'=>'8.4 GB', 'status'=>'Connected',    'updated'=>'2026-05-06 10:05 AM'],
    (object)['id'=>2, 'device'=>'iPhone 15 Pro',       'user'=>'Jane Smith',   'type'=>'4G LTE', 'ssid'=>'—',              'ip'=>'10.20.30.51',   'signal'=>74, 'data_up'=>'320 MB', 'data_down'=>'2.1 GB', 'status'=>'Connected',    'updated'=>'2026-05-06 10:10 AM'],
    (object)['id'=>3, 'device'=>'Xiaomi 14',           'user'=>'Ali Hassan',   'type'=>'WiFi',   'ssid'=>'Office_Wifi',   'ip'=>'192.168.0.55',  'signal'=>45, 'data_up'=>'88 MB',  'data_down'=>'540 MB', 'status'=>'Weak Signal',  'updated'=>'2026-05-06 10:08 AM'],
    (object)['id'=>4, 'device'=>'OnePlus 12',          'user'=>'Siti Rahimah', 'type'=>'5G',     'ssid'=>'—',              'ip'=>'10.50.0.22',    'signal'=>88, 'data_up'=>'2.4 GB', 'data_down'=>'12.1 GB','status'=>'Connected',    'updated'=>'2026-05-06 10:01 AM'],
    (object)['id'=>5, 'device'=>'Realme GT 5',         'user'=>'Kumar Raj',    'type'=>'WiFi',   'ssid'=>'CafeWifi_Free', 'ip'=>'172.16.0.14',   'signal'=>30, 'data_up'=>'45 MB',  'data_down'=>'210 MB', 'status'=>'Disconnected', 'updated'=>'2026-05-06 09:55 AM'],
];

@endphp

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">System /</span> Network Monitor
    </h4>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center"><div class="card-body">
                <i class="fa-solid fa-wifi fa-2x text-success mb-2"></i>
                <h4 class="mb-0">3</h4><small class="text-muted">WiFi Connected</small>
            </div></div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center"><div class="card-body">
                <i class="fa-solid fa-signal fa-2x text-info mb-2"></i>
                <h4 class="mb-0">2</h4><small class="text-muted">Mobile Data (4G/5G)</small>
            </div></div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center"><div class="card-body">
                <i class="fa-solid fa-circle-xmark fa-2x text-danger mb-2"></i>
                <h4 class="mb-0">1</h4><small class="text-muted">Disconnected</small>
            </div></div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center"><div class="card-body">
                <i class="fa-solid fa-arrow-down fa-2x text-primary mb-2"></i>
                <h4 class="mb-0">23.3 GB</h4><small class="text-muted">Total Downloaded</small>
            </div></div>
        </div>
    </div>

    {{-- Signal Strength Overview --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fa-solid fa-tower-broadcast me-2"></i>Signal Strength Overview</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach($networks as $n)
                @php
                    $sigColor = $n->signal >= 70 ? 'success' : ($n->signal >= 40 ? 'warning' : 'danger');
                @endphp
                <div class="col-md-4 col-sm-6">
                    <div class="d-flex align-items-center gap-3 p-3 border rounded">
                        <div>
                            <i class="fa-solid fa-{{ $n->type == 'WiFi' ? 'wifi' : 'signal' }} fa-2x text-{{ $sigColor }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="font-size:0.85rem;">{{ $n->device }}</div>
                            <small class="text-muted">{{ $n->type }}{{ $n->ssid != '—' ? ' · '.$n->ssid : '' }}</small>
                            <div class="progress mt-1" style="height:6px;">
                                <div class="progress-bar bg-{{ $sigColor }}" style="width:{{ $n->signal }}%"></div>
                            </div>
                            <small class="text-{{ $sigColor }}">{{ $n->signal }}% signal</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Network Table --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Network Details</h5>
            <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-download me-1"></i>Export</button>
        </div>
        <div class="card-datatable">
            <div style="overflow-x:auto;">
                <table class="table table-bordered" id="mytable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Device</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>SSID</th>
                            <th>IP Address</th>
                            <th>Signal</th>
                            <th>Upload</th>
                            <th>Download</th>
                            <th>Status</th>
                            <th>Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($networks as $row)
                        @php $sigColor = $row->signal >= 70 ? 'success' : ($row->signal >= 40 ? 'warning' : 'danger'); @endphp
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->device }}</td>
                            <td>{{ $row->user }}</td>
                            <td><span class="badge bg-info">{{ $row->type }}</span></td>
                            <td>{{ $row->ssid }}</td>
                            <td><code>{{ $row->ip }}</code></td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <div class="progress" style="height:6px;min-width:60px;">
                                        <div class="progress-bar bg-{{ $sigColor }}" style="width:{{ $row->signal }}%"></div>
                                    </div>
                                    <small class="text-{{ $sigColor }}">{{ $row->signal }}%</small>
                                </div>
                            </td>
                            <td><i class="fa-solid fa-arrow-up text-warning me-1"></i>{{ $row->data_up }}</td>
                            <td><i class="fa-solid fa-arrow-down text-primary me-1"></i>{{ $row->data_down }}</td>
                            <td>
                                @if($row->status == 'Connected')
                                    <span class="badge bg-success">Connected</span>
                                @elseif($row->status == 'Weak Signal')
                                    <span class="badge bg-warning">Weak Signal</span>
                                @else
                                    <span class="badge bg-danger">Disconnected</span>
                                @endif
                            </td>
                            <td>{{ $row->updated }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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