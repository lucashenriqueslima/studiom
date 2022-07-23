<?php

	include"../includes/conexao.php";

	 
	 session_start();

	if($_SESSION['id_formando'] == NULL) {
	
	echo"<script language=\"JavaScript\">
	location.href=\"index.php\";
	</script>";
	
	} else {
		
	$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);

	$id_pacote = $_GET['id_pacote'];
  $id = $_GET['id'];

  $sql_pacote_itens = mysqli_query($con, "select * from pacotes_itens_album where id_item = '$id_pacote'");
  $vetor_pacote_itens = mysqli_fetch_array($sql_pacote_itens);

  $sql_pacote = mysqli_query($con, "select * from pacotes where id_pacote = '$vetor_pacote_itens[id_pacote]'");
  $vetor_pacote = mysqli_fetch_array($sql_pacote);

  if($vetor_cadastro['comissao'] == 2) {

  $valorvenda = $vetor_pacote_itens['valorcomissao'];

  }

  else {

  $valorvenda = $vetor_pacote_itens['valor'];

  }
	
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Studio M Fotografia</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Studiom Fotografia" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery.min.js"> </script>
<!-- Mainly scripts -->
<script src="js/jquery.metisMenu.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<link href="css/custom.css" rel="stylesheet">
<script src="js/custom.js"></script>
<script src="js/screenfull.js"></script>
		<script>
		$(function () {
			$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

			if (!screenfull.enabled) {
				return false;
			}

			

			$('#toggle').click(function () {
				screenfull.toggle($('#container')[0]);
			});
			

			
		});
		</script>

<!----->

