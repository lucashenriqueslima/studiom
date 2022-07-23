<?php
ini_set('memory_limit', '-1');
$sql_permissoes_cadastros = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '1' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_marketing = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '2' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_comercial = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '3' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_crm = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '4' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_administrativo = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '5' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_gestaodecontratos = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '6' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_calendario = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '7' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_fotografia = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '8' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_criacao = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '9' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_financeiro = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '10' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_vendas = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '11' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_album = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '12' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_juridico = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '13' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_rh = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '14' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_convite = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '16' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_pcp = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '17' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_affotografia = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '18' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_impressao = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '19' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_permissoes_producao = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '20' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");
$sql_departamentos_comercial = mysqli_query($con, "select * from departamentos where id_departamento = '1'");
$vetor_departamento_comercial = mysqli_fetch_array($sql_departamentos_comercial);
$sql_departamentos_fotografia = mysqli_query($con, "select * from departamentos where id_departamento = '2'");
$vetor_departamento_fotografia = mysqli_fetch_array($sql_departamentos_fotografia);
$sql_departamentos_gestao = mysqli_query($con, "    select * from departamentos where id_departamento = '3'");
$vetor_departamento_gestao = mysqli_fetch_array($sql_departamentos_gestao);
$sql_departamentos_financeiro = mysqli_query($con, "select * from departamentos where id_departamento = '4'");
$vetor_departamento_financeiro = mysqli_fetch_array($sql_departamentos_financeiro);
$sql_departamentos_vendas = mysqli_query($con, "select * from departamentos where id_departamento = '5'");
$vetor_departamento_vendas = mysqli_fetch_array($sql_departamentos_vendas);
$sql_departamentos_marketing = mysqli_query($con, "select * from departamentos where id_departamento = '7'");
$vetor_departamento_marketing = mysqli_fetch_array($sql_departamentos_marketing);
$sql_departamentos_administrativo = mysqli_query($con, "select * from departamentos where id_departamento = '8'");
$vetor_departamento_administrativo = mysqli_fetch_array($sql_departamentos_administrativo);
$sql_departamentos_criacao = mysqli_query($con, "select * from departamentos where id_departamento = '9'");
$vetor_departamento_criacao = mysqli_fetch_array($sql_departamentos_criacao);
$sql_departamentos_album = mysqli_query($con, "select * from departamentos where id_departamento = '10'");
$vetor_departamento_album = mysqli_fetch_array($sql_departamentos_album);
$sql_departamentos_juridico = mysqli_query($con, "select * from departamentos where id_departamento = '11'");
$vetor_departamento_juridico = mysqli_fetch_array($sql_departamentos_juridico);
$sql_departamentos_rh = mysqli_query($con, "select * from departamentos where id_departamento = '12'");
$vetor_departamento_rh = mysqli_fetch_array($sql_departamentos_rh);
$sql_departamentos_pcp = mysqli_query($con, "select * from departamentos where id_departamento = '14'");
$vetor_departamento_pcp = mysqli_fetch_array($sql_departamentos_pcp);
$sql_departamentos_producao = mysqli_query($con, "select * from departamentos where id_departamento = '16'");
$vetor_departamento_producao = mysqli_fetch_array($sql_departamentos_producao);
$sql_departamentos_impressao = mysqli_query($con, "select * from departamentos where id_departamento = '15'");
$vetor_departamento_impressao = mysqli_fetch_array($sql_departamentos_impressao);
$sql_permissoes_convite = mysqli_query($con, "select * from departamentos where id_departamento = '13'");
$vetor_departamento_convite = mysqli_fetch_array($sql_permissoes_convite);
$sql_tarefas = mysqli_query($con, "select * from responsaveis_calendario where id_usuario = '$_SESSION[id]' and lido = '1'");
?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="arquivos/<?php echo $_SESSION['imagem']; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $vetor_usuario['nome']; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU NAVEGAÇÃO</li>
<!--            <li>-->
<!--                <a href="tarefas.php">-->
<!--                    <i class="fa fa-calendar"></i> <span>Minhas Tarefas</span>-->
<!--                    <span class="pull-right-container">-->
<!--              --><?php //if (mysqli_num_rows($sql_tarefas) == 0) {
//              }else { ?><!--<small-->
<!--                      class="label pull-right bg-red">--><?php //echo mysqli_num_rows($sql_tarefas); ?><!--</small>--><?php //} ?>
<!--            </span>-->
<!--                </a>-->
<!--            </li>-->
					<?php if (mysqli_num_rows($sql_permissoes_cadastros) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-pie-chart cadastrosgerais"></i>
                      <span>Cadastros Gerais</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_1 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '1' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_1) > 0) {
											?>
                        <li><a href="cadastros_fornecedores.php"><i class="fa fa-circle-o"></i> Fornecedores</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_2 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '2' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_2) > 0) {
											?>
                        <li><a href="cadastros_instituicao.php"><i class="fa fa-circle-o"></i> Instituição</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_3 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '3' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_3) > 0) {
											?>
                        <li><a href="cadastros_cursos.php"><i class="fa fa-circle-o"></i> Cursos</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_102 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '102' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_102) > 0) {
											?>
                        <li><a href="cadastros_turmasmkt.php"><i class="fa fa-circle-o"></i> Turmas</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_5 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '5' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_5) > 0) {
											?>
                        <li><a href="cadastros_formandos.php"><i class="fa fa-circle-o"></i> Formandos</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_6 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '6' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_6) > 0) {
											?>
                        <li><a href="cadastros_categorias.php"><i class="fa fa-circle-o"></i> Categorias CRM</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_7 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '7' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_7) > 0) {
											?>
                        <li><a href="cadastros_status.php"><i class="fa fa-circle-o"></i> Status Categorias CRM</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_8 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '8' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_8) > 0) {
											?>
                        <li><a href="cadastros_departamentos.php"><i class="fa fa-circle-o"></i> Departamentos</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_9 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '9' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_9) > 0) {
											?>
                        <li><a href="cadastros_locaiseventos.php"><i class="fa fa-circle-o"></i> Locais de Eventos</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_10 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '10' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_10) > 0) {
											?>
                        <li><a href="cadastros_categoriaseventos.php"><i class="fa fa-circle-o"></i> Categoria de
                                Eventos</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_55 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '55' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_55) > 0) {
											?>
                        <li><a href="cadastros_categoriasfornecedores.php"><i class="fa fa-circle-o"></i> Categoria de
                                Fornecedores</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_11 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '11' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_11) > 0) {
											?>
                        <li><a href="cadastros_tiposinteracao.php"><i class="fa fa-circle-o"></i> Meio Interação</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_15 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '15' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_15) > 0) {
											?>
                        <li><a href="cadastros_assuntos.php"><i class="fa fa-circle-o"></i> Assuntos Interação</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_43 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '43' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_43) > 0) {
											?>
                        <li><a href="cadastros_cadbancos.php"><i class="fa fa-circle-o"></i> Bancos</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_98 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '98' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_43) > 0) {
											?>
                        <li><a href="cadastros_tiposarquivos.php"><i class="fa fa-circle-o"></i> Tipos de Arquivos</a>
                        </li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_marketing) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-rocket marketing"></i>
                      <span>Marketing</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right "></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_104 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '104' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_104) > 0) {
											?>
                        <li><a href="marketing_prospeccao.php"><i class="fa fa-circle-o"></i> Prospecções</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_16 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '16' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_16) > 0) {
											?>
                        <li><a href="tarefas.php?departamento=7"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_comercial) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-handshake-o comercial"></i>
                      <span>Comercial</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_17 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '17' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_17) > 0) {
											?>
                        <li><a href="tarefas.php?departamento=1"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
                      <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> Fotografia
                              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                          </a>
                          <ul class="treeview-menu">
                              <li><a href="listarorcfotografia.php"><i class="fa fa-circle-o"></i> Orçamento</a></li>
                              <li><a href="listarpropfotografia.php"><i class="fa fa-circle-o"></i> Proposta</a></li>
                              <li><a href="listarcontratofotografia.php"><i class="fa fa-circle-o"></i> Contrato</a>
                              </li>
                              <li class="treeview">
                                  <a href="#"><i class="fa fa-circle-o"></i> Cadastros Gerais
                                      <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                  </a>
                                  <ul class="treeview-menu">
																		<?php
																		$sql_permissao_item_116 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '116' and id_usuario = '$_SESSION[id]' and listar = '2'");
																		if (mysqli_num_rows($sql_permissao_item_116) > 0) {
																			?>
                                        <li><a href="listartabelafotografia.php"><i class="fa fa-circle-o"></i> Tabela
                                                Fotografia</a></li>
																		<?php } ?>
                                  </ul>
                              </li>
                          </ul>
                      </li>
                      <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> Convite
                              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                          </a>
                          <ul class="treeview-menu">
                              <li><a href="comercial_orcamento_convite.php"><i class="fa fa-circle-o"></i> Orçamento</a>
                              </li>
                              <li class="treeview">
                                  <a href="#"><i class="fa fa-circle-o"></i> Cadastros Gerais
                                      <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                  </a>
                                  <ul class="treeview-menu">
																		<?php
																		$sql_permissao_item_107 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '107' and id_usuario = '$_SESSION[id]' and listar = '2'");
																		if (mysqli_num_rows($sql_permissao_item_107) > 0) {
																			?>
                                        <li><a href="comercial_itenstabelaconvite.php"><i class="fa fa-circle-o"></i>
                                                Itens Tabela</a></li>
																		<?php } ?>
																		<?php
																		$sql_permissao_item_109 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '109' and id_usuario = '$_SESSION[id]' and listar = '2'");
																		if (mysqli_num_rows($sql_permissao_item_109) > 0) {
																			?>
                                        <li><a href="comercial_dadosbasico.php"><i class="fa fa-circle-o"></i> Dados
                                                Básicos</a></li>
																		<?php } ?>
																		<?php
																		$sql_permissao_item_110 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '110' and id_usuario = '$_SESSION[id]' and listar = '2'");
																		if (mysqli_num_rows($sql_permissao_item_110) > 0) {
																			?>
                                        <li><a href="comercial_tabelaacabamentos.php"><i class="fa fa-circle-o"></i>
                                                Tabela Acabamentos</a></li>
																		<?php } ?>
																		<?php
																		$sql_permissao_item_106 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '106' and id_usuario = '$_SESSION[id]' and listar = '2'");
																		if (mysqli_num_rows($sql_permissao_item_106) > 0) {
																			?>
                                        <li><a href="comercial_tabelatribconvite.php"><i class="fa fa-circle-o"></i>
                                                Tributos</a></li>
																		<?php } ?>
                                  </ul>
                              </li>
                          </ul>
                      </li>
                      <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> CRM
                              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                          </a>
                          <ul class="treeview-menu">
														<?php
														$sql_permissao_item_18 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '18' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_18) > 0) {
															?>
                                <li><a href="comercial_oportunidades.php"><i class="fa fa-circle-o"></i>
                                        Leads</a></li>
														<?php } ?>
														<?php
														$sql_permissao_item_19 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '19' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_19) > 0) {
															?>
                                <li><a href="comercial_pipe.php"><i class="fa fa-circle-o"></i> PIPE</a></li>
														<?php } ?>
