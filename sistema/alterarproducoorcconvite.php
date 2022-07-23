<?php
	 include"../includes/conexao.php";

	 
	 session_start();

	if($_SESSION['id'] == NULL) {
	
	echo"<script language=\"JavaScript\">
	location.href=\"index.php\";
	</script>";
	
	} else {
		
	$id = $_GET['id'];
  $id1 = $_GET['id1'];

  $sql_produto = mysqli_query($con, "select * from orcamento_produto where id_item = '$id'");
  $vetor_produto = mysqli_fetch_array($sql_produto);

  $sql = mysqli_query($con, "select * from orcamento_convite where id_orcamento = '$id1'");
  $vetor = mysqli_fetch_array($sql);

  $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);
	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Studio M Fotografia</title>
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

<script type="text/javascript" src="aplicacoes/aplicjava.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>  
<!-- Adicionando JQuery -->
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" >

        $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...")
                        $("#bairro").val("...")
                        $("#cidade").val("...")
                        $("#uf").val("...")
                        $("#ibge").val("...")

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });
		
		$(document).ready(function() {

            function limpa_formulário_cep1() {
                // Limpa valores do formulário de cep.
                $("#rua1").val("");
                $("#bairro1").val("");
                $("#cidade1").val("");
                $("#uf1").val("");
                $("#ibge1").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep1").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua1").val("...")
                        $("#bairro1").val("...")
                        $("#cidade1").val("...")
                        $("#uf1").val("...")
                        $("#ibge1").val("...")

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua1").val(dados.logradouro);
                                $("#bairro1").val(dados.bairro);
                                $("#cidade1").val(dados.localidade);
                                $("#uf1").val(dados.uf);
                                $("#ibge1").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep1();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep1();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep1();
                }
            });
        });

    </script>
    <script type="text/javascript">
