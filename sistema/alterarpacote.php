<?php

include "../includes/conexao.php";

session_start();

if ($_SESSION['id'] == NULL) {

    echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";

} else {

    $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);

    $id = $_GET['id'];

    $sql = mysqli_query($con, "select * from pacotes where id_pacote = '$id'");
    $vetor = mysqli_fetch_array($sql);

    $id_pagina = 51;

    $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
    $vetor_permissao = mysqli_fetch_array($sql_permissao);

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

        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        <script type="text/javascript">
            function arrumaModal(id) {
                $('#confirmaExcluir').modal('show');
                $('#pacoteExcluir').val(id);
            }
            $(document).ready(function () {
                $('#confirmouExclusao').click(function () {
                    $.ajax({
                        url: 'excluirprodutopacotealbum.php?id=' + $('#pacoteExcluir').val(),
                        type: "POST",
                        success: function (rep) {
                            if (rep == 'OK') {
                                alert('Excluido com Sucesso');
                                window.location.reload(true);
                            } else {
                                alert('Erro na Modificação do banco de dados');
                            }
                        }
                    });
                });
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
                                    <li class="breadcrumb-item">Vendas</a></li>
                                    <li class="breadcrumb-item">Fotografia</a></li>
                                    <li class="breadcrumb-item">Pré</a></li>
                                    <li class="breadcrumb-item">Produtos Álbum</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Alterar Produto</li>
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
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Dados do Produto</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pacotes"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Pacotes</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#imagens_produtos"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Imagens dos Produtos</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#imagens_eventos"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Imagens dos Eventos</span></a>
                                    </li>

                                </ul>

                                <div class="tab-content tabcontent-border">
                                    <div id="confirmaExcluir" class="modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Exclusão de Pacote</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Você tem certeza que deseja excluir o pacote?</p>
                                                </div>
                                                <input type="text" id="pacoteExcluir" hidden>
                                                <div class="modal-footer">
                                                    <button id="confirmouExclusao" type="button"
                                                            class="btn btn-danger" data-dismiss="modal">Excluir Pacote
                                                    </button>
                                                    <button type="button" class="btn btn-success"
                                                            data-dismiss="modal">Voltar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane active" id="dados" role="tabpanel">

                                        <br>
                                        <br>

                                        <form action="recebe_alterarpacote.php?id=<?php echo $id; ?>" method="post"
                                              name="cliente" enctype="multipart/form-data"
                                              onSubmit="return verificarCPF()" id="formID">

                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Contrato</label>
                                                        <select name="id_turma" class="form-control">
                                                            <option value="" selected="selected">Selecione...</option>
                                                            <?php

                                                            $sql_cursos = mysqli_query($con, "select * from turmas order by nome ASC");

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

                                            </div>

                                            <div class="row">

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Data de
                                                            Abertura da Venda</label>
                                                        <input type="date" name="dataabertura"
                                                               value="<?php echo $vetor['dataabertura']; ?>"
                                                               class="form-control" required="">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Data de
                                                            Encerramento da Venda</label>
                                                        <input type="date" name="termino"
                                                               value="<?php echo $vetor['termino']; ?>"
                                                               class="form-control" id="exampleInput" required="">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Mês da
                                                            Formatura</label>
                                                        <input type="month" name="dataentrega"
                                                               value="<?php echo substr($vetor['dataentrega'],0,7); ?>"
                                                               class="form-control" id="exampleInput" required="">
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Desconto a
                                                            vista (%)</label>
                                                        <input type="text" name="desconto"
                                                               value="<?php echo $vetor['desconto']; ?>"
                                                               class="form-control" id="exampleInput"
                                                               placeholder="Valor Desconto" required="">
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div class="row">

                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Tipo de Contrato</label>
                                                    <select name="tipocontrato" id="tipocontrato" class="form-control" required="">
                                                        <option value="" selected="">Selecione...</option>
                                                        <option value="1" <?php if (strcasecmp($vetor['tipoContrato'], '1') == 0) : ?>selected="selected"<?php endif; ?>>Contrato Antigo</option>
                                                        <option value="2" <?php if (strcasecmp($vetor['tipoContrato'], '2') == 0) : ?>selected="selected"<?php endif; ?>>Taxa - Ensaio Foto de Convite </option>
                                                        <option value="3" <?php if (strcasecmp($vetor['tipoContrato'], '3') == 0) : ?>selected="selected"<?php endif; ?>>Páginas - Ensaio Foto de Convite </option>
                                                        <option value="4" <?php if (strcasecmp($vetor['tipoContrato'], '4') == 0) : ?>selected="selected"<?php endif; ?>>Arquivo Digital - Ensaio Foto de Convite </option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-6" id="hidden_div" <?php  if ($vetor['valorContrato']>0) {
                                                # code...
                                            }else {
                                                # code...
                                            ?> style="display: none;" <?php }?>>
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="">Valor</label>
                                                    <input type="text" name="valorcontrato" class="form-control" value="<?php echo $vetor['valorContrato']; ?>"
                                                        id="valorcontrato">
                                                </fieldset>
                                            </div>
                                        </div>

                                            <div class="row">

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Documento?</label>
                                                        <br>
                                                        <a href="arquivos/<?php echo $vetor['arquivo']; ?>"
                                                           target="_blank">
                                                            <button type="button" class="btn btn-primary mesmo-tamanho"
                                                                    title="Visualizar Documento"><i
                                                                        class="fa fa-print"></i></button>
                                                        </a> Alterar Documento?
                                                        <input type="file" name="arquivo" class="form-control"
                                                               id="exampleInput">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Tipo
                                                            Pagamento</label>
                                                        <select name="tipopagamento" class="form-control" required="">
                                                            <option value="" selected="">Selecione...</option>
                                                            <option value="1"
                                                                    <?php if (strcasecmp($vetor['tipopagamento'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Santander
                                                            </option>
                                                            <option value="2"
                                                                    <?php if (strcasecmp($vetor['tipopagamento'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Outros
                                                            </option>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Tipo
                                                            Pagamento Cartão</label>
                                                        <select name="tipopagamentocartao" class="form-control"
                                                                required="">
                                                            <option value="" selected="">Selecione...</option>
                                                            <option value="1"
                                                                    <?php if (strcasecmp($vetor['tipopagamentocartao'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Santander
                                                            </option>
                                                            <option value="2"
                                                                    <?php if (strcasecmp($vetor['tipopagamentocartao'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Outros
                                                            </option>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                            </div>


                                            <?php if ($vetor_permissao['alteracao'] == 1) {
                                            } else { ?>
                                                <button type="submit" class="btn btn-primary" style="    float: left;">
                                                    Salvar
                                                </button><?php } ?>

                                        </form>

                                    </div>

                                    <div class="tab-pane" id="pacotes" role="tabpanel">

                                        <br>
                                        <br>

                                        <a href="cadastroitempacote.php?id=<?php echo $id; ?>">
                                            <button class="btn btn-primary" style="    float: left;">Novo
                                                Pacote
                                            </button>
                                        </a>
                                        <br>
                                        <br>
                                        <br>
                                        <table id="lang_opt2" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Pacote</th>
                                                <th>Valor</th>
                                                <th width="13%">Ação</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            $sql_pacotes = mysqli_query($con, "select * from pacotes_itens_album WHERE id_pacote = '$id' order by titulo ASC");

                                            while ($vetor_pacote = mysqli_fetch_array($sql_pacotes)) {

                                                ?>
                                                <tr>
                                                    <td><?php echo $vetor_pacote['titulo']; ?></td>
                                                    <td><?php echo $num = number_format($vetor_pacote['valor'], 2, ',', '.'); ?></td>
                                                    <td>
                                                        <a href="alterarprodutopacotealbum.php?id=<?php echo $vetor_pacote['id_item']; ?>&id1=<?php echo $id; ?>"
                                                           target="_blank">
                                                            <button type="button" class="btn btn-info mesmo-tamanho"
                                                                    title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i>
                                                            </button>
                                                        </a> <?php if ($vetor_permissao['exclusao'] == 1) {
                                                        } else { ?>
                                                                <button type="button"
                                                                        class="btn btn-danger mesmo-tamanho"
                                                                        onclick="arrumaModal(<?php echo $vetor_pacote['id_item']; ?>)"
                                                                        title="Excluir Cadastro"><i class="mdi mdi-window-close"></i></button>
                                                                <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="tab-pane" id="imagens_produtos" role="tabpanel">

                                        <br
                                        <br>
                                        <div class="table-responsive">
                                            <table id="lang_opt2" class="table table-striped table-bordered display"
                                                   style="width:100%">
                                                <thead align="center">
                                                <tr>
                                                    <th><h5><strong>Nome Produto</strong></h5></th>
                                                    <th><h5><strong>Foto Especifica?</strong></h5></th>
                                                    <th width="13%"><h5><strong>Ação</strong></h5></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php

                                                $sql_itens_produtos = mysqli_query($con, "select pid.id_produto,pid.chave_imagem,pid.id_pacote from pacotes_itens_produtos pid  WHERE id_pacote in (select id_item from pacotes_itens_album where id_pacote = '$id')  GROUP by pid.id_produto ");
                                                $lock = 0;
                                                while ($produtos = mysqli_fetch_array($sql_itens_produtos)) {
                                                    $tipo_produto = mysqli_fetch_array(mysqli_query($con, "select * from tipo_opcionais where id_tipo = '$produtos[id_produto]'"));
                                                    if ($produtos['chave_imagem'] == null) {
                                                        $chave_imagem = $tipo_produto['chave_imagem'];
                                                        $imagem_especifica = 'Não';
                                                        $lock = 1;
                                                    } else {
                                                        $chave_imagem = $produtos['chave_imagem'];
                                                        $imagem_especifica = 'Sim';
                                                        $lock = 2;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $tipo_produto['nome']; ?>
                                                        </td>
                                                        <td align="center"><?php echo $imagem_especifica ?></td>
                                                        <td align="center">
                                                            <a href="alterarimagemproduto.php?id_pacote=<?php echo $id; ?>&id=<?php echo $produtos['id_pacote']; ?>&id_produto=<?php echo $produtos['id_produto']; ?>"
                                                               target="_blank">
                                                                <button type="button" class="btn btn-info"
                                                                        title="Editar Imagens"><i class="fa fa-edit"></i>
                                                                </button>
                                                            </a>
                                                            <a href="recebe_imagemproduto.php?id_pacote=<?php echo $id; ?>&id=<?php echo $produtos['id_pacote']; ?>&id_produto=<?php echo $produtos['id_produto']; ?>&remove=sim">
                                                                <button type="button"
                                                                        class="btn btn-danger"
                                                                        title="Excluir Cadastro"><i class="mdi mdi-window-close"></i></button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                    <div class="tab-pane" id="imagens_eventos" role="tabpanel">

                                        <br
                                        <br>
                                        <div class="table-responsive">
                                            <table id="lang_opt2" class="table table-striped table-bordered display"
                                                   style="width:100%">
                                                <thead align="center">
                                                <tr>
                                                    <th><h5><strong>Nome Evento</strong></h5></th>
                                                    <th><h5><strong>Foto Especifica?</strong></h5></th>
                                                    <th width="13%"><h5><strong>Ação</strong></h5></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php

                                                $sql_itens_eventos = mysqli_query($con, "select e.id_evento,e.chave_imagem,e.id_pacote from eventos_pacote e  WHERE id_pacote in (select id_item from pacotes_itens_album where id_pacote = '$id')  GROUP by e.id_evento ");
                                                $lock = 0;
                                                while ($eventos = mysqli_fetch_array($sql_itens_eventos)) {
                                                    $eventos_turma_lista = mysqli_fetch_array(mysqli_query($con, "select * from eventos_turma_lista where id_evento_turma = '$eventos[id_evento]'"));
                                                    $categoria_eventos = mysqli_fetch_array(mysqli_query($con, "select * from categoriaevento where id_categoria = '$eventos_turma_lista[id_evento]'"));
                                                    if ($eventos['chave_imagem'] == null) {
                                                        $chave_imagem = $categoria_eventos['chave_imagem'];
                                                        $imagem_especifica = 'Não';
                                                        $lock = 1;
                                                    } else {
                                                        $chave_imagem = $eventos['chave_imagem'];
                                                        $imagem_especifica = 'Sim';
                                                        $lock = 2;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $categoria_eventos['nome']; ?>
                                                        </td>
                                                        <td align="center"><?php echo $imagem_especifica ?></td>
                                                        <td align="center">
                                                            <a href="alterarimagemevento.php?id_pacote=<?php echo $id; ?>&id=<?php echo $eventos['id_pacote']; ?>&id_evento=<?php echo $eventos['id_evento']; ?>"
                                                               target="_blank">
                                                                <button type="button" class="btn btn-info"
                                                                        title="Editar Imagens"><i class="fa fa-edit"></i>
                                                                </button>
                                                            </a>
                                                            <a href="recebe_imagemproduto.php?id_pacote=<?php echo $id; ?>&id=<?php echo $eventos['id_pacote']; ?>&id_evento=<?php echo $eventos['id_evento']; ?>&remove=sim">
                                                                <button type="button"
                                                                        class="btn btn-danger"
                                                                        title="Excluir Cadastro">
                                                                    <i class="mdi mdi-window-close"></i>
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
        window.onload=function(){
        document.getElementById('tipocontrato').addEventListener('change', function () {
            var style = (this.value == '2')||(this.value == '3') ? 'block' : 'none';
            document.getElementById('hidden_div').style.display = style;
            
           
        });
        }
    </script>
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