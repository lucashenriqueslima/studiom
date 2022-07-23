<?php
include "../includes/conexao.php";
date_default_timezone_set('America/Sao_Paulo');
session_start();
$id_pagina = 47;
if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
} else {
    $sql_permissao = mysqli_query($con, "select listar from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
    $vetor_permissao = mysqli_fetch_array($sql_permissao);
    if ($vetor_permissao['listar'] != 2) {
        echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
    }
    $vetor_banco = mysqli_fetch_array(mysqli_query($con, "select ambiente, urlhomologacao, urlproducao from banco where id_banco = '1'"));
    if ($vetor_banco['ambiente'] == 1) {
        $urlbase = $vetor_banco['urlhomologacao'];
    }
    if ($vetor_banco['ambiente'] == 2) {
        $urlbase = $vetor_banco['urlproducao'];
    }
    if ($vetor_permissao['listar'] == 2) {
        ?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../layout/assets/images/favicon.png">
    <title>Studio M Fotografia</title>
    <!-- Custom CSS -->
    <link href="../layout/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="../layout/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../layout/assets/extra-libs/horizontal-timeline/horizontal-timeline.css" rel="stylesheet">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <!-- Custom CSS -->
    <link href="../layout/dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../layout/assets/libs/select2/dist/css/select2.min.css">
    <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
    <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>

.ajax_load {
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 2000;
}

.ajax_load_box {
    margin: auto;
    text-align: center;
    color: #ffffff;
    font-weight: bold;
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.5);
}

.ajax_load_box_circle {
    border: 16px solid #e3e3e3;
    border-top: 16px solid #4e73df;
    border-radius: 50%;
    margin: auto;
    width: 80px;
    height: 80px;

    -webkit-animation: spin 1.2s linear infinite;
    -o-animation: spin 1.2s linear infinite;
    animation: spin 1.2s linear infinite;
}

.ajax_load_box_title {
    margin-top: 15px;
    font-weight: bold;
}

@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
    }
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
.bg-secondary, .bg-light {
transition: all .5s linear;
transform: translateY(0px);
opacity: 1;
}

    </style>

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
    <div id="loader" class="ajax_load">
                <div class="ajax_load_box">
                    <div class="ajax_load_box_circle"></div>
                    <div class="ajax_load_box_title">Aguarde, carrengando...</div>
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
                                width="110px" />
                            <img src="../layout/assets/images/logo-icon.png" alt="homepage" class="light-logo"
                                width="50px" />
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
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <ul class="list-style-none">
                                    <li>
                                        <div class="drop-title bg-primary text-white">
                                            <h4 class="m-b-0 m-t-5">4 New</h4>
                                            <span class="font-light">Notifications</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="message-center notifications">
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-danger btn-circle"><i
                                                        class="fa fa-link"></i></span>
                                                <div class="mail-contnet">
                                                    <h5 class="message-title">Luanch Admin</h5> <span
                                                        class="mail-desc">Just see the my new admin!</span>
                                                    <span class="time">9:30 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-success btn-circle"><i
                                                        class="ti-calendar"></i></span>
                                                <div class="mail-contnet">
                                                    <h5 class="message-title">Event today</h5> <span
                                                        class="mail-desc">Just a reminder that you have event</span>
                                                    <span class="time">9:10 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-info btn-circle"><i class="ti-settings"></i></span>
                                                <div class="mail-contnet">
                                                    <h5 class="message-title">Settings</h5> <span class="mail-desc">You
                                                        can customize this template as you want</span>
                                                    <span class="time">9:08 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-primary btn-circle"><i class="ti-user"></i></span>
                                                <div class="mail-contnet">
                                                    <h5 class="message-title">Pavan kumar</h5> <span
                                                        class="mail-desc">Just see the my admin!</span> <span
                                                        class="time">9:02 AM</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center m-b-5 text-dark" href="javascript:void(0);">
                                            <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>" alt="user"
                                    class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>"
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
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Financeiro</a></li>
                                    <li class="breadcrumb-item">Cobrança</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Régua de Cobrança</li>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 container"
                                        style="margin-bottom: 0px !important;">
                                        <form method="post" action="https://localhost/studiomfotografia/api/regua-cobranca/save-regua-cobranca">
                                        <button type="button" class="btn waves-effect waves-light btn-success mt-3"
                                            onclick="addFormReminder()">
                                            <i class="fas fa-plus"></i> Adicionar Lembrete
                                        </button>
                                        <button type="submit" id="save-alteracoes" class="btn waves-effect waves-light btn-info mt-3">
                                            <i class="far fa-save"></i> Salvar Mudanças
                                        </button>
                                        <div id="forms-reminder" class="mt-5">
                                            
                                        </div>
                                        </form>
                                        <section class="cd-horizontal-timeline pt-5">
                                            <div class="timeline">
                                                <div class="events-wrapper">
                                                    <div class="events"style="top: 30px;">
                                                        <ol>
                                                        
                                                        </ol>
                                                        <span class="filling-line" aria-hidden="true"></span>
                                                    </div>
                                                    <!-- .events -->
                                                </div>
                                                <!-- .events-wrapper -->
                                                <ul class="cd-timeline-navigation">
                                                    <li><a href="#0" class="prev inactive">Prev</a></li>
                                                    <li><a href="#0" class="next"> Próximo </a></li>
                                                </ul>
                                                <!-- .cd-timeline-navigation -->
                                            </div>
                                        </section>
                                    </div>
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
    <script src="../layout/assets/libs/select2/dist/js/select2.min.js"></script>
    <!--chartjs -->
    <script src="../layout/dist/js/pages/dashboards/dashboard1.js"></script>
    <script src="../layout/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../layout/assets/libs/moment/min/moment.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../layout/assets/extra-libs/horizontal-timeline/horizontal-timeline-regua.js"></script>


        <script defer>
            initReguaCobranca()

    function initReguaCobranca() {

        fetch(`https://localhost/studiomfotografia/api/regua-cobranca/get-regua-cobranca`, {
                        method: 'GET',
                    }).then((response) => {
                    response.json().then((data) => {
                    dados = data
                    }).then(() => {
                       
                    dados.forEach(element => {
                        addFormReminder(element, element.dia)
                        addLiOnInit(element.dia)
                    })
                    initTimeline($('.cd-horizontal-timeline'))

                    document.querySelector("#forms-reminder").querySelectorAll("input, textarea, select").forEach((e) => {
                        e.disabled = true
                    })
                })
            })
    }

    window.addEventListener("beforeunload", function(event) { 
        event.preventDefault();
        event.returnValue = "Mensagem de aviso"; 
    return "Mensagem de aviso";
    });
        </script>

    <script>





const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})



