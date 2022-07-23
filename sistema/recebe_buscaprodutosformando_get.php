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

  $id_pagina = 14;

  $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
  $vetor_permissao = mysqli_fetch_array($sql_permissao);

  if($vetor_permissao['listar'] != 2) { 

    echo"<script language=\"JavaScript\">
    location.href=\"sempermissao.php\";
    </script>";

  } if($vetor_permissao['listar'] == 2) {

  $id_formando = $_GET['id_formando'];

  $sql_produto = mysqli_query($con, "select * from produtos_formando where id_formando = '$id_formando'");
	
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
  <link rel="stylesheet" href="layout/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="layout/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="layout/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="layout/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
    <a href="dashboard.php" class="logo">
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
        <li class="active">Vendas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Produtos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
            <?php if($vetor_permissao['cadastro'] == 1) { } else { ?><a href="cadastroprodutoformando.php"><button class="btn btn-primary"  style="    float: left;">Cadastrar Novo Produto</button></a>
            <br>
            <br>
           	<br><?php } ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Formando</th>
                  <th>Data</th>
                  <th>Valor Total</th>
                  <th>Status</th>
                  <th width="13%">Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php 
								
				        while ($vetor=mysqli_fetch_array($sql_produto)) {

                $sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor[id_formando]'");
                $vetor_formando = mysqli_fetch_array($sql_formando);
				
				        ?>
                <tr>
                  <td><?php echo $vetor_formando['nome']; ?></td>
                  <td><?php echo date('d/m/Y', strtotime($vetor['data'])); ?></td>
                  <td><?php echo $num = number_format($vetor['valorfinal'],2,',','.'); ?></td>
                  <td><?php if($vetor['status'] == 1) { echo "Em Estoque"; } if($vetor['status'] == 2) { echo "Em Venda"; } if($vetor['status'] == 3) { echo "Vendido"; } ?></td>
                  <td><?php if($vetor['status'] == 1) { ?><a href="alterarprodutoop.php?id=<?php echo $vetor['id_produto']; ?>" target="_blank"><button type="button" class="btn btn-info mesmo-tamanho" title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i></button></a> <?php if($vetor_permissao['exclusao'] == 1) { } else { ?><a href="confexcluirprodutoop.php?id=<?php echo $vetor['id_produto']; ?>" ><button type="button" class="btn btn-danger mesmo-tamanho" title="Excluir Cadastro"><i class="fa fa-close"></i></button></a><?php } } ?></td> 
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Formando</th>
                  <th>Data</th>
                  <th>Valor Total</th>
                  <th>Status</th>
                  <th width="13%">Ação</th>
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
<script src="layout/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="layout/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="layout/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="layout/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="layout/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="layout/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../layout/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../layout/dist/js/demo.js"></script>
<!-- page script -->
<script>
$(function() {
                $('#example1').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false,
                    "columnDefs": [
                        { responsivePriority: 1, targets: 0 },
                        { responsivePriority: 10, targets: -1 }
                    ]
                });
            });
</script>
</body>
</html>
<?php } } ?>