<?php
$dataatual = date('Y-m-d');
include "includes/conexao.php";
$cpf = $_POST['cpf'];
if (!empty($cpf)) {
	$sql_formando = mysqli_query($con, "select * from formandos where cpf = '$cpf'");
	$vetor_formando = mysqli_fetch_array($sql_formando);
	$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor_formando[turma]'");
	$vetor_turma = mysqli_fetch_array($sql_turma);
	if (mysqli_num_rows($sql_formando) == 0) {
		echo "<script> alert('CPF não encontrado')</script>";
		echo "<script> window.location.href='identificacao.html'</script>";
	}else {
		?>
      <!DOCTYPE html>
      <html>

      <head>
          <meta charset="utf-8">
          <link href="layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">

          <link href="layout/assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
          <!-- Custom CSS -->
          <link href="layout/dist/css/style.min.css" rel="stylesheet">
          <title>StudioM Fotografia</title>
      </head>

      <link rel="icon" type="image/png" sizes="32x32" href="imgs/logo1.png">
      <style>
          body {
              background-image: url("imgs/fundo.png");
          }

          #box {
              text-align: justify;
              width: 600px;
              height: 100%;
              border-radius: 10px;
              margin: auto;
              padding: 10px;
              margin-bottom: 20px;
          }

          #logo {
              width: 15%;
              height: auto;
              margin-left: 28vw;
          }

          .underline {
              text-decoration: underline;
          }

          td, th {
              padding: 3px;
          }
      </style>

      <body>
      <br>
      <div class="container">
          <img id="logo" src="imgs/Studio%20M%20-%20Logo-01.png">
          <div id="box">
              <br>
              <strong>Seja Bem vindo, <?php echo $vetor_formando['nome']; ?>!</strong>
              <br>
              <br>
              A importância deste procedimento é darmos maior agilidade na disponibilização das fotos para vocês logo
              após os eventos.

              <div class="underline">
                  A foto para a verificação facial deverá ser tirada quando chegar ao evento para que as fotos a serem
                  produzidas sejam o mais verossímeis possível.
              </div>
              Assim podemos utilizar demais itens para esta verificação,
              assim como maquiagem, acessórios, vestimentas…
              <div class="underline">É importante que não se use óculos escuros, bonés, capelo (chapéu) de colação de
                  grau ou quaisquer
                  acessórios que possam diminuir o grau de assertividade do software.
              </div>

              <!--              Isso aí! Obrigado pela colaboração.-->
              <br>
              <strong style="text-align: justify;">Estes são os eventos para os quais você precisa subir sua foto para
                  verificação facial.</strong>
              <br>
              <br>
              <h4><strong style="float: left;">Eventos</strong></h4>
              <br>
						<?php
						$sql_eventos = mysqli_query($con, "SELECT * FROM eventos_turma WHERE id_turma = '$vetor_formando[turma]' and data >= '$dataatual' order by data ASC");
						while ($vetor_eventos = mysqli_fetch_array($sql_eventos)) {
							$sql_evento = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_eventos[id_categoria]'");
							$vetor_evento = mysqli_fetch_array($sql_evento);
							$eventoexplode = explode("/", $vetor_eventos['nome']);
							$nomeevento = $eventoexplode[2];
							$sql_consulta = mysqli_query($con, "select * from identificacao_formandos where id_evento = '$vetor_eventos[id_evento]' and id_formando = '$vetor_formando[id_formando]'");
							if (mysqli_num_rows($sql_consulta) == 0) {
								?>

                  <table width="100%">
                      <tr>
                          <td width="50%"><?php echo $nomeevento; ?></td>
                          
                          <td>
                              <div style="float: right">
                                  <a href="fazeridentificacao.php?id=<?php echo $vetor_eventos['id_evento']; ?>&id_formando=<?php echo $vetor_formando['id_formando']; ?>">
                                      <button class="btn btn btn-outline-primary waves-effect waves-light"
                                              type="button">
                                          <span class="btn-label"><i class="mdi mdi-camera"></i></span> Tirar Foto
                                      </button>
                              </div>
                              <hr style="margin-right: 120px;width: 300px">
                              </button>
                      </tr>
                      <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>
                  </table>
							
							
							<?php }
						} ?>

          </div>
      </div>
      </body>

      </html>
		<?php
	}
}else {
	echo "<script language=\"JavaScript\">
	location.href=\"identificacao.html\";
	</script>";
}
?>