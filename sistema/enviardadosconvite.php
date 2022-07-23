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
<!DOCTYPE html>
<html>
<head>
	<title>Studio M</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
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

<?php

$sql_item_4_1 = mysqli_query($con, "select * from tipos_arquivos_turma where id_tipo_formando = '$id1' and id_tipo = '4'");
$vetor_item_4_1 = mysqli_fetch_array($sql_item_4_1);

?>

<script type="text/javascript">
      var CheckMaximo = <?php echo $vetor_item_4_1['qtd']; ?>;



      function verificar() {
      var Marcados = 1;
      var objCheck = document.forms['form1'].elements['imagem'];

      //Percorrendo os checks para ver quantos foram selecionados:
      for (var iLoop=0; iLoop<objCheck.length; iLoop++) {
      //Se o número máximo de checkboxes ainda não tiver sido atingido, continua a verificação:
        if (objCheck[iLoop].checked) {
            Marcados++;
        }
        
        if (Marcados <= CheckMaximo) {
        //Habilitando todos os checkboxes, pois o máximo ainda não foi alcançado.
          for (var i=0; i<objCheck.length; i++) {
            objCheck[i].disabled = false;
          }       
          //Caso contrário, desabilitar o checkbox;
          //Nesse caso, é necessário percorrer todas as opções novamente, desabilitando as não checadas;
          
        } else {
          for (var i=0; i<objCheck.length; i++) {
            if(objCheck[i].checked == false) {
              objCheck[i].disabled = true;
            }       
            }
          }
      }
      }
      </script>
<body>

<form action="recebe_enviardadosconvite.php?id=<?php echo $id; ?>" name="form1" method="post" enctype="multipart/form-data">

<div class="container">

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

      <?php

      $sql_item_4 = mysqli_query($con, "select * from tipos_arquivos_turma where id_tipo_formando = '$id1' and id_tipo = '$id'");
      $vetor_item_4 = mysqli_fetch_array($sql_item_4);

      for($f=1; $f<=$vetor_item_4['qtd']; $f++) {

      ?>

      <input type="hidden" name="contaimagem[]" value="<?php echo $f; ?>">

			<div class="row">

	          <div class="col-lg-12">
	            <fieldset class="form-group">
	              <label class="form-label semibold" for="exampleInput">Selecione a Foto</label>
	              <input type="file" name="imagem_up[]" class="form-control">
	            </fieldset>
	          </div>

	        </div>

      <?php } ?>

    	</div>

    	<div id="1">

        <h3>Você pode selecionar <?php echo $vetor_item_4_1['qtd']; ?> Fotos</h3>
        <br>

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

              	<input type="checkbox" id="imagem" name="imagem[]" value="<?php echo $img; ?>" onclick="verificar()"> 
                
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

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $img; ?>"> 
                
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

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $img; ?>"> 
                
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

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $img; ?>"> 
                
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

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $img; ?>"> 
                
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

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $img; ?>"> 
                
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

              	<input type="radio" id="imagem" name="imagem" value="<?php echo $img; ?>"> 
                
                Selecionar esta imagem!!!

                <br>

              </div>

              <br>

            </div>


          <?php $g++; } ?>

          </div>

    <?php 

  } if($id == 12) { 

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

    <?php } ?>

    <button type="submit" class="btn btn-primary"  style="    float: left;">Salvar</button>

   </div>

</section>

</div>

</form>

</body>
</html>
<?php } ?>