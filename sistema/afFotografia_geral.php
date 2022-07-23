<?php
include "../includes/conexao.php";
session_start();
$id_pagina = 56;
$id_usuario = $_SESSION['id'];
$usuarios_permitidos = array(1, 2, 67,74,68,45);
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
}else {
	if (in_array($id_usuario, $usuarios_permitidos)) {
		$limita = 0;
	}else {
		$limita = 1;
	}
	$sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '{$id_pagina}' and id_usuario = '{$_SESSION['id']}'");
	$vetor_permissao = mysqli_fetch_array($sql_permissao);
	if ($vetor_permissao['listar'] != 2) {
		echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
	}
	$horaTotal = 0;
	$minutosTotal = 0;
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
              function openModal(id, tipo) {
                  $('#id_modal').attr('value', id);
                  switch (tipo) {
                      case '1':
                          $('#id_modal_inserir').attr('value', '1');
                          break;
                      case '2':
                          $('#id_modal_inserir').attr('value', '2');
                          break;
                      case '3':
                          $('#id_modal_inserir').attr('value', '3');
                          break;
                      case '4':
                          $('#id_modal_inserir').attr('value', '4');
                          break;
                  }
                  $('#modalEnviarUsuario').modal('show');
              }

              function enviaUsuario() {
                  var inserir = $('#id_modal_inserir').val();
                  var id = $('#id_modal').val();
                  var usuario = $('#id_usuario').val();
                  $.post('recebe_fotografiageral.php?inserir=' + inserir, {
                      id: id,
                      usuario: usuario
                  }, function (response) {
                      switch (inserir) {
                          case '4':
                              $('#topfotos_' + id).html(response);
                              break;
                          case '3':
                              $('#escolha_' + id).html(response);
                              break;
                          case '2':
                              $('#album_' + id).html(response);
                              break;
                          case '1':
                              $('#convite_' + id).html(response);
                              break;
                      }
                  });
              }

              function dataAtualFormatada() {
                  var data = new Date(),
                      dia = data.getDate().toString().padStart(2, '0'),
                      mes = (data.getMonth() + 1).toString().padStart(2, '0'), //+1 pois no getMonth Janeiro começa com zero.
                      ano = data.getFullYear();
                  return dia + "/" + mes + "/" + ano;
              }

              function finalizaJob(id, inserir) {
                  $.post('recebe_fotografiageral.php?id=' + id + '&inserir=' + inserir, function () {
                      switch (inserir) {
                          case '4':
                              var eaux = document.getElementById('t_' + id).nextElementSibling.lastElementChild;
													<?php if($limita == 0){ ?>
                              eaux.classList.remove('btn-warning');
                              eaux.classList.add('btn-danger');
                              eaux.setAttribute("onclick", "gerarOs('" + id + "','4')");
                              eaux.setAttribute("title", "Recuperar Job");
                              eaux.innerHTML = "Gerar OS";
													<?php }else{ ?>
                              eaux.remove();
													<?php } ?>
                              document.getElementById('t_' + id).previousElementSibling.previousElementSibling.previousElementSibling.innerHTML = dataAtualFormatada();
                              document.getElementById('t_' + id).remove();
                              var aux = document.getElementById('tf_' + id).cloneNode(true);
                              document.getElementById('tf_' + id).remove();
                              $('#lang_opt2 tr:last').after(aux);
                              break;
                          case '3':
                              var eaux = document.getElementById('e_' + id).nextElementSibling.lastElementChild;
													<?php if($limita == 0){ ?>
                              eaux.classList.remove('btn-warning');
                              eaux.classList.add('btn-danger');
                              eaux.setAttribute("onclick", "gerarOs('" + id + "','4')");
                              eaux.setAttribute("title", "Recuperar Job");
                              eaux.innerHTML = "Gerar OS";
													<?php }else{ ?>
                              eaux.remove();
													<?php } ?>
                              document.getElementById('e_' + id).previousElementSibling.previousElementSibling.previousElementSibling.innerHTML = dataAtualFormatada();
                              document.getElementById('e_' + id).remove();
                              var aux = document.getElementById('es_' + id).cloneNode(true);
                              document.getElementById('es_' + id).remove();
                              $('#lang_opt2 tr:last').after(aux);
                              break;
                              A
                          case '2':
                              var eaux = document.getElementById('a_' + id).nextElementSibling.lastElementChild;
													<?php if($limita == 0){ ?>
                              eaux.classList.remove('btn-warning');
                              eaux.classList.add('btn-danger');
                              eaux.setAttribute("onclick", "gerarOs('" + id + "','4')");
                              eaux.setAttribute("title", "Recuperar Job");
                              eaux.innerHTML = "Gerar OS";
													<?php }else{ ?>
                              eaux.remove();
													<?php } ?>
                              document.getElementById('a_' + id).previousElementSibling.previousElementSibling.previousElementSibling.innerHTML = dataAtualFormatada();
                              document.getElementById('a_' + id).remove();
                              var aux = document.getElementById('al_' + id).cloneNode(true);
                              document.getElementById('al_' + id).remove();
                              $('#lang_opt2 tr:last').after(aux);
                              break;
                          case '1':
                              var eaux = document.getElementById('c_' + id).nextElementSibling.lastElementChild;
													<?php if($limita == 0){ ?>
                              eaux.classList.remove('btn-warning');
                              eaux.classList.add('btn-danger');
                              eaux.setAttribute("onclick", "gerarOs('" + id + "','4')");
                              eaux.setAttribute("title", "Recuperar Job");
                              eaux.innerHTML = "Gerar OS";
													<?php }else{ ?>
                              eaux.remove();
													<?php } ?>
                              document.getElementById('c_' + id).previousElementSibling.previousElementSibling.previousElementSibling.innerHTML = dataAtualFormatada();
                              document.getElementById('c_' + id).remove();
                              var aux = document.getElementById('co_' + id).cloneNode(true);
                              document.getElementById('co_' + id).remove();
                              $('#lang_opt2 tr:last').after(aux);
                              break;
                      }
                      alert('O Serviço foi Finalizado.');
                  });
              }

              function gerarOs(id, inserir) {
                  $.post('recebe_fotografiageral.php?id=' + id + '&remover=' + inserir, function () {
                      switch (inserir) {
                          case '4':
                              document.getElementById('tf_' + id).remove();
                              break;
                          case '3':
                              document.getElementById('es_' + id).remove();
                              break;
                              A
                          case '2':
                              document.getElementById('al_' + id).remove();
                              break;
                          case '1':
                              document.getElementById('co_' + id).remove();
                              break;
                      }
                      alert('O Serviço foi Recuperado.');
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
                          <!--                          <h4 class="page-title">Arte Final - Fotografia</h4>-->
                          <div class="d-flex align-items-center">
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item">Arte Final - Fotografia</a></li>
                                      <li class="breadcrumb-item">Aprovação Produtos Fotografia</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Produtos Formando</li>
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
																<?php if ($limita == 0) { ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Colaboradores</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <select name="categoria" id="categoria"
                                                            class="form-control"
                                                            required>
                                                        <option value="" selected="selected">Todos os
                                                            Colaboradores
                                                        </option>
																											<?php
																											$sql = mysqli_query($con, "select * from usuarios where departamento='10' order by nome ASC");
																											while ($vetor = mysqli_fetch_array($sql)) { ?>
                                                          <option value="<?php echo $vetor['nome']; ?>"><?php echo $vetor['nome'] ?></option>
																											<?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8"></div>
                                    </div>
																<?php } ?>
                                  <br>
                                  <br>
                                  <ul class="nav nav-tabs" role="tablist">

                                      <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                              href="#execucao"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Em Execução</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                              href="#finalizado"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Finalizados</span></a>
                                      </li>

                                  </ul>

                                  <div id="modalEnviarUsuario" class="modal fade"
                                       role="dialog" aria-hidden="true" tabindex="-1">
                                      <div class="modal-dialog modal-lg" role="document" style="display:table;">
                                          <!-- Modal content-->
                                          <input type="text" id="id_modal" class="form-control" hidden>
                                          <input type="text" id="id_modal_inserir" class="form-control" hidden>
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h4 class="modal-title">Enviar Colaborador</h4>
                                              </div>
                                              <div class="modal-body">
                                                  <div class="col-lg-12">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Colaborador</label>
                                                          <select id="id_usuario" name="usuario" class="form-control">
                                                              <option value="" selected="selected">Selecione...
                                                              </option>
																														<?php
																														$sql = mysqli_query($con, "select * from usuarios where departamento='10' order by nome ASC");
																														while ($vetor = mysqli_fetch_array($sql)) {
																															?>
                                                                <option value="<?php echo $vetor['id_usuario']; ?>"><?php echo $vetor['nome'] ?></option>
																														<?php } ?>
                                                          </select>
                                                      </fieldset>
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button"
                                                          class="btn btn-success"
                                                          onclick="enviaUsuario()"
                                                          data-dismiss="modal">Salvar
                                                  </button>
                                                  <button type="button"
                                                          class="btn btn-default"
                                                          data-dismiss="modal">Fechar
                                                  </button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="tab-content tabcontent-border">
                                      <div class="tab-pane active" id="execucao" role="tabpanel">
                                          <br>
                                          <br>
                                          <div class="table-responsive">
                                              <table id="lang_opt" class="table table-striped table-bordered display"
                                                     style="width:100%">
                                                  <thead align="center">
                                                  <tr>
                                                      <th width="10%"><strong><h5>Código</h5></strong></th>
                                                      <th><strong><h5>Nome</h5></strong></th>
                                                      <th><strong><h5>Job</h5></strong></th>
                                                      <th><strong><h5>Atividade</h5></strong></th>
                                                      <th><strong><h5>Data de Entrada</h5></strong></th>
                                                      <th><strong><h5>Serviço</h5></strong></th>
                                                      <th><strong><h5>Responsável</h5></strong></th>
                                                      <th><strong><h5>Tempo Estimado</h5></strong></th>
                                                      <th width="10%"><strong><h5>Ação</h5></strong></th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
																									<?php
																									$sql_atual = mysqli_query($con, "select
	ce.id_exclusive ,
	ce.id_responsavel ,
	u.nome as unome ,
	ce.dataaprovacao ,
	t.ncontrato ,
	f.id_cadastro ,
	f.nome as fnome
from
	convite_exclusive ce
left join
	usuarios u on u.id_usuario = ce.id_responsavel
left join
	formandos f on f.id_formando = ce.id_formando
left join
	turmas t on t.id_turma = f.turma
where
	ce.status in ('3','4') and ce.finalizado is null ".($limita == 1 ? 'and ce.id_responsavel = '.$_SESSION['id'] : '')."
order by
	ce.id_exclusive DESC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										if ($vetor['id_responsavel'] == null  || $vetor['id_responsavel'] == 0) {
																											$responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal('.$vetor['id_exclusive'].',\'1\')"
                                                                  class="btn btn-info btn-block">Enviar
                                                          </button>';
																										}elseif($limita == 0) {
                                                                                                            $responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal('.$vetor['id_exclusive'].',\'1\')"
                                                                  class="btn btn-info btn-block">'. $vetor['unome'] .'
                                                          </button>';
																										}else{
                                                                                                            $responsavel = $vetor['unome'];
                                                                                                        }
																										$qtd_paginas = mysqli_fetch_array(mysqli_query($con, "select sum(qtdfotos) as qtd from convite_exclusive_itens where id_exclusive = '{$vetor['id_exclusive']}' and tipo='1'"));
																										$tempo = floor((int)$qtd_paginas['qtd'] * 900 / 60);
																										$qtd_paginas = mysqli_fetch_array(mysqli_query($con, "select sum(qtdfotos) as qtd from convite_exclusive_itens where id_exclusive = '{$vetor['id_exclusive']}' and tipo='2'"));
																										$tempo += floor((int)$qtd_paginas['qtd'] * 300 / 60) + 10;
																										?>
                                                      <tr id="co_<?php echo $vetor['id_exclusive']; ?>">
                                                          <td align="center"><?php echo $vetor['ncontrato']; ?>
                                                              -<?php echo $vetor['id_cadastro']; ?></td>
                                                          <td><?php echo $vetor['fnome']; ?></td>
                                                          <td align="center">Convite</td>
                                                          <td align="center">Escolha de Fotos</td>
                                                          <td align="center"><?php if ($vetor['dataaprovacao'] != null) {
																															echo date('d/m/Y', strtotime($vetor['dataaprovacao']));
																														} ?>
                                                          </td>
                                                          <td align="center">Recorte/Tratamento Fotos</td>
                                                          <td align="center"
                                                              id="convite_<?php echo $vetor['id_exclusive']; ?>"><?php echo $responsavel; ?></td>
                                                          <td id="c_<?php echo $vetor['id_exclusive']; ?>"
                                                              align="center"><?php echo $tempo; ?></td>
                                                          <td align="center">
                                                              <a class="fancybox fancybox.ajax"
                                                                 href="alterarexclusive.php?id=<?php echo $vetor['id_exclusive']; ?>"
                                                                 target="_blank">
                                                                  <button type="button"
                                                                          class="btn btn-success"
                                                                          title="Alterar"><i
                                                                              class="mdi mdi-tooltip-edit"></i>
                                                                  </button>
                                                              </a>
                                                              <button type="button"
                                                                      class="btn btn-warning"
                                                                      onclick="finalizaJob(<?php echo $vetor['id_exclusive']; ?>,'1')"
                                                                      title="Finalizar Job">Finalizar
                                                              </button>
                                                          </td>
                                                      </tr>
																									<?php } ?>
																									
																									<?php
																									$sql_atual = mysqli_query($con, "select
	me.id_meualbum ,
	me.id_responsavel ,
	u.nome as unome ,
	me.dataaprovacao ,
	t.ncontrato ,
	f.id_cadastro ,
	f.nome as fnome,
	tp.tempo_unitario,
	tp.nome as tnome
from
	meu_album me
left join
	usuarios u on u.id_usuario = me.id_responsavel
left join
	tipo_opcionais tp on tp.id_tipo = me.id_item
left join
	formandos f on f.id_formando = me.id_formando
left join
	turmas t on t.id_turma = f.turma
where
	me.status in ('3','4','5') and me.finalizado is null ".($limita == 1 ? 'and me.id_responsavel = '.$_SESSION['id'] : '')."
order by
	me.id_meualbum DESC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                                                                        if ($vetor['id_responsavel'] == null  || $vetor['id_responsavel'] == 0) {
                                                                                                            $responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal('.$vetor['id_meualbum'].',\'2\')"
                                                                  class="btn btn-info btn-block">Enviar
                                                          </button>';
                                                                                                        }elseif($limita == 0) {
                                                                                                            $responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal('.$vetor['id_meualbum'].',\'2\')"
                                                                  class="btn btn-info btn-block">'. $vetor['unome'] .'
                                                          </button>';
                                                                                                        }else{
                                                                                                            $responsavel = $vetor['unome'];
                                                                                                        }

																										$qtd_paginas = mysqli_fetch_array(mysqli_query($con, "select count(id_meualbum) as qtd from meu_album_paginas where id_meualbum = '{$vetor['id_meualbum']}' and descricao <> ''"));
                                                                                                        if($vetor['tempo_unico'] == '1'){
                                                                                                            $tempo = ((int)$qtd_paginas['qtd'] * 5) + 10;
                                                                                                        }else{
                                                                                                            $tempo = (((int)$qtd_paginas['qtd'] * (int)$vetor['tempo_unitario']) / 60) + 10;
                                                                                                        }
																										?>
                                                      <tr id="al_<?php echo $vetor['id_meualbum']; ?>">
                                                          <td align="center"><?php echo $vetor['ncontrato']; ?>
                                                              -<?php echo $vetor['id_cadastro']; ?></td>
                                                          <td><?php echo $vetor['fnome']; ?></td>
                                                          <td align="center"><?php echo $vetor['tnome']; ?></td>
                                                          <td align="center">Aprovação</td>
                                                          <td align="center"><?php if ($vetor['dataaprovacao'] != null) {
																															echo date('d/m/Y', strtotime($vetor['dataaprovacao']));
																														} ?>
                                                          </td>
                                                          <td align="center">Diagramação/Tratamento</td>
                                                          <td align="center"
                                                              id="album_<?php echo $vetor['id_meualbum']; ?>"><?php echo $responsavel; ?></td>
                                                          <td id="a_<?php echo $vetor['id_meualbum']; ?>"
                                                              align="center"><?php echo $tempo; ?></td>
                                                          <td align="center">
                                                              <a class="fancybox fancybox.ajax"
                                                                 href="alteraralbumformando.php?id=<?php echo $vetor['id_meualbum']; ?>"
                                                                 target="_blank">
                                                                  <button type="button"
                                                                          class="btn btn-success"
                                                                          title="Ver ou Alterar Cadastro"><i
                                                                              class="mdi mdi-tooltip-edit"></i>
                                                                  </button>
                                                              </a>
                                                              <button type="button"
                                                                      class="btn btn-warning"
                                                                      onclick="finalizaJob(<?php echo $vetor['id_meualbum']; ?>,'2')"
                                                                      title="Finalizar Job">Finalizar
                                                              </button>
                                                          </td>
                                                      </tr>
																									<?php }
																									$sql_atual = mysqli_query($con, "select
	ef.id_escolha ,
	ef.id_responsavel ,
	u.nome as unome ,
	ef.dataaprovacao ,
	t.ncontrato ,
	f.id_cadastro ,
	f.nome as fnome,
	tp.tempo_unitario,
	tp.nome as tnome
from
	escolha_fotos ef
left join
	usuarios u on u.id_usuario = ef.id_responsavel
left join
	tipo_opcionais tp on tp.id_tipo = ef.id_item
left join
	formandos f on f.id_formando = ef.id_formando
left join
	turmas t on t.id_turma = f.turma
where
	ef.status in ('3','4') and ef.finalizado is null ".($limita == 1 ? 'and ef.id_responsavel = '.$_SESSION['id'] : '')."
order by
	ef.id_escolha DESC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                                                                        if ($vetor['id_responsavel'] == null  || $vetor['id_responsavel'] == 0) {
                                                                                                            $responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal('.$vetor['id_escolha'].',\'3\')"
                                                                  class="btn btn-info btn-block">Enviar
                                                          </button>';
                                                                                                        }elseif($limita == 0) {
                                                                                                            $responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal('.$vetor['id_escolha'].',\'3\')"
                                                                  class="btn btn-info btn-block">'. $vetor['unome'] .'
                                                          </button>';
                                                                                                        }else{
                                                                                                            $responsavel = $vetor['unome'];
                                                                                                        }

                                                                                                        if($vetor['tempo_unico'] == 1){
                                                                                                            $tempo = (((int)$vetor['tempo_unitario']) / 60) + 10;
                                                                                                        }else{
                                                                                                            $qtd_paginas = mysqli_fetch_array(mysqli_query($con, "select count(id_escolha) as qtd from escolha_fotos_itens where id_escolha = '{$vetor['id_escolha']}' and bloqueio <> 2"));
                                                                                                            $tempo = (((int)$qtd_paginas['qtd'] * (int)$vetor['tempo_unitario']) / 60) + 10;
                                                                                                        }
																										?>
                                                      <tr id="es_<?php echo $vetor['id_escolha']; ?>">
                                                          <td align="center"><?php echo $vetor['ncontrato']; ?>
                                                              -<?php echo $vetor['id_cadastro']; ?></td>
                                                          <td><?php echo $vetor['fnome']; ?></td>
                                                          <td align="center"><?php echo $vetor['tnome']; ?></td>
                                                          <td align="center">Escolha de Fotos</td>
                                                          <td align="center"><?php if ($vetor['dataaprovacao'] != null) {
																															echo date('d/m/Y', strtotime($vetor['dataaprovacao']));
																														} ?></td>
                                                          <td align="center">Diagramação/Tratamento</td>
                                                          <td align="center"
                                                              id="escolha_<?php echo $vetor['id_escolha']; ?>"><?php echo $responsavel; ?></td>
                                                          <td id="e_<?php echo $vetor['id_escolha']; ?>"
                                                              align="center"><?php echo $tempo; ?></td>
                                                          <td align="center">
                                                              <a class="fancybox fancybox.ajax"
                                                                 href="alterarescolhafoto.php?id=<?php echo $vetor['id_escolha']; ?>"
                                                                 target="_blank">
                                                                  <button type="button" class="btn btn-success"
                                                                          title="Ver ou Alterar Cadastro"><i
                                                                              class="mdi mdi-tooltip-edit"></i>
                                                                  </button>
                                                              </a>
                                                              <button type="button"
                                                                      class="btn btn-warning"
                                                                      onclick="finalizaJob(<?php echo $vetor['id_escolha']; ?>,'3')"
                                                                      title="Finalizar Job">Finalizar
                                                              </button>
                                                          </td>
                                                      </tr>
																									<?php } ?>
																									
																									<?php
																									$sql_atual = mysqli_query($con, "select
	eft.id_escolha ,
	eft.id_responsavel ,
	eft.id_evento,
	f.id_formando,
	u.nome as unome ,
	eft.data ,
	t.ncontrato ,
	f.id_cadastro ,
	f.nome as fnome,
	e.titulo
from
	escolha_fotos_tratamento eft
left join
	usuarios u on u.id_usuario = eft.id_responsavel
left join
	eventosformando e on e.id_evento_turma = eft.id_evento
left join
	formandos f on f.id_formando = eft.id_formando
left join
	turmas t on t.id_turma = f.turma
where
	eft.finalizado is null ".($limita == 1 ? 'and eft.id_responsavel = '.$_SESSION['id'] : '')."
group by
	eft.id_formando DESC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                                                                        if ($vetor['id_responsavel'] == null  || $vetor['id_responsavel'] == 0) {
                                                                                                            $responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal('.$vetor['id_escolha'].',\'4\')"
                                                                  class="btn btn-info btn-block">Enviar
                                                          </button>';
                                                                                                        }elseif($limita == 0) {
                                                                                                            $responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal('.$vetor['id_escolha'].',\'4\')"
                                                                  class="btn btn-info btn-block">'. $vetor['unome'] .'
                                                          </button>';
                                                                                                        }else{
                                                                                                            $responsavel = $vetor['unome'];
                                                                                                        }
																										$qtd_paginas = mysqli_fetch_array(mysqli_query($con, "select count(id_escolha) as qtd from escolha_fotos_tratamento where id_formando = '{$vetor['id_formando']}'"));
																										$tempo = (((int)$qtd_paginas['qtd'] * 900) / 60) + 10;
																										?>
                                                      <tr id="tf_<?php echo $vetor['id_escolha']; ?>">
                                                          <td align="center"><?php echo $vetor['ncontrato']; ?>
                                                              -<?php echo $vetor['id_cadastro']; ?></td>
                                                          <td><?php echo $vetor['fnome']; ?></td>
                                                          <td align="center">Top
                                                              Fotos<br><?php echo $vetor['titulo']; ?>
                                                          </td>
                                                          <td align="center">Escolha de Fotos</td>
                                                          <td align="center">
																														<?php if ($vetor['data'] != null) {
																															echo date('d/m/Y', strtotime($vetor['data']));
																														} ?>
                                                          </td>
                                                          <td align="center">Tratamento</td>
                                                          <td align="center"
                                                              id="topfotos_<?php echo $vetor['id_escolha']; ?>"><?php echo $responsavel; ?></td>
                                                          <td id="t_<?php echo $vetor['id_escolha']; ?>"
                                                              align="center"><?php echo $tempo; ?></td>
                                                          <td align="center">
                                                              <a class="fancybox fancybox.ajax"
                                                                 href="vertopfotos.php?id_formando=<?php echo $vetor['id_formando']; ?>&id_evento=<?php echo $vetor['id_evento']; ?>"
                                                                 target="_blank">
                                                                  <button type="button"
                                                                          class="btn btn-success"
                                                                          title="Ver ou Alterar Cadastro"><i
                                                                              class="mdi mdi-tooltip-edit"></i>
                                                                  </button>
                                                              </a>
                                                              <button type="button"
                                                                      class="btn btn-warning"
                                                                      onclick="finalizaJob(<?php echo $vetor['id_escolha']; ?>,'4')"
                                                                      title="Finalizar Job">Finalizar
                                                              </button>
                                                          </td>
                                                      </tr>
																									<?php } ?>
                                                  </tbody>
                                                  <tfoot>
                                                  <tr>
                                                      <th align="center" style="border:none"></th>
                                                      <th align="center" style="border:none"></th>
                                                      <th align="center" style="border:none"></th>
                                                      <th align="center" style="border:none"></th>
                                                      <th align="center" style="border:none"></th>
                                                      <th align="center" style="border:none"></th>
                                                      <th align="center"
                                                          style="border:none;text-align: center;white-space: nowrap"></th>
                                                      <th align="center"
                                                          style="border:none;text-align: center;white-space: nowrap"></th>
                                                      <th align="center" style="border:none"></th>
                                                  </tr>
                                                  </tfoot>
                                              </table>
                                          </div>
                                      </div>


                                      <div class="tab-pane" id="finalizado" role="tabpanel">
                                          <br>
                                          <br>
                                          <div class="table-responsive">
                                              <table id="lang_opt2" class="table table-striped table-bordered display"
                                                     style="width:100%">
                                                  <thead align="center">
                                                  <tr>
                                                      <th width="10%"><strong><h5>Código</h5></strong></th>
                                                      <th><strong><h5>Nome</h5></strong></th>
                                                      <th><strong><h5>Job</h5></strong></th>
                                                      <th><strong><h5>Atividade</h5></strong></th>
                                                      <th><strong><h5>Data de Finalização</h5></strong></th>
                                                      <th><strong><h5>Serviço</h5></strong></th>
                                                      <th><strong><h5>Responśavel</h5></strong></th>
                                                      <th width="10%"><strong><h5>Ação</h5></strong></th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
																									<?php
																									$sql_atual = mysqli_query($con, "select
	ce.id_exclusive ,
	ce.id_responsavel ,
	u.nome as unome ,
	ce.data_finalizado ,
	t.ncontrato ,
	f.id_cadastro ,
	f.nome as fnome
from
	convite_exclusive ce
left join
	usuarios u on u.id_usuario = ce.id_responsavel
left join
	formandos f on f.id_formando = ce.id_formando
left join
	turmas t on t.id_turma = f.turma
where
	ce.status in ('3','4') and ce.finalizado = '0' ".($limita == 1 ? 'and ce.id_responsavel = '.$_SESSION['id'] : '')."
order by
	ce.id_exclusive DESC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										$responsavel = $vetor['unome'];
																										?>
                                                      <tr id="co_<?php echo $vetor['id_exclusive']; ?>">
                                                          <td align="center"><?php echo $vetor['ncontrato']; ?>
                                                              -<?php echo $vetor['id_cadastro']; ?></td>
                                                          <td><?php echo $vetor['fnome']; ?></td>
                                                          <td align="center">Convite</td>
                                                          <td align="center">Escolha de Fotos</td>
                                                          <td align="center"><?php echo date('d/m/Y', strtotime($vetor['data_finalizado'])); ?></td>
                                                          <td align="center">Recorte/Tratamento Fotos</td>
                                                          <td align="center"
                                                              id="convite_<?php echo $vetor['id_exclusive']; ?>"><?php echo $responsavel; ?></td>
                                                          <td align="center">
                                                              <a class="fancybox fancybox.ajax"
                                                                 href="alterarexclusive.php?id=<?php echo $vetor['id_exclusive']; ?>"
                                                                 target="_blank">
                                                                  <button type="button"
                                                                          class="btn btn-success"
                                                                          title="Alterar"><i
                                                                              class="mdi mdi-tooltip-edit"></i>
                                                                  </button>
                                                              </a>
                                                              <button type="button"
                                                                      class="btn btn-danger"
                                                                      onclick="gerarOs(<?php echo $vetor['id_exclusive']; ?>,'1')"
                                                                      title="Recuperar Job">Gerar OS
                                                              </button>
                                                          </td>
                                                      </tr>
																									<?php } ?>
																									
																									<?php
																									$sql_atual = mysqli_query($con, "select
	me.id_meualbum ,
	me.id_responsavel ,
	u.nome as unome ,
	me.data_finalizado ,
	t.ncontrato ,
	f.id_cadastro ,
	f.nome as fnome,
	tp.tempo_unitario,
	tp.nome as tnome
from
	meu_album me
left join
	usuarios u on u.id_usuario = me.id_responsavel
left join
	tipo_opcionais tp on tp.id_tipo = me.id_item
left join
	formandos f on f.id_formando = me.id_formando
left join
	turmas t on t.id_turma = f.turma
where
	me.status in ('3','4','5') and me.finalizado = '0' ".($limita == 1 ? 'and me.id_responsavel = '.$_SESSION['id'] : '')."
order by
	me.id_meualbum DESC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										$responsavel = $vetor['unome'];
																										?>
                                                      <tr id="al_<?php echo $vetor['id_meualbum']; ?>">
                                                          <td align="center"><?php echo $vetor['ncontrato']; ?>
                                                              -<?php echo $vetor['id_cadastro']; ?></td>
                                                          <td><?php echo $vetor['fnome']; ?></td>
                                                          <td align="center"><?php echo $vetor['tnome']; ?></td>
                                                          <td align="center">Aprovação</td>
                                                          <td align="center"><?php if ($vetor['data_finalizado'] != null) {
																															echo date('d/m/Y', strtotime($vetor['data_finalizado']));
																														} ?>
                                                          </td>
                                                          <td align="center">Diagramação/Tratamento</td>
                                                          <td align="center"
                                                              id="album_<?php echo $vetor['id_meualbum']; ?>"><?php echo $responsavel; ?></td>
                                                          <td align="center">
                                                              <a class="fancybox fancybox.ajax"
                                                                 href="alteraralbumformando.php?id=<?php echo $vetor['id_meualbum']; ?>"
                                                                 target="_blank">
                                                                  <button type="button"
                                                                          class="btn btn-success"
                                                                          title="Ver ou Alterar Cadastro"><i
                                                                              class="mdi mdi-tooltip-edit"></i>
                                                                  </button>
                                                              </a>
                                                              <button type="button"
                                                                      class="btn btn-danger"
                                                                      onclick="gerarOs(<?php echo $vetor['id_meualbum']; ?>,'2')"
                                                                      title="Recuperar Job">Gerar OS
                                                              </button>
                                                          </td>
                                                      </tr>
																									<?php } ?>
																									
																									<?php
																									$sql_atual = mysqli_query($con, "select
	ef.id_escolha ,
	ef.id_responsavel ,
	u.nome as unome ,
	ef.data_finalizado ,
	t.ncontrato ,
	f.id_cadastro ,
	f.nome as fnome,
	tp.tempo_unitario,
	tp.nome as tnome
from
	escolha_fotos ef
left join
	usuarios u on u.id_usuario = ef.id_responsavel
left join
	tipo_opcionais tp on tp.id_tipo = ef.id_item
left join
	formandos f on f.id_formando = ef.id_formando
left join
	turmas t on t.id_turma = f.turma
where
	ef.status in ('3','4') and ef.finalizado = '0' ".($limita == 1 ? 'and ef.id_responsavel = '.$_SESSION['id'] : '')."
order by
	ef.id_escolha DESC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										$responsavel = $vetor['unome'];
																										?>
                                                      <tr id="es_<?php echo $vetor['id_escolha']; ?>">
                                                          <td align="center"><?php echo $vetor['ncontrato']; ?>
                                                              -<?php echo $vetor['id_cadastro']; ?></td>
                                                          <td><?php echo $vetor['fnome']; ?></td>
                                                          <td align="center"><?php echo $vetor['fnome']; ?></td>
                                                          <td align="center">Escolha de Fotos</td>
                                                          <td align="center"><?php if ($vetor['data_finalizado'] != null) {
																															echo date('d/m/Y', strtotime($vetor['data_finalizado']));
																														} ?></td>
                                                          <td align="center">Diagramação/Tratamento</td>
                                                          <td align="center"
                                                              id="escolha_<?php echo $vetor['id_escolha']; ?>"><?php echo $responsavel; ?></td>
                                                          <td align="center">
                                                              <a class="fancybox fancybox.ajax"
                                                                 href="alterarescolhafoto.php?id=<?php echo $vetor['id_escolha']; ?>"
                                                                 target="_blank">
                                                                  <button type="button" class="btn btn-success"
                                                                          title="Ver ou Alterar Cadastro"><i
                                                                              class="mdi mdi-tooltip-edit"></i>
                                                                  </button>
                                                              </a>
                                                              <button type="button"
                                                                      class="btn btn-danger"
                                                                      onclick="gerarOs(<?php echo $vetor['id_escolha']; ?>,'3')"
                                                                      title="Recuperar Job">Gerar OS
                                                              </button>
                                                          </td>
                                                      </tr>
																									<?php } ?>
																									
																									<?php
																									$sql_atual = mysqli_query($con, "select
	eft.id_escolha ,
	eft.id_responsavel ,
	eft.id_evento,
	u.nome as unome ,
	eft.data_finalizado ,
	t.ncontrato ,
	f.id_cadastro ,
	f.nome as fnome,
	e.titulo
from
	escolha_fotos_tratamento eft
left join
	usuarios u on u.id_usuario = eft.id_responsavel
left join
	eventosformando e on e.id_evento_turma = eft.id_evento
left join
	formandos f on f.id_formando = eft.id_formando
left join
	turmas t on t.id_turma = f.turma
where
	eft.finalizado = '0' ".($limita == 1 ? 'and eft.id_responsavel = '.$_SESSION['id'] : '')."
group by
	eft.id_formando DESC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										$responsavel = $vetor['unome'];
																										?>
                                                      <tr id="tf_<?php echo $vetor['id_escolha']; ?>">
                                                          <td align="center"><?php echo $vetor['ncontrato']; ?>
                                                              -<?php echo $vetor['id_cadastro']; ?></td>
                                                          <td><?php echo $vetor['fnome']; ?></td>
                                                          <td align="center">Top
                                                              Fotos<br><?php echo $vetor['titulo']; ?>
                                                          </td>
                                                          <td align="center">Escolha de Fotos</td>
                                                          <td align="center"><?php if ($vetor['data_finalizado'] != null) {
																															echo date('d/m/Y', strtotime($vetor['data_finalizado']));
																														} ?></td>
                                                          <td align="center">Tratamento</td>
                                                          <td align="center"
                                                              id="topfotos_<?php echo $vetor['id_escolha']; ?>"><?php echo $responsavel; ?></td>
                                                          <td align="center">
                                                              <a class="fancybox fancybox.ajax"
                                                                 href="vertopfotos.php?id_formando=<?php echo $vetor['id_formando']; ?>&id_evento=<?php echo $vetor['id_evento']; ?>"
                                                                 target="_blank">
                                                                  <button type="button"
                                                                          class="btn btn-success"
                                                                          title="Ver ou Alterar Cadastro"><i
                                                                              class="mdi mdi-tooltip-edit"></i>
                                                                  </button>
                                                              </a>
																														<?php if ($limita == 0) { ?>
                                                                <button type="button"
                                                                        class="btn btn-danger"
                                                                        onclick="gerarOs(<?php echo $vetor['id_escolha']; ?>,'4')"
                                                                        title="Recuperar Job">Gerar OS
                                                                </button>
																														<?php } ?>
                                                          </td>
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

          function formatarCampo(dado, tipo) {
              if (tipo == 1) {
                  var aux = parseInt(dado) - 10;
              } else {
                  var aux = parseInt(dado);
              }
              if (aux >= 60) {
                  var horas = Math.floor(parseInt(aux) / 60);
                  var minutos = parseInt(aux) - (horas * 60);
                  if (tipo == 1) {
                      return horas + "h " + (minutos == 0 ? "" : "e " + minutos + "min") + " + 10min";
                  } else {
                      return horas + "h " + (minutos == 0 ? "" : "e " + minutos + "min");
                  }
              } else {
                  if (tipo == 1) {
                      return aux + "min + 10 min";
                  } else {
                      return aux + "min";
                  }
              }
          }

          var init_data_Table = function () {
              var tabelaNcms = null;
              if ($.fn.dataTable.isDataTable('#lang_opt')) {
                  $('#lang_opt').dataTable().fnDestroy();
                  init_data_Table();
              } else {
                  tabelaNcms = $('#lang_opt').DataTable({
                      destroy: false,
                      "pageLength": 50,
                      scrollCollapse: true,
                      ordering: true,
                      info: true,
                      searching: true,
                      paging: true,
                      dom: 'Bfrtip',
                      "order": [[4, "desc"]],
                      columnDefs: [
                          {
                              type: 'date-br',
                              targets: 4
                          },
                          {
                              "render": function (data, type, row) {

                                  return formatarCampo(data, 1);
                              },
                              "targets": 7
                          }
                      ],
                      "footerCallback": function (row, data, start, end, display) {
                          var api = this.api(), data;

                          // Remove the formatting to get integer data for summation
                          var parseFloat = function (i) {
                              return typeof i === 'string' ?
                                  i.replace(/[$,]/g, '') * 1 :
                                  typeof i === 'number' ?
                                      i : 0;
                          };

                          // Total over all pages
                          total = api
                              .column(7)
                              .data()
                              .reduce(function (a, b) {
                                  return parseFloat(a) + parseFloat(b);
                              }, 0);

                          // // Total over this page
                          pageTotal = api
                              .column(7, {page: 'current'})
                              .data()
                              .reduce(function (a, b) {
                                  return parseFloat(a) + parseFloat(b);
                              }, 0);

                          // Update footer
                          $(api.column(7).footer()).html('<strong>Horas de Serviço<br>Departamento<br>' + formatarCampo(total, 2) + ' </strong>');
                          $(api.column(6).footer()).html('<strong>Horas de Serviço<br>Colaborador<br>' + formatarCampo(pageTotal, 2) + ' </strong>');
                      },
                  });
                  $('#categoria').on('change', function () {
                      tabelaNcms.search(this.value).draw();
                  });
              }
          };
          var init_data_Table2 = function () {
              var tabelaNcms = null;
              if ($.fn.dataTable.isDataTable('#lang_opt2')) {
                  $('#lang_opt2').dataTable().fnDestroy();
                  init_data_Table2();
              } else {
                  tabelaNcms = $('#lang_opt2').DataTable({
                      destroy: false,
                      scrollCollapse: true,
                      ordering: true,
                      info: true,
                      searching: true,
                      paging: true,
                      dom: 'Bfrtip',
                      "order": [[4, "desc"]],
                      columnDefs: [
                          {
                              type: 'date-br',
                              targets: 4
                          }
                      ]
                  });
                  $('#categoria').on('change', function () {
                      tabelaNcms.search(this.value).draw();
                  });
              }
          };

          $(document).ready(function () {
              init_data_Table();
              init_data_Table2();
          });
      </script>
      </body>

      </html>
	<?php }
} ?>