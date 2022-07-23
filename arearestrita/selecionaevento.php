<?php
session_start();
include "../includes/conexao.php";
if ($_POST['preeventos'] != '') {
	$preeventos = $_POST['preeventos'];
	$result_pre = mysqli_query($con, "SELECT * FROM eventosformando WHERE id_evento = '$preeventos' and id_formando = '$_SESSION[id_formando]'");
	$row_pre = mysqli_fetch_array($result_pre);
	$caminho = "../sistema/arquivos/formandos/$row_pre[pasta]/";
	$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
	$contador = count($img);
	?>
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
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .thumbnail img.portrait {
            width: 100%;
            height: auto;
        }

        #box1 {
            width: 680px;
            height: 100%;
            border-radius: 0px;
            margin: auto;
            padding: 0px;
            margin-bottom: 0px;
        }
    </style>

    <div class="table-responsive">
        <table class="table">
            <tbody>
            <tr>
							
							<?php
							$i = 0;
							foreach ($img as $img) {
								?>

                  <td>
                      <div class="thumbnail">


                          <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img
                                      alt=""
                                      src="<?php echo $img; ?>"/></a>

                      </div>
										
										<?php
										$imagem = explode("/", $img);
										$imagemfinal = $imagem[5];
										$nomeimagem = explode(".", $imagemfinal);
										echo $nomeimagem[0];
										?>
                  </td>
								
								<?php $i++;
							} ?>

            </tr>
            </tbody>
        </table>
    </div>
<?php } ?>