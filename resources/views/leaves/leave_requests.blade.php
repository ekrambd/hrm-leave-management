@extends('admin_master')

@section('content')
 <main class="app-main">
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">All Leave Request</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Leave Request</li>
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
               <div class="card-header bg-primary text-light"><div class="card-title">All Leave Request</div></div>
                <div class="card-body">
               
                  <div class="table-responsive">
                  	<table class="table table-striped table-bordered bg-info data-table" id="leave-request-table">
                  	<thead>
                      <tr>
                       <th>#ID</th>
                       <th>Name</th>
                       <th>Code</th>
                       <th>Department</th>
                       <th>Designation</th>
                       <th>Start Date</th>
                       <th>To Date</th>
                       <th>Durantion (Days)</th>
                       <th>Status</th>	
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
  	
  	var leaveRequestTable = $('#leave-request-table').DataTable({
            searching: true,
            processing: true,
            serverSide: true,
            ordering: false,
            responsive: true,
            stateSave: true,
            ajax: {
                url: "{{ route('leaves.requests') }}",
                data:function(d){

	                d.search = $('.dataTables_filter input').val();


	            }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'employee_name', name: 'employee_name' },
                { data: 'employee_code', name: 'employee_code' },
                { data: 'department', name: 'department' },
                { data: 'designation', name: 'designation' },
                { data: 'from_date', name: 'from_date' },
                { data: 'to_date', name: 'to_date' },
                { data: 'leave_duration', name: 'leave_duration' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
    });


    window.socket.on("leave_request_created", function(data){

        console.log("Leave request received", data);

        leaveRequestTable.ajax.reload(null, false);

    });

  });	
 </script>
@endpush
