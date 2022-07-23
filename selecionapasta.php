<?php
include "includes/conexao.php";
$preeventos = $_POST['preeventos'];
if ($preeventos != '') {
	$result_pre = mysqli_query($con, "SELECT * FROM preeventos WHERE id_pre = '$preeventos'");
	$row_pre = mysqli_fetch_array($result_pre);
	$caminho = "imagem/$row_pre[pasta]/";
	$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
	$contador = count($img);
	?>
    <style type="text/css">
        .thumbnail {
            position: relative;
            width: 140px;
            height: 140px;
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
            width: 820px;
            height: 100%;
            border-radius: 0px;
            margin: auto;
            padding: 0px;
            margin-bottom: 0px;
        }
    </style>

    <div class="container">

        <div id="box1">

            <div class="row">
							
							<?php
							$i = 0;
							foreach ($img as $img) {
								?>

                  <div class="col-md-3">

                      <div class="thumbnail">

                          <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img
                                      alt="" src="<?php echo $img; ?>"/></a>

                      </div>

                      <br>

                      <div align="center">
												
												<?php
												$imagem = explode("/", $img);
												$imagemfinal = $imagem[2];
												$nomeimagem = explode(".", $imagemfinal);
												echo $nomeimagem[0];
												?>

                          <br>

                      </div>

                      <br>

                  </div>
								
								
								<?php $i++;
							} ?>

            </div>

        </div>

    </div>
<?php } ?>