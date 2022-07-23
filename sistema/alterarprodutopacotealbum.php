<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$id = $_GET['id'];
	$id1 = $_GET['id1'];
	$vetor = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_itens_album where id_item = '$id'"));
	$itens_produtos = mysqli_query($con, "select * from pacotes_itens_produtos where id_pacote = '$id'");
	if ($vetor['pacote_especial'] != 2) {
		$pacote_especial = 1;
	}else {
		$pacote_especial = 0;
	}
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
                                    <li class="breadcrumb-item">Alterar Produto</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Alterar Pacote</li>
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
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Dados do Pacote</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eventos"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Eventos</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#produtos"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Produtos</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#formaspagamento"
                                                            role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span class="hidden-xs-down">Formas de Pagamento</span></a>
                                    </li>

                                </ul>

                                <div class="tab-content tabcontent-border">

                                    <div class="tab-pane active" id="dados" role="tabpanel">

                                        <br>

                                        <form action="recebe_alterarpacoteitem.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>"
                                              method="post" name="cliente" enctype="multipart/form-data"
                                              onSubmit="return verificarCPF()" id="formID">


                                            <div class="row">

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Titulo</label>
                                                        <input type="text" name="titulo"
                                                               value="<?php echo $vetor['titulo']; ?>"
                                                               class="form-control" required="">
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Valor
                                                            Pacote</label>
                                                        <input type="text" name="valor" class="form-control"
                                                               value="<?php echo $num = number_format($vetor['valor'], 2, ',', '.'); ?>"
                                                               id="exampleInput" placeholder="Valor Pagamento"
                                                               onKeyPress="mascara(this,mvalor)" required>
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-4">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold" for="exampleInput">Valor
                                                            Pacote Comissão</label>
                                                        <input type="text" name="valorcomissao" class="form-control"
                                                               value="<?php echo $num = number_format($vetor['valorcomissao'], 2, ',', '.'); ?>"
                                                               id="exampleInput" placeholder="Valor Pagamento"
                                                               onKeyPress="mascara(this,mvalor)" required>
                                                    </fieldset>
                                                </div>

                                            </div>

                                            <div class="row">
																							<?php if ($pacote_especial == 0) { ?>
                                                  <div class="col-lg-6">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Tamanho
                                                              da
                                                              Página</label>
                                                          <select name="tamanho" class="form-control">
                                                              <option value="" selected="selected">Nenhum</option>
                                                              <option value="1"
																															        <?php if (strcasecmp($vetor['tamanho'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                  30x40cm
                                                              </option>
                                                              <option value="2"
																															        <?php if (strcasecmp($vetor['tamanho'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                                  22x30cm
                                                              </option>
                                                          </select>
                                                      </fieldset>
                                                  </div>
																							<?php }else { ?>
                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Qtd.
                                                              Parcelas</label>
                                                          <input type="number" name="qtdparcelas" class="form-control"
                                                                 value="<?php echo $vetor['qtdparcelas']; ?>"
                                                                 id="exampleInput"
                                                                 placeholder="Quantidade de Parcelas" required>
                                                      </fieldset>
                                                  </div>
                                                  <div class="col-lg-4">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Data Limite de Compra do Pacote</label>
                                                          <input type="date" name="data_limite" class="form-control"
                                                                 value="<?php echo $vetor['data_limite']; ?>"
                                                                 id="exampleInput"
                                                                 placeholder="Data limite do pacote">
                                                      </fieldset>
                                                  </div>
																							<?php } ?>
                                            </div>

                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label semibold"
                                                               for="exampleInput">Descrição</label>
                                                        <textarea name="descricao" class="ckeditor" id="editor1"
                                                                  required=""><?php echo $vetor['descricao']; ?></textarea>
                                                    </fieldset>
                                                </div>

                                            </div>


                                            <button type="submit" class="btn btn-primary" style="    float: left;">
                                                Salvar
                                            </button>

                                        </form>

                                    </div>
                                    <div class="tab-pane" id="eventos" role="tabpanel">

                                        <br>
                                        <br>
                                        <a href="cadastroeventopacote.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>">
                                            <button class="btn btn-primary" style="    float: left;">Novo
                                                Evento
                                            </button>
                                        </a>
                                        <br>
                                        <br>
                                        <br>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Evento</th>
                                                <th width="13%">Ação</th>
                                            </tr>
                                            </thead>
                                            <tbody>
																						<?php
																						$sql_eventos = mysqli_query($con, "select * from eventos_pacote WHERE id_pacote = '$id' order by id_evento_pacote ASC");
                                                                                        $i = 0;
																						while ($vetor_eventos = mysqli_fetch_array($sql_eventos)) {
																							$sql_evento = mysqli_query($con, "select * from eventos_turma_lista where id_evento_turma = '$vetor_eventos[id_evento]'");
																							$vetor_evento = mysqli_fetch_array($sql_evento);
																							$sql_evento_nome = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_evento[id_evento]'");
																							$vetor_evento_nome = mysqli_fetch_array($sql_evento_nome);
																							?>
                                                <tr>
                                                    <td><?= $vetor_evento_nome['nome'].' '.$vetor_evento['preevento']?> </td>
                                                    <td><a
                                                                href="confexcluireventopacote.php?id=<?php echo $vetor_eventos['id_evento_pacote']; ?>&id1=<?php echo $id; ?>">
                                                            <button type="button"
                                                                    class="btn btn-danger mesmo-tamanho"
                                                                    title="Excluir Cadastro"><i
                                                                        class="mdi mdi-window-close"></i></button>
                                                        </a></td>
                                                </tr>
																						<?php } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="tab-pane" id="produtos" role="tabpanel">
                                        <br>
																			<?php if ($pacote_especial == 0) { ?>
                                          <a href="cadastroprodutopacotealbum.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>">
                                              <button class="btn btn-primary" style="    float: left;">Novo
                                                  Produto
                                              </button>
                                          </a>

                                          <br>
                                          <br>
																			<?php } ?>
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Produto</th>
																							<?php if ($pacote_especial == 0) { ?>
                                                  <th>Qtd de Páginas</th>
                                                  <th width="13%">Ação</th>
																							<?php } ?>
                                            </tr>
                                            </thead>
                                            <tbody>
																						<?php
																						$sql_itens = mysqli_query($con, "select * from pacotes_itens_produtos WHERE id_pacote = '$id' order by id_produto_item DESC");
																						while ($vetor_item = mysqli_fetch_array($sql_itens)) {
																							$sql_produto = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '$vetor_item[id_produto]'");
																							$vetor_produto = mysqli_fetch_array($sql_produto);
																							?>
                                                <tr>
                                                    <td><?php echo $vetor_produto['nome']; ?></td>
																									<?php if ($pacote_especial == 0) { ?>
                                                      <td><?php echo $vetor_item['qtdpaginas']; ?></td>
                                                      <td>
                                                          <a href="alteraritempacote.php?id=<?php echo $vetor_item['id_produto_item']; ?>&id1=<?php echo $id; ?>"
                                                             target="_blank">
                                                              <button type="button" class="btn btn-info mesmo-tamanho"
                                                                      title="Ver ou Alterar Cadastro"><i
                                                                          class="fa fa-edit"></i>
                                                              </button>
                                                          </a><a
                                                                  href="confexcluiritempacote.php?id=<?php echo $vetor_item['id_produto_item']; ?>&id1=<?php echo $id; ?>">
                                                              <button type="button"
                                                                      class="btn btn-danger mesmo-tamanho"
                                                                      title="Excluir Cadastro"><i
                                                                          class="mdi mdi-window-close"></i></button>
                                                          </a>
                                                      </td>
																									<?php } ?>
                                                </tr>
																						<?php } ?>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="tab-pane" id="formaspagamento" role="tabpanel">

                                        <br>
                                        <br>

                                        <a href="cadastropacoteformapag.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>">
                                            <button class="btn btn-primary" style="    float: left;">Nova
                                                Forma de Pagamento
                                            </button>
                                        </a>

                                        <br>
                                        <br>
                                        <br>
                                        <table id="example3" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Forma de Pagamento</th>
                                                <th width="13%">Ação</th>
                                            </tr>
                                            </thead>
                                            <tbody>
																						<?php
																						$sql_formas = mysqli_query($con, "select * from formaspag_pacote WHERE id_pacote = '$id' order by id_item DESC");
																						while ($vetor_forma = mysqli_fetch_array($sql_formas)) {
																							$sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_forma[id_forma]'");
																							$vetor_formapag = mysqli_fetch_array($sql_forma);
																							?>
                                                <tr>
                                                    <td><?php echo $vetor_formapag['nome']; ?></td>
                                                    <td>
                                                        <a href="alterarpacoteformapag.php?id=<?php echo $vetor_forma['id_item']; ?>&id1=<?php echo $id; ?>"
                                                           target="_blank">
                                                            <button type="button" class="btn btn-info mesmo-tamanho"
                                                                    title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i>
                                                            </button>
                                                        </a><a
                                                                href="confexcluirpacoteformapag.php?id=<?php echo $vetor_forma['id_item']; ?>&id1=<?php echo $id; ?>">
                                                            <button type="button"
                                                                    class="btn btn-danger mesmo-tamanho"
                                                                    title="Excluir Cadastro"><i
                                                                        class="mdi mdi-window-close"></i></button>
                                                        </a></td>
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