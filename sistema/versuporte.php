<?php

include "../includes/conexao.php";

session_start();

if ($_SESSION['id'] == NULL) {

    echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";

} else {
    $id = $_GET['id'];
    $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);
    $sql = mysqli_query($con, "select * from suporte where id = '$id'");
    $vetor = mysqli_fetch_array($sql);

    $sql_interacoes = mysqli_query($con, "select * from suporte_mensagens where id_suporte = '$id' order by id_mensagem DESC");
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
                        <h4 class="page-title">Interações</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Ajustes e Evoluções</a></li>
                                    <li class="breadcrumb-item active">Ver Suporte</a></li>
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
            <!--            <div class="card">-->
            <!--                <div class="card-body">-->
            <!--                    <h4 class="card-title">Interações do Suporte</h4>-->
            <!--                    <ul class="list-unstyled mt-5">-->
            <!---->
            <!--                    </ul>-->
            <!--                </div>-->
            <!--            </div>-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Assunto: <?php echo $vetor['assunto']; ?></h4>
                                <h6>Link: <?php echo $vetor['link']; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="timeline">
                                    <?php
                                    while ($vetor_interacoes = mysqli_fetch_array($sql_interacoes)) {
                                        $sql_tipo = mysqli_query($con, "select * from usuarios where id_usuario = '$vetor_interacoes[id_cadastro]'");
                                        $vetor_tipo = mysqli_fetch_array($sql_tipo);

                                        if ($vetor_interacoes['id_cadastro'] == 67) {
                                            ?>
                                            <li class="timeline-inverted timeline-item">
                                                <div class="timeline-badge success"><img class="mr-3"
                                                                                         src="../sistema/arquivos/<?php echo $vetor_tipo['imagem']; ?>"
                                                                                         width="60"
                                                                                         alt="<?php echo $vetor_tipo['nome']; ?>">
                                                </div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php echo $vetor_tipo['nome']; ?></h4>
                                                        <p><small class="text-muted"></i>
                                                                Data: <?php echo date('d/m/Y', strtotime(substr($vetor_interacoes['data'], 0, 10))); ?>
                                                                -
                                                                Hora: <?php echo substr($vetor_interacoes['data'], 11, 8); ?>
                                                            </small></p>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <?php echo $vetor_interacoes['mensagem']; ?>
                                                        <div class="row">
                                                            <?php
                                                            $sql_anexos = mysqli_query($con, "select * from suporte_mensagens_anexos where id_mensagem = '$vetor_interacoes[id_mensagem]' order by id_anexo DESC");
                                                            while ($vetor_anexo = mysqli_fetch_array($sql_anexos)) {
                                                                ?>
                                                                <div class="col-md-2">
                                                                    <a href="arquivos/<?php echo $vetor_anexo['anexo']; ?>"
                                                                       target="_blank">
                                                                        <button class="btn btn-light waves-effect waves-light"
                                                                                type="button"><span class="btn-label"><i
                                                                                        class="fas fa-file-alt"></i></span>
                                                                            Anexo
                                                                        </button>
                                                                    </a>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } else { ?>
                                            <li class="timeline-item">
                                                <div class="timeline-badge success"><img class="mr-3"
                                                                                         src="../sistema/arquivos/<?php echo $vetor_tipo['imagem']; ?>"
                                                                                         width="60"
                                                                                         alt="<?php echo $vetor_tipo['nome']; ?>">
                                                </div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php echo $vetor_tipo['nome']; ?></h4>
                                                        <p><small class="text-muted"></i>
                                                                Data: <?php echo date('d/m/Y', strtotime(substr($vetor_interacoes['data'], 0, 10))); ?>
                                                                -
                                                                Hora: <?php echo substr($vetor_interacoes['data'], 11, 8); ?>
                                                            </small></p>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <?php echo $vetor_interacoes['mensagem']; ?>
                                                        <div class="row">
                                                            <?php
                                                            $sql_anexos = mysqli_query($con, "select * from suporte_mensagens_anexos where id_mensagem = '$vetor_interacoes[id_mensagem]' order by id_anexo DESC");
                                                            while ($vetor_anexo = mysqli_fetch_array($sql_anexos)) {
                                                                ?>
                                                                <div class="col-md-2">
                                                                    <a href="arquivos/<?php echo $vetor_anexo['anexo']; ?>"
                                                                       target="_blank">
                                                                        <button class="btn btn-light waves-effect waves-light"
                                                                                type="button"><span class="btn-label"><i
                                                                                        class="fas fa-file-alt"></i></span>
                                                                            Anexo
                                                                        </button>
                                                                    </a>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12">

                        <?php if ($vetor['status'] != '3') { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-3">Enviar Resposta</h4>
                                    <form method="post" action="recebe_respostasuporte.php?id=<?php echo $id; ?>"
                                          enctype="multipart/form-data">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Descrição</label>
                                                    <textarea id="mymce" name="descricao"></textarea>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div id="origem">

                                            <div class="row">

                                                <input type="hidden" name="nimagem[]" value="1">

                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Anexo</label>
                                                        <input type="file" name="arquivo[]">
                                                    </fieldset>
                                                </div>
                                            </div>

                                        </div>

                                        <div id="destino"></div>
                                        <br>
                                        <input type="button" value="Adicionar Anexo" onclick="duplicarCampos();"
                                               class="btn btn-warning">
                                        <input type="button" value="Excluir Anexo" onclick="removerCampos(this);"
                                               class="btn btn-danger">

                                        <br>
                                        <br>
                                        <?php if ($vetor['status'] == '2') { ?>
                                            <div class="col-md-2" style="margin-left: -10px">
                                                <label for="validado">Validado?</label>
                                                <select name="validado" class="form-control" required>
                                                    <option value="" required>Selecione uma Opção</option>
                                                    <option value="1">Validado</option>
                                                    <option value="2">Com Ressalva</option>
                                                </select>
                                            </div>
                                        <?php } ?>
                                        <table width="100%">
                                            <tr>
                                                <td width="5%">
                                                    <button type="submit"
                                                            class="mt-4 btn waves-effect waves-light btn-success">Enviar
                                                    </button>
                                    </form>
                                    </td>
                                    </tr>
                                    </table>

                                </div>
                            </div>
                        <?php } ?>
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

    <script src="../layout/assets/libs/tinymce/tinymce.min.js"></script>

    <script>
        $(function () {

            if ($("#mymce").length > 0) {
                tinymce.init({
                    selector: "textarea#mymce",
                    theme: "modern",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

                });
            }
            // ==============================================================
            // Our Visitor
            // ==============================================================

            var chart = c3.generate({
                bindto: '#visitor',
                data: {
                    columns: [
                        ['Open', 4],
                        ['Closed', 2],
                        ['In progress', 2],
                        ['Other', 0],
                    ],

                    type: 'donut',
                    tooltip: {
                        show: true
                    }
                },
                donut: {
                    label: {
                        show: false
                    },
                    title: "Tickets",
                    width: 35,

                },

                legend: {
                    hide: true
                    //or hide: 'data1'
                    //or hide: ['data1', 'data2']

                },
                color: {
                    pattern: ['#40c4ff', '#2961ff', '#ff821c', '#7e74fb']
                }
            });
        });
    </script>
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