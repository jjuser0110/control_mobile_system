@extends('layouts.app')

@section('content')

{{-- Viewer CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/viewerjs/dist/viewer.min.css">

<style>
    .img-thumb {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #ddd;
        cursor: zoom-in;
        transition: transform 0.2s, border-color 0.2s;
    }
    .img-thumb:hover {
        transform: scale(1.05);
        border-color: #0d6efd;
    }
    .img-wrapper {
        position: relative;
        display: inline-block;
    }
    .btn-delete-img {
        position: absolute;
        top: -8px;
        right: -8px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        line-height: 1;
    }
    .btn-delete-img:hover {
        background: darkred;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <h4>User Detail</h4>

    {{-- USER INFO --}}
    <div class="card mb-3">
        <div class="card-body">
            @php
                $folder = 'uploads/' . $user->id;
                $files = Storage::disk('public')->exists($folder)
                         ? Storage::disk('public')->files($folder)
                         : [];
                $profileImage = count($files) > 0 ? asset('storage/' . $files[0]) : null;
            @endphp

            <div class="d-flex align-items-center gap-3 mb-3">
                @if($profileImage)
                    <img src="{{ $profileImage }}"
                         style="width:100px; height:100px; object-fit:cover; border-radius:50%; border:2px solid #ccc;">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=100&background=0D8ABC&color=fff"
                         style="width:100px; height:100px; object-fit:cover; border-radius:50%; border:2px solid #ccc;">
                @endif
                <div>
                    <h5 class="mb-0">{{ $user->name }}</h5>
                    <small class="text-muted">{{ $user->username }}</small>
                </div>
            </div>

            <p><b>Name:</b> {{ $user->name }}</p>
            <p><b>Email:</b> {{ $user->email }}</p>
            <p><b>Username:</b> {{ $user->username }}</p>
            <p><b>NRIC:</b> {{ $user->nric }}</p>
            <p><b>Contact No:</b> {{ $user->contact_no }}</p>
            <p><b>Status:</b>
                <span class="badge {{ $user->user_status == 'active' ? 'bg-success' : 'bg-danger' }}">
                    {{ ucfirst($user->user_status) }}
                </span>
            </p>
        </div>
    </div>

    {{-- CONTACTS --}}
    <div class="card mb-3">
        <div class="card-header"><h5>Contacts</h5></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr><th>ID</th><th>Name</th><th>Phone</th></tr>
                </thead>
                <tbody>
                    @forelse($user->contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->phoneNumbers }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">No contacts found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- CALL LOGS --}}
    <div class="card mb-3">
        <div class="card-header"><h5>Call Logs</h5></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr><th>Name</th><th>Phone</th><th>Duration</th><th>Type</th><th>Time</th></tr>
                </thead>
                <tbody>
                    @forelse($user->callLogs as $log)
                        <tr>
                            <td>{{ $log->name }}</td>
                            <td>{{ $log->phoneNumber }}</td>
                            <td>{{ $log->duration }}</td>
                            <td>{{ $log->type }}</td>
                            <td>{{ $log->timestamp }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No call logs found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- USER IMAGES --}}
    <div class="card mb-3">
        <div class="card-header"><h5>Uploaded Images</h5></div>
        <div class="card-body">
            @php
                $folder = 'uploads/' . $user->id;
                $images = Storage::disk('public')->exists($folder)
                          ? Storage::disk('public')->files($folder)
                          : [];
            @endphp

            @if(count($images) > 0)
                <div class="d-flex flex-wrap gap-3" id="image-gallery">
                    @foreach($images as $img)
                        <div class="img-wrapper" id="wrap-{{ md5($img) }}">
                            <button class="btn-delete-img"
                                onclick="deleteImage('{{ $img }}', '{{ md5($img) }}')"
                                title="Delete">✕</button>
                            <img src="{{ asset('storage/' . $img) }}"
                                 class="img-thumb gallery-img"
                                 alt="{{ basename($img) }}"
                                 data-original="{{ asset('storage/' . $img) }}">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted" id="no-images-msg">No images found for this user.</p>
            @endif
        </div>
    </div>

</div>

{{-- Viewer JS --}}
<script src="https://cdn.jsdelivr.net/npm/viewerjs/dist/viewer.min.js"></script>
<script>
    // Init viewer.js on gallery
    const gallery = document.getElementById('image-gallery');
    let viewer;

    function initViewer() {
        if (viewer) viewer.destroy();
        if (gallery) {
            viewer = new Viewer(gallery, {
                toolbar: {
                    zoomIn: 1,
                    zoomOut: 1,
                    oneToOne: 1,
                    reset: 1,
                    prev: 1,
                    play: 0,
                    next: 1,
                    rotateLeft: 1,
                    rotateRight: 1,
                    flipHorizontal: 1,
                    flipVertical: 1,
                },
                tooltip: true,
                movable: true,
                zoomable: true,
                rotatable: true,
                scalable: true,
                keyboard: true,
            });
        }
    }

    initViewer();

    // Delete image
    function deleteImage(imgPath, hash) {
        if (!confirm('Are you sure you want to delete this image?')) return;

        fetch('{{ route("user.image.delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ path: imgPath })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Remove image from DOM
                document.getElementById('wrap-' + hash).remove();

                // Reinit viewer after removal
                initViewer();

                // Show no images message if all deleted
                const remaining = document.querySelectorAll('.img-wrapper');
                if (remaining.length === 0) {
                    gallery.innerHTML = '';
                    document.getElementById('image-gallery').insertAdjacentHTML(
                        'afterend',
                        '<p class="text-muted">No images found for this user.</p>'
                    );
                }
            } else {
                alert('Failed to delete image: ' + (data.message ?? 'Unknown error'));
            }
        })
        .catch(() => alert('Something went wrong.'));
    }
</script>

@endsection