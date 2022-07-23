<?php
include "includes/conexao.php";
$id = $_GET['id'];
$id_formando = $_GET['id_formando'];
$sql_formando = mysqli_query($con, "select * from formandos where cpf = '$cpf'");
$vetor_formando = mysqli_fetch_array($sql_formando);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" lang="pt">
    <title>StudioM Fotografia</title>
</head>
<link href="layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">

<link href="layout/assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="layout/dist/css/style.min.css" rel="stylesheet">
<link rel="icon" type="image/png" sizes="32x32" href="imgs/logo1.png">
<style>

    body {
        background-image: url("imgs/fundo.png");
    }

    #box {
        width: 400px;
        height: 100%;
        border-radius: 10px;
        margin: auto;
        padding: 10px;
        margin-bottom: 20px;
    }

    #box img {
        width: 50%;
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
        <br>
        <h4><strong>Fazer Upload da Foto</strong></h4>
        <br>
        <br>

        <form action="recebe_identificacao.php?id=<?php echo $id; ?>&id_formando=<?php echo $id_formando; ?>"
              method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input class="custom-file-input" type="file" name="imagem" id="imagem" accept="image/*">
                        <label class="custom-file-label" for="imagem">Escolha um arquivo</label>
                    </div>
                </div>
            </div>

            <br>
            <br>

            <table width="100%" style="text-align: center;">
                <tr>
                    <td width="10%"></td>
                    <td>
                        <button type="button" class="btn btn-primary"><i class="mdi mdi-upload"></i> Enviar</button>
                    </td>
                </tr>
            </table>

    </div>
</div>
</body>
</html>