<?php

include "../includes/conexao.php";

session_start();
if (isset($_POST['cat_pai'])) {
    $cat_pai = $_POST['cat_pai'];
    if ($cat_pai != '') {
        $sql = mysqli_query($con, "select * from categorias_contas where cat_pai='$cat_pai' and status='1'");
        if (mysqli_num_rows($sql) > 0) {
            echo "<div class=\"col-lg-2 col-md-3 col-sm-4 remover\">
		        <div class=\"form-group\">
			        <label>Subcategoria</label>
		            <select name=\"cat_pai\" class=\"form-control categoria\"  onchange=\"carregaSelect()\" required=\"\">";
            echo "<option value=''>Selecione uma Categoria</option>";
            while ($vetor = mysqli_fetch_array($sql)) {
                echo "<option value='".$vetor['id_catconta']."'>". $vetor['numeracao'] . ' - ' . $vetor['titulo']."</option>";
            }
            echo "</select>
            </div>
        </div>";
        }else{
            echo "0";
        }
    }else{
        echo "0";
    }
    die();
}
if (isset($_POST['produto'])) {
    $produto = $_POST['produto'];
    if ($produto != '') {
        $sql = mysqli_query($con, "select * from ficha_tecnica where cat_pai='$produto' and status='1' and categoria_fornecedor='0'");
        if (mysqli_num_rows($sql) > 0) {
            echo "<div class=\"col-lg-2 col-md-3 col-sm-4 remover\">
		        <div class=\"form-group\">
			        <label>Subcategoria</label>
		            <select name=\"produto\" class=\"form-control produto\" required=\"\">";
            echo "<option value=''>Selecione uma Categoria</option>";
            while ($vetor = mysqli_fetch_array($sql)) {
                echo "<option value='".$vetor['id_ficha']."'>".$vetor['titulo']."</option>";
            }
            echo "</select>
            </div>
        </div>";
        }else{
            echo "0";
        }
    }else{
        echo "0";
    }
    die();
}
if ($_SESSION['id'] == NULL) {

    echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";

} else {

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

        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

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
                    <a class="navbar-brand" href="inicio.php">
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
                                    src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>" alt="user"
                                    class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img
                                            src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"
                                            alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $vetor_cadastro['nome']; ?></h4>
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
                                    <li class="breadcrumb-item">Contas a Pagar</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cadastrar Categoria de
                                        Conta
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

                                <form action="recebe_fichatecnica.php" enctype="multipart/form-data" method="post">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-4">
                                            <div class="form-group">
                                                <label>Produto</label>
                                                <select id="produto" name="produto" class="form-control produto" required="">
                                                    <option value="0" selected="">Selecione um Produto</option>
                                                    <?php
                                                    $sql_contas = mysqli_query($con, "select * from ficha_tecnica where status='1' and cat_pai='0' order by titulo");
                                                    while ($vetor_contas = mysqli_fetch_array($sql_contas)) {
                                                        ?>
                                                        <option value="<?php echo $vetor_contas['id_ficha']; ?>"><?php echo $vetor_contas['titulo']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="fim2">
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-4">
                                            <button id="addCat" type="button" class="btn btn-md btn-success" onclick="carregaSelect2()" style="float: left;margin-top: 29px"><span><i class="fas fa-plus"></i></span> Subcategoria</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-4">
                                            <div class="form-group">
                                                <label>Tipologia</label>
                                                <select id="cat_pai_raiz" name="cat_pai" class="form-control categoria" required="" onchange="carregaSelect()">
                                                    <option value="0" selected="">Nenhuma</option>
                                                    <?php
                                                    $sql_contas = mysqli_query($con, "select * from categorias_contas where status='1' and cat_pai='0' order by numero");
                                                    while ($vetor_contas = mysqli_fetch_array($sql_contas)) {
                                                        ?>
                                                        <option value="<?php echo $vetor_contas['id_catconta']; ?>"><?php echo $vetor_contas['numeracao'] . ' - ' . $vetor_contas['titulo']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="fim">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-4">
                                            <div class="form-group">
                                                <label>Categoria De Fornecedor</label>
                                                <select name="cat_fornecedor" class="form-control">
                                                    <option value="0" selected="">Nenhuma</option>
                                                    <?php
                                                    $sql_fornecedor = mysqli_query($con, "select * from categoriafornecedor order by nome");
                                                    while ($vetor_fornecedor = mysqli_fetch_array($sql_fornecedor)) {
                                                        ?>
                                                        <option value="<?php echo $vetor_fornecedor['id_categoria']; ?>"><?php echo $vetor_fornecedor['nome']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" onclick="resetar()" class="btn btn-danger" style="float: left">Resetar</button>
                                    <br>
                                    <br>
                                    <button type="submit" class="btn btn-primary" style="float: left;">Cadastrar
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
        function carregaSelect() {
            $('.categoria').each(function () {
                var aux = $(this);
                var attr = aux.attr('disabled');
                if (!(typeof attr !== typeof undefined && attr !== false) && this.value != '') {
                    var fd = new FormData();
                    fd.append('cat_pai', this.value);
                    $.ajax({
                        url: 'cadastrar_fichatecnica.php',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response != '0') {
                                $('#fim').before(response);
                                aux.attr('disabled','disabled');
                            }
                        },
                    });
                }
            });

        }
        function carregaSelect2() {
            $('.produto').each(function () {
                var aux = $(this);
                var attr = aux.attr('disabled');
                if (!(typeof attr !== typeof undefined && attr !== false) && this.value != '') {
                    var fd = new FormData();
                    fd.append('produto', this.value);
                    $.ajax({
                        url: 'cadastrar_fichatecnica.php',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response != '0') {
                                $('#fim2').before(response);
                                aux.attr('disabled','disabled');
                            }else{
                                $('#addCat').attr('disabled','disabled');
                            }
                        },
                    });
                }
            });

        }

        function resetar() {
            $('.remover').each(function () {
                this.remove();
            });
            $('#cat_pai_raiz').val("0");
            $('#produto').val("0");
            $('#addCat').removeAttr('disabled');
            $('#cat_pai_raiz').removeAttr("disabled");
            $('#produto').removeAttr("disabled");
            $('#cat_fornecedor').val("0");
        }
    </script>
    </body>

    </html>
<?php } ?>