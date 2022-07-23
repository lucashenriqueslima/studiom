<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from usuarios where id_usuario = '{$_SESSION['id']}'"));
	$id = $_GET['id'];
	$sql = mysqli_query($con, "select * from produtos_turma where id_produto = '{$id}'");
	$vetor = mysqli_fetch_array($sql);
	$data_inicial = date('Y-m-d');
	$data_final = $vetor['dataentrega'];
	function geraTimestamp($data)
	{
		$partes = explode('-', $data);
		return mktime(0, 0, 0, $partes[1], $partes[2], $partes[0]);
	}
	
	// Usa a função criada e pega o timestamp das duas datas:
	$time_inicial = geraTimestamp($data_inicial);
	$time_final = geraTimestamp($data_final);
	// Calcula a diferença de segundos entre as duas datas:
	$diferenca = $time_final - $time_inicial; // 19522800 segundos
	// Calcula a diferença de dias
	$dias = (int)floor($diferenca / (60 * 60 * 24)); // 225 dias
	// Exibe uma mensagem de resultado:
	$dias;
	$meses = $dias / 30;
	$mesesfinal = floor($meses);
	$id_pagina = 14;
	$sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '{$id_pagina}' and id_usuario = '{$_SESSION['id']}'");
	$arquivosdeconvite = mysqli_query($con, "select * from tipos_arquivos_turma where id_turma = '{$vetor['id_turma']}'");
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
        <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">
        <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>
        <style type="text/css">

            .thumbnail {
                position: relative;
                width: 150px;
                height: 150px;
                overflow: hidden;
            }

            .thumbnail img {
                position: absolute;
                left: 50%;
                top: 50%;
                height: 100%;
                width: auto;
                -webkit-transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            .thumbnail img.portrait {
                width: 100%;
                height: auto;
            }

            .tooltip-inner {
                background-color: #4a148c !important;
                box-shadow: 0px 0px 4px black !important;
                padding: 10px !important;
            }
        </style>
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

        <script type="text/javascript">
            $(document).ready(function () {
                $('#turmas').change(function () {
                    $('#solicitante').load('formandos.php?id_turma=' + $('#turmas').val());

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
                        <!--                        <h4 class="page-title">Vendas</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Vendas</a></li>
                                    <li class="breadcrumb-item">Convite</a></li>
                                    <li class="breadcrumb-item">Produtos</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Alterar Venda</li>
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
                                <!--                                <h4 class="card-title">Alteração de Produto</h4>-->

                                <ul class="nav nav-tabs" role="tablist">

                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#dados"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Dados do Produto</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pacotes"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Produtos</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#formapagamento"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Forma de Pagamento</span></a>
                                    </li>

                                </ul>

                                <div class="tab-content tabcontent-border">

                                    <div class="tab-pane active" id="dados" role="tabpanel">

                                        <br>
                                        <br>

                                        <form action="recebe_alterarproduto.php?id=<?php echo $id; ?>" method="post"
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
																														$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '{$vetor_curso['id_instituicao']}'");
																														$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
																														$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '{$vetor_curso['curso']}'");
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

                                                <div class="col-md-12">

                                                    <div class="form-group">
                                                        <label>Tipo</label>
                                                        <select name="tipo" class="form-control" required="">
                                                            <option value="1"
																														        <?php if (strcasecmp($vetor['tipo'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Convite
                                                            </option>
                                                            <option value="2"
																														        <?php if (strcasecmp($vetor['tipo'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Fotografia
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
																							<?php if (mysqli_num_rows($arquivosdeconvite) > 0) { ?>
                                                  <div class="col-lg-3">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Data
                                                              de
                                                              Abertura da Venda</label>
                                                          <input type="date" name="dataabertura"
                                                                 value="<?php echo $vetor['dataabertura']; ?>"
                                                                 class="form-control" required="">
                                                      </fieldset>
                                                  </div>

                                                  <div class="col-lg-3">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Data
                                                              de
                                                              Encerramento da Venda</label>
                                                          <input type="date" name="termino"
                                                                 value="<?php echo $vetor['termino']; ?>"
                                                                 class="form-control" id="exampleInput" required="">
                                                      </fieldset>
                                                  </div>
																							<?php }else { ?>
                                                  <div class="col-lg-6">
                                                      <div class="alert alert-secondary" role="alert"
                                                           style="margin-top: 24px">
                                                          Você deve preencher os tipos de arquivos de convite antes de
                                                          abrir uma venda.
                                                      </div>
                                                  </div>
																							<?php } ?>
                                                
                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Mês de 
                                                            inicio do pagamento</label>
                                                        <input type="month" name="mesinicio"
                                                            value="<?php echo $vetor['mesinicio']; ?>" class="form-control"
                                                            data-toggle="tooltip" title='A quantidade de parcelas será delimitada automaticamente entre o período informado no campo "Mês de início do pagamento" e a data no campo "Data Limite para parcelamento".' required="">
                                                    </fieldset>
                                                </div>
                                                
                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Data
                                                            Limite para parcelamento</label>
                                                        <input type="date" name="dataencerramento"
                                                               value="<?php echo $vetor['dataencerramento']; ?>" class="form-control"
                                                               data-toggle="tooltip" title='Este campo é determinado automaticamente por a data informada no campo "Data de Entrega".' >
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-3">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Data de
                                                            Entrega</label>
                                                        <input type="date" name="dataentrega"
                                                               value="<?php echo $vetor['dataentrega']; ?>"
                                                               class="form-control" required="">
                                                    </fieldset>
                                                </div>

                                                

                                            </div>

                                            <div class="row">

                                                <div class="col-md-6" hidden>

                                                    <div class="form-group">
                                                        <label>Selecionar mês inicio pagamento?</label>
                                                        <select name="mesano" class="form-control" required="">
                                                            <option value="1"
                                                                                                                        <?php //if (strcasecmp($vetor['mesano'], '1') == 0) : ?>selected="selected"<?php //endif; ?>>
                                                                Não
                                                            </option>
                                                            <option value="2"
                                                                                                                        <?php if (strcasecmp($vetor['mesano'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                Sim
                                                            </option>
                                                        </select>
                                                    </div>
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
																					
																					<?php if ($vetor_permissao['alteracao'] == 1) {
																					}else { ?>
                                              <button type="submit" class="btn btn-primary" style="    float: left;">
                                                  Alterar
                                              </button><?php } ?>

                                        </form>

                                    </div>


                                    <div class="tab-pane" id="pacotes" role="tabpanel">

                                        <br>
                                        <br>

                                        <a href="cadastroprodutopacote.php?id=<?php echo $id; ?>">
                                            <button class="btn btn-primary" style="    float: left;">Novo
                                                Produto
                                            </button>
                                        </a>
                                        <br>
                                        <br>
                                        <br>
                                        <table class="table table-bordered table-striped">
                                            <thead align="center">
                                            <tr>
                                                <th><strong><h5>Produto</h5></strong></th>
                                                <th width="50%"><strong><h5>Ação</h5></strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
																						<?php
																						$pacote = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_turma WHERE id_produto = '{$id}' order by titulo ASC"));
																						$sql_itens = mysqli_query($con, "select * from pacotes_itens where id_pacote = '{$pacote['id_pacote']}' and status = '1' group by id_tipo");
																						while ($vetor_item = mysqli_fetch_array($sql_itens)) {
																							$sql_produto = mysqli_query($con, "select * from tipos_produtos where id_tipo = '{$vetor_item['id_tipo']}'");
																							$vetor_produto = mysqli_fetch_array($sql_produto);
																							?>
                                                <tr>
                                                    <td align="center"><?php echo $vetor_produto['nome']; ?></td>
                                                    <td align="center">
                                                        <a href="alterarprodutopacoteitem.php?id=<?php echo $vetor_item['id_pacote']; ?>&tipo=<?php echo $vetor_item['id_tipo'] ?>&id1=<?php echo $id; ?>"
                                                           target="_blank">
                                                            <button type="button" class="btn btn-success mesmo-tamanho"
                                                                    title="Ver ou Alterar Cadastro"><i
                                                                        class="mdi mdi-tooltip-edit"></i></button>
                                                        </a>
                                                        <a href="recebe_alterarproduto.php?id=<?php echo $id; ?>&tipo=<?php echo $vetor_item['id_tipo'] ?>&id_p=<?php echo $vetor_item['id_pacote']; ?>&remover=sim">
                                                            <button type="button" class="btn btn-danger mesmo-tamanho"
                                                                    title="Excluir Cadastro"><i
                                                                        class="mdi mdi-window-close"></i></button>
                                                        </a></td>
                                                </tr>
																						<?php } ?>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="tab-pane" id="formapagamento" role="tabpanel">

                                        <br>
                                        <br>

                                        <a href="cadastroprodutoformapag.php?id=<?php echo $id; ?>">
                                            <button class="btn btn-primary" style="    float: left;">Nova
                                                Forma de Pagamento
                                            </button>
                                        </a>
                                        <br>
                                        <br>
                                        <br>
                                        <div class="table-responsive">
                                            <table id="lang_opt2" class="table table-striped table-bordered display"
                                                   style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Forma de Pagamento</th>
                                                    <th>Quantidade Parcelas</th>
                                                    <th width="13%">Ação</th>
                                                </tr>
                                                </thead>
                                                <tbody>
																								<?php
																								$sql_formas = mysqli_query($con, "select * from formaspag_produto WHERE id_produto = '{$id}' order by id_item DESC");
																								while ($vetor_forma = mysqli_fetch_array($sql_formas)) {
																									$sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '{$vetor_forma['id_forma']}'");
																									$vetor_formapag = mysqli_fetch_array($sql_forma);
																									?>
                                                    <tr>
                                                        <td><?php echo $vetor_formapag['nome']; ?></td>
                                                        <td><?php echo $vetor_forma['qtdparcelas']; ?></td>
                                                        <td>
                                                            <a href="alterarprodutoformapag.php?id=<?php echo $vetor_forma['id_item']; ?>&id1=<?php echo $id; ?>"
                                                               target="_blank">
                                                                <button type="button"
                                                                        class="btn btn-success mesmo-tamanho"
                                                                        title="Ver ou Alterar Cadastro"><i
                                                                            class="mdi mdi-tooltip-edit"></i></button>
                                                            </a> <?php if ($vetor_permissao['exclusao'] == 1) {
																													}else { ?><a
                                                                href="confexcluirprodutoformapag.php?id=<?php echo $vetor_forma['id_item']; ?>&id1=<?php echo $id; ?>" >
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
            $('[data-toggle="tooltip"]').tooltip({
                placement: "right",
                trigger: "focus"
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