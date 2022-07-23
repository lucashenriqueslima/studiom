<?php
include "includes/conexao.php";

$preeventos = $_GET['p'];

$result_pre = mysqli_query($con, "SELECT p.*,t.ncontrato FROM preeventos p,turmas t WHERE id_pre = '$preeventos' and t.id_turma=p.id_turma");
$row_pre = mysqli_fetch_array($result_pre);

$caminho = "imagem/$row_pre[pasta]/";
$img = glob($caminho . "*.{JPG,jpg,png,gif}", GLOB_BRACE);
$contador = count($img);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>StudioM Fotografia</title>
    <!-- This Page CSS -->
    <link href="layout/assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
    <link href="layout/assets/libs/magnific-popup/animation.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="layout/dist/css/style.min.css" rel="stylesheet">

    <link href="imgs/logo1.png" rel="icon" sizes="32x32" type="image/png">

    <script src="layout/dist/js/lightbox-plus-jquery.min.js"></script>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="layout/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="layout/dist/js/app.min.js"></script>
    <script src="layout/dist/js/app.init.horizontal.js"></script>
    <script src="layout/dist/js/app-style-switcher.horizontal.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="layout/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="layout/assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="layout/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="layout/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="layout/dist/js/custom.min.js"></script>
    <!-- This Page JS -->
    <script src="layout/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="layout/assets/libs/magnific-popup/meg.init.js"></script>
</head>
<style>
    body {
        background-image: url("layout/assets/images/big/auth-bg.jpg");
    }

    #logo {
        margin-left: 1%;
        width: 25%;
        height: auto;
    }

</style>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<body>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<br>

<div class="container">
    <div align="center" id="box">
        <img id="logo" src="imgs/Studio%20M%20-%20Logo-01.png"/>
    </div>
    <br>
    <div align="center">
        <h4>
            <strong>
                <?php
                echo $row_pre['ncontrato'] . ' - ' . $row_pre['titulo'];
                ?>
            </strong>
        </h4>
    </div>
    <br>
    <div class="popup-gallery row m-t-30">
        <?php
        $i = 0;
        foreach ($img as $img) {
            ?>
            <div class="col-md-2" style="overflow: hidden">
                <a href="<?php echo $img; ?>" title="<a href='<?php echo $img; ?>' class='btn btn-info' download><i class='fa fa-download'></i></a>">
                    <img src="<?php echo $img; ?>" alt="img" style="width: 175px;height: 175px;object-fit: cover;padding: 5px"/>
                </a>
            </div>
            <?php $i++;
        } ?>
    </div>
</div>

</body>
</html>