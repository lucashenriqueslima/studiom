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

	$dataatual = date('Y-m-d');

   $sql_consulta = mysqli_query($con, "select * from vendas where id_venda = '$id' and status = '3'");

   if(mysqli_num_rows($sql_consulta) != 0) {

    echo "<script> alert('Compra já gravada, favor entrar em suas compras!')</script>";
    echo "<script> window.location.href='minhascompras.php'</script>";

    } else { 

   $id = $_GET['id'];

   $id = $_GET['id'];

   $sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
   $vetor_venda = mysqli_fetch_array($sql_venda);

   $selec1 = mysqli_query($con, "SELECT SUM(valor*qtd) as total FROM itens_venda_individual where id_venda = '$id'");
   $totalizador = mysqli_fetch_array($selec1);

   $sql_atualiza = mysqli_query($con, "update vendas SET valorvenda = '$totalizador[total]', status='2', iniciada = '2' where id_venda = '$id'");

   $sql_turma = mysqli_query($con, "select * from produtos_turma where id_turma = '$vetor_cadastro[turma]' order by id_produto DESC");
   $vetor_turma = mysqli_fetch_array($sql_turma);

   $data_inicial  = date('Y-m-d');
   $data_final  = $vetor_turma['dataentrega'];
   
  // Cria uma função que retorna o timestamp de uma data no formato AAAA-MM-DD
  function geraTimestamp($data) {
    $partes = explode('-',$data);
    return mktime(0, 0, 0, $partes[1], $partes[2], $partes[0]);
  }
   
  // Usa a função criada e pega o timestamp das duas datas:
  $time_inicial = geraTimestamp($data_inicial);
  $time_final = geraTimestamp($data_final);
   
  // Calcula a diferença de segundos entre as duas datas:
  $diferenca = $time_final - $time_inicial; // 19522800 segundos
   
  // Calcula a diferença de dias
  $dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
   
  // Exibe uma mensagem de resultado:
  $dias;

  $meses = $dias / 30;

  $mesesfinal = floor($meses);
	
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

<script src="../jquery-1.3.2.min.js" type="text/javascript"></script>
	<script type="text/javascript">  
$(document).ready(function(){  
        $("#palco > div").hide();  
        $("#produto").change(function(){  
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
        var input = document.getElementById("qtdparcelas2");
        if(lista.value == "3"){
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
      }
      
      
    </script>

    <script type="text/javascript">
              $(document).ready(function(){
                  $('#mesano').change(function(){
                      $('#parcelas').load('buscameses.php?mesano='+$('#mesano').val() );

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
            
            <form action="compra_finaliza.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

            <input type="hidden" name="cpf" value="<?php echo $cpf; ?>">

            <div class="row">
              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="exampleInput">Forma de Pagamento</label>
                  <select name="formapag" id="tipobusca" class="form-control" onchange="ativarInputDataContrato()" required="">
                  	<option value="" selected="">Selecione...</option>
                  	<?php

                  	$sql_formas = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]'");

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

              if($vetor_turma['mesano'] == 1) { 

              $sql_forma_item = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]' and id_forma = '2'");
              $vetor_forma_item = mysqli_fetch_array($sql_forma_item);

              ?>

              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas" id = "qtdparcelas" class="form-control" disabled required="true">
                  <option value="" selected="">Selecione...</option>

                  <?php

                  if($mesesfinal <= $vetor_forma_item['qtdparcelas']) { 

                  for($f=1; $f<=$mesesfinal; $f++) { 

                  $totalparcela = $totalizador['total'] / $f;

                  if($totalparcela < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php } } 

                  } else { 
                  
                  for($f=1; $f<=$vetor_forma_item['qtdparcelas']; $f++) { 

                  $totalparcela = $totalizador['total'] / $f;

                  if($totalparcela < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php } } } ?>

                </select>

              </div>
              </div>

          </div>

          <?php 

          } if($vetor_turma['mesano'] == 2) {  

          $sql_forma_item = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]' and id_forma = '2'");
          $vetor_forma_item = mysqli_fetch_array($sql_forma_item);

          ?>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Mês Início Pagamento</label>
                
                <select name="mesano" id="mesano" class="form-control">
                    <option value="" selected="selected">Selecione...</option>
                    <?php 

                    $startDate = strtotime($vetor_turma['dataencerramento']);
                    $endDate   = strtotime($vetor_turma['dataabertura']);

                    $currentDate = $endDate;

                    while ($currentDate <= $startDate) {

                    ?>
                    <option value="<?php echo date('Y-m',$currentDate); ?>_<?php echo $vetor_forma_item[id_item]; ?>_<?php echo $id; ?>"><?php $mes = date('m',$currentDate); $ano = date('Y',$currentDate); if($mes == 1) { echo "Janeiro de ".$ano; } if($mes == 2) { echo "Fevereiro de ".$ano; } if($mes == 3) { echo "Março de ".$ano; } if($mes == 4) { echo "Abril de ".$ano; } if($mes == 5) { echo "Maio de ".$ano; } if($mes == 6) { echo "Junho de ".$ano; } if($mes == 7) { echo "Julho de ".$ano; } if($mes == 8) { echo "Agosto de ".$ano; } if($mes == 9) { echo "Setembro de ".$ano; } if($mes == 10) { echo "Outubro de ".$ano; } if($mes == 11) { echo "Novembro de ".$ano; } if($mes == 12) { echo "Dezembro de ".$ano; } ?></option>
                    <?php $currentDate = strtotime( date('Y-m-d',$currentDate).' +1 month'); } ?>
                  </select>

              </div>
              </div>

          </div>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas" id="parcelas" class="form-control">
                <option value="">Escolha um Mês</option>
              </select>

              </div>
              </div>

          </div>

          <?php } ?>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Datas de Vencimento</label>
                
                <select name="diavencimento" id = "diavencimento" class="form-control">
                  <option value="" selected="">Selecione...</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                </select>

              </div>
              </div>

          </div>
          </div>

          <div id="3">

            <?php

              $sql_forma_item = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]' and id_forma = '3'");
              $vetor_forma_item = mysqli_fetch_array($sql_forma_item);

              ?>

            <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas2" id = "qtdparcelas2" class="form-control" disabled required="true">
                  <option value="" selected="">Selecione...</option>

                  <?php

                  if($mesesfinal <= $vetor_forma_item['qtdparcelas']) { 

                  for($f2=1; $f2<=$mesesfinal; $f2++) { 

                  $totalparcela2 = $totalizador['total'] / $f;

                  if($totalparcela2 < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f2; ?>"><?php echo $f2; ?>x R$<?php echo $num = number_format($totalparcela2,2,',','.'); ?></option>

                  <?php } } 

                  } else { 
                  
                  for($f2=1; $f2<=$vetor_forma_item['qtdparcelas']; $f2++) { 

                  $totalparcela2 = $totalizador['total'] / $f;

                  if($totalparcela2 < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f2; ?>"><?php echo $f2; ?>x R$<?php echo $num = number_format($totalparcela2,2,',','.'); ?></option>

                  <?php } } } ?>

                </select>

              </div>
              </div>

          </div>

          </div>

          <div id="4">

            <?php

              $sql_forma_item = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]' and id_forma = '4'");
              $vetor_forma_item = mysqli_fetch_array($sql_forma_item);

              ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-danger">
                 Para finalizar seu pedido favor efetuar a transferência e anexe o comprovante para finalizar seu termo de adesão individual.
                 <br>
                 Valor para transferência tem desconto de: <?php echo $vetor_turma['desconto']; ?>%.
                 <br>
                 <strong>Valor final para transferência: 
                 <?php 

                 $percentual = $vetor_turma['desconto'] / 100.0; 

                 $valorfinal = $totalizador['total'] - ($percentual * $totalizador['total']);

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

          <div id="5">

            <?php

              $sql_forma_item = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]' and id_forma = '5'");
              $vetor_forma_item = mysqli_fetch_array($sql_forma_item);

              ?>
              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas1" id = "qtdparcelas1" class="form-control" disabled required="true">
                  <option value="" selected="">Selecione...</option>

                  <?php

                  if($mesesfinal <= $vetor_forma_item['qtdparcelas']) { 

                  for($f1=1; $f1<=$mesesfinal; $f1++) { 

                  $totalparcela1 = $totalizador['total'] / $f1;

                  if($totalparcela1 < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f1; ?>"><?php echo $f1; ?>x R$<?php echo $num = number_format($totalparcela1,2,',','.'); ?></option>

                  <?php } } 

                  } else { 
                  
                  for($f1=1; $f1<=$vetor_forma_item['qtdparcelas']; $f1++) { 

                  $totalparcela1 = $totalizador['total'] / $f1;

                  if($totalparcela1 < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f1; ?>"><?php echo $f1; ?>x R$<?php echo $num = number_format($totalparcela1,2,',','.'); ?></option>

                  <?php } } } ?>

                </select>

              </div>
              </div>

          </div>
          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Datas de Vencimento</label>
                
                <select name="diavencimento1" id = "diavencimento1" class="form-control" disabled required="true">
                  <option value="" selected="">Selecione...</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                </select>

              </div>
              </div>

          </div>
          </div>

          </div>
                
            <button type="submit" class="btn btn-primary"  style="    float: left;">Avançar</button>
                
              </form>

		  </div>

		</div>
			
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
<?php } } ?>