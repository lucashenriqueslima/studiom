<?php
include "../includes/conexao.php";
date_default_timezone_set('America/Sao_Paulo');
session_start();
$id_pagina = 47;
if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
} else {
    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from usuarios where id_usuario = '$_SESSION[id]'"));
    $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
    $vetor_permissao = mysqli_fetch_array($sql_permissao);
    if ($vetor_permissao['listar'] != 2) {
        echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
    }
    $vetor_banco = mysqli_fetch_array(mysqli_query($con, "select * from banco where id_banco = '1'"));
    if ($vetor_banco['ambiente'] == 1) {
        $urlbase = $vetor_banco['urlhomologacao'];
    }
    if ($vetor_banco['ambiente'] == 2) {
        $urlbase = $vetor_banco['urlproducao'];
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
            <link href="../layout/dist/css/style.min.css" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="../layout/assets/libs/select2/dist/css/select2.min.css">            
            <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
            <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                $(document).ready(function ($) {
                    $('#valor_recebido').mask('###.###,##', {reverse: true});
                    $('#valor_pago').mask('###.###,##', {reverse: true});
                    $('#valor_gerado').mask('###.###,##', {reverse: true});
                });
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
                            <!-- Comment -->
                            <!-- ============================================================== -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle waves-effect waves-dark" href=""
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                            class="mdi mdi-bell font-24"></i>
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
                                                    <span class="btn btn-success btn-circle"><i class="ti-calendar"></i></span>
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
                                                                class="mail-desc">Just see the my admin!</span> <span
                                                                class="time">9:02 AM</span></div>
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            <a class="nav-link text-center m-b-5 text-dark" href="javascript:void(0);">
                                                <strong>Check all notifications</strong> <i
                                                        class="fa fa-angle-right"></i> </a>
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
                                        <li class="breadcrumb-item">Financeiro</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Gestão de Títulos</li>
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
                                    <h4>Filtrar Data</h4>
                                    <div class="form-row">
                                        <div class="form-group col-lg-2 col-md-3 col-sm-4"
                                             style="margin-bottom: 0px !important;">
                                            <label for="Doctor-name">De</label>
                                            <input type="date" id="min" onchange="filtraData()"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3 col-sm-4"
                                             style="margin-bottom: 0px !important;">
                                            <label for="dob">Até</label>
                                            <input type="date" id="max" onchange="filtraData()"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group col-lg-8 col-md-6 col-sm-4 "
                                             style="margin-bottom: 0px !important;">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="dob" style="float: right !important; margin-right: 0px !important;">Relatório de Inadimplentes: 
                                                    
                                                        <a data-toggle="modal" data-target="#modalRelatorioInadiplentes" href="#"  role="tab">
                                                            <button type="button"
                                                                class="btn btn-primary mesmo-tamanho"
                                                                title="Imprimir Cadastros"><i
                                                                class="fa fa-print"></i>
                                                            </button>
                                                        </a>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="dob" style="float: right !important; margin-right: 0px !important;">Excel Gestão e Título: 
                                                    
                                                        <a data-toggle="modal" data-target="#modalExcelGestaodeTitulos" href="#"  role="tab">
                                                            <button type="button"
                                                                class="btn btn-primary mesmo-tamanho"
                                                                title="Imprimir Cadastros"><i
                                                                class="fa fa-print"></i>
                                                            </button>
                                                        </a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                href="#ch1"
                                                                role="tab"><span
                                                        class="hidden-xs-down">Contas a Receber</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ch3"
                                                                role="tab"><span
                                                        class="hidden-xs-down">Recebidos</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ch2"
                                                                role="tab"><span
                                                        class="hidden-xs-down">Cobrança</span></a>
                                        </li>
                                        
                                        <!--<li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#modalRelatorioInadiplentes" href="#" 
                                                                role="tab"><span
                                                        class="hidden-xs-down">Relatório de Inadimplentes</span></a>
                                        </li>-->
                                    </ul>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalRelatorioInadiplentes" tabindex="-1" role="dialog" aria-labelledby="modalLabelRelatorioInad" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabelRelatorioInad">Relatório de Inadimplentes</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <!--<form action="imprime_relatorioInadimplentes.php" target="_blank">-->
                                            <div class="modal-body">
                                                <label class="form-label semibold" for="data">Data de Vencimento do Boletos:</label>
                                                <input class="form-control" type="date" name="dataRelatorio" id="dataRelatorio">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                <!--<button type="button" class="btn btn-primary" id="exportarcsv">Exportar .CSV</button>-->
                                                
                                                <!--<button type="submit" class="btn btn-primary"  id="exportarcsv" value="csv">Exportar .CSV</button>-->
                                                <button type="button" class="btn btn-primary"  id="exportarcsv" value="csv">Exportar .CSV</button>
    
                                                <a href="javascript:void(0)" id="dlbtn" style="display: none;">
                                                    <button type="button" id="mine"></button>
                                                </a>
                                            </div>
                                        <!-- </form> -->
                                        </div>
                                    </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalExcelGestaodeTitulos" tabindex="-1" role="dialog" aria-labelledby="modalLabelRelatorioInad" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabelRelatorioInad">Excel Movimentação</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                            <form action="imprime_movimentacaofinanceira.php" method="post">    
                                                <div class="form-row">
                                                    <div class="col-lg"></div>
                                                    <div class="form-group col-lg-5 col-md-6 col-sm-8"
                                                        style="margin-bottom: 0px !important;">
                                                        <label for="">De</label>
                                                        <input type="date" id="minn" name="minn"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-lg"></div>
                                                    <div class="form-group col-lg-5 col-md-6 col-sm-8"
                                                        style="margin-bottom: 0px !important;">
                                                        <label for="">Até</label>
                                                        <input type="date" id="maxx" name="maxx"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-lg"></div>
                                                </div>    
                                                <input type="hidden" id="tipo" name="tipo" value="entrada">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    <!--<button type="button" class="btn btn-primary" id="exportarcsv">Exportar .CSV</button>-->
                                                
                                                    <button type="submit" class="btn btn-primary">Exportar Excel</button>
                                                    <!--<button type="button" class="btn btn-primary"  id="exportarcsv" value="csv">Exportar .CSV</button>-->
        
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="tab-content tabcontent-border">
                                        <div class="tab-pane active" id="ch1" role="tabpanel">
                                            <br>
                                            <div class="table-responsive">
                                                <table id="tabela" class="table table-striped table-bordered display"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <tr>
                                                        <th><h5><strong>Cód.<br>Cliente</strong></h5></th>
                                                        <th><h5><strong>Serviço</strong></h5></th>
                                                        <th><h5><strong>Forma<br>Pagamento</strong></h5></th>
                                                        <th><h5><strong>Parcela</strong></h5></th>
                                                        <th><h5><strong>Vencimento</strong></h5></th>
                                                        <th><h5><strong>Fomento</strong></h5></th>
                                                        <th><h5><strong>Valor</strong></h5></th>
                                                        <th><h5><strong>Status</strong></h5></th>
                                                        <th width="16%"><h5><strong>Ação</strong></h5></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $dataatual = date('Y-m-d');
                                                    $sql_atual = mysqli_query($con, "select fo.nome as fonome,t.ncontrato ,f.id_cadastro ,f.nome as fnome ,df.*,v.tipo ,v.qtdparcelas ,fp.nome as fpnome from duplicatas_faturas df
	left join duplicatas d on d.id_duplicata = df.id_duplicata
	left join vendas v on  v.id_venda = d.id_venda
	left join formandos f on f.id_formando = v.id_formando
	left join formaspag fp on fp.id_forma = df.formapag
	left join turmas t on t.id_turma = f.turma
	left join fomentos fo on fo.id_fomento=df.id_fomento
	where v.status ='3' and df.data >= '$dataatual' and df.status <> 2");
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        ?>
                                                        <tr id="tr<?php echo $vetor['id_item']; ?>">
                                                            <td align="center"
                                                                title="<?php echo $vetor['fnome']; ?>"><span
                                                                        hidden><?php echo $vetor['fnome']; ?></span><?php echo $vetor['ncontrato'] . '-' . $vetor['id_cadastro']; ?>
                                                            </td>
                                                            <td align="center"><?php switch ($vetor['tipo']) {
                                                                    case '1':
                                                                        echo "Convite";
                                                                        break;
                                                                    case '2':
                                                                        echo "Fotografia";
                                                                        break;
                                                                    case '3':
                                                                        echo "V.Avulsa";
                                                                        break;
                                                                    case '4':
                                                                        echo "Taxa de Estúdio";
                                                                        break;
                                                                }; ?>
                                                            </td>
                                                            <td align="center"><?php echo $vetor['fpnome']; ?></td>
                                                            <td align="center"><?php echo $vetor['posicao'] . '/' . $vetor['qtdparcelas']; ?></td>
                                                            <td align="center"><?php echo date('d/m/Y', strtotime($vetor['data'])); ?></td>
                                                            <td align="center">
                                                                <?php if ($vetor['id_fomento'] == null && $vetor['link'] == null) {
                                                                    echo "<button
                                                                      type=\"button\" class=\"btn btn-info\"
                                                                      title=\"Inserir Fomento\"
                                                                      onclick=\"abreModal(" . $vetor['id_item'] . ",'')\">
                                                              <span><i class=\"fas fa-money-bill-alt fa-lg\"></i></span>
                                                              </button>";
                                                                } else {
                                                                    if ($vetor['id_fomento'] == null) {
                                                                        echo "GetNet";
                                                                    } else {
                                                                        echo "<button
                                                                      type=\"button\" class=\"btn btn-info\"
                                                                      title=\"Inserir Fomento\"
                                                                      onclick=\"abreModal(" . $vetor['id_item'] . ",'')\">
                                                              <span>" . $vetor['fonome'] . "</span>
                                                              </button>";
                                                                    }
                                                                } ?>
                                                            </td>
                                                            <td align="center"><?php echo $vetor['valor']; ?></td>
                                                            <td align="center"
                                                                id="status_<?php echo $vetor['id_item']; ?>"><?php switch ($vetor['status']) {
                                                                    case '1':
                                                                        if ($vetor['id_fomento'] != null) {
                                                                            echo "Antecipado";
                                                                        } else {
                                                                            echo "Em Aberto";
                                                                        }
                                                                        break;
                                                                    case '4':
                                                                        echo "Negado";
                                                                        break;
                                                                } ?>
                                                            </td>
                                                            <td align="center">
                                                                <button type="button" class="btn btn-info btn-md"
                                                                        title="Inserir Valor Recebido"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'2')"
                                                                        id="valorrecebido_<?php echo $vetor['id_item']; ?>">
                                                                    <span><i class="fas fa-hand-holding-usd fa-lg"></i></span>
                                                                </button>
                                                                <button id="gerar_<?php echo $vetor['id_item']; ?>"
                                                                        type="button"
                                                                        class="btn btn-secondary" <?php if ($vetor['arquivo'] != null) {
                                                                    echo 'hidden';
                                                                } ?>
                                                                        title="Gerar Boleto Santander"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'5')">
                                                                    <span><i class="fas fa-history fa-lg"></i></span>
                                                                </button>
                                                                <button id="inserir<?php echo $vetor['id_item']; ?>"
                                                                        type="button" class="btn btn-success"
                                                                        title="Inserir Boleto"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'4')" <?php if (!($vetor['arquivo'] == '' && $vetor['boleto'] == '')) {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-cloud-upload-alt fa-md"></i></span>
                                                                </button>
                                                                <a href="<?php if ($vetor['arquivo'] != null) {
                                                                    echo 'arquivos/' . $vetor['arquivo'];
                                                                } elseif ($vetor['link'] != null) {
                                                                    echo $urlbase . $vetor['link'];
                                                                } ?>" target="_blank"
                                                                   id="bol<?php echo $vetor['id_item']; ?>" <?php if ($vetor['arquivo'] == null && $vetor['link'] == null) {
                                                                    echo 'hidden';
                                                                }; ?>>
                                                                    <button type="button" class="btn btn-warning"
                                                                            title="Ver Boleto">
                                                                        <span><i class="fas fa-file-alt fa-lg"></i></span>
                                                                    </button>
                                                                </a>
                                                                <button id="exclui<?php echo $vetor['id_item'] ?>"
                                                                        type="button" class="btn btn-danger"
                                                                        title="Excluir Boleto"
                                                                        onclick="excluiBoleto(<?php echo $vetor['id_item']; ?>)" <?php if (($vetor['arquivo'] == '') && ($vetor['arquivo'] != null)) {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-times fa-lg"></i></span>
                                                                </button>
                                                                <button type="button" class="btn btn-danger"
                                                                        title="Recomprar Título"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'6')"
                                                                        id="resgatar_<?php echo $vetor['id_item']; ?>"
                                                                        hidden>
                                                                    <span><i class="fas fa-history fa-lg"></i></span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                    <tfoot align="center">
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <input type="text" name="id_boleto" id="id_boleto" hidden>
                                        <!--                                      MODALS-->
                                        <div>
                                            <div id="modal" class="modal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Inserir Fomento</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                <label class="form-label semibold"
                                                                       for="fomento">Escolha um
                                                                    Fomento</label>
                                                                <select id="fomento" name="fomento"
                                                                        class="form-control">
                                                                    <option value="">Selecione um Fomento</option>
                                                                    <?php
                                                                    $sql_fomento = mysqli_query($con, "select * from fomentos where status = '1' order by nome");
                                                                    while ($fomento = mysqli_fetch_array($sql_fomento)) {
                                                                        echo "<option value=\"" . $fomento['id_fomento'] . "\">" . $fomento['nome'] . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" id="enviarFomento"
                                                                    class="btn btn-success" data-dismiss="modal">Salvar
                                                            </button>
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Fechar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="modal2" class="modal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Valor Recebido</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label class="form-label semibold"
                                                                   for="valor_recebido">R$</label>
                                                            <input type="text" class="form-control"
                                                                   name="valor_recebido" id="valor_recebido">
                                                            <br>
                                                            <label class="form-label semibold"
                                                                   for="id_conta">Data de Baixa</label>
                                                            <input type="date" id="data_pagamento" class="form-control">
                                                            <br>
                                                            <label class="form-label semibold"
                                                                   for="id_conta">Conta de Destino</label>
                                                            <select class="form-control" name="id_conta" id="id_conta">
                                                                <?php
                                                                $contas = mysqli_query($con, "select * from contas where status = '1'");
                                                                while ($vetor_contas = mysqli_fetch_array($contas)) { ?>
                                                                    <option value="<?php echo $vetor_contas['id_conta']; ?>"><?php echo ucwords($vetor_contas['nome']); ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <br>
                                                            <label class="form-label semibold"
                                                                   for="id_conta">Tipo de Pagamento</label>
                                                            <select class="form-control" name="tipo_pagamento"
                                                                    id="tipo_pagamento">
                                                                <?php
                                                                $tipo_pagamento = mysqli_query($con, "select * from tipos_pagamento where tipo = 'receita' and status = '1'");
                                                                while ($vetor_tipo_pagamento = mysqli_fetch_array($tipo_pagamento)) { ?>
                                                                    <option value="<?php echo $vetor_tipo_pagamento['id_tipo_pagamento']; ?>"><?php echo ucwords($vetor_tipo_pagamento['nome']); ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <br>
                                                            <span id="plano_contas_esconde" hidden>
                                                          <label class="form-label semibold"
                                                                 for="selectTurma">Plano de Contas</label>
                                                          <select id="plano_contas" name="plano_contas"
                                                                  class="select2 form-control"
                                                                  style="width: 100%">
                                                              <option value="" selected="">Selecione uma
                                                                  Categoria
                                                              </option>
			                                                      <?php
                                                                  $sql = mysqli_query($con, "select * from categorias_contas where cat_filha = '321' or cat_filha = '341' and status = '1'");
                                                                  while ($vetor = mysqli_fetch_array($sql)) {
                                                                      ?>
                                                                      <option value="<?php echo $vetor['id_catconta']; ?>"><?php echo $vetor['numeracao'] . ' - ' . $vetor['titulo']; ?></option>
                                                                  <?php } ?>
                                                          </select>
                                                              </span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" id="enviarValor"
                                                                    class="btn btn-success">Salvar
                                                            </button>
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Fechar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="modal4" class="modal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Enviar Boleto</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                <input class="custom-file-input" type="file"
                                                                       name="boleto"
                                                                       id="boleto">
                                                                <label class="custom-file-label" id="labelboleto"
                                                                       for="boleto">Escolha um
                                                                    arquivo</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" id="enviarboleto"
                                                                    class="btn btn-success" data-dismiss="modal">Salvar
                                                            </button>
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Fechar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="modal5" class="modal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Gerar Boleto Santander</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label class="form-label semibold"
                                                                   for="valor_gerado">R$</label>
                                                            <input type="text" class="form-control"
                                                                   name="valor_gerado" id="valor_gerado">
                                                            <br>
                                                            <div>
                                                                <label class="form-label semibold"
                                                                       for="data">Data de Vencimento do Boleto</label>
                                                                <input class="form-control" type="date" name="data"
                                                                       id="data">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" id="gerarBoleto"
                                                                    class="btn btn-success" data-dismiss="modal">Gerar
                                                            </button>
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Fechar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="modal6" class="modal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Recomprar Título</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label class="form-label semibold"
                                                                   for="valor_pago">R$</label>
                                                            <input type="text" class="form-control"
                                                                   name="valor_pago" id="valor_pago">
                                                            <br>
                                                            <label class="form-label semibold"
                                                                   for="id_conta2">Conta de Destino</label>
                                                            <select class="form-control" name="id_conta" id="id_conta2">
                                                                <?php
                                                                $contas = mysqli_query($con, "select * from contas where status = '1'");
                                                                while ($vetor_contas = mysqli_fetch_array($contas)) { ?>
                                                                    <option value="<?php echo $vetor_contas['id_conta']; ?>"><?php echo ucwords($vetor_contas['nome']); ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" id="resgatarTitulo"
                                                                    class="btn btn-success" data-dismiss="modal">Salvar
                                                            </button>
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Fechar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" id="valor_real" name="valor_real" hidden>
                                        </div>
                                        <!--                                      COBRANÇA-->
                                        <div class="tab-pane" id="ch2" role="tabpanel">
                                            <br>
                                            <div class="table-responsive">
                                                <table id="tabela2" class="table table-striped table-bordered display"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <tr>
                                                        <th><h5><strong>Cód.<br>Cliente</strong></h5></th>
                                                        <th><h5><strong>Nome</strong></h5></th>
                                                        <th><h5><strong>Serviço</strong></h5></th>
                                                        <th><h5><strong>Parcela</strong></h5></th>
                                                        <th><h5><strong>Vencimento</strong></h5></th>
                                                        <th><h5><strong>Fomento</strong></h5></th>
                                                        <th><h5><strong>Valor</strong></h5></th>
                                                        <th><h5><strong>Pago</strong></h5></th>
                                                        <th width="16%"><h5><strong>Ação</strong></h5></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $dataatual = date('Y-m-d');
                                                    $sql_atual = mysqli_query($con, "select fo.nome as fonome,t.ncontrato ,f.id_cadastro ,f.nome as fnome ,df.*,v.tipo ,v.qtdparcelas from duplicatas_faturas df
	left join duplicatas d on d.id_duplicata = df.id_duplicata
	left join vendas v on  v.id_venda = d.id_venda
	left join formandos f on f.id_formando = v.id_formando
	left join turmas t on t.id_turma = f.turma
	left join fomentos fo on fo.id_fomento=df.id_fomento
	where v.status ='3' and (df.data < '{$dataatual}' and (df.status = 1 || df.status = 4)) or (df.status = 2 and (df.pagamento is null or df.pagamento = 0) and df.data < '{$dataatual}')");
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        ?>
                                                        <tr id="tr<?php echo $vetor['id_item']; ?>">
                                                            <td align="center"
                                                                title="<?php echo $vetor['fnome']; ?>"><?php echo $vetor['ncontrato'] . '-' . $vetor['id_cadastro']; ?></td>
                                                            <td align="center"><?php echo $vetor['fnome']; ?></td>
                                                            <td align="center"><?php switch ($vetor['tipo']) {
                                                                    case '1':
                                                                        echo "Convite";
                                                                        break;
                                                                    case '2':
                                                                        echo "Fotografia";
                                                                        break;
                                                                    case '3':
                                                                        echo "V.Avulsa";
                                                                        break;
                                                                    case '4':
                                                                        echo "Taxa de Estúdio";
                                                                        break;
                                                                }; ?>
                                                            </td>
                                                            <td align="center"><?php echo $vetor['posicao'] . '/' . $vetor['qtdparcelas']; ?></td>
                                                            <td align="center"><?php echo date('d/m/Y', strtotime($vetor['data'])); ?></td>
                                                            <td align="center">
                                                                <?php if ($vetor['id_fomento'] == null && $vetor['link'] == null) {
                                                                    echo "<button
                                                                      type=\"button\" class=\"btn btn-info\"
                                                                      title=\"Inserir Fomento\"
                                                                      onclick=\"abreModal(" . $vetor['id_item'] . ",'','2')\">
                                                              <span><i class=\"fas fa-money-bill-alt fa-lg\"></i></span>
                                                              </button>";
                                                                } else {
                                                                    if ($vetor['id_fomento'] == null) {
                                                                        echo "GetNet";
                                                                    } else {
                                                                        echo "<button
                                                                      type=\"button\" class=\"btn btn-info\"
                                                                      title=\"Inserir Fomento\"
                                                                      onclick=\"abreModal(" . $vetor['id_item'] . ",'','2')\">
                                                              <span>" . $vetor['fonome'] . "</span>
                                                              </button>";
                                                                    }
                                                                } ?>
                                                            </td>
                                                            <td align="center"><?php echo $vetor['valor']; ?></td>
                                                            <td align="center">
                                                                <button id="pago_<?php echo $vetor['id_item']; ?>"
                                                                        class="btn btn-success"
                                                                        onclick="mudaStatus(<?php echo $vetor['id_item']; ?>,'0')" <?php if (!((int)$vetor['pagamento'] != 1 && $vetor['status'] == '2' )) {
                                                                    echo "hidden";
                                                                } ?>>SIM
                                                                </button>
                                                                <button id="naopago_<?php echo $vetor['id_item']; ?>"
                                                                        class="btn btn-danger"
                                                                        onclick="mudaStatus(<?php echo $vetor['id_item']; ?>,'1')" <?php if (!((int)$vetor['pagamento'] != 0 && $vetor['status'] == '2')) {
                                                                    echo "hidden";
                                                                } ?>>NÃO
                                                                </button>
                                                            </td>
                                                            <td align="center">
                                                                <button type="button" class="btn btn-info btn-md"
                                                                        title="Valor Recebido"
                                                                        id="valorrecebido_<?php echo $vetor['id_item']; ?>"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'2','2')" <?php if ($vetor['status'] == '2') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-hand-holding-usd fa-lg"></i></span>
                                                                </button>
                                                                <button id="gerar_<?php echo $vetor['id_item']; ?>"
                                                                        type="button" class="btn btn-secondary"
                                                                        title="Gerar Boleto Santander"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'5','2')" <?php if ($vetor['status'] == '2') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-history fa-lg"></i></span>
                                                                </button>
                                                                <a href="interacoes_cobranca.php?id=<?php echo $vetor['id_item']; ?>"
                                                                   target="_blank"
                                                                   id="interacoes_<?php echo $vetor['id_item']; ?>">
                                                                    <button type="button" class="btn btn-primary"
                                                                            title="Visualizar Interações">
                                                                        <span><i class="fas fa-eye fa-md"></i></span>
                                                                    </button>
                                                                </a>
                                                                <button id="inserir<?php echo $vetor['id_item']; ?>"
                                                                        type="button" class="btn btn-success"
                                                                        title="Inserir Boleto"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'4','2')" <?php if (!($vetor['arquivo'] == '' && $vetor['boleto'] == '')) {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-cloud-upload-alt fa-md"></i></span>
                                                                </button>
                                                                <a href="<?php if ($vetor['arquivo'] != null) {
                                                                    echo 'arquivos/' . $vetor['arquivo'];
                                                                } elseif ($vetor['link'] != null) {
                                                                    echo $urlbase . $vetor['link'];
                                                                } ?>" target="_blank"
                                                                   id="bol<?php echo $vetor['id_item']; ?>" <?php if ($vetor['arquivo'] == null && $vetor['link'] == null) {
                                                                    echo 'hidden';
                                                                }; ?>>
                                                                    <button type="button" class="btn btn-warning"
                                                                            title="Ver Boleto">
                                                                        <span><i class="fas fa-file-alt fa-lg"></i></span>
                                                                    </button>
                                                                </a>
                                                                <button id="exclui<?php echo $vetor['id_item'] ?>"
                                                                        type="button" class="btn btn-danger"
                                                                        title="Excluir Boleto"
                                                                        onclick="excluiBoleto(<?php echo $vetor['id_item']; ?>)" <?php if (($vetor['arquivo'] == '') && ($vetor['arquivo'] != null)) {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-times fa-lg"></i></span>
                                                                </button>
                                                                <button type="button" class="btn btn-danger"
                                                                        title="Recomprar Título"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'6','2')"
                                                                        id="resgatar_<?php echo $vetor['id_item']; ?>" <?php if ($vetor['status'] == '1') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-history fa-lg"></i></span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                    <tfoot align="center">
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <!--                                      RECEBIDOS-->
                                        <div class="tab-pane" id="ch3" role="tabpanel">
                                            <br>
                                            <div class="table-responsive">
                                                <table id="tabela3" class="table table-striped table-bordered display"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <tr>
                                                        <th><h5><strong>Cód.<br>Cliente</strong></h5></th>
                                                        <th><h5><strong>Nome</strong></h5></th>
                                                        <th><h5><strong>Serviço</strong></h5></th>
                                                        <th><h5><strong>Parcela</strong></h5></th>
                                                        <th><h5><strong>Vencimento</strong></h5></th>
                                                        <th><h5><strong>Fomento</strong></h5></th>
                                                        <th><h5><strong>Valor<br>Recebido</strong></h5></th>
                                                        <th><h5><strong>Status</strong></h5></th>
                                                        <th><h5><strong>Pago</strong></h5></th>
                                                        <th width="16%"><h5><strong>Ação</strong></h5></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $dataatual = date('Y-m-d');
                                                    $sql_atual = mysqli_query($con, "select fo.nome as fonome,t.ncontrato ,f.id_cadastro ,f.nome as fnome ,df.*,v.tipo ,v.qtdparcelas from duplicatas_faturas df
	left join duplicatas d on d.id_duplicata = df.id_duplicata
	left join vendas v on  v.id_venda = d.id_venda
	left join formandos f on f.id_formando = v.id_formando
	left join turmas t on t.id_turma = f.turma
	left join fomentos fo on fo.id_fomento=df.id_fomento
	where v.status ='3' and (df.status = 2 and df.data >= '$dataatual') or (df.status = 2 and df.pagamento = 1)");
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        $cobranca = mysqli_query($con, "select * from interacao_cobranca where id_duplicata_fatura='$vetor[id_item]'");
                                                        ?>
                                                        <tr id="tr<?php echo $vetor['id_item']; ?>">
                                                            <td align="center"
                                                                title="<?php echo $vetor['fnome']; ?>"><?php echo $vetor['ncontrato'] . '-' . $vetor['id_cadastro']; ?></td>
                                                            <td align="center"><?php echo $vetor['fnome']; ?></td>
                                                            <td align="center"><?php switch ($vetor['tipo']) {
                                                                    case '1':
                                                                        echo "Convite";
                                                                        break;
                                                                    case '2':
                                                                        echo "Fotografia";
                                                                        break;
                                                                    case '3':
                                                                        echo "V.Avulsa";
                                                                        break;
                                                                    case '4':
                                                                        echo "Taxa de Estúdio";
                                                                        break;
                                                                }; ?>
                                                            </td>
                                                            <td align="center"><?php echo $vetor['posicao'] . '/' . $vetor['qtdparcelas']; ?></td>
                                                            <td align="center"><?php echo date('d/m/Y', strtotime($vetor['data'])); ?></td>
                                                            <td align="center">
                                                                <?php if ($vetor['id_fomento'] == null && $vetor['link'] == null && $vetor['formapag'] != '3') {
                                                                    echo "<button
                                                                      type=\"button\" class=\"btn btn-info\"
                                                                      title=\"Inserir Fomento\"
                                                                      onclick=\"abreModal(" . $vetor['id_item'] . ",'','3')\">
                                                              <span><i class=\"fas fa-money-bill-alt fa-lg\"></i></span>
                                                              </button>";
                                                                } else {
                                                                    if ($vetor['id_fomento'] == null || $vetor['formapag'] == '3') {
                                                                        echo "GetNet";
                                                                    } else {
                                                                        echo "<button
                                                                      type=\"button\" class=\"btn btn-info\"
                                                                      title=\"Inserir Fomento\"
                                                                      onclick=\"abreModal(" . $vetor['id_item'] . ",'','3')\">
                                                              <span>" . $vetor['fonome'] . "</span>
                                                              </button>";
                                                                    }
                                                                } ?>
                                                            </td>
                                                            <td align="center"><?php echo $vetor['valor_recebido']; ?></td>
                                                            <td align="center"
                                                                id="status_<?php echo $vetor['id_item']; ?>"><?php if ($vetor['cobranca'] == '1') {
                                                                    echo "Cobrança";
                                                                } elseif ($vetor['id_fomento'] != null) {
                                                                    echo "Antecipação";
                                                                } elseif ($vetor['link'] != null) {
                                                                    echo "Cliente";
                                                                } else {
                                                                    echo "Recebido";
                                                                } ?>
                                                            </td>
                                                            <td align="center">
                                                                <button id="pago_<?php echo $vetor['id_item']; ?>"
                                                                        class="btn btn-success"
                                                                        onclick="mudaStatus(<?php echo $vetor['id_item']; ?>,'0')" <?php if ((int)$vetor['pagamento'] != 1) {
                                                                    echo "hidden";
                                                                } ?>>SIM
                                                                </button>
                                                                <button id="naopago_<?php echo $vetor['id_item']; ?>"
                                                                        class="btn btn-danger"
                                                                        onclick="mudaStatus(<?php echo $vetor['id_item']; ?>,'1')" <?php if ((int)$vetor['pagamento'] == 1) {
                                                                    echo "hidden";
                                                                } ?>>NÃO
                                                                </button>
                                                            </td>
                                                            <td align="center">
                                                                <button type="button" class="btn btn-info btn-md"
                                                                        title="Valor Recebido"
                                                                        id="valorrecebido_<?php echo $vetor['id_item']; ?>"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'2','3')"
                                                                        hidden>
                                                                    <span><i class="fas fa-hand-holding-usd fa-lg"></i></span>
                                                                </button>
                                                                <button id="gerar_<?php echo $vetor['id_item']; ?>"
                                                                        type="button"
                                                                        class="btn btn-secondary" <?php if ($vetor['arquivo'] != null) {
                                                                    echo 'hidden';
                                                                } ?>
                                                                        title="Gerar Boleto Santander"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'5','3')"
                                                                        hidden>
                                                                    <span><i class="fas fa-history fa-lg"></i></span>
                                                                </button> <?php if (mysqli_num_rows($cobranca) > 0) { ?>
                                                                    <a href="interacoes_cobranca.php?id=<?php echo $vetor['id_item']; ?>"
                                                                       target="_blank"
                                                                       id="interacoes_<?php echo $vetor['id_item']; ?>">
                                                                        <button type="button" class="btn btn-primary"
                                                                                title="Visualizar Interações">
                                                                            <span><i class="fas fa-eye fa-md"></i></span>
                                                                        </button>
                                                                    </a>
                                                                <?php } ?>
                                                                <button type="button" class="btn btn-success"
                                                                        title="Inserir Boleto"
                                                                        id="inserir<?php echo $vetor['id_item']; ?>"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'4','3')" <?php if (!($vetor['arquivo'] == '' && $vetor['boleto'] == '')) {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-cloud-upload-alt fa-md"></i></span>
                                                                </button>
                                                                <a href="<?php if ($vetor['arquivo'] != null) {
                                                                    echo 'arquivos/' . $vetor['arquivo'];
                                                                } elseif ($vetor['link'] != null) {
                                                                    echo $urlbase . $vetor['link'];
                                                                } ?>" target="_blank"
                                                                   id="bol<?php echo $vetor['id_item']; ?>" <?php if ($vetor['arquivo'] == null && $vetor['link'] == null) {
                                                                    echo 'hidden';
                                                                }; ?>>
                                                                    <button type="button" class="btn btn-warning"
                                                                            title="Ver Boleto">
                                                                        <span><i class="fas fa-file-alt fa-lg"></i></span>
                                                                    </button>
                                                                </a>
                                                                <button id="exclui<?php echo $vetor['id_item'] ?>"
                                                                        type="button" class="btn btn-danger"
                                                                        title="Excluir Boleto"
                                                                        onclick="excluiBoleto(<?php echo $vetor['id_item']; ?>)" <?php if (($vetor['arquivo'] == '') && ($vetor['arquivo'] != null)) {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-times fa-lg"></i></span>
                                                                </button>
                                                                <button type="button" class="btn btn-danger"
                                                                        title="Recomprar Título"
                                                                        onclick="abreModal(<?php echo $vetor['id_item']; ?>,'6','3')"
                                                                        id="resgatar_<?php echo $vetor['id_item']; ?>"
                                                                        hidden>
                                                                    <span><i class="fas fa-history fa-lg"></i></span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                    <tfoot align="center">
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    </tfoot>
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
        <script src="../layout/assets/libs/select2/dist/js/select2.min.js"></script>
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
        <script src="../layout/assets/libs/moment/min/moment.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var valid = true;
                    var min = moment($("#min").val());
                    if (!min.isValid()) {
                        min = null;
                    }
                    var max = moment($("#max").val());
                    if (!max.isValid()) {
                        max = null;
                    }
                    if (min === null && max === null) {
                        // no filter applied or no date columns
                        valid = true;
                    } else {
                        $.each(settings.aoColumns, function (i, col) {
                            if (col.type == "date-br") {
                                var cDate = moment(data[i], 'DD/MM/YYYY');
                                if (cDate.isValid()) {
                                    if (max !== null && max.isBefore(cDate)) {
                                        valid = false;
                                    }
                                    if (min !== null && cDate.isBefore(min)) {
                                        valid = false;
                                    }
                                } else {
                                    valid = false;
                                }
                            }
                        });
                    }
                    return valid;
                });
            function formatarCampo(dado) {
                var aux = parseFloat(dado);
                return aux.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
            }
            $(document).ready(function () {
                $('.select2').each(function () {
                    $(this).select2({
                        dropdownParent: $('#modal2'),
                        width: 'resolve'
                    });
                });
                var tabela = $('#tabela').DataTable({
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
                            targets: 4
                        },
                        {
                            render: function (data, type, row) {
                                return formatarCampo(data);
                            },
                            targets: 6
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
                        // // Total over this page
                        pageTotal = api
                            .column(6, {filter: 'applied'})
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);
                        // Update footer
                        $(api.column(6).footer()).html('<strong>Total: ' + pageTotal.toLocaleString('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        }));
                    }
                });
                var tabela2 = $('#tabela2').DataTable({
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
                            targets: 4
                        },
                        {
                            render: function (data, type, row) {
                                return formatarCampo(data);
                            },
                            targets: 6
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
                        // // Total over this page
                        pageTotal = api
                            .column(6, {filter: 'applied'})
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);
                        // Update footer
                        $(api.column(6).footer()).html('<strong>Total: ' + pageTotal.toLocaleString('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        }));
                    }
                });
                var tabela3 = $('#tabela3').DataTable({
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
                            targets: 6
                        },
                        {
                            render: function (data, type, row) {
                                return formatarCampo(data);
                            },
                            targets: 6
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
                        // // Total over this page
                        pageTotal = api
                            .column(6, {filter: 'applied'})
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);
                        // Update footer
                        $(api.column(6).footer()).html('<strong>Total: ' + pageTotal.toLocaleString('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        }));
                    }
                });
                var activeTab = location.hash;
                if (activeTab != "") {
                    var splitted = activeTab.split('#');
                    for (var i = 1; i < splitted.length; i++) {
                        $('.nav-link[href="#' + splitted[i] + '"]').click();
                    }
                }
                $("#enviarboleto").click(function () {
                    var fd = new FormData();
                    var files = $('#boleto')[0].files[0];
                    fd.append('boleto', files);
                    fd.append('id_boleto', $('#id_boleto').val());
                    $.ajax({
                        url: 'recebe_gestaotitulos.php?tag=5jy',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            swal('Boleto Enviado com Sucesso!', '', 'success');
                            $('#boleto').val('');
                            $('#labelboleto').html('Escolha um arquivo');
                            $("#bol" + $('#id_boleto').val()).attr('href', '../sistema/arquivos/' + response);
                            $("#inserir" + $('#id_boleto').val()).attr('hidden', 'hidden');
                            $("#bol" + $('#id_boleto').val()).removeAttr('hidden');
                            $("#exclui" + $('#id_boleto').val()).removeAttr('hidden');
                        },
                    });
                });
                $("#resgatarTitulo").click(function () {
                    var fd = new FormData();
                    fd.append('valor_pago', $('#valor_pago').val());
                    fd.append('id_conta', $('#id_conta2').val());
                    $.ajax({
                        url: 'recebe_gestaotitulos.php?resgatar=' + $('#id_boleto').val(),
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            swal("Recompra de Título Efetuada com Sucesso!", '', 'success');
                            $('#tabela2').DataTable().row("#tr" + $('#id_boleto').val()).remove();
                            var dados = response.split(';;');
                            $('#tabela2').DataTable().row.add([dados[0], dados[1], dados[2], dados[3], dados[4], dados[5], dados[6], dados[7], dados[8]]).draw().node().id = 'tr' + $('#id_boleto').val();
                            $('#tabela2').DataTable().draw();
                        },
                    });
                    var aux = $('#tr' + $('#id_boleto').val()).children();
                    aux.each(function () {
                        $(this).attr('align', 'center');
                    });
                    $('#tabela2').DataTable().draw();
                });
                $("#enviarFomento").click(function () {
                    var fd = new FormData();
                    fd.append('id_boleto', $('#id_boleto').val());
                    fd.append('fomento', $('#fomento').val());
                    $.ajax({
                        url: 'recebe_gestaotitulos.php?tag=4y3',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            swal('Fomento Inserido com Sucesso!', '', 'success');
                            var aux = $('#tr' + $('#id_boleto').val()).children();
                            $(aux[5]).html(response);
                            $("#status_" + $('#id_boleto').val()).html('Antecipado');
                            $("#gerar_" + $('#id_boleto').val()).attr('hidden', 'hidden');
                        },
                    });
                });
                $("#enviarValor").click(function () {
                    if ((verificaValores($('#valor_recebido').val()) && $('#plano_contas').val() != '') || (!verificaValores($('#valor_recebido').val()))) {
                        var fd = new FormData();
                        fd.append('id_boleto', $('#id_boleto').val());
                        fd.append('valor_recebido', $('#valor_recebido').val());
                        fd.append('id_conta', $('#id_conta').val());
                        fd.append('tipo_pagamento', $('#tipo_pagamento').val());
                        fd.append('data_pagamento', $('#data_pagamento').val());
                        if (verificaValores($('#valor_recebido').val())) {
                            fd.append('plano_contas', $('#plano_contas').val());
                        }
                        $.ajax({
                            url: 'recebe_gestaotitulos.php?tag=kh2',
                            type: 'post',
                            data: fd,
                            async: false,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                $('#modal2').modal('hide');
                                swal('Valor Recebido Inserido com Sucesso!', '', 'success');
                                var qualTabela = document.getElementById('tr' + $('#id_boleto').val()).parentElement.parentElement.id;
                                $('#' + qualTabela).DataTable().row("#tr" + $('#id_boleto').val()).remove();
                                var dados = response.split(';;');
                                $('#tabela3').DataTable().row.add([dados[0], dados[1], dados[2], dados[3], dados[4], dados[5], dados[6], dados[7], dados[8], dados[9]]).draw().node().id = 'tr' + $('#id_boleto').val();
                                $('#tabela3').DataTable().draw();
                                $('#' + qualTabela).DataTable().draw();
                            }
                        });
                    } else {
                        swal('Você precisa inserir uma categoria do plano de contas para justificar a diferença de valor.', '', 'warning');
                    }
                });
                $("#gerarBoleto").click(function () {
                    var fd = new FormData();
                    fd.append('id_boleto', $('#id_boleto').val());
                    fd.append('data', $('#data').val());
                    fd.append('valor_gerado', $('#valor_gerado').val());
                    $.ajax({
                        url: 'recebe_gestaotitulos.php?tag=53g',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            swal('Boleto Gerado com Sucesso!', '', 'success');
                            $("#inserir" + $('#id_boleto').val()).attr('hidden', 'hidden');
                            $("#bol" + $('#id_boleto').val()).removeAttr('hidden');
                            $("#bol" + $('#id_boleto').val()).attr('href', response);
                            $("#fomento_" + $('#id_boleto').val()).html('GetNet');
                        },
                    });
                });
                //exportar csv ajax
                
                $("#exportarcsv").click(function(){                   
                    var dataRelatorio = document.getElementById("dataRelatorio").value;
                    //console.log(dataRelatorio);
                    if (typeof(dataRelatorio) != 'undefined' && dataRelatorio != null && dataRelatorio != '') {
                               
                        $.ajax({
                            type: 'POST',
                            url: 'recebe_gestaotitulos.php?tag=4ri',
                            data: {dataRelatorio:dataRelatorio},
                            
                            success: function(result) {
                                //console.log(result);
                                const data = new Date(dataRelatorio),
                                    
                                    dia  = data.getDate(data.setDate(data.getDate()+1)).toString().padStart(2, '0'), //setando +1 a data para obter a data correta inserida.
                                    mes  = (data.getMonth()+1).toString().padStart(2, '0'), //+1 pois no getMonth Janeiro começa com zero.
                                    ano  = data.getFullYear();
                                //console.log(data);
                            
                            
                                    var dlbtn = document.getElementById("dlbtn");
                                    var file = new Blob([result], {type: 'text/csv'});
                                    dlbtn.href = URL.createObjectURL(file);
                                    dlbtn.download = 'Relatorio'+dia+"_"+mes+"_"+ano+'.csv';
                                    //dlbtn.download = 'Relatorio'+dataRelatorio+'.csv';
                                    $( "#mine").click();
                                    
                                    //console.log(dia);
                                    swal('Relatório Gerado com Sucesso!', '', 'success');
                            },
                            
                                                        
                        });
                     
                    }else{
                        swal('Data não inserida!', '', 'error');
                    }
                });
                
                /** function exportarTabela(tipo_arquivo) {
                    let extensao = '';
                    if(tipo_arquivo){
                        extensao = '.csv';
                    }else{
                        extensao = '.pdf';
                    }
                    func_loading_show();
                    $.ajax({
                        url: 'ajax/exportar_extrato?tipo=' + tipo_arquivo,
                        type: 'post',
                        dataType: 'binary',
                        success: function (data) {
                            saveAs(data, 'Extrato_' + $.format.date(new Date(), "dd_MM_yyyy_HH_mm_ss") + extensao);
                        },
                    }).then(function () {
                        func_loading_hide();
                    });
                } */
                $('#valor_recebido').change(function () {
                    if (verificaValores(this.value)) {
                        $('#plano_contas_esconde').removeAttr('hidden');
                    } else {
                        $('#plano_contas_esconde').attr('hidden', 'hidden');
                    }
                    ;
                });
            });
            function verificaValores(dado) {
                var aux = dado;
                aux = aux.replace('.', '');
                aux = aux.replace(',', '.');
                var valor = parseFloat(aux);
                var valor_real = parseFloat($('#valor_real').val());
                var maximo = valor_real + (valor_real * 0.005);
                var minimo = valor_real - (valor_real * 0.005);
                if (valor <= minimo || valor >= maximo) {
                    return true;
                } else {
                    return false;
                }
            }
            function filtraData() {
                $('#tabela').DataTable().draw();
                $('#tabela2').DataTable().draw();
                $('#tabela3').DataTable().draw();
            }
            function mudaStatus(id, status) {
                $('#id_boleto').val(id);
                var fd = new FormData();
                fd.append('pagamento', status);
                fd.append('id_item', id);
                $.ajax({
                    url: 'recebe_gestaotitulos.php?tag=8ui',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response == '0') {
                            swal('Confirmação de Pagamento Retirada com Sucesso!', '', 'success');
                            $('#pago_' + $('#id_boleto').val()).attr('hidden', 'hidden');
                            $('#naopago_' + $('#id_boleto').val()).removeAttr('hidden', 'hidden');
                        } else if (response == '1') {
                            swal('Confirmação de Pagamento Realizada com Sucesso!', '', 'success');
                            $('#naopago_' + $('#id_boleto').val()).attr('hidden', 'hidden');
                            $('#pago_' + $('#id_boleto').val()).removeAttr('hidden', 'hidden');
                        } else {
                            swal('Título movido para recebidos!', '', 'success');
                            $('#tabela2').DataTable().row("#tr" + $('#id_boleto').val()).remove();
                            var dados = response.split(';;');
                            $('#tabela3').DataTable().row.add([dados[0], dados[1], dados[2], dados[3], dados[4], dados[5], dados[6], dados[7], dados[8], dados[9]]).draw().node().id = 'tr' + $('#id_boleto').val();
                            $('#tabela3').DataTable().draw();
                            $('#tabela2').DataTable().draw();
                        }
                    },
                });
            }
            function abreModal(id, modal, tabela = '') {
                $('#id_boleto').val(id);
                $('#plano_contas_esconde').attr('hidden', 'hidden');
                $('#plano_contas').val('');
                var aux = $('#tabela' + tabela).DataTable().row('#tr' + id).data();
                if (modal == '2') {
                    $('#valor_recebido').val(parseFloat(aux[6]).toLocaleString('pt-BR', {minimumFractionDigits: 2}));
                    $('#valor_real').val(aux[6]);
                    $('#data_pagamento').val(moment().format('YYYY-MM-DD'));
                    $('#valor_recebido').trigger('input');
                } else if (modal == '6') {
                    $('#valor_pago').val(parseFloat(aux[6]).toLocaleString('pt-BR', {minimumFractionDigits: 2}));
                } else if (modal == '5') {
                    $('#valor_gerado').val(parseFloat(aux[6]).toLocaleString('pt-BR', {minimumFractionDigits: 2}));
                }
                $('#modal' + modal).modal('show');
            }
            function excluiBoleto(id) {
                $.post('recebe_gestaotitulos.php?excluir=' + id);
                $("#inserir" + id).removeAttr('hidden');
                $("#gerar_" + id).removeAttr('hidden');
                $("#bol" + id).attr('hidden', 'hidden');
                $("#exclui" + id).attr('hidden', 'hidden');
            }
        </script>
        </body>
        </html>
    <?php }
} ?>        