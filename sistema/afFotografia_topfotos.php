<?php
include "../includes/conexao.php";
session_start();
$id_pagina = 123;
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
}else {
	$sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);
	$sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
	$vetor_permissao = mysqli_fetch_array($sql_permissao);
	if ($vetor_permissao['listar'] != 2) {
		echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
	}
	if ($vetor_permissao['listar'] == 2) {
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
                          <!--                          <h4 class="page-title">Arte Final - Fotografia</h4>-->
                          <div class="d-flex align-items-center">
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item">Arte Final - Fotografia</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Top Fotos</li>
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
                                  <!--                                  <h4 class="card-title">Top Fotos</h4>-->
                                  <ul class="nav nav-tabs" role="tablist">

                                      <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                              href="#cadastrodeevento"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Cadastro de Evento</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                              href="#fotosescolhidas"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Fotos Escolhidas</span></a>
                                      </li>

                                  </ul>
                                  <div class="tab-content tabcontent-border">
                                      <div class="tab-pane active" id="cadastrodeevento" role="tabpanel">
                                          <br>
																				
																				<?php if ($vetor_permissao['cadastro'] == 1) {
																				}else { ?><a href="cadastroescolhafototurma.php">
                                            <button type="button" class="btn waves-effect waves-light btn-warning">Novo
                                                Top Fotos
                                            </button>
                                        </a>

                                            <br>
                                            <br>
                                            <br>
																				
																				<?php } ?>

                                          <div class="table-responsive">
                                              <table id="lang_opt2" class="table table-striped table-bordered display"
                                                     style="width:100%">
                                                  <thead>
                                                  <tr>
                                                      <th>Contrato</th>
                                                      <th>Evento</th>
                                                      <th>Qtd de Fotos</th>
                                                      <th width="10%">Ação</th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
																									<?php
																									$sql_atual = mysqli_query($con, "select * from turmas_escolha order by id_turma_escolha DESC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										$sql_contrato = mysqli_query($con, "select * from turmas where id_turma = '$vetor[id_turma]'");
																										$vetor_contrato = mysqli_fetch_array($sql_contrato);
																										$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_contrato[id_instituicao]'");
																										$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
																										$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_contrato[curso]'");
																										$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
																										$sql_evento = mysqli_query($con, "SELECT * FROM eventos_turma WHERE id_evento = '$vetor[id_evento]' order by data ASC");
																										$vetor_evento = mysqli_fetch_array($sql_evento);
																										?>
                                                      <tr>
                                                          <td><?php echo $vetor_contrato['ncontrato']; ?>
                                                              - <?php echo $vetor_curso_inicio['nome']; ?> <?php echo $vetor_contrato['ano']; ?> <?php echo $vetor_instituicao_inicio['nome']; ?></td>
                                                          <td><?php echo $vetor_evento['nome']; ?></td>
                                                          <td><?php echo $vetor['qtd']; ?></td>
                                                          <td><a class="fancybox fancybox.ajax"
                                                                 href="alterarescolhafotosturma.php?id=<?php echo $vetor['id_turma_escolha']; ?>"
                                                                 target="_blank">
                                                                  <button type="button"
                                                                          class="btn btn-success mesmo-tamanho"
                                                                          title="Ver ou Alterar Cadastro"><i
                                                                              class="mdi mdi-tooltip-edit"></i></button>
                                                              </a> <?php if ($vetor_permissao['exclusao'] == 1) {
																														}else { ?><a class="fancybox fancybox.ajax"
                                                                         href="confexcluirescolhafotosturma.php?id=<?php echo $vetor['id_turma_escolha']; ?>">
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

                                      <div class="tab-pane" id="fotosescolhidas" role="tabpanel">
                                          <br>
                                          <div class="table-responsive">
                                              <table id="lang_opt" class="table table-striped table-bordered display"
                                                     style="width:100%">
                                                  <thead>
                                                  <tr>
                                                      <th width="6%">Cód.Cliente</th>
                                                      <th>Formando</th>
                                                      <th>Evento</th>
                                                      <th>Quant. Fotos</th>
                                                      <th>Data (finalização)</th>
                                                      <th width="13%">Ação</th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
																									<?php
																									$sql_atual = mysqli_query($con, "SELECT DISTINCT id_evento, id_formando, data, tipo FROM escolha_fotos_tratamento order by id_escolha DESC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor[id_formando]'");
																										$vetor_formando = mysqli_fetch_array($sql_formando);
																										$sql_contrato = mysqli_query($con, "select * from turmas where id_turma = '$vetor_formando[turma]'");
																										$vetor_contrato = mysqli_fetch_array($sql_contrato);
																										$sql_evento = mysqli_query($con, "select * from eventosformando where id_evento_turma = '$vetor[id_evento]'");
																										$vetor_evento = mysqli_fetch_array($sql_evento);
																										$sql_total = mysqli_query($con, "select * from escolha_fotos_tratamento where id_evento = '$vetor[id_evento]' and id_formando = '$vetor[id_formando]'");
																										$total = mysqli_num_rows($sql_total);
																										$sql_tipos = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor[id_item]'");
																										$vetor_tipos = mysqli_fetch_array($sql_tipos);
																										?>
                                                      <tr>
                                                          <td><?php echo $vetor_contrato['ncontrato']; ?>-<?php echo $vetor_formando['id_cadastro']; ?></td>
                                                          <td><?php echo $vetor_formando['nome']; ?></td>
                                                          <td><?php echo $vetor_evento['titulo']; ?></td>
                                                          <td><?php echo $total; ?></td>
                                                          <td><?php if ($vetor['data'] != null) {
																															echo date('d/m/Y', strtotime($vetor['data']));
																														} ?></td>
                                                          <td><a class="fancybox fancybox.ajax"
                                                                 href="vertopfotos.php?id_formando=<?php echo $vetor['id_formando']; ?>&id_evento=<?php echo $vetor['id_evento']; ?>"
                                                                 target="_blank">
                                                                  <button type="button"
                                                                          class="btn btn-success mesmo-tamanho"
                                                                          title="Ver ou Alterar Cadastro"><i
                                                                              class="mdi mdi-tooltip-edit"></i></button>
                                                              </a> <?php if ($vetor_permissao['exclusao'] == 1) {
																														}else { ?><a class="fancybox fancybox.ajax"
                                                                         href="excluirtopfotos.php?id_formando=<?php echo $vetor['id_formando']; ?>&id_evento=<?php echo $vetor['id_evento']; ?>">
                                                                      <button type="button"
                                                                              class="btn btn-danger mesmo-tamanho"
                                                                              title="Excluir Cadastro"><i
                                                                                  class="mdi mdi-window-close"></i>
                                                                      </button>
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
	<?php }
} ?>