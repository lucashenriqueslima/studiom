<?php
include "../includes/conexao.php";
session_start();

if(isset($_GET['fotos'])){
    $vetor_conviteu = mysqli_fetch_array(mysqli_query($con, "select * from convite_personal where id_convite = '$_GET[fotos]' order by id_convite DESC"));
    $sqlu = mysqli_query($con, "select * from convite_personal_itens where id_convite = '$vetor_conviteu[id_convite]' order by id_item ASC");
    $zip = new ZipArchive();
    $nome = $vetor_conviteu['id_formando'].'.zip';
    if($zip->open($nome, ZIPARCHIVE::CREATE) == TRUE) {
        while ($vetor_itensu = mysqli_fetch_array($sqlu)) {
            $sql_fotos = mysqli_query($con, "select * from convite_personal_escolhas where id_item = '$vetor_itensu[id_item]'");
            while ($vetor_fotos = mysqli_fetch_array($sql_fotos)) {
                $imagem = explode("/", $vetor_fotos['imagem']);
                $imagemfinal = $imagem[3];
                $zip->addFile($vetor_fotos['imagem'],$imagemfinal);
            }

        }
    }
    $zip->close();
    header("Content-length: " . filesize( "$nome" ) );
    header("Content-type: application/octet-stream");
    header("Content-disposition: attachment; filename=$nome");
    readfile( "$nome" );
    unlink("$nome");
    die();
}

