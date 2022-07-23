<?php
include "../includes/conexao.php";
if (isset($_GET['load'])) {
	$id = $_GET['id'];
	$sql = mysqli_query($con, "select * from sub_categorias where id_categoria = '$id'");
	while ($status = mysqli_fetch_array($sql)) {
		echo "<option value='".$status['id_sub']."'>".$status['nome']."</option>";
	}
	die();
}
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$id = $_GET['id'];
	$sql_categoriaCRM = mysqli_query($con, "select * from categorias order by nome ASC");
	$vetor = mysqli_fetch_array(mysqli_query($con, "select * from prospeccoes where id_prospeccao = '$id'"));
	$vetor_turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas_mkt where id_turma = '".$vetor['id_turma']."'"));
	$vetor_curso = mysqli_fetch_array(mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[id_curso]'"));
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
        <script src="../layout/bower_components/jquery/dist/jquery.min.js"></script>
    </head>
    <script type="text/javascript">
        $(document).ready(function () {

            $("#tipobusca").change(function () {
                switch ($("#tipobusca").val()) {
                    case '0':
                        $("#nomeindicacao").attr('hidden', 'hidden');
                        $("#contrato").attr('hidden', 'hidden');
                        $("#formando").attr('hidden', 'hidden');
                        break;
                    case '1':
                        $("#nomeindicacao").attr('hidden', 'hidden');
                        $("#contrato").removeAttr("hidden");
                        $("#formando").removeAttr("hidden");
                        break;
                    case '2':
                        $("#nomeindicacao").removeAttr("hidden");
                        $("#contrato").attr('hidden', 'hidden');
                        $("#formando").attr('hidden', 'hidden');
                        break;
                }
            });
            $('#fotografia_viabilidade').change(function () {
                if ($('#fotografia_viabilidade').val() == '1') {
                    $("#fotografia_empresa_fechado").attr('hidden', 'hidden');
                    $("#fotografia_motivo_fechado").attr('hidden', 'hidden');
                    $("#fotografia_qtdalunos").removeAttr("hidden");
                    $("#form_fotografia").attr('action', 'recebe_lead.php?id=' + $('#id').val());
                    $('#salvar_fotografia').attr('hidden', 'hidden');
                    $("#gerar_fotografia").removeAttr("hidden");
                    $("#fotografia_num_alunos").removeAttr("hidden");

                } else {
                    $("#form_fotografia").attr('action', 'recebe_alterarprospeccao.php?id=' + $('#id').val());
                    $('#gerar_fotografia').attr('hidden', 'hidden');
                    $("#salvar_fotografia").removeAttr("hidden");
                    $("#fotografia_qtdalunos").attr('hidden', 'hidden');
                    $("#fotografia_num_alunos").attr('hidden', 'hidden');
                    $("#fotografia_motivo_fechado").removeAttr("hidden");
                }
            });
            $('#fotografia_motivo').change(function () {
                if ($('#fotografia_motivo').val() == '1') {
                    $("#fotografia_empresa_fechado").removeAttr("hidden");
                } else {
                    $("#fotografia_empresa_fechado").attr('hidden', 'hidden');
                }
            });

            $('#convite_viabilidade').change(function () {
                if ($('#convite_viabilidade').val() == '1') {
                    $("#convite_empresa_fechado").attr('hidden', 'hidden');
                    $("#convite_motivo_fechado").attr('hidden', 'hidden');
                    $("#convite_qtdalunos").removeAttr("hidden");
                    $("#form_convite").attr('action', 'recebe_lead.php?id=' + $('#id').val());
                    $('#salvar_convite').attr('hidden', 'hidden');
                    $("#gerar_convite").removeAttr("hidden");
                    $("#convite_num_alunos").removeAttr("hidden");
                } else {
                    $("#form_convite").attr('action', 'recebe_alterarprospeccao.php?id=' + $('#id').val());
                    $('#gerar_convite').attr('hidden', 'hidden');
                    $("#salvar_convite").removeAttr("hidden");
                    $("#convite_qtdalunos").attr('hidden', 'hidden');
                    $("#convite_num_alunos").attr('hidden', 'hidden');
                    $("#convite_motivo_fechado").removeAttr("hidden");
                }
            });
            $('#convite_motivo').change(function () {
                if ($('#convite_motivo').val() == '1') {
                    $("#convite_empresa_fechado").removeAttr("hidden");
                } else {
                    $("#convite_empresa_fechado").attr('hidden', 'hidden');
                }
            });

            $('#ensaio_viabilidade').change(function () {
                if ($('#ensaio_viabilidade').val() == '1') {
                    $("#ensaio_empresa_fechado").attr('hidden', 'hidden');
                    $("#ensaio_motivo_fechado").attr('hidden', 'hidden');
                    $("#ensaio_qtdalunos").removeAttr("hidden");
                    $("#ensaio_num_alunos").removeAttr("hidden");
                    $("#form_ensaio").attr('action', 'recebe_lead.php?id=' + $('#id').val());
                    $('#salvar_ensaio').attr('hidden', 'hidden');
                    $("#gerar_ensaio").removeAttr("hidden");
                } else {
                    $("#form_ensaio").attr('action', 'recebe_alterarprospeccao.php?id=' + $('#id').val());
                    $('#gerar_ensaio').attr('hidden', 'hidden');
                    $("#salvar_ensaio").removeAttr("hidden");
                    $("#ensaio_qtdalunos").attr('hidden', 'hidden');
                    $("#ensaio_num_alunos").attr('hidden', 'hidden');
                    $("#ensaio_motivo_fechado").removeAttr("hidden");
                }
            });
            $('#ensaio_motivo').change(function () {
                if ($('#ensaio_motivo').val() == '1') {
                    $("#ensaio_empresa_fechado").removeAttr("hidden");
                } else {
                    $("#ensaio_empresa_fechado").attr('hidden', 'hidden');
                }
            });

            $('#placa_viabilidade').change(function () {
                if ($('#placa_viabilidade').val() == '1') {
                    $("#placa_empresa_fechado").attr('hidden', 'hidden');
                    $("#placa_motivo_fechado").attr('hidden', 'hidden');
                    $("#placa_qtdalunos").removeAttr("hidden");
                    $("#placa_num_alunos").removeAttr("hidden");
                    $("#form_placa").attr('action', 'recebe_lead.php?id=' + $('#id').val());
                    $('#salvar_placa').attr('hidden', 'hidden');
                    $("#gerar_placa").removeAttr("hidden");
                } else {
                    $("#form_placa").attr('action', 'recebe_alterarprospeccao.php?id=' + $('#id').val());
                    $('#gerar_placa').attr('hidden', 'hidden');
                    $("#salvar_placa").removeAttr("hidden");
                    $("#placa_qtdalunos").attr('hidden', 'hidden');
                    $("#placa_num_alunos").attr('hidden', 'hidden');
                    $("#placa_motivo_fechado").removeAttr("hidden");
                }
            });
            $('#placa_motivo').change(function () {
                if ($('#placa_motivo').val() == '1') {
                    $("#placa_empresa_fechado").removeAttr("hidden");
                } else {
                    $("#placa_empresa_fechado").attr('hidden', 'hidden');
                }
            });
            $('#empresa').change(function () {
                if ($('#empresa').val() == '1') {
                    $("#empresacerimonial").removeAttr("hidden");
                } else {
                    $("#empresacerimonial").attr('hidden', 'hidden');
                }
            });

            $('#turmas').change(function () {
                $('#selectformando').load('formandos_tarefa.php?load=sim&id_turma=' + $('#turmas').val());
            });

            $('#categoriaCRM').change(function () {
                $('#statusCRM').load('alterarprospeccao.php?load=sim&id=' + $('#categoriaCRM').val())
            });
        });
    </script>

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
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Marketing</a></li>
                                    <li class="breadcrumb-item">Prospecção</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Editar Prospecção</li>
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

                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#dados"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Dados da Prospecção</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fotografia"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span
                                                    class="hidden-xs-down" <?php if ($vetor['fotografia_viabilidade'] == 'inviavel') {
																					echo "style='text-decoration-line: line-through;'";
																				} ?>>Fotografia</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#convite"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span
                                                    class="hidden-xs-down" <?php if ($vetor['convite_viabilidade'] == 'inviavel') {
																					echo "style='text-decoration-line: line-through;'";
																				} ?>>Convite</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ensaio"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span
                                                    class="hidden-xs-down" <?php if ($vetor['ensaio_viabilidade'] == 'inviavel') {
																					echo "style='text-decoration-line: line-through;'";
																				} ?>>Ensaio</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#placa"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span
                                                    class="hidden-xs-down" <?php if ($vetor['placa_viabilidade'] == 'inviavel') {
																					echo "style='text-decoration-line: line-through;'";
																				} ?>>Placa</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#interacoes"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Interações</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contatos"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Contatos</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#documentos"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Documentos</span></a>
                                    </li>

                                </ul>

                                <div class="tab-content tabcontent-border">

                                    <div class="tab-pane active" id="dados" role="tabpanel">

                                        <br>
                                        <br>

                                        <form action="recebe_alterarprospeccao.php?id=<?php echo $id; ?>&dados=true"
                                              method="post"
                                              name="cliente" enctype="multipart/form-data"
                                              id="formID">

                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Turma</label>
                                                        <input type="text" name="id_turma"
                                                               value="<?php echo $vetor_curso['nome'].'/'.$vetor_curso['sigla'].'/'.$vetor_turma['conclusao'].'-'.$vetor_turma['semestre']; ?>"
                                                               class="form-control" readonly>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-1">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Vagas</label>
                                                        <input type="text" name="qtdalunos"
                                                               value="<?php echo $vetor_curso['vagas1']; ?>"
                                                               class="form-control" readonly>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-2">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Quantidade de Alunos</label>
                                                        <input type="text" name="num_alunos"
                                                               value="<?php echo $vetor['num_alunos']; ?>"
                                                               class="form-control">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Contato</label>
                                                        <input type="text" name="tipo_comunicacao"
                                                               value="<?php if ($vetor['tipo_comunicacao'] == 'ativa') {
																													       echo "Ativo";
																												       }else {
																													       echo "Passivo";
																												       } ?>"
                                                               class="form-control" readonly>
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">
                                                            Indicação?</label>
                                                        <input type="text" name="indicacao"
                                                               value="<?php switch ($vetor['indicacao']) {
																													       case 0:
																														       echo "Não";
																														       break;
																													       case 1:
																														       echo "Contrato";
																														       break;
																													       case 2:
																														       echo "Outros";
																														       break;
																												       } ?>"
                                                               class="form-control" readonly>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-4">
                                                    <fieldset id="nomeindicacao"
                                                              class="form-group" <?php if ($vetor['indicacao'] != '2') {
																											echo "hidden";
																										} ?>>
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Nome</label>
                                                        <input type="text" name="nome_indicacao"
                                                               value="<?php echo $vetor['nome_indicacao']; ?>"
                                                               class="form-control" readonly>
                                                    </fieldset>
                                                    <fieldset id="contrato"
                                                              class="form-group" <?php if ($vetor['indicacao'] != '1') {
																											echo "hidden";
																										} ?>>
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Contrato</label>
																											
																											<?php
																											if ($vetor['indicacao'] == 1) {
																												$vetor_formandoI = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$vetor[nome_indicacao]'"));
																												$vetor_cursoI = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma  = '$vetor_formandoI[turma]'"));
																												$vetor_instituicao_inicioI = mysqli_fetch_array(mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_cursoI[id_instituicao]'"));
																												?>
                                                          <input type="text" name="contrato"
                                                                 value="<?php echo $vetor_cursoI['ncontrato'].'-'.$vetor_cursoI['nome'].$vetor_cursoI['ano'].$vetor_instituicao_inicioI['sigla']; ?>"
                                                                 class="form-control" readonly>
																											<?php } ?>
                                                    </fieldset>
                                                </div>

                                                <div class="col-md-4">
                                                    <div id="formando"
                                                         class="form-group" <?php if ($vetor['indicacao'] != '1') {
																											echo "hidden";
																										} ?>>
                                                        <label>Formando</label>
																											<?php
																											if ($vetor['indicacao'] == 1) {
																												?>
                                                          <input type="text" name="nome_indicacao"
                                                                 value="<?php echo $vetor_formandoI['nome']; ?>"
                                                                 class="form-control" readonly>
																											<?php } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Empresa de
                                                            Festa (cerimonial)?</label>
                                                        <select name="empresa_cerimonial" id="empresa"
                                                                class="form-control">
                                                            <option value="1" <?php if ($vetor['empresa_cerimonial'] == 1) {
																															echo "selected=''";
																														} ?>>
                                                                Sim
                                                            </option>
                                                            <option value="2" <?php if ($vetor['empresa_cerimonial'] == 2) {
																															echo "selected=''";
																														} ?>>
                                                                Não
                                                            </option>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group"
                                                              id="empresacerimonial" <?php if ($vetor['empresa_cerimonial'] == 2) {
																											echo "hidden";
																										} ?>>
                                                        <label class="form-label semibold" for="exampleInput">Nome
                                                            da Empresa</label>
                                                        <input type="text" name="nome_cerimonial"
                                                               value="<?php echo $vetor['nome_cerimonial']; ?>"
                                                               class="form-control" id="exampleInput"
                                                               placeholder="Empresa de Festa (cerimonial)?">
                                                    </fieldset>
                                                </div>

                                            </div><!--.row-->

                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Observações</label>
                                                        <textarea name="observacao"
                                                                  class="form-control"><?php echo $vetor['observacao']; ?></textarea>
                                                    </fieldset>
                                                </div>

                                            </div>
                                            <button type="submit" class="btn btn-success"
                                                    style="float: left;">
                                                Salvar
                                            </button>
                                        </form>

                                    </div>
                                    <div class="tab-pane" id="fotografia" role="tabpanel">
                                        <br>
																			<?php if ($vetor['fotografia_viabilidade'] != 'gerado') { ?>
                                          <form action="<?php if ($vetor['fotografia_viabilidade'] == 'inviavel') {
																						echo "recebe_alterarprospeccao.php?id=".$id;
																					}else {
																						echo "recebe_lead.php?id=".$id;
																					} ?>"
                                                enctype="multipart/form-data"
                                                method="post" id="form_fotografia">
                                              <div class="row">

                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Viabilidade
                                                              de
                                                              Negócio?</label>
                                                          <select id="fotografia_viabilidade"
                                                                  name="fotografia_viabilidade"
                                                                  class="form-control">
                                                              <option value="" <?php if ($vetor['fotografia_viabilidade'] == '') {
																																echo "selected=''";
																															} ?>>
                                                                  Selecione uma Opção
                                                              </option>
                                                              <option value="1" <?php if ($vetor['fotografia_viabilidade'] == 'viavel') {
																																echo "selected=''";
																															} ?>>
                                                                  Sim
                                                              </option>
                                                              <option value="2" <?php if ($vetor['fotografia_viabilidade'] == 'inviavel') {
																																echo "selected=''";
																															} ?>>
                                                                  Não
                                                              </option>
                                                          </select>
                                                      </fieldset>
                                                  </div>

                                                  <!--                                            VIABILIDADE-->
                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group"
                                                                id="fotografia_qtdalunos" <?php if ($vetor['fotografia_viabilidade'] != 'viavel') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Quantidade de Formandos</label>
                                                          <input type="text" name="num_formandos"
                                                                 class="form-control">
                                                      </fieldset>
                                                      <fieldset class="form-group"
                                                                id="fotografia_motivo_fechado" <?php if ($vetor['fotografia_viabilidade'] != 'inviavel') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Motivo</label>
                                                          <select id="fotografia_motivo" name="fotografia_motivo"
                                                                  class="form-control">
                                                              <option value="">
                                                                  Selecione um motivo
                                                              </option>
                                                              <option value="1" <?php if ($vetor['fotografia_motivo'] == 'Contrato Fechado com outra Empresa') {
																																echo "selected=''";
																															} ?>>
                                                                  Contrato Fechado com outra empresa
                                                              </option>
                                                              <option value="2" <?php if ($vetor['fotografia_motivo'] == 'Fora do Perfil de atendimento') {
																																echo "selected=''";
																															} ?>>
                                                                  Fora do Perfil de atendimento
                                                              </option>
                                                          </select>
                                                      </fieldset>
                                                  </div>

                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group"
                                                                id="fotografia_empresa_fechado" <?php if ($vetor['fotografia_viabilidade'] != 'inviavel' || $vetor['fotografia_motivo'] == 'Fora do Perfil de atendimento') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Nome da Empresa</label>
                                                          <input type="text" name="fotografia_empresa"
                                                                 value="<?php echo $vetor['fotografia_empresa']; ?>"
                                                                 class="form-control"
                                                                 placeholder="Nome da Empresa">
                                                      </fieldset>
                                                  </div>
                                                  <input type="text" name="qual_produto" class="form-control"
                                                         id="qual_produto"
                                                         value="fotografia" hidden>
                                                  <div class="col-lg-2" <?php if ($vetor['fotografia_viabilidade'] != 'viavel') {
																										echo "hidden";
																									} ?> id="gerar_fotografia">
                                                      <button type="submit" class="btn btn-primary"
                                                              style="float: left;">
                                                          Gerar Lead
                                                      </button>
                                                  </div>
                                                  <div class="col-lg-2" <?php if ($vetor['fotografia_viabilidade'] != 'inviavel') {
																										echo "hidden";
																									} ?> id="salvar_fotografia">
                                                      <button type="submit" class="btn btn-success"
                                                              style="float: left;">
                                                          Salvar
                                                      </button>
                                                  </div>
                                              </div><!--.row-->
                                          </form>
																			<?php }else {
																				$turma_lead = mysqli_fetch_array(mysqli_query($con, "select * from turmas_leads where id_prospeccao='$id'"));
																				?>

                                          <strong><h4>Lead Gerado</h4></strong>
                                          <br>
                                          <a href="alteraroportunidade.php?id=<?php echo $turma_lead['id_turma_lead']; ?>">
                                              <button type="button" class="btn btn-info"
                                                      style="float: left;">
                                                  Ir para o Lead
                                              </button>
                                          </a>
																			<?php } ?>
                                    </div>
                                    <div class="tab-pane" id="convite" role="tabpanel">
                                        <br>
																			<?php if ($vetor['convite_viabilidade'] != 'gerado') { ?>
                                          <form action="<?php if ($vetor['convite_viabilidade'] != 'viavel') {
																						echo "recebe_alterarprospeccao.php?id=".$id;
																					}else {
																						echo "recebe_lead.php?id=".$id;
																					} ?>"
                                                enctype="multipart/form-data"
                                                method="post" id="form_convite">
                                              <div class="row">

                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Viabilidade
                                                              de
                                                              Negócio?</label>
                                                          <select id="convite_viabilidade" name="convite_viabilidade"
                                                                  class="form-control">
                                                              <option value="" <?php if ($vetor['convite_viabilidade'] == '') {
																																echo "selected=''";
																															} ?>>
                                                                  Selecione uma Opção
                                                              </option>
                                                              <option value="1" <?php if ($vetor['convite_viabilidade'] == 'viavel') {
																																echo "selected=''";
																															} ?>>
                                                                  Sim
                                                              </option>
                                                              <option value="2" <?php if ($vetor['convite_viabilidade'] == 'inviavel') {
																																echo "selected=''";
																															} ?>>
                                                                  Não
                                                              </option>
                                                          </select>
                                                      </fieldset>
                                                  </div>

                                                  <!--                                            VIABILIDADE-->
                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group"
                                                                id="convite_qtdalunos" <?php if ($vetor['convite_viabilidade'] != 'viavel') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold" for="exampleInput">Quantidade
                                                              de Formandos</label>
                                                          <input type="text" name="num_formandos"
                                                                 class="form-control">
                                                      </fieldset>
                                                      <fieldset class="form-group"
                                                                id="convite_motivo_fechado" <?php if ($vetor['convite_viabilidade'] != 'inviavel') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Motivo</label>
                                                          <select id="convite_motivo" name="convite_motivo"
                                                                  class="form-control">
                                                              <option value="">
                                                                  Selecione um motivo
                                                              </option>
                                                              <option value="1" <?php if ($vetor['convite_motivo'] == 'Contrato Fechado com outra Empresa') {
																																echo "selected=''";
																															} ?>>
                                                                  Contrato Fechado com outra empresa
                                                              </option>
                                                              <option value="2" <?php if ($vetor['convite_motivo'] == 'Fora do Perfil de atendimento') {
																																echo "selected=''";
																															} ?>>
                                                                  Fora do Perfil de atendimento
                                                              </option>
                                                          </select>
                                                      </fieldset>
                                                  </div>

                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group"
                                                                id="convite_empresa_fechado" <?php if ($vetor['convite_viabilidade'] != 'inviavel' || $vetor['convite_motivo'] == 'Fora do Perfil de atendimento') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Nome da Empresa</label>
                                                          <input type="text" name="convite_empresa"
                                                                 value="<?php echo $vetor['convite_empresa']; ?>"
                                                                 class="form-control"
                                                                 placeholder="Nome da Empresa">
                                                      </fieldset>
                                                  </div>
                                                  <input type="text" name="qual_produto" class="form-control"
                                                         id="qual_produto"
                                                         value="convite" hidden>
                                                  <div class="col-lg-2" <?php if ($vetor['convite_viabilidade'] != 'viavel') {
																										echo "hidden";
																									} ?> id="gerar_convite">
                                                      <button type="submit" class="btn btn-primary"
                                                              style="float: left;">
                                                          Gerar Lead
                                                      </button>
                                                  </div>
                                                  <div class="col-lg-2" <?php if ($vetor['convite_viabilidade'] != 'inviavel') {
																										echo "hidden";
																									} ?> id="salvar_convite">
                                                      <button type="submit" class="btn btn-success"
                                                              style="float: left;">
                                                          Salvar
                                                      </button>
                                                  </div>
                                              </div><!--.row-->
                                          </form>
																			<?php }else {
																				$turma_lead = mysqli_fetch_array(mysqli_query($con, "select * from turmas_leads where id_prospeccao='$id'"));
																				?>

                                          <strong><h4>Lead Gerado</h4></strong>
                                          <br>
                                          <a href="alteraroportunidade.php?id=<?php echo $turma_lead['id_turma_lead']; ?>">
                                              <button type="button" class="btn btn-info"
                                                      style="float: left;">
                                                  Ir para o Lead
                                              </button>
                                          </a>
																			<?php } ?>
                                    </div>
                                    <div class="tab-pane" id="ensaio" role="tabpanel">
                                        <br>
																			<?php if ($vetor['ensaio_viabilidade'] != 'gerado') { ?>
                                          <form action="<?php if ($vetor['ensaio_viabilidade'] != 'viavel') {
																						echo "recebe_alterarprospeccao.php?id=".$id;
																					}else {
																						echo "recebe_lead.php?id=".$id;
																					} ?>"
                                                enctype="multipart/form-data"
                                                method="post" id="form_ensaio">
                                              <div class="row">

                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Viabilidade
                                                              de
                                                              Negócio?</label>
                                                          <select id="ensaio_viabilidade" name="ensaio_viabilidade"
                                                                  class="form-control">
                                                              <option value="" <?php if ($vetor['ensaio_viabilidade'] == '') {
																																echo "selected=''";
																															} ?>>
                                                                  Selecione uma Opção
                                                              </option>
                                                              <option value="1" <?php if ($vetor['ensaio_viabilidade'] == 'viavel') {
																																echo "selected=''";
																															} ?>>
                                                                  Sim
                                                              </option>
                                                              <option value="2" <?php if ($vetor['ensaio_viabilidade'] == 'inviavel') {
																																echo "selected=''";
																															} ?>>
                                                                  Não
                                                              </option>
                                                          </select>
                                                      </fieldset>
                                                  </div>

                                                  <!--                                            VIABILIDADE-->
                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group"
                                                                id="ensaio_qtdalunos" <?php if ($vetor['ensaio_viabilidade'] != 'viavel') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold" for="exampleInput">Quantidade
                                                              de Formandos</label>
                                                          <input type="text" name="num_formandos"
                                                                 class="form-control">
                                                      </fieldset>
                                                      <fieldset class="form-group"
                                                                id="ensaio_motivo_fechado" <?php if ($vetor['ensaio_viabilidade'] != 'inviavel') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Motivo</label>
                                                          <select id="ensaio_motivo" name="ensaio_motivo"
                                                                  class="form-control">
                                                              <option value="">
                                                                  Selecione um motivo
                                                              </option>
                                                              <option value="1" <?php if ($vetor['ensaio_motivo'] == 'Contrato Fechado com outra Empresa') {
																																echo "selected=''";
																															} ?>>
                                                                  Contrato Fechado com outra empresa
                                                              </option>
                                                              <option value="2" <?php if ($vetor['ensaio_motivo'] == 'Fora do Perfil de atendimento') {
																																echo "selected=''";
																															} ?>>
                                                                  Fora do Perfil de atendimento
                                                              </option>
                                                          </select>
                                                      </fieldset>
                                                  </div>

                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group"
                                                                id="ensaio_empresa_fechado" <?php if ($vetor['ensaio_viabilidade'] != 'inviavel' || $vetor['ensaio_motivo'] == 'Fora do Perfil de atendimento') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Nome da Empresa</label>
                                                          <input type="text" name="ensaio_empresa"
                                                                 value="<?php echo $vetor['ensaio_empresa']; ?>"
                                                                 class="form-control"
                                                                 placeholder="Nome da Empresa">
                                                      </fieldset>
                                                  </div>
                                                  <input type="text" name="qual_produto" class="form-control"
                                                         id="qual_produto"
                                                         value="ensaio" hidden>
                                                  <div class="col-lg-2" <?php if ($vetor['ensaio_viabilidade'] != 'viavel') {
																										echo "hidden";
																									} ?> id="gerar_ensaio">
                                                      <button type="submit" class="btn btn-primary"
                                                              style="float: left;">
                                                          Gerar Lead
                                                      </button>
                                                  </div>
                                                  <div class="col-lg-2" <?php if ($vetor['ensaio_viabilidade'] != 'inviavel') {
																										echo "hidden";
																									} ?> id="salvar_ensaio">
                                                      <button type="submit" class="btn btn-success"
                                                              style="float: left;">
                                                          Salvar
                                                      </button>
                                                  </div>
                                              </div><!--.row-->
                                          </form>
																			<?php }else {
																				$turma_lead = mysqli_fetch_array(mysqli_query($con, "select * from turmas_leads where id_prospeccao='$id'"));
																				?>

                                          <strong><h4>Lead Gerado</h4></strong>
                                          <br>
                                          <a href="alteraroportunidade.php?id=<?php echo $turma_lead['id_turma_lead']; ?>">
                                              <button type="button" class="btn btn-info"
                                                      style="float: left;">
                                                  Ir para o Lead
                                              </button>
                                          </a>
																			<?php } ?>
                                    </div>
                                    <div class="tab-pane" id="placa" role="tabpanel">
                                        <br>
																			<?php if ($vetor['placa_viabilidade'] != 'gerado') { ?>
                                          <form action="<?php if ($vetor['placa_viabilidade'] != 'viavel') {
																						echo "recebe_alterarprospeccao.php?id=".$id;
																					}else {
																						echo "recebe_lead.php?id=".$id;
																					} ?>"
                                                enctype="multipart/form-data"
                                                method="post" id="form_placa">
                                              <div class="row">

                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Viabilidade
                                                              de
                                                              Negócio?</label>
                                                          <select id="placa_viabilidade" name="placa_viabilidade"
                                                                  class="form-control">
                                                              <option value="" <?php if ($vetor['placa_viabilidade'] == '') {
																																echo "selected=''";
																															} ?>>
                                                                  Selecione uma Opção
                                                              </option>
                                                              <option value="1" <?php if ($vetor['placa_viabilidade'] == 'viavel') {
																																echo "selected=''";
																															} ?>>
                                                                  Sim
                                                              </option>
                                                              <option value="2" <?php if ($vetor['placa_viabilidade'] == 'inviavel') {
																																echo "selected=''";
																															} ?>>
                                                                  Não
                                                              </option>
                                                          </select>
                                                      </fieldset>
                                                  </div>

                                                  <!--                                            VIABILIDADE-->
                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group"
                                                                id="placa_qtdalunos" <?php if ($vetor['placa_viabilidade'] != 'viavel') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold" for="exampleInput">Quantidade
                                                              de Formandos</label>
                                                          <input type="text" name="num_formandos"
                                                                 class="form-control">
                                                      </fieldset>
                                                      <fieldset class="form-group"
                                                                id="placa_motivo_fechado" <?php if ($vetor['placa_viabilidade'] != 'inviavel') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Motivo</label>
                                                          <select id="placa_motivo" name="placa_motivo"
                                                                  class="form-control">
                                                              <option value="">
                                                                  Selecione um motivo
                                                              </option>
                                                              <option value="1" <?php if ($vetor['placa_motivo'] == 'Contrato Fechado com outra Empresa') {
																																echo "selected=''";
																															} ?>>
                                                                  Contrato Fechado com outra empresa
                                                              </option>
                                                              <option value="2" <?php if ($vetor['placa_motivo'] == 'Fora do Perfil de atendimento') {
																																echo "selected=''";
																															} ?>>
                                                                  Fora do Perfil de atendimento
                                                              </option>
                                                          </select>
                                                      </fieldset>
                                                  </div>

                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group"
                                                                id="placa_empresa_fechado" <?php if ($vetor['placa_viabilidade'] != 'inviavel' || $vetor['placa_motivo'] == 'Fora do Perfil de atendimento') {
																												echo "hidden";
																											} ?>>
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Nome da Empresa</label>
                                                          <input type="text" name="placa_empresa"
                                                                 value="<?php echo $vetor['placa_empresa']; ?>"
                                                                 class="form-control"
                                                                 placeholder="Nome da Empresa">
                                                      </fieldset>
                                                  </div>
                                                  <input type="text" name="qual_produto" class="form-control"
                                                         id="qual_produto"
                                                         value="placa" hidden>
                                                  <div class="col-lg-2" <?php if ($vetor['placa_viabilidade'] != 'viavel') {
																										echo "hidden";
																									} ?> id="gerar_placa">
                                                      <button type="submit" class="btn btn-primary"
                                                              style="float: left;">
                                                          Gerar Lead
                                                      </button>
                                                  </div>
                                                  <div class="col-lg-2" <?php if ($vetor['placa_viabilidade'] != 'inviavel') {
																										echo "hidden";
																									} ?> id="salvar_placa">
                                                      <button type="submit" class="btn btn-success"
                                                              style="float: left;">
                                                          Salvar
                                                      </button>
                                                  </div>
                                              </div><!--.row-->
                                          </form>
																			<?php }else {
																				$turma_lead = mysqli_fetch_array(mysqli_query($con, "select * from turmas_leads where id_prospeccao='$id'"));
																				?>

                                          <strong><h4>Lead Gerado</h4></strong>
                                          <br>
                                          <a href="alteraroportunidade.php?id=<?php echo $turma_lead['id_turma_lead']; ?>">
                                              <button type="button" class="btn btn-info"
                                                      style="float: left;">
                                                  Ir para o Lead
                                              </button>
                                          </a>
																			<?php } ?>
                                    </div>
                                    <div class="tab-pane" id="interacoes" role="tabpanel">

                                        <br>
                                        <br>

                                        <a href="cadastro_interacao.php?id=<?php echo $id; ?>&prospeccao=sim"
                                        >
                                            <button type="button" class="btn btn-primary" style="    float: left;">
                                                Cadastrar Interação
                                            </button>
                                        </a>

                                        <br>
                                        <br>
                                        <br>

                                        <table id="lang_opt" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th><strong><h5>Data</h5></strong></th>
                                                <th><strong><h5>Hora</h5></strong></th>
                                                <th><strong><h5>Meio</h5></strong></th>
                                                <th><strong><h5>Assunto</h5></strong></th>
                                                <th><strong><h5>Ocorrência</h5></strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
																						<?php
																						$sql_interacoes = mysqli_query($con, "select * from interacao_mkt where id_prospeccao = '$id' order by id_interacao DESC");
																						while ($vetor_interacao = mysqli_fetch_array($sql_interacoes)) {
																							?>
                                                <tr>
                                                    <td><?php echo date('d/m/Y', strtotime($vetor_interacao['data'])); ?></td>
                                                    <td><?php echo $vetor_interacao['hora']; ?></td>
                                                    <td><?php echo $vetor_interacao['tipo']; ?></td>
                                                    <td><?php echo $vetor_interacao['assunto']; ?></td>
                                                    <td><?php echo $vetor_interacao['ocorrencia']; ?></td>
                                                </tr>
																						<?php } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="tab-pane" id="documentos" role="tabpanel">

                                        <br>
                                        <br>
                                        <button type="button" class="btn btn-primary" style="    float: left;"
                                                data-toggle="modal" data-target="#modal-default">
                                            Cadastrar Arquivo
                                        </button>

                                        <br>
                                        <br>
                                        <br>

                                        <table id="lang_opt1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th><strong><h5>Titulo</h5></strong></th>
                                                <th><strong><h5>Produto</h5></strong></th>
                                                <th><strong><h5>Data</h5></strong></th>
                                                <th><strong><h5>Hora</h5></strong></th>
                                                <th><strong><h5>Arquivo</h5></strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
																						<?php
																						$sql_arquivos = mysqli_query($con, "select * from arquivos_mkt where id_prospeccao = '$id' order by id_arquivo DESC");
																						while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
																							?>
                                                <tr>
                                                    <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                    <td><?php echo $vetor_arquivo['produto']; ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?></td>
                                                    <td><?php echo substr($vetor_arquivo['hora'], 0, 5); ?></td>
                                                    <td><a href="arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                        >
                                                            <button type="button" class="btn btn-default">Arquivo
                                                            </button>
                                                        </a>
                                                        <a href="excluirarquivoprospeccao.php?id=<?php echo $vetor_arquivo['id_arquivo']; ?>&id1=<?php echo $id; ?>"
                                                        >
                                                            <button type="button" class="btn btn-danger mesmo-tamanho"
                                                                    title="Excluir Cadastro"><i
                                                                        class="mdi mdi-window-close"></i></button>
                                                        </a>
                                                    </td>
                                                </tr>
																						<?php } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="tab-pane" id="contatos" role="tabpanel">

                                        <br>
                                        <br>

                                        <a href="cadastro_contato.php?id=<?php echo $id; ?>&prospeccao=sim">
                                            <button type="button" class="btn btn-primary" style="    float: left;">
                                                Cadastrar Contato
                                            </button>
                                        </a>

                                        <br>
                                        <br>
                                        <br>

                                        <table id="lang_opt2" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th><strong><h5>Nome</h5></strong></th>
                                                <th><strong><h5>Telefone</h5></strong></th>
                                                <th><strong><h5>E-mail</h5></strong></th>
                                                <th><strong><h5>Tipo de Cliente</h5></strong></th>
                                                <th><strong><h5>Ação</h5></strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
																						<?php
																						$sql_contatos = mysqli_query($con, "select * from contatos_mkt where id_prospeccao = '$id' order by nome ASC");
																						while ($vetor_contato = mysqli_fetch_array($sql_contatos)) {
																							?>
                                                <tr>
                                                    <td><?php echo $vetor_contato['nome']; ?></td>
                                                    <td><?php echo $vetor_contato['telefone']; ?></td>
                                                    <td><?php echo $vetor_contato['email']; ?></td>
                                                    <td><?php if ($vetor_contato['comissao'] == '') { ?>
                                                            <button type="button"
                                                                    class="btn btn-block btn-success btn-sm">Formando
                                                            </button><?php }
																											if ($vetor_contato['comissao'] == '1') { ?>
                                                          <button type="button"
                                                                  class="btn btn-block btn-success btn-sm">Formando
                                                          </button><?php }
																											if ($vetor_contato['comissao'] == 2) { ?>
                                                          <button type="button"
                                                                  class="btn btn-block btn-danger btn-sm">Comissão
                                                          </button><?php } ?></td>
                                                    <td><a
                                                                href="alterarcontatoturma.php?id=<?php echo $vetor_contato['id_contato']; ?>&id1=<?php echo $id; ?>"
                                                        >
                                                            <button type="button" class="btn btn-info mesmo-tamanho"
                                                                    title="Ver ou Alterar Cadastro"><i
                                                                        class="fa fa-edit"></i></button>
                                                        </a>
                                                        <a
                                                                href="excluircontatoturma.php?id=<?php echo $vetor_contato['id_contato']; ?>&id1=<?php echo $id; ?>"
                                                        >
                                                            <button type="button" class="btn btn-danger mesmo-tamanho"
                                                                    title="Excluir Cadastro"><i
                                                                        class="mdi mdi-window-close"></i></button>
                                                        </a>
                                                    </td>
                                                </tr>
																						<?php } ?>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="modal-default" class="modal fade"
                 role="dialog" aria-hidden="true" tabindex="-1">
                <div class="modal-dialog" role="document" style=";display:table;">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cadastrar Anexo</h4>
                        </div>
                        <form action="recebe_arquivoprospeccao.php?id=<?php echo $id; ?>"
                              enctype="multipart/form-data"
                              method="post">
                            <div class="modal-body" id="cadastrar_arquivo">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <fieldset class="form-group">
                                            <label class="form-label semibold" for="exampleInput">Titulo</label>
                                            <input type="text" name="titulo" class="form-control" id="exampleInput"
                                                   placeholder="Digite o Titulo" required>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-6">
                                        <fieldset class="form-group">
                                            <label class="form-label semibold" for="exampleInput">Arquivo</label>
                                            <input type="file" name="arquivo" class="form-control" id="exampleInput"
                                                   required>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-12">
                                        <fieldset class="form-group">
                                            <label class="form-label semibold" for="exampleInput">Tipo</label>
                                            <select name="tipo" class="form-control">
                                                <option value="Fotografia" selected="">Fotografia</option>
                                                <option value="Convite">Convite</option>
                                                <option value="Ensaio">Ensaio</option>
                                                <option value="Placa">Placa</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Cadastrar
                                </button>
                                <button type="button"
                                        class="btn btn-danger"
                                        data-dismiss="modal">Fechar
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- ./wrapper -->
            <input type="text" id="id"
                   value="<?php echo $id; ?>" hidden>
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