<?php
session_start();
include "includes/conexao.php";
$id = $_GET['id'];
$sql = mysqli_query($con, "select * from formandos where id_formando = '$id'");
$vetor = mysqli_fetch_array($sql);
$_SESSION['id_formando_cad'] = $id;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>StudioM Fotografia</title>
</head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<!-- Favicon icon -->
<link rel="icon" type="image/png" sizes="16x16" href="layout/assets/images/favicon.png">
<title>Studio M Fotografia</title>
<!-- Custom CSS -->
<link href="layout/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
<link href="layout/assets/extra-libs/c3/c3.min.css" rel="stylesheet">

<link href="layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="layout/dist/css/style.min.css" rel="stylesheet">

<link rel="stylesheet" href="cropper.min.css">

<script type="text/javascript" src="aplicacoes/aplicjava.js"></script>

<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" href="cropper.min.css">
<style>

    body {
        background-image: url("imgs/fundo.png");
    }
    #divCorpo {
        display: flex;
        flex-direction: row;
        justify-content: center;
        position: absolute;
        z-index: 1000;
    }

    img {
        display: block;
        max-width: 100%;
    }

    .img-container,
    .img-preview {
        text-align: center;
        width: 100%;
    }

    .img-container {
        margin-bottom: 1rem;
        max-height: 497px;
        min-height: 200px;
    }

    @media (min-width: 768px) {
        .img-container {
            min-height: 497px;
        }
    }

    .img-container > img {
        max-width: 100%;
    }
    #box img{
        width: 14%;
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Editar Foto</h4>

                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="img-container">

                                    <div id="divCorpo"></div>

                                      <img id="image" src="sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"
                                           alt="">

                                </div>
                            </div>
                        </div>

                        <div class="row" id="actions">
                            <div class="col-md-8 offset-md-2 text-center docs-buttons">
                                <br>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-md" data-method="setDragMode"
                                            data-option="move" title="Move">
                                        <span class="docs-tooltip" data-toggle="tooltip"
                                              title="cropper.setDragMode(&quot;move&quot;)">
                                          <span class="fa fa-arrows-alt"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-md" data-method="setDragMode"
                                            data-option="crop" title="Crop">
                                        <span class="docs-tooltip" data-toggle="tooltip"
                                              title="cropper.setDragMode(&quot;crop&quot;)">
                                          <span class="fa fa-crop-alt"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-md" data-method="zoom"
                                            data-option="0.1" title="Zoom In">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
                                          <span class="fa fa-search-plus"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-md" data-method="zoom"
                                            data-option="-0.1" title="Zoom Out">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
                                          <span class="fa fa-search-minus"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-md" data-method="rotate"
                                            data-option="-45" title="Rotate Left">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
                                          <span class="fa fa-undo-alt"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-md" data-method="rotate"
                                            data-option="45" title="Rotate Right">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
                                          <span class="fa fa-redo-alt"></span>
                                        </span>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <label class="btn btn-primary btn-upload"
                                           for="inputImage" title="Upload image file">
                                        <input type="file" class="sr-only" id="inputImage" name="file"
                                               accept="image/*">
                                        <span class="docs-tooltip" data-toggle="tooltip">
                                        <span class="fa fa-upload"></span> Escolher Foto
                                      </span>
                                    </label>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" data-method="getCroppedCanvas"
                                            data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }">
                                        <span class="docs-tooltip" data-toggle="tooltip">
                                          <span class="fa fa-check"></span> Salvar Foto
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</body>
</html>
<script src="layout/dist/js/app-style-switcher.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="layout/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="layout/assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="layout/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="layout/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="layout/dist/js/custom.min.js"></script>
<!--This page JavaScript -->
<!--chartis chart-->
<script src="layout/assets/libs/chartist/dist/chartist.min.js"></script>
<script src="layout/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<!--c3 charts -->
<script src="layout/assets/extra-libs/c3/d3.min.js"></script>
<script src="layout/assets/extra-libs/c3/c3.min.js"></script>
<!--chartjs -->
<script src="layout/assets/libs/chart.js/dist/Chart.min.js"></script>
<script src="layout/dist/js/pages/dashboards/dashboard1.js"></script>
<script src="layout/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="layout/dist/js/pages/datatable/datatable-basic.init.js"></script>

<script src="layout/assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- apps -->
<script src="layout/dist/js/app.min.js"></script>

<script src="cropper.min.js"></script>
<script src="cropperconfig.js"></script>