<!--														--><?php
//														$sql_permissao_item_20 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '20' and id_usuario = '$_SESSION[id]' and listar = '2'");
//														if (mysqli_num_rows($sql_permissao_item_20) > 0) {
//															?>
<!--                                <li><a href="comercial_funil.php"><i class="fa fa-circle-o"></i> Funil CRM</a></li>-->
<!--														--><?php //} ?>
<!--														--><?php
//														$sql_permissao_item_21 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '21' and id_usuario = '$_SESSION[id]' and listar = '2'");
//														if (mysqli_num_rows($sql_permissao_item_21) > 0) {
//															?>
<!--                                <li><a href="comercial_dashboard.php"><i class="fa fa-circle-o"></i> Dashboard CRM</a>-->
<!--                                </li>-->
<!--														--><?php //} ?>
														<?php
														$sql_permissao_item_22 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '22' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_22) > 0) {
															?>
                                <li><a href="comercial_campanhas.php"><i class="fa fa-circle-o"></i> Campanhas</a></li>
														<?php } ?>
														<?php
														$sql_permissao_item_23 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '23' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_23) > 0) {
															?>
                                <li><a href="COMENTAR AQUI"><i class="fa fa-circle-o"></i> Cases</a></li>
														<?php } ?>
                          </ul>
                      </li>
                  </ul>
              </li>
						<?php if (mysqli_num_rows($sql_permissoes_vendas) > 0) { ?>
                  <li class="treeview">
                      <a href="#">
                          <i class="fa fa-cart-plus vendas"></i>
                          <span>Vendas</span>
                          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                      </a>
                      <ul class="treeview-menu">

                          <li class="treeview">
                              <a href="#"><i class="fa fa-circle-o"></i> Fotografia
                                  <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                              </a>
                              <ul class="treeview-menu">

                                  <li class="treeview">
                                      <a href="#"><i class="fa fa-circle-o"></i> Pós
                                          <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                      </a>
                                      <ul class="treeview-menu">
																				
																				<?php
																				$sql_permissao_item_50 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '50' and id_usuario = '$_SESSION[id]' and listar = '2'");
																				if (mysqli_num_rows($sql_permissao_item_50) > 0) {
																					?>
                                            <li><a href="vendas_remessas.php"><i class="fa fa-circle-o"></i> Remessas</a>
                                            </li>
																				<?php } ?>
																				<?php
																				$sql_permissao_item_48 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '48' and id_usuario = '$_SESSION[id]' and listar = '2'");
																				if (mysqli_num_rows($sql_permissao_item_48) > 0) {
																					?>
                                            <li><a href="vendas_produtosformando.php"><i class="fa fa-circle-o"></i>
                                                    Produtos Formando</a></li>
																				<?php } ?>

                                      </ul>

                                  </li>

                                  <li class="treeview">
                                      <a href="#"><i class="fa fa-circle-o"></i> Pré
                                          <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                      </a>
                                      <ul class="treeview-menu">
																				
																				<?php
																				$sql_permissao_item_51 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '51' and id_usuario = '$_SESSION[id]' and listar = '2'");
																				if (mysqli_num_rows($sql_permissao_item_51) > 0) {
																					?>
                                            <li><a href="vendas_pacotes.php"><i class="fa fa-circle-o"></i> Produtos
                                                    Álbum</a></li>
																				<?php } ?>

                                      </ul>

                                  </li>
																
																<?php
																$sql_permissao_item_96 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '96' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_num_rows($sql_permissao_item_96) > 0) {
																	?>
                                    <li><a href="vendas_avulsas.php"><i class="fa fa-circle-o"></i> Avulsa</a></li>
																<?php } ?>
																
																<?php
																$sql_permissao_item_97 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '97' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_num_rows($sql_permissao_item_97) > 0) {
																	?>
                                    <li><a href="vendas_liberarfotos.php"><i class="fa fa-circle-o"></i> Liberar
                                            Fotos</a></li>
																<?php } ?>

                              </ul>

                          </li>

                          <li class="treeview">
                              <a href="#"><i class="fa fa-circle-o"></i> Convite
                                  <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                              </a>
                              <ul class="treeview-menu">
																
																<?php
																$sql_permissao_item_14 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '14' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_num_rows($sql_permissao_item_14) > 0) {
																	?>
                                    <li><a href="vendas_produtos.php"><i class="fa fa-circle-o"></i> Produtos</a></li>
																<?php } ?>

                              </ul>

                          </li>


                          <li class="treeview">
                              <a href="#"><i class="fa fa-circle-o"></i> Gestor de Vendas
                                  <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                              </a>
                              <ul class="treeview-menu">

                                  <li class="treeview">
                                      <a href="#"><i class="fa fa-circle-o"></i> Convite
                                          <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                      </a>
                                      <ul class="treeview-menu">
																				
																				<?php
																				$sql_permissao_item_31 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '31' and id_usuario = '$_SESSION[id]' and listar = '2'");
																				if (mysqli_num_rows($sql_permissao_item_31) > 0) {
																					?>
                                            <li><a href="vendas_gestaodeconvites.php"><i class="fa fa-circle-o"></i>
                                                    Gestão Parcial da Venda</a></li>
                                            <li><a href="vendas_gestaodeconvitestodos.php"><i class="fa fa-circle-o"></i>
                                                    Gestão Total da Venda</a></li>
																				<?php } ?>
																				<?php
																				$sql_permissao_item_31 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '31' and id_usuario = '$_SESSION[id]' and listar = '2'");
																				if (mysqli_num_rows($sql_permissao_item_31) > 0) {
																					?>
                                            <li><a href="vendas_aceitesgerar.php"><i class="fa fa-circle-o"></i> Gerar
                                                    Aceite de Convites</a></li>
                                            <li><a href="vendas_aceites.php"><i class="fa fa-circle-o"></i> Impressão de
                                                    Aceite</a></li>
																				<?php } ?>

                                      </ul>
                                  </li>

                                  <li class="treeview">
                                      <a href="#"><i class="fa fa-circle-o"></i> Fotografia
                                          <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                      </a>
                                      <ul class="treeview-menu">
																				
																				<?php
																				$sql_permissao_item_32 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '32' and id_usuario = '$_SESSION[id]' and listar = '2'");
																				if (mysqli_num_rows($sql_permissao_item_32) > 0) {
																					?>
                                            <li><a href="vendas_gestaodealbuns.php"><i class="fa fa-circle-o"></i> Gestão
                                                    de Álbuns e <br>Fotografias</a></li>
																				<?php } ?>
																				<?php
																				$sql_permissao_item_31 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '31' and id_usuario = '$_SESSION[id]' and listar = '2'");
																				if (mysqli_num_rows($sql_permissao_item_31) > 0) {
																					?>
                                            <li><a href="vendas_aceitesalbuns.php"><i class="fa fa-circle-o"></i>
                                                    Impressão de Aceite</a></li>
																				<?php } ?>

                                      </ul>
                                  </li>

                              </ul>
                          </li>
                          <li><a href="vendas_gestaodevendas.php"><i class="fa fa-circle-o"></i> Gestão de Vendas</a>
                          </li>
                          <li><a href="vendas_relvendas.php"><i class="fa fa-circle-o"></i> Relatório de Vendas</a></li>
												<?php
												$sql_permissao_item_52 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '52' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_num_rows($sql_permissao_item_52) > 0) {
													?>
                            <li><a href="vendas_exclusao.php"><i class="fa fa-circle-o"></i> Excluir Vendas</a>
                            </li>
												<?php } ?>
                          <li class="treeview">
                              <a href="#"><i class="fa fa-circle-o"></i> Cadastros Gerais
                                  <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                              </a>
                              <ul class="treeview-menu">
																<?php
																$sql_permissao_item_13 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '13' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_num_rows($sql_permissao_item_13) > 0) {
																	?>
                                    <li><a href="vendas_formas.php"><i class="fa fa-circle-o"></i> Formas de
                                            Pagamento</a></li>
																<?php } ?>
																<?php
																$sql_permissao_item_49 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '49' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_num_rows($sql_permissao_item_49) > 0) {
																	?>
                                    <li><a href="vendas_tiposprodutosop.php"><i class="fa fa-circle-o"></i> Produtos
                                            Fotografia</a></li>
																<?php } ?>
																<?php
																$sql_permissao_item_12 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '12' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_num_rows($sql_permissao_item_12) > 0) {
																	?>
                                    <li><a href="vendas_tiposprodutos.php"><i class="fa fa-circle-o"></i> Produtos
                                            Convite</a></li>
																<?php } ?>
                              </ul>
                          </li>
												<?php
												$sql_permissao_item_36 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '36' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_num_rows($sql_permissao_item_36) > 0) {
													?>
                            <li><a href="tarefas.php?departamento=5"><i class="fa fa-circle-o"></i> Tarefas</a></li>
												<?php } ?>
                      </ul>
                  </li>
						<?php } ?>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_administrativo) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-cog administrativo"></i>
                      <span>Administrativo</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_4 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '4' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_4) > 0) {
											?>
                        <li><a href="projetos_turmas.php"><i class="fa fa-circle-o"></i> Gestão de Contratos</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_111 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '111' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_111) > 0) {
											?>
                        <li><a href="projetos_hds.php"><i class="fa fa-circle-o"></i> HDS</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_26 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '26' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_26) > 0) {
											?>
                        <li><a href="tarefas.php?departamento=3"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_juridico) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-gavel juridico"></i>
                      <span>Jurídico</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_67 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '6' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_67) > 0) {
											?>
                        <li><a href="juridico_processos.php"><i class="fa fa-circle-o"></i> Processos</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_38 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '38' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_38) > 0) {
											?>
                        <li><a href="tarefas.php?departamento=11"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_rh) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-address-book rh"></i>
                      <span>RH</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_39 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '39' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_39) > 0) {
											?>
                        <li><a href="rh_colaboradores.php"><i class="fa fa-circle-o"></i> Colaboradores</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_40 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '40' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_40) > 0) {
											?>
                        <li><a href="tarefas.php?departamento=12"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_financeiro) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-money financeiro"></i>
                      <span>Financeiro</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										
										<?php
										$sql_permissao_item_101 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '101' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_101) > 0) {
											?>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-circle-o"></i> C. Receber
                                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="financeiro_contasareceber.php"><i class="fa fa-circle-o"></i> Em Aberto</a></li>
                                <li><a href="financeiro_contasareceberfim.php"><i class="fa fa-circle-o"></i> Finalizados</a>
                                </li>
                            </ul>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_47 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '47' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_47) > 0) {
											?>
                        <li><a href="financeiro_boletos.php"><i class="fa fa-circle-o"></i> Boletos</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_33 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '33' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_33) > 0) {
											?>
                        <li><a href="financeiro_duplicatas.php"><i class="fa fa-circle-o"></i> Duplicatas</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_34 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '34' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_34) > 0) {
											?>
                        <li><a href="listarcobranca.php"><i class="fa fa-circle-o"></i> Cobrança</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_122 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '122' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_122) > 0) {
											?>
                        <li><a href="#" class=" hvr-bounce-to-right"
                               onClick="window.open('retorno/upload.php', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, WIDTH=350, HEIGHT=100');"><i
                                        class="fa fa-circle-o"></i> Retorno Santander</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_35 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '35' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_35) > 0) {
											?>
                        <li><a href="tarefas.php?departamento=4"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
                      <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> Cadastros Gerais
                              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                          </a>
                          <ul class="treeview-menu">
														<?php
														$sql_permissao_item_44 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '44' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_44) > 0) {
															?>
                                <li><a href="MUDAR"><i class="fa fa-circle-o"></i> Contas Bancárias</a>
                                </li>
														<?php } ?>
														<?php
														$sql_permissao_item_45 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '45' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_45) > 0) {
															?>
                                <li><a href="MUDAR"><i class="fa fa-circle-o"></i> Factorings</a></li>
														<?php } ?>
														<?php
														$sql_permissao_item_46 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '46' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_46) > 0) {
															?>
                                <li><a href="financeiro_maquinascartao.php"><i class="fa fa-circle-o"></i> Maquinas de Cartão</a>
                                </li>
														<?php } ?>
                          </ul>
                      </li>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_calendario) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-calendar-minus-o"></i>
                      <span>Interatividades</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
                      <li><a href="interatividade_calendario.php"><i class="fa fa-circle-o"></i> Calendário</a></li>
                      <li><a href="cadastrar_tarefa.php"><i class="fa fa-circle-o"></i> Nova Tarefa</a></li>
                      <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> Fotografia
                              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                          </a>
                          <ul class="treeview-menu">
														<?php
														$sql_permissao_item_58 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '58' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_58) > 0) {
															?>
                                <li><a href="listareventosbkp.php"
                                       title="arquivosdefotosfotografia@studiomfotografia.com.br"><i
                                                class="fa fa-circle-o"></i> Arquivos de Fotos</a></li>
														<?php } ?>
														<?php
														$sql_permissao_item_59 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '59' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_59) > 0) {
															?>
                                <li><a href="listareventosproducao.php"
                                       title="arquivosdeproducaofotografia@studiomfotografia.com.br"><i
                                                class="fa fa-circle-o"></i> Arquivos de Produção</a></li>
														<?php } ?>
														<?php
														$sql_permissao_item_60 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '60' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_60) > 0) {
															?>
                                <li><a href="listarmostruario.php" title="mostruario@studiomfotografia.com.br"><i
                                                class="fa fa-circle-o"></i> Mostruário</a></li>
														<?php } ?>
                          </ul>
                      </li>
                      <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> Convite
                              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                          </a>
                          <ul class="treeview-menu">
														<?php
														$sql_permissao_item_61 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '61' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_61) > 0) {
															?>
                                <li><a href="listararquivosdeconvites.php"><i class="fa fa-circle-o"></i> Arquivo de
                                        Convites</a></li>
                                <li><a href="listararquivosdeproducao.php"
                                       title="arquivosdeproducaoconvite@studiomfotografia.com.br"><i
                                                class="fa fa-circle-o"></i> Arquivo de Produção</a></li>
                                <li><a href="listararquivosdeimpressao.php"
                                       title="arquivosdeimpressao@studiomfotografia.com.br"><i
                                                class="fa fa-circle-o"></i> Arquivos de Impressão</a></li>
														<?php } ?>
                          </ul>
                      </li>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_pcp) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-cogs pcp"></i>
                      <span>PCP</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_65 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '65' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_65) > 0) {
											?>
                        <li><a href="projetos_tipojob.php"><i class="fa fa-circle-o"></i> Tipos de Jobs</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_68 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '68' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_68) > 0) {
											?>
                        <li><a href="projetos_cadastrar_entrada_pcp.php"><i class="fa fa-circle-o"></i> Cadastro de Job</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_69 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '69' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_69) > 0) {
											?>
                        <li><a href="projetos_pcpgeral_lista.php"><i class="fa fa-circle-o"></i> PCP Geral</a></li>
                        <li><a href="projetos_pcpgeral.php"><i class="fa fa-circle-o"></i> Gestão de JOBS</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_67 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '67' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_67) > 0) {
											?>
                        <li><a href="projetos_processos.php"><i class="fa fa-circle-o"></i> Processos</a></li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_fotografia) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-camera-retro fotografia"></i>
                      <span>Fotografia</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_25 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '25' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_25) > 0) {
											?>
                        <li><a href="fotografia_eventos.php"><i class="fa fa-circle-o"></i> Gestão de Eventos</a></li>
										<?php } ?>
                      <li><a href="fotografia_identificacao.php"><i class="fa fa-circle-o"></i> Indentificação por Evento</a>
                      </li>
                      <li><a href="fotografia_identificacaocad.php"><i class="fa fa-circle-o"></i> Indentificação por
                              Cadastro</a></li>
										<?php
										$sql_permissao_item_115 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '115' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_115) > 0) {
											?>
                        <li><a href="fotografia_planejamento_eventos.php"><i class="fa fa-circle-o"></i> Escala de
                                Eventos</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_117 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '117' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_117) > 0) {
											?>
                        <li><a href="fotografia_faturamentodeeventos.php"><i class="fa fa-circle-o"></i> Faturamento de
                                Eventos</a></li>
										<?php } ?>
                      <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> Relatórios
                              <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                          </a>
                          <ul class="treeview-menu">
														<?php
														$sql_permissao_item_115 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '115' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_115) > 0) {
															?>
                                <li><a href="fotografia_relatorioparticipacaoevento.php" target="_blank"><i
                                                class="fa fa-circle-o"></i> Participação por Evento</a></li>
														<?php } ?>
                          </ul>
                      </li>
										<?php
										$sql_permissao_item_29 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '29' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_29) > 0) {
											?>
                        <li><a href="tarefas.php?departamento=2"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_criacao) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-paint-brush criacao"></i>
                      <span>Criação</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_113 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '113' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_113) > 0) {
											?>
                        <li><a href="criacao_solicitacaodeartes.php"><i class="fa fa-circle-o"></i> Solicitação de
                                Artes</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_76 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '76' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_76) > 0) {
											?>
                        <li><a href="criacao_tiposervicocriacao.php"><i class="fa fa-circle-o"></i> Tipo de Serviço</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_77 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '77' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_77) > 0) {
											?>
                        <li><a href="cadastrar_servicocriacao.php"><i class="fa fa-circle-o"></i> Cadastro de Serviço</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_70 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '70' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_70) > 0) {
											?>
                        <li><a href="criacao_pcp.php"><i class="fa fa-circle-o"></i> PCP</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_78 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '78' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_78) > 0) {
											?>
                        <li><a href="MUDAR"><i class="fa fa-circle-o"></i> Apontamentos</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_30 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '30' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_30) > 0) {
											?>
                        <li><a href="tarefas.php?departamento=9"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_affotografia) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-inbox album"></i>
                      <span>Arte Final - Fotografia</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
                      <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> Escolha de Fotos
                              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                          </a>
                          <ul class="treeview-menu">
														<?php
														$sql_permissao_item_123 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '123' and id_usuario = '$_SESSION[id]' and listar = '2'");
														if (mysqli_num_rows($sql_permissao_item_123) > 0) {
															?>
                                <li><a href="afFotografia_escolhadefotos.php"><i class="fa fa-circle-o"></i> Produtos
                                        Fotografia</a></li>
														<?php } ?>
                              <li class="treeview">
                                  <a href="#"><i class="fa fa-circle-o"></i> Produtos Convite
                                      <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                  </a>
                                  <ul class="treeview-menu">
																		<?php
																		$sql_permissao_item_124 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '124' and id_usuario = '$_SESSION[id]' and listar = '2'");
																		if (mysqli_num_rows($sql_permissao_item_124) > 0) {
																			?>
                                        <li><a href="afFotografia_personal.php"><i class="fa fa-circle-o"></i> Personal</a>
                                        </li>
																		<?php } ?>
																		<?php
																		$sql_permissao_item_124 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '124' and id_usuario = '$_SESSION[id]' and listar = '2'");
																		if (mysqli_num_rows($sql_permissao_item_124) > 0) {
																			?>
                                        <li><a href="afFotografia_exclusive.php"><i class="fa fa-circle-o"></i> Produtos
                                                Exclusive</a></li>
																		<?php } ?>
																		<?php
																		$sql_permissao_item_124 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '124' and id_usuario = '$_SESSION[id]' and listar = '2'");
																		if (mysqli_num_rows($sql_permissao_item_124) > 0) {
																			?>
                                        <li><a href="afFotografia_exclusive.php"><i class="fa fa-circle-o"></i> Exclusive</a></li>
																		<?php } ?>
                                  </ul>
                              </li>
                              <li class="treeview">
                                  <a href="#"><i class="fa fa-circle-o"></i> Top Fotos
                                      <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                  </a>
                                  <ul class="treeview-menu">
																		<?php
																		$sql_permissao_item_123 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '123' and id_usuario = '$_SESSION[id]' and listar = '2'");
																		if (mysqli_num_rows($sql_permissao_item_123) > 0) {
																			?>
                                        <li><a href="afFotografia_topfotos.php"><i class="fa fa-circle-o"></i> Cadastro Escolha de
                                                Fotos</a></li>
																		<?php } ?>
                                  </ul>
                              </li>
                          </ul>
                      </li>
                      <li><a href="afFotografia_topfotos.php"><i class="fa fa-circle-o"></i> Top Fotos</a></li>
										<?php
										$sql_permissao_item_119 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '119' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_119) > 0) {
											?>
                        <li><a href="afFotografia_tiposervico.php"><i class="fa fa-circle-o"></i> Tipo de
                                Serviço</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_120 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '120' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_120) > 0) {
											?>
                        <li><a href="afFotografia_colaboradoraoservico.php"><i class="fa fa-circle-o"></i> Colaborador ao
                                Serviço</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_72 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '72' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_72) > 0) {
											?>
                        <li><a href="afFotografia_pcpaffotografia.php"><i class="fa fa-circle-o"></i> PCP</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_81 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '81' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_81) > 0) {
											?>
                        <li><a href="MUDARlistarapontamentosaffotografia.php"><i class="fa fa-circle-o"></i> Apontamentos</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_56 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '56' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_56) > 0) {
											?>
                        <li><a href="afFotografia_albumturma.php"><i class="fa fa-circle-o"></i> Produtos Turma</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_57 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '57' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_57) > 0) {
											?>
                        <li><a href="afFotografia_albumformando.php"><i class="fa fa-circle-o"></i> Produtos Formando</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_37 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '37' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_37) > 0) {
											?>
                        <li><a href="tarefas.php?departamento=10"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_54 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '54' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_54) > 0) {
											?>
                        <li><a href="afFotografia_preeventos.php"><i class="fa fa-circle-o"></i> Pré-Eventos</a></li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_convite) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-drivers-license-o convite"></i>
                      <span>Arte Final - Convite</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_112 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '112' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_112) > 0) {
											?>
                        <li><a href="afConvite_dados.php"><i class="fa fa-circle-o"></i> Dados Convite Comissão</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_99 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '99' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_99) > 0) {
											?>
                        <li><a href="afConvite_arquivos.php"><i class="fa fa-circle-o"></i> Arquivos de Convite</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_94 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '94' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_94) > 0) {
											?>
                        <li><a href="afConvite_contrato.php"><i class="fa fa-circle-o"></i> Convites Contrato</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_64 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '64' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_64) > 0) {
											?>
                        <li><a href="afConvite_formandos.php"><i class="fa fa-circle-o"></i> Convites Formandos</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_82 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '82' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_82) > 0) {
											?>
                        <li><a href="afConvite_tiposervico.php"><i class="fa fa-circle-o"></i> Tipo de Serviço</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_83 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '83' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_83) > 0) {
											?>
                        <li><a href="cadastrar_servicoafconvite.php"><i class="fa fa-circle-o"></i> Cadastro de
                                Serviço</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_73 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '73' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_73) > 0) {
											?>
                        <li><a href="MUDARlistarpcpafconvite.php"><i class="fa fa-circle-o"></i> PCP</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_84 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '84' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_84) > 0) {
											?>
                        <li><a href="MUDARlistarapontamentosafconvite.php"><i class="fa fa-circle-o"></i> Apontamentos</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_93 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '93' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_93) > 0) {
											?>
                        <li><a href="MUDARlistartarefasafconvite.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_impressao) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-print impressao"></i>
                      <span>Impressão</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_85 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '85' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_85) > 0) {
											?>
                        <li><a href="MUDARlistartiposervicoimpressao.php"><i class="fa fa-circle-o"></i> Tipo de Serviço</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_86 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '86' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_86) > 0) {
											?>
                        <li><a href="MUDARcadastroservicoimpressao.php"><i class="fa fa-circle-o"></i> Cadastro de
                                Serviço</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_74 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '74' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_74) > 0) {
											?>
                        <li><a href="listarpcpimpressao.php"><i class="fa fa-circle-o"></i> PCP</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_87 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '87' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_87) > 0) {
											?>
                        <li><a href="listarapontamentosimpressao.php"><i class="fa fa-circle-o"></i> Apontamentos</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_91 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '91' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_91) > 0) {
											?>
                        <li><a href="tarefas.php?departamento=15"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php if (mysqli_num_rows($sql_permissoes_producao) > 0) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-print producao"></i>
                      <span>Produção</span>
                      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                  </a>
                  <ul class="treeview-menu">
										<?php
										$sql_permissao_item_88 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '88' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_88) > 0) {
											?>
                        <li><a href="producao_tiposervico.php"><i class="fa fa-circle-o"></i> Tipo de Serviço</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_89 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '89' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_89) > 0) {
											?>
                        <li><a href="producao_cadastroservico.php"><i class="fa fa-circle-o"></i> Cadastro de Serviço</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_75 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '75' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_75) > 0) {
											?>
                        <li><a href="MUDARlistarpcpproducao.php"><i class="fa fa-circle-o"></i> PCP</a></li>
										<?php } ?>
										<?php
										$sql_permissao_item_90 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '90' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_90) > 0) {
											?>
                        <li><a href="MUDARlistarapontamentosproducao.php"><i class="fa fa-circle-o"></i> Apontamentos</a>
                        </li>
										<?php } ?>
										<?php
										$sql_permissao_item_92 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '92' and id_usuario = '$_SESSION[id]' and listar = '2'");
										if (mysqli_num_rows($sql_permissao_item_92) > 0) {
											?>
                        <li><a href="MUDARlistartarefasproducao.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
										<?php } ?>
                  </ul>
              </li>
					<?php } ?>
					<?php
					$sql_permissao_item_105 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '105' and id_usuario = '$_SESSION[id]' and listar = '2'");
					if (mysqli_num_rows($sql_permissao_item_105) > 0) {
						?>
              <li>
                  <a href="listarfaq.php">
                      <i class="fa fa-question-circle"></i>
                      <span>FAQ</span>
                  </a>
              </li>
					<?php } ?>
					<?php
					$sql_permissao_item_41 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '41' and id_usuario = '$_SESSION[id]' and listar = '2'");
					if (mysqli_num_rows($sql_permissao_item_41) > 0) {
						?>
              <li>
                  <a href="usuarios.php">
                      <i class="fa fa-user-plus"></i>
                      <span>Usuários</span>
                  </a>
              </li>
					<?php } ?>
					<?php
					$sql_permissao_item_95 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '95' and id_usuario = '$_SESSION[id]' and listar = '2'");
					if (mysqli_num_rows($sql_permissao_item_95) > 0) {
						?>
              <li>
                  <a href="backup.php" target="_blank">
                      <i class="fa fa-cog"></i>
                      <span>Backup</span>
                  </a>
              </li>
					<?php } ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>