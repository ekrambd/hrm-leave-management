@extends('admin_master')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Add Employee</h3>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Employee</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="row g-4">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header bg-primary text-light">
                                <div class="card-title">Add Employee</div>
                            </div>

                            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">
                                                Name <span class="required">*</span>
                                            </label>

                                            <input type="text"
                                                   name="name"
                                                   class="form-control"
                                                   id="name"
                                                   placeholder="Employee Name"
                                                   value="{{ old('name') }}"
                                                   required>

                                            @error('name')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">
                                                Email <span class="required">*</span>
                                            </label>

                                            <input type="email"
                                                   name="email"
                                                   id="email"
                                                   class="form-control"
                                                   placeholder="Email"
                                                   value="{{ old('email') }}">

                                            @error('email')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">
                                                Phone <span class="required">*</span>
                                            </label>

                                            <input type="text"
                                                   name="phone"
                                                   id="phone"
                                                   class="form-control"
                                                   placeholder="Phone"
                                                   value="{{ old('phone') }}">

                                            @error('phone')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="employee_code" class="form-label">
                                                Employee Code <span class="required">*</span>
                                            </label>

                                            <input type="text"
                                                   name="employee_code"
                                                   id="employee_code"
                                                   class="form-control"
                                                   placeholder="Employee Code"
                                                   value="{{ old('employee_code') }}"
                                                   required>

                                            @error('employee_code')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="department_id" class="form-label">
                                                Department <span class="required">*</span>
                                            </label>

                                            <select class="form-control select2bs4"
                                                    name="department_id"
                                                    id="department_id"
                                                    required>

                                                <option value="" selected disabled>
                                                    Select Department
                                                </option>

                                                @foreach(departments() as $department)
                                                    <option value="{{ $department->id }}">
                                                        {{ $department->department_name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('department_id')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="designation_id" class="form-label">
                                                Designation <span class="required">*</span>
                                            </label>

                                            <select class="form-control select2bs4" id="designation_id"
                                                    name="designation_id"
                                                    required>

                                                <option value="" selected disabled>
                                                    Select Designation
                                                </option>

                                                @foreach(designations() as $designation)
                                                    <option value="{{ $designation->id }}">
                                                        {{ $designation->designation_name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('designation_id')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="paid_leave" class="form-label">
                                                Paid Leave <span class="required">*</span>
                                            </label>

                                            <input type="number"
                                                   name="paid_leave"
                                                   id="paid_leave"
                                                   class="form-control"
                                                   value="{{ old('paid_leave',20) }}">

                                            @error('paid_leave')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="sick_leave" class="form-label">
                                                Sick Leave <span class="required">*</span>
                                            </label>

                                            <input type="number"
                                                   name="sick_leave"
                                                   id="sick_leave"
                                                   class="form-control"
                                                   value="{{ old('sick_leave',10) }}">

                                            @error('sick_leave')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="casual_leave" class="form-label">
                                                Casual Leave <span class="required">*</span>
                                            </label>

                                            <input type="number"
                                                   name="casual_leave"
                                                   id="casual_leave"
                                                   class="form-control"
                                                   value="{{ old('casual_leave',5) }}">

                                            @error('casual_leave')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">
                                                Password <span class="required">*</span>
                                            </label>

                                            <input type="password"
                                                   name="password"
                                                   id="password"
                                                   class="form-control"
                                                   required placeholder="Password">

                                            @error('password')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="confirm_password" class="form-label">
                                                Confirm Password <span class="required">*</span>
                                            </label>

                                            <input type="password"
                                                   name="confirm_password"
                                                   id="confirm_password"
                                                   class="form-control"
                                                   required placeholder="Password">

                                            @error('confirm_password')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="image" class="form-label">
                                                Profile Image
                                            </label>

                                            <input name="image" type="file" id="image" accept="image/*" class="dropify" data-height="150" />

                                            @error('image')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-success">
                                        Submit
                                    </button>

                                </div>
                            </form>

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
     // Department Change
    $('#department_id').change(function(){

        let id = $(this).val();

        $('#designation_id').html('<option value="" selected="" disabled="">Select Designation</option>');

        $.ajax({

            url:"{{ url('designations-by-department') }}",

            type:"GET",

            data:{'department_id':id},

            success:function(response){
                $.each(response,function(key,value){

                    $('#designation_id').append(
                        '<option value="'+value.id+'">'+value.designation_name+'</option>'
                    );

                });

            }

        });


    });
  });  
</script>
@endpush