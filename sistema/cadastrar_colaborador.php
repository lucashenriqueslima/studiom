<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$id = $_GET['id'];
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

        </script>
    </head>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#turmas').change(function () {
                $('#solicitante').load('formandos.php?id_turma=' + $('#turmas').val());

            });

        });

        $(document).ready(function () {
            $('#turmas1').change(function () {
                $('#formando').load('formandos_tarefa.php?load=sim&id_turma=' + $('#turmas1').val());

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

        function duplicarCampos3() {
            var clone3 = document.getElementById('origem3').cloneNode(true);
            var destino3 = document.getElementById('destino3');
            destino3.appendChild(clone3);
            var camposClonados3 = clone3.getElementsByTagName('input');
            for (i = 0; i < camposClonados3.length; i++) {
                camposClonados3[i].value = '';
            }
        }

        function removerCampos3(id) {
            var node3 = document.getElementById('destino3');
            node3.removeChild(node3.childNodes[0]);
        }

    </script>

    <script src="ckeditor/ckeditor.js"></script>

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
                        <h4 class="page-title">RH</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">RH</a></li>
                                    <li class="breadcrumb-item">Colaboradores</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cadastrar Colaborador</li>
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
                                <h4 class="card-title">Cadastro de Colaborador</h4>

                                <form action="recebe_colaborador.php" method="post" enctype="multipart/form-data"
                                      name="cliente">
                                    <input type="hidden" name="tipocad" value="3">
                                    <div class="box-body">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nome do Colaborador</label>
                                                    <input type="text" name="nome" value="<?php echo $vetor['nome']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite o Nome" required>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Data de Nascimento</label>
                                                    <input type="date" name="datanasc"
                                                           value="<?php echo $vetor['datanasc']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite a Data de Nascimento">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Local de Nascimento</label>
                                                    <input type="text" name="localnasc"
                                                           value="<?php echo $vetor['localnasc']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite o Local de Nascimento">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>UF</label>
                                                    <select id="estadonasc" name="estado" class="form-control">
                                                        <option value="" selected="">Selecione....</option>
                                                        <option value="AC"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'AC') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Acre
                                                        </option>
                                                        <option value="AL"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'AL') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Alagoas
                                                        </option>
                                                        <option value="AP"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'AP') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Amapá
                                                        </option>
                                                        <option value="AM"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'AM') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Amazonas
                                                        </option>
                                                        <option value="BA"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'BA') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Bahia
                                                        </option>
                                                        <option value="CE"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'CE') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Ceará
                                                        </option>
                                                        <option value="DF"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'DF') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Distrito Federal
                                                        </option>
                                                        <option value="ES"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'ES') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Espírito Santo
                                                        </option>
                                                        <option value="GO"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'GO') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Goiás
                                                        </option>
                                                        <option value="MA"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'MA') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Maranhão
                                                        </option>
                                                        <option value="MT"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'MT') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Mato Grosso
                                                        </option>
                                                        <option value="MS"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'MS') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Mato Grosso do Sul
                                                        </option>
                                                        <option value="MG"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'MG') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Minas Gerais
                                                        </option>
                                                        <option value="PA"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'PA') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Pará
                                                        </option>
                                                        <option value="PB"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'PB') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Paraíba
                                                        </option>
                                                        <option value="PR"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'PR') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Paraná
                                                        </option>
                                                        <option value="PE"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'PE') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Pernambuco
                                                        </option>
                                                        <option value="PI"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'PI') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Piauí
                                                        </option>
                                                        <option value="RJ"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'RJ') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Rio de Janeiro
                                                        </option>
                                                        <option value="RN"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'RN') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Rio Grande do Norte
                                                        </option>
                                                        <option value="RS"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'RS') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Rio Grande do Sul
                                                        </option>
                                                        <option value="RO"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'RO') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Rondônia
                                                        </option>
                                                        <option value="RR"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'RR') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Roraima
                                                        </option>
                                                        <option value="SC"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'SC') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Santa Catarina
                                                        </option>
                                                        <option value="SP"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'SP') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            São Paulo
                                                        </option>
                                                        <option value="SE"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'SE') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Sergipe
                                                        </option>
                                                        <option value="TO"
																												        <?php if (strcasecmp($vetor['estadonasc'], 'TO') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Tocantins
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Carteira de Trabalho</label>
                                                    <input type="text" name="carteiratrabalho"
                                                           value="<?php echo $vetor['carteiratrabalho']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite a Carteira de Trabalho">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Serie</label>
                                                    <input type="text" name="seriecarteiratrabalho"
                                                           value="<?php echo $vetor['seriecarteiratrabalho']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite a Serie">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>CPF</label>
                                                    <input type="text" name="cpfcnpj"
                                                           value="<?php echo $vetor['cpfcnpj']; ?>" class="form-control"
                                                           id="exampleInput" placeholder="Digite apenas os numeros"
                                                           pattern="[0-9]+$">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Titulo Eleitoral N°</label>
                                                    <input type="text" name="tituloeleitor"
                                                           value="<?php echo $vetor['tituloeleitor']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite o Titulo Eleitoral N°">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Zona</label>
                                                    <input type="text" name="zona" value="<?php echo $vetor['zona']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite a Zona">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Seção</label>
                                                    <input type="text" name="secao"
                                                           value="<?php echo $vetor['secao']; ?>" class="form-control"
                                                           id="exampleInput" placeholder="Digite a Seção">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Seção</label>
                                                    <select id="estadosecao" name="estado" class="form-control">
                                                        <option value="" selected="">Selecione....</option>
                                                        <option value="AC"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'AC') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Acre
                                                        </option>
                                                        <option value="AL"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'AL') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Alagoas
                                                        </option>
                                                        <option value="AP"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'AP') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Amapá
                                                        </option>
                                                        <option value="AM"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'AM') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Amazonas
                                                        </option>
                                                        <option value="BA"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'BA') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Bahia
                                                        </option>
                                                        <option value="CE"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'CE') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Ceará
                                                        </option>
                                                        <option value="DF"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'DF') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Distrito Federal
                                                        </option>
                                                        <option value="ES"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'ES') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Espírito Santo
                                                        </option>
                                                        <option value="GO"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'GO') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Goiás
                                                        </option>
                                                        <option value="MA"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'MA') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Maranhão
                                                        </option>
                                                        <option value="MT"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'MT') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Mato Grosso
                                                        </option>
                                                        <option value="MS"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'MS') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Mato Grosso do Sul
                                                        </option>
                                                        <option value="MG"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'MG') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Minas Gerais
                                                        </option>
                                                        <option value="PA"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'PA') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Pará
                                                        </option>
                                                        <option value="PB"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'PB') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Paraíba
                                                        </option>
                                                        <option value="PR"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'PR') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Paraná
                                                        </option>
                                                        <option value="PE"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'PE') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Pernambuco
                                                        </option>
                                                        <option value="PI"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'PI') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Piauí
                                                        </option>
                                                        <option value="RJ"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'RJ') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Rio de Janeiro
                                                        </option>
                                                        <option value="RN"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'RN') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Rio Grande do Norte
                                                        </option>
                                                        <option value="RS"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'RS') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Rio Grande do Sul
                                                        </option>
                                                        <option value="RO"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'RO') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Rondônia
                                                        </option>
                                                        <option value="RR"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'RR') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Roraima
                                                        </option>
                                                        <option value="SC"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'SC') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Santa Catarina
                                                        </option>
                                                        <option value="SP"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'SP') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            São Paulo
                                                        </option>
                                                        <option value="SE"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'SE') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Sergipe
                                                        </option>
                                                        <option value="TO"
																												        <?php if (strcasecmp($vetor['estadosecao'], 'TO') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Tocantins
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Cart. de Identidade</label>
                                                    <input type="text" name="rg" value="<?php echo $vetor['rg']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite o RG">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Orgão Emissor</label>
                                                    <input type="text" name="orgaoemissor"
                                                           value="<?php echo $vetor['orgaoemissor']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite o Orgão Emissor">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Data Emissão</label>
                                                    <input type="date" name="dataemissao"
                                                           value="<?php echo $vetor['dataemissao']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite a Data Emissão">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Certif. de Reservista N°</label>
                                                    <input type="text" name="certidaoreservista"
                                                           value="<?php echo $vetor['certidaoreservista']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite o Certif. de Reservista N°">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Serie</label>
                                                    <input type="text" name="seriereservista"
                                                           value="<?php echo $vetor['seriereservista']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite a Serie">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Categoria</label>
                                                    <input type="text" name="categoria"
                                                           value="<?php echo $vetor['categoria']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite a Categoria">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>PIS N°</label>
                                                    <input type="text" name="pis" value="<?php echo $vetor['pis']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite o PIS N°">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Data Cadastro</label>
                                                    <input type="date" name="datacadastro"
                                                           value="<?php echo $vetor['datacadastro']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite a Data Cadastro">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Telefone</label>
                                                    <input type="text" name="telefone"
                                                           value="<?php echo $vetor['telefone']; ?>"
                                                           class="form-control" placeholder="Digite o Telefone"
                                                           id="telefone">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Celular</label>
                                                    <input type="text" name="celular"
                                                           value="<?php echo $vetor['celular']; ?>" class="form-control"
                                                           placeholder="Digite o Celular" id="telefone2">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Telefone p/ Recado</label>
                                                    <input type="text" name="telefonerecado"
                                                           value="<?php echo $vetor['telefonerecado']; ?>"
                                                           class="form-control" placeholder="Digite o Celular"
                                                           id="telefone3">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>E-mail</label>
                                                    <input type="text" name="email"
                                                           value="<?php echo $vetor['email']; ?>" class="form-control"
                                                           id="exampleInput" placeholder="Digite o E-mail">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome do Pai</label>
                                                    <input type="text" name="nomepai"
                                                           value="<?php echo $vetor['nomepai']; ?>" class="form-control"
                                                           id="exampleInput" placeholder="Digite o Nome">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome da Mãe</label>
                                                    <input type="text" name="nomemae"
                                                           value="<?php echo $vetor['nomemae']; ?>" class="form-control"
                                                           id="exampleInput" placeholder="Digite o Nome">
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>CEP</label>
                                                    <input type="text" name="cep" value="<?php echo $vetor['cep']; ?>"
                                                           id="cep" class="form-control" placeholder="CEP">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Rua</label>
                                                    <input type="text" name="endereco"
                                                           value="<?php echo $vetor['endereco']; ?>" id="rua"
                                                           class="form-control" placeholder="Endereço">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Numero</label>
                                                    <input type="text" name="numero"
                                                           value="<?php echo $vetor['numero']; ?>" class="form-control"
                                                           id="exampleInput" placeholder="Numero">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Complemento</label>
                                                    <input type="text" name="complemento"
                                                           value="<?php echo $vetor['complemento']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Complemento">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Bairro</label>
                                                    <input type="text" name="bairro"
                                                           value="<?php echo $vetor['bairro']; ?>" id="bairro"
                                                           class="form-control" placeholder="Bairro">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Cidade</label>
                                                    <input type="text" name="cidade"
                                                           value="<?php echo $vetor['cidade']; ?>" id="cidade"
                                                           class="form-control" placeholder="Cidade">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Estado</label>
                                                    <input type="text" name="estado"
                                                           value="<?php echo $vetor['estado']; ?>" id="uf"
                                                           class="form-control" placeholder="Estado">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Banco</label>
                                                    <input type="text" name="banco"
                                                           value="<?php echo $vetor['banco']; ?>" class="form-control"
                                                           id="exampleInput" placeholder="Nome do Banco">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Agencia</label>
                                                    <input type="text" name="agencia"
                                                           value="<?php echo $vetor['agencia']; ?>" class="form-control"
                                                           placeholder="Agencia">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Conta</label>
                                                    <input type="text" name="conta"
                                                           value="<?php echo $vetor['conta']; ?>" class="form-control"
                                                           placeholder="Conta">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Tipo da Conta</label>
                                                    <select name="tipoconta" class="form-control select2"
                                                            style="width: 100%;" required>
                                                        <option value="1"
																												        <?php if (strcasecmp($vetor['tipoconta'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Corrente
                                                        </option>
                                                        <option value="2"
																												        <?php if (strcasecmp($vetor['tipoconta'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Poupança
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Grau de Instrução</label>
                                                    <input type="text" name="grauinstrucao" class="form-control"
                                                           value="<?php echo $vetor['grauinstrucao']; ?>"
                                                           placeholder="Digite o Grau de Instrução">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Est.
                                                        Civil</label>
                                                    <select name="estadocivil" class="form-control">
                                                        <option value="" selected="">Selecione...</option>
                                                        <option value="Casado(a)"
																												        <?php if (strcasecmp($vetor['estadocivil'], 'Casado(a)') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Casado(a)
                                                        </option>
                                                        <option value="Solteiro(a)"
																												        <?php if (strcasecmp($vetor['estadocivil'], 'Solteiro(a)') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Solteiro(a)
                                                        </option>
                                                        <option value="Divorciado(a)"
																												        <?php if (strcasecmp($vetor['estadocivil'], 'Divorciado(a)') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Divorciado(a)
                                                        </option>
                                                        <option value="Viúvo(a)"
																												        <?php if (strcasecmp($vetor['estadocivil'], 'Viúvo(a)') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Viúvo(a)
                                                        </option>
                                                        <option value="Amasiado(a)"
																												        <?php if (strcasecmp($vetor['estadocivil'], 'Amasiado(a)') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Amasiado(a)
                                                        </option>
                                                    </select>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nome Cônjuge</label>
                                                    <input type="text" name="conjuge" class="form-control"
                                                           value="<?php echo $vetor['conjuge']; ?>"
                                                           placeholder="Digite o Nome Cônjuge">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tem Filhos Menores de 14 Anos?</label>
                                                    <select name="filhosmenores" class="form-control">
                                                        <option value="" selected="">Selecione...</option>
                                                        <option value="1"
																												        <?php if (strcasecmp($vetor['filhosmenores'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Sim
                                                        </option>
                                                        <option value="2"
																												        <?php if (strcasecmp($vetor['filhosmenores'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Não
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Quantos</label>
                                                    <input type="number" name="quantos"
                                                           value="<?php echo $vetor['quantos']; ?>" class="form-control"
                                                           id="exampleInput" placeholder="Digite a Quantidade">
                                                </div>
                                            </div>

                                        </div>

                                        <div id="origem">

                                            <div class="row">

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Nome
                                                            Filho</label>
                                                        <input type="text" name="nomefilho[]" class="form-control">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Data de
                                                            Nascimento</label>
                                                        <input type="date" name="datanascfilho[]" class="form-control">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Certidão</label>
                                                        <input type="file" name="anexos[]" class="form-control">
                                                    </fieldset>
                                                </div>

                                            </div>

                                        </div>

                                        <div id="destino">
                                        </div>
                                        <br>
                                        <input type="button" value="Adicionar Filho" onclick="duplicarCampos();"
                                               class="btn btn-warning">
                                        <input type="button" value="Excluir Filho" onclick="removerCampos(this);"
                                               class="btn btn-danger">

                                        <br>
                                        <br>

                                        <h3>INFORMAÇÕES SOBRE SAÚDE</h3>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alergias</label>
                                                    <textarea name="alergias"
                                                              class="form-control"><?php echo $vetor['alergias']; ?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Medicação</label>
                                                    <textarea name="medicacao"
                                                              class="form-control"><?php echo $vetor['medicacao']; ?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Outros</label>
                                                    <textarea name="outros"
                                                              class="form-control"><?php echo $vetor['outros']; ?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Médico</label>
                                                    <input type="text" name="medico"
                                                           value="<?php echo $vetor['medico']; ?>" class="form-control"
                                                           id="exampleInput" placeholder="Digite o Nome do Médico">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Telefone Médico</label>
                                                    <input type="text" name="telefonemedico"
                                                           value="<?php echo $vetor['telefonemedico']; ?>"
                                                           class="form-control" placeholder="Digite o Telefone Médico"
                                                           id="telefone4">
                                                </div>
                                            </div>

                                        </div>

                                        <h3>EM CASO DE EMERGÊNCIA ENTRAR EM CONTATO COM</h3>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <input type="text" name="nomeemergencia1"
                                                           value="<?php echo $vetor['nomeemergencia1']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite o Nome">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Telefone</label>
                                                    <input type="text" name="telefoneemergencia1"
                                                           value="<?php echo $vetor['telefoneemergencia1']; ?>"
                                                           class="form-control" placeholder="Digite o Telefone"
                                                           id="telefone5">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <input type="text" name="nomeemergencia2"
                                                           value="<?php echo $vetor['nomeemergencia2']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite o Nome">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Telefone</label>
                                                    <input type="text" name="telefoneemergencia2"
                                                           value="<?php echo $vetor['telefoneemergencia2']; ?>"
                                                           class="form-control" placeholder="Digite o Telefone Médico"
                                                           id="telefone6">
                                                </div>
                                            </div>

                                        </div>

                                        <h3>OUTRAS INFORMAÇÕES IMPORTANTES</h3>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Outros</label>
                                                    <textarea name="outrasinformacoes"
                                                              class="form-control"><?php echo $vetor['outrasinformacoes']; ?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <h3>DADOS ADMISSIONAIS</h3>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Data de Admissão</label>
                                                    <input type="date" name="dataadmissao"
                                                           value="<?php echo $vetor['dataadmissao']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite o RG">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Função</label>
                                                    <input type="text" name="funcao"
                                                           value="<?php echo $vetor['funcao']; ?>" class="form-control"
                                                           placeholder="Função">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>N° Ponto</label>
                                                    <input type="number" name="nponto"
                                                           value="<?php echo $vetor['nponto']; ?>" class="form-control"
                                                           placeholder="N° Ponto">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Data do Exame Admissional</label>
                                                    <input type="date" name="dataexame"
                                                           value="<?php echo $vetor['dataexame']; ?>"
                                                           class="form-control" id="exampleInput"
                                                           placeholder="Digite o RG">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Apto</label>
                                                    <select name="apto" class="form-control">
                                                        <option value="" selected="">Selecione...</option>
                                                        <option value="1"
																												        <?php if (strcasecmp($vetor['apto'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Sim
                                                        </option>
                                                        <option value="2"
																												        <?php if (strcasecmp($vetor['apto'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Não
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>CBO N°</label>
                                                    <input type="text" name="cbo" value="<?php echo $vetor['cbo']; ?>"
                                                           class="form-control" placeholder="CBO N°">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Salário</label>
                                                    <input type="text" name="salario"
                                                           value="<?php echo number_format($vetor['salario'], 2, ',', '.'); ?>"
                                                           onKeyPress="mascara(this,mvalor)" class="form-control"
                                                           placeholder="Salário">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Por</label>
                                                    <input type="text" name="por" value="<?php echo $vetor['por']; ?>"
                                                           class="form-control" placeholder="Por">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Admissão por Contrato de Experiência?</label>
                                                    <select name="contratoexperiencia" class="form-control">
                                                        <option value="" selected="">Selecione...</option>
                                                        <option value="1"
																												        <?php if (strcasecmp($vetor['contratoexperiencia'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Sim
                                                        </option>
                                                        <option value="2"
																												        <?php if (strcasecmp($vetor['contratoexperiencia'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Não
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Por período de 30, 60 ou 90 dias</label>
                                                    <select name="periodoexperiencia" class="form-control">
                                                        <option value="" selected="">Selecione...</option>
                                                        <option value="1"
																												        <?php if (strcasecmp($vetor['periodoexperiencia'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            30 dias
                                                        </option>
                                                        <option value="2"
																												        <?php if (strcasecmp($vetor['periodoexperiencia'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            60 dias
                                                        </option>
                                                        <option value="3"
																												        <?php if (strcasecmp($vetor['periodoexperiencia'], '3') == 0) : ?>selected="selected"<?php endif; ?>>
                                                            90 dias
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Armário</label>
                                                    <input type="text" name="armario" class="form-control"
                                                           value="<?php echo $vetor['armario']; ?>">
                                                </div>
                                            </div>

                                        </div>

                                        <button type="submit" class="btn btn-primary" style="    float: left;">
                                            Cadastrar
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