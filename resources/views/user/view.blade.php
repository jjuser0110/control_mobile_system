@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4>User Detail</h4>

    {{-- USER INFO --}}
    <div class="card mb-3">
        <div class="card-body">
            <p><b>Name:</b> {{ $user->name }}</p>
            <p><b>Email:</b> {{ $user->email }}</p>
            <p><b>Username:</b> {{ $user->username }}</p>
            <p><b>NRIC:</b> {{ $user->nric }}</p>
            <p><b>Contact No:</b> {{ $user->contact_no }}</p>
            <p><b>Status:</b> {{ $user->user_status }}</p>
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
                            <td colspan="3">No contacts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- CALL LOGS --}}
    <div class="card">
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
                            <td colspan="5">No call logs found</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection