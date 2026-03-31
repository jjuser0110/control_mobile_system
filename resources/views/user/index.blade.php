@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">User /</span> List
    </h4>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">User List</h5>
        </div>

        <div class="card-datatable text-nowrap">
            <table class="table table-bordered" id="mytable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>NRIC</th>
                        <th>Contact No</th>
                        <th>Status</th>
                        <th>Verify</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($user as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->username }}</td>
                            <td>{{ $row->nric }}</td>
                            <td>{{ $row->contact_no }}</td>

                            {{-- Active / Inactive --}}
                            <td>
                                @if($row->is_active == 1)
                                    <span style="color:green;">Active</span>
                                @else
                                    <span style="color:red;">Inactive</span>
                                @endif
                            </td>

                            {{-- Verify Status --}}
                            <td>{{ $row->user_status }}</td>

                            {{-- Actions --}}
                            <td>

                                {{-- VERIFY / UNVERIFY --}}
                                @if($row->user_status != "verified")
                                    <a href="{{ route('user.verify', $row->id) }}"
                                       onclick="return confirm('Verify this user?')">
                                        Verify
                                    </a>
                                @else
                                    <a style="color:red"
                                       href="{{ route('user.unverify', $row->id) }}"
                                       onclick="return confirm('Unverify this user?')">
                                        Not Verify
                                    </a>
                                @endif

                                {{-- VIEW --}}
                                <a href="{{ route('user.view', $row->id) }}" onclick="showLoading()">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('user.edit', $row->id) }}" onclick="showLoading()">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                {{-- DELETE --}}
                                <a style="color:red"
                                   href="{{ route('user.destroy', $row->id) }}"
                                   onclick="return confirm('Delete this user?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>

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