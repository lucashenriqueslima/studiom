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
	
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Studiom Fotografia</title>
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

.nav-tabs>li>a {
  background-color: #333333; 
  border-color: #777777;
  color:#e8e8e8;
}

/* active tab color */
.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
  color: #000;
  background-color: #fff;
  border: 1px solid #888888;
}

/* hover tab color */
.nav-tabs>li>a:hover {
  border-color: #000000;
  background-color: #333333;
}

</style>
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
				<a href="index.php">Minhas Fotos</a>
				<i class="fa fa-angle-right"></i>
				<span>Ensaio Fotos de Convite</span>
				</h2>
		    </div>
		<!--//banner-->
		<!--content-->
		<div class="content-top">
			
			
		<div class="grid-form">

		  <div class="grid-form1">

		  	<?php 

	        $sql_vendas_formando = mysqli_query($con, "select * from vendas where tipo = '1' and iniciada = '2' and pagamento = '1' AND id_formando = '$vetor_cadastro[id_formando]' order by id_venda DESC");

	        $sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor_cadastro[id_formando]' and album = '1'");

	        if(mysqli_num_rows($sql_vendas_formando) > 0 || mysqli_num_rows($sql_formando) > 0) { 

	        ?>  

	        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <?php

              $sql_arquivos = mysqli_query($con, "select * from tipos_arquivos a, tipos_arquivos_turma b where a.id_tipo = b.id_tipo and b.id_turma = '$vetor_cadastro[turma]' and a.fotos = '1' order by a.nome ASC");

              $i = 1;

              while($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {

              ?>
              <li <?php if($i == 1) { ?>class="active"<?php } ?>><a href="#tab_<?php echo $i; ?>" data-toggle="tab"><?php echo $vetor_arquivo['nome']; ?></a></li>
              <?php $i++; } ?>
            </ul>

            <div class="tab-content">
           
            <?php

              $sql_arquivos1 = mysqli_query($con, "select * from tipos_arquivos a, tipos_arquivos_turma b where a.id_tipo = b.id_tipo and b.id_turma = '$vetor_cadastro[turma]' and a.fotos = '1' order by a.nome ASC");

              $f = 1;

              while($vetor_arquivo1 = mysqli_fetch_array($sql_arquivos1)) {

              $sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$vetor_arquivo1[id_tipo]' and id_formando = '$vetor_cadastro[id_formando]'");
              $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

              $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
			  $img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
			  $contador = count($img);

              ?>

            <div class="tab-pane <?php if($f == 1) { ?>active<?php } ?>" id="tab_<?php echo $f; ?>">

            <div class="row">

          <?php 

          $g = 0;

          foreach($img as $img){ 

                $imagem = explode("/", $img);
                $imagemfinal = $imagem[6];

                $nomeimagem = explode(".", $imagemfinal);

          ?>

            <div class="col-md-2">
              
              <div class="thumbnail">

              <a href="<?php echo $img; ?>" class="b-link-stripe b-animate-go  swipebox" title="<?php echo $nomeimagem[0]; ?>"><img alt="" src="<?php echo $img; ?>" /></a>  

              </div>

              <br>

              <div align="center">
                
                <?php echo $nomeimagem[0]; ?>

                <br>

                <a href="forcadownload.php?arquivo=<?php echo $img; ?>" target="_blank"><i class="fa fa-caret-square-o-down nav_icon"></i></a>

              </div>

              <br>

            </div>


          <?php $g++; } ?>

          </div>
	
            </div>

            <?php $f++; } ?>

            </div>
            </div>

			<?php

			} else { ?>

		  	<div class="alert alert-info" role="alert">
			  Caro(a), <?php echo $vetor_cadastro['nome']; ?> Etapa ainda não disponível.
			</div> 

          	  <?php } ?>

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
<link rel="stylesheet" href="css/swipebox.css">
  <script src="js/jquery.swipebox.min.js"></script> 
      <script type="text/javascript">
      jQuery(function($) {
        $(".swipebox").swipebox();
      });
</script>
<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<script src="js/bootstrap.min.js"> </script>
</body>
</html>
<?php } ?>