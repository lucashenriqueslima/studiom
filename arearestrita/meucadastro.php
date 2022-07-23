<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id_formando'] == null || $_SESSION['id_formando'] == '') {
	echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";
}else {
	$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);
	$sql_chamados = mysqli_query($con, "select * from chamados order by id_chamado DESC");
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
                v = v.replace(/\D/g, ""); //Remove tudo o que nÃ£o Ã© dÃ­gito
                v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
                v = v.replace(/(\d)(\d{4})$/, "$1-$2"); //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
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
                        <h4 class="page-title">Meu Cadastro</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
                                </ol>
                            </nav>
                        </div>
                        <br>
											<?php
											$sql_cursos = mysqli_query($con, "select * from turmas where id_turma = '$vetor_cadastro[turma]' order by nome ASC");
											$vetor_curso = mysqli_fetch_array($sql_cursos);
											$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
											$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
											$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_curso[curso]'");
											$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
											?>
											<?php echo $vetor_curso['ncontrato'] ?>
                        - <?php echo $vetor_curso['nome'] ?> <?php echo $vetor_curso['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?></option>
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
                                <form action="recebe_alterarcadastro.php" method="post" name="cliente"
                                      enctype="multipart/form-data" onSubmit="return verificarCPF()" id="formID">

                                    <div class="row">


                                        <div class="col-md-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Cód.</label>
                                                <input type="text" name="nome"
                                                       value="<?php echo $vetor_curso['ncontrato'].'-'.$vetor_cadastro['id_cadastro']; ?>"
                                                       class="form-control" id="exampleInput"
                                                       placeholder="Digite o nome" disabled>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-8">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Nome</label>
                                                <input type="text" name="nome"
                                                       value="<?php echo $vetor_cadastro['nome']; ?>"
                                                       class="form-control" id="exampleInput"
                                                       placeholder="Digite o nome" required>
                                            </fieldset>
                                        </div>


                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="row">

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Sexo</label>
                                                        <select name="sexo" class="form-control">
                                                            <option value="" selected="">Selecione...</option>
                                                            <option value="Masculino"
																														        <?php if (strcasecmp($vetor_cadastro['sexo'], 'Masculino') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                Masculino
                                                            </option>
                                                            <option value="Feminino"
																														        <?php if (strcasecmp($vetor_cadastro['sexo'], 'Feminino') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                Feminino
                                                            </option>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Est.
                                                            Civil</label>
                                                        <select name="estadocivil" class="form-control">
                                                            <option value="" selected="">Selecione...</option>
                                                            <option value="Casado(a)"
																														        <?php if (strcasecmp($vetor_cadastro['estadocivil'], 'Casado(a)') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                Casado(a)
                                                            </option>
                                                            <option value="Solteiro(a)"
																														        <?php if (strcasecmp($vetor_cadastro['estadocivil'], 'Solteiro(a)') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                Solteiro(a)
                                                            </option>
                                                            <option value="Divorciado(a)"
																														        <?php if (strcasecmp($vetor_cadastro['estadocivil'], 'Divorciado(a)') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                Divorciado(a)
                                                            </option>
                                                            <option value="Viúvo(a)"
																														        <?php if (strcasecmp($vetor_cadastro['estadocivil'], 'Viúvo(a)') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                Viúvo(a)
                                                            </option>
                                                            <option value="Amasiado(a)"
																														        <?php if (strcasecmp($vetor_cadastro['estadocivil'], 'Amasiado(a)') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                Amasiado(a)
                                                            </option>
                                                        </select>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Data
                                                            Nasc.</label>
                                                        <input type="date"
                                                               value="<?php echo $vetor_cadastro['datanasc']; ?>"
                                                               name="datanasc" class="form-control" id="datanasc">
                                                    </fieldset>
                                                </div>

                                            </div>
                                            <!--.row-->

                                        </div>

                                        <div class="col-md-6">

                                            <div class="row">


                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">RG</label>
                                                        <input type="number" name="rg"
                                                               value="<?php echo $vetor_cadastro['rg']; ?>"
                                                               class="form-control" placeholder="RG" disabled>
                                                </div>

                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">CPF</label>
                                                        <input type="number" name="cpf"
                                                               value="<?php echo $vetor_cadastro['cpf']; ?>"
                                                               class="form-control" placeholder="CPF" disabled>
                                                    </fieldset>
                                                </div>

                                            </div>
                                            <!--.row-->

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <fieldset class="form-group">
                                                                <label class="form-label"
                                                                       for="exampleInputEmail1">CEP</label>
                                                                <input type="text" name="cep"
                                                                       value="<?php echo $vetor_cadastro['cep']; ?>"
                                                                       id="cep" class="form-control" placeholder="CEP"
                                                                       required>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <fieldset class="form-group">
                                                                <label class="form-label" for="exampleInputPassword1">Bairro</label>
                                                                <input type="text" name="bairro"
                                                                       value="<?php echo $vetor_cadastro['bairro']; ?>"
                                                                       id="bairro" class="form-control"
                                                                       placeholder="Bairro" required>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <!--.row-->

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="row">

                                                <div class="col-lg-8">
                                                    <fieldset class="form-group">
                                                        <label class="form-label"
                                                               for="exampleInputPassword1">Rua</label>
                                                        <input type="text" name="endereco"
                                                               value="<?php echo $vetor_cadastro['endereco']; ?>"
                                                               id="rua" class="form-control" placeholder="Endereço"
                                                               required>
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputPassword1">Complemento</label>
                                                        <input type="text" name="complemento"
                                                               value="<?php echo $vetor_cadastro['complemento']; ?>"
                                                               class="form-control" placeholder="Complemento" required>
                                                    </fieldset>
                                                </div>

                                            </div>

                                        </div>


                                        <div class="col-md-4">

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Número</label>
                                                        <input type="number" name="numero"
                                                               value="<?php echo $vetor_cadastro['numero']; ?>"
                                                               class="form-control" id="exampleInput"
                                                               placeholder="Número">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Cidade</label>
                                                        <input type="text" name="cidade"
                                                               value="<?php echo $vetor_cadastro['cidade']; ?>"
                                                               id="cidade" class="form-control" placeholder="Cidade"
                                                               required>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label"
                                                               for="exampleInputEmail1">Estado</label>
                                                        <input type="text" name="estado"
                                                               value="<?php echo $vetor_cadastro['estado']; ?>" id="uf"
                                                               class="form-control" placeholder="Estado" required>
                                                    </fieldset>
                                                </div>

                                            </div>
                                            <!--.row-->

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Celular com
                                                    DDD</label>
                                                <input type="text" name="telefone" id="telefone"
                                                       value="<?php echo $vetor_cadastro['telefone']; ?>"
                                                       class="form-control" placeholder="Celular">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">Telefone com
                                                    DDD</label>
                                                <input type="text" name="celular" id="telefone2"
                                                       value="<?php echo $vetor_cadastro['celular']; ?>"
                                                       class="form-control" placeholder="Telefone" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">E-mail</label>
                                                <input type="email" name="email"
                                                       value="<?php echo $vetor_cadastro['email']; ?>"
                                                       class="form-control" placeholder="E-mail" required>
                                            </fieldset>
                                        </div>

                                    </div>
                                    <!--.row-->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observações</label>
                                                <textarea name="observacoes"
                                                          class="form-control"><?php echo $vetor_cadastro['observacoes']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

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
                                                       value="<?php echo $vetor_cadastro['pai']; ?>"
                                                       class="form-control nomepais" placeholder="Pai">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>In Memoriam (Pai Falecido)</label>
                                                <select id="inmemorianpai" name="inmemorianpai"
                                                        onchange="inMemorianPai(this.value)"
                                                        class="form-control">
                                                    <option value="1"
																										        <?php if ($vetor_cadastro['inmemorianpai'] == 1) { ?>selected="selected" <?php } ?>>
                                                        Sim
                                                    </option>
                                                    <option value="0"
																										        <?php if ($vetor_cadastro['inmemorianpai'] == 0) { ?>selected="selected" <?php } ?>>
                                                        Não
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div id="paiOptions">
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
                                                                       value="<?php echo $vetor_cadastro['celularpai']; ?>"
                                                                       class="form-control"
                                                                       placeholder="Celular"></td>
                                                <td width="2%"></td>
                                                <td width="32%"><input type="text" name="telresidencial"
                                                                       id="telefone5" class="form-control"
                                                                       value="<?php echo $vetor_cadastro['telresidencial']; ?>"
                                                                       placeholder="Telefone" required="true">
                                                </td>
                                                <td width="2%"></td>
                                                <td width="32%"><input type="email" name="emailpai"
                                                                       class="form-control" id="emailpai"
                                                                       required="true"
                                                                       value="<?php echo $vetor_cadastro['emailpai']; ?>"
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
                                                <!-- BUG -->
                                                <td width="10%"><input type="text" name="cep1" id="cep1"
                                                                       class="form-control"
                                                                       value="<?php echo $vetor_cadastro['cep1']; ?>"
                                                                       placeholder="CEP" required="true"></td>
                                                <td width="2%"></td>
                                                <td width="20%"><input type="text" name="bairro1" id="bairro1"
                                                                       class="form-control"
                                                                       value="<?php echo $vetor_cadastro['bairro1']; ?>"
                                                                       placeholder="Bairro" required="true">
                                                </td>
                                                <td width="2%"></td>
                                                <td width="21%"><input type="text" name="endereco1" id="rua1"
                                                                       class="form-control"
                                                                       value="<?php echo $vetor_cadastro['endereco1']; ?>"
                                                                       placeholder="Endereço" required="true">
                                                </td>
                                                <td width="2%"></td>
                                                <td width="8%"><input type="text" name="complemento1"
                                                                      class="form-control"
                                                                      value="<?php echo $vetor_cadastro['complemento1']; ?>"
                                                                      placeholder="Complemento" required="true">
                                                </td>
                                                <td width="2%"></td>
                                                <td width="7%"><input type="number" name="numero1"
                                                                      class="form-control" id="numero1"
                                                                      value="<?php echo $vetor_cadastro['numero1']; ?>"
                                                                      placeholder="Numero" required="true"></td>
                                                <td width="2%"></td>
                                                <td width="15%"><input type="text" name="cidade1" id="cidade1"
                                                                       class="form-control"
                                                                       value="<?php echo $vetor_cadastro['cidade1']; ?>"
                                                                       placeholder="Cidade" required="true">
                                                </td>
                                                <td width="2%"></td>
                                                <td width="7%"><input type="text" name="estado1" id="uf1"
                                                                      class="form-control"
                                                                      value="<?php echo $vetor_cadastro['estado1']; ?>"
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
                                                       value="<?php echo $vetor_cadastro['mae']; ?>"
                                                       class="form-control nomepais" placeholder="Mãe">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>In Memoriam (Mãe Falecida)</label>
                                                <select id="inmemorianmae" name="inmemorianmae"
                                                        class="select-inmemorianmae form-control"
                                                        onchange="inMemorianMae(this.value)">
                                                    <option value="1"
																										        <?php if ($vetor_cadastro['inmemorianmae'] == 1) : ?>selected="selected" <?php endif; ?>>
                                                        Sim
                                                    </option>
                                                    <option value="0"
																										        <?php if ($vetor_cadastro['inmemorianmae'] == 0) : ?>selected="selected" <?php endif; ?>>
                                                        Não
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div id="maeOptions">
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
                                                                       value="<?php echo $vetor_cadastro['celularmae']; ?>"
                                                                       placeholder="Celular" required="true">
                                                </td>
                                                <td width="2%"></td>
                                                <td width="32%"><input type="text" name="telresidencial1"
                                                                       id="telefone6"
                                                                       value="<?php echo $vetor_cadastro['telresidencial1']; ?>"
                                                                       class="form-control"
                                                                       placeholder="Telefone" required="true">
                                                </td>
                                                <td width="2%"></td>
                                                <td width="32%"><input type="email" name="emailmae"
                                                                       class="form-control"
                                                                       value="<?php echo $vetor_cadastro['emailmae']; ?>"
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
                                                                       value="<?php echo $vetor_cadastro['cep2']; ?>"
                                                                       placeholder="CEP" required="true"></td>
                                                <td width="2%"></td>
                                                <td width="20%"><input type="text" name="bairro2" id="bairro2"
                                                                       class="form-control"
                                                                       value="<?php echo $vetor_cadastro['bairro2']; ?>"
                                                                       placeholder="Bairro" required="true">
                                                </td>
                                                <td width="2%"></td>
                                                <td width="21%"><input type="text" name="endereco2" id="rua2"
                                                                       class="form-control"
                                                                       value="<?php echo $vetor_cadastro['endereco2']; ?>"
                                                                       placeholder="Endereço" required="true">
                                                </td>
                                                <td width="2%"></td>
                                                <td width="8%"><input type="text" name="complemento2"
                                                                      class="form-control"
                                                                      value="<?php echo $vetor_cadastro['complemento2']; ?>"
                                                                      placeholder="Complemento" required="true">
                                                </td>
                                                <td width="2%"></td>
                                                <td width="7%"><input type="number" name="numero2"
                                                                      class="form-control" id="exampleInput"
                                                                      value="<?php echo $vetor_cadastro['numero2']; ?>"
                                                                      placeholder="Numero" required="true"></td>
                                                <td width="2%"></td>
                                                <td width="15%"><input type="text" name="cidade2" id="cidade2"
                                                                       class="form-control"
                                                                       value="<?php echo $vetor_cadastro['cidade2']; ?>"
                                                                       placeholder="Cidade" required="true">
                                                </td>
                                                <td width="2%"></td>
                                                <td width="7%"><input type="text" name="estado2" id="uf2"
                                                                      class="form-control"
                                                                      value="<?php echo $vetor_cadastro['estado2']; ?>"
                                                                      placeholder="Estado" required="true"></td>
                                            </tr>
                                        </table>

                                    </div>

                                    <h3>Outro Responsavel</h3>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nome</label>
                                                <input type="text" name="nomeresponsavel" id="nomeresponsavel"
                                                       value="<?php echo $vetor_cadastro['nomeresponsavel']; ?>"
                                                       class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Telefone</label>
                                                <input type="text" name="telefoneresponsavel"
                                                       id="telefoneresponsavel"
                                                       value="<?php echo $vetor_cadastro['telefoneresponsavel']; ?>"
                                                       class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tipo Responsável</label>
                                                <select name="tiporesponsavel" id="tiporesponsavel"
                                                        class="form-control">
                                                    <option value="<?php echo $vetor_cadastro['tiporesponsavel']; ?>"
                                                            selected><?php echo $vetor_cadastro['tiporesponsavel']; ?></option>
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
                                                        <input type="text" name="outroresponsavel"
                                                               id="outroresponsavel"
                                                               disabled required="true"
                                                               class="form-control">

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label" for="exampleInputEmail1">Este pode ser um meio
                                                    pelo qual suas fotografias poderão ser enviadas futuramente,
                                                    portanto, é muito importante que nos deixe o endereço da sua rede
                                                    social.</label>
                                                <input type="text" name="instagram"
                                                       value="<?php echo $vetor_cadastro['instagram']; ?>"
                                                       class="form-control" placeholder="Instagram">
                                            </fieldset>
                                        </div>
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInputEmail1">Facebook:</label>
                                                    <input type="text" name="facebook"
                                                           value="<?php echo $vetor_cadastro['facebook']; ?>"
                                                           class="form-control"
                                                           placeholder="Facebook">
                                                </fieldset>
                                            </div>

                                        </div>

                                    </div>
                                    <!--.row-->

                                    <button type="submit" class="btn btn-primary" style="    float: left;">Alterar
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

    <script src="../layout/assets/libs/tinymce/tinymce.min.js"></script>

    <script>
        $(function () {

            if ($("#mymce").length > 0) {
                tinymce.init({
                    selector: "textarea#mymce",
                    theme: "modern",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

                });
            }
            // ==============================================================
            // Our Visitor
            // ==============================================================

            var chart = c3.generate({
                bindto: '#visitor',
                data: {
                    columns: [
                        ['Open', 4],
                        ['Closed', 2],
                        ['In progress', 2],
                        ['Other', 0],
                    ],

                    type: 'donut',
                    tooltip: {
                        show: true
                    }
                },
                donut: {
                    label: {
                        show: false
                    },
                    title: "Tickets",
                    width: 35,

                },

                legend: {
                    hide: true
                    //or hide: 'data1'
                    //or hide: ['data1', 'data2']

                },
                color: {
                    pattern: ['#40c4ff', '#2961ff', '#ff821c', '#7e74fb']
                }
            });
        });
    </script>
    <script type="text/javascript">
        function inMemorianPai(valor) {
            if (valor == "1") {
                $('#paiOptions').hide();
                $("#paiOptions :input").attr('required', false);
            }
            if (valor == "false") {
                $('#paiOptions').show()
                $("#paiOptions :input").attr('required', true);

            }
        }

        function inMemorianMae(valor) {
            if (valor == "1") {
                $('#maeOptions').hide()
                $("#maeOptions :input").attr('required', false);
            }
            if (valor == "false") {
                $('#maeOptions').show()
                $("#maeOptions :input").attr('required', true);

            }
        }

        $(document).ready(function () {
            inMemorianPai($("#inmemorianpai").val());
            inMemorianMae($("#inmemorianmae").val());
        });

    </script>
    </body>

    </html>
<?php } ?>