/* MÃ¡scaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}
window.onload = function(){  
    id('telefone').onkeypress = function(){  
        mascara( this, mtel);  
    }
    id('telefone2').onkeypress = function(){  
        mascara( this, mtel);  
    }
	id('telefone3').onkeypress = function(){  
        mascara( this, mtel);  
    }
	id('telefone4').onkeypress = function(){  
        mascara( this, mtel);  
    }
}
</script>
    <style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
-->
    </style>

	<script type="text/javascript">  
$(document).ready(function(){  
        $("#palco > div").hide();  
        $("#tipo").change(function(){  
                $("#palco > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
		$("#palco1 > div").hide(); 
		$("#tipobusca").change(function(){  
                $("#palco1 > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
        $("input[name='rd-sexo']").click(function(){  
                $("#palco > div").hide();  
                $( '#'+$( this ).val() ).show('fast');    
        });  
});  
</script>

<script type="text/javascript">
          $(document).ready(function(){
              $('#tipo').change(function(){
                  $('#tamanhos').load('tabelatamanhos.php?id_tipo='+$('#tipo').val() );

              });

              $('#tipo').change(function(){
                  $('#tamanhos1').load('tabelatamanhos.php?id_tipo='+$('#tipo').val() );

              });

              $('#tamanhos').change(function(){
                  $('#embalagens').load('tabelaembalagens.php?id_tipo='+$('#tamanhos').val() );

              });

              $('#tamanhos1').change(function(){
                  $('#embalagens1').load('tabelaembalagens.php?id_tipo='+$('#tamanhos1').val() );

              });

              $('#tamanhos').change(function(){
                  $('#acabamentoembalagens').load('tabelaacabamentoembalagens.php?id_tipo='+$('#tamanhos').val() );

              });

              $('#tamanhos1').change(function(){
                  $('#acabamentoembalagens1').load('tabelaacabamentoembalagens.php?id_tipo='+$('#tamanhos1').val() );

              });

              $('#tamanhos').change(function(){
                  $('#sobrecapaencarte').load('tabelasobrecapaencarte.php?id_tipo='+$('#tamanhos').val() );

              });

              $('#tamanhos').change(function(){
                  $('#capa').load('tabelacapa.php?id_tipo='+$('#tamanhos').val() );

              });

              $('#tamanhos').change(function(){
                  $('#acabamentocapa').load('tabelaacabamentocapa.php?id_tipo='+$('#tamanhos').val() );

              });

              $('#tamanhos1').change(function(){
                  $('#paginas').load('tabelapaginas.php?id_tipo='+$('#tamanhos1').val() );

              });

              $('#tamanhos').change(function(){
                  $('#qtdpaginaspadrao').load('tabelaaqtdpaginaspadrao.php?id_tipo='+$('#tamanhos').val() );

              });

              $('#tamanhos').change(function(){
                  $('#qtdpaginaspersonalizadas').load('tabelaqtdpaginaspersonalizadas.php?id_tipo='+$('#tamanhos').val() );

              });

          });

</script>
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
        <li class="active">Comercial</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Cadastro de Orçamento Convite</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
            <form action="recebe_alterarprodutoorcconvite.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>" method="post" name="cliente" enctype="multipart/form-data" onSubmit="return verificarCPF()" id="formID">

              <?php if($vetor_produto['id_produto'] == 2) { ?>

                <input type="hidden" value="2" name="id_produto">
    				
                <div class="row">

                  <div class="col-lg-6">
                    <fieldset class="form-group">
                      <label class="form-label semibold" for="exampleInput">Quantidade</label>
                      <input type="number" name="qtdconvites" value="<?php echo $vetor_produto['qtd']; ?>" class="form-control">
                    </fieldset>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Tamanho</label>
                      <select name="tamanho" id="tamanhos" class="form-control">
                        <option value="">Selecione...</option>
                        <?php

                        $tabela_tamanho = mysqli_query($con, "SELECT * FROM tabela_basico WHERE id_produto = '2' order by id_produto ASC");

                        while($vetor_tamanho = mysqli_fetch_array($tabela_tamanho)) {

                        $sql_tipo_final = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tamanho[id_tamanho]'");
                        $vetor_tipo_final = mysqli_fetch_array($sql_tipo_final);

                        $sql_item_tamanho = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '$vetor_tamanho[id_basico]'");

                        $vetor_item_tamanho = mysqli_fetch_array($sql_item_tamanho);

                        ?>
                        <option value="<?php echo $vetor_tamanho['id_basico']; ?>" <?php if (mysqli_num_rows($sql_item_tamanho) > 0) { ?>selected="selected"<?php } ?>><?php echo $vetor_tipo_final['titulo']; ?></option>

                        <?php $id_tamanho .= $vetor_item_tamanho['id_itemtabela']; } ?>
                      </select>
                    </div>
                  </div>

                </div>

                <h3>Embalagem do Convite</h3>

                <hr>

                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Embalagem</label>
                      <select name="embalagem" id="embalagens" class="form-control">
                        <option value="">Escolha o Tamanho</option>
                        <?php 

                        $tabela_embalagens = mysqli_query($con, "SELECT DISTINCT(id_itemtabela) FROM tabela_basico_itens WHERE id_basico = '$id_tamanho' and id_tipo = '2' order by id_item ASC");

                        while($vetor_embalagem = mysqli_fetch_array($tabela_embalagens)) {

                        $sql_tipo_final1 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_embalagem[id_itemtabela]'");
                        $vetor_tipo_final1 = mysqli_fetch_array($sql_tipo_final1);

                        $sql_item_embalagem = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '$vetor_embalagem[id_itemtabela]'");

                        ?>
                        <option value="<?php echo $vetor_embalagem['id_itemtabela']; ?>" <?php if (mysqli_num_rows($sql_item_embalagem) > 0) { ?>selected="selected"<?php } ?>><?php echo $vetor_tipo_final1['titulo']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Acabamento Interno da Embalagem</label>
                      <select name="acabamentoembalagem[]" multiple="" id="acabamentoembalagens" class="form-control select2">
                        <option value="">Escolha o Tamanho</option>
                        <?php 

                        $tabela_acabamento = mysqli_query($con, "SELECT DISTINCT(id_itemtabela) FROM tabela_basico_itens WHERE id_basico = '$id_tamanho' and id_tipo = '3' order by id_item ASC");

                        while($vetor_acabamento = mysqli_fetch_array($tabela_acabamento)) {

                        $sql_tipo_final2 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_acabamento[id_itemtabela]'");
                        $vetor_tipo_final2 = mysqli_fetch_array($sql_tipo_final2);

                        $sql_item_acabamento = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '$vetor_acabamento[id_itemtabela]'");

                        ?>
                        <option value="<?php echo $vetor_acabamento['id_itemtabela']; ?>" <?php if (mysqli_num_rows($sql_item_acabamento) > 0) { ?>selected="selected"<?php } ?>><?php echo $vetor_tipo_final2['titulo']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">

                      <label>Acabamento Externo da Embalagem</label>

                      <table width="100%" class="table table-bordered table-striped">

                        <tr>

                          <?php

                          $tabela_opcostura = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '10'");
                          $vetor_opcostura = mysqli_fetch_array($tabela_opcostura);

                          $tabela_opcinta = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '49'");
                          $vetor_opcinta = mysqli_fetch_array($tabela_opcinta);

                          ?>
                          
                          <td><input type="checkbox" name="opcostura" value="10" <?php if(mysqli_num_rows($tabela_opcostura) > 0) { ?>checked <?php } ?>> Costura  <?php if(mysqli_num_rows($tabela_opcostura) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opcostura['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                          <td><input type="checkbox" name="opcinta" value="49" <?php if(mysqli_num_rows($tabela_opcinta) > 0) { ?>checked <?php } ?>> Cinta  <?php if(mysqli_num_rows($tabela_opcinta) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opcinta['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>

                        </tr>

                        <?php

                          $tabela_opcosturaespecial = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '73'");
                          $vetor_opcosturaespecial = mysqli_fetch_array($tabela_opcosturaespecial);

                          $tabela_opjanelaacrilico = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '50'");
                          $vetor_opjanelaacrilico = mysqli_fetch_array($tabela_opjanelaacrilico);

                          ?>

                        <tr>
                          
                          <td><input type="checkbox" name="opcosturaespecial" value="73" <?php if(mysqli_num_rows($tabela_opcosturaespecial) > 0) { ?>checked <?php } ?>> Costura especial  <?php if(mysqli_num_rows($tabela_opcosturaespecial) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opcosturaespecial['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                          <td><input type="checkbox" name="opjanelaacrilico" value="50" <?php if(mysqli_num_rows($tabela_opjanelaacrilico) > 0) { ?>checked <?php } ?>> Janela de acrílico  <?php if(mysqli_num_rows($tabela_opjanelaacrilico) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opjanelaacrilico['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>

                        </tr>

                        <?php

                          $tabela_opinsertacrilico = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '44'");
                          $vetor_opinsertacrilico = mysqli_fetch_array($tabela_opinsertacrilico);

                          $tabela_ophotstamping = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '51'");
                          $vetor_ophotstamping = mysqli_fetch_array($tabela_ophotstamping);

                        ?>

                        <tr>
                          
                          <td><input type="checkbox" name="opinsertacrilico" value="44" <?php if(mysqli_num_rows($tabela_opinsertacrilico) > 0) { ?>checked <?php } ?>> Insert de acrílico  <?php if(mysqli_num_rows($tabela_opinsertacrilico) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opinsertacrilico['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                          <td><input type="checkbox" name="ophotstamping" value="51" <?php if(mysqli_num_rows($tabela_ophotstamping) > 0) { ?>checked <?php } ?>> Hot stamping  <?php if(mysqli_num_rows($tabela_ophotstamping) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_ophotstamping['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>

                        </tr>

                        <?php

                          $tabela_opbaixorelevo = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '45'");
                          $vetor_opbaixorelevo = mysqli_fetch_array($tabela_opbaixorelevo);

                          $tabela_opvernizlocalizado = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '52'");
                          $vetor_opvernizlocalizado = mysqli_fetch_array($tabela_opvernizlocalizado);

                        ?>

                        <tr>
                          
                          <td><input type="checkbox" name="opbaixorelevo" value="45" <?php if(mysqli_num_rows($tabela_opbaixorelevo) > 0) { ?>checked <?php } ?>> Baixo Relevo  <?php if(mysqli_num_rows($tabela_opbaixorelevo) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opbaixorelevo['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                          <td><input type="checkbox" name="opvernizlocalizado" value="52" <?php if(mysqli_num_rows($tabela_opvernizlocalizado) > 0) { ?>checked <?php } ?>> Verniz Localizado  <?php if(mysqli_num_rows($tabela_opvernizlocalizado) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opvernizlocalizado['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>

                        </tr>

                        <?php

                          $tabela_opcortealaser = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '46'");
                          $vetor_opcortealaser = mysqli_fetch_array($tabela_opcortealaser);

                          $tabela_opgravacaoalaser = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '53'");
                          $vetor_opgravacaoalaser = mysqli_fetch_array($tabela_opgravacaoalaser);

                        ?>

                        <tr>
                          
                          <td><input type="checkbox" name="opcortealaser" value="46" <?php if(mysqli_num_rows($tabela_opcortealaser) > 0) { ?>checked <?php } ?>> Corte a laser  <?php if(mysqli_num_rows($tabela_opcortealaser) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opcortealaser['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                          <td><input type="checkbox" name="opgravacaoalaser" value="53" <?php if(mysqli_num_rows($tabela_opgravacaoalaser) > 0) { ?>checked <?php } ?>> Gravação a laser  <?php if(mysqli_num_rows($tabela_opgravacaoalaser) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opgravacaoalaser['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>

                        </tr>

                        <?php

                          $tabela_opmedalhademetal = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '47'");
                          $vetor_opmedalhademetal = mysqli_fetch_array($tabela_opmedalhademetal);

                          $tabela_opsuporteacrilico = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '54'");
                          $vetor_opsuporteacrilico = mysqli_fetch_array($tabela_opsuporteacrilico);

                        ?>

                        <tr>
                          
                          <td><input type="checkbox" name="opmedalhademetal" value="47" <?php if(mysqli_num_rows($tabela_opmedalhademetal) > 0) { ?>checked <?php } ?>> Medalha de metal  <?php if(mysqli_num_rows($tabela_opmedalhademetal) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opmedalhademetal['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                          <td><input type="checkbox" name="opsuporteacrilico" value="54" <?php if(mysqli_num_rows($tabela_opsuporteacrilico) > 0) { ?>checked <?php } ?>> Suporte acrílico  <?php if(mysqli_num_rows($tabela_opsuporteacrilico) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opsuporteacrilico['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>

                        </tr>

                        <?php

                          $tabela_opaplicacaoacrilico = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '48'");
                          $vetor_opaplicacaoacrilico = mysqli_fetch_array($tabela_opaplicacaoacrilico);

                          $tabela_opsuportemadeira = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '55'");
                          $vetor_opsuportemadeira = mysqli_fetch_array($tabela_opsuportemadeira);

                        ?>

                        <tr>
                          
                          <td><input type="checkbox" name="opaplicacaoacrilico" value="48" <?php if(mysqli_num_rows($tabela_opaplicacaoacrilico) > 0) { ?>checked <?php } ?>> Aplicação acrílico  <?php if(mysqli_num_rows($tabela_opaplicacaoacrilico) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opaplicacaoacrilico['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                          <td><input type="checkbox" name="opsuportemadeira" value="55" <?php if(mysqli_num_rows($tabela_opsuportemadeira) > 0) { ?>checked <?php } ?>> Suporte de madeira  <?php if(mysqli_num_rows($tabela_opsuportemadeira) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_opaplicacaoacrilico['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>

                        </tr>

                      </table>

                    </div>
                  </div>

                </div>

                <h3>Convite</h3>

                <hr>

                <div class="row">

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Capa</label>
                      <select name="capa" id="capa" class="form-control">
                        <option value="">Escolha o Tamanho</option>
                        <?php 

                        $tabela_capa = mysqli_query($con, "SELECT DISTINCT(id_itemtabela) FROM tabela_basico_itens WHERE id_basico = '$id_tamanho' and id_tipo = '5' order by id_item ASC");

                        while($vetor_capa = mysqli_fetch_array($tabela_capa)) {

                        $sql_tipo_final4 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_capa[id_itemtabela]'");
                        $vetor_tipo_final4 = mysqli_fetch_array($sql_tipo_final4);

                        $sql_item_capa = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '$vetor_capa[id_itemtabela]'");

                        ?>
                        <option value="<?php echo $vetor_capa['id_itemtabela']; ?>" <?php if (mysqli_num_rows($sql_item_capa) > 0) { ?>selected="selected"<?php } ?>><?php echo $vetor_tipo_final4['titulo']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Acabamento da Capa</label>
                      <select name="acabamentocapa[]" multiple="" id="acabamentocapa" class="form-control select2">
                        <option value="">Escolha o Tamanho</option>
                        <?php 

                        $tabela_acabamentocapa = mysqli_query($con, "SELECT DISTINCT(id_itemtabela) FROM tabela_basico_itens WHERE id_basico = '$id_tamanho' and id_tipo = '6' order by id_item ASC");

                        while($vetor_acabamentocapa = mysqli_fetch_array($tabela_acabamentocapa)) {

                        $sql_tipo_final5 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_acabamentocapa[id_itemtabela]'");
                        $vetor_tipo_final5 = mysqli_fetch_array($sql_tipo_final5);

                        $sql_item_acabamentocapa = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '$vetor_acabamentocapa[id_itemtabela]'");

                        ?>
                        <option value="<?php echo $vetor_acabamentocapa['id_itemtabela']; ?>" <?php if (mysqli_num_rows($sql_item_acabamentocapa) > 0) { ?>selected="selected"<?php } ?>><?php echo $vetor_tipo_final5['titulo']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Sobrecapa/Encarte</label>
                      <select name="sobrecapaencarte" id="sobrecapaencarte" class="form-control">
                        <option value="">Escolha o Tamanho</option>
                        <?php 

                        $tabela_sobrecapa = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_basico = '$id_tamanho' and id_tipo = '4' order by id_item ASC");

                        while($vetor_sobrecapa = mysqli_fetch_array($tabela_sobrecapa)) {

                        $sql_tipo_final3 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_sobrecapa[id_itemtabela]'");
                        $vetor_tipo_final3 = mysqli_fetch_array($sql_tipo_final3);

                        $sql_item_sobrecapa = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '$vetor_sobrecapa[id_itemtabela]'");

                        ?>
                        <option value="<?php echo $vetor_sobrecapa['id_itemtabela']; ?>" <?php if (mysqli_num_rows($sql_item_sobrecapa) > 0) { ?>selected="selected"<?php } ?>><?php echo $vetor_tipo_final3['titulo']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                </div>

                <h3>Componentes Padrão do Miolo</h3>

                <hr>

                <?php

                $sql_basico = mysqli_query($con, "select * from tabela_basico where id_basico = '$id_tamanho'");
                $vetor_basico = mysqli_fetch_array($sql_basico);

                ?>

                <div class="row">
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      
                      <table width="60%" class="table table-bordered table-striped">
                        <tr>
                          <td  width="10%"><strong>Check</strong></td>
                          <td><strong>Itens</strong></td>
                          <td><strong>Papel (Cadastrar)</strong></td>
                          <td width="15%"><strong>Quant.</strong></td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="capabloco" checked=""></td>
                          <td>Capa do Bloco (Capa Mole)</td>
                          <td>Couchê Fosco 250g</td>
                          <td>
                            <select name="qtdcapabloco" id="qtdcapabloco" class="form-control">
                              <option value="1">1</option>
                            </select>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="paginaspadrao" checked=""></td>
                          <td>Páginas Padrão</td>
                          <td>Couchê Fosco 170g</td>
                          <td>
                            <select name="qtdpaginaspadrao" id="qtdpaginaspadrao" class="form-control">
                              <option value="<?php echo $vetor_basico['paginas']; ?>"><?php echo $vetor_basico['paginas']; ?></option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="paginaspersonalizadas" checked=""></td>
                          <td>Páginas Personalizadas</td>
                          <td>Couchê Fosco 170g</td>
                          <td>
                            <select name="qtdpaginaspersonalizadas" id="qtdpaginaspersonalizadas" class="form-control">
                              <option value="<?php echo $vetor_basico['paginaspersonalizadas']; ?>"><?php echo $vetor_basico['paginaspersonalizadas']; ?></option>
                            </select>
                        </tr>
                        
                      </table>

                    </div>
                  </div>

                </div>

                <h3>Componentes Extras do Miolo</h3>

                <hr>

                <div class="row">
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      
                      <table width="60%" class="table table-bordered table-striped">
                        <tr>
                          <td  width="10%"><strong>Check</strong></td>
                          <td><strong>Itens</strong></td>
                          <td><strong>Papel (Cadastrar)</strong></td>
                          <td width="15%"><strong>Quant.</strong></td>
                          <td width="3%"><strong></strong></td>
                        </tr>

                        <?php

                          $tabela_paginasextras = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '34'");
                          $vetor_tabela_paginasextras = mysqli_fetch_array($tabela_paginasextras);

                        ?>

                        <tr>
                          <td><input type="checkbox" name="paginasextras" value="34" <?php if(mysqli_num_rows($tabela_paginasextras) > 0) { ?>checked <?php } ?>></td>
                          <td>Páginas Extras</td>
                          <td>Couchê Fosco 170g</td>
                          <td><input type="number" name="qtdpaginasextras" <?php if(mysqli_num_rows($tabela_paginasextras) > 0) { ?> value="<?php echo $vetor_tabela_paginasextras['qtd']; ?>" <?php } ?> class="form-control"></td>
                          <td><?php if(mysqli_num_rows($tabela_paginasextras) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_tabela_paginasextras['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                        </tr>

                        <?php

                          $tabela_paginasextraspersonalizadas = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '75'");
                          $vetor_tabela_paginasextraspersonalizadas = mysqli_fetch_array($tabela_paginasextraspersonalizadas);

                        ?>

                        <tr>
                          <td><input type="checkbox" name="paginasextraspersonalizadas" value="75" <?php if(mysqli_num_rows($tabela_paginasextraspersonalizadas) > 0) { ?>checked <?php } ?>></td>
                          <td>Páginas Extras Personalizadas</td>
                          <td>Couchê Fosco 170g</td>
                          <td><input type="number" name="qtdpaginasextraspersonalizadas" <?php if(mysqli_num_rows($tabela_paginasextraspersonalizadas) > 0) { ?> value="<?php echo $vetor_tabela_paginasextraspersonalizadas['qtd']; ?>" <?php } ?> class="form-control"></td>
                          <td><?php if(mysqli_num_rows($tabela_paginasextraspersonalizadas) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_tabela_paginasextraspersonalizadas['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                        </tr>

                        <?php

                          $tabela_miniposter = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '36'");
                          $vetor_tabela_miniposter = mysqli_fetch_array($tabela_miniposter);

                        ?>

                        <tr>
                          <td><input type="checkbox" name="miniposter" value="36" <?php if(mysqli_num_rows($tabela_miniposter) > 0) { ?>checked <?php } ?>></td>
                          <td>Mini Poster</td>
                          <td>Couchê Fosco 170g</td>
                          <td><input type="number" name="qtdminiposter" <?php if(mysqli_num_rows($tabela_miniposter) > 0) { ?> value="<?php echo $vetor_tabela_miniposter['qtd']; ?>" <?php } ?> class="form-control"></td>
                          <td><?php if(mysqli_num_rows($tabela_miniposter) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_tabela_miniposter['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                        </tr>

                        <?php

                          $tabela_vegetalcomum = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '37'");
                          $vetor_tabela_vegetalcomum = mysqli_fetch_array($tabela_vegetalcomum);

                        ?>

                        <tr>
                          <td><input type="checkbox" name="vegetalcomum" value="37" <?php if(mysqli_num_rows($tabela_vegetalcomum) > 0) { ?>checked <?php } ?>></td>
                          <td>Página Vegetal Comum</td>
                          <td>Vegetal 90g</td>
                          <td><input type="number" name="qtdvegetalcomum" <?php if(mysqli_num_rows($tabela_vegetalcomum) > 0) { ?> value="<?php echo $vetor_tabela_vegetalcomum['qtd']; ?>" <?php } ?> class="form-control"></td>
                          <td><?php if(mysqli_num_rows($tabela_vegetalcomum) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_tabela_vegetalcomum['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                        </tr>

                        <?php

                          $tabela_vegetalpersonalizado = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '38'");
                          $vetor_tabela_vegetalpersonalizado = mysqli_fetch_array($tabela_vegetalpersonalizado);

                        ?>

                        <tr>
                          <td><input type="checkbox" name="vegetalpersonalizado" <?php if(mysqli_num_rows($tabela_vegetalpersonalizado) > 0) { ?>checked <?php } ?> value="38"></td>
                          <td>Página Vegetal Personalizado</td>
                          <td>Vegetal 90g</td>
                          <td><input type="number" name="qtdvegetalpersonalizado" <?php if(mysqli_num_rows($tabela_vegetalpersonalizado) > 0) { ?> value="<?php echo $vetor_tabela_vegetalpersonalizado['qtd']; ?>" <?php } ?> class="form-control"></td>
                          <td><?php if(mysqli_num_rows($tabela_vegetalpersonalizado) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_tabela_vegetalpersonalizado['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                        </tr>

                        <?php

                          $tabela_acetatocomum = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '71'");
                          $vetor_tabela_acetatocomum = mysqli_fetch_array($tabela_acetatocomum);

                        ?>

                        <tr>
                          <td><input type="checkbox" name="acetatocomum" <?php if(mysqli_num_rows($tabela_acetatocomum) > 0) { ?>checked <?php } ?> value="71"></td>
                          <td>Página Transparência Comum</td>
                          <td>Acetato transparente</td>
                          <td><input type="number" name="qtdacetatocomum" <?php if(mysqli_num_rows($tabela_acetatocomum) > 0) { ?> value="<?php echo $vetor_tabela_acetatocomum['qtd']; ?>" <?php } ?> class="form-control"></td>
                          <td><?php if(mysqli_num_rows($tabela_acetatocomum) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_tabela_acetatocomum['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                        </tr>

                        <?php

                          $tabela_acetatopersonalizado = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '72'");
                          $vetor_tabela_acetatopersonalizado = mysqli_fetch_array($tabela_acetatopersonalizado);

                        ?>

                        <tr>
                          <td><input type="checkbox" name="acetatopersonalizado" <?php if(mysqli_num_rows($tabela_acetatopersonalizado) > 0) { ?>checked <?php } ?> value="72"></td>
                          <td>Página Transparência Personalizado</td>
                          <td>Acetato transparente</td>
                          <td><input type="number" name="qtdacetatopersonalizado" <?php if(mysqli_num_rows($tabela_acetatopersonalizado) > 0) { ?> value="<?php echo $vetor_tabela_acetatopersonalizado['qtd']; ?>" <?php } ?> class="form-control"></td>
                          <td><?php if(mysqli_num_rows($tabela_acetatopersonalizado) > 0) { ?><a href="excluiritemprodorc.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id2=<?php echo $vetor_tabela_acetatopersonalizado['id_item']; ?>"><i class="fa fa-close"></i></a><?php } ?></td>
                        </tr>
                        </table>

                    </div>
                  </div>

                </div>

                <hr>

              </div>

                <?php } if($vetor_produto['id_produto'] == 4) { ?>


                <div class="row">

                  <div class="col-lg-4">
                    <fieldset class="form-group">
                      <label class="form-label semibold" for="exampleInput">Quantidade</label>
                      <input type="number" name="qtdconvites1" value="<?php echo $vetor_produto['qtd']; ?>" class="form-control">
                    </fieldset>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Tamanho</label>
                      <select name="tamanho1" id="tamanhos1" class="form-control">
                        <?php

                        $tabela_tamanho = mysqli_query($con, "SELECT * FROM tabela_basico WHERE id_produto = '4' order by id_produto ASC");

                        while($vetor_tamanho = mysqli_fetch_array($tabela_tamanho)) {

                        $sql_tipo_final = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tamanho[id_tamanho]'");
                        $vetor_tipo_final = mysqli_fetch_array($sql_tipo_final);

                        $sql_item_tamanho = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '$vetor_tamanho[id_basico]'");

                        $vetor_item_tamanho = mysqli_fetch_array($sql_item_tamanho);

                        ?>
                        <option value="<?php echo $vetor_tamanho['id_basico']; ?>" <?php if (mysqli_num_rows($sql_item_tamanho) > 0) { ?>selected="selected"<?php } ?>><?php echo $vetor_tipo_final['titulo']; ?></option>

                        <?php $id_tamanho .= $vetor_item_tamanho['id_itemtabela']; } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Embalagem</label>
                      <select name="embalagem1" id="embalagens1" class="form-control">
                        <?php 

                        $tabela_embalagens = mysqli_query($con, "SELECT DISTINCT(id_itemtabela) FROM tabela_basico_itens WHERE id_basico = '$id_tamanho' and id_tipo = '2' order by id_item ASC");

                        while($vetor_embalagem = mysqli_fetch_array($tabela_embalagens)) {

                        $sql_tipo_final1 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_embalagem[id_itemtabela]'");
                        $vetor_tipo_final1 = mysqli_fetch_array($sql_tipo_final1);

                        $sql_item_embalagem = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '$vetor_embalagem[id_itemtabela]'");

                        ?>
                        <option value="<?php echo $vetor_embalagem['id_itemtabela']; ?>" <?php if (mysqli_num_rows($sql_item_embalagem) > 0) { ?>selected="selected"<?php } ?>><?php echo $vetor_tipo_final1['titulo']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Acabamento da Embalagem</label>
                      <select name="acabamentoembalagem1[]" multiple="" id="acabamentoembalagens1" class="form-control select2">
                        <?php 

                        $tabela_acabamento = mysqli_query($con, "SELECT DISTINCT(id_itemtabela) FROM tabela_basico_itens WHERE id_basico = '$id_tamanho' and id_tipo = '3' order by id_item ASC");

                        while($vetor_acabamento = mysqli_fetch_array($tabela_acabamento)) {

                        $sql_tipo_final2 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_acabamento[id_itemtabela]'");
                        $vetor_tipo_final2 = mysqli_fetch_array($sql_tipo_final2);

                        $sql_item_acabamento = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '$vetor_acabamento[id_itemtabela]'");

                        ?>
                        <option value="<?php echo $vetor_acabamento['id_itemtabela']; ?>" <?php if (mysqli_num_rows($sql_item_acabamento) > 0) { ?>selected="selected"<?php } ?>><?php echo $vetor_tipo_final2['titulo']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Páginas (capas e contracapas inclusas)</label>
                      <select name="paginas" id="paginas" class="form-control">
                        <?php 

                        $tabela_paginas = mysqli_query($con, "SELECT DISTINCT(id_itemtabela) FROM tabela_basico_itens WHERE id_basico = '$id_tamanho' and id_tipo = '10' order by id_item ASC");

                        while($vetor_paginas = mysqli_fetch_array($tabela_paginas)) {

                        $sql_tipo_final3 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_paginas[id_itemtabela]'");
                        $vetor_tipo_final3 = mysqli_fetch_array($sql_tipo_final3);

                        $sql_item_pagina = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id1' AND id_produto = '$id' and id_itemtabela = '$vetor_paginas[id_itemtabela]'");

                        ?>
                        <option value="<?php echo $vetor_paginas['id_itemtabela']; ?>" <?php if (mysqli_num_rows($sql_item_pagina) > 0) { ?>selected="selected"<?php } ?>><?php echo $vetor_tipo_final3['titulo']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                </div>

                <?php } ?>
                
        
            <button type="submit" class="btn btn-primary"  style="    float: left;">Alterar</button>
                
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
    <strong>Todos direitos reservados Studio Graff.
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

<link rel="stylesheet" href="../layout/bower_components/select2/dist/css/select2.min.css">
<!-- AdminLTE App -->
<script src="../layout/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../layout/dist/js/demo.js"></script>
<!-- page script -->
<script src="../layout/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
  
  $('.select2').select2()

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
<?php } ?>