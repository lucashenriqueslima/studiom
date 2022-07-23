<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id_formando'] == null || $_SESSION['id_formando'] == '') {
	echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";
}else {
	$vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$_SESSION[id_formando]'"));
	$dataatual = date('Y-m-d');
	$sql_produtos = mysqli_query($con, "select * from produtos_turma where termino >= '$dataatual' and id_turma = '$vetor_cadastro[turma]' order by id_produto DESC");
	if (mysqli_num_rows($sql_produtos) == 0) {
		echo "<script> alert('Não existe convites para serem comprados neste momento!')</script>";
		echo "<script> window.location.href='minhascompras.php'</script>";
	}else {
		$vetor_produtos = mysqli_fetch_array($sql_produtos);
		$sql_pacotes = mysqli_query($con, "select * from pacotes_turma where id_produto = '$vetor_produtos[id_produto]'");
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
                                      <li class="breadcrumb-item">Home</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Minhas Compras</li>
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
																
																<?php
																if (mysqli_num_rows($sql_pacotes) != 0) {
																	?>

                                    <div class="row">
																			<?php
																			$i = 0;
																			$totalcadastros = mysqli_num_rows($sql_pacotes);
																			while ($vetor_pacotes = mysqli_fetch_array($sql_pacotes)) {
																				?>
                                          <div class="col-md-<?php if ($totalcadastros == 1) {
																						echo "12";
																					}
																					if ($totalcadastros == 2) {
																						echo "6";
																					}
																					if ($totalcadastros >= 3) {
																						echo "4";
																					} ?>">
                                              <div class="panel panel-<?php if ($i == 0) { ?>success<?php }
																							if ($i == 1) { ?>info<?php }
																							if ($i == 2) { ?>warning<?php } ?>">

                                                  <div class="panel-heading">

                                                      <h3><?php echo $vetor_pacotes['titulo']; ?></h3>

                                                  </div>
                                                  <!-- /.box-header -->
                                                  <div class="panel-body">

                                                      <h3>Produtos</h3>
                                                      <table width="40%" class="table table-bordered table-striped">
                                                          <tr>
                                                              <th>Produto</th>
                                                              <th>Quantidade Mínima</th>
                                                              <th>Valor Un.</th>
                                                              <th>Valor Total.</th>
                                                          </tr>
																												<?php
																												$sql_itens = mysqli_query($con, "select * from pacotes_itens where status = '1' and id_pacote = '$vetor_pacotes[id_pacote]' order by id_item ASC");
																												$totalizador = 0;
																												while ($vetor_item = mysqli_fetch_array($sql_itens)) {
																													$sql_produto_item = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_item[id_tipo]'");
																													$vetor_produto_item = mysqli_fetch_array($sql_produto_item);
																													?>
                                                            <tr>
                                                                <td><?php echo $vetor_produto_item['nome']; ?></td>
                                                                <td><?php echo $vetor_item['qtdminima']; ?></td>
                                                                <td>
                                                                    R$ <?php echo $num = number_format($vetor_item['valorun'], 2, ',', '.'); ?></td>
                                                                <td>
                                                                    R$ <?php $total = $vetor_item['valorun'] * $vetor_item['qtdminima'];
																																	echo $num = number_format($total, 2, ',', '.'); ?></td>
                                                            </tr>
																													<?php $totalizador += $total;
																												} ?>
                                                          <tr>
                                                              <td></td>
                                                              <td></td>
                                                              <td bgcolor="#e8e8e8">
                                                                  <div align="Right">Valor do Pacote:</div>
                                                              </td>
                                                              <td bgcolor="#e8e8e8">
                                                                  R$ <?php echo $num = number_format($totalizador, 2, ',', '.'); ?></td>
                                                          </tr>
                                                      </table>

                                                      <a href="compra_pacote.php?id_pacote_turma=<?php echo $vetor_pacotes['id_pacote']; ?>">
                                                          <button type="button" class="btn btn-primary"
                                                                  style="    float: left;">Comprar pacote
                                                          </button>
                                                      </a>

                                                  </div>
                                                  <!-- /.box-body -->
                                              </div>
                                              <!-- /.box -->
                                          </div>
                                          <!-- ./col -->
																				
																				<?php $i++;
																			} ?>

                                    </div>
																
																<?php }else { ?>
																	
																	<?php
																	$sql_produto = mysqli_query($con, "select * from produtos_turma where termino >= '$dataatual' and id_turma = '$vetor_cadastro[turma]'");
																	while ($vetor_produto = mysqli_fetch_array($sql_produto)) {
																		echo "<script> window.location.href='compra_etapa1.php?produto=$vetor_produto[id_produto]&tipo=1'</script>";
																	}
																	?>
																
																<?php } ?>

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
	<?php }
} ?>