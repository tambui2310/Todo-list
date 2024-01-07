<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Todo list</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet'
        href='https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css'>
    <link rel="stylesheet" href="./public/style.css">

</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="p-5">
        <h2 class="mb-4">
            Todo list
        </h2>
        <div class="card">
            <div class="card-body p-0">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <!-- calendar modal -->
    <div id="modal-view-event" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="update-event" method="post">
                    <div class="modal-body">
                        <h4>Add Event Detail</h4>
                        <div class="form-group">
                            <label>Event name</label>
                            <input id="update-title" type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Event Date</label>
                            <input id="update-event-date" type='text' class="datetimepicker form-control"
                                name="event_date" required>
                        </div>
                        <div class="form-group">
                            <label>Task Status</label>
                            <select id="update-status" class="form-control" name="status">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="delete-task" class="btn btn-danger">Delete</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-view-event-add" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="add-event" method="post">
                    <div class="modal-body">
                        <h4>Add Task Detail</h4>
                        <div class="form-group">
                            <label>Task name</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Event Date</label>
                            <input type='text' class="datetimepicker form-control" name="event_date" required>
                        </div>
                        <div class="form-group">
                            <label>Task Status</label>
                            <select class="form-control" name="status">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- partial -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js'></script>

</body>

</html>
<script>
    var currentClickDate = '';
    var id;
    jQuery(document).ready(function () {
        jQuery('.datetimepicker').datepicker({
            timepicker: true,
            language: 'en',
            range: true,
            multipleDates: true,
            multipleDatesSeparator: " - "
        });
        jQuery("#add-event").submit(function () {
            var values = {};
            $.each($('#add-event').serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            $.ajax({
                url: 'tasks/createTask',
                type: 'POST',
                data: values,
                dataType: 'json',

                success: function (response) {
                    console.log(response);
                },

                error: function (xhr, status, error) {
                }
            });
        });
        jQuery("#update-event").submit(function () {
            var values = {};
            $.each($('#update-event').serializeArray(), function (i, field) {
                values[field.name] = field.value;
                values['id'] = id;
            });
            $.ajax({
                url: 'tasks/updateTask',
                type: 'POST',
                data: values,
                dataType: 'json',

                success: function (response) {
                    console.log(response);
                },

                error: function (xhr, status, error) {
                }
            });
        });
        jQuery("#delete-task").click(function () {
            console.log(123);
            var values = {};
            values['id'] = id;
            $.ajax({
                url: 'tasks/deleteTask',
                type: 'POST',
                data: values,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                },

                error: function (xhr, status, error) {
                }
            });
        });
    });

    (function () {
        'use strict';
        // ------------------------------------------------------- //
        // Calendar
        // ------------------------------------------------------ //
        jQuery(function () {
            // page is ready
            jQuery('#calendar').fullCalendar({
                themeSystem: 'bootstrap4',
                // emphasizes business hours
                businessHours: false,
                defaultView: 'month',
                // event dragging & resizing
                editable: true,
                // header
                header: {
                    left: 'title',
                    center: 'month,agendaWeek,agendaDay',
                    right: 'today prev,next'
                },
                events: <?php echo $data["tasks"]; ?>,
                eventRender: function (event, element) {
                    if (event.icon) {
                        element.find(".fc-title").prepend("<i class='fa fa-" + event.icon + "'></i>");
                    }
                },
                dayClick: function (e) {
                    currentClickDate = e._d;
                    jQuery('#modal-view-event-add').modal();
                },
                eventClick: function (event, jsEvent, view) {
                    console.log(event);
                    jQuery('.event-icon').html("<i class='fa fa-" + event.icon + "'></i>");
                    jQuery('.event-title').html(event.title);
                    jQuery('.event-body').html(event.description);
                    jQuery('.eventUrl').attr('href', event.url);
                    jQuery('#modal-view-event').modal();
                    document.getElementById('update-title').value = event.title;
                    document.getElementById('update-status').value = event.status;
                    document.getElementById('update-event-date').value = moment(event.start).format('MM/DD/YYYY hh:mm a') + " - " + moment(event.end).format('MM/DD/YYYY hh:mm a');
                    id = event.id;
                },
            })
        });

    })(jQuery);
</script>