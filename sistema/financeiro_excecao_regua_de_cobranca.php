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
    <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../layout/dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../layout/assets/libs/select2/dist/css/select2.min.css">
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link
      href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css"
      rel="stylesheet"
    />     
    <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
    <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <script src="../js/utils/reqs.js"></script>

    <style>
        .gridjs-table {
            width: 100% !important;
        }

        .gridjs-th-content {
            white-space: pre;
        }

        ::selection {
            color: #fff;
            background: #664AFF;
        }

        .wrapper {
            max-width: 450px !important;
            margin: 80px auto;
        }

        .wrapper .search-input {
            background: #fff;
            width: 100%;
            border-radius: 5px;
            position: relative;
            box-shadow: 0px 1px 5px 3px rgba(0, 0, 0, 0.12);
        }

        .search-input input {
            height: 55px;
            width: 100%;
            outline: none;
            border: none;
            border-radius: 5px;
            padding: 0 60px 0 20px;
            font-size: 18px;
            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.2);
        }

        .search-input.active-box input {
            border-radius: 5px 5px 0 0;
        }

        .search-input .autocom-box {
            padding: 0;
            opacity: 0;
            pointer-events: none;
            max-height: 280px;
            overflow-y: auto;
            border-radius: 5px;
            border: #efefef 1px solid;
           
        }

        .search-input.active-box .autocom-box {
            opacity: 1;
            pointer-events: auto;
        }

        .autocom-box li {
            list-style: none;
            padding: 15px;
            display: none;
            width: 100%;
            cursor: pointer;
            border-radius: 3px;
            font-size: 20px;
            text-transform: uppercase;

        }

        .autocom-box li:hover {
            background: #e0e0e0 !important;
        }

        a {
            text-decoration: none;
            color: #000;
        }

        .search-input.active-box .autocom-box li {
            display: block;
        }

        .autocom-box li:hover {
            background: #efefef;
        }

        .search-input .icon {
            position: absolute;
            right: 0px;
            top: 0px;
            height: 55px;
            width: 55px;
            text-align: center;
            line-height: 55px;
            font-size: 20px;
            color: #644bff;
        }

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
                                    <li class="breadcrumb-item" aria-current="page">Exceções de Cobrança</li>
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

                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addeModalTitle"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="addModalContent">
                <form method="post" id="addExcecaoForm">
                    <input type="text" id="is-formando-input" value="" name="is_formando" hidden>
                    <div class="input-group py-3">
                        <label class="input-group-text" for="inputGroupSelect01">Motivo</label>
                        <select class="form-control" id="motivo" name="motivo" required>
                            <option selected disabled value>Escolher...</option>
                            <?php
                                $sql_atual = mysqli_query($con, "select * from motivos_excecao_cobranca order by id_motivo_excecao_cobranca ASC");
                                while ($vetor = mysqli_fetch_array($sql_atual)) {
                            ?>
                            <option value="<?=$vetor["id_motivo_excecao_cobranca"]?>"><?=$vetor["motivo"]?></option>
                            <?php } ?>
                        </select>
                        </div>

                        <div class="input-group py-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">Observação</span>
                            </div>
                            <textarea id="observacao" name="observacao" class="form-control"></textarea>
                        </div>
                        <div class="row px-2 py-3" id="col-servicos">
                            <span class="input-group-text col-2" id="">Serviços</span>
                            <div class="col-10 border d-flex justify-content-around align-items-center" id="group-col-servicos" style="font-size: 15px;">
                                <div class="col-3" id="col-fotografia">
                                    <div class="form-check py-2">
                                        <input class="form-check-input" type="checkbox" value="" id="fotografia" name="fotografia" data-target="input-parcelas-fotografia">
                                        <label class="form-check-label" for="fotografia">
                                            Fotografia
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3" id="col-convite">
                                    <div class="form-check py-2">
                                        <input class="form-check-input" type="checkbox" value="" id="convite" name="convite" data-target="input-parcelas-convite">
                                        <label class="form-check-label" for="convite">
                                            Convite
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3" id="col-ensaio">
                                    <div class="form-check py-2">
                                        <input class="form-check-input" type="checkbox" value="" id="ensaio" name="ensaio" data-target="input-parcelas-ensaio">
                                        <label class="form-check-label" for="ensaio">
                                            Ensaio
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row px-2 py-3" id="input-parcelas">
                            <span class="input-group-text col-2">Parcelas</span>
                            <div class="col-10 border d-flex justify-content-around align-items-center"
                                style="font-size: 15px;">
                                <div class="col-3" id="input-parcelas-fotografia">

                                </div>
                                <div class="col-3" id="input-parcelas-convite">
                                    
                                </div>
                                <div class="col-3" id="input-parcelas-ensaio">
                                    
                                </div>

                            </div>
                        </div>



                    
                
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-icon-split" type="button" data-dismiss="modal">
                        <span class="icon text-white-50">
                            <i class="fas fa-times"></i>
                        </span>
                        <span class="text">Cancelar</span>
                    </button>
                    <button class="btn btn-success btn-icon-split" id="addModalButton" type="submit">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Adicionar</span>
                    </button>
                </div>
                
            </div>
        </div>
        </form>
    </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="wrapper"></div>
                                <div class="search-input">
                                    <a href="" target="_blank" hidden></a>
                                    <input type="text" placeholder="Digite para pesquisar...">
                                    <div class="autocom-box">
                                    </div>
                                </div>
                                    <div id="table-js-excecoes" class="mt-5"></div>
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
    <!--c3 charts -->
    <script src="../layout/assets/extra-libs/c3/d3.min.js"></script>
    <script src="../layout/assets/extra-libs/c3/c3.min.js"></script>
    <!--chartjs -->
    <script src="../layout/assets/libs/chart.js/dist/Chart.min.js"></script>
    <script src="../layout/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../layout/dist/js/pages/datatable/datatable-basic.init.js"></script>
    <script src="../layout/assets/libs/moment/min/moment.min.js"></script>
    <script src="../js/utils/alert.js"></script>
    <script>


