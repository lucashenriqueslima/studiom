<?php
ini_set('memory_limit', '-1');
// $sql_permissoes_cadastros = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '1' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_marketing = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '2' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_comercial = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '3' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_administrativo = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '5' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_calendario = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '7' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_fotografia = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '8' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_criacao = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '9' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_financeiro = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '10' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_vendas = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '11' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_juridico = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '13' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_rh = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '14' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_convite = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '16' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_affotografia = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '18' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_impressao = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '19' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");
// $sql_permissoes_producao = mysqli_query($con, "(select count(*) from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '20' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2')");

$permissoes = mysqli_fetch_array(mysqli_query($con, "SELECT
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '1' and pp.id_usuario = '1' and listar = '2') permissoes_cadastros,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '2' and pp.id_usuario = '1' and listar = '2') permissoes_marketing,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '3' and pp.id_usuario = '1' and listar = '2') permissoes_comercial,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '5' and pp.id_usuario = '1' and listar = '2') permissoes_administrativo,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '7' and pp.id_usuario = '1' and listar = '2') permissoes_calendario,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '8' and pp.id_usuario = '1' and listar = '2') permissoes_fotografia,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '9' and pp.id_usuario = '1' and listar = '2') permissoes_criacao,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '10' and pp.id_usuario = '1' and listar = '2') permissoes_financeiro,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '11' and pp.id_usuario = '1' and listar = '2') permissoes_vendas,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '13' and pp.id_usuario = '1' and listar = '2') permissoes_juridico,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '14' and pp.id_usuario = '1' and listar = '2') permissoes_rh,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '16' and pp.id_usuario = '1' and listar = '2') permissoes_convite,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '18' and pp.id_usuario = '1' and listar = '2') permissoes_affotografia,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '19' and pp.id_usuario = '1' and listar = '2') permissoes_impressao,
(select COUNT(*) from paginas_permissoes pp inner join paginas p on p.id_pagina = pp.id_pagina where p.id_modulo = '20' and pp.id_usuario = '1' and listar = '2') permissoes_producao

"));


