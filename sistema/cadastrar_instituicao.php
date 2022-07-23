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
<!--                        <h4 class="page-title">Cadastros Gerais</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Cadastros</a></li>
                                    <li class="breadcrumb-item">Instituições</li>
                                    <li class="breadcrumb-item active" aria-current="page">Cadastrar Nova Instuição</li>
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
<!--                                <h4 class="card-title">Instituição</h4>-->

                                <form action="recebe_instituicao.php" method="post" name="cliente"
                                      enctype="multipart/form-data"  id="formID">

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Nome</label>
                                                <input type="text" name="nome" value="<?php echo $vetor['nome']; ?>"
                                                       class="form-control" id="exampleInput"
                                                       placeholder="Digite o nome" required>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Sigla</label>
                                                <input type="text" name="sigla" value="<?php echo $vetor['sigla']; ?>"
                                                       class="form-control" id="exampleInput"
                                                       placeholder="Digite a Sigla">
                                            </fieldset>
                                        </div>

                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">CEP</label>
                                                <input type="text" name="cep" id="cep" class="form-control"
                                                       placeholder="CEP" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputPassword1">Endereço</label>
                                                <input type="text" name="endereco" id="rua" class="form-control"
                                                       placeholder="Endereço" required>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">Complemento</label>
                                                <input type="text" name="complemento" class="form-control"
                                                       placeholder="Complemento">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputPassword1">Bairro</label>
                                                <input type="text" name="bairro" id="bairro" class="form-control"
                                                       placeholder="Bairro" required>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->


                                    <div class="row">
                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Cidade</label>
                                                <input type="text" name="cidade" id="cidade" class="form-control"
                                                       placeholder="Cidade" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">UF</label>
                                                <select id="estado" name="estado" class="form-control" required="">
                                                    <option value="" selected="">UF</option>
                                                    <option value="AC"
																										        <?php if (strcasecmp($vetor['estado'], 'AC') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Acre
                                                    </option>
                                                    <option value="AL"
																										        <?php if (strcasecmp($vetor['estado'], 'AL') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Alagoas
                                                    </option>
                                                    <option value="AP"
																										        <?php if (strcasecmp($vetor['estado'], 'AP') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Amapá
                                                    </option>
                                                    <option value="AM"
																										        <?php if (strcasecmp($vetor['estado'], 'AM') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Amazonas
                                                    </option>
                                                    <option value="BA"
																										        <?php if (strcasecmp($vetor['estado'], 'BA') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Bahia
                                                    </option>
                                                    <option value="CE"
																										        <?php if (strcasecmp($vetor['estado'], 'CE') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Ceará
                                                    </option>
                                                    <option value="DF"
																										        <?php if (strcasecmp($vetor['estado'], 'DF') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Distrito Federal
                                                    </option>
                                                    <option value="ES"
																										        <?php if (strcasecmp($vetor['estado'], 'ES') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Espírito Santo
                                                    </option>
                                                    <option value="GO"
																										        <?php if (strcasecmp($vetor['estado'], 'GO') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Goiás
                                                    </option>
                                                    <option value="MA"
																										        <?php if (strcasecmp($vetor['estado'], 'MA') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Maranhão
                                                    </option>
                                                    <option value="MT"
																										        <?php if (strcasecmp($vetor['estado'], 'MT') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Mato Grosso
                                                    </option>
                                                    <option value="MS"
																										        <?php if (strcasecmp($vetor['estado'], 'MS') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Mato Grosso do Sul
                                                    </option>
                                                    <option value="MG"
																										        <?php if (strcasecmp($vetor['estado'], 'MG') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Minas Gerais
                                                    </option>
                                                    <option value="PA"
																										        <?php if (strcasecmp($vetor['estado'], 'PA') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Pará
                                                    </option>
                                                    <option value="PB"
																										        <?php if (strcasecmp($vetor['estado'], 'PB') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Paraíba
                                                    </option>
                                                    <option value="PR"
																										        <?php if (strcasecmp($vetor['estado'], 'PR') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Paraná
                                                    </option>
                                                    <option value="PE"
																										        <?php if (strcasecmp($vetor['estado'], 'PE') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Pernambuco
                                                    </option>
                                                    <option value="PI"
																										        <?php if (strcasecmp($vetor['estado'], 'PI') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Piauí
                                                    </option>
                                                    <option value="RJ"
																										        <?php if (strcasecmp($vetor['estado'], 'RJ') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Rio de Janeiro
                                                    </option>
                                                    <option value="RN"
																										        <?php if (strcasecmp($vetor['estado'], 'RN') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Rio Grande do Norte
                                                    </option>
                                                    <option value="RS"
																										        <?php if (strcasecmp($vetor['estado'], 'RS') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Rio Grande do Sul
                                                    </option>
                                                    <option value="RO"
																										        <?php if (strcasecmp($vetor['estado'], 'RO') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Rondônia
                                                    </option>
                                                    <option value="RR"
																										        <?php if (strcasecmp($vetor['estado'], 'RR') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Roraima
                                                    </option>
                                                    <option value="SC"
																										        <?php if (strcasecmp($vetor['estado'], 'SC') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Santa Catarina
                                                    </option>
                                                    <option value="SP"
																										        <?php if (strcasecmp($vetor['estado'], 'SP') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        São Paulo
                                                    </option>
                                                    <option value="SE"
																										        <?php if (strcasecmp($vetor['estado'], 'SE') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Sergipe
                                                    </option>
                                                    <option value="TO"
																										        <?php if (strcasecmp($vetor['estado'], 'TO') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Tocantins
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Telefone</label>
                                                <input type="text" name="telefone"
                                                       value="<?php echo $vetor['telefone']; ?>" class="form-control"
                                                       id="telefone" placeholder="Telefone">
                                            </fieldset>
                                        </div>

                                    </div><!--.row-->

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Site</label>
                                                <input type="text" name="site" value="<?php echo $vetor['site']; ?>"
                                                       class="form-control" id="exampleInput"
                                                       placeholder="Digite o Site">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Região</label>
                                                <select name="regiao" class="form-control">
                                                    <option value="Centro Oeste"
																										        <?php if (strcasecmp($vetor['regiao'], 'Centro Oeste') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Centro Oeste
                                                    </option>
                                                    <option value="Nordeste"
																										        <?php if (strcasecmp($vetor['regiao'], 'Nordeste') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Nordeste
                                                    </option>
                                                    <option value="Norte"
																										        <?php if (strcasecmp($vetor['regiao'], 'Norte') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Norte
                                                    </option>
                                                    <option value="Sudeste"
																										        <?php if (strcasecmp($vetor['regiao'], 'Sudeste') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Sudeste
                                                    </option>
                                                    <option value="Sul"
																										        <?php if (strcasecmp($vetor['regiao'], 'Sul') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Sul
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold"
                                                       for="exampleInput">Administração</label>
                                                <select name="administracao" class="form-control">
                                                    <option value="Privada"
																										        <?php if (strcasecmp($vetor['administracao'], 'Privada') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Privada
                                                    </option>
                                                    <option value="Estadual"
																										        <?php if (strcasecmp($vetor['administracao'], 'Estadual') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Estadual
                                                    </option>
                                                    <option value="Federal"
																										        <?php if (strcasecmp($vetor['administracao'], 'Federal') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Federal
                                                    </option>
                                                    <option value="Municipal"
																										        <?php if (strcasecmp($vetor['administracao'], 'Municipal') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Municipal
                                                    </option>
                                                    <option value="Pública"
																										        <?php if (strcasecmp($vetor['administracao'], 'Pública') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Pública
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">Distância
                                                    (Km)</label>
                                                <input type="text" name="distancia" class="form-control"
                                                       placeholder="Distancia" required>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary" style="    float: left;">Cadastrar
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
    </body>

    </html>
<?php } ?>