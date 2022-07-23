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
	$id = $_GET['id'];
	$sql_escolha = mysqli_query($con, "select * from escolha_fotos where id_formando = '$_SESSION[id_formando]' and id_escolha = '$id'");
	$vetor_escolha = mysqli_fetch_array($sql_escolha);
	$sql_tipos = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '$vetor_escolha[id_item]'");
	$vetor_tipos = mysqli_fetch_array($sql_tipos);
	$sql_itens = mysqli_query($con, "select * from escolha_fotos_itens where id_escolha = '$vetor_escolha[id_escolha]' order by npagina ASC");
	$sql_itens_aprovacao = mysqli_query($con, "select * from escolha_fotos_itens where id_escolha = '$vetor_escolha[id_escolha]' and (bloqueio is null or bloqueio = 1) order by npagina ASC");
	$sql_itens2 = mysqli_query($con, "select * from escolha_fotos_itens where id_escolha = '$vetor_escolha[id_escolha]' and status = '2' order by npagina ASC");
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

        <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>
        <!-- Custom CSS -->
        <link href="../layout/dist/css/style.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">
        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
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
            .testimonial-group {
                display: block;
                overflow-y: auto;
                width: 50vw;
            }
        </style>

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
                                    <li class="breadcrumb-item">Escolha de Fotos</a></li>
                                    <li class="breadcrumb-item">Produtos Fotografia</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Álbum</li>
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
                                <h4 class="card-title"><?php echo $vetor_tipos['nome']; ?></h4>

                                <div align="center" style="width: 100%; background-color: #fff;">
																	
																	<?php while ($vetor_item = mysqli_fetch_array($sql_itens)) { ?>

                                    <div id="<?php echo $vetor_item['id_item']; ?>">

                                        <script type="text/javascript">
                                            //<!--
                                            function Mudarestado(el) {
                                                var display = document.getElementById(el).style.display;
                                                if (display == "none")
                                                    document.getElementById(el).style.display = 'block';
                                                else
                                                    document.getElementById(el).style.display = 'none';
                                            }

                                            function duplicarCampos<?php echo $vetor_item['id_item']; ?>() {
                                                var clone = document.getElementById('origem<?php echo $vetor_item['id_item']; ?>').cloneNode(true);
                                                var destino = document.getElementById('destino<?php echo $vetor_item['id_item']; ?>');
                                                destino.appendChild(clone);
                                                var camposClonados = clone.getElementsByTagName('input');
                                                for (i = 0; i < camposClonados.length; i++) {
                                                    camposClonados[i].value = '';
                                                }
                                            }

                                            function removerCampos<?php echo $vetor_item['id_item']; ?>(id) {
                                                var node1 = document.getElementById('destino<?php echo $vetor_item['id_item']; ?>');
                                                node1.removeChild(node1.childNodes[0]);
                                            }

                                            //
                                            //-->
                                        </script>

                                        <div id="Lamina-<?php echo $vetor_item['id_item']; ?>"
                                             id="Lamina-<?php echo $vetor_item['id_item']; ?>">

                                            <input type="hidden" name="id_item[]"
                                                   value="<?php echo $vetor_item['id_pagina']; ?>">

                                            <table width="100%">
                                                <tr>
                                                    <td valign="top">

                                                        <h4>Lâmina N° <?php echo $vetor_item['npagina']; ?></h4>

                                                        <br>

                                                        <img src="../sistema/arquivos/turmas/<?php echo $vetor_item['imagem']; ?>"
                                                             height="450px">

                                                        <br>
                                                        <br>
																											
																											<?php
																											if ($vetor_item['bloqueio'] != '2') {
																											if ($vetor_item['status'] == 1) {
																											?>

                                                        <button type="button"
                                                                class="btn waves-effect waves-light btn-secondary"
                                                                onclick="Mudarestado('minhaDivcad<?php echo $vetor_item['id_item']; ?>')">
                                                            Selecionar Foto(s)
                                                        </button>
                                                        <br>
                                                        <br>

                                                        <div id="minhaDivcad<?php echo $vetor_item['id_item']; ?>"
                                                             style="display:none; background-color: #E8E8E8;">

                                                            <form action="recebe_escolhadefoto.php?id=<?php echo $vetor_item['id_item']; ?>&id_escolha=<?php echo $vetor_escolha['id_escolha']; ?>"
                                                                  enctype="multipart/form-data" method="POST">

                                                                <br>

                                                                <table width="100%">

                                                                    <tr>

                                                                        <td width="1%"></td>
                                                                        <td>

                                                                            <h3>Arquivo Studio M</h3>

                                                                            <div class="row">

                                                                                <div class="col-lg-3">
                                                                                    <fieldset class="form-group">
                                                                                        <select name="preeventos"
                                                                                                id="preeventos<?php echo $vetor_item['id_item']; ?>"
                                                                                                class="form-control"
                                                                                                onchange="myFunction()">
                                                                                            <option value=""
                                                                                                    selected="selected">
                                                                                                Selecione...
                                                                                            </option>
																																													<?php
																																													$sql_eventos = mysqli_query($con, "select * from eventosformando where id_formando = '$vetor_cadastro[id_formando]' order by id_evento DESC");
																																													while ($vetor_eventos = mysqli_fetch_array($sql_eventos)) {
																																														?>
                                                                                              <option value="<?php echo $vetor_eventos['id_evento']; ?>"><?php echo $vetor_eventos['titulo'] ?></option>
																																													<?php } ?>
                                                                                        </select>
                                                                                    </fieldset>
                                                                                </div>
                                                                            </div>

                                                                        </td>

                                                                    </tr>

                                                                    <tr>
                                                                        <td width="1%"></td>
                                                                        <td>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div id="resultado<?php echo $vetor_item['id_item']; ?>"
                                                                                         style="margin-left: 1%; float: center; width: 800px;"></div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
																																	
																																	<?php if ($vetor_escolha['status'] != 4) { ?>


                                                                      <tr>
                                                                          <td width="1%"></td>
                                                                          <td>

                                                                              <div class="row">
                                                                                  <div class="col-md-12">
                                                                                      <div class="form-group">
                                                                                          <label>Observações</label>
                                                                                          <textarea name="observacoes"
                                                                                                    class="form-control"><?php echo $vetor['observacoes']; ?></textarea>
                                                                                      </div>
                                                                                  </div>
                                                                              </div>

                                                                          </td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td></td>
                                                                          <td></td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td></td>
                                                                          <td>
                                                                              <button type="submit"
                                                                                      class="btn btn-primary"
                                                                                      style="    float: left;">Salvar
                                                                                  Escolha(s)
                                                                              </button>
                                                                          </td>
                                                                      </tr>
																																	
																																	<?php } ?>


                                                                    <tr>
                                                                        <td width="1%"></td>
                                                                        <td>

                                                                            <h3>Arquivo pessoal</h3>

                                                                            <br>

                                                                            <div id="origem<?php echo $vetor_item['id_item']; ?>">

                                                                                <div class="row">

                                                                                    <div class="col-lg-4">
                                                                                        <fieldset class="form-group">
                                                                                            <label class="form-label semibold"
                                                                                                   for="exampleInput">Selecione
                                                                                                a Foto</label>
                                                                                            <input type="file"
                                                                                                   name="imagem_up[]"
                                                                                                   class="form-control">
                                                                                        </fieldset>
                                                                                    </div>

                                                                                </div>

                                                                            </div>

                                                                            <div id="destino<?php echo $vetor_item['id_item']; ?>">
                                                                            </div>
                                                                            <br>
                                                                            <input type="button" value="Adicionar Foto"
                                                                                   onclick="duplicarCampos<?php echo $vetor_item['id_item']; ?>();"
                                                                                   class="btn btn-warning">
                                                                            <input type="button" value="Excluir Foto"
                                                                                   onclick="removerCampos<?php echo $vetor_item['id_item']; ?>(this);"
                                                                                   class="btn btn-danger">

                                                                            <br>
                                                                            <br>

                                                                        </td>
                                                                    </tr>

                                                                </table>


                                                                <script type="text/javascript">
                                                                    //Fica monitorando o evento 'change' do id=cursos, ao ocorrer este evento é disparado a função
                                                                    document.getElementById('preeventos<?php echo $vetor_item['id_item']; ?>').addEventListener('change', function () {
                                                                        //Caso queira passar mais de fique com o exemplo abaixo:
                                                                        //var params = "lorem=ipsum&name=binny";

                                                                        //Porem só precisamos passar o value do 'cursos'
                                                                        var params = "preeventos=" + document.getElementById('preeventos<?php echo $vetor_item['id_item']; ?>').value;

                                                                        var ajax = new XMLHttpRequest();
                                                                        ajax.open('POST', 'selecionaeventoescolha.php', true);
                                                                        ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                                                        ajax.send(params);

                                                                        ajax.onreadystatechange = function () {
                                                                            if (ajax.readyState == 4 && ajax.status == 200) {
                                                                                document.getElementById('resultado<?php echo $vetor_item['id_item']; ?>').innerHTML = ajax.responseText;
                                                                            }
                                                                        }
                                                                    });
                                                                </script>


                                                            </form>

                                                            <br>

                                                        </div>

                                        </div>
																			
																			<?php }else { ?>

                                          <button type="button" class="btn btn-primary"
                                                  onclick="Mudarestado('minhaDivfotos<?php echo $vetor_item['id_item']; ?>')">
                                              Mostrar Foto(s) Cadastradas
                                          </button>
                                          <br>
                                          <br>


                                          <div id="minhaDivfotos<?php echo $vetor_item['id_item']; ?>"
                                               style="display:none; overflow-y: scroll; background-color: #E8E8E8;">
                                              <div class="testimonial-group">
                                                  <div class="row">
                                                      <table class="table" width="100%">
                                                          <tbody>
                                                          <tr>
																														
																														<?php
																														$sql_fotos_cadastradas = mysqli_query($con, "select * from escolha_fotos_escolhidas where id_escolha = '$vetor_item[id_item]'");
																														while ($vetor_fotos_cadastradas = mysqli_fetch_array($sql_fotos_cadastradas)) {
																															?>

                                                                <td>
                                                                    <div class="thumbnail">


                                                                        <a class="example-image-link"
                                                                           href="<?php echo $vetor_fotos_cadastradas['foto']; ?>"
                                                                           data-lightbox="example-set"><img
                                                                                    alt=""
                                                                                    src="<?php echo $vetor_fotos_cadastradas['foto']; ?>"/></a>

                                                                    </div>
                                                                    <span><?php echo "Código: ".$vetor_fotos_cadastradas['id_escolhida']; ?></span>

                                                                </td>
																														
																														<?php } ?>

                                                          </tr>
                                                          </tbody>
                                                      </table>
                                                  </div>
                                              </div>
                                              <table class="table">
                                                  <tr>
                                                      <td>
                                                          Observações: <?php echo $vetor_item['observacoes']; ?></td>
                                                  </tr>
                                              </table>

                                              <br>
																						
																						<?php if ($vetor_escolha['status'] != 4) { ?>

                                                <a href="excluirescolhas.php?id=<?php echo $vetor_item['id_item']; ?>&id_escolha=<?php echo $vetor_escolha['id_escolha']; ?>">
                                                    <button type="button" class="btn btn-danger"
                                                            style="    float: left;">Excluir Escolha(s)
                                                    </button>
                                                </a>
																						
																						<?php } ?>
                                          </div>
																			
																			<?php }
																			} ?>

                                        </td>

                                        </tr>
                                        </table>

                                        <br>

                                    </div>

                                </div>
															
															<?php } ?>

                                <div style="background: #ffffff">

                                    <br>
																	
																	<?php
																	if (mysqli_num_rows($sql_itens_aprovacao) == mysqli_num_rows($sql_itens2)) {
																		if ($vetor_escolha['status'] == '1' || $vetor_escolha['status'] == '2') {
																			?>

                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <div class="alert alert-danger" role="alert">
                                                        Caro(a) Formando(a), antes de finalizar a (s) escolha (s) favor
                                                        confirme se foram realizadas em todas lâminas.
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="finalizarescolhas.php?id_escolha=<?php echo $vetor_escolha['id_escolha']; ?>">
                                                        <button type="button" class="btn btn-success">Finalizar
                                                            Escolha(s)
                                                        </button>
                                                    </a></td>
                                            </tr>
                                        </table>
																		
																		<?php }
																	} ?>

                                    <br>
                                    <br>

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