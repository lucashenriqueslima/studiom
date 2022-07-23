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
            <link
      href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css"
      rel="stylesheet"
    />            
            <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
            <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                $(document).ready(function ($) {
                    $('#valor_recebido').mask('###.###,##', {reverse: true});
                    $('#valor_pago').mask('###.###,##', {reverse: true});
                    $('#valor_gerado').mask('###.###,##', {reverse: true});
                });
            </script>

            <style>
                .gridjs-table{
                    width: 100% !important;
                }
                .gridjs-th-content{
                    white-space: nowrap;
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
                           aria-controls="navbarSupportedContent" aria-expanded="false"
                           aria-label="Toggle navigation"><i
                                    class="ti-more"></i></a>
                    </div>
                    <div class="navbar-collapse collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav float-left mr-auto">
                            <li class="nav-item d-none d-md-block"><a
                                        class="nav-link sidebartoggler waves-effect waves-light"
                                        href="javascript:void(0)"
                                        data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                        </ul>
                        <ul class="navbar-nav float-right">
                            <!-- Comment -->
                            <!-- ============================================================== -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle waves-effect waves-dark" href=""
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                            class="mdi mdi-bell font-24"></i>
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
                                                        <span class="time">9:30 AM</span></div>
                                                </a>
                                                <!-- Message -->
                                                <a href="javascript:void(0)" class="message-item">
                                                    <span class="btn btn-success btn-circle"><i class="ti-calendar"></i></span>
                                                    <div class="mail-contnet">
                                                        <h5 class="message-title">Event today</h5> <span
                                                                class="mail-desc">Just a reminder that you have event</span>
                                                        <span class="time">9:10 AM</span></div>
                                                </a>
                                                <!-- Message -->
                                                <a href="javascript:void(0)" class="message-item">
                                                    <span class="btn btn-info btn-circle"><i
                                                                class="ti-settings"></i></span>
                                                    <div class="mail-contnet">
                                                        <h5 class="message-title">Settings</h5> <span class="mail-desc">You can customize this template as you want</span>
                                                        <span class="time">9:08 AM</span></div>
                                                </a>
                                                <!-- Message -->
                                                <a href="javascript:void(0)" class="message-item">
                                                    <span class="btn btn-primary btn-circle"><i
                                                                class="ti-user"></i></span>
                                                    <div class="mail-contnet">
                                                        <h5 class="message-title">Pavan kumar</h5> <span
                                                                class="mail-desc">Just see the my admin!</span> <span
                                                                class="time">9:02 AM</span></div>
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            <a class="nav-link text-center m-b-5 text-dark" href="javascript:void(0);">
                                                <strong>Check all notifications</strong> <i
                                                        class="fa fa-angle-right"></i> </a>
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
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Financeiro</a></li>
                                        <li class="breadcrumb-item">Cobrança</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Relatório de Cobrança</li>
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

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 "
                                             style="margin-bottom: 0px !important;">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="input-group my-3">
                                    <input type="date" id="data-filtro" value="<?=date('Y-m-d')?>">
                                    </div>
                                    <div class="table-responsive my-5">
                                    <h3 class="text-center mt-3">Projeção de Envios</h2>
                                        <div id="table-js-relatorio"></div>
                                    </div>
                                    
                                    <div class="table-responsive my-5">
                                    <h3 class="text-center mt-3">Mensagens não Enviadas</h2>
                                        <div id="table-js-nao-enviados"></div>
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
        <!--chartis chart-->
        <script src="../layout/assets/libs/chartist/dist/chartist.min.js"></script>
        <script src="../layout/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
        <!--c3 charts -->
        <script src="../layout/assets/extra-libs/c3/d3.min.js"></script>
        <script src="../layout/assets/extra-libs/c3/c3.min.js"></script>
        <!--chartjs -->
        <script src="../layout/assets/libs/chart.js/dist/Chart.min.js"></script>
        <script src="../layout/dist/js/pages/dashboards/dashboard1.js"></script>
        <script src="../layout/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../layout/dist/js/pages/datatable/datatable-basic.init.js"></script>
        <script src="../layout/assets/libs/moment/min/moment.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        </body>
        </html>

        <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>

        <script>
        const relatorioTable = new gridjs.Grid({
            fixedHeader: true,
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

            columns: ['Cód Formando', 'Nome', 'Telefone', 'Parcela', 'Valor', 'Data', 'Mensagem Wpp', 'Status', 'Boleto'],
            pagination: {
                enabled: true,
                limit: 10,
            },
            search: true,
            sort: true,

            server: {
                url: 'http://localhost/studiomfotografia/api/scripts/get-regua-cobranca-to-script?passwd=a)()8***0--asf',
                then: data => data.map(relatorio => [
                    relatorio.id, relatorio.nome_formando, relatorio.telefone, relatorio.parcela_atual, relatorio.valor, `${relatorio.data_vencimento} ${relatorio.datedif}`, relatorio.mensagem_wpp, gridjs.html(`<span class="${relatorio.id_lembrete_regua_cobranca_erro ? "text-danger" : "text-success"}">${relatorio.id_lembrete_regua_cobranca_erro ? "Não Enviado" : "Enviado/Pendente"}</span>`), gridjs.html(`<a href="${relatorio.boleto_wpp ? relatorio.boleto_wpp : ""}">${relatorio.boleto_wpp ? 'Ver Boleto' : 'Sem Boleto'}</a>`)
                ]),
            }
        }).render(document.getElementById("table-js-relatorio"));

        const relatorioErrosTable = new gridjs.Grid({
            fixedHeader: true,
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

            columns: ['Cód Formando', 'Nome', 'Telefone', 'Parcela', 'Motivo'],
            pagination: {
                enabled: true,
                limit: 10,
            },
            search: true,
            sort: true,

            server: {
                url: 'http://localhost/studiomfotografia/api/scripts/get-erros-regua-cobranca?passwd=a)()8***0--asf',
                then: data => data.map(relatorio => [
                    relatorio.cod_formando, relatorio.nome_formando, relatorio.telefone, relatorio.parcela, relatorio.motivo
                ]),
            }
        }).render(document.getElementById("table-js-nao-enviados"));


    document.querySelector("#data-filtro").onchange = () => {
        relatorioTable.updateConfig({
            server: {
                url: `http://localhost/studiomfotografia/api/scripts/get-regua-cobranca-to-script?passwd=a)()8***0--asf&data-filtro=${document.querySelector("#data-filtro").value}`,
                then: data => data.map(relatorio => [
                    relatorio.id, relatorio.nome_formando, relatorio.telefone, relatorio.parcela_atual, relatorio.valor, `${relatorio.data_vencimento} ${relatorio.datedif}`, relatorio.mensagem_wpp, gridjs.html(`<span class="${relatorio.id_lembrete_regua_cobranca_erro ? "text-danger" : "text-success"}">${relatorio.id_lembrete_regua_cobranca_erro ? "Não Enviado" : "Enviado/Pendente"}</span>`), gridjs.html(`<a href="${relatorio.boleto_wpp ? relatorio.boleto_wpp : ""}" class="${relatorio.boleto_wpp ? "text-success" : "text-danger"}">${relatorio.boleto_wpp ? 'Ver Boleto' : 'Sem Boleto'}</a>`)
                ]),
            }
        }).forceRender()

        relatorioErrosTable.updateConfig({
            server: {
                url: `http://localhost/studiomfotografia/api/scripts/get-erros-regua-cobranca?passwd=a)()8***0--asf&data-filtro=${document.querySelector("#data-filtro").value}`,
                then: data => data.map(relatorio => [
                    relatorio.id, relatorio.nome_formando, relatorio.telefone, relatorio.parcela_atual, relatorio.valor, `${relatorio.data_vencimento} ${relatorio.datedif}`, relatorio.mensagem_wpp, gridjs.html(`<a href="${relatorio.boleto_wpp ? relatorio.boleto_wpp : ""}" class="${relatorio.boleto_wpp ? "text-success" : "text-danger"}">${relatorio.boleto_wpp ? 'Ver Boleto' : 'Sem Boleto'}</a>`)
                ]),
            }
        }).forceRender()
    }

        </script>
    <?php }
} ?>        





