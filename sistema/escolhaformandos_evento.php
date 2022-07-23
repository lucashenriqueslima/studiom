<?php
include "../includes/conexao.php";
session_start();
$id_pagina = 47;
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
}else {
	$vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from usuarios where id_usuario = '$_SESSION[id]'"));
	$id_evento = $_GET['id_evento'];
	$id = $_GET['id'];
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

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
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
                        <!--                          <h4 class="page-title">Financeiro</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Projetos</a></li>
                                    <li class="breadcrumb-item">Gestão de Projetos</a></li>
                                    <li class="breadcrumb-item">Alterar Projeto</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Escolher Formando por
                                        Evento
                                    </li>
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

                                <ul class="nav nav-tabs" role="tablist">

                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                            href="#semevento"
                                                            role="tab"><span class="hidden-xs-down">Formandos Sem o Evento</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#comevento"
                                                            role="tab"><span class="hidden-xs-down">Formandos Com o Evento</span></a>
                                    </li>


                                </ul>

                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="semevento" role="tabpanel">

                                        <br>
                                        <div class="table-responsive">
                                            <table id="tabela" class="table table-striped table-bordered display"
                                                   style="width:100%">
                                                <thead align="center">
                                                <tr>
                                                    <th><h5><strong>Formando</strong></h5></th>
                                                    <th width="15%"><h5><strong>Ação</strong></h5></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr id="tr" hidden>
                                                    <td></td>
                                                    <td>
                                                        <button type="button"
                                                                class="btn btn-primary btn-block"
                                                                style="    float: left;"
                                                                onclick="enviaFormando()">
                                                            Fazer Pasta
                                                        </button>
                                                    </td>
                                                </tr>
																								<?php
																								$sql_atual = mysqli_query($con, "select * from formandos f2 where f2.turma='$id' and f2.id_formando not in (select f.id_formando from formandos f left join eventosformando ef on ef.id_formando = f.id_formando left join eventos_turma_lista etl on etl.id_evento_turma = ef.id_evento_turma_lista where f.turma = '$id' and ef.id_evento_turma_lista = '$id_evento') order by nome ASC") ;
																								while ($vetor = mysqli_fetch_array($sql_atual)) {
																									?>
                                                    <tr id="tr<?php echo $vetor['id_formando'] ?>">
                                                        <td><?php echo $vetor['nome']; ?></td>
                                                        <td>
                                                            <button type="button"
                                                                    class="btn btn-primary btn-block"
                                                                    style="    float: left;"
                                                                    onclick="enviaFormando(<?php echo $vetor['id_formando'] ?>)">
                                                                Fazer Pasta
                                                            </button>
                                                        </td>
                                                    </tr>
																								
																								<?php } ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="comevento" role="tabpanel">
                                        <br>
                                        <div class="table-responsive">
                                            <table id="tabela2" class="table table-striped table-bordered display"
                                                   style="width:100%">
                                                <thead align="center">
                                                <tr>
                                                    <th><h5><strong>Formando</strong></h5></th>
                                                    <th width="15%"><h5><strong>Ação</strong></h5></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr id="tr" hidden>
                                                    <td></td>
                                                    <td align="center">
                                                        <button type="button"
                                                                class="btn btn-danger btn-block"
                                                                style="float: left;"
                                                                onclick="removeFormando()">
                                                            Remover
                                                            Pasta
                                                        </button>
                                                    </td>
                                                </tr>
																								<?php
																								$sql_atual = mysqli_query($con, "select f.* from formandos f left join eventosformando ef on ef.id_formando = f.id_formando left join eventos_turma_lista etl on etl.id_evento_turma = ef.id_evento_turma where f.turma = '$id' and ef.id_evento_turma_lista = '$id_evento' ORDER BY f.nome");
																								while ($vetor = mysqli_fetch_array($sql_atual)) {
																									?>
                                                    <tr id="tr<?php echo $vetor['id_formando'] ?>">
                                                        <td><?php echo $vetor['nome']; ?></td>
                                                        <td align="center">
                                                            <button type="button"
                                                                    class="btn btn-danger btn-block"
                                                                    style="float: left;"
                                                                    onclick="removeFormando(<?php echo $vetor['id_formando'] ?>)">
                                                                Remover
                                                                Pasta
                                                            </button>
                                                        </td>
                                                    </tr>
																								<?php } ?>
                                                </tbody>
                                            </table>

                                        </div>
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

    <script type="text/javascript">

        function enviaFormando(id) {
            $.post('recebe_escolhaformandoevento.php?id=' + id + '&id_evento=<?php echo $id_evento; ?>');
            var clone = document.getElementById("tr" + id).cloneNode(true);
            var botao = document.getElementById("tabela2").lastElementChild.firstElementChild.lastElementChild.innerHTML;
            clone.lastElementChild.innerHTML = botao;
            clone.lastElementChild.firstElementChild.setAttribute("onclick", "removeFormando('" + id + "')");
            $("#tr" + id).remove();
            $('#tabela2 tr:last').after(clone);
        }

        function removeFormando(id) {
            $.post('recebe_escolhaformandoevento.php?id=' + id + '&reverte=sim&id_evento=<?php echo $id_evento; ?>');
            var clone = document.getElementById("tr" + id).cloneNode(true);
            var botao = document.getElementById("tabela").lastElementChild.firstElementChild.lastElementChild.innerHTML;
            clone.lastElementChild.innerHTML = botao;
            clone.lastElementChild.firstElementChild.setAttribute("onclick", "enviaFormando('" + id + "')");
            $("#tr" + id).remove();
            $('#tabela tr:last').after(clone);
        }
    </script>
    </body>

    </html>
	<?php
} ?>