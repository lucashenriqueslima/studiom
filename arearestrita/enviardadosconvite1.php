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
	$id1 = $_GET['id1'];

	$sql_item = mysqli_query($con, "select * from tipos_arquivos_turma where id_tipo_formando = '$id1'");
	$vetor_item = mysqli_fetch_array($sql_item);

	$sql_tipo = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '$id'");
	$vetor_tipo = mysqli_fetch_array($sql_tipo);
	
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
				<a href="index.php">Convites</a>
				<i class="fa fa-angle-right"></i>
				<span>Dados do Convite</span>
				</h2>
		    </div>
		<!--//banner-->
		<!--content-->
		<div class="content-top">
			
			
		<div class="grid-form">

		  <div class="grid-form1">

		  <form action="recebe_enviardadosconvite.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

		  <?php if($id == 1) { ?>

<h3>Preencher <?php echo $vetor_tipo['nome']; ?></h3>

<?php } ?>

<?php if($id == 2) { ?>

<h3>Preencher <?php echo $vetor_tipo['nome']; ?></h3>

<?php } ?>

<section class="content">

  <div class="content-main">
	
	<?php if($id == 1) { ?>

	<script type="text/javascript">//<![CDATA[

    $(window).load(function(){
      
	$(document).on("input", "#comentario", function() {
	        var limite = <?php echo $vetor_item[qtd]; ?>;
	        var informativo = "caracteres restantes.";
	        var caracteresDigitados = $(this).val().length;
	        var caracteresRestantes = limite - caracteresDigitados;

	        if (caracteresRestantes <= 0) {
	            var comentario = $("textarea[name=comentario]").val();
	            $("textarea[name=comentario]").val(comentario.substr(0, limite));
	            $(".caracteres").text("0 " + informativo);
	        } else {
	            $(".caracteres").text(caracteresRestantes + " " + informativo);
	        }
	    });

	    });

  //]]></script>
	
	<div class="row">

          <div class="col-lg-12">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Digite seu Texto</label>
              <textarea name="comentario" id="comentario" class="form-control" required=""></textarea>
              <small class="caracteres"></small>
            </fieldset>
          </div>

        </div>

    <?php } if($id == 2) { ?>

    <script type="text/javascript">//<![CDATA[

    $(window).load(function(){
      
	$(document).on("input", "#comentario", function() {
	        var limite = <?php echo $vetor_item[qtd]; ?>;
	        var informativo = "caracteres restantes.";
	        var caracteresDigitados = $(this).val().length;
	        var caracteresRestantes = limite - caracteresDigitados;

	        if (caracteresRestantes <= 0) {
	            var comentario = $("textarea[name=comentario]").val();
	            $("textarea[name=comentario]").val(comentario.substr(0, limite));
	            $(".caracteres").text("0 " + informativo);
	        } else {
	            $(".caracteres").text(caracteresRestantes + " " + informativo);
	        }
	    });

	    });

  //]]></script>
	
	<div class="row">

          <div class="col-lg-12">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Digite seu Texto</label>
              <textarea name="comentario" id="comentario" class="form-control" required=""></textarea>
              <small class="caracteres"></small>
            </fieldset>
          </div>

        </div>

    <?php } if($id == 3) { ?>

    <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

    	<div class="row">

          <div class="col-lg-12">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Selecione a Foto</label>
              <input type="file" name="imagem" class="form-control">
            </fieldset>
          </div>

        </div>

    <?php } if($id == 4) { ?>

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
	
	<h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>
	
	<div class="row">
        <div class="col-md-6">
           <div class="form-group">
               <label>Tipo da Foto</label>
               <select name="upload" id="tipobusca" class="form-control">
            
               <option value="" selected="">Selecione...</option>
               <option value="2">Arquivo pessoal</option>
               <option value="1">Arquivo Studio M</option>
            
               </select>
            
            </div>
        </div>              
    </div>

    <div id="palco1">

    	<div id="2">

			<div class="row">

	          <div class="col-lg-12">
	            <fieldset class="form-group">
	              <label class="form-label semibold" for="exampleInput">Selecione a Foto</label>
	              <input type="file" name="imagem" class="form-control">
	            </fieldset>
	          </div>

	        </div>

    	</div>

    	<div id="1">

    		<?php

    		$sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
		    $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

		    $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
			$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
			$contador = count($img);

			?>

    <div class="row">

          <?php 

          $g = 0;

          foreach($img as $img){ 

          ?>

            <div class="col-md-2">
              
              <div class="thumbnail">

              <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img alt="" src="<?php echo $img; ?>" /></a>



              </div>

              <br>

              <div align="center">

              	<?php

              	$imagem = explode("/", $img);
                $imagemfinal = $imagem[6];

                $nomeimagem = explode(".", $imagemfinal);

                ?>

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $img; ?>"> 
                
                Selecionar esta imagem!!!

                <br>

              </div>

              <br>

            </div>


          <?php $g++; } ?>

          </div>

    	</div>

    </div>

    <?php 

	} if($id == 5) { 

	$sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
    $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

    $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
	$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
	$contador = count($img);

    ?>

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

    <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

    <div class="row">

          <?php 

          $g = 0;

          foreach($img as $img){ 

          ?>

            <div class="col-md-2">
              
              <div class="thumbnail">

              <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img alt="" src="<?php echo $img; ?>" /></a>



              </div>

              <br>

              <div align="center">

              	<?php

              	$imagem = explode("/", $img);
                $imagemfinal = $imagem[6];

                $nomeimagem = explode(".", $imagemfinal);

                ?>

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $nomeimagem[0]; ?>"> 
                
                Selecionar esta imagem!!!

                <br>

              </div>

              <br>

            </div>


          <?php $g++; } ?>

          </div>

    <?php 

	} if($id == 6) { 

	$sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
    $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

    $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
	$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
	$contador = count($img);

    ?>

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

    <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

    <div class="row">

          <?php 

          $g = 0;

          foreach($img as $img){ 

          ?>

            <div class="col-md-2">
              
              <div class="thumbnail">

              <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img alt="" src="<?php echo $img; ?>" /></a>



              </div>

              <br>

              <div align="center">

              	<?php

              	$imagem = explode("/", $img);
                $imagemfinal = $imagem[6];

                $nomeimagem = explode(".", $imagemfinal);

                ?>

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $img; ?>"> 
                
                Selecionar esta imagem!!!

                <br>

              </div>

              <br>

            </div>


          <?php $g++; } ?>

          </div>

    <?php 

	} if($id == 7) { 

	$sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
    $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

    $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
	$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
	$contador = count($img);

    ?>

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

    <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

    <div class="row">

          <?php 

          $g = 0;

          foreach($img as $img){ 

          ?>

            <div class="col-md-2">
              
              <div class="thumbnail">

              <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img alt="" src="<?php echo $img; ?>" /></a>



              </div>

              <br>

              <div align="center">

              	<?php

              	$imagem = explode("/", $img);
                $imagemfinal = $imagem[6];

                $nomeimagem = explode(".", $imagemfinal);

                ?>

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $nomeimagem[0]; ?>"> 
                
                Selecionar esta imagem!!!

                <br>

              </div>

              <br>

            </div>


          <?php $g++; } ?>

          </div>

    <?php 

	} if($id == 8) { 

	$sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
    $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

    $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
	$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
	$contador = count($img);

    ?>

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

    <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

    <div class="row">

          <?php 

          $g = 0;

          foreach($img as $img){ 

          ?>

            <div class="col-md-2">
              
              <div class="thumbnail">

              <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img alt="" src="<?php echo $img; ?>" /></a>



              </div>

              <br>

              <div align="center">

              	<?php

              	$imagem = explode("/", $img);
                $imagemfinal = $imagem[6];

                $nomeimagem = explode(".", $imagemfinal);

                ?>

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $nomeimagem[0]; ?>"> 
                
                Selecionar esta imagem!!!

                <br>

              </div>

              <br>

            </div>


          <?php $g++; } ?>

          </div>

    <?php 

	} if($id == 9) { 

	$sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
    $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

    $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
	$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
	$contador = count($img);

    ?>

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

    <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

    <div class="row">

          <?php 

          $g = 0;

          foreach($img as $img){ 

          ?>

            <div class="col-md-2">
              
              <div class="thumbnail">

              <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img alt="" src="<?php echo $img; ?>" /></a>



              </div>

              <br>

              <div align="center">

              	<?php

              	$imagem = explode("/", $img);
                $imagemfinal = $imagem[6];

                $nomeimagem = explode(".", $imagemfinal);

                ?>

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $nomeimagem[0]; ?>"> 
                
                Selecionar esta imagem!!!

                <br>

              </div>

              <br>

            </div>


          <?php $g++; } ?>

          </div>

    <?php 

	} if($id == 10) { 

	$sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
    $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

    $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
	$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
	$contador = count($img);

    ?>

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

    <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

    <div class="row">

          <?php 

          $g = 0;

          foreach($img as $img){ 

          ?>

            <div class="col-md-2">
              
              <div class="thumbnail">

              <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img alt="" src="<?php echo $img; ?>" /></a>



              </div>

              <br>

              <div align="center">

              	<?php

              	$imagem = explode("/", $img);
                $imagemfinal = $imagem[6];

                $nomeimagem = explode(".", $imagemfinal);

                ?>

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $nomeimagem[0]; ?>"> 
                
                Selecionar esta imagem!!!

                <br>

              </div>

              <br>

            </div>


          <?php $g++; } ?>

          </div>

    <?php 

	} if($id == 11) { 

	$sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
    $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

    $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
	$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
	$contador = count($img);

    ?>

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

    <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

    <div class="row">

          <?php 

          $g = 0;

          foreach($img as $img){ 

          ?>

            <div class="col-md-2">
              
              <div class="thumbnail">

              <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img alt="" src="<?php echo $img; ?>" /></a>



              </div>

              <br>

              <div align="center">

              	<?php

              	$imagem = explode("/", $img);
                $imagemfinal = $imagem[6];

                $nomeimagem = explode(".", $imagemfinal);

                ?>

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $nomeimagem[0]; ?>"> 
                
                Selecionar esta imagem!!!

                <br>

              </div>

              <br>

            </div>


          <?php $g++; } ?>

          </div>

    <?php } ?>

    <button type="submit" class="btn btn-primary"  style="    float: left;">Salvar</button>

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
<?php } ?>