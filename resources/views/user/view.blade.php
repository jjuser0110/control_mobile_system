@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{route('user.index')}}">User /</a> 
         View
    </h4>
    <div class="row gy-4">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <!-- User Card -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="user-avatar-section">
                    <div class="d-flex align-items-center flex-column">
                        <img
                            class="img-fluid rounded my-4"
                            src="{{ $user->front_ic ? asset('storage/' . $user->front_ic) : asset('default-front.png') }}"
                            alt="Front IC" />

                        <img
                            class="img-fluid rounded my-4"
                            src="{{ $user->back_ic ? asset('storage/' . $user->back_ic) : asset('default-back.png') }}"
                            alt="Back IC" />
                    </div>
                </div>
                <h5 class="pb-2 border-bottom mb-4">Details</h5>
                <div class="info-container">
                <ul class="list-unstyled">
                    <li class="mb-3">
                    <span class="fw-bold me-2">Name:</span>
                    <span>{{$user->name??''}}</span>
                    </li>
                    
                    <li class="mb-3">
                    <span class="fw-bold me-2">Email:</span>
                    <span>{{$user->email??''}}</span>
                    </li>
                    
                    <li class="mb-3">
                    <span class="fw-bold me-2">Username:</span>
                    <span>{{$user->username??''}}</span>
                    </li>

                    <li class="mb-3">
                    <span class="fw-bold me-2">NRIC:</span>
                    <span>{{$user->nric??''}}</span>
                    </li>

                    <li class="mb-3">
                    <span class="fw-bold me-2">Contact:</span>
                    <span>{{$user->contact_no??''}}</span>
                    </li>

                    <li class="mb-3">
                    <span class="fw-bold me-2">Company:</span>
                    <span>{{$user->company_name??''}}</span>
                    </li>

                    <li class="mb-3">
                    <span class="fw-bold me-2">Company Contact:</span>
                    <span>{{$user->company_contact??''}}</span>
                    </li>

                    <li class="mb-3">
                    <span class="fw-bold me-2">Job Title:</span>
                    <span>{{$user->job_title??''}}</span>
                    </li>

                    <li class="mb-3">
                    <span class="fw-bold me-2">Salary Per Month:</span>
                    <span>{{$user->salary??''}}</span>
                    </li>

                    <li class="mb-3">
                    <span class="fw-bold me-2">Salary Date:</span>
                    <span>{{$user->salary_date??''}}</span>
                    </li>

                    <li class="mb-3">
                    <span class="fw-bold me-2">Status:</span>
                    <span class="{{$user->user_status??''}}">{{$user->user_status??''}}</span>
                    </li>

                    <li class="mb-3">
                    <span class="fw-bold me-2">Bill Tnb:</span>
                    <span ><a href="{{ $user->bill_tnb ? asset('storage/' . $user->bill_tnb) : asset('default-front.png') }}" target="_blank">View</a></span>
                    </li>

                    <li class="mb-3">
                    <span class="fw-bold me-2">Bill Air:</span>
                    <span ><a href="{{ $user->bill_air ? asset('storage/' . $user->bill_air) : asset('default-front.png') }}" target="_blank">View</a></span>
                    </li>

                    <li class="mb-3">
                    <span class="fw-bold me-2">Slip Gaji:</span>
                    <span ><a href="{{ $user->slip_gaji ? asset('storage/' . $user->slip_gaji) : asset('default-front.png') }}" target="_blank">View</a></span>
                    </li>
                </ul>
                <div class="d-flex justify-content-center pt-3">
                    <a
                    href="javascript:;"
                    class="btn btn-primary me-3"
                    href="{{ route('user.edit',$user) }}" onclick="showLoading()"
                    >Edit</a
                    >
                    @if($user->user_status != 'verified')
                    <a onclick="if(confirm('Are you sure you want to verify this user?')){showLoading();window.location.href='{{ route('user.verify',$user) }}'}" class="btn btn-label-success">Verify</a>
                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ User Sidebar -->

    <!-- User Content -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        <!-- User Pills -->
        <!-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>Account</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="app-user-view-security.html"
            ><i class="bx bx-lock-alt me-1"></i>Security</a
            >
        </li>
        <li class="nav-item">
            <a class="nav-link" href="app-user-view-billing.html"
            ><i class="bx bx-detail me-1"></i>Billing & Plans</a
            >
        </li>
        <li class="nav-item">
            <a class="nav-link" href="app-user-view-notifications.html"
            ><i class="bx bx-bell me-1"></i>Notifications</a
            >
        </li>
        <li class="nav-item">
            <a class="nav-link" href="app-user-view-connections.html"
            ><i class="bx bx-link-alt me-1"></i>Connections</a
            >
        </li>
        </ul> -->
        <!--/ User Pills -->

        <!-- Project table -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">User's Contact List</h5>
                <a class="btn btn-success" type="button" href="{{route('user.exportContacts', $user->id)}}">
    <i class="bx bx-download me-1"></i>
    <span>Export to Excel</span>
