@extends('admin_master')

@section('content')
 <main class="app-main">
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Add Leave Request</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Leave Request</li>
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
               <div class="card-header bg-primary text-light"><div class="card-title">Add Leave Request</div></div>
              <form action="{{route('leaves.store')}}" method="POST">
                @csrf
                <div class="card-body">

                  <div class="mb-3">
                    <label for="from_date" class="form-label">From Date <span class="required">*</span></label>
                    <input type="date" class="form-control" name="from_date" id="from_date" value="{{date('Y-m-d')}}"/>
                    @error('from_date')
                      <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="to_date" class="form-label">To Date <span class="required">*</span></label>
                    <input type="date" class="form-control" name="to_date" id="to_date" value="{{date('Y-m-d')}}"/>
                    @error('to_date')
                      <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                  </div>


                  <div class="mb-3">
                    <label for="type" class="form-label">Select Leave Type <span class="required">*</span></label>
                    <select class="form-control select2bs4" name="type" id="type" required>
                    	<option value="" selected="" disabled="">Select Leave Type</option>
                    	<option value="sick">Sick</option>
                    	<option value="paid">Paid</option>
                    	<option value="unpaid">Unpaid</option>
                    	<option value="casual">Casual</option>
                    	<option value="special_consideration">Special Consideration</option>
                    </select>
                    @error('type')
                      <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="leave_reason" class="form-label">Leave Reason <span class="required">*</span></label>
                    <textarea class="description" name="leave_reason" id="leave_reason">{!!old('leave_reason')!!}</textarea> 
                    @error('leave_reason')
                      <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                  </div>


                  <div class="mb-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>

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