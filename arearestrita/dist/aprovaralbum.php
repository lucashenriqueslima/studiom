<?php

	include"../../includes/conexao.php";
	 
	 session_start();

	if($_SESSION['id_formando'] == NULL) {
	
	echo"<script language=\"JavaScript\">
	location.href=\"index.html\";
	</script>";
	
	} else {
		
	$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);
	
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
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
<!--//skycons-icons-->

<style type="text/css">
  .img-circle {
    border-radius: 50%;
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

		    
        </nav>
</div>

</div>

<div class="row">

          <div class="col-lg-3">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Eventos / Pré-eventos</label>
              <select name="preeventos" id="preeventos" class="form-control" onchange="myFunction()">
                    <option value="" selected="selected">Selecione...</option>
                    <?php 

                    $sql_eventos = mysqli_query($con, "select * from eventosformando where id_formando = '$vetor_cadastro[id_formando]' order by id_evento DESC");

                    while ($vetor_eventos=mysqli_fetch_array($sql_eventos)) { 

                    ?>
                    <option value="<?php echo $vetor_eventos['id_evento']; ?>"><?php echo $vetor_eventos['titulo'] ?></option>
                    <?php } ?>
                  </select>
            </fieldset>
          </div>
</div>

<div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
            
            <div id="resultado"></div>

	        <script type="text/javascript">
			
			//Fica monitorando o evento 'change' do id=cursos, ao ocorrer este evento é disparado a função
			document.getElementById('preeventos').addEventListener('change', function() {
				//Caso queira passar mais de fique com o exemplo abaixo:
				//var params = "lorem=ipsum&name=binny"; 
				
				//Porem só precisamos passar o value do 'cursos'
				var params = "preeventos=" + document.getElementById('preeventos').value;
				
				var ajax = new XMLHttpRequest();
				ajax.open('POST', 'selecionaevento.php', true);
				ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				ajax.send(params);
					
				ajax.onreadystatechange = function() {
					if(ajax.readyState == 4 && ajax.status == 200) {
						document.getElementById('resultado').innerHTML = ajax.responseText;
					}
				}
			});
		
			</script>

            </tr>
        </tbody>
    </table>
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