?>
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    <div class="user-profile d-flex no-block dropdown mt-3">
                        <div class="user-pic"><img src="arquivos/<?php echo $_SESSION['imagem']; ?>" alt="users"
                                                   class="rounded-circle" width="40"/></div>
                        <div class="user-content hide-menu ml-2">
                            <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <h5 class="mb-0 user-name font-medium"><?php echo $_SESSION['nome']; ?> <i
                                            class="fa fa-angle-down"></i></h5>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="sair.php"><i class="fa fa-power-off mr-1 ml-1"></i> Sair</a>
                            </div>
                        </div>
                    </div>
                    <!-- End User Profile-->
                </li>
							<?php if ($permissoes["permissoes_cadastros"] > 0) { ?>
                  <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                              href="javascript:void(0)" aria-expanded="false"><img
                                  src="imgs/icons/icones-revisados-21.png" width="25px"/><span
                                  class="hide-menu cadastrosgerais" style="margin-left: 7px;">Cadastros</span></a>
                      <ul aria-expanded="false" class="collapse  first-level">
												<?php
												$sql_permissao_item_1 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '1' and id_usuario = '$_SESSION[id]' and listar = '2'");
                                                if (mysqli_fetch_array($sql_permissao_item_1)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_fornecedores.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Fornecedores </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_2 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '2' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_2)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_instituicao.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Instituições </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_3 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '3' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_3)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_cursos.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> Cursos </span></a></li>
												<?php } ?>
												<?php
												$sql_permissao_item_102 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '102' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_102)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_turmasmkt.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> Turmas </span></a></li>
												<?php } ?>
												<?php
												$sql_permissao_item_5 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '5' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_5)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_formandos.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Formandos </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_6 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '6' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_6)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_categorias.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Categorias CRM </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_7 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '7' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_7)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_status.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Status Categorias CRM </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_8 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '8' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_8)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_departamentos.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Departamentos </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_9 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '9' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_9)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_locaiseventos.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Locais de Eventos </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_10 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '10' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_10)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_categoriaseventos.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Categoria de Eventos </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_55 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '55' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_55)[0] > 0) {
													?>
<!--                            <li class="sidebar-item"><a href="cadastros_categoriasfornecedores.php"-->
<!--                                                        class="sidebar-link"><i style="margin-left:15px;"-->
<!--                                                                                class="mdi mdi-arrow-right-bold-circle"></i><span-->
<!--                                            class="hide-menu"> Categoria de Fornecedores </span></a>-->
<!--                            </li>-->
												<?php } ?>
												<?php
												$sql_permissao_item_11 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '11' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_11)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_tiposinteracao.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Meio Interação </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_15 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '15' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_15)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_assuntos.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Assuntos Interação </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_43 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '43' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_43)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_cadbancos.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> Bancos </span></a></li>
												<?php } ?>
												<?php
												$sql_permissao_item_98 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '98' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_98)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="cadastros_tiposarquivos.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Tipos de Arquivos </span></a>
                            </li>
												<?php } ?>
                            
                            <li class="sidebar-item"><a href="cadastro_dispositivo.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Cadastro de Dispositivo</span></a>
                          </li>
                      </ul>
                  </li>
							<?php } ?>
							<?php if ($permissoes["permissoes_marketing"] > 0) { ?>
                  <li class="sidebar-item marketing"><a class="sidebar-link marketing has-arrow waves-effect"
                                                        href="javascript:void(0)" aria-expanded="false"><img
                                  src="imgs/icons/icones-revisados-25.png"
                                  width="25px"/><span class="hide-menu marketing"
                                                      style="margin-left: 7px;">Marketing </span></a>
                      <ul aria-expanded="false" class="collapse  first-level">
												<?php
												$sql_permissao_item_104 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '104' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_104)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="marketing_prospeccao.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Prospecção </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_119 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '119' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_119)[0] > 0) {
													?>
                            <!--                            <li class="sidebar-item"><a href="marketing_tipos_servico.php" class="sidebar-link"><i-->
                            <!--                                            style="margin-left:15px;"-->
                            <!--                                            class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Tipo de Serviço </span></a>-->
                            <!--                            </li>-->
												<?php } ?>
                          <li class="sidebar-item"><a href="marketing_aniversarios.php" class="sidebar-link">
                                  <i style="margin-left:15px;" class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Aniversários </span></a>
                          </li>
                          <li class="sidebar-item"><a href="marketing_redesocial.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Redes Sociais </span></a>
                          </li>
                          <li class="sidebar-item"><a href="#" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu" style="color: red"> Campanhas </span></a>
                          </li>
												<?php
												$sql_permissao_item_16 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '16' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_16)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="tarefas.php?departamento=7" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> Tarefas </span></a></li>
												<?php } ?>
                          <li class="sidebar-item"><a href="pcp_departamento.php?departamento=7"
                                                      class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> PCP </span></a>
                          </li>
                      </ul>
                  </li>
							<?php }
							if ($permissoes["permissoes_comercial"] > 0) { ?>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><img
                                src="imgs/icons/icones-revisados-19.png"
                                width="25px"/><span class="hide-menu comercial"
                                                    style="margin-left: 7px;">Comercial </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i>
                                <span
                                        class="hide-menu">Convite</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
                                <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                            aria-expanded="false"><i style="margin-left:30px;"
                                                                                     class="mdi mdi-plus-circle-outline"></i>
                                        <span class="hide-menu">Cadastros Gerais</span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
																			<?php
																			$sql_permissao_item_107 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '107' and id_usuario = '$_SESSION[id]' and listar = '2'");
																			if (mysqli_fetch_array($sql_permissao_item_107)[0] > 0) {
																				?>
                                          <li class="sidebar-item"><a href="comercial_itenstabelaconvite.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span class="hide-menu"> Tabela de Valores</span></a>
                                          </li>
																			<?php } ?>
																			<?php
																			$sql_permissao_item_109 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '109' and id_usuario = '$_SESSION[id]' and listar = '2'");
																			if (mysqli_fetch_array($sql_permissao_item_109)[0] > 0) {
																				?>
                                          <li class="sidebar-item"><a href="comercial_dadosbasico.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span class="hide-menu"> Dados Básicos</span></a>
                                          </li>
																			<?php } ?>
																			<?php
																			$sql_permissao_item_110 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '110' and id_usuario = '$_SESSION[id]' and listar = '2'");
																			if (mysqli_fetch_array($sql_permissao_item_110)[0] > 0) {
																				?>
                                          <li class="sidebar-item"><a href="comercial_tabelaacabamentos.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span class="hide-menu"> Tabela Acabamentos</span></a>
                                          </li>
																			<?php } ?>
																			<?php
																			$sql_permissao_item_106 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '106' and id_usuario = '$_SESSION[id]' and listar = '2'");
																			if (mysqli_fetch_array($sql_permissao_item_106)[0] > 0) {
																				?>
                                          <li class="sidebar-item"><a href="comercial_tabelatribconvite.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span class="hide-menu"> Tributos</span></a>
                                          </li>
																			<?php } ?>
                                    </ul>
                                </li>
                                <li class="sidebar-item"><a href="comercial_orcamento_convite.php"
                                                            class="sidebar-link"><i
                                                class="mdi mdi-arrow-right-bold-circle"
                                                style="margin-left:30px;"></i><span
                                                class="hide-menu"> Orçamento</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i>
                                <span
                                        class="hide-menu crm">CRM</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
															<?php
															$sql_permissao_item_18 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '18' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_18)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="comercial_oportunidades.php"
                                                              class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span
                                                  class="hide-menu"> Leads</span></a></li>
															<?php } ?>
															<?php
															$sql_permissao_item_19 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '19' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_19)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="comercial_pipe.php" class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span
                                                  class="hide-menu"> PIPE</span></a></li>
															<?php } ?>
															<?php
															$sql_permissao_item_22 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '22' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_22)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="comercial_campanhas.php" class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span
                                                  class="hide-menu"> Campanhas</span></a></li>
															<?php } ?>
                            </ul>
													<?php
													$sql_permissao_item_17 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '17' and id_usuario = '$_SESSION[id]' and listar = '2'");
													if (mysqli_fetch_array($sql_permissao_item_17)[0] > 0) {
													?>
                        <li class="sidebar-item"><a href="tarefas.php?departamento=1" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Tarefas </span></a></li>
											<?php } ?>
                        </li>
											<?php } ?>
                    </ul>
									<?php if ($permissoes["permissoes_vendas"] > 0) { ?>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><img
                                src="imgs/icons/icones-revisados-33.png"
                                width="25px"/><span class="hide-menu vendas"
                                                    style="margin-left: 7px;">Vendas </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i>
                                <span
                                        class="hide-menu">Fotografia</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
                                <li class="sidebar-item"><a class="has-arrow sidebar-link"
                                                            href="javascript:void(0)"
                                                            aria-expanded="false"><i style="margin-left:30px"
                                                                                     class="mdi mdi-plus-circle-outline"></i>
                                        <span
                                                class="hide-menu">Pós</span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
																			<?php
																			$sql_permissao_item_50 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '50' and id_usuario = '$_SESSION[id]' and listar = '2'");
																			if (mysqli_fetch_array($sql_permissao_item_50)[0] > 0) {
																				?>
                                          <li class="sidebar-item"><a href="vendas_remessas.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span
                                                          class="hide-menu"> Remessas</span></a>
                                          </li>
																			<?php } ?>
																			<?php
																			$sql_permissao_item_48 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '48' and id_usuario = '$_SESSION[id]' and listar = '2'");
																			if (mysqli_fetch_array($sql_permissao_item_48)[0] > 0) {
																				?>
                                          <li class="sidebar-item"><a href="vendas_produtosformando.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span
                                                          class="hide-menu"> Produtos Formando</span></a>
                                          </li>
																			<?php } ?>
                                    </ul>
                                </li>
                                <li class="sidebar-item"><a class="has-arrow sidebar-link"
                                                            href="javascript:void(0)"
                                                            aria-expanded="false"><i style="margin-left:30px"
                                                                                     class="mdi mdi-plus-circle-outline"></i>
                                        <span
                                                class="hide-menu">Pré</span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
																			<?php
																			$sql_permissao_item_51 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '51' and id_usuario = '$_SESSION[id]' and listar = '2'");
																			if (mysqli_fetch_array($sql_permissao_item_51)[0] > 0) {
																				?>
                                          <li class="sidebar-item"><a href="vendas_pacotes.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span
                                                          class="hide-menu"> Produtos Álbum</span></a>
                                          </li>
																			<?php } ?>
                                    </ul>
                                </li>
															<?php
															$sql_permissao_item_96 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '96' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_96)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="vendas_avulsas.php"
                                                              class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px"></i><span
                                                  class="hide-menu"> Vendas Avulsa</span></a>
                                  </li>
															<?php } ?>
															<?php
															$sql_permissao_item_97 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '97' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_97)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="vendas_liberarfotos.php"
                                                              class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px"></i><span
                                                  class="hide-menu"> Liberar Fotos</span></a></li>
															<?php } ?>
                            </ul>
                        </li>
                        <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i>
                                <span
                                        class="hide-menu">Convite</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
															<?php
															$sql_permissao_item_14 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '14' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_14)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="vendas_produtos.php" class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span
                                                  class="hide-menu"> Produtos</span></a></li>
															<?php } ?>
                            </ul>
                        </li>
                        <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i>
                                <span
                                        class="hide-menu">Gestor de Vendas</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
                                <li class="sidebar-item"><a class="has-arrow sidebar-link"
                                                            href="javascript:void(0)"
                                                            aria-expanded="false"><i style="margin-left:30px"
                                                                                     class="mdi mdi-plus-circle-outline"></i>
                                        <span
                                                class="hide-menu">Convite</span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
																			<?php
																			$sql_permissao_item_31 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '31' and id_usuario = '$_SESSION[id]' and listar = '2'");
																			if (mysqli_fetch_array($sql_permissao_item_31)[0] > 0) {
																				?>
                                          <li class="sidebar-item"><a href="vendas_gestaodeconvites.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span
                                                          class="hide-menu"> Gestão Parcial da<br> Venda</span></a>
                                          </li>
                                          <li class="sidebar-item"><a href="vendas_gestaodeconvitestodos.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span
                                                          class="hide-menu"> Gestão Total da Venda</span></a>
                                          </li>
																			<?php } ?>
																			<?php
																			$sql_permissao_item_48 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '48' and id_usuario = '$_SESSION[id]' and listar = '2'");
																			if (mysqli_fetch_array($sql_permissao_item_48)[0] > 0) {
																				?>
                                          <li class="sidebar-item"><a href="vendas_aceitesgerar.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span
                                                          class="hide-menu"> Gerar Aceite de<br> Convites</span></a>
                                          </li>
                                          <li class="sidebar-item"><a href="vendas_aceites.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span
                                                          class="hide-menu"> Impressão de Aceite</span></a>
                                          </li>
																			<?php } ?>
                                    </ul>
                                </li>
                                <li class="sidebar-item"><a class="has-arrow sidebar-link"
                                                            href="javascript:void(0)"
                                                            aria-expanded="false"><i style="margin-left:30px"
                                                                                     class="mdi mdi-plus-circle-outline"></i>
                                        <span
                                                class="hide-menu">Fotografia</span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
																			<?php
																			$sql_permissao_item_32 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '32' and id_usuario = '$_SESSION[id]' and listar = '2'");
																			if (mysqli_fetch_array($sql_permissao_item_32)[0] > 0) {
																				?>
                                          <li class="sidebar-item"><a href="vendas_gestaodealbuns.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span
                                                          class="hide-menu">Gestão de Álbuns <br>e Fotografias</span></a>
                                          </li>
																			<?php } ?>
																			<?php
																			$sql_permissao_item_31 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '31' and id_usuario = '$_SESSION[id]' and listar = '2'");
																			if (mysqli_fetch_array($sql_permissao_item_31)[0] > 0) {
																				?>
                                          <li class="sidebar-item"><a href="vendas_aceitesalbuns.php"
                                                                      class="sidebar-link"><i
                                                          class="mdi mdi-arrow-right-bold-circle"
                                                          style="margin-left:45px;"></i><span
                                                          class="hide-menu"> Impressão de Aceite</span></a>
                                          </li>
																			<?php } ?>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i>
                                <span
                                        class="hide-menu">Cadastros Gerais</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
															<?php
															$sql_permissao_item_13 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '13' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_13)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="vendas_formas.php" class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span class="hide-menu"> Formas de Pagamento</span></a>
                                  </li>
															<?php } ?>
															<?php
															$sql_permissao_item_49 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '49' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_49)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="vendas_tiposprodutosop.php"
                                                              class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span class="hide-menu"> Produtos Fotografia</span></a>
                                  </li>
															<?php } ?>
															<?php
															$sql_permissao_item_12 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '12' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_12)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="vendas_tiposprodutos.php"
                                                              class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span class="hide-menu"> Produtos Convite</span></a>
                                  </li>
															<?php } ?>
                            </ul>
                        </li>
                        <li class="sidebar-item"><a href="vendas_gestaodevendas.php" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Gestão de Vendas</span></a>
                        </li>
                        <li class="sidebar-item"><a href="vendas_relvendas.php" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Relatório de Vendas</span></a></li>
											<?php
											$sql_permissao_item_52 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '52' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_52)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="vendas_exclusao.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Excluir Vendas</span></a>
                          </li>
											<?php } ?>
											<?php
											$sql_permissao_item_36 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '36' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_36)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="tarefas.php?departamento=5"
                                                      class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Tarefas</span></a>
                          </li>
											<?php } ?>
                    </ul>
                </li>
						<?php }
						if ($permissoes["permissoes_administrativo"] > 0) { ?>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><img
                                src="imgs/icons/icones-revisados-31.png"
                                width="25px"/><span class="hide-menu administrativo"
                                                    style="margin-left: 7px;">Contratos </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
											<?php
											$sql_permissao_item_4 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '4' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_4)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="projetos_turmas.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Gestão de Contratos </span></a>
                          </li>
											<?php } ?>
											<?php
											$sql_permissao_item_111 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '111' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_111)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="projetos_hds.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> HDS </span></a></li>
											<?php } ?>
                        <li class="sidebar-item"><a href="tarefas.php?departamento=3" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Tarefas </span></a></li>
                    </ul>
                </li>
						<?php }
						if ($permissoes["permissoes_administrativo"] > 0) { ?>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><img
                                src="imgs/icons/icones-revisados-41.png"
                                width="25px"/><span class="hide-menu administrativo"
                                                    style="margin-left: 7px;">PCP </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
											<?php
											$sql_permissao_item_65 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '65' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_65)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="pcp_geral.php" class="sidebar-link"><i
                                          style="margin-left:15px"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Visão Geral </span></a>
                          </li>
                          <li class="sidebar-item"><a href="pcp_cadastros.php" class="sidebar-link"><i
                                          style="margin-left:15px"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Cadastros </span></a>
                          </li>
											<?php } ?>
											<?php
											$sql_permissao_item_68 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '68' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_68)[0] > 0) {
												?>
                          <!--                                    <li class="sidebar-item"><a href="projetos_cadastrar_entrada_pcp.php"-->
                          <!--                                                                class="sidebar-link"><i-->
                          <!--                                                    style="margin-left:30px"-->
                          <!--                                                    class="mdi mdi-arrow-right-bold-circle"></i><span-->
                          <!--                                                    class="hide-menu"> Cadastro de Job<br>no Contrato </span></a>-->
                          <!--                                    </li>-->
											<?php } ?>
											<?php
											$sql_permissao_item_69 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '69' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_69)[0] > 0) {
												?>
                          <!--                                    <li class="sidebar-item"><a href="projetos_pcpgeral_lista.php"-->
                          <!--                                                                class="sidebar-link"><i-->
                          <!--                                                    style="margin-left:30px"-->
                          <!--                                                    class="mdi mdi-arrow-right-bold-circle"></i><span-->
                          <!--                                                    class="hide-menu"> PCP Geral </span></a>-->
                          <!--                                    </li>-->
                          <!--                                    <li class="sidebar-item"><a href="projetos_pcpgeral.php" class="sidebar-link"><i-->
                          <!--                                                    style="margin-left:30px"-->
                          <!--                                                    class="mdi mdi-arrow-right-bold-circle"></i><span-->
                          <!--                                                    class="hide-menu"> Gestão de JOBS </span></a>-->
                          <!--                                    </li>-->
											<?php } ?>
                    </ul>
                </li>
						<?php }
						if ($permissoes["permissoes_juridico"] > 0) { ?>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><img
                                src="imgs/icons/icones-revisados-27.png"
                                width="25px"/><span class="hide-menu juridico"
                                                    style="margin-left: 7px;">Jurídico </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
											<?php
											$sql_permissao_item_67 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '6' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_67)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="juridico_processos.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Processos </span></a>
                          </li>
											<?php } ?>
											<?php
											$sql_permissao_item_38 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '38' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_38)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="tarefas.php?departamento=11" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Tarefas </span></a></li>
											<?php } ?>
                    </ul>
                </li>
						<?php }
						if ($permissoes["permissoes_rh"] > 0) { ?>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><img
                                src="imgs/icons/icones-revisados-13.png"
                                width="25px"/><span class="hide-menu rh" style="margin-left: 7px;">RH </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
											<?php
											$sql_permissao_item_39 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '39' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_39)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="rh_colaboradores.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Colaboradores </span></a>
                          </li>
											<?php } ?>
											<?php
											$sql_permissao_item_40 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '40' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_40)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="tarefas.php?departamento=12" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Tarefas </span></a></li>
											<?php } ?>
                    </ul>
                </li>
						<?php }
						if ($permissoes["permissoes_financeiro"] > 0) { ?>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><img
                                src="imgs/icons/icones-revisados-15.png"
                                width="25px"/><span
                                class="hide-menu financeiro" style="margin-left: 7px;">Financeiro </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i>
                                <span
                                        class="hide-menu">Cobrança</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
															<?php
															$sql_permissao_item_33 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '33' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_33)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="financeiro_regua_de_cobranca.php" class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span
                                                  class="hide-menu">Régua de Cobrança</span></a></li>
															<?php } ?>

                                                            <?php
															$sql_permissao_item_33 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '33' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_33)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="financeiro_relatorio_regua_de_cobranca.php" class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span
                                                  class="hide-menu">Relatório de Cobrança</span></a></li>
															<?php } ?>

                                                            <?php
															$sql_permissao_item_33 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '33' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_33)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="financeiro_excecao_regua_de_cobranca.php" class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span
                                                  class="hide-menu">Exceção de Cobrança</span></a></li>
															<?php } ?>

                            </ul>
                        </li>
											<?php
											$sql_permissao_item_33 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '33' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_33)[0] > 0) {
												?>
                          <li class="sidebar-item">
                              <a href="financeiro_controle_financeiro.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Fluxo de Caixa </span>
                              </a>
                          </li>
											<?php } ?>
                                            <?php
											$sql_permissao_item_33 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '33' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_33)[0] > 0) {
												?>
                          <li class="sidebar-item">
                              <a href="financeiro_gestaotitulos.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Gestão de Títulos </span>
                              </a>
                          </li>
											<?php } ?>
											<?php
											$sql_permissao_item_33 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '33' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_33)[0] > 0) {
												?>
                          <li class="sidebar-item">
                              <a href="financeiro_movimentacao.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Movimentação Financeira </span>
                              </a>
                          </li>
											<?php } ?>
											<?php
											$sql_permissao_item_33 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '33' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_33)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="financeiro_duplicatas.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Duplicatas </span></a>
                          </li>
											<?php } ?>
											<?php
											$sql_permissao_item_122 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '122' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_122)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="#" class="sidebar-link"
                                                      onClick="window.open('retorno/upload.php', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, WIDTH=350, HEIGHT=100');"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Retorno Santander </span></a>
                          </li>
											<?php } ?>
											<?php
											$sql_permissao_item_47 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '47' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_47)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="financeiro_cadastros.php" class="sidebar-link"><i
                                          style="margin-left:15px"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Cadastros </span></a>
                          </li>
											<?php } ?>
											<?php
											$sql_permissao_item_35 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '35' and id_usuario = '$_SESSION[id]' and listar = '2'");
											if (mysqli_fetch_array($sql_permissao_item_35)[0] > 0) {
												?>
                          <li class="sidebar-item"><a href="tarefas.php?departamento=4"
                                                      class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Tarefas </span></a></li>
											<?php } ?>
                    </ul>
                </li>
						<?php }
						if ($permissoes["permissoes_calendario"] > 0) { ?>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><img
                                src="imgs/icons/icones-revisados-35.png"
                                width="25px"/><span
                                class="hide-menu" style="margin-left: 7px;">Interatividades </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="interatividade_chamados.php" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Chamados </span></a></li>
                        <li class="sidebar-item"><a href="interatividade_chat.php" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Chat </span></a></li>

                        <li class="sidebar-item"><a href="interatividade_calendario.php" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Calendário </span></a>
                        </li>
                        <li class="sidebar-item"><a href="interatividade_feriados.php" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Feriados </span></a>
                        </li>
                        <li class="sidebar-item"><a href="tarefas.php?departamento=0" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Tarefas </span></a>
                        </li>
                        <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i>
                                <span
                                        class="hide-menu">Fotografia</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
															<?php
															$sql_permissao_item_58 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '58' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_58)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="listareventosbkp.php" class="sidebar-link"
                                                              title="arquivosdefotosfotografia@studiomfotografia.com.br"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span class="hide-menu"> Arquivos de Fotos</span></a>
                                  </li>
															<?php } ?>
															<?php
															$sql_permissao_item_59 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '59' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_59)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="listareventosproducao.php"
                                                              class="sidebar-link"
                                                              title="arquivosdeproducaofotografia@studiomfotografia.com.br"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span class="hide-menu"> Arquivos de Produção</span></a>
                                  </li>
															<?php } ?>
															<?php
															$sql_permissao_item_60 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '60' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_60)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="listarmostruario.php" class="sidebar-link"
                                                              title="mostruario@studiomfotografia.com.br"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span
                                                  class="hide-menu"> Mostruário</span></a></li>
															<?php } ?>
                            </ul>
                        </li>
                        <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i>
                                <span
                                        class="hide-menu"> Convite</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
															<?php
															$sql_permissao_item_61 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '61' and id_usuario = '$_SESSION[id]' and listar = '2'");
															if (mysqli_fetch_array($sql_permissao_item_61)[0] > 0) {
																?>
                                  <li class="sidebar-item"><a href="listararquivosdeconvites.php"
                                                              class="sidebar-link"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span class="hide-menu"> Arquivo de Convites</span></a>
                                  </li>
                                  <li class="sidebar-item"><a href="listararquivosdeproducao.php"
                                                              class="sidebar-link"
                                                              title="arquivosdeproducaoconvite@studiomfotografia.com.br"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span class="hide-menu"> Arquivo de Produção</span></a>
                                  </li>
                                  <li class="sidebar-item"><a href="listararquivosdeimpressao.php"
                                                              class="sidebar-link"
                                                              title="arquivosdeimpressao@studiomfotografia.com.br"><i
                                                  class="mdi mdi-arrow-right-bold-circle"
                                                  style="margin-left:30px;"></i><span class="hide-menu"> Arquivos de Impressão</span></a>
                                  </li>
															<?php } ?>
                            </ul>
                        </li>
                    </ul>
                </li>
							<?php if ($permissoes["permissoes_criacao"] > 0) { ?>
                    <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                href="javascript:void(0)" aria-expanded="false"><img
                                    src="imgs/icons/icones-revisados-05.png"
                                    width="25px"/><span class="hide-menu criacao"
                                                        style="margin-left: 7px;">Criação </span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
													<?php
													$sql_permissao_item_113 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '113' and id_usuario = '$_SESSION[id]' and listar = '2'");
													if (mysqli_fetch_array($sql_permissao_item_113)[0] > 0) {
														?>
                              <li class="sidebar-item"><a href="criacao_solicitacaodeartes.php"
                                                          class="sidebar-link"><i
                                              style="margin-left:15px;"
                                              class="mdi mdi-arrow-right-bold-circle"></i><span
                                              class="hide-menu"> Solicitação de Artes </span></a>
                              </li>
													<?php } ?>
													<?php
													$sql_permissao_item_76 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '76' and id_usuario = '$_SESSION[id]' and listar = '2'");
													if (mysqli_fetch_array($sql_permissao_item_76)[0] > 0) {
														?>
                              <!--                                        <li class="sidebar-item"><a href="criacao_tiposervicocriacao.php"-->
                              <!--                                                                    class="sidebar-link"><i-->
                              <!--                                                        style="margin-left:15px;"-->
                              <!--                                                        class="mdi mdi-arrow-right-bold-circle"></i><span-->
                              <!--                                                        class="hide-menu"> Tipo de Serviço </span></a>-->
                              <!--                                        </li>-->
													<?php } ?>
													<?php
													$sql_permissao_item_70 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '70' and id_usuario = '$_SESSION[id]' and listar = '2'");
													if (mysqli_fetch_array($sql_permissao_item_70)[0] > 0) {
														?>
                              <!--                                        <li class="sidebar-item"><a href="criacao_pcp.php" class="sidebar-link"><i-->
                              <!--                                                        style="margin-left:15px;"-->
                              <!--                                                        class="mdi mdi-arrow-right-bold-circle"></i><span-->
                              <!--                                                        class="hide-menu"> PCP </span></a></li>-->
													<?php } ?>
													<?php
													$sql_permissao_item_30 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '30' and id_usuario = '$_SESSION[id]' and listar = '2'");
													if (mysqli_fetch_array($sql_permissao_item_30)[0] > 0) {
														?>
                              <li class="sidebar-item"><a href="tarefas.php?departamento=9"
                                                          class="sidebar-link"><i
                                              style="margin-left:15px;"
                                              class="mdi mdi-arrow-right-bold-circle"></i><span
                                              class="hide-menu"> Tarefas </span></a>
                              </li>
													<?php } ?>
                                <li class="sidebar-item"><a href="pcp_departamento.php?departamento=9"
                                                            class="sidebar-link"><i
                                                style="margin-left:15px;"
                                                class="mdi mdi-arrow-right-bold-circle"></i><span
                                                class="hide-menu"> PCP </span></a>
                                </li>
                        </ul>
                    </li>
							<?php }
							if ($permissoes["permissoes_fotografia"] > 0) { ?>
                  <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                              href="javascript:void(0)" aria-expanded="false"><img
                                  src="imgs/icons/icones-revisados-09.png"
                                  width="25px"/><span class="hide-menu fotografia"
                                                      style="margin-left: 7px;">Eventos </span></a>
                      <ul aria-expanded="false" class="collapse  first-level">
                          <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                      aria-expanded="false"><i style="margin-left:15px;"
                                                                               class="mdi mdi-plus-circle-outline"></i>
                                  <span class="hide-menu">Relatórios</span></a>
                              <ul aria-expanded="false" class="collapse second-level">
																<?php
																$sql_permissao_item_115 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '115' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_fetch_array($sql_permissao_item_115)[0] > 0) {
																	?>
                                    <li class="sidebar-item"><a
                                                href="fotografia_relatorioparticipacaoevento.php"
                                                class="sidebar-link" target="_blank"><i
                                                    class="mdi mdi-arrow-right-bold-circle"
                                                    style="margin-left:30px;"></i><span class="hide-menu"> Relatório de Participação<br>
                                                        em Evento</span></a></li>
																<?php } ?>
                              </ul>
                          </li>
												<?php
												$sql_permissao_item_25 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '25' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_25)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="fotografia_eventos.php" class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> Gestão de Eventos </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_125 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '125' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_125)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="fotografia_perfilfotografico.php"
                                                        class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> Perfil Fotográfico </span></a>
                            </li>
												<?php } ?>
                          <li class="sidebar-item"><a href="fotografia_identificacao.php"
                                                      class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Indentificação por Evento </span></a>
                          </li>
                          <li class="sidebar-item"><a href="fotografia_identificacaocad.php"
                                                      class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Indentificação por Cadastro </span></a>
                          </li>
												<?php
												$sql_permissao_item_115 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '115' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_115)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="fotografia_planejamento_eventos.php"
                                                        class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> Escala de Eventos </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_117 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '117' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_117)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="fotografia_faturamentodeeventos.php"
                                                        class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> Faturamento de Eventos </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_119 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '119' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_119)[0] > 0) {
													?>
                            <!--                                      <li class="sidebar-item"><a href="fotografia_tiposervicofotografia.php"-->
                            <!--                                                                  class="sidebar-link"><i-->
                            <!--                                                      style="margin-left:15px;"-->
                            <!--                                                      class="mdi mdi-arrow-right-bold-circle"></i><span-->
                            <!--                                                      class="hide-menu"> Tipo de Serviço </span></a>-->
                            <!--                                      </li>-->
												<?php } ?>
												<?php
												$sql_permissao_item_29 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '29' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_29)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="tarefas.php?departamento=2"
                                                        class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> Tarefas </span></a>
                            </li>
												<?php } ?>
                          <li class="sidebar-item"><a href="pcp_departamento.php?departamento=2"
                                                      class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> PCP </span></a>
                          </li>
                          

                      </ul>
                  </li>
							<?php }
							if ($permissoes["permissoes_affotografia"] > 0) { ?>
                  <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                              href="javascript:void(0)" aria-expanded="false"><img
                                  src="imgs/icons/icones-revisados-11.png"
                                  width="25px"/><span
                                  class="hide-menu album" style="margin-left: 7px;">Fotografia </span></a>

                      <ul aria-expanded="false" class="collapse  first-level">
                          <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                      aria-expanded="false"><i style="margin-left:15px;"
                                                                               class="mdi mdi-plus-circle-outline"></i>
                                  <span class="hide-menu">Escolha de Fotos</span></a>

                              <ul aria-expanded="false" class="collapse second-level">
                                  <li class="sidebar-item"><a
                                              class="sidebar-link has-arrow waves-effect waves-dark"
                                              href="javascript:void(0)"
                                              aria-expanded="false"><i style="margin-left:30px"
                                                                       class="mdi mdi-plus-circle-outline"></i>
                                          <span class="hide-menu">Produtos Convite</span></a>
                                      <ul aria-expanded="false" class="collapse second-level">
																				<?php
																				$sql_permissao_item_124 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '124' and id_usuario = '$_SESSION[id]' and listar = '2'");
																				if (mysqli_fetch_array($sql_permissao_item_124)[0] > 0) {
																					?>
                                            <li class="sidebar-item"><a href="afFotografia_personal.php"
                                                                        class="sidebar-link"><i
                                                            class="mdi mdi-arrow-right-bold-circle"
                                                            style="margin-left:45px;"></i><span
                                                            class="hide-menu"> Personal</span></a>
                                            </li>
																				
																				<?php } ?>
																				<?php
																				$sql_permissao_item_124 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '124' and id_usuario = '$_SESSION[id]' and listar = '2'");
																				if (mysqli_fetch_array($sql_permissao_item_124)[0] > 0) {
																					?>
                                            <li class="sidebar-item"><a href="afFotografia_exclusive.php"
                                                                        class="sidebar-link"><i
                                                            class="mdi mdi-arrow-right-bold-circle"
                                                            style="margin-left:45px;"></i><span
                                                            class="hide-menu"> Exclusive</span></a>
                                            </li>
																				<?php } ?>
                                      </ul>
                                  </li>
																<?php
																$sql_permissao_item_56 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '56' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_fetch_array($sql_permissao_item_56)[0] > 0) {
																	?>
                                    <li class="sidebar-item"><a href="afFotografia_escolhadefotos.php"
                                                                class="sidebar-link"><i
                                                    style="margin-left:30px"
                                                    class="mdi mdi-arrow-right-bold-circle"></i><span
                                                    class="hide-menu"> Produtos Fotografia</span></a></li>
																<?php } ?>
                                    <li class="sidebar-item"><a href="afFotografia_albumturma.php"
                                                                class="sidebar-link"><i
                                                    class="mdi mdi-arrow-right-bold-circle"
                                                    style="margin-left:30px;"></i><span class="hide-menu"> Produtos Turma</span></a>
                                    </li>
                              </ul>
                          </li>
                          <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                      aria-expanded="false"><i style="margin-left:15px;"
                                                                               class="mdi mdi-plus-circle-outline"></i>
                                  <span class="hide-menu">Aprovação Produtos<br>  Fotografia</span></a>
                              <ul aria-expanded="false" class="collapse second-level">
																<?php
																$sql_permissao_item_57 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '57' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_fetch_array($sql_permissao_item_57)[0] > 0) {
																	?>
                                    <li class="sidebar-item"><a href="afFotografia_albumformando.php"
                                                                class="sidebar-link"><i
                                                    class="mdi mdi-arrow-right-bold-circle"
                                                    style="margin-left:30px;"></i><span
                                                    class="hide-menu"> Produtos Formando</span></a>
                                    </li>
																<?php } ?>
                              </ul>
                          </li>
                          <!---->
                          <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                      aria-expanded="false"><i style="margin-left:15px;"
                                                                               class="mdi mdi-plus-circle-outline"></i>
                                  <span class="hide-menu">Relatórios</span></a>
                              <ul aria-expanded="false" class="collapse second-level">
																<?php
																$sql_permissao_item_129 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '129' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_fetch_array($sql_permissao_item_129)[0] > 0) {
																	?>
                                    <li class="sidebar-item"><a href="Fotografia_relatorioCompraProduto.php"
                                                                class="sidebar-link"><i
                                                    class="mdi mdi-arrow-right-bold-circle"
                                                    style="margin-left:30px;"></i><span
                                                    class="hide-menu"> Relatório de Compra <br> de Produtos</span></a>
                                    </li>
                                    <li class="sidebar-item"><a href="Fotografia_relatorioCompraProduto_copy.php"
                                                                class="sidebar-link"><i
                                                    class="mdi mdi-arrow-right-bold-circle"
                                                    style="margin-left:30px;"></i><span
                                                    class="hide-menu"> Relatório de Compra <br> de Produtos(Total)</span></a>
                                    </li>
																<?php } ?>
                                                                <?php
																$sql_permissao_item_131 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '131' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_fetch_array($sql_permissao_item_131)[0] > 0) {
																	?>
                                    <li class="sidebar-item"><a href="Fotografia_relatorioVenda.php"
                                                                class="sidebar-link"><i
                                                    class="mdi mdi-arrow-right-bold-circle"
                                                    style="margin-left:30px;"></i><span
                                                    class="hide-menu"> Relatório de Venda</span></a>
                                    </li>
																<?php } ?>
                              </ul>
                          </li>

                          <!---->
                          <?php
																$sql_permissao_item_130 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '130' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_fetch_array($sql_permissao_item_130)[0] > 0) {
																	?>
                          <li class="sidebar-item"><a href="fotografia_os.php"
                                                        class="sidebar-link"><i
                                            class="mdi mdi-arrow-right-bold-circle"
                                            style="margin-left:15px;"></i><span
                                            class="hide-menu">O.S </span></a>
                            </li>
                          <?php } ?>

												<?php
												$sql_permissao_item_123 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '123' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_123)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="afFotografia_topfotos.php"
                                                        class="sidebar-link"><i
                                            class="mdi mdi-arrow-right-bold-circle"
                                            style="margin-left:15px;"></i><span
                                            class="hide-menu"> Top Fotos</span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_54 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '54' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_54)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="afFotografia_preeventos.php"
                                                        class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> Pré-Eventos </span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_57 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '57' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_57)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="afFotografia_geral.php"
                                                        class="sidebar-link"><i
                                            class="mdi mdi-arrow-right-bold-circle"
                                            style="margin-left:15px;"></i><span
                                            class="hide-menu"> Visão Geral</span></a>
                            </li>
												<?php } ?>
												<?php
												$sql_permissao_item_37 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '37' and id_usuario = '$_SESSION[id]' and listar = '2'");
												if (mysqli_fetch_array($sql_permissao_item_37)[0] > 0) {
													?>
                            <li class="sidebar-item"><a href="tarefas.php?departamento=10"
                                                        class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> Tarefas </span></a>
                            </li>
												<?php } ?>
                          <li class="sidebar-item"><a href="pcp_departamento.php?departamento=10"
                                                      class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> PCP </span></a>
                          </li>
                          
                      </ul>
                  </li>
							<?php }
							if ($permissoes["permissoes_convite"] > 0) { ?>
                  <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                              href="javascript:void(0)" aria-expanded="false"><img
                                  src="imgs/icons/icones-revisados-17.png"
                                  width="25px"/><span class="hide-menu convite"
                                                      style="margin-left: 7px;">Arte Final </span></a>
                      <ul aria-expanded="false" class="collapse  first-level">
                          <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                      aria-expanded="false"><i style="margin-left:15px;"
                                                                               class="mdi mdi-plus-circle-outline"></i>
                                  <span class="hide-menu">Arquivos de Convite</span></a>
                              <ul aria-expanded="false" class="collapse second-level">
																<?php
																$sql_permissao_item_112 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '112' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_fetch_array($sql_permissao_item_112)[0] > 0) {
																	?>
                                    <li class="sidebar-item"><a href="afConvite_dados.php"
                                                                class="sidebar-link"><i
                                                    class="mdi mdi-arrow-right-bold-circle"
                                                    style="margin-left:30px;"></i><span
                                                    class="hide-menu"> Comissão </span></a></li>
																<?php } ?>
																<?php
																$sql_permissao_item_99 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '99' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_fetch_array($sql_permissao_item_99)[0] > 0) {
																	?>
                                    <li class="sidebar-item"><a href="afConvite_arquivos.php"
                                                                class="sidebar-link"><i
                                                    class="mdi mdi-arrow-right-bold-circle"
                                                    style="margin-left:30px;"></i><span
                                                    class="hide-menu"> Formandos </span></a></li>
																<?php } ?>
                              </ul>
                          </li>
                          <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                      aria-expanded="false"><i style="margin-left:15px;"
                                                                               class="mdi mdi-plus-circle-outline"></i>
                                  <span class="hide-menu">Aprovação Produtos <br> Convite</span></a>
                              <ul aria-expanded="false" class="collapse second-level">
																<?php
																$sql_permissao_item_94 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '94' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_fetch_array($sql_permissao_item_94)[0] > 0) {
																	?>
                                    <li class="sidebar-item"><a href="afConvite_contrato.php"
                                                                class="sidebar-link"><i
                                                    style="margin-left:30px;"
                                                    class="mdi mdi-arrow-right-bold-circle"></i><span
                                                    class="hide-menu">Comissão </span></a>
                                    </li>
																<?php } ?>
																<?php
																$sql_permissao_item_64 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '64' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_fetch_array($sql_permissao_item_64)[0] > 0) {
																	?>
                                    <li class="sidebar-item"><a href="afConvite_formandos.php"
                                                                class="sidebar-link"><i
                                                    style="margin-left:30px;"
                                                    class="mdi mdi-arrow-right-bold-circle"></i><span
                                                    class="hide-menu">Formandos </span></a>
                                    </li>
																<?php } ?>
                              </ul>
                          </li>
                          <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                      aria-expanded="false"><i style="margin-left:15px;"
                                                                               class="mdi mdi-plus-circle-outline"></i>
                                  <span class="hide-menu">Relatórios</span></a>
                              <ul aria-expanded="false" class="collapse second-level">
															  <?php
																$sql_permissao_item_132 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '132' and id_usuario = '$_SESSION[id]' and listar = '2'");
																if (mysqli_fetch_array($sql_permissao_item_132)[0] > 0) {
																	?>
                                    <li class="sidebar-item"><a href="convite_relatorioCompraProduto.php"
                                                                class="sidebar-link"><i
                                                    class="mdi mdi-arrow-right-bold-circle"
                                                    style="margin-left:30px;"></i><span
                                                    class="hide-menu"> Relatório de Compra <br> de Produtos</span></a>
                                    </li>
																<?php } ?>
                              </ul>
                          </li>
                          <li class="sidebar-item">
                              <a href="afConvite_digital.php"
                                  class="sidebar-link"><i
                                  style="margin-left:15px;"
                                  class="mdi mdi-arrow-right-bold-circle"></i><span
                                  class="hide-menu"> Convite Digital </span></a>
                          </li>
                          <li class="sidebar-item"><a href="tarefas.php?departamento=13"
                                                      class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Tarefas </span></a>
                          </li>
                          <li class="sidebar-item"><a href="pcp_departamento.php?departamento=13"
                                                      class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> PCP </span></a>
                          </li>
                          <li class="sidebar-item">
                              <a href="solenidades_qrcode.php"
                                  class="sidebar-link"><i
                                  style="margin-left:15px;"
                                  class="mdi mdi-arrow-right-bold-circle"></i><span
                                  class="hide-menu"> QR-code </span></a>
                          </li>
                      </ul>
                  </li>
							<?php }
							if ($permissoes["permissoes_producao"] > 0) { ?>
                  <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                               href="javascript:void(0)" aria-expanded="false"><img
                              src="imgs/icons/icones-revisados-29.png"
                              width="25px"/><span class="hide-menu producao"
                                                  style="margin-left: 7px;">Produção </span></a>
                  <ul aria-expanded="false" class="collapse  first-level">
							<?php } ?>
                <li class="sidebar-item"><a href="tarefas.php?departamento=16"
                                            class="sidebar-link"><i
                                style="margin-left:15px;"
                                class="mdi mdi-arrow-right-bold-circle"></i><span
                                class="hide-menu"> Tarefas </span></a>
                </li>
                            <li class="sidebar-item"><a href="pcp_departamento.php?departamento=16"
                                                        class="sidebar-link"><i
                                            style="margin-left:15px;"
                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                            class="hide-menu"> PCP </span></a>
                            </li>
                </ul>
                </li>
                            <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                        href="javascript:void(0)" aria-expanded="false"><img
                                            src="imgs/icons/icones-revisados-43.png"
                                            width="25px"/><span class="hide-menu producao"
                                                                style="margin-left: 7px;">Entrega </span></a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    <li class="sidebar-item"><a href="pcp_departamento.php?departamento=21"
                                                                class="sidebar-link"><i
                                                    style="margin-left:15px;"
                                                    class="mdi mdi-arrow-right-bold-circle"></i><span
                                                    class="hide-menu"> PCP </span></a>
                                    </li>
                                </ul>
                            </li>
						<?php } ?>
							<?php
							$sql_permissao_item_127 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '127' and id_usuario = '$_SESSION[id]' and listar = '2'");
							if (mysqli_fetch_array($sql_permissao_item_127)[0] > 0) {
								?>
							<?php } ?>
							<?php
							$sql_permissao_item_105 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '105' and id_usuario = '$_SESSION[id]' and listar = '2'");
							if (mysqli_fetch_array($sql_permissao_item_105)[0] > 0) {
								?>
                  <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                              href="listarfaq.php" aria-expanded="false"><img
                                  src="imgs/icons/icones-revisados-07.png"
                                  width="25px"/><span class="hide-menu" style="margin-left: 7px;">FAQ</span></a>
                  </li>
							<?php } ?>
							<?php
							$sql_permissao_item_41 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '41' and id_usuario = '$_SESSION[id]' and listar = '2'");
							if (mysqli_fetch_array($sql_permissao_item_41)[0] > 0) {
								?>
                  <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                              href="javascript:void(0)" aria-expanded="false"><img
                                  src="imgs/icons/icones-revisados-01.png"
                                  width="25px"/><span class="hide-menu producao"
                                                      style="margin-left: 7px;">Usuários </span></a>
                      <ul aria-expanded="false" class="collapse  first-level">
                          <li class="sidebar-item"><a href="usuarios.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Usuários </span></a></li>
                      </ul>
                  </li>
							<?php } ?>
							<?php
							$sql_permissao_item_126 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '126' and id_usuario = '$_SESSION[id]' and listar = '2'");
							if (mysqli_fetch_array($sql_permissao_item_126)[0] > 0) {
								?>
                  <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                              href="javascript:void(0)" aria-expanded="false"><img
                                  src="imgs/icons/icones-revisados-37.png"
                                  width="25px"/><span class="hide-menu producao"
                                                      style="margin-left: 7px;">Ajustes e Evoluções </span></a>
                      <ul aria-expanded="false" class="collapse  first-level">
                          <li class="sidebar-item"><a href="ajustes_evolucoes.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Ajustes e Evoluções </span></a></li>
                                          <li class="sidebar-item"><a href="relajusteseevolucoes.php" class="sidebar-link"><i
                                          style="margin-left:15px;"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                          class="hide-menu"> Relatório de Horas </span></a></li>
                      </ul>
                  </li>
							<?php } ?>
							<?php
							$sql_permissao_item_95 = mysqli_query($con, "select count(*) from paginas_permissoes where id_pagina = '95' and id_usuario = '$_SESSION[id]' and listar = '2'");
							if (mysqli_fetch_array($sql_permissao_item_95)[0] > 0) {
								?>
                  <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                              href="backup.php" aria-expanded="false"><img
                                  src="imgs/icons/icones-revisados-03.png"
                                  width="25px"/><span class="hide-menu" style="margin-left: 7px;">Backup</span></a>
                  </li>
							<?php } ?>
                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                            href="sair.php"
                                            aria-expanded="false"><img src="imgs/icons/icones-revisados-23.png"
                                                                       width="25px"/><span
                                class="hide-menu" style="margin-left: 7px;">Sair</span></a></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>