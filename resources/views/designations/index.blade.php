@extends('admin_master')

@section('content')
 <main class="app-main">
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">All Designation</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Designation</li>
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
               <div class="card-header bg-primary text-light"><div class="card-title">All Designation</div></div>
                <div class="card-body">
               
                  <div class="table-responsive">
                    <a href="{{route('designations.create')}}" class="btn btn-success float-end"><i class="fa fa-plus"></i> Add New Designation</a><br/><br/>
                  	<table class="table table-striped table-bordered bg-info" id="designation-table">
                  	<thead>
                      <tr>
                       <th>Designation Name</th>
                       <th>Department</th>	
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
  	let designation_id;
  	var designationTable = $('#designation-table').DataTable({
            searching: true,
            processing: true,
            serverSide: true,
            ordering: false,
            responsive: true,
            stateSave: true,
            ajax: {
                url: "{{ route('designations.index') }}"
            },
            columns: [
                { data: 'designation_name', name: 'designation_name' },
                { data: 'department', name: 'department' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
    });

  	$(document).on('click', '.delete-designation', function(e) {
        e.preventDefault();
        designation_id = $(this).data('id');
        if (confirm('Do you want to delete this designation?')) {
            $.ajax({
                url: "{{ url('/designations') }}/" + designation_id,
                type: "DELETE",
                dataType: "json",
                success: function(data) {
                  designationTable.ajax.reload(null, false);
                  toastr.success(data.message);
                }
            });
        }
    });

  });	
 </script>
@endpush