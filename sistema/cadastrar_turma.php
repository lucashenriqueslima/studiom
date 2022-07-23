<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$sql_consulta = mysqli_query($con, "SELECT * FROM turmas order by ncontrato DESC limit 0,1");
	$vetor_consulta = mysqli_fetch_array($sql_consulta);
	$ncontrato = $vetor_consulta['ncontrato'] + 1;
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
                        <!--                        <h4 class="page-title">Administrativo</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Projetos</a></li>
                                    <li class="breadcrumb-item">Gestão de Projetos</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cadastrar Novo Contrato</li>
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
                                <!--                                <h4 class="card-title">Cadastro de Contrato</h4>-->

                                <form action="recebe_turma.php" method="post" name="cliente"
                                      enctype="multipart/form-data" id="formID">

                                    <div class="row">

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">N°
                                                    Contrato</label>
                                                <input type="number" name="ncontrato" value="<?php echo $ncontrato; ?>"
                                                       class="form-control" placeholder="N° Contrato" readonly>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Tipo
                                                    Contrato</label>
                                                <select name="tipo" class="form-control" required="">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">
                                                        Fotografia
                                                    </option>
                                                    <option value="2">
                                                        Convite
                                                    </option>
                                                    <option value="3">
                                                        Fotografia/Convite
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Curso</label>
                                                <select name="curso" id="categorias" class="form-control">
                                                    <option value="" selected="selected">Selecione...</option>
																									<?php
																									$sql_cursos = mysqli_query($con, "select * from cursos order by nome ASC, sigla ASC");
																									while ($vetor_curso = mysqli_fetch_array($sql_cursos)) {
																										$sql_instituicao_curso = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
																										$vetor_instituicao_curso = mysqli_fetch_array($sql_instituicao_curso);
																										?>
                                                      <option value="<?php echo $vetor_curso['id_curso']; ?>"><?php echo $vetor_curso['nome'] ?>
                                                          / <?php echo $vetor_instituicao_curso['sigla'] ?></option>
																									<?php } ?>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Conclusão</label>
                                                <input type="text" name="ano" value=""
                                                       class="form-control" id="exampleInput"
                                                       placeholder="Ano Conclusão">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold"
                                                       for="exampleInput">Instituição</label>
                                                <select name="id_instituicao" id="categorias" class="form-control">
                                                    <option value="" selected="selected">Selecione...</option>
																									<?php
																									$sql_instituicoes = mysqli_query($con, "select * from instituicoes order by sigla ASC, nome ASC");
																									while ($vetor_instituicao = mysqli_fetch_array($sql_instituicoes)) { ?>
                                                      <option value="<?php echo $vetor_instituicao['id_instituicao']; ?>"><?php echo $vetor_instituicao['sigla'] . ' - ' . $vetor_instituicao['nome'] ?></option>
																									<?php } ?>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Qtde
                                                    Alunos</label>
                                                <input type="number" name="qtdalunos"
                                                       value="" class="form-control"
                                                       placeholder="Quantidade">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Qtde
                                                    Comissão</label>
                                                <input type="number" name="qtdcomissao"
                                                       value="" class="form-control"
                                                       placeholder="Quantidade">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Qtde de
                                                    Formandos</label>
                                                <input type="number" name="qtdformandos"
                                                       value=""
                                                       class="form-control" id="exampleInput" placeholder="Quantidade">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">Ano de
                                                    realização</label>
                                                <input type="text" name="anorealizacao"
                                                       value=""
                                                       class="form-control" placeholder="Ano de realização" required>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Mês de
                                                    realização</label>
                                                <select name="mesrealizacao" class="form-control" required="">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="Janeiro">
                                                        Janeiro
                                                    </option>
                                                    <option value="Fevereiro">
                                                        Fevereiro
                                                    </option>
                                                    <option value="Março">
                                                        Março
                                                    </option>
                                                    <option value="Abril">
                                                        Abril
                                                    </option>
                                                    <option value="Maio">
                                                        Maio
                                                    </option>
                                                    <option value="Junho">
                                                        Junho
                                                    </option>
                                                    <option value="Julho">
                                                        Julho
                                                    </option>
                                                    <option value="Agosto">
                                                        Agosto
                                                    </option>
                                                    <option value="Setembro">
                                                        Setembro
                                                    </option>
                                                    <option value="Outubro">
                                                        Outubro
                                                    </option>
                                                    <option value="Novembro">
                                                        Novembro
                                                    </option>
                                                    <option value="Dezembro">
                                                        Dezembro
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">Turma</label>
                                                <input type="text" name="turma" value=""
                                                       class="form-control" placeholder="Turma" required>
                                            </fieldset>
                                        </div>

                                    </div><!--.row-->

                                    <div class="row">

                                        <div class="col-lg-3">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Valor da Pagina
                                                    30x40cm</label>
                                                <input type="text" name="valorfoto"
                                                       value=""
                                                       class="form-control" id="exampleInput"
                                                       onKeyPress="mascara(this,mvalor)" placeholder="Valor de Pagina">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-3">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Valor da Pagina
                                                    22x30cm</label>
                                                <input type="text" name="valorfoto1"
                                                       value=""
                                                       class="form-control" id="exampleInput"
                                                       onKeyPress="mascara(this,mvalor)" placeholder="Valor de Pagina">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-3">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Valor da
                                                    Encadernação</label>
                                                <input type="text" name="valorencadernacao"
                                                       value=""
                                                       class="form-control" onKeyPress="mascara(this,mvalor)"
                                                       placeholder="Valor da Encadernação">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-3">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Valor do Arquivo
                                                    Digital</label>
                                                <input type="text" name="valoralbum"
                                                       value=""
                                                       class="form-control" onKeyPress="mascara(this,mvalor)"
                                                       placeholder="Valor do Arquivo Digital">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">E-mail da Comissão
                                                    de Formatura</label>
                                                <input type="email" name="emailcomissao"
                                                       value=""
                                                       class="form-control"
                                                       placeholder="E-mail da Comissão de Formatura">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Cerimonial</label>
                                                <input type="text" name="cerimonial"
                                                       value="" class="form-control"
                                                       id="exampleInput" placeholder="Cerimonial">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Telefone
                                                    Cerimonial</label>
                                                <input type="text" name="telefonecerimonial" id="telefone5"
                                                       value=""
                                                       class="form-control" placeholder="Telefone Cerimonial">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Responsável
                                                    Cerimonial</label>
                                                <input type="text" name="nomeresponsavel"
                                                       value=""
                                                       class="form-control" id="exampleInput"
                                                       placeholder="Responsável Cerimonial">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Telefone
                                                    Responsável Cerimonial</label>
                                                <input type="text" name="telefoneresponsavel" id="telefone6"
                                                       value=""
                                                       class="form-control"
                                                       placeholder="Telefone Responsável Cerimonial">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <h3>Eventos da Turma</h3>

                                    <div id="origem">

                                        <div class="row">

                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Eventos</label>
                                                    <select name="id_evento[]" class="form-control">
                                                        <option value="" selected="selected">Selecione...</option>
																											<?php
																											$sql_evento = mysqli_query($con, "select * from categoriaevento order by nome ASC");
																											while ($vetor_evento = mysqli_fetch_array($sql_evento)) {
																												?>
                                                          <option value="<?php echo $vetor_evento['id_categoria']; ?>"><?php echo $vetor_evento['nome'] ?></option>
																											<?php } ?>
                                                    </select>
                                                </fieldset>
                                            </div>

                                        </div>

                                    </div>

                                    <div id="destino">
                                    </div>
                                    <br>
                                    <input type="button" value="Adicionar Evento" onclick="duplicarCampos();"
                                           class="btn btn-warning">
                                    <input type="button" value="Excluir Evento" onclick="removerCampos(this);"
                                           class="btn btn-danger">

                                    <br>
                                    <br>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Logo/Brasão ou
                                                    Símbolo da turma</label>
                                                <input type="file" name="logo">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observações</label>
                                                <textarea name="observacoes"
                                                          class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Liberar Pré-evento apos compra?</label>
                                                <select name="preevento" class="form-control">
                                                    <option value="1" selected>Não</option>
                                                    <option value="2">Sim</option>
                                                </select>
                                            </div>
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