function excluiExcecao(e) {



$.ajax({
    url: `https://www.studiomfotografia.com.br/api/regua-cobranca/delete-excecao-regua-cobranca`,
    data: {
        id_excecao: e.dataset.id
    },
    type: "post",
    dataType: "json",

    success: function (su) {
        console.log(su)

        setTimeout(function () {

            if (su.message) {

                Toast.fire({
                    icon: su.message.icon,
                    title: su.message.message
                })
            }

        }, 800)

        setTimeout(function () {
            location.reload()
        }, 1200)
    }
});
}


        (() => {

            drawExcecoesTable()

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


            const searchWrapper = document.querySelector(".search-input");
            const inputBox = searchWrapper.querySelector("input");
            const suggBox = searchWrapper.querySelector(".autocom-box");
        
            let linkTag = searchWrapper.querySelector("a");
            let webLink;

            fetch("https://www.studiomfotografia.com.br/api/regua-cobranca/get-formandos-faculdades", {
                method: 'GET'
            })
            .then((response) => {
                response.json().then((data) => {

                    inputBox.onkeyup = (e) => {
                        let userData = e.target.value;
                        let emptyArray = [];
                        if (userData) {
                            emptyArray = data.filter((data) => {

                                return data.descricao.toLocaleLowerCase().includes(userData.toLocaleLowerCase());
                            });
                            emptyArray = emptyArray.map((data) => {

                                return data = `<li data-id="${data.id}" data-isformando="${data.is_formando}" style="background: ${data.is_formando == '0' ? '#eeeeee' : ''}"> ${data.descricao}</li>`;
                            });
                            searchWrapper.classList.add("active-box");
                            showSuggestions(emptyArray);
                            let allList = suggBox.querySelectorAll("li");
                        } else {
                            searchWrapper.classList.remove("active-box");
                        }
                    }

                })
            })

            $('#addModal').on('hide.bs.modal', function (event) {
                clickedItem.classList.remove("bg-secondary");
            })
            
            //abre Modal
            document.querySelector(".autocom-box").addEventListener('click', (e) => {
                
                clickedItem = e.target;
                
                if (clickedItem.tagName != "LI") {
                    return
                }

                let modal = document.querySelector("#addModal");

                modal.querySelector("#col-servicos").querySelectorAll(".col-3").forEach((item) => {
                    item.hidden = true
                })
                modal.querySelector("#input-parcelas").querySelectorAll(".col-3").forEach((item) => {
                        item.hidden = true
                })

                modal.querySelector("#input-parcelas").hidden = true

                document.querySelector("#input-parcelas").querySelectorAll(".col-3").forEach((item) => {
                    item.innerHTML = ''
                })

                document.querySelector("#col-servicos").querySelectorAll('input[type="checkbox"]').forEach((item) => {
                    item.checked = false
                })
                
                document.querySelector("#observacao").value = ''



                clickedItem.classList.add("bg-secondary");
                
                
                modal.querySelector(".modal-header").innerText = clickedItem.innerText;

                if(clickedItem.dataset.isformando != '1') {

                    //Caso Faculdade

                    document.querySelector("#is-formando-input").value = '0'

                    document.querySelector("#col-servicos").querySelectorAll('input[type="checkbox"]').forEach((item) => {
                        item.value = clickedItem.dataset.id
                    })

                fetch(`https://www.studiomfotografia.com.br/api/regua-cobranca/get-tipo-contrato-by-turma-id?id_turma=${clickedItem.dataset.id}`, {
                    method: 'GET'
                }).then((response) => {
                        
                        response.json().then((data) => {
                            
                            data.forEach((tipo_vendas) => {

                                switch(tipo_vendas.tipo){
                                    case '1':
                                        modal.querySelector("#col-convite").hidden = false                                        
                                    break

                                    case '2':
                                        modal.querySelector("#col-fotografia").hidden = false
                                    break

                                    case '4':
                                        modal.querySelector("#col-ensaio").hidden = false
                                    break
                                    }
                            })
                                

                        })

                    })
                    
                }else{

                    document.querySelector("#is-formando-input").value = '1'

                    modal.querySelector("#input-parcelas").hidden = false

                    fetch(`https://www.studiomfotografia.com.br/api/regua-cobranca/get-tipo-venda-by-formando-id?id_formando=${clickedItem.dataset.id}`, {
                        method: 'GET'
                    }).then((response) => {
                        response.json().then((data) => {
                            
                            console.log(data)
                            
                            let parcelasFotografia = filterArrayByDescricao(data, "Fotografia")
                            let parcelasConvite = filterArrayByDescricao(data, "Convite")
                            let parcelasEnsaio = filterArrayByDescricao(data, "Ensaio")

                            if(parcelasFotografia.length){
                                modal.querySelector("#col-fotografia").hidden = false
                                data.forEach((item) => {
                                    createCheckBoxParcelas(item, modal.querySelector("#input-parcelas-fotografia"))
                                })
                            }

                            if(parcelasConvite.length){
                                modal.querySelector("#col-convite").hidden = false
                                data.forEach((item) => {
                                    createCheckBoxParcelas(item, modal.querySelector("#input-parcelas-convite"))
                                })
                            }

                            if(parcelasEnsaio.length){
                                modal.querySelector("#col-ensaio").hidden = false
                                data.forEach((item) => {
                                    createCheckBoxParcelas(item, modal.querySelector("#input-parcelas-convite"))
                                })
                            }
                        })
                    })

                }
                
                $('#addModal').modal('show');
            
            })

            //Mostra parcelas
            document.querySelector("#group-col-servicos").querySelectorAll('input[type="checkbox"]').forEach((item) => {
                item.addEventListener('change', (e) => {
                    if(e.target.checked){
                        document.querySelector(`#${e.target.dataset.target}`).hidden = false
                        return
                    }

                    document.querySelector(`#${e.target.dataset.target}`).hidden = true
                    document.querySelector(`#${e.target.dataset.target}`).querySelectorAll('input[type="checkbox"]').forEach((item) => {
                        item.checked = false
                    })
                })
            })
            


                $(window).on("load", function(){


                $("form").submit(function (e) {
                    e.preventDefault();

                    

                    var form = $(this);
                    var action = `https://www.studiomfotografia.com.br/api/regua-cobranca/save-excecoes-regua-cobranca`;
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

                            console.log(su)

                            ajax_load("close");

                            setTimeout(function() {

                            if (su.message) {


                                Toast.fire({
                                    icon: su.message.icon,
                                    title: su.message.message
                                    })
                                    
                                    
                                

                                $('#addModal').modal('hide');

                                document.querySelector(".search-input").classList.remove("active-box")
                            }


                        }, 800)
                        setTimeout(function() {
                        location.reload()
                    }, 1500)
                        }
        });

        function ajax_load(action) {
            ajax_load_div = $(".ajax_load");

            if (action === "open") {
                ajax_load_div.fadeIn(400).css("display", "flex");
            }

            if (action === "close") {
                ajax_load_div.fadeOut(600);
            }
        }
    });

            })

            function showSuggestions(list) {
                let listData;
                if (!list.length) {
                    userValue = inputBox.value;
                    listData = `<li style="pointer-events: none">Nenhum resultado encontrado...</li>`;
                } else {
                    listData = list.join('');
                }
                suggBox.innerHTML = listData;
            }

            function filterArrayByDescricao(array, value){
                let filtered = [];
                for(var i = 0; i < array.length; i++){

                    var obj = array[i];

                    for(var key in obj){
                        if(obj['descricao_tipo_venda'] == value){
                            filtered.push(obj['descricao_tipo_venda']);
                        }
                    }

                }    

                return filtered;

            }

            function createCheckBoxParcelas(data, element) {
                let checkBoxParcelasModel = document.createElement("div")
        checkBoxParcelasModel.innerHTML = `<div class="form-check py-2">
                                                <input class="form-check-input" type="checkbox" value="${data.id_item}" id="${data.id_item}" name="parcela[]">
                                                    <label class="form-check-label" for="${data.id_item}">
                                                        ${data.parcela}
                                                    </label>
                                            </div>`

                element.appendChild(checkBoxParcelasModel)
            }