</a>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered" id="mytable">
                    <thead>
                        <tr>
                            <th>Contact Name</th>
                            <th>Contact Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->contact_number as $contact)
                        <tr>
                            <td>{{$contact->displayName??''}}</td>
                            <td>{{$contact->filtered_phone_numbers??''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">User's Call Logs</h5>
                <a class="btn btn-success" type="button" href="{{route('user.exportCallLogs', $user)}}">
                    <i class="bx bx-download me-1"></i>
                    <span>Export to Excel</span>
                </a>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered" id="mytable3">
                    <thead>
                        <tr>
                            <th>Contact Name</th>
                            <th>Contact Number</th>
                            <th>Duration</th>
                            <th>Type</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->call_logs as $call_log)
                        <tr>
                            <td>{{$call_log->name??''}}</td>
                            <td>{{$call_log->phoneNumber??''}}</td>
                            <td>{{$call_log->duration??''}}</td>
                            <td>{{$call_log->type??''}}</td>
                            <td>{{$call_log->timestamp??''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">User's Image</h5>
                <a class="btn btn-success" type="button" href="{{route('user.downloadImages', $user)}}">
                    <i class="bx bx-download me-1"></i>
                    <span>Download All Images</span>
                </a>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered" id="mytable4">
                    <thead>
                        <tr>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->images as $image)
                        <tr>
                            <td><a href="{{ $image->image_uri ? asset('storage/' . $image->image_uri) : asset('default-front.png') }}" target="_blank">{{$image->image_uri??''}}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(auth()->check() && auth()->user()->role_id != 4)
        <div class="card mb-4">
            <h5 class="card-header">User's Loan List</h5>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered" id="mytable2">
                <thead>
                    <tr>
                        <th>Loan Amount (RM)</th>
                        <th>Start Date</th>
                        <th>Duration (month)</th>
                        <th>Bank</th>
                        <th>Account No</th>
                        <th>Account Name</th>
                        <th>Video</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->loans as $loan)
                    <tr>
                        <td>{{$loan->loan_amount ?? ""}}</td>
                        <td>{{$loan->start_date ?? ""}}</td>
                        <td>{{$loan->duration_of_month ?? ""}}</td>
                        <td>{{$loan->bank->bank_name ?? ""}}</td>
                        <td>{{$loan->account_number ?? ""}}</td>
                        <td>{{$loan->account_name ?? ""}}</td>
                        <td>
                            <a class="btn btn-success" href="{{ $loan->video_path ? asset('storage/' . $loan->video_path) : asset('default-front.png') }}" target="_blank">
                                View
                            </a>
                        </td>
                        <td>{{$loan->status ?? ""}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endif
    </div>
    <!--/ User Content -->
    </div>
</div>
<!-- / Content -->
@endsection

@section('scripts')
<script>
    $(function(){
      var table = $('#mytable').DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        pageLength: 5,
        displayLength: 5,
        ordering:false,
        lengthMenu: [5, 10, 25, 50, 75, 100],
      });
      
      var table = $('#mytable2').DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        pageLength: 5,
        displayLength: 5,
        ordering:false,
        lengthMenu: [5, 10, 25, 50, 75, 100],
      });
      
      var table = $('#mytable3').DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        pageLength: 5,
        displayLength: 5,
        ordering:false,
        lengthMenu: [5, 10, 25, 50, 75, 100],
      });
      
      var table = $('#mytable4').DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        pageLength: 5,
        displayLength: 5,
        ordering:false,
        lengthMenu: [5, 10, 25, 50, 75, 100],
      });
    });
</script>
@endsection
