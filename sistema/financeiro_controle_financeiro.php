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
    $sql_permissao = mysqli_query($con, "select listar from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
    $vetor_permissao = mysqli_fetch_array($sql_permissao);
    if ($vetor_permissao['listar'] != 2) {
        echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
    }
    $vetor_banco = mysqli_fetch_array(mysqli_query($con, "select ambiente, urlhomologacao, urlproducao from banco where id_banco = '1'"));
    if ($vetor_banco['ambiente'] == 1) {
        $urlbase = $vetor_banco['urlhomologacao'];
    }
    if ($vetor_banco['ambiente'] == 2) {
        $urlbase = $vetor_banco['urlproducao'];
    }
    if ($vetor_permissao['listar'] == 2) {

        if(isset($_GET['id_conta'])){
            $id_conta = $_GET['id_conta'];
            $sql = mysqli_query($con,"SELECT * FROM contas WHERE status = '1' and id_conta <> '{$id_conta}'");
            while($conta = mysqli_fetch_array($sql)){
                echo "<option value='".$conta['id_conta']."'>".strtoupper($conta['nome'])."</option>";
            }
            die();
        }

        if (isset($_GET['id_f'])) {
            $fornecedores = $_GET['id_f'];
            $sql = mysqli_query($con, "select cf.nome,cf.id_categoria,cc.numeracao,cc.id_catconta from categorias_contas cc
        left join categoriafornecedor cf on cf.id_categoria = cc.categoria_fornecedor
        left join fornecedor_categoria fc on fc.id_categoria = cf.id_categoria
        left join clientes c on c.id_cli = fc.id_fornecedor
        where c.id_cli = '$fornecedores'") or die (mysqli_error($con));
            $msg = '';
            if (mysqli_num_rows($sql) > 1) {
                $msg .= "<option value=''>Selecione a Categoria</option>";
            }
            while ($vetor = mysqli_fetch_array($sql)) {
                $msg .= "<option value='" . $vetor['id_categoria'] . ';' . $vetor['id_catconta'] . "'>" . $vetor['nome'] . "</option>";
            }
            echo $msg;
            die();
        }
        if (isset($_GET['tipo_pagamento'])) {
            $tipo_pagamento = $_GET['tipo_pagamento'];
            $sql = mysqli_query($con, "select * from tipos_pagamento where tipo='$tipo_pagamento' and status = 1 order by nome ASC");
            echo "<option value=''>Selecione o Tipo de Pagamento</option>";
            while ($vetor = mysqli_fetch_array($sql)) {
                echo "<option value='" . $vetor['id_tipo_pagamento'] . "'>" . $vetor['nome'] . "</option>";
            }
            die();
        }
        ?>
        <!DOCTYPE html>
        <html dir="ltr" lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
            <!-- Tell the browser to be responsive to screen width -->
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
            <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
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
            <link href="../layout/assets/extra-libs/horizontal-timeline/horizontal-timeline.css" rel="stylesheet">
            
            <link
      href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css"
      rel="stylesheet"
    />            
            <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <style>
                .gridjs-table{
                    width: 100% !important;
                }
                .gridjs-th-content{
                    white-space: pre;
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
                                        <li class="breadcrumb-item active" aria-current="page">Fluxo de Caixa</li>
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
                                    <div class="form-row">

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 "
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
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ch2"
                                                                role="tab"><span
                                                        class="hidden-xs-down">Cobrança</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ch3"
                                                                role="tab"><span
                                                        class="hidden-xs-down">Recebidos</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ch4"
                                                                role="tab"><span
                                                        class="hidden-xs-down">Contas a Pagar</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ch5"
                                                                role="tab"><span
                                                        class="hidden-xs-down">Movimento</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ch6"
                                                                role="tab"><span
                                                        class="hidden-xs-down">Fluxo Futuro</span></a>
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
                                                <div id="table-js-contas-a-receber"></div>
                                            </div>
                                            <input type="text" name="id_boleto" id="id_boleto2" hidden>
                                        </div>
                                        <input type="text" name="id_boleto" id="id_boleto2" hidden>
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
                                                                    $sql_fomento = mysqli_query($con, "select id_fomento, nome from fomentos where status = '1' order by nome");
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
                                                                $contas = mysqli_query($con, "select id_conta, nome from contas where status = '1'");
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
                                                                $tipo_pagamento = mysqli_query($con, "select id_tipo_pagamento, nome from tipos_pagamento where tipo = 'receita' and status = '1'");
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
                                                            <br>
                                                            <div>
                                                            <label class="form-label semibold"
                                                                   for="boleto_recompra">Novo Boleto</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="boleto_recompra" aria-describedby="inputGroupFileAddon01">
                                                                <label class="custom-file-label" for="boleto_recompra" id="label_boleto_recompra">Escolher arquivo</label>
                                                            </div>
                                                            </div>

                                                            <label class="form-label semibold mt-3"
                                                                   for="id_conta2">Conta de Destino</label>
                                                            <select class="form-control" name="id_conta2" id="id_conta2">
                                                            <?php
                                                                $contas = mysqli_query($con, "select id_conta, nome from contas where status = '1'");
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


                                        <!-- MODAIS MF -->
                                        <input type="text" id="id_lancamento" name="id_lancamento" hidden>
                                    <input type="text" id="id_movimentacao" name="id_movimentacao" hidden>
                                    <input type="text" id="valor_realMF" name="valor_real" hidden>

                                        <div>
                                        <div id="modal13" class="modal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Modificar Data</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label class="form-label semibold"
                                                               for="data">Nova Data</label>
                                                        <input class="form-control" type="date"
                                                               name="nova_data" id="nova_data"
                                                               required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id="modificarData"
                                                                style="position: absolute;left: 15px;"
                                                                class="btn btn-success">Alterar
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="modal12" class="modal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Valor</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="tipo_lancamento">Tipo de
                                                                        Lançamento</label>
                                                                    <select id="tipo_lancamento" name="tipo_lancamento"
                                                                            class="select2 form-control"
                                                                            style="width: 100%" required="">
                                                                        <option value="0" selected>Selecione um Tipo de
                                                                            Lançamento
                                                                        </option>
                                                                        <option value="receita">Receita</option>
                                                                        <option value="despesa">Despesa</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="id_fornecedor">Fornecedor</label>
                                                                    <select id="id_fornecedor" name="id_fornecedor"
                                                                            class="select2 form-control"
                                                                            style="width: 100%" required="">
                                                                        <option value="0" selected>Selecione um
                                                                            Fornecedor
                                                                        </option>
                                                                        <?php
                                                                        $sql = mysqli_query($con, "select c.nome,c.id_cli from clientes c order by c.nome");
                                                                        while ($vetor = mysqli_fetch_array($sql)) {
                                                                            echo "<option value='" . $vetor['id_cli'] . "'>" . ucwords(strtolower($vetor['nome'])) . "</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4" id="esconde_cat_fornecedor">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="id_cat_fornecedor">Categoria de
                                                                        Fornecedor</label>
                                                                    <select id="id_cat_fornecedor"
                                                                            name="id_cat_fornecedor"
                                                                            class="select2 form-control"
                                                                            style="width: 100%" required="">
                                                                        <option value="0" selected="">Selecione um
                                                                            Fornecedor
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="centro_custo">Centro de Custo</label>
                                                                    <select id="centro_custo" name="centro_custo"
                                                                            class="select2 form-control"
                                                                            style="width: 100%" required>
                                                                        <option value="0" selected="">Selecione um
                                                                            Centro
                                                                        </option>
                                                                        <?php
                                                                        $sql = mysqli_query($con, "select * from centro_custo where status='1' order by id_centro");
                                                                        while ($vetor = mysqli_fetch_array($sql)) {
                                                                            ?>
                                                                            <option value="<?php echo $vetor['id_centro']; ?>"><?php echo "0" . $vetor['id_centro'] . ' - ' . $vetor['nome']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="titulo">Titulo (Opcional)</label>
                                                                    <input id="titulo" name="titulo"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Tipo
                                                                        de Pagamento</label>
                                                                    <select id="tipo_pagamento" name="tipo_pagamento"
                                                                            class="select2 form-control"
                                                                            style="width: 100%" required>
                                                                        <option value="0" selected>Selecione um Tipo de
                                                                            Pagamento
                                                                        </option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Conta</label>
                                                                    <select class="select2 form-control"
                                                                            style="width: 100%" name="id_conta"
                                                                            id="id_conta">
                                                                        <option value="0" selected>Selecione um Conta
                                                                        </option>
                                                                        <?php
                                                                        $contas = mysqli_query($con, "select * from contas where status = '1'");
                                                                        while ($vetor_contas = mysqli_fetch_array($contas)) { ?>
                                                                            <option value="<?php echo $vetor_contas['id_conta']; ?>"><?php echo ucwords($vetor_contas['nome']); ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="selectTurma">Contrato (Opcional)</label>
                                                                    <select id="selectTurma" name="selectTurma"
                                                                            class="select2 form-control"
                                                                            style="width: 100%">
                                                                        <option value="0" selected="">Selecione um
                                                                            Contrato
                                                                        </option>
                                                                        <?php
                                                                        $sql = mysqli_query($con, "select t.id_turma,t.ncontrato,c.nome as cnome, t.ano, i.sigla from turmas t left join instituicoes i on i.id_instituicao = t.id_instituicao left join cursos c on c.id_curso = t.curso order by t.ncontrato ASC");
                                                                        while ($vetor = mysqli_fetch_array($sql)) {
                                                                            ?>
                                                                            <option value="<?php echo $vetor['id_turma']; ?>"><?php echo $vetor['ncontrato'] . ' - ' . $vetor['cnome'] . ' ' . $vetor['ano'] . ' ' . $vetor['sigla']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="data">Competencia</label>
                                                                    <input class="form-control" type="month"
                                                                           name="data_competencia" id="data_competencia"
                                                                           required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="data">Emissão</label>
                                                                    <input class="form-control" type="date"
                                                                           name="data_emissao" id="data_emissao"
                                                                           required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="data">Vencimento</label>
                                                                    <input class="form-control" type="date"
                                                                           name="data_vencimento" id="data_vencimento"
                                                                           required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="cadastroNovoLancamento">
                                                            <div class="col-lg-2 col-md-3 col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Parcelado?</label>
                                                                    <select name="parcelamento" id="parcelamento"
                                                                            class="form-control">
                                                                        <option value="1" selected="">Não</option>
                                                                        <option value="2">2x</option>
                                                                        <option value="3">3x</option>
                                                                        <option value="4">4x</option>
                                                                        <option value="5">5x</option>
                                                                        <option value="6">6x</option>
                                                                        <option value="7">7x</option>
                                                                        <option value="8">8x</option>
                                                                        <option value="9">9x</option>
                                                                        <option value="10">10x</option>
                                                                        <option value="11">11x</option>
                                                                        <option value="12">12x</option>
                                                                    </select>
                                                                    <br>
                                                                    <label class="form-label semibold"
                                                                           for="recorrencia">Recorrencia?</label>
                                                                    <input name="recorrencia" id="recorrencia"
                                                                           type="checkbox" class="form-check-inline">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="valor">Valor (R$)</label>
                                                                    <input id="valor" name="valor" class="form-control"
                                                                           required/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6" id="esconde_plano_contas" hidden>
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="selectTurma">Plano de Contas</label>
                                                                    <select id="plano_contas" name="plano_contas"
                                                                            class="select2 form-control"
                                                                            style="width: 100%">
                                                                        <option value="" selected="">Selecione uma
                                                                            Categoria
                                                                        </option>
                                                                        <?php
                                                                        $sql = mysqli_query($con, "select * from categorias_contas where cat_filha <> '0' and status = '1'");
                                                                        while ($vetor = mysqli_fetch_array($sql)) {
                                                                            ?>
                                                                            <option value="<?php echo $vetor['id_catconta']; ?>"><?php echo $vetor['numeracao'] . ' - ' . $vetor['titulo']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="data_baixa_esconde">
                                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="data">Data de Baixa</label>
                                                                    <input class="form-control" type="date"
                                                                           name="data_baixa" id="data_baixa"
                                                                           value="<?php echo date('Y-m-d'); ?>"
                                                                           required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="observacoes_esconde">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="observacoes">Observações</label>
                                                                    <textarea id="observacoes" name="observacoes"
                                                                              class="form-control"
                                                                              rows="2"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id="enviarValorMF"
                                                                style="position: absolute;left: 15px;"
                                                                class="btn btn-success">Dar Baixa
                                                        </button>
                                                        <button type="button" id="cadastrarENovo"
                                                                style="position: absolute;left: 15px;"
                                                                class="btn btn-success">Cadastrar e Novo
                                                        </button>
                                                        <button type="button" id="cadastrarNovo"
                                                                class="btn btn-success">Cadastrar
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="modal14" class="modal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Enviar Arquivo</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div>
                                                            <input class="custom-file-input" type="file"
                                                                   name="arquivo"
                                                                   id="arquivo">
                                                            <label class="custom-file-label" id="labelarquivo"
                                                                   for="arquivo">Escolha um
                                                                arquivo</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id="enviarArquivo"
                                                                class="btn btn-success" data-dismiss="modal">Salvar
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="modal15" class="modal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Realizar Transferência</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="conta_origem">Conta Origem</label>
                                                                    <select id="conta_origem" name="conta_origem"
                                                                            class="select2 select2modal5 form-control"
                                                                            style="width: 100%" required="">
                                                                        <option value="" selected>Selecione uma Conta
                                                                        </option>
                                                                        <?php $sql = mysqli_query($con,"SELECT * FROM contas WHERE status = '1'");
                                                                            while($conta = mysqli_fetch_array($sql)){ ?>
                                                                                <option value="<?php echo $conta['id_conta']; ?>"><?php echo strtoupper($conta['nome']); ?>
                                                                                </option>
                                                                        <?php
                                                                            }
                                                                            ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="conta_destino">Conta Destino</label>
                                                                    <select id="conta_destino" name="conta_destino"
                                                                            class="select2 select2modal5 form-control"
                                                                            style="width: 100%" required="">
                                                                        <option value="0" selected>Selecione uma Conta de Origem
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label class="form-label semibold"
                                                                   for="valor_transferencia">Valor (R$)</label>
                                                            <input id="valor_transferencia" name="valor" class="form-control"
                                                                   required/>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id="enviarTransferencia"
                                                                class="btn btn-success">Salvar
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                        <!--                                      COBRANÇA-->
                                        <div class="tab-pane" id="ch2" role="tabpanel">
                                            <br>
                                            <div class="table-responsive">
                                                <div id="table-js-cobrancas"></div>
                                            </div>
                                            
                                        </div>
                                        <!--                                      RECEBIDOS-->
                                        <div class="tab-pane" id="ch3" role="tabpanel">
                                            <br>
                                            <div class="table-responsive">
                                                <div id="table-js-recebidos"></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="ch4" role="tabpanel">
                                        <button type="button" onclick="abreModalMF('','12', this)"
                                                    class="btn waves-effect waves-light btn-warning my-4">
                                                <i class="fas fa-plus"></i> Lançamento
                                            </button>
                                            <div class="table-responsive">
                                                <div id="table-js-contas-a-pagar"></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="ch5" role="tabpanel">
                                            <br>
                                            <div class="table-responsive">
                                                <div class="form-check">
                                                    <input class="form-check-input mb-2" type="radio" name="flexRadioDefault"
                                                        id="flexRadioDefault1" onchange="updateConfigPesquisaGeral(this)" checked>
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Pesquisa Geral
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                        id="flexRadioDefault2" onchange="updateConfigPesquisaAvancada(this)">
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        Pesquisa Avançada
                                                    </label>
                                                </div>
                                                <div id="table-js-movimento"></div>

                                            </div>
                                        </div>
                                        <div class="tab-pane" id="ch6" role="tabpanel">
                                            <br>
                                            <div class="table-responsive">
                                                <div id="table-js-fluxo-futuro"></div>
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
    <!--chartjs -->
    <script src="../layout/dist/js/pages/dashboards/dashboard1.js"></script>
    <script src="../layout/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../layout/assets/libs/moment/min/moment.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../layout/assets/extra-libs/horizontal-timeline/horizontal-timeline.js"></script>
    <script src="../js/utils/reqs.js"></script>
        
        <script>

            
function preenchidos() {
                if ($('#tipo_lancamento').val() != '0' && $('#id_fornecedor').val() != '0' && $('#id_cat_fornecedor').val() != '0' && $('#centro_custo').val() != '0' && $('#tipo_pagamento').val() != '0' && $('#id_conta').val() != '0' && $('#data_competencia').val() != '' && $('#data_emissao').val() != '' && $('#data_vencimento').val() != '' && $('#valor').val() != '') {
                    return true;
                } else {
                    return false;
                }
            }


            fetch(`http://localhost/studiomfotografia/api/regua-cobranca/get-regua-cobranca`).then((response) => {
                    response.json().then((data) => {
                        reguaCobranca = data
                    })
                })

                document.querySelector("#table-js-cobrancas").querySelectorAll('[data-date]').forEach((item) => {
                    item.addEventListener("click", (e) => {
                    })
                })

$("#enviarArquivo").click(function () {

                    var fd = new FormData();
                    var files = $('#arquivo')[0].files[0];
                    fd.append('arquivo', files);
                    fd.append('id_lancamento', $('#id_lancamento').val());

                    $.ajax({
                        url: 'recebe_lancamento.php?arquivo=1',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            swal('Arquivo Enviado com Sucesso!', '', 'success');
                            $('#arquivo').val('');
                            $('#labelarquivo').html('Escolha um arquivo');

                            let td_pai = selected_tr_mf.children[8].children[0]

                            let id_lancamento_arq = document.querySelector('#id_lancamento').value

                            if(td_pai.children.length == 1){
                                td_pai.removeChild(td_pai.children[0]);

                                td_pai.innerHTML = 
                                `<a href="../sistema/arquivos/${id_lancamento_arq}${response}" 
                                target="_blank"
                                id="arq${id_lancamento_arq}${response}">
                                <button type="button" class="btn btn-warning"
                                title="Ver Arquivo">
                                <span style="pointer-event: none"><i class="fas fa-file-alt fa-lg"></i></span>
                                </button>
                                </a>
                                
                                <button id="exclui${id_lancamento_arq}"
                                type="button" class="btn btn-danger"
                                title="Excluir Arquivo"
                                onclick="excluirArquivo(${id_lancamento_arq}, this)" >
                                <span style="pointer-event: none"><i class="fas fa-times fa-lg"></i></span>
                                </button>`                               
                            
                            }else{

                                td_pai.removeChild(td_pai.children[1]);

                            }

                        },
                    });
                });

                $("#enviarValorMF").click(function () {
                    arrumarCampos($('#valor').val());
                    if (preenchidos()) {
                        if ((verificaValores($('#valor').val()) && $('#observacoes').val() != '' && $('#plano_contas').val() != '') || (!verificaValores($('#valor').val()))) {
                            var fd = new FormData();
                            fd.append('id_lancamento', $('#id_lancamento').val());
                            fd.append('tipo_lancamento', $('#tipo_lancamento').val());
                            fd.append('id_fornecedor', $('#id_fornecedor').val());
                            fd.append('id_cat_fornecedor', $('#id_cat_fornecedor').val());
                            fd.append('centro_custo', $('#centro_custo').val());
                            fd.append('titulo', $('#titulo').val());
                            fd.append('tipo_pagamento', $('#tipo_pagamento').val());
                            fd.append('id_conta', $('#id_conta').val());
                            fd.append('selectTurma', $('#selectTurma').val());
                            fd.append('data_competencia', $('#data_competencia').val());
                            fd.append('data_emissao', $('#data_emissao').val());
                            fd.append('data_vencimento', $('#data_vencimento').val());
                            fd.append('data_baixa', $('#data_baixa').val());
                            fd.append('valor', $('#valor').val());
                            fd.append('observacoes', $('#observacoes').val());
                            fd.append('plano_contas', $('#plano_contas').val());

                            $.ajax({
                                url: 'recebe_lancamento.php?baixar=1',
                                type: 'post',
                                data: fd,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    $('#modal12').modal('hide');
                                    swal('Movimentação Inserida com Sucesso!', '', 'success');
                                    var dados = response.split(';;');
                                    $('#tabela').DataTable().row.add({
                                        conta: dados[0],
                                        descricao: dados[1],
                                        valor: dados[2],
                                        data: dados[3],
                                        acao: dados[4],
                                        id_lancamento: dados[5],
                                        id_duplicata: ""
                                    }).draw().node().id = 'tr' + $('#id_lancamento').val();
                                    if (parseFloat(dados[2]) > 0) {

                                    } else {

                                    }
                                    var aux = $('#tr' + $('#id_lancamento').val()).children();
                                    $(aux[3]).attr('align', 'center');
                                    $(aux[4]).attr('align', 'center');
                                    $(aux[5]).attr('align', 'center');
                                    $(aux[6]).attr('hidden', 'hidden');
                                    $(aux[7]).attr('hidden', 'hidden');
                                },
                            });
                        } else {
                            swal('Você precisa inserir uma observação e uma categoria do plano de contas para justificar a diferença de valor.', '', 'warning');
                        }
                    } else {
                        swal('É preciso preencher todos os campos obrigatórios!', '', 'warning');
                    }
                });


            function abreRegua(e){
                
                let clickedTr = e.parentNode.parentNode.parentNode

                clickedTr.querySelectorAll("td").forEach((item) => {
                    item.style.cssText += "border-bottom:none"
                })

                let newTr = document.createElement("tr")

                let day = e.dataset.date
                let vencimento = e.dataset.vencimento

                newTr.innerHTML = ` <td class="td-regua-cobranca" id="regua-cobranca" colspan="10">
                                        <section class="cd-horizontal-timeline loaded">
                                            <div class="timeline">

                                                <div class="events-wrapper">
                                                    <div class="events" style="width: 1800px; transform: translateX(0px);">
                                                        <ol>

                                                        </ol>
                                                        <span class="filling-line" aria-hidden="true"></span>
                                                    </div>
                                                    <!-- .events -->
                                                </div>
                                                <!-- .events-wrapper -->
                                                <ul class="cd-timeline-navigation">
                                                    <li><a href="#0" style="margin-top: 20px" class="prev inactive">Prev</a></li>
                                                    <li><a href="#0" style="margin-top: 20px" class="next">Next</a></li>
                                                </ul>
                                                <!-- .cd-timeline-navigation -->
                                            </div>
                                        </section>
                                    </td>`
                                                 
                                clickedTr.after(newTr)

                                let ol = newTr.querySelector("ol")

                                let newLi;

                                const myDate = new Date(); 
                                myDate.addDays(vencimento, day).toLocaleDateString()

                                for (var i = 0; i < reguaCobranca.length; i++) {


                                    newLi = document.createElement("li")
                                    

                                    if(i != reguaCobranca.length -1){
                                        if (parseInt(day) > parseInt(reguaCobranca[i].dia) && parseInt(day) < reguaCobranca[i + 1].dia && parseInt(day) != parseInt(reguaCobranca[i + 1].dia)) {
                                            newLi.innerHTML = `<a class="selected" title="${reguaCobranca[i].nome_lembrete}" data-date="${reguaCobranca[i].dia}">${myDate.addDays(vencimento, parseInt(reguaCobranca[i].dia)).toLocaleDateString()}<br>${parseInt(reguaCobranca[i].dia)}</a>`
                                            ol.appendChild(newLi)
                                            continue

                                        }

                                        
                                    }
                                    
                                    if(parseInt(day) == parseInt(reguaCobranca[i].dia)){
                                        newLi.innerHTML = `<a class="selected" title="${reguaCobranca[i].nome_lembrete}" data-date="${parseInt(reguaCobranca[i].dia)}">${myDate.addDays(vencimento, parseInt(reguaCobranca[i].dia)).toLocaleDateString()}<br>${parseInt(reguaCobranca[i].dia)}</a>`
                                        ol.appendChild(newLi)
                                        continue
                                    }

                                    if(i != reguaCobranca.length - 1){    
                                        newLi.innerHTML = `<a title="${reguaCobranca[i].nome_lembrete}" data-date="${parseInt(reguaCobranca[i].dia)}">${myDate.addDays(vencimento, parseInt(reguaCobranca[i].dia)).toLocaleDateString()}<br>${parseInt(reguaCobranca[i].dia)}</a>`
                                        ol.appendChild(newLi)
                                    }
                                }
                               
                                
                                    let newLiReset = document.createElement("li")        
                                    newLiReset.innerHTML = `<a title="${reguaCobranca[reguaCobranca.length - 1].nome_lembrete}" ${parseInt(reguaCobranca[reguaCobranca.length - 1].dia) <= parseInt(day) ? "class='selected'": ''} data-date="${reguaCobranca[reguaCobranca.length - 1].dia}">${myDate.addDays(vencimento, parseInt(reguaCobranca[reguaCobranca.length - 1].dia)).toLocaleDateString()}<br>${parseInt(reguaCobranca[reguaCobranca.length - 1].dia)}</a>`
                                    ol.appendChild(newLiReset)
                                         

                                    e.parentNode.innerHTML = `<i class="fas fa-minus-circle" onclick="fechaRegua(this)" style="cursor: pointer;" data-date="${day}" data-vencimento="${vencimento}"></i>`
            
                                    callInitTimeLine()

                                    
                                }

                                function callInitTimeLine() {
                                    initTimeline(document.querySelectorAll(".timeline"))
                                }

                                Date.prototype.addDays = function(dataVencimento, noOfDays){
                                    var tmpDate = new Date(`${dataVencimento}`);
                                    tmpDate.setDate(tmpDate.getDate() + noOfDays + 1);
                                    return tmpDate;
                                }

                                
                                                                

            function fechaRegua(e){
                let clickedTr = e.parentNode.parentNode.parentNode

                clickedTr.nextSibling.remove()

                e.parentNode.innerHTML = `<i onclick="abreRegua(this)" style="cursor: pointer;" class="fas fa-minus-circle fa-plus-circle" data-date="${e.dataset.date}" data-vencimento="${e.dataset.vencimento}"></i>`
            }


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
                        dropdownParent: $('#modal12'),
                        width: 'resolve'
                    });
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
                    fd.append('id_boleto', $('#id_boleto2').val());
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
                            $("#bol" + $('#id_boleto2').val()).attr('href', '../sistema/arquivos/' + response);
                            $("#inserir" + $('#id_boleto2').val()).attr('hidden', 'hidden');
                            $("#bol" + $('#id_boleto2').val()).removeAttr('hidden');
                            $("#exclui" + $('#id_boleto2').val()).removeAttr('hidden');
                        },
                    });
                });
                $("#resgatarTitulo").click(function () {

                    $.post('recebe_gestaotitulos.php?excluir=' + $('#id_boleto2').val());

                    var fd = new FormData();
                    var files = document.querySelector("#boleto_recompra").files[0];
                    fd.append('boleto', files);
                    fd.append('id_boleto', $('#id_boleto2').val());
                    $.ajax({
                        url: 'recebe_gestaotitulos.php?tag=5jy',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            swal('Boleto Enviado com Sucesso!', '', 'success');
                            $('#boleto_recompra').val('');
                            $('#label_boleto_recompra').html('Escolher arquivo');
                            $("#bol" + $('#id_boleto2').val()).attr('href', '../sistema/arquivos/' + response);
                            $("#inserir" + $('#id_boleto2').val()).attr('hidden', 'hidden');
                            document.querySelector("#resgatar_" + document.querySelector("#id_boleto2").value).attr('hidden', 'hidden');
                            $("#bol" + $('#id_boleto2').val()).removeAttr('hidden');
                            $("#exclui" + $('#id_boleto2').val()).removeAttr('hidden');
                        },
                    });

                    var fd = new FormData();
                    fd.append('valor_pago', $('#valor_pago').val());
                    fd.append('id_conta', $('#id_conta2').val());
                    $.ajax({
                        url: 'recebe_gestaotitulos.php?resgatar=' + $('#id_boleto2').val(),
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            swal("Recompra de Título Efetuada com Sucesso!", '', 'success');
                        }
                    });

                });
                $("#enviarFomento").click(function () {
                    var fd = new FormData();
                    fd.append('id_boleto', $('#id_boleto2').val());
                    fd.append('fomento', $('#fomento').val());
                    
                    $.ajax({
                        url: 'recebe_gestaotitulos.php?tag=4y3',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            swal('Fomento Inserido com Sucesso!', '', 'success');
                            aux[5].innerHTML = `<span style="pointer-event: none";>  ${response} </span>`
                            $("#status_" + $('#id_boleto2').val()).html('Antecipado');
                            $("#gerar_" + $('#id_boleto2').val()).attr('hidden', 'hidden');
                        },
                    });
                });
                $("#enviarValor").click(function () {


                    if ((verificaValores($('#valor_recebido').val()) && $('#plano_contas').val() != '') || (!verificaValores($('#valor_recebido').val()))) {
                        var fd = new FormData();
                        fd.append('id_boleto', $('#id_boleto2').val());
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
                                selected_tr.remove()
                            }
                        });
                    } else {
                        swal('Você precisa inserir uma categoria do plano de contas para justificar a diferença de valor.', '', 'warning');
                    }
                });

                $("#gerarBoleto").click(function () {
                    var fd = new FormData();
                    fd.append('id_boleto', $('#id_boleto2').val());
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
                            $("#inserir" + $('#id_boleto2').val()).attr('hidden', 'hidden');
                            $("#bol" + $('#id_boleto2').val()).removeAttr('hidden');
                            $("#bol" + $('#id_boleto2').val()).attr('href', response);
                            $("#fomento_" + $('#id_boleto2').val()).html('GetNet');
                        },
                    });
                });
                
                //exportar csv ajax
                $("#exportarcsv").click(function(){                   
                    var dataRelatorio = document.getElementById("dataRelatorio").value;
                    if (typeof(dataRelatorio) != 'undefined' && dataRelatorio != null && dataRelatorio != '') {
                               
                        $.ajax({
                            type: 'POST',
                            url: 'recebe_gestaotitulos.php?tag=4ri',
                            data: {dataRelatorio:dataRelatorio},
                            
                            success: function(result) {
                                const data = new Date(dataRelatorio),
                                    
                                    dia  = data.getDate(data.setDate(data.getDate()+1)).toString().padStart(2, '0'), //setando +1 a data para obter a data correta inserida.
                                    mes  = (data.getMonth()+1).toString().padStart(2, '0'), //+1 pois no getMonth Janeiro começa com zero.
                                    ano  = data.getFullYear();
                            
                            
                                    var dlbtn = document.getElementById("dlbtn");
                                    var file = new Blob([result], {type: 'text/csv'});
                                    dlbtn.href = URL.createObjectURL(file);
                                    dlbtn.download = 'Relatorio'+dia+"_"+mes+"_"+ano+'.csv';
                                    //dlbtn.download = 'Relatorio'+dataRelatorio+'.csv';
                                    $( "#mine").click();
                                    
                                    swal('Relatório Gerado com Sucesso!', '', 'success');
                            },
                            
                                                        
                        });
                     
                    }else{
                        swal('Data não inserida!', '', 'error');
                    }
                });
                
                $("#cadastrarNovo").click(function () {
                    if (preenchidos()) {
                        var fd = new FormData();
                        fd.append('id_lancamento', $('#id_lancamento').val());
                        fd.append('tipo_lancamento', $('#tipo_lancamento').val());
                        fd.append('id_fornecedor', $('#id_fornecedor').val());
                        fd.append('id_cat_fornecedor', $('#id_cat_fornecedor').val());
                        fd.append('centro_custo', $('#centro_custo').val());
                        fd.append('titulo', $('#titulo').val());
                        fd.append('parcelamento', $('#parcelamento').val());
                        fd.append('recorrencia', $('#recorrencia').val());
                        fd.append('tipo_pagamento', $('#tipo_pagamento').val());
                        fd.append('id_conta', $('#id_conta').val());
                        fd.append('turma', $('#selectTurma').val());
                        fd.append('data_competencia', $('#data_competencia').val());
                        fd.append('data_emissao', $('#data_emissao').val());
                        fd.append('data_vencimento', $('#data_vencimento').val());
                        fd.append('valor', $('#valor').val());

                        $.ajax({
                            url: 'recebe_lancamento.php?novo=0',
                            type: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                $('#modal12').modal('hide');
                                swal('Lançamento Efetuado com Sucesso!', '', 'success');
                                var rows = response.split(';new;');
                                rows.forEach(function (rowsAux) {
                                    var dados = rowsAux.split(';');
                                    $('#tabela2').DataTable().row.add([dados[0], dados[1], dados[2], dados[3], dados[4], dados[5]]).draw().node().id = 'tr' + dados[6];
                                    if (parseFloat(dados[4]) > 0) {
                                        $('#tr' + dados[6]).addClass('table-success');
                                    } else {
                                        $('#tr' + dados[6]).addClass('table-danger');
                                    }
                                    var aux = $('#tr' + dados[6]).children();
                                    aux.each(function () {
                                        $(this).attr('align', 'center');
                                    });
                                })
                                $('#tabela2').DataTable().draw();
                            },
                        });
                    } else {
                        swal('É preciso preencher todos os campos obrigatórios!', '', 'warning');
                    }
                });
                
                $('#cadastrarENovo').click(function () {
                    $('#cadastrarNovo').trigger('click');
                    setTimeout(function () {
                        if (preenchidos()) {
                            abreModal('', 2)
                        }
                    }, 1000);
                });


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
                
                dado = dado.replace('.', '');
                dado = dado.replace(',', '.');
                var valor = parseFloat(dado);
                var valor_real = parseFloat($('#valor_real').val());
                var maximo = valor_real + (valor_real * 0.005);
                var minimo = valor_real - (valor_real * 0.005);
                if (valor <= minimo || valor >= maximo) {
                    return true;
                } else {
                    return false;
                }
            }

            function mudaStatus(id, pagamento, status, recebidos, e) {

                swal({
                    title: "Deseja alterar o status do título?",
                    icon: "info",
                    buttons: true,
                    buttons: ["Cancelar", "Sim"],
                    })
                    .then((willChange) => {
                    if (willChange) {

                        $('#id_boleto2').val(id);
                        var fd = new FormData();
                        fd.append('pagamento', pagamento);
                        fd.append('id_item', id);
                        fd.append('status', status);
                        fd.append('recebidos',recebidos);
                        $.ajax({
                            url: 'recebe_gestaotitulos.php?tag=8ui',
                            type: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                if (response == '0') {
                                    swal('Confirmação de Pagamento Retirada com Sucesso!', '', 'success');
                                    
                                    $('#pago_' + $('#id_boleto2').val()).attr('hidden', 'hidden');
                                    $('#naopago_' + $('#id_boleto2').val()).removeAttr('hidden', 'hidden');

                                    
                                } else if (response == '1') {
                                    swal('Confirmação de Pagamento Realizada com Sucesso!', '', 'success');
                                    $('#naopago_' + $('#id_boleto2').val()).attr('hidden', 'hidden');
                                    $('#pago_' + $('#id_boleto2').val()).removeAttr('hidden', 'hidden');
                                } else {
                                        swal('Título movido para recebidos!', '', 'success');
                                        
                                        e.parentNode.parentNode.parentNode.remove();

                                }
                            },
                });

                    }
                    });

            }
            function abreModal(id, modal, tabela = '', e) {
                $('#id_boleto2').val(id);
                $('#plano_contas_esconde').attr('hidden', 'hidden');
                $('#plano_contas').val('');
                
                selected_tr = e.parentNode.parentNode.parentNode

                aux = e.parentNode.parentNode.parentNode.children

                aux['valor'] = selected_tr.querySelector("[data-column-id='valor']")
                
                
                if (modal == '2') {
                    $('#valor_recebido').val(aux['valor'].innerHTML.replace('R$ ', ''));
                    $('#valor_real').val(aux['valor'].innerHTML.replace('R$ ', ''));
                    $('#data_pagamento').val(moment().format('YYYY-MM-DD'));
                    $('#valor_recebido').trigger('input');
                } else if (modal == '6') {
                    $('#valor_pago').val(aux['valor'].innerHTML.replace('R$ ', ''));
                } else if (modal == '5') {
                    $('#valor_gerado').val(aux['valor'].innerHTML.replace('R$ ', ''));
                }
                $('#modal' + modal).modal('show');
            }

            function abreModalMF(id, modal, e) {

                selected_tr_mf = e.parentNode.parentNode.parentNode

                $('#id_lancamento').val(id);
                $('#esconde_plano_contas').attr('hidden', 'hidden');
                $('#plano_contas').val('');
                

                if (modal == '12' && id != '') {
                    $('#alterarCadastro').removeAttr('hidden');
                    $('#enviarValor').removeAttr('hidden');
                    $('#data_baixa_esconde').removeAttr('hidden');
                    $('#observacoes_esconde').removeAttr('hidden');
                    $('#cadastrarNovo').attr('hidden', 'hidden');
                    $('#cadastrarENovo').attr('hidden', 'hidden');
                    $('#cadastroNovoLancamento').attr('hidden', 'hidden');
                    var fd = new FormData();
                    fd.append('editar', id);
                    $.ajax({
                        url: 'recebe_movimentacao.php',
                        type: 'post',
                        data: fd,
                        asynx: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            var aux = response.split('|');

                            
                            $('#tipo_lancamento').val(aux[0]);
                            $('#tipo_lancamento').trigger("change");
                            $('#id_fornecedor').val(aux[1])
                            $('#id_fornecedor').trigger("change");
                            $('#id_cat_fornecedor').val(aux[2]);
                            $('#id_cat_fornecedor').trigger("change");
                            $('#centro_custo').val(aux[3]);
                            $('#centro_custo').trigger("change");
                            $('#titulo').val(aux[4]);
                            $('#tipo_pagamento').val(aux[5]);
                            $('#tipo_pagamento').trigger("change");
                            $('#id_conta').val(aux[6]);
                            $('#id_conta').trigger("change");
                            $('#selectTurma').val(aux[7]);
                            $('#selectTurma').trigger("change");
                            $('#data_competencia').val(aux[8]);
                            $('#data_emissao').val(aux[9]);
                            $('#data_vencimento').val(aux[10]);
                            $('#valor').val(aux[11]);
                            $('#valor_realMF').val(aux[11]);
                        },
                    });
                } else if (modal == '12') {
                    $('#cadastrarNovo').removeAttr('hidden');
                    $('#cadastrarENovo').removeAttr('hidden');
                    $('#cadastroNovoLancamento').removeAttr('hidden');
                    $('#enviarValor').attr('hidden', 'hidden');
                    $('#alterarCadastro').attr('hidden', 'hidden');
                    $('#data_baixa_esconde').attr('hidden', 'hidden');
                    $('#observacoes_esconde').attr('hidden', 'hidden');
                    $('#tipo_lancamento').val('0');
                    $('#tipo_lancamento').trigger("change");
                    $('#id_fornecedor').val('0');
                    $('#id_fornecedor').trigger("change");
                    $('#id_cat_fornecedor').val('0');
                    $('#id_cat_fornecedor').trigger("change");
                    $('#centro_custo').val('0');
                    $('#centro_custo').trigger("change");
                    $('#titulo').val('');
                    $('#tipo_pagamento').val('0');
                    $('#tipo_pagamento').trigger("change");
                    $('#id_conta').val('0');
                    $('#id_conta').trigger("change");
                    $('#selectTurma').val('0');
                    $('#selectTurma').trigger("change");
                    $('#data_competencia').val('');
                    $('#data_emissao').val('');
                    $('#data_vencimento').val('');
                    $('#valor').val('');
                    $('#valor_real').val('');
                    $('#parcelamento').val('1');
                } else if (modal == '13') {
                    $('#id_movimentacao').val(id);
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

            function excluirArquivo(id, e) {
                e.parentNode.innerHTML = `<button id="inserir${id}
                type="button" class="btn btn-success"
                title="Inserir Arquivo"
                onclick="abreModalMF(${id},'14', this)">
                <span><i class="fas fa-cloud-upload-alt fa-md"></i></span>
                </button>`
                $("#arq" + id).attr('hidden', 'hidden');
                $("#exclui" + id).attr('hidden', 'hidden');
                return
                $.post('recebe_lancamento.php?excluir=' + id);
                
                

            }

            function arrumarCampos(dado) {
                if (verificaValores(dado)) {
                    $('#esconde_plano_contas').removeAttr('hidden');
                } else {
                    $('#plano_contas').val('');
                    $('#esconde_plano_contas').attr('hidden', 'hidden');
                }
            }

            function desativarLancamento(id, e) {

                swal({
                    title: "Você tem certeza que deseja excluir este lançamento?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.post('recebe_lancamento.php?desativar=' + id, function () {
                                swal('Lançamento Excluído com Sucesso!', '', 'success');
                            });
                         
                            e.parentNode.parentNode.parentNode.remove();

                        }
                    });
            }

        </script>








        <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
        <script>


