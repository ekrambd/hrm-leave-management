<div>

@if(user()->id == admin()->id)

<script>
$(document).ready(function () {

    window.socket = io("{{ config('services.socket.url') }}", {
        transports: ["websocket"]
    });


    let Admin_ID = "{{ user()->id }}";

    let countNotification = parseInt("{{ count(unReadNotifications()) }}");


    window.socket.on("connect", function () {

        console.log("Connected:", window.socket.id);

        window.socket.emit("join_admin_room", Admin_ID);

    });


    window.socket.on("leave_request_created", function (data) {

        countNotification++;

        $('.count-notification').text(countNotification);


        $.get("{{ route('notifications.latest') }}", function (data) {

            let html = '';

            $.each(data, function(index, row){

                html += `
                    <div class="dropdown-divider"></div>

                    <a href="/notification-read/${row.id}" class="dropdown-item">

                        <i class="bi bi-people-fill me-2"></i>

                        ${row.data.title}

                        <span class="float-end text-secondary fs-7">
                            just now
                        </span>

                    </a>
                `;

            });


            $('.noitification-lists').html(html);

        });


        toastr.success(data.message);

    });


    window.socket.on("disconnect", function(reason){

        console.log("Disconnected:", reason);

    });


    window.socket.on("connect_error", function(err){

        console.log("Connect Error:", err.message);

    });


});
</script>


@else


<script>
$(document).ready(function () {


    window.socket = io("{{ config('services.socket.url') }}", {
        transports: ["websocket"]
    });


    let User_ID = "{{ user()->id }}";


    let countNotification = parseInt("{{ count(unReadNotifications()) }}");


    window.socket.on("connect", function () {

        console.log("Connected:", window.socket.id);


        // এখানে admin room না
        window.socket.emit("join_user_room", User_ID);

    });



    window.socket.on("leave_status_updated", function(data){


        console.log("Leave Status Updated", data);


        countNotification++;


        $('.count-notification').text(countNotification);



        $.get("{{ route('notifications.latest') }}", function(data){


            let html = '';


            $.each(data, function(index,row){


                html += `

                <div class="dropdown-divider"></div>

                <a href="/notification-read/${row.id}" class="dropdown-item">

                    <i class="bi bi-people-fill me-2"></i>

                    ${row.data.title}

                    <span class="float-end text-secondary fs-7">
                        just now
                    </span>

                </a>

                `;


            });


            $('.noitification-lists').html(html);


        });



        toastr.success(data.message);


    });



    window.socket.on("disconnect", function(reason){

        console.log("Disconnected:", reason);

    });



    window.socket.on("connect_error", function(err){

        console.log("Connect Error:", err.message);

    });



});
</script>


@endif

</div>