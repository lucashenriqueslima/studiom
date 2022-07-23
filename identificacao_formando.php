<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>StudioM Fotografia</title>
</head>
<link href="layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">

<link href="layout/assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
    <!-- Custom CSS -->
<link href="layout/dist/css/style.min.css" rel="stylesheet">
<link rel="icon" type="image/png" sizes="32x32" href="imgs/logo1.png">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<style>

          body {
		  background-image: url("imgs/fundo.png");
		  }

          #box {
          width:240px;
          height:100%;
          border-radius: 10px;
          margin: auto;
          padding:10px;
          margin-bottom: 20px;
          }
          #box img{
              width: 60%;
              height: auto;
          }

</style>
<body>
<br>
<br>
<br>
<br>
<div class="container">
	<div id="box" align="center">

		<img src="imgs/Studio%20M%20-%20Logo-01.png">

		<br>
		<br>
		<h4><strong>Bem Vindo!</strong></h4>
        <br>
		<p>Digite seu CPF:

		<form action="identificacao.php" method="post">
			
			<input name="cpf" id="cpf" class="form-control" placeholder="Apenas os Números" required="">
			<br>
			<p><button type="submit" class="btn btn-primary btn-block btn-flat">Confirmar</button></p>

		</form>

	</div>
</div>
<script defer>
$("#cpf").mask("000.000.000-00");
</script>
</body>
</html>