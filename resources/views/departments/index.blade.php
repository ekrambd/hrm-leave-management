@extends('admin_master')

@section('content')
 <main class="app-main">
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">All Department</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Department</li>
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
               <div class="card-header bg-primary text-light"><div class="card-title">All Department</div></div>
                <div class="card-body">
               
                  <div class="table-responsive">
                    <a href="{{route('departments.create')}}" class="btn btn-success float-end"><i class="fa fa-plus"></i> Add New Department</a><br/><br/>
                  	<table class="table table-striped table-bordered bg-info" id="department-table">
                  	<thead>
                      <tr>
                       <th>Department Name</th>	
                       <th>Action</th>
                      </tr>		
                  	</thead>
                  	<tbody class="conts"></tbody>
                  </table>
                  </div>

                </div>
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

@push('scripts')
 <script>
  $(document).ready(function(){
  	let department_id;
  	var departmentTable = $('#department-table').DataTable({
            searching: true,
            processing: true,
            serverSide: true,
            ordering: false,
            responsive: true,
            stateSave: true,
            ajax: {
                url: "{{ route('departments.index') }}"
            },
            columns: [
                { data: 'department_name', name: 'department_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
    });

  	$(document).on('click', '.delete-department', function(e) {
        e.preventDefault();
        department_id = $(this).data('id');
        if (confirm('Do you want to delete this department?')) {
            $.ajax({
                url: "{{ url('/departments') }}/" + department_id,
                type: "DELETE",
                dataType: "json",
                success: function(data) {
                  departmentTable.ajax.reload(null, false);
                  toastr.success(data.message);
                }
            });
        }
    });

  });	
 </script>
@endpush