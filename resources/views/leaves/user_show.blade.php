@extends('admin_master')

@section('content')
<main class="app-main">

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-6">
                    <h3 class="mb-0">
                        Show Leave Request
                    </h3>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Show Leave Request
                        </li>
                    </ol>
                </div>

            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card">

                    <div class="card-header bg-primary text-light">
                        <div class="card-title">
                            Show Leave Request
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">
                                From Date
                            </label>

                            <input type="date"
                                   class="form-control"
                                   value="{{ $leave->from_date }}"
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                To Date
                            </label>

                            <input type="date"
                                   class="form-control"
                                   value="{{ $leave->to_date }}"
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Leave Type
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ ucfirst(str_replace('_',' ',$leave->type)) }}"
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Status
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ ucfirst($leave->status) }}"
                                   readonly>
                        </div>
                        @if($leave->status == 'rejected')
                        <div class="mb-3">
                           <label class="form-label">
                                Remarks
                            </label>

                           <div style="text-align: justify;">
                             {{ $leave->leave_review }}
                            </div> 
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">
                                <b>Leave Reason</b>
                            </label>

                            <p>{!! $leave->leave_reason !!}</p>
                        </div>

                        <a href="{{ url('/leaves') }}"
                           class="btn btn-success">
                            Go Back
                        </a>

                    </div>

                </div>

            </div>
        </div>

    </div>

</main>
@endsection