<?php
include "../includes/conexao.php";
session_start();
$id_pagina = 56;
$id_usuario = $_SESSION['id'];
$departamento = $_GET['departamento'];
switch($departamento){
    case '9': // Criação
        $usuarios_permitidos = array(1,34,61,67);
        break;
    case '10':// Fotografia
        $usuarios_permitidos = array(1,61,68,67);
        break;
    case '2': // Eventos
        $usuarios_permitidos = array(1,61,87,43,67);
        break;
    case '13':// Arte Final
        $usuarios_permitidos = array(1,61,36,67);
        break;
    case '16': // Produção
        $usuarios_permitidos = array(1,61,44,67);
        break;
    case '7': // Marketing
        $usuarios_permitidos = array(1,61,72,67);
        break;
    case '21': // Entrega
        $usuarios_permitidos = array(1,61,44,67);
        break;

}

if (in_array($id_usuario, $usuarios_permitidos)) {
    $limita = 0;
} else {
    $limita = 1;
}
$nome_departamento = mysqli_fetch_array(mysqli_query($con,"select nome from departamentos where id_departamento = {$departamento}"))['nome'];
$vetor_num_colaboradores = mysqli_fetch_array(mysqli_query($con,"select count(1) as qtd_total from usuarios where departamento='{$departamento}' and pcp = 1"))['qtd_total'];
$vetor_num_colaboradores = ($vetor_num_colaboradores == 0 || $limita == 1?1:$vetor_num_colaboradores);
function calculaTEMPOSTATUS($tempo_total,$vetor_num_colaboradores)
{
    $minutos_totais = floor($tempo_total / 60);
    $dias_status = 0;
    $horas_diaatual = 17 - (int)date('H');
    if ((int)date('H') < 13) {
        $horas_diaatual--;
    }
    $minutos_diaatual = 60 - (int)date('i');
    $tempo_status = ceil(($minutos_totais - $minutos_diaatual) / 60);
    if ($horas_diaatual < 0 || ($horas_diaatual == 0 && $minutos_diaatual == 0) || (int)date('H') < (8 * $vetor_num_colaboradores)) {
        $dias_status++;
    } else {
        $tempo_status -= $horas_diaatual;
        if ($tempo_status > 0) {
            if ($tempo_status > (8 * $vetor_num_colaboradores)) {
                $dias_status += ceil($tempo_status / (8 * $vetor_num_colaboradores));
            } else {
                $dias_status++;
            }
        }
    }
    return $dias_status;
}

function numeroFeriados($data_inicial, $tempo_estimado, $con)
{
    $data_inicio_feriados = '2021' . substr($data_inicial, 4, 10);
    $data_final_feriados = '2021' . substr(date('Y-m-d', strtotime('+' . $tempo_estimado . ' weekdays', strtotime($data_inicial))), 4, 10);
    $sql_feriados = mysqli_query($con, "select * from feriados where status = 1 and `data` between '{$data_inicio_feriados}' and '{$data_final_feriados}'");
    while (mysqli_num_rows($sql_feriados) > 0) {
        $tempo_estimado += mysqli_num_rows($sql_feriados);
        $data_final_feriados = date('Y-m-d', strtotime('+1 weekday', strtotime($data_final_feriados)));
        $sql_feriados = mysqli_query($con, "select * from feriados where status = 1 and `data`  = '{$data_final_feriados}'");
    }
    return $tempo_estimado;
}

