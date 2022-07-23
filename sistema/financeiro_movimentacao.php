<?php
include "../includes/conexao.php";
date_default_timezone_set('America/Sao_Paulo');
session_start();
$id_usuario = $_SESSION['id'];
$usuarios_permitidos = array(1, 2, 67,74);
$id_pagina = 47;
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
            <!-- This Page CSS -->
            <link rel="stylesheet" type="text/css" href="../layout/assets/libs/select2/dist/css/select2.min.css">
            <link rel="stylesheet" type="text/css" href="../layout/assets/extra-libs/prism/prism.css">
            <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
            <!-- Custom CSS -->
            <link href="../layout/dist/css/style.min.css" rel="stylesheet">
            <style>
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
            <style></style>
            <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
            <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
            <script>
                $(document).ready(function ($) {
                    $('#valor_pago').mask('###.###,##', {reverse: true});
                    $('#valor').mask('###.###,##', {reverse: true});
                    $('#valor_transferencia').mask('###.###,##', {reverse: true});
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
                                        <li class="breadcrumb-item active" aria-current="page">Contas a Pagar</li>
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
                    <!-- Sales chart -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <br>
                                    <h4>Filtrar Data</h4>
                                    <div class="form-row">
                                        <div class="form-group col-lg-2 col-md-3 col-sm-4"
                                             style="margin-bottom: 0px !important;">
                                            <label for="">De</label>
                                            <input type="date" id="min" onchange="filtraData()"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3 col-sm-4"
                                             style="margin-bottom: 0px !important;">
                                            <label for="">Até</label>
                                            <input type="date" id="max" onchange="filtraData()"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group col-lg-8 col-md-6 col-sm-4 "
                                             style="margin-bottom: 0px !important;">
                                            <label for="dob" style="float: right !important; margin-right: 0px !important;">Excel Movimentação: 
                                            
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
                                    <br>
                                    <ul class="nav nav-tabs" role="tablist">

                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                href="#ch1"
                                                                role="tab"><span
                                                        class="hidden-xs-down">Movimentação Financeira</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ch2"
                                                                role="tab"><span
                                                        class="hidden-xs-down">Lançamentos Pendentes</span></a>
                                        </li>
                                    </ul>
                                    <input type="text" id="id_lancamento" name="id_lancamento" hidden>
                                    <input type="text" id="id_movimentacao" name="id_movimentacao" hidden>
                                    <input type="text" id="valor_real" name="valor_real" hidden>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalRelatorioInadiplentes" tabindex="-1" role="dialog" aria-labelledby="modalLabelRelatorioInad" aria-hidden="true">
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
                                                <input type="hidden" id="tipo" name="tipo" value="saida">
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
                                    <!--                                      MODALS-->
                                    <div>
                                        <div id="modal3" class="modal" tabindex="-1" role="dialog">
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

                                        <div id="modal2" class="modal" tabindex="-1" role="dialog">
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
                                                        <button type="button" id="enviarValor"
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
                                                        <button type="button" id="alterarCadastro"
                                                                class="btn btn-success">Alterar
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

                                        <div id="modal5" class="modal" tabindex="-1" role="dialog">
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
                                    <div class="tab-content tabcontent-border">

                                        <div class="tab-pane active" id="ch1" role="tabpanel">
                                            <br>
                                            <div class="table-responsive">
                                                <table id="tabela" class="table v-middle"
                                                       style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th width="5%"></th>
                                                        <th><h5><strong>Conta</strong></h5></th>
                                                        <th><h5><strong>Descrição</strong></h5></th>
                                                        <th style="text-align: center"><h5><strong>Valor</strong></h5>
                                                        </th>
                                                        <th style="text-align: center"><h5><strong>Baixa</strong></h5>
                                                        </th>
                                                        <th style="text-align: center"><h5><strong>Ação</strong></h5>
                                                        </th>
                                                        <th hidden></th>
                                                        <th hidden></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $sql_atual = mysqli_query($con, "select mf.id_movimentacao,l.id_lancamento,l.arquivo,mf.valor,mf.data,l.parcela,l.chave_parcelamento,c.nome as cnome,cc.numeracao, l.titulo, cf.nome as titulo_fornecedor, c2.nome as fornecedor from movimentacao_financeira mf
                                                                                            left join lancamentos l on l.id_lancamento = mf.id_lancamento
                                                                                            left join contas c on c.id_conta = mf.id_conta
                                                                                            left join clientes c2 on c2.id_cli = l.id_fornecedor
                                                                                            left join categoriafornecedor cf on cf.id_categoria = l.categoria_fornecedor
                                                                                            left join categorias_contas cc on cc.id_catconta = mf.id_catconta
                                                                                            where mf.status='1' and mf.id_duplicata is null");
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        ?>
                                                        <tr id="tr<?php echo $vetor['id_lancamento']; ?>"
                                                            class="<?php if ((float)$vetor['valor'] < 0) {
                                                                echo 'table-danger';
                                                            } else {
                                                                echo 'table-success';
                                                            } ?>">
                                                            <td></td>
                                                            <td>
                                                                <?php if ((float)$vetor['valor'] < 0) {
                                                                    echo '<span hidden>despesa</span>';
                                                                } else {
                                                                    echo '<span hidden>receita</span>';
                                                                }
                                                                echo $vetor['cnome']; ?>
                                                            </td>
                                                            <td><?php echo ($vetor['titulo_fornecedor'] != ''?$vetor['titulo_fornecedor'] . ' - ' . ucwords(strtolower($vetor['fornecedor'])):'') . ($vetor['titulo'] == '' ? '' : ($vetor['titulo_fornecedor'] != ''?'<br>':'') . $vetor['titulo']); ?></td>
                                                            <td align="center">
                                                                <?php echo ((float)$vetor['valor'] > 0 ? '+' : '') . $vetor['valor']; ?>
                                                            </td>
                                                            <td align="center"><?php echo date('d/m/Y', strtotime($vetor['data'])); ?></td>

                                                            <td align="center">
                                                                <button id="inserir<?php echo $vetor['id_lancamento']; ?>"
                                                                        type="button" class="btn btn-success"
                                                                        title="Inserir Arquivo"
                                                                        onclick="abreModal(<?php echo $vetor['id_lancamento']; ?>,'4')" <?php if (!($vetor['arquivo'] == '')) {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-cloud-upload-alt fa-md"></i></span>
                                                                </button>

                                                                <a href="<?php if ($vetor['arquivo'] != null) {
                                                                    echo 'arquivos/' . $vetor['arquivo'];
                                                                } ?>" target="_blank"
                                                                   id="arq<?php echo $vetor['id_lancamento']; ?>" <?php if ($vetor['arquivo'] == null) {
                                                                    echo 'hidden';
                                                                }; ?>>
                                                                    <button type="button" class="btn btn-warning"
                                                                            title="Ver Arquivo">
                                                                        <span><i class="fas fa-file-alt fa-lg"></i></span>
                                                                    </button>
                                                                </a>
                                                                <?php if (in_array($id_usuario, $usuarios_permitidos)) { ?>
                                                                    <button type="button" class="btn btn-danger btn-md"
                                                                            title="Cancelar Lançamento"
                                                                            onclick="cancelarLancamento(<?php echo $vetor['id_lancamento']; ?>)">
                                                                        <span><i class="mdi mdi-window-close"></i></span>
                                                                    </button>
                                                                <?php } ?>

                                                            </td>

                                                            <td hidden><?php echo $vetor['id_lancamento'] . ';' . $vetor['id_movimentacao'] ?></td>
                                                            <td hidden></td>
                                                        </tr>
                                                    <?php }
                                                    $sql_atual = mysqli_query($con, "select mf.id_movimentacao,mf.id_duplicata,f.nome as fnome,cc.numeracao,cc.titulo,mf.valor,mf.data,c.nome as cnome from movimentacao_financeira mf
                                                                                            left join duplicatas_faturas df on df.id_item = mf.id_duplicata
                                                                                            left join duplicatas d on d.id_duplicata = df.id_duplicata
                                                                                            left join vendas v on v.id_venda = d.id_venda   
                                                                                            left join formandos f on f.id_formando = v.id_formando
                                                                                            left join contas c on c.id_conta=mf.id_lancamento
                                                                                            left join categorias_contas cc on cc.id_catconta = mf.id_catconta
                                                                                            where mf.status = '1' and mf.id_lancamento is NULL ;");
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        ?>
                                                        <tr class="<?php if ((float)$vetor['valor'] < 0) {
                                                            echo 'table-danger';
                                                        } else {
                                                            echo 'table-success';
                                                        } ?>" id="tr<?php echo $vetor['id_movimentacao']; ?>">
                                                            <td></td>
                                                            <td>
                                                                <?php if ((float)$vetor['valor'] < 0) {
                                                                    echo '<span hidden>despesa</span>';
                                                                } else {
                                                                    echo '<span hidden>receita</span>';
                                                                }
                                                                echo $vetor['cnome']; ?>
                                                            </td>
                                                            <td><?php echo $vetor['numeracao'] . ' - ' . $vetor['titulo'] . ' - ' . $vetor['fnome']; ?></td>
                                                            <td align="center">
                                                                <?php echo ((float)$vetor['valor'] > 0 ? '+' : '') . $vetor['valor']; ?>
                                                            </td>
                                                            <td align="center"><?php echo date('d/m/Y', strtotime($vetor['data'])); ?></td>
                                                            <td align="center">
                                                                <?php if (in_array($id_usuario, $usuarios_permitidos)) { ?>
                                                                    <button type="button" class="btn btn-warning btn-md"
                                                                            title="Modificar Data"
                                                                            onclick="abreModal(<?php echo $vetor['id_movimentacao']; ?>,'3')">
                                                                        <span><i class="far fa-calendar-alt"></i></span>
                                                                    </button>
                                                                <?php } ?>
                                                            </td>
                                                            <td hidden></td>
                                                            <td hidden><?php echo $vetor['id_movimentacao'] . ';' . $vetor['id_duplicata']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <th align="center" style="border:none"></th>
                                                        <th align="center" style="border:none"></th>
                                                        <th align="center" style="border:none"></th>
                                                        <th align="center"
                                                            style="border:none;text-align: center;white-space: nowrap"></th>
                                                        <th align="center"
                                                            style="border:none;text-align: center;white-space: nowrap"></th>
                                                        <th align="center" style="border:none"></th>
                                                        <th align="center" style="border:none"></th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="ch2" role="tabpanel">
                                            <br>
                                            <button type="button" onclick="abreModal('','2')"
                                                    class="btn waves-effect waves-light btn-warning">
                                                <i class="fas fa-plus"></i> Lançamento
                                            </button>
                                            <button type="button" onclick="abreModal('','5')"
                                                    class="btn waves-effect waves-light btn-info">
                                                <i class="fas fa-plus"></i> Transferência
                                            </button>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="tabela2" class="table v-middle"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    <tr>
                                                        <th><h5><strong>Contrato</strong></h5></th>
                                                        <th><h5><strong>Centro<br>Custo</strong></h5></th>
                                                        <th><h5><strong>Descrição</strong></h5></th>
                                                        <th><h5><strong>Vencimento</strong></h5></th>
                                                        <th><h5><strong>Valor</strong></h5></th>
                                                        <th><h5><strong>Ação</strong></h5></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $dataatual = date('Y-m-d');
                                                    $sql_atual = mysqli_query($con, "select cp.*,cc3.nome as centronome,c.nome as fornecedor,cf.nome as titulo_fornecedor,cc.numeracao, t.ncontrato from lancamentos cp
                                                        left join turmas t on t.id_turma = cp.id_turma
                                                        left join clientes c on c.id_cli = cp.id_fornecedor
                                                        left join categoriafornecedor cf on cf.id_categoria = cp.categoria_fornecedor
                                                        left join ficha_tecnica ft on ft.categoria_fornecedor = cp.categoria_fornecedor
                                                        left join categorias_contas cc on cc.id_catconta = ft.id_catconta
                                                        left join centro_custo cc3 on cc3.id_centro = cp.id_centro
                                                        where cp.status='0'");
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        ?>
                                                        <tr id="tr<?php echo $vetor['id_lancamento']; ?>"
                                                            class="<?php if ((float)$vetor['valor'] < 0) {
                                                                echo 'table-danger';
                                                            } else {
                                                                echo 'table-success';
                                                            } ?>">
                                                            <td align="center"><?php echo($vetor['ncontrato'] != null ? $vetor['ncontrato'] : 'Custo Fixo'); ?></td>
                                                            <td align="center"><?php echo $vetor['centronome']; ?></td>
                                                            <td align="center"><?php echo $vetor['titulo_fornecedor'] . ' - ' . ucwords(strtolower($vetor['fornecedor'])) . ($vetor['titulo'] == '' ? '' : '<br>' . $vetor['titulo']); ?></td>
                                                            <td align="center"><?php echo date('d/m/Y', strtotime($vetor['data_vencimento'])); ?></td>
                                                            <td align="center"><?php echo $vetor['valor']; ?></td>
                                                            <td align="center">
                                                                <button type="button" class="btn btn-info btn-md"
                                                                        title="Dar Baixa"
                                                                        onclick="abreModal(<?php echo $vetor['id_lancamento']; ?>,'2')">
                                                                    <span><i class="fas fa-hand-holding-usd fa-lg"></i></span>
                                                                </button>

                                                                <button id="inserir<?php echo $vetor['id_lancamento']; ?>"
                                                                        type="button" class="btn btn-success"
                                                                        title="Inserir Arquivo"
                                                                        onclick="abreModal(<?php echo $vetor['id_lancamento']; ?>,'4')" <?php if (!($vetor['arquivo'] == '')) {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-cloud-upload-alt fa-md"></i></span>
                                                                </button>

                                                                <a href="<?php if ($vetor['arquivo'] != null) {
                                                                    echo 'arquivos/' . $vetor['arquivo'];
                                                                } ?>" target="_blank"
                                                                   id="arq<?php echo $vetor['id_lancamento']; ?>" <?php if ($vetor['arquivo'] == null) {
                                                                    echo 'hidden';
                                                                }; ?>>
                                                                    <button type="button" class="btn btn-warning"
                                                                            title="Ver Arquivo">
                                                                        <span><i class="fas fa-file-alt fa-lg"></i></span>
                                                                    </button>
                                                                </a>
                                                                <button id="exclui<?php echo $vetor['id_lancamento'] ?>"
                                                                        type="button" class="btn btn-danger"
                                                                        title="Excluir Arquivo"
                                                                        onclick="excluirArquivo(<?php echo $vetor['id_lancamento']; ?>)" <?php if (!($vetor['arquivo'] != '')) {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <span><i class="fas fa-times fa-lg"></i></span>
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-md"
                                                                        title="Desativar Lançamento"
                                                                        onclick="desativarLancamento(<?php echo $vetor['id_lancamento']; ?>)">
                                                                    <span><i class="far fa-trash-alt"></i></span>
                                                                </button>
                                                            </td>
                                                        </tr>

                                                    <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <th align="center" style="border:none"></th>
                                                        <th align="center" style="border:none"></th>
                                                        <th align="center" style="border:none"></th>
                                                        <th align="center" style="border:none"></th>
                                                        <th align="center"
                                                            style="border:none;text-align: center;white-space: nowrap"></th>
                                                        <th align="center" style="border:none"></th>
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
        <!-- This Page JS -->
        <script src="../layout/assets/libs/select2/dist/js/select2.min.js"></script>
        <script src="../layout/dist/js/app-style-switcher.js"></script>
        <script src="../layout/assets/extra-libs/prism/prism.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="../layout/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
        <script src="../layout/assets/extra-libs/sparkline/sparkline.js"></script>
        <!--Wave Effects -->
        <script src="../layout/dist/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="../layout/dist/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="../layout/dist/js/custom.min.js"></script>
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
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="../layout/dist/js/pages/datatable/datatable-basic.init.js"></script>
        <script src="../layout/assets/libs/moment/min/moment.min.js"></script>

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
                if (parseFloat(dado) > 0) {
                    return "<span class='text-success'>" + aux.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    }) + "</span>";
                } else {
                    return "<span class='text-danger'>" + (aux).toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    }) + "</span>";
                }
            }

            function format(d) {
                var aux = '';
                var fd = new FormData();
                fd.append('detalhes', '1');
                if (d.id_lancamento != '') {
                    fd.append('id_lancamento', d.id_lancamento);
                    $.ajax({
                        url: 'recebe_movimentacao.php',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        async: false,
                        success: function (response) {
                            aux = response;
                        },
                    });
                } else {
                    fd.append('id_duplicata', d.id_duplicata);
                    $.ajax({
                        url: 'recebe_movimentacao.php',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        async: false,
                        success: function (response) {
                            aux = response;
                        },
                    });
                }
                return aux;
            }

            $(document).ready(function () {
                $('#conta_origem').change(function (){
                    $('#conta_destino').load('financeiro_movimentacao.php?id_conta=' + $('#conta_origem').val());
                });
                $('.select2').each(function () {
                    $(this).select2({
                        dropdownParent: $('#modal2 .modal-content'),
                        width: 'resolve'
                    });
                });
                $('.select2modal5').each(function () {
                    $(this).select2({
                        dropdownParent: $('#modal5 .modal-content'),
                        width: 'resolve'
                    });
                });
                var tabela = $('#tabela').DataTable({
                    destroy: false,
                    "pageLength": 50,
                    scrollCollapse: true,
                    ordering: true,
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
                        {"data": "conta"},
                        {"data": "descricao"},
                        {
                            "data": "valor",
                            "render": function (data, type, row) {
                                return formatarCampo(data);
                            }
                        },
                        {"data": "data", "type": "date-br"},
                        {"data": "acao"},
                        {"data": "id_lancamento"},
                        {"data": "id_duplicata"}
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
                            .column(3)
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);

                        // // Total over this page
                        pageTotal = api
                            .column(3, {filter: 'applied'})
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);

                        // Update footer
                        if (pageTotal > 0) {
                            $(api.column(3).footer()).html('<strong>Total: <span class="text-success">' + pageTotal.toLocaleString('pt-BR', {
                                style: 'currency',
                                currency: 'BRL'
                            }) + '</span></strong>');
                        } else {
                            $(api.column(3).footer()).html('<strong>Total: <span class="text-danger">' + pageTotal.toLocaleString('pt-BR', {
                                style: 'currency',
                                currency: 'BRL'
                            }) + '</span></strong>');
                        }

                    },
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
                var tabela2 = $('#tabela2').DataTable({
                    destroy: false,
                    "pageLength": 50,
                    scrollCollapse: true,
                    ordering: true,
                    info: true,
                    searching: true,
                    paging: true,
                    dom: 'Bfrtip',
                    columnDefs: [
                        {
                            type: 'date-br',
                            targets: 3,
                        },
                        {
                            targets: 4,
                            "render": function (data, type, row) {
                                return formatarCampo(data);
                            }
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
                            .column(4)
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);

                        // // Total over this page
                        pageTotal = api
                            .column(4, {filter: 'applied'})
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);

                        // Update footer
                        if (pageTotal > 0) {
                            $(api.column(4).footer()).html('<strong>Total: <span class="text-success">' + pageTotal.toLocaleString('pt-BR', {
                                style: 'currency',
                                currency: 'BRL'
                            }) + '</span></strong>');
                        } else {
                            $(api.column(4).footer()).html('<strong>Total: <span class="text-danger">' + pageTotal.toLocaleString('pt-BR', {
                                style: 'currency',
                                currency: 'BRL'
                            }) + '</span></strong>');
                        }

                    },
                });
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
                            $("#arq" + $('#id_lancamento').val()).attr('href', '../sistema/arquivos/' + response);
                            $("#inserir" + $('#id_lancamento').val()).attr('hidden', 'hidden');
                            $("#arq" + $('#id_lancamento').val()).removeAttr('hidden');
                            $("#exclui" + $('#id_lancamento').val()).removeAttr('hidden');

                        },
                    });
                });

                $("#enviarTransferencia").click(function () {
                    if($('#conta_origem').val() != '' && $('#conta_destino').val() != '' && $('#valor_transferencia').val() != ''){
                        var fd = new FormData();
                        var conta_origem = $('#conta_origem').val();
                        var conta_destino = $('#conta_destino').val();
                        var valor = $('#valor_transferencia').val();
                        fd.append('conta_origem', conta_origem);
                        fd.append('conta_destino', conta_destino);
                        fd.append('valor_transferencia', valor);

                        $.ajax({
                            url: 'recebe_lancamento.php',
                            type: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                $('#modal5').modal('hide');
                                swal('Transferência efetuada com sucesso!', '', 'success');
                            },
                        });
                    }else{
                        swal('É necessário preencher todos os campos!', '', 'warning');
                    }

                });
                $("#enviarValor").click(function () {
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
                                    $('#modal2').modal('hide');
                                    swal('Movimentação Inserida com Sucesso!', '', 'success');
                                    $('#tabela2').DataTable().row("#tr" + $('#id_lancamento').val()).remove();
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
                                        $('#tr' + $('#id_lancamento').val()).addClass('table-success');
                                    } else {
                                        $('#tr' + $('#id_lancamento').val()).addClass('table-danger');
                                    }
                                    var aux = $('#tr' + $('#id_lancamento').val()).children();
                                    $(aux[3]).attr('align', 'center');
                                    $(aux[4]).attr('align', 'center');
                                    $(aux[5]).attr('align', 'center');
                                    $(aux[6]).attr('hidden', 'hidden');
                                    $(aux[7]).attr('hidden', 'hidden');
                                    $('#tabela2').DataTable().draw();
                                    $('#tabela').DataTable().draw();
                                },
                            });
                        } else {
                            swal('Você precisa inserir uma observação e uma categoria do plano de contas para justificar a diferença de valor.', '', 'warning');
                        }
                    } else {
                        swal('É preciso preencher todos os campos obrigatórios!', '', 'warning');
                    }
                });
                $("#modificarData").click(function () {
                    var fd = new FormData();
                    fd.append('id_movimentacao', $('#id_movimentacao').val());
                    fd.append('nova_data', $('#nova_data').val());
                    $.ajax({
                        url: 'recebe_movimentacao.php?modificardata=1',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            $('#modal3').modal('hide');
                            swal('Data modificada com Sucesso!', '', 'success');
                            var aux = $('#tr' + $('#id_movimentacao').val()).children();
                            $(aux[4]).html(response);
                            $('#tabela').DataTable().draw();
                        },
                    });
                });
                $("#alterarCadastro").click(function () {
                    if (preenchidos()) {
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
                        fd.append('valor', $('#valor').val());
                        fd.append('observacoes', $('#observacoes').val());

                        $.ajax({
                            url: 'recebe_lancamento.php?alterar=1',
                            type: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                $('#modal2').modal('hide');
                                swal('Alteração Realizada com Sucesso!', '', 'success');
                                $('#tabela2').DataTable().row("#tr" + $('#id_lancamento').val()).remove();
                                var dados = response.split(';');
                                $('#tabela2').DataTable().row.add([dados[0], dados[1], dados[2], dados[3], dados[4], dados[5]]).draw().node().id = 'tr' + $('#id_lancamento').val();
                                if (parseFloat(dados[4]) > 0) {
                                    $('#tr' + $('#id_lancamento').val()).addClass('table-success');
                                } else {
                                    $('#tr' + $('#id_lancamento').val()).addClass('table-danger');
                                }
                                var aux = $('#tr' + $('#id_lancamento').val()).children();
                                aux.each(function () {
                                    $(this).attr('align', 'center');
                                });
                                $('#tabela2').DataTable().draw();
                            },
                        });
                    } else {
                        swal('É preciso preencher todos os campos obrigatórios!', '', 'warning');
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
                                $('#modal2').modal('hide');
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
                $('body').on('click', function (e) {
                    $('[data-toggle=popover]').each(function () {
                        // hide any open popovers when the anywhere else in the body is clicked
                        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                            $(this).popover('hide');
                        }
                    });
                });
                var activeTab = location.hash;
                if (activeTab != "") {
                    var splitted = activeTab.split('#');
                    for (var i = 1; i < splitted.length; i++) {
                        $('.nav-link[href="#' + splitted[i] + '"]').click();
                    }
                }
            });

            function verificaValores(dado) {
                var aux = dado;
                aux = aux.replace('.', '');
                aux = aux.replace(',', '.');
                var valor = parseFloat(aux);
                aux = $('#valor_real').val();
                aux = aux.replace('.', '');
                aux = aux.replace(',', '.');
                var valor_real = parseFloat(aux);
                var maximo = valor_real + (valor_real * 0.005);
                var minimo = valor_real - (valor_real * 0.005);
                if (valor <= minimo || valor >= maximo) {
                    return true;
                } else {
                    return false;
                }
            }

            function preenchidos() {
                if ($('#tipo_lancamento').val() != '0' && $('#id_fornecedor').val() != '0' && $('#id_cat_fornecedor').val() != '0' && $('#centro_custo').val() != '0' && $('#tipo_pagamento').val() != '0' && $('#id_conta').val() != '0' && $('#data_competencia').val() != '' && $('#data_emissao').val() != '' && $('#data_vencimento').val() != '' && $('#valor').val() != '') {
                    return true;
                } else {
                    return false;
                }
            }

            function arrumarCampos(dado) {
                if (verificaValores(dado)) {
                    $('#esconde_plano_contas').removeAttr('hidden');
                } else {
                    $('#plano_contas').val('');
                    $('#esconde_plano_contas').attr('hidden', 'hidden');
                }
            }

            function filtraData() {
                $('#tabela').DataTable().draw();
                $('#tabela2').DataTable().draw();
            }

            function abreModal(id, modal) {
                $('#id_lancamento').val(id);
                $('#esconde_plano_contas').attr('hidden', 'hidden');
                $('#plano_contas').val('');
                if (modal == '2' && id != '') {
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
                            $('#id_fornecedor').val(aux[1]);
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
                            $('#valor_real').val(aux[11]);
                        },
                    });
                } else if (modal == '2') {
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
                } else if (modal == '3') {
                    $('#id_movimentacao').val(id);
                }
                $('#modal' + modal).modal('show');
            }

            function excluirArquivo(id) {
                $.post('recebe_lancamento.php?excluir=' + id);
                $("#inserir" + id).removeAttr('hidden');
                $("#arq" + id).attr('hidden', 'hidden');
                $("#exclui" + id).attr('hidden', 'hidden');
            }

            function cancelarLancamento(id) {
                swal({
                    title: "Você tem certeza que deseja cancelar esta movimentação?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.post('recebe_movimentacao.php?excluir=' + id, function (response) {
                                swal('Movimentação Cancelada com Sucesso!', '', 'success');
                                var dados = response.split(';');
                                $('#tabela2').DataTable().row.add([dados[0], dados[1], dados[2], dados[3], dados[4], dados[5]]).draw().node().id = 'tr' + id;
                                if (parseFloat(dados[4]) > 0) {
                                    $('#tr' + id).addClass('table-success');
                                } else {
                                    $('#tr' + id).addClass('table-danger');
                                }
                                var aux = $('#tr' + id).children();
                                aux.each(function () {
                                    $(this).attr('align', 'center');
                                });
                                $('#tabela2').DataTable().draw();
                            });
                            $('#tabela').DataTable().row("#tr" + id).remove();
                            $('#tabela').DataTable().draw();
                        }
                    });
            }

            function desativarLancamento(id) {
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
                            $('#tabela2').DataTable().row("#tr" + id).remove();
                            $('#tabela2').DataTable().draw();
                        }
                    });
            }
        </script>
        </body>

        </html>
    <?php }
} ?>