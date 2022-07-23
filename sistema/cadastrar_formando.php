<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
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

        <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../layout/dist/css/style.min.css" rel="stylesheet">

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#palco1 > div").hide();
                $("#tipobusca").change(function () {
                    $("#palco1 > div").hide();
                    $('#' + $(this).val()).show('fast');
                });
                $("#palco2 > div").hide();
                $("#tiporesponsavel").change(function () {
                    $("#palco2 > div").hide();
                    $('#' + $(this).val()).show('fast');
                });
                $("input[name='rd-sexo']").click(function () {
                    $("#palco > div").hide();
                    $('#' + $(this).val()).show('fast');
                });
            });
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

            $(document).ready(function () {

                function limpa_formulário_cep1() {
// Limpa valores do formulário de cep.
                    $("#rua1").val("");
                    $("#bairro1").val("");
                    $("#cidade1").val("");
                    $("#uf1").val("");
                    $("#ibge1").val("");
                }

//Quando o campo cep perde o foco.
                $("#cep1").blur(function () {

//Nova variável "cep" somente com dígitos.
                    var cep = $(this).val().replace(/\D/g, '');

//Verifica se campo cep possui valor informado.
                    if (cep != "") {

//Expressão regular para validar o CEP.
                        var validacep = /^[0-9]{8}$/;

//Valida o formato do CEP.
                        if (validacep.test(cep)) {

//Preenche os campos com "..." enquanto consulta webservice.
                            $("#rua1").val("...")
                            $("#bairro1").val("...")
                            $("#cidade1").val("...")
                            $("#uf1").val("...")
                            $("#ibge1").val("...")

//Consulta o webservice viacep.com.br/
                            $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                                if (!("erro" in dados)) {
//Atualiza os campos com os valores da consulta.
                                    $("#rua1").val(dados.logradouro);
                                    $("#bairro1").val(dados.bairro);
                                    $("#cidade1").val(dados.localidade);
                                    $("#uf1").val(dados.uf);
                                    $("#ibge1").val(dados.ibge);
                                } //end if.
                                else {
//CEP pesquisado não foi encontrado.
                                    limpa_formulário_cep1();
                                    alert("CEP não encontrado.");
                                }
                            });
                        } //end if.
                        else {
//cep é inválido.
                            limpa_formulário_cep1();
                            alert("Formato de CEP inválido.");
                        }
                    } //end if.
                    else {
//cep sem valor, limpa formulário.
                        limpa_formulário_cep1();
                    }
                });
            });

            $(document).ready(function () {

                function limpa_formulário_cep2() {
// Limpa valores do formulário de cep.
                    $("#rua2").val("");
                    $("#bairro2").val("");
                    $("#cidade2").val("");
                    $("#uf2").val("");
                    $("#ibge2").val("");
                }

//Quando o campo cep perde o foco.
                $("#cep2").blur(function () {

//Nova variável "cep" somente com dígitos.
                    var cep = $(this).val().replace(/\D/g, '');

//Verifica se campo cep possui valor informado.
                    if (cep != "") {

//Expressão regular para validar o CEP.
                        var validacep = /^[0-9]{8}$/;

//Valida o formato do CEP.
                        if (validacep.test(cep)) {

//Preenche os campos com "..." enquanto consulta webservice.
                            $("#rua2").val("...")
                            $("#bairro2").val("...")
                            $("#cidade2").val("...")
                            $("#uf2").val("...")
                            $("#ibge2").val("...")

//Consulta o webservice viacep.com.br/
                            $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                                if (!("erro" in dados)) {
//Atualiza os campos com os valores da consulta.
                                    $("#rua2").val(dados.logradouro);
                                    $("#bairro2").val(dados.bairro);
                                    $("#cidade2").val(dados.localidade);
                                    $("#uf2").val(dados.uf);
                                    $("#ibge2").val(dados.ibge);
                                } //end if.
                                else {
//CEP pesquisado não foi encontrado.
                                    limpa_formulário_cep2();
                                    alert("CEP não encontrado.");
                                }
                            });
                        } //end if.
                        else {
//cep é inválido.
                            limpa_formulário_cep2();
                            alert("Formato de CEP inválido.");
                        }
                    } //end if.
                    else {
//cep sem valor, limpa formulário.
                        limpa_formulário_cep2();
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
                id('telefone3').onkeypress = function () {
                    mascara(this, mtel);
                }
                id('telefone4').onkeypress = function () {
                    mascara(this, mtel);
                }
                id('telefone5').onkeypress = function () {
                    mascara(this, mtel);
                }
                id('telefone6').onkeypress = function () {
                    mascara(this, mtel);
                }
                id('telefone7').onkeypress = function () {
                    mascara(this, mtel);
                }
            }

            function validaEmail(input) {
                if (input.value != document.getElementById('txtEmail').value) {
                    input.setCustomValidity('Repita e-mail corretamente');
                } else {
                    input.setCustomValidity('');
                }
            }

            function validaCPF(input) {
                if (input.value != document.getElementById('txtcpf').value) {
                    input.setCustomValidity('Repita CPF corretamente');
                } else {
                    input.setCustomValidity('');
                }
            }

            var input = document.getElementById("emailpai");
            if (lista.value == "1_2") {
                input.disabled = true;
                input.required = false;
            } else {
                input.disabled = false;
                input.required = true;
            }

            function ativarInputDataContrato() {
                var lista = document.getElementById("tipobusca");

                var input = document.getElementById("cargo");
                if (lista.value == "2_1") {
                    input.disabled = false;
                    input.required = true;
                } else {
                    input.disabled = true;
                    input.required = false;
                }
            }

            function ativarInputOutrosContrato() {
                var lista = document.getElementById("tiporesponsavel");

                var input = document.getElementById("outrosresp");
                if (lista.value == "Outros") {
                    input.disabled = false;
                    input.required = true;
                } else {
                    input.disabled = true;
                    input.required = false;
                }
            }

            function verifica(value) {
                var input = document.getElementById("input");

                if (value == 1_2) {
                    input.disabled = false;
                    input.required = true;
                } else if (value == 2_2) {
                    input.disabled = true;
                    input.required = false;
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
                       aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                    class="nav-link sidebartoggler waves-effect waves-light"
                                    href="javascript:void(0)" data-sidebartype="mini-sidebar"><i
                                        class="mdi mdi-menu font-24"></i></a></li>


                    </ul>

                    <ul class="navbar-nav float-right">


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                        src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>"
                                        alt="user" class="rounded-circle" width="31"></a>
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
<!--                        <h4 class="page-title">Cadastro de Formandos</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Cadastros</a></li>
                                    <li class="breadcrumb-item">Formandos</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cadastrar Novo Formando</li>
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
<!--                                <h4 class="card-title">Formando</h4>-->

                                <form action="recebe_formando.php" method="post" name="cliente"
                                      enctype="multipart/form-data" onSubmit="return verificarCPF()" id="formID">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Foto</label>
                                                <input type="file" name="imagem">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Contrato</label>
                                                <select name="turma" id="turmas" class="form-control">
                                                    <option value="" selected="selected">Selecione...</option>
																									<?php
																									$sql_cursos = mysqli_query($con, "select * from turmas order by nome ASC");
																									while ($vetor_curso = mysqli_fetch_array($sql_cursos)) {
																										$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
																										$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
																										$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_curso[curso]'");
																										$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
																										?>
                                                      <option value="<?php echo $vetor_curso['id_turma']; ?>">
																												<?php echo $vetor_curso['ncontrato'] ?>
																												<?php echo $vetor_curso['nome'] ?>
																												<?php echo $vetor_curso['ano']; ?>
																												<?php echo $vetor_instituicao_inicio['sigla']; ?>
                                                      </option>
																									<?php } ?>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <table width="100%">
                                        <tr>
                                            <td width="22%"><strong>Nome Completo:</strong></td>
                                            <td width="2%"></td>
                                            <td width="10%"><strong>Sexo:</strong></td>
                                            <td width="2%"></td>
                                            <td width="10%"><strong>Est. Civil:</strong></td>
                                            <td width="2%"></td>
                                            <td width="10%"><strong>Data Nascimento:</strong></td>
                                            <td width="2%"></td>
                                            <td width="10%"><strong>RG:</strong></td>
                                            <td width="2%"></td>
                                            <td width="12%"><strong>CPF:</strong></td>
                                            <td width="2%"></td>
                                            <td width="12%"><strong>Confirmar CPF:</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="22%"><input type="text" name="nome" class="form-control"
                                                                   placeholder="Digite o nome"
                                                                   required></td>
                                            <td width="2%"></td>
                                            <td width="10%"><select name="sexo" class="form-control" required="">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="Masculino">Masculino</option>
                                                    <option value="Feminino">Feminino</option>
                                                </select>
                                            </td>
                                            <td width="2%"></td>
                                            <td width="10%"><select name="estadocivil" class="form-control" required="">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="Casado(a)">Casado(a)</option>
                                                    <option value="Solteiro(a)">Solteiro(a)</option>
                                                    <option value="Divorciado(a)">Divorciado(a)</option>
                                                    <option value="Viúvo(a)">Viúvo(a)</option>
                                                    <option value="Amasiado(a)">Amasiado(a)</option>
                                                </select></td>
                                            <td width="2%"></td>
                                            <td width="10%"><input type="date" name="datanasc" class="form-control"
                                                                   id="exampleInput" required></td>
                                            <td width="2%"></td>
                                            <td width="10%"><input type="number" name="rg" class="form-control"
                                                                   placeholder="RG" required=""></td>
                                            <td width="2%"></td>
                                            <td width="12%"><input type="number" name="cpf" class="form-control"
                                                                   id="txtcpf" placeholder="CPF"
                                                                   required=""></td>
                                            <td width="2%"></td>
                                            <td width="12%"><input type="number" name="confirmarcpf"
                                                                   class="form-control"
                                                                   placeholder="Confirmar CPF" required=""
                                                                   onkeydown="BloqueiaComando(event)"
                                                                   oninput="validaCPF(this)"
                                                                   onpaste="return OnPaste ();"></td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table width="100%">
                                        <tr>
                                            <td width="10%"><strong>CEP:</strong></td>
                                            <td width="2%"></td>
                                            <td width="20%"><strong>Bairro:</strong></td>
                                            <td width="2%"></td>
                                            <td width="21%"><strong>Endereço:</strong></td>
                                            <td width="2%"></td>
                                            <td width="8%"><strong>Complemento:</strong></td>
                                            <td width="2%"></td>
                                            <td width="7%"><strong>Número:</strong></td>
                                            <td width="2%"></td>
                                            <td width="15%"><strong>Cidade:</strong></td>
                                            <td width="2%"></td>
                                            <td width="7%"><strong>UF:</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="10%"><input type="text" name="cep" id="cep" class="form-control"
                                                                   placeholder="CEP" required>
                                            </td>
                                            <td width="2%"></td>
                                            <td width="20%"><input type="text" name="bairro" id="bairro"
                                                                   class="form-control" placeholder="Bairro"
                                                                   required></td>
                                            <td width="2%"></td>
                                            <td width="21%"><input type="text" name="endereco" id="rua"
                                                                   class="form-control" placeholder="Endereço"
                                                                   required></td>
                                            <td width="2%"></td>
                                            <td width="8%"><input type="text" name="complemento" class="form-control"
                                                                  placeholder="Complemento">
                                            </td>
                                            <td width="2%"></td>
                                            <td width="7%"><input type="number" name="numero" class="form-control"
                                                                  id="exampleInput"
                                                                  placeholder="Numero"></td>
                                            <td width="2%"></td>
                                            <td width="15%"><input type="text" name="cidade" id="cidade"
                                                                   class="form-control" placeholder="Cidade"
                                                                   required></td>
                                            <td width="2%"></td>
                                            <td width="7%"><input type="text" name="estado" id="uf" class="form-control"
                                                                  placeholder="Estado"
                                                                  required></td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table width="100%">
                                        <tr>
                                            <td width="20%"><strong>Celular com DDD:</strong></td>
                                            <td width="2%"></td>
                                            <td width="20%"><strong>Telefone residêncial com DDD:</strong></td>
                                            <td width="2%"></td>
                                            <td width="27%"><strong>Email:</strong></td>
                                            <td width="2%"></td>
                                            <td width="27%"><strong>Confirmar Email:</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="20%"><input type="text" name="telefone" id="telefone"
                                                                   class="form-control"
                                                                   placeholder="Celular" required></td>
                                            <td width="2%"></td>
                                            <td width="20%"><input type="text" name="celular" id="telefone2"
                                                                   class="form-control"
                                                                   placeholder="Telefone"></td>
                                            <td width="2%"></td>
                                            <td width="27%"><input type="email" name="email" id="txtEmail"
                                                                   class="form-control"
                                                                   placeholder="exemplo@exemplo.com.br" required></td>
                                            <td width="2%"></td>
                                            <td width="27%"><input type="email" name="email1" id="repetir_email"
                                                                   onkeydown="BloqueiaComando(event)"
                                                                   oninput="validaEmail(this)"
                                                                   onpaste="return OnPaste ();" class="form-control"
                                                                   placeholder="exemplo@exemplo.com.br" required></td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table width="100%">
                                        <tr>
                                            <td><strong>Você gostaria que o nome dos seu pais fizessem parte do seu
                                                    convite de formatura?</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select name="mostrarpai" class="form-control"
                                                        onchange="ativarInputpais(this.value)"
                                                        id="tipobusca1">
                                                    <option value="" selected="">Selecione</option>
                                                    <option value="true">Sim</option>
                                                    <option value="false">Não</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>

                                    <div id="palco">
                                        <div id="1" style="display: none;">

                                            <table width="100%">
                                                <tr>
                                                    <td><strong>Pai</strong></td>
                                                </tr>
                                            </table>
                                            <br>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nome Completo</label>
                                                        <input type="text" name="pai" id="pai"
                                                               class="form-control nomepais" placeholder="Pai">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>In Memoriam</label>
                                                        <select id="inmemoria" name="inmemorianpai"
                                                                onchange="inMemoPai(this.value)"
                                                                class="select-inmemorian form-control">
                                                            <option value="false">Não</option>
                                                            <option value="true">Sim</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="target" id="paiOps">

                                                <table width="100%">
                                                    <tr>
                                                        <td width="32%"><strong>Celular com DDD:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="32%"><strong>Telefone residêncial com DDD:</strong>
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="32%"><strong>Email:</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="32%"><input type="text" name="celularpai"
                                                                               id="celularpai" required="true"
                                                                               class="form-control"
                                                                               placeholder="Celular"></td>
                                                        <td width="2%"></td>
                                                        <td width="32%"><input type="text" name="telresidencial"
                                                                               id="telefone5" class="form-control"
                                                                               placeholder="Telefone" required="true">
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="32%"><input type="email" name="emailpai"
                                                                               class="form-control" id="emailpai"
                                                                               required="true"
                                                                               placeholder="exemplo@exemplo.com.br">
                                                        </td>
                                                    </tr>
                                                </table>
                                                <br>
                                                <table width="100%">
                                                    <tr>
                                                        <td width="10%"><strong>CEP:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="20%"><strong>Bairro:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="21%"><strong>Endereço:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="8%"><strong>Complemento:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="7%"><strong>Número:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="15%"><strong>Cidade:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="7%"><strong>UF:</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="10%"><input type="text" name="cep1" id="cep1"
                                                                               class="form-control"
                                                                               placeholder="CEP" required="true"></td>
                                                        <td width="2%"></td>
                                                        <td width="20%"><input type="text" name="bairro1" id="bairro1"
                                                                               class="form-control"
                                                                               placeholder="Bairro" required="true">
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="21%"><input type="text" name="endereco1" id="rua1"
                                                                               class="form-control"
                                                                               placeholder="Endereço" required="true">
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="8%"><input type="text" name="complemento1"
                                                                              class="form-control"
                                                                              placeholder="Complemento" required="true">
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="7%"><input type="number" name="numero1"
                                                                              class="form-control" id="exampleInput"
                                                                              placeholder="Numero" required="true"></td>
                                                        <td width="2%"></td>
                                                        <td width="15%"><input type="text" name="cidade1" id="cidade1"
                                                                               class="form-control"
                                                                               placeholder="Cidade" required="true">
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="7%"><input type="text" name="estado1" id="uf1"
                                                                              class="form-control"
                                                                              placeholder="Estado" required="true"></td>
                                                    </tr>
                                                </table>

                                            </div>

                                            <br>
                                            <table width="100%">
                                                <tr>
                                                    <td><strong>Mãe</strong></td>
                                                </tr>
                                            </table>
                                            <br>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nome Completo</label>
                                                        <input type="text" name="mae" id="mae"
                                                               class="form-control nomepais" placeholder="Mãe">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>In Memoriam</label>
                                                        <select id="inmemoria1" name="inmemorianmae"
                                                                class="select-inmemorianmae form-control"
                                                                onchange="inMemoMae(this.value)">
                                                            <option value="false">Não</option>
                                                            <option value="true">Sim</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="target1" id="maeOps">

                                                <table width="100%">
                                                    <tr>
                                                        <td width="32%"><strong>Celular com DDD:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="32%"><strong>Telefone residêncial com DDD:</strong>
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="32%"><strong>Email:</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="32%"><input type="text" name="celularmae"
                                                                               id="telefone4" class="form-control"
                                                                               placeholder="Celular" required="true">
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="32%"><input type="text" name="telresidencial1"
                                                                               id="telefone6"
                                                                               class="form-control"
                                                                               placeholder="Telefone" required="true">
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="32%"><input type="email" name="emailmae"
                                                                               class="form-control"
                                                                               placeholder="exemplo@exemplo.com.br"
                                                                               required="true"></td>
                                                    </tr>
                                                </table>
                                                <br>
                                                <table width="100%">
                                                    <tr>
                                                        <td width="10%"><strong>CEP:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="20%"><strong>Bairro:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="21%"><strong>Endereço:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="8%"><strong>Complemento:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="7%"><strong>Número:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="15%"><strong>Cidade:</strong></td>
                                                        <td width="2%"></td>
                                                        <td width="7%"><strong>UF:</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="10%"><input type="text" name="cep2" id="cep2"
                                                                               class="form-control"
                                                                               placeholder="CEP" required="true"></td>
                                                        <td width="2%"></td>
                                                        <td width="20%"><input type="text" name="bairro2" id="bairro2"
                                                                               class="form-control"
                                                                               placeholder="Bairro" required="true">
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="21%"><input type="text" name="endereco2" id="rua2"
                                                                               class="form-control"
                                                                               placeholder="Endereço" required="true">
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="8%"><input type="text" name="complemento2"
                                                                              class="form-control"
                                                                              placeholder="Complemento" required="true">
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="7%"><input type="number" name="numero2"
                                                                              class="form-control" id="exampleInput"
                                                                              placeholder="Numero" required="true"></td>
                                                        <td width="2%"></td>
                                                        <td width="15%"><input type="text" name="cidade2" id="cidade2"
                                                                               class="form-control"
                                                                               placeholder="Cidade" required="true">
                                                        </td>
                                                        <td width="2%"></td>
                                                        <td width="7%"><input type="text" name="estado2" id="uf2"
                                                                              class="form-control"
                                                                              placeholder="Estado" required="true"></td>
                                                    </tr>
                                                </table>

                                            </div>

                                            <br>
                                            <br>
                                        </div>
                                    </div>

                                    <strong>
                                        <div align="justify">Se o Studio M precisar falar contigo e não conseguir por
                                            algum motivo, você pode nos
                                            deixar o contato de algum responsável?
                                        </div>
                                    </strong>

                                    <br>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nome</label>
                                                <input type="text" name="nomeresponsavel" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Telefone</label>
                                                <input type="text" name="telefoneresponsavel" id="telefone7"
                                                       class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tipo Responsável</label>
                                                <select name="tiporesponsavel" id="tiporesponsavel"
                                                        onchange="ativarInputOutrosContrato()"
                                                        class="form-control" required>
                                                    <option value="">Selecione...</option>
                                                    <option value="Pai">Pai</option>
                                                    <option value="Mãe">Mãe</option>
                                                    <option value="Cônjuge">Cônjuge</option>
                                                    <option value="Tio">Tio</option>
                                                    <option value="Tia">Tia</option>
                                                    <option value="Padrinho">Padrinho</option>
                                                    <option value="Madrinha">Madrinha</option>
                                                    <option value="Irmã">Irmã</option>
                                                    <option value="Irmão">Irmão</option>
                                                    <option value="Avô">Avô</option>
                                                    <option value="Avó">Avó</option>
                                                    <option value="Outros">Outros</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <div id="palco2">
                                                    <div id="Outros">


                                                        <label>Tipo Responsável</label>
                                                        <input type="text" name="outroresponsavel" id="outrosresp"
                                                               disabled required="true"
                                                               class="form-control">

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><strong>Comissão de Formatura</strong></label>
                                                <select name="comissao" id="tipobusca" class="form-control"
                                                        onchange="ativarInputDataContrato()"
                                                        required>
                                                    <option value="" selected="selected">Selecione a Opção</option>
                                                    <option value="1_1">Não</option>
                                                    <option value="2_1">Sim</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="palco1">

                                        <div id="2_1">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><strong>Cargo</strong></label>

                                                        <select name="cargo" id="cargo" class="form-control" disabled
                                                                required="true">
                                                            <option value="">Selecione...</option>
                                                            <option value="Presidente">Presidente</option>
                                                            <option value="Vice-Presidente">Vice-Presidente</option>
                                                            <option value="Tesoureiro (a)">Tesoureiro (a)</option>
                                                            <option value="Secretário (a)">Secretário (a)</option>
                                                            <option value="Coordenador de Eventos">Coordenador de
                                                                Eventos
                                                            </option>
                                                        </select>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <br>

                                    <strong>
                                        <div align="justify">Este pode ser um meio pelo qual suas fotografias poderão
                                            ser enviadas futuramente,
                                            portanto, é muito importante que nos deixe o endereço da sua rede social.
                                        </div>
                                    </strong>

                                    <br>

                                    <table width="100%">
                                        <tr>
                                            <td width="100%"><strong>Instagram:</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="100%"><input type="text" name="instagram" class="form-control"
                                                                    placeholder="Digite seu Instagram"></td>
                                        </tr>
                                        <tr>
                                            <td width="100%"><strong>Facebook:</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="100%"><input type="text" name="facebook" class="form-control"
                                                                    placeholder="Cole o link de seu facebook"></td>
                                        </tr>
                                    </table>

                                    <br>
                                    <br>

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
    <script type="text/javascript">

        function ativarInputpais(a) {
            if (a == "true") {
                $('div#1').css('display', 'block')
                $('div#1 :input').attr('required', true)
            } else {
                $('div#1').css('display', 'none')
                $('div#1 :input').attr('required', false)
            }
        }

        function inMemoPai(a) {
            if (a == "true") {
                $('#paiOps').hide()
                $("#paiOps :input").attr('required', false);
            }
            if (a == "false") {
                $('#paiOps').show()
                $("#paiOps :input").attr('required', true);

            }
        }

        function inMemoMae(a) {
            if (a == "true") {
                $('#maeOps').hide()
                $("#maeOps :input").attr('required', false);
            }
            if (a == "false") {
                $('#maeOps').show()
                $("#maeOps :input").attr('required', true);
            }
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