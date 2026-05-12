@extends('layouts.app')

@section('content')

@php

$devices = [
    (object)['id' => 1, 'name' => 'Samsung Galaxy S23', 'user' => 'John Doe'],
    (object)['id' => 2, 'name' => 'iPhone 15 Pro',       'user' => 'Jane Smith'],
    (object)['id' => 3, 'name' => 'Xiaomi 14',           'user' => 'Ali Hassan'],
    (object)['id' => 4, 'name' => 'OnePlus 12',          'user' => 'Siti Rahimah'],
];

$files = [
    (object)['id'=>1, 'device_id'=>1, 'name'=>'profile_photo.jpg',     'type'=>'image', 'size'=>'2.4 MB',  'path'=>'/sdcard/DCIM/',          'modified'=>'2026-05-05 08:20 AM'],
    (object)['id'=>2, 'device_id'=>1, 'name'=>'video_clip_beach.mp4',  'type'=>'video', 'size'=>'85.6 MB', 'path'=>'/sdcard/DCIM/Camera/',   'modified'=>'2026-05-01 04:30 PM'],
    (object)['id'=>3, 'device_id'=>1, 'name'=>'notes_work.txt',        'type'=>'text',  'size'=>'12 KB',   'path'=>'/sdcard/Documents/',     'modified'=>'2026-04-28 09:00 AM'],
    (object)['id'=>4, 'device_id'=>2, 'name'=>'salary_slip_april.pdf', 'type'=>'pdf',   'size'=>'320 KB',  'path'=>'/sdcard/Documents/',     'modified'=>'2026-05-04 03:10 PM'],
    (object)['id'=>5, 'device_id'=>2, 'name'=>'notes_meeting.txt',     'type'=>'text',  'size'=>'8 KB',    'path'=>'/sdcard/Documents/',     'modified'=>'2026-04-30 09:15 AM'],
    (object)['id'=>6, 'device_id'=>3, 'name'=>'voice_note_001.m4a',    'type'=>'audio', 'size'=>'1.1 MB',  'path'=>'/sdcard/WhatsApp/Media', 'modified'=>'2026-05-03 11:00 AM'],
    (object)['id'=>7, 'device_id'=>3, 'name'=>'photo_trip.jpg',        'type'=>'image', 'size'=>'4.2 MB',  'path'=>'/sdcard/DCIM/',          'modified'=>'2026-05-02 07:45 AM'],
    (object)['id'=>8, 'device_id'=>4, 'name'=>'backup_contacts.vcf',   'type'=>'file',  'size'=>'45 KB',   'path'=>'/sdcard/Backups/',       'modified'=>'2026-05-02 06:45 PM'],
    (object)['id'=>9, 'device_id'=>4, 'name'=>'presentation.pdf',      'type'=>'pdf',   'size'=>'2.1 MB',  'path'=>'/sdcard/Documents/',     'modified'=>'2026-05-01 02:00 PM'],
];

// Per-device storage & folder data
$deviceData = [
    1 => [
        'internal_used' => 34.2, 'internal_total' => 128,
        'sd_used' => 58.7,       'sd_total' => 64,
        'types' => ['Images'=>'1.2 GB','Videos'=>'4.1 GB','Audio'=>'310 MB','Docs'=>'220 MB'],
        'folders' => [
            ['name'=>'DCIM',       'files'=>124, 'size'=>'1.2 GB'],
            ['name'=>'Documents',  'files'=>38,  'size'=>'220 MB'],
            ['name'=>'Downloads',  'files'=>57,  'size'=>'540 MB'],
            ['name'=>'WhatsApp',   'files'=>312, 'size'=>'3.8 GB'],
        ],
    ],
    2 => [
        'internal_used' => 62.5, 'internal_total' => 256,
        'sd_used' => 0,          'sd_total' => 0,
        'types' => ['Images'=>'800 MB','Videos'=>'1.2 GB','Audio'=>'90 MB','Docs'=>'540 MB'],
        'folders' => [
            ['name'=>'Documents',  'files'=>54,  'size'=>'540 MB'],
            ['name'=>'Downloads',  'files'=>21,  'size'=>'200 MB'],
            ['name'=>'iCloud',     'files'=>430, 'size'=>'60.1 GB'],
        ],
    ],
    3 => [
        'internal_used' => 88.0, 'internal_total' => 256,
        'sd_used' => 22.4,       'sd_total' => 128,
        'types' => ['Images'=>'3.1 GB','Videos'=>'7.4 GB','Audio'=>'1.1 MB','Docs'=>'100 MB'],
        'folders' => [
            ['name'=>'DCIM',       'files'=>210, 'size'=>'10.5 GB'],
            ['name'=>'WhatsApp',   'files'=>890, 'size'=>'12.3 GB'],
            ['name'=>'Recordings', 'files'=>14,  'size'=>'310 MB'],
        ],
    ],
    4 => [
        'internal_used' => 15.3, 'internal_total' => 128,
        'sd_used' => 8.1,        'sd_total' => 64,
        'types' => ['Images'=>'2.0 GB','Videos'=>'500 MB','Audio'=>'200 MB','Docs'=>'2.1 MB'],
        'folders' => [
            ['name'=>'Backups',    'files'=>6,   'size'=>'90 MB'],
            ['name'=>'Downloads',  'files'=>18,  'size'=>'300 MB'],
            ['name'=>'Documents',  'files'=>22,  'size'=>'2.1 GB'],
        ],
    ],
];

