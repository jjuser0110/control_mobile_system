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
    </ul>
</aside>
<!-- end: sidebar -->