@extends('admin_master')

@section('content')
 <main class="app-main">
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">All Leave</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Leave</li>
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
               <div class="card-header bg-primary text-light"><div class="card-title">All Leave</div></div>
                <div class="card-body">
               
                  <div class="table-responsive">
                    <a href="{{route('leaves.create')}}" class="btn btn-success float-end"><i class="fa fa-plus"></i> Add New Leave</a><br/><br/>
                  	<table class="table table-striped table-bordered bg-info" id="leave-table">
                  	<thead>
                      <tr>
                       <th>#ID</th>
                       <th>From Date</th>
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

    let leave_id;

    var leaveTable = $('#leave-table').DataTable({
        searching: true,
        processing: true,
        serverSide: true,
        ordering: false,
        responsive: true,
        stateSave: true,
        ajax: {
            url: "{{ route('leaves.index') }}"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'from_date', name: 'from_date' },
            { data: 'to_date', name: 'to_date' },
            { data: 'leave_duration', name: 'leave_duration' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable:false, searchable:false }
        ]
    });


    $(document).on('click', '.delete-leave', function(e){

        e.preventDefault();

        leave_id = $(this).data('id');

        if(confirm('Do you want to delete this leave?')){

            $.ajax({

                url: "{{ url('/leaves') }}/" + leave_id,

                type:"DELETE",

                dataType:"json",

                success:function(data){

                    leaveTable.ajax.reload(null,false);

                    toastr.success(data.message);

                }

            });

        }

    });


    // Socket Check
    if(window.socket){

        window.socket.on("leave_status_updated", function(data){

            console.log("Leave Status received", data);


            leaveTable.ajax.reload(null,false);

        });

    }else{

        console.log("Socket not initialized");

    }


});
</script>
@endpush