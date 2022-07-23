<?php
function formatarCPF_CNPJ($campo, $formatado = true)
{
	//retira formato
	$codigoLimpo = preg_replace("[' '-./ t]", '', $campo);
	// pega o tamanho da string menos os digitos verificadores
	$tamanho = (strlen($codigoLimpo) - 2);
	//verifica se o tamanho do cÃ³digo informado Ã© vÃ¡lido
	if ($tamanho != 9 && $tamanho != 12) {
		return false;
	}
	if ($formatado) {
		// seleciona a mÃ¡scara para cpf ou cnpj
		$mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';
		$indice = -1;
		for ($i = 0; $i < strlen($mascara); $i++) {
			if ($mascara[$i] == '#') {
				$mascara[$i] = $codigoLimpo[++$indice];
			}
		}
		//retorna o campo formatado
		$retorno = $mascara;
	}else {
		//se nÃ£o quer formatado, retorna o campo limpo
		$retorno = $codigoLimpo;
	}
	return $retorno;
}

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
	$id = $_GET['id'];
	$sql = "select * from clientes where id_cli = '$id'";
	$res = mysqli_query($con, $sql);
	$vetor = mysqli_fetch_array($res);
	$id_pagina = 1;
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
        <link rel="stylesheet" type="text/css" href="../layout/assets/libs/select2/dist/css/select2.min.css">

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

            function duplicarCampos() {
                var clone = document.getElementById('origem').cloneNode(true);
                var destino = document.getElementById('destino');
                destino.appendChild(clone);
                var camposClonados = clone.getElementsByTagName('input');
                for (i = 0; i < camposClonados.length; i++) {
                    camposClonados[i].value = '';
                }
                $('.select2').each(function () {
                    $(this).select2({
                        dropdownParent: $('#formID'),
                        width: 'resolve'
                    });
                });
            }

            function removerCampos(id) {
                var node1 = document.getElementById('destino');
                node1.removeChild(node1.childNodes[0]);
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
                        <h4 class="page-title">Cadastros Gerais</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Fornecedores</li>
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
                                <h4 class="card-title">Fornecedores</h4>

                                <ul class="nav nav-tabs" role="tablist">

                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#dados"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Dados do Fornecedor</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#interacoes"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Interações</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#documentos"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Documentos</span></a>
                                    </li>

                                </ul>

                                <div class="tab-content tabcontent-border">

                                    <div class="tab-pane active" id="dados" role="tabpanel">

                                        <br>
                                        <br>

                                        <form action="recebe_alterarfornecedor.php?id=<?php echo $id; ?>" method="post"
                                              name="cliente" enctype="multipart/form-data" id="formID">
                                            <input type="hidden" name="tipocad" value="2">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Nome ou
                                                            Razão Social</label>
                                                        <input type="text" name="nome" class="form-control"
                                                                value="<?php echo $vetor['nome']; ?>"
                                                               placeholder="Digite o nome">
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->

                                            <div class="row">

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Tipo
                                                            Cadastro</label>
                                                        <select name="tipo" id="tipobusca" class="select2 form-control" style="width: 100%;"
                                                                required="">
                                                            <option value="" selected="">Selecione</option>
                                                            <option value="1"
																														        <?php if (strcasecmp($vetor['tipo'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Física
                                                            </option>
                                                            <option value="2"
																														        <?php if (strcasecmp($vetor['tipo'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Jurídica
                                                            </option>
                                                        </select>
                                                    </fieldset>
                                                </div>
																							
																							<?php if ($vetor['tipo'] == 1) { ?>

                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group">
                                                          <label class="form-label"
                                                                 for="exampleInputPassword1">CPF</label>
                                                          <input type="text" name="cpfcnpj"
                                                                 value="<?php echo $vetor['cpfcnpj']; ?>"
                                                                 class="form-control" 
                                                                 placeholder="Digite apenas os numeros">
                                                      </fieldset>
                                                  </div>

                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group">
                                                          <label class="form-label" for="exampleInputPassword1">Data de
                                                              Nascimento</label>
                                                          <input type="date" name="datanasc"
                                                                 value="<?php echo $vetor['datanasc']; ?>"
                                                                 class="form-control" >
                                                      </fieldset>
                                                  </div>
																							
																							<?php }
																							if ($vetor['tipo'] == 2) { ?>

                                                  <div class="col-lg-8">

                                                      <div class="row">

                                                          <div class="col-lg-4">
                                                              <fieldset class="form-group">
                                                                  <label class="form-label" for="exampleInputPassword1">CNPJ</label>
                                                                  <input type="text" name="cpfcnpj1"
                                                                         value="<?php echo $vetor['cpfcnpj']; ?>"
                                                                         class="form-control" 
                                                                         placeholder="Digite apenas os numeros"
                                                                         pattern="[0-9]+$">
                                                              </fieldset>
                                                          </div>

                                                          <div class="col-lg-4">
                                                              <fieldset class="form-group">
                                                                  <label class="form-label" for="exampleInputPassword1">Data
                                                                      de Fundação</label>
                                                                  <input type="date"
                                                                         value="<?php echo $vetor['datanasc']; ?>"
                                                                         name="datanasc1" class="form-control"
                                                                         >
                                                              </fieldset>
                                                          </div>

                                                          <div class="col-lg-4">
                                                              <fieldset class="form-group">
                                                                  <label class="form-label" for="exampleInputPassword1">Logo
                                                                      / Fachada</label>
                                                                  <br>
                                                                  <img src="arquivos/<?php echo $vetor['logo']; ?>"
                                                                       width="180px"> Alterar imagem?
                                                                  <input type="file" name="logo" class="form-control"
                                                                         >
                                                              </fieldset>
                                                          </div>

                                                      </div>

                                                  </div>
																							
																							<?php } ?>

                                            </div><!--.row-->

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Nome do
                                                            Responsável</label>
                                                        <input type="text" name="nomeresp" class="form-control"
                                                               
                                                               value="<?php echo $vetor['nomeresp']; ?>"
                                                               placeholder="Digite o nome">
                                                    </fieldset>
                                                </div>

                                            </div><!--.row-->

                                            <div id="origem">

                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold" for="exampleInput">Categorias</label>
                                                            <select name="categorias[]" class="select2 form-control" style="width: 100%;">
                                                                <option value="" selected="selected">Selecione...
                                                                </option>
																															<?php
																															$sql_categoria = mysqli_query($con, "select * from categoriafornecedor order by nome ASC");
																															while ($vetor_categoria = mysqli_fetch_array($sql_categoria)) {
																																?>
                                                                  <option value="<?php echo $vetor_categoria['id_categoria']; ?>"><?php echo $vetor_categoria['nome'] ?></option>
																															<?php } ?>
                                                            </select>
                                                        </fieldset>
                                                    </div>

                                                </div>

                                            </div>

                                            <div id="destino">
                                            </div>
                                            <br>
                                            <input type="button" value="Adicionar Categoria" onclick="duplicarCampos();"
                                                   class="btn btn-warning">
                                            <input type="button" value="Excluir Categoria"
                                                   onclick="removerCampos(this);" class="btn btn-danger">

                                            <br>
                                            <br>

                                            <h3>Categorias Cadastradas</h3>

                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Categoria</th>
                                                    <th width="13%">Ação</th>
                                                </tr>
                                                </thead>
                                                <tbody>
																								<?php
																								$sql_pacotes = mysqli_query($con, "select * from fornecedor_categoria where id_fornecedor = '$id'");
																								while ($vetor_pacote = mysqli_fetch_array($sql_pacotes)) {
																									$sql_categoria = mysqli_query($con, "select * from categoriafornecedor where id_categoria = '$vetor_pacote[id_categoria]'");
																									$vetor_categoria = mysqli_fetch_array($sql_categoria);
																									?>
                                                    <tr>
                                                        <td><?php echo $vetor_categoria['nome']; ?></td>
                                                        <td><?php if ($vetor_permissao['exclusao'] == 1) {
																													}else { ?><a
                                                                href="confexcluircatfornecedor.php?id=<?php echo $vetor_pacote['id_cat']; ?>&id1=<?php echo $id; ?>" >
                                                                    <button type="button"
                                                                            class="btn btn-danger mesmo-tamanho"
                                                                            title="Excluir Cadastro"><i
                                                                                class="mdi mdi-window-close"></i>
                                                                    </button></a><?php } ?></td>
                                                    </tr>
																								<?php } ?>
                                                </tbody>
                                            </table>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">CEP</label>
                                                        <input type="text" name="cep"
                                                               value="<?php echo $vetor['cep']; ?>" id="cep"
                                                               class="form-control"  placeholder="CEP">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label"
                                                               for="exampleInputPassword1">Rua</label>
                                                        <input type="text" name="endereco" id="rua"
                                                               value="<?php echo $vetor['endereco']; ?>"
                                                               class="form-control" 
                                                               placeholder="Endereço">
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Numero</label>
                                                        <input type="text" name="numero"
                                                               value="<?php echo $vetor['numero']; ?>"
                                                               class="form-control" 
                                                               placeholder="Numero">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label"
                                                               for="exampleInputEmail1">Complemento</label>
                                                        <input type="text" name="complemento" class="form-control"
                                                               value="<?php echo $vetor['complemento']; ?>"
                                                                placeholder="Complemento">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label"
                                                               for="exampleInputPassword1">Bairro</label>
                                                        <input type="text" name="bairro" id="bairro"
                                                               class="form-control"
                                                               value="<?php echo $vetor['bairro']; ?>" 
                                                               placeholder="Bairro">
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Cidade</label>
                                                        <input type="text" name="cidade" id="cidade"
                                                               class="form-control"
                                                               value="<?php echo $vetor['cidade']; ?>" 
                                                               placeholder="Cidade">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label"
                                                               for="exampleInputEmail1">Estado</label>
                                                        <input type="text" name="estado" id="uf" class="form-control"
                                                               value="<?php echo $vetor['estado']; ?>" 
                                                               placeholder="Estado">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputPassword1">Codigo
                                                            Municipio</label>
                                                        <input type="text" name="codigoibge" id="ibge"
                                                               value="<?php echo $vetor['codigoibge']; ?>"
                                                               class="form-control" 
                                                               placeholder="Codigo Municipio">
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Telefone</label>
                                                        <input type="text" name="telefone" id="telefone"
                                                               class="form-control"
                                                               value="<?php echo $vetor['telefone']; ?>"
                                                                placeholder="Telefone">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label"
                                                               for="exampleInputEmail1">Celular</label>
                                                        <input type="text" name="celular" id="telefone2"
                                                               class="form-control"
                                                               value="<?php echo $vetor['celular']; ?>"
                                                                placeholder="Celular">
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label"
                                                               for="exampleInputPassword1">E-mail</label>
                                                        <input type="text" name="email" class="form-control"
                                                               value="<?php echo $vetor['email']; ?>" 
                                                               placeholder="Digite seu E-mail">
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Classificação</label>
                                                        <select name="classificacao" class="form-control select2"
                                                                style="width: 100%;" required>
                                                            <option value="0"
																														        <?php if (strcasecmp($vetor['classificacao'], '0') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                0
                                                            </option>
                                                            <option value="1"
																														        <?php if (strcasecmp($vetor['classificacao'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                1
                                                            </option>
                                                            <option value="2"
																														        <?php if (strcasecmp($vetor['classificacao'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                2
                                                            </option>
                                                            <option value="3"
																														        <?php if (strcasecmp($vetor['classificacao'], '3') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                3
                                                            </option>
                                                            <option value="4"
																														        <?php if (strcasecmp($vetor['classificacao'], '4') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                4
                                                            </option>
                                                            <option value="5"
																														        <?php if (strcasecmp($vetor['classificacao'], '5') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                5
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div><!--.row-->

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Banco</label>
                                                        <input type="text" name="banco"
                                                               value="<?php echo $vetor['banco']; ?>"
                                                               class="form-control" 
                                                               placeholder="Nome do Banco">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Agencia</label>
                                                        <input type="text" name="agencia"
                                                               value="<?php echo $vetor['agencia']; ?>"
                                                               class="form-control" placeholder="Agencia">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Conta</label>
                                                        <input type="text" name="conta"
                                                               value="<?php echo $vetor['conta']; ?>"
                                                               class="form-control" placeholder="Conta">
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


                                            <div class="form-group row">
                                                <label for="exampleSelect" class="col-sm-2 form-control-label">Observações</label>
                                                <div class="col-sm-10">
                                                    <textarea rows="4" name="anotacoes" class="form-control"
                                                              placeholder="Digite suas Observações"><?php echo $vetor['anotacoes']; ?></textarea>
                                                </div>
                                            </div>
																					
																					<?php if ($vetor_permissao['alteracao'] == 1) {
																					}else { ?>
                                              <button type="submit" class="btn btn-primary" style="    float: left;">
                                                  Salvar
                                              </button><?php } ?>
                                        </form>

                                    </div>

                                    <div class="tab-pane" id="interacoes" role="tabpanel">

                                        <br>
                                        <br>

                                        <a href="cadastrointeracaofornecedor.php?id=<?php echo $id; ?>" target="_blank">
                                            <button type="button" class="btn btn-primary" style="    float: left;">
                                                Cadastrar Interação
                                            </button>
                                        </a>

                                        <br>
                                        <br>
                                        <br>

                                        <div class="table-responsive">

                                            <table id="lang_opt1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Hora</th>
                                                    <th>Meio</th>
                                                    <th>Assunto</th>
                                                    <th width="80%">Ocorrência</th>
                                                </tr>
                                                </thead>
                                                <tbody>
																								<?php
																								$sql_interacoes = mysqli_query($con, "select * from interacao_fornecedor where id_fornecedor = '$id' order by id_interacao DESC");
																								while ($vetor_interacao = mysqli_fetch_array($sql_interacoes)) {
																									$sql_tipo = mysqli_query($con, "select * from tipo_interacao where id_tipo = '$vetor_interacao[tipo]'");
																									$vetor_tipo = mysqli_fetch_array($sql_tipo);
																									$sql_assunto = mysqli_query($con, "select * from assuntos where id_assunto = '$vetor_interacao[assunto]'");
																									$vetor_assunto = mysqli_fetch_array($sql_assunto);
																									?>
                                                    <tr>
                                                        <td><?php echo date('d/m/Y', strtotime($vetor_interacao['data'])); ?></td>
                                                        <td><?php echo $vetor_interacao['hora']; ?></td>
                                                        <td><?php echo $vetor_tipo['nome']; ?></td>
                                                        <td><?php echo $vetor_assunto['nome']; ?></td>
                                                        <td><?php echo $vetor_interacao['ocorrencia']; ?></td>
                                                    </tr>
																								<?php } ?>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                    <div class="tab-pane" id="documentos" role="tabpanel">

                                        <br>
                                        <br>

                                        <a href="cadastroarquivofornecedor.php?id=<?php echo $id; ?>">
                                            <button type="button" class="btn btn-primary" style="    float: left;">
                                                Cadastrar Arquivo
                                            </button>
                                        </a>

                                        <br>
                                        <br>
                                        <br>

                                        <div class="table-responsive">

                                            <table id="lang_opt2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Titulo</th>
                                                    <th>Data</th>
                                                    <th>Hora</th>
                                                    <th>Arquivo</th>
                                                </tr>
                                                </thead>
                                                <tbody>
																								<?php
																								$sql_arquivos = mysqli_query($con, "select * from arquivos_fornecedor where id_fornecedor = '$id' order by id_arquivo DESC");
																								while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
																									?>
                                                    <tr>
                                                        <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?></td>
                                                        <td><?php echo $vetor_arquivo['hora']; ?></td>
                                                        <td><a href="arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                               target="_blank">
                                                                <button type="button" class="btn btn-default">Arquivo
                                                                </button>
                                                            </a> <?php if ($vetor_permissao['exclusao'] == 1) {
																													}else { ?><a
                                                                href="excluirarquivofornecedor.php?id=<?php echo $vetor_arquivo['id_arquivo']; ?>&id1=<?php echo $id; ?>"
                                                                target="_blank">
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').each(function () {
                $(this).select2({
                    dropdownParent: $('#formID'),
                    width: 'resolve'
                });
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
    </body>

    </html>
<?php } ?>