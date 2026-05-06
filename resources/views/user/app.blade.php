@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Apps /</span> List
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">App List</h5>
        </div>

        <div class="card-datatable text-nowrap">
            <table class="table table-bordered" id="mytable">
                <thead>
                    <tr>
                        <th style="min-width:200px;">APP</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Installed At</th>
                        <th>Last Seen</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($apps as $row)
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">

                                @php $iconUrl = optional($row->appIcon)->app_icon_url; @endphp

                                {{-- Show icon or default emoji --}}
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
                                    <div style="font-weight:600; font-size:13px;">{{ $row->app_name }}</div>
                                    <div style="font-size:11px; color:#888;">{{ $row->package_name }}</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            @if($row->app_type == 'system')
                                <span class="badge bg-secondary">System</span>
                            @else
                                <span class="badge bg-primary">User</span>
                            @endif
                        </td>

                        <td>
                            @if($row->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td style="font-size:12px; color:#555;">{{ $row->installed_at ?? '-' }}</td>
                        <td style="font-size:12px; color:#555;">{{ $row->last_seen_at ?? '-' }}</td>

                        {{-- ACTION --}}
                        <td>
                            @if($iconUrl)
                                {{-- Has icon — show replace button --}}
                                <button class="btn btn-sm btn-outline-secondary upload-icon-btn"
                                    data-package="{{ $row->package_name }}"
                                    data-name="{{ $row->app_name }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#uploadIconModal"
                                    title="Replace Icon">
                                    <i class="fa-solid fa-repeat me-2"></i> Replace Icon
                                </button>
                            @else
                                {{-- No icon — show upload button --}}
                                <button class="btn btn-sm btn-outline-primary upload-icon-btn"
                                    data-package="{{ $row->package_name }}"
                                    data-name="{{ $row->app_name }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#uploadIconModal"
                                    title="Upload Icon">
                                    <i class="fa-solid fa-upload me-2"></i> Upload Icon
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3">No apps found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- UPLOAD ICON MODAL --}}
<div class="modal fade" id="uploadIconModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Upload Icon — <span id="modalAppName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('user.app.icon.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="package_name" id="modalPackageName">

                <div class="modal-body">

                    <div class="mb-2">
                        <label class="form-label text-muted" style="font-size:12px;">Package</label>
                        <p id="modalPackageDisplay" class="fw-bold mb-0"></p>
                    </div>

                    <div class="mb-3 mt-3">
                        <label class="form-label">App Icon Image</label>
                        <input type="file" name="app_icon" id="iconFileInput"
                               class="form-control" accept="image/*" required>
                    </div>

                    {{-- Preview --}}
                    <div class="mb-3" id="previewBox" style="display:none;">
                        <label class="form-label">Preview</label><br>
                        <img id="iconPreview" src="#" width="60" height="60"
                             style="border-radius:10px; border:1px solid #ddd;">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-upload  me-2"></i> Upload & Replace
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(function () {
    $('#mytable').DataTable({
        pageLength: 10,
        ordering: true,
        lengthMenu: [5, 10, 25, 50, 100],
        dom: '<"row"<"col-md-6"l><"col-md-6"f>>t<"row"<"col-md-6"i><"col-md-6"p>>'
    });

    $(document).on('click', '.upload-icon-btn', function() {
        const pkg  = $(this).data('package');
        const name = $(this).data('name');

        $('#modalPackageName').val(pkg);
        $('#modalPackageDisplay').text(pkg);
        $('#modalAppName').text(name);

        $('#previewBox').hide();
        $('#iconPreview').attr('src', '#');
        $('#iconFileInput').val('');
    });

    $('#iconFileInput').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#iconPreview').attr('src', e.target.result);
                $('#previewBox').show();
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection