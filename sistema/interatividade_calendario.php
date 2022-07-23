<?php
include "../includes/conexao.php";
session_start();

if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
} else {

    $sql = mysqli_query($con, "select id_departamento,corcalendario from departamentos");
    $auxDepto = array();
    while ($vetor_departamento = mysqli_fetch_array($sql)) {
        $auxDepto[$vetor_departamento['id_departamento']] = $vetor_departamento['corcalendario'];
    }
    if (!isset($dashboard)) {
        $sql = mysqli_query($con, "select id_calendario,departamento,titulo,descricao,data,datafim,hora,horafim from calendario where titulo <> 'Outros'");
    } else {
        $sql = mysqli_query($con, "select id_calendario,departamento,titulo,descricao,data,datafim,hora,horafim from calendario where departamento='" . $_SESSION['departamento'] . "' and titulo <> 'Outros'");
    }

    ?>
    <!DOCTYPE html>
    <html dir="ltr" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="../layout/assets/images/favicon.png">
        <title>Studio M Fotografia</title>
        <!-- Custom CSS -->
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
    </head>

    <body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                                class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="dashboard.php">
                        <b class="logo-icon">

                            <img src="../layout/assets/images/logo-2.png" alt="homepage" class="dark-logo"
                                 width="110px"/>

                            <img src="../layout/assets/images/logo-icon.png" alt="homepage" class="light-logo"
                                 width="50px"/>
                        </b>

                    </a>

                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                       data-toggle="collapse" data-target="#navbarSupportedContent"
                       aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                                class="ti-more"></i></a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                    class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                    data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>


                    </ul>

                    <ul class="navbar-nav float-right">


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                        src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>" alt="user"
                                        class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img
                                                src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>"
                                                alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $_SESSION['nome']; ?></h4>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="sair.php"><i class="fa fa-power-off m-r-5 m-l-5"></i>
                                    Sair</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include "includes/menu.php"; ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <!--                        <h4 class="page-title">Interatividade</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <?php if (!isset($dashboard)) { ?>
                                        <li class="breadcrumb-item">Interatividades</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Calendário</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active" aria-current="page">Dashbord</li>
                                    <?php } ?>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <?php if (!isset($dashboard)) { ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Departamento</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <select name="categoria" id="categoria" class="form-control"
                                                            required>
                                                        <option value="999" selected="selected">Todos os Departamentos
                                                        </option>
                                                        <?php
                                                        $sql_categorias = mysqli_query($con, "select * from departamentos order by nome ASC");
                                                        while ($vetor_categoria = mysqli_fetch_array($sql_categorias)) { ?>
                                                            <option value="<?php echo $vetor_categoria['id_departamento']; ?>"><?php echo $vetor_categoria['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div id="calendar"></div>
                                    <div id="carregaModal"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer text-center">
                Todos direitos reservados. <a href="https://studiomfotografia.com.br">Studio M Fotografia</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->

    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="../layout/dist/js/app.min.js"></script>
    <!-- minisidebar -->
    <script>
        $(function () {
            "use strict";
            $("#main-wrapper").AdminSettings({
                Theme: false, // this can be true or false ( true means dark and false means light ),
                Layout: 'vertical',
                LogoBg: 'skin5', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                NavbarBg: 'skin5', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarType: 'mini-sidebar', // You can change it full / mini-sidebar / iconbar / overlay
                SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarPosition: false, // it can be true / false ( true means Fixed and false means absolute )
                HeaderPosition: false, // it can be true / false ( true means Fixed and false means absolute )
                BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid )
            });
        });
    </script>
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
                    $('#carregaModal').load('interatividades_auxModal.php?id=' + calEvent.id, function () {
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
                    <?php while($evento = mysqli_fetch_array($sql)){ ?>
                    {
                        id: '<?php echo $evento['id_calendario']; ?>',
                        title: '<?php echo $evento['titulo']; ?>',
                        start: '<?php echo $evento['data'] . ' ' . $evento['hora']; ?>',
                        backgroundColor: '<?php echo $auxDepto[$evento['departamento']]; ?>',
                        end: '<?php echo $evento['datafim'] . ' ' . $evento['horafim']; ?>',
                        departamento: '<?php echo $evento['departamento']; ?>'
                    },
                    <?php } ?>
                ];
                var $this = this;
                $this.$calendarObj = $this.$calendar.fullCalendar({
                    slotDuration: '00:15:00',
                    /* If we want to split day time each 15minutes */
                    minTime: '08:00:00',
                    maxTime: '19:00:00',
                    defaultView: 'month',
                    handleWindowResize: true,
                    displayEventTime: false,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
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
                    <?php if (!isset($dashboard)) { ?>
                    eventRender: function eventRender(event, element, view) {
                        return ['999', event.departamento].indexOf($('#categoria').val()) >= 0
                    },
                    <?php } ?>
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