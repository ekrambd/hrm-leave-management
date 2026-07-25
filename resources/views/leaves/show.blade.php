@extends('admin_master')

@section('content')
 <main class="app-main">
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Show Leave Request</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Show Leave Request</li>
          </ol>
        </div>
      </div>
      <!--end::Row-->
    </div>
    <!--end::Container-->

    <!--begin::App Content-->
    <div class="app-content">
      <!--begin::Container-->
       <div class="container-fluid">
         <!--begin::Row-->
          <div class="row g-4">
            <div class="col-md-12">
             <div class="card">
               <div class="card-header bg-primary text-light"><div class="card-title">Show Leave Request</div></div>
               @if(user()->role_id == 1)
                <form action="{{route('leaves.store')}}" method="POST">
                @csrf
                @method('PATCH')
               @endif
                <div class="card-body"> 

                  <div class="mb-3">
                    <label for="from_date" class="form-label">From Date <span class="required">*</span></label>
                    <input type="date" class="form-control" name="from_date" id="from_date" value="{{$leave->from_date}}" readonly />

                  </div>

                  <div class="mb-3">
                    <label for="to_date" class="form-label">To Date <span class="required">*</span></label>
                    <input type="date" class="form-control" name="to_date" id="to_date" value="{{$leave->to_date}}" readonly />

                  </div>

                @if(user()->role_id == 2)
                  <div class="mb-3">
                    <label for="type" class="form-label">Select Leave Type <span class="required">*</span></label>
                    
                    <input type="text" class="form-control" id="type" value="{{$leave->type}}" readonly />

                  </div>
                @endif


                @if(user()->role_id == 2)
                  <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="required">*</span></label>
                    
                    <input type="text" class="form-control" id="status" value="{{$leave->status}}" readonly />

                  </div>
                @endif

                @if(user()->role_id == 1)
                  <div class="mb-3">
                    <label for="type" class="form-label">Select Leave Type <span class="required">*</span></label>
                    <select class="form-control select2bs4" name="type" id="type" required>
                    	<option value="" selected="" disabled="">Select Leave Type</option>
                    	<option value="sick" <?php if($leave->type == 'sick'){echo "selected";} ?>>Sick</option>
                    	<option value="paid" <?php if($leave->type == 'paid'){echo "selected";} ?>>Paid</option>
                    	<option value="unpaid" <?php if($leave->type == 'unpaid'){echo "selected";} ?>>Unpaid</option>
                    	<option value="casual" <?php if($leave->type == 'casual'){echo "selected";} ?>>Casual</option>
                    	<option value="special_consideration" <?php if($leave->type == 'special_consideration'){echo "selected";} ?>>Special Consideration</option>
                    </select>

                  </div>
                @endif


                @if(user()->role_id == 1)
                  <div class="mb-3">
                    <label for="status" class="form-label">Select Status <span class="required">*</span></label>
                    <select class="form-control select2bs4" name="type" id="type" required>
                    	<option value="" selected="" disabled="">Select Status Type</option>
                    	<option value="pending" <?php if($leave->type == 'pending'){echo "selected";} ?>>Pending</option>
                    	<option value="approved" <?php if($leave->type == 'approved'){echo "selected";} ?>>Approved</option>
                    	<option value="rejected" <?php if($leave->type == 'rejected'){echo "selected";} ?>>Rejected</option>
                    </select>

                  </div>
                @endif

                  <div class="mb-3">
                    <label for="leave_reason" class="form-label"><b>Leave Reason:-></b></label>

                    <p>{!!$leave->leave_reason!!}</p>

                  </div>
                @if(user()->role_id == 1)
                  <div class="mb-3">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                  </div>
                @endif

                @if(user()->role_id == 2)
                 <div class="mb-3">
                    <a href="{{url('/leaves')}}" class="btn btn-success">Go Back</a>
                  </div>
                @endif

                </div>
              </form>
             </div> 
              
            </div>
          </div>
        <!--end::Row--> 
       </div>
      <!--end::Container-->
    </div>

  </div>
 </main>
@endsection