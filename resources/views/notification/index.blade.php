@extends('layouts.app')

@section('content')

@php

$notifications = [
    (object)['id'=>1, 'device'=>'Samsung Galaxy S23', 'user'=>'John Doe',     'app'=>'WhatsApp',    'app_icon'=>'fa-whatsapp',    'title'=>'Ahmad Fadzil',       'body'=>'Hey, are you free this weekend?',                    'priority'=>'High',   'received_at'=>'2026-05-06 10:02 AM'],
    (object)['id'=>2, 'device'=>'Samsung Galaxy S23', 'user'=>'John Doe',     'app'=>'Gmail',       'app_icon'=>'fa-envelope',    'title'=>'Google Security',    'body'=>'New sign-in detected from Chrome on Windows.',        'priority'=>'High',   'received_at'=>'2026-05-06 09:55 AM'],
    (object)['id'=>3, 'device'=>'iPhone 15 Pro',       'user'=>'Jane Smith',   'app'=>'Instagram',   'app_icon'=>'fa-instagram',   'title'=>'New Follower',       'body'=>'rina_travels started following you.',                 'priority'=>'Normal', 'received_at'=>'2026-05-06 09:40 AM'],
    (object)['id'=>4, 'device'=>'iPhone 15 Pro',       'user'=>'Jane Smith',   'app'=>'Grab',        'app_icon'=>'fa-car',         'title'=>'Order Confirmed',    'body'=>'Your GrabFood order from McDonald\'s is confirmed.',   'priority'=>'Normal', 'received_at'=>'2026-05-06 09:30 AM'],
    (object)['id'=>5, 'device'=>'Xiaomi 14',           'user'=>'Ali Hassan',   'app'=>'Telegram',    'app_icon'=>'fa-telegram',    'title'=>'Project Group',      'body'=>'Azwan: Bro boleh siapkan report hari ni tak?',        'priority'=>'High',   'received_at'=>'2026-05-06 09:15 AM'],
    (object)['id'=>6, 'device'=>'OnePlus 12',          'user'=>'Siti Rahimah', 'app'=>'Maybank2u',   'app_icon'=>'fa-building-columns','title'=>'Transaction Alert','body'=>'RM 150.00 deducted. Balance: RM 2,430.55.',          'priority'=>'High',   'received_at'=>'2026-05-06 09:05 AM'],
    (object)['id'=>7, 'device'=>'OnePlus 12',          'user'=>'Siti Rahimah', 'app'=>'TikTok',      'app_icon'=>'fa-music',       'title'=>'New Like',           'body'=>'Your video got 500 likes!',                          'priority'=>'Low',    'received_at'=>'2026-05-06 08:50 AM'],
];

$appCounts = [
    'WhatsApp' => 1, 'Gmail' => 1, 'Instagram' => 1,
    'Grab' => 1, 'Telegram' => 1, 'Maybank2u' => 1, 'TikTok' => 1,
];

@endphp

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Logs /</span> Notification Log
    </h4>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center"><div class="card-body">
                <i class="fa-solid fa-bell fa-2x text-primary mb-2"></i>
                <h4 class="mb-0">{{ count($notifications) }}</h4><small class="text-muted">Total Captured</small>
            </div></div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center"><div class="card-body">
                <i class="fa-solid fa-circle-exclamation fa-2x text-danger mb-2"></i>
                <h4 class="mb-0">4</h4><small class="text-muted">High Priority</small>
            </div></div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center"><div class="card-body">
                <i class="fa-solid fa-mobile-screen fa-2x text-info mb-2"></i>
                <h4 class="mb-0">4</h4><small class="text-muted">Devices Monitored</small>
            </div></div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center"><div class="card-body">
                <i class="fa-solid fa-grid-2 fa-2x text-success mb-2"></i>
                <h4 class="mb-0">7</h4><small class="text-muted">Apps Captured</small>
            </div></div>
        </div>
    </div>

    {{-- App Breakdown + Recent Feed --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa-solid fa-chart-bar me-2"></i>By App</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach(['WhatsApp'=>'fa-whatsapp text-success','Telegram'=>'fa-telegram text-info','Gmail'=>'fa-envelope text-danger','Instagram'=>'fa-instagram text-warning','Maybank2u'=>'fa-building-columns text-primary','Grab'=>'fa-car text-success','TikTok'=>'fa-music text-dark'] as $app => $iconClass)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa-brands {{ $iconClass }} me-2"></i>{{ $app }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $appCounts[$app] ?? 0 }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa-solid fa-list me-2"></i>Recent Notifications</h5>
                </div>
                <div class="card-body p-2" style="max-height:320px; overflow-y:auto;">
                    @foreach($notifications as $n)
                    @php $pColor = $n->priority == 'High' ? 'danger' : ($n->priority == 'Normal' ? 'primary' : 'secondary'); @endphp
                    <div class="d-flex align-items-start mb-3 pb-2 border-bottom">
                        <div class="me-3 mt-1">
                            <span class="badge bg-{{ $pColor }} p-2">
                                <i class="fa-brands {{ $n->app_icon }}"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold" style="font-size:0.85rem;">{{ $n->title }}</span>
                                <small class="text-muted">{{ $n->received_at }}</small>
                            </div>
                            <div style="font-size:0.82rem;">{{ $n->body }}</div>
                            <small class="text-muted">{{ $n->app }} &mdash; {{ $n->device }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Notification Log Table</h5>
            <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-download me-1"></i>Export</button>
        </div>
        <div class="card-datatable text-nowrap">
            <table class="table table-bordered" id="mytable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Device</th>
                        <th>User</th>
                        <th>App</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Priority</th>
                        <th>Received At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $row)
                    @php $pColor = $row->priority == 'High' ? 'danger' : ($row->priority == 'Normal' ? 'primary' : 'secondary'); @endphp
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->device }}</td>
                        <td>{{ $row->user }}</td>
                        <td><i class="fa-brands {{ $row->app_icon }} me-1"></i>{{ $row->app }}</td>
                        <td>{{ $row->title }}</td>
                        <td style="max-width:180px; white-space:normal;">{{ $row->body }}</td>
                        <td><span class="badge bg-{{ $pColor }}">{{ $row->priority }}</span></td>
                        <td>{{ $row->received_at }}</td>
                        <td>
                            <a href="#" class="me-2"><i class="fa-solid fa-eye"></i></a>
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