<!--pie-chart--->
<script src="js/pie-chart.js" type="text/javascript"></script>
 <script type="text/javascript">

        $(document).ready(function () {
            $('#demo-pie-1').pieChart({
                barColor: '#3bb2d0',
                trackColor: '#eee',
                lineCap: 'round',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-2').pieChart({
                barColor: '#fbb03b',
                trackColor: '#eee',
                lineCap: 'butt',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-3').pieChart({
                barColor: '#ed6498',
                trackColor: '#eee',
                lineCap: 'square',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

           
        });

    </script>
<!--skycons-icons-->
<script src="js/skycons.js"></script>
<!--//skycons-icons-->

<style type="text/css">
  .circle img {
    background-color: #ddd;
    border-radius: 100%;
    height: 100px;
    width: 100px;
    object-fit: cover;
  }
</style>

<script src="../jquery-1.3.2.min.js" type="text/javascript"></script>
  <script type="text/javascript">  
$(document).ready(function(){  

        $("#palco1 > div").hide(); 
        $("#tipobusca").change(function(){  
                $("#palco1 > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
        $("#palco_cartao > div").hide();  
        $("#cartao").change(function(){  
                $("#palco_cartao > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        });
        $("#palco_boleto > div").hide();  
        $("#boleto").change(function(){  
                $("#palco_boleto > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        });   
});  


</script>
<script>
    
      function ativarInputDataContrato(){
        var lista = document.getElementById("tipobusca");
        var input = document.getElementById("qtdparcelas");
        if(lista.value == "2"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("diavencimento");
        if(lista.value == "2"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("anexo");
        if(lista.value == "4"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("qtdparcelas1");
        if(lista.value == "5"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("diavencimento1");
        if(lista.value == "5"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("qtdparcelas2");
        if(lista.value == "3"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("diavencimento2");
        if(lista.value == "3"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("qtdparcelas3");
        if(lista.value == "5"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("diavencimento3");
        if(lista.value == "5"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }

        var lista = document.getElementById("tipobusca");
      }
      
      
    </script>

</head>
<body>
<div id="wrapper">

<!----->
        <nav class="navbar-default navbar-static-top" role="navigation">
             <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <h1> <a class="navbar-brand" href="index.php">Área do Formando</a></h1>         
			   </div>
			 <div class=" border-bottom">
        	<div class="full-left">
        	  Seja Bem Vindo, <?php echo $vetor_cadastro['nome']; ?>.
            <div class="clearfix"> </div>
           </div>
     
       
            <!-- Brand and toggle get grouped for better mobile display -->
		 
		   <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="drop-men" >
		        <ul class=" nav_1">
		           
		    		
					<li class="dropdown">
		            </li>
		           
		        </ul>
		     </div><!-- /.navbar-collapse -->
			<div class="clearfix">
       
     </div>
	  
		    <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">

                <div align="center"><div class="circle"><img src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"></div></div>
                
                <ul class="nav" id="side-menu">
				
                    <?php include"includes/menu.php"; ?>
                    
                </ul>
            </div>
			</div>
        </nav>
        <div id="page-wrapper" class="gray-bg dashbard-1">
       <div class="content-main">
 
  		<!--banner-->	
		    <div class="banner">
		   
				<h2>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<span>Minhas Compras</span>
				</h2>
		    </div>
		<!--//banner-->
		<!--content-->
		<div class="content-top">
			
			
		<div class="grid-form">

		  <div class="grid-form1">

			<form action="compra_finaliza_fotografia.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

            <input type="hidden" name="cpf" value="<?php echo $cpf; ?>">

            <div class="row">
              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="exampleInput">Forma de Pagamento</label>
                  <select name="formapag" id="tipobusca" class="form-control" onchange="ativarInputDataContrato()" required="">
                    <option value="" selected="">Selecione...</option>
                    <?php

                    $sql_formas = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote'");

                    while($vetor_formas = mysqli_fetch_array($sql_formas)) { 

                    $sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_formas[id_forma]'");
                    $vetor_forma = mysqli_fetch_array($sql_forma);

                    ?>
                    <option value="<?php echo $vetor_forma['id_forma']; ?>"><?php echo $vetor_forma['nome']; ?></option>
                    <?php } ?>
                  </select>
                </fieldset>
              </div>
            </div>

          <div id="palco1">
          <div id="2">

            <?php 
            $sql_formas_2 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '2'"); 
            $vetor_forma_2 = mysqli_fetch_array($sql_formas_2);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_2['descricao']; ?>
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas2" id = "qtdparcelas2" class="form-control">
                  <option value="" selected="">Selecione...</option>

                  <?php


                  for($f=1; $f<=$vetor_forma_2['qtdparcelas']; $f++) { 

                  $totalparcela = $valorvenda / $f;

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php }  ?>

                </select>

              </div>
              </div>

          </div>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Datas de Vencimento</label>
                
                <select name="diavencimento" id = "diavencimento" class="form-control">
                  <option value="" selected="">Selecione...</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                </select>

              </div>
              </div>

          </div>
          </div>

          <div id="15">

            <?php 
            $sql_formas_15 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '15'"); 
            $vetor_forma_15 = mysqli_fetch_array($sql_formas_15);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_15['descricao']; ?>
                </div>
              </div>
              </div>

          </div>

          <div id="9">

            <?php 
            $sql_formas_9 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '9'"); 
            $vetor_forma_9 = mysqli_fetch_array($sql_formas_9);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_9['descricao']; ?>
                </div>
              </div>
              </div>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas9" id = "qtdparcelas9" class="form-control">
                  <option value="" selected="">Selecione...</option>

                  <?php


                  for($f=1; $f<=$vetor_forma_9['qtdparcelas']; $f++) { 

                  $totalparcela = $valorvenda / $f;

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php }  ?>

                </select>

              </div>
              </div>

          </div>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Datas de Vencimento</label>
                
                <select name="diavencimento9" id = "diavencimento9" class="form-control">
                  <option value="" selected="">Selecione...</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                </select>

              </div>
              </div>

          </div>

          </div>

          <div id="8">

            <?php 
            $sql_formas_8 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '8'"); 
            $vetor_forma_8 = mysqli_fetch_array($sql_formas_8);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_8['descricao']; ?>
                </div>
              </div>
              </div>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas8" id = "qtdparcelas8" class="form-control">
                  <option value="" selected="">Selecione...</option>

                  <?php


                  for($f=1; $f<=$vetor_forma_8['qtdparcelas']; $f++) { 

                  $totalparcela = $valorvenda / $f;

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php }  ?>

                </select>

              </div>
              </div>

          </div>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Datas de Vencimento</label>
                
                <select name="diavencimento8" id = "diavencimento8" class="form-control">
                  <option value="" selected="">Selecione...</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                </select>

              </div>
              </div>

          </div>

          </div>

          <div id="18">

            <?php 
            $sql_formas_18 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '18'"); 
            $vetor_forma_18 = mysqli_fetch_array($sql_formas_18);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_18['descricao']; ?>
                </strong>
                </div>
              </div>
              </div>
              
          </div>

          <div id="3">

            <?php 
            $sql_formas_3 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '3'"); 
            $vetor_forma_3 = mysqli_fetch_array($sql_formas_3);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_3['descricao']; ?>
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas3" id = "qtdparcelas2" class="form-control">
                  <option value="" selected="">Selecione...</option>

                  <?php


                  for($f=1; $f<=$vetor_forma_3['qtdparcelas']; $f++) { 

                  $totalparcela = $valorvenda / $f;

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php }  ?>

                </select>

              </div>
              </div>

          </div>

          </div>

          <div id="6">

          <?php 
            $sql_formas_6 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '6'"); 
            $vetor_forma_6 = mysqli_fetch_array($sql_formas_6);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_6['descricao']; ?>
                </div>
              </div>
              </div>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas6" id = "qtdparcelas6" class="form-control">
                  <option value="" selected="">Selecione...</option>

                  <?php


                  for($f=1; $f<=$vetor_forma_6['qtdparcelas']; $f++) { 

                  $totalparcela = $valorvenda / $f;

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php }  ?>

                </select>

              </div>
              </div>

          </div>

          </div>

          <div id="7">

          <?php 
            $sql_formas_7 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '7'"); 
            $vetor_forma_7 = mysqli_fetch_array($sql_formas_7);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_7['descricao']; ?>
                </div>
              </div>
              </div>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas7" id = "qtdparcelas7" class="form-control">
                  <option value="" selected="">Selecione...</option>

                  <?php


                  for($f=1; $f<=$vetor_forma_7['qtdparcelas']; $f++) { 

                  $totalparcela = $valorvenda / $f;

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php }  ?>

                </select>

              </div>
              </div>

          </div>

          </div>

          <div id="4">

            <?php 
            $sql_formas_4 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '4'"); 
            $vetor_forma_4 = mysqli_fetch_array($sql_formas_4);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_4['descricao']; ?>
                 <br>
                 <strong>Valor final para transferência: 
                 <?php 

                 $percentual = $vetor_pacote['desconto'] / 100.0; 

                 $valorfinal = $valorvenda - ($percentual * $valorvenda);

                 echo "R$".number_format($valorfinal,2,',','.');

                 ?>
                </strong>
                </div>
              </div>
              </div>
              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Comprovante de Transferência</label>

                <br>
                
                <input type="file" name="anexo" id = "anexo" class="form-control">

              </div>
              </div>

          </div>
          
          </div>

          <div id="12">

            <?php 
            $sql_formas_12 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '12'"); 
            $vetor_forma_12 = mysqli_fetch_array($sql_formas_12);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_12['descricao']; ?>
                 <br>
                 <strong>Valor final para transferência: 
                 <?php 

                 $percentual = $vetor_pacote['desconto'] / 100.0; 

                 $valorfinal = $valorvenda - ($percentual * $valorvenda);

                 echo "R$".number_format($valorfinal,2,',','.');

                 ?>
                </strong>
                </div>
              </div>
              </div>
          
          </div>

          <div id="13">

            <?php 
            $sql_formas_13 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '13'"); 
            $vetor_forma_13 = mysqli_fetch_array($sql_formas_13);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_13['descricao']; ?>
                 <br>
                 <strong>Valor final para transferência: 
                 <?php 

                 $percentual = $vetor_pacote['desconto'] / 100.0; 

                 $valorfinal = $valorvenda - ($percentual * $valorvenda);

                 echo "R$".number_format($valorfinal,2,',','.');

                 ?>
                </strong>
                </div>
              </div>
              </div>
          
          </div>

          <div id="5">
            
            <?php 
            $sql_formas_5 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '5'"); 
            $vetor_forma_5 = mysqli_fetch_array($sql_formas_5);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_5['descricao']; ?>
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas5" id = "qtdparcelas5" class="form-control">
                  <option value="" selected="">Selecione...</option>

                  <?php


                  for($f=1; $f<=$vetor_forma_5['qtdparcelas']; $f++) { 

                  $totalparcela = $valorvenda / $f;

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php }  ?>

                </select>

              </div>
              </div>

          </div>
          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Datas de Vencimento</label>
                
                <select name="diavencimento5" id = "diavencimento5" class="form-control">
                  <option value="" selected="">Selecione...</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                </select>

              </div>
              </div>

          </div>
          </div>

          <div id="10">
            
            <?php 
            $sql_formas_10 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '10'"); 
            $vetor_forma_10 = mysqli_fetch_array($sql_formas_10);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_10['descricao']; ?>
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas10" id = "qtdparcelas10" class="form-control">
                  <option value="" selected="">Selecione...</option>

                  <?php


                  for($f=1; $f<=$vetor_forma_10['qtdparcelas']; $f++) { 

                  $totalparcela = $valorvenda / $f;

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php }  ?>

                </select>

              </div>
              </div>

          </div>
          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Datas de Vencimento</label>
                
                <select name="diavencimento10" id = "diavencimento5" class="form-control">
                  <option value="" selected="">Selecione...</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                </select>

              </div>
              </div>

          </div>
          </div>

          <div id="11">
            
            <?php 
            $sql_formas_11 = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote' and id_forma = '11'"); 
            $vetor_forma_11 = mysqli_fetch_array($sql_formas_11);

            ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-info">
                 <?php echo $vetor_forma_11['descricao']; ?>
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas11" id = "qtdparcelas11" class="form-control">
                  <option value="" selected="">Selecione...</option>

                  <?php


                  for($f=1; $f<=$vetor_forma_11['qtdparcelas']; $f++) { 

                  $totalparcela = $valorvenda / $f;

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php }  ?>

                </select>

              </div>
              </div>

          </div>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Datas de Vencimento</label>
                
                <select name="diavencimento11" id = "diavencimento5" class="form-control">
                  <option value="" selected="">Selecione...</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                </select>

              </div>
              </div>

          </div>
          </div>

            <button type="submit" class="btn btn-primary"  style="    float: left;">Avançar</button>
                
              </form>

		  </div>

		</div>

		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
			
		</div>
		<!--//content-->


	 
		<!---->
<div class="copy">
            <p> &copy; 2019 Studiom Fotografia. Todos Direitos Reservados.</p>
	    </div>
		</div>
		<div class="clearfix"> </div>
       </div>
     </div>
<!---->
<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<script src="js/bootstrap.min.js"> </script>
</body>
</html>
<?php } ?>