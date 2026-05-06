@php

$currentRoute = request()->route()->getName();

@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <!-- <span class="app-brand-logo demo">
                <img src="{{ asset('logo.png') }}" alt="Logo" style="width:100%;" />
            </span> -->
            <span class="app-brand-text demo menu-text fw-bold ms-2" style="font-size:1.2rem">Control Mobile System</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ Str::contains($currentRoute, 'dashboard') ? 'active' : ''}}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboards</div>
            </a>
        </li>

        <li class="menu-item {{ Str::contains($currentRoute, 'user.index') ? 'active' : '' }}">
            <a href="{{ route('user.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div>User</div>
            </a>
        </li>

        <li class="menu-item {{ Str::contains($currentRoute, 'contact.index') ? 'active' : '' }}">
            <a href="{{ route('contact.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-voice"></i>
                <div>Contact List</div>
            </a>
        </li>

        <li class="menu-item {{ Str::contains($currentRoute, 'call_log.index') ? 'active' : '' }}">
            <a href="{{ route('call_log.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-phone-call"></i>
                <div>Call Log List</div>
            </a>
        </li>

         <li class="menu-item {{ Str::contains($currentRoute, 'device.index') ? 'active' : '' }}">
            <a href="{{ route('device.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-devices"></i>
                <div>Device</div>
            </a>
        </li>

        <li class="menu-item {{ Str::contains($currentRoute, 'remote.index') ? 'active' : '' }}">
            <a href="{{ route('remote.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-network-chart"></i>
                <div>Remote Session</div>
            </a>
        </li>

    </ul>
</aside>
<!-- end: sidebar -->