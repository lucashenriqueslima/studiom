<?php
include "../includes/conexao.php";
session_start();
$id_pagina = 65;
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
}else {
	$sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
	$vetor_permissao = mysqli_fetch_array($sql_permissao);
	if ($vetor_permissao['listar'] != 2) {
		echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
	}
	$arvoreCategoria = array();
	$sql = mysqli_query($con, "select * from categorias_contas where status = '1' order by cat_pai ASC,numero ASC");
	while ($aux = mysqli_fetch_array($sql)) {
		$arvoreCategoria[$aux['id_catconta']] = array(
			"cat_pai" => $aux['cat_pai'],
			"titulo" =>
				$aux['titulo']
		);
	}
	$colaboradores = array();
	$sql = mysqli_query($con, "select ft.*,cc.numeracao from ficha_tecnica ft left join categorias_contas cc on cc.id_catconta = ft.id_catconta where ft.status = '1' and categoria_fornecedor <> '0' order by ft.cat_pai ASC,ft.numero ASC");
	while ($aux = mysqli_fetch_array($sql)) {
		$colaboradores[$aux['id_ficha']] = array(
			"cat_pai" => $aux['cat_pai'],
			"titulo" => $aux['titulo'],
			"numeracao" => $aux['numeracao']
		);
	}
	$arvoreFicha = array();
	$sql = mysqli_query($con, "select ft.*,cc.numeracao from ficha_tecnica ft left join categorias_contas cc on cc.id_catconta = ft.id_catconta where ft.status = '1' and categoria_fornecedor = '0' order by ft.cat_pai ASC,ft.numero ASC");
	while ($aux = mysqli_fetch_array($sql)) {
		$arvoreFicha[$aux['id_ficha']] = array(
			"cat_pai" => $aux['cat_pai'],
			"titulo" => $aux['titulo'],
			"numeracao" => $aux['numeracao']
		);
	}
	function verifyParent($array, $currentParent, $qtd = 0)
	{
		$i = 0;
		foreach ($array as $category) {
			if ($currentParent == $category['cat_pai']) {
				if($qtd <= $i){
					return true;
				}
				$i++;
			}
		}
		return false;
	}
    foreach ($colaboradores as $key => $colaborador) {
        if (!(verifyParent($arvoreFicha,$colaborador['cat_pai'],1))) {
            $arvoreFicha[max(array_keys($arvoreFicha)) + 1] = array(
                "cat_pai" => $colaborador['cat_pai'],
                "titulo" => $colaborador['titulo'],
                "numeracao" => $colaborador['numeracao']
            );
            unset($colaboradores[$key]);
        }
    }
	foreach ($arvoreFicha as $key => $arvore) {
		foreach ($colaboradores as $colaborador) {
			if ($colaborador['cat_pai'] == $arvore['cat_pai']) {
				$arvoreFicha[max(array_keys($arvoreFicha)) + 1] = array(
					"cat_pai" => $key,
					"titulo" => $colaborador['titulo'],
					"numeracao" => $colaborador['numeracao']
				);
			}
		}
	}
	
	function createTree($array, $currentParent, $currLevel = 0, $prevLevel = -1)
	{
		foreach ($array as $categoryId => $category) {
			if ($currentParent == $category['cat_pai']) {
				if ($currLevel > $prevLevel && $currentParent != 0) {
					echo " <ol class='nested'> ";
				}
				if ($currLevel > $prevLevel && $currentParent == 0) {
					echo " <ol class=''> ";
				}
				if ($currLevel == $prevLevel) {
					echo " </li> ";
				}
				if (verifyParent($array, $categoryId)) {
					echo '<li><span class="has-arrow waves-effect waves-dark click"><i class="fas fa-angle-right fa-angle-down fa-lg"></i> '.$category['titulo'].'</span>';
				}else {
					echo '<li>'.$category['titulo'];
				}
				if ($currLevel > $prevLevel) {
					$prevLevel = $currLevel;
				} // 4
				$currLevel++; // 5
				createTree($array, $categoryId, $currLevel, $prevLevel); // 6
				$currLevel--; // 7
			}
		}
		if ($currLevel == $prevLevel) {
			echo " </li>  </ol> ";
		} // 8
	}
	
	function createTreeFicha($array, $currentParent, $currLevel = 0, $prevLevel = -1)
	{
		foreach ($array as $categoryId => $category) {
			if ($currentParent == $category['cat_pai']) {
				if ($currLevel > $prevLevel && $currentParent != 0) {
					echo " <ol class='nested'> ";
				}
				if ($currLevel > $prevLevel && $currentParent == 0) {
					echo " <ol class=''> ";
				}
				if ($currLevel == $prevLevel) {
					echo " </li> ";
				}
				if (verifyParent($array, $categoryId)) {
					echo '<li><span class="has-arrow waves-effect waves-dark click"><i class="fas fa-angle-right fa-angle-down fa-lg"></i> '.$category['titulo'].'</span>';
				}else {
					echo '<li>'.$category['numeracao'].' - '.$category['titulo'];
				}
				if ($currLevel > $prevLevel) {
					$prevLevel = $currLevel;
				} // 4
				$currLevel++; // 5
				createTreeFicha($array, $categoryId, $currLevel, $prevLevel); // 6
				$currLevel--; // 7
			}
		}
		if ($currLevel == $prevLevel) {
			echo " </li>  </ol> ";
		} // 8
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
          <style>
              #ch2-1 ol {
                  counter-reset: section;
                  /* Creates a new instance of the
																							section counter with each ol
																							element */
                  list-style-type: none;
              }

              #ch2-1 li::before {
                  counter-increment: section;
                  /* Increments only this instance
																									of the section counter */
                  content: counters(section, ".") " ";
                  /* Combines the values of all instances
																													 of the section counter, separated
																													 by a period */
              }

              #ch3-1 ol {
                  counter-reset: none;
                  /* Creates a new instance of the
																							section counter with each ol
																							element */
                  list-style-type: none;
              }

              #ch3-1 ol::before {
                  counter-increment: none;
                  /* Increments only this instance
																									of the section counter */
                  content: none ";
              }

              /* Hide the nested list */
              .nested {
                  display: none;
              }

              /* Show the nested list when the user clicks on the caret/arrow (with JavaScript) */
              .active {
                  display: block;
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
                          <div class="d-flex align-items-center">
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item">Financeiro</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Cadastros</li>
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
                                                              href="#ch1"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Fomentos</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                              href="#ch2"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Plano de Contas</span></a>
                                      </li>
<!--                                      <li class="nav-item"><a class="nav-link" data-toggle="tab"-->
<!--                                                              href="#ch3"-->
<!--                                                              role="tab"><span class="hidden-sm-up"><i-->
<!--                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Ficha Técnica</span></a>-->
<!--                                      </li>-->
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                              href="#ch4"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Centro de Custo</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                              href="#ch5"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Tipo de Pagamento</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                              href="#ch6"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Comissões</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                              href="#ch7"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Motivo de Exceção de Cobrança</span></a>
                                      </li>
                                  </ul>

                                  <div class="tab-content tabcontent-border">
                                      <!--FOMENTOS-->
                                      <!--//////////////////////////////-->
                                      <div class="tab-pane active" id="ch1" role="tabpanel">
                                          <br>
																				<?php if ($vetor_permissao['cadastro'] == 1) {
																				}else { ?><a href="cadastrar_fomento.php">
                                            <button type="button" class="btn waves-effect waves-light btn-warning">
                                                Novo
                                                Fomento
                                            </button>
                                        </a>
                                            <br>
																				<?php } ?>
                                          <br>
                                          <div class="table-responsive">
                                              <table id="lang_opt"
                                                     class="table table-striped table-bordered display"
                                                     style="width:100%">
                                                  <thead>
                                                  <tr align="center">
                                                      <th><strong><h5>Nome</h5></strong></th>
                                                      <th width="20%">
                                                          <strong><h5>Status</h5></strong>
                                                      </th>
                                                      <th width="15%"><strong><h5>Ação</h5></strong></th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
																									<?php
																									$sql_atual = mysqli_query($con, "select * from fomentos order by nome ASC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										?>
                                                      <tr>
                                                          <td><?php echo $vetor['nome']; ?></td>
                                                          <td align="center"><?php if ($vetor['status'] == 1) {
																															echo "<button type=\"button\"
                                                                          class=\"btn btn-success btn-block\"
                                                                          title=\"Ativo\" disabled>Ativo</button>";
																														}else {
																															echo "<button type=\"button\"
                                                                          class=\"btn btn-danger btn-block\"
                                                                          title=\"Inativo\" disabled>Inativo</button>";
																														} ?></td>
                                                          <td align="center"><a
                                                                      href="alterar_fomento.php?alterar=<?php echo $vetor['id_fomento']; ?>">
                                                                  <button type="button"
                                                                          class="btn btn-success mesmo-tamanho"
                                                                          title="Ver ou Alterar Cadastro"><i
                                                                              class="mdi mdi-tooltip-edit"></i>
                                                                  </button>
                                                              </a> <?php if ($vetor_permissao['exclusao'] != 1 && $vetor['status'] == 1) { ?>
                                                              <a class="fancybox fancybox.ajax"
                                                                 href="recebe_fomento.php?remover=<?php echo $vetor['id_fomento']; ?>">
                                                                      <button type="button"
                                                                              class="btn btn-danger mesmo-tamanho"
                                                                              title="Desativar Cadastro"><i
                                                                                  class="mdi mdi-window-close"></i>
                                                                      </button>
                                                                  </a><?php } ?></td>
                                                      </tr>
																									<?php } ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>

                                      <!--Plano de Contas-->
                                      <!--//////////////////////////////-->
                                      <div class="tab-pane" id="ch2" role="tabpanel">
                                          <br>
																				<?php if ($vetor_permissao['cadastro'] == 1) {
																				}else { ?>
                                            <a href="cadastrar_contascategoria.php">
                                                <button type="button"
                                                        class="btn waves-effect waves-light btn-warning">
                                                    Nova
                                                    Categoria
                                                </button>
                                            </a>
                                            <br>
																				<?php } ?>
                                          <br>
                                          <ul class="nav nav-tabs" role="tablist">
                                              <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                      href="#ch2-1"
                                                                      role="tab"><span class="hidden-sm-up"><i
                                                                  class="ti-email"></i></span> <span
                                                              class="hidden-xs-down">Estrutura</span></a>
                                              </li>
                                              <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                      href="#ch2-2"
                                                                      role="tab"><span class="hidden-sm-up"><i
                                                                  class="ti-email"></i></span> <span
                                                              class="hidden-xs-down">Categorias</span></a>
                                              </li>
                                          </ul>
                                          <div class="tab-content tabcontent-border">
                                              <div class="tab-pane active" id="ch2-1" role="tabpanel">
                                                  <br>
																								<?php createTree($arvoreCategoria, 0); ?>
                                              </div>

                                              <div class="tab-pane" id="ch2-2" role="tabpanel">
                                                  <br>
                                                  <div class="table-responsive">
                                                      <table id="lang_opt2"
                                                             class="table table-striped table-bordered display"
                                                             style="width:100%">
                                                          <thead>
                                                          <tr align="center">
                                                              <th><strong><h5>Categoria</h5></strong></th>
                                                              <th width="20%">
                                                                  <strong><h5>Status</h5></strong>
                                                              </th>
                                                              <th width="15%"><strong><h5>Ação</h5></strong></th>
                                                          </tr>
                                                          </thead>
                                                          <tbody>
																													<?php
																													$sql_atual = mysqli_query($con, "select c.id_catconta,c.titulo as ctitulo,c.status from categorias_contas c ");
																													while ($vetor = mysqli_fetch_array($sql_atual)) {
																														?>
                                                              <tr>
                                                                  <td><?php echo $vetor['ctitulo']; ?></td>
                                                                  <td align="center"><?php if ((int)$vetor['status'] == 1) {
																																			echo "<button type=\"button\"
                                                                          class=\"btn btn-success btn-block\"
                                                                          title=\"Ativo\" disabled>Ativo</button>";
																																		}else {
																																			echo "<button type=\"button\"
                                                                          class=\"btn btn-danger btn-block\"
                                                                          title=\"Inativo\" disabled>Inativo</button>";
																																		} ?></td>
                                                                  <td align="center">
                                                                      <a href="alterar_catconta.php?alterar=<?php echo $vetor['id_catconta']; ?>">
                                                                          <button type="button"
                                                                                  class="btn btn-success mesmo-tamanho"
                                                                                  title="Ver ou Alterar Cadastro"><i
                                                                                      class="mdi mdi-tooltip-edit"></i>
                                                                          </button>
                                                                      </a>
                                                                      <!--                                                                      --><?php //if ($vetor_permissao['exclusao'] != 1 && $vetor['status'] == 1) { ?>
                                                                      <!--                                                                          <a class="fancybox fancybox.ajax"-->
                                                                      <!--                                                                             href="recebe_catconta.php?remover=-->
																																		<?php //echo $vetor['id_catconta']; ?><!--">-->
                                                                      <!--                                                                              <button type="button"-->
                                                                      <!--                                                                                      class="btn btn-danger mesmo-tamanho"-->
                                                                      <!--                                                                                      title="Desativar Cadastro"><i-->
                                                                      <!--                                                                                          class="mdi mdi-window-close"></i>-->
                                                                      <!--                                                                              </button>-->
                                                                      <!--                                                                          </a>-->
                                                                      <!--                                                                      --><?php //} ?>
                                                                  </td>
                                                              </tr>
																													<?php } ?>
                                                          </tbody>
                                                      </table>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                      <!--Ficha Técnica-->
                                      <!--//////////////////////////////-->
                                      <div class="tab-pane" id="ch3" role="tabpanel">
                                          <br>
                                          <div class="row">
																						<?php if ($vetor_permissao['cadastro'] == 1) {
																						}else { ?>
                                                <a href="cadastrar_produtoficha.php">
                                                    <button type="button"
                                                            class="btn waves-effect waves-light btn-warning">
                                                        Nova Categoria
                                                    </button>
                                                </a>
                                                <br>
																						<?php } ?>
																						<?php if ($vetor_permissao['cadastro'] == 1) {
																						}else { ?>
                                                <a href="cadastrar_fichatecnica.php" style="margin-left: 5px">
                                                    <button type="button"
                                                            class="btn waves-effect waves-light btn-info">
                                                        Novo
                                                        Item
                                                    </button>
                                                </a>
                                                <br>
																						<?php } ?>
                                          </div>
                                          <br>
                                          <ul class="nav nav-tabs" role="tablist">
                                              <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                      href="#ch3-1"
                                                                      role="tab"><span class="hidden-sm-up"><i
                                                                  class="ti-email"></i></span> <span
                                                              class="hidden-xs-down">Estrutura</span></a>
                                              </li>
                                              <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                      href="#ch3-2"
                                                                      role="tab"><span class="hidden-sm-up"><i
                                                                  class="ti-email"></i></span> <span
                                                              class="hidden-xs-down">Categorias</span></a>
                                              </li>
                                          </ul>
                                          <div class="tab-content tabcontent-border">
                                              <div class="tab-pane active" id="ch3-1" role="tabpanel">
                                                  <br>
																								<?php createTreeFicha($arvoreFicha, 0); ?>
                                              </div>

                                              <div class="tab-pane" id="ch3-2" role="tabpanel">
                                                  <br>
                                                  <div class="table-responsive">
                                                      <table id="lang_opt2"
                                                             class="table table-striped table-bordered display"
                                                             style="width:100%">
                                                          <thead>
                                                          <tr align="center">
                                                              <th><strong><h5>Categoria</h5></strong></th>
                                                              <th width="20%">
                                                                  <strong><h5>Status</h5></strong>
                                                              </th>
                                                              <th width="15%"><strong><h5>Ação</h5></strong></th>
                                                          </tr>
                                                          </thead>
                                                          <tbody>
																													<?php
																													$sql_atual = mysqli_query($con, "select ft.*,c.numeracao from ficha_tecnica ft left join categorias_contas c on c.id_catconta = ft.id_catconta");
																													while ($vetor = mysqli_fetch_array($sql_atual)) {
																														?>
                                                              <tr>
                                                                  <td><?php echo ($vetor['id_catconta'] != 0 && $vetor['id_catconta'] != null ? $vetor['numeracao'].' - ' : '').$vetor['titulo']; ?></td>
                                                                  <td align="center"><?php if ((int)$vetor['status'] == 1) {
																																			echo "<button type=\"button\"
                                                                          class=\"btn btn-success btn-block\"
                                                                          title=\"Ativo\" disabled>Ativo</button>";
																																		}else {
																																			echo "<button type=\"button\"
                                                                          class=\"btn btn-danger btn-block\"
                                                                          title=\"Inativo\" disabled>Inativo</button>";
																																		} ?></td>
                                                                  <td align="center">
                                                                      <a href="alterar_fichatecnica.php?alterar=<?php echo $vetor['id_ficha']; ?>">
                                                                          <button type="button"
                                                                                  class="btn btn-success mesmo-tamanho"
                                                                                  title="Ver ou Alterar Cadastro"><i
                                                                                      class="mdi mdi-tooltip-edit"></i>
                                                                          </button>
                                                                      </a>
																																		<?php if ($vetor_permissao['exclusao'] != 1 && $vetor['status'] == 1) { ?>
                                                                        <a class="fancybox fancybox.ajax"
                                                                           href="recebe_fichatecnica.php?remover=<?php echo $vetor['id_ficha']; ?>">
                                                                            <button type="button"
                                                                                    class="btn btn-danger mesmo-tamanho"
                                                                                    title="Desativar Cadastro"><i
                                                                                        class="mdi mdi-window-close"></i>
                                                                            </button>
                                                                        </a>
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

                                      <!--Centro de Custo-->
                                      <!--//////////////////////////////-->
                                      <div class="tab-pane" id="ch4" role="tabpanel">
                                          <br>
																				<?php if ($vetor_permissao['cadastro'] == 1) {
																				}else { ?>
                                            <a href="cadastrar_centrocusto.php">
                                                <button type="button"
                                                        class="btn waves-effect waves-light btn-warning">
                                                    Novo Centro de Custo
                                                </button>
                                            </a>
                                            <br>
																				<?php } ?>
                                          <br>
                                          <div class="tab-pane" id="ch3-2" role="tabpanel">
                                              <br>
                                              <div class="table-responsive">
                                                  <table id="lang_opt2"
                                                         class="table table-striped table-bordered display"
                                                         style="width:100%">
                                                      <thead>
                                                      <tr align="center">
                                                          <th><strong><h5>Centro de Custo</h5></strong></th>
                                                          <th><strong><h5>Sigla</h5></strong></th>
                                                          <th width="20%">
                                                              <strong><h5>Status</h5></strong>
                                                          </th>
                                                          <th width="15%"><strong><h5>Ação</h5></strong></th>
                                                      </tr>
                                                      </thead>
                                                      <tbody>
																											<?php
																											$sql_atual = mysqli_query($con, "select * from centro_custo");
																											while ($vetor = mysqli_fetch_array($sql_atual)) {
																												?>
                                                          <tr>
                                                              <td><?php echo $vetor['nome']; ?></td>
                                                              <td align="center"><?php echo $vetor['sigla']; ?></td>
                                                              <td align="center"><?php if ((int)$vetor['status'] == 1) {
																																	echo "<button type=\"button\"
                                                                          class=\"btn btn-success btn-block\"
                                                                          title=\"Ativo\" disabled>Ativo</button>";
																																}else {
																																	echo "<button type=\"button\"
                                                                          class=\"btn btn-danger btn-block\"
                                                                          title=\"Inativo\" disabled>Inativo</button>";
																																} ?></td>
                                                              <td align="center">
                                                                  <a href="alterar_centrocusto.php?alterar=<?php echo $vetor['id_centro']; ?>">
                                                                      <button type="button"
                                                                              class="btn btn-success mesmo-tamanho"
                                                                              title="Ver ou Alterar Cadastro"><i
                                                                                  class="mdi mdi-tooltip-edit"></i>
                                                                      </button>
                                                                  </a>
																																<?php if ($vetor_permissao['exclusao'] != 1 && $vetor['status'] == 1) { ?>
                                                                    <a class="fancybox fancybox.ajax"
                                                                       href="recebe_centrocusto.php?remover=<?php echo $vetor['id_centro']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger mesmo-tamanho"
                                                                                title="Desativar Cadastro"><i
                                                                                    class="mdi mdi-window-close"></i>
                                                                        </button>
                                                                    </a>
																																<?php } ?>
                                                              </td>
                                                          </tr>
																											<?php } ?>
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>

                                      <!--Tipos de Pagamento-->
                                      <!--//////////////////////////////-->
                                      <div class="tab-pane" id="ch5" role="tabpanel">
                                          <br>
																				<?php if ($vetor_permissao['cadastro'] == 1) {
																				}else { ?>
                                            <a href="cadastrar_tipopagamento.php">
                                                <button type="button"
                                                        class="btn waves-effect waves-light btn-warning">
                                                    Novo Tipo de Pagamento
                                                </button>
                                            </a>
                                            <br>
																				<?php } ?>
                                          <br>
                                          <div class="tab-pane" id="ch5-1" role="tabpanel">
                                              <br>
                                              <div class="table-responsive">
                                                  <table id="lang_opt2"
                                                         class="table table-striped table-bordered display"
                                                         style="width:100%">
                                                      <thead>
                                                      <tr align="center">
                                                          <th><strong><h5>Tipo</h5></strong></th>
                                                          <th><strong><h5>Titulo</h5></strong></th>
                                                          <th><strong><h5>Conta</h5></strong></th>
                                                          <th><strong><h5>Porcentagem</h5></strong></th>
                                                          <th><strong><h5>Valor Fixo</h5></strong></th>
                                                          <th width="20%">
                                                              <strong><h5>Status</h5></strong>
                                                          </th>
                                                          <th width="15%"><strong><h5>Ação</h5></strong></th>
                                                      </tr>
                                                      </thead>
                                                      <tbody>
																											<?php
																											$sql_atual = mysqli_query($con, "select tp.*,c.nome as cnome from tipos_pagamento tp left join contas c on c.id_conta = tp.id_conta");
																											while ($vetor = mysqli_fetch_array($sql_atual)) {
																												?>
                                                          <tr>
                                                              <td><?php echo ucfirst($vetor['tipo']); ?></td>
                                                              <td align="center"><?php echo $vetor['nome']; ?></td>
                                                              <td align="center"><?php echo $vetor['cnome']; ?></td>
                                                              <td align="center"><?php echo $vetor['porcentagem'] . '%'; ?></td>
                                                              <td align="center"><?php echo 'R$' . $vetor['valor']; ?></td>
                                                              <td align="center"><?php if ((int)$vetor['status'] == 1) {
																																	echo "<button type=\"button\"
                                                                          class=\"btn btn-success btn-block\"
                                                                          title=\"Ativo\" disabled>Ativo</button>";
																																}else {
																																	echo "<button type=\"button\"
                                                                          class=\"btn btn-danger btn-block\"
                                                                          title=\"Inativo\" disabled>Inativo</button>";
																																} ?></td>
                                                              <td align="center">
                                                                  <a href="alterar_tipopagamento.php?alterar=<?php echo $vetor['id_tipo_pagamento']; ?>">
                                                                      <button type="button"
                                                                              class="btn btn-success mesmo-tamanho"
                                                                              title="Ver ou Alterar Cadastro"><i
                                                                                  class="mdi mdi-tooltip-edit"></i>
                                                                      </button>
                                                                  </a>
																																<?php if ($vetor_permissao['exclusao'] != 1 && $vetor['status'] == 1) { ?>
                                                                    <a class="fancybox fancybox.ajax"
                                                                       href="recebe_tipopagamento.php?remover=<?php echo $vetor['id_tipo_pagamento']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger mesmo-tamanho"
                                                                                title="Desativar Cadastro"><i
                                                                                    class="mdi mdi-window-close"></i>
                                                                        </button>
                                                                    </a>
																																<?php } ?>
                                                              </td>
                                                          </tr>
																											<?php } ?>
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>

                                      <!--Comissões-->
                                      <!--//////////////////////////////-->
                                      <div class="tab-pane" id="ch6" role="tabpanel">
                                          <br>
																				<?php if ($vetor_permissao['cadastro'] == 1) {
																				}else { ?>
                                            <a href="cadastrar_comissao.php">
                                                <button type="button"
                                                        class="btn waves-effect waves-light btn-warning">
                                                    Nova Comissão
                                                </button>
                                            </a>
                                            <br>
																				<?php } ?>
                                          <br>
                                          <div class="tab-pane" id="ch6-1" role="tabpanel">
                                              <br>
                                              <div class="table-responsive">
                                                  <table id="lang_opt2"
                                                         class="table table-striped table-bordered display"
                                                         style="width:100%">
                                                      <thead>
                                                      <tr align="center">
                                                          <th><strong><h5>Conta</h5></strong></th>
                                                          <th><strong><h5>Base de Cálculo</h5></strong></th>
                                                          <th width="20%">
                                                              <strong><h5>Status</h5></strong>
                                                          </th>
                                                          <th width="15%"><strong><h5>Ação</h5></strong></th>
                                                      </tr>
                                                      </thead>
                                                      <tbody>
																											<?php
																											$sql_atual = mysqli_query($con, "select cc.*,c.nome as cnome from comissoes cc left join contas c on c.id_conta=cc.id_conta");
																											while ($vetor = mysqli_fetch_array($sql_atual)) {
																												?>
                                                          <tr>
                                                              <td><?php echo $vetor['cnome']; ?></td>
                                                              <td align="center"><?php echo ucfirst($vetor['base_calculo']); ?></td>
                                                              <td align="center"><?php if ((int)$vetor['status'] == 1) {
																																	echo "<button type=\"button\"
                                                                          class=\"btn btn-success btn-block\"
                                                                          title=\"Ativo\" disabled>Ativo</button>";
																																}else {
																																	echo "<button type=\"button\"
                                                                          class=\"btn btn-danger btn-block\"
                                                                          title=\"Inativo\" disabled>Inativo</button>";
																																} ?></td>
                                                              <td align="center">
                                                                  <a href="alterar_centrocusto.php?alterar=<?php echo $vetor['id_catconta']; ?>">
                                                                      <button type="button"
                                                                              class="btn btn-success mesmo-tamanho"
                                                                              title="Ver ou Alterar Cadastro"><i
                                                                                  class="mdi mdi-tooltip-edit"></i>
                                                                      </button>
                                                                  </a>
																																<?php if ($vetor_permissao['exclusao'] != 1 && $vetor['status'] == 1) { ?>
                                                                    <a class="fancybox fancybox.ajax"
                                                                       href="recebe_centrocusto.php?remover=<?php echo $vetor['id_catconta']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger mesmo-tamanho"
                                                                                title="Desativar Cadastro"><i
                                                                                    class="mdi mdi-window-close"></i>
                                                                        </button>
                                                                    </a>
																																<?php } ?>
                                                              </td>
                                                          </tr>
																											<?php } ?>
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="tab-pane" id="ch7" role="tabpanel">
                                          <br>
											
                                          <a href="cadastrar_motivo_excecao_cobranca.php">
                                            <button type="button" class="btn waves-effect waves-light btn-warning">
                                                Novo Motivo
                                            </button>
                                        </a>
                                            <br>
																				
                                          <br>
                                          <div class="table-responsive">
                                              <table id="lang_opt"
                                                     class="table table-striped table-bordered display"
                                                     style="width:100%">
                                                  <thead>
                                                  <tr align="center">
                                                      <th><strong><h5>Motivo</h5></strong></th>
                                                      <th><strong><h5>Ação</h5></strong></th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
																									<?php
																									$sql_atual = mysqli_query($con, "select * from motivos_excecao_cobranca order by id_motivo_excecao_cobranca ASC");
																									while ($vetor = mysqli_fetch_array($sql_atual)) {
																										?>
                                                      <tr>
                                                          <td><?php echo $vetor['motivo']; ?></td>
                                                          
                                                          <td align="center"><a
                                                                      href="recebe_motivo_excecao_cobranca.php?remover=<?php echo $vetor['id_motivo_excecao_cobranca']; ?>">
                                                                  <button type="button"
                                                                          class="btn btn-danger mesmo-tamanho"
                                                                          title="Deletar Motivo"><i
                                                                              class="mdi mdi-window-close"></i>
                                                                  </button>
                                                              </a> 
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
          $(document).ready(function () {
              var toggler = document.getElementsByClassName("click");
              var i;

              for (i = 0; i < toggler.length; i++) {
                  toggler[i].addEventListener("click", function () {
                      this.parentElement.querySelector(".nested").classList.toggle("active");
                      this.firstChild.classList.toggle("fa-angle-right");
                  });
              }

              var activeTab = location.hash;
              if (activeTab != "") {
                  var splitted = activeTab.split('#');
                  for (var i = 1; i < splitted.length; i++) {
                      $('.nav-link[href="#' + splitted[i] + '"]').click();
                  }
              }
          });
      </script>
      </body>

      </html>
	<?php }
} ?>