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
	$id = $_GET['id'];
	$sql = mysqli_query($con, "select * from convite_exclusive where id_exclusive = '$id'");
	$vetor = mysqli_fetch_array($sql);
	$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor[id_formando]'");
	$vetor_formando = mysqli_fetch_array($sql_formando);
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

        <link href="../layout/assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">

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

            $(document).ready(function () {
                $('#turmas').change(function () {
                    $('#formando').load('formandos_tarefa.php?load=sim&id_turma=' + $('#turmas').val());

                });

            });
        </script>
        <script src="ckeditor/ckeditor.js"></script>
    </head>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }


        /** THUMBNAILS GLOBALS **/
        .thumbnails {
            display: flex;
            flex-wrap: wrap;
        }

        .thumbnails a {
            width: 120px;
            height: 120px;
            margin: 14px;
            border-radius: 2px;
            overflow: hidden;
        }

        .thumbnails img {
            height: 100%;
            object-fit: cover;
            transition: transform .3s;
        }

        .thumbnails a:hover img {
            transform: scale(1.05);
        }

        /** THUMBNAILS GRID **/
        .thumbnails.grid a.double {
            width: calc(50% - 4px);
        }

        .thumbnails.grid img {
            width: 100%;
        }

        /** THUMBNAILS MASONRY **/
        .thumbnails.masonry a {
            flex-grow: 1;
        }

        .thumbnails.masonry img {
            min-width: 100%;
        }
    </style>

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
                        <h4 class="page-title">Arte Final - Fotografia</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Arte Final - Fotografia</a></li>
                                    <li class="breadcrumb-item">Escolha de Fotos</li>
                                    <li class="breadcrumb-item">Produtos Convite</li>
                                    <li class="breadcrumb-item">Exclusive</li>
                                    <li class="breadcrumb-item active" aria-current="page">Alterar Produto Exclusive</li>
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
                                <h4 class="card-title">Cadastro de Produto Exclusive</h4>

                                <form action="recebe_alterarexclusive.php?id=<?php echo $id; ?>" method="post"
                                      name="cliente" enctype="multipart/form-data" onSubmit="return verificarCPF()"
                                      id="formID">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Formando</label>
                                                <br>
																							<?php echo $vetor_formando['nome']; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Data Final</label>
                                                <input type="date" name="datafinal" class="form-control"
                                                       value="<?php echo $vetor['datafinal']; ?>">

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Produto</label>
                                                <select name="id_item" id="turmas" class="form-control" required="">
                                                    <option value="" selected="selected">Selecione...</option>
																									<?php
																									$sql_produtos = mysqli_query($con, "select * from tipos_produtos order by nome ASC");
																									while ($vetor_produto = mysqli_fetch_array($sql_produtos)) {
																										?>
                                                      <option value="<?php echo $vetor_produto['id_tipo']; ?>"
																											        <?php if (strcasecmp($vetor['id_item'], $vetor_produto['id_tipo']) == 0) : ?>selected="selected" <?php endif; ?>><?php echo $vetor_produto['nome'] ?></option>
																									<?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Descrição</label>
                                                <textarea name="texto" class="ckeditor"
                                                          id="editor1"><?php echo $vetor['texto']; ?></textarea>

                                            </div>
                                        </div>
                                    </div>

                                    <h3>Cadastrar Nova Página</h3>

                                    <div id="origem">

                                        <div class="row">

                                            <div class="col-lg-2">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Arquivo</label>
                                                    <input type="file" name="arquivo[]">
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-2">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">N°
                                                        Pagina</label>
                                                    <input type="number" name="npagina[]" class="form-control"
                                                           value="<?php echo $vetor['npagina']; ?>">
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-2">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Foto de
                                                        Família</label>
                                                    <select name="tipo[]" class="form-control" required="">
                                                        <option value="1">Não</option>
                                                        <option value="2">Sim</option>
                                                    </select>
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-2">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Bloqueio de
                                                        Lâmina?</label>
                                                    <select name="bloqueio[]" class="form-control">
                                                        <option value="1" selected="">Não</option>
                                                        <option value="2">Sim</option>
                                                    </select>
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-2">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Qtd
                                                        Fotos?</label>
                                                    <input type="number" name="qtdfotos[]" class="form-control">
                                                </fieldset>
                                            </div>

                                        </div>

                                    </div>

                                    <div id="destino">
                                    </div>
                                    <br>
                                    <input type="button" value="Adicionar Pagina" onclick="duplicarCampos();"
                                           class="btn btn-warning">
                                    <input type="button" value="Excluir Pagina" onclick="removerCampos(this);"
                                           class="btn btn-danger">

                                    <br>
                                    <br>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold"
                                                       for="exampleInput">Finalizado?</label>
                                                <select name="status" id="categorias" class="form-control select2">
                                                    <option value="" selected="selected">Selecione...</option>
                                                    <option value="2"
																										        <?php if (strcasecmp($vetor['status'], '2') == 0) : ?>selected="selected" <?php endif; ?>>
                                                        Em Preenchimento
                                                    </option>
                                                    <option value="5"
																										        <?php if (strcasecmp($vetor['status'], '5') == 0) : ?>selected="selected" <?php endif; ?>>
                                                        Sim
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary" style="    float: left;">Salvar
                                    </button>

                                </form>

                                <br>
                                <br>

                                <h3>Imagens Cadastradas</h3>

                                <div class="table-responsive">

                                    <table width="100%" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>
                                                <div class="a">Imagem</div>
                                            </th>
                                            <th>
                                                <div class="a">Alterar</div>
                                            </th>
                                            <th>
                                                <div class="a">N° Pagina</div>
                                            </th>
                                            <th>
                                                <div class="a">Foto Família</div>
                                            </th>
                                            <th>
                                                <div class="a">Qtd Fotos</div>
                                            </th>
                                            <th width="40%">
                                                <div class="a">Observações</div>
                                            </th>
                                            <th>
                                                <div class="a">Foto(s) Escolhida</div>
                                            </th>
                                            <th>Bloqueio?</th>
                                            <th>
                                                <div class="a">Ação</div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
																				
																				<?php
																				$sql_imagens = mysqli_query($con, "select * from convite_exclusive_itens where id_exclusive = '$id' order by npagina ASC");
																				$i = 0;
																				while ($vetor_imagens = mysqli_fetch_array($sql_imagens)) {
																					?>

                                            <form action="recebe_alterarfotoexclusive.php?id=<?php echo $id; ?>"
                                                  method="post" name="cliente" enctype="multipart/form-data"
                                                  onSubmit="return verificarCPF()" id="formID">

                                                <input type="hidden" name="id_pagina"
                                                       value="<?php echo $vetor_imagens['id_item']; ?>">

                                                <tr>
                                                    <td><img src="arquivos/<?php echo $vetor_imagens['imagem']; ?>"
                                                             width="420px"></td>
                                                    <td>
                                                        <button style="display:block;width:120px; height:30px;"
                                                                onclick="document.getElementById('getFile').click()">
                                                            Nova Imagem?
                                                        </button>
                                                        <input type="file" id="getFile" style="display:none"
                                                               name="imagem"></td>
                                                    <td><input type="number" name="npagina1"
                                                               value="<?php echo $vetor_imagens['npagina']; ?>"></td>
                                                    <td><select name="tipo" class="form-control">
                                                            <option value="1"
																														        <?php if ($vetor_imagens['tipo'] == '1') { ?>selected="" <?php } ?>>
                                                                Não
                                                            </option>
                                                            <option value="2"
																														        <?php if ($vetor_imagens['tipo'] == '2') { ?>selected="" <?php } ?>>
                                                                Sim
                                                            </option>
                                                        </select>
                                                    </td>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="qtdfotos"
                                                               value="<?= $vetor_imagens['qtdfotos']; ?>">
                                                    </td>
                                                    <td><?php echo $vetor_imagens['observacoes']; ?></td>
                                                    <td>
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
																															
																															<?php
																															$sql_fotos_cadastradas = mysqli_query($con, "select * from convite_exclusive_escolhidas where id_exclusive = '$vetor_imagens[id_item]'");
																															while ($vetor_fotos_cadastradas = mysqli_fetch_array($sql_fotos_cadastradas)) {
																																?>

                                                                  <td>
																																		
																																		<?php if ($vetor_fotos_cadastradas['tipo'] == 2) { ?>

                                                                        <div class="col-md-2">


                                                                            <a class="image-popup-vertical-fit"
                                                                               href="arquivos/<?php echo $vetor_fotos_cadastradas['foto']; ?>"><img
                                                                                        alt=""
                                                                                        src="arquivos/<?php echo $vetor_fotos_cadastradas['foto']; ?>"
                                                                                        width="120px"
                                                                                        height="120px"/></a>


                                                                        </div>

                                                                        <br>
																																			
																																			<?php
																																			$imgexplode = explode("/", $vetor_fotos_cadastradas['foto']);
																																			echo $imgexplode[count($imgexplode) - 1];
																																			?>
																																		
																																		<?php }else { ?>

                                                                        <div class="col-md-2">

                                                                            <a class="image-popup-vertical-fit"
                                                                               href="<?php echo $vetor_fotos_cadastradas['foto']; ?>"><img
                                                                                        alt=""
                                                                                        src="<?php echo $vetor_fotos_cadastradas['foto']; ?>"
                                                                                        width="120px"
                                                                                        height="120px"/></a>


                                                                        </div>

                                                                        <br>
																																			
																																			<?php
																																			$imgexplode = explode("/", $vetor_fotos_cadastradas['foto']);
																																			echo $imgexplode[count($imgexplode) - 1];
																																			?>
																																		
																																		<?php } ?>

                                                                  </td>
																															
																															<?php } ?>

                                                            </tr>
                                                            </tbody>
                                                        </table>

                                                    </td>
                                                    <td><select name="bloqueio" class="form-control">
                                                            <option value="1"
																														        <?php if ($vetor_imagens['bloqueio'] == '1') { ?>selected="" <?php } ?>>
                                                                Não
                                                            </option>
                                                            <option value="2"
																														        <?php if ($vetor_imagens['bloqueio'] == '2') { ?>selected="" <?php } ?>>
                                                                Sim
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-info mesmo-tamanho"
                                                                title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i>
                                                        </button>
                                            </form><a
                                                    href="excluirimagemexclusive.php?id=<?php echo $vetor_imagens['id_item']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro"><i class="mdi mdi-window-close"></i>
                                                </button>
                                            </a></td>
                                            </tr>
																					
																					
																					<?php $i++;
																				} ?>

                                        </tbody>
                                    </table>

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

    <script src="../layout/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="../layout/assets/libs/magnific-popup/meg.init.js"></script>
    </body>

    </html>
<?php } ?>