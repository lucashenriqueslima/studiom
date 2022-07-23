<?php

include "includes/conexao.php";

$sql_contratos = mysqli_query($con, "select * from turmas order by ncontrato ASC");

?>

<!DOCTYPE html>
<html dir="ltr">

<head>
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
    <link href="layout/dist/css/style.min.css" rel="stylesheet">
</head>
<script src="layout/dist/js/lightbox-plus-jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#contrato').change(function () {
            $('#turma').load('buscarcontratos.php?id_turma=' + $('#contrato').val());
            $('#preeventos').load('buscarpreeventos.php?id_turma=' + $('#contrato').val());
        });
    });
</script>
<body>
<div class="main-wrapper">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
         style="background:url(layout/assets/images/big/auth-bg.jpg) no-repeat center center;">
        <div class="auth-box">
            <div id="loginform">
                <div class="logo">
                    <span class="db"><img src="layout/assets/images/logo-icon.png" alt="logo"/></span>
                    <br>
                    </br
                    <h5 class="font-medium mb-3">Pré-Eventos</h5>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Contrato</label>
                                <select name="id_instituicao" id="contrato" class="form-control">
                                    <option value="" selected="selected">Selecione...</option>
                                    <?php
                                    while ($vetor_contratos = mysqli_fetch_array($sql_contratos)) {

                                        $sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_contratos[id_instituicao]'");
                                        $vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

                                        ?>
                                        <option value="<?php echo $vetor_contratos['id_turma']; ?>"><?php echo $vetor_contratos['ncontrato'] ?>
                                            - <?php echo $vetor_contratos['nome'] ?> <?php echo $vetor_contratos['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?></option>
                                    <?php } ?>
                                </select>
                            </fieldset>
                        </div>
                        <form class="form-horizontal mt-3" method="GET" id="loginform" action="procurareventos.php">

                            <div class="col-lg-12">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="exampleInput">Pré Eventos</label>
                                    <select name="p" id="preeventos" class="form-control">
                                        <option value="">Selecione um Evento</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="form-group text-center">
                                <button class="btn col-8 btn-md btn-info" type="submit">Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- All Required js -->
<!-- ============================================================== -->
<script src="layout/assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- ============================================================== -->
<!-- This page plugin js -->
<!-- ============================================================== -->
</body>
</html>