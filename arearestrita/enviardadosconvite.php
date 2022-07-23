<?php

include "../includes/conexao.php";

session_start();

if ($_SESSION['id_formando'] == NULL || $_SESSION['id_formando'] == '') {

    echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";

} else {

    $sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);

    $id = $_GET['id'];
    $id1 = $_GET['id1'];
    $id_dados = $_GET['id_dados'];

    $sql_item = mysqli_query($con, "select * from tipos_arquivos_turma where id_tipo_formando = '$id1'");
    $vetor_item = mysqli_fetch_array($sql_item);

    $sql_tipo = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '$id'");
    $vetor_tipo = mysqli_fetch_array($sql_tipo);

    if (!empty($id_dados)) {

        $sql_dados = mysqli_query($con, "select * from dadosconvite where id_dados = '$id_dados'");
        $vetor_dados = mysqli_fetch_array($sql_dados);
    }

    ?>
    <!DOCTYPE html>
    <html dir="ltr" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="../layout/assets/images/favicon.png">
        <title>Studio M Fotografia</title>
        <!-- Custom CSS -->
        <link href="../layout/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
        <link href="../layout/assets/extra-libs/c3/c3.min.css" rel="stylesheet">

        <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../layout/dist/css/style.min.css" rel="stylesheet">

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

        <?php

        $sql_item_4_1 = mysqli_query($con, "select * from tipos_arquivos_turma where id_tipo_formando = '$id1' and (id_tipo = '4' OR id_tipo = '5')");
        $vetor_item_4_1 = mysqli_fetch_array($sql_item_4_1);

        ?>

        <script type="text/javascript">
            var CheckMaximo = <?php echo $vetor_item_4_1['qtd']; ?>;


            function verificar() {
                var Marcados = 1;
                var objCheck = document.forms['form1'].elements['imagem'];

                //Percorrendo os checks para ver quantos foram selecionados:
                for (var iLoop = 0; iLoop < objCheck.length; iLoop++) {
                    //Se o número máximo de checkboxes ainda não tiver sido atingido, continua a verificação:
                    if (objCheck[iLoop].checked) {
                        Marcados++;
                    }

                    if (Marcados <= CheckMaximo) {
                        //Habilitando todos os checkboxes, pois o máximo ainda não foi alcançado.
                        for (var i = 0; i < objCheck.length; i++) {
                            objCheck[i].disabled = false;
                        }
                        //Caso contrário, desabilitar o checkbox;
                        //Nesse caso, é necessário percorrer todas as opções novamente, desabilitando as não checadas;

                    } else {
                        for (var i = 0; i < objCheck.length; i++) {
                            if (objCheck[i].checked == false) {
                                objCheck[i].disabled = true;
                            }
                        }
                    }
                }
            }
        </script>

    </head>

    <body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                                class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="inicio.php">
                        <b class="logo-icon">

                            <img src="../layout/assets/images/logo-2.png" alt="homepage" class="dark-logo"
                                 width="110px"/>

                            <img src="../layout/assets/images/logo-icon.png" alt="homepage" class="light-logo"
                                 width="50px"/>
                        </b>

                    </a>

                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                       data-toggle="collapse" data-target="#navbarSupportedContent"
                       aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                                class="ti-more"></i></a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                    class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                    data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>


                    </ul>

                    <ul class="navbar-nav float-right">


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                        src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>" alt="user"
                                        class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img
                                                src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"
                                                alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $vetor_cadastro['nome']; ?></h4>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="sair.php"><i class="fa fa-power-off m-r-5 m-l-5"></i>
                                    Sair</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include "includes/menu.php"; ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Escolha de Fotos</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Convite Personal</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">


                                <form action="recebe_enviardadosconvite.php?id=<?php echo $id; ?><?php if (!empty($id_dados)) { ?>&id_dados=<?php echo $id_dados;
                                } ?>" name="form1" method="post" enctype="multipart/form-data">

                                    <?php if ($id == 1 || $id == 2) { ?>

                                        <h3>Preencher <?php echo $vetor_tipo['nome']; ?></h3>

                                    <?php } ?>

                                    <section class="content">

                                        <div class="content-main">

                                            <?php if ($id == 1 || $id == 2) { ?>

                                                <script type="text/javascript">//<![CDATA[

                                                    $(window).load(function () {

                                                        $(document).on("input", "#comentario", function () {
                                                            var limite = <?php echo $vetor_item['qtd']; ?>;
                                                            var informativo = "caracteres restantes.";
                                                            var caracteresDigitados = $(this).val().length;
                                                            var caracteresRestantes = limite - caracteresDigitados;

                                                            if (caracteresRestantes <= 0) {
                                                                var comentario = $("textarea[name=comentario]").val();
                                                                $("textarea[name=comentario]").val(comentario.substr(0, limite));
                                                                $(".caracteres").text("0 " + informativo);
                                                            } else {
                                                                $(".caracteres").text(caracteresRestantes + " " + informativo);
                                                            }
                                                        });

                                                    });

                                                    //]]></script>

                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold" for="exampleInput">Digite
                                                                seu Texto</label>
                                                            <textarea name="comentario" id="comentario"
                                                                      class="form-control mymce"
                                                                      required=""><?php echo $vetor_dados['texto']; ?></textarea>
                                                            <small class="caracteres"></small>
                                                        </fieldset>
                                                    </div>

                                                </div>

                                            <?php }?>
                                            <?php
                                            if ($id == 3) { ?>

                                                <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold" for="exampleInput">Selecione
                                                                a Foto</label>
                                                            <input type="file" name="imagem" class="form-control">
                                                        </fieldset>
                                                    </div>

                                                </div>

                                            <?php }
                                            if ($id == 4) { ?>

                                                <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

                                                <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

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

                                                <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Tipo da Foto</label>
                                                            <select name="upload" id="tipobusca" class="form-control">

                                                                <option value="" selected="">Selecione...</option>
                                                                <option value="2">Arquivo pessoal</option>
                                                                <option value="1">Arquivo Studio M</option>

                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="palco1">

                                                    <div id="2">

                                                        <?php

                                                        $sql_item_4 = mysqli_query($con, "select * from tipos_arquivos_turma where id_tipo_formando = '$id1' and id_tipo = '$id'");
                                                        $vetor_item_4 = mysqli_fetch_array($sql_item_4);

                                                        for ($f = 1; $f <= $vetor_item_4['qtd']; $f++) {

                                                            ?>

                                                            <input type="hidden" name="contaimagem[]"
                                                                   value="<?php echo $f; ?>">

                                                            <div class="row">

                                                                <div class="col-lg-12">
                                                                    <fieldset class="form-group">
                                                                        <label class="form-label semibold"
                                                                               for="exampleInput">Selecione a
                                                                            Foto</label>
                                                                        <input type="file" name="imagem_up[]"
                                                                               class="form-control">
                                                                    </fieldset>
                                                                </div>

                                                            </div>

                                                        <?php } ?>

                                                    </div>

                                                    <div id="1">

                                                        <h3>Você pode selecionar <?php echo $vetor_item_4_1['qtd']; ?>
                                                            Fotos</h3>
                                                        <br>

                                                        <?php

                                                        $sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
                                                        $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

                                                        $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
                                                        $img = glob($caminho . "*.{JPG,jpg,png,gif}", GLOB_BRACE);
                                                        $contador = count($img);

                                                        ?>

                                                        <div class="row">

                                                            <?php

                                                            $g = 0;

                                                            foreach ($img as $img) {

                                                                ?>

                                                                <div class="col-md-2">

                                                                    <div class="thumbnail">

                                                                        <a class="example-image-link"
                                                                           href="<?php echo $img; ?>"
                                                                           data-lightbox="example-set"><img alt=""
                                                                                                            src="<?php echo $img; ?>"/></a>


                                                                    </div>

                                                                    <br>

                                                                    <div align="center">

                                                                        <?php

                                                                        $imagem = explode("/", $img);
                                                                        $imagemfinal = $imagem[6];

                                                                        $nomeimagem = explode(".", $imagemfinal);

                                                                        ?>

                                                                        <input type="checkbox" id="imagem"
                                                                               name="imagem[]"
                                                                               value="<?php echo $img; ?>"
                                                                               onclick="verificar()">

                                                                        Selecionar esta imagem!!!

                                                                        <br>

                                                                    </div>

                                                                    <br>

                                                                </div>


                                                                <?php $g++;
                                                            } ?>

                                                        </div>

                                                    </div>

                                                </div>

                                                <?php

                                            }
                                            if ($id == 5) {

                                                $sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
                                                $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

                                                $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
                                                $img = glob($caminho . "*.{JPG,jpg,png,gif}", GLOB_BRACE);
                                                $contador = count($img);

                                                ?>

                                                <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

                                                <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

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

                                                <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

                                                <div class="row">

                                                    <?php

                                                    $g = 0;

                                                    foreach ($img as $img) {

                                                        ?>

                                                        <div class="col-md-2">

                                                            <div class="thumbnail">

                                                                <a class="example-image-link" href="<?php echo $img; ?>"
                                                                   data-lightbox="example-set"><img alt=""
                                                                                                    src="<?php echo $img; ?>"/></a>


                                                            </div>

                                                            <br>

                                                            <div align="center">

                                                                <?php

                                                                $imagem = explode("/", $img);
                                                                $imagemfinal = $imagem[6];

                                                                $nomeimagem = explode(".", $imagemfinal);

                                                                ?>

                                                                <input type="checkbox" id="imagem" name="imagem[]"
                                                                       value="<?php echo $img; ?>"
                                                                       onclick="verificar()">

                                                                Selecionar esta imagem!!!

                                                                <br>

                                                            </div>

                                                            <br>

                                                        </div>


                                                        <?php $g++;
                                                    } ?>

                                                </div>

                                                <?php

                                            }
                                            if ($id == 6) {

                                                $sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
                                                $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

                                                $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
                                                $img = glob($caminho . "*.{JPG,jpg,png,gif}", GLOB_BRACE);
                                                $contador = count($img);

                                                ?>

                                                <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

                                                <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

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

                                                <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

                                                <div class="row">

                                                    <?php

                                                    $g = 0;

                                                    foreach ($img as $img) {

                                                        ?>

                                                        <div class="col-md-2">

                                                            <div class="thumbnail">

                                                                <a class="example-image-link" href="<?php echo $img; ?>"
                                                                   data-lightbox="example-set"><img alt=""
                                                                                                    src="<?php echo $img; ?>"/></a>


                                                            </div>

                                                            <br>

                                                            <div align="center">

                                                                <?php

                                                                $imagem = explode("/", $img);
                                                                $imagemfinal = $imagem[6];

                                                                $nomeimagem = explode(".", $imagemfinal);

                                                                ?>

                                                                <input type="radio" id="imagem" name="imagem"
                                                                       value="<?php echo $img; ?>">

                                                                Selecionar esta imagem!!!

                                                                <br>

                                                            </div>

                                                            <br>

                                                        </div>


                                                        <?php $g++;
                                                    } ?>

                                                </div>

                                                <?php

                                            }
                                            if ($id == 7) {

                                                $sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
                                                $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

                                                $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
                                                $img = glob($caminho . "*.{JPG,jpg,png,gif}", GLOB_BRACE);
                                                $contador = count($img);

                                                ?>

                                                <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

                                                <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

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

                                                <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

                                                <div class="row">

                                                    <?php

                                                    $g = 0;

                                                    foreach ($img as $img) {

                                                        ?>

                                                        <div class="col-md-2">

                                                            <div class="thumbnail">

                                                                <a class="example-image-link" href="<?php echo $img; ?>"
                                                                   data-lightbox="example-set"><img alt=""
                                                                                                    src="<?php echo $img; ?>"/></a>


                                                            </div>

                                                            <br>

                                                            <div align="center">

                                                                <?php

                                                                $imagem = explode("/", $img);
                                                                $imagemfinal = $imagem[6];

                                                                $nomeimagem = explode(".", $imagemfinal);

                                                                ?>

                                                                <input type="radio" id="imagem" name="imagem"
                                                                       value="<?php echo $img; ?>">

                                                                Selecionar esta imagem!!!

                                                                <br>

                                                            </div>

                                                            <br>

                                                        </div>


                                                        <?php $g++;
                                                    } ?>

                                                </div>

                                                <?php

                                            }
                                            if ($id == 8) {

                                                $sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
                                                $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

                                                $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
                                                $img = glob($caminho . "*.{JPG,jpg,png,gif}", GLOB_BRACE);
                                                $contador = count($img);

                                                ?>

                                                <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

                                                <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

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

                                                <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

                                                <div class="row">

                                                    <?php

                                                    $g = 0;

                                                    foreach ($img as $img) {

                                                        ?>

                                                        <div class="col-md-2">

                                                            <div class="thumbnail">

                                                                <a class="example-image-link" href="<?php echo $img; ?>"
                                                                   data-lightbox="example-set"><img alt=""
                                                                                                    src="<?php echo $img; ?>"/></a>


                                                            </div>

                                                            <br>

                                                            <div align="center">

                                                                <?php

                                                                $imagem = explode("/", $img);
                                                                $imagemfinal = $imagem[6];

                                                                $nomeimagem = explode(".", $imagemfinal);

                                                                ?>

                                                                <input type="radio" id="imagem" name="imagem"
                                                                       value="<?php echo $img; ?>">

                                                                Selecionar esta imagem!!!

                                                                <br>

                                                            </div>

                                                            <br>

                                                        </div>


                                                        <?php $g++;
                                                    } ?>

                                                </div>

                                                <?php

                                            }
                                            if ($id == 9) {

                                                $sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
                                                $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

                                                $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
                                                $img = glob($caminho . "*.{JPG,jpg,png,gif}", GLOB_BRACE);
                                                $contador = count($img);

                                                ?>

                                                <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

                                                <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

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

                                                <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

                                                <div class="row">

                                                    <?php

                                                    $g = 0;

                                                    foreach ($img as $img) {

                                                        ?>

                                                        <div class="col-md-2">

                                                            <div class="thumbnail">

                                                                <a class="example-image-link" href="<?php echo $img; ?>"
                                                                   data-lightbox="example-set"><img alt=""
                                                                                                    src="<?php echo $img; ?>"/></a>


                                                            </div>

                                                            <br>

                                                            <div align="center">

                                                                <?php

                                                                $imagem = explode("/", $img);
                                                                $imagemfinal = $imagem[6];

                                                                $nomeimagem = explode(".", $imagemfinal);

                                                                ?>

                                                                <input type="radio" id="imagem" name="imagem"
                                                                       value="<?php echo $img; ?>">

                                                                Selecionar esta imagem!!!

                                                                <br>

                                                            </div>

                                                            <br>

                                                        </div>


                                                        <?php $g++;
                                                    } ?>

                                                </div>

                                                <?php

                                            }
                                            if ($id == 10) {

                                                $sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
                                                $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

                                                $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
                                                $img = glob($caminho . "*.{JPG,jpg,png,gif}", GLOB_BRACE);
                                                $contador = count($img);

                                                ?>

                                                <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

                                                <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

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

                                                <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

                                                <div class="row">

                                                    <?php

                                                    $g = 0;

                                                    foreach ($img as $img) {

                                                        ?>

                                                        <div class="col-md-2">

                                                            <div class="thumbnail">

                                                                <a class="example-image-link" href="<?php echo $img; ?>"
                                                                   data-lightbox="example-set"><img alt=""
                                                                                                    src="<?php echo $img; ?>"/></a>


                                                            </div>

                                                            <br>

                                                            <div align="center">

                                                                <?php

                                                                $imagem = explode("/", $img);
                                                                $imagemfinal = $imagem[6];

                                                                $nomeimagem = explode(".", $imagemfinal);

                                                                ?>

                                                                <input type="radio" id="imagem" name="imagem"
                                                                       value="<?php echo $img; ?>">

                                                                Selecionar esta imagem!!!

                                                                <br>

                                                            </div>

                                                            <br>

                                                        </div>


                                                        <?php $g++;
                                                    } ?>

                                                </div>

                                                <?php

                                            }
                                            if ($id == 11) {

                                                $sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
                                                $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

                                                $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
                                                $img = glob($caminho . "*.{JPG,jpg,png,gif}", GLOB_BRACE);
                                                $contador = count($img);

                                                ?>

                                                <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

                                                <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

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

                                                <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

                                                <div class="row">

                                                    <?php

                                                    $g = 0;

                                                    foreach ($img as $img) {

                                                        ?>

                                                        <div class="col-md-2">

                                                            <div class="thumbnail">

                                                                <a class="example-image-link" href="<?php echo $img; ?>"
                                                                   data-lightbox="example-set"><img alt=""
                                                                                                    src="<?php echo $img; ?>"/></a>


                                                            </div>

                                                            <br>

                                                            <div align="center">

                                                                <?php

                                                                $imagem = explode("/", $img);
                                                                $imagemfinal = $imagem[6];

                                                                $nomeimagem = explode(".", $imagemfinal);

                                                                ?>

                                                                <input type="radio" id="imagem" name="imagem"
                                                                       value="<?php echo $img; ?>">

                                                                Selecionar esta imagem!!!

                                                                <br>

                                                            </div>

                                                            <br>

                                                        </div>


                                                        <?php $g++;
                                                    } ?>

                                                </div>

                                                <?php

                                            }
                                            if ($id == 12) {

                                                $sql_arquivo_formando = mysqli_query($con, "select * from tipos_arquivos_formando where id_tipo = '$id' and id_formando = '$vetor_cadastro[id_formando]'");
                                                $vetor_arquivo_formando = mysqli_fetch_array($sql_arquivo_formando);

                                                $caminho = "../sistema/arquivos/formandos/fotosconvite/$vetor_arquivo_formando[pasta]/";
                                                $img = glob($caminho . "*.{JPG,jpg,png,gif}", GLOB_BRACE);
                                                $contador = count($img);

                                                ?>

                                                <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

                                                <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

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

                                                <h3>Selecione <?php echo $vetor_tipo['nome']; ?></h3>

                                                <div class="row">

                                                    <?php

                                                    $g = 0;

                                                    foreach ($img as $img) {

                                                        ?>

                                                        <div class="col-md-2">

                                                            <div class="thumbnail">

                                                                <a class="example-image-link" href="<?php echo $img; ?>"
                                                                   data-lightbox="example-set"><img alt=""
                                                                                                    src="<?php echo $img; ?>"/></a>


                                                            </div>

                                                            <br>

                                                            <div align="center">

                                                                <?php

                                                                $imagem = explode("/", $img);
                                                                $imagemfinal = $imagem[6];

                                                                $nomeimagem = explode(".", $imagemfinal);

                                                                ?>

                                                                <input type="radio" id="imagem" name="imagem"
                                                                       value="<?php echo $img; ?>">

                                                                Selecionar esta imagem!!!

                                                                <br>

                                                            </div>

                                                            <br>

                                                        </div>


                                                        <?php $g++;
                                                    } ?>

                                                </div>

                                            <?php } ?>

                                            <button type="submit" class="btn btn-primary" style="    float: left;">
                                                Salvar
                                            </button>

                                        </div>

                                    </section>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <footer class="footer text-center">
                Todos direitos reservados. <a href="https://studiomfotografia.com.br">Studio M Fotografia</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->

    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="../layout/dist/js/app.min.js"></script>
    <!-- minisidebar -->
    <script>
        $(function () {
            "use strict";
            $("#main-wrapper").AdminSettings({
                Theme: false, // this can be true or false ( true means dark and false means light ),
                Layout: 'vertical',
                LogoBg: 'skin5', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                NavbarBg: 'skin5', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarType: 'mini-sidebar', // You can change it full / mini-sidebar / iconbar / overlay
                SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarPosition: false, // it can be true / false ( true means Fixed and false means absolute )
                HeaderPosition: false, // it can be true / false ( true means Fixed and false means absolute )
                BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid )
            });
        });
    </script>
    <script src="../layout/dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../layout/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../layout/assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../layout/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../layout/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../layout/dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="../layout/assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../layout/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 charts -->
    <script src="../layout/assets/extra-libs/c3/d3.min.js"></script>
    <script src="../layout/assets/extra-libs/c3/c3.min.js"></script>
    <!--chartjs -->
    <script src="../layout/assets/libs/chart.js/dist/Chart.min.js"></script>
    <script src="../layout/dist/js/pages/dashboards/dashboard1.js"></script>
    <script src="../layout/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../layout/dist/js/pages/datatable/datatable-basic.init.js"></script>
    </body>

    </html>
<?php } ?>