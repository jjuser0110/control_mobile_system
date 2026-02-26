@extends('layouts.app')

@section('content')

    <!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Dashboard</span>
    </h4>

    <!-- Card Border Shadow -->
    <div class="row">
        <h1 class="ms-1 mb-0">Welcome to Control Mobile System</h4>

        <!-- <div class="col-sm-12 col-lg-12">
            <div class="col-md-6 col-12 mb-4">
                <form method="GET">
                    <div class="input-group input-daterange" >
                        <input type="date" class="form-control" name="date_from" value="{{$date_from??''}}"/>
                        <span class="input-group-text">to</span>
                        <input type="date" class="form-control" name="date_to" value="{{$date_to??''}}"/>
                        <button class="btn btn-primary" type="submit" >Filter</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-truck"></i></span>
                </div>
                <h4 class="ms-1 mb-0">{{$no_of_user??0}}</h4>
                </div>
                <p class="mb-1">Number of Register</p>
            </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-warning h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                <div class="avatar me-2">
                    <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-error"></i></span>
                </div>
                <h4 class="ms-1 mb-0">{{$no_of_loan??0}}</h4>
                </div>
                <p class="mb-1">Number of Loan Applied</p>
            </div>
            </div>
        </div> -->
    </div>
    <!--/ Card Border Shadow -->
</div>
    <!-- / Content -->

@endsection
@section('page-js')
@endsection
@section('scripts')
@endsection
