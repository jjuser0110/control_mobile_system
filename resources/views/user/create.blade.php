@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{route('user.index')}}">User /</a> 
         @if (isset($user)) Edit @else Create @endif
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
            <h5 class="card-header">User Details</h5>
            <div class="card-body">
                <form class="row g-3" enctype="multipart/form-data" @if (isset($user)) method="post" action="{{ route('user.update',$user) }}" @else method="post" action="{{ route('user.store') }}" @endif onsubmit="showLoading()">
                @csrf
                <div class="col-md-6">
                    <label class="form-label" for="username">Username</label>
                    <input
                        type="text"
                        class="form-control"
                        id="username"
                        name="username"
                        placeholder="Mayuser"
                        value="{{ old('username', $user->username ?? '') }}"
                        required
                    />
                </div>

                <!-- Name -->
                <div class="col-md-6">
                    <label class="form-label" for="name">Full Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="John Doe"
                        value="{{ old('name', $user->name ?? '') }}"
                        required
                    />
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label" for="email">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="user@example.com"
                        value="{{ old('email', $user->email ?? '') }}"
                        required
                    />
                </div>

                <!-- NRIC -->
                <div class="col-md-6">
                    <label class="form-label" for="nric">NRIC</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nric"
                        name="nric"
                        placeholder="e.g. 900101145678"
                        value="{{ old('nric', $user->nric ?? '') }}"
                        required
                    />
                </div>

                <!-- Contact Number -->
                <div class="col-md-7">
                    <label class="form-label" for="contact_no">Contact No</label>
                    <input
                        type="text"
                        class="form-control"
                        id="contact_no"
                        name="contact_no"
                        placeholder="e.g. 0123456789"
                        value="{{ old('contact_no', $user->contact_no ?? '') }}"
                        required
                    />
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="company_name">Company Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="company_name"
                        name="company_name"
                        placeholder="e.g. company abc"
                        value="{{ old('company_name', $user->company_name ?? '') }}"
                        
                    />
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="company_contact">Company Contact</label>
                    <input
                        type="text"
                        class="form-control"
                        id="company_contact"
                        name="company_contact"
                        placeholder="e.g. 082665544"
                        value="{{ old('company_contact', $user->company_contact ?? '') }}"
                        
                    />
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="job_title">Job Title</label>
                    <input
                        type="text"
                        class="form-control"
                        id="job_title"
                        name="job_title"
                        placeholder="e.g. Director"
                        value="{{ old('job_title', $user->job_title ?? '') }}"
                        
                    />
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="salary_date">Salary Date</label>
                    <input
                        type="text"
                        class="form-control"
                        id="salary_date"
                        name="salary_date"
                        placeholder="e.g. 20th"
                        value="{{ old('salary_date', $user->salary_date ?? '') }}"
                        
                    />
                </div>

                <div class="col-md-7">
                    <label class="form-label" for="salary">Salary</label>
                    <input
                        type="text"
                        class="form-control"
                        id="salary"
                        name="salary"
                        placeholder="e.g. 3888.00"
                        value="{{ old('salary', $user->salary ?? '') }}"
                        
                    />
                </div>

                <div class="col-md-6">
                    <label class="form-label">Front IC</label>
                    <input
                        type="file"
                        class="form-control"
                        name="front_ic"
                        accept="image/*,.pdf"
                    />
                    <a href="{{ $user->front_ic ? asset('storage/' . $user->front_ic) : asset('default-front.png') }}" target="_blank">View</a>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Back IC</label>
                    <input
                        type="file"
                        class="form-control"
                        name="back_ic"
                        accept="image/*,.pdf"
                    />
                    <a href="{{ $user->back_ic ? asset('storage/' . $user->back_ic) : asset('default-front.png') }}" target="_blank">View</a>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Bill TNB</label>
                    <input
                        type="file"
                        class="form-control"
                        name="bill_tnb"
                        accept="image/*,.pdf"
                    />
                    <a href="{{ $user->bill_tnb ? asset('storage/' . $user->bill_tnb) : asset('default-front.png') }}" target="_blank">View</a>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Bill Air</label>
                    <input
                        type="file"
                        class="form-control"
                        name="bill_air"
                        accept="image/*,.pdf"
                    />
                    <a href="{{ $user->bill_air ? asset('storage/' . $user->bill_air) : asset('default-front.png') }}" target="_blank">View</a>
                </div>

                <div class="col-md-7">
                    <label class="form-label">Slip Gaji</label>
                    <input
                        type="file"
                        class="form-control"
                        name="slip_gaji"
                        accept="image/*,.pdf"
                    />
                    <a href="{{ $user->slip_gaji ? asset('storage/' . $user->slip_gaji) : asset('default-front.png') }}" target="_blank">View</a>
                </div>
                

                <div class="col-md-7">
                    <label class="form-label" for="password">Password</label>
                    <input
                    type="password"
                    class="form-control"
                    placeholder="password"
                    name="password"
                    @if(!isset($user)) required @endif />
                </div>
                @if(isset($user))
                <div class="col-md-7">
                    <label class="form-label" for="password">Is Active?</label>
                    <select name="is_active" class="form-control">
                        <option value="1" <?php echo isset($user)&&$user->is_active == 1?'selected':'' ?>>Active</option>
                        <option value="0" <?php echo isset($user)&&$user->is_active == 0?'selected':'' ?>>Inactive</option>
                    </select>
                </div>
                @endif

                <hr>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection

@section('scripts')
@endsection