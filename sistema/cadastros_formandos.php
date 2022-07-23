<?php

include "../includes/conexao.php";
session_start();
$id_pagina = 5;
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
}else {
	$vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from usuarios where id_usuario = '$_SESSION[id]'"));
	$vetor_permissao = mysqli_fetch_array(mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'"));
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
<!--                          <h4 class="page-title">Cadastros Gerais</h4>-->
                          <div class="d-flex align-items-center">
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item">Cadastros</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Formandos</li>
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
<!--                                  <h4 class="card-title">Formandos</h4>-->
																
																<?php if ($vetor_permissao['cadastro'] == 1) {
																}else { ?><a href="cadastrar_formando.php">
                                    <button type="button" class="btn waves-effect waves-light btn-warning">Novo
                                        Formando
                                    </button>
                                </a>

                                    <br>
                                    <br>
                                    <br>
																
																<?php } ?>

                                  <div class="table-responsive">
                                      <table id="lang_opt" class="table table-striped table-bordered display"
                                             style="width:100%; text-align: center;">
                                          <thead>
                                          <tr>
                                              <th width="5%"><strong><h5>Contrato</h5></strong></th>
                                              <th width="5%"><strong><h5>Cód. Aluno</h5></strong></th>
                                              <th><strong><h5>Nome</h5></strong></th>
                                              <th><strong><h5>Curso</h5></strong></th>
                                              <th><strong><h5>Conclusão</h5></strong></th>
                                              <th><strong><h5>Instituição</h5></strong></th>
                                              <th><strong><h5>Celular</h5></strong></th>
                                              <th width="8%"><strong><h5>Tipo Serviço</h5></strong></th>
                                              <th width="8%"><strong><h5>Tipo Formando</h5></strong></th>
                                              <th width="20%"><strong><h5>Ação</h5></strong></th>
                                          </tr>
                                          </thead>
                                          <tbody>
																					<?php
																					if (!empty($nome)) {
																						$where .= " AND a.nome LIKE '%".$id_empresa."%'";
																					}
																					$sql_atual = mysqli_fetch_all(mysqli_query($con, "SELECT 
                                                                                    f.id_formando,
                                                                                    f.turma,
                                                                                    f.id_cadastro,
                                                                                    f.nome f_nome, 
                                                                                    f.conclusao, 
                                                                                    f.telefone, 
                                                                                    f.comissao, 
                                                                                    f.`status`,
                                                                                    t.ncontrato,
                                                                                    i.sigla,
                                                                                    c.nome
                                                                                    FROM formandos f
                                                                                    LEFT JOIN turmas t
                                                                                    ON f.turma = t.id_turma
                                                                                    LEFT JOIN instituicoes i
                                                                                    ON t.id_instituicao = i.id_instituicao
                                                                                    LEFT JOIN cursos c
                                                                                    ON t.curso = c.id_curso"), MYSQLI_ASSOC);

																					foreach ($sql_atual as $vetor) {

																						$sql_vendas_convites = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) vendas_convites FROM vendas vc WHERE vc.tipo = '1' AND vc.iniciada = '2' AND vc.id_formando = '$vetor[id_formando]'"));
																						$sql_vendas_fotografia = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) vendas_fotografias FROM vendas v WHERE v.tipo IN ('2', '3') AND v.id_formando = '$vetor[id_formando]' AND v.iniciada = '2'"));
																						
                                                                                        ?>
                                              <tr>
                                                  <td><?php echo $vetor['ncontrato']; ?></td>
                                                  <td><?php echo $vetor['id_cadastro']; ?></td>       
                                                  <td><?php echo $vetor['f_nome']; ?></td>
                                                  <td><?php echo $vetor['nome']; ?></td>
                                                  <td><?php echo $vetor['conclusao']; ?></td>
                                                  <td><?php echo $vetor['sigla']; ?></td>
                                                  <td><?php echo $vetor['telefone']; ?></td>
                                                  <td>
																										<?php
																										if ($sql_vendas_fotografia['vendas_fotografias'] > 0 && $sql_vendas_convites['vendas_convites'] == 0) {
																											echo "F";
																										}
																										if ($sql_vendas_fotografia['vendas_fotografias'] == 0 &&$sql_vendas_convites['vendas_convites'] > 0) {
																											echo "C";
																										}
																										if ($sql_vendas_fotografia['vendas_fotografias'] > 0 && $sql_vendas_convites['vendas_convites'] > 0) {
																											echo "F/C";
																										}
																										?>
                                                  </td>
                                                  <td><?php if ($vetor['comissao'] == '') { ?>
                                                          <button type="button"
                                                                  class="btn btn-block btn-success btn-sm">Formando
                                                          </button><?php }
																										if ($vetor['comissao'] == '1') { ?>
                                                        <button type="button" class="btn btn-block btn-success btn-sm">
                                                            Formando
                                                        </button><?php }
																										if ($vetor['comissao'] == 2) { ?>
                                                        <button type="button" class="btn btn-block btn-danger btn-sm">
                                                            Comissão
                                                        </button><?php } ?></td>
                                                  <td><a class="fancybox fancybox.ajax"
                                                         href="alterarformando.php?id=<?php echo $vetor['id_formando']; ?>"
                                                         target="_blank">
                                                          <button type="button" class="btn btn-success mesmo-tamanho"
                                                                  title="Ver ou Alterar Cadastro"><i
                                                                      class="mdi mdi-tooltip-edit"></i></button>
                                                      </a>
                                                      <a href="listarlinhatempo.php?id=<?php echo $vetor['id_formando']; ?>"
                                                         target="_blank">
                                                          <button type="button" class="btn btn-warning mesmo-tamanho"
                                                                  title="Linha do Tempo"><i
                                                                      class="mdi mdi-chart-timeline"></i></button>
                                                      </a>
                                                      <a href="imprimirformando.php?id=<?php echo $vetor['id_formando']; ?>"
                                                         target="_blank">
                                                          <button type="button" class="btn btn-primary mesmo-tamanho"
                                                                  title="Imprimir Cadastro"><i
                                                                      class="mdi mdi-cloud-print"></i></button>
                                                      </a> <?php if ($vetor['status'] == 2) { ?><a
                                                          href="liberaracesso.php?id=<?php echo $vetor['id_formando']; ?>" >
                                                              <button type="button"
                                                                      class="btn btn-default mesmo-tamanho"
                                                                      title="Liberar Acesso"><i
                                                                          class="mdi mdi-account-key"></i></button>
                                                          </a> <?php }
																										if ($vetor['status'] == 1) { ?><a
                                                        href="bloquearacesso.php?id=<?php echo $vetor['id_formando']; ?>" >
                                                            <button type="button" class="btn btn-default mesmo-tamanho"
                                                                    title="Bloquear Acesso"><i
                                                                        class="mdi mdi-account-key"></i></button>
                                                        </a> <?php }
																										if ($vetor_permissao['exclusao'] == 1) {
																										}else { ?><a class="fancybox fancybox.ajax"
                                                                 href="confexcluirformando.php?id=<?php echo $vetor['id_formando']; ?>">
                                                            <button type="button" class="btn btn-danger mesmo-tamanho"
                                                                    title="Excluir Cadastro"><i
                                                                        class="mdi mdi-window-close"></i></button>
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

      <script src="../layout/dist/js/pages/dashboards/dashboard1.js"></script>
      <script src="../layout/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
      <script src="../layout/dist/js/pages/datatable/datatable-basic.init.js"></script>
      </body>

      </html>
	<?php }
} ?>