function showMoreForm(e) {

    let row = e.parentNode.parentNode.parentNode.parentNode

    if (e.value != "formando") {
        row.querySelector("#colaboradorForm").hidden = false
        row.querySelector("#formandoForm").hidden = true

        row.querySelector("#formandoForm").querySelectorAll("input, textarea, select").forEach((e) => {
            e.value = ""
            e.checked = false
        })

        return
    }

    row.querySelector("#colaboradorForm").hidden = true
    row.querySelector("#formandoForm").hidden = false

    row.querySelector("#colaboradorForm").querySelectorAll("input, textarea, select").forEach((e) => {
        e.value = ""
    })

}



function addReminder(e) {

    let row = e.parentNode.parentNode.parentNode.parentNode

    console.log(row)

    let forms = row.querySelectorAll("input, textarea, select")

    for(let i = 0; i < forms.length; i++) {
        if (forms[i].value == "" && forms[i].dataset.required == 'true') {
            
            Toast.fire({
            icon: 'warning',
            title: 'Favor preencha todos os campos obrigatórios'
            })

            return
        }
    }

    let day = row.querySelector("#day").value

    let a_created = document.querySelector(".cd-horizontal-timeline").querySelectorAll('[data-date]')

    let a_created_dates = checkRepeatDay(day, a_created)

    if (a_created_dates === false) {
    
        Toast.fire({
        icon: 'warning',
        title: 'Já existe um lembrete para esse dia'
        })
        return
    }

    row.querySelector(".btn-success").hidden = true
    row.querySelector(".btn-warning").hidden = false

    disableActivateForms(row, true)
    
    addLi(day, a_created, a_created_dates)

    initTimeline($('.cd-horizontal-timeline'))
    

    row.id = `form-day-${day}`

    Toast.fire({
        icon: 'success',
        title: 'Lembrete adicionado com sucesso'
        })
}

