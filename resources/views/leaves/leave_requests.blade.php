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
               <div class="card-header bg-primary text-light"><div class="card-title">All Leave Request</div>
             </div>
                <div class="card-body">
                <div class="row mb-3">

                    <div class="col-md-3">
                        <label>From Date</label>
                        <input type="date" class="form-control" id="from_date">
                    </div>

                    <div class="col-md-3">
                        <label>To Date</label>
                        <input type="date" class="form-control" id="to_date">
                    </div>

                    <div class="col-md-3">
                        <label>Status</label>

                        <select class="form-control" id="status">
                            <option value="">All</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">

                        <button class="btn btn-primary me-2" id="filterBtn">
                            Filter
                        </button>

                        <button class="btn btn-secondary" id="resetBtn">
                            Reset
                        </button>

                    </div>

                </div>
                  <div class="table-responsive">
                  	<table class="table table-striped table-bordered bg-info data-table" id="leave-request-table">
                  	<thead>
                      <tr>
                       <th>#ID</th>
                       <th>Name</th>
                       <th>Code</th>
                       <th>Department</th>
                       <th>Designation</th>
                       <th>Issue Date</th>
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

 <div class="modal" id="ai-review-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">AI Review</h5>
        
      </div>
      <div class="modal-body">
        <div class="ai-result">
          <div class="ai-result-type"></div>
          <div class="ai-result-review"></div>
        </div>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-danger close-modal" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
 <script>
  $(document).ready(function(){
  	let leave_id;
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

                  d.from_date = $('#from_date').val();

                  d.to_date = $('#to_date').val();

                  d.status = $('#status').val();

                }


            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'employee_name', name: 'employee_name' },
                { data: 'employee_code', name: 'employee_code' },
                { data: 'department', name: 'department' },
                { data: 'designation', name: 'designation' },
                { data: 'issue_date', name: 'issue_date' },
                { data: 'from_date', name: 'from_date' },
                { data: 'to_date', name: 'to_date' },
                { data: 'leave_duration', name: 'leave_duration' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
    });


    $('#filterBtn').click(function(){

      leaveRequestTable.ajax.reload();

  });


    $('#resetBtn').click(function(){

      $('#from_date').val('');

      $('#to_date').val('');

      $('#status').val('');

      leaveRequestTable.ajax.reload();

  });


    window.socket.on("leave_request_created", function(data){

        console.log("Leave request received", data);

        leaveRequestTable.ajax.reload(null, false);

    });


    $(document).on('click', '.ai-review', function(e){

        e.preventDefault();



        leave_id = $(this).data('id');


        $('.ai-btn-txt-'+leave_id).html(`
                <button type="button" 
                    class="btn btn-info btn-sm action-button text-light ai-review" 
                    data-id="${leave_id}">
                    <i class="fa fa-spinner fa-spin"></i> Loading...
                </button>
            `);

        $.ajax({

            url: "{{ url('/ai-context') }}",

            type:"POST",

            dataType:"json",

            data:{'leave_id':leave_id},

            success:function(response){

              $('#ai-review-modal').modal('show');

              $('.ai-btn-txt-'+leave_id).html(`
                <button type="button" 
                    class="btn btn-info btn-sm action-button text-light ai-review" 
                    data-id="${leave_id}">
                    <i class="bi bi-robot"></i>
                </button>
            `);

              $('.ai-result-type').html(`
                  <h3>Recommend: ${response.data.type}</h3>
              `);

              $('.ai-result-review').html(`
                  <h3>Review</h3>
                  <p>${response.data.ai_review}</p>
              `);


              leaveRequestTable.ajax.reload(null,false);

                //toastr.success(data.message);

            }

        });

        

    });

    $(document).on('click', '.close-modal', function(e){
      e.preventDefault();
      $('.ai-result-type').text('');

      $('.ai-result-review').text('');
      $('#ai-review-modal').modal('hide');
    });

  });	
 </script>
@endpush
