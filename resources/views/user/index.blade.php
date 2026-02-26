@extends('layouts.app')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">User </span></h4>

        <!-- DataTable with Buttons -->
        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label">
                    <h5 class="card-title mb-0">User List</h5>
                </div>
                <!-- <div class="dt-action-buttons text-end pt-3 pt-md-0">
                    <div class="dt-buttons"> 
                        <a class="dt-button btn btn-success me-2" type="button" href="{{route('user.export')}}">
                            <span><i class="bx bx-download me-sm-1"></i> 
                                <span class="d-none d-sm-inline-block">Export to Excel</span>
                            </span>
                        </a>
                        <a class="dt-button create-new btn btn-primary" type="button" href="{{route('user.create')}}" onclick="showLoading()">
                            <span><i class="bx bx-plus me-sm-1"></i> 
                                <span class="d-none d-sm-inline-block">Add New Record</span>
                            </span>
                        </a> 
                    </div>
                </div> -->
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered" id="mytable">
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
                            <td>{{$row->id??""}}</td>
                            <td>{{$row->name??""}}</td>
                            <td>{{$row->email??""}}</td>
                            <td>{{$row->username??""}}</td>
                            <td>{{$row->nric??""}}</td>
                            <td>{{$row->contact_no??""}}</td>
                            <td><?php echo isset($row)&&$row->is_active == 1?'<span style="color:green">Active</span>':'<span style="color:red">Inactive</span>'?></td>
                            <td class="{{$row->user_status}}">{{$row->user_status??""}}</td>
                            <td>
                                @if($row->user_status != "verified")
                                <a style="cursor:pointer" onclick="if(confirm('Are you sure you want to verify this user?')){showLoading();window.location.href='{{ route('user.verify',$row) }}'}">Verify</a>
                                @else
                                <a style="color:red;cursor:pointer" onclick="if(confirm('Are you sure you want to reject this user?')){showLoading();window.location.href='{{ route('user.unverify',$row) }}'}">Not Verify</a>
                                    @endif
                                <a href="{{ route('user.view',$row) }}" onclick="showLoading()"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('user.edit',$row) }}" onclick="showLoading()"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a style="color:red;cursor:pointer" onclick="if(confirm('Are you sure you want to delete?')){showLoading();window.location.href='{{ route('user.destroy',$row) }}'}"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->


    @endsection
    @section('page-js')
    @endsection
@section('scripts')
    <script>
        $(function(){
            var table = $('#mytable').DataTable({
                dom: '<"row"<"col-sm-12 col-md-6 d-flex gap-2"l<"status-filter pt-2 ps-2">><"col-sm-12 col-md-6"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                pageLength: 10,
                displayLength: 5,
                ordering:false,
                lengthMenu: [5, 10, 25, 50, 75, 100],
                initComplete: function () {
                    var statusColumn = this.api().column(7);
                    var statusValues = [];
                    
                    statusColumn.data().unique().sort().each(function (d, j) {
                        if(d && d.trim() !== '') {
                            statusValues.push(d.trim());
                        }
                    });

                    var select = $('<select class="form-select" style="width: auto;"><option value="">All Status</option></select>')
                        .appendTo($('.status-filter'))
                        .on('change', function () {
                            var val = $(this).val();
                            statusColumn.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    statusValues.forEach(function(status) {
                        var capitalizedStatus = status.charAt(0).toUpperCase() + status.slice(1);
                        select.append('<option value="' + status + '">' + capitalizedStatus + '</option>');
                    });
                }
            });
        });
  </script>
@endsection