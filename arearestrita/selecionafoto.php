<?php

include"../includes/conexao.php";

	 
session_start();

if($_SESSION['id_formando'] == NULL) {
	
echo"<script>opener.location.reload(); window.close();</script>";

	
} else {
		
$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
$res_cadastro = mysqli_query($con, $sql_cadastro);
$vetor_cadastro = mysqli_fetch_array($res_cadastro);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Escolha de Foto</title>
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
</head>
<body>

<div class="container">

<div class="row">

          <div class="col-lg-3">
            <fieldset class="form-group">
              <select name="preeventos" id="preeventos" class="form-control" onchange="myFunction()">
                    <option value="" selected="selected">Selecione...</option>
                    <?php 

                    $sql_eventos = mysqli_query($con, "select * from eventosformando where id_formando = '$vetor_cadastro[id_formando]' order by id_evento DESC");

                    while ($vetor_eventos=mysqli_fetch_array($sql_eventos)) { 

                    ?>
                    <option value="<?php echo $vetor_eventos['id_evento']; ?>_<?php echo $_GET['id']; ?>"><?php echo $vetor_eventos['titulo'] ?></option>
                    <?php } ?>
                  </select>
            </fieldset>
          </div>
</div>

</td>

</tr>

</table>

            <div id="resultado"></div>

	        <script type="text/javascript">
			
			//Fica monitorando o evento 'change' do id=cursos, ao ocorrer este evento é disparado a função
			document.getElementById('preeventos').addEventListener('change', function() {
				//Caso queira passar mais de fique com o exemplo abaixo:
				//var params = "lorem=ipsum&name=binny"; 
				
				//Porem só precisamos passar o value do 'cursos'
				var params = "preeventos=" + document.getElementById('preeventos').value;
				
				var ajax = new XMLHttpRequest();
				ajax.open('POST', 'selecionafotoevento.php', true);
				ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				ajax.send(params);
					
				ajax.onreadystatechange = function() {
					if(ajax.readyState == 4 && ajax.status == 200) {
						document.getElementById('resultado').innerHTML = ajax.responseText;
					}
				}
			});
		
			</script>

</div>
</body>
</html>
<?php } ?>