function updateReminder(e) {

    let row = e.parentNode.parentNode.parentNode.parentNode
    
    document.querySelector(`[data-date='${row.querySelector("#day").value}']`).remove()
    row.querySelector(".btn-success").hidden = false
    row.querySelector(".btn-warning").hidden = true
    disableActivateForms(row, false)
    
    }

    function deleteReminder(e) {
        let row = e.parentNode.parentNode.parentNode.parentNode

        if(document.querySelector(`[data-date='${row.querySelector("#day").value}']`) != null) {
            document.querySelector(`[data-date='${row.querySelector("#day").value}']`).remove()
        }

        row.remove()

        initTimeline($('.cd-horizontal-timeline'))
    }


    function addLi(day, a_created, a_created_dates) {
        let new_li = document.createElement("li")
        new_li.innerHTML = `<a data-date="${day}" data-move="#form-day-${day}" onclick="rollToForm(this)">${day}</a>`

        if(a_created_dates.length == 0){
            document.querySelector(".events").querySelector("ol").appendChild(new_li)
            return
        } 

        for(let i = 0; i <= a_created_dates.length -2; i++) {
            if (day > a_created_dates[i] && day < a_created_dates[i+1]) {
                a_created[i].parentNode.after(new_li)
                return
            }
        }

        if(day > a_created_dates[a_created_dates.length - 1]) {
            a_created[a_created_dates.length - 1].parentNode.after(new_li)
            return
        }

        a_created[0].parentNode.parentNode.insertBefore(new_li, a_created[0].parentNode)

    }

    function addLiOnInit(day) {

        let new_li = document.createElement("li")
        new_li.innerHTML = `<a data-date="${day}" data-move="#form-day-${day}" onclick="rollToForm(this)">${day}</a>`

        if(document.querySelector(".cd-horizontal-timeline").querySelectorAll('[data-date]').length == 0){
            document.querySelector(".events").querySelector("ol").appendChild(new_li)
            return
        }
        document.querySelector(".events").querySelector("ol").lastChild.after(new_li)
    }

function disableActivateForms(row, isToDisabled) {

    if (isToDisabled) {

        row.querySelectorAll("input, textarea, select").forEach((e) => {
        e.disabled = true
        })

        return
    }

    row.querySelectorAll("input, textarea, select").forEach((e) => {
        e.disabled = false
    })
}

function checkRepeatDay(day, a_created) {

    let a_created_dates = []

    for(let i = 0; i <= a_created.length - 1; i++) {
        
        if(a_created[i].dataset.date == day){
            return false
        }

        a_created_dates.push(parseInt(a_created[i].dataset.date))
    }


    return a_created_dates
}

