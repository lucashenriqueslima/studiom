<?php
session_start();
include "../includes/conexao.php";
$preeventos = $_POST['preeventos'];
if ($preeventos != '') {
	$result_pre = mysqli_query($con, "SELECT * FROM eventosformando WHERE id_evento = '$preeventos' and id_formando = '$_SESSION[id_formando]'");
	$row_pre = mysqli_fetch_array($result_pre);
	$sql_escolha = mysqli_query($con, "select * from escolha_fotos where id_formando = '$_SESSION[id_formando]'");
	$vetor_escolha = mysqli_fetch_array($sql_escolha);
	$caminho = "../sistema/arquivos/formandos/$row_pre[pasta]/";
	$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
	$contador = count($img);
	?>

    <script src="../dist/js/lightbox-plus-jquery.min.js"></script>

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

    <div class="row">
			
			<?php
			$i = 0;
			foreach ($img as $img) {
				$sql_itens = mysqli_query($con, "select * from escolha_fotos_itens where id_escolha = '$vetor_escolha[id_escolha]' and foto = '$img'");
				$vetor_itens = mysqli_fetch_array($sql_itens);
				?>

          <div class="col-md-3">

              <div class="thumbnail">


                  <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img alt=""
                                                                                                            src="<?php echo $img; ?>"/></a>

              </div>

              <div class="row">
                  <div class="col-lg-6">
                      <fieldset class="form-group">
                          <label>
                              <input type="checkbox" name="foto[]" value="<?php echo $img; ?>" class="minimal"
															       <?php if (mysqli_num_rows($sql_itens) > 0) { ?>checked <?php } ?>>
                          </label>
                      </fieldset>
                  </div>

                  <div class="col-lg-6">
                      <fieldset class="form-group">
                          <label>
                              <select name="npagina[]" class="form-control">
                                  <option value="" selected="">Selecione a pagina desejada</option>
																<?php
																$sql_paginas = mysqli_query($con, "select * from escolha_fotos_itens where id_escolha = '$vetor_escolha[id_escolha]' order by npagina ASC");
																while ($vetor_paginas = mysqli_fetch_array($sql_paginas)) {
																	?>
                                    <option value="<?php echo $vetor_paginas['id_item']; ?>" <?php if (mysqli_num_rows($sql_itens) > 0) { ?> selected <?php } ?>>
                                        Página N°: <?php echo $vetor_paginas['npagina']; ?></option>
																<?php } ?>
                              </select>
                          </label>
                      </fieldset>
                  </div>

              </div><!--.row-->

              <br>

          </div>
				
				
				<?php $i++;
			} ?>

    </div>

    </div>
<?php } ?>