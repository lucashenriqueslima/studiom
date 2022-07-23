<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);
	$id = $_GET['id'];
	$sql = mysqli_query($con, "select * from convite_personal where id_convite = '$id'");
	$vetor = mysqli_fetch_array($sql);
	$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor[id_formando]'");
	$vetor_formando = mysqli_fetch_array($sql_formando);
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

        <link href="../layout/assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../layout/dist/css/style.min.css" rel="stylesheet">

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
                border: 0;
                outline: 0;
                box-sizing: border-box;
            }

            html, body {
                height: 100%;
            }


            /** THUMBNAILS GLOBALS **/
            .thumbnails {
                display: flex;
                flex-wrap: wrap;
            }

            .thumbnails a {
                width: 200px;
                height: 200px;
                margin: 14px;
                border-radius: 2px;
                overflow: hidden;
            }

            .thumbnails img {
                height: 100%;
                object-fit: cover;
                transition: transform .3s;
            }

            .thumbnails a:hover img {
                transform: scale(1.05);
            }

            /** THUMBNAILS GRID **/
            .thumbnails.grid a.double {
                width: calc(50% - 4px);
            }

            .thumbnails.grid img {
                width: 100%;
            }

            /** THUMBNAILS MASONRY **/
            .thumbnails.masonry a {
                flex-grow: 1;
            }

            .thumbnails.masonry img {
                min-width: 100%;
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
<!--                        <h4 class="page-title">Arte Final - Fotografia</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Arte Final - Fotografia</a></li>
                                    <li class="breadcrumb-item">Escolha de Fotos</a></li>
                                    <li class="breadcrumb-item">Produtos de Convite</a></li>
                                    <li class="breadcrumb-item">Personal</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Alterar Personal</li>
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
<!--                                <h4 class="card-title">Cadastro de Produto Personal</h4>-->

                                <form action="recebe_alterarconvitepersonal.php?id=<?php echo $id; ?>" method="post"
                                      name="cliente" enctype="multipart/form-data"
                                      id="formID">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Formando</label>
                                                <br>
																							<?php echo $vetor_formando['nome']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Data Final para Aprovação</label>
                                                <br>
                                                <input type="date" name="datafinal"
                                                       value="<?php echo $vetor['datafinal']; ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" id="turmas" class="form-control" required="">
                                                    <option value="" selected="selected">Selecione...</option>
                                                    <option value="1"
																										        <?php if (strcasecmp($vetor['status'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Em Aberto
                                                    </option>
                                                    <option value="2"
																										        <?php if (strcasecmp($vetor['status'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Em Preenchimento
                                                    </option>
                                                    <option value="3"
																										        <?php if (strcasecmp($vetor['status'], '3') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Escolha Finalizada
                                                    </option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="    float: left;">Salvar
                                    </button>

                                </form>

                                <br>
                                <br>
															
															<?php
															$sql_itens = mysqli_query($con, "select * from convite_personal_itens where id_convite = '$id'");
															while ($vetor_itens = mysqli_fetch_array($sql_itens)) {
																$sql_tipo = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '$vetor_itens[id_tipo]'");
																$vetor_tipo = mysqli_fetch_array($sql_tipo);
																?>

                                  <h3><?php echo $vetor_tipo['nome']; ?></h3>

                                  <table width="100%" class="table table-bordered table-striped">
                                      <thead>
                                      <tr>

                                          <th>
                                              <div class="a">Foto(s) Escolhida</div>
                                          </th>

                                      </tr>
                                      </thead>
                                      <tbody>

                                      <tr>

                                          <td>
                                              <table class="table">
                                                  <tbody>
                                                  <tr>
																										
																										<?php
																										$sql_fotos_cadastradas = mysqli_query($con, "select * from convite_personal_escolhas where id_item = '$vetor_itens[id_item]'");
																										while ($vetor_fotos_cadastradas = mysqli_fetch_array($sql_fotos_cadastradas)) {
																											?>

                                                        <td>
                                                            <div class="thumbnail">


                                                                <img alt=""
                                                                     src="<?php echo $vetor_fotos_cadastradas['imagem']; ?>"
                                                                     width="150px"/>


                                                            </div>

                                                            <br>
																													
																													<?php
																													$imgexplode = explode("/", $vetor_fotos_cadastradas['imagem']);
																													if ($vetor_fotos_cadastradas['id_tipo'] == '1') {
																														echo $imgexplode[3];
																													}
																													if ($vetor_fotos_cadastradas['id_tipo'] == '2') {
																														echo $imgexplode[6];
																													}
																													?>

                                                        </td>
																										
																										<?php } ?>

                                                  </tr>
                                                  </tbody>
                                              </table>

                                          </td>
                                      </tr>


                                      </tbody>
                                  </table>

                                  <br>
                                  <br>

                                  <a href="excluirimagempersonal.php?id=<?php echo $vetor_itens['id_item']; ?>&id1=<?php echo $id; ?>">
                                      <button type="button" class="btn btn-danger mesmo-tamanho"
                                              title="Excluir Cadastro">Excluir Escolhas
                                      </button>
                                  </a>
															
															<?php } ?>

                                <br>
                                <br>


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

    <script src="../layout/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="../layout/assets/libs/magnific-popup/meg.init.js"></script>
    </body>

    </html>
<?php } ?>