drawContasReceberTable()
drawRecebidosTable()
drawCobrancasTable()
drawContasAPagarTable()
drawFluxoFuturo()
 
function drawContasReceberTable() {
//contas a receber
new gridjs.Grid({

language: {
    search: {
      placeholder: 'Procurar...'
    },
    pagination: {
      previous: 'Anterior',
      next: 'Próximo',
      navigate: (page, pages) => `Página ${page} de ${pages}`,
      page: (page) => `Página ${page}`,
      showing: 'Mostrando ',
      of: 'entre',
      to: 'a',
      results: 'resultados',
    },
    loading: 'Carrregando...',
        noRecordsFound: 'Nenhum registro encontrado',
    error: 'Erro ao conectar a base de dados',
  },

  style: {

    th: {
      'text-align': 'center'
    },
    td: {
      'text-align': 'center'
    }
  },

columns: ['Cód. Cliente', 'Serviço', 'Forma Pagamento', 'Parcela', 'Vencimento', 'Fomento', 'Valor', 'Status', 'Ações'],
pagination: {
enabled: true,
limit: 10,
server: {
  url: (prev, page, limit) => `${prev}&limit=${limit}&offset=${page * limit}`
}
},
search: {
server: {
  url: (prev, keyword) => `${prev}?&search=${keyword}&`
}
},
sort: {
multiColumn: false,
server: {
  url: (prev, columns) => {
   if (!columns.length) return prev;

   const col = columns[0];
   const dir = col.direction === 1 ? 'asc' : 'desc';
   let colName = ['id', 'descricao_tipo_venda', 'fpnome', 'parcela_atual', 'df.data', 'fonome', 'df.valor', 'fonome', 'id'][col.index];
   
   return `${prev}&order=${colName}&dir=${dir}`;
 }
}
},

server: {
url: 'http://localhost/studiomfotografia/api/titulos/get-contas-a-receber',
then: data => data.results.map(titulos => [
  gridjs.html(`<span title="${titulos.fnome}"> ${titulos.id} </span>`),
  titulos.descricao_tipo_venda, titulos.fpnome, titulos.parcela_atual, 
  titulos.vencimento, gridjs.html(
      `<button
                                                                      type=\"button\" class=\"btn btn-info\"
                                                                      title=\"Inserir Fomento\"
                                                                      onclick=\"abreModal(${titulos.id_item},'', '', this)\">
                                                              <span style="pointer-event: none";">${titulos.fonome ? titulos.fonome : `<i class=\"fas fa-money-bill-alt fa-lg\">`}</i></span>
                                                              </button>`),
   "R$ "+ titulos.valor_formatado, 
   gridjs.html(`<span id="status_${titulos.id_item}"> ${(() => {
                                                                
                                                                if(titulos.recomprado == 1){
                                                                    return 'Recompra' 
                                                                }

                                                                switch(titulos.status) {
                                                                case '1':
                                                                    if(titulos.id_fomento != null) {
                                                                        return `Antecipado`;
                                                                    }else{
                                                                        return `Em Aberto`;
                                                                    }
                                                                
                                                                case '4':
                                                                    return 'Negado';
                                                                break
                                                                 }
                                                                })()} </span>`),
   gridjs.html(`<button ${titulos.recomprado == 1 ? "hidden" : ""} type="button" class="btn btn-info btn-md"
                                                                        title="Inserir Valor Recebido"
                                                                        onclick="abreModal(${titulos.id_item}, '2',  '', this)"
                                                                        id="valorrecebido_${titulos.id_item}">
                                                                    <span style="pointer-event: none";><i class="fas fa-hand-holding-usd fa-lg"></i></span>
                                                                </button>
                                                                <button id="gerar_${titulos.id_item}"
                                                                        type="button"
                                                                        class="btn btn-secondary" ${titulos.arquivo != null ? `hidden` : ``}
                                                                        title="Gerar Boleto Santander"
                                                                        onclick="abreModal(${titulos.id_item},'5', '', this)">
                                                                    <span style="pointer-event: none";><i class="fas fa-history fa-lg"></i></span>
                                                                </button>
                                                                <button id="inserir${titulos.id_item}"
                                                                        type="button" class="btn btn-success"
                                                                        title="Inserir Boleto"
                                                                        onclick="abreModal(${titulos.id_item},'4', '', this)" ${(() => { if ((titulos.arquivo != null && titulos.boleto != null)){ return `hidden` } })()} >
                                                                    <span style="pointer-event: none";><i class="fas fa-cloud-upload-alt fa-md"></i></span>
                                                                </button>
                                                                <a href=" ${(()=> { if(titulos.arquivo != null) { return `arquivos/${titulos.arquivo}` } else if(titulos.link); { return `https://api-homologacao.getnet.com.br${titulos.link}`} })()} " target="_blank"
                                                                   id="bol${titulos.id_item}" ${(() => { if(titulos.arquivo == null && titulos.link == null){ return `hidden` } } )()} >
                                                                    <button type="button" class="btn btn-warning"
                                                                            title="Ver Boleto">
                                                                        <span style="pointer-event: none";><i class="fas fa-file-alt fa-lg"></i></span>
                                                                    </button>
                                                                </a>
                                                                <button id="exclui${titulos.id_item}"
                                                                        type="button" class="btn btn-danger"
                                                                        title="Excluir Boleto"
                                                                        onclick="excluiBoleto(${titulos.id_item})" ${(() => { if(titulos.arquivo == '' && titulos.arquivo != null) { return `hidden` } })()} >
                                                                    <span style="pointer-event: none";><i class="fas fa-times fa-lg"></i></span>
                                                                </button>
                                                                `)
]),
total: data => data.count
} 
}).render(document.getElementById("table-js-contas-a-receber"));

}

function drawCobrancasTable() {

//cobranças
new gridjs.Grid({

language: {
    search: {
      placeholder: 'Procurar...'
    },
    pagination: {
      previous: 'Anterior',
      next: 'Próximo',
      navigate: (page, pages) => `Página ${page} de ${pages}`,
      page: (page) => `Página ${page}`,
      showing: 'Mostrando ',
      of: 'entre',
      to: 'a',
      results: 'resultados',
    },
    loading: 'Carrregando...',
        noRecordsFound: 'Nenhum registro encontrado',
    error: 'Erro ao conectar a base de dados',
  },

  style: {

    th: {
      'text-align': 'center'
    },
    td: {
      'text-align': 'center'
    }
  },

columns: ['Régua', 'Cód. Cliente', 'Nome', 'Serviço', 'Parcela', 'Vencimento', 'Fomento', 'Valor', 'Pago', 'Ações'],
pagination: {
enabled: true,
limit: 10,
server: {
  url: (prev, page, limit) => `${prev}&limit=${limit}&offset=${page * limit}`
}
},
search: {
server: {
  url: (prev, keyword) => `${prev}&search=${keyword}&`
}
},
sort: {
multiColumn: false,
server: {
  url: (prev, columns) => {

   if (!columns.length) return prev;
   
   const col = columns[0];
   const dir = col.direction === 1 ? 'asc' : 'desc';
   let colName = ['id', 'id', 'fnome',  'descricao_tipo_venda', 'parcela_atual', 'df.data', 'fonome', 'df.valor', 'status', 'df.pagamento'][col.index];
   
   return `${prev}&order=${colName}&dir=${dir}`;
 }
}
},


server: {
url: 'http://localhost/studiomfotografia/api/titulos/get-cobrancas',
then: data => data.results.map(titulos => [
    gridjs.html(`<i onclick="abreRegua(this)" style="cursor: pointer;" class="fas fa-minus-circle fa-plus-circle" data-date="${titulos.datedif}" data-vencimento="${titulos.data}"></i>`),
  titulos.id, titulos.fnome, titulos.descricao_tipo_venda, titulos.parcela_atual, 
  titulos.vencimento, gridjs.html(
        `${(() => { 
            if(titulos.id_fomento == null && titulos.link == null) {
                return `<button
                                                                      type=\"button\" class=\"btn btn-info\"
                                                                      title=\"Inserir Fomento\"
                                                                      onclick=\"abreModal(${titulos.id_item},'','2', this)\">
                                                              <span style="pointer-event: none"><i class=\"fas fa-money-bill-alt fa-lg\"></i></span>
                                                              </button>`
            }else{
                if(titulos.id_fomento == null){
                    return `<span style="pointer-event: none"> GetNet </span>`;
                }else{
                    return `<button
                                                                      type=\"button\" class=\"btn btn-info\"
                                                                      title=\"Inserir Fomento\"
                                                                      onclick=\"abreModal(${titulos.id_item},'','2', this)\">
                                                              <span style="pointer-event: none">${titulos.fonome}</span>
                                                              </button>`
                }
            }
        }) ()}`  
    ),
   "R$ "+ titulos.valor_formatado, 

gridjs.html(`                       <button id="pago_${titulos.id_item}"
                                                                        class="btn btn-success" ${titulos.pagamento != 1 ? 'hidden' : ''}
                                                                        onclick="mudaStatus(${titulos.id_item},'0','1', null, this)">SIM 
                                                                </button>
                                                                
                                                                <button id="naopago_${titulos.id_item}"
                                                                        class="btn btn-danger" ${titulos.pagamento == 1 ? 'hidden' : ''}
                                                                        onclick="mudaStatus(${titulos.id_item},'1','2', null, this)"> NÃO 
                                                                </button>`),

gridjs.html(`                                                               <button id="gerar_${titulos.id_item}"
                                                                        type="button"
                                                                        class="btn btn-secondary" ${titulos.arquivo != null ? 'hidden' : ''} 
                                                                        title="Gerar Boleto Santander"
                                                                        onclick="abreModal(${titulos.id_item},'5','2', this)">
                                                                        
                                                                    <span style="pointer-event: none"><i class="fas fa-history fa-lg"></i></span>
                                                                    </button> 
                                                                    <a href="interacoes_cobranca.php?id=${titulos.id_item}"
                                                                       target="_blank"
                                                                       id="interacoes_${titulos.id_item}">
                                                                        <button type="button" class="btn btn-primary"
                                                                                title="Visualizar Interações">
                                                                            <span style="pointer-event: none"><i class="fas fa-eye fa-md"></i></span>
                                                                        </button>
                                                                    </a>

                                                                   <button type="button" class="btn btn-success"
                                                                        title="Inserir Boleto"
                                                                        id="inserir${titulos.id_item}"
                                                                        onclick="abreModal(${titulos.id_item},'4','2', this)" ${(() => { if(!(titulos.arquivo == null && titulos.boleto == null)) { return 'hidden' } })()}>
                                                                    <span style="pointer-event: none"><i class="fas fa-cloud-upload-alt fa-md"></i></span>
                                                                </button>
                                                                <a href="${ (() => { if(titulos.arquivo != null) {

                                                                    return `arquivos/${titulos.arquivo}`
                                                                    
                                                                }else if(titulos.link != null) {

                                                                    return  `https://api-homologacao.getnet.com.br${titulos.link}`;

                                                                }
                                                                
                                                                } )() }" target="_blank"
                                                                   id="bol${titulos.id_item}" ${ (() => { if(titulos.arquivo == null && titulos.link == null) {
                                                                    return 'hidden';
                                                                   } })() }>
                                                                    <button type="button" class="btn btn-warning"
                                                                            title="Ver Boleto">
                                                                        <span style="pointer-event: none"><i class="fas fa-file-alt fa-lg"></i></span>
                                                                    </button>
                                                                </a>
                                                                <button id="exclui${titulos.id_item}"
                                                                        type="button" class="btn btn-danger"
                                                                        title="Excluir Boleto"
                                                                        onclick="excluiBoleto(${titulos.id_item})" ${ (() => { if(titulos.arquivo == '' && titulos.arquivo == null) { 'hidden' } })()}>
                                                                    <span style="pointer-event: none"><i class="fas fa-times fa-lg"></i></span>
                                                                </button>

                                                                
                                                                    
                                                                     <button type="button" ${titulos.recomprado == 1 ? "hidden" : ""} class="btn btn-danger"
                                                                        title="Recomprar Título"
                                                                        onclick="abreModal(${titulos.id_item},'6','2', this)"
                                                                        id="resgatar_${titulos.id_item}" ${titulos.status == 1 ? '' : ''}>
                                                                    <span style="pointer-event: none"><i class="fas fa-history fa-lg"></i></span></button>
                                                                    
                                                                
                                                                `),
]),
total: data => {

    document.querySelectorAll("#regua-cobranca").forEach((regua) => {
        regua.parentNode.remove()
    })

    return data.count

} 
} 
}).render(document.getElementById("table-js-cobrancas"));

}

function drawRecebidosTable() {

//recebidos
new gridjs.Grid({

language: {
    search: {
      placeholder: 'Procurar...'
    },
    pagination: {
      previous: 'Anterior',
      next: 'Próximo',
      navigate: (page, pages) => `Página ${page} de ${pages}`,
      page: (page) => `Página ${page}`,
      showing: 'Mostrando ',
      of: 'entre',
      to: 'a',
      results: 'resultados',
    },
    loading: 'Carrregando...',
        noRecordsFound: 'Nenhum registro encontrado',
    error: 'Erro ao conectar a base de dados',
  },

  style: {

    th: {
      'text-align': 'center'
    },
    td: {
      'text-align': 'center'
    }
  },

columns: ['Cód. Cliente', 'Nome', 'Serviço', 'Conta', 'Forma Pagamento', 'Parcela', 'Vencimento', 'Fomento', 'Valor do Título', 'Valor Recebido', 'Status', 'Pago', 'Ações'],
pagination: {
enabled: true,
limit: 10,
server: {
  url: (prev, page, limit) => `${prev}&limit=${limit}&offset=${page * limit}`
}
},
search: {
server: {
  url: (prev, keyword) => `${prev}&search=${keyword}&`
}
},
sort: {
multiColumn: false,
server: {
  url: (prev, columns) => {
   if (!columns.length) return prev;
   
   const col = columns[0];
   const dir = col.direction === 1 ? 'asc' : 'desc';
   let colName = ['id', 'fnome',  'descricao_tipo_venda', 'conta_destino', 'fp.nome', 'parcela_atual', 'df.data', 'fonome', 'df.valor', 'df.valor_recebido', 'fonome', 'df.pagamento'][col.index];
   
   return `${prev}&order=${colName}&dir=${dir}`;
 }
}
},

server: {
url: 'http://localhost/studiomfotografia/api/titulos/get-recebidos',
then: data => data.results.map(titulos => [
  titulos.id, titulos.fnome, titulos.descricao_tipo_venda, titulos.conta_destino,titulos.fpnome, titulos.parcela_atual, 
  titulos.vencimento, gridjs.html(
        `${(() => { 
            if(titulos.id_fomento == null && titulos.link == null && titulos.formapag != 3) {
                return `<button
                                                                      type=\"button\" class=\"btn btn-info\"
                                                                      title=\"Inserir Fomento\"
                                                                      onclick=\"abreModal(${titulos.id_item},'','3', this)\">
                                                              <span style="pointer-event: none"><i class=\"fas fa-money-bill-alt fa-lg\"></i></span>
                                                              </button>`
            }else{
                if(titulos.id_fomento == null || titulos.formapag == 3){
                    return `<span style="pointer-event: none"> GetNet </span>`;
                }else{
                   return `<button
                                                                      type=\"button\" class=\"btn btn-info\"
                                                                      title=\"Inserir Fomento\"
                                                                      onclick=\"abreModal(${titulos.id_item},'','3', this)\">
                                                              <span style="pointer-event: none">${titulos.fonome}</span>
                                                              </button>`
                }
            }
        }) ()}`  
    ),
   "R$ "+ titulos.valor_formatado,
   `R$ ${titulos.valor_recebido_formatado ? titulos.valor_recebido_formatado : '0,00'}`,
   gridjs.html(`<span style="pointer-event: none" id="status_${titulos.id_item}"> ${(() => {
                                                                if(titulos.cobranca == 1) {
                                                                    return 'Cobrança'
                                                                }else if(titulos.id_fomento != null) {
                                                                    return 'Antecipação'
                                                                }else if(titulos.link != null) {
                                                                    return 'Cliente'
                                                                }else{
                                                                    return 'Recebido'
                                                                }
                                                                 }
                                                                )()} </span>`),
gridjs.html(`                       <button id="pago_${titulos.id_item}"
                                                                        class="btn btn-success" ${titulos.pagamento != 1 ? 'hidden' : ''}
                                                                        onclick="mudaStatus(${titulos.id_item},'0','1', null, this)">SIM 
                                                                </button>
                                                                
                                                                <button id="naopago_${titulos.id_item}"
                                                                        class="btn btn-danger" ${titulos.pagamento == 1 ? 'hidden' : ''}
                                                                        onclick="mudaStatus(${titulos.id_item},'1','2','1', this)"> NÃO 
                                                                </button>`),
gridjs.html(`       <button type="button" class="btn btn-info btn-md"
                                                                        title="Valor Recebido"
                                                                        id="valorrecebido_${titulos.id_item}"
                                                                        onclick="abreModal(${titulos.id_item},'2','3', this)"
                                                                        hidden>
                                                                    <span style="pointer-event: none"><i class="fas fa-hand-holding-usd fa-lg"></i></span>
                                                                </button>
                                                                <button id="gerar_${titulos.id_item}"
                                                                        type="button"
                                                                        class="btn btn-secondary" ${(() => {if (titulos.id_item != null) {
                                                                    return 'hidden'
                                                                } } )()} 
                                                                        title="Gerar Boleto Santander"
                                                                        onclick="abreModal(${titulos.id_item},'5','3', this)"
                                                                        hidden>
                                                                    <span style="pointer-event: none"><i class="fas fa-history fa-lg"></i></span>
                                                                    </button> ${titulos.cobranca > 0 ? `  <a href="interacoes_cobranca.php?id=${titulos.id_item}"
                                                                       target="_blank"
                                                                       id="interacoes_${titulos.id_item}">
                                                                        <button type="button" class="btn btn-primary"
                                                                                title="Visualizar Interações">
                                                                            <span style="pointer-event: none"><i class="fas fa-eye fa-md"></i></span>
                                                                        </button>
                                                                    </a>` : ''}                                                                   
                                                                <button type="button" class="btn btn-success"
                                                                        title="Inserir Boleto"
                                                                        id="inserir${titulos.id_item}"
                                                                        onclick="abreModal(${titulos.id_item},'4','3', this)" ${(() =>{ if(!(titulos.arquivo == null && titulos.boleto == null)) { return 'hidden' } })()} 
                                                                    >
                                                                    <span style="pointer-event: none"><i class="fas fa-cloud-upload-alt fa-md"></i></span>
                                                                </button>
                                                                <a href="${(() =>{ if(titulos.arquivo != null) {

                                                                    return `arquivos/${titulos.arquivo}`;

                                                                }else if(titulos.link != null) {
                                                                    return `href="https://api-homologacao.getnet.com.br${titulos.link}`
                                                                }
                                                             })()}" target="_blank"
                                                                   id="bol${titulos.id_item}" ${(() =>{ if(titulos.arquivo == null && titulos.link == null) { return 'hidden' } })() }>
                                                                    <button type="button" class="btn btn-warning"
                                                                            title="Ver Boleto">
                                                                        <span style="pointer-event: none"><i class="fas fa-file-alt fa-lg"></i></span>
                                                                    </button>
                                                                </a>
                                                                <button id="exclui${titulos.id_item}"
                                                                        type="button" class="btn btn-danger"
                                                                        title="Excluir Boleto"
                                                                        onclick="excluiBoleto(${titulos.id_item})" ${(() => { if((titulos.id_item == '') && (titulos.id_item != null)) { return 'hidden' } })()} >
                                                                    <span style="pointer-event: none"><i class="fas fa-times fa-lg"></i></span>
                                                                </button>
                                                                `)
]),
total: data => data.count
} 
}).render(document.getElementById("table-js-recebidos"));

}

function drawContasAPagarTable() {

//
new gridjs.Grid({

language: {
    search: {
      placeholder: 'Procurar...'
    },
    pagination: {
      previous: 'Anterior',
      next: 'Próximo',
      navigate: (page, pages) => `Página ${page} de ${pages}`,
      page: (page) => `Página ${page}`,
      showing: 'Mostrando ',
      of: 'entre',
      to: 'a',
      results: 'resultados',
    },
    loading: 'Carrregando...',
        noRecordsFound: 'Nenhum registro encontrado',
    error: 'Erro ao conectar a base de dados',
  },

  style: {

    th: {
      'text-align': 'center'
    },
    td: {
      'text-align': 'center'
    }
  },

columns: ['Contrato', 'Centro de Custo', 'Descrição', 'Vencimento', 'Valor', 'Data de Pagamento', 'Conta', 'Status', 'Ações'],
pagination: {
enabled: true,
limit: 10,
server: {
  url: (prev, page, limit) => `${prev}&limit=${limit}&offset=${page * limit}`
}
},
search: {
server: {
  url: (prev, keyword) => `${prev}&search=${keyword}&`
}
},
sort: {
multiColumn: false,
server: {
  url: (prev, columns) => {

   if (!columns.length) return prev;
   
   const col = columns[0];
   const dir = col.direction === 1 ? 'asc' : 'desc';
   let colName = ['contrato', 'cc3.nome', 'descricao', 'vencimento', 'cp.valor', 'cp.data_pagamento', 'conta_nome', 'status_conta', 'status_conta'][col.index];
   
   return `${prev}&order=${colName}&dir=${dir}`;
 }
}
},

server: {
url: 'http://localhost/studiomfotografia/api/titulos/get-contas-a-pagar',
then: data => data.results.map(titulos => [
  titulos.contrato, titulos.centronome, titulos.descricao, titulos.vencimento, titulos.valor_conta, titulos.pagamento, titulos.conta_nome, 
  gridjs.html(`<p class="${titulos.status_conta != 'Não Pago' ? 'text-success' : 'text-danger'}">${titulos.status_conta}</p>`),
  gridjs.html(`${titulos.status_conta != 'Não Pago'
                ? 
                '' 
                : 
                `<button type="button" class="btn btn-info btn-md"
                title="Dar Baixa"
                onclick="abreModalMF(${titulos.id_lancamento}, '12', this)">
                <span style="pointer-event: none"><i class="fas fa-hand-holding-usd fa-lg"></i></span>
                </button>`}
                ${titulos.arquivo 
                ? 
                `<a href="arquivos/${titulos.arquivo}" 
                target="_blank"
                id="arq${titulos.id_lancamento}">
                <button type="button" class="btn btn-warning"
                title="Ver Arquivo">
                <span style="pointer-event: none"><i class="fas fa-file-alt fa-lg"></i></span>
                </button>
                </a>
                
                <button id="exclui${titulos.id_lancamento}"
                type="button" class="btn btn-danger"
                title="Excluir Arquivo"
                onclick="excluirArquivo(${titulos.id_lancamento}, this)" >
                <span style="pointer-event: none"><i class="fas fa-times fa-lg"></i></span>
                </button>` 
                : 
                `<button id="inserir${titulos.id_lancamento}
                type="button" class="btn btn-success"
                title="Inserir Arquivo"
                onclick="abreModalMF(${titulos.id_lancamento},'14', this)">
                <span style="pointer-event: none"><i class="fas fa-cloud-upload-alt fa-md"></i></span>
                </button>`}
                ${titulos.status_conta != 'Não Pago' 
                ?
                ''
                :
                `<button type="button" class="btn btn-danger btn-md"
                title="Desativar Lançamento"
                onclick="desativarLancamento(${titulos.id_lancamento}, this)">
                <span style="pointer-event: none"><i class="far fa-trash-alt"></i></span>
                </button>`}
                `)
]),
total: data => {
    return data.count
}
} 
}).render(document.getElementById("table-js-contas-a-pagar"));

}



//Movimento

const movimentoTable = new gridjs.Grid({

language: {
    search: {
      placeholder: 'Procurar...'
    },
    pagination: {
      previous: 'Anterior',
      next: 'Próximo',
      navigate: (page, pages) => `Página ${page} de ${pages}`,
      page: (page) => `Página ${page}`,
      showing: 'Mostrando ',
      of: 'entre',
      to: 'a',
      results: 'resultados',
    },
    loading: 'Carrregando...',
        noRecordsFound: 'Nenhum registro encontrado',
    error: 'Erro ao conectar a base de dados',
  },

  style: {

    th: {
      'text-align': 'center'
    },
    td: {
      'text-align': 'center'
    }
  },

columns: [
`Nº 
Movimentação`,

`Contrato`, 
`Centro de
 Custo`,

'Descrição',

'Parcela',

`Data 
Vencimento`,

`Data 
Pago|Ganho`,

`Valor Real`, 

`Valor 
Pago|Ganho`,

'Conta', 
'Observação'],
pagination: {
enabled: true,
limit: 10,
},
search: {
server: {
  url: (prev, keyword) => `${prev}&search=${keyword}&`
}
},
sort: {
multiColumn: false,
server: {
  url: (prev, columns) => {
   if (!columns.length) return prev;
   
   const col = columns[0];
   const dir = col.direction === 1 ? 'asc' : 'desc';
   let colName = ['id_movimentacao', 'id_item', 'centro_custo', 'descricao', 'parcela', 'data_vencimento', 'data_realizado', 'valor_total', 'valor_realizado', 'nome', 'observacoes'][col.index];

    if(document.querySelectorAll("#total-tr") != 1){
        document.querySelectorAll("#total-tr")[0].parentNode.remove()
    }

   return `${prev}&order=${colName}&dir=${dir}`;
 }
}
},


server: {
url: 'http://localhost/studiomfotografia/api/titulos/get-fluxo-de-caixa',
then: data => data.results.map(titulos => [titulos.id_movimentacao, titulos.id_item, titulos.centro_custo, titulos.descricao, titulos.parcela, titulos.data_vencimento, titulos.data_realizado, titulos.valor_total, 
gridjs.html(`<span class="${titulos.valor_realizado.replace('R$ ', '').replace(',', '.') > 0 ? 'text-success' : 'text-danger'}">${titulos.valor_realizado}<span>`),
titulos.nome, titulos.observacao
]),
total: data => {
    let header = document.querySelector("#table-js-movimento").querySelector(".gridjs-head")
    let tbody = document.querySelector("#table-js-movimento").querySelector(".gridjs-tbody")

    if(header.querySelector(".text-right")){
        
        header.querySelector(".text-right").innerHTML = `<b class="text-danger">Despesa: ${data.negative_total}</b>  |  <b class="text-success">Ganho: ${data.positive_total}</b>`
        tbody.lastChild.querySelector(".gridjs-td").innerHTML = `<b class="${data.total.replace('R$ ', '').replace(',', '.') >= 0 ? 'text-success' : 'text-danger'}">${data.total}</b>`
        
    }else{
        
        let p_total_positive_negative = document.createElement('div')
        let p_total = document.createElement('tr')

        p_total_positive_negative.classList.add('text-right', 'align-text-bottom', 'mr-1')
        p_total.classList.add('text-center', 'gridjs-tr')
        
        p_total_positive_negative.innerHTML = `<b class="text-danger">Despesa: ${data.negative_total}</b>  |  <b class="text-success">Ganho: ${data.positive_total}</b>`
        p_total.innerHTML = `<td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td id="total-tr" class="gridjs-td"><b class="${data.total.replace('R$ ', '').replace(',', '.') >= 0 ? 'text-success' : 'text-danger'}">${data.total}</b></td><td></td>` 

        header.lastChild.after(p_total_positive_negative)
        tbody.lastChild.after(p_total)
    }

    return data.count
}
} 
}).render(document.getElementById("table-js-movimento"));


function updateConfigPesquisaGeral(e) {

    document.querySelector(".text-right").remove()

    document.querySelector("#table-search-js-movimento").remove()

    if(document.querySelectorAll("#total-tr") != 1){
        document.querySelectorAll("#total-tr")[0].parentNode.remove()
    }

    movimentoTable.updateConfig({
        language: {
            search: {
                placeholder: 'Procurar...'
            },
            pagination: {
                previous: 'Anterior',
                next: 'Próximo',
                navigate: (page, pages) => `Página ${page} de ${pages}`,
                page: (page) => `Página ${page}`,
                showing: 'Mostrando ',
                of: 'entre',
                to: 'a',
                results: 'resultados',
            },
            loading: 'Carrregando...',
            noRecordsFound: 'Nenhum registro encontrado',
            error: 'Erro ao conectar a base de dados',
        },

        style: {

            th: {
                'text-align': 'center'
            },
            td: {
                'text-align': 'center'
            }
        },

        columns: [
            `Nº 
