<div>
  @if(user()->id == admin()->id)
    <script>
    $(document).ready(function () {

        let socket = io("{{ config('services.socket.url') }}", {
            transports: ["websocket"]
        });

        let Admin_ID = "{{ user()->id }}";

        let countNotification = parseInt("{{ count(unReadNotifications()) }}");

        socket.on("connect", function () {

            console.log("Connected:", socket.id);

            socket.emit("join_admin_room", Admin_ID);

        });

        socket.on("leave_request_created", function (data) {

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

        socket.on("disconnect", function (reason) {

            console.log("Disconnected:", reason);

        });

        socket.on("connect_error", function (err) {

            console.log("Connect Error:", err.message);

        });

    });
    </script>
  @endif
</div> 