if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
} else {
    $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);
    $id = $_GET['id'];
    $sql = mysqli_query($con, "select * from formandos where id_formando = '$id'");
    $vetor = mysqli_fetch_array($sql);
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
        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
                border: 0;
                outline: 0;
                box-sizing: border-box;
            }

            html, body {
                height: 100%;
            }


            /** THUMBNAILS GLOBALS **/
            .thumbnails {
                display: flex;
                flex-wrap: wrap;
            }

            .thumbnails a {
                width: 200px;
                height: 200px;
                margin: 14px;
                border-radius: 2px;
                overflow: hidden;
            }

            .thumbnails img {
                height: 100%;
                object-fit: cover;
                transition: transform .3s;
            }

            .thumbnails a:hover img {
                transform: scale(1.05);
            }

            /** THUMBNAILS GRID **/
            .thumbnails.grid a.double {
                width: calc(50% - 4px);
            }

            .thumbnails.grid img {
                width: 100%;
            }

            /** THUMBNAILS MASONRY **/
            .thumbnails.masonry a {
                flex-grow: 1;
            }

            .thumbnails.masonry img {
                min-width: 100%;
            }
        </style>
        <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../layout/dist/css/style.min.css" rel="stylesheet">

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>


        <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

        <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>

        <style type="text/css">
            .thumbnail {
                position: relative;
                width: 300px;
                height: 300px;
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
                    <a class="navbar-brand" href="dashboard.php">
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
                                        src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>" alt="user"
                                        class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img
                                                src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>"
                                                alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $_SESSION['nome']; ?></h4>
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
                        <!--                        <h4 class="page-title">Arte Final - Convite</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Arte Final - Convite</a></li>
                                    <li class="breadcrumb-item">Arquivos de Convite</a></li>
                                    <li class="breadcrumb-item">Turma</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Alterar Turma</li>
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

                                <div class="alert alert-secondary" role="alert">
                                    <h4><strong>Nome do Formando</strong></h4>
                                    <br>
                                    <?php echo $vetor['nome']; ?>

                                </div>

                                <div class="alert alert-secondary" role="alert">

                                    <h4><strong>Nome dos Pais</strong></h4>
                                    <br>
                                    <?php
                                    $sql_pais_formanados = mysqli_fetch_array(mysqli_query($con, "SELECT f.pai, f.mae, f.inmemorianpai, f.inmemorianmae, f.nao_mostrar_pai_convite, f.nao_mostrar_mae_convite FROM formandos f WHERE f.id_formando = '$_SESSION[id_formando]'"));
                                    
                                    
                                        if($sql_pais_formanados['nao_mostrar_pai_convite'] != 1){
                                            echo "Pai: " . $sql_pais_formanados['pai'] . ($sql_pais_formanados['inmemorianpai'] != 1 ? '' : ' | (In Memoriam)') . "<br>";
                                        }

                                        if($sql_pais_formanados['nao_mostrar_mae_convite'] != 1){
                                            echo "Mãe: " . $sql_pais_formanados['mae'] . ($sql_pais_formanados['inmemorianmae'] != 1 ? '' : ' | (In Memoriam)') . "<br>";
                                        }

                                    
                                    $sql_consulta_pais = mysqli_query($con, "select * from dadosconvite_nomes where id_formando = '$id'");
                                    while ($vetor_consulta_pais = mysqli_fetch_array($sql_consulta_pais)) {
                                        ?>

                                        <?php echo $vetor_consulta_pais['nome'] . ($vetor_consulta_pais['inmemoriam'] == '0' ? '' : ' | (In Memoriam)'); ?>

                                        <br>

                                    <?php } ?>

                                </div>

                                <?php
                                $sql_itens = mysqli_query($con, "select * from tipos_arquivos_turma where id_turma = '$vetor[turma]' order by id_tipo ASC");
                                while ($vetor_itens = mysqli_fetch_array($sql_itens)) {
                                    $sql_tipo = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '$vetor_itens[id_tipo]'");
                                    $vetor_tipo = mysqli_fetch_array($sql_tipo);
                                    ?>

                                    <div class="alert alert-secondary" role="alert">

                                        <h4><strong><?php echo $vetor_tipo['nome']; ?></strong></h4>

                                        <?php
                                        $sql_consulta = mysqli_query($con, "select * from dadosconvite where id_formando = '$id' and id_tipo = '$vetor_itens[id_tipo]'");
                                        $vetor_consulta = mysqli_fetch_array($sql_consulta);
                                        if ($vetor_itens['id_tipo'] == 1) {
                                            echo "<br>";
                                            echo "<p>" . nl2br($vetor_consulta['texto']) . "</p>";
                                            ?>

                                            <br>
                                            <br>

                                            <a href="confexcluirverarquivo.php?id=<?php echo $vetor_consulta['id_dados']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                            <?php
                                        }
                                        if ($vetor_itens['id_tipo'] == 2) {
                                            echo "<br>";
                                            echo "<p>" . nl2br($vetor_consulta['texto']) . "</p>";
                                            ?>

                                            <br>
                                            <br>

                                            <a href="confexcluirverarquivo.php?id=<?php echo $vetor_consulta['id_dados']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                        <?php }
                                        if ($vetor_itens['id_tipo'] == 3) { ?>

                                            <div class="thumbnail">

                                                <a class="example-image-link"
                                                   href="<?php echo 'arquivos/' . $vetor_consulta['imagem']; ?>"
                                                   data-lightbox="example-set"><img alt=""
                                                                                    src="<?php echo 'arquivos/' . $vetor_consulta['imagem']; ?>"/></a>


                                            </div>

                                            <br>

                                            <?php echo $vetor_consulta['imagem']; ?>

                                            <br>
                                            <br>

                                            <a href="confexcluirverarquivo.php?id=<?php echo $vetor_consulta['id_dados']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                        <?php }
                                        if ($vetor_itens['id_tipo'] == 4) { ?>

                                            <div class="row">
                                                <?php
                                                $vetor_conviteu = mysqli_fetch_array(mysqli_query($con, "select * from convite_personal where id_formando = '$id' order by id_convite DESC"));
                                                $sqlu = mysqli_query($con, "select * from convite_personal_itens where id_convite = '$vetor_conviteu[id_convite]' order by id_item ASC");

                                                while ($vetor_itensu = mysqli_fetch_array($sqlu)) {
                                                    $sql_fotos = mysqli_query($con, "select * from convite_personal_escolhas where id_item = '$vetor_itensu[id_item]'");

                                                    if (mysqli_num_rows($sql_fotos) > 0) {

                                                        ?>

                                                        <div class="row">

                                                            <?php

                                                            while ($vetor_fotos = mysqli_fetch_array($sql_fotos)) {

                                                                ?>

                                                                <br>

                                                                <div class="col-md-3">

                                                                    <div class="thumbnails grid">

                                                                        <a class="image-popup-vertical-fit"
                                                                           href="<?php echo $vetor_fotos['imagem']; ?>"><img
                                                                                    src="<?php echo $vetor_fotos['imagem']; ?>"
                                                                                    alt="" download></a>

                                                                    </div>

                                                                </div>

                                                            <?php } ?>

                                                        </div>
                                                    <?php } ?>

                                                    <br>
                                                    <br>
                                                    <br>

                                                <?php } ?>
                                            </div>
                                            <a href="verarquivoconvite.php?fotos=<?php echo $vetor_conviteu['id_convite']; ?>" target="_blank">
                                                <button type="button" class="btn btn-success"
                                                        title="Baixar Todas as Fotos">Download
                                                </button>
                                            </a>
                                            <br>
                                            <br>
                                            <a href="confexcluirverarquivofotofamilia.php?id=<?php echo $vetor_itens['id_tipo']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                        <?php }
                                        if ($vetor_itens['id_tipo'] == 5) { ?>

                                            <div class="row">

                                                <?php
                                                $sql_consulta_5 = mysqli_query($con, "select * from dadosconvite where id_formando = '$id' and id_tipo = '5'");
                                                while ($vetor_consulta_5 = mysqli_fetch_array($sql_consulta_5)) {
                                                    ?>

                                                    <div class="col-lg-3">

                                                        <div class="thumbnail">

                                                            <a class="example-image-link"
                                                               href="<?php if ($vetor_consulta_5['upload'] == 1) {
                                                                   echo $vetor_consulta_5['imagem'];
                                                               } else {
                                                                   echo 'arquivos/' . $vetor_consulta_5['imagem'];
                                                               } ?>" data-lightbox="example-set"><img alt=""
                                                                                                      src="<?php if ($vetor_consulta_5['upload'] == 1) {
                                                                                                          echo $vetor_consulta_5['imagem'];
                                                                                                      } else {
                                                                                                          echo 'arquivos/' . $vetor_consulta_5['imagem'];
                                                                                                      } ?>"/></a>

                                                        </div>

                                                        <br>

                                                        <?php echo $vetor_consulta_5['imagem']; ?>

                                                    </div>

                                                <?php } ?>

                                            </div>

                                            <br>
                                            <br>

                                            <a href="confexcluirverarquivofotofamilia.php?id=<?php echo $vetor_itens['id_tipo']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                        <?php }
                                        if ($vetor_itens['id_tipo'] == 6) { ?>

                                            <br>

                                            <div class="thumbnail">

                                                <a class="example-image-link"
                                                   href="<?php echo $vetor_consulta['imagem']; ?>"
                                                   data-lightbox="example-set"><img alt=""
                                                                                    src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                            </div>

                                            <br>

                                            <?php echo $vetor_consulta['imagem']; ?>

                                            <br>
                                            <br>

                                            <a href="confexcluirverarquivo.php?id=<?php echo $vetor_consulta['id_dados']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                        <?php }
                                        if ($vetor_itens['id_tipo'] == 7) { ?>

                                            <br>

                                            <div class="thumbnail">

                                                <a class="example-image-link"
                                                   href="<?php echo $vetor_consulta['imagem']; ?>"
                                                   data-lightbox="example-set"><img alt=""
                                                                                    src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                            </div>

                                            <br>

                                            <?php echo $vetor_consulta['imagem']; ?>

                                            <br>
                                            <br>

                                            <a href="confexcluirverarquivo.php?id=<?php echo $vetor_consulta['id_dados']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                        <?php }
                                        if ($vetor_itens['id_tipo'] == 8) { ?>

                                            <br>

                                            <div class="thumbnail">

                                                <a class="example-image-link"
                                                   href="<?php echo $vetor_consulta['imagem']; ?>"
                                                   data-lightbox="example-set"><img alt=""
                                                                                    src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                            </div>

                                            <br>

                                            <?php echo $vetor_consulta['imagem']; ?>

                                            <br>
                                            <br>

                                            <a href="confexcluirverarquivo.php?id=<?php echo $vetor_consulta['id_dados']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                        <?php }
                                        if ($vetor_itens['id_tipo'] == 9) { ?>

                                            <br>

                                            <div class="thumbnail">

                                                <a class="example-image-link"
                                                   href="<?php echo $vetor_consulta['imagem']; ?>"
                                                   data-lightbox="example-set"><img alt=""
                                                                                    src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                            </div>

                                            <br>

                                            <?php echo $vetor_consulta['imagem']; ?>

                                            <br>
                                            <br>

                                            <a href="confexcluirverarquivo.php?id=<?php echo $vetor_consulta['id_dados']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                        <?php }
                                        if ($vetor_itens['id_tipo'] == 10) { ?>

                                            <br>

                                            <div class="thumbnail">

                                                <a class="example-image-link"
                                                   href="<?php echo $vetor_consulta['imagem']; ?>"
                                                   data-lightbox="example-set"><img alt=""
                                                                                    src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                            </div>

                                            <br>

                                            <?php echo $vetor_consulta['imagem']; ?>

                                            <br>
                                            <br>

                                            <a href="confexcluirverarquivo.php?id=<?php echo $vetor_consulta['id_dados']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                        <?php }
                                        if ($vetor_itens['id_tipo'] == 11) { ?>

                                            <br>

                                            <div class="thumbnail">

                                                <a class="example-image-link"
                                                   href="<?php echo $vetor_consulta['imagem']; ?>"
                                                   data-lightbox="example-set"><img alt=""
                                                                                    src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                            </div>

                                            <br>

                                            <?php echo $vetor_consulta['imagem']; ?>

                                            <br>
                                            <br>

                                            <a href="confexcluirverarquivo.php?id=<?php echo $vetor_consulta['id_dados']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                        <?php }
                                        if ($vetor_itens['id_tipo'] == 12) { ?>

                                            <br>

                                            <div class="thumbnail">

                                                <a class="example-image-link"
                                                   href="<?php echo $vetor_consulta['imagem']; ?>"
                                                   data-lightbox="example-set"><img alt=""
                                                                                    src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                            </div>

                                            <br>

                                            <?php echo $vetor_consulta['imagem']; ?>

                                            <br>
                                            <br>

                                            <a href="confexcluirverarquivo.php?id=<?php echo $vetor_consulta['id_dados']; ?>&id1=<?php echo $id; ?>">
                                                <button type="button" class="btn btn-danger mesmo-tamanho"
                                                        title="Excluir Cadastro">Excluir Cadastro
                                                </button>
                                            </a>

                                        <?php } ?>

                                    </div>

                                <?php } ?>
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