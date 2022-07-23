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
<link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

<script src="../js/lightbox-plus-jquery.min.js"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<!--//skycons-icons-->

<style type="text/css">
  .circle img {
	  background-color: #ddd;
	  border-radius: 100%;
	  height: 100px;
	  width: 100px;
	  object-fit: cover;
	}

  .main iframe {
    border: none;
    top: 0;
    left: 0;
    width: 100%;
    height: 405px;
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
        	  Seja Bem Vindo, <?php echo $vetor_cadastro['nome']; ?>. <a href="index.php">Voltar para o sistema.</a>
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

		    
        </nav>
</div>

</div>

<h3>Imagens Cadastradas</h3>

              <table width="100%" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><div class="a">Imagem</div></th>
                  <th><div class="a">N° Pagina</div></th>
                  <th width="60%"><div class="a">Observações</div></th>
                </tr>
                </thead>
                <tbody>
                
                <?php

                $sql_imagens = mysqli_query($con, "select * from meu_album_paginas where id_meualbum = '$id' order by npagina ASC");

                $i = 0;

                while($vetor_imagens = mysqli_fetch_array($sql_imagens)) { 

                ?>


                <tr>
                  <td><img src="../sistema/arquivos/turmas/<?php echo $vetor_imagens['imagem']; ?>" width="420px"></td>
                  <td><?php echo $vetor_imagens['npagina']; ?></td>
                  <td><?php echo $vetor_imagens['descricao']; ?></td>
                </tr>



                <?php $i++; } ?>

                </tbody>
              </table>


</div>

<!---->
<!--scrolling js-->
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<script src="js/bootstrap.min.js"> </script>
</body>
</html>
<?php } ?>