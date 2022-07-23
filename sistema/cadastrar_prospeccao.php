<?php
include "../includes/conexao.php";
session_start();

if (isset($_GET['id_turma'])) {
    $id = $_GET['id_turma'];
    $turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas_mkt where id_turma = '$id'"));
    $curso = mysqli_fetch_array(mysqli_query($con, "select * from cursos where id_curso = '$turma[id_curso]'"));
    echo "<label class='form-label' semibold for='exampleInput'>Vagas</label>
          <input type='text' name='qtdalunos' value='" . $curso['vagas1'] . "' class='form-control' readonly>";
    die();
}
if(isset($_GET['id'])){
    $oportunidades = mysqli_fetch_array(mysqli_query($con, "select * from oportunidades where id_oportunidade='$_GET[id]'"));
    $prospeccao = mysqli_fetch_array(mysqli_query($con, "select * from marketing where id_mkt='$oportunidades[id_prospeccao]'"));
}
if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
} else {
    $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);
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
        <link rel="stylesheet" type="text/css" href="../layout/assets/libs/select2/dist/css/select2.min.css">
        <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../layout/dist/css/style.min.css" rel="stylesheet">

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
        <style>
            .select2 {
                width:100%!important;
            }
        </style>
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function () {
                $('#qtdalunos').load('cadastrar_prospeccao.php?id_turma=' + $('#id_turma').val());
                $("#membrocomissao").change(function () {
                    if ($("#membrocomissao").val() == 2)
                        $("#cargo").removeAttr("hidden");
                    else
                        $("#cargo").attr('hidden', 'hidden');
                });

                $("#temempresa").change(function () {
                    if ($("#temempresa").val() == 1) {
                        $("#empresacerimonial_revela").removeAttr("hidden");
                    } else {
                        $("#empresacerimonial_revela").attr('hidden', 'hidden');
                    }
                });

                $('#id_turma').change(function () {
                    $('#qtdalunos').load('cadastrar_prospeccao.php?id_turma=' + $('#id_turma').val());
                });

                $('#viabilidade_fotografia').change(function () {
                    if ($("#viabilidade_fotografia").val() == 2) {
                        $("#fotografia_revela").removeAttr("hidden");
                        $("#fotografia_motivo").attr('required', 'required');
                    } else {
                        $("#fotografia_revela").attr('hidden', 'hidden');
                        $("#fotografia_motivo").removeAttr("required");
                        $("#fotografia_empresa_revela").attr('hidden', 'hidden');
                        $("#fotografia_empresa").removeAttr("required");
                    }
                });

                $('#fotografia_motivo').change(function () {
                    if ($("#fotografia_motivo").val() == 1) {
                        $("#fotografia_empresa_revela").removeAttr("hidden");
                        $("#fotografia_empresa").attr('required', 'required');
                    } else {
                        $("#fotografia_empresa_revela").attr('hidden', 'hidden');
                        $("#fotografia_empresa").removeAttr("required");
                    }
                });

                //
                $('#viabilidade_convite').change(function () {
                    if ($("#viabilidade_convite").val() == 2) {
                        $("#convite_revela").removeAttr("hidden");
                        $("#convite_motivo").attr('required', 'required');
                    } else {
                        $("#convite_revela").attr('hidden', 'hidden');
                        $("#convite_motivo").removeAttr("required");
                        $("#convite_empresa_revela").attr('hidden', 'hidden');
                        $("#convite_empresa").removeAttr("required");
                    }
                });

                $('#convite_motivo').change(function () {
                    if ($("#convite_motivo").val() == 1) {
                        $("#convite_empresa_revela").removeAttr("hidden");
                        $("#convite_empresa").attr('required', 'required');
                    } else {
                        $("#convite_empresa_revela").attr('hidden', 'hidden');
                        $("#convite_empresa").removeAttr("required");
                    }
                });

                //
                $('#viabilidade_ensaio').change(function () {
                    if ($("#viabilidade_ensaio").val() == 2) {
                        $("#ensaio_revela").removeAttr("hidden");
                        $("#ensaio_motivo").attr('required', 'required');
                    } else {
                        $("#ensaio_revela").attr('hidden', 'hidden');
                        $("#ensaio_motivo").removeAttr("required");
                        $("#ensaio_empresa_revela").attr('hidden', 'hidden');
                        $("#ensaio_empresa").removeAttr("required");
                    }
                });

                $('#ensaio_motivo').change(function () {
                    if ($("#ensaio_motivo").val() == 1) {
                        $("#ensaio_empresa_revela").removeAttr("hidden");
                        $("#ensaio_empresa").attr('required', 'required');
                    } else {
                        $("#ensaio_empresa_revela").attr('hidden', 'hidden');
                        $("#ensaio_empresa").removeAttr("required");
                    }
                });

                //
                $('#viabilidade_placa').change(function () {
                    if ($("#viabilidade_placa").val() == 2) {
                        $("#placa_revela").removeAttr("hidden");
                        $("#placa_motivo").attr('required', 'required');
                    } else {
                        $("#placa_revela").attr('hidden', 'hidden');
                        $("#placa_motivo").removeAttr("required");
                        $("#placa_empresa_revela").attr('hidden', 'hidden');
                        $("#placa_empresa").removeAttr("required");
                    }
                });

                $('#placa_motivo').change(function () {
                    if ($("#placa_motivo").val() == 1) {
                        $("#placa_empresa_revela").removeAttr("hidden");
                        $("#placa_empresa").attr('required', 'required');
                    } else {
                        $("#placa_empresa_revela").attr('hidden', 'hidden');
                        $("#placa_empresa").removeAttr("required");
                    }
                });

                $("#tipobusca").change(function () {
                    switch ($("#tipobusca").val()) {
                        case '0':
                            $("#nomeindicacao").attr('hidden', 'hidden');
                            $("#contrato").attr('hidden', 'hidden');
                            $("#formando").attr('hidden', 'hidden');
                            break;
                        case '1':
                            $("#nomeindicacao").attr('hidden', 'hidden');
                            $("#contrato").removeAttr("hidden");
                            $("#formando").removeAttr("hidden");
                            break;
                        case '2':
                            $("#nomeindicacao").removeAttr("hidden");
                            $("#contrato").attr('hidden', 'hidden');
                            $("#formando").attr('hidden', 'hidden');
                            break;
                    }
                });

                $('#contrato').change(function () {
                    $('#selectformando').load('formandos_tarefa.php?load=sim&id_turma=' + $('#turmas').val());
                });

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
                    <a class="navbar-brand" href="inicio.php">
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
                                        src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>" alt="user"
                                        class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img
                                                src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"
                                                alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $vetor_cadastro['nome']; ?></h4>
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
                                    <li class="breadcrumb-item">Marketing</a></li>
                                    <li class="breadcrumb-item">Prospecção</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Nova Prospecção</li>
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

                                <form action="recebe_prospeccao.php<?php if(isset($_GET['id'])){echo "?id=".$_GET['id'];} ?>" method="post" name="cliente"
                                      enctype="multipart/form-data" id="formID">

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Turma</label>
                                                <select name="id_turma" class="form-control select2" required="" id="id_turma">
                                                    <?php if(!isset($_GET['id'])){ ?>
                                                    <option selected="" value="">Selecione...</option>

                                                    <?php
                                                    $sql_turma = mysqli_query($con, "select * from turmas_mkt a, cursos b, instituicoes c where a.id_curso = b.id_curso and b.id_instituicao = c.id_instituicao order by b.nome ASC, b.sigla ASC, a.conclusao ASC");
                                                    while ($vetor_turma = mysqli_fetch_array($sql_turma)) {
                                                        $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[id_curso]' order by nome ASC,sigla ASC");
                                                        $vetor_curso = mysqli_fetch_array($sql_curso);
                                                        ?>

                                                        <option value="<?php echo $vetor_turma['id_turma']; ?>"><?php echo $vetor_curso['nome']; ?>
                                                            / <?php echo $vetor_curso['sigla']; ?>
                                                            / <?php echo $vetor_turma['conclusao']; ?>
                                                            -<?php echo $vetor_turma['semestre']; ?></option>

                                                    <?php }
                                                    }else{
                                                        $sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '$prospeccao[id_turma]'");
                                                        $vetor_turma = mysqli_fetch_array($sql_turma);
                                                        $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[id_curso]'");
                                                        $vetor_curso = mysqli_fetch_array($sql_curso);
                                                        ?>
                                                        <option value="<?php echo $vetor_turma['id_turma']; ?>" selected=""><?php echo $vetor_curso['nome']; ?>
                                                            / <?php echo $vetor_curso['sigla']; ?>
                                                            / <?php echo $vetor_turma['conclusao']; ?>
                                                            -<?php echo $vetor_turma['semestre']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-2">
                                            <fieldset id="qtdalunos" class="form-group">

                                            </fieldset>
                                        </div>
                                    </div><!--.row-->
                                    <?php if (!isset($_GET['id'])) { ?>
                                        <h5>Contato</h5>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Nome</label>
                                                    <input type="text" name="nome_contato" class="form-control"
                                                           required="">
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-3">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">E-mail</label>
                                                    <input type="text" name="email_contato" class="form-control">
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Telefone</label>
                                                    <input type="text" name="telefone_contato" id="telefone"
                                                           class="form-control">
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-2">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Rede
                                                        Social</label>
                                                    <select name="rede_social" class="select2 form-control">
                                                        <option value="" selected="selected">Selecione...</option>
                                                        <option value="Facebook">
                                                            Facebook
                                                        </option>
                                                        <option value="Instagram">
                                                            Instagram
                                                        </option>
                                                        <option value="Twitter">
                                                            Twitter
                                                        </option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Link</label>
                                                    <input type="text" name="link" class="form-control"
                                                           value="">
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-3">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Meio de
                                                        Comunicação</label>
                                                    <select name="meio_comunicacao" id="produto" class="select2 form-control"
                                                            required="">
                                                        <option selected="" value="">Selecione...</option>
                                                        <option value="Facebook">Facebook</option>
                                                        <option value="Instagram">Instagram</option>
                                                        <option value="Whatsapp">Whatsapp</option>
                                                        <option value="Ligação Telefônica">Ligação Telefônica</option>
                                                        <option value="Indicação">Indicação</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Membro da
                                                        Comissão?</label>
                                                    <select id="membrocomissao" name="membro_comissao"
                                                            class="select2 form-control">
                                                        <option value="" selected="">Não</option>
                                                        <option value="2">Sim</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-3">
                                                <fieldset id="cargo" class="form-group" hidden>
                                                    <label class="form-label semibold" for="exampleInput">Cargo</label>
                                                    <select name="cargo" class="select2 form-control">
                                                        <option value="">Selecione...</option>
                                                        <option value="Presidente">Presidente</option>
                                                        <option value="Vice-Presidente">Vice-Presidente</option>
                                                        <option value="Tesoureiro (a)">Tesoureiro (a)</option>
                                                        <option value="Secretário (a)">Secretário (a)</option>
                                                        <option value="Coordenador de Eventos">Coordenador de Eventos</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Tipo de
                                                    Contato</label>
                                                <select name="tipo_comunicacao" class="select2 form-control" required="">
                                                    <option selected="" value="">Selecione...</option>
                                                    <option value="ativa">Ativa</option>
                                                    <option value="passiva">Passiva</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-2">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">É uma
                                                    indicação?</label>
                                                <select name="indicacao" id="tipobusca" class="select2 form-control">
                                                    <option selected="" value="0">Não</option>
                                                    <option value="1">Contrato</option>
                                                    <option value="2">Outros</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-3">
                                            <fieldset id="nomeindicacao" class="form-group" hidden>
                                                <label class="form-label semibold"
                                                       for="exampleInput">Nome</label>
                                                <input type="text" name="nome_indicacao"
                                                       class="form-control">
                                            </fieldset>

                                            <fieldset id="contrato" class="form-group" hidden>
                                                <label class="form-label semibold"
                                                       for="exampleInput">Contrato</label>
                                                <select name="contrato" id="turmas"
                                                        class="select2 form-control">
                                                    <option value="" selected="selected">Selecione...
                                                    </option>
                                                    <?php
                                                    $sql_cursos = mysqli_query($con, "select * from turmas order by ncontrato ASC");
                                                    while ($vetor_curso = mysqli_fetch_array($sql_cursos)) {
                                                        $sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_curso[curso]' order by nome ASC,sigla ASC");
                                                        $vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
                                                        ?>
                                                        <option value="<?php echo $vetor_curso['id_turma']; ?>"><?php echo $vetor_curso['ncontrato'] ?>
                                                            - <?php echo $vetor_curso['nome'] ?> <?php echo $vetor_curso['ano']; ?> <?php echo $vetor_curso_inicio['sigla']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-4">
                                            <div id="formando" class="form-group" hidden>
                                                <label>Formando</label>
                                                <select name="nome_indicacaocontrato"
                                                        class="select2 form-control" id="selectformando">
                                                    <option value="">Escolha um Formando</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!--.row-->

                                    <h5>Viabilidade de Serviços</h5>

                                    <div class="row">
                                        <div class="col-lg-1">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold"
                                                       for="exampleInput">Fotografia</label>
                                                <select id="viabilidade_fotografia" name="viabilidade_fotografia"
                                                        class="select2 form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Viável</option>
                                                    <option value="2">Inviável</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-3">
                                            <fieldset id="fotografia_revela" class="form-group" hidden>
                                                <label class="form-label semibold"
                                                       for="exampleInput">Motivo</label>
                                                <select id="fotografia_motivo" name="fotografia_motivo"
                                                        class="select2 form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Contrato Fechado com outra Empresa</option>
                                                    <option value="2">Fora do Perfil de atendimento</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-3">
                                            <fieldset id="fotografia_empresa_revela" class="form-group" hidden>
                                                <label class="form-label semibold"
                                                       for="exampleInput">Nome da Empresa</label>
                                                <input id="fotografia_empresa" type="text" name="fotografia_empresa"
                                                       class="form-control">
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-1">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold"
                                                       for="exampleInput">Convite</label>
                                                <select id="viabilidade_convite" name="viabilidade_convite"
                                                        class="select2 form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Viável</option>
                                                    <option value="2">Inviável</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-3">
                                            <fieldset id="convite_revela" class="form-group" hidden>
                                                <label class="form-label semibold"
                                                       for="exampleInput">Motivo</label>
                                                <select id="convite_motivo" name="convite_motivo" class="select2 form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Contrato Fechado com outra Empresa</option>
                                                    <option value="2">Fora do Perfil de atendimento</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-3">
                                            <fieldset id="convite_empresa_revela" class="form-group" hidden>
                                                <label class="form-label semibold"
                                                       for="exampleInput">Nome da Empresa</label>
                                                <input id="convite_empresa" type="text" name="convite_empresa"
                                                       class="form-control">
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold"
                                                       for="exampleInput">Ensaio</label>
                                                <select id="viabilidade_ensaio" name="viabilidade_ensaio"
                                                        class="select2 form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Viável</option>
                                                    <option value="2">Inviável</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-3">
                                            <fieldset id="ensaio_revela" class="form-group" hidden>
                                                <label class="form-label semibold"
                                                       for="exampleInput">Motivo</label>
                                                <select id="ensaio_motivo" name="ensaio_motivo" class="select2 form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Contrato Fechado com outra Empresa</option>
                                                    <option value="2">Fora do Perfil de atendimento</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-3">
                                            <fieldset id="ensaio_empresa_revela" class="form-group" hidden>
                                                <label class="form-label semibold"
                                                       for="exampleInput">Nome da Empresa</label>
                                                <input id="ensaio_empresa" type="text" name="ensaio_empresa"
                                                       class="form-control">
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold"
                                                       for="exampleInput">Placa</label>
                                                <select id="viabilidade_placa" name="viabilidade_placa"
                                                        class="select2 form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Viável</option>
                                                    <option value="2">Inviável</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-3">
                                            <fieldset id="placa_revela" class="form-group" hidden>
                                                <label class="form-label semibold"
                                                       for="exampleInput">Motivo</label>
                                                <select id="placa_motivo" name="placa_motivo" class="select2 form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Contrato Fechado com outra Empresa</option>
                                                    <option value="2">Fora do Perfil de atendimento</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-3">
                                            <fieldset id="placa_empresa_revela" class="form-group" hidden>
                                                <label class="form-label semibold"
                                                       for="exampleInput">Nome da Empresa</label>
                                                <input id="placa_empresa" type="text" name="placa_empresa"
                                                       class="form-control">
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-3">
                                                <label class="form-label semibold" for="exampleInput">Empresa de Festa
                                                    (cerimonial)?</label>
                                                <select name="empresa_cerimonial" id="temempresa" class="select2 form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="1">Sim</option>
                                                    <option value="2">Não</option>
                                                </select>
                                        </div>

                                        <div id="empresacerimonial_revela" class="col-lg-3" hidden>
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Nome da
                                                    Empresa</label>
                                                <input type="text" name="nome_cerimonial" class="form-control"
                                                       id="empresacerimonial"
                                                       placeholder="Empresa de Festa (cerimonial)?">
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold"
                                                       for="exampleInput">Observações</label>
                                                <textarea name="observacao" class="form-control"></textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="float: left;">Cadastrar
                                    </button>

                                </form>
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
        $(document).ready(function (){
            $('.select2').each(function () {
                $(this).select2({
                    dropdownParent: $('.card-body'),
                    width: 'resolve'
                });
            });
        });
    </script>
    <script src="../layout/assets/libs/select2/dist/js/select2.min.js"></script>
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