$typeIcon = [
    'image' => ['icon'=>'fa-file-image', 'color'=>'success'],
    'pdf'   => ['icon'=>'fa-file-pdf',   'color'=>'danger'],
    'audio' => ['icon'=>'fa-file-audio', 'color'=>'warning'],
    'video' => ['icon'=>'fa-file-video', 'color'=>'info'],
    'text'  => ['icon'=>'fa-file-lines', 'color'=>'secondary'],
    'file'  => ['icon'=>'fa-file',       'color'=>'primary'],
];

@endphp

{{-- Pass PHP data to JS --}}
<script>
    const allFiles    = @json($files);
    const deviceData  = @json($deviceData);
    const typeIconMap = @json($typeIcon);
</script>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Files /</span> File Manager
    </h4>

    @php

    use App\Models\Device;

    $devices = Device::latest()->get();

    @endphp

    {{-- Device Selector --}}
    <div class="card mb-4">
        <div class="card-body py-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <label for="deviceSelector" class="fw-semibold mb-0 text-nowrap">
                    <i class="fa-solid fa-mobile-screen me-1 text-primary"></i>
                    Select Device:
                </label>

                <select id="deviceSelector" class="form-select w-auto">
                    @foreach($devices as $d)
                        <option 
                            value="{{ $d->id }}"
                            data-device-name="{{ $d->device_name }}"
                            data-device-user="{{ $d->device_id }}"
                            {{ $loop->first ? 'selected' : '' }}
                        >
                            {{ $d->device_name }} ({{ $d->device_id }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Active Device Badge --}}
    <div class="mb-3">
        <span class="text-muted">Showing data for: </span>
        <span class="badge bg-primary fs-6 px-3 py-2" id="active-device-badge">
            <i class="fa-solid fa-mobile-screen-button me-1"></i>
            <span id="active-device-name">
                {{ $devices->first()->device_name ?? 'No Device' }}
            </span>
        </span>
    </div>

    {{-- Storage Summary --}}
    <div class="row mb-4" id="storage-section">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Internal Storage</h6>
                    <h4 class="mb-1" id="int-used-label">— <small class="text-muted fs-6">/ —</small></h4>
                    <div class="progress mb-2" style="height:8px;">
                        <div class="progress-bar" id="int-bar" style="width:0%"></div>
                    </div>
                    <small class="text-muted" id="int-sub">—</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2">SD Card</h6>
                    <h4 class="mb-1" id="sd-used-label">— <small class="text-muted fs-6">/ —</small></h4>
                    <div class="progress mb-2" style="height:8px;">
                        <div class="progress-bar" id="sd-bar" style="width:0%"></div>
                    </div>
                    <small class="text-muted" id="sd-sub">—</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-3">File Types Breakdown</h6>
                    <div class="d-flex justify-content-around" id="type-breakdown">
                        {{-- filled by JS --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Folder Grid --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fa-solid fa-folder-open me-2"></i>Folders</h5>
        </div>
        <div class="card-body">
            <div class="row g-3" id="folder-grid">
                {{-- filled by JS --}}
            </div>
        </div>
    </div>

    {{-- Recent Files Table --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa-solid fa-clock-rotate-left me-2"></i>Recent Files</h5>
            <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-download me-1"></i>Export</button>
        </div>
        <div class="card-datatable text-nowrap">
            <table class="table table-bordered" id="mytable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>File Name</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Path</th>
                        <th>Modified</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="file-tbody">
                    {{-- filled by JS --}}
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>

let dataTable = null;

// ── colour helpers ────────────────────────────────────────────────────────────
const iconMap = {
    image : { icon: 'fa-file-image', color: 'success'   },
    pdf   : { icon: 'fa-file-pdf',   color: 'danger'    },
    audio : { icon: 'fa-file-audio', color: 'warning'   },
    video : { icon: 'fa-file-video', color: 'info'      },
    text  : { icon: 'fa-file-lines', color: 'secondary' },
    file  : { icon: 'fa-file',       color: 'primary'   },
};

const typeIcons = {
    Images : { icon: 'fa-file-image', color: 'success' },
    Videos : { icon: 'fa-file-video', color: 'info'    },
    Audio  : { icon: 'fa-file-audio', color: 'warning' },
    Docs   : { icon: 'fa-file-pdf',   color: 'danger'  },
};

// ── main render ───────────────────────────────────────────────────────────────
function renderDevice(deviceId) {

    const data = deviceData[deviceId];

    // ── storage bars ─────────────────────────────────────────────────────────
    const intPct  = Math.round((data.internal_used / data.internal_total) * 100);
    const intFree = (data.internal_total - data.internal_used).toFixed(1);
    const intColor = intPct >= 80 ? 'bg-danger' : intPct >= 55 ? 'bg-warning' : 'bg-primary';

    document.getElementById('int-used-label').innerHTML =
        `${data.internal_used} GB <small class="text-muted fs-6">/ ${data.internal_total} GB</small>`;
    document.getElementById('int-bar').style.width = intPct + '%';
    document.getElementById('int-bar').className   = `progress-bar ${intColor}`;
    document.getElementById('int-sub').textContent = `${intPct}% used — ${intFree} GB free`;

    if (data.sd_total > 0) {
        const sdPct   = Math.round((data.sd_used / data.sd_total) * 100);
        const sdFree  = (data.sd_total - data.sd_used).toFixed(1);
        const sdColor = sdPct >= 80 ? 'bg-danger' : sdPct >= 55 ? 'bg-warning' : 'bg-success';

        document.getElementById('sd-used-label').innerHTML =
            `${data.sd_used} GB <small class="text-muted fs-6">/ ${data.sd_total} GB</small>`;
        document.getElementById('sd-bar').style.width = sdPct + '%';
        document.getElementById('sd-bar').className   = `progress-bar ${sdColor}`;
        document.getElementById('sd-sub').textContent = `${sdPct}% used — ${sdFree} GB free`;
    } else {
        document.getElementById('sd-used-label').innerHTML = `<span class="text-muted">No SD Card</span>`;
        document.getElementById('sd-bar').style.width = '0%';
        document.getElementById('sd-sub').textContent = 'Not available';
    }

    // ── type breakdown ────────────────────────────────────────────────────────
    const breakdown = document.getElementById('type-breakdown');
    breakdown.innerHTML = Object.entries(data.types).map(([label, size]) => {
        const t = typeIcons[label] || { icon: 'fa-file', color: 'secondary' };
        return `<div class="text-center">
            <i class="fa-solid ${t.icon} fa-2x text-${t.color}"></i><br>
            <small>${label}<br><b>${size}</b></small>
        </div>`;
    }).join('');

    // ── folders ───────────────────────────────────────────────────────────────
    const folderGrid = document.getElementById('folder-grid');
    folderGrid.innerHTML = data.folders.map(f => `
        <div class="col-md-2 col-sm-4 col-6">
            <div class="card text-center border h-100" style="cursor:pointer;">
                <div class="card-body py-3">
                    <i class="fa-solid fa-folder fa-3x text-warning mb-2"></i>
                    <div class="fw-semibold" style="font-size:0.85rem;">${f.name}</div>
                    <small class="text-muted">${f.files} files</small><br>
                    <small class="text-muted">${f.size}</small>
                </div>
            </div>
        </div>
    `).join('');

    // ── files table ───────────────────────────────────────────────────────────
    const filtered = allFiles.filter(f => f.device_id == deviceId);

    const rows = filtered.map(f => {
        const t = iconMap[f.type] || iconMap['file'];
        return `<tr>
            <td>${f.id}</td>
            <td><i class="fa-solid ${t.icon} text-${t.color} me-1"></i>${f.name}</td>
            <td><span class="badge bg-${t.color}">${f.type.charAt(0).toUpperCase() + f.type.slice(1)}</span></td>
            <td>${f.size}</td>
            <td><code>${f.path}</code></td>
            <td>${f.modified}</td>
            <td>
                <a href="#" class="me-2"><i class="fa-solid fa-download"></i></a>
                <a href="#" class="me-2"><i class="fa-solid fa-eye"></i></a>
                <a href="#" style="color:red;"><i class="fa-solid fa-trash"></i></a>
            </td>
        </tr>`;
    }).join('');

    // rebuild DataTable
    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }
    document.getElementById('file-tbody').innerHTML = rows;
    dataTable = $('#mytable').DataTable({
        pageLength  : 10,
        ordering    : false,
        lengthMenu  : [5, 10, 25, 50, 100],
        dom         : '<"row"<"col-md-6"l><"col-md-6"f>>t<"row"<"col-md-6"i><"col-md-6"p>>'
    });
}

// ── device button click ───────────────────────────────────────────────────────
$(function () {

    // render first selected device on load
    let firstDeviceId = $('#deviceSelector').val();
    renderDevice(firstDeviceId);

    // dropdown change
    $('#deviceSelector').on('change', function () {

        let selected = $(this).find(':selected');

        // update active device text
        const name = selected.data('device-name');
        const user = selected.data('device-user');

        $('#active-device-name').text(name);

        // render selected device
        const deviceId = $(this).val();
        renderDevice(deviceId);
    });

});

</script>
@endsection