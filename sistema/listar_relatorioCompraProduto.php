<?php
include "../includes/conexao.php";
session_start();
$id_pagina = 129;
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
  

    $idturma = $_POST['id_turma'];

    $sql_turma = mysqli_query($con, "select ncontrato, ano, id_instituicao, curso from turmas where id_turma = '$idturma'");
    $vetorturma = mysqli_fetch_array($sql_turma);  

    $sql_instituicao_inicio = mysqli_query($con, "select nome from instituicoes where id_instituicao = '$vetorturma[id_instituicao]'");
    $vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

    $sql_curso = mysqli_query($con, "select nome from cursos where id_curso = '$vetorturma[curso]'");
    $vetor_curso = mysqli_fetch_array($sql_curso); 

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
                          <!--                          <h4 class="page-title">Arte Final - Fotografia</h4>-->
                          <div class="d-flex align-items-center">
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item">Fotografia</a></li>
                                      <li class="breadcrumb-item">Relatório</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Relatório de Compra de Produtos</li>
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
                                  <!-- <h4 class="card-title">Pré-Eventos</h4>-->
                                  <div class="form-group col-lg-12 col-md-12 col-sm-12 "
                                             style="margin-bottom: 0px !important;"> 
                                            <div class="row">
                                                <div class="col">
                                                    <label for="dob" style="float: right !important; margin-right: 0px !important;">Relatório de Compra de Produto(s): 
                                                      <button type="button" id="escolherPapel" data-toggle="modal" data-target="#modalEscolherPapel"
                                                            class="btn btn-primary mesmo-tamanho"
                                                            title="Relatório de Compra de Produto(s)"><i
                                                            class="fa fa-print"></i>
                                                                                
                                                                                    
                                                      </button>
                                                    </label>
                                                </div>
                                            </div>
                                  </div>
                                  

                                  <?php $sql_atual = mysqli_query($con, "select f.id_formando as id_formando, t.ncontrato as ncontrato, f.id_cadastro as codformando, to2.nome as produto, pip.qtdpaginas as qtdpaginas from pacotes_itens_produtos pip 
                                            left join tipo_opcionais to2 on to2.id_tipo = pip.id_produto 
                                            left join vendas v on v.id_pacote = pip.id_pacote 
                                            left join formandos f on f.id_formando = v.id_formando
                                            left join turmas t on t.id_turma = f.turma 
                                            where t.id_turma = $idturma order by to2.nome ASC");

                                            
                                            while ($vetor = mysqli_fetch_array($sql_atual)) {
                                              $vetorprodutos[] = $vetor['produto'];
                                            }
                                            $vetorprodutos = array_unique($vetorprodutos);

                                        $sql_atual = mysqli_query($con, "select f.id_formando as id_formando, t.ncontrato as ncontrato, f.id_cadastro as codformando, to2.nome as produto, pip.qtdpaginas as qtdpaginas from pacotes_itens_produtos pip 
                                            left join tipo_opcionais to2 on to2.id_tipo = pip.id_produto 
                                            left join vendas v on v.id_pacote = pip.id_pacote 
                                            left join formandos f on f.id_formando = v.id_formando
                                            left join turmas t on t.id_turma = f.turma 
                                            where t.id_turma = $idturma order by f.id_cadastro ASC");

                                            while ($vetor = mysqli_fetch_array($sql_atual)) {
                                              $vetorformando[] = $vetor['id_formando'];
                                            }
                                            $vetorformando = array_unique($vetorformando);

                                            
                                      ?>
  
                                      
                                      <br><br>              
                                      <table width="100%">
                                        
                                        <tr>
                                        <td width="100%" style="text-align: right;"><b> Contrato n° <?= $vetorturma['ncontrato'] ?> </b></td>
                                        </tr>

                                      </table>
                                      <br>

                                      <div align="center">
                                        <h4><strong>Relatório de Compra de Produto(s)</strong></h4>
                                        <h4><?= $vetorturma['ncontrato'].' - '.$vetor_curso['nome'].' '.$vetor_instituicao_inicio['nome'].' '.$vetorturma['ano'] ?></h4>
                                      </div> 
                                        <br>
                                        <div class="table-responsive">
        
                                        <table id="lang_opt" class="table table-striped table-bordered display"
                                             style="width:100%; text-align: center; " > 
                                          <thead>

                                            <th width="5%"></th>
                                            <th>Cód. Formando</th>
                                            <th>Formando</th> 
                                            <?php 
                                            foreach ($vetorprodutos as $vetorprodutos){
                                            ?> 
                                              <th><?php echo $vetorprodutos?></th>  
                                              <th>Qtd. Pag.</th>
                                            <?php } ?>

                                          </thead>
                                          <tbody>
                                          <?php 


                                          $i = 1;

                                          foreach($vetorformando as $vetorformando){  
                                              $sql_formando = mysqli_fetch_array(mysqli_query($con, "select t.ncontrato as ncontrato, f.id_formando, f.id_cadastro as codformando, f.nome as nomeformando from formandos f
                                              left join turmas t on t.id_turma = f.turma 
                                              where f.id_formando =  $vetorformando"));
                                          ?>
                                          
                                              <tr>
                                                
                                                <td><div align="center"><?php echo $i; ?></div></td>
                                                <td><?php echo $sql_formando['ncontrato'].'-'.$sql_formando['codformando']; ?></td>
                                                <td><?php echo $sql_formando['nomeformando']; ?></td>
                                                
                                                <?php
                                                  $sql_atualproduto = mysqli_query($con, "select f.id_formando as id_formando, t.ncontrato as ncontrato, f.id_cadastro as codformando, to2.nome as produto, pip.qtdpaginas as qtdpaginas from pacotes_itens_produtos pip 
                                                  left join tipo_opcionais to2 on to2.id_tipo = pip.id_produto 
                                                  left join vendas v on v.id_pacote = pip.id_pacote 
                                                  left join formandos f on f.id_formando = v.id_formando
                                                  left join turmas t on t.id_turma = f.turma 
                                                  where t.id_turma = $idturma order by to2.nome ASC");

                                                  
                                                  while ($vetorproduto = mysqli_fetch_array($sql_atualproduto)) {
                                                    
                                                    $vetorprodutoss[] = $vetorproduto['produto'];
                                                  }
                                                  
                                                  $vetorprodutos2 = array_unique($vetorprodutoss);



                                                  foreach($vetorprodutos2 as $vetorprodutos2){
                                                    $sql_qtd = mysqli_fetch_array(mysqli_query($con, "select distinct id_produto_item, CONCAT(pip.id_produto, '(',count(pip.id_produto_item),')') as qtd
                                                            from pacotes_itens_produtos pip 
                                                            left join tipo_opcionais to2 on to2.id_tipo = pip.id_produto 
                                                            left join vendas v on v.id_pacote = pip.id_pacote 
                                                            left join formandos f on f.id_formando = v.id_formando
                                                            left join turmas t on t.id_turma = f.turma 
                                                            where f.id_formando = $vetorformando and to2.nome = '$vetorprodutos2'"));

                                                    $sql_qtdpag = mysqli_fetch_array(mysqli_query($con, "select SUM(pip.qtdpaginas) as qtdpaginas from pacotes_itens_produtos pip 
                                                            left join tipo_opcionais to2 on to2.id_tipo = pip.id_produto 
                                                            left join vendas v on v.id_pacote = pip.id_pacote 
                                                            left join formandos f on f.id_formando = v.id_formando
                                                            left join turmas t on t.id_turma = f.turma 
                                                            where f.id_formando = $vetorformando and to2.nome = '$vetorprodutos2'"));

                                                    if (!isset($sql_qtd['qtd'])) {
                                                      $qtd = 0;
                                                    }else {
                                                      $produtoexp = explode("(",$sql_qtd['qtd']);  
                                                      $qtd = rtrim( $produtoexp[1],")" );
                                                    }

                                                    if (!isset($sql_qtdpag['qtdpaginas'])) {
                                                      $qtdpaginas = 0;
                                                    }else {
                                                      $qtdpaginas = $sql_qtdpag['qtdpaginas'];
                                                    }   
                                                    
                                                    

                                                ?>

                                                    <td><?php echo $qtd; ?></td>
                                                    <td><?php echo $qtdpaginas; ?></td>
                                                
                                                <?php } ?>
                                              
                                              </tr>
                                            
                                            <?php $i++; }

                                            while ($vetorproduto = mysqli_fetch_array($sql_atualproduto)) {
                                                    
                                              $vetorprodutoss[] = $vetorproduto['produto'];
                                            }
                                            
                                            $vetorprodutos2 = array_unique($vetorprodutoss);
                                            foreach($vetorprodutos2 as $vetorprodutos2){

                                              $sql_totalProduto = mysqli_num_rows(mysqli_query($con, "select f.nome   from pacotes_itens_produtos pip 
                                                    left join tipo_opcionais to2 on to2.id_tipo = pip.id_produto 
                                                          left join vendas v on v.id_pacote = pip.id_pacote 
                                                          left join formandos f on f.id_formando = v.id_formando
                                                          left join turmas t on t.id_turma = f.turma 
                                                          where t.id_turma = $idturma and to2.nome = '$vetorprodutos2'"));

                                                    $sql_totalQuantidade  = mysqli_fetch_array(mysqli_query($con, "select SUM(pip.qtdpaginas) as qtdpaginas from pacotes_itens_produtos pip 
                                                    left join tipo_opcionais to2 on to2.id_tipo = pip.id_produto 
                                                    left join vendas v on v.id_pacote = pip.id_pacote 
                                                    left join formandos f on f.id_formando = v.id_formando
                                                    left join turmas t on t.id_turma = f.turma 
                                                    where t.id_turma = $idturma and to2.nome = '$vetorprodutos2'"));


                                                    if (!isset($sql_totalProduto)) {
                                                      $vetorTotal[] = 0;
                                                    }else {
                                                      $vetorTotal[] = $sql_totalProduto;
                                                    }

                                                    if (!isset($sql_totalQuantidade['qtdpaginas'])) {
                                                      $vetorTotal[] = 0;
                                                    }else {
                                                      $vetorTotal[] = $sql_totalQuantidade['qtdpaginas'];
                                                    }   

                                            }
                                            
                                            ?>
                                          

                                          </tbody> 
                                          <tfoot style="background-color: black; color:#ffffff">
                                            <tr>
                                              <td colspan="3" style="text-align: center;">Totais:</td>
                                              
                                              <?php foreach($vetorTotal as $vetorTotal) { 
                                              ?>
                                              <td><?= $vetorTotal ?></td> 
                                              <?php
                                                }
                                              ?>      

                                            </tr>
                                          </tfoot>
                                        </table>
                                      </div>
                                                    
                                  </div>
                                  
                              </div>
                              
                               
                          </div>
                      </div>
                  </div>  

                  <!-- Modal -->
                  <div class="modal fade" id="modalEscolherPapel" tabindex="-1" role="dialog" aria-labelledby="modalEscolherPapelLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Escolha o Tamanho da Folha</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="gera_relatorioCompraProduto.php?turma=<?= $idturma?>" method="post" target="_blank">
                          <div class="modal-body" style="text-align: justify;">
                            <p>Verifique se o relatório possui mais que 9 produtos cadastrados. Caso tenha, teremos duas variáveis de impressão:</p>

                                                            <p>1 ) Impressão de Relatório em Formato A4</p>

                                                            <p>&emsp;&emsp;Produtos cadastrados maior que 9 unidades: divide a planilha em duas tabelas, sendo a 		segunda 	parte da tabela a continuação dos produtos da primeira. A disposição da tabela virá logo abaixo a sequência da primeira.</p>

                                                            <p>&emsp;&emsp;Produtos cadastrados maior que 18 unidades: divide a planilha em três tabelas, sendo a segunda e terceira parte da tabela, a continuação dos produtos da primeira. A disposição da tabela virá logo abaixo da sequência da primeira, segunda e terceira.</p>

                                                            <p>2 ) Impressão de Relatório em Formatos Maiores</p>

                                                            <p>&emsp;&emsp;A impressão do relatório em formatos maiores que o formato A4, com mais que 9 ou 18 produtos cadastrados para o contrato, faz com que a tabela não seja quebrada, podendo ser visualizada sequencialmente.<p>
                                                </p>
                            <select name="tamanhofolha" id="tamanhofolha" class="form-control" required>
                              <option value="" selected="selected">Selecione...</option>
                              <option value="A4">A4</option>
                              <option value="A3">A3</option>
                              <option value="A2">A2</option>
                              <option value="A1">A1</option>
                            </select>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                            <button type="submit" class="btn btn-primary">Gerar PDF</button>
                          </div>
                        </form>
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