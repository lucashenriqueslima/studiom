<?php
include "../includes/conexao.php";
session_start();
if (isset($_POST['id_pcp'])) {
    $id_pcp = $_POST['id_pcp'];
    $i = 0;
    $vetor_datas = array();
    $sql = mysqli_query($con, "SELECT dap.*,d.nome as dnome, u.nome as unome  FROM departamento_atual_pcp dap left join departamentos d on d.id_departamento = dap.id_departamento left join usuarios u on u.id_usuario =  dap.id_responsavel WHERE dap.id_pcp = '{$id_pcp}' order by dap.data_criado");
    while ($vetor = mysqli_fetch_array($sql)) {
        $vetor_datas[substr($vetor['data_criado'], 0, 10)][$vetor['dnome']]['data_criado'] = $vetor['data_criado'];
        $vetor_datas[substr($vetor['data_criado'], 0, 10)][$vetor['dnome']]['unome'] = $vetor['unome'];
        if ($vetor['data_inicio'] != null) {
            $vetor_datas[substr($vetor['data_inicio'], 0, 10)][$vetor['dnome']]['data_inicio'] = $vetor['data_inicio'];
            $vetor_datas[substr($vetor['data_inicio'], 0, 10)][$vetor['dnome']]['unome'] = $vetor['unome'];
        }
        if ($vetor['data_termino'] != null) {
            $vetor_datas[substr($vetor['data_termino'], 0, 10)][$vetor['dnome']]['data_termino'] = $vetor['data_termino'];
            $vetor_datas[substr($vetor['data_termino'], 0, 10)][$vetor['dnome']]['unome'] = $vetor['unome'];

        }
        if ($vetor['data_movimento_pcp'] != null) {
            $vetor_datas[substr($vetor['data_movimento_pcp'], 0, 10)][$vetor['dnome']]['data_movimento_pcp'] = $vetor['data_movimento_pcp'];
            $vetor_datas[substr($vetor['data_movimento_pcp'], 0, 10)][$vetor['dnome']]['unome'] = $vetor['unome'];

        }
    }
    $msg = '<div class="slider">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <section class="cd-horizontal-timeline">
                                    <div class="timeline">
                                        <div class="events-wrapper">
                                            <div class="events">
                                                <ol>';
    foreach ($vetor_datas as $key => $data) {
        $msg .= '<li><a href="#0" data-date="' . date('d/m/Y', strtotime($key)) . '" ' . ($i++ == 0 ? ' class="selected"' : '') . '>' . strftime('%d %b', strtotime($key)) . '</a></li>';
    }
    $i = 0;
    $msg .= '                                    </ol>
                                                <span class="filling-line" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <ul class="cd-timeline-navigation">
                                            <li><a href="#0" class="prev inactive">Prev</a></li>
                                            <li><a href="#0" class="next">Next</a></li>
                                        </ul>
                                    </div>
                                    <div class="events-content">
                                        <ol>';
    foreach ($vetor_datas as $key => $data) {
        $msg .= '<li data-date="' . date('d/m/Y', strtotime($key)) . '" ' . ($i++ == 0 ? ' class="selected"' : '') . '>
	                <div class="d-flex align-items-center">
	                    <div>';
        foreach ($data as $depto => $depto_atual) {
            $msg .= '<h2>' . $depto . '</h2>';
            foreach ($depto_atual as $tipo => $data_atual) {

                switch ($tipo) {
                    case 'data_criado':
                        $msg .= '<h6>' . strftime('%H:%M', strtotime($data_atual)) . ' : Entrada no Departamento.'.($depto_atual['unome'] != null?' Usuário: '.$depto_atual['unome']:'').'</h6>';
                        break;
                    case 'data_inicio':
                        $msg .= '<h6>' . strftime('%H:%M', strtotime($data_atual)) . ' : Inicio do Serviço'.($depto_atual['unome'] != null?' Usuário: '.$depto_atual['unome']:'').'</h6>';
                        break;
                    case 'data_termino':
                        $msg .= '<h6>' . strftime('%H:%M', strtotime($data_atual)) . ' : Término do Serviço'.($depto_atual['unome'] != null?' Usuário: '.$depto_atual['unome']:'').'</h6>';
                        break;
                    case 'data_movimento_pcp':
                        $msg .= '<h6>' . strftime('%H:%M', strtotime($data_atual)) . ' : Movimentação do Job no PCP'.($depto_atual['unome'] != null?' Usuário: '.$depto_atual['unome']:'').'</h6>';
                        break;
                }
            }
            $msg .= '<br>';
        }
        $msg .= "</div>
                    </div>
                </li>";
    }
    $msg .= '</ol>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="../layout/assets/extra-libs/horizontal-timeline/horizontal-timeline.js"></script>';
    echo $msg;
    die();
}
function calculaTEMPOSTATUS($tempo_total,$vetor_num_colaboradores){
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

$id_pagina = 56;
if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
} else {
    $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
    $vetor_permissao = mysqli_fetch_array($sql_permissao);
    if ($vetor_permissao['listar'] != 2) {
        echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
    }
    $sql = mysqli_query($con, "select * from departamentos where pcp is not null order by pcp asc");
    $maxDepto = mysqli_num_rows($sql);
    $depto = array();
    $i = 0;
    while ($vetor = mysqli_fetch_array($sql)) {
        $depto[$i]['cor'] = $vetor['corcalendario'];
        $depto[$i]['nome'] = $vetor['nome'];
        $depto[$i]['departamento'] = $vetor['id_departamento'];
        $i++;
    }
    if ($vetor_permissao['listar'] == 2) {
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
            <link href="../layout/assets/extra-libs/horizontal-timeline/horizontal-timeline.css" rel="stylesheet">
            <link href="../layout/dist/css/style.min.css" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/rr-1.2.7/datatables.min.css"/>
            <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
            <style>
                table.floatThead-table {
                    border-top: none;
                    border-bottom: none;
                    background-color: #fff;
                }

                .box {
                    border-radius: 10px;
                    color: #000000;
                    margin: auto;
                    padding: 10px;
                }

                .pop-div {
                    font-size: 13px;
                    margin-top: 100px;
                }

                .pop-title {
                    display: none;
                    color: blue;
                    font-size: 15px;
                }

                .pop-content {
                    display: none;
                    color: red;
                    font-size: 10px;
                }

                div.slider {
                    display: none;
                }

                table.dataTable tbody td.no-padding {
                    padding: 0;
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
                            <!--                            <li class="nav-item dropdown">-->
                            <!--                                <a class="nav-link dropdown-toggle waves-effect waves-dark" href=""-->
                            <!--                                   data-toggle="dropdown"-->
                            <!--                                   aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>-->
                            <!---->
                            <!--                                </a>-->
                            <!--                                <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">-->
                            <!--                                    <span class="with-arrow"><span class="bg-primary"></span></span>-->
                            <!--                                    <ul class="list-style-none">-->
                            <!--                                        <li>-->
                            <!--                                            <div class="drop-title bg-primary text-white">-->
                            <!--                                                <h4 class="m-b-0 m-t-5">4 New</h4>-->
                            <!--                                                <span class="font-light">Notifications</span>-->
                            <!--                                            </div>-->
                            <!--                                        </li>-->
                            <!--                                        <li>-->
                            <!--                                            <div class="message-center notifications">-->
                            <!--                                                 Message -->
                            <!--                                                <a href="javascript:void(0)" class="message-item">-->
                            <!--                                                <span class="btn btn-danger btn-circle"><i-->
                            <!--                                                            class="fa fa-link"></i></span>-->
                            <!--                                                    <div class="mail-contnet">-->
                            <!--                                                        <h5 class="message-title">Luanch Admin</h5> <span-->
                            <!--                                                                class="mail-desc">Just see the my new admin!</span>-->
                            <!--                                                        <span class="time">9:30 AM</span></div>-->
                            <!--                                                </a>-->
                            <!--                                                 Message -->
                            <!--                                                <a href="javascript:void(0)" class="message-item">-->
                            <!--                                                <span class="btn btn-success btn-circle"><i-->
                            <!--                                                            class="ti-calendar"></i></span>-->
                            <!--                                                    <div class="mail-contnet">-->
                            <!--                                                        <h5 class="message-title">Event today</h5> <span-->
                            <!--                                                                class="mail-desc">Just a reminder that you have event</span>-->
                            <!--                                                        <span class="time">9:10 AM</span></div>-->
                            <!--                                                </a>-->
                            <!--                                                Message -->
                            <!--                                                <a href="javascript:void(0)" class="message-item">-->
                            <!--                                                    <span class="btn btn-info btn-circle"><i-->
                            <!--                                                                class="ti-settings"></i></span>-->
                            <!--                                                    <div class="mail-contnet">-->
                            <!--                                                        <h5 class="message-title">Settings</h5> <span class="mail-desc">You can customize this template as you want</span>-->
                            <!--                                                        <span class="time">9:08 AM</span></div>-->
                            <!--                                                </a>-->
                            <!--                                                 Message -->
                            <!--                                                <a href="javascript:void(0)" class="message-item">-->
                            <!--                                                    <span class="btn btn-primary btn-circle"><i-->
                            <!--                                                                class="ti-user"></i></span>-->
                            <!--                                                    <div class="mail-contnet">-->
                            <!--                                                        <h5 class="message-title">Pavan kumar</h5> <span-->
                            <!--                                                                class="mail-desc">Just see the my admin!</span>-->
                            <!--                                                        <span class="time">9:02 AM</span></div>-->
                            <!--                                                </a>-->
                            <!--                                            </div>-->
                            <!--                                        </li>-->
                            <!--                                        <li>-->
                            <!--                                            <a class="nav-link text-center m-b-5 text-dark" href="javascript:void(0);">-->
                            <!--                                                <strong>Check all notifications</strong> <i-->
                            <!--                                                        class="fa fa-angle-right"></i>-->
                            <!--                                            </a>-->
                            <!--                                        </li>-->
                            <!--                                    </ul>-->
                            <!--                                </div>-->
                            <!--                            </li>-->
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
                            <!--                          <h4 class="page-title">Arte Final - Fotografia</h4>-->
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">PCP</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Visão Geral</li>
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
                        <div id="result">
                            Event result:
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Jobs</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <select name="categoria" id="categoria"
                                                            class="form-control"
                                                            required>
                                                        <option value="" selected="selected">Todos os
                                                            Jobs
                                                        </option>
                                                        <?php
                                                        $sql = mysqli_query($con, "select * from jobs order by titulo ASC");
                                                        while ($vetor = mysqli_fetch_array($sql)) { ?>
                                                            <option value="<?php echo $vetor['titulo']; ?>"><?php echo $vetor['titulo']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8"></div>
                                    </div>
                                    <br>
                                    <br>
                                    <ul class="nav nav-tabs" role="tablist">

                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                href="#execucao"
                                                                role="tab"><span class="hidden-sm-up"><i
                                                            class="ti-email"></i></span> <span class="hidden-xs-down">Em Execução</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                href="#finalizado"
                                                                role="tab"><span class="hidden-sm-up"><i
                                                            class="ti-email"></i></span> <span class="hidden-xs-down">Finalizados</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                href="#cancelados"
                                                                role="tab"><span class="hidden-sm-up"><i
                                                            class="ti-email"></i></span> <span class="hidden-xs-down">Cancelados</span></a>
                                        </li>

                                    </ul>
                                    <div class="tab-content tabcontent-border">
                                        <div class="tab-pane active" id="execucao" role="tabpanel">
                                            <br>
                                            <a href="cadastrar_job.php">
                                                <button type="button" class="btn waves-effect waves-light btn-warning">
                                                    Novo
                                                    Job
                                                </button>
                                            </a>
                                            <br>
                                            <br>
                                            <div class="table-responsive">

                                                <table id="tabela" class="table table-striped sticky-header"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <tr>
                                                        <th>N°</th>
                                                        <th></th>
                                                        <th><strong><h5>Contrato</h5></strong></th>
                                                        <th><strong><h5>Job</h5></strong></th>
                                                        <?php for ($i = 0; $i < $maxDepto; $i++) {
                                                            echo "<th style='background-color: " . $depto[$i]['cor'] . "'><strong><h5>" . ucfirst($depto[$i]['nome']) . "</h5></strong></th>";
                                                        } ?>
                                                        <th><strong><h5>Ação</h5></strong></th>
                                                        <th hidden></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $sql = mysqli_query($con, "select p.*,t.ncontrato,j.titulo,j.tipo_calculo,f.id_cadastro,f.nome as fnome from pcp p left join turmas t on t.id_turma = p.id_turma left join formandos f on f.id_formando=p.id_formando left join jobs j on j.id_job = p.id_job where p.status = '0' order by p.prioridade");
                                                    while ($vetor = mysqli_fetch_array($sql)) {
                                                        $aux = 0;
                                                        $titulo = $vetor['fnome'];
                                                        $titulo_inner = $vetor['ncontrato'] . ($vetor['id_cadastro'] == null ? '' : '-' . $vetor['id_cadastro']);
                                                        if($vetor['fnome'] == null){
                                                            $vetor_turma = mysqli_fetch_array(mysqli_query($con, "select t.id_turma,t.ncontrato,c.nome as cnome,t.ano,i.sigla from turmas t left join instituicoes i on t.id_instituicao = i.id_instituicao left join cursos c on c.id_curso = t.curso where t.id_turma={$vetor['id_turma']} order by ncontrato ASC"));
                                                            $titulo = $vetor_turma['cnome'] . ' / ' . $vetor_turma['ano'] . ' / ' . $vetor_turma['sigla'];
                                                            if(($vetor['tipo_calculo'] > 41 && $vetor['tipo_calculo'] < 46)|| $vetor['tipo_calculo'] == 4){
                                                                $vetor_evento = mysqli_fetch_array(mysqli_query($con,"select * from eventos_turma where id_evento = {$vetor['id_trabalho']}"));
                                                                $titulo = $vetor_evento['nome'];
                                                                $titulo_inner = $vetor_evento['nome'];
                                                            }
                                                        }
                                                        ?>
                                                        <tr id="tr<?php echo $vetor['id_pcp']; ?>">
                                                            <td align="center"
                                                                style="vertical-align: middle"><?php echo $vetor['prioridade']; ?></td>
                                                            <td align="center" style="vertical-align: middle"></td>
                                                            <td align="center"
                                                                style="vertical-align: middle"
                                                                title="<?php echo $titulo; ?>"><?php echo $titulo_inner; ?></td>
                                                            <td align="center"
                                                                style="vertical-align: middle"><?php echo $vetor['titulo']; ?></td>
                                                            <?php
                                                            $sql_etapas = mysqli_query($con, "select * from jobs_etapas where id_job = '{$vetor['id_job']}' and status = '1' order by etapa");
                                                            $etapas = mysqli_fetch_array($sql_etapas);
                                                            $datainicial = $vetor['data_calculo'];
                                                            while ($aux < $maxDepto) {
                                                                if ($depto[$aux]['departamento'] == $etapas['id_departamento']) {
                                                                    $deptoAtual = mysqli_fetch_array(mysqli_query($con, "select * from departamento_atual_pcp where id_pcp = '{$vetor['id_pcp']}' and id_departamento='{$etapas['id_departamento']}'"));
                                                                    $vetor_num_colaboradores = mysqli_fetch_array(mysqli_query($con,"select count(1) as qtd_total from usuarios where departamento='{$etapas['id_departamento']}' and pcp = 1"))['qtd_total'];
                                                                    $vetor_num_colaboradores = ($vetor_num_colaboradores == 0?1:$vetor_num_colaboradores);
                                                                    $tempo_estimado = numeroFeriados($datainicial, (int)$etapas['prazo_geral'], $con);
                                                                    if($etapas['id_departamento'] == 21 && $etapas['id_job'] == 2){
                                                                        $data_estimada_final = date('d/m/Y',strtotime($vetor['data_entrega']));
                                                                    }else{
                                                                        $data_estimada_final = date('d/m/Y', strtotime('+' . $tempo_estimado . ' weekdays', strtotime($datainicial)));
                                                                    }
                                                                    if(isset($deptoAtual['data_inicio']) && $deptoAtual['data_inicio'] != ''){
                                                                        $auxiliar_inicial = date('d/m/Y',  strtotime(substr($deptoAtual['data_inicio'],0,10)));
                                                                        $tempo_aux = ($vetor['tempo_especifico'] > 0 && $etapas['id_departamento'] == 10?$vetor['tempo_especifico']*60:$etapas['tempo_estimado']);
                                                                        $auxiliar_final = date('d/m/Y', strtotime('+' . calculaTEMPOSTATUS($tempo_aux,$vetor_num_colaboradores) . ' weekdays', strtotime(substr($deptoAtual['data_inicio'],0,10))));
                                                                        $tempo_data_estimada_final = strtotime('+' . $tempo_estimado . ' weekdays', strtotime($datainicial));
                                                                        if(($tempo_data_estimada_final - time()) > 0){
                                                                            $status = ceil(($tempo_data_estimada_final - (time() + (numeroFeriados(date('Y-m-d'), $tempo_data_estimada_final, $con)-$tempo_data_estimada_final)*(60*60*24)))/ (60 * 60 * 24));
                                                                        }else{
                                                                            $status = -1;
                                                                        }
                                                                    }else {
                                                                        $sql_etapas_status = mysqli_query($con, "select * from jobs_etapas where id_job = '{$vetor['id_job']}' and status = '1' and etapa <= (SELECT etapa from jobs_etapas where id_job='{$vetor['id_job']}' and id_departamento = '{$etapas['id_departamento']}' and status = '1')");
                                                                        $tempo_estimado_status = 0;
                                                                        while ($vetor_etapas = mysqli_fetch_array($sql_etapas_status)) {
                                                                            $tempo_estimado_status += (int)$vetor_etapas['prazo_geral'];
                                                                        }
                                                                        $tempo_estimado_status = numeroFeriados(substr($vetor['data_calculo'], 0, 10), $tempo_estimado_status, $con);
                                                                        $soma_status = mysqli_fetch_array(mysqli_query($con, "select SUM(je.tempo_estimado) as tempo_estimado from departamento_atual_pcp dap
                                            left join pcp p on p.id_pcp = dap.id_pcp
                                            left join jobs_etapas je on je.id_job = p.id_job and je.etapa = p.etapa
                                            where dap.id_departamento = '{$etapas['id_departamento']}' and p.prioridade <= '{$vetor['prioridade']}' ORDER BY p.prioridade"));
                                                                        $soma_status_especifico = mysqli_fetch_array(mysqli_query($con, "select SUM(p.tempo_especifico) as tempo_especifico from departamento_atual_pcp dap
                                            left join pcp p on p.id_pcp = dap.id_pcp
                                            left join jobs_etapas je on je.id_job = p.id_job and je.etapa = p.etapa
                                            where dap.id_departamento = '{$etapas['id_departamento']}' and p.prioridade <= '{$vetor['prioridade']}' and je.tempo_estimado = 0 ORDER BY p.prioridade"));
                                                                        $tempo_fila_final = numeroFeriados(date('Y-m-d'), calculaTEMPOSTATUS((int)$soma_status['tempo_estimado'] + ((int)$soma_status_especifico['tempo_especifico'] * 60),$vetor_num_colaboradores), $con);
                                                                        $status = ceil((strtotime('+' . $tempo_estimado_status . ' weekdays', strtotime(substr($vetor['data_calculo'], 0, 10))) - strtotime('+' . $tempo_fila_final . ' weekdays', strtotime(date('Y-m-d')))) / (60 * 60 * 24));
                                                                        $tempo_fila_inicial = numeroFeriados(date('Y-m-d'), calculaTEMPOSTATUS((int)$soma_status['tempo_estimado'] + (int)$soma_status_especifico['tempo_especifico'] * 60 - (int)$vetor['tempo_especifico'] * 60 - (int)$etapas['tempo_estimado'],$vetor_num_colaboradores), $con);
                                                                        $auxiliar_inicial = date('d/m/Y', strtotime('+' . $tempo_fila_inicial . ' weekdays', strtotime(date('Y-m-d'))));
                                                                        $auxiliar_final = date('d/m/Y', strtotime('+' . $tempo_fila_final . ' weekdays', strtotime(date('Y-m-d'))));
                                                                    }
                                                                    if ($status < 0) {
                                                                        $status = '#fc000099';
                                                                    } elseif ($status < 4) {
                                                                        $status = '#ffa500cc';
                                                                    } else {
                                                                        $status = 'lightgreen';
                                                                    }
                                                                    ?>
                                                                    <td>
                                                                        <div class="box"
                                                                             style="background-color: <?php if ($deptoAtual['data_inicio'] != null) {
                                                                                 echo $depto[$aux]['cor'];
                                                                             } else {
                                                                                 echo '#80808047';
                                                                             } ?>">
                                                                            <div align="center">
                                                                                <?php echo($deptoAtual['data_inicio'] != null ? date('d/m/Y', strtotime($deptoAtual['data_inicio'])) : date('d/m/Y', strtotime($datainicial))); ?>
                                                                                à <?php echo($deptoAtual['data_termino'] != null ? date('d/m/Y', strtotime($deptoAtual['data_termino'])) : ($deptoAtual['data_inicio'] != null ? "<span style='color: gray'>" . $data_estimada_final . "</span>" : $data_estimada_final)); ?>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <?php if ($deptoAtual['data_termino'] == null && $deptoAtual['data_criado'] != null) { ?>
                                                                            <div class="box"
                                                                                 style="background-color: <?php echo $status; ?>">
                                                                                <div align="center">
                                                                                    <?php echo $auxiliar_inicial; ?>
                                                                                    à <?php echo $auxiliar_final; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <?php
                                                                    $tempo_estimado++;
                                                                    $datainicial = date('Y-m-d', strtotime('+' . $tempo_estimado . ' weekdays', strtotime($datainicial)));
                                                                    $etapas = mysqli_fetch_array($sql_etapas);
                                                                } else {
                                                                    echo "<td></td>";
                                                                }
                                                                $aux++;
                                                            } ?>
                                                            <td align="center" style="vertical-align: middle">
                                                                <button type="button" class="btn btn-danger"
                                                                        onclick="cancelarPCP('<?php echo $vetor['id_pcp'] ?>')">
                                                                    <i class="mdi mdi-window-close"></i></button>
                                                            </td>
                                                            <td hidden><?php echo $vetor['id_pcp']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="finalizado" role="tabpanel">
                                            <br>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="tabela2" class="table table-striped table-bordered"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <tr>
                                                        <th></th>
                                                        <th><strong><h5>Contrato</h5></strong></th>
                                                        <th><strong><h5>Job</h5></strong></th>
                                                        <?php for ($i = 0; $i < $maxDepto; $i++) {
                                                            echo "<th style='background-color: " . $depto[$i]['cor'] . "'><strong><h5>" . ucfirst($depto[$i]['nome']) . "</h5></strong></th>";
                                                        } ?>
                                                        <th hidden></th>
                                                        <th hidden></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $sql = mysqli_query($con, "select p.*,t.ncontrato,j.titulo from pcp p left join turmas t on t.id_turma = p.id_turma left join jobs j on j.id_job = p.id_job where p.status = '1' order by p.prioridade");
                                                    while ($vetor = mysqli_fetch_array($sql)) {
                                                        $aux = 0;
                                                        ?>
                                                        <tr id="tr<?php echo $vetor['id_pcp']; ?>">
                                                            <td></td>
                                                            <td align="center"
                                                                style="vertical-align: middle"><?php echo $vetor['ncontrato']; ?></td>
                                                            <td align="center"
                                                                style="vertical-align: middle"><?php echo $vetor['titulo']; ?></td>
                                                            <?php
                                                            $sql_etapas = mysqli_query($con, "select * from jobs_etapas where id_job = '{$vetor['id_job']}' and status = '1' order by etapa");
                                                            $etapas = mysqli_fetch_array($sql_etapas);
                                                            $datainicial = $vetor['data_calculo'];
                                                            while ($aux < $maxDepto) {
                                                                if ($depto[$aux]['departamento'] == $etapas['id_departamento']) {
                                                                    $tempo_estimado = (int)$etapas['prazo_geral'];
                                                                    $deptoAtual = mysqli_fetch_array(mysqli_query($con, "select * from departamento_atual_pcp where id_pcp = '{$vetor['id_pcp']}' and id_departamento='{$etapas['id_departamento']}' and status = '1'"));
                                                                    ?>
                                                                    <td>
                                                                        <div class="box"
                                                                             style="background-color: <?php if ($deptoAtual['data_inicio'] != null) {
                                                                                 echo $depto[$aux]['cor'];
                                                                             } else {
                                                                                 echo 'gray';
                                                                             } ?>">
                                                                            <div align="center">
                                                                                <?php echo($deptoAtual['data_inicio'] != null ? date('d/m/Y', strtotime($deptoAtual['data_inicio'])) : date('d/m/Y', strtotime($datainicial))); ?>
                                                                                à <?php echo($deptoAtual['data_inicio'] != null ? ($deptoAtual['data_termino'] != null ? date('d/m/Y', strtotime('+1 months', strtotime($deptoAtual['data_inicio']))) : '--/--/----') : date('d/m/Y', strtotime('+' . $tempo_estimado . ' days', strtotime($datainicial)))); ?>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <?php
                                                                    $tempo_estimado++;
                                                                    $datainicial = date('Y-m-d', strtotime('+' . $tempo_estimado . ' days', strtotime($datainicial)));
                                                                    $etapas = mysqli_fetch_array($sql_etapas);
                                                                } else {
                                                                    echo "<td></td>";
                                                                }
                                                                $aux++;
                                                            } ?>
                                                            <td hidden></td>
                                                            <td hidden><?php echo $vetor['id_pcp']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="cancelados" role="tabpanel">
                                            <br>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="tabela3" class="table table-striped table-bordered"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <tr id="tr<?php echo $vetor['id_pcp']; ?>">
                                                        <th></th>
                                                        <th><strong><h5>Contrato</h5></strong></th>
                                                        <th><strong><h5>Job</h5></strong></th>
                                                        <?php for ($i = 0; $i < $maxDepto; $i++) {
                                                            echo "<th style='background-color: " . $depto[$i]['cor'] . "'><strong><h5>" . ucfirst($depto[$i]['nome']) . "</h5></strong></th>";
                                                        } ?>
                                                        <th hidden></th>
                                                        <th hidden></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $sql = mysqli_query($con, "select p.*,t.ncontrato,j.titulo from pcp p left join turmas t on t.id_turma = p.id_turma left join jobs j on j.id_job = p.id_job where p.status is null order by p.prioridade");
                                                    while ($vetor = mysqli_fetch_array($sql)) {
                                                        $aux = 0;
                                                        ?>
                                                        <tr>
                                                            <td></td>
                                                            <td align="center"
                                                                style="vertical-align: middle"><?php echo $vetor['ncontrato']; ?></td>
                                                            <td align="center"
                                                                style="vertical-align: middle"><?php echo $vetor['titulo']; ?></td>
                                                            <?php
                                                            $sql_etapas = mysqli_query($con, "select * from jobs_etapas where id_job = '{$vetor['id_job']}' and status = '1' order by etapa");
                                                            $etapas = mysqli_fetch_array($sql_etapas);
                                                            $datainicial = $vetor['data_calculo'];
                                                            while ($aux < $maxDepto) {
                                                                if ($depto[$aux]['departamento'] == $etapas['id_departamento']) {
                                                                    $tempo_estimado = (int)$etapas['prazo_geral'];
                                                                    $deptoAtual = mysqli_fetch_array(mysqli_query($con, "select * from departamento_atual_pcp where id_pcp = '{$vetor['id_pcp']}' and id_departamento='{$etapas['id_departamento']}' and status = '1'"));
                                                                    ?>
                                                                    <td>
                                                                        <div class="box"
                                                                             style="background-color: <?php if ($deptoAtual['data_inicio'] != null) {
                                                                                 echo $depto[$aux]['cor'];
                                                                             } else {
                                                                                 echo 'gray';
                                                                             } ?>">
                                                                            <div align="center">
                                                                                <?php echo($deptoAtual['data_inicio'] != null ? date('d/m/Y', strtotime($deptoAtual['data_inicio'])) : date('d/m/Y', strtotime($datainicial))); ?>
                                                                                à <?php echo($deptoAtual['data_inicio'] != null ? ($deptoAtual['data_termino'] != null ? date('d/m/Y', strtotime('+1 months', strtotime($deptoAtual['data_inicio']))) : '--/--/----') : date('d/m/Y', strtotime('+' . $tempo_estimado . ' days', strtotime($datainicial)))); ?>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <?php
                                                                    $tempo_estimado++;
                                                                    $datainicial = date('Y-m-d', strtotime('+' . $tempo_estimado . ' days', strtotime($datainicial)));
                                                                    $etapas = mysqli_fetch_array($sql_etapas);
                                                                } else {
                                                                    echo "<td></td>";
                                                                }
                                                                $aux++;
                                                            } ?>
                                                            <td hidden></td>
                                                            <td hidden><?php echo $vetor['id_pcp']; ?></td>
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
        <script src="../layout/assets/extra-libs/horizontal-timeline/horizontal-timeline.js"></script>
        <script src="../layout/dist/js/custom.min.js"></script>
        <!--This page JavaScript -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="../layout/assets/libs/chartist/dist/chartist.min.js"></script>
        <script src="../layout/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
        <!--c3 charts -->
        <script src="../layout/assets/extra-libs/c3/d3.min.js"></script>
        <script src="../layout/assets/extra-libs/c3/c3.min.js"></script>
        <!--chartjs -->
        <script src="../layout/assets/libs/chart.js/dist/Chart.min.js"></script>
        <script src="../layout/dist/js/pages/dashboards/dashboard1.js"></script>
        <script src="../layout/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/rr-1.2.7/datatables.min.js"></script>

        <script src="https://unpkg.com/floatthead"></script>
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

            function format(d) {
                var aux = '';
                var fd = new FormData();
                fd.append('id_pcp', d.id_pcp);
                $.ajax({
                    url: 'pcp_geral.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    async: false,
                    success: function (response) {
                        aux = response;
                    },
                });
                return aux;
            }

            function cancelarPCP(id) {
                swal({
                    title: "Você tem certeza que deseja cancelar este job?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.post('recebe_job.php?cancelar=' + id, function () {
                                swal('Job Cancelado com Sucesso!', '', 'success');
                                var aux = $('#tabela').DataTable().row('#tr' + id).data();
                                $('#tabela').DataTable().row("#tr" + id).remove();
                                $('#tabela').DataTable().draw();
                                $('#tabela3').DataTable().row.add(aux).draw().node().id = 'tr' + id;
                                $('#tabela3').DataTable().draw();
                                aux = $('#tr' + id).children();
                                $(aux[9]).attr('hidden', 'hidden');
                                $(aux[10]).attr('hidden', 'hidden');
                                aux.each(function () {
                                    $(this).attr('align', 'center');
                                });

                            });

                        }
                    });
            }

            $(document).ready(function () {
                var tabela = $('#tabela').DataTable({
                    destroy: false,
                    scrollCollapse: true,
                    rowReorder: {
                        dataSrc: 'prioridade'
                    },
                    ordering: true,
                    info: true,
                    searching: true,
                    paging: false,
                    dom: 'Bfrtip',
                    "columns": [
                        {"data": "prioridade"},
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": '<button type="button" class="btn"><span><i class="fas fa-plus-circle fa-minus-circle"></i></span></button>'
                        },
                        {"data": "contrato"},
                        {"data": "jobs"},
                        {"data": "criacao"},
                        {"data": "eventos"},
                        {"data": "fotografia"},
                        {"data": "artefinal"},
                        {"data": "producao"},
                        {"data": "marketing"},
                        {"data": "entrega"},
                        {"data": "acao"},
                        {"data": "id_pcp"}
                    ]
                });
                var tabela2 = $('#tabela2').DataTable({
                    destroy: false,
                    "pageLength": 500,
                    scrollCollapse: true,
                    ordering: false,
                    info: true,
                    searching: true,
                    paging: true,
                    dom: 'Bfrtip',
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": '<button type="button" class="btn"><span><i class="fas fa-plus-circle fa-minus-circle"></i></span></button>'
                        },
                        {"data": "contrato"},
                        {"data": "jobs"},
                        {"data": "criacao"},
                        {"data": "eventos"},
                        {"data": "fotografia"},
                        {"data": "artefinal"},
                        {"data": "producao"},
                        {"data": "marketing"},
                        {"data": "entrega"},
                        {"data": "acao"},
                        {"data": "id_pcp"}
                    ]
                });
                var tabela3 = $('#tabela3').DataTable({
                    destroy: false,
                    "pageLength": 500,
                    scrollCollapse: true,
                    ordering: false,
                    info: true,
                    searching: true,
                    paging: true,
                    dom: 'Bfrtip',
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": '<button type="button" class="btn"><span><i class="fas fa-plus-circle fa-minus-circle"></i></span></button>'
                        },
                        {"data": "contrato"},
                        {"data": "jobs"},
                        {"data": "criacao"},
                        {"data": "eventos"},
                        {"data": "fotografia"},
                        {"data": "artefinal"},
                        {"data": "producao"},
                        {"data": "marketing"},
                        {"data": "entrega"},
                        {"data": "acao"},
                        {"data": "id_pcp"}
                    ]
                });
                tabela.on('row-reorder', function (e, diff, edit) {
                    var id_pcp = [];
                    var prioridade = [];
                    for (var i = 0, ien = diff.length; i < ien; i++) {
                        var rowData = tabela.row(diff[i].node).data();
                        id_pcp.push(rowData.id_pcp);
                        prioridade.push(diff[i].newPosition);
                    }
                    var fd = new FormData();
                    fd.append('id_pcp', id_pcp);
                    fd.append('prioridade', prioridade);
                    $.ajax({
                        url: 'recebe_job.php',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        async: false,
                        success: function (response) {
                            if (response == '0') {
                                swal('Erro ao modificar a prioridade!', '', 'warning');
                            }
                        },
                    });
                });
                $('#categoria').on('change', function () {
                    tabela.search(this.value).draw();
                    tabela2.search(this.value).draw();
                    tabela3.search(this.value).draw();
                });
                $('#tabela tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = tabela.row(tr);
                    this.firstElementChild.firstElementChild.firstElementChild.classList.toggle('fa-plus-circle');
                    if (row.child.isShown()) {
                        // This row is already open - close it
                        $('div.slider', row.child()).slideUp('fast', function () {
                            row.child.hide();
                            tr.removeClass('shown');
                        });
                    } else {
                        // Open this row
                        row.child(format(row.data()), 'no-padding').show();
                        tr.addClass('shown');

                        $('div.slider', row.child()).slideDown('fast');
                    }
                });
                $('#tabela2 tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = tabela2.row(tr);
                    this.firstElementChild.firstElementChild.firstElementChild.classList.toggle('fa-plus-circle');
                    if (row.child.isShown()) {
                        // This row is already open - close it
                        $('div.slider', row.child()).slideUp('fast', function () {
                            row.child.hide();
                            tr.removeClass('shown');
                        });
                    } else {
                        // Open this row
                        row.child(format(row.data()), 'no-padding').show();
                        tr.addClass('shown');

                        $('div.slider', row.child()).slideDown('fast');
                    }
                });
                $('#tabela3 tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = tabela3.row(tr);
                    this.firstElementChild.firstElementChild.firstElementChild.classList.toggle('fa-plus-circle');
                    if (row.child.isShown()) {
                        // This row is already open - close it
                        $('div.slider', row.child()).slideUp('fast', function () {
                            row.child.hide();
                            tr.removeClass('shown');
                        });
                    } else {
                        // Open this row
                        row.child(format(row.data()), 'no-padding').show();
                        tr.addClass('shown');

                        $('div.slider', row.child()).slideDown('fast');
                    }
                });
                $('#tabela').floatThead({
                    zIndex: '3'
                });
                $('#tabela2').floatThead({
                    zIndex: '3'
                });
                $('#tabela3').floatThead({
                    zIndex: '3'
                });

            });
        </script>
        </body>

        </html>
    <?php }
} ?>