@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4>User Detail</h4>

    {{-- USER INFO --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
                {{-- Profile Image --}}
                @php
                    $folder = 'uploads/' . $user->id;
                    $files = Storage::disk('public')->exists($folder) 
                            ? Storage::disk('public')->files($folder) 
                            : [];
                    $profileImage = count($files) > 0 ? asset('storage/' . $files[0]) : null;
                @endphp

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
        <div class="card-header">
            <h5>Contacts</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->phoneNumbers }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No contacts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- CALL LOGS --}}
    <div class="card mb-3">
        <div class="card-header">
            <h5>Call Logs</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Duration</th>
                        <th>Type</th>
                        <th>Time</th>
                    </tr>
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
                        <tr>
                            <td colspan="5" class="text-center text-muted">No call logs found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- USER IMAGES --}}
    <div class="card mb-3">
        <div class="card-header">
            <h5>Uploaded Images</h5>
        </div>
        <div class="card-body">
            @php
                $folder = 'uploads/' . $user->id;
                $images = Storage::disk('public')->exists($folder) 
                        ? Storage::disk('public')->files($folder) 
                        : [];
            @endphp

            @if(count($images) > 0)
                <div class="d-flex flex-wrap gap-2">
                    @foreach($images as $img)
                        <a href="{{ asset('storage/' . $img) }}" target="_blank">
                            <img src="{{ asset('storage/' . $img) }}" 
                                style="width:120px; height:120px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No images found for this user.</p>
            @endif
        </div>
    </div>

</div>

@endsection