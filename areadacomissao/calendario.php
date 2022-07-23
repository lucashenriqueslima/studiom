<?php

include "../includes/conexao.php";

session_start();

if ($_SESSION['id_formando'] == NULL && $_SESSION['comissao'] == NULL) {

    echo "<script language=\"JavaScript\">
	location.href=\"inicio.php\";
	</script>";

} else {

    if ($_SESSION['comissao'] != 2) {

        echo "<script language=\"JavaScript\">
  location.href=\"inicio.php\";
  </script>";

    }
    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$_SESSION[id_formando]'"));
    $vetor_turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '$vetor_cadastro[turma]'"));

    $sql = mysqli_query($con, "select * from calendario a, eventos_turma b where a.id = b.id_evento and b.id_turma = '$vetor_cadastro[turma]'");
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title></title>
        <link href="../layout/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
        <link href="../layout/assets/extra-libs/c3/c3.min.css" rel="stylesheet">

        <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../layout/dist/css/style.min.css" rel="stylesheet">

        <link rel="stylesheet" href="../layout/bower_components/fullcalendar/dist/fullcalendar.min.css">
        <link rel="stylesheet" href="../layout/bower_components/fullcalendar/dist/fullcalendar.print.min.css"
              media="print">

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

        <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
        <style type="text/css">
            .img-circle {
                border-radius: 50%;
            }

            .portlet.calendar .fc-event .fc-time {
                color: #000000;
            }

            .fc-day-grid-event > .fc-content {
                white-space: inherit;
            }
        </style>

    </head>
    <body>

    <section class="content">

        <div class="row">

            <!-- /.col -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div id="calendar"></div>
                        <div id="carregaModal"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>

    </section>

    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="../layout/dist/js/app.min.js"></script>
    <script src="../layout/dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../layout/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../layout/assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../layout/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../layout/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../layout/dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="../layout/assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../layout/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 charts -->
    <script src="../layout/assets/extra-libs/c3/d3.min.js"></script>
    <script src="../layout/assets/extra-libs/c3/c3.min.js"></script>
    <!--chartjs -->
    <script src="../layout/assets/libs/chart.js/dist/Chart.min.js"></script>
    <script src="../layout/dist/js/pages/dashboards/dashboard1.js"></script>

    <!--This page JavaScript -->
    <script src="../layout/assets/libs/moment/min/moment.min.js"></script>
    <script src="../layout/assets/libs/fullcalendar/dist/fullcalendar.min.js"></script>
    <!--<script src="../layout/dist/js/pages/calendar/cal-init.js"></script>-->
    <script src='../layout/assets/libs/fullcalendar/dist/locale/pt-br.js'></script>

    <script>
        !function ($) {
            "use strict";

            var CalendarApp = function () {
                this.$body = $("body")
                this.$calendar = $('#calendar'),
                    this.$event = ('#calendar-events div.calendar-events'),
                    this.$categoryForm = $('#add-new-event form'),
                    this.$extEvents = $('#calendar-events'),
                    this.$modal = $('#my-event'),
                    this.$saveCategoryBtn = $('.save-category'),
                    this.$calendarObj = null
            };

            /* on drop */
            CalendarApp.prototype.onDrop = function (eventObj, date) {
                var $this = this;
                s
                // retrieve the dropped element's stored Event Object
                var originalEventObject = eventObj.data('eventObject');
                var $categoryClass = eventObj.attr('data-class');
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);
                // assign it the date that was reported
                copiedEventObject.start = date;
                if ($categoryClass)
                    copiedEventObject['className'] = [$categoryClass];
                // render the event on the calendar
                $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    eventObj.remove();
                }
            },
                /* on click on event */
                CalendarApp.prototype.onEventClick = function (calEvent, jsEvent, view) {
                    $('#carregaModal').load('calendario_auxModal.php?id=' + calEvent.id,function () {
                        $('#myModal').modal('show');
                    });



                    // var $this = this;
                    // var form = $("<form></form>");
                    // form.append("<label>Change event name</label>");
                    // form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success waves-effect waves-light'><i class='fa fa-check'></i> Save</button></span></div>");
                    // $this.$modal.modal({
                    //     backdrop: 'static'
                    // });
                    // $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
                    //     $this.$calendarObj.fullCalendar('removeEvents', function (ev) {
                    //         return (ev._id == calEvent._id);
                    //     });
                    //     $this.$modal.modal('hide');
                    // });
                    // $this.$modal.find('form').on('submit', function () {
                    //     calEvent.title = form.find("input[type=text]").val();
                    //     $this.$calendarObj.fullCalendar('updateEvent', calEvent);
                    //     $this.$modal.modal('hide');
                    //     return false;
                    // });
                },
                /* on select */
                CalendarApp.prototype.onSelect = function (start, end, allDay) {
                    var $this = this;
                    $this.$modal.modal({
                        backdrop: 'static'
                    });
                    var form = $("<form></form>");
                    form.append("<div class='row'></div>");
                    form.find(".row")
                        .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div></div>")
                        .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>")
                        .find("select[name='category']")
                        .append("<option value='bg-danger'>Danger</option>")
                        .append("<option value='bg-success'>Success</option>")
                        .append("<option value='bg-primary'>Primary</option>")
                        .append("<option value='bg-info'>Info</option>")
                        .append("<option value='bg-warning'>Warning</option></div></div>");
                    $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                        form.submit();
                    });
                    $this.$modal.find('form').on('submit', function () {
                        var title = form.find("input[name='title']").val();
                        var beginning = form.find("input[name='beginning']").val();
                        var ending = form.find("input[name='ending']").val();
                        var categoryClass = form.find("select[name='category'] option:checked").val();
                        if (title !== null && title.length != 0) {
                            $this.$calendarObj.fullCalendar('renderEvent', {
                                title: title,
                                start: start,
                                end: end,
                                allDay: false,
                                className: categoryClass
                            }, true);
                            $this.$modal.modal('hide');
                        } else {
                            alert('You have to give a title to your event');
                        }
                        return false;

                    });
                    $this.$calendarObj.fullCalendar('unselect');
                },
                CalendarApp.prototype.enableDrag = function () {
                    //init events
                    $(this.$event).each(function () {
                        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                        // it doesn't need to have a start or end
                        var eventObject = {
                            title: $.trim($(this).text()) // use the element's text as the event title
                        };
                        // store the Event Object in the DOM element so we can get to it later
                        $(this).data('eventObject', eventObject);
                        // make the event draggable using jQuery UI
                        $(this).draggable({
                            zIndex: 999,
                            revert: true, // will cause the event to go back to its
                            revertDuration: 0 //  original position after the drag
                        });
                    });
                }
            /* Initializing */
            CalendarApp.prototype.init = function () {
                this.enableDrag();
                /*  Initialize the calendar  */
                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
                var form = '';
                var today = new Date($.now());
                // today.setDate(today.getDate() + 4);
                // + 84800000

                var Events = [
                    <?php
                    while($event = mysqli_fetch_array($sql)) {
                    ?>
                    {
                        id: '<?php echo $event['id_calendario']; ?>',
                        title: '<?php echo $event['titulo']; ?>',
                        start: '<?php echo $event['data'] . ' ' . $event['hora']; ?>',
                        backgroundColor: '#f1931e',
                        end: '<?php echo $event['datafim'] . ' ' . $event['horafim']; ?>',
                    },
                    <?php } ?>
                ]
                var $this = this;
                $this.$calendarObj = $this.$calendar.fullCalendar({
                    slotDuration: '00:15:00',
                    /* If we want to split day time each 15minutes */
                    minTime: '08:00:00',
                    maxTime: '19:00:00',
                    defaultView: 'month',
                    handleWindowResize: true,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    timeFormat: 'HH:mm -',
                    events: Events,
                    editable: true,
                    droppable: false, // this allows things to be dropped onto the calendar !!!
                    eventLimit: false, // allow "more" link when too many events
                    selectable: false,
                    drop: function (date) {
                        $this.onDrop($(this), date);
                    },
                    select: function (start, end, allDay) {
                        $this.onSelect(start, end, allDay);
                    },
                    eventRender: function eventRender(event, element, view) {
                        return ['999', event.departamento].indexOf($('#categoria').val()) >= 0
                    },
                    eventClick: function (calEvent, jsEvent, view) {
                        $this.onEventClick(calEvent, jsEvent, view);
                    }
                });
                //on new event
                this.$saveCategoryBtn.on('click', function () {
                    var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
                    var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
                    if (categoryName !== null && categoryName.length != 0) {
                        $this.$extEvents.append('<div class="calendar-events m-b-20" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-circle text-' + categoryColor + ' m-r-10" ></i>' + categoryName + '</div>')
                        $this.enableDrag();
                    }
                });
            },
                //init CalendarApp
                $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
        }
        (window.jQuery),

//initializing CalendarApp
            $(window).on('load', function () {
                $.CalendarApp.init();

            });
        $(document).ready(function () {
            $('#calendar').fullCalendar('rerenderEvents');
            $('#categoria').on('change', function () {
                $('#calendar').fullCalendar('rerenderEvents');
            });
        });

    </script>


    </body>
    </html>
<?php } ?>