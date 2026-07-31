@extends('admin_master')

@section('content')
<main class="app-main">

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Show Leave Request</h3>
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

              <div class="row">
                 <div class="col-md-7">

                  <div class="card">
                      <div class="card-header bg-primary text-light">
                          <div class="card-title">
                              Show Leave Request
                          </div>
                      </div>

                      <form action="{{ route('leaves.update',$leave->id) }}" method="POST">
                          @csrf
                          @method('PATCH')

                          <div class="card-body">

                              <div class="mb-3">
                                  <label for="from_date" class="form-label">From Date</label>

                                  <input type="date"
                                         class="form-control"
                                         id="from_date"
                                         value="{{ $leave->from_date }}"
                                         readonly>

                              </div>

                              <div class="mb-3">
                                  <label for="to_date" class="form-label">To Date</label>

                                  <input type="date"
                                         class="form-control"
                                         value="{{ $leave->to_date }}"
                                         id="to_date"
                                         readonly>
                              </div>


                              <div class="mb-3">
                                  <label for="leave_duration" class="form-label">Leave Duration ( Days )</label>

                                  <input type="text"
                                         class="form-control"
                                         id="leave_duration"
                                         value="{{ $leave->leave_duration }}"
                                         readonly>

                              </div>

                              <div class="mb-3">
                                  <label for="leave_type" class="form-label">
                                      Select Leave Type
                                  </label>

                                  <select class="form-control select2bs4"
                                          name="type"
                                          id="leave_type"
                                          required>

                                      <option value="">Select Leave Type</option>

                                      <option value="sick"
                                          @selected($leave->type=='sick')>
                                          Sick
                                      </option>

                                      <option value="paid"
                                          @selected($leave->type=='paid')>
                                          Paid
                                      </option>

                                      <option value="unpaid"
                                          @selected($leave->type=='unpaid')>
                                          Unpaid
                                      </option>

                                      <option value="casual"
                                          @selected($leave->type=='casual')>
                                          Casual
                                      </option>

                                      <option value="special_consideration"
                                          @selected($leave->type=='special_consideration')>
                                          Special Consideration
                                      </option>

                                  </select>

                                  @error('leave_type')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                  @enderror
                              </div>

                          @if($leave->status == 'approved')
                            <div class="mb-3">
                                  <label for="status" class="form-label">
                                      Select Status
                                  </label>

                                  <select class="form-control select2bs4"
                                          name="status"
                                          id="status"
                                          required>

                                      <option value="approved" selected="">
                                          Approved
                                      </option>


                                  </select>

                                  @error('status')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                  @enderror

                            </div>

                          @else

                              <div class="mb-3">
                                  <label for="status" class="form-label">
                                      Select Status
                                  </label>

                                  <select class="form-control select2bs4"
                                          name="status"
                                          id="status"
                                          required>

                                      <option value="">Select Status</option>

                                      <option value="pending"
                                          @selected($leave->status=='pending')>
                                          Pending
                                      </option>

                                      <option value="approved"
                                          @selected($leave->status=='approved')>
                                          Approved
                                      </option>

                                      <option value="rejected"
                                          @selected($leave->status=='rejected')>
                                          Rejected
                                      </option>

                                  </select>

                                  @error('status')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                  @enderror

                              </div>
                          @endif

                            <div class="mb-3" id="db_leave_review"></div>

                            @if($leave->status == 'rejected')

                              <div class="mb-3" id="db_leave_review">
                                <label for="leave_review">Remarks</label>
                                <textarea class="form-control" id="leave_review" name="leave_review" placeholder="Remarks">{!!old('leave_review')!!}</textarea>
                                @error('leave_review')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                              </div>

                            @endif


                              <div class="mb-3">
                                  <label class="form-label">
                                      <b>Leave Reason</b>
                                  </label>

                                  <div style="text-align: justify;">
                                    {!! $leave->leave_reason !!}
                                  </div>
                              </div>

                              <button class="btn btn-success">
                                  Save Changes
                              </button>

                              <a href="{{ url('/leave-requests') }}"
                                 class="btn btn-secondary">
                                  Back
                              </a>

                          </div>

                      </form>

                  </div>

                 </div>
                 
                 <div class="col-md-5">
                   <div class="card card-success mb-4">
                              <div class="card-header">
                                  <h3 class="card-title">
                                      <i class="fas fa-calendar-check me-1"></i>
                                      Employee Leave Balance
                                  </h3>
                              </div>

                              <div class="card-body">

                                  <div class="row">

                                      <div class="col-lg-3 col-md-6 col-sm-6">
                                          <div class="small-box bg-info">
                                              <div class="inner">
                                                  <h3>{{ $leave->employee->sick_leave }}</h3>
                                                  <p>Sick Leave</p>
                                              </div>

                                              <div class="icon">
                                                  <i class="fas fa-notes-medical"></i>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-lg-3 col-md-6 col-sm-6">
                                          <div class="small-box bg-primary">
                                              <div class="inner">
                                                  <h3>{{ $leave->employee->paid_leave }}</h3>
                                                  <p>Paid Leave</p>
                                              </div>

                                              <div class="icon">
                                                  <i class="fas fa-money-check-alt"></i>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-lg-3 col-md-6 col-sm-6">
                                          <div class="small-box bg-warning">
                                              <div class="inner">
                                                  <h3>{{ $leave->employee->casual_leave }}</h3>
                                                  <p>Casual Leave</p>
                                              </div>

                                              <div class="icon">
                                                  <i class="fas fa-umbrella-beach"></i>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-lg-3 col-md-6 col-sm-6">
                                          <div class="small-box bg-success">
                                              <div class="inner">
                                                  <h3>{{ $leave->employee->total_leave_balance }}</h3>
                                                  <p>Total Balance</p>
                                              </div>

                                              <div class="icon">
                                                  <i class="fas fa-chart-pie"></i>
                                              </div>
                                          </div>
                                      </div>

                                  </div>

                                  <div class="table-responsive mt-3">
                                      <table class="table table-bordered table-striped align-middle mb-0">
                                          <thead class="table-light">
                                              <tr>
                                                  <th>Leave Type</th>
                                                  <th class="text-center">Available Days</th>
                                              </tr>
                                          </thead>

                                          <tbody>

                                              <tr>
                                                  <td>
                                                      <i class="fas fa-notes-medical text-info me-1"></i>
                                                      Sick Leave
                                                  </td>
                                                  <td class="text-center">
                                                      <span class="badge bg-info">
                                                          {{ $leave->employee->sick_leave }} Days
                                                      </span>
                                                  </td>
                                              </tr>

                                              <tr>
                                                  <td>
                                                      <i class="fas fa-money-check-alt text-primary me-1"></i>
                                                      Paid Leave
                                                  </td>
                                                  <td class="text-center">
                                                      <span class="badge bg-primary">
                                                          {{ $leave->employee->paid_leave }} Days
                                                      </span>
                                                  </td>
                                              </tr>

                                              <tr>
                                                  <td>
                                                      <i class="fas fa-umbrella-beach text-warning me-1"></i>
                                                      Casual Leave
                                                  </td>
                                                  <td class="text-center">
                                                      <span class="badge bg-warning text-dark">
                                                          {{ $leave->employee->casual_leave }} Days
                                                      </span>
                                                  </td>
                                              </tr>

                                              <tr class="table-success">
                                                  <th>Total Leave Balance</th>
                                                  <th class="text-center">
                                                      {{ $leave->employee->total_leave_balance }} Days
                                                  </th>
                                              </tr>

                                          </tbody>
                                      </table>
                                  </div>

                              </div>
                            </div>
                 </div> 

              </div>

            </div>
        </div>

    </div>

</main>
@endsection

@push('scripts')
 <script>
   $(document).ready(function(){
      $(document).on('change', '#status',function(){
        if(confirm('Are you sure want to change the status?'))
        {
            let status = $(this).val();
            if(status == 'rejected')
            {
              $('#db_leave_review').html(`
                <label for="leave_review" class="form-label">Remarks</label>
                <textarea class="form-control" name="leave_review" id="leave_review" placeholder="Remarks">{!!old('leave_review')!!}</textarea/>
              `);
            }else{
              $('#db_leave_review').html('');
            } 
        }           
        
      });

      

   });
 </script>
@endpush