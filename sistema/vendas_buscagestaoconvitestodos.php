<?php

include "../includes/conexao.php";
session_start();
$id_pagina = 31;
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
		$id_formando = $_GET['id_formando'];
		$sql_produto = mysqli_query($con, "select * from venda_avulsa");
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
<!--                          <h4 class="page-title">Vendas</h4>-->
                          <div class="d-flex align-items-center">
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item">Vendas</a></li>
                                      <li class="breadcrumb-item">Gestor de Vendas</a></li>
                                      <li class="breadcrumb-item">Convite</a></li>
                                      <li class="breadcrumb-item">Gestão Total da Venda</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Abrir Venda</li>
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
                                  <h4 class="card-title">Gestão de Convites</h4>
																
																<?php
																$id_turma = $_POST['id_turma'];
																$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$id_turma'");
																$vetor_turma = mysqli_fetch_array($sql_turma);
																$sql_produtos_turma = mysqli_query($con, "select * from produtos_turma where id_turma = '$id_turma'");
																$vetor_produtos_turma = mysqli_fetch_array($sql_produtos_turma);
																$sql_itens = mysqli_query($con, "select * from produtos_turma_item where id_produto = '$vetor_produtos_turma[id_produto]' order by id_item ASC");
																$sql_itens2 = mysqli_query($con, "select * from produtos_turma_item where id_produto = '$vetor_produtos_turma[id_produto]' order by id_item ASC");
																$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
																$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
																$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
																$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
																?>

                                  <table width="100%">
                                      <tr>
                                          <td width="74%" valign="middle">
                                              <strong><?php echo $vetor_turma['ncontrato']; ?>
                                                  - <?php echo $vetor_curso_inicio['nome']; ?> <?php echo $vetor['ano']; ?> <?php echo $vetor_instituicao_inicio['nome']; ?></strong>
                                          </td>
                                          <td width="10%"></td>
                                          <td width="16%" valign="middle">
                                              <table width="100%">
                                                  <tr>
                                                      <td width="70%">Relatório de Venda:</td>
                                                      <td width="30%"><a
                                                                  href="imprimirrelvendatodos.php?id_turma=<?php echo $id_turma; ?>"
                                                                  target="_blank">
                                                              <button type="button"
                                                                      class="btn btn-primary mesmo-tamanho"
                                                                      title="Imprimir Cadastros"><i
                                                                          class="fa fa-print"></i></button>
                                                          </a></td>
                                                  </tr>
                                                  <tr>
                                                      <td></td>
                                                      <td><img src="imgs/transp.png"></td>
                                                  </tr>
                                                  <tr>
                                                      <td width="70%">Exportar em Excel:</td>
                                                      <td width="30%"><a
                                                                  href="imprimirrelvendacsv.php?id_turma=<?php echo $id_turma; ?>"
                                                                  target="_blank">
                                                              <button type="button"
                                                                      class="btn btn-primary mesmo-tamanho"
                                                                      title="Imprimir Cadastros"><i
                                                                          class="fa fa-print"></i></button>
                                                          </a></td>
                                                  </tr>
                                              </table>
                                          </td>
                                      </tr>
                                  </table>


                                  <br>
                                  <br>

                                  <table class="table table-bordered table-striped">
                                      <thead>
                                      <tr>
                                          <th></th>
                                          <th width="15%"></th>
																				<?php
																				$sql_soma_qtd2 = mysqli_query($con, "SELECT SUM(valorvenda) as total FROM vendas where status != '4' and iniciada = '2'");
																				$vetor_soma_qtd2 = mysqli_fetch_array($sql_soma_qtd2);
																				$sql_soma_avista = mysqli_query($con, "SELECT SUM(valorvenda) as total FROM vendas where formapag = '4' and status != '4' and iniciada = '2'");
																				$vetor_soma_vista = mysqli_fetch_array($sql_soma_avista);
																				$percentual = 10.0 / 100.0;
																				$totalcomissao = $vetor_soma_vista['total'] - ($percentual * $vetor_soma_vista['total']);
																				$sobra = $vetor_soma_vista['total'] - $totalcomissao;
																				$finalvenda = $vetor_soma_qtd2['total'] - $sobra;
																				while ($vetor_itens2 = mysqli_fetch_array($sql_itens2)) {
																					$sql_soma_qtd1 = mysqli_query($con, "SELECT SUM(b.qtd) as total FROM vendas a, itens_venda_individual b where a.id_venda = b.id_venda and b.id_item = '$vetor_itens2[id_item]' and a.status != '4' and a.iniciada = '2'");
																					$vetor_soma_qtd1 = mysqli_fetch_array($sql_soma_qtd1);
																					?>
                                            <th><?php echo $vetor_soma_qtd1['total']; ?></th>
																				<?php } ?>
                                      </tr>
                                      <tr bgcolor="#e8e8e8">
                                          <th></th>
                                          <th width="15%">Formando</th>
																				<?php
																				while ($vetor_itens = mysqli_fetch_array($sql_itens)) {
																					$sql_nome_produto = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_itens[id_tipo]'");
																					$vetor_nome_produto = mysqli_fetch_array($sql_nome_produto);
																					?>
                                            <th><?php echo $vetor_nome_produto['nome']; ?></th>
																				<?php } ?>
                                      </tr>
                                      </thead>
                                      <tbody>
																			<?php
																			$sql_atual = mysqli_query($con, "select * from formandos where turma = '$id_turma' order by nome ASC");
																			$i = 1;
																			while ($vetor_atual = mysqli_fetch_array($sql_atual)) {
																				$sql_itens1 = mysqli_query($con, "select * from produtos_turma_item where id_produto = '$vetor_produtos_turma[id_produto]' order by id_item ASC");
																				$sql_venda = mysqli_query($con, "select * from vendas where id_formando = '$vetor_atual[id_formando]' and iniciada = '2' order by id_venda DESC limit 0,1");
																				$vetor_venda = mysqli_fetch_array($sql_venda);
																				$sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_venda[formapag]'");
																				$vetor_forma = mysqli_fetch_array($sql_forma);
																				$sql_vencimentos = mysqli_query($con, "select a.id_duplicata, a.id_venda, b.id_duplicata, b.data, b.posicao from duplicatas a, duplicatas_faturas b where a.id_duplicata = b.id_duplicata and a.id_venda = '$vetor_venda[id_venda]' order by b.posicao ASC limit 0,1");
																				$vetor_vencimento = mysqli_fetch_array($sql_vencimentos);
																				?>
                                          <tr>
                                              <td><?php echo $i; ?></td>
                                              <td><?php echo $vetor_turma['ncontrato']; ?>
                                                  -<?php echo $vetor_atual['id_cadastro']; ?>
                                                  - <?php echo $vetor_atual['nome']; ?></td>
																						<?php
																						while ($vetor_itens1 = mysqli_fetch_array($sql_itens1)) {
																							$sql_soma_qtd = mysqli_query($con, "SELECT SUM(b.qtd) as total FROM vendas a, itens_venda_individual b where a.id_venda = b.id_venda and a.id_formando = '$vetor_atual[id_formando]' and b.id_item = '$vetor_itens1[id_item]' and a.iniciada = '2'");
																							$vetor_soma_qtd = mysqli_fetch_array($sql_soma_qtd);
																							?>
                                                <td><?php echo $vetor_soma_qtd['total']; ?></td>
																							<?php
																						}
																						$sql_soma_valor = mysqli_query($con, "SELECT SUM(valorvenda) as total FROM vendas  where id_formando = '$vetor_atual[id_formando]' and a.iniciada = '2'");
																						$vetor_soma_valor = mysqli_fetch_array($sql_soma_valor);
																						?>
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