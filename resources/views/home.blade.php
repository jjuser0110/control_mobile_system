@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Title -->
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Dashboard</span>
    </h4>

    <!-- Top Stats Row -->
    <div class="row g-3">

        <!-- Card 1 -->
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Total Users</small>
                    <h3 class="mb-0">3</h3>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Total Devices</small>
                    <h3 class="mb-0">3</h3>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Total Sessions</small>
                    <h3 class="mb-0">20</h3>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Active Sessions</small>
                    <h3 class="mb-0">15</h3>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Remote Connections</small>
                    <h3 class="mb-0">10</h3>
                </div>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Security Logs</small>
                    <h3 class="mb-0">20</h3>
                </div>
            </div>
        </div>

        <!-- Card 7 -->
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">File Transfers</small>
                    <h3 class="mb-0">12</h3>
                </div>
            </div>
        </div>

        <!-- Card 8 -->
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Support Tickets</small>
                    <h3 class="mb-0">19</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Spacer -->
    <div class="mt-4"></div>

    <!-- Bottom Section (Optional extra dashboard feel) -->
    <div class="row g-3">

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5>Recent Activity</h5>
                    <p class="text-muted mb-0">System running normally. No critical alerts.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5>System Status</h5>
                    <p class="text-success mb-0">All services online</p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@section('scripts')
@endsection