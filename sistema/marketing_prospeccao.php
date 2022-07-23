<?php

include "../includes/conexao.php";

if(isset($_GET['novo'])){
    $id = $_GET[ 'id' ];
    if($_GET['novo'] == 'sim'){
        $sql_exclui = mysqli_query($con,"delete FROM prospeccoes where id_prospeccao = '$id'");
    }else{
        $sql_exclui = mysqli_query($con,"delete FROM marketing where id_mkt = '$id'");
    }
    if($sql_exclui){
        echo "OK";
    }else{
        echo "ERRO";
    }
    die();
}


session_start();
$id_pagina = 104;
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
          <script type="text/javascript">
              function arrumaModal(id) {
                  $('#confirmouExclusao').attr('onclick','excluiCadastro(' + id + ')')
              }
              function excluiCadastro(id) {
                  $.ajax({
                      url: 'marketing_prospeccao.php?id=' + id + '&novo=nao',
                      type: "POST",
                      success: function(rep) {
                          if(rep == 'OK'){
                              alert('Excluido com Sucesso');
                              window.location.reload(true);
                          }else{
                              alert('Erro na Modificação do banco de dados');
                          }
                      }
                  });
              }
              function arrumaModalP(id) {
                  $('#confirmouExclusao').attr('onclick','excluiCadastroP(' + id + ')')
              }
              function excluiCadastroP(id) {
                  $.ajax({
                      url: 'marketing_prospeccao.php?id=' + id + '&novo=sim',
                      type: "POST",
                      success: function(rep) {
                          if(rep == 'OK'){
                              alert('Excluido com Sucesso');
                              window.location.reload(true);
                          }else{
                              alert('Erro na Modificação do banco de dados');
                          }
                      }
                  });
              }
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
<!--                          <h4 class="page-title">Marketing</h4>-->
                          <div class="d-flex align-items-center">
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item">Marketing</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Prospecção</li>
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
<!--                                  <h4 class="card-title">Prospecção</h4>-->
																
																<?php if ($vetor_permissao['cadastro'] == 1) {
																}else { ?><a href="cadastrar_prospeccao.php">
                                    <button type="button" class="btn waves-effect waves-light btn-warning">Nova
                                        Prospecção
                                    </button>
                                </a>

                                    <br>
                                    <br>
                                    <br>
																
																<?php } ?>

                                  <div class="table-responsive">
                                      <table id="lang_opt" class="table table-striped table-bordered display"
                                             style="width:100%">
                                          <thead>
                                          <tr>
                                              <th><strong>Turma</strong></th>
                                              <th><strong>Cidade</strong></th>
                                              <th><strong>UF</strong></th>
                                              <th><strong>Região</strong></th>
                                              <th><strong>Administração</strong></th>
                                              <th><strong>Vagas</strong></th>
                                              <th><strong style="white-space: nowrap">Viabilidade Fotografia</strong></th>
                                              <th><strong style="white-space: nowrap">Viabilidade Convite</strong></th>
                                              <th><strong style="white-space: nowrap">Viabilidade Ensaio</strong></th>
                                              <th><strong style="white-space: nowrap">Viabilidade Placa</strong></th>
                                              <th><strong>Ação</strong></th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $sql_atual = mysqli_query($con, "select * from prospeccoes order by id_prospeccao ASC");
                                          while ($vetor = mysqli_fetch_array($sql_atual)) {
                                              $sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '$vetor[id_turma]'");
                                              $vetor_turma = mysqli_fetch_array($sql_turma);
                                              $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[id_curso]'");
                                              $vetor_curso = mysqli_fetch_array($sql_curso);
                                              $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
                                              $vetor_instituicao = mysqli_fetch_array($sql_instituicao);
                                              ?>
                                              <tr>
                                                  <td><?php echo $vetor_curso['nome']; ?>
                                                      / <?php echo $vetor_curso['sigla']; ?>
                                                      / <?php echo $vetor_turma['conclusao']; ?>
                                                      -<?php echo $vetor_turma['semestre']; ?>
                                                  </td>
                                                  <td><?php echo $vetor_instituicao['cidade']; ?></td>
                                                  <td><?php echo $vetor_instituicao['estado']; ?></td>
                                                  <td><?php echo $vetor_instituicao['regiao']; ?></td>
                                                  <td><?php echo $vetor_instituicao['administracao']; ?></td>
                                                  <td><?php echo $vetor_curso['vagas1']; ?></td>
                                                  <!--                                                  <td>--><?php //if ($vetor['oportunidade'] == 1) {
                                                  //																											echo "Sim";
                                                  //																										}
                                                  //																										if ($vetor['oportunidade'] == 2) {
                                                  //																											echo "Não";
                                                  //																										} ?>
                                                  <!--                                                  </td>-->
                                                  <td align="center">
                                                      <?php if ($vetor['fotografia_viabilidade'] == 'viavel' || $vetor['fotografia_viabilidade'] == 'gerado') { ?>
                                                          <span style="color:transparent;">a</span>
                                                          <button type="button" class="btn btn-success"
                                                                  title="Contrato Fechado"><i
                                                                      class="fa fa-thumbs-up"></i></button>
                                                      <?php }else{ ?>
                                                          <span style="color:transparent;">b</span>
                                                          <button type="button" class="btn btn-danger"
                                                                  title="Contrato Não Fechado"><i
                                                                      class="fa fa-thumbs-down"></i></button>
                                                      <?php } ?>
                                                  </td>
                                                  <td align="center"><?php if ($vetor['convite_viabilidade'] == 'viavel' || $vetor['convite_viabilidade'] == 'gerado') { ?>
                                                          <span style="color:transparent;">a</span>
                                                          <button type="button" class="btn btn-success"
                                                                  title="Contrato Fechado"><i
                                                                      class="fa fa-thumbs-up"></i></button><?php }else{ ?>
                                                          <span style="color:transparent;">b</span>
                                                          <button type="button" class="btn btn-danger"
                                                                  title="Contrato Não Fechado"><i
                                                                      class="fa fa-thumbs-down"></i></button><?php } ?>
                                                  </td><td align="center"><?php if ($vetor['ensaio_viabilidade'] == 'viavel' || $vetor['ensaio_viabilidade'] == 'gerado') { ?>
                                                          <span style="color:transparent;">a</span>
                                                          <button type="button" class="btn btn-success"
                                                                  title="Contrato Fechado"><i
                                                                      class="fa fa-thumbs-up"></i></button><?php }else{ ?>
                                                          <span style="color:transparent;">b</span>
                                                          <button type="button" class="btn btn-danger"
                                                                  title="Contrato Não Fechado"><i
                                                                      class="fa fa-thumbs-down"></i></button><?php } ?>
                                                  </td><td align="center"><?php if ($vetor['placa_viabilidade'] == 'viavel' || $vetor['placa_viabilidade'] == 'gerado') { ?>
                                                          <span style="color:transparent;">a</span>
                                                          <button type="button" class="btn btn-success"
                                                                  title="Contrato Fechado"><i
                                                                      class="fa fa-thumbs-up"></i></button><?php }else{ ?>
                                                          <span style="color:transparent;">b</span>
                                                          <button type="button" class="btn btn-danger"
                                                                  title="Contrato Não Fechado"><i
                                                                      class="fa fa-thumbs-down"></i></button><?php } ?>
                                                  </td>
                                                  <td><a class="fancybox fancybox.ajax"
                                                         href="alterarprospeccao.php?id=<?php echo $vetor['id_prospeccao']; ?>"
                                                         >
                                                          <button type="button" class="btn btn-success mesmo-tamanho"
                                                                  title="Ver ou Alterar Cadastro"><i
                                                                      class="mdi mdi-tooltip-edit"></i></button>
                                                      </a> <?php if ($vetor_permissao['exclusao'] == 1) {
                                                      }else { ?>
                                                          <button type="button" class="btn btn-danger"
                                                                  data-toggle="modal" data-target="#confirmaExcluir"
                                                                  title="Excluir Lead"
                                                                  onclick="arrumaModalP(<?php echo $vetor['id_prospeccao']; ?>)">
                                                              <i
                                                                      class="mdi mdi-window-close"></i>
                                                          </button>
                                                          <?php } ?></td>
                                              </tr>
                                          <?php } ?>

                                          <?php
                                          $sql_atual = mysqli_query($con, "select * from marketing order by id_mkt ASC");
                                          while ($vetor = mysqli_fetch_array($sql_atual)) {
                                              $sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '$vetor[id_turma]'");
                                              $vetor_turma = mysqli_fetch_array($sql_turma);
                                              $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[id_curso]'");
                                              $vetor_curso = mysqli_fetch_array($sql_curso);
                                              $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
                                              $vetor_instituicao = mysqli_fetch_array($sql_instituicao);
                                              ?>
                                              <tr>
                                                  <td><?php echo $vetor_curso['nome']; ?>
                                                      / <?php echo $vetor_curso['sigla']; ?>
                                                      / <?php echo $vetor_turma['conclusao']; ?>
                                                      -<?php echo $vetor_turma['semestre']; ?>
                                                  </td>
                                                  <td><?php echo $vetor_instituicao['cidade']; ?></td>
                                                  <td><?php echo $vetor_instituicao['estado']; ?></td>
                                                  <td><?php echo $vetor_instituicao['regiao']; ?></td>
                                                  <td><?php echo $vetor_instituicao['administracao']; ?></td>
                                                  <td><?php echo $vetor['qtdalunos']; ?></td>
                                                  <!--                                                  <td>--><?php //if ($vetor['oportunidade'] == 1) {
                                                  //																											echo "Sim";
                                                  //																										}
                                                  //																										if ($vetor['oportunidade'] == 2) {
                                                  //																											echo "Não";
                                                  //																										} ?>
                                                  <!--                                                  </td>-->
                                                  <td align="center">
                                                      <?php if($vetor['servico'] == '1' or $vetor['servico'] == '3') { ?>
                                                          <span style="color:transparent;">a</span>
                                                      <button type="button" class="btn btn-success"
                                                              title="Contrato Fechado"><i
                                                                  class="fa fa-thumbs-up"></i></button>
                                                      <?php }else{ ?>
                                                          <span style="color:transparent;">c</span>
                                                      <?php } ?>
                                                  </td>
                                                  <td align="center">
                                                      <?php if($vetor['servico'] == '2' or $vetor['servico'] == '3') { ?>
                                                          <span style="color:transparent;">a</span>
                                                      <button type="button" class="btn btn-success"
                                                              title="Contrato Fechado"><i
                                                                  class="fa fa-thumbs-up"></i></button>
                                                      <?php }else{ ?>
                                                          <span style="color:transparent;">c</span>
                                                      <?php } ?>
                                                  </td>
                                                  <td align="center">
                                                      <span style="color:transparent;">c</span>
                                                  </td>
                                                  <td align="center">
                                                      <span style="color:transparent;">c</span>
                                                  </td>
                                                  <td><a class="fancybox fancybox.ajax"
                                                         href="auxcadastrar_prospeccao.php?id=<?php echo $vetor['id_mkt']; ?>"
                                                         >
                                                          <button type="button" class="btn btn-info"
                                                                  title="Ver ou Alterar Cadastro"><i
                                                                      class="mdi mdi-tooltip-edit"></i></button>
                                                      </a> <?php if ($vetor_permissao['exclusao'] == 1) {
                                                      }else { ?>
                                                          <button type="button" class="btn btn-danger"
                                                                  data-toggle="modal" data-target="#confirmaExcluir"
                                                                  title="Excluir Lead"
                                                                  onclick="arrumaModal(<?php echo $vetor['id_mkt']; ?>)">
                                                              <i
                                                                      class="mdi mdi-window-close"></i></button>
                                                          <?php } ?></td>
                                              </tr>
                                          <?php } ?>
                                          </tbody>
                                      </table>

                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div id="confirmaExcluir" class="modal" tabindex="-1" role="dialog">
                      <div class="modal-dialog modal-md" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title">Exclusão de Lead</h5>
                                  <button type="button" class="close" data-dismiss="modal"
                                          aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                  <p>Você tem certeza que deja excluir a Lead?</p>
                              </div>
                              <div class="modal-footer">
                                  <button id="confirmouExclusao" type="button" class="btn btn-danger"
                                          onclick="excluiCadastro()">Excluir Lead
                                  </button>
                                  <button type="button" class="btn btn-success"
                                          data-dismiss="modal">Voltar
                                  </button>
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