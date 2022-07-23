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

  $sql_pacotes = mysqli_query($con, "select * from pacotes where termino >= '$dataatual' and id_turma = '$vetor_cadastro[turma]' order by id_pacote DESC");
	
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

			<?php if(mysqli_num_rows($sql_pacotes) == 0) { ?>

            <div class="alert alert-primary">

                Nenhum álbum para compra no momento!!

            </div> 

            <?php 

            } else {

            //$vetor_produtos = mysqli_fetch_array($sql_produtos);

            $sql_valida = mysqli_query($con, "select * from pacotes a, vendas b where a.termino >= '$dataatual' and a.id_turma = '$vetor_cadastro[turma]' and a.id_pacote = b.produto and b.id_formando = '$_SESSION[id_formando]' and b.tipo = '2' and b.iniciada = '2' order by a.id_pacote DESC limit 0,1"); 

            if(mysqli_num_rows($sql_valida) != 0) { 

            ?>

            <div class="alert alert-primary">

                Caro Formando, você não tem álbum para comprar!

            </div>

            <?php 

            } else { 

            $sql_itens = mysqli_query($con, "select * from produtos_turma_item where id_produto = '$vetor_produtos[id_produto]'");

            $sql_pacotes = mysqli_query($con, "select * from pacotes_turma where id_produto = '$vetor_produtos[id_produto]'");

            ?>
            
            <form action="compra_album.php" method="post" name="cliente" enctype="multipart/form-data" onSubmit="return verificarCPF()" id="formID">

            <input type="hidden" name="cpf" value="<?php echo $cpf; ?>">

            <div class="row">
              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="exampleInput">Iniciar compra agora?</label>
                  <select name="produto" class="form-control" required="">
                    <?php

                    $sql_pacote = mysqli_query($con, "select * from pacotes where termino >= '$dataatual' and id_turma = '$vetor_cadastro[turma]'");

                    while ($vetor_pacote=mysqli_fetch_array($sql_pacote)) { 

                    ?>
                    <option value="<?php echo $vetor_pacote['id_pacote']; ?>">Sim</option>
                    <?php } ?>
                  </select>
                </fieldset>
              </div>
            </div><!--.row-->
                
            <button type="submit" class="btn btn-primary"  style="    float: left;">Avançar</button>
                
              </form>

              <?php } } ?>

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