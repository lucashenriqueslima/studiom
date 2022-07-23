<?php

function formatarCPF_CNPJ($campo, $formatado = true){
	//retira formato
	$codigoLimpo = preg_replace("[' '-./ t]",'',$campo);
	// pega o tamanho da string menos os digitos verificadores
	$tamanho = (strlen($codigoLimpo) -2);
	//verifica se o tamanho do cÃ³digo informado Ã© vÃ¡lido
	if ($tamanho != 9 && $tamanho != 12){
		return false; 
	}
 
	if ($formatado){ 
		// seleciona a mÃ¡scara para cpf ou cnpj
		$mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##'; 
 
		$indice = -1;
		for ($i=0; $i < strlen($mascara); $i++) {
			if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
		}
		//retorna o campo formatado
		$retorno = $mascara;
 
	}else{
		//se nÃ£o quer formatado, retorna o campo limpo
		$retorno = $codigoLimpo;
	}
 
	return $retorno;
 
}

	 include"../includes/conexao.php";

	 
	 session_start();

	if($_SESSION['id'] == NULL) {
	
	echo"<script language=\"JavaScript\">
	location.href=\"index.php\";
	</script>";
	
	} else {
		
	$sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);

  $id_pagina = 5;

  $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
  $vetor_permissao = mysqli_fetch_array($sql_permissao);

  if($vetor_permissao['listar'] != 2) { 

    echo"<script language=\"JavaScript\">
    location.href=\"sempermissao.php\";
    </script>";

  } if($vetor_permissao['listar'] == 2) { 
	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>StudioM Fotografia</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../layout/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../layout/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../layout/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../layout/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../layout/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../layout/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="../layout/assets/css/custom.css">
  
  <link rel="icon" type="image/png" sizes="32x32" href="imgs/logo1.png">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-yellow sidebar-collapse sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="imgs/logo1.png" width="40px"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="imgs/LOGOS-LOGIN-1.png" width="100px"></span>    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <?php include"includes/topo.php"; ?>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <?php include"includes/menu_sistema.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Seja bem-vindo,
        <small> <?php echo $_SESSION['nome']; ?></small>      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cadastros Gerais</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Formandos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <?php if($vetor_permissao['cadastro'] == 1) { } else { ?><a href="cadastrar_formando.php"><button class="btn btn-primary"  style="    float: left;">Cadastrar Novo Formando</button></a>
            <br>
            <br>
           	<br><?php } ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">Cód. Aluno</th>
                  <th>Nome</th>
                  <th>Curso</th>
                  <th>Conclusão</th>
                  <th>Instituição</th>
                  <th>Telefone</th>
                  <th>Celular</th>
                  <th>Tipo</th>
                  <th width="16%">Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php 
				
        $nome = ucwords(strtolower($_POST['nome']));
        $cpf = $_POST['cpf'];
		$ncontrato = $_POST['ncontrato'];
        $numero = $_POST['numero'];

        if(!empty($nome)) { $where .= " AND a.nome LIKE '%".$nome."%'"; }
        if(!empty($cpf)) { $where .= " AND a.cpf = '".$cpf."'"; }
        if(!empty($ncontrato)) { $where .= " AND b.ncontrato = '".$ncontrato."'"; }
        if(!empty($numero)) { $where .= " AND a.id_cadastro = '".$numero."'"; }
				  
		$sql_atual = mysqli_query($con, "select a.nome, a.id_cadastro, a.conclusao, a.telefone, a.celular, a.comissao, a.id_formando, a.turma, b.id_turma, b.ncontrato  from formandos a, turmas b where a.turma = b.id_turma".$where."");
				
		  while ($vetor=mysqli_fetch_array($sql_atual)) {

          $sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[turma]'");
          $vetor_turma = mysqli_fetch_array($sql_turma);

          $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
          $vetor_instituicao = mysqli_fetch_array($sql_instituicao);          

          $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
          $vetor_curso = mysqli_fetch_array($sql_curso);
				
				 ?>
                <tr>
                  <td><?php echo $vetor_turma['ncontrato']; ?>-<?php echo $vetor['id_cadastro']; ?></td>
                  <td><?php echo $vetor['nome']; ?></td>
                  <td><?php echo $vetor_curso['nome']; ?></td>
                  <td><?php echo $vetor['conclusao']; ?></td>
                  <td><?php echo $vetor_instituicao['sigla']; ?></td>
                  <td><?php echo $vetor['telefone']; ?></td>
                  <td><?php echo $vetor['celular']; ?></td>
                  <td><?php if($vetor['comissao'] == '') {  ?><button type="button" class="btn btn-block btn-success btn-sm">Formando</button><?php } if($vetor['comissao'] == '1') {  ?><button type="button" class="btn btn-block btn-success btn-sm">Formando</button><?php } if($vetor['comissao'] == 2) {  ?><button type="button" class="btn btn-block btn-danger btn-sm">Comissão</button><?php } ?></td>
                  <td><a href="alterarformando.php?id=<?php echo $vetor['id_formando']; ?>" target="_blank"><button type="button" class="btn btn-info mesmo-tamanho" title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i></button></a> <a href="listarlinhatempo.php?id=<?php echo $vetor['id_formando']; ?>" target="_blank"><button type="button" class="btn btn-warning mesmo-tamanho" title="Linha do Tempo"><i class="fa fa-clock-o"></i></button></a> <a href="imprimirformando.php?id=<?php echo $vetor['id_formando']; ?>" target="_blank"><button type="button" class="btn btn-primary mesmo-tamanho" title="Imprimir Cadastro"><i class="fa fa-print"></i></button></a> <?php if($vetor_permissao['exclusao'] == 1) { } else { ?><a href="confexcluirformando.php?id=<?php echo $vetor['id_formando']; ?>" ><button type="button" class="btn btn-danger mesmo-tamanho" title="Excluir Cadastro"><i class="fa fa-close"></i></button></a><?php } ?></td> 
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th width="10%">Cód. Aluno</th>
                  <th>Nome</th>
                  <th>Curso</th>
                  <th>Conclusão</th>
                  <th>Instituição</th>
                  <th>Telefone</th>
                  <th>Celular</th>
                  <th>Tipo</th>
                  <th width="16%">Ação</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Filtro de Busca</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <form action="recebe_buscaformando.php" method="post">
            
            <div class="row">

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Nome</label>
              <input type="text" name="nome" class="form-control" placeholder="Digite o Nome">
            </fieldset>
          </div>

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">CPF</label>
              <input type="number" name="cpf" class="form-control" placeholder="CPF">
            </fieldset>
          </div>

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Número contrato</label>
              <input type="text" name="ncontrato" class="form-control" placeholder="Número contrato">
            </fieldset>
          </div>

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Codigo Aluno</label>
              <input type="text" name="numero" class="form-control" placeholder="Codigo Aluno">
            </fieldset>
          </div>

        </div><!--.row-->

        <button type="submit" class="btn btn-primary"  style="    float: left;">Buscar</button>

        </form>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Versão</b> 1.0    </div>
    <strong>Todos direitos reservados StudioM Fotografia.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../layout/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../layout/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../layout/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../layout/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../layout/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../layout/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../layout/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../layout/dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
<?php } } ?>