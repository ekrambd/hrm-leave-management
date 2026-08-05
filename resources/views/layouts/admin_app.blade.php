@extends('admin_master')
@section('content')
<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">

			    <!-- Today Requests -->
			    <div class="col-lg-3 col-6">
			        <div class="small-box text-bg-primary">
			            <div class="inner">
			                <h3>{{ $summary['today_leave_requests'] }}</h3>
			                <p>Today's Leave Requests</p>
			            </div>
			            <i class="bi bi-calendar-check small-box-icon"></i>
			        </div>
			    </div>

			    <!-- Today Pending -->
			    <div class="col-lg-3 col-6">
			        <div class="small-box text-bg-warning">
			            <div class="inner">
			                <h3>{{ $summary['today_pending_leave_requests'] }}</h3>
			                <p>Today's Pending Requests</p>
			            </div>
			            <i class="bi bi-hourglass-split small-box-icon"></i>
			        </div>
			    </div>

			    <!-- Approved -->
			    <div class="col-lg-3 col-6">
			        <div class="small-box text-bg-success">
			            <div class="inner">
			                <h3>{{ $summary['total_approved_requests'] }}</h3>
			                <p>Total Approved Requests</p>
			            </div>
			            <i class="bi bi-check-circle-fill small-box-icon"></i>
			        </div>
			    </div>

			    <!-- Rejected -->
			    <div class="col-lg-3 col-6">
			        <div class="small-box text-bg-danger">
			            <div class="inner">
			                <h3>{{ $summary['total_rejected_requests'] }}</h3>
			                <p>Total Rejected Requests</p>
			            </div>
			            <i class="bi bi-x-circle-fill small-box-icon"></i>
			        </div>
			    </div>

			</div>
            <!--end::Row-->
            
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
@endsection