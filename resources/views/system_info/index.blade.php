@extends('layouts.app')

@section('content')

@php

$devices = [
    (object)[
        'id'          => 1,
        'device'      => 'Samsung Galaxy S23',
        'user'        => 'John Doe',
        'os'          => 'Android 14',
        'model'       => 'SM-S911B',
        'brand'       => 'Samsung',
        'imei'        => '352099001761481',
        'serial'      => 'R5CT800XXXX',
        'ram_used'    => 4.2,
        'ram_total'   => 8,
        'cpu'         => 'Snapdragon 8 Gen 2',
        'cpu_usage'   => 38,
        'uptime'      => '2d 4h 12m',
        'last_seen'   => '2026-05-06 10:05 AM',
        'status'      => 'Online',
    ],
    (object)[
        'id'          => 2,
        'device'      => 'iPhone 15 Pro',
        'user'        => 'Jane Smith',
        'os'          => 'iOS 17.4',
        'model'       => 'A3101',
        'brand'       => 'Apple',
        'imei'        => '013954006297001',
        'serial'      => 'F2LWQ1XXXXXX',
        'ram_used'    => 3.1,
        'ram_total'   => 8,
        'cpu'         => 'Apple A17 Pro',
        'cpu_usage'   => 22,
        'uptime'      => '5d 10h 5m',
        'last_seen'   => '2026-05-06 10:10 AM',
        'status'      => 'Online',
    ],
    (object)[
        'id'          => 3,
        'device'      => 'Xiaomi 14',
        'user'        => 'Ali Hassan',
        'os'          => 'Android 14 (HyperOS)',
        'model'       => '23127PN0CC',
        'brand'       => 'Xiaomi',
        'imei'        => '861234050012345',
        'serial'      => 'MI14XXXX1234',
        'ram_used'    => 10.4,
        'ram_total'   => 12,
        'cpu'         => 'Snapdragon 8 Gen 3',
        'cpu_usage'   => 71,
        'uptime'      => '0d 18h 44m',
        'last_seen'   => '2026-05-06 10:08 AM',
        'status'      => 'Online',
    ],
    (object)[
        'id'          => 4,
        'device'      => 'OnePlus 12',
        'user'        => 'Siti Rahimah',
        'os'          => 'Android 14 (OxygenOS)',
        'model'       => 'CPH2581',
        'brand'       => 'OnePlus',
        'imei'        => '860693050123456',
        'serial'      => 'OP12XXXX5678',
        'ram_used'    => 6.8,
        'ram_total'   => 16,
        'cpu'         => 'Snapdragon 8 Gen 3',
        'cpu_usage'   => 15,
        'uptime'      => '10d 2h 30m',
        'last_seen'   => '2026-05-06 10:01 AM',
        'status'      => 'Online',
    ],
];

@endphp

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">System /</span> Device Info
    </h4>

    {{-- Device Info Cards --}}
    <div class="row mb-4">
        @foreach($devices as $d)
        @php
            $ramPct   = round(($d->ram_used / $d->ram_total) * 100);
            $ramColor = $ramPct >= 80 ? 'danger' : ($ramPct >= 55 ? 'warning' : 'success');
            $cpuColor = $d->cpu_usage >= 70 ? 'danger' : ($d->cpu_usage >= 40 ? 'warning' : 'success');
        @endphp
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-0">{{ $d->device }}</h6>
                            <small class="text-muted">{{ $d->user }} &mdash; {{ $d->os }}</small>
                        </div>
                        <span class="badge bg-{{ $d->status == 'Online' ? 'success' : 'danger' }}">{{ $d->status }}</span>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="p-2 rounded border text-center">
                                <small class="text-muted d-block">Brand</small>
                                <span class="fw-semibold" style="font-size:0.82rem;">{{ $d->brand }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded border text-center">
                                <small class="text-muted d-block">Model</small>
                                <span class="fw-semibold" style="font-size:0.82rem;">{{ $d->model }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded border text-center">
                                <small class="text-muted d-block">IMEI</small>
                                <span class="fw-semibold" style="font-size:0.78rem;">{{ $d->imei }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded border text-center">
                                <small class="text-muted d-block">Uptime</small>
                                <span class="fw-semibold" style="font-size:0.82rem;">{{ $d->uptime }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <small>RAM Usage</small>
                            <small class="text-{{ $ramColor }}">{{ $d->ram_used }} / {{ $d->ram_total }} GB ({{ $ramPct }}%)</small>
                        </div>
                        <div class="progress" style="height:7px;">
                            <div class="progress-bar bg-{{ $ramColor }}" style="width:{{ $ramPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between mb-1">
                            <small>CPU Usage — {{ $d->cpu }}</small>
                            <small class="text-{{ $cpuColor }}">{{ $d->cpu_usage }}%</small>
                        </div>
                        <div class="progress" style="height:7px;">
                            <div class="progress-bar bg-{{ $cpuColor }}" style="width:{{ $d->cpu_usage }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted" style="font-size:0.78rem;">
                    <i class="fa-solid fa-clock me-1"></i>Last seen: {{ $d->last_seen }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Full Detail Table --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">System Info Table</h5>
        </div>

        <div class="card-datatable">
            <div style="overflow-x:auto;">
                <table class="table table-bordered" id="mytable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Device</th>
                            <th>User</th>
                            <th>OS</th>
                            <th>Brand</th>
                            <th>IMEI</th>
                            <th>Serial</th>
                            <th>CPU</th>
                            <th>RAM</th>
                            <th>Uptime</th>
                            <th>Status</th>
                            <th>Last Seen</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($devices as $row)
                        @php
                            $ramPct = round(($row->ram_used / $row->ram_total) * 100);
                            $ramColor = $ramPct >= 80 ? 'danger' : ($ramPct >= 55 ? 'warning' : 'success');
                        @endphp

                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->device }}</td>
                            <td>{{ $row->user }}</td>
                            <td>{{ $row->os }}</td>
                            <td>{{ $row->brand }}</td>
                            <td><code>{{ $row->imei }}</code></td>
                            <td><code>{{ $row->serial }}</code></td>
                            <td>{{ $row->cpu }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <div class="progress" style="height:6px;min-width:60px;">
                                        <div class="progress-bar bg-{{ $ramColor }}" style="width:{{ $ramPct }}%"></div>
                                    </div>
                                    <small>{{ $row->ram_used }}/{{ $row->ram_total }}GB</small>
                                </div>
                            </td>
                            <td>{{ $row->uptime }}</td>
                            <td>
                                <span class="badge bg-{{ $row->status == 'Online' ? 'success' : 'danger' }}">
                                    {{ $row->status }}
                                </span>
                            </td>
                            <td>{{ $row->last_seen }}</td>
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