function addFormReminder(data = null, day = null) {

    let new_form_reminder = document.createElement("div")
    
    new_form_reminder.className = "bg-light"

    if(day != null){
        console.log(day)
    new_form_reminder.setAttribute('id',`form-day-${day}`) 
    }

    if(data == null) {

    new_form_reminder.innerHTML = `<hr>
                                            <div class="row pt-2">
                                                <div class="col-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="reminder_name">Nome do Lembrete:</label>
                                                        <input type="text" name="reminder_names[]" class="form-control" data-required="true"
                                                            id="reminder_name">
                                                    </fieldset>
                                                </div>
                                                <div class="col-2">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                            for="day">Dia:</label>
                                                        <input type="number" name="days[]" id="day" class="form-control"
                                                            name="days[]" data-required="true">
                                                    </fieldset>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>Destinatário</label>
                                                        <select name="destinatarys[]"
                                                            class="form-control" data-required="true" onchange="showMoreForm(this)">
                                                            <option disabled selected value> Selecione o destinatário
                                                            </option>
                                                            <option value="formando">Formando
                                                            </option>
                                                            <option value="colaborador">Colaborador</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-2" style="margin-top: 28px">
                                                    <div class="form-group ml-4">
                                                        <button type="button"
                                                            onclick="addReminder(this)" class="btn btn-success" id="conclude_reminder">
                                                            Concluir
                                                        </button>
                                                        <button type="button" hidden 
                                                            onclick="updateReminder(this)" class="btn btn-warning">
                                                            Editar
                                                        </button>
                                                        <button type="button" 
                                                            onclick="deleteReminder(this)" class="btn btn-danger">
                                                            Excluir
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row mt-3" id="formandoForm" hidden>
                                                <div class="col-5">
                                                    <div class="form-group">

                                                        <label>Whatsapp:</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" data-required="false"
                                                                 data-required="false" name="is_to_send_bill_by_wpp[]" id="is_to_send_bill_by_wpp">
                                                            <label class="form-check-label mb-1">
                                                                Enviar Boleto por Whatsapp?
                                                            </label>
                                                        </div>
                                                        <textarea class="form-control rounded-0" placeholder="Insira a mensagem que será enviada via Whatsapp"
                                                            data-required="false" rows="4" name="wpp_messages[]"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <label>Email: </label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" data-required="false"
                                                             name="is_to_send_bill_by_email[]" id="is_to_send_bill_by_email">
                                                            <label class="form-check-label mb-1">
                                                                Enviar Boleto por Email?
                                                            </label>
                                                        </div>
                                                        <textarea class="form-control rounded-0" placeholder="Insira a mensagem que será enviada via Email"
                                                            id="exampleFormControlTextarea1" data-required="false" rows="4" name="email_messages[]"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3 row justify-content-center" id="colaboradorForm" hidden>
                                                <div class="col-5">
                                                    <div class="form-group">

                                                        <label for="exampleFormControlTextarea1">Mensagem via Sistema</label>
                                                        <div class="form-check">
                                                        </div>
                                                        <textarea class="form-control rounded-0" placeholder="Insira a mensagem que será enviada via sistema"
                                                        data-required="false" rows="4" name="colaborador_messages[]"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr class="mt-3">`

    } else {

        console.log(data.mensagem_colaborador)

        new_form_reminder.innerHTML = `<hr>
                                            <div class="row pt-2">
                                                <div class="col-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="reminder_name">Nome do Lembrete:</label>
                                                        <input type="text" name="reminder_names[]" class="form-control" data-required="true"
                                                            id="reminder_name" value="${data.nome_lembrete}">
                                                    </fieldset>
                                                </div>
                                                <div class="col-2">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                            for="day">Dia:</label>
                                                        <input type="number" name="days[]" id="day" class="form-control"
                                                            name="days[]" data-required="true" value="${data.dia}">
                                                    </fieldset>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>Destinatário</label>
                                                        <select name="destinatarys[]"
                                                            class="form-control" data-required="true" onchange="showMoreForm(this)">
                                                            <option disabled value> Selecione o destinatário
                                                            </option>
                                                            <option ${data.destinatario == '1' ? 'selected' : ''} value="formando">Formando
                                                            </option>
                                                            <option ${data.destinatario == '0' ? 'selected' : ''} value="colaborador">Colaborador</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-2" style="margin-top: 28px">
                                                    <div class="form-group ml-4">
                                                        <button type="button"  hidden 
                                                            onclick="addReminder(this)" class="btn btn-success" id="conclude_reminder">
                                                            Concluir
                                                        </button>
                                                        <button type="button"
                                                            onclick="updateReminder(this)" class="btn btn-warning">
                                                            Editar
                                                        </button>
                                                        <button type="button" 
                                                            onclick="deleteReminder(this)" class="btn btn-danger">
                                                            Excluir
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row mt-3" id="formandoForm" ${data.destinatario == '1' ? '' : 'hidden'}>
                                                <div class="col-5">
                                                    <div class="form-group">

                                                        <label>Whatsapp:</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" data-required="false"
                                                                 data-required="false" name="is_to_send_bill_by_wpp[]" id="is_to_send_bill_by_wpp" ${data.enviar_boleto_wpp == '1' ? 'checked' : ''}>
                                                            <label class="form-check-label mb-1">
                                                                Enviar Boleto por Whatsapp?
                                                            </label>
                                                        </div>
                                                        <textarea class="form-control rounded-0" placeholder="Insira a mensagem que será enviada via Whatsapp"
                                                            data-required="false" rows="4" name="wpp_messages[]">${data.mensagem_wpp}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <label>Email: </label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" data-required="false"
                                                             name="is_to_send_bill_by_email[]" id="is_to_send_bill_by_email" ${data.enviar_boleto_email == '1' ? 'checked' : ''}>
                                                            <label class="form-check-label mb-1">
                                                                Enviar Boleto por Email?
                                                            </label>
                                                        </div>
                                                        <textarea class="form-control rounded-0" placeholder="Insira a mensagem que será enviada via Email"
                                                         data-required="false" rows="4" name="email_messages[]">${data.mensagem_email}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3 row justify-content-center" id="colaboradorForm" ${data.destinatario == '0' ? '' : 'hidden'}>
                                                <div class="col-5">
                                                    <div class="form-group">

                                                        <label for="exampleFormControlTextarea1">Mensagem via Sistema</label>
                                                        <div class="form-check">
                                                        </div>
                                                        <textarea class="form-control rounded-0" placeholder="Insira a mensagem que será enviada via sistema"
                                                        data-required="false" rows="4" name="colaborador_messages[]">${data.mensagem_colaborador}</textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr class="mt-3">`
    }
                                            document.querySelector("#forms-reminder").appendChild(new_form_reminder)
                
}

    function rollToForm(e){
    var hash = e.dataset.move

    console.log(hash)

    $('html, body').animate({
    scrollTop: $(hash).offset().top
    }, 800, function(){
    window.location.hash = hash;
    });
    document.querySelector(hash).classList.remove("bg-light")
    document.querySelector(hash).classList.add("bg-secondary")
    setTimeout(() => {
        document.querySelector(hash).classList.remove("bg-secondary")
        document.querySelector(hash).classList.add("bg-light")
    }, "2000")
    
}

