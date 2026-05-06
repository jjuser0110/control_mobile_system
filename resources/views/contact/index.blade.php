@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Contact /</span> List
    </h4>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Contact List</h5>
        </div>

        <div class="card-datatable text-nowrap">
            <table class="table table-bordered" id="mytable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Contact Name</th>
                        <th>Contact Number</th>
                        <th>Created Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($contact as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->phoneNumbers }}</td>
                            <td>{{ $row->created_at }}</td>

                            {{-- Actions --}}
                            <td>
                                {{-- VIEW --}}
                                <a href="{{ route('user.view', $row->id) }}" onclick="showLoading()">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                {{-- DELETE --}}
                                <a style="color:red"
                                   href="{{ route('contact.destroy', $row->id) }}"
                                   onclick="return confirm('Delete this contact?')">
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