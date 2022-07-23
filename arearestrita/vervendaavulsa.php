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

  $id = $_GET['id'];

  $sql = mysqli_query($con, "select * from venda_avulsa where id_avulsa = '$id'");
  $vetor = mysqli_fetch_array($sql);

  $sql_venda = mysqli_query($con, "select * from vendas where tipo = '3' and produto = '$id'");
  $vetor_venda = mysqli_fetch_array($sql_venda);

  $sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_venda[formapag]'");
  $vetor_forma = mysqli_fetch_array($sql_forma);

  $sql_itens_venda = mysqli_query($con, "select * from venda_avulsa_produtos where id_avulsa = '$id'");

  $sql_eventos_venda = mysqli_query($con, "select * from eventos_venda_avulsa where id_avulsa = '$id'");
	
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

<link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

<script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

<style type="text/css">
.thumbnail {
  position: relative;
  width: 150px;
  height: 150px;
  overflow: hidden;
}
.thumbnail img {
  position: absolute;
  left: 50%;
  top: 50%;
  height: 100%;
  width: auto;
  -webkit-transform: translate(-50%,-50%);
      -ms-transform: translate(-50%,-50%);
          transform: translate(-50%,-50%);
}
.thumbnail img.portrait {
  width: 100%;
  height: auto;
}

#box1 {
          width:680px;
          height:100%;
          border-radius: 0px;
          margin: auto;
          padding:0px;
          margin-bottom: 0px;
          }
</style>

<style type="text/css">
  .circle img {
    background-color: #ddd;
    border-radius: 100%;
    height: 100px;
    width: 100px;
    object-fit: cover;
  }
</style>

<!--//skycons-icons-->
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
				<a href="index.php">Minhas Compras</a>
				<i class="fa fa-angle-right"></i>
				<span>Minha Compra</span>
				</h2>
		    </div>
		<!--//banner-->
		<!--content-->
		<div class="content-top">
			
			
		<div class="grid-form">

		  <div class="grid-form1">

      <table width="100%">
              <tr>
                <td><strong>Valor Compra:</strong> R$<?php echo $num1 = number_format($vetor_venda['valorvenda'],2,',','.'); ?></td>
              </tr>
              <tr>
                <td><strong>Data Compra:</strong> <?php echo date('d/m/Y', strtotime($vetor_venda['data'])); ?></td>
              </tr>
              <tr>
                <td><strong>Qtd de Parcelas:</strong> <?php echo $vetor_venda['qtdparcelas']; ?></td>
              </tr>
              <tr>
                <td><strong>Valor da Parcelas:</strong> R$<?php $valorparcela = $vetor_venda['valorvenda'] / $vetor_venda['qtdparcelas']; echo $num1 = number_format($valorparcela,2,',','.'); ?></td>
              </tr>
              <tr>
                <td><strong>Forma de Pagamento:</strong> <?php echo $vetor_forma['nome']; ?></td>
              </tr>
            </table>

          <br>
          <br>

      <strong>Produtos</strong>
            <br>
            <br>
 
            <table width="100%" class="table table-bordered table-striped">
              <tr bgcolor="#e8e8e8">
                  <td width="33%">Produto</td>
                  <td width="34%">Total</td>
              </tr>

              <?php

              while($vetor_itens = mysqli_fetch_array($sql_itens_venda)) {

              $sql_produto = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '$vetor_itens[id_item]'");
              $vetor_produto = mysqli_fetch_array($sql_produto);

              $num = number_format($vetor_itens['valor'],2,',','.');

              ?>

              <tr>
                  <td width="33%"><?php echo $vetor_produto['nome']; ?></td>
                  <td width="34%">R$ <?php echo $num; ?></td>
              </tr>
            <?php
              $totalizador += $vetor_itens['valor'];
            }

            $num1 = number_format($totalizador,2,',','.');

            ?>
            <tr>
                  <td width="33%"></td>
                  <td width="34%">Total: R$ <?php echo $num1; ?></td>
              </tr>
              </table>

            <br>
            <br>

            <strong>Eventos</strong>
            <br>
            <br>

            <table class="table table-bordered table-striped">

              <thead>
                
                <tr bgcolor="#e8e8e8">
                  <th>Evento</th>
                </tr>

              </thead>

              <tbody>

                <?php 

                while($vetor_evento = mysqli_fetch_array($sql_eventos_venda)) { 

                $sql_evento = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_evento[id_evento]'");
                $vetor_evento = mysqli_fetch_array($sql_evento);

                ?>

                <tr>

                  <td><?php echo $vetor_evento['nome']; ?></td>

                </tr>

                <?php } ?>

              </tbody>

            </table>

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
<?php } ?>