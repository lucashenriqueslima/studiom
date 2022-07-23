<?php

include "../includes/conexao.php";

session_start();

if ($_SESSION['id_formando'] == NULL || $_SESSION['id_formando'] == '') {

    echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";

} else {
    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$_SESSION[id_formando]'"));
    $id_item = $_GET['id'];
    $sql_itens = mysqli_query($con, "select * from pacotes_itens_produtos WHERE id_pacote = '$id_item'");
    $itens_album = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_itens_album where id_item = '$id_item'"));

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

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">
        <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../layout/assets/extra-libs/prism/prism.css">
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <style type="text/css">
            .thumbnail {
                width: 512px;
                position: relative;
                overflow: hidden;
                height: 384px;
            }

            #info {
                margin-top: -20px;
            }

            #setas {
                width: 512px;
                height: 384px;
                position: absolute;
            }

            #left {
                float: left;
                top: 40%;
                position: relative;
                left: -10%
            }

            #right {
                float: right;
                top: 40%;
                position: relative;
                right: -10%
            }

            @media only screen and (max-width: 425px) {
                .thumbnail {
                    width: 292px;
                    position: relative;
                    overflow: hidden;
                    height: 219px;
                }

                #info {
                    margin-top: -10px;
                }

                #setas {
                    width: 292px;
                    height: 219px;
                    position: absolute;
                }

                #left {
                    left: -18%;
                }

                #right {
                    right: -18%;
                }
            }

            .thumbnail img {
                width: 100%;
                height: auto;
            }
            .adjustimg{
                max-width: 100%;
                max-height: 100%;
            }
            #descricaopacote {
                position: absolute;
                left: 550px;
            }

            @media only screen and (max-width: 900px) {
                #descricaopacote {
                    position: relative;
                    left: 0;
                }
            }

        </style>
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
                        <h4 class="page-title">Minhas Compras</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Minhas Compras</li>
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
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h3><?php echo ucfirst($itens_album['titulo']); ?></h3>
                                <div class="row" style="margin-top: 15px;margin-left: 20px;white-space: pre-wrap;">
                                    <div id="bread_inicio"></div>
                                    <?php
                                    $i = 0;
                                    $qtd = mysqli_num_rows($sql_itens);
                                    while ($vetor_item = mysqli_fetch_array($sql_itens)) {
                                        $tipo = mysqli_fetch_array(mysqli_query($con, "select * from tipo_opcionais where id_tipo = '$vetor_item[id_produto]'"));
                                        $spec = mysqli_query($con, "select * from produtos_especificacoes where id_tipo_produto = '$tipo[id_tipo]'");
                                        ?>
                                        <h5 id="bread<?php echo $vetor_item['id_produto_item']; ?>" style="
                                        <?php if ($i != 0) {
                                            echo "font-weight: normal;";
                                        } else {
                                            echo "color:#7460ee;font-weight: bolder;border-bottom:1px solid #7460ee;";
                                        } ?>margin-left: 20px;white-space: pre-wrap;margin-bottom: 5px;line-height:1;cursor:pointer"><?php echo ucfirst($tipo['nome']); ?></h5>

                                        <?php $i++;
                                    }
                                    $sql_itens = mysqli_query($con, "select * from pacotes_itens_produtos WHERE id_pacote = '$id_item'");
                                    ?>
                                    <div id="bread_fim"></div>
                                </div>
                                <br>
                                <div id="inicio"></div>
                                <?php
                                $lock = 0;
                                while ($vetor_item = mysqli_fetch_array($sql_itens)) {
                                    $tipo = mysqli_fetch_array(mysqli_query($con, "select * from tipo_opcionais where id_tipo = '$vetor_item[id_produto]'"));
                                    $spec = mysqli_query($con, "select * from produtos_especificacoes where id_tipo_produto = '$tipo[id_tipo]'");
                                    if ($vetor_item['chave_imagem'] == null) {
                                        $chave_imagem = $tipo['chave_imagem'];
                                    } else {
                                        $chave_imagem = $vetor_item['chave_imagem'];
                                    }
                                    ?>
                                    <div id="esconde<?php echo $vetor_item['id_produto_item']; ?>" <?php if ($lock != 0) {
                                        echo "hidden";
                                    } ?>>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <div class="white-box text-center">
                                                    <div id="produto<?php echo $vetor_item['id_produto_item']; ?>"
                                                         class="carousel slide"
                                                         data-ride="carousel">
                                                        <div class="carousel-inner thumbnail" role="listbox">
                                                            <?php
                                                            $first = 0;
                                                            $imagens = mysqli_query($con, "select * from imagens_produtos where id_produto = '$tipo[id_tipo]' and chave_imagem='$chave_imagem' order by posicao ASC");
                                                            while ($imagem = mysqli_fetch_array($imagens)) { ?>
                                                                <div class="carousel-item <?php if ($first == 0) {
                                                                    echo "active";
                                                                } ?>">
                                                                    <a class="img-fluid"
                                                                       href="<?php echo $imagem['imagem']; ?>"
                                                                       data-lightbox="<?php echo $vetor_item['id_produto_item']; ?>">
                                                                        <img alt="" class="adjustimg"
                                                                             src="<?php echo $imagem['imagem']; ?>"/>
                                                                    </a>
                                                                </div>
                                                                <?php $first = 1;
                                                            } ?>
                                                            <a class="carousel-control-prev"
                                                               href="#produto<?php echo $vetor_item['id_produto_item']; ?>"
                                                               role="button"
                                                               data-slide="prev"> <span
                                                                        class="carousel-control-prev-icon"
                                                                        aria-hidden="true"></span> <span
                                                                        class="sr-only">Previous</span> </a>
                                                            <a class="carousel-control-next"
                                                               href="#produto<?php echo $vetor_item['id_produto_item']; ?>"
                                                               role="button"
                                                               data-slide="next"> <span
                                                                        class="carousel-control-next-icon"
                                                                        aria-hidden="true"></span> <span
                                                                        class="sr-only">Next</span> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="descricaopacote" class="col-lg-5 col-md-12 col-sm-12">
                                                <h4 class="box-title m-t-40">Descrição do Pacote</h4>
                                                <p><?php echo $itens_album['descricao']; ?></p>
                                                <a href="compra_album_pagamento.php?id_pacote=<?php echo $id_item; ?>">
                                                    <button class="btn btn-primary"> Comprar Pacote</button>
                                                </a>
                                            </div>
                                            <div id="info" class="col-lg-12 col-md-12 col-sm-12">
                                                <h3 class="box-title m-t-40">Informações Gerais</h3>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                        <?php while ($especificacao = mysqli_fetch_array($spec)) { ?>
                                                            <tr>
                                                                <td width="390"><?php echo $especificacao['esquerda']; ?></td>
                                                                <td><?php echo $especificacao['direita']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php if ($vetor_item['id_produto'] == '19' || $vetor_item['id_produto'] == '20' || $vetor_item['id_produto'] == '13' || $vetor_item['id_produto'] == '22' || $vetor_item['id_produto'] == '15' || $vetor_item['id_produto'] == '10') { ?>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h2 class="box-title m-t-40" align="center" style="text-decoration: underline">Fotos dos Eventos deste Pacote</h2>
                                                    <?php
                                                    $sql_eventos = mysqli_query($con, "select a.*,c.nome as nome_cat,c.chave_imagem as cat_chave from studioms_sistema.eventos_pacote a 
	left join studioms_sistema.eventos_turma_lista b on a.id_evento = b.id_evento_turma
	left join studioms_sistema.categoriaevento c on b.id_evento = c.id_categoria
	where a.id_pacote = '$id_item' order by c.posicao");
                                                    while ($eventos = mysqli_fetch_array($sql_eventos)) {
                                                        if ($eventos['chave_imagem'] == null) {
                                                            $chave_imagem = $eventos['cat_chave'];
                                                        } else {
                                                            $chave_imagem = $eventos['chave_imagem'];
                                                        }
                                                        ?>
                                                        <h2 class="box-title m-t-40"><span><i class="fas fa-sm fa-camera-retro"></i></span> <?php echo $eventos['nome_cat']; ?></h2>
                                                        <br>
                                                            <?php
                                                            $imagens = mysqli_query($con, "select * from imagens_produtos where chave_imagem='$chave_imagem' order by posicao ASC");
                                                            while ($imagem = mysqli_fetch_array($imagens)) { ?>

                                                                    <a class="img-thumbnail"
                                                                       href="<?php echo $imagem['imagem']; ?>"
                                                                       data-lightbox="12">
                                                                        <img alt="" class="img-thumbnail"
                                                                             src="<?php echo $imagem['imagem']; ?>"/>
                                                                    </a>
                                                                <br>
                                                                <?php $first = 1;
                                                            } ?>
                                                    <?php } ?>


                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php $lock = 1;
                                } ?>
                                <div id="fim"></div>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <!-- ============================================================== -->
                    <!-- End PAge Content -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Right sidebar -->
                    <!-- ============================================================== -->
                    <!-- .right-sidebar -->
                    <!-- ============================================================== -->
                    <!-- End Right sidebar -->
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
            <!-- Bootstrap tether Core JavaScript -->
            <script src="../layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
            <script src="../layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
            <!-- apps -->
            <script src="../layout/dist/js/app.min.js"></script>
            <!-- minisidebar -->
            <script type="text/javascript">
                var maximo = <?php echo --$qtd; ?>;
                var minimo = 0;
                $(document).ready(function () {
                    <?php
                    $i = 0;
                    $sql_itens = mysqli_query($con, "select * from pacotes_itens_produtos WHERE id_pacote = '$id_item'");
                    while ($vetor_item = mysqli_fetch_array($sql_itens)) {
                    ?>
                    $("#bread<?php echo $vetor_item['id_produto_item']; ?>").click(function () {
                        var escolha = "esconde<?php echo $vetor_item['id_produto_item']; ?>";
                        escondeProdutos();
                        $("#" + escolha).removeAttr('hidden');
                        $("#bread<?php echo $vetor_item['id_produto_item']; ?>").removeAttr('style');
                        $("#bread<?php echo $vetor_item['id_produto_item']; ?>").attr('style', 'margin-left: 20px;white-space: pre-wrap;font-weight:bolder;color:#7460ee;border-bottom:1px solid #7460ee;margin-bottom: 5px;line-height: 1;cursor:pointer');
                    });
                    <?php } ?>
                });

                function escondeProdutos() {
                    var atual = document.getElementById("inicio").nextElementSibling.id;
                    while (atual != 'fim') {
                        $("#" + atual).attr('hidden', 'hidden');
                        atual = document.getElementById(atual).nextElementSibling.id;
                    }
                    var atual = document.getElementById("bread_inicio").nextElementSibling.id;
                    while (atual != 'bread_fim') {
                        $("#" + atual).removeAttr('style');
                        $("#" + atual).attr('style', 'margin-left: 20px;white-space: pre-wrap;font-weight:normal;margin-bottom: 5px;line-height: 1;cursor:pointer');
                        atual = document.getElementById(atual).nextElementSibling.id;
                    }
                }

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
            <!-- Bootstrap tether Core JavaScript -->
            <script src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
            <script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
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
            <script src="../layout/assets/extra-libs/prism/prism.js"></script>
            <!--chartis chart-->
    </body>

    </html>
<?php } ?>