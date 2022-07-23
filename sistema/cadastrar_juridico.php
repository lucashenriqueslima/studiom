<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$id = $_GET['id'];
	$sql = mysqli_query($con, "select * from hds where id_hd = '$id'");
	$vetor = mysqli_fetch_array($sql);
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
<!--                        <h4 class="page-title">Jurídico</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Jurídico</a></li>
                                    <li class="breadcrumb-item">Processos</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cadastrar Processo</li>
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
<!--                                <h4 class="card-title">Cadastro de HD</h4>-->

                                <form action="recebe_juridico.php" method="post" name="cliente"
                                      enctype="multipart/form-data" id="formID">

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">N°
                                                    Processo</label>
                                                <input type="number" name="nprocesso" class="form-control"
                                                       id="exampleInput" placeholder="Digite o nome" required>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Partes</label>
                                                <select name="tipoparte" id="tipo" class="form-control" required="">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1_1">Autor</option>
                                                    <option value="2_1">Réu</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Qualificar
                                                    Partes</label>
                                                <select name="tipoqualificar" id="tipopartes" class="form-control">

                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Comissão de Formatura</option>
                                                    <option value="2">Formando</option>
                                                    <option value="3">Colaborador</option>
                                                    <option value="4">Outros</option>

                                                </select>
                                            </fieldset>
                                        </div>

                                        <div id="palco1">
                                            <div id="1">

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Contrato</label>
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
																															        <?php if (strcasecmp($vetor['id_turma'], $vetor_curso['id_turma']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_curso['ncontrato'] ?>
                                                                  - <?php echo $vetor_curso['nome'] ?> <?php echo $vetor_curso['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?></option>
																													<?php } ?>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Contrato</label>
                                                        <select name="id_responsavel" id="solicitante"
                                                                class="form-control" required="">
                                                            <option value="">Escolha um Contrato</option>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div id="2">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Contrato</label>
                                                        <select name="id_turma" id="turmas1" class="form-control">
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
																															        <?php if (strcasecmp($vetor['id_turma'], $vetor_curso['id_turma']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_curso['ncontrato'] ?>
                                                                  - <?php echo $vetor_curso['nome'] ?> <?php echo $vetor_curso['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?></option>
																													<?php } ?>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Formando</label>
                                                        <select name="id_responsavel1" id="formando"
                                                                class="form-control">
                                                            <option value="">Escolha um Contrato</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div id="3">

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Colaborador</label>
                                                        <select name="id_responsavel2" class="form-control">
                                                            <option value="" selected="selected">Selecione...</option>
																													<?php
																													$sql_colaboradores = mysqli_query($con, "select * from colaboradores order by nome ASC");
																													while ($vetor_colaborador = mysqli_fetch_array($sql_colaboradores)) {
																														?>
                                                              <option value="<?php echo $vetor_colaborador['id_colaborador']; ?>"><?php echo $vetor_colaborador['nome'] ?></option>
																													<?php } ?>
                                                        </select>

                                                    </div>
                                                </div>

                                            </div>

                                            <div id="4">

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Outros</label>

                                                        <input type="text" name="responsaveloutro" class="form-control">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div><!--.row-->

                                    <div id="palco">

                                        <div id="1_1">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Data do
                                                            Protocolo</label>
                                                        <input type="date" name="dataprotocolo" class="form-control">
                                                    </fieldset>
                                                </div>
                                            </div>

                                        </div>

                                        <div id="2_1">

                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Data do
                                                            recebimento da notificação</label>
                                                        <input type="date" name="datarecebimento" class="form-control">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Tipo de
                                                            Notificação</label>
                                                        <select name="tiponotificacao" class="form-control">
                                                            <option value="" selected="">Selecione...</option>
                                                            <option value="1">AR</option>
                                                            <option value="2">Oficial de Justiça</option>
                                                            <option value="3">Edital</option>
                                                            <option value="4">E-mail</option>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Liminar?</label>
                                                <select name="pedidoliminar" id="liminar" class="form-control">

                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1_2">Sim</option>
                                                    <option value="2_2">Não</option>

                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div id="palco2">

                                        <div id="1_2">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Descrição
                                                            Liminar</label>
                                                        <textarea name="descricaolimitar" class="ckeditor"
                                                                  id="editor1"><?php echo $vetor['descricaolimitar']; ?></textarea>
                                                    </fieldset>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <h3>Recursos</h3>

                                    <div id="origem">

                                        <div class="row">

                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Data</label>
                                                    <input type="date" name="datarecurso[]" class="form-control">
                                                </fieldset>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Descrição</label>
                                                    <textarea name="julgado[]" class="ckeditor" id="editor1"></textarea>
                                                </fieldset>
                                            </div>

                                        </div>

                                    </div>

                                    <div id="destino">
                                    </div>
                                    <br>
                                    <input type="button" value="Adicionar Recurso" onclick="duplicarCampos();"
                                           class="btn btn-warning">
                                    <input type="button" value="Excluir Recurso" onclick="removerCampos(this);"
                                           class="btn btn-danger">

                                    <br>
                                    <br>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Valor da
                                                    Causa</label>
                                                <input type="text" name="valorcausa" class="form-control"
                                                       onKeyPress="mascara(this,mvalor)">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Natureza da
                                                    Ação</label>
                                                <select name="naturezaacao" class="form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="Trabalhista">Trabalhista</option>
                                                    <option value="Cível">Cível</option>
                                                    <option value="Tributária">Tributária</option>
                                                    <option value="Penal">Penal</option>
                                                    <option value="Ambiental">Ambiental</option>
                                                    <option value="Outros">Outros</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Ocorrência</label>
                                                <textarea name="ocorrencia" class="ckeditor" id="editor1"></textarea>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Providências
                                                    Preliminares</label>
                                                <textarea name="providencias" class="ckeditor" id="editor1"></textarea>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Objeto da
                                                    Ação</label>
                                                <input type="text" name="objetoacao" class="form-control">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Cidade</label>
                                                <input type="text" name="cidade" class="form-control">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Estado</label>
                                                <input type="text" name="estado" class="form-control">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">N° Vara</label>
                                                <input type="text" name="nvara" class="form-control">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Tipo de
                                                    Vara</label>
                                                <input type="text" name="tipovara" class="form-control">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Fase</label>
                                                <select name="fase" id="fase" class="form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1_3">Inicial</option>
                                                    <option value="2_3">Contestação</option>
                                                    <option value="3_3">Recursal</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div id="palco3">

                                        <div id="3_3">

                                            <div id="origem1">

                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold"
                                                                   for="exampleInput">Data</label>
                                                            <input type="date" name="datarecurso1[]"
                                                                   class="form-control">
                                                        </fieldset>
                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold" for="exampleInput">Descrição</label>
                                                            <textarea name="julgado1[]" class="ckeditor"
                                                                      id="editor1"></textarea>
                                                        </fieldset>
                                                    </div>

                                                </div>

                                            </div>

                                            <div id="destino1">
                                            </div>
                                            <br>
                                            <input type="button" value="Adicionar Recurso" onclick="duplicarCampos1();"
                                                   class="btn btn-warning">
                                            <input type="button" value="Excluir Recurso" onclick="removerCampos1(this);"
                                                   class="btn btn-danger">

                                            <br>
                                            <br>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Cumprimento de
                                                    Sentença</label>
                                                <input type="text" name="cumprimentosentenca" class="form-control">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Data
                                                    Audiência</label>
                                                <input type="date" name="dataaudiencia" class="form-control">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Tipo
                                                    Audiência</label>
                                                <select name="tipoaudiencia" class="form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Conciliação</option>
                                                    <option value="2">Instrução e Julgamento</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Relatar
                                                    audiência</label>
                                                <textarea name="relataraudiencia" class="ckeditor"
                                                          id="editor1"></textarea>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Sentença</label>
                                                <select name="sentenca" id="sentenca" class="form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1_4">Favorável</option>
                                                    <option value="2_4">Desfavorável</option>
                                                    <option value="3_4">Parcialmente</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div id="palco4">

                                            <div id="1_4">

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Descrição
                                                            Sentença</label>
                                                        <input type="text" name="descricaosentenca"
                                                               class="form-control">
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div id="2_4">

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Descrição
                                                            Sentença</label>
                                                        <input type="text" name="descricaosentenca1"
                                                               class="form-control">
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div id="3_4">

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Descrição
                                                            Sentença</label>
                                                        <input type="text" name="descricaosentenca2"
                                                               class="form-control">
                                                    </fieldset>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Data
                                                    Sentença</label>
                                                <input type="date" name="datasentenca" class="form-control">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Recurso</label>
                                                <select name="recursofinal" id="recursofinal" class="form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1_5">Sim</option>
                                                    <option value="2_5">Não</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div id="palco5">

                                        <div id="1_5">

                                            <div id="origem2">

                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold"
                                                                   for="exampleInput">Data</label>
                                                            <input type="date" name="datarecurso2[]"
                                                                   class="form-control">
                                                        </fieldset>
                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold" for="exampleInput">Descrição</label>
                                                            <textarea name="julgado2[]" class="ckeditor"
                                                                      id="editor1"></textarea>
                                                        </fieldset>
                                                    </div>

                                                </div>

                                            </div>

                                            <div id="destino2">
                                            </div>
                                            <br>
                                            <input type="button" value="Adicionar Recurso" onclick="duplicarCampos2();"
                                                   class="btn btn-warning">
                                            <input type="button" value="Excluir Recurso" onclick="removerCampos2(this);"
                                                   class="btn btn-danger">

                                            <br>
                                            <br>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Tipo
                                                    Despesa</label>
                                                <input type="text" name="tipodespesa" class="form-control">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Valor
                                                    Despesa</label>
                                                <input type="text" name="valordespesa" onKeyPress="mascara(this,mvalor)"
                                                       class="form-control">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Data
                                                    Despesa</label>
                                                <input type="date" name="datadespesa" class="form-control">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Forma
                                                    Despesa</label>
                                                <select name="forma" class="form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Reembolso</option>
                                                    <option value="2">Pagamento</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div id="origem3">

                                        <div class="row">

                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Título
                                                        Histórico Processual</label>
                                                    <input type="text" name="titulo[]" class="form-control">
                                                </fieldset>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Histórico
                                                        Processual</label>
                                                    <textarea name="descricaoprocessual[]" class="ckeditor"
                                                              id="editor1"></textarea>
                                                </fieldset>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Descrição</label>
                                                    <select name="id_responsavelmov[]" class="form-control">
                                                        <option value="" selected="selected">Selecione...</option>
																											<?php
																											$sql_colaboradores = mysqli_query($con, "select * from colaboradores order by nome ASC");
																											while ($vetor_colaborador = mysqli_fetch_array($sql_colaboradores)) {
																												?>
                                                          <option value="<?php echo $vetor_colaborador['id_colaborador']; ?>"><?php echo $vetor_colaborador['nome'] ?></option>
																											<?php } ?>
                                                    </select>
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Prazo para
                                                        conclusão</label>
                                                    <input type="date" name="prazoconclusao[]" class="form-control">
                                                </fieldset>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Prognótico</label>
                                                    <textarea name="prognostico[]" class="ckeditor"
                                                              id="editor1"></textarea>
                                                </fieldset>
                                            </div>

                                        </div>

                                    </div>

                                    <div id="destino3">
                                    </div>
                                    <br>
                                    <input type="button" value="Adicionar Movimentação" onclick="duplicarCampos3();"
                                           class="btn btn-warning">
                                    <input type="button" value="Excluir Movimentação" onclick="removerCampos3(this);"
                                           class="btn btn-danger">

                                    <br>
                                    <br>


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