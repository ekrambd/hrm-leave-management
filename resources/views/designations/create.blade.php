@extends('admin_master')

@section('content')
 <main class="app-main">
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Add Designation</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Designation</li>
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
               <div class="card-header bg-primary text-light"><div class="card-title">Add Designation</div></div>
              <form action="{{route('designations.store')}}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="mb-3">
                    <label for="designation_name" class="form-label">Designation Name <span class="required">*</span></label>
                    <input
                      type="text"
                      class="form-control"
                      name="designation_name"
                      id="designation_name"
                      placeholder="Designation Name"
                      required=""
                      value="{{old('designation_name')}}"
                    />
                    @error('designation_name')
                      <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="department_id" class="form-label">Select Department <span class="required">*</span></label>
                    <select class="form-control select2bs4" name="department_id" id="department_id" required>
                    	<option value="" selected="" disabled="">Select Department</option>
                    	@foreach(departments() as $department)
                    	 <option value="{{$department->id}}">{{$department->department_name}}</option>
                    	@endforeach
                    </select>
                    @error('department_id')
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