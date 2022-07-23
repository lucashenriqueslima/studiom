<?php
session_start();
include "../includes/conexao.php";

if ($_POST['preeventos'] != '') {
	$preeventos = $_POST['preeventos'];
	$preeventos_explode = explode("_", $preeventos);
	$id = $preeventos_explode[0];
	$id_item = $preeventos_explode[1];
	$result_pre = mysqli_query($con, "SELECT * FROM eventosformando WHERE id_evento = '$id' and id_formando = '$_SESSION[id_formando]'");
	$row_pre = mysqli_fetch_array($result_pre);
	$sql_qtd_item = mysqli_query($con, "select * from convite_exclusive_itens where id_item = '$id_item'");
	$vetor_qtd_item = mysqli_fetch_array($sql_qtd_item);
	$caminho = "../sistema/arquivos/formandos/$row_pre[pasta]/";
	$img = glob($caminho."*.{JPG,jpg,png,gif}", GLOB_BRACE);
	$contador = count($img);
	?>

    <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

    <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

    <style type="text/css">

        .testimonial-group {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            width: 100vw;
        }

        .thumbnail {
            position: relative;
            width: 220px;
            height: 220px;
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

        .largurafotos {
            float: left;
            width: 160%;
        }

    </style>

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
                                                 class="minimal" title="Selecione esta Foto" id="imagem"
                                                 onclick="verificar<?php echo $id_item; ?>()"> <?php echo $nomeimagem[0]; ?>
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