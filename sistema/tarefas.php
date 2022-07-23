<?php
include "../includes/conexao.php";
session_start();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $today = date('Y-m-d');
    $data = (isset($_POST['data'])?($_POST['data'] != ''?$_POST['data']:$today):$today);
	$hora = (isset($_POST['hora'])?($_POST['hora'] != ''?$_POST['hora']:'08:00'):'08:00'). ':00';
	$datafim = (isset($_POST['datafim'])?($_POST['datafim'] != ''?$_POST['datafim']:$data):$data);
	$horafim = (isset($_POST['horafim'])?($_POST['horafim'] != ''?$_POST['horafim']:'18:00'):'18:00'). ':00';
    $responsavel = $_POST['responsavel'];
    mysqli_query($con, "UPDATE calendario SET `data` = '$data',hora='$hora',datafim='$datafim',horafim='$horafim',id_colaborador='$responsavel' WHERE id_calendario = '$id'");
    die();
}

$departamento = $_GET['departamento'];
$id_pagina = 0;

switch ($departamento) {
    case 1:
        $id_pagina = 16;
        break;
    case 2:
        $id_pagina = 29;
        break;
    case 3:
        $id_pagina = 26;
        break;
    case 4:
        $id_pagina = 35;
        break;
    case 5:
        $id_pagina = 36;
        break;
    case 7:
        $id_pagina = 16;
        break;
    case 9:
        $id_pagina = 30;
        break;
    case 10:
        $id_pagina = 30;
        break;
    case 11:
        $id_pagina = 38;
        break;
    case 12:
        $id_pagina = 40;
        break;
    default:
        $id_pagina = 0;
        break;
}

