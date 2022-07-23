<?php

include "../includes/conexao.php";
session_start();
$id_pagina = 112;
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
		$id = $_GET['id'];
		$sql = mysqli_query($con, "select * from dados_convite where id_dados = '$id'");
		$vetor = mysqli_fetch_array($sql);

        function dataformatada($dataformatada){
            return date("d-m-Y", strtotime($dataformatada));
        }
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
<!--                          <h4 class="page-title">Arte Final - Convite</h4>-->
                          <div class="d-flex align-items-center">
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item">Arte Final - Convite</a></li>
                                      <li class="breadcrumb-item">Arquivos de Convite</a></li>
                                      <li class="breadcrumb-item">Comissão</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Alterar Comissão</li>
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
<!--                                  <h4 class="card-title">Dados Convite Comissão</h4>-->

                                
                                  <h5>SOLENIDADES (DATA, LOCAL E HORÁRIO)</h5>

                                  <br>

                                  <?php 
                                        #SOLENIDADES (DATA, LOCAL E HORÁRIO)
                                        $sql_convite = mysqli_query($con, "SELECT dc.*, c.nome FROM dados_evento_qrconvite dc left join categoriaevento c on c.id_categoria = dc.id_categoriaEvento_fk WHERE dc.id_turma_fk = '$vetor[id_turma]' ");
                                        while($row_convite = mysqli_fetch_assoc($sql_convite)){
                                                                
                                            if (is_null($row_convite["id_dadosQrconvite"])  || $row_convite["id_dadosQrconvite"] == ""){
                                                # code...
                                            }else{  
                                        
                                    ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    
                                                    <label class="form-label semibold" for="exampleInput"><?= $row_convite['nome']?></label>
                                                        

                                                                <textarea name="jantardospais" class="form-control"><?= dataformatada($row_convite["dataQrconvite"])?> as <?= $row_convite["horainicio"]?> - <?= $row_convite["nomeLocal"]?> (<?= $row_convite["endereco"]?> - <?= $row_convite["cidade"]?> - <?= $row_convite["estado"]?>)</textarea>
                                                                
                                                    
                                                </fieldset>
                                            </div>
                                        </div><!--.row-->
                                    <?php }} ?>     

                                  
                            

                                  <br>

                                  <h5>MENSAGEM INICIAL</h5>

                                  <br>

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Mensagem
                                                  Inicial</label>
                                              <textarea name="mensageminicial"
                                                        class="form-control"><?php echo $vetor['mensageminicial']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <br>

                                  <h5>HOMENAGEADOS</h5>

                                  <br>
                                <?php
                                    $sql_verifica_homenageados = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and (corpoHomenageados = 'Patrono' || corpoHomenageados = 'Patrona' || corpoHomenageados = 'patronesse') order by nome_homenageado asc");
                                    $row_verifica_homenageados = mysqli_fetch_assoc($sql_verifica_homenageados);
                                    if (is_null($row_verifica_homenageados["nome_homenageado"])  || $row_verifica_homenageados["nome_homenageado"] == "" ){ 

                                    }else{
                                ?>
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Patrono /
                                                  Patronesse</label>
                                              <textarea name="patrono" class="form-control"><?php 
                                                    $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and (corpoHomenageados = 'Patrono' || corpoHomenageados = 'Patrona' || corpoHomenageados = 'patronesse') order by nome_homenageado asc");
                                                    while($row_convite = mysqli_fetch_assoc($sql_convite)){?><?= $row_convite["titulo"]?> <?= $row_convite["nome_homenageado"]."\n"?><?php } ?>
                                              </textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->
                                <?php }?>


                                <?php
                                $sql_verifica_paraninfo = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and (corpoHomenageados = 'Paraninfo' || corpoHomenageados = 'Paraninfa') order by nome_homenageado asc");
                                $row_verifica_paraninfo = mysqli_fetch_assoc($sql_verifica_paraninfo);
                                if (is_null($row_verifica_paraninfo["nome_homenageado"])  || $row_verifica_paraninfo["nome_homenageado"] == "" ){ 

                                }else{
                                ?>        
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Paraninfo
                                                  (a)</label>
                                              <textarea name="parainfo" class="form-control"><?php 
                                                $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and (corpoHomenageados = 'Paraninfo' || corpoHomenageados = 'Paraninfa') order by nome_homenageado asc");
                                                while($row_convite = mysqli_fetch_assoc($sql_convite)){?><?= $row_convite["titulo"]?> <?= $row_convite["nome_homenageado"]."\n"?><?php } ?>
                                              </textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->
                                <?php }?>    

                                <?php
                                    $sql_verifica_professores = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and (corpoHomenageados = 'Professor' || corpoHomenageados = 'Professora') order by nome_homenageado asc");
                                    $row_verifica_professores = mysqli_fetch_assoc($sql_verifica_professores);
                                    if (is_null($row_verifica_professores["nome_homenageado"])  || $row_verifica_professores["nome_homenageado"] == "" ){ 

                                    }else{
                                ?>
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Professores
                                                  Homenageados</label>
                                                <textarea name="professores" class="form-control"><?php 
                                                    $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and (corpoHomenageados = 'Professor' || corpoHomenageados = 'Professora') order by nome_homenageado asc");
                                                    while($row_convite = mysqli_fetch_assoc($sql_convite)){?><?= $row_convite["titulo"]?> <?= $row_convite["nome_homenageado"]."\n";?><?php }?>
                                                </textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->
                                <?php }?>


                                <?php
                                    $sql_verifica_nomeTurma = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and corpoHomenageados = 'Nome da Turma' order by nome_homenageado asc");
                                    $row_verifica_nomeTurma = mysqli_fetch_assoc($sql_verifica_nomeTurma);
                                    if (is_null($row_verifica_nomeTurma["nome_homenageado"])  || $row_verifica_nomeTurma["nome_homenageado"] == "" ){ 

                                    }else{
                                ?>
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Nome da
                                                  Turma</label>
                                                  <textarea name="nometurma" class="form-control"><?php
                                                    $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and corpoHomenageados = 'Nome da Turma' order by nome_homenageado asc");
                                                    while($row_convite = mysqli_fetch_assoc($sql_convite)){?><?= $row_convite["titulo"]?> <?= $row_convite["nome_homenageado"];?><?php }?>
                                                </textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->
                                <?php }?>
                                
                                <?php
                                    $sql_verifica_nomeTurma = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and corpoHomenageados = 'Residente Homenageado' order by nome_homenageado asc");
                                    $row_verifica_nomeTurma = mysqli_fetch_assoc($sql_verifica_nomeTurma);
                                    if (is_null($row_verifica_nomeTurma["nome_homenageado"])  || $row_verifica_nomeTurma["nome_homenageado"] == "" ){ 

                                    }else{
                                ?>
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Residente Homenageado</label>
                                                  <textarea name="nometurma" class="form-control"><?php
                                                    $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and corpoHomenageados = 'Residente Homenageado' order by nome_homenageado asc");
                                                    while($row_convite = mysqli_fetch_assoc($sql_convite)){?><?= $row_convite["titulo"]?> <?= $row_convite["nome_homenageado"];?><?php }?>
                                                </textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->
                                <?php }?>

                                <?php
                                    $sql_verifica_professores = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and (corpoHomenageados = 'Funcionário Homenageado' || corpoHomenageados = 'Funcionária Homenageada') order by nome_homenageado asc");
                                    $row_verifica_professores = mysqli_fetch_assoc($sql_verifica_professores);
                                    if (is_null($row_verifica_professores["nome_homenageado"])  || $row_verifica_professores["nome_homenageado"] == "" ){ 

                                    }else{
                                ?>
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Funcionários
                                                  Homenageados</label>
                                                <textarea name="professores" class="form-control"><?php 
                                                    $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$vetor[id_turma]' and (corpoHomenageados = 'Funcionário Homenageado' || corpoHomenageados = 'Funcionária Homenageada') order by nome_homenageado asc");
                                                    while($row_convite = mysqli_fetch_assoc($sql_convite)){?><?= $row_convite["titulo"]?> <?= $row_convite["nome_homenageado"]."\n";?><?php }?>
                                                </textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->
                                <?php }?>

                                <?php
                                    $sql_verifica_corpoadministrativo = mysqli_query($con, "SELECT * FROM corpoadministrativo WHERE id_turma_fk = '$vetor[id_turma]'");
                                    $row_verifica_corpoadministrativo = mysqli_fetch_assoc($sql_verifica_corpoadministrativo);
                                    if (is_null($row_verifica_corpoadministrativo["nome_corpoAdministrativo"])  || $row_verifica_corpoadministrativo["nome_corpoAdministrativo"] == "" ){ 

                                    }else{
                                    ?>        
                                    <br>
                                <h5>CORPO ADMINISTRATIVO</h5>

                                <br>
                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Corpo Administrativo</label>
                                                <textarea name="corpoadministrativo" class="form-control"><?php 
                                                    $sql_convite = mysqli_query($con, "SELECT * FROM corpoadministrativo WHERE id_turma_fk = '$vetor[id_turma]' ");
                                                    while($row_convite = mysqli_fetch_assoc($sql_convite)){?><?= $row_convite["corpoAdministrativo"]."\n"?><?= $row_convite["titulo"]?> <?= $row_convite["nome_corpoAdministrativo"]."\n"?><?php } ?>
                                                </textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->
                                    <?php }?>

                                  <br>

                                  <h5>AGRADECIMENTOS / MENSAGENS</h5>

                                  <br>

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">A Deus</label>
                                              <textarea name="adeus"
                                                        class="form-control"><?php echo $vetor['adeus']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Aos Pais</label>
                                              <textarea name="aospais"
                                                        class="form-control"><?php echo $vetor['aospais']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Aos Pais
                                                  Ausentes</label>
                                              <textarea name="aospaisausentes"
                                                        class="form-control"><?php echo $vetor['aospaisausentes']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">À Família</label>
                                              <textarea name="afamilia"
                                                        class="form-control"><?php echo $vetor['afamilia']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Aos que
                                                  Amamos</label>
                                              <textarea name="aosqueamamos"
                                                        class="form-control"><?php echo $vetor['aosqueamamos']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Aos Amigos</label>
                                              <textarea name="aosamigos"
                                                        class="form-control"><?php echo $vetor['aosamigos']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Aos Mestres</label>
                                              <textarea name="aosmestres"
                                                        class="form-control"><?php echo $vetor['aosmestres']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Aos
                                                  Funcionários</label>
                                              <textarea name="aosfuncionarios"
                                                        class="form-control"><?php echo $vetor['aosfuncionarios']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Aos Pacientes
                                                  (Medicina)</label>
                                              <textarea name="aospacientes"
                                                        class="form-control"><?php echo $vetor['aospacientes']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Ao Cadáver
                                                  Desconhecido (Medicina)</label>
                                              <textarea name="aocadaver"
                                                        class="form-control"><?php echo $vetor['aocadaver']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Juramento</label>
                                              <textarea name="juramento"
                                                        class="form-control"><?php echo $vetor['juramento']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <br>

                                  <h5>MENSAGENS FINAIS</h5>

                                  <br>

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Mensagem da
                                                  Comissão</label>
                                              <textarea name="mensagemcomissao"
                                                        class="form-control"><?php echo $vetor['mensagemcomissao']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Mensagem
                                                  Final</label>
                                              <textarea name="mensagemfinal"
                                                        class="form-control"><?php echo $vetor['mensagemfinal']; ?></textarea>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <br>

                                  <h5>CRÉDITOS</h5>

                                  <br>

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Logo
                                                  Instituição</label>
																						<?php if ($vetor['logoinstituicao'] == null) { ?>
																						<?php }else { ?>
                                                <img src="../sistema/arquivos/<?php echo $vetor['logoinstituicao']; ?>">
																						<?php } ?>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Logo
                                                  Cerimonial</label>
																						<?php if ($vetor['logocerimonial'] == null) { ?>
																						<?php }else { ?>
                                                <img src="../sistema/arquivos/<?php echo $vetor['logocerimonial']; ?>">
																						<?php } ?>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Logo Empresa
                                                  Fotográfica</label>
																						<?php if ($vetor['empresafotografica'] == null) { ?>
																						<?php }else { ?>
                                                <img src="../sistema/arquivos/<?php echo $vetor['empresafotografica']; ?>">
																						<?php } ?>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->

                                  <div class="row">
                                      <div class="col-lg-12">
                                          <fieldset class="form-group">
                                              <label class="form-label semibold" for="exampleInput">Logo Outra</label>
																						<?php if ($vetor['outra'] == null) { ?>
																						<?php }else { ?>
                                                <img src="../sistema/arquivos/<?php echo $vetor['outra']; ?>">
																						<?php } ?>
                                          </fieldset>
                                      </div>
                                  </div><!--.row-->
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