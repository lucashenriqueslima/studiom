<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$id = $_GET['id'];
	$sql = mysqli_query($con, "select * from turmas where id_turma = '$id'");
	$vetor = mysqli_fetch_array($sql);
	$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor[id_instituicao]'");
	$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
	$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor[curso]'");
	$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
	$id_pagina = 4;
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

            $(document).ready(function () {
                var activeTab = location.hash;
                if (activeTab != "") {
                    var splitted = activeTab.split('#');
                    $('.nav-link[href="#' + splitted[1] + '"]').click();
                    $('.nav-link[href="#' + splitted[2] + '"]').click();
                }

                function limpa_formulário_cep() {
                    // Limpa valores do formulário de cep.
                    $("#rua").val("");
                    $("#bairro").val("");
                    $("#cidade").val("");
                    $("#uf").val("");
                    $("#ibge").val("");
                }

                //Quando o campo cep perde o foco.
                $("#cep").blur(function () {

                    //Nova variável "cep" somente com dígitos.
                    var cep = $(this).val().replace(/\D/g, '');

                    //Verifica se campo cep possui valor informado.
                    if (cep != "") {

                        //Expressão regular para validar o CEP.
                        var validacep = /^[0-9]{8}$/;

                        //Valida o formato do CEP.
                        if (validacep.test(cep)) {

                            //Preenche os campos com "..." enquanto consulta webservice.
                            $("#rua").val("...")
                            $("#bairro").val("...")
                            $("#cidade").val("...")
                            $("#uf").val("...")
                            $("#ibge").val("...")

                            //Consulta o webservice viacep.com.br/
                            $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                                if (!("erro" in dados)) {
                                    //Atualiza os campos com os valores da consulta.
                                    $("#rua").val(dados.logradouro);
                                    $("#bairro").val(dados.bairro);
                                    $("#cidade").val(dados.localidade);
                                    $("#uf").val(dados.uf);
                                    $("#ibge").val(dados.ibge);
                                } //end if.
                                else {
                                    //CEP pesquisado não foi encontrado.
                                    limpa_formulário_cep();
                                    alert("CEP não encontrado.");
                                }
                            });
                        } //end if.
                        else {
                            //cep é inválido.
                            limpa_formulário_cep();
                            alert("Formato de CEP inválido.");
                        }
                    } //end if.
                    else {
                        //cep sem valor, limpa formulário.
                        limpa_formulário_cep();
                    }
                });
            });

        </script>
        <script type="text/javascript">
            /* MÃ¡scaras ER */
            function mascara(o, f) {
                v_obj = o
                v_fun = f
                setTimeout("execmascara()", 1)
            }

            function execmascara() {
                v_obj.value = v_fun(v_obj.value)
            }

            function mtel(v) {
                v = v.replace(/\D/g, "");             //Remove tudo o que nÃ£o Ã© dÃ­gito
                v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
                v = v.replace(/(\d)(\d{4})$/, "$1-$2");    //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
                return v;
            }

            function id(el) {
                return document.getElementById(el);
            }

            window.onload = function () {
                id('telefone').onkeypress = function () {
                    mascara(this, mtel);
                }
                id('telefone2').onkeypress = function () {
                    mascara(this, mtel);
                }
            }

            $(document).ready(function () {
                $("#palco > div").hide();
                $("#produto").change(function () {
                    $("#palco > div").hide();
                    $('#' + $(this).val()).show('fast');
                });
                $("#palco1 > div").hide();
                $("#tipobusca").change(function () {
                    $("#palco1 > div").hide();
                    $('#' + $(this).val()).show('fast');
                });
                $("#palco2 > div").hide();
                $("#tipobusca1").change(function () {
                    $("#palco2 > div").hide();
                    $('#' + $(this).val()).show('fast');
                });
                $("#palco3 > div").hide();
                $("#tipobusca2").change(function () {
                    $("#palco3 > div").hide();
                    $('#' + $(this).val()).show('fast');
                });
                $("input[name='rd-sexo']").click(function () {
                    $("#palco > div").hide();
                    $('#' + $(this).val()).show('fast');
                });
            });

            function duplicarCampos() {
                var clone = document.getElementById('origem').cloneNode(true);
                var destino = document.getElementById('destino');
                destino.appendChild(clone);
                var camposClonados = clone.getElementsByTagName('input');
                for (i = 0; i < camposClonados.length; i++) {
                    camposClonados[i].value = '';
                }
            }

            function removerCampos(id) {
                var node1 = document.getElementById('destino');
                node1.removeChild(node1.childNodes[0]);
            }

            function duplicarCampos1() {
                var clone1 = document.getElementById('origem1').cloneNode(true);
                var destino1 = document.getElementById('destino1');
                destino1.appendChild(clone1);
                var camposClonados1 = clone1.getElementsByTagName('input');
                for (i = 0; i < camposClonados1.length; i++) {
                    camposClonados1[i].value = '';
                }
            }

            function removerCampos1(id) {
                var node1 = document.getElementById('destino1');
                node1.removeChild(node1.childNodes[0]);
            }

            function duplicarCampos2() {
                var clone2 = document.getElementById('origem2').cloneNode(true);
                var destino2 = document.getElementById('destino2');
                destino2.appendChild(clone2);
                var camposClonados2 = clone2.getElementsByTagName('input');
                for (i = 0; i < camposClonados2.length; i++) {
                    camposClonados2[i].value = '';
                }
            }

            function removerCampos2(id) {
                var node2 = document.getElementById('destino2');
                node2.removeChild(node2.childNodes[0]);
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
                        <h4 class="page-title">Administrativo</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Contratos</li>
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
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Dados do Contrato</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fotografia"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Fotografia</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#convite"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Convite</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ensaio"
                                                            role="tab"><span class="hidden-sm-up" style="color: red"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down" style="color: red">Ensaio</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#placa"
                                                            role="tab"><span class="hidden-sm-up" style="color: red"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down" style="color: red">Placa</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#interacao"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Interação</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#formandos"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Formandos</span></a>
                                    </li>

                                </ul>

                                <div class="tab-content tabcontent-border">

                                    <div class="tab-pane active" id="dados" role="tabpanel">

                                        <br>
                                        <br>

                                        <form action="recebe_alterarturma.php?id=<?php echo $id; ?>" method="post"
                                              name="cliente" enctype="multipart/form-data"
                                              onSubmit="return verificarCPF()" id="formID">

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">N°
                                                            Contrato</label>
                                                        <input type="number" name="ncontrato"
                                                               value="<?php echo $vetor['ncontrato']; ?>"
                                                               class="form-control" placeholder="N° Contrato" readonly>
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Tipo
                                                            Contrato</label>
                                                        <select name="tipo" class="form-control" required="">
                                                            <option value="" selected="">Selecione...</option>
                                                            <option value="1"
																														        <?php if (strcasecmp($vetor['tipo'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Fotografia
                                                            </option>
                                                            <option value="2"
																														        <?php if (strcasecmp($vetor['tipo'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Convite
                                                            </option>
                                                            <option value="3"
																														        <?php if (strcasecmp($vetor['tipo'], '3') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Fotografia/Convite
                                                            </option>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Curso</label>
                                                        <select name="curso" id="categorias" class="form-control">
                                                            <option value="" selected="selected">Selecione...</option>
																													<?php
																													$sql_cursos = mysqli_query($con, "select * from cursos order by nome ASC");
																													while ($vetor_curso = mysqli_fetch_array($sql_cursos)) {
																														$sql_instituicao_curso = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
																														$vetor_instituicao_curso = mysqli_fetch_array($sql_instituicao_curso);
																														?>
                                                              <option value="<?php echo $vetor_curso['id_curso']; ?>"
																															        <?php if (strcasecmp($vetor['curso'], $vetor_curso['id_curso']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_curso['nome'] ?>
                                                                  / <?php echo $vetor_instituicao_curso['sigla'] ?></option>
																													<?php } ?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Conclusão</label>
                                                        <input type="text" name="ano"
                                                               value="<?php echo $vetor['ano']; ?>" class="form-control"
                                                               id="exampleInput" placeholder="Ano Conclusão">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Instituição</label>
                                                        <select name="id_instituicao" id="categorias"
                                                                class="form-control">
                                                            <option value="" selected="selected">Selecione...</option>
																													<?php
																													$sql_instituicoes = mysqli_query($con, "select * from instituicoes order by nome ASC");
																													while ($vetor_instituicao = mysqli_fetch_array($sql_instituicoes)) { ?>
                                                              <option value="<?php echo $vetor_instituicao['id_instituicao']; ?>"
																															        <?php if (strcasecmp($vetor['id_instituicao'], $vetor_instituicao['id_instituicao']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_instituicao['nome'] ?></option>
																													<?php } ?>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Qtde
                                                            Alunos</label>
                                                        <input type="number" name="qtdalunos"
                                                               value="<?php echo $vetor['qtdalunos']; ?>"
                                                               class="form-control" placeholder="Quantidade">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Qtde
                                                            Comissão</label>
                                                        <input type="number" name="qtdcomissao"
                                                               value="<?php echo $vetor['qtdcomissao']; ?>"
                                                               class="form-control" placeholder="Quantidade">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Qtde de
                                                            Formandos</label>
                                                        <input type="number" name="qtdformandos"
                                                               value="<?php echo $vetor['qtdformandos']; ?>"
                                                               class="form-control" id="exampleInput"
                                                               placeholder="Quantidade">
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Ano de
                                                            realização</label>
                                                        <input type="text" name="anorealizacao"
                                                               value="<?php echo $vetor['anorealizacao']; ?>"
                                                               class="form-control" placeholder="Ano de realização"
                                                               required>
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Mês de
                                                            realização</label>
                                                        <select name="mesrealizacao" class="form-control" required="">
                                                            <option value="" selected="">Selecione...</option>
                                                            <option value="Janeiro"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Janeiro') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Janeiro
                                                            </option>
                                                            <option value="Fevereiro"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Fevereiro') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Fevereiro
                                                            </option>
                                                            <option value="Março"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Março') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Março
                                                            </option>
                                                            <option value="Abril"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Abril') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Abril
                                                            </option>
                                                            <option value="Maio"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Maio') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Maio
                                                            </option>
                                                            <option value="Junho"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Junho') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Junho
                                                            </option>
                                                            <option value="Julho"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Julho') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Julho
                                                            </option>
                                                            <option value="Agosto"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Agosto') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Agosto
                                                            </option>
                                                            <option value="Setembro"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Setembro') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Setembro
                                                            </option>
                                                            <option value="Outubro"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Outubro') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Outubro
                                                            </option>
                                                            <option value="Novembro"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Novembro') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Novembro
                                                            </option>
                                                            <option value="Dezembro"
																														        <?php if (strcasecmp($vetor['mesrealizacao'], 'Dezembro') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Dezembro
                                                            </option>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Turma</label>
                                                        <input type="text" name="turma"
                                                               value="<?php echo $vetor['turma']; ?>"
                                                               class="form-control" placeholder="Turma" required>
                                                    </fieldset>
                                                </div>

                                            </div><!--.row-->

                                            <div class="row">

                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Valor da
                                                            Pagina 30x40cm</label>
                                                        <input type="text" name="valorfoto"
                                                               value="<?php echo $num = number_format($vetor['valorfoto'], 2, ',', '.'); ?>"
                                                               class="form-control" id="exampleInput"
                                                               onKeyPress="mascara(this,mvalor)"
                                                               placeholder="Valor de Pagina">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Valor da
                                                            Pagina 22x30cm</label>
                                                        <input type="text" name="valorfoto1"
                                                               value="<?php echo $num = number_format($vetor['valorfoto1'], 2, ',', '.'); ?>"
                                                               class="form-control" id="exampleInput"
                                                               onKeyPress="mascara(this,mvalor)"
                                                               placeholder="Valor de Pagina">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Valor da
                                                            Encadernação</label>
                                                        <input type="text" name="valorencadernacao"
                                                               value="<?php echo $num = number_format($vetor['valorencadernacao'], 2, ',', '.'); ?>"
                                                               class="form-control" onKeyPress="mascara(this,mvalor)"
                                                               placeholder="Valor da Encadernação">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Valor do
                                                            Arquivo Digital</label>
                                                        <input type="text" name="valoralbum"
                                                               value="<?php echo $num = number_format($vetor['valoralbum'], 2, ',', '.'); ?>"
                                                               class="form-control" onKeyPress="mascara(this,mvalor)"
                                                               placeholder="Valor do Arquivo Digital">
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">E-mail da
                                                            Comissão de Formatura</label>
                                                        <input type="email" name="emailcomissao"
                                                               value="<?php echo $vetor['emailcomissao']; ?>"
                                                               class="form-control"
                                                               placeholder="E-mail da Comissão de Formatura">
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Cerimonial</label>
                                                        <input type="text" name="cerimonial"
                                                               value="<?php echo $vetor['cerimonial']; ?>"
                                                               class="form-control" id="exampleInput"
                                                               placeholder="Cerimonial">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Telefone
                                                            Cerimonial</label>
                                                        <input type="text" name="telefonecerimonial" id="telefone5"
                                                               value="<?php echo $vetor['telefonecerimonial']; ?>"
                                                               class="form-control" placeholder="Telefone Cerimonial">
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Responsável
                                                            Cerimonial</label>
                                                        <input type="text" name="nomeresponsavel"
                                                               value="<?php echo $vetor['nomeresponsavel']; ?>"
                                                               class="form-control" id="exampleInput"
                                                               placeholder="Responsável Cerimonial">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Telefone
                                                            Responsável Cerimonial</label>
                                                        <input type="text" name="telefoneresponsavel" id="telefone6"
                                                               value="<?php echo $vetor['telefoneresponsavel']; ?>"
                                                               class="form-control"
                                                               placeholder="Telefone Responsável Cerimonial">
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <h3>Eventos da Turma</h3>

                                            <div id="origem">

                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold" for="exampleInput">Eventos</label>
                                                            <select name="id_evento[]" class="form-control">
                                                                <option value="" selected="selected">Selecione...
                                                                </option>
																															<?php
																															$sql_evento = mysqli_query($con, "select * from categoriaevento order by nome ASC");
																															while ($vetor_evento = mysqli_fetch_array($sql_evento)) {
																																?>
                                                                  <option value="<?php echo $vetor_evento['id_categoria']; ?>"><?php echo $vetor_evento['nome'] ?></option>
																															<?php } ?>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                                                                                                
                                                </div>

                                                

                                            </div>

                                            <div id="destino">
                                            </div>
                                            <br>
                                            <input type="button" value="Adicionar Evento" onclick="duplicarCampos();"
                                                   class="btn btn-warning">
                                            <input type="button" value="Excluir Evento" onclick="removerCampos(this);"
                                                   class="btn btn-danger">

                                            <br>
                                            <br>

                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Logo/Brasão
                                                            ou Símbolo da turma</label>
                                                        <input type="file" name="logo">
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Observações</label>
                                                        <textarea name="observacoes" rows="5"
                                                                  class="form-control"><?php echo $vetor['observacoes']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Liberar Pré-evento apos compra?</label>
                                                        <select name="preevento" class="form-control">
                                                            <option value="1" selected>Não</option>
                                                            <option value="2">Sim</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary" style="    float: left;">
                                                Cadastrar
                                            </button>

                                        </form>

                                    </div>

                                    <div class="tab-pane" id="fotografia" role="tabpanel">

                                        <br>
                                        <br>

                                        <ul class="nav nav-tabs" role="tablist">

                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                    href="#documentosfotografia" role="tab"><span
                                                            class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down">Documentos</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#eventosfotografia" role="tab"><span
                                                            class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down">Eventos</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Produtos</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Mostruários Comerciais</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#"
                                                                    role="tab"><span class="hidden-sm-up" style="color: red"><i
                                                                class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Mostruários Oficiais</span></a></li>

                                        </ul>

                                        <div class="tab-content tabcontent-border">

                                            <div class="tab-pane active" id="documentosfotografia" role="tabpanel">

                                                <br>
                                                <br>

                                                <a href="cadastroarquivocontrato.php?id=<?php echo $id; ?>">
                                                    <button type="button" class="btn btn-primary"
                                                            style="    float: left;">Cadastrar Arquivo
                                                    </button>
                                                </a>

                                                <br>
                                                <br>
                                                <br>

                                                <table id="lang_opt1" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Titulo</th>
                                                        <th>Data</th>
                                                        <th>Hora</th>
                                                        <th>Anexar e-mail de compra?</th>
                                                        <th>Compartilhar com a Comissão?</th>
                                                        <th>Extensão Arquivo</th>
                                                        <th>Arquivo</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
																										<?php
																										$sql_arquivos = mysqli_query($con, "select * from arquivos_contratos where id_cliente = '$id' and tipo = '1' order by id_arquivo DESC");
																										while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
																											?>
                                                        <tr>
                                                            <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                            <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?></td>
                                                            <td><?php echo $vetor_arquivo['hora']; ?></td>
                                                            <td><?php if ($vetor_arquivo['emailcompra'] == 1) {
																																echo "Não";
																															}
																															if ($vetor_arquivo['emailcompra'] == 2) {
																																echo "Sim";
																															} ?></td>
                                                            <td>

                                                                <table width="100%">
                                                                    <tr>
                                                                        <td>

                                                                            <form action="recebe_alterar_arquivo.php?id=<?php echo $id; ?>&id_arquivo=<?php echo $vetor_arquivo['id_arquivo']; ?>"
                                                                                  method="POST">
                                                                                <select name="comissao"
                                                                                        class="form-control">
                                                                                    <option value="1"
																																										        <?php if (strcasecmp($vetor_arquivo['comissao'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                                        Sim
                                                                                    </option>
                                                                                    <option value="2"
																																										        <?php if (strcasecmp($vetor_arquivo['comissao'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                                        Não
                                                                                    </option>
                                                                                </select>
                                                                        </td>
                                                                        <td width="2%"></td>
                                                                        <td><?php if ($vetor_permissao['alteracao'] == 1) {
																																					}else { ?>
                                                                                <button type="submit"
                                                                                        class="btn btn-primary"
                                                                                        style="    float: left;">Alterar
                                                                                </button><?php } ?>

                                                                            </form>

                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                            </td>
                                                            <td><?php echo $ext = strrchr($vetor_arquivo['arquivo'], '.'); ?></td>
                                                            <td>
                                                                <a href="arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                                   target="_blank">
                                                                    <button type="button" class="btn btn-default">
                                                                        Arquivo
                                                                    </button>
                                                                </a> <?php if ($vetor_permissao['exclusao'] == 1) {
																															}else { ?><a
                                                                    href="excluirarquivocontrato.php?id=<?php echo $vetor_arquivo['id_arquivo']; ?>&id1=<?php echo $id; ?>&tab=tab_4&tab1=tab_doc_1"
                                                                    target="_blank">
                                                                        <button type="button" class="btn btn-danger">
                                                                            Excluir
                                                                        </button></a><?php } ?></td>
                                                        </tr>
																										<?php } ?>
                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="tab-pane" id="eventosfotografia" role="tabpanel">

                                                <br>
                                                <br>

                                                <form action="recebe_eventosturma.php?id=<?php echo $id; ?>"
                                                      method="post" name="cliente" enctype="multipart/form-data"
                                                      id="formID">

                                                    <div id="origem2">

                                                        <div class="row">

                                                            <div class="col-lg-12">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Eventos</label>
                                                                    <select id="categoriasevento" class="form-control select2" name="id_evento[]"
                                                                            required="">
                                                                        <option value="" selected="selected">
                                                                            Selecione...
                                                                        </option>
																																			<?php
																																			$sql_evento = mysqli_query($con, "select * from categoriaevento order by nome ASC");
																																			while ($vetor_evento = mysqli_fetch_array($sql_evento)) {
																																				?>
                                                                          <option value="<?php echo $vetor_evento['id_categoria']; ?>"><?php echo $vetor_evento['nome'] ?></option>
																																			<?php } ?>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <!--
                                                            <div class="col-lg-6" id="hidden_div" > style="display: none;">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold" for="exampleInput">Número</label>
                                                                    <input type="number" name="titulo[]" class="form-control">
                                                                </fieldset>
                                                            </div>
                                                            -->
                                                        </div>

                                                    </div>

                                                    <div id="destino2">
                                                    </div>
                                                    <br>
                                                    <input type="button" value="Adicionar Evento"
                                                           onclick="duplicarCampos2();" class="btn btn-warning">
                                                    <input type="button" value="Excluir Evento"
                                                           onclick="removerCampos2(this);" class="btn btn-danger">

                                                    <br>
                                                    <br>
																									
																									<?php if ($vetor_permissao['alteracao'] == 1) {
																									}else { ?>
                                                      <button type="submit" class="btn btn-primary"
                                                              style="    float: left;">Salvar
                                                      </button><?php } ?>

                                                </form>

                                                <br>
                                                <br>

                                                <h3>Eventos Cadastrados</h3>

                                                <table class="table table-bordered table-striped">
                                                    <thead align="center">
                                                    <tr>
                                                        <th><strong><h5>Evento</h5></strong></th>
                                                        <th width="13%"><strong><h5>Ação</h5></strong></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
																										<?php
																										$sql_eventos = mysqli_query($con, "select * from eventos_turma_lista WHERE id_turma = '$id' order by id_evento_turma ASC");
																										
                                                                                                        while ($vetor_eventos = mysqli_fetch_array($sql_eventos)) {
																											$sql_evento = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_eventos[id_evento]'");
																											$vetor_evento = mysqli_fetch_array($sql_evento);
																											?>
                                                        <tr>
                                                            <td align="center"><?php if ($vetor_evento['nome'] == 'Pré-evento'){ echo $vetor_evento['nome'].' '.$vetor_eventos['preevento']; }else { echo $vetor_evento['nome']; }?></td>
                                                            <td align="center">
																																<?php if ($vetor_evento['especificar_formandos'] == '1') { ?>
                                                                        <a href="escolhaformandos_evento.php?id_evento=<?php echo $vetor_eventos['id_evento_turma']; ?>&id=<?php echo $id; ?>">
                                                                            <button type="button"
                                                                                    class="btn btn-success mesmo-tamanho"
                                                                                    title="Escolher Formandos"><i
                                                                                        class="fa fa-edit"></i>
                                                                            </button>
                                                                        </a>
																																<?php } ?>
                                                                <a href="confexcluireventoturma.php?id=<?php echo $vetor_eventos['id_evento_turma']; ?>&id1=<?php echo $id; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger mesmo-tamanho"
                                                                                title="Excluir Cadastro"><i
                                                                                    class="mdi mdi-window-close"></i>
                                                                        </button></a>

                                                            </td>
                                                        </tr>
														<?php } ?>
                                                        <?php
														$sql_eventos = mysqli_query($con, "select * from preevento_turma_lista WHERE id_turma = '$id' order by id_evento_turma ASC");
														
                                                        while ($vetor_eventos = mysqli_fetch_array($sql_eventos)) {
															$sql_evento = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_eventos[id_evento]'");
															$vetor_evento = mysqli_fetch_array($sql_evento);
														?>
                                                        <tr>
                                                            <td align="center"><?php if ($vetor_evento['nome'] == 'Pré-evento'){ echo $vetor_evento['nome'].' - '.$vetor_eventos['preevento']; }else { echo $vetor_evento['nome']; }?></td>
                                                            <td align="center">
																																<?php if ($vetor_evento['especificar_formandos'] == '1') { ?>
                                                                        <a href="escolhaformandos_evento.php?id_evento=<?php echo $vetor_eventos['id_evento_turma']; ?>&id=<?php echo $id; ?>">
                                                                            <button type="button"
                                                                                    class="btn btn-success mesmo-tamanho"
                                                                                    title="Escolher Formandos"><i
                                                                                        class="fa fa-edit"></i>
                                                                            </button>
                                                                        </a>
																																<?php } ?>
                                                                <a href="confexcluireventoturma.php?id=<?php echo $vetor_eventos['id_evento_turma']; ?>&id1=<?php echo $id; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger mesmo-tamanho"
                                                                                title="Excluir Cadastro"><i
                                                                                    class="mdi mdi-window-close"></i>
                                                                        </button></a>

                                                            </td>
                                                        </tr>
														<?php } ?>
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="tab-pane" id="convite" role="tabpanel">

                                        <br>
                                        <br>


                                        <ul class="nav nav-tabs" role="tablist">

                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                    href="#documentosconvite" role="tab"><span
                                                            class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down">Documentos</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Orçamentos</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Arquivos Gráficos</span></a>
                                            </li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#tiposdearquivosconvite" role="tab"><span
                                                            class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down">Arquivos de Convite</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Arquivos de Aprovação</span></a></li>

                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Arquivos de Produção</span></a></li>

                                        </ul>

                                        <div class="tab-content tabcontent-border">

                                            <div class="tab-pane active" id="documentosconvite" role="tabpanel">

                                                <br>
                                                <br>

                                                <a href="cadastroarquivocontrato.php?id=<?php echo $id; ?>">
                                                    <button type="button" class="btn btn-primary"
                                                            style="    float: left;">Cadastrar Arquivo
                                                    </button>
                                                </a>

                                                <br>
                                                <br>
                                                <br>

                                                <table id="lang_opt5" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Titulo</th>
                                                        <th>Data</th>
                                                        <th>Hora</th>
                                                        <th>Anexar e-mail de compra?</th>
                                                        <th>Compartilhar com a Comissão?</th>
                                                        <th>Extensão Arquivo</th>
                                                        <th>Arquivo</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
																										<?php
																										$sql_arquivos = mysqli_query($con, "select * from arquivos_contratos where id_cliente = '$id' and tipo = '2' order by id_arquivo DESC");
																										while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
																											?>
                                                        <tr>
                                                            <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                            <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?></td>
                                                            <td><?php echo $vetor_arquivo['hora']; ?></td>
                                                            <td><?php if ($vetor_arquivo['emailcompra'] == 1) {
																																echo "Não";
																															}
																															if ($vetor_arquivo['emailcompra'] == 2) {
																																echo "Sim";
																															} ?></td>
                                                            <td>

                                                                <table width="100%">
                                                                    <tr>
                                                                        <td>

                                                                            <form action="recebe_alterar_arquivo.php?id=<?php echo $id; ?>&id_arquivo=<?php echo $vetor_arquivo['id_arquivo']; ?>"
                                                                                  method="POST">
                                                                                <select name="comissao"
                                                                                        class="form-control">
                                                                                    <option value="1"
																																										        <?php if (strcasecmp($vetor_arquivo['comissao'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                                        Não
                                                                                    </option>
                                                                                    <option value="2"
																																										        <?php if (strcasecmp($vetor_arquivo['comissao'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                                        Sim
                                                                                    </option>
                                                                                </select>
                                                                        </td>
                                                                        <td width="2%"></td>
                                                                        <td><?php if ($vetor_permissao['alteracao'] == 1) {
																																					}else { ?>
                                                                                <button type="submit"
                                                                                        class="btn btn-primary"
                                                                                        style="    float: left;">Alterar
                                                                                </button><?php } ?>

                                                                            </form>

                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                            </td>
                                                            <td><?php echo $ext = strrchr($vetor_arquivo['arquivo'], '.'); ?></td>
                                                            <td>
                                                                <a href="arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                                   target="_blank">
                                                                    <button type="button" class="btn btn-default">
                                                                        Arquivo
                                                                    </button>
                                                                </a> <?php if ($vetor_permissao['exclusao'] == 1) {
																															}else { ?><a
                                                                    href="excluirarquivocontrato.php?id=<?php echo $vetor_arquivo['id_arquivo']; ?>&id1=<?php echo $id; ?>"
                                                                    target="_blank">
                                                                        <button type="button" class="btn btn-danger">
                                                                            Excluir
                                                                        </button></a><?php } ?></td>
                                                        </tr>
																										<?php } ?>
                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="tab-pane" id="tiposdearquivosconvite" role="tabpanel">

                                                <br>
                                                <br>

                                                <a href="cadastrotipoarquivo_turma.php?id=<?php echo $id; ?>">
                                                    <button type="button" class="btn btn-primary"
                                                            style="    float: left;">Cadastrar Arquivos de Convite
                                                    </button>
                                                </a>
                                                <button type="button" class="btn btn-danger" onclick="arrumaConvite()"
                                                        style="float: right;">Arrumar Arquivos de Convite
                                                </button>

                                                <br>
                                                <br>
                                                <br>

                                                <?php
                                                $sql_data_arquivo = mysqli_query($con, "select * from dados_convite_data where id_turma = '$id'");
                                                $vetor_data_arquivo = mysqli_fetch_array($sql_data_arquivo);
                                                ?>

                                                <form action="recebe_dataarquivo.php?id=<?php echo $id; ?>"
                                                      method="post">

                                                    <?php
                                                    $sql_data = mysqli_query($con, "select * from turmas where id_turma = '$id'");
                                                    $vetor_data = mysqli_fetch_array($sql_data);
                                                    ?>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <fieldset class="form-group">
                                                                <label class="form-label semibold" for="exampleInput">Data
                                                                    Final Convite Personal</label>
                                                                <input type="date" name="datafinal"
                                                                       value="<?php echo $vetor_data['datafinal']; ?>"
                                                                       class="form-control" id="exampleInput" required>
                                                            </fieldset>
                                                        </div>
                                                    </div><!--.row-->


                                                    <button type="submit" class="btn btn-primary"
                                                            style="    float: left;">Salvar Data
                                                    </button>

                                                </form>

                                                <br>
                                                <br>
                                                <br>

                                                <table id="lang_opt9" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Tipo Arquivo</th>
                                                        <th>Qtd Caracteres</th>
                                                        <th>Ação</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $sql_tipoarquivo = mysqli_query($con, "select * from tipos_arquivos_turma where id_turma = '$id'");
                                                    while ($vetor_tipoarquivo = mysqli_fetch_array($sql_tipoarquivo)) {
                                                        $sql_tipo_nome = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '$vetor_tipoarquivo[id_tipo]'");
                                                        $vetor_tipo_nome = mysqli_fetch_array($sql_tipo_nome);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $vetor_tipo_nome['nome']; ?></td>
                                                            <td><?php echo $vetor_tipoarquivo['qtd']; ?></td>
                                                            <td>
                                                                <a href="alterartipoarquivo_turma.php?id=<?php echo $vetor_tipoarquivo['id_tipo_formando']; ?>&id1=<?php echo $id; ?>"
                                                                   target="_blank">
                                                                    <button type="button"
                                                                            class="btn btn-info mesmo-tamanho"
                                                                            title="Alterar Cadastro"><i
                                                                                class="mdi mdi-tooltip-edit"></i>
                                                                    </button>
                                                                </a> <?php if ($vetor_permissao['exclusao'] == 1) {
                                                                }else { ?><a
                                                                    href="confexcluirtipoarquivo_turma.php?id=<?php echo $vetor_tipoarquivo['id_tipo_formando']; ?>&id1=<?php echo $id; ?>" >
                                                                        <button type="button"
                                                                                class="btn btn-danger mesmo-tamanho"
                                                                                title="Excluir Cadastro"><i
                                                                                    class="mdi mdi-window-close"></i>
                                                                        </button></a><?php } ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="tab-pane" id="placa" role="tabpanel">
                                        <br>
                                        <ul class="nav nav-tabs" role="tablist">

                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Documentos</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Orçamentos</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Arquivos Gráficos</span></a>
                                            </li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Arquivos de Placa</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Arquivos de Aprovação</span></a></li>

                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Arquivos de Produção</span></a></li>

                                        </ul>
                                    </div>
                                    
                                    <div class="tab-pane" id="ensaio" role="tabpanel">
                                        <br>

                                        <ul class="nav nav-tabs" role="tablist">

                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Documentos</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Eventos</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Produtos</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#" role="tab"><span
                                                            class="hidden-sm-up" style="color: red"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Mostruários Comerciais</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#"
                                                                    role="tab"><span class="hidden-sm-up" style="color: red"><i
                                                                class="ti-email"></i></span> <span
                                                            class="hidden-xs-down" style="color: red">Mostruários Oficiais</span></a></li>

                                        </ul>
                                    </div>
                                    
                                    <div class="tab-pane" id="interacao" role="tabpanel">
                                        <br>
                                        <a href="cadastro_interacao.php?id=<?php echo $id; ?>" target="_blank">
                                            <button type="button" class="btn btn-primary" style="    float: left;">
                                                Cadastrar
                                                Interação
                                            </button>
                                        </a>

                                        <br>
                                        <br>
                                        <br>

                                        <ul class="nav nav-tabs" role="tablist">

                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                    href="#interacaocontrato" role="tab"><span
                                                            class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down">Contrato</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#interacaoformando" role="tab"><span
                                                            class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                                            class="hidden-xs-down">Formando</span></a></li>

                                        </ul>

                                        <div class="tab-content tabcontent-border">

                                            <div class="tab-pane active" id="interacaocontrato" role="tabpanel">

                                                <br>
                                                <div class="table-responsive">
                                                    <table id="lang_opt10" class="table table-bordered table-striped">
                                                        <thead align="center">
                                                        <tr>
                                                            <th><strong><h4>Data</h4></strong></th>
                                                            <th><strong><h4>Hora</h4></strong></th>
                                                            <th><strong><h4>Meio</h4></strong></th>
                                                            <th><strong><h4>Assunto</h4></strong></th>
                                                            <th><strong><h4>Ocorrência</h4></strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
																												<?php
																												$sql_interacoes = mysqli_query($con, "select * from interacao_contratos where id_cliente = '$id' order by `data` ASC");
																												while ($vetor_interacao = mysqli_fetch_array($sql_interacoes)) {
																													?>
                                                            <tr>
                                                                <td align="center"><?php echo date('d/m/Y', strtotime($vetor_interacao['data'])); ?></td>
                                                                <td align="center"><?php echo substr($vetor_interacao['hora'], 0, 5); ?></td>
                                                                <td><?php echo $vetor_interacao['tipo']; ?></td>
                                                                <td><?php echo $vetor_interacao['assunto']; ?></td>
                                                                <td align="center">
                                                                    <button type='button'
                                                                            class='btn btn-success btn-xs'
                                                                            style='padding: 3px;height: 30px;vertical-align: middle'
                                                                            data-toggle="modal"
                                                                            data-target="#ocorrencia<?php echo $vetor_interacao['id_interacao']; ?>">
                                                                        <i class='mdi mdi-24px mdi-eye'
                                                                           style='position: relative;top: -6px'></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <div id='ocorrencia<?php echo $vetor_interacao['id_interacao']; ?>'
                                                                 class='modal' tabindex='-1' role='dialog'>
                                                                <div class='modal-dialog modal-lg' role='document'>
                                                                    <div class='modal-content'>
                                                                        <div class='modal-header'>
                                                                            <h5 class='modal-title'>Ocorrência</h5>
                                                                        </div>
                                                                        <div class='modal-body'>
                                                                            <div class='row'>
                                                                                <div class='col-lg-12'>
																																									<?php echo $vetor_interacao['ocorrencia']; ?>
                                                                                </div>
                                                                            </div><!--.row-->
                                                                        </div>
                                                                        <div class='modal-footer'>
                                                                            <button type='button'
                                                                                    class='btn btn-secondary'
                                                                                    data-dismiss='modal'>Fechar
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
																												<?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="interacaoformando" role="tabpanel">

                                                <br>
                                                <br>
                                                <div class="table-responsive">
                                                    <table id="lang_opt11" class="table table-bordered table-striped">
                                                        <thead align="center">
                                                        <tr>
                                                            <th><strong><h4>Formando</h4></strong></th>
                                                            <th><strong><h4>Data</h4></strong></th>
                                                            <th><strong><h4>Hora</h4></strong></th>
                                                            <th><strong><h4>Tipo</h4></strong></th>
                                                            <th><strong><h4>Assunto</h4></strong></th>
                                                            <th width="60%"><strong><h4>Ocorrência</h4></strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
																												<?php
																												$sql_interacoes_formando = mysqli_query($con, "select * from interacao a, formandos b where a.id_cliente = b.id_formando and b.turma = '$id' order by a.id_interacao DESC");
																												while ($vetor_interacao_formando = mysqli_fetch_array($sql_interacoes_formando)) {
																													$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor_interacao_formando[id_cliente]'");
																													$vetor_formando = mysqli_fetch_array($sql_formando);
																													$sql_tipo = mysqli_query($con, "select * from tipo_interacao where id_tipo = '$vetor_interacao_formando[tipo]'");
																													$vetor_tipo = mysqli_fetch_array($sql_tipo);
																													$sql_assunto1 = mysqli_query($con, "select * from assuntos where id_assunto = '$vetor_interacao_formando[assunto]'");
																													$vetor_assunto1 = mysqli_fetch_array($sql_assunto1);
																													?>
                                                            <tr>
                                                                <td><?php echo $vetor_formando['nome']; ?></td>
                                                                <td align="center"><?php echo date('d/m/Y', strtotime($vetor_interacao_formando['data'])); ?></td>
                                                                <td align="center"><?php echo substr($vetor_interacao_formando['hora'], 0, 5); ?></td>
                                                                <td><?php echo $vetor_tipo['nome']; ?></td>
                                                                <td><?php echo $vetor_assunto1['nome']; ?></td>
                                                                <td><?php echo $vetor_interacao_formando['ocorrencia']; ?></td>
                                                            </tr>
																												<?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="formandos" role="tabpanel">

                                        <br>
                                        <br>

                                        <table width="100%">
                                            <tr>
                                                <td width="80%"></td>
                                                <td width="12%"></td>
                                                <td width="8%"><a
                                                            href="imprimirformandosORDER.php?id=<?php echo $id; ?>">
                                                        <button type="button" class="btn btn-primary mesmo-tamanho"
                                                                title="Imprimir Cadastros"><i
                                                                    class="mdi mdi-cloud-print"></i></button>
                                                    </a>
                                                    <a href="imprimirformandosORDERexcel.php?id=<?php echo $id; ?>">
                                                        <button type="button" class="btn btn-success mesmo-tamanho"
                                                                title="Imprimir Cadastros"><i
                                                                    class="mdi mdi-file-excel"></i></button>
                                                    </a></td>
                                            </tr>
                                        </table>

                                        <br>
                                        <br>
                                        <div class="table-responsive">
                                            <table id="lang_opt" class="table table-bordered table-striped" style="text-align: center;">
                                                <thead>
                                                <tr>
                                                    <th width="5%"><strong><h5>Contrato</h5></strong></th>
                                                    <th width="5%"><strong><h5>Cód. Aluno</h5></strong></th>
                                                    <th><strong><h5>Nome</h5></strong></th>
                                                    <th><strong><h5>Curso</h5></strong></th>
                                                    <th><strong><h5>Conclusão</h5></strong></th>
                                                    <th><strong><h5>Instituição</h5></strong></th>
                                                    <th><strong><h5>Celular</h5></strong></th>
                                                    <th width="8%"><strong><h5>Tipo Serviço</h5></strong></th>
                                                    <th width="8%"><strong><h5>Tipo Formando</h5></strong></th>
                                                    <th width="20%"><strong><h5>Ação</h5></strong></th>
                                                </tr>
                                                </thead>
                                                <tbody>
																								<?php
																								$nome = ucwords(strtolower($_POST['nome']));
																								$cpf = $_POST['cpf'];
																								$ncontrato = $_POST['ncontrato'];
																								$numero = $_POST['numero'];
																								if (!empty($nome)) {
																									$where .= " AND a.nome LIKE '%".$id_empresa."%'";
																								}
																								$sql_atual = mysqli_query($con, "select * from formandos where turma = '$id' order by nome ASC");
																								while ($vetor = mysqli_fetch_array($sql_atual)) {
																									$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[turma]'");
																									$vetor_turma = mysqli_fetch_array($sql_turma);
																									$sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
																									$vetor_instituicao = mysqli_fetch_array($sql_instituicao);
																									$sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
																									$vetor_curso = mysqli_fetch_array($sql_curso);
																									$sql_vendas_convites = mysqli_query($con, "select * from vendas where tipo = '1' and id_formando = '$vetor[id_formando]' and iniciada = '2'");
																									$sql_vendas_fotografia = mysqli_query($con, "select * from vendas where tipo IN ('2', '3') and id_formando = '$vetor[id_formando]' and iniciada = '2'");
																									?>

                                                    <tr>
                                                        <td><?php echo $vetor_turma['ncontrato']; ?></td>
                                                        <td><?php echo $vetor['id_cadastro']; ?></td>
                                                        <td><?php echo $vetor['nome']; ?></td>
                                                        <td><?php echo $vetor_curso['nome']; ?></td>
                                                        <td><?php echo $vetor['conclusao']; ?></td>
                                                        <td><?php echo $vetor_instituicao['sigla']; ?></td>
                                                        <td><?php echo $vetor['telefone']; ?></td>
                                                        <td>
																													<?php
																													if (mysqli_num_rows($sql_vendas_fotografia) > 0 && mysqli_num_rows($sql_vendas_convites) == 0) {
																														echo "F";
																													}
																													if (mysqli_num_rows($sql_vendas_fotografia) == 0 && mysqli_num_rows($sql_vendas_convites) > 0) {
																														echo "C";
																													}
																													if (mysqli_num_rows($sql_vendas_fotografia) > 0 && mysqli_num_rows($sql_vendas_convites) > 0) {
																														echo "F/C";
																													}
																													?>
                                                        </td>
                                                        <td>
	                                                        <?php if ($vetor['comissao'] == '') { ?>
                                                              <button type="button"
                                                                      class="btn btn-block btn-success btn-sm">Formando
                                                              </button><?php }
	                                                        if ($vetor['comissao'] == '1') { ?>
                                                              <button type="button" class="btn btn-block btn-success btn-sm">
                                                                  Formando
                                                              </button><?php }
	                                                        if ($vetor['comissao'] == 2) { ?>
                                                              <button type="button" class="btn btn-block btn-danger btn-sm">
                                                                  Comissão
                                                              </button><?php } ?>
                                                        </td>
                                                        <td><a class="fancybox fancybox.ajax"
                                                               href="alterarformando.php?id=<?php echo $vetor['id_formando']; ?>"
                                                               target="_blank">
                                                                <button type="button"
                                                                        class="btn btn-success mesmo-tamanho"
                                                                        title="Ver ou Alterar Cadastro"><i
                                                                            class="mdi mdi-tooltip-edit"></i></button>
                                                            </a>
                                                            <a href="listarlinhatempo.php?id=<?php echo $vetor['id_formando']; ?>"
                                                               target="_blank">
                                                                <button type="button"
                                                                        class="btn btn-warning mesmo-tamanho"
                                                                        title="Linha do Tempo"><i
                                                                            class="mdi mdi-chart-timeline"></i></button>
                                                            </a>
                                                            <a href="imprimirformando.php?id=<?php echo $vetor['id_formando']; ?>"
                                                               target="_blank">
                                                                <button type="button"
                                                                        class="btn btn-primary mesmo-tamanho"
                                                                        title="Imprimir Cadastro"><i
                                                                            class="mdi mdi-cloud-print"></i></button>
                                                            </a> <?php if ($vetor['status'] == 2) { ?><a
                                                                href="liberaracesso_turma.php?id=<?php echo $vetor['id_formando']; ?>&id1=<?php echo $id; ?>" >
                                                                    <button type="button"
                                                                            class="btn btn-default mesmo-tamanho"
                                                                            title="Liberar Acesso"><i
                                                                                class="mdi mdi-account-key"></i>
                                                                    </button>
                                                                </a> <?php }
																													if ($vetor['status'] == 1) { ?><a
                                                              href="bloquearacesso_turma.php?id=<?php echo $vetor['id_formando']; ?>&id1=<?php echo $id; ?>" >
                                                                  <button type="button"
                                                                          class="btn btn-default mesmo-tamanho"
                                                                          title="Bloquear Acesso"><i
                                                                              class="mdi mdi-account-key"></i></button>
                                                              </a> <?php }
																													if ($vetor_permissao['exclusao'] == 1) {
																													}else { ?><a class="fancybox fancybox.ajax"
                                                                       href="confexcluirformando.php?id=<?php echo $vetor['id_formando']; ?>">
                                                                  <button type="button"
                                                                          class="btn btn-danger mesmo-tamanho"
                                                                          title="Excluir Cadastro"><i
                                                                              class="mdi mdi-window-close"></i></button>
                                                              </a><?php } ?></td>
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

    <script>
       // window.onload=function(){
            //document.getElementById('categoriasevento').addEventListener('change', function () {
              //  var style = this.value == '2' ? 'block' : 'none';
            //    document.getElementById('hidden_div').style.display = style;       
          //  });
        //}       
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
            if ($.fn.dataTable.isDataTable('#lang_opt10')) {
                $('#lang_opt10').dataTable().fnDestroy();
                init_data_Table();
            } else {
                tabelaNcms = $('#lang_opt10').DataTable({
                    destroy: false,
                    scrollCollapse: true,
                    ordering: true,
                    info: true,
                    searching: true,
                    paging: true,
                    dom: 'Bfrtip',
                    "order": [[0, "desc"]],
                    columnDefs: [
                        {
                            type: 'date-br',
                            targets: 0
                        }
                    ],
                });
            }
        };

        function arrumaConvite() {
            $.post('recebe_fixarquivosdeconvite.php?id_turma=<?php echo $_GET['id']; ?>');
            alert('Arquivos de Convites Arrumados!');
        }

        $(document).ready(function () {
            init_data_Table();
        });
    </script>
    </body>

    </html>
<?php } ?>