function drawExcecoesTable(){

                document.getElementById("table-js-excecoes").innerHTML = ''

    new gridjs.Grid({

        language: {
            search: {
            placeholder: 'Procurar...'
            },
            pagination: {
            previous: 'Anterior',
            next: 'Próximo',
            navigate: (page, pages) => `Página ${page} de ${pages}`,
            page: (page) => `Página ${page}`,
            showing: 'Mostrando ',
            of: 'entre',
            to: 'a',
            results: 'resultados',
            },
            loading: 'Carrregando...',
                noRecordsFound: 'Nenhum registro encontrado',
            error: 'Erro ao conectar a base de dados',
        },

        style: {

            th: {
            'text-align': 'center'
            },
            td: {
            'text-align': 'center'
            }
        },

        columns: ['Cód Contrato', 'Serviço', 'Parcela', 'Valor', 'Motivo', 'Observações', 'Ação'],
        pagination: {
        enabled: true,
        limit: 10,
        },
        search: true,
        sort: true,

        server: {
    url: `https://www.studiomfotografia.com.br/api/regua-cobranca/get-excecoes-regua-cobranca`,
        then: data => data.map(excecoes => [
            excecoes.id_item, excecoes.tipo_venda, excecoes.parcela, excecoes.valor, excecoes.motivo, excecoes.observacao, 
            gridjs.html(`
            <button id="exclui-excecao"
                type="button" class="btn btn-danger"
                title="Excluir Excecao"
                onclick="excluiExcecao(this)" data-id="${excecoes.id_excecao}">
            <span style="pointer-event: none"><i class="fas fa-times fa-lg"></i></span>
        </button>                
            `)
        ]),
} 
}).render(document.getElementById("table-js-excecoes"));
            }
        })()


    

    </script>
</body>

</html>

<?php }
} ?>