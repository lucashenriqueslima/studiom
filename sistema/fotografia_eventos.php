<?php

include "../includes/conexao.php";
session_start();
$id_pagina = 25;
if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
} else {
    $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);
    $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
    $vetor_permissao = mysqli_fetch_array($sql_permissao);
    if ($vetor_permissao['listar'] != 2) {
        echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
    }
    if ($vetor_permissao['listar'] == 2) {
        $id_formando = $_GET['id_formando'];
        $sql_produto = mysqli_query($con, "select * from venda_avulsa");
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
            <script type="text/javascript"
                    src="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"></script>
            <script type="text/javascript"
                    src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
            <!-- Custom CSS -->
            <link href="../layout/dist/css/style.min.css" rel="stylesheet">

            <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
            <script src="//cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>
            <script src="//cdn.datatables.net/plug-ins/1.10.21/sorting/data-eu.js"></script>


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
                            <!--                          <h4 class="page-title">Administrativo</h4>-->
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Fotografia</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Gestão de Eventos</li>
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
                                    <!--                                  <h4 class="card-title">Eventos</h4>-->

                                    <?php if ($vetor_permissao['cadastro'] == 1) {
                                    } else { ?><a href="cadastrar_evento.php">
                                        <button type="button" class="btn waves-effect waves-light btn-warning">Novo
                                            Evento
                                        </button>
                                    </a>

                                        <br>
                                        <br>
                                        <br>

                                    <?php } ?>

                                    <ul class="nav nav-tabs" role="tablist">

                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                href="#emaberto"
                                                                role="tab"><span class="hidden-sm-up"><i
                                                            class="ti-email"></i></span> <span class="hidden-xs-down">Em Aberto</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#realizados"
                                                                role="tab"><span class="hidden-sm-up"><i
                                                            class="ti-email"></i></span> <span class="hidden-xs-down">Realizados</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cancelados"
                                                                role="tab"><span class="hidden-sm-up"><i
                                                            class="ti-email"></i></span> <span class="hidden-xs-down">Cancelados</span></a>
                                        </li>

                                    </ul>

                                    <div class="tab-content tabcontent-border">

                                        <div class="tab-pane active" id="emaberto" role="tabpanel">

                                            <br>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="lang_opt_data"
                                                       class="table table-striped table-bordered display"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <button onclick="tableToExcel('lang_opt_data','Relatorio');"
                                                            type="button"
                                                            class="btn btn-info"
                                                            style="float: right;margin-left: 10px;margin-bottom: 3px"><i
                                                                class="mdi mdi-printer"></i></button>
                                                    <tr>
                                                        <th width="37%"><strong><h4>Projetos</strong></h4></th>
                                                        <th width="2%"><strong><h4>Contratos</strong></h4></th>
                                                        <th width="18%"><strong><h4>Evento</strong></h4></th>
                                                        <th width="10%"><strong><h4>Data</strong></h4></th>
                                                        <th width="10%"><strong><h4>Hora</strong></h4></th>
                                                        <th width="5%"><strong><h4>Cidade</strong></h4></th>
                                                        <th width="2%"><strong><h4>UF</strong></h4></th>
                                                        <th width="16%"><strong><h4>Ação</strong></h4></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $dataatual = date('Y-m-d');
                                                    $sql_atual = mysqli_query($con, "select * from eventos_turma where status = 0 order by data ASC");
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        $totalizador = 0;
                                                        $sql_contrato = mysqli_query($con, "select * from turmas where id_turma = '$vetor[id_turma]'");
                                                        $vetor_contrato = mysqli_fetch_array($sql_contrato);
                                                        $sql_categoria = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor[id_categoria]'");
                                                        $vetor_categoria = mysqli_fetch_array($sql_categoria);
                                                        $sql_local = mysqli_query($con, "select * from locais where id_local = '$vetor[id_local]'");
                                                        $vetor_local = mysqli_fetch_array($sql_local);
                                                        //calculo qtd formandos
                                                        $sql_vendas = mysqli_query($con, "select DISTINCT(a.id_formando), a.id_venda, a.id_pacote, a.tipo, b.turma from vendas a, formandos b where a.id_formando = b.id_formando and b.turma = '$vetor[id_turma]' and a.iniciada = '2' and a.tipo IN('2', '3') order by id_venda ASC");
                                                        $sql_consulta = mysqli_query($con, "select * from escala_eventos_itens a, eventos_turma b, escala_eventos c where a.id_evento = b.id_evento and a.id_escala = c.id_escala and c.id_contrato = '$vetor[id_turma]' and b.id_categoria = '$vetor[id_categoria]' order by b.data ASC");
                                                        $vetor_consulta = mysqli_fetch_array($sql_consulta);
                                                        $totalcat = mysqli_num_rows($sql_consulta);
                                                        while ($vetor_vendas = mysqli_fetch_array($sql_vendas)) {
                                                            $sql_pacotes = mysqli_query($con, "SELECT * FROM pacotes a, pacotes_itens_album b WHERE a.id_pacote = b.id_pacote and b.id_item = '$vetor_vendas[id_pacote]'");
                                                            $sql_eventos = mysqli_query($con, "select * from eventos_pacote a, eventos_turma_lista b WHERE a.id_pacote = '$vetor_vendas[id_pacote]' and a.id_evento = b.id_evento_turma and b.id_evento = '$vetor[id_categoria]'");
                                                            $vetor_eventos = mysqli_fetch_array($sql_eventos);
                                                            $total = mysqli_num_rows($sql_eventos);
                                                            if ($total == 1) {
                                                                $totalizador += 1;
                                                            }
                                                        }
                                                        //final calculo qtd formandos
                                                        $totalfinalqtdformando = $totalizador;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $vetor['nome']; ?></td>
                                                            <td align="center"><?php echo $totalfinalqtdformando; ?></td>
                                                            <td><?php echo $vetor_categoria['nome']; ?></td>
                                                            <td align="center"><?php echo date('d/m/Y', strtotime($vetor['data'])); ?></td>
                                                            <td align="center"><?php echo substr($vetor['horainicio'], 0, 5); ?> <?php if ($vetor['horafim'] != '00:00:00') { ?>- <?php echo substr($vetor['horafim'], 0, 5);
                                                                } ?></td>
                                                            <td align="center"><?php echo $vetor_local['cidade']; ?></td>
                                                            <td align="center"><?php echo $vetor_local['estado']; ?></td>
                                                            <td><a class="fancybox fancybox.ajax"
                                                                   href="alterarevento.php?id=<?php echo $vetor['id_evento']; ?>"
                                                                   target="_blank">
                                                                    <button type="button"
                                                                            class="btn btn-success mesmo-tamanho"
                                                                            title="Ver ou Alterar Cadastro"><i
                                                                                class="mdi mdi-tooltip-edit"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="imprimirevento.php?id=<?php echo $vetor['id_evento']; ?>"
                                                                   target="_blank">
                                                                    <button type="button"
                                                                            class="btn btn-primary mesmo-tamanho"
                                                                            title="Imprimir Cadastro"><i
                                                                                class="mdi mdi-cloud-print"></i>
                                                                    </button>
                                                                </a> <?php if ($vetor_permissao['exclusao'] == 1) {
                                                                } else { ?><a class="fancybox fancybox.ajax"
                                                                              href="confexcluirevento.php?id=<?php echo $vetor['id_evento']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger mesmo-tamanho"
                                                                                title="Excluir Cadastro"><i
                                                                                    class="mdi mdi-window-close"></i>
                                                                        </button></a>
                                                                    <a
                                                                        class="fancybox fancybox.ajax"
                                                                        href="cancelarevento.php?id=<?php echo $vetor['id_evento']; ?>">
                                                                    <button type="button"
                                                                            class="btn btn-warning mesmo-tamanho"
                                                                            title="Cancelar Evento"><i
                                                                                class="mdi mdi-timer-off"></i></button>
                                                                </a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    } ?>
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                        <div class="tab-pane" id="realizados" role="tabpanel">

                                            <br>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="lang_opt_data1"
                                                       class="table table-striped table-bordered display"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <button onclick="tableToExcel('lang_opt_data1','Relatorio');"
                                                            type="button"
                                                            class="btn btn-info"
                                                            style="float: right;margin-left: 10px;margin-bottom: 3px"><i
                                                                class="mdi mdi-printer"></i></button>
                                                    <tr>
                                                        <th width="37%"><strong><h4>Projetos</strong></h4></th>
                                                        <th width="2%"><strong><h4>Contratos</strong></h4></th>
                                                        <th width="18%"><strong><h4>Evento</strong></h4></th>
                                                        <th width="10%"><strong><h4>Data</strong></h4></th>
                                                        <th width="10%"><strong><h4>Hora</strong></h4></th>
                                                        <th width="5%"><strong><h4>Cidade</strong></h4></th>
                                                        <th width="2%"><strong><h4>UF</strong></h4></th>
                                                        <th width="16%"><strong><h4>Ação</strong></h4></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $dataatual = date('Y-m-d');
                                                    $sql_atual = mysqli_query($con, "select * from eventos_turma where status = 1 order by data ASC");
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        $totalizador = 0;
                                                        $sql_contrato = mysqli_query($con, "select * from turmas where id_turma = '$vetor[id_turma]'");
                                                        $vetor_contrato = mysqli_fetch_array($sql_contrato);
                                                        $sql_categoria = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor[id_categoria]'");
                                                        $vetor_categoria = mysqli_fetch_array($sql_categoria);
                                                        $sql_local = mysqli_query($con, "select * from locais where id_local = '$vetor[id_local]'");
                                                        $vetor_local = mysqli_fetch_array($sql_local);
                                                        //calculo qtd formandos
                                                        $sql_vendas = mysqli_query($con, "select DISTINCT(a.id_formando), a.id_venda, a.id_pacote, a.tipo, b.turma from vendas a, formandos b where a.id_formando = b.id_formando and b.turma = '$vetor[id_turma]' and a.iniciada = '2' and a.tipo IN('2', '3') order by id_venda ASC");
                                                        $sql_consulta = mysqli_query($con, "select * from escala_eventos_itens a, eventos_turma b, escala_eventos c where a.id_evento = b.id_evento and a.id_escala = c.id_escala and c.id_contrato = '$vetor[id_turma]' and b.id_categoria = '$vetor[id_categoria]' order by b.data ASC");
                                                        $vetor_consulta = mysqli_fetch_array($sql_consulta);
                                                        $totalcat = mysqli_num_rows($sql_consulta);
                                                        while ($vetor_vendas = mysqli_fetch_array($sql_vendas)) {
                                                            $sql_pacotes = mysqli_query($con, "SELECT * FROM pacotes a, pacotes_itens_album b WHERE a.id_pacote = b.id_pacote and b.id_item = '$vetor_vendas[id_pacote]'");
                                                            $sql_eventos = mysqli_query($con, "select * from eventos_pacote a, eventos_turma_lista b WHERE a.id_pacote = '$vetor_vendas[id_pacote]' and a.id_evento = b.id_evento_turma and b.id_evento = '$vetor[id_categoria]'");
                                                            $vetor_eventos = mysqli_fetch_array($sql_eventos);
                                                            $total = mysqli_num_rows($sql_eventos);
                                                            if ($total == 1) {
                                                                $totalizador += 1;
                                                            }
                                                        }
                                                        //final calculo qtd formandos
                                                        $totalfinalqtdformando = $totalizador;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $vetor['nome']; ?></td>
                                                            <td align="center"><?php echo $totalfinalqtdformando; ?></td>
                                                            <td><?php echo $vetor_categoria['nome']; ?></td>
                                                            <td align="center"><?php echo date('d/m/Y', strtotime($vetor['data'])); ?></td>
                                                            <td align="center"><?php echo substr($vetor['horainicio'], 0, 5); ?> <?php if ($vetor['horafim'] != '00:00:00') { ?>- <?php echo substr($vetor['horafim'], 0, 5);
                                                                } ?></td>
                                                            <td align="center"><?php echo $vetor_local['cidade']; ?></td>
                                                            <td align="center"><?php echo $vetor_local['estado']; ?></td>
                                                            <td><a class="fancybox fancybox.ajax"
                                                                   href="alterarevento.php?id=<?php echo $vetor['id_evento']; ?>"
                                                                   target="_blank">
                                                                    <button type="button"
                                                                            class="btn btn-success mesmo-tamanho"
                                                                            title="Ver ou Alterar Cadastro"><i
                                                                                class="mdi mdi-tooltip-edit"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="imprimirevento.php?id=<?php echo $vetor['id_evento']; ?>"
                                                                   target="_blank">
                                                                    <button type="button"
                                                                            class="btn btn-primary mesmo-tamanho"
                                                                            title="Imprimir Cadastro"><i
                                                                                class="mdi mdi-cloud-print"></i>
                                                                    </button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="cancelados" role="tabpanel">

                                            <br>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="lang_opt_data2"
                                                       class="table table-striped table-bordered display"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <button onclick="tableToExcel('lang_opt_data2','Relatorio');"
                                                            type="button"
                                                            class="btn btn-info"
                                                            style="float: right;margin-left: 10px;margin-bottom: 3px"><i
                                                                class="mdi mdi-printer"></i></button>
                                                    <tr>
                                                        <th width="37%"><strong><h4>Projetos</strong></h4></th>
                                                        <th width="2%"><strong><h4>Contratos</strong></h4></th>
                                                        <th width="18%"><strong><h4>Evento</strong></h4></th>
                                                        <th width="10%"><strong><h4>Data</strong></h4></th>
                                                        <th width="10%"><strong><h4>Hora</strong></h4></th>
                                                        <th width="5%"><strong><h4>Cidade</strong></h4></th>
                                                        <th width="2%"><strong><h4>UF</strong></h4></th>
                                                        <th width="16%"><strong><h4>Ação</strong></h4></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $sql_atual = mysqli_query($con, "select * from eventos_turma where status = 2 order by data ASC");
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        $totalizador = 0;
                                                        $sql_contrato = mysqli_query($con, "select * from turmas where id_turma = '$vetor[id_turma]'");
                                                        $vetor_contrato = mysqli_fetch_array($sql_contrato);
                                                        $sql_categoria = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor[id_categoria]'");
                                                        $vetor_categoria = mysqli_fetch_array($sql_categoria);
                                                        $sql_local = mysqli_query($con, "select * from locais where id_local = '$vetor[id_local]'");
                                                        $vetor_local = mysqli_fetch_array($sql_local);
                                                        //calculo qtd formandos
                                                        $sql_vendas = mysqli_query($con, "select DISTINCT(a.id_formando), a.id_venda, a.id_pacote, a.tipo, b.turma from vendas a, formandos b where a.id_formando = b.id_formando and b.turma = '$vetor[id_turma]' and a.iniciada = '2' and a.tipo IN('2', '3') order by id_venda ASC");
                                                        $sql_consulta = mysqli_query($con, "select * from escala_eventos_itens a, eventos_turma b, escala_eventos c where a.id_evento = b.id_evento and a.id_escala = c.id_escala and c.id_contrato = '$vetor[id_turma]' and b.id_categoria = '$vetor[id_categoria]' order by b.data ASC");
                                                        $vetor_consulta = mysqli_fetch_array($sql_consulta);
                                                        $totalcat = mysqli_num_rows($sql_consulta);
                                                        while ($vetor_vendas = mysqli_fetch_array($sql_vendas)) {
                                                            $sql_pacotes = mysqli_query($con, "SELECT * FROM pacotes a, pacotes_itens_album b WHERE a.id_pacote = b.id_pacote and b.id_item = '$vetor_vendas[id_pacote]'");
                                                            $sql_eventos = mysqli_query($con, "select * from eventos_pacote a, eventos_turma_lista b WHERE a.id_pacote = '$vetor_vendas[id_pacote]' and a.id_evento = b.id_evento_turma and b.id_evento = '$vetor[id_categoria]'");
                                                            $vetor_eventos = mysqli_fetch_array($sql_eventos);
                                                            $total = mysqli_num_rows($sql_eventos);
                                                            if ($total == 1) {
                                                                $totalizador += 1;
                                                            }
                                                        }
                                                        //final calculo qtd formandos
                                                        $totalfinalqtdformando = $totalizador;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $vetor['nome']; ?></td>
                                                            <td align="center"><?php echo $totalfinalqtdformando; ?></td>
                                                            <td><?php echo $vetor_categoria['nome']; ?></td>
                                                            <td align="center"><?php echo date('d/m/Y', strtotime($vetor['data'])); ?></td>
                                                            <td align="center"><?php echo substr($vetor['horainicio'], 0, 5); ?> <?php if ($vetor['horafim'] != '00:00:00') { ?>- <?php echo substr($vetor['horafim'], 0, 5);
                                                                } ?></td>
                                                            <td align="center"><?php echo $vetor_local['cidade']; ?></td>
                                                            <td align="center"><?php echo $vetor_local['estado']; ?></td>
                                                            <td><a class="fancybox fancybox.ajax"
                                                                   href="alterarevento.php?id=<?php echo $vetor['id_evento']; ?>"
                                                                   target="_blank">
                                                                    <button type="button"
                                                                            class="btn btn-success mesmo-tamanho"
                                                                            title="Ver ou Alterar Cadastro"><i
                                                                                class="mdi mdi-tooltip-edit"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="imprimirevento.php?id=<?php echo $vetor['id_evento']; ?>"
                                                                   target="_blank">
                                                                    <button type="button"
                                                                            class="btn btn-primary mesmo-tamanho"
                                                                            title="Imprimir Cadastro"><i
                                                                                class="mdi mdi-cloud-print"></i>
                                                                    </button>
                                                                </a> <?php if ($vetor_permissao['exclusao'] == 1) {
                                                                } else { ?><a class="fancybox fancybox.ajax"
                                                                              href="confexcluirevento.php?id=<?php echo $vetor['id_evento']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger mesmo-tamanho"
                                                                                title="Excluir Cadastro"><i
                                                                                    class="mdi mdi-window-close"></i>
                                                                        </button></a><?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    } ?>
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
                if ($.fn.dataTable.isDataTable('#lang_opt_data')) {
                    $('#lang_opt_data').dataTable().fnDestroy();
                    init_data_Table();
                } else {
                    tabelaNcms = $('#lang_opt_data').DataTable({
                        destroy: false,
                        scrollCollapse: true,
                        ordering: true,
                        info: true,
                        searching: true,
                        paging: true,
                        dom: 'Bfrtip',
                        "order": [[3, "asc"]],
                        columnDefs: [
                            {
                                type: 'date-br',
                                targets: 3
                            }
                        ],
                    });
                }
            };

            var init_data_Table1 = function () {
                var tabelaNcms = null;
                if ($.fn.dataTable.isDataTable('#lang_opt_data1')) {
                    $('#lang_opt_data1').dataTable().fnDestroy();
                    init_data_Table1();
                } else {
                    tabelaNcms = $('#lang_opt_data1').DataTable({
                        destroy: false,
                        scrollCollapse: true,
                        ordering: true,
                        info: true,
                        searching: true,
                        paging: true,
                        dom: 'Bfrtip',
                        "order": [[3, "asc"]],
                        columnDefs: [
                            {
                                type: 'date-br',
                                targets: 3
                            }
                        ],
                    });
                }
            };
            var init_data_Table2 = function () {
                var tabelaNcms = null;
                if ($.fn.dataTable.isDataTable('#lang_opt_data2')) {
                    $('#lang_opt_data2').dataTable().fnDestroy();
                    init_data_Table2();
                } else {
                    tabelaNcms = $('#lang_opt_data2').DataTable({
                        destroy: false,
                        scrollCollapse: true,
                        ordering: true,
                        info: true,
                        searching: true,
                        paging: true,
                        dom: 'Bfrtip',
                        "order": [[3, "asc"]],
                        columnDefs: [
                            {
                                type: 'date-br',
                                targets: 3
                            }
                        ],
                    });
                }
            };
            var tableToExcel = (function () {
                var uri = 'data:application/vnd.ms-excel;base64,',
                    template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40%22%3E<head><meta charset="utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
                    base64 = function (
                        s) {
                        return window.btoa(unescape(encodeURIComponent(s)))
                    }, format = function (s, c) {
                        return s.replace(/{(\w+)}/g, function (m, p) {
                            return c[p];
                        })
                    }
                return function (table, name) {
                    if (!table.nodeType)
                        table = document.getElementById(table)
                    var ctx = {
                        worksheet: name || 'Worksheet',
                        table: table.innerHTML
                    }
                    // window.location.href = uri + base64(format(template, ctx))
                    var link = document.createElement("a");
                    link.download = "relatorio.xls";
                    link.href = uri + base64(format(template, ctx));
                    link.click();
                }
            })()

            $(document).ready(function () {
                init_data_Table();
                init_data_Table1();
                init_data_Table2();

                $('#turmas').change(function () {
                    $('#formando').load('formandos_tarefa.php?id_turma=' + $('#turmas').val());

                });

            });

        </script>
        </body>

        </html>
    <?php }
} ?>