function ajax_load(action) {
    ajax_load_div = $(".ajax_load");

    if (action === "open") {
        ajax_load_div.fadeIn(400).css("display", "flex");
    }

    if (action === "close") {
        ajax_load_div.fadeOut(600);
    }
}

$("form").submit(function (e) {

    e.preventDefault();

    let verifyFormsConcludes = document.querySelectorAll("#conclude_reminder")
    
    for(let i = 0; i < verifyFormsConcludes.length; i++){
        if(verifyFormsConcludes[i].hidden == false){
            
            Toast.fire({
            icon: 'warning',
            title: 'Favor conclua todos lembretes'
            })
            return
        }
    }

    let count_email = 0
    let count_wpp = 0

    document.querySelectorAll("#is_to_send_bill_by_email").forEach(function (e) {
        e.name = `${e.id}[${count_email}]`
        count_email++
    })

    document.querySelectorAll("#is_to_send_bill_by_wpp").forEach(function (e) {
        e.name = `${e.id}[${count_wpp}]`
        count_wpp++
    })

    document.querySelector("#forms-reminder").querySelectorAll("input, textarea, select").forEach((e) => {
        e.disabled = false
    })

    

    var form = $(this);
    var action = form.attr("action")
    var data = form.serialize();

    $.ajax({
        url: action,
        data: data,
        type: "post",
        dataType: "json",
        beforeSend: function (load) {
             ajax_load("open");
        },
        success: function (su) {

             ajax_load("close");

            setTimeout(function() {

            if (su.message) {
                Toast.fire({
                    icon: su.message.icon,
                    title: su.message.message
            })
                return;
            }
        
        }, 800)
    }
        
    });

    document.querySelector("#forms-reminder").querySelectorAll("input, textarea, select").forEach((e) => {
        e.disabled = true
    })
})



    </script>

</body>

</html>
<?php }
} ?>