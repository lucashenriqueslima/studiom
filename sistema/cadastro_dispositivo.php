<?php
include "../includes/conexao.php";
session_start();
$id_pagina = 128;
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
		$id_formando = $_GET['id_formando'];
		$sql_produto = mysqli_query($con, "select * from venda_avulsa");
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
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                padding-top: 100px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }
                
            .modal-content {
                position: relative;
                top: 50%;
                transform: translateY(-50%); 
                background-color: #fefefe;
                margin: auto;
                padding: 0;
                
                border: 1px solid #888;
                
                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
                -webkit-animation-name: animatetop;
                -webkit-animation-duration: 0.4s;
                animation-name: animatetop;
                animation-duration: 0.4s
                }

                .close:hover,
                .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
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
<!--                          <h4 class="page-title">Administrativo</h4>-->
                          <div class="d-flex align-items-center">
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item">Cadastros</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Dispositivos</li>
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
<!--                                  <h4 class="card-title">HDs</h4>-->
																
																<?php if ($vetor_permissao['cadastro'] == 1) {
																}else { ?><a href="cadastrar_dispositivo.php">
                                    <button type="button" class="btn waves-effect waves-light btn-warning">Novo Dispositivo
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
                                              <th >Código</th>
                                              <th>Dispositivo</th>
                                              <th>Tipo de Dispositivo</th>
                                              <th>Tamanho</th>
                                              <th>Marca</th>
                                              <th>N° Serie</th>

                                              <th width="13%">Ação</th>
                                          </tr>
                                          </thead>
                                          <tbody>
																					<?php
																					$sql_atual = mysqli_query($con, "select * from dispositivos order by id_dispositivo ASC");
																					while ($vetor = mysqli_fetch_array($sql_atual)) {
																						
																						?>
                                              <tr>
                                                  <td>STM <?php echo $vetor['id_dispositivo']; ?></td>
                                                  <td><?php echo $vetor['dispositivo']; ?></td>
                                                  <td><?php echo $vetor['tipoDispositivo']; ?></td>
                                                  <td><?php echo $vetor['tamanhoDispositivo']; ?></td>
                                                  <td><?php echo $vetor['marcaDispositivo']; ?></td>
                                                  <td><?php echo $vetor['nserieDispositivo']; ?></td>
                                                  
                                                  <td><a class="fancybox fancybox.ajax"
                                                         href="alterardispositivo.php?id=<?php echo $vetor['id_dispositivo']; ?>"
                                                         target="_blank">
                                                          <button type="button" class="btn btn-success mesmo-tamanho"
                                                                  title="Ver ou Alterar Cadastro"><i
                                                                      class="mdi mdi-tooltip-edit"></i></button>
                                                      </a>
                                                      <a class="fancybox fancybox.ajax">                                
                                                            <button type="button" class="inserirNF btn btn-success mesmo-tamanho" id="inserirNF<?= $vetor['id_dispositivo']?>"   
                                                                    title="Adicionar Nota Fiscal">
                                                                    <i class="mdi mdi-cloud-upload"></i>  
                                                            </button> 
                                                        </a> 
                                                        <a class="fancybox fancybox.ajax">                               
                                                            <button type="button" class="inserirCG btn btn-success mesmo-tamanho" id="inserirCG<?= $vetor['id_dispositivo']?>"   
                                                                    title="Adicionar Certificado de Garantia">
                                                                    <i class="mdi mdi-cloud-upload"></i> 
                                                            </button>
                                                        </a>
                                                      <?php if ($vetor_permissao['exclusao'] == 1) {
																										}else { ?><a class="fancybox fancybox.ajax"
                                                                 href="confexcluirDispositivo.php?id=<?php echo $vetor['id_dispositivo']; ?>">
                                                              <button type="button" class="btn btn-danger mesmo-tamanho"
                                                                      title="Excluir Cadastro"><i
                                                                          class="mdi mdi-window-close"></i></button>
                                                          </a><?php } ?>

                                                         
                                                    </td>
                                              </tr>
                                              <!--- Modal -->                                        
                                                                    <!-- Inserir Nota Fiscal -->
                                                                    <div id="myModalNF<?= $vetor['garantiaDispositivo']?>" class="modalNF<?= $vetor['garantiaDispositivo']?> modal">
                                                                    <div class="modal-content col-4">
                                                                        <form action="recebe_nfgarantiaDispositivo.php?tipo=1" method="post" 
                                                                            enctype="multipart/form-data">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Inserir Nota Fiscal</h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div>
                                                                                        <input class="custom-file-input" type="file" name="nf[]"
                                                                                                id="arquivoNF" required>
                                                                                        <label class="custom-file-label" id="labelarquivonf"
                                                                                                for="arquivo">Selecione a Nota Fiscal</label>
                                                                                    </div>
                                                                                    <div>
                                                                                        <?php if ($vetor['nfDispositivo'] != '') {
                                                                                            # code...
                                                                                        ?>
                                                                                        <a href="<?php echo $vetor['nfDispositivo'];?>" target="_blank">Baixar Nota Fiscal</a>
                                                                                        <?php }?>
                                                                                    </div>
                                                                                    <div class="col-lg-12" name="hide" style="display:none;">
                                                                                        <fieldset class="form-group">
                                                                                            
                                                                                            <input id="id_dispositivonf" name="id_dispositivonf" type="text" value="<?php echo $vetor['id_dispositivo'];?>">
                                                                                        </fieldset>
                                                                                    </div>
                                                                                    <div>
                                                                                      
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                <a 
                                                                                        href="recebe_nfgarantiaDispositivo.php?idnf=<?php echo $vetor['id_dispositivo'];?>">
                                                                                    <button type="button"
                                                                                            class="btn btn-danger mesmo-tamanho"
                                                                                            title="Excluir Convite">Excluir
                                                                                    </button></a>
                                                                                                                                                                
                                                                                <button type="submit" class="btn btn-primary" style="    float: left;">Cadastrar
                                                                                </button>
                                                                                <button type="button" class="btn btn-secondary"
                                                                                        data-dismiss="modal" id="fecharNF<?php echo $vetor['id_dispositivo'];?>">Fechar
                                                                                </button>
                                                                                </div>                
                                                                        </form>
                                                                        </div> 
                                                                    </div>
                                                                    
                                                                   
                                                                    <!-- Modal -->    
                                                                    <!-- Inserir Certificado de Garantia -->
                                                                    <div id="myModalCG<?= $vetor['garantiaDispositivo']?>" class="modalCG<?= $vetor['garantiaDispositivo']?> modal">
                                                                    <div class="modal-content col-4">
                                                                    <form action="recebe_nfgarantiaDispositivo.php?tipo=2" method="post" 
                                                                            enctype="multipart/form-data">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Inserir Certificado de Garantia</h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div>
                                                                                        <input class="custom-file-input" type="file" name="cg[]"
                                                                                                id="arquivoCG" required>
                                                                                        <label class="custom-file-label" id="labelarquivocg"
                                                                                                for="arquivo">Selecione o Certificado de Garantia</label>
                                                                                    </div>
                                                                                    <div>
                                                                                        <?php if ($vetor['garantiaDispositivo'] != '') {
                                                                                            # code...
                                                                                        ?>
                                                                                        <a href="<?= $vetor['garantiaDispositivo']?>" target="_blank">Baixar Certificado de Garantia</a>
                                                                                        <?php }?>
                                                                                    </div>
                                                                                    <div class="col-lg-12" name="hide" style="display:none;">
                                                                                        <fieldset class="form-group">
                                                                                            
                                                                                            <input id="id_dispositivocg" name="id_dispositivocg" type="text" value="<?php echo $vetor['id_dispositivo'];?>">
                                                                                        </fieldset>
                                                                                    </div>
                                                                                    <div>
                                                                                      
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                <a class="fancybox fancybox.ajax"
                                                                                        href="recebe_nfgarantiaDispositivo.php?idcg=<?php echo $vetor['id_dispositivo'];?>">
                                                                                    <button type="button"
                                                                                            class="btn btn-danger mesmo-tamanho"
                                                                                            title="Excluir Convite">Excluir
                                                                                    </button></a>
                                                                                                                                                                
                                                                                <button type="submit" class="btn btn-primary" style="    float: left;">Cadastrar
                                                                                </button>
                                                                                <button type="button" class="btn btn-secondary"
                                                                                        data-dismiss="modal" id="fecharCG<?php echo $vetor['id_dispositivo'];?>">Fechar
                                                                                </button>
                                                                                </div>            
                                                                        </form> 
                                                                        </div>                    
                                                                        </div>   

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
        <?php 
            $sql_atual = mysqli_query($con, "select * from dispositivos order by id_dispositivo ASC");
            while ($vetor = mysqli_fetch_array($sql_atual)) {
        ?>
        <script>  
        

            // Get the modal NF
            var modalNF = document.getElementById("myModalNF<?= $vetor['garantiaDispositivo']?>");

            // Get the button that opens the modal
            var btnNF = document.getElementById("inserirNF<?= $vetor['id_dispositivo']?>");

            // Get the <span> element that closes the modal
            var spanNF = document.getElementById("fecharNF<?php echo $vetor['id_dispositivo'];?>");

            // When the user clicks the button, open the modal 
            btnNF.onclick = function() {
                modalNF.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            spanNF.onclick = function() {
                modalNF.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
            if (event.target == modalNF) {
                modalNF.style.display = "none";
            }
            }


            // Get the modal CG
            var modalCG = document.getElementById("myModalCG<?= $vetor['garantiaDispositivo']?>");

            // Get the button that opens the modal
            var btnCG = document.getElementById("inserirCG<?= $vetor['id_dispositivo']?>");

            // Get the <span> element that closes the modal
            var spanCG = document.getElementById("fecharCG<?php echo $vetor['id_dispositivo'];?>");

            // When the user clicks the button, open the modal 
            btnCG.onclick = function() {
                modalCG.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            spanCG.onclick = function() {
                modalCG.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
            if (event.target == modalCG) {
                modalCG.style.display = "none";
            }
            }
        </script>
        <?php
            }                                                                                    
        ?>
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
      <script>
                
            /**$(".inserirNF").click(function() {
                var divcg = document.querySelector('.divCG');
                var divnf = document.querySelector('.divNF');
                
                //$('.divNF').show();
                //$('.divCG').hide();
                //divnf.style.visibility = 'visible';
                //divcg.style.visibility = 'hidden';         
            });*/

           
      </script>
      <script>
          
         
           /**$(".inserirCG").click(function() {
                var divnf = document.querySelector('.divNF');
                var divcg = document.querySelector('.divCG');

                //$('.divNF').hide();
                //$('.divCG').show();
                //divcg.style.visibility = 'visible';
                //divnf.style.visibility = 'hidden';         
            });*/
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