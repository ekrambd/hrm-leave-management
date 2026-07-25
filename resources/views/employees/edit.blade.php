@extends('admin_master')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Employee</h3>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Employee</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="row g-4">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header bg-success text-light">
                                <div class="card-title">Edit Employee</div>
                            </div>

                            <form action="{{ route('employees.update',$employee->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label for="name">Name</label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   id="name"
                                                   value="{{ old('name',$employee->user->name) }}"
                                                   required>

                                            @error('name')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="email">Email <span class="required">*</span></label>

                                            <input type="email"
                                                   class="form-control"
                                                   name="email"
                                                   id="email"
                                                   value="{{ old('email',$employee->user->email) }}">

                                            @error('email')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="phone">Phone <span class="required">*</span></label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="phone"
                                                   id="phone"
                                                   value="{{ old('phone',$employee->user->phone) }}">

                                            @error('phone')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="employee_code">Employee Code <span class="required">*</span></label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="employee_code"
                                                   id="employee_code"
                                                   value="{{ old('employee_code',$employee->employee_code) }}"
                                                   required>

                                            @error('employee_code')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="department_id">Department <span class="required">*</span></label>

                                            <select class="form-control select2bs4"
                                                    name="department_id"
                                                    required id="department_id">

                                                @foreach(departments() as $department)

                                                    <option value="{{ $department->id }}"
                                                        {{ old('department_id',$employee->department_id)==$department->id?'selected':'' }}>
                                                        {{ $department->department_name }}
                                                    </option>

                                                @endforeach

                                            </select>

                                            @error('department_id')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="designation_id">Designation <span class="required">*</span></label>

                                            <select class="form-control select2bs4"
                                                    name="designation_id"
                                                    required id="designation_id">

                                                @foreach(designations() as $designation)

                                                    <option value="{{ $designation->id }}"
                                                        {{ old('designation_id',$employee->designation_id)==$designation->id?'selected':'' }}>
                                                        {{ $designation->designation_name }}
                                                    </option>

                                                @endforeach

                                            </select>

                                            @error('designation_id')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="paid_leave">Paid Leave <span class="required">*</span></label>

                                            <input type="number"
                                                   class="form-control"
                                                   name="paid_leave"
                                                   id="paid_leave"
                                                   value="{{ old('paid_leave',$employee->paid_leave) }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="sick_leave">Sick Leave <span class="required">*</span></label>

                                            <input type="number"
                                                   class="form-control"
                                                   name="sick_leave"
                                                   id="sick_leave"
                                                   value="{{ old('sick_leave',$employee->sick_leave) }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="casual_leave">Casual Leave <span class="required">*</span></label>

                                            <input type="number"
                                                   class="form-control"
                                                   name="casual_leave"
                                                   id="casual_leave"
                                                   value="{{ old('casual_leave',$employee->casual_leave) }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="image">Profile Image</label>

                                            <input name="image" type="file" id="image" accept="image/*" class="dropify" data-default-file="{{URL::to($employee->user->image)}}" data-height="150" />

                                            @error('image')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>

                                    <button class="btn btn-success">
                                        Save Changes
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