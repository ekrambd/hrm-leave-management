@extends('admin_master')

@section('content')
 <main class="app-main">
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Add Department</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Department</li>
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
               <div class="card-header bg-primary text-light"><div class="card-title">Add Department</div></div>
              <form action="{{route('departments.store')}}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="mb-3">
                    <label for="department_name" class="form-label">Department Name <span class="required">*</span></label>
                    <input
                      type="text"
                      class="form-control"
                      name="department_name"
                      id="department_name"
                      placeholder="Department Name"
                      required=""
                      value="{{old('department_name')}}"
                    />
                    @error('department_name')
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