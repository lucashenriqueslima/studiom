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

  $id_pagina = 4;

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
        <li class="active">Cadastros Gerais</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Contratos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
            <?php if($vetor_permissao['cadastro'] == 1) { } else { ?><a href="cadastrar_turma.php"><button class="btn btn-primary"  style="    float: left;">Cadastrar Novo Contrato</button></a>
            <br>
            <br>
           	<br><?php } ?>
              <table id="example1" class="table table-bordered table-striped table-responsive" style="width:100%">
                <thead>
                <tr>
                  <th data-priority="1">N° Contrato</th>
                  <th>Tipo</th>
                  <th>Curso</th>
                  <th>Conclusão</th>
                  <th>Instituição</th>
                  <th>Cidade</th>
                  <th>UF</th>
                  <th width="10%">Qtde Formandos</th>
                  <th width="10%">Qtde de Alunos Cadastrados</th>
                  <th width="13%" data-priority="2">Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php 
				
				        $id_instituicao = $_POST['id_instituicao'];
                $ano = $_POST['ano'];
                $estado = $_POST['estado'];
                $regiao = $_POST['regiao'];

                if(!empty($id_instituicao)) { $where .= " AND a.id_instituicao = '".$id_instituicao."'"; }
                if(!empty($ano)) { $where .= " AND a.ano = '".$ano."'"; }
                if(!empty($estado)) { $where .= " AND b.estado = '".$estado."'"; }
                if(!empty($regiao)) { $where .= " AND b.regiao = '".$regiao."'"; }
                  
                $sql_atual = mysqli_query($con, "select a.id_turma, a.nome, a.ano, a.ncontrato, a.id_instituicao, a.id_turma, a.turma, a.tipo, a.qtdformandos, b.id_instituicao from turmas a, instituicoes b where a.id_instituicao = b.id_instituicao".$where."");
				
				        while ($vetor=mysqli_fetch_array($sql_atual)) {

                $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor[id_instituicao]'");
                $vetor_instituicao = mysqli_fetch_array($sql_instituicao);

                $sql_formandos = mysqli_query($con, "select * from formandos where turma = '$vetor[id_turma]'");
				
				        ?>
                <tr>
                  <td><?php echo $vetor['ncontrato']; ?></td>
                  <td><?php if($vetor['tipo'] == '1') { echo "F"; } if($vetor['tipo'] == '2') { echo "C"; } if($vetor['tipo'] == '3') { echo "F / C"; } ?></td>
                  <td><?php echo $vetor['nome']; ?></td>
                  <td><?php echo $vetor['ano']; ?></td>
                  <td><?php echo $vetor_instituicao['sigla']; ?></td>
                  <td><?php echo $vetor_instituicao['cidade']; ?></td>
                  <td><?php echo $vetor_instituicao['estado']; ?></td>
                  <td><?php echo $vetor['qtdformandos']; ?></td>
                  <td><?php echo mysqli_num_rows($sql_formandos); ?></td>
                  <td><a href="alterarturma.php?id=<?php echo $vetor['id_turma']; ?>" target="_blank"><button type="button" class="btn btn-info mesmo-tamanho" title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i></button></a> <?php if($vetor_permissao['exclusao'] == 1) { } else { ?><a href="confexcluirturma.php?id=<?php echo $vetor['id_turma']; ?>" ><button type="button" class="btn btn-danger mesmo-tamanho" title="Excluir Cadastro"><i class="fa fa-close"></i></button></a><?php } ?></td> 
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Curso</th>
                  <th>Tipo</th>
                  <th>N° Contrato</th>
                  <th>Conclusão</th>
                  <th>Instituição</th>
                  <th>Cidade</th>
                  <th>Estado</th>
                  <th>Qtde Formandos</th>
                  <th>Qtde de Alunos Cadastrados</th>
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
    
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Filtro de Busca</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <form action="recebe_buscaturma.php" method="post">
            
            <div class="row">

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Instituição</label>
              <select name="id_instituicao" id="categorias" class="form-control">
                    <option value="" selected="selected">Selecione...</option>
                    <?php 
                    $sql_instituicoes = mysqli_query($con, "select * from instituicoes order by nome ASC");
                    while ($vetor_instituicao=mysqli_fetch_array($sql_instituicoes)) { ?>
                    <option value="<?php echo $vetor_instituicao['id_instituicao']; ?>" <?php if (strcasecmp($vetor['id_instituicao'], $vetor_instituicao['id_instituicao']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_instituicao['sigla'] ?></option>
                    <?php } ?>
                  </select>
            </fieldset>
          </div>

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Conclusão</label>
              <input type="text" name="ano" class="form-control" id="exampleInput" placeholder="Ano Conclusão">
            </fieldset>
          </div>

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">UF</label>
              <select id="estado" name="estado" class="form-control">
                  <option value="" selected="">Selecione...</option>
                  <option value="AC" <?php if (strcasecmp($vetor['estado'], 'AC') == 0) : ?>selected="selected"<?php endif; ?>>Acre</option>
                  <option value="AL" <?php if (strcasecmp($vetor['estado'], 'AL') == 0) : ?>selected="selected"<?php endif; ?>>Alagoas</option>
                  <option value="AP" <?php if (strcasecmp($vetor['estado'], 'AP') == 0) : ?>selected="selected"<?php endif; ?>>Amapá</option>
                  <option value="AM" <?php if (strcasecmp($vetor['estado'], 'AM') == 0) : ?>selected="selected"<?php endif; ?>>Amazonas</option>
                  <option value="BA" <?php if (strcasecmp($vetor['estado'], 'BA') == 0) : ?>selected="selected"<?php endif; ?>>Bahia</option>
                  <option value="CE" <?php if (strcasecmp($vetor['estado'], 'CE') == 0) : ?>selected="selected"<?php endif; ?>>Ceará</option>
                  <option value="DF" <?php if (strcasecmp($vetor['estado'], 'DF') == 0) : ?>selected="selected"<?php endif; ?>>Distrito Federal</option>
                  <option value="ES" <?php if (strcasecmp($vetor['estado'], 'ES') == 0) : ?>selected="selected"<?php endif; ?>>Espírito Santo</option>
                  <option value="GO" <?php if (strcasecmp($vetor['estado'], 'GO') == 0) : ?>selected="selected"<?php endif; ?>>Goiás</option>
                  <option value="MA" <?php if (strcasecmp($vetor['estado'], 'MA') == 0) : ?>selected="selected"<?php endif; ?>>Maranhão</option>
                  <option value="MT" <?php if (strcasecmp($vetor['estado'], 'MT') == 0) : ?>selected="selected"<?php endif; ?>>Mato Grosso</option>
                  <option value="MS" <?php if (strcasecmp($vetor['estado'], 'MS') == 0) : ?>selected="selected"<?php endif; ?>>Mato Grosso do Sul</option>
                  <option value="MG" <?php if (strcasecmp($vetor['estado'], 'MG') == 0) : ?>selected="selected"<?php endif; ?>>Minas Gerais</option>
                  <option value="PA" <?php if (strcasecmp($vetor['estado'], 'PA') == 0) : ?>selected="selected"<?php endif; ?>>Pará</option>
                  <option value="PB" <?php if (strcasecmp($vetor['estado'], 'PB') == 0) : ?>selected="selected"<?php endif; ?>>Paraíba</option>
                  <option value="PR" <?php if (strcasecmp($vetor['estado'], 'PR') == 0) : ?>selected="selected"<?php endif; ?>>Paraná</option>
                  <option value="PE" <?php if (strcasecmp($vetor['estado'], 'PE') == 0) : ?>selected="selected"<?php endif; ?>>Pernambuco</option>
                  <option value="PI" <?php if (strcasecmp($vetor['estado'], 'PI') == 0) : ?>selected="selected"<?php endif; ?>>Piauí</option>
                  <option value="RJ" <?php if (strcasecmp($vetor['estado'], 'RJ') == 0) : ?>selected="selected"<?php endif; ?>>Rio de Janeiro</option>
                  <option value="RN" <?php if (strcasecmp($vetor['estado'], 'RN') == 0) : ?>selected="selected"<?php endif; ?>>Rio Grande do Norte</option>
                  <option value="RS" <?php if (strcasecmp($vetor['estado'], 'RS') == 0) : ?>selected="selected"<?php endif; ?>>Rio Grande do Sul</option>
                  <option value="RO" <?php if (strcasecmp($vetor['estado'], 'RO') == 0) : ?>selected="selected"<?php endif; ?>>Rondônia</option>
                  <option value="RR" <?php if (strcasecmp($vetor['estado'], 'RR') == 0) : ?>selected="selected"<?php endif; ?>>Roraima</option>
                  <option value="SC" <?php if (strcasecmp($vetor['estado'], 'SC') == 0) : ?>selected="selected"<?php endif; ?>>Santa Catarina</option>
                  <option value="SP" <?php if (strcasecmp($vetor['estado'], 'SP') == 0) : ?>selected="selected"<?php endif; ?>>São Paulo</option>
                  <option value="SE" <?php if (strcasecmp($vetor['estado'], 'SE') == 0) : ?>selected="selected"<?php endif; ?>>Sergipe</option>
                  <option value="TO" <?php if (strcasecmp($vetor['estado'], 'TO') == 0) : ?>selected="selected"<?php endif; ?>>Tocantins</option>
              </select>
            </fieldset>
          </div>

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Região</label>
              <select name="regiao" class="form-control">
                <option value="" selected="">Selecione...</option>
                <option value="Centro Oeste" <?php if (strcasecmp($vetor['regiao'], 'Centro Oeste') == 0) : ?>selected="selected"<?php endif; ?>>Centro Oeste</option>
                <option value="Nordeste" <?php if (strcasecmp($vetor['regiao'], 'Nordeste') == 0) : ?>selected="selected"<?php endif; ?>>Nordeste</option>
                <option value="Norte" <?php if (strcasecmp($vetor['regiao'], 'Norte') == 0) : ?>selected="selected"<?php endif; ?>>Norte</option>
                <option value="Sudeste" <?php if (strcasecmp($vetor['regiao'], 'Sudeste') == 0) : ?>selected="selected"<?php endif; ?>>Sudeste</option>
                <option value="Sul" <?php if (strcasecmp($vetor['regiao'], 'Sul') == 0) : ?>selected="selected"<?php endif; ?>>Sul</option>
              </select>
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