if ($_SESSION['id'] == null) {
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
        <style>
            .box {
                border-radius: 10px;
                color: #000000;
                margin: auto;
                padding: 10px;
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

                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href=""
                               data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>

                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <ul class="list-style-none">
                                    <li>
                                        <div class="drop-title bg-primary text-white">
                                            <h4 class="m-b-0 m-t-5">4 New</h4>
                                            <span class="font-light">Notifications</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="message-center notifications">
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-danger btn-circle"><i
                                                            class="fa fa-link"></i></span>
                                                <div class="mail-contnet">
                                                    <h5 class="message-title">Luanch Admin</h5> <span
                                                            class="mail-desc">Just see the my new admin!</span>
                                                    <span class="time">9:30 AM</span></div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-success btn-circle"><i
                                                            class="ti-calendar"></i></span>
                                                <div class="mail-contnet">
                                                    <h5 class="message-title">Event today</h5> <span
                                                            class="mail-desc">Just a reminder that you have event</span>
                                                    <span class="time">9:10 AM</span></div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="message-item">
                                                    <span class="btn btn-info btn-circle"><i
                                                                class="ti-settings"></i></span>
                                                <div class="mail-contnet">
                                                    <h5 class="message-title">Settings</h5> <span class="mail-desc">You can customize this template as you want</span>
                                                    <span class="time">9:08 AM</span></div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="message-item">
                                                    <span class="btn btn-primary btn-circle"><i
                                                                class="ti-user"></i></span>
                                                <div class="mail-contnet">
                                                    <h5 class="message-title">Pavan kumar</h5> <span
                                                            class="mail-desc">Just see the my admin!</span>
                                                    <span class="time">9:02 AM</span></div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center m-b-5 text-dark" href="javascript:void(0);">
                                            <strong>Check all notifications</strong> <i
                                                    class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
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
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">PCP</a></li>
                                    <li class="breadcrumb-item">Departamento</li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo $nome_departamento;?></li>

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
                                <div id="modalEnviarUsuario" class="modal fade"
                                     role="dialog" aria-hidden="true" tabindex="-1">
                                    <div class="modal-dialog modal-lg" role="document" style="display:table;">
                                        <!-- Modal content-->
                                        <input type="text" id="id_modal" class="form-control" hidden>
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Enviar Colaborador</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Colaborador</label>
                                                        <select id="id_usuario" name="usuario" class="form-control">
                                                            <option value="" selected="selected">Selecione...
                                                            </option>
                                                            <?php
                                                            $sql = mysqli_query($con, "select * from usuarios where departamento='{$departamento}' order by nome ASC");
                                                            while ($vetor = mysqli_fetch_array($sql)) {
                                                                ?>
                                                                <option value="<?php echo $vetor['id_usuario']; ?>"><?php echo $vetor['nome'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                        class="btn btn-success"
                                                        onclick="enviaUsuario()"
                                                        data-dismiss="modal">Salvar
                                                </button>
                                                <button type="button"
                                                        class="btn btn-default"
                                                        data-dismiss="modal">Fechar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($limita == 0) { ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Colaboradores</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <select name="categoria" id="categoria"
                                                            class="form-control"
                                                            required>
                                                        <option value="" selected="selected">Todos os
                                                            Colaboradores
                                                        </option>
                                                        <?php
                                                        $sql = mysqli_query($con, "select * from usuarios where departamento='{$departamento}' order by nome ASC");
                                                        while ($vetor = mysqli_fetch_array($sql)) { ?>
                                                            <option value="<?php echo $vetor['nome']; ?>"><?php echo $vetor['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8"></div>
                                    </div>
                                    <br>
                                    <br>
                                <?php } ?>
                                <ul class="nav nav-tabs" role="tablist">

                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                            href="#execucao"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Em Execução</span></a>
                                    </li>
                                    <?php if ($limita == 0) { ?>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                href="#finalizado"
                                                                role="tab"><span class="hidden-sm-up"><i
                                                            class="ti-email"></i></span> <span
                                                        class="hidden-xs-down">Finalizados</span></a>
                                        </li>
                                    <?php } ?>

                                </ul>
                                <br>
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="execucao" role="tabpanel">
                                        <br>
                                        <br>
                                        <div class="table-responsive">
                                            <table id="tabela" class="table table-striped table-bordered display"
                                                   style="width:100%">
                                                <thead align="center">
                                                <tr>
                                                    <th><strong><h5>PCP</h5></strong></th>
                                                    <th><strong><h5>Contrato</h5></strong></th>
                                                    <th><strong><h5>Job</h5></strong></th>
                                                    <th><strong><h5>Data<br>Entrada</h5></strong></th>
                                                    <th><strong><h5>Data<br>Limite</h5></strong></th>
                                                    <th><strong><h5>Data<br>Início</h5></strong></th>
                                                    <th><strong><h5>Tempo<br>Estimado</h5></strong></th>
                                                    <th><strong><h5>Responsável</h5></strong></th>
                                                    <th><strong><h5>Ação</h5></strong></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $sql_pcp = mysqli_query($con, "SELECT dap.*,p.data_calculo as pdata_criado,p.prioridade,j.id_job,j.tipo_calculo,p.tempo_especifico,t.ncontrato,j.titulo,u.nome as unome, f.id_cadastro,f.nome as fnome,p.id_trabalho,f.id_formando from departamento_atual_pcp dap left join pcp p on p.id_pcp = dap.id_pcp left join formandos f on f.id_formando=p.id_formando left join jobs j on j.id_job = p.id_job left join turmas t on t.id_turma = p.id_turma left join usuarios u on u.id_usuario = dap.id_responsavel where (dap.status = '0' or dap.status is null) and p.status is not null and id_departamento='{$departamento}'" . ($limita == 1 ? " and dap.id_responsavel = '{$id_usuario}'" : "") . " order by p.prioridade");
                                                while ($vetor_pcp = mysqli_fetch_array($sql_pcp)) {
                                                    $sql_etapas = mysqli_query($con, "select * from jobs_etapas where id_job = '{$vetor_pcp['id_job']}' and status = '1' and etapa <= (SELECT etapa from jobs_etapas where id_job='{$vetor_pcp['id_job']}' and id_departamento = '{$departamento}' and status = '1')");
                                                    $tempo_estimado = 0;
                                                    $tempo_trabalhado = 0;
                                                    while ($vetor_etapas = mysqli_fetch_array($sql_etapas)) {
                                                        $tempo_estimado += (int)$vetor_etapas['prazo_geral'];
                                                        if ($vetor_etapas['id_departamento'] == $departamento) {
                                                            if ($vetor_pcp['tempo_especifico'] > 0) {
                                                                $tempo_trabalhado = $vetor_pcp['tempo_especifico'];
                                                            } else {
                                                                $tempo_trabalhado = $vetor_etapas['tempo_estimado'];
                                                            }
                                                        }
                                                    }
                                                    $tempo_estimado = numeroFeriados(substr($vetor_pcp['pdata_criado'], 0, 10), $tempo_estimado, $con);
                                                    $data_limite = date('d/m/Y', strtotime('+' . $tempo_estimado . ' weekdays', strtotime(substr($vetor_pcp['pdata_criado'], 0, 10))));
                                                    if ($vetor_pcp['id_responsavel'] == null) {
                                                        $responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal(' . $vetor_pcp['id_depto_atual'] . ')"
                                                                                  class="btn btn-info btn-block" style="background-color: #80808047;color: black">Enviar</button>';
                                                    } elseif ($limita == 0) {
                                                        $responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal(' . $vetor_pcp['id_depto_atual'] . ')"
                                                                                  class="btn btn-info btn-block">' . $vetor_pcp['unome'] . '</button>';
                                                    } else {
                                                        $responsavel = $vetor_pcp['unome'];
                                                    }
                                                    $soma_status = mysqli_fetch_array(mysqli_query($con, "select SUM(je.tempo_estimado) as tempo_estimado from departamento_atual_pcp dap
                                                                                                left join pcp p on p.id_pcp = dap.id_pcp
                                                                                                left join jobs_etapas je on je.id_job = p.id_job and je.etapa = p.etapa
                                                                                                where (dap.status = '0' or dap.status is null) and dap.id_departamento = '{$departamento}' and p.prioridade <= '{$vetor_pcp['prioridade']}' and p.status is not null ORDER BY p.prioridade"));
                                                    $tempo_fila = numeroFeriados(date('Y-m-d'), calculaTEMPOSTATUS((int)$soma_status['tempo_estimado'],$vetor_num_colaboradores), $con);
                                                    $status = ceil((strtotime('+' . $tempo_estimado . ' weekdays', strtotime(substr($vetor_pcp['pdata_criado'], 0, 10))) - strtotime('+' . $tempo_fila . ' weekdays', strtotime(date('Y-m-d')))) / (60 * 60 * 24));
                                                    if ($status < 1) {
                                                        $status = '#fc000099';
                                                    } elseif ($status < 4) {
                                                        $status = '#ffa500cc';
                                                    } else {
                                                        $status = 'lightgreen';
                                                    }
                                                    ?>
                                                    <tr id="tr<?php echo $vetor_pcp['id_depto_atual']; ?>">
                                                        <td align="center"><?php echo $vetor_pcp['prioridade']; ?></td>
                                                        <td align="center"
                                                            style="vertical-align: middle"
                                                            title="<?php echo $vetor_pcp['fnome']; ?>"><?php echo $vetor_pcp['ncontrato'] . ($vetor_pcp['id_cadastro'] == null ? '' : '-' . $vetor_pcp['id_cadastro']); ?></td>
                                                        <td align="center"><?php echo $vetor_pcp['titulo'] ?></td>
                                                        <td align="center"><?php echo ($limita == 1?date('d/m/Y H:i:s', strtotime($vetor_pcp['data_direcionamento'])):date('d/m/Y H:i:s', strtotime($vetor_pcp['data_criado']))); ?></td>
                                                        <td align="center"><?php echo $data_limite; ?></td>
                                                        <td align="center"><?php echo($vetor_pcp['data_inicio'] != null ? date('d/m/Y', strtotime($vetor_pcp['data_inicio'])) : ''); ?></td>
                                                        <td align="center"
                                                            style="background-color: <?php echo $status; ?>"><?php echo $tempo_trabalhado; ?></td>
                                                        <td align="center"
                                                            id="usuario_<?php echo $vetor_pcp['id_depto_atual'] ?>"><?php echo $responsavel ?></td>
                                                        <td align="center">
                                                            <?php
                                                            if($departamento == '10' && $vetor_pcp['id_trabalho'] != ''){
                                                                switch ($vetor_pcp['tipo_calculo']){
                                                                    case "2": // Tabela: convite_exclusive
                                                                        echo '<a class="fancybox fancybox.ajax"
                                                                                     href="alterarexclusive.php?id='.$vetor_pcp['id_trabalho'].'
                                                                                     target="_blank"">
                                                                                      <button type="button"
                                                                                              class="btn btn-success"
                                                                                              title="Alterar"><i
                                                                                                  class="mdi mdi-tooltip-edit"></i>
                                                                                      </button>
                                                                                  </a>';
                                                                        break;
                                                                    case "3": // Tabela: escolha_fotos_tratamento
                                                                        echo '<a class="fancybox fancybox.ajax"
                                                                                     href="vertopfotos.php?id_formando='.$vetor_pcp['id_formando'].'&id_evento='.$vetor_pcp['id_trabalho'].'
                                                                                     target="_blank"">
                                                                                      <button type="button"
                                                                                              class="btn btn-success"
                                                                                              title="Alterar"><i
                                                                                                  class="mdi mdi-tooltip-edit"></i>
                                                                                      </button>
                                                                                  </a>';
                                                                        break;
                                                                    default: // Tabela: escolha_fotos
                                                                        if($vetor_pcp['tipo_calculo'] > 24 && $vetor_pcp['tipo_calculo'] < 42){
                                                                            echo '<a class="fancybox fancybox.ajax"
                                                                                     href="alterarescolhafoto.php?id='.$vetor_pcp['id_trabalho'].'
                                                                                     target="_blank"">
                                                                                      <button type="button"
                                                                                              class="btn btn-success"
                                                                                              title="Alterar"><i
                                                                                                  class="mdi mdi-tooltip-edit"></i>
                                                                                      </button>
                                                                                  </a>';
                                                                        }elseif ($vetor_pcp['tipo_calculo'] > 4 && $vetor_pcp['tipo_calculo'] < 22){
                                                                            echo '<a class="fancybox fancybox.ajax"
                                                                                     href="alteraralbumformando.php?id='.$vetor_pcp['id_trabalho'].'
                                                                                     target="_blank"">
                                                                                      <button type="button"
                                                                                              class="btn btn-success"
                                                                                              title="Alterar"><i
                                                                                                  class="mdi mdi-tooltip-edit"></i>
                                                                                      </button>
                                                                                  </a>';
                                                                        }
                                                                        break;
                                                                }
                                                            }
                                                            if ($vetor_pcp['data_inicio'] == null) {
                                                                echo "<button type='button' onclick='iniciarPCP({$vetor_pcp['id_depto_atual']})' class='btn btn-success'><i class='fas fa-play'></i></button>";
                                                            } else {
                                                                echo "<button type='button' onclick='finalizarPCP({$vetor_pcp['id_depto_atual']})' class='btn btn-warning'>Finalizar</button>";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }

                                                if ($limita == 0) {
                                                    $sql = mysqli_query($con, "select p.*,t.ncontrato,j.titulo,je.etapa as jeetapa 
                                                                                                                                                from pcp p left join turmas t on t.id_turma = p.id_turma 
                                                                                                                                                    left join jobs j on j.id_job = p.id_job 
                                                                                                                                                    left join jobs_etapas je on je.id_job = j.id_job 
                                                                                                                                                where p.status = '0' and je.id_departamento = '{$departamento}' and  p.id_pcp not in (select dap.id_pcp from departamento_atual_pcp dap where dap.id_departamento = '{$departamento}' and (dap.status is null or dap.status = 0))
                                                                                                                                                      order by p.prioridade");
                                                    while ($vetor_pcp = mysqli_fetch_array($sql)) {
                                                        $sql_etapas = mysqli_query($con, "select * from jobs_etapas where id_job = '{$vetor_pcp['id_job']}' and status = '1' and etapa <= (SELECT etapa from jobs_etapas where id_job='{$vetor_pcp['id_job']}' and id_departamento = '{$departamento}' and status = '1')");
                                                        $tempo_estimado = (int)$vetor_pcp['jeetapa'] - 1;
                                                        $tempo_trabalhado = 0;
                                                        while ($vetor_etapas = mysqli_fetch_array($sql_etapas)) {
                                                            $tempo_estimado += (int)$vetor_etapas['prazo_geral'];
                                                            if ($vetor_etapas['id_departamento'] == $departamento) {
                                                                $tempo_trabalhado = $vetor_etapas['tempo_estimado'];
                                                                $prazo_geral = $vetor_etapas['prazo_geral'];
                                                            }
                                                        }
                                                        $tempo_inicial = numeroFeriados(substr($vetor_pcp['data_calculo'], 0, 10), ($tempo_estimado - $prazo_geral), $con);
                                                        $data_inicial = date('d/m/Y', strtotime('+' . $tempo_inicial . ' weekdays', strtotime($vetor_pcp['data_calculo'])));
                                                        $tempo_final = numeroFeriados(substr($vetor_pcp['data_calculo'], 0, 10), $tempo_estimado, $con);
                                                        $data_final = date('d/m/Y', strtotime('+' . $tempo_final . ' weekdays', strtotime($vetor_pcp['data_calculo'])));
                                                        ?>
                                                        <tr>
                                                            <td align="center"><span hidden>99999999</span></td>
                                                            <td align="center"><?php echo $vetor_pcp['ncontrato']; ?></td>
                                                            <td align="center"><?php echo $vetor_pcp['titulo'] ?></td>
                                                            <td align="center"><?php echo $data_inicial; ?></td>
                                                            <td align="center"><?php echo $data_final; ?></td>
                                                            <td align="center"></td>
                                                            <td align="center"><?php echo($tempo_trabalhado > 0 ? $tempo_trabalhado : 10); ?></td>
                                                            <td align="center"></td>
                                                            <td align="center"></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th align="center" style="border:none"></th>
                                                    <th align="center" style="border:none"></th>
                                                    <th align="center" style="border:none"></th>
                                                    <th align="center" style="border:none"></th>
                                                    <th align="center" style="border:none"></th>
                                                    <th align="center" style="border:none"></th>
                                                    <th align="center"
                                                        style="border:none;text-align: center;white-space: nowrap"></th>
                                                    <th align="center"
                                                        style="border:none;text-align: center;white-space: nowrap"></th>
                                                    <th align="center" style="border:none"></th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <?php if ($limita == 0) { ?>
                                        <div class="tab-pane" id="finalizado" role="tabpanel">
                                            <br>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="tabela2"
                                                       class="table table-striped table-bordered display"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <tr>
                                                        <th><strong><h5>Contrato</h5></strong></th>
                                                        <th><strong><h5>Job</h5></strong></th>
                                                        <th><strong><h5>Data<br>Início</h5></strong></th>
                                                        <th><strong><h5>Data<br>Término</h5></strong></th>
                                                        <th><strong><h5>Responsável</h5></strong></th>
                                                        <th><strong><h5>Ação</h5></strong></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $sql_pcp = mysqli_query($con, "SELECT dap.*,t.ncontrato,j.titulo,u.nome as unome from departamento_atual_pcp dap left join pcp p on p.id_pcp = dap.id_pcp left join jobs j on j.id_job = p.id_job left join turmas t on t.id_turma = p.id_turma left join usuarios u on u.id_usuario = dap.id_responsavel where (dap.status = '1' and dap.data_movimento_pcp is null) and p.status is not null and id_departamento='{$departamento}'");
                                                    while ($vetor_pcp = mysqli_fetch_array($sql_pcp)) {
                                                        $responsavel = $vetor_pcp['unome'];
                                                        ?>
                                                        <tr id="tr<?php echo $vetor_pcp['id_depto_atual']; ?>">
                                                            <td align="center"><?php echo $vetor_pcp['ncontrato']; ?></td>
                                                            <td align="center"><?php echo $vetor_pcp['titulo'] ?></td>
                                                            <td align="center"><?php echo date('d/m/Y', strtotime($vetor_pcp['data_inicio'])); ?></td>
                                                            <td align="center"><?php echo date('d/m/Y', strtotime($vetor_pcp['data_termino'])); ?></td>
                                                            <td align="center"
                                                                id="usuario_<?php echo $vetor_pcp['id_depto_atual']; ?>"><?php echo $responsavel ?></td>
                                                            <td align="center">
                                                                <button type="button"
                                                                        onclick="moverPCP(<?php echo $vetor_pcp['id_depto_atual']; ?>)"
                                                                        class="btn btn-danger">Finalizar JOB
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php } ?>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

        function openModal(id) {
            $('#id_modal').attr('value', id);
            $('#modalEnviarUsuario').modal('show');
        }

        function enviaUsuario() {
            var id = $('#id_modal').val();
            var usuario = $('#id_usuario').val();
            $.post('recebe_job.php', {
                id: id,
                usuario: usuario
            }, function (response) {
                swal('Responsável adicionado com sucesso!', '', 'success');
                $('#usuario_' + $('#id_modal').val()).html(response);
            });
        }

        function formatarCampo(dado, tipo) {
            if (tipo == 1) {
                var aux = parseInt(dado) - 10;
            } else {
                var aux = parseInt(dado);
            }
            if (aux >= 60) {
                var horas = Math.floor(parseInt(aux) / 60);
                var minutos = parseInt(aux) - (horas * 60);
                if (tipo == 1) {
                    return horas + "h " + (minutos == 0 ? "" : "e " + minutos + "min") + " + 10min";
                } else {
                    return horas + "h " + (minutos == 0 ? "" : "e " + minutos + "min");
                }
            } else {
                if (tipo == 1) {
                    return aux + "min + 10 min";
                } else {
                    return aux + "min";
                }
            }
        }

        function iniciarPCP(id) {
            swal({
                title: "Confirmar a inicialização?",
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: 'recebe_job.php?ativar=' + id,
                            type: 'post',
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                swal('JOB iniciado!', '', 'success');
                                var dados = response.split(';');
                                $('#tabela').DataTable().row("#tr" + dados[9]).remove();
                                $('#tabela').DataTable().row.add([dados[0], dados[1], dados[2], dados[3], dados[4], dados[5], dados[6], dados[7], dados[8], dados[9]]).draw().node().id = 'tr' + dados[9];
                                var aux = $('#tr' + dados[9]).children();
                                aux.each(function () {
                                    $(this).attr('align', 'center');
                                });
                                $('#tabela').DataTable().draw();
                            },
                        });
                    }
                });
        }

        function finalizarPCP(id) {
            swal({
                title: "Confirmar a finalização?",
                text: "<?php if ($departamento == '2') {
                    echo "Digite o número de fotos";
                } ?>",
                icon: "warning",
                <?php if ($departamento == '2') {
                    echo 'content: {
                      element: "input",
                      attributes: {
                          placeholder: "Quantidade de Fotos",
                          type: "number",
                      }
                  },';
                }?>
                buttons: true,
                dangerMode: true,
            })
                .then((<?php if ($departamento == '2') {
                    echo "inputValue";
                } else {
                    echo "willDelete";
                } ?>) => {
                    <?php if ($departamento == '2') {
                    echo 'if (inputValue == "") {
                          swal("É necessário inserir o número de fotos!", "", "warning");
                          return false;
                      }
                      if (parseInt(inputValue) == 0) {
                          swal("É necessário inserir o número de fotos!", "", "warning");
                          return false
                      }
                      if (parseInt(inputValue) > 0) {
                          $("#tabela").DataTable().row("#tr" + id).remove();
                          $.ajax({
                              url: "recebe_job.php?finalizar=" + id + "&qtd_fotos=" + inputValue,
                              type: "post",
                              contentType: false,
                              processData: false,
                              success: function (response) {
                                  swal("JOB finalizado com sucesso!", "", "success");
                                  $("#tabela").DataTable().draw();
                              },
                          });
                      }';
                } else {
                    echo 'if (willDelete) {
                          $("#tabela").DataTable().row("#tr" + id).remove();
                          $.ajax({
                              url: "recebe_job.php?finalizar=" + id,
                              type: "post",
                              contentType: false,
                              processData: false,
                              success: function (response) {
                                  swal("JOB finalizado com sucesso!", "", "success");
                                  $("#tabela").DataTable().draw();
                              },
                          });
                      }';
                } ?>
                });
        }

        function moverPCP(id) {
            swal({
                title: "Confirmar a finalização?",
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#tabela2').DataTable().row("#tr" + id).remove();
                        $.ajax({
                            url: 'recebe_job.php?moverpcp=' + id,
                            type: 'post',
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                swal('JOB finalizado com sucesso!', '', 'success');
                                $('#tabela2').DataTable().draw();
                            },
                        });
                    }
                });
        }

        var init_data_Table = function () {
            var tabelaNcms = null;
            if ($.fn.dataTable.isDataTable('#tabela')) {
                $('#tabela').dataTable().fnDestroy();
                init_data_Table();
            } else {
                tabelaNcms = $('#tabela').DataTable({
                    destroy: false,
                    scrollCollapse: true,
                    ordering: true,
                    info: true,
                    searching: true,
                    paging: false,
                    dom: 'Bfrtip',
                    columnDefs: [
                        {
                            type: 'date-br',
                            targets: 3
                        },
                        {
                            type: 'date-br',
                            targets: 4
                        },
                        {
                            type: 'date-br',
                            targets: 5
                        },
                        {
                            "render": function (data, type, row) {

                                return formatarCampo(data, 1);
                            },
                            "targets": 6
                        }
                    ],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(), data;

                        // Remove the formatting to get integer data for summation
                        var parseFloat = function (i) {
                            return typeof i === 'string' ?
                                i.replace(/[$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        // Total over all pages
                        total = api
                            .column(6)
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);

                        // // Total over this page
                        pageTotal = api
                            .column(6, {page: 'current'})
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);

                        // Update footer
                        $(api.column(7).footer()).html('<strong>Horas de Serviço<br>Departamento<br>' + formatarCampo(total, 2) + ' </strong>');
                        $(api.column(6).footer()).html('<strong>Horas de Serviço<br>Filtradas<br>' + formatarCampo(pageTotal, 2) + ' </strong>');
                    },
                });
                $('#categoria').on('change', function () {
                    tabelaNcms.search(this.value).draw();
                });
            }
        };
        var init_data_Table2 = function () {
            var tabelaNcms = null;
            if ($.fn.dataTable.isDataTable('#tabela2')) {
                $('#tabela2').dataTable().fnDestroy();
                init_data_Table2();
            } else {
                tabelaNcms = $('#tabela2').DataTable({
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
                            targets: 2
                        },
                        {
                            type: 'date-br',
                            targets: 3
                        }
                    ]
                });
                $('#categoria').on('change', function () {
                    tabelaNcms.search(this.value).draw();
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
    <?php
} ?>