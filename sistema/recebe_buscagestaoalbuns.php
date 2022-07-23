<?php

include "../includes/conexao.php";
session_start();
$id_pagina = 31;
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
}else {
    $id_turma = $_POST['id_turma'];
	$sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '{$id_pagina}' and id_usuario = '{$_SESSION['id']}'");
	$vetor_permissao = mysqli_fetch_array($sql_permissao);
	if ($vetor_permissao['listar'] != 2) {
		echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
	}
	if ($vetor_permissao['listar'] == 2) {
		if($_POST['tipo'] == '1'){
		    $sql = mysqli_query($con,"SELECT SUM(a.valorvenda) as total FROM vendas a, formandos c where a.id_formando = c.id_formando and c.turma = '{$id_turma}' and a.status <> '4' and a.iniciada = '2' and (a.tipo = '2' or a.tipo = '3')");
        }else{
		    $sql = mysqli_query($con,"SELECT SUM(a.valorvenda) as total FROM vendas a, formandos c where a.id_formando = c.id_formando and c.turma = '{$id_turma}' and a.status <> '4' and a.iniciada = '2' and a.tipo = '4'");
        }
		$ncontratos = 0;
		$vetor = mysqli_fetch_array($sql);
		?>
      <!DOCTYPE html>
      <html dir="ltr" lang="pt">

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
																<?php
																$vetor_turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '$id_turma'"));
																$vetor_instituicao_inicio = mysqli_fetch_array(mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'"));
																$vetor_curso_inicio = mysqli_fetch_array(mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'"));
																?>

                                  <table width="100%">
                                      <tr>
                                          <td width="74%" valign="middle">
                                              <strong><?php echo $vetor_turma['ncontrato']; ?>
                                                  - <?php echo $vetor_curso_inicio['nome'] . ' '; ?><?php echo $vetor_instituicao_inicio['nome']; ?></strong>
                                          </td>
                                          <td width="10%"></td>
                                          <td width="16%" valign="middle">
                                              <table width="100%">
                                                  <tr>
                                                      <td width="70%">Relatório de Venda:</td>
                                                      <td width="30%"><a
                                                                  href="imprimirrelvendaalbum.php?id_turma=<?php echo $id_turma; ?>"
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
                                                      <td width="70%">Relatório de Venda Boleto:</td>
                                                      <td width="30%"><a
                                                                  href="imprimirrelvendaboletoalbum.php?id_turma=<?php echo $id_turma; ?>"
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
                                                      <td width="70%">Protocolo de Entrega:</td>
                                                      <td width="30%"><a
                                                                  href="imprimirrelprotocoloalbum.php?id_turma=<?php echo $id_turma; ?>"
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

                                  <table id="tabela" class="table table-bordered table-striped">
                                      <thead align="center">
                                      <tr bgcolor="#e8e8e8">
                                          <th></th>
                                          <th><strong><h5>Formando</h5></strong></th>
                                          <th><strong><h5>Data de Vencimento</h5></strong></th>
                                          <th><strong><h5>Data 1° Vencimento</h5></strong></th>
                                          <th><strong><h5>Parcelas</h5></strong></th>
                                          <th><strong><h5>Forma de Pagamento</h5></strong></th>
                                          <th><strong><h5>Total<br>R$ <?php echo $num = number_format($vetor['total'], 2, ',', '.'); ?></h5></strong></th>
                                          <th></th>
                                          <th><strong><h5>Pago?</h5></strong></th>
                                      </tr>
                                      </thead>
                                      <tbody>
																			<?php
																			$sql_atual = mysqli_query($con, "select * from formandos where turma = '{$id_turma}' order by nome ASC");
																			$i = 1;
																			while ($vetor_atual = mysqli_fetch_array($sql_atual)) {
																			    if($_POST['tipo'] == '1'){
																			        $sql = mysqli_query($con, "select v.diavencimento,v.qtdparcelas,df.`data` as dfdata,f.nome as fnome,v.duplicata,v.status,v.id_venda, SUM(v.valorvenda) as total,df.pagamento,v.tipo from vendas v
                                                                                                                            left join pacotes_itens_album pia on pia.id_item = v.id_pacote
                                                                                                                            left join pacotes p on p.id_pacote = pia.id_pacote
                                                                                                                            left join formaspag f on f.id_forma = v.formapag
                                                                                                                            left join duplicatas d on d.id_venda = v.id_venda
                                                                                                                            left join duplicatas_faturas df on df.id_duplicata = d.id_duplicata
                                                                                                                        where v.id_formando = '{$vetor_atual['id_formando']}' and v.iniciada = '2' and (v.tipo = '2' or v.tipo = '3') and df.posicao = '1' and v.status <> '4'");
                                                                                }else{
																			        $sql = mysqli_query($con, "select v.diavencimento,v.qtdparcelas,df.`data` as dfdata,f.nome as fnome,v.duplicata,v.status,v.id_venda, SUM(v.valorvenda) as total,df.pagamento,v.tipo from vendas v
                                                                                                                            left join pacotes_itens_album pia on pia.id_item = v.id_pacote
                                                                                                                            left join pacotes p on p.id_pacote = pia.id_pacote
                                                                                                                            left join formaspag f on f.id_forma = v.formapag
                                                                                                                            left join duplicatas d on d.id_venda = v.id_venda
                                                                                                                            left join duplicatas_faturas df on df.id_duplicata = d.id_duplicata
                                                                                                                        where v.id_formando = '{$vetor_atual['id_formando']}' and v.iniciada = '2' and v.tipo = '4' and df.posicao = '1' and v.status <> '4'");
                                                                                }
																				$vetor = mysqli_fetch_array($sql);
																				?>
                                          <tr>
                                              <td align="center"><?php echo $i; ?></td>
                                              <td><?php echo $vetor_turma['ncontrato']; ?>-<?php echo $vetor_atual['id_cadastro']; ?>
                                                  - <?php echo $vetor_atual['nome']; ?></td>
                                              <td align="center"><?php echo $vetor['diavencimento']; ?></td>
                                              <td align="center"><?php echo date('d/m/Y', strtotime($vetor['dfdata'])); ?></td>
                                              <td align="center"><?php echo $vetor['qtdparcelas']; ?></td>
                                              <td align="center"><?php echo $vetor['fnome']; ?></td>
                                              <td align="center">R$ <?php echo $num = number_format($vetor['total'], 2, ',', '.'); ?></td>
                                              <td align="center"><?php if ($vetor['duplicata'] == 1) { ?>
                                                      <a href="confirmarcompraalbum.php?id=<?php echo $vetor['id_venda']; ?>">
                                                          <i class="fa fa-check-circle" title="Confirmar Venda"></i>
                                                      </a>
                                                <?php } ?>
                                              </td>
                                              <td>
	                                              <?php if($vetor['tipo'] == '4'){ ?>
	                                              <?php if($vetor['pagamento'] == '1'){?>
                                                    <span hidden>SIM</span><button class="btn btn-success btn-block">SIM</button>
	                                              <?php }else{?>
                                                      <span hidden>NAO</span><button class="btn btn-danger btn-block">NÃO</button>
	                                              <?php }
	                                              }?>
                                              </td>
                                          </tr>
												<?php
                                                                              if($vetor['total'] != 0 && $vetor['total'] != null){
	                                                                              $ncontratos++;
                                                                              }
                                                                              $i++;
																			} ?>
                                      </tbody>
                                  </table>

                                  <h3>Total de contratos: <?php echo $ncontratos; ?></h3>
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
          $(document).ready(function () {
              var tabela = $('#tabela').DataTable({
                  destroy: false,
                  "pageLength": 150,
                  scrollCollapse: true,
                  ordering: true,
                  info: true,
                  searching: true,
                  paging: true,
                  dom: 'Bfrtip',
                  columnDefs: [
                      {
                          type: 'date-br',
                          targets: 3
                      }
                  ],
              });
          });
      </script>
      </body>

      </html>
	<?php }
} ?>