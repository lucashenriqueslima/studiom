
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
                  <div class="user-pic"><img src="../sistema/arquivos/<?=$vetor_turma['logo']?>" alt="turma" class="rounded-circle" width="40"/>
                  </div>
                </div>
                <!-- End User Profile-->
              </li>

              
              <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-content-copy cadastrosgerais"></i><span
                                class="hide-menu">Solicitações </span></a>
                               
                <ul aria-expanded="false" class="collapse  first-level">
                  <?php
                  if ($vetor_turma['tipo'] != 2) {              
                  ?>
                  <li class="sidebar-item"><a href="solicitacaoeventos.php" class="sidebar-link" > <i class="mdi mdi-arrow-right-bold-circle nav_icon" style="margin-left:15px;"></i><span
                                  class="hide-menu">Eventos</span></a></li>
                  <?php }if ($vetor_turma['tipo'] != 1) {?>                                 
                  <li  class="sidebar-item"><a href="solicitacaoartes.php" class="sidebar-link"><i class="mdi mdi-arrow-right-bold-circle nav_icon" style="margin-left:15px;"></i><span
                                  class="hide-menu">Artes</span></a></li>
                  <?php }?>  
                </ul>

              </li>
              

              <li  class="sidebar-item ">

                  <a href="docscomissao.php" class="sidebar-link"><i class="fa fa-archive cadastrosgerais"></i> <span class="hide-menu">Doc's Comissão</span> </a>

              </li>
              <?php
              if ($vetor_turma['tipo'] != 1) {              
              ?>
              <li  class="sidebar-item">

                  <a href="dadosconvite.php" class="sidebar-link" ><i class="mdi mdi-content-duplicate"></i> <span class="hide-menu">Arquivos de Convite</span> </a>

              </li>
              <?php }?>
              <li  class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                  href="javascript:void(0)" aria-expanded="false"><i 
                                  class="  fas fa-comment-dots "></i> <span 
                                  class="hide-menu">Interações</span></a>
                  
                  <ul aria-expanded="false" class="collapse  first-level">
                      <li  class="sidebar-item"><a href="interacoescontrato.php" class="sidebar-link"> <i class="mdi mdi-arrow-right-bold-circle nav_icon" style="margin-left:15px;"></i><span
                                class="hide-menu">Contrato</span></a></li>
                                                  
                      <li  class="sidebar-item"><a href="interacoesformandos.php" class="sidebar-link"><i class="mdi mdi-arrow-right-bold-circle nav_icon" style="margin-left:15px;"></i><span
                                class="hide-menu">Formando</span></a></li>

                  
                  </ul>

              </li>

              

             <li  class="sidebar-item ">
                <a class="sidebar-link "  onClick="window.open('calendario.php', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, WIDTH=1200, HEIGHT=700');">
                        <i class="icon-calender"></i><span class="hide-menu">Calendário</span></a>

              </li>

              <li  class="sidebar-item"><a  class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i class="fas fa-file"></i> <span 
                                class="hide-menu">Relatórios</span><span class="fa arrow"></span></a>
                  
                  <ul aria-expanded="false" class="collapse  first-level">
                      
                      <li  class="sidebar-item"><a href="relcadastros.php" class="sidebar-link"><i class="mdi mdi-arrow-right-bold-circle nav_icon" style="margin-left:15px;"></i><span
                                class="hide-menu">Cadastros</span></a></li>

                      <li  class="sidebar-item"><a href="relvendas.php" class="sidebar-link"><i class="mdi mdi-arrow-right-bold-circle nav_icon" style="margin-left:15px;"></i><span
                                class="hide-menu">Compras</span></a></li>

                      <li  class="sidebar-item"><a href="relaprovacaoconvites.php" class="sidebar-link"><i class="mdi mdi-arrow-right-bold-circle nav_icon" style="margin-left:15px;"></i><span
                                class="hide-menu">Aprovações de Convites</span></a></li>

                      <li  class="sidebar-item"><a href="relarquivoconvites.php"class="sidebar-link" ><i class="mdi mdi-arrow-right-bold-circle nav_icon" style="margin-left:15px;"></i><span
                                class="hide-menu">Arquivo de convites</span></a></li>

                  
                  </ul>

              </li>

              <?php 

              $sql_convite_ap = mysqli_query($con, "select * from meu_convite_turma where id_turma = '$vetor_cadastro[turma]'");
              $vetor_convite_ap = mysqli_fetch_array($sql_convite_ap);

              if(mysqli_num_rows($sql_convite_ap) > 0) { ?>

              <li  class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                      href="javascript:void(0)" aria-expanded="false"><i 
                      class="far fa-sticky-note nav_icon"></i> <span 
                      class="hide-menu">Convite</span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                  <li  class="sidebar-item"><a href="meuconvite.php" class="sidebar-link"><i class="mdi mdi-arrow-right-bold-circle nav_icon" style="margin-left:15px;"></i><span 
                          class="hide-menu">Aprovações</span></a></li>
                </ul>
            
              </li>

              
              <?php } ?>

              <li  class="sidebar-item">

                  <a href="sair.php" class="sidebar-link"><i class="mdi mdi-directions"></i> <span class="hide-menu">Sair</span> </a>

              </li>

                      <div class="modal fade" id="modal-default">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title">Calendário</h4>
                            </div>
                            <div class="modal-body">
                              <p>Carregando...</p>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>