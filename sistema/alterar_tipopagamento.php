<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
    $id_tipo_pagamento = $_GET['alterar'];
    $vetor_pagamento = mysqli_fetch_array(mysqli_query($con,"select * from tipos_pagamento where id_tipo_pagamento='$id_tipo_pagamento'"));
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
        <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function ($) {
                $('#valor').mask('#.###,##', {reverse: true});
                $('#porcentagem').mask('##,##%');
            });
            $(document).ready(function () {
                $('#tipo').change(function () {
                    if(this.value == 'receita'){
                        $('#libera-receita').removeAttr('hidden');
                    }else{
                        $('#libera-receita').attr('hidden','hidden');
                    }
                });
                $('#taxa').change(function () {
                    if (this.value == '1') {
                        $('#liberaTaxa').removeAttr('hidden');
                    } else {
                        $('#liberaTaxa').attr('hidden', 'hidden');
                    }
                });
            });
        </script>
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
                        <!--                        <h4 class="page-title">PCP</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">PCP</a></li>
                                    <li class="breadcrumb-item">Cadastros</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Novo Fomento</li>
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
                                <form action="recebe_tipopagamento.php" method="post"
                                      enctype="multipart/form-data" id="formID">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Tipo</label>
                                                <select id="tipo" name="tipo" class="form-control" required>
                                                    <option value="despesa" <?php echo ($vetor_pagamento['tipo'] == 'despesa'?'selected=""':''); ?>>Despesa</option>
                                                    <option value="receita" <?php echo ($vetor_pagamento['tipo'] == 'despesa'?'':'selected=""'); ?>>Receita</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Nome</label>
                                                <input type="text" class="form-control" name="nome" value="<?php echo $vetor_pagamento['nome']; ?>" required>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Conta</label>
                                                <select name="conta" class="form-control" required>
																									<?php
																									$sql = mysqli_query($con, "select * from contas where status = 1");
																									while ($vetor = mysqli_fetch_array($sql)) {
																										echo "<option value='".$vetor['id_conta']."' " . ($vetor_pagamento['id_conta'] == $vetor['id_conta'] ?'selected=""':'') . ">".$vetor['nome']."</option>";
																									}
																									?>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Forma de
                                                    Pagamento</label>
                                                <select name="formapag" class="form-control" required>
																									<?php
																									$sql = mysqli_query($con, "select * from formaspag where status = 1");
																									while ($vetor = mysqli_fetch_array($sql)) {
																										echo "<option value='".$vetor['id_forma']."' " . ($vetor_pagamento['id_forma'] == $vetor['id_forma']?'selected=""':'') . ">".$vetor['nome']."</option>";
																									}
																									?>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Qtd.
                                                    Parcelas</label>
                                                <input type="number" name="qtdparcelas" class="form-control" value="<?php echo $vetor_pagamento['qtd_parcelas']; ?>">
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div id="libera-receita" <?php echo ($vetor_pagamento['tipo'] == 'receita'?'':'hidden'); ?>>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Compensação
                                                        (dias)</label>
                                                    <input type="number" name="compensacao" class="form-control" value="<?php echo $vetor_pagamento['compensacao']; ?>">
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Taxa?</label>
                                                    <select name="taxa" id="taxa" class="form-control">
                                                        <option value="0" <?php echo ($vetor_pagamento['tipo'] == 'receita'?'':'selected=""'); ?>>Não</option>
                                                        <option value="1" <?php echo ($vetor_pagamento['tipo'] == 'receita'?'selected=""':''); ?>>Sim</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row" id="liberaTaxa" <?php echo ($vetor_pagamento['tipo'] == 'receita'?'':'hidden'); ?>>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Taxa - Porcentagem</label>
                                                    <input type="text" id="porcentagem" name="porcentagem" class="form-control" value="<?php echo number_format( $vetor_pagamento['porcentagem'], 2, ",", "." ) . '%'; ?>">
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Taxa - Valor Fixo</label>
                                                    <input type="text" id="valor" name="valor" class="form-control"  value="<?php echo 'R$' . number_format( $vetor_pagamento['valor'], 2, ",", "." ); ?>">
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary" style="    float: left;">Salvar
                                    </button>

                                </form>
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
    </body>

    </html>
<?php } ?>