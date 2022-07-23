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
    <div class="testimonial-group largurafotos">
        <div class="row">

            <table class="table" width="100%">
                <tbody>
                <tr>
									
									<?php
									$i = 0;
									foreach ($img as $img) {
										?>

                      <td>
                          <div class="thumbnail">


                              <a class="example-image-link" href="<?php echo $img; ?>" data-lightbox="example-set"><img
                                          src="<?php echo $img; ?>" alt=""></a>

                          </div>
												
												<?php
												$imagem = explode("/", $img);
												$imagemfinal = $imagem[5];
												$nomeimagem = explode(".", $imagemfinal);
												?>

                          <div class="row">
                              <div class="col-lg-12">
                                  <fieldset class="form-group">
                                      <label>
                                          <input type="checkbox" name="foto[]" value="<?php echo $img; ?>"
                                                 class="minimal"
                                                 title="Selecione esta Foto"> <?php echo $nomeimagem[0]; ?>
                                      </label>
                                  </fieldset>
                              </div>
                          </div><!--.row-->

                      </td>
										
										<?php $i++;
									} ?>

                </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>