if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
} else {
    $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
    $vetor_permissao = mysqli_fetch_array($sql_permissao);
    if ($vetor_permissao['listar'] != 2 and $id_pagina != 0) {
        echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
    }
    if ($vetor_permissao['listar'] == 2 or $id_pagina == 0) {
        $sql_depto = mysqli_query($con, "select * from departamentos");
        $depto = array();
        while ($deptoAux = mysqli_fetch_array($sql_depto)) {
            $depto[$deptoAux['id_departamento']]['nome'] = $deptoAux['nome'];
            $depto[$deptoAux['id_departamento']]['cor'] = $deptoAux['corcalendario'];
        }
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
            <script type="text/javascript">
                function enviarTarefa(id) {
                    var dataE = $('#data' + id).val();
                    var horaE = $('#hora' + id).val();
                    var datafimE = $('#datafim' + id).val();
                    var horafimE = $('#horafim' + id).val();
                    var responsavel = $('#responsavel' + id).val();
                    $.post('tarefas.php',
                        {
                            id: id,
                            data: dataE,
                            hora: horaE,
                            datafim: datafimE,
                            horafim: horafimE,
                            responsavel: responsavel
                        }
                    )
                    window.location.reload(true);
                }
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
                                        Sair
                                    </a>
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
                                        <?php
                                        switch ($departamento) {
                                            case 0:
                                                echo "<li class=\"breadcrumb-item\">Interatividades</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 1:
                                                echo "<li class=\"breadcrumb-item\">Comercial</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 2:
                                                echo "<li class=\"breadcrumb-item\">Eventos</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 3:
                                                echo "<li class=\"breadcrumb-item\">Projetos</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 4:
                                                echo "<li class=\"breadcrumb-item\">Financeiro</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 5:
                                                echo "<li class=\"breadcrumb-item\">Vendas</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 7:
                                                echo "<li class=\"breadcrumb-item\">Marketing</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 9:
                                                echo "<li class=\"breadcrumb-item\">Criação</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 10:
                                                echo "<li class=\"breadcrumb-item\">Fotografia</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 11:
                                                echo "<li class=\"breadcrumb-item\">Jurídico</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 12:
                                                echo "<li class=\"breadcrumb-item\">RH</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                            case 13:
                                                echo "<li class=\"breadcrumb-item\">Arte Final</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 15:
                                                echo "<li class=\"breadcrumb-item\">Impressão</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                            case 16:
                                                echo "<li class=\"breadcrumb-item\">Produção</a></li>
                                        <li class=\"breadcrumb-item active\" aria-current=\"page\">Tarefas</li>";
                                                break;
                                        }
                                        ?>

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
                                    <!--                                  <h4 class="card-title">Tarefas</h4>-->

                                    <?php if ($vetor_permissao['cadastro'] == 1) {
                                    } else { ?><a href="cadastrar_tarefa.php">
                                        <button type="button" class="btn waves-effect waves-light btn-warning">Nova
                                            Tarefa
                                        </button>
                                    </a>

                                        <br>
                                        <br>

                                    <?php } ?>

                                    <br>
                                    <br>

                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item"><a class="nav-link  active" data-toggle="tab"
                                                                href="#emaberto"
                                                                role="tab"><span class="hidden-sm-up"><i
                                                            class="ti-email"></i></span> <span class="hidden-xs-down">Em Aberto</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#concluidas"
                                                                role="tab"><span class="hidden-sm-up"><i
                                                            class="ti-email"></i></span> <span class="hidden-xs-down">Concluídas</span></a>
                                        </li>

                                    </ul>

                                    <div class="tab-content tabcontent-border">

                                        <div class="tab-pane active" id="emaberto" role="tabpanel">

                                            <br>
                                            <br>

                                            <div class="table-responsive">
                                                <table id="lang_opt2" class="table table-striped table-bordered display"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <tr>
                                                        <th><strong><h4>Título</h4></strong></th>
                                                        <th><strong><h4>Data de Inclusão</h4></strong></th>
                                                        <th><strong><h4>Data Prevista</h4></strong></th>
                                                        <th><strong><h4>Hora Prevista</h4></strong></th>
                                                        <?php if ($departamento == 0) {
                                                            echo "<th><strong><h4>Departamento</h4></strong></th>";
                                                        } ?>
                                                        <th><strong><h4>Responsável</strong></h4></th>
                                                        <?php if ($departamento != 0) {
                                                            echo "<th><strong><h4>Ação</h4></strong></th>";
                                                        } ?>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    if ($departamento == 0) {
                                                        $sql_atual = mysqli_query($con, "select * from calendario where status is NULL and tarefa=1");
                                                    } else {
                                                        $sql_atual = mysqli_query($con, "select * from calendario where status is NULL and departamento = '$departamento' and tarefa = 1 order by data ASC");
                                                    }
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        $usuarioConclusão = mysqli_fetch_array(mysqli_query($con, "select * from usuarios where id_usuario = '$vetor[id_colaborador]'"));
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $vetor['titulo']; ?></td>
                                                            <td align="center"><?php echo($vetor['datainclusao'] != null ? date('d/m/Y', strtotime($vetor['datainclusao'])) : ''); ?></td>
                                                            <td align="center"><?php echo($vetor['datafim'] != null ? date('d/m/Y', strtotime($vetor['datafim'])) : ''); ?></td>
                                                            <td align="center"><?php
                                                                if ($vetor['hora'] != null) {
                                                                    $horaexplode1 = explode(':', $vetor['horafim']);
                                                                    echo $horaexplode1[0] . ':' . $horaexplode1[1];
                                                                } else {
                                                                    echo '';
                                                                } ?>
                                                            </td>
                                                            <?php if ($departamento == 0) { ?>
                                                                <td>
                                                                    <button type="button"
                                                                            class="btn btn-block btn-sm" style="background-color: <?php echo $depto[$vetor['departamento']]['cor']; ?>;border-color: <?php echo $depto[$vetor['departamento']]['cor']; ?>;"><?php echo $depto[$vetor['departamento']]['nome']; ?>
                                                                    </button>
                                                                </td>
                                                            <?php } ?>
                                                            <td><?php echo $usuarioConclusão['nome']; ?></td>
                                                            <?php if ($departamento != 0) { ?>
                                                                <td align="center">
                                                                    <?php if ($vetor['hora'] != null and $vetor['horafim'] != null and $vetor['data'] != null and $vetor['datafim'] != null) { ?>
                                                                        <a class="fancybox fancybox.ajax"
                                                                           href="vertarefa.php?id=<?php echo $vetor['id_calendario']; ?>"
                                                                           target="_blank">
                                                                            <button type="button"
                                                                                    class="btn btn-success"
                                                                                    title="Ver ou Alterar Cadastro"><i
                                                                                        class="mdi mdi-tooltip-edit"></i>
                                                                            </button>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <button type="button" data-toggle="modal"
                                                                                data-target="#modal<?php echo $vetor['id_calendario']; ?>"
                                                                                class="btn btn-info"
                                                                        ><i
                                                                                    class="mdi mdi-tooltip-edit"></i>
                                                                        </button>
                                                                        <div id="modal<?php echo $vetor['id_calendario']; ?>"
                                                                             class="modal" tabindex="-1" role="dialog">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title">
                                                                                            Tarefa</h5>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                <fieldset
                                                                                                        class="form-group">
                                                                                                    <label class="form-label semibold"
                                                                                                           for="exampleInput">Descrição
                                                                                                        da
                                                                                                        Tarefa</label>
                                                                                                    <textarea
                                                                                                            name="descricao"
                                                                                                            class="ckeditor form-control"
                                                                                                            id="descricao<?php echo $vetor['id_calendario']; ?>"
                                                                                                            readonly>
                                                                                                    <?php echo $vetor['descricao'] ?>
                                                                                                </textarea>
                                                                                                </fieldset>
                                                                                            </div>
                                                                                        </div><!--.row-->

                                                                                        <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                <fieldset
                                                                                                        class="form-group">
                                                                                                    <label class="form-label semibold"
                                                                                                           for="exampleInput">Data
                                                                                                        de
                                                                                                        Início</label>
                                                                                                    <input id="data<?php echo $vetor['id_calendario']; ?>"
                                                                                                           type="date"
                                                                                                           name="data"
                                                                                                           value=""
                                                                                                           class="form-control">
                                                                                                </fieldset>
                                                                                            </div>
                                                                                        </div><!--.row-->

                                                                                        <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                <fieldset
                                                                                                        class="form-group">
                                                                                                    <label class="form-label semibold"
                                                                                                           for="exampleInput">Hora
                                                                                                        de
                                                                                                        Início</label>
                                                                                                    <input id="hora<?php echo $vetor['id_calendario']; ?>"
                                                                                                           type="time"
                                                                                                           name="hora"
                                                                                                           value=""
                                                                                                           class="form-control">
                                                                                                </fieldset>
                                                                                            </div>
                                                                                        </div><!--.row-->

                                                                                        <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                <fieldset
                                                                                                        class="form-group">
                                                                                                    <label class="form-label semibold"
                                                                                                           for="exampleInput">Data
                                                                                                        Prevista</label>
                                                                                                    <input id="datafim<?php echo $vetor['id_calendario']; ?>"
                                                                                                           type="date"
                                                                                                           name="datafim"
                                                                                                           value=""
                                                                                                           class="form-control">
                                                                                                </fieldset>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                <fieldset
                                                                                                        class="form-group">
                                                                                                    <label class="form-label semibold"
                                                                                                           for="exampleInput">Hora
                                                                                                        Prevista</label>
                                                                                                    <input id="horafim<?php echo $vetor['id_calendario']; ?>"
                                                                                                           type="time"
                                                                                                           name="horafim"
                                                                                                           value=""
                                                                                                           class="form-control">
                                                                                                </fieldset>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                <fieldset
                                                                                                        class="form-group">
                                                                                                    <label class="form-label semibold"
                                                                                                           for="exampleInput">Responsável</label>
                                                                                                    <select id="responsavel<?php echo $vetor['id_calendario']; ?>"
                                                                                                            type="time"
                                                                                                            name="responsavel"
                                                                                                            value=""
                                                                                                            class="form-control">
                                                                                                        <?php
                                                                                                        $usuariosDpt_sql = mysqli_query($con, "select * from usuarios where departamento = '$departamento'");
                                                                                                        if (mysqli_num_rows($usuariosDpt_sql) == 0) {
                                                                                                            $usuariosDpt_sql = mysqli_query($con, "select * from usuarios");
                                                                                                        }
                                                                                                        while ($usuariosDpt = mysqli_fetch_array($usuariosDpt_sql)) { ?>
                                                                                                            <option value="<?php echo $usuariosDpt['id_usuario']; ?>"><?php echo $usuariosDpt['nome']; ?></option>
                                                                                                        <?php } ?>
                                                                                                    </select>
                                                                                                </fieldset>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                                onclick="enviarTarefa(<?php echo $vetor['id_calendario']; ?>)"
                                                                                                class="btn btn-success">
                                                                                            Salvar
                                                                                        </button>
                                                                                        <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-dismiss="modal">
                                                                                            Fechar
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                        <div class="tab-pane" id="concluidas" role="tabpanel">

                                            <br>
                                            <br>

                                            <div class="table-responsive">
                                                <table id="lang_opt" class="table table-striped table-bordered display"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <tr>
                                                        <th><strong><h4>Título</h4></strong></th>
                                                        <th><strong><h4>Data de Inclusão</h4></strong></th>
                                                        <th><strong><h4>Data de Conclusão</h4></strong></th>
                                                        <th><strong><h4>Hora de Conclusão</h4></strong></th>
                                                        <?php if ($departamento == 0) {
                                                            echo "<th><strong><h4>Departamento</h4></strong></th>";
                                                        } ?>
                                                        <th><strong><h4>Responsável</strong></h4></th>
                                                        <?php if ($departamento != 0) {
                                                            echo "<th><strong><h4>Ação</h4></strong></th>";
                                                        } ?>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    if ($departamento == 0) {
                                                        $sql_atual = mysqli_query($con, "select * from calendario where status = '2' and tarefa = 1");
                                                    } else {
                                                        $sql_atual = mysqli_query($con, "select * from calendario where status = '2' and departamento = '$departamento' and tarefa = 1 order by data ASC");
                                                    }
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        $usuarioConclusão = mysqli_fetch_array(mysqli_query($con, "select * from usuarios where id_usuario = '$vetor[quemconcluiu]'"));
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $vetor['titulo']; ?></td>
                                                            <td align="center"><?php echo($vetor['datainclusao'] != null ? date('d/m/Y', strtotime($vetor['datainclusao'])) : ''); ?></td>
                                                            <td align="center"><?php echo($vetor['datatermino'] != null ? date('d/m/Y', strtotime($vetor['datatermino'])) : ''); ?></td>
                                                            <td align="center"><?php
                                                                if ($vetor['horatermino'] != null) {
                                                                    $horaexplode1 = explode(':', $vetor['horatermino']);
                                                                    echo $horaexplode1[0] . ':' . $horaexplode1[1];
                                                                } else {
                                                                    echo '';
                                                                } ?></td>
                                                            <?php if ($departamento == 0) { ?>
                                                                <td><?php echo $depto[$vetor['departamento']]; ?></td>
                                                            <?php } ?>
                                                            <td><?php echo $usuarioConclusão['nome']; ?></td>
                                                            <?php if ($departamento != 0) { ?>
                                                                <td>
                                                                    <a class="fancybox fancybox.ajax"
                                                                       href="vertarefa.php?id=<?php echo $vetor['id_calendario']; ?>"
                                                                       target="_blank">
                                                                        <button type="button"
                                                                                class="btn btn-success mesmo-tamanho"
                                                                                title="Ver ou Alterar Cadastro"><i
                                                                                    class="mdi mdi-tooltip-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            <?php } ?>
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
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "date-br-pre": function (a) {
                    if (a == null || a == "") {
                        return 0;
                    }
                    var brDatea = a.split('/');
                    return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
                },

                "date-br-asc": function (a, b) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },

                "date-br-desc": function (a, b) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });

            var init_data_Table = function () {
                var tabelaNcms = null;
                if ($.fn.dataTable.isDataTable('#lang_opt')) {
                    $('#lang_opt').dataTable().fnDestroy();
                    init_data_Table();
                } else {
                    tabelaNcms = $('#lang_opt').DataTable({
                        autoWidth: false,
                        destroy: false,
                        scrollCollapse: true,
                        ordering: true,
                        info: true,
                        searching: true,
                        paging: true,
                        dom: 'Bfrtip',
                        columnDefs: [
                            {
                                type: 'date-br',
                                targets: 1
                            },
                            {
                                type: 'date-br',
                                targets: 2
                            }
                        ],
                    });
                }
            };
            var init_data_Table2 = function () {
                var tabelaNcms = null;
                if ($.fn.dataTable.isDataTable('#lang_opt2')) {
                    $('#lang_opt2').dataTable().fnDestroy();
                    init_data_Table2();
                } else {
                    tabelaNcms = $('#lang_opt2').DataTable({
                        autoWidth: false,
                        destroy: false,
                        scrollCollapse: true,
                        ordering: true,
                        info: true,
                        searching: true,
                        paging: true,
                        dom: 'Bfrtip',
                        columnDefs: [
                            {
                                type: 'date-br',
                                targets: 1
                            },
                            {
                                type: 'date-br',
                                targets: 2
                            }
                        ],
                    });
                }
            };

            $(document).ready(function () {
                init_data_Table();
                init_data_Table2();
            });

        </script>
        </body>

        </html>
    <?php }
} ?>