Movimentação`,

            `Contrato`,
            `Centro de
 Custo`,

            'Descrição',

            'Parcela',

            `Data 
Vencimento`,

            `Data 
Pago|Ganho`,

            `Valor Real`,

            `Valor 
Pago|Ganho`,

            'Conta',
            'Observação'
        ],
        pagination: {
            enabled: true,
            limit: 10,
        },
        search: {
            server: {
                url: (prev, keyword) => `${prev}&search=${keyword}&`
            }
        },
        sort: {
            multiColumn: false,
            server: {
                url: (prev, columns) => {
                    if (!columns.length) return prev;

                    const col = columns[0];
                    const dir = col.direction === 1 ? 'asc' : 'desc';
                    let colName = ['id_movimentacao', 'id_item', 'centro_custo', 'descricao', 'parcela', 'data_vencimento', 'data_realizado', 'valor_total', 'valor_realizado', 'nome', 'observacoes'][col.index];

                    return `${prev}&order=${colName}&dir=${dir}`;
                }
            }
        },

        server: {
            
            url: 'http://localhost/studiomfotografia/api/titulos/get-fluxo-de-caixa',
            then: data => data.results.map(titulos => [
                titulos.id_movimentacao, titulos.id_item, titulos.centro_custo, titulos.descricao, titulos.parcela != '1/0' ? titulos.parcela : '1/1', titulos.data_vencimento, titulos.data_realizado, titulos.valor_total,
                gridjs.html(`<span class="${titulos.valor_realizado.replace('R$ ', '').replace(',', '.') > 0 ? 'text-success' : 'text-danger'}">${titulos.valor_realizado}<span>`),
                titulos.nome, titulos.observacao
            ]),
            total: data => {
                
                if(document.querySelectorAll("#total-tr") != 1){
                    document.querySelectorAll("#total-tr")[0].parentNode.remove()
                }

                let header = document.querySelector("#table-js-movimento").querySelector(".gridjs-head")
                let tbody = document.querySelector("#table-js-movimento").querySelector(".gridjs-tbody")

                if (header.querySelector(".text-right")) {

                    header.querySelector(".text-right").innerHTML = `<b class="text-danger">Despesa: ${data.negative_total}</b>  |  <b class="text-success">Ganho: ${data.positive_total}</b>`
                    tbody.lastChild.querySelector(".gridjs-td").innerHTML = `<b class="${data.total.replace('R$ ', '').replace(',', '.') >= 0 ? 'text-success' : 'text-danger'}">${data.total}</b>`

                } else {

                    let p_total_positive_negative = document.createElement('div')
                    let p_total = document.createElement('tr')

                    p_total_positive_negative.classList.add('text-right', 'align-text-bottom', 'mr-1')
                    p_total.classList.add('text-center', 'gridjs-tr')

                    p_total_positive_negative.innerHTML = `<b class="text-danger">Despesa: ${data.negative_total}</b>  |  <b class="text-success">Ganho: ${data.positive_total}</b>`
                    p_total.innerHTML = `<td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td id="total-tr" class="gridjs-td"><b class="${data.total.replace('R$ ', '').replace(',', '.') >= 0 ? 'text-success' : 'text-danger'}">${data.total}</b></td><td></td>`

                    header.lastChild.after(p_total_positive_negative)
                    tbody.lastChild.after(p_total)
                }

                return data.count
            }
        }
    }).forceRender();
}



    function updateConfigPesquisaAvancada(e, columns = [], values = []) {


        movimentoTable.updateConfig({

            search: false,

            server: {
                url: 'http://localhost/studiomfotografia/api/titulos/get-fluxo-de-caixa?bycolumn=true&columns=' + columns.join(',') + '&values=' + values.join(','),
                then: data => data.results.map(titulos => [titulos.id_movimentacao, titulos.id_item, titulos.centro_custo, titulos.descricao, titulos.parcela != '1/0' ? titulos.parcela : '1/1', titulos.data_vencimento, titulos.data_realizado, titulos.valor_total,
                    gridjs.html(`<span class="${titulos.valor_realizado.replace('R$ ', '').replace(',', '.') > 0 ? 'text-success' : 'text-danger'}">${titulos.valor_realizado}<span>`),
                    titulos.nome, titulos.observacao
                ]),
                total: data => {
                    let totalNegativo = 0
                    let totalPostivo = 0
                    let valorParaSoma

                    for(let i = 0; i < data.results.length; i++) {

                        valorParaSoma = parseFloat(data.results[i].valor_realizado.replace('R$ ', '').replace(',', '.'))

                        if(valorParaSoma < 0) {
                            totalNegativo = parseFloat(totalNegativo) + parseFloat(valorParaSoma) 
                            continue
                        }

                        totalPostivo += parseFloat(valorParaSoma)
                    }
                    
                    let total = parseFloat(totalNegativo) - (parseFloat(totalPostivo)*-1)   
                                    
                    let header = document.querySelector("#table-search-js-movimento")
                    let tbody = document.querySelector("#table-js-movimento").querySelector("tbody")

                    let p_total_positive_negative = document.createElement('div')
                    let p_total = document.createElement('tr')

                    p_total_positive_negative.classList.add('text-right', 'align-text-bottom', 'mr-1')
                    p_total.classList.add('text-center', 'gridjs-tr')
                    p_total.id = "tr-total"

                    p_total_positive_negative.innerHTML = `<b class="text-danger">Despesa: R$ ${totalNegativo.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</b>  |  <b class="text-success">Ganho: ${totalPostivo.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</b>`
                    p_total.innerHTML = `<td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td id="total-tr" class="gridjs-td"><b class="${total >= 0 ? 'text-success' : 'text-danger'}">${total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</b></td><td></td>`
                
                        header.after(p_total_positive_negative)
                    
                       
                    if(tbody.lastChild.id == "tr-total") {
                        tbody.lastChild.replaceWith(p_total)
                    } else {
                        tbody.lastChild.after(p_total)
                    }

                    return data.count

                }
            }


        }).forceRender();


        let newSearchTable = document.createElement('table')
        newSearchTable.classList.add('table', 'table-sm', 'table-bordered', 'table-hover', 'table-striped', 'table-responsive', 'mt-2')
        newSearchTable.id = 'table-search-js-movimento'

        newSearchTable.innerHTML = `
        <thead>
            <tr class="gridjs-tr">
                <th><input type="text" placeholder="Nº Movimentação" data-column="id_movimentacao"
                        style="border-radius: 3px; padding:8px 3px;border: 1px solid #d2d6dc;"></th>
                <th><input type="text" placeholder="Contrato" data-column="id_item"
                        style="border-radius: 3px; padding:8px 3px;border: 1px solid #d2d6dc;"></th>
                <th><input type="text" placeholder="Centro de Custo" data-column="centro_custo"
                        style="border-radius: 3px; padding:8px 3px;border: 1px solid #d2d6dc;"></th>
                <th><input type="text" placeholder="Descrição" data-column="descricao"
                        style="border-radius: 3px; padding:8px 3px;border: 1px solid #d2d6dc;"></th>
                <th><input type="text" placeholder="Parcela" data-column="parcela"
                        style="border-radius: 3px; padding:8px 3px;border: 1px solid #d2d6dc;"></th>
                <th><input type="text" placeholder="Data Vencimento" data-column="data_vencimento"
                        style="border-radius: 3px; padding:8px 3px;border: 1px solid #d2d6dc;"></th>
                <th><input type="text" placeholder="Data Pago|Ganho" data-column="data_realizado"
                        style="border-radius: 3px; padding:8px 3px;border: 1px solid #d2d6dc;"></th>
                <th><input type="text" placeholder="Valor Real" data-column="valor_total"
                        style="border-radius: 3px; padding:8px 3px;border: 1px solid #d2d6dc;"></th>
                <th><input type="text" placeholder="Valor Pago|Ganho" data-column="valor_realizado"
                        style="border-radius: 3px; padding:8px 3px;border: 1px solid #d2d6dc;"></th>
                <th><input type="text" placeholder="Conta" data-column="nome"
                        style="border-radius: 3px; padding:8px 3px;border: 1px solid #d2d6dc;"></th>
                <th><input type="text" placeholder="Observação" data-column="observacoes"
                        style="border-radius: 3px; padding:8px 3px;border: 1px solid #d2d6dc;"></th>
                
            </tr>
        </thead>
        `

        let tableMovimento = document.querySelector("#table-js-movimento")
        tableMovimento.insertBefore(newSearchTable, tableMovimento.firstChild)

        var timer;

        newSearchTable.querySelectorAll("input").forEach(searchInput => {
            searchInput.oninput = () => {

                clearTimeout(timer)



                let columns = []
                let values = []

                document.querySelector("#table-js-movimento").querySelectorAll("input").forEach(searchInput => {
                    if (searchInput.value.length > 0) {
                        columns.push(searchInput.dataset.column)
                        values.push(searchInput.value)
                        searchInput.style.cssText = "border:1px solid #36bea6; padding: 5px 2px;"

                    } else {
                        searchInput.style.cssText = "border:1px solid #d2d6dc; padding: 5px 2px;"
                    }


                })

                timer = setTimeout(function () {

                    movimentoTable.updateConfig({

                        search: false,

                        server: {
                            url: 'http://localhost/studiomfotografia/api/titulos/get-fluxo-de-caixa?bycolumn=true&columns=' + columns.join(',') + '&values=' + values.join(','),
                            then: data => data.results.map(titulos => [titulos.id_movimentacao, titulos.id_item, titulos.centro_custo, titulos.descricao, titulos.parcela != '1/0' ? titulos.parcela : '1/1', titulos.data_vencimento, titulos.data_realizado, titulos.valor_total,
                                gridjs.html(`<span class="${titulos.valor_realizado.replace('R$ ', '').replace(',', '.') > 0 ? 'text-success' : 'text-danger'}">${titulos.valor_realizado}<span>`),
                                titulos.nome, titulos.observacao
                            ]),
                            total: data => {
                                let tbody = document.querySelector("#table-js-movimento").querySelector("tbody")

                                if (document.querySelector(".text-right")) {

                                    let totalNegativo = 0
                                    let totalPostivo = 0
                                    let valorParaSoma

                                    for(let i = 0; i < data.results.length; i++) {

                                        valorParaSoma = parseFloat(data.results[i].valor_realizado.replace('R$ ', '').replace(',', '.'))

                                        
                                        if(valorParaSoma < 0) {
                                            totalNegativo = parseFloat(totalNegativo) + parseFloat(valorParaSoma) 
                                            continue
                                        }

                                        totalPostivo += parseFloat(valorParaSoma)
                                    }

                                    let total = parseFloat(totalNegativo) - (parseFloat(totalPostivo)*-1) 

                                    document.querySelector(".text-right").innerHTML = `<b class="text-danger">Despesa: ${totalNegativo.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</b>  |  <b class="text-success">Ganho: ${totalPostivo.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</b>`
                                    let p_total = document.createElement('tr')
                                    p_total.innerHTML = `<td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td id="total-tr" class="gridjs-td"><b class="${total >= 0 ? 'text-success' : 'text-danger'}"> ${total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</b></td><td></td>`
                                    p_total.classList.add('text-center', 'gridjs-tr')
                                    tbody.lastChild.after(p_total)
                                }

                                return data.count

                            }
                        }

                    }).forceRender();

                }, 600);
            }
        })
    }


    function drawFluxoFuturo() {
        
        new gridjs.Grid({

language: {
    search: {
      placeholder: 'Procurar...'
    },
    pagination: {
      previous: 'Anterior',
      next: 'Próximo',
      navigate: (page, pages) => `Página ${page} de ${pages}`,
      page: (page) => `Página ${page}`,
      showing: 'Mostrando ',
      of: 'entre',
      to: 'a',
      results: 'resultados',
    },
    loading: 'Carrregando...',
        noRecordsFound: 'Nenhum registro encontrado',
    error: 'Erro ao conectar a base de dados',
  },

  style: {

    th: {
      'text-align': 'center'
    },
    td: {
      'text-align': 'center'
    }
  },

columns: [

`Contrato`, 

`Centro de Custo`,

'Descrição',

'Parcela',

`Data Vencimento`,

`Valor`

],
pagination: {
enabled: true,
limit: 10,
server: {
  url: (prev, page, limit) => `${prev}&limit=${limit}&offset=${page * limit}`
}
},
search: {
server: {
  url: (prev, keyword) => `${prev}&search=${keyword}&`
}
},
sort: {
multiColumn: false,
server: {
  url: (prev, columns) => {
   if (!columns.length) return prev;
   
   const col = columns[0];
   const dir = col.direction === 1 ? 'asc' : 'desc';
   let colName = ['contrato', 'centro_custo', 'descricao', 'parcela', 'data_vencimento', 'valor'][col.index];
   
   return `${prev}&order=${colName}&dir=${dir}`;
 }
}
},


server: {
url: 'http://localhost/studiomfotografia/api/titulos/get-fluxo-futuro',
then: data => data.results.map(titulos => [gridjs.html(`<span title="${titulos.nome}">${titulos.contrato}</span>`),
titulos.centro_custo, titulos.descricao, titulos.parcela != '1/0' ? titulos.parcela : '1/1', titulos.data_vencimento, 
gridjs.html(`<span class="${titulos.valor.replace('R$ ', '').replace(',', '.') > 0 ? 'text-success' : 'text-danger'}">${titulos.valor}<span>`),
]),
total: data => {
    let header = document.querySelector("#table-js-fluxo-futuro").querySelector(".gridjs-head")
    let tbody = document.querySelector("#table-js-fluxo-futuro").querySelector(".gridjs-tbody")

    if(header.querySelector(".text-right")){
        
        header.querySelector(".text-right").innerHTML = `<b class="text-danger">Despesa: ${data.negative_total}</b>  |  <b class="text-success">Ganho: ${data.positive_total}</b>`
        tbody.lastChild.querySelector(".gridjs-td").innerHTML = `<b class="${data.total.replace('R$ ', '').replace(',', '.') >= 0 ? 'text-success' : 'text-danger'}">${data.total}</b>`
        
    }else{
        
        let p_total_positive_negative = document.createElement('div')
        let p_total = document.createElement('tr')

        p_total_positive_negative.classList.add('text-right', 'align-text-bottom', 'mr-1')
        p_total.classList.add('text-center', 'gridjs-tr')
        
        p_total_positive_negative.innerHTML = `<b class="text-danger">Despesa: ${data.negative_total}</b>  |  <b class="text-success">Ganho: ${data.positive_total}</b>`
        p_total.innerHTML = ` <td style="padding: 8px 0px !important;"></td> <td style="padding: 8px 0px !important;"></td> <td></td> <td></td> <td></td> <td id="total-tr" class="gridjs-td"><b class="${data.total.replace('R$ ', '').replace(',', '.') >= 0 ? 'text-danger' : 'text-success'}">${data.total}</b></td>` 

        header.lastChild.after(p_total_positive_negative)
        tbody.lastChild.after(p_total)
    }

    return data.count
}
} 
}).render(document.getElementById("table-js-fluxo-futuro"));

    }
    $('#tipo_lancamento').change(function () {
                    $.ajax({
                        url: 'financeiro_movimentacao.php?tipo_pagamento=' + this.value + '',
                        type: 'post',
                        async: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            $('#tipo_pagamento').html(response);
                        },
                    });
                });
                $('#id_fornecedor').change(function () {
                    $.ajax({
                        url: 'financeiro_movimentacao.php?id_f=' + this.value + '',
                        type: 'post',
                        async: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            $('#id_cat_fornecedor').html(response);
                        },
                    });
                });
                $('#valor').change(function () {
                    arrumarCampos(this.value);
                });
                $('#observacoes').change(function () {
                    arrumarCampos($('#valor').val());
                });
                $('#plano_contas').change(function () {
                    arrumarCampos($('#valor').val());
                });


    

        </script>
        </body>
        </html>
    <?php }
} ?>        





