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
                            <div class="card-header bg-primary text-light">
                                <div class="card-title">Edit Employee</div>
                            </div>

                            <form action="{{ route('employees.update',$employee->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label>Name</label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   value="{{ old('name',$employee->user->name) }}"
                                                   required>

                                            @error('name')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Email</label>

                                            <input type="email"
                                                   class="form-control"
                                                   name="email"
                                                   value="{{ old('email',$employee->user->email) }}">

                                            @error('email')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Phone</label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="phone"
                                                   value="{{ old('phone',$employee->user->phone) }}">

                                            @error('phone')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Employee Code</label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="employee_code"
                                                   value="{{ old('employee_code',$employee->employee_code) }}"
                                                   required>

                                            @error('employee_code')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Department</label>

                                            <select class="form-control select2bs4"
                                                    name="department_id"
                                                    required>

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
                                            <label>Designation</label>

                                            <select class="form-control select2bs4"
                                                    name="designation_id"
                                                    required>

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
                                            <label>Paid Leave</label>

                                            <input type="number"
                                                   class="form-control"
                                                   name="paid_leave"
                                                   value="{{ old('paid_leave',$employee->paid_leave) }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Sick Leave</label>

                                            <input type="number"
                                                   class="form-control"
                                                   name="sick_leave"
                                                   value="{{ old('sick_leave',$employee->sick_leave) }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Casual Leave</label>

                                            <input type="number"
                                                   class="form-control"
                                                   name="casual_leave"
                                                   value="{{ old('casual_leave',$employee->casual_leave) }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Profile Image</label>

                                            <input type="file"
                                                   class="form-control"
                                                   name="image">

                                            @error('image')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">

                                            @if($employee->user->image)
                                                <img src="{{ asset($employee->user->image) }}"
                                                     width="120"
                                                     class="img-thumbnail">
                                            @endif

                                        </div>

                                    </div>

                                    <button class="btn btn-primary">
                                        Update
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