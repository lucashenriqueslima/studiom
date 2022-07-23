<?php
	 include"../includes/conexao.php";

	 
	 session_start();

	if($_SESSION['id'] == NULL) {
	
	echo"<script language=\"JavaScript\">
	location.href=\"index.php\";
	</script>";
	
	} else {
		
	$id = $_GET['id'];
  $sql = mysqli_query($con, "select * from formandos where id_formando = '$id'");
  $vetor = mysqli_fetch_array($sql);

  $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);

  
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>StudioM Fotografia</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../layout/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../layout/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../layout/bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../layout/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../layout/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../layout/dist/css/skins/_all-skins.min.css">
  
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
</head>
<body>

            <div class="box-body">

        <div class="row">

          <div class="col-lg-12">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Conclusão:</label>
              <?php echo $vetor['conclusao']; ?>
            </fieldset>
          </div> 

        </div><!--.row-->

        <div class="row">

          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Nome</label>
              <input type="text" name="nome" value="<?php echo $vetor['nome']; ?>" class="form-control" id="exampleInput" placeholder="Digite o nome" disabled>
            </fieldset>
          </div> 

          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Sexo / Genero</label>
              <select name="sexo" class="form-control" disabled>
                <option value="Masculino" <?php if (strcasecmp($vetor['sexo'], 'Masculino') == 0) : ?>selected="selected"<?php endif; ?>>Masculino</option>
                <option value="Feminino" <?php if (strcasecmp($vetor['sexo'], 'Feminino') == 0) : ?>selected="selected"<?php endif; ?>>Feminino</option>
              </select>
            </fieldset>
          </div>

        </div><!--.row-->

        <div class="row">

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">CPF</label>
              <input type="number" name="cpf" value="<?php echo $vetor['cpf']; ?>" class="form-control" placeholder="CPF" disabled>
            </fieldset>
          </div>

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">RG</label>
              <input type="number" name="rg" value="<?php echo $vetor['rg']; ?>" class="form-control" placeholder="RG" disabled>
            </fieldset>
          </div>

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Orgão Expedidor</label>
              <input type="text" name="oe" value="<?php echo $vetor['oe']; ?>" class="form-control" placeholder="Orgão Expedidor" disabled>
            </fieldset>
          </div>

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Data de Nascimento</label>
              <input type="date" name="datanasc" value="<?php echo $vetor['datanasc']; ?>" class="form-control" id="exampleInput" placeholder="Digite o nome" disabled>
            </fieldset>
          </div> 

        </div><!--.row-->

        <div class="row">
          
          <div class="col-lg-12">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Turma</label>
              <select name="turma" id="categorias" class="form-control" disabled>
                    <option value="" selected="selected">Selecione...</option>
                    <?php 
                    $sql_turmas = mysqli_query($con, "select * from turmas order by nome ASC");
                    while ($vetor_turma=mysqli_fetch_array($sql_turmas)) { ?>
                    <option value="<?php echo $vetor_turma['id_turma']; ?>" <?php if (strcasecmp($vetor['turma'], $vetor_turma['id_turma']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_turma['nome'] ?></option>
                    <?php } ?>
                  </select>
            </fieldset>
          </div>

        </div>

        <div class="row">
             
              <div class="col-md-12">
              <div class="form-group">
                <label>Comissão de Formatura</label>
                <select name="comissao" id="tipobusca" class="form-control" disabled>
                <option value="1" <?php if (strcasecmp($vetor['comissao'], '1') == 0) : ?>selected="selected"<?php endif; ?>>Não</option>
                <option value="2" <?php if (strcasecmp($vetor['comissao'], '2') == 0) : ?>selected="selected"<?php endif; ?>>Sim</option>
                </select>
              </div>
              </div>
         </div>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Cargo</label>
                
                <input type="text" name="cargo" value="<?php echo $vetor['cargo']; ?>" class="form-control" placeholder="Digite o Cargo" disabled>

              </div>
              </div>

          </div>

        <div class="row">
          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputEmail1">CEP</label>
              <input type="text" name="cep" value="<?php echo $vetor['cep']; ?>" id="cep" class="form-control" placeholder="CEP" disabled>
            </fieldset>
          </div>
          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputPassword1">Rua</label>
              <input type="text" name="endereco" value="<?php echo $vetor['endereco']; ?>" id="rua" class="form-control" placeholder="Endereço" disabled>
            </fieldset>
          </div>
        </div><!--.row-->
                
                <div class="row">
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Numero</label>
              <input type="text" name="numero" value="<?php echo $vetor['numero']; ?>" class="form-control" id="exampleInput" placeholder="Numero" disabled>
            </fieldset>
          </div>
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputEmail1">Complemento</label>
              <input type="text" name="complemento" value="<?php echo $vetor['complemento']; ?>" class="form-control" id="exampleInput" placeholder="Complemento" disabled>
            </fieldset>
          </div>
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputPassword1">Bairro</label>
              <input type="text" name="bairro" value="<?php echo $vetor['bairro']; ?>" id="bairro" class="form-control" placeholder="Bairro" disabled>
            </fieldset>
          </div>
        </div><!--.row-->
                
        <div class="row">
          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Cidade</label>
              <input type="text" name="cidade" value="<?php echo $vetor['cidade']; ?>" id="cidade" class="form-control" placeholder="Cidade" disabled>
            </fieldset>
          </div>
          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputEmail1">Estado</label>
              <input type="text" name="estado" value="<?php echo $vetor['estado']; ?>" id="uf" class="form-control" placeholder="Estado" disabled>
            </fieldset>
          </div>

        </div><!--.row-->

        <div class="row">
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Telefone</label>
              <input type="text" name="telefone" id="telefone" value="<?php echo $vetor['telefone']; ?>" class="form-control" placeholder="telefone" disabled>
            </fieldset>
          </div>
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputEmail1">Celular</label>
              <input type="text" name="celular" id="telefone2" value="<?php echo $vetor['celular']; ?>" class="form-control" placeholder="Celular" disabled>
            </fieldset>
          </div>
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputEmail1">E-mail</label>
              <input type="email" name="email" value="<?php echo $vetor['email']; ?>" class="form-control" placeholder="Estado" disabled>
            </fieldset>
          </div>

        </div><!--.row-->

        <div class="row">
        <div class="col-md-12">
          <div class="form-group">
                <label>Observações</label>
                <textarea name="observacoes" class="form-control" disabled><?php echo $vetor['observacoes']; ?></textarea>
          </div>
          </div>
        </div>

        <div class="row">
        <div class="col-md-12">
          <div class="form-group">
                <label>Foto</label>
                <br>
                <img src="imgs/<?php echo $vetor['imagem']; ?>" width="100px"> 
          </div>
          </div>
        </div>

        <h3>Dados dos Pais</h3>

        <div class="row">
          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Pai</label>
              <input type="text" name="pai" value="<?php echo $vetor['pai']; ?>" class="form-control" placeholder="Pai" disabled>
            </fieldset>
          </div>
          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputEmail1">Mãe</label>
              <input type="text" name="mae" value="<?php echo $vetor['mae']; ?>" class="form-control" placeholder="Mãe" disabled>
            </fieldset>
          </div>

        </div><!--.row-->

        <div class="row">
          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputEmail1">CEP</label>
              <input type="text" name="cep1" value="<?php echo $vetor['cep1']; ?>" id="cep1" class="form-control" placeholder="CEP" disabled>
            </fieldset>
          </div>
          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputPassword1">Rua</label>
              <input type="text" name="endereco1" value="<?php echo $vetor['endereco1']; ?>" id="rua1" class="form-control" placeholder="Endereço" disabled>
            </fieldset>
          </div>
        </div><!--.row-->
                
                <div class="row">
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Numero</label>
              <input type="text" name="numero1" value="<?php echo $vetor['numero1']; ?>" class="form-control" id="exampleInput" placeholder="Numero" disabled>
            </fieldset>
          </div>
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputEmail1">Complemento</label>
              <input type="text" name="complemento1" value="<?php echo $vetor['complemento1']; ?>" class="form-control" id="exampleInput" placeholder="Complemento" disabled>
            </fieldset>
          </div>
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputPassword1">Bairro</label>
              <input type="text" name="bairro1" value="<?php echo $vetor['bairro1']; ?>" id="bairro1" class="form-control" placeholder="Bairro" disabled>
            </fieldset>
          </div>
        </div><!--.row-->
                
                <div class="row">
          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Cidade</label>
              <input type="text" name="cidade1" value="<?php echo $vetor['cidade1']; ?>" id="cidade1" class="form-control" placeholder="Cidade" disabled>
            </fieldset>
          </div>
          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputEmail1">Estado</label>
              <input type="text" name="estado1" value="<?php echo $vetor['estado1']; ?>" id="uf1" class="form-control" placeholder="Estado" disabled>
            </fieldset>
          </div>

        </div><!--.row-->

        <div class="row">
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputEmail1">Telefone</label>
              <input type="text" name="telresidencial" id="telefone5" value="<?php echo $vetor['telresidencial']; ?>" class="form-control" placeholder="Celular" disabled>
            </fieldset>
          </div>
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Celular Pai</label>
              <input type="text" name="celularpai" id="telefone3" value="<?php echo $vetor['celularpai']; ?>" class="form-control" placeholder="Celular Pai" disabled>
            </fieldset>
          </div>
          <div class="col-lg-4">
            <fieldset class="form-group">
              <label class="form-label" for="exampleInputEmail1">Celular Mãe</label>
              <input type="text" name="celularmae" id="telefone4" value="<?php echo $vetor['celularmae']; ?>" class="form-control" placeholder="Celular" disabled>
            </fieldset>
          </div>
        </div><!--.row-->
</body>
</html>
<?php } ?>
<script type="text/javascript">
<!--
        print();
-->
</script>