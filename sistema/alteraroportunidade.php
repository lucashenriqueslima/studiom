<?php
include "../includes/conexao.php";
session_start();
//PROSPECCAO
if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
} else {
    $id = $_GET['id'];
    $sql = mysqli_query($con, "select * from turmas_leads where id_turma_lead = '{$id}'");
    $vetor = mysqli_fetch_array($sql);
    $media = (float)mysqli_fetch_array(mysqli_query($con,"SELECT AVG(v.valorvenda) as media_venda
  FROM (SELECT v.valorvenda FROM vendas v 
 			WHERE v.status <> '4' and v.tipo = '1' 
 			order by v.`data` DESC,v.id_venda DESC 
 			LIMIT 0,500) v"))['media_venda'];
    $sql_prospeccao = mysqli_query($con, "select * from prospeccoes where id_prospeccao = '{$vetor['id_prospeccao']}'");
    $vetor_prospeccao = mysqli_fetch_array($sql_prospeccao);
    $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '{$vetor['id_curso']}'");
    $vetor_curso = mysqli_fetch_array($sql_curso);
    $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '{$vetor_curso['id_instituicao']}'");
    $vetor_instituicao = mysqli_fetch_array($sql_instituicao);
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script type="text/javascript">
            function enviaContrato(produto, id) {
                if ($('#contrato_fechado_' + produto).val() == 'sim') {
                    $.post('recebe_gerarcontrato.php',
                        {
                            id: id,
                            contrato: 'sim'
                        }
                    );
                } else {
                    $.post('recebe_gerarcontrato.php',
                        {
                            id: id,
                            contrato: 'nao'
                        }
                    );
                }
            }

            $(document).ready(function () {
                $('#qtd_alunos').change(function () {
                    var valor_fotografia = parseFloat($('#qtd_alunos').val()) - Math.ceil(parseFloat($('#qtd_alunos').val()) * 0.3);
                    var valor_convite = parseFloat($('#qtd_alunos').val()) - Math.ceil(parseFloat($('#qtd_alunos').val()) * 0.2);
                    $('#fotografia_formandos').val(valor_fotografia);
                    $('#fotografia_formandos').trigger('change');
                    $('#convite_formandos').val(valor_convite);
                    $('#convite_formandos').trigger('change');
                });
                $('#convite_formandos').change(function () {
                    var valor = parseFloat($('#convite_formandos').val()) * parseFloat(<?php echo $media;  ?>)
                    $('#convite_valor').val(new Intl.NumberFormat(['pt-BR'], {
                        minimumFractionDigits: 2
                    }).format(valor));
                });
                $('#fotografia_formandos').change(function () {
                    var valor = (parseFloat($('#fotografia_formandos').val()) - Math.ceil(parseFloat($('#qtd_comissao').val()) / 2)) * 9215
                    $('#fotografia_valor').val(new Intl.NumberFormat(['pt-BR'], {
                        minimumFractionDigits: 2
                    }).format(valor));
                });
                $('#empresa_cerimonial').change(function () {
                    if ($('#empresa_cerimonial').val() == 1) {
                        $('#nome_cerimonial_revela').removeAttr('hidden');
                    } else {
                        $('#nome_cerimonial_revela').attr('hidden', 'hidden');
                    }
                });
                $("#contrato_fechado_fotografia").change(function () {
                    switch ($("#contrato_fechado_fotografia").val()) {
                        case '':
                            $('#btn_contrato_fotografia').attr('hidden', 'hidden');
                            break;
                        case 'sim':
                            $('#btn_contrato_fotografia').removeAttr('hidden');
                            $('#btn_salvar_fotografia').attr('hidden', 'hidden');
                            $('#btn_contrato_fotografia').attr('style', 'border-color: orange;background-color: orange;margin-left:1%');
                            document.querySelector('#btn_contrato_fotografia').innerHTML = 'Gerar Contrato'
                            break;
                        case 'nao':
                            $('#btn_contrato_fotografia').removeAttr('hidden');
                            $('#btn_salvar_fotografia').attr('hidden', 'hidden');
                            $('#btn_contrato_fotografia').attr('style', 'border-color: gray;background-color: gray;margin-left:1%');
                            document.querySelector('#btn_contrato_fotografia').innerHTML = 'Contrato Não Fechado';
                            break;
                    }
                });
                $("#contrato_fechado_convite").change(function () {
                    switch ($("#contrato_fechado_convite").val()) {
                        case '':
                            $('#btn_contrato_convite').attr('hidden', 'hidden');
                            break;
                        case 'sim':
                            $('#btn_contrato_convite').removeAttr('hidden');
                            $('#btn_salvar_convite').attr('hidden', 'hidden');
                            $('#btn_contrato_convite').attr('style', 'border-color: orange;background-color: orange;margin-left:1%');
                            document.querySelector('#btn_contrato_convite').innerHTML = 'Gerar Contrato'
                            break;
                        case 'nao':
                            $('#btn_contrato_convite').removeAttr('hidden');
                            $('#btn_salvar_convite').attr('hidden', 'hidden');
                            $('#btn_contrato_convite').attr('style', 'border-color: gray;background-color: gray;margin-left:1%');
                            document.querySelector('#btn_contrato_convite').innerHTML = 'Contrato Não Fechado';
                            break;
                    }
                });
                $("#contrato_fechado_ensaio").change(function () {
                    switch ($("#contrato_fechado_ensaio").val()) {
                        case '':
                            $('#btn_contrato_ensaio').attr('hidden', 'hidden');
                            break;
                        case 'sim':
                            $('#btn_contrato_ensaio').removeAttr('hidden');
                            $('#btn_salvar_ensaio').attr('hidden', 'hidden');
                            $('#btn_contrato_ensaio').attr('style', 'border-color: orange;background-color: orange;margin-left:1%');
                            document.querySelector('#btn_contrato_ensaio').innerHTML = 'Gerar Contrato'
                            break;
                        case 'nao':
                            $('#btn_contrato_ensaio').removeAttr('hidden');
                            $('#btn_salvar_ensaio').attr('hidden', 'hidden');
                            $('#btn_contrato_ensaio').attr('style', 'border-color: gray;background-color: gray;margin-left:1%');
                            document.querySelector('#btn_contrato_ensaio').innerHTML = 'Contrato Não Fechado';
                            break;
                    }
                });
                $("#contrato_fechado_placa").change(function () {
                    switch ($("#contrato_fechado_placa").val()) {
                        case '':
                            $('#btn_contrato_placa').attr('hidden', 'hidden');
                            break;
                        case 'sim':
                            $('#btn_contrato_placa').removeAttr('hidden');
                            $('#btn_salvar_placa').attr('hidden', 'hidden');
                            $('#btn_contrato_placa').attr('style', 'border-color: orange;background-color: orange;margin-left:1%');
                            document.querySelector('#btn_contrato_placa').innerHTML = 'Gerar Contrato'
                            break;
                        case 'nao':
                            $('#btn_contrato_placa').removeAttr('hidden');
                            $('#btn_salvar_placa').attr('hidden', 'hidden');
                            $('#btn_contrato_placa').attr('style', 'border-color: gray;background-color: gray;margin-left:1%');
                            document.querySelector('#btn_contrato_placa').innerHTML = 'Contrato Não Fechado';
                            break;
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function ($) {
                $('.valor_venda').mask('#.###.###.###.###,##', {reverse: true});
                $('#fotografia_valor').mask('#.###.###.###.###,##', {reverse: true});
                $('.probabilidade_fechamento').mask('##%', {reverse: true});
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
                                        <h5 class="m-b-0"><?php echo $_SESSION['nome']; ?></h5>
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
                                    <li class="breadcrumb-item">Comercial</a></li>
                                    <li class="breadcrumb-item">CRM</a></li>
                                    <li class="breadcrumb-item">Leads</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Editar Lead</li>
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
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Dados do Lead</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fotografia"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span
                                                    class="hidden-xs-down" <?php if ($vetor_prospeccao['fotografia_viabilidade'] == 'inviavel') {
                                                echo "style='text-decoration-line: line-through;'";
                                            } ?>>Fotografia</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#convite"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span
                                                    class="hidden-xs-down" <?php if ($vetor_prospeccao['convite_viabilidade'] == 'inviavel') {
                                                echo "style='text-decoration-line: line-through;'";
                                            } ?>>Convite</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ensaio"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span
                                                    class="hidden-xs-down" <?php if ($vetor_prospeccao['ensaio_viabilidade'] == 'inviavel') {
                                                echo "style='text-decoration-line: line-through;'";
                                            } ?>>Ensaio</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#placa"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span
                                                    class="hidden-xs-down" <?php if ($vetor_prospeccao['placa_viabilidade'] == 'inviavel') {
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

                                </ul>

                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="dados" role="tabpanel">

                                        <br>
                                        <br>
                                        <form action="recebe_alteraroportunidade.php?id=<?php echo $id ?>&dados_gerais=sim"
                                              method="post">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Turma</label>
                                                        <input type="text" name="id_turma"
                                                               value="<?php echo $vetor_curso['nome'] . "/" . $vetor_curso['sigla'] . "/" . $vetor['ano_conclusao'] . "-" . $vetor['semestre']; ?>"
                                                               class="form-control" disabled>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-2">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Tipo de
                                                            Prospecção</label>
                                                        <input type="text" name="tipo_comunicacao"
                                                               value="<?php echo ucfirst($vetor['tipo_comunicacao']); ?>"
                                                               class="form-control" disabled>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">E-mail da
                                                            Comissão</label>
                                                        <input type="text" name="email_comissao"
                                                               value="<?php echo $vetor['email_comissao']; ?>"
                                                               class="form-control">
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->

                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Vagas</label>
                                                        <input type="number" name="qtdalunos"
                                                               value="<?php echo $vetor_curso['vagas1']; ?>"
                                                               class="form-control" disabled>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Quantidade
                                                            de
                                                            Alunos</label>
                                                        <input type="number" name="num_alunos" id="qtd_alunos"
                                                               value="<?php echo $vetor['num_alunos']; ?>"
                                                               class="form-control">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Quantidade
                                                            Comissão</label>
                                                        <input type="number" name="num_comissao" id="qtd_comissao"
                                                               value="<?php echo $vetor['num_comissao']; ?>"
                                                               class="form-control">
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Empresa de
                                                            Festa (cerimonial)?</label>
                                                        <select name="empresa_cerimonial" id="empresa_cerimonial"
                                                                class="form-control">
                                                            <option value="1" <?php echo($vetor_prospeccao['empresa_cerimonial'] == 1 ? 'selected=""' : ''); ?>>
                                                                Sim
                                                            </option>
                                                            <option value="2" <?php echo($vetor_prospeccao['empresa_cerimonial'] == 2 ? 'selected=""' : ''); ?>>
                                                                Não
                                                            </option>
                                                        </select>
                                                    </fieldset>
                                                </div>


                                                <div class="col-lg-6">
                                                    <fieldset class="form-group"
                                                              id="nome_cerimonial_revela" <?php echo($vetor_prospeccao['empresa_cerimonial'] == 2 ? 'hidden' : ''); ?>>
                                                        <label class="form-label semibold" for="exampleInput">Nome da
                                                            Empresa</label>
                                                        <input type="text" name="nome_cerimonial"
                                                               value="<?php echo $vetor_prospeccao['nome_cerimonial']; ?>"
                                                               class="form-control" id="nome_cerimonial"
                                                               placeholder="Digite o nome da empresa">
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Observações</label>
                                                        <textarea name="observacao"
                                                                  class="form-control"><?php echo $vetor_prospeccao['observacao']; ?></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <button type="submit" class="btn btn-success"
                                                            style="float: left;">
                                                        Salvar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!--                                    FOTOGRAFIA-->
                                    <div class="tab-pane" id="fotografia" role="tabpanel">
                                        <br>
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                    href="#dados_fotografia"
                                                                    role="tab"><span class="hidden-sm-up"><i
                                                                class="ti-email"></i></span> <span
                                                            class="hidden-xs-down">Dados</span></a>
                                            </li>
                                            <?php if ($vetor['id_fotografia'] != 0) { ?>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                        href="#documentos_fotografia"
                                                                        role="tab"><span class="hidden-sm-up"><i
                                                                    class="ti-email"></i></span> <span
                                                                class="hidden-xs-down">Documentos</span></a>
                                                </li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                        href="#orcamentos_fotografia"
                                                                        role="tab"><span class="hidden-sm-up"><i
                                                                    class="ti-email"></i></span> <span
                                                                class="hidden-xs-down"
                                                                style="color: red">Orçamentos</span></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content tabcontent-border">
                                            <div class="tab-pane active" id="dados_fotografia" role="tabpanel">
                                                <br>
                                                <form action="<?php if ($vetor_prospeccao['fotografia_viabilidade'] == 'gerado') {
                                                    echo "recebe_alteraroportunidade.php?id=" . $id . "&dados_fotografia=sim";
                                                } else {
                                                    echo "recebe_lead.php?id_oportunidade=" . $id . "&id=" . $vetor['id_prospeccao'];
                                                } ?>"
                                                      method="post">
                                                    <?php
                                                    if ($vetor['id_fotografia'] != 0) {
                                                        $vetor_lead = mysqli_fetch_array(mysqli_query($con, "select * from leads where id_lead = '{$vetor['id_fotografia']}'"));
                                                        $vetor_calendario = mysqli_fetch_array(mysqli_query($con, "select * from calendario where id_calendario = '{$vetor_lead['id_calendario']}'"));
                                                        $sql_usuarios = mysqli_query($con, "select * from usuarios where departamento=1 order by nome ASC");
                                                        $vetor_categoriasCRM = mysqli_fetch_array(mysqli_query($con, "select * from categorias where id_categoria = '{$vetor_lead['id_categoria_crm']}'"));
                                                        $sql_statusCRM = mysqli_query($con, "select * from sub_categorias where id_categoria = '{$vetor_lead['id_categoria_crm']}' order by posicao ASC");
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Representante
                                                                        Comercial</label>
                                                                    <select name="vendedor"
                                                                            class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <option value="">
                                                                            Selecione um colaborador
                                                                        </option>
                                                                        <?php while ($usuarios = mysqli_fetch_array($sql_usuarios)) { ?>
                                                                            <option value="<?php echo $usuarios['id_usuario']; ?>" <?php echo($vetor_lead['id_responsavel'] == $usuarios['id_usuario'] ? 'selected=""' : ''); ?>>
                                                                                <?php echo $usuarios['nome']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Qtde.
                                                                        de
                                                                        Formandos</label>
                                                                    <input type="text" name="num_formandos"
                                                                           id="fotografia_formandos"
                                                                           value="<?php echo($vetor_lead['num_formandos'] ? $vetor_lead['num_formandos'] : $vetor['num_alunos'] - ceil($vetor['num_alunos'] * 0.3)); ?>"
                                                                           class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Possibilidade Total
                                                                        de Venda (R$)</label>
                                                                    <input type="text" name="valor_venda"
                                                                           id="fotografia_valor"
                                                                           value="<?php
                                                                           $comissao = ($vetor['num_comissao'] != null && $vetor['num_comissao'] != 0 ? ceil((float)$vetor['num_comissao'] / 2) : 5);
                                                                           $previsao = ($vetor_lead['num_formandos'] != 0 ? number_format(((int)$vetor_lead['num_formandos'] - $comissao) * 9215, 2, ',', '.') : '');
                                                                           $previsao_semlead = ($vetor['num_alunos'] != 0 ? number_format((($vetor['num_alunos'] - ceil($vetor['num_alunos'] * 0.3) - $comissao) * 9215), 2, ',', '.') : '');
                                                                           echo($vetor_lead['valor_venda'] != null && $vetor_lead['valor_venda'] != 0 ? $vetor_lead['valor_venda'] : ($vetor_lead['num_formandos'] != 0 ? $previsao : $previsao_semlead)); ?>"
                                                                           class="form-control valor_venda" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>

                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Desconto Comissão
                                                                        (R$)</label>
                                                                    <input type="text"
                                                                           value="<?php echo number_format(ceil((int)$vetor['num_comissao'] / 2) * 9215, 2, ',', '.'); ?>"
                                                                           class="form-control">
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Probabilidade
                                                                        de Fechamento</label>
                                                                    <input type="text" name="probabilidade_fechamento"
                                                                           value="<?php echo substr($vetor_lead['probabilidade_fechamento'], 0, 2); ?>"
                                                                           class="form-control probabilidade_fechamento" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                </fieldset>
                                                            </div>
                                                        </div><!--.row-->
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <label class="form-label semibold" for="exampleInput">Previsão
                                                                    de Fechamento</label>
                                                                <input type="date" name="data_prevista"
                                                                       value="<?php echo $vetor_calendario['datafim']; ?>"
                                                                       class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                    echo "disabled=''";
                                                                } ?>>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Categoria
                                                                        CRM</label>
                                                                    <input type="text" name="categoriaCRM"
                                                                           value="<?php echo $vetor_categoriasCRM['nome']; ?>"
                                                                           class="form-control" disabled>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Status
                                                                        CRM</label>
                                                                    <select name="statusCRM"
                                                                            class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <?php while ($status = mysqli_fetch_array($sql_statusCRM)) { ?>
                                                                            <option value="<?php echo $status['id_sub']; ?>" <?php echo($status['id_sub'] == $vetor_lead['id_status'] ? 'selected=""' : ''); ?>>
                                                                                <?php echo $status['nome']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                        </div><!--.row-->
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Contrato
                                                                        Fechado?</label>
                                                                    <select name="contrato_fechado"
                                                                            class="form-control"
                                                                            id="contrato_fechado_fotografia" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <option value="">Em Aberto</option>
                                                                        <option value="sim" <?php if ($vetor_lead['contrato_fechado'] == 'sim') {
                                                                            echo "selected=''";
                                                                        } ?>>Sim
                                                                        </option>
                                                                        <option value="nao" <?php if ($vetor_lead['contrato_fechado'] == 'nao') {
                                                                            echo "selected=''";
                                                                        } ?>>Não
                                                                        </option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <?php if ($vetor_lead['contrato_fechado'] == null) { ?>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <button type="submit" class="btn btn-success" id="btn_salvar_fotografia"
                                                                            style="float: left;">
                                                                        Salvar
                                                                    </button>
                                                                    <button type="submit" class="btn"
                                                                            id="btn_contrato_fotografia"
                                                                            onclick="enviaContrato('fotografia',<?php echo $vetor_lead['id_lead']; ?>)"
                                                                            hidden>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div class="row">

                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Viabilidade
                                                                        de
                                                                        Negócio?</label>
                                                                    <select id="fotografia_viabilidade"
                                                                            name="fotografia_viabilidade"
                                                                            class="form-control" disabled>
                                                                        <option value="1" <?php if ($vetor_prospeccao['fotografia_viabilidade'] == 'viavel') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Sim
                                                                        </option>
                                                                        <option value="2" <?php if ($vetor_prospeccao['fotografia_viabilidade'] == 'inviavel') {
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
                                                                          id="fotografia_qtdalunos" <?php if ($vetor_prospeccao['fotografia_viabilidade'] == 'inviavel') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Quantidade de
                                                                        Formandos</label>
                                                                    <input type="text" name="num_formandos"
                                                                           class="form-control">
                                                                </fieldset>
                                                                <input type="text" name="qual_produto"
                                                                       class="form-control"
                                                                       id="qual_produto"
                                                                       value="fotografia" hidden>
                                                                <fieldset class="form-group"
                                                                          id="fotografia_motivo_fechado" <?php if ($vetor_prospeccao['fotografia_viabilidade'] == 'viavel') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Motivo</label>
                                                                    <select id="fotografia_motivo"
                                                                            name="fotografia_motivo"
                                                                            class="form-control" disabled>
                                                                        <option value="1" <?php if ($vetor_prospeccao['fotografia_motivo'] == 'Contrato Fechado com outra Empresa') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Contrato Fechado com outra empresa
                                                                        </option>
                                                                        <option value="2" <?php if ($vetor_prospeccao['fotografia_motivo'] == 'Fora do Perfil de atendimento') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Fora do Perfil de atendimento
                                                                        </option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group"
                                                                          id="fotografia_empresa_fechado" <?php if ($vetor_prospeccao['fotografia_viabilidade'] == 'viavel' or $vetor_prospeccao['fotografia_motivo'] == 'Fora do Perfil de atendimento') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Nome da Empresa</label>
                                                                    <input type="text" name="fotografia_empresa"
                                                                           value="<?php echo $vetor_prospeccao['fotografia_empresa']; ?>"
                                                                           class="form-control"
                                                                           placeholder="Nome da Empresa" disabled>
                                                                </fieldset>
                                                            </div>
                                                            <?php if ($vetor_prospeccao['fotografia_viabilidade'] == 'viavel') { ?>
                                                                <div class="col-lg-2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                            style="float: left;">
                                                                        Gerar Lead
                                                                    </button>
                                                                </div>
                                                            <?php } ?>
                                                        </div><!--.row-->
                                                    <?php } ?>
                                                </form>
                                            </div>
                                            <?php if ($vetor['id_fotografia'] != 0) { ?>
                                                <div class="tab-pane" id="documentos_fotografia" role="tabpanel">
                                                    <br>
                                                    <br>

                                                    <a href="cadastroarquivooportunidade.php?id=<?php echo $vetor_lead['id_lead']; ?>&id_turma_lead=<?php echo $vetor['id_turma_lead']; ?>">
                                                        <button type="button" class="btn btn-primary"
                                                                style="    float: left;">
                                                            Cadastrar Arquivo
                                                        </button>
                                                    </a>

                                                    <br>
                                                    <br>
                                                    <br>

                                                    <table id="lang_opt2" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th><strong><h5>Titulo</h5></strong></th>
                                                            <th><strong><h5>Data</h5></strong></th>
                                                            <th><strong><h5>Hora</h5></strong></th>
                                                            <th><strong><h5>Arquivo</h5></strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $sql_arquivos = mysqli_query($con, "select * from arquivos_oportunidade where id_lead = '{$vetor_lead['id_lead']}' order by id_arquivo DESC");
                                                        while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                                <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?></td>
                                                                <td><?php echo substr($vetor_arquivo['hora'], 0, 5); ?></td>
                                                                <td>
                                                                    <a href="arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                                    >
                                                                        <button type="button" class="btn btn-default">
                                                                            Arquivo
                                                                        </button>
                                                                    </a> <a
                                                                            href="excluirarquivooportunidade.php?id=<?php echo $vetor_arquivo['id_arquivo']; ?>&id_turma_lead=<?php echo $vetor['id_turma_lead']; ?>"
                                                                    >
                                                                        <button type="button" class="btn btn-danger">
                                                                            <i class="mdi mdi-window-close"></i>
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="orcamentos_fotografia" role="tabpanel">
                                                    <br>

                                                    <table id="lang_opt4" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th><strong><h5>Código</h5></strong></th>
                                                            <th><strong><h5>Oportunidade</h5></strong></th>
                                                            <th><strong><h5>Qtd de Formandos</h5></strong></th>
                                                            <th><strong><h5>Data</h5></strong></th>
                                                            <th><strong><h5>Valor</h5></strong></th>
                                                            <th><strong><h5>Status</h5></strong></th>
                                                            <th><strong><h5>Ação</h5></strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $sql_orcamentos = mysqli_query($con, "select * from orcamento_convite where tipo = '1' AND id_oportunidade = '{$id}' order by id_orcamento DESC");
                                                        while ($vetor_orcamento = mysqli_fetch_array($sql_orcamentos)) {
                                                            $sql_oportunidade = mysqli_query($con, "select * from oportunidades where id_oportunidade = '{$id}'");
                                                            $vetor_oportunidade = mysqli_fetch_array($sql_oportunidade);
                                                            $sql_mkt = mysqli_query($con, "select * from prospeccoes where id_prospeccao = '{$vetor_oportunidade['id_prospeccao']}'");
                                                            $vetor_prospeccao = mysqli_fetch_array($sql_mkt);
                                                            $sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '{$vetor_prospeccao['id_turma']}'");
                                                            $vetor_turma = mysqli_fetch_array($sql_turma);
                                                            $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '{$vetor_turma['id_curso']}'");
                                                            $vetor_curso = mysqli_fetch_array($sql_curso);
                                                            $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '{$vetor_curso['id_instituicao']}'");
                                                            $vetor_instituicao = mysqli_fetch_array($sql_instituicao);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $vetor_orcamento['id_orcamento']; ?></td>
                                                                <td><?php echo $id; ?>
                                                                    - <?php echo $vetor_curso['nome']; ?>
                                                                    / <?php echo $vetor_curso['sigla']; ?>
                                                                    / <?php echo $vetor_turma['conclusao']; ?>
                                                                    -<?php echo $vetor_turma['semestre']; ?></td>
                                                                <td><?php echo $vetor_orcamento['qtdformandos']; ?></td>
                                                                <td><?php echo date('d/m/Y', strtotime($vetor_orcamento['data'])); ?></td>
                                                                <td>
                                                                    R$<?php echo $num = number_format($vetor_orcamento['valortotal'], 2, ',', '.'); ?></td>
                                                                <td>
                                                                </td>
                                                                <td>
                                                                    <a href="cadastroorcfotografia_produtos.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>"
                                                                    >
                                                                        <button type="button"
                                                                                class="btn btn-info"
                                                                                title="Ver ou Alterar Cadastro"><i
                                                                                    class="fa fa-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href="confexcluirorcconvite.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger"
                                                                                title="Excluir Cadastro">
                                                                            <i class="mdi mdi-window-close"></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href="imprimirproposta.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>"
                                                                    >
                                                                        <button type="button"
                                                                                class="btn btn-primary"
                                                                                title="Imprimir Cadastro"><i
                                                                                    class="fa fa-print"></i></button>
                                                                    </a>
                                                                    <a href="aprovarproposta.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-success"
                                                                                title="Aprovar Proposta"><i
                                                                                    class="fa fa-thumbs-up"></i>
                                                                        </button>
                                                                    </a></td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <!--                                    CONVITE-->
                                    <div class="tab-pane" id="convite" role="tabpanel">
                                        <br>
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                    href="#dados_convite"
                                                                    role="tab"><span class="hidden-sm-up"><i
                                                                class="ti-email"></i></span> <span
                                                            class="hidden-xs-down">Dados</span></a>
                                            </li>
                                            <?php if ($vetor['id_convite'] != 0) { ?>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                        href="#documentos_convite"
                                                                        role="tab"><span class="hidden-sm-up"><i
                                                                    class="ti-email"></i></span> <span
                                                                class="hidden-xs-down">Documentos</span></a>
                                                </li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                        href="#orcamentos_convite"
                                                                        role="tab"><span class="hidden-sm-up"><i
                                                                    class="ti-email"></i></span> <span
                                                                class="hidden-xs-down"
                                                                style="color: red">Orçamentos</span></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content tabcontent-border">
                                            <div class="tab-pane active" id="dados_convite" role="tabpanel">
                                                <br>
                                                <form action="<?php if ($vetor_prospeccao['convite_viabilidade'] == 'gerado') {
                                                    echo "recebe_alteraroportunidade.php?id=" . $id . "&dados_convite=sim";
                                                } else {
                                                    echo "recebe_lead.php?id_oportunidade=" . $id . "&id=" . $vetor['id_prospeccao'];
                                                } ?>"
                                                      method="post">
                                                    <?php
                                                    if ($vetor['id_convite'] != 0) {
                                                        $vetor_lead = mysqli_fetch_array(mysqli_query($con, "select * from leads where id_lead = '{$vetor['id_convite']}'"));
                                                        $vetor_calendario = mysqli_fetch_array(mysqli_query($con, "select * from calendario where id_calendario = '{$vetor_lead['id_calendario']}'"));
                                                        $sql_usuarios = mysqli_query($con, "select * from usuarios where departamento=1 order by nome ASC");
                                                        $vetor_categoriasCRM = mysqli_fetch_array(mysqli_query($con, "select * from categorias where id_categoria = '{$vetor_lead['id_categoria_crm']}'"));
                                                        $sql_statusCRM = mysqli_query($con, "select * from sub_categorias where id_categoria = '{$vetor_lead['id_categoria_crm']}' order by posicao ASC");
                                                        ?>

                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Representante
                                                                        Comercial</label>
                                                                    <select name="vendedor"
                                                                            class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <option value="">
                                                                            Selecione um colaborador
                                                                        </option>
                                                                        <?php while ($usuarios = mysqli_fetch_array($sql_usuarios)) { ?>
                                                                            <option value="<?php echo $usuarios['id_usuario']; ?>" <?php echo($vetor_lead['id_responsavel'] == $usuarios['id_usuario'] ? 'selected=""' : ''); ?>>
                                                                                <?php echo $usuarios['nome']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Qtde.
                                                                        de
                                                                        Formandos</label>
                                                                    <input type="text" name="num_formandos" id="convite_formandos"
                                                                           value="<?php echo ($vetor_lead['num_formandos'] != null && $vetor_lead['num_formandos'] != 0?$vetor_lead['num_formandos']:(int)$vetor['num_alunos'] - ceil((int)$vetor['num_alunos'] * 0.2)); ?>"
                                                                           class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Possibilidade Total
                                                                        de Venda (R$)</label>
                                                                    <input type="text" name="valor_venda" id="convite_valor"
                                                                           value="<?php echo number_format(($vetor_lead['valor_venda'] != null && $vetor_lead['valor_venda'] != '0'?$vetor_lead['valor_venda']:($vetor_lead['num_formandos'] != null && $vetor_lead['num_formandos'] != '0'?$vetor_lead['num_formandos']:(int)$vetor['num_alunos'] - ceil((int)$vetor['num_alunos'] * 0.2))*$media),2,',','.'); ?>"
                                                                           class="form-control valor_venda" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Probabilidade
                                                                        de Fechamento</label>
                                                                    <input type="text" name="probabilidade_fechamento"
                                                                           value="<?php echo substr($vetor_lead['probabilidade_fechamento'], 0, 2); ?>"
                                                                           class="form-control probabilidade_fechamento" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                </fieldset>
                                                            </div>
                                                        </div><!--.row-->
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Categoria
                                                                        CRM</label>
                                                                    <input type="text" name="categoriaCRM"
                                                                           value="<?php echo $vetor_categoriasCRM['nome']; ?>"
                                                                           class="form-control" disabled>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Status
                                                                        CRM</label>
                                                                    <select name="statusCRM"
                                                                            class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <?php while ($status = mysqli_fetch_array($sql_statusCRM)) { ?>
                                                                            <option value="<?php echo $status['id_sub']; ?>" <?php echo($status['id_sub'] == $vetor_lead['id_status'] ? 'selected=""' : ''); ?>>
                                                                                <?php echo $status['nome']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label class="form-label semibold" for="exampleInput">Previsão
                                                                    de Fechamento</label>
                                                                <input type="date" name="data_prevista"
                                                                       value="<?php echo $vetor_calendario['datafim']; ?>"
                                                                       class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                    echo "disabled=''";
                                                                } ?>>
                                                            </div>
                                                        </div><!--.row-->
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Contrato
                                                                        Fechado?</label>
                                                                    <select name="contrato_fechado"
                                                                            class="form-control"
                                                                            id="contrato_fechado_convite" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <option value="">Em Aberto</option>
                                                                        <option value="sim" <?php if ($vetor_lead['contrato_fechado'] == 'sim') {
                                                                            echo "selected=''";
                                                                        } ?>>Sim
                                                                        </option>
                                                                        <option value="nao" <?php if ($vetor_lead['contrato_fechado'] == 'nao') {
                                                                            echo "selected=''";
                                                                        } ?>>Não
                                                                        </option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <?php if ($vetor_lead['contrato_fechado'] == null) { ?>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <button type="submit" class="btn btn-success" id="btn_salvar_convite"
                                                                            style="float: left;">
                                                                        Salvar
                                                                    </button>
                                                                    <button type="submit" class="btn"
                                                                            id="btn_contrato_convite"
                                                                            onclick="enviaContrato('convite',<?php echo $vetor_lead['id_lead']; ?>)"
                                                                            hidden>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div class="row">

                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Viabilidade
                                                                        de
                                                                        Negócio?</label>
                                                                    <select id="convite_viabilidade"
                                                                            name="convite_viabilidade"
                                                                            class="form-control" disabled>
                                                                        <option value="1" <?php if ($vetor_prospeccao['convite_viabilidade'] == 'viavel') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Sim
                                                                        </option>
                                                                        <option value="2" <?php if ($vetor_prospeccao['convite_viabilidade'] == 'inviavel') {
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
                                                                          id="convite_qtdalunos" <?php if ($vetor_prospeccao['convite_viabilidade'] == 'inviavel') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Quantidade de
                                                                        Formandos</label>
                                                                    <input type="text" name="num_formandos"
                                                                           class="form-control">
                                                                </fieldset>
                                                                <input type="text" name="qual_produto"
                                                                       class="form-control"
                                                                       id="qual_produto"
                                                                       value="convite" hidden>
                                                                <fieldset class="form-group"
                                                                          id="convite_motivo_fechado" <?php if ($vetor_prospeccao['convite_viabilidade'] == 'viavel') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Motivo</label>
                                                                    <select id="convite_motivo" name="convite_motivo"
                                                                            class="form-control" disabled>
                                                                        <option value="1" <?php if ($vetor_prospeccao['convite_motivo'] == 'Contrato Fechado com outra Empresa') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Contrato Fechado com outra empresa
                                                                        </option>
                                                                        <option value="2" <?php if ($vetor_prospeccao['convite_motivo'] == 'Fora do Perfil de atendimento') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Fora do Perfil de atendimento
                                                                        </option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group"
                                                                          id="convite_empresa_fechado" <?php if ($vetor_prospeccao['convite_viabilidade'] == 'viavel' or $vetor_prospeccao['convite_motivo'] == 'Fora do Perfil de atendimento') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Nome da Empresa</label>
                                                                    <input type="text" name="convite_empresa"
                                                                           value="<?php echo $vetor_prospeccao['convite_empresa']; ?>"
                                                                           class="form-control"
                                                                           placeholder="Nome da Empresa" disabled>
                                                                </fieldset>
                                                            </div>
                                                            <?php if ($vetor_prospeccao['convite_viabilidade'] == 'viavel') { ?>
                                                                <div class="col-lg-2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                            style="float: left;">
                                                                        Gerar Lead
                                                                    </button>
                                                                </div>
                                                            <?php } ?>
                                                        </div><!--.row-->
                                                    <?php } ?>

                                                </form>
                                            </div>
                                            <?php if ($vetor['id_convite'] != 0) { ?>
                                                <div class="tab-pane" id="documentos_convite" role="tabpanel">
                                                    <br>
                                                    <br>

                                                    <a href="cadastroarquivooportunidade.php?id=<?php echo $vetor_lead['id_lead']; ?>&id_turma_lead=<?php echo $vetor['id_turma_lead']; ?>">
                                                        <button type="button" class="btn btn-primary"
                                                                style="    float: left;">
                                                            Cadastrar Arquivo
                                                        </button>
                                                    </a>

                                                    <br>
                                                    <br>
                                                    <br>

                                                    <table id="lang_opt2" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th><strong><h5>Titulo</h5></strong></th>
                                                            <th><strong><h5>Data</h5></strong></th>
                                                            <th><strong><h5>Hora</h5></strong></th>
                                                            <th><strong><h5>Arquivo</h5></strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $sql_arquivos = mysqli_query($con, "select * from arquivos_oportunidade where id_lead = '{$vetor_lead['id_lead']}' order by id_arquivo DESC");
                                                        while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                                <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?></td>
                                                                <td><?php echo substr($vetor_arquivo['hora'], 0, 5); ?></td>
                                                                <td>
                                                                    <a href="arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                                    >
                                                                        <button type="button" class="btn btn-default">
                                                                            Arquivo
                                                                        </button>
                                                                    </a> <a
                                                                            href="excluirarquivooportunidade.php?id=<?php echo $vetor_arquivo['id_arquivo']; ?>&id_turma_lead=<?php echo $vetor['id_turma_lead']; ?>"
                                                                    >
                                                                        <button type="button" class="btn btn-danger">
                                                                            <i class="mdi mdi-window-close"></i>
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="orcamentos_convite" role="tabpanel">
                                                    <br>

                                                    <table id="lang_opt4" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th><strong><h5>Código</h5></strong></th>
                                                            <th><strong><h5>Oportunidade</h5></strong></th>
                                                            <th><strong><h5>Qtd de Formandos</h5></strong></th>
                                                            <th><strong><h5>Data</h5></strong></th>
                                                            <th><strong><h5>Valor</h5></strong></th>
                                                            <th><strong><h5>Status</h5></strong></th>
                                                            <th><strong><h5>Ação</h5></strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $sql_orcamentos = mysqli_query($con, "select * from orcamento_convite where tipo = '1' AND id_oportunidade = '{$id}' order by id_orcamento DESC");
                                                        while ($vetor_orcamento = mysqli_fetch_array($sql_orcamentos)) {
                                                            $sql_oportunidade = mysqli_query($con, "select * from oportunidades where id_oportunidade = '{$id}'");
                                                            $vetor_oportunidade = mysqli_fetch_array($sql_oportunidade);
                                                            $sql_mkt = mysqli_query($con, "select * from prospeccoes where id_prospeccao = '{$vetor_oportunidade['id_prospeccao']}'");
                                                            $vetor_prospeccao = mysqli_fetch_array($sql_mkt);
                                                            $sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '{$vetor_prospeccao['id_turma']}'");
                                                            $vetor_turma = mysqli_fetch_array($sql_turma);
                                                            $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '{$vetor_turma['id_curso']}'");
                                                            $vetor_curso = mysqli_fetch_array($sql_curso);
                                                            $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '{$vetor_curso['id_instituicao']}'");
                                                            $vetor_instituicao = mysqli_fetch_array($sql_instituicao);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $vetor_orcamento['id_orcamento']; ?></td>
                                                                <td><?php echo $id; ?>
                                                                    - <?php echo $vetor_curso['nome']; ?>
                                                                    / <?php echo $vetor_curso['sigla']; ?>
                                                                    / <?php echo $vetor_turma['conclusao']; ?>
                                                                    -<?php echo $vetor_turma['semestre']; ?></td>
                                                                <td><?php echo $vetor_orcamento['qtdformandos']; ?></td>
                                                                <td><?php echo date('d/m/Y', strtotime($vetor_orcamento['data'])); ?></td>
                                                                <td>
                                                                    R$<?php echo $num = number_format($vetor_orcamento['valortotal'], 2, ',', '.'); ?></td>
                                                                <td>
                                                                </td>
                                                                <td>
                                                                    <a href="cadastroorcfotografia_produtos.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>"
                                                                    >
                                                                        <button type="button"
                                                                                class="btn btn-info"
                                                                                title="Ver ou Alterar Cadastro"><i
                                                                                    class="fa fa-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href="confexcluirorcconvite.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger"
                                                                                title="Excluir Cadastro">
                                                                            <i class="mdi mdi-window-close"></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href="imprimirproposta.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>"
                                                                    >
                                                                        <button type="button"
                                                                                class="btn btn-primary"
                                                                                title="Imprimir Cadastro"><i
                                                                                    class="fa fa-print"></i></button>
                                                                    </a>
                                                                    <a href="aprovarproposta.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-success"
                                                                                title="Aprovar Proposta"><i
                                                                                    class="fa fa-thumbs-up"></i>
                                                                        </button>
                                                                    </a></td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <!--                                    ENSAIO-->
                                    <div class="tab-pane" id="ensaio" role="tabpanel">
                                        <br>
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                    href="#dados_ensaio"
                                                                    role="tab"><span class="hidden-sm-up"><i
                                                                class="ti-email"></i></span> <span
                                                            class="hidden-xs-down">Dados</span></a>
                                            </li>
                                            <?php if ($vetor['id_ensaio'] != 0) { ?>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                        href="#documentos_ensaio"
                                                                        role="tab"><span class="hidden-sm-up"><i
                                                                    class="ti-email"></i></span> <span
                                                                class="hidden-xs-down">Documentos</span></a>
                                                </li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                        href="#orcamentos_ensaio"
                                                                        role="tab"><span class="hidden-sm-up"><i
                                                                    class="ti-email"></i></span> <span
                                                                class="hidden-xs-down"
                                                                style="color: red">Orçamentos</span></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content tabcontent-border">
                                            <div class="tab-pane active" id="dados_ensaio" role="tabpanel">
                                                <br>
                                                <form action="<?php if ($vetor_prospeccao['ensaio_viabilidade'] == 'gerado') {
                                                    echo "recebe_alteraroportunidade.php?id=" . $id . "&dados_ensaio=sim";
                                                } else {
                                                    echo "recebe_lead.php?id_oportunidade=" . $id . "&id=" . $vetor['id_prospeccao'];
                                                } ?>"
                                                      method="post">
                                                    <?php
                                                    if ($vetor['id_ensaio'] != 0) {
                                                        $vetor_lead = mysqli_fetch_array(mysqli_query($con, "select * from leads where id_lead = '{$vetor['id_ensaio']}'"));
                                                        $vetor_calendario = mysqli_fetch_array(mysqli_query($con, "select * from calendario where id_calendario = '{$vetor_lead['id_calendario']}'"));
                                                        $sql_usuarios = mysqli_query($con, "select * from usuarios where departamento=1 order by nome ASC");
                                                        $vetor_categoriasCRM = mysqli_fetch_array(mysqli_query($con, "select * from categorias where id_categoria = '{$vetor_lead['id_categoria_crm']}'"));
                                                        $sql_statusCRM = mysqli_query($con, "select * from sub_categorias where id_categoria = '{$vetor_lead['id_categoria_crm']}' order by posicao ASC");
                                                        ?>

                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Representante
                                                                        Comercial</label>
                                                                    <select name="vendedor"
                                                                            class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <option value="">
                                                                            Selecione um colaborador
                                                                        </option>
                                                                        <?php while ($usuarios = mysqli_fetch_array($sql_usuarios)) { ?>
                                                                            <option value="<?php echo $usuarios['id_usuario']; ?>" <?php echo($vetor_lead['id_responsavel'] == $usuarios['id_usuario'] ? 'selected=""' : ''); ?>>
                                                                                <?php echo $usuarios['nome']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Qtde.
                                                                        de
                                                                        Formandos</label>
                                                                    <input type="text" name="num_formandos"
                                                                           value="<?php echo $vetor_lead['num_formandos']; ?>"
                                                                           class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Possibilidade
                                                                        de Venda (R$)</label>
                                                                    <input type="text" name="valor_venda"
                                                                           value="<?php echo $vetor_lead['valor_venda']; ?>"
                                                                           class="form-control valor_venda" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Probabilidade
                                                                        de Fechamento</label>
                                                                    <input type="text" name="probabilidade_fechamento"
                                                                           value="<?php echo substr($vetor_lead['probabilidade_fechamento'], 0, 2); ?>"
                                                                           class="form-control probabilidade_fechamento" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                </fieldset>
                                                            </div>
                                                        </div><!--.row-->
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Categoria
                                                                        CRM</label>
                                                                    <input type="text" name="categoriaCRM"
                                                                           value="<?php echo $vetor_categoriasCRM['nome']; ?>"
                                                                           class="form-control" disabled>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Status
                                                                        CRM</label>
                                                                    <select name="statusCRM"
                                                                            class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <?php while ($status = mysqli_fetch_array($sql_statusCRM)) { ?>
                                                                            <option value="<?php echo $status['id_sub']; ?>" <?php echo($status['id_sub'] == $vetor_lead['id_status'] ? 'selected=""' : ''); ?>>
                                                                                <?php echo $status['nome']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label class="form-label semibold" for="exampleInput">Previsão
                                                                    de Fechamento</label>
                                                                <input type="date" name="data_prevista"
                                                                       value="<?php echo $vetor_calendario['datafim']; ?>"
                                                                       class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                    echo "disabled=''";
                                                                } ?>>
                                                            </div>
                                                        </div><!--.row-->
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Contrato
                                                                        Fechado?</label>
                                                                    <select name="contrato_fechado"
                                                                            class="form-control"
                                                                            id="contrato_fechado_ensaio" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <option value="">Em Aberto</option>
                                                                        <option value="sim" <?php if ($vetor_lead['contrato_fechado'] == 'sim') {
                                                                            echo "selected=''";
                                                                        } ?>>Sim
                                                                        </option>
                                                                        <option value="nao" <?php if ($vetor_lead['contrato_fechado'] == 'nao') {
                                                                            echo "selected=''";
                                                                        } ?>>Não
                                                                        </option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <?php if ($vetor_lead['contrato_fechado'] == null) { ?>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <button type="submit" class="btn btn-success"  id="btn_salvar_convite"
                                                                            style="float: left;">
                                                                        Salvar
                                                                    </button>
                                                                    <button type="submit" class="btn"
                                                                            id="btn_contrato_ensaio"
                                                                            onclick="enviaContrato('ensaio',<?php echo $vetor_lead['id_lead']; ?>)"
                                                                            hidden>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div class="row">

                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Viabilidade
                                                                        de
                                                                        Negócio?</label>
                                                                    <select id="ensaio_viabilidade"
                                                                            name="ensaio_viabilidade"
                                                                            class="form-control" disabled>
                                                                        <option value="1" <?php if ($vetor_prospeccao['ensaio_viabilidade'] == 'viavel') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Sim
                                                                        </option>
                                                                        <option value="2" <?php if ($vetor_prospeccao['ensaio_viabilidade'] == 'inviavel') {
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
                                                                          id="ensaio_qtdalunos" <?php if ($vetor_prospeccao['ensaio_viabilidade'] == 'inviavel') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Quantidade de
                                                                        Formandos</label>
                                                                    <input type="text" name="num_formandos"
                                                                           class="form-control">
                                                                </fieldset>
                                                                <input type="text" name="qual_produto"
                                                                       class="form-control"
                                                                       id="qual_produto"
                                                                       value="ensaio" hidden>
                                                                <fieldset class="form-group"
                                                                          id="ensaio_motivo_fechado" <?php if ($vetor_prospeccao['ensaio_viabilidade'] == 'viavel') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Motivo</label>
                                                                    <select id="ensaio_motivo" name="ensaio_motivo"
                                                                            class="form-control" disabled>
                                                                        <option value="1" <?php if ($vetor_prospeccao['ensaio_motivo'] == 'Contrato Fechado com outra Empresa') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Contrato Fechado com outra empresa
                                                                        </option>
                                                                        <option value="2" <?php if ($vetor_prospeccao['ensaio_motivo'] == 'Fora do Perfil de atendimento') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Fora do Perfil de atendimento
                                                                        </option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group"
                                                                          id="ensaio_empresa_fechado" <?php if ($vetor_prospeccao['ensaio_viabilidade'] == 'viavel' or $vetor_prospeccao['ensaio_motivo'] == 'Fora do Perfil de atendimento') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Nome da Empresa</label>
                                                                    <input type="text" name="ensaio_empresa"
                                                                           value="<?php echo $vetor_prospeccao['ensaio_empresa']; ?>"
                                                                           class="form-control"
                                                                           placeholder="Nome da Empresa" disabled>
                                                                </fieldset>
                                                            </div>
                                                            <?php if ($vetor_prospeccao['ensaio_viabilidade'] == 'viavel') { ?>
                                                                <div class="col-lg-2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                            style="float: left;">
                                                                        Gerar Lead
                                                                    </button>
                                                                </div>
                                                            <?php } ?>
                                                        </div><!--.row-->
                                                    <?php } ?>

                                                </form>
                                            </div>
                                            <?php if ($vetor['id_ensaio'] != 0) { ?>
                                                <div class="tab-pane" id="documentos_ensaio" role="tabpanel">
                                                    <br>
                                                    <br>

                                                    <a href="cadastroarquivooportunidade.php?id=<?php echo $vetor_lead['id_lead']; ?>&id_turma_lead=<?php echo $vetor['id_turma_lead']; ?>">
                                                        <button type="button" class="btn btn-primary"
                                                                style="    float: left;">
                                                            Cadastrar Arquivo
                                                        </button>
                                                    </a>

                                                    <br>
                                                    <br>
                                                    <br>

                                                    <table id="lang_opt2" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th><strong><h5>Titulo</h5></strong></th>
                                                            <th><strong><h5>Data</h5></strong></th>
                                                            <th><strong><h5>Hora</h5></strong></th>
                                                            <th><strong><h5>Arquivo</h5></strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $sql_arquivos = mysqli_query($con, "select * from arquivos_oportunidade where id_lead = '{$vetor_lead['id_lead']}' order by id_arquivo DESC");
                                                        while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                                <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?></td>
                                                                <td><?php echo substr($vetor_arquivo['hora'], 0, 5); ?></td>
                                                                <td>
                                                                    <a href="arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                                    >
                                                                        <button type="button" class="btn btn-default">
                                                                            Arquivo
                                                                        </button>
                                                                    </a> <a
                                                                            href="excluirarquivooportunidade.php?id=<?php echo $vetor_arquivo['id_arquivo']; ?>&id_turma_lead=<?php echo $vetor['id_turma_lead']; ?>"
                                                                    >
                                                                        <button type="button" class="btn btn-danger">
                                                                            <i class="mdi mdi-window-close"></i>
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="orcamentos_ensaio" role="tabpanel">
                                                    <br>

                                                    <table id="lang_opt4" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th><strong><h5>Código</h5></strong></th>
                                                            <th><strong><h5>Oportunidade</h5></strong></th>
                                                            <th><strong><h5>Qtd de Formandos</h5></strong></th>
                                                            <th><strong><h5>Data</h5></strong></th>
                                                            <th><strong><h5>Valor</h5></strong></th>
                                                            <th><strong><h5>Status</h5></strong></th>
                                                            <th><strong><h5>Ação</h5></strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $sql_orcamentos = mysqli_query($con, "select * from orcamento_convite where tipo = '1' AND id_oportunidade = '{$id}' order by id_orcamento DESC");
                                                        while ($vetor_orcamento = mysqli_fetch_array($sql_orcamentos)) {
                                                            $sql_oportunidade = mysqli_query($con, "select * from oportunidades where id_oportunidade = '{$id}'");
                                                            $vetor_oportunidade = mysqli_fetch_array($sql_oportunidade);
                                                            $sql_mkt = mysqli_query($con, "select * from prospeccoes where id_prospeccao = '{$vetor_oportunidade['id_prospeccao']}'");
                                                            $vetor_prospeccao = mysqli_fetch_array($sql_mkt);
                                                            $sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '{$vetor_prospeccao['id_turma']}'");
                                                            $vetor_turma = mysqli_fetch_array($sql_turma);
                                                            $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '{$vetor_turma['id_curso']}'");
                                                            $vetor_curso = mysqli_fetch_array($sql_curso);
                                                            $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '{$vetor_curso['id_instituicao']}'");
                                                            $vetor_instituicao = mysqli_fetch_array($sql_instituicao);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $vetor_orcamento['id_orcamento']; ?></td>
                                                                <td><?php echo $id; ?>
                                                                    - <?php echo $vetor_curso['nome']; ?>
                                                                    / <?php echo $vetor_curso['sigla']; ?>
                                                                    / <?php echo $vetor_turma['conclusao']; ?>
                                                                    -<?php echo $vetor_turma['semestre']; ?></td>
                                                                <td><?php echo $vetor_orcamento['qtdformandos']; ?></td>
                                                                <td><?php echo date('d/m/Y', strtotime($vetor_orcamento['data'])); ?></td>
                                                                <td>
                                                                    R$<?php echo $num = number_format($vetor_orcamento['valortotal'], 2, ',', '.'); ?></td>
                                                                <td>
                                                                </td>
                                                                <td>
                                                                    <a href="cadastroorcfotografia_produtos.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>"
                                                                    >
                                                                        <button type="button"
                                                                                class="btn btn-info"
                                                                                title="Ver ou Alterar Cadastro"><i
                                                                                    class="fa fa-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href="confexcluirorcconvite.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger"
                                                                                title="Excluir Cadastro">
                                                                            <i class="mdi mdi-window-close"></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href="imprimirproposta.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>"
                                                                    >
                                                                        <button type="button"
                                                                                class="btn btn-primary"
                                                                                title="Imprimir Cadastro"><i
                                                                                    class="fa fa-print"></i></button>
                                                                    </a>
                                                                    <a href="aprovarproposta.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-success"
                                                                                title="Aprovar Proposta"><i
                                                                                    class="fa fa-thumbs-up"></i>
                                                                        </button>
                                                                    </a></td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <!--                                    PLACA-->
                                    <div class="tab-pane" id="placa" role="tabpanel">
                                        <br>
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                    href="#dados_placa"
                                                                    role="tab"><span class="hidden-sm-up"><i
                                                                class="ti-email"></i></span> <span
                                                            class="hidden-xs-down">Dados</span></a>
                                            </li>
                                            <?php if ($vetor['id_placa'] != 0) { ?>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                        href="#documentos_placa"
                                                                        role="tab"><span class="hidden-sm-up"><i
                                                                    class="ti-email"></i></span> <span
                                                                class="hidden-xs-down">Documentos</span></a>
                                                </li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                        href="#orcamentos_placa"
                                                                        role="tab"><span class="hidden-sm-up"><i
                                                                    class="ti-email"></i></span> <span
                                                                class="hidden-xs-down"
                                                                style="color: red">Orçamentos</span></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content tabcontent-border">
                                            <div class="tab-pane active" id="dados_placa" role="tabpanel">
                                                <br>
                                                <form action="<?php if ($vetor_prospeccao['placa_viabilidade'] == 'gerado') {
                                                    echo "recebe_alteraroportunidade.php?id=" . $id . "&dados_placa=sim";
                                                } else {
                                                    echo "recebe_lead.php?id_oportunidade=" . $id . "&id=" . $vetor['id_prospeccao'];
                                                } ?>"
                                                      method="post">
                                                    <?php
                                                    if ($vetor['id_placa'] != 0) {
                                                        $vetor_lead = mysqli_fetch_array(mysqli_query($con, "select * from leads where id_lead = '{$vetor['id_placa']}'"));
                                                        $vetor_calendario = mysqli_fetch_array(mysqli_query($con, "select * from calendario where id_calendario = '{$vetor_lead['id_calendario']}'"));
                                                        $sql_usuarios = mysqli_query($con, "select * from usuarios where departamento=1 order by nome ASC");
                                                        $vetor_categoriasCRM = mysqli_fetch_array(mysqli_query($con, "select * from categorias where id_categoria = '{$vetor_lead['id_categoria_crm']}'"));
                                                        $sql_statusCRM = mysqli_query($con, "select * from sub_categorias where id_categoria = '{$vetor_lead['id_categoria_crm']}' order by posicao ASC");
                                                        ?>

                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Representante
                                                                        Comercial</label>
                                                                    <select name="vendedor"
                                                                            class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <option value="">
                                                                            Selecione um colaborador
                                                                        </option>
                                                                        <?php while ($usuarios = mysqli_fetch_array($sql_usuarios)) { ?>
                                                                            <option value="<?php echo $usuarios['id_usuario']; ?>" <?php echo($vetor_lead['id_responsavel'] == $usuarios['id_usuario'] ? 'selected=""' : ''); ?>>
                                                                                <?php echo $usuarios['nome']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Qtde.
                                                                        de
                                                                        Formandos</label>
                                                                    <input type="text" name="num_formandos"
                                                                           value="<?php echo $vetor_lead['num_formandos']; ?>"
                                                                           class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Possibilidade
                                                                        de Venda (R$)</label>
                                                                    <input type="text" name="valor_venda"
                                                                           value="<?php echo $vetor_lead['valor_venda']; ?>"
                                                                           class="form-control valor_venda" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Probabilidade
                                                                        de Fechamento</label>
                                                                    <input type="text" name="probabilidade_fechamento"
                                                                           value="<?php echo substr($vetor_lead['probabilidade_fechamento'], 0, 2); ?>"
                                                                           class="form-control probabilidade_fechamento" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                </fieldset>
                                                            </div>
                                                        </div><!--.row-->
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Categoria
                                                                        CRM</label>
                                                                    <input type="text" name="categoriaCRM"
                                                                           value="<?php echo $vetor_categoriasCRM['nome']; ?>"
                                                                           class="form-control" disabled>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Status
                                                                        CRM</label>
                                                                    <select name="statusCRM"
                                                                            class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <?php while ($status = mysqli_fetch_array($sql_statusCRM)) { ?>
                                                                            <option value="<?php echo $status['id_sub']; ?>" <?php echo($status['id_sub'] == $vetor_lead['id_status'] ? 'selected=""' : ''); ?>>
                                                                                <?php echo $status['nome']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label class="form-label semibold" for="exampleInput">Previsão
                                                                    de Fechamento</label>
                                                                <input type="date" name="data_prevista"
                                                                       value="<?php echo $vetor_calendario['datafim']; ?>"
                                                                       class="form-control" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                    echo "disabled=''";
                                                                } ?>>
                                                            </div>
                                                        </div><!--.row-->
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Contrato
                                                                        Fechado?</label>
                                                                    <select name="contrato_fechado"
                                                                            class="form-control"
                                                                            id="contrato_fechado_placa" <?php if ($vetor_lead['contrato_fechado'] != null) {
                                                                        echo "disabled=''";
                                                                    } ?>>
                                                                        <option value="">Em Aberto</option>
                                                                        <option value="sim" <?php if ($vetor_lead['contrato_fechado'] == 'sim') {
                                                                            echo "selected=''";
                                                                        } ?>>Sim
                                                                        </option>
                                                                        <option value="nao" <?php if ($vetor_lead['contrato_fechado'] == 'nao') {
                                                                            echo "selected=''";
                                                                        } ?>>Não
                                                                        </option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <?php if ($vetor_lead['contrato_fechado'] == null) { ?>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <button type="submit" class="btn btn-success"  id="btn_salvar_convite"
                                                                            style="float: left;">
                                                                        Salvar
                                                                    </button>
                                                                    <button type="submit" class="btn"
                                                                            id="btn_contrato_placa"
                                                                            onclick="enviaContrato('placa',<?php echo $vetor_lead['id_lead']; ?>)"
                                                                            hidden>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div class="row">

                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Viabilidade
                                                                        de
                                                                        Negócio?</label>
                                                                    <select id="placa_viabilidade"
                                                                            name="placa_viabilidade"
                                                                            class="form-control" disabled>
                                                                        <option value="1" <?php if ($vetor_prospeccao['placa_viabilidade'] == 'viavel') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Sim
                                                                        </option>
                                                                        <option value="2" <?php if ($vetor_prospeccao['placa_viabilidade'] == 'inviavel') {
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
                                                                          id="placa_qtdalunos" <?php if ($vetor_prospeccao['placa_viabilidade'] == 'inviavel') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Quantidade de
                                                                        Formandos</label>
                                                                    <input type="text" name="num_formandos"
                                                                           class="form-control">
                                                                </fieldset>
                                                                <input type="text" name="qual_produto"
                                                                       class="form-control"
                                                                       id="qual_produto"
                                                                       value="placa" hidden>
                                                                <fieldset class="form-group"
                                                                          id="placa_motivo_fechado" <?php if ($vetor_prospeccao['placa_viabilidade'] == 'viavel') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Motivo</label>
                                                                    <select id="placa_motivo" name="placa_motivo"
                                                                            class="form-control" disabled>
                                                                        <option value="1" <?php if ($vetor_prospeccao['placa_motivo'] == 'Contrato Fechado com outra Empresa') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Contrato Fechado com outra empresa
                                                                        </option>
                                                                        <option value="2" <?php if ($vetor_prospeccao['placa_motivo'] == 'Fora do Perfil de atendimento') {
                                                                            echo "selected=''";
                                                                        } ?>>
                                                                            Fora do Perfil de atendimento
                                                                        </option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group"
                                                                          id="placa_empresa_fechado" <?php if ($vetor_prospeccao['placa_viabilidade'] == 'viavel' or $vetor_prospeccao['placa_motivo'] == 'Fora do Perfil de atendimento') {
                                                                    echo "hidden";
                                                                } ?>>
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Nome da Empresa</label>
                                                                    <input type="text" name="placa_empresa"
                                                                           value="<?php echo $vetor_prospeccao['placa_empresa']; ?>"
                                                                           class="form-control"
                                                                           placeholder="Nome da Empresa" disabled>
                                                                </fieldset>
                                                            </div>
                                                            <?php if ($vetor_prospeccao['placa_viabilidade'] == 'viavel') { ?>
                                                                <div class="col-lg-2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                            style="float: left;">
                                                                        Gerar Lead
                                                                    </button>
                                                                </div>
                                                            <?php } ?>
                                                        </div><!--.row-->
                                                    <?php } ?>

                                                </form>
                                            </div>
                                            <?php if ($vetor['id_placa'] != 0) { ?>
                                                <div class="tab-pane" id="documentos_placa" role="tabpanel">
                                                    <br>
                                                    <br>

                                                    <a href="cadastroarquivooportunidade.php?id=<?php echo $vetor_lead['id_lead']; ?>&id_turma_lead=<?php echo $vetor['id_turma_lead']; ?>">
                                                        <button type="button" class="btn btn-primary"
                                                                style="    float: left;">
                                                            Cadastrar Arquivo
                                                        </button>
                                                    </a>

                                                    <br>
                                                    <br>
                                                    <br>

                                                    <table id="lang_opt2" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th><strong><h5>Titulo</h5></strong></th>
                                                            <th><strong><h5>Data</h5></strong></th>
                                                            <th><strong><h5>Hora</h5></strong></th>
                                                            <th><strong><h5>Arquivo</h5></strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $sql_arquivos = mysqli_query($con, "select * from arquivos_oportunidade where id_lead = '{$vetor_lead['id_lead']}' order by id_arquivo DESC");
                                                        while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                                <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?></td>
                                                                <td><?php echo substr($vetor_arquivo['hora'], 0, 5); ?></td>
                                                                <td>
                                                                    <a href="arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                                    >
                                                                        <button type="button" class="btn btn-default">
                                                                            Arquivo
                                                                        </button>
                                                                    </a> <a
                                                                            href="excluirarquivooportunidade.php?id=<?php echo $vetor_arquivo['id_arquivo']; ?>&id_turma_lead=<?php echo $vetor['id_turma_lead']; ?>"
                                                                    >
                                                                        <button type="button" class="btn btn-danger">
                                                                            <i class="mdi mdi-window-close"></i>
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="orcamentos_placa" role="tabpanel">
                                                    <br>

                                                    <table id="lang_opt4" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th><strong><h5>Código</h5></strong></th>
                                                            <th><strong><h5>Oportunidade</h5></strong></th>
                                                            <th><strong><h5>Qtd de Formandos</h5></strong></th>
                                                            <th><strong><h5>Data</h5></strong></th>
                                                            <th><strong><h5>Valor</h5></strong></th>
                                                            <th><strong><h5>Status</h5></strong></th>
                                                            <th><strong><h5>Ação</h5></strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $sql_orcamentos = mysqli_query($con, "select * from orcamento_placa where tipo = '1' AND id_oportunidade = '{$id}' order by id_orcamento DESC");
                                                        while ($vetor_orcamento = mysqli_fetch_array($sql_orcamentos)) {
                                                            $sql_oportunidade = mysqli_query($con, "select * from oportunidades where id_oportunidade = '{$id}'");
                                                            $vetor_oportunidade = mysqli_fetch_array($sql_oportunidade);
                                                            $sql_mkt = mysqli_query($con, "select * from prospeccoes where id_prospeccao = '{$vetor_oportunidade['id_prospeccao']}'");
                                                            $vetor_prospeccao = mysqli_fetch_array($sql_mkt);
                                                            $sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '{$vetor_prospeccao['id_turma']}'");
                                                            $vetor_turma = mysqli_fetch_array($sql_turma);
                                                            $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '{$vetor_turma['id_curso']}'");
                                                            $vetor_curso = mysqli_fetch_array($sql_curso);
                                                            $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '{$vetor_curso['id_instituicao']}'");
                                                            $vetor_instituicao = mysqli_fetch_array($sql_instituicao);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $vetor_orcamento['id_orcamento']; ?></td>
                                                                <td><?php echo $id; ?>
                                                                    - <?php echo $vetor_curso['nome']; ?>
                                                                    / <?php echo $vetor_curso['sigla']; ?>
                                                                    / <?php echo $vetor_turma['conclusao']; ?>
                                                                    -<?php echo $vetor_turma['semestre']; ?></td>
                                                                <td><?php echo $vetor_orcamento['qtdformandos']; ?></td>
                                                                <td><?php echo date('d/m/Y', strtotime($vetor_orcamento['data'])); ?></td>
                                                                <td>
                                                                    R$<?php echo $num = number_format($vetor_orcamento['valortotal'], 2, ',', '.'); ?></td>
                                                                <td>
                                                                </td>
                                                                <td>
                                                                    <a href="cadastroorcfotografia_produtos.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>"
                                                                    >
                                                                        <button type="button"
                                                                                class="btn btn-info"
                                                                                title="Ver ou Alterar Cadastro"><i
                                                                                    class="fa fa-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href="confexcluirorcplaca.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger"
                                                                                title="Excluir Cadastro">
                                                                            <i class="mdi mdi-window-close"></i>
                                                                        </button>
                                                                    </a>
                                                                    <a href="imprimirproposta.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>"
                                                                    >
                                                                        <button type="button"
                                                                                class="btn btn-primary"
                                                                                title="Imprimir Cadastro"><i
                                                                                    class="fa fa-print"></i></button>
                                                                    </a>
                                                                    <a href="aprovarproposta.php?id=<?php echo $vetor_orcamento['id_orcamento']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-success"
                                                                                title="Aprovar Proposta"><i
                                                                                    class="fa fa-thumbs-up"></i>
                                                                        </button>
                                                                    </a></td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>


                                    <!--                                    INTERACOES-->
                                    <div class="tab-pane" id="interacoes" role="tabpanel">
                                        <br>
                                        <br>
                                        <a href="cadastro_interacao.php?id=<?php echo $id; ?>&oportunidade=sim"
                                        >
                                            <button type="button" class="btn btn-primary" style="float: left;">
                                                Cadastrar Interação
                                            </button>
                                        </a>

                                        <br>
                                        <br>
                                        <div class="table-responsive">
                                            <table id="lang_opt" class="table table-bordered table-striped"
                                                   style="width: 100%">
                                                <thead align="center">
                                                <tr>
                                                    <th width="6%"><strong><h4>Data</h4></strong></th>
                                                    <th width="6%"><strong><h4>Hora</h4></strong></th>
                                                    <th width="8%"><strong><h4>Meio</h4></strong></th>
                                                    <th width="10%"><strong><h4>Assunto</h4></strong></th>
                                                    <th width="80%"><strong><h4>Ocorrência</h4></strong></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $sql_interacoes = mysqli_query($con, "select * from interacao_oportunidade where id_oportunidade = '{$id}' order by id_interacao DESC");
                                                while ($vetor_interacao = mysqli_fetch_array($sql_interacoes)) {
                                                    ?>
                                                    <tr>
                                                        <td align="center"><?php echo date('d/m/Y', strtotime($vetor_interacao['data'])); ?></td>
                                                        <td align="center"><?php echo substr($vetor_interacao['hora'], 0, 5); ?></td>
                                                        <td><?php echo $vetor_interacao['tipo']; ?></td>
                                                        <td><?php echo $vetor_interacao['assunto']; ?></td>
                                                        <td><?php echo $vetor_interacao['ocorrencia']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <!--                                    CONTATOS-->
                                    <div class="tab-pane" id="contatos" role="tabpanel">

                                        <br>
                                        <br>

                                        <a href="cadastro_contato.php?id=<?php echo $id; ?>&oportunidade=sim">
                                            <button type="button" class="btn btn-primary" style="    float: left;">
                                                Cadastrar Contato
                                            </button>
                                        </a>

                                        <br>
                                        <br>
                                        <br>

                                        <table id="lang_opt2" class="table table-bordered table-striped">
                                            <thead align="center">
                                            <tr>
                                                <th><strong><h4>Nome</h4></strong></th>
                                                <th><strong><h4>Telefone</h4></strong></th>
                                                <th><strong><h4>E-mail</h4></strong></th>
                                                <th><strong><h4>Comissão</h4></strong></th>
                                                <th><strong><h4>Ação</h4></strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql_contatos = mysqli_query($con, "select * from contatos_oportunidade where id_oportunidade = '{$id}' order by nome ASC");
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
                                                        if ($vetor_contato['comissao'] == '2') { ?>
                                                            <button type="button"
                                                                    class="btn btn-block btn-danger btn-sm">Comissão
                                                            </button><?php } ?></td>
                                                    <td>
                                                        <a href="alterarcontatooportunidade.php?id=<?php echo $vetor_contato['id_contato']; ?>&id1=<?php echo $id; ?>"
                                                        >
                                                            <button type="button" class="btn btn-info mesmo-tamanho"
                                                                    title="Ver ou Alterar Cadastro"><i
                                                                        class="fa fa-edit"></i>
                                                            </button>
                                                        </a> <a
                                                                href="excluircontatooportunidade.php?id=<?php echo $vetor_contato['id_contato']; ?>&id1=<?php echo $id; ?>"
                                                        >
                                                            <button type="button" class="btn btn-danger">Excluir
                                                            </button>
                                                        </a>
                                                    </td>
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

            <div class="modal fade" id="modal-default">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title">Anexos</h5>
                        </div>
                        <div class="modal-body">
                            <p>Carregando...</p>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
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