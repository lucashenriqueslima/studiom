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

  $id_pagina = 102;

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
              <h3 class="box-title">Turmas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
            <?php if($vetor_permissao['cadastro'] == 1) { } else { ?>

            <table width="100%">
              <tr>
                <td width="13%"><a href="cadastrar_turmamkt.php"><button class="btn btn-primary"  style="    float: left;">Cadastrar Nova Turma</button></a></td>
                <td><a href="cadastrar_turmamktaut.php"><button class="btn btn-primary"  style="    float: left;">Cadastrar Novas Turmas Automaticamente</button></a></td>
              </tr>
            </table>

            <br>
            <br>
           	<br><?php } ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">Código</th>
                  <th>Turma</th>
                  <th>Cidade</th>
                  <th>Região</th>
                  <th>Administração</th>
                  <th>Vagas</th>
                  <th>Viabilidade</th>
                  <th>Contrato Fechado?</th>
                  <th width="13%">Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php 
								  
				        $ano = $_POST['ano'];
                $semestre = $_POST['semestre'];
                $estado = $_POST['estado'];
                $regiao = $_POST['regiao'];
                $administracao = $_POST['administracao'];
                $qtdalunos = $_POST['qtdalunos'];

                if(!empty($ano)) { $where .= " AND a.conclusao = '".$ano."'"; }
                if(!empty($semestre)) { $where .= " AND a.semestre = '".$semestre."'"; }
                if(!empty($estado)) { $where .= " AND b.estado = '".$estado."'"; }
                if(!empty($regiao)) { $where .= " AND b.regiao = '".$regiao."'"; }
                if(!empty($administracao)) { $where .= " AND b.administracao = '".$administracao."'"; }
                if(!empty($qtdalunos)) { $where .= " AND a.qtdalunos = '".$qtdalunos."'"; }

                $sql_atual = mysqli_query($con, "select * from turmas_mkt a, instituicoes b, cursos c where a.id_curso = c.id_curso and c.id_instituicao = b.id_instituicao".$where." order by a.id_turma ASC");
				
				        while ($vetor=mysqli_fetch_array($sql_atual)) {

                $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor[id_curso]'");
                $vetor_curso = mysqli_fetch_array($sql_curso);

                $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
                $vetor_instituicao = mysqli_fetch_array($sql_instituicao);
				
				        ?>
                <tr>
                  <td><?php echo $vetor['id_turma']; ?></td>
                  <td><?php echo $vetor_curso['nome']; ?> / <?php echo $vetor_curso['sigla']; ?> / <?php echo $vetor['conclusao']; ?>-<?php echo $vetor['semestre']; ?></td> 
                  <td><?php echo $vetor_instituicao['cidade']; ?></td>
                  <td><?php echo $vetor_instituicao['regiao']; ?></td>
                  <td><?php echo $vetor_instituicao['administracao']; ?></td>
                  <td><?php echo $vetor_curso['vagas1']; ?></td>
                  <td><?php echo $vetor_curso['viavel']; ?></td>
                  <td><?php if($vetor['contratofechado'] == 1) { ?><button type="button" class="btn btn-success mesmo-tamanho" title="Contrato Fechado"><i class="fa fa-thumbs-up"></i></button><?php } if($vetor['contratofechado'] == 2) { ?><button type="button" class="btn btn-danger mesmo-tamanho" title="Contrato Não Fechado"><i class="fa fa-thumbs-down"></i></button><?php } else { ?><button type="button" class="btn btn-info mesmo-tamanho" title="Em Negociação"><i class="fa fa-handshake-o"></i></button><?php } ?></td>
                  <td><a href="alterarturmamkt.php?id=<?php echo $vetor['id_turma']; ?>" target="_blank"><button type="button" class="btn btn-info mesmo-tamanho" title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i></button></a> <?php if($vetor_permissao['exclusao'] == 1) { } else { ?><a href="confexcluirturmamkt.php?id=<?php echo $vetor['id_turma']; ?>" ><button type="button" class="btn btn-danger mesmo-tamanho" title="Excluir Cadastro"><i class="fa fa-close"></i></button></a><?php } ?></td> 
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th width="10%">Código</th>
                  <th>Turma</th>
                  <th>Cidade</th>
                  <th>Região</th>
                  <th>Administração</th>
                  <th>Vagas</th>
                  <th>Viabilidade</th>
                  <th>Contrato Fechado?</th>
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

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Filtro de Busca</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <form action="recebe_buscaturmamkt.php" method="post">
            
            <div class="row">

          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Ano</label>
              <select name="ano" id="categorias" class="form-control">
                    <option value="" selected="">Selecione...</option>
                    <?php 
                    $sql_turmas_ano = mysqli_query($con, "select DISTINCT conclusao from turmas_mkt order by conclusao ASC");
                    while ($vetor_turmas_ano=mysqli_fetch_array($sql_turmas_ano)) { ?>
                    <option value="<?php echo $vetor_turmas_ano['conclusao']; ?>" ><?php echo $vetor_turmas_ano['conclusao'] ?></option>
                    <?php } ?>
                  </select>
            </fieldset>
          </div>

          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Semestre</label>
              <input type="number" name="semestre" class="form-control" placeholder="Semestre">
            </fieldset>
          </div>

          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Estado</label>
              <select id="estado" name="estado" class="form-control">
                  <option value="" selected="">UF</option>
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

        </div><!--.row-->

        <div class="row">

          <div class="col-lg-4">
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

          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Tipo Administração</label>
              <select name="administracao" class="form-control">
                <option value="" selected="">Selecione...</option>
                <option value="Privada" <?php if (strcasecmp($vetor['administracao'], 'Privada') == 0) : ?>selected="selected"<?php endif; ?>>Privada</option>
                <option value="Estadual" <?php if (strcasecmp($vetor['administracao'], 'Estadual') == 0) : ?>selected="selected"<?php endif; ?>>Estadual</option>
                <option value="Federal" <?php if (strcasecmp($vetor['administracao'], 'Federal') == 0) : ?>selected="selected"<?php endif; ?>>Federal</option>
                <option value="Municipal" <?php if (strcasecmp($vetor['administracao'], 'Municipal') == 0) : ?>selected="selected"<?php endif; ?>>Municipal</option>
                <option value="Pública" <?php if (strcasecmp($vetor['administracao'], 'Pública') == 0) : ?>selected="selected"<?php endif; ?>>Pública</option>
              </select>
            </fieldset>
          </div>

          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Quantidade de Alunos</label>
              <input type="number" name="qtdalunos" class="form-control" placeholder="Quantidade de Alunos">
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