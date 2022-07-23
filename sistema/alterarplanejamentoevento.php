<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$id = $_GET['id'];
	$sql = mysqli_query($con, "select * from escala_eventos where id_escala = '$id'");
	$vetor = mysqli_fetch_array($sql);
	$sql_formandos = mysqli_query($con, "select * from formandos where turma = '$vetor[id_contrato]' order by nome ASC");
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

        <style type="text/css">
            <!--
            .style1 {
                font-size: 18px;
                font-weight: bold;
            }

            -->
        </style>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#palco > div").hide();
                $("#produto").change(function () {
                    $("#palco > div").hide();
                    $('#' + $(this).val()).show('fast');
                });
                $("#palco1 > div").hide();
                $("#tipobusca").change(function () {
                    $("#palco1 > div").hide();
                    $('#' + $(this).val()).show('fast');
                });
                $("input[name='rd-sexo']").click(function () {
                    $("#palco > div").hide();
                    $('#' + $(this).val()).show('fast');
                });
            });
        </script>
    </head>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#turmas').change(function () {
                $('#eventos').load('eventos_planejamento.php?id_turma=' + $('#turmas').val());

            });

        });

        function duplicarCampos() {
            var clone = document.getElementById('origem').cloneNode(true);
            var destino = document.getElementById('destino');
            destino.appendChild(clone);
            var camposClonados = clone.getElementsByTagName('input');
            for (i = 0; i < camposClonados.length; i++) {
                camposClonados[i].value = '';
            }
        }

        function removerCampos(id) {
            var node1 = document.getElementById('destino');
            node1.removeChild(node1.childNodes[0]);
        }

        function duplicarCampos1() {
            var clone1 = document.getElementById('origem1').cloneNode(true);
            var destino1 = document.getElementById('destino1');
            destino1.appendChild(clone1);
            var camposClonados1 = clone1.getElementsByTagName('input');
            for (i = 0; i < camposClonados1.length; i++) {
                camposClonados1[i].value = '';
            }
        }

        function removerCampos1(id) {
            var node11 = document.getElementById('destino1');
            node11.removeChild(node11.childNodes[0]);
        }

    </script>
    <script src="ckeditor/ckeditor.js"></script>

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
                        <!--                        <h4 class="page-title">Fotografia</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Fotografia</a></li>
                                    <li class="breadcrumb-item">Planejamento de Eventos</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cadastrar Planejamento de
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
                                <!--                                <h4 class="card-title">Cadastro de Planejamento de Eventos</h4>-->

                                <form action="recebe_alterarplanejamentoevento.php?id=<?php echo $id; ?>" method="post"
                                      name="cliente" enctype="multipart/form-data" onSubmit="return verificarCPF()"
                                      id="formID">

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Contrato</label>
                                                <select name="id_turma" id="turmas" class="form-control">
                                                    <option value="" selected="selected">Selecione...</option>
																									<?php
																									$sql_cursos = mysqli_query($con, "select * from turmas order by ncontrato ASC");
																									while ($vetor_curso = mysqli_fetch_array($sql_cursos)) {
																										$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
																										$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
																										$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_curso[curso]'");
																										$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
																										?>
                                                      <option value="<?php echo $vetor_curso['id_turma']; ?>"
																											        <?php if (strcasecmp($vetor['id_contrato'], $vetor_curso['id_turma']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_curso['ncontrato'] ?>
                                                          - <?php echo $vetor_curso['nome'] ?> <?php echo $vetor_curso['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?></option>
																									<?php } ?>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div id="origem1">

                                        <div class="row">

                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Evento(s)</label>
                                                    <select name="eventos[]" class="form-control">
                                                        <option value="">Escolha um Contrato</option>
																											
																											<?php
																											$sql_eventos = mysqli_query($con, "SELECT * FROM eventos_turma WHERE id_turma = '$vetor[id_contrato]' order by id_evento ASC");
																											while ($vetor_eventos = mysqli_fetch_array($sql_eventos)) {
																												?>

                                                          <option value="<?php echo $vetor_eventos['id_evento']; ?>"
																													        <?php if (mysqli_num_rows($sql_evento_cad) > 0) { ?>selected <?php } ?>><?php echo $vetor_eventos['nome']; ?></option>
																											
																											<?php } ?>

                                                    </select>
                                                </fieldset>
                                            </div>

                                        </div>

                                    </div>

                                    <div id="destino1">
                                    </div>
                                    <br>
                                    <input type="button" value="Adicionar Evento" onclick="duplicarCampos1();"
                                           class="btn btn-warning">
                                    <input type="button" value="Excluir Evento" onclick="removerCampos1(this);"
                                           class="btn btn-danger">

                                    <br>
                                    <br>

                                    <h3>Eventos Cadastrados</h3>

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Evento</th>
                                            <td width="15%">Qtde Total Formandos</td>
                                            <td width="15%">Qtde Formandos Evento</td>
                                            <th>Data</th>
                                            <th>Horário Inicio</th>
                                            <th>Horário Término</th>
                                            <th width="13%">Ação</th>
                                        </tr>
                                        </thead>
                                        <tbody>
																				<?php
																				$sql_escala_eventos = mysqli_query($con, "select * from escala_eventos_itens a, eventos_turma b where a.id_evento = b.id_evento and a.id_escala = '$id' order by b.data ASC");
																				while ($vetor_escala_evento = mysqli_fetch_array($sql_escala_eventos)) {
																					$nomeevento = explode("/", $vetor_escala_evento['nome']);
																					?>
                                            <tr>
                                                <td><?php echo $nomeevento[2]; ?></td>
                                                <td><?php echo mysqli_num_rows($sql_formandos); ?></td>
                                                <td><?php echo $vetor_escala_evento['qtd']; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($vetor_escala_evento['data'])); ?></td>
                                                <td><?php echo $vetor_escala_evento['horainicio']; ?></td>
                                                <td><?php echo $vetor_escala_evento['horafim']; ?></td>
                                                <td>
                                                    <a href="alterareventoescala.php?id=<?php echo $vetor_escala_evento['id_escala_item']; ?>&id1=<?php echo $id; ?>"
                                                       target="_blank">
                                                        <button type="button" class="btn btn-info mesmo-tamanho"
                                                                title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                    <a href="confexcluireventoescala.php?id=<?php echo $vetor_escala_evento['id_escala_item']; ?>&id1=<?php echo $id; ?>">
                                                        <button type="button" class="btn btn-danger mesmo-tamanho"
                                                                title="Excluir Cadastro"><i
                                                                    class="mdi mdi-window-close"></i></button>
                                                    </a>
                                                    <a href="imprimirescalaevento.php?id=<?php echo $id; ?>&id_evento=<?php echo $vetor_escala_evento['id_escala_item']; ?>"
                                                       target="_blank">
                                                        <button type="button" class="btn btn-primary mesmo-tamanho"
                                                                title="Imprimir Cadastro"><i class="fa fa-print"></i>
                                                        </button>
                                                    </a></td>
                                            </tr>
																				<?php } ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Função</th>
                                            <th width="13%">Ação</th>
                                        </tr>
                                        </tfoot>
                                    </table>

                                    <h3>Escala de Profissionais</h3>

                                    <div id="origem">

                                        <div class="row">

                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Função</label>
                                                    <select name="id_funcao[]" id="categorias" class="form-control">

                                                        <option value="" selected="">Selecione...</option>
																											<?php
																											$sql_categoria = mysqli_query($con, "select * from tabela_fotografia where planejamento = '1' order by titulo ASC");
																											while ($vetor_categoria = mysqli_fetch_array($sql_categoria)) { ?>
                                                          <option value="<?php echo $vetor_categoria['id_tabela']; ?>"
																													        <?php if (strcasecmp($vetor['id_funcao'], $vetor_categoria['id_tabela']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_categoria['titulo'] ?></option>
																											<?php } ?>
                                                    </select>
                                                </fieldset>
                                            </div>

                                        </div>

                                    </div>

                                    <div id="destino">
                                    </div>
                                    <br>
                                    <input type="button" value="Adicionar Função" onclick="duplicarCampos();"
                                           class="btn btn-warning">
                                    <input type="button" value="Excluir Função" onclick="removerCampos(this);"
                                           class="btn btn-danger">

                                    <br>
                                    <br>

                                    <h3>Escala de Profissionais Cadastrados</h3>

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Função</th>
                                            <th width="13%">Ação</th>
                                        </tr>
                                        </thead>
                                        <tbody>
																				<?php
																				$sql_escala_profissionais = mysqli_query($con, "select * from escala_profissionais where id_escala = '$id' order by id_escala_profissional ASC");
																				while ($vetor_escala_profissionais = mysqli_fetch_array($sql_escala_profissionais)) {
																					$sql_tabela = mysqli_query($con, "select * from tabela_fotografia where id_tabela = '$vetor_escala_profissionais[id_funcao]'");
																					$vetor_tabela = mysqli_fetch_array($sql_tabela);
																					$sql_fornecedor = mysqli_query($con, "select * from clientes where id_cli = '$vetor_escala_profissionais[id_colaborador]'");
																					$vetor_fornecedor = mysqli_fetch_array($sql_fornecedor);
																					?>
                                            <tr>
                                                <td><?php echo $vetor_fornecedor['nome']; ?></td>
                                                <td><?php echo $vetor_tabela['titulo']; ?></td>
                                                <td>
                                                    <a href="alterarescalaprofissional.php?id=<?php echo $vetor_escala_profissionais['id_escala_profissional']; ?>&id1=<?php echo $id; ?>"
                                                       target="_blank">
                                                        <button type="button" class="btn btn-info mesmo-tamanho"
                                                                title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                    <a href="confexcluirescalaprofissional.php?id=<?php echo $vetor_escala_profissionais['id_escala_profissional']; ?>&id1=<?php echo $id; ?>">
                                                        <button type="button" class="btn btn-danger mesmo-tamanho"
                                                                title="Excluir Cadastro"><i
                                                                    class="mdi mdi-window-close"></i></button>
                                                    </a></td>
                                            </tr>
																				<?php } ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Função</th>
                                            <th width="13%">Ação</th>
                                        </tr>
                                        </tfoot>
                                    </table>

                                    <button type="submit" class="btn btn-primary" style="    float: left;">Alterar
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