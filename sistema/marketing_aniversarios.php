<?php
include "../includes/conexao.php";
session_start();
$id_pagina = 47;
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
}else {
	$vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from usuarios where id_usuario = '$_SESSION[id]'"));
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
                         aria-label="Toggle navigation"><i
                                  class="ti-more"></i></a>
                  </div>

                  <div class="navbar-collapse collapse" id="navbarSupportedContent">

                      <ul class="navbar-nav float-left mr-auto">
                          <li class="nav-item d-none d-md-block"><a
                                      class="nav-link sidebartoggler waves-effect waves-light"
                                      href="javascript:void(0)"
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
                          <!--                          <h4 class="page-title">Financeiro</h4>-->
                          <div class="d-flex align-items-center">
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item">Financeiro</a></li>
                                      <li class="breadcrumb-item">Financeiro</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Processos</li>
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

                                      <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                              href="#clientes"
                                                              role="tab"><span
                                                      class="hidden-xs-down">Clientes</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#prestadores"
                                                              role="tab"><span class="hidden-xs-down">Prestadores de Serviço</span></a>
                                      </li>
                                  </ul>

                                  <div class="tab-content tabcontent-border">
                                      <div class="tab-pane active" id="clientes" role="tabpanel">
                                          <br>
                                          <br>
                                          <div class="table-responsive">
                                              <table id="lang_opt" class="table table-striped table-bordered display"
                                                     style="width:100%">
                                                  <thead align="center">
                                                  <tr>
                                                      <th width="10%"><strong><h5>Cód. Aluno</h5></strong></th>
                                                      <th><strong><h5>Nome</h5></strong></th>
                                                      <th><strong><h5>Curso</h5></strong></th>
                                                      <th><strong><h5>Instituição</h5></strong></th>
                                                      <th><strong><h5>Conclusão</h5></strong></th>
                                                      <th><strong><h5>Data de Aniversário</h5></strong></th>
                                                      <th width="8%"><strong><h5>Rede Social</h5></strong></th>
                                                      <th width="8%"><strong><h5>Tipo Formando</h5></strong></th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
																									<?php
																									$sql_atual = mysqli_query($con, "select * from formandos f WHERE DAYOFYEAR (CURDATE()) <= dayofyear (f.datanasc) AND DAYOFYEAR (CURDATE()) +30 >= dayofyear (f.datanasc)");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[turma]'");
																										$vetor_turma = mysqli_fetch_array($sql_turma);
																										$sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
																										$vetor_instituicao = mysqli_fetch_array($sql_instituicao);
																										$sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
																										$vetor_curso = mysqli_fetch_array($sql_curso);
																										$sql_vendas_convites = mysqli_query($con, "select * from vendas where tipo = '1' and id_formando = '$vetor[id_formando]' and iniciada = '2'");
																										$sql_vendas_fotografia = mysqli_query($con, "select * from vendas where tipo IN ('2', '3') and id_formando = '$vetor[id_formando]' and iniciada = '2'");
																										?>
                                                      <tr>
                                                          <td align="center"><?php echo $vetor_turma['ncontrato']; ?>-<?php echo $vetor['id_cadastro']; ?></td>
                                                          <td><?php echo $vetor['nome']; ?></td>
                                                          <td align="center"><?php echo $vetor_curso['nome']; ?></td>
                                                          <td align="center"><?php echo $vetor_instituicao['sigla']; ?></td>
                                                          <td align="center"><?php echo $vetor['conclusao']; ?></td>
                                                          <td align="center"><?php echo date('d/m', strtotime($vetor['datanasc'])).'/'.date('Y'); ?></td>
                                                          <td><?php echo ($vetor['facebook']!=''?$vetor['facebook'].'<br>':'').($vetor['instagram'] != ''?(substr($vetor['instagram'], 0, 1) == '@' ? $vetor['instagram'] : '@'.$vetor['instagram']):''); ?></td>
                                                          <td align="center"><?php if ($vetor['comissao'] == '') { ?>
                                                                  <button type="button"
                                                                          class="btn btn-block btn-success btn-sm">
                                                                      Formando
                                                                  </button><?php }
																														if ($vetor['comissao'] == '1') { ?>
                                                                <button type="button"
                                                                        class="btn btn-block btn-success btn-sm">
                                                                    Formando
                                                                </button><?php }
																														if ($vetor['comissao'] == 2) { ?>
                                                                <button type="button"
                                                                        class="btn btn-block btn-danger btn-sm">
                                                                    Comissão
                                                                </button><?php } ?></td>
                                                      </tr>
																									<?php } ?>
                                                  </tbody>
                                              </table>

                                          </div>
                                      </div>
                                      <div class="tab-pane" id="prestadores" role="tabpanel">
                                          <br>
                                          <br>
                                          <div class="table-responsive">
                                              <table id="lang_opt2" class="table table-striped table-bordered display"
                                                     style="width:100%">
                                                  <thead align="center">
                                                  <tr>
                                                      <th><strong><h5>Nome</h5></strong></th>
                                                      <th><strong><h5>Tipo</h5></strong></th>
                                                      <th><strong><h5>Data de Aniversário</h5></strong></th>
                                                      <th><strong><h5>Função</h5></strong></th>
                                                      <!--                                                      <th>Rede Social</th>-->
                                                  </tr>
                                                  </thead>
                                                  <tbody>
																									<?php
																									$sql_atual = mysqli_query($con, "select * from colaboradores f WHERE DAYOFYEAR (CURDATE()) <= dayofyear (f.datanasc) AND DAYOFYEAR (CURDATE()) +30 >= dayofyear (f.datanasc)");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										?>
                                                      <tr>
                                                          <td><?php echo $vetor['nome']; ?></td>
                                                          <td align="center">Colaborador</td>
                                                          <td align="center"><?php echo date('d/m', strtotime($vetor['datanasc'])).'/'.date('Y'); ?></td>
                                                          <td align="center"><?php echo $vetor['funcao']; ?></td>
                                                          <!--                                                          <td>-->
																												<?php //echo $vetor['facebook'].'<br>'.(substr($vetor['instagram'], 0, 1) == '@' ? $vetor['instagram'] : '@'.$vetor['instagram']);; ?><!--</td>-->
                                                      </tr>
																									<?php }
																									$sql_atual = mysqli_query($con, "select * from clientes f WHERE DAYOFYEAR (CURDATE()) <= dayofyear (f.datanasc) AND DAYOFYEAR (CURDATE()) +30 >= dayofyear (f.datanasc)");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										$sql_categoria = mysqli_query($con, "select * from fornecedor_categoria where id_fornecedor = '$vetor[id_cli]' order by id_cat ASC");
																										$vetor_categoria = mysqli_fetch_array($sql_categoria);
																										$sql_cat = mysqli_query($con, "select * from categoriafornecedor where id_categoria = '$vetor_categoria[id_categoria]'");
																										$vetor_cat = mysqli_fetch_array($sql_cat);
																										?>
                                                      <tr>
                                                          <td><?php echo $vetor['nome']; ?></td>
                                                          <td align="center">Fornecedor</td>
                                                          <td align="center"><?php echo date('d/m/Y', strtotime($vetor['datanasc'])); ?></td>
                                                          <td align="center"><?php echo $vetor_cat['nome']; ?></td>
                                                          <!--                                                          <td>-->
																												<?php //echo $vetor['facebook'].'<br>'.(substr($vetor['instagram'], 0, 1) == '@' ? $vetor['instagram'] : '@'.$vetor['instagram']);; ?><!--</td>-->
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

      <script type="text/javascript">
          jQuery.extend(jQuery.fn.dataTableExt.oSort, {
              "date-br-pre": function (a) {
                  if (a == null || a == "") {
                      return 0;
                  }
                  var brDatea = a.split('/');
                  return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
              },

              "date-br-asc": function (a, b) {
                  return ((a < b) ? -1 : ((a > b) ? 1 : 0));
              },

              "date-br-desc": function (a, b) {
                  return ((a < b) ? 1 : ((a > b) ? -1 : 0));
              }
          });

          var init_data_Table = function () {
              var tabelaNcms = null;
              if ($.fn.dataTable.isDataTable('#lang_opt')) {
                  $('#lang_opt').dataTable().fnDestroy();
                  init_data_Table();
              } else {
                  tabelaNcms = $('#lang_opt').DataTable({
                      destroy: false,
                      scrollCollapse: true,
                      ordering: true,
                      info: true,
                      searching: true,
                      paging: true,
                      dom: 'Bfrtip',
                      "order": [[5, "asc"]],
                      columnDefs: [
                          {
                              type: 'date-br',
                              targets: 5
                          }
                      ],
                  });
              }
          };

          var init_data_Table1 = function () {
              var tabelaNcms = null;
              if ($.fn.dataTable.isDataTable('#lang_opt2')) {
                  $('#lang_opt2').dataTable().fnDestroy();
                  init_data_Table1();
              } else {
                  tabelaNcms = $('#lang_opt2').DataTable({
                      destroy: false,
                      scrollCollapse: true,
                      ordering: true,
                      info: true,
                      searching: true,
                      paging: true,
                      dom: 'Bfrtip',
                      "order": [[2, "asc"]],
                      columnDefs: [
                          {
                              type: 'date-br',
                              targets: 2
                          }
                      ],
                  });
              }
          };

          $(document).ready(function () {
              init_data_Table();
              init_data_Table1();
          });
      </script>
      </body>

      </html>
	<?php }
} ?>