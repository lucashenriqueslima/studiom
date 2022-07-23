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
                        <div class="user-pic"><img src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"
                                                   alt="users" class="rounded-circle" width="40"/>
                        </div>

                    </div>
                    <!-- End User Profile-->
                </li>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-content-copy cadastrosgerais"></i><span
                                class="hide-menu">Meu Cadastro </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="meucadastro.php" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Cadastro </span></a></li>
                        <li class="sidebar-item"><a href="alterarsenha.php" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Alterar Senha </span></a>
                        </li>
                        <li class="sidebar-item"><a href="editarfoto.php" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Editar Foto </span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                            href="meuscontratos.php" aria-expanded="false"><i
                                class="mdi mdi-archive"></i><span class="hide-menu">Meus Doc's</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                            href="minhascompras.php" aria-expanded="false"><i
                                class="mdi mdi-basket"></i><span class="hide-menu">Minhas Compras</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                            href="meufinanceiro.php" aria-expanded="false"><i
                                class="mdi mdi-square-inc-cash"></i><span class="hide-menu">Meu Financeiro</span></a>
                </li>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-camera"></i><span class="hide-menu">Minhas Fotos </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="preeventos.php" class="sidebar-link"><i
                                        style="margin-left:15px;"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Pré-Eventos </span></a></li>
                        <li class="sidebar-item"><a href="eventos.php" class="sidebar-link">
                                <i style="margin-left:15px;"
                                   class="mdi mdi-arrow-right-bold-circle"></i><span
                                        class="hide-menu"> Eventos </span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                            href="meuperfilfotografico.php" aria-expanded="false"><i
                                class="mdi mdi-camera-front-variant"></i><span
                                class="hide-menu">Meu Perfil Fotográfico</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-camera-enhance"></i><span class="hide-menu">Escolha de Fotos </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i><span
                                        class="hide-menu">Produtos Fotografia</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
															<?php
															$sql_produtos_contrato = mysqli_query($con, "select * from vendas where id_formando = '$_SESSION[id_formando]' and tipo = '2' and iniciada = '2'");
															while ($vetor_produtos_contrato = mysqli_fetch_array($sql_produtos_contrato)) {
																$sql_pacotes1 = mysqli_query($con, "select * from pacotes_itens_album where id_item = '$vetor_produtos_contrato[id_pacote]'");
																$vetor_pacotes1 = mysqli_fetch_array($sql_pacotes1);
																$sql_produtos = mysqli_query($con, "select * from pacotes_itens_produtos where id_pacote = '$vetor_pacotes1[id_item]'");
																while ($vetor_produto_final = mysqli_fetch_array($sql_produtos)) {
																	$sql_produto_item = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '$vetor_produto_final[id_produto]' and escolha = '2'");
																	$vetor_produto_item = mysqli_fetch_array($sql_produto_item);
																	if (mysqli_num_rows($sql_produto_item) > 0) {
																		if ($vetor_produtos_contrato['formapag'] == 3 || $vetor_produtos_contrato['formapag'] == 6 || $vetor_produtos_contrato['formapag'] == 7 || $vetor_produtos_contrato['formapag'] == 3 || $vetor_produtos_contrato['formapag'] == 14 || $vetor_produtos_contrato['formapag'] == 15) {
																			if ($vetor_produtos_contrato['pagamento'] == 1) {
																				?>
                                          <li class="sidebar-item"><a
                                                      href="listarescolhafotos.php?id=<?php echo $vetor_produto_item['id_tipo']; ?>"
                                                      class="sidebar-link"><i style="margin-left:30px"
                                                                              class="mdi mdi-arrow-right-bold-circle"></i><span
                                                          class="hide-menu"><?php echo $vetor_produto_item['nome']; ?></span></a>
                                          </li>
																			
																			<?php }
																		}else { ?>

                                        <li class="sidebar-item"><a
                                                    href="listarescolhafotos.php?id=<?php echo $vetor_produto_item['id_tipo']; ?>"
                                                    class="sidebar-link"><i style="margin-left:30px"
                                                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                                        class="hide-menu"><?php echo $vetor_produto_item['nome']; ?></span></a>
                                        </li>
																			<?php
																		}
																	}
																}
															}
															$sql_produtos_contrato = mysqli_query($con, "select * from vendas where id_formando = '$_SESSION[id_formando]' and tipo = '3'");
															while ($vetor_produtos_contrato = mysqli_fetch_array($sql_produtos_contrato)) {
																$sql_pacotes1 = mysqli_query($con, "select * from pacotes_itens_album where id_item = '$vetor_produtos_contrato[id_pacote]'");
																$vetor_pacotes1 = mysqli_fetch_array($sql_pacotes1);
																$sql_produtos = mysqli_query($con, "select * from venda_avulsa_produtos where id_avulsa = '$vetor_produtos_contrato[produto]'");
																while ($vetor_produto_final = mysqli_fetch_array($sql_produtos)) {
																	$sql_produto_item = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '$vetor_produto_final[id_item]' and escolha = '2'");
																	$vetor_produto_item = mysqli_fetch_array($sql_produto_item);
																	if (mysqli_num_rows($sql_produto_item) > 0) {
																		?>
                                      <li class="sidebar-item"><a
                                                  href="listarescolhafotos.php?id=<?php echo $vetor_produto_item['id_tipo']; ?>"
                                                  class="sidebar-link"><i style="margin-left:30px"
                                                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                                      class="hide-menu"> <?php echo $vetor_produto_item['nome']; ?></span></a>
                                      </li>
																	<?php }
																}
															} ?>
                            </ul>
                        </li>
                        <li class="sidebar-item"><a href="listarconviteexclusive.php" class="sidebar-link"><i
                                        style="margin-left:15px"
                                        class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Produtos Convite </span></a>
                        </li>
                        <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i><span
                                        class="hide-menu">Top Fotos</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
                                <li class="sidebar-item"><a href="escolhadefotospreevento.php" class="sidebar-link"><i
                                                style="margin-left:30px"
                                                class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu">Pré-Evento</span></a>
                                </li>
                                <li class="sidebar-item"><a href="escolhafotoeventos.php" class="sidebar-link"><i
                                                style="margin-left:30px"
                                                class="mdi mdi-arrow-right-bold-circle"></i><span
                                                class="hide-menu">Eventos</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
							<?php
							$sql_produtos_convite1 = mysqli_query($con, "select * from vendas where id_formando = '$_SESSION[id_formando]' and tipo = '1' and iniciada = '2' and aceite = '2'");
							if (mysqli_num_rows($sql_produtos_convite1) > 0) { ?>
                  <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                              href="dadosconvite.php" aria-expanded="false"><i
                                  class="mdi mdi-content-duplicate"></i><span
                                  class="hide-menu">Arquivos de Convite</span></a></li>
							<?php } ?>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-checkbox-marked-outline"></i><span
                                class="hide-menu">Aprovações </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a class="has-arrow sidebar-link" href="javascript:void(0)"
                                                    aria-expanded="false"><i style="margin-left:15px;"
                                                                             class="mdi mdi-plus-circle-outline"></i><span
                                        class="hide-menu">Produtos Fotografia</span></a>
                            <ul aria-expanded="false" class="collapse second-level">
															<?php
															$sql_produtos_contrato = mysqli_query($con, "select * from vendas where id_formando = '$_SESSION[id_formando]' and tipo = '2' and iniciada = '2'");
															while ($vetor_produtos_contrato = mysqli_fetch_array($sql_produtos_contrato)) {
																$sql_pacotes1 = mysqli_query($con, "select * from pacotes_itens_album where id_item = '$vetor_produtos_contrato[id_pacote]'");
																$vetor_pacotes1 = mysqli_fetch_array($sql_pacotes1);
																$sql_produtos = mysqli_query($con, "select * from pacotes_itens_produtos where id_pacote = '$vetor_pacotes1[id_item]'");
																while ($vetor_produto_final = mysqli_fetch_array($sql_produtos)) {
																	$sql_produto_item = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '$vetor_produto_final[id_produto]'");
																	$vetor_produto_item = mysqli_fetch_array($sql_produto_item);
																	if ($vetor_produtos_contrato['formapag'] == 3 || $vetor_produtos_contrato['formapag'] == 6 || $vetor_produtos_contrato['formapag'] == 7 || $vetor_produtos_contrato['formapag'] == 3 || $vetor_produtos_contrato['formapag'] == 14 || $vetor_produtos_contrato['formapag'] == 15) {
																		if ($vetor_produtos_contrato['pagamento'] == 1) {
																			?>
                                        <li class="sidebar-item"><a
                                                    href="meualbum.php?id=<?php echo $vetor_produto_item['id_tipo']; ?>"
                                                    class="sidebar-link"><i style="margin-left:30px"
                                                                            class="mdi mdi-arrow-right-bold-circle"></i><span
                                                        class="hide-menu"> <?php echo $vetor_produto_item['nome']; ?></span></a>
                                        </li>
																		<?php }
																	}else { ?>
                                      <li class="sidebar-item"><a
                                                  href="meualbum.php?id=<?php echo $vetor_produto_item['id_tipo']; ?>"
                                                  class="sidebar-link"><i style="margin-left:30px"
                                                                          class="mdi mdi-arrow-right-bold-circle"></i><span
                                                      class="hide-menu"> <?php echo $vetor_produto_item['nome']; ?></span></a>
                                      </li>
																		<?php
																	}
																}
															}
															$sql_produtos_contrato = mysqli_query($con, "select * from vendas where id_formando = '$_SESSION[id_formando]' and tipo = '3'");
															while ($vetor_produtos_contrato = mysqli_fetch_array($sql_produtos_contrato)) {
																$sql_pacotes1 = mysqli_query($con, "select * from pacotes_itens_album where id_item = '$vetor_produtos_contrato[id_pacote]'");
																$vetor_pacotes1 = mysqli_fetch_array($sql_pacotes1);
																$sql_produtos = mysqli_query($con, "select * from venda_avulsa_produtos where id_avulsa = '$vetor_produtos_contrato[produto]'");
																while ($vetor_produto_final = mysqli_fetch_array($sql_produtos)) {
																	$sql_produto_item = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '$vetor_produto_final[id_item]'");
																	$vetor_produto_item = mysqli_fetch_array($sql_produto_item);
																	?>
                                    <li class="sidebar-item"><a
                                                href="meualbum.php?id=<?php echo $vetor_produto_item['id_tipo']; ?>"
                                                class="sidebar-link"><i style="margin-left:30px"
                                                                        class="mdi mdi-arrow-right-bold-circle"></i><span
                                                    class="hide-menu"> <?php echo $vetor_produto_item['nome']; ?></span></a>
                                    </li>
																<?php }
															} ?>
                            </ul>
                        </li>
											<?php
											$sql_produtos_convite = mysqli_query($con, "select * from vendas where id_formando = '$_SESSION[id_formando]' and tipo = '1' and iniciada = '2' and aceite = '2'");
											if (mysqli_num_rows($sql_produtos_convite) > 0) {
												?>
                          <li class="sidebar-item"><a href="meuconvite.php" class="sidebar-link"><i
                                          style="margin-left:15px"
                                          class="mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu"> Produtos Convite </span></a>
                          </li>
											<?php } ?>
                    </ul>
                </li>
                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                            href="topfotos.php" aria-expanded="false"><i
                                class="mdi mdi-book-multiple-variant"></i><span class="hide-menu">Top Fotos</span></a>
                </li>
                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                            href="meuarquivodigital.php" aria-expanded="false"><i
                                class="mdi mdi-burst-mode"></i><span class="hide-menu">Arquivo Digital</span></a></li>
							<?php
							$sql_album_virtual = mysqli_query($con, "select * from album_virutal where id_formando = '$vetor_cadastro[id_formando]'");
							$vetor_album_virtual = mysqli_fetch_array($sql_album_virtual);
							if (mysqli_num_rows($sql_album_virtual) > 0) {
								?>
                  <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                              href="../sistema/arquivos/album_virtual/<?php echo $vetor_album_virtual['arquivo']; ?>"
                                              aria-expanded="false" target="_blank"><i
                                  class="mdi mdi-book-open-page-variant"></i><span
                                  class="hide-menu">Álbum virtual</span></a></li>
							<?php }else { ?>
                  <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link" href="#"
                                              aria-expanded="false" title="Etapa ainda não disponível"><i
                                  class="mdi mdi-book-open-page-variant"></i><span
                                  class="hide-menu">Álbum virtual</span></a></li>
							<?php } ?>
                <?php
                $sql = mysqli_query($con,"select * from formandos where id_formando='$_SESSION[id_formando]' and convite_digital is not NULL");
                if(mysqli_num_rows($sql) > 0){
                    $vetor = mysqli_fetch_array($sql);
                    ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../sistema/arquivos/<?php echo $vetor['convite_digital']; ?>"
                           aria-expanded="false" title="Etapa ainda não disponível" target="_blank"><i
                                    class="mdi mdi-cloud-print-outline"></i><span
                                    class="hide-menu">Convite Digital</span>
                        </a>
                    </li>
                <?php } ?>
                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link" href="sair.php"
                                            aria-expanded="false"><i class="mdi mdi-directions"></i><span
                                class="hide-menu">Sair</span></a></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>