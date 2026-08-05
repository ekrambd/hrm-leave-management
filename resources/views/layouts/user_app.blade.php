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

              <!-- My Total Leave Requests -->
              <div class="col-lg-3 col-6">
                  <div class="small-box text-bg-primary">
                      <div class="inner">
                          <h3>{{ $summary['my_total_leave_requests'] }}</h3>
                          <p>My Total Leave Requests</p>
                      </div>

                      <i class="bi bi-file-earmark-text-fill small-box-icon"></i>
                  </div>
              </div>

              <!-- My Pending Requests -->
              <div class="col-lg-3 col-6">
                  <div class="small-box text-bg-warning">
                      <div class="inner">
                          <h3>{{ $summary['my_total_pending_requests'] }}</h3>
                          <p>My Pending Requests</p>
                      </div>

                      <i class="bi bi-hourglass-split small-box-icon"></i>
                  </div>
              </div>

              <!-- My Approved Requests -->
              <div class="col-lg-3 col-6">
                  <div class="small-box text-bg-success">
                      <div class="inner">
                          <h3>{{ $summary['my_total_approved_requests'] }}</h3>
                          <p>My Approved Requests</p>
                      </div>

                      <i class="bi bi-check-circle-fill small-box-icon"></i>
                  </div>
              </div>

              <!-- My Rejected Requests -->
              <div class="col-lg-3 col-6">
                  <div class="small-box text-bg-danger">
                      <div class="inner">
                          <h3>{{ $summary['my_total_rejected_requests'] }}</h3>
                          <p>My Rejected Requests</p>
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