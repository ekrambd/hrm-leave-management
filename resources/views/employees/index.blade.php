@extends('admin_master')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">All Employees</h3>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">All Employees</li>
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
                                <div class="card-title">
                                    All Employees
                                </div>
                            </div>

                            <div class="card-body">

                                <div class="row mb-3">

                                    <div class="col-md-6">
                                        <select class="form-control select2bs4" id="department_filter">
                                            <option value="">All Departments</option>

                                            @foreach(departments() as $department)
                                                <option value="{{ $department->id }}">
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <select class="form-control select2bs4" id="designation_filter">
                                            <option value="">All Designations</option>

                                            @foreach(designations() as $designation)
                                                <option value="{{ $designation->id }}">
                                                    {{ $designation->designation_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-md-12 text-end my-2">
                                        <a href="{{ route('employees.create') }}"
                                           class="btn btn-success">
                                            <i class="fa fa-plus"></i>
                                            Add Employee
                                        </a>
                                    </div>

                                </div>


                                <div class="table-responsive">

                                    <table class="table table-striped table-bordered bg-info"
                                           id="employee-table">

                                        <thead>

                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Employee Code</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>

                                        </thead>

                                        <tbody></tbody>

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

$(function(){

    $('.select2bs4').select2({
        theme:'bootstrap4'
    });

    let employee_id;

    var employeeTable = $('#employee-table').DataTable({
        searching: true,
        processing:true,
        serverSide:true,
        responsive:true,
        ordering:false,
        stateSave:true,

        ajax:{

            url:"{{ route('employees.index') }}",

            data:function(d){

                d.search       = $('.dataTables_filter input').val();

                d.department_id = $('#department_filter').val();

                d.designation_id = $('#designation_filter').val();

            }

        },

        columns:[

            {
                data:'image',
                name:'image',
                orderable:false,
                searchable:false
            },

            {
                data:'name',
                name:'name'
            },

            {
                data:'employee_code',
                name:'employee_code'
            },

            {
                data:'department',
                name:'department'
            },

            {
                data:'designation',
                name:'designation'
            },

            {
                data:'email',
                name:'email'
            },

            {
                data:'phone',
                name:'phone'
            },

            {
                data:'action',
                name:'action',
                orderable:false,
                searchable:false
            }

        ]

    });


    // Department Change
    $('#department_filter').change(function(){

        let id = $(this).val();

        $('#designation_filter').html('<option value="">All Designations</option>');

        // if(id==""){

        //     employeeTable.ajax.reload();

        //     return;

        // }

        if(id == ""){
            id = "all_department";
        }

        $.ajax({

            url:"{{ url('designations-by-department') }}",

            type:"GET",

            data:{'department_id':id},

            success:function(response){

                console.log(response);

                $.each(response,function(key,value){

                    $('#designation_filter').append(
                        '<option value="'+value.id+'">'+value.designation_name+'</option>'
                    );

                });

            }

        });

        employeeTable.ajax.reload();

    });


    // Designation Filter

    $('#designation_filter').change(function(){

        employeeTable.ajax.reload();

    });


    // Delete

    $(document).on('click','.delete-employee',function(e){

        e.preventDefault();

        employee_id=$(this).data('id');

        if(confirm('Do you want to delete this employee?')){

            $.ajax({

                url:"{{ url('/employees') }}/"+employee_id,

                type:"DELETE",

                dataType:"json",

                success:function(data){

                    employeeTable.ajax.reload(null,false);

                    toastr.success(data.message);

                }

            });

        }

    });

});

</script>

@endpush