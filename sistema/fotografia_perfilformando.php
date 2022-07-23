<?php


include "../includes/conexao.php";

session_start();

if ($_SESSION['id'] == NULL) {

    echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
} else {
    $id_formando = $_GET['id_formando'];
    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$id_formando'"));
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
                           aria-controls="navbarSupportedContent" aria-expanded="false"
                           aria-label="Toggle navigation"><i class="ti-more"></i></a>
                    </div>

                    <div class="navbar-collapse collapse" id="navbarSupportedContent">

                        <ul class="navbar-nav float-left mr-auto">
                            <li class="nav-item d-none d-md-block"><a
                                    class="nav-link sidebartoggler waves-effect waves-light"
                                    href="javascript:void(0)" data-sidebartype="mini-sidebar"><i
                                        class="mdi mdi-menu font-24"></i></a></li>


                        </ul>

                        <ul class="navbar-nav float-right">


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                        src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"
                                        alt="user" class="rounded-circle" width="31"></a>
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
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Perfil Fotográfico</li>
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
                                    <h4 class="card-title">Perfil Fotográfico - <?php echo $vetor_cadastro['nome']; ?></h4>

                                    <br>

                                    <?php

                                    $sql_consulta = mysqli_query($con, "select * from meuperfilfotografico where id_formando = '$vetor_cadastro[id_formando]'");

                                    $vetor_consulta = mysqli_fetch_array($sql_consulta);

                                    $sql_fotosladorosto = mysqli_query($con, "select * from fotoslado where id_formando = '$vetor_cadastro[id_formando]'");

                                    $sql_fotospreferidas = mysqli_query($con, "select * from fotospreferidas where id_formando = '$vetor_cadastro[id_formando]'");

                                    $sql_referenciasfotograficas = mysqli_query($con, "select * from referenciasfotograficas where id_formando = '$vetor_cadastro[id_formando]'");

                                    ?>

                                    <ul class="nav nav-tabs" role="tablist">

                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#dados"
                                                                role="tab"><span class="hidden-sm-up"><i
                                                        class="ti-email"></i></span> <span
                                                    class="hidden-xs-down">Dados</span></a></li>

                                        <?php if (mysqli_num_rows($sql_fotosladorosto) > 0) { ?>

                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#fotosladorosto" role="tab"><span
                                                        class="hidden-sm-up"><i class="ti-image"></i></span> <span
                                                        class="hidden-xs-down">Fotos Lado do Rosto</span></a></li>

                                        <?php } ?>

                                        <?php if (mysqli_num_rows($sql_fotospreferidas) > 0) { ?>

                                            <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                    href="#fotospreferidas" role="tab"><span
                                                        class="hidden-sm-up"><i class="ti-image"></i></span> <span
                                                        class="hidden-xs-down">Minhas Fotos Preferidas</span></a></li>

                                        <?php } ?>

                                        <?php if (mysqli_num_rows($sql_referenciasfotograficas) > 0) { ?>

                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#referencias"
                                                                    role="tab"><span class="hidden-sm-up"><i
                                                            class="ti-image"></i></span> <span class="hidden-xs-down">Eventos - Referências Fotográficas</span></a>
                                            </li>

                                        <?php } ?>

                                    </ul>

                                    <div class="tab-content tabcontent-border">

                                        <div class="tab-pane active" id="dados" role="tabpanel">

                                            <br>
                                            <br>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold" for="exampleInput">Você se
                                                                sente bem ao ser fotografado (a)?</label>
                                                            <select readonly='' name="gostafotografico" class="form-control"
                                                                    required="">
                                                                <option value="" selected="">Selecione...</option>
                                                                <option value="Sim. Gosto de ser fotografado (a)" <?php if ($vetor_consulta['gostafotografico'] == 'Sim. Gosto de ser fotografado (a)') { ?> selected="" <?php } ?>>
                                                                    Sim. Gosto de ser fotografado (a).
                                                                </option>
                                                                <option value="Não. Não gosto de ser fotografado (a)" <?php if ($vetor_consulta['gostafotografico'] == 'Não. Não gosto de ser fotografado (a)') { ?> selected="" <?php } ?>>
                                                                    Não. Não gosto de ser fotografado (a).
                                                                </option>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold" for="exampleInput">Você se
                                                                sente melhor ao ser fotografado (a) por alguém do mesmo
                                                                sexo?</label>
                                                            <select readonly='' name="sexofotografo" class="form-control" required="">
                                                                <option value="" selected="">Selecione...</option>
                                                                <option value="Sim" <?php if ($vetor_consulta['sexofotografo'] == 'Sim') { ?> selected="" <?php } ?>>
                                                                    Sim.
                                                                </option>
                                                                <option value="Não" <?php if ($vetor_consulta['sexofotografo'] == 'Não. Não tenho problema quanto a isso') { ?> selected="" <?php } ?>>
                                                                    Não. Não tenho problema quanto a isso.
                                                                </option>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold" for="exampleInput">Qual parte
                                                                do seu corpo você mais gosta?</label>
                                                            <input readonly='' type="text" name="qualparte"
                                                                   value="<?php echo $vetor_consulta['qualparte']; ?>"
                                                                   class="form-control">
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <?php if ($vetor_consulta['parteincomoda'] == 'Sim') { ?>

                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <fieldset class="form-group">
                                                                <label class="form-label semibold" for="exampleInput">Alguma
                                                                    parte do seu corpo te incomoda?</label>
                                                                <select readonly='' name="parteincomoda" id="tipobusca"
                                                                        class="form-control" required="">
                                                                    <option value="" selected="">Selecione...</option>
                                                                    <option value="Sim" <?php if ($vetor_consulta['parteincomoda'] == 'Sim') { ?> selected="" <?php } ?>>
                                                                        Sim.
                                                                    </option>
                                                                    <option value="Não" <?php if ($vetor_consulta['parteincomoda'] == 'Não') { ?> selected="" <?php } ?>>
                                                                        Não. Não tenho problema com meu corpo.
                                                                    </option>
                                                                </select>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-lg-8">


                                                            <div class="row">

                                                                <div class="col-lg-6">

                                                                    <fieldset class="form-group">
                                                                        <label class="form-label semibold"
                                                                               for="exampleInput">Qual?</label>
                                                                        <input readonly='' type="text" name="qual"
                                                                               value="<?php echo $vetor_consulta['qual']; ?>"
                                                                               class="form-control">
                                                                    </fieldset>

                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <fieldset class="form-group">
                                                                        <label class="form-label semibold"
                                                                               for="exampleInput">Podemos fazer algo para
                                                                            que se sinta melhor?</label>
                                                                        <input readonly='' type="text" name="podemosfazeralgo"
                                                                               value="<?php echo $vetor_consulta['podemosfazeralgo']; ?>"
                                                                               class="form-control">
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                <?php } else { ?>

                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <fieldset class="form-group">
                                                                <label class="form-label semibold" for="exampleInput">Alguma
                                                                    parte do seu corpo te incomoda?</label>
                                                                <select readonly='' name="parteincomoda" id="tipobusca"
                                                                        class="form-control" required="">
                                                                    <option value="" selected="">Selecione...</option>
                                                                    <option value="Sim" <?php if ($vetor_consulta['parteincomoda'] == 'Sim') { ?> selected="" <?php } ?>>
                                                                        Sim.
                                                                    </option>
                                                                    <option value="Não" <?php if ($vetor_consulta['parteincomoda'] == 'Não') { ?> selected="" <?php } ?>>
                                                                        Não. Não tenho problema com meu corpo.
                                                                    </option>
                                                                </select>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-lg-8">

                                                            <div id="palco1">

                                                                <div id="Sim">

                                                                    <div class="row">

                                                                        <div class="col-lg-6">

                                                                            <fieldset class="form-group">
                                                                                <label class="form-label semibold"
                                                                                       for="exampleInput">Qual?</label>
                                                                                <input readonly='' type="text" name="qual"
                                                                                       value="<?php echo $vetor_consulta['qual']; ?>"
                                                                                       class="form-control">
                                                                            </fieldset>

                                                                        </div>

                                                                        <div class="col-lg-6">
                                                                            <fieldset class="form-group">
                                                                                <label class="form-label semibold"
                                                                                       for="exampleInput">Podemos fazer algo
                                                                                    para que se sinta melhor?</label>
                                                                                <input readonly='' type="text" name="podemosfazeralgo"
                                                                                       value="<?php echo $vetor_consulta['podemosfazeralgo']; ?>"
                                                                                       class="form-control">
                                                                            </fieldset>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                <?php } ?>

                                                <h4>Qual sua preferência por fotos? Marque todos os campos indicando de
                                                    forma ordenada o estilo de foto que mais gosta?</h4>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <fieldset class="form-group">
                                                            <select readonly='' name="close" class="form-control" required="">
                                                                <option value="" selected="">(1) Selecione...</option>
                                                                <option value="Close" <?php if ($vetor_consulta['close'] == 'Close') { ?> selected="" <?php } ?>>
                                                                    Close
                                                                </option>
                                                                <option value="Meio corpo" <?php if ($vetor_consulta['close'] == 'Meio corpo') { ?> selected="" <?php } ?>>
                                                                    Meio corpo
                                                                </option>
                                                                <option value="Corpo inteiro" <?php if ($vetor_consulta['close'] == 'Corpo inteiro') { ?> selected="" <?php } ?>>
                                                                    Corpo inteiro
                                                                </option>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <fieldset class="form-group">
                                                            <select readonly='' name="close1" class="form-control" required="">
                                                                <option value="" selected="">(2) Selecione...</option>
                                                                <option value="Close" <?php if ($vetor_consulta['meiocorpo'] == 'Close') { ?> selected="" <?php } ?>>
                                                                    Close
                                                                </option>
                                                                <option value="Meio corpo" <?php if ($vetor_consulta['meiocorpo'] == 'Meio corpo') { ?> selected="" <?php } ?>>
                                                                    Meio corpo
                                                                </option>
                                                                <option value="Corpo inteiro" <?php if ($vetor_consulta['meiocorpo'] == 'Corpo inteiro') { ?> selected="" <?php } ?>>
                                                                    Corpo inteiro
                                                                </option>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <fieldset class="form-group">
                                                            <select readonly='' name="close2" class="form-control" required="">
                                                                <option value="" selected="">(3) Selecione...</option>
                                                                <option value="Close" <?php if ($vetor_consulta['corpointeiro'] == 'Close') { ?> selected="" <?php } ?>>
                                                                    Close
                                                                </option>
                                                                <option value="Meio corpo" <?php if ($vetor_consulta['corpointeiro'] == 'Meio corpo') { ?> selected="" <?php } ?>>
                                                                    Meio corpo
                                                                </option>
                                                                <option value="Corpo inteiro" <?php if ($vetor_consulta['corpointeiro'] == 'Corpo inteiro') { ?> selected="" <?php } ?>>
                                                                    Corpo inteiro
                                                                </option>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <fieldset class="form-group">
                                                            <label class="form-label semibold" for="exampleInput">Quando
                                                                formos tratar suas fotografias, tem algo que sempre queira
                                                                que façamos antes de disponibilizarmos elas para você? Tirar
                                                                uma mancha, pinta, marca de expressão, etc...</label>
                                                            <input readonly='' type="text" name="tratamento"
                                                                   value="<?php echo $vetor_consulta['tratamento']; ?>"
                                                                   class="form-control">
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <h4>Qual o tipo de tratamento de imagem relativo a coloração das fotos você
                                                    prefere?</h4>

                                                <br>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <img src="imgs/a01_MG_3104.jpg" width="300px">
                                                        <br>
                                                        <br>
                                                        <img src="imgs/b01_MG_8176.jpg" width="300px">
                                                        <br>
                                                        <br>
                                                        <img src="imgs/c01_MG_8386.jpg" width="300px">
                                                        <br>
                                                        <br>
                                                        <div class="custom-control custom-radio">
                                                            <input readonly='' type="radio" id="customRadio1" name="coloracao"
                                                                   value="Coloração menos saturada"
                                                                   class="custom-control-input" <?php if ($vetor_consulta['coloracao'] == 'Coloração menos saturada') { ?> checked <?php } ?>>
                                                            <label class="custom-control-label" for="customRadio1">Coloração
                                                                menos saturada</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <img src="imgs/a02_MG_3104.jpg" width="300px">
                                                        <br>
                                                        <br>
                                                        <img src="imgs/b02_MG_8176.jpg" width="300px">
                                                        <br>
                                                        <br>
                                                        <img src="imgs/c02_MG_8386.jpg" width="300px">
                                                        <br>
                                                        <br>

                                                        <div class="custom-control custom-radio">
                                                            <input readonly='' type="radio" id="customRadio2" name="coloracao"
                                                                   value="Coloração Natural"
                                                                   class="custom-control-input" <?php if ($vetor_consulta['coloracao'] == 'Coloração Natural') { ?> checked <?php } ?>>
                                                            <label class="custom-control-label" for="customRadio2">Coloração
                                                                Natural</label>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-4">
                                                        <img src="imgs/a03_MG_3104.jpg" width="300px">
                                                        <br>
                                                        <br>
                                                        <img src="imgs/b03_MG_8176.jpg" width="300px">
                                                        <br>
                                                        <br>
                                                        <img src="imgs/c03_MG_8386.jpg" width="300px">
                                                        <br>
                                                        <br>

                                                        <div class="custom-control custom-radio">
                                                            <input readonly='' type="radio" id="customRadio3" name="coloracao"
                                                                   value="Coloração mais saturada"
                                                                   class="custom-control-input" <?php if ($vetor_consulta['coloracao'] == 'Coloração mais saturada') { ?> checked <?php } ?>>
                                                            <label class="custom-control-label" for="customRadio3">Coloração
                                                                mais saturada</label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <br>

                                        </div>

                                        <?php if (mysqli_num_rows($sql_fotosladorosto) > 0) { ?>

                                            <div class="tab-pane" id="fotosladorosto" role="tabpanel">

                                                <br>
                                                <br>

                                                <br>
                                                <br>

                                                <div class="row">

                                                    <?php while ($vetor_ladorosto = mysqli_fetch_array($sql_fotosladorosto)) { ?>

                                                        <div class="col-md-2">

                                                            <div class="thumbnails grid">

                                                                <a class="image-popup-vertical-fit"
                                                                   href="../sistema/arquivos/<?php echo $vetor_ladorosto['foto']; ?>"><img
                                                                        src="../sistema/arquivos/<?php echo $vetor_ladorosto['foto']; ?>"
                                                                        alt=""></a>

                                                            </div>

                                                        </div>

                                                    <?php } ?>

                                                </div>

                                            </div>

                                        <?php } ?>

                                        <?php if (mysqli_num_rows($sql_fotospreferidas) > 0) { ?>

                                            <div class="tab-pane" id="fotospreferidas" role="tabpanel">

                                                <br>
                                                <br>

                                                <div class="row">

                                                    <?php while ($vetor_escolhas = mysqli_fetch_array($sql_fotospreferidas)) { ?>

                                                        <div class="col-md-2">

                                                            <div class="thumbnails grid">

                                                                <a class="image-popup-vertical-fit"
                                                                   href="../sistema/arquivos/<?php echo $vetor_escolhas['foto']; ?>"><img
                                                                        src="../sistema/arquivos/<?php echo $vetor_escolhas['foto']; ?>"
                                                                        alt=""></a>

                                                            </div>

                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>

                                        <?php } ?>

                                        <?php if (mysqli_num_rows($sql_referenciasfotograficas) > 0) { ?>

                                            <div class="tab-pane" id="referencias" role="tabpanel">

                                                <br>
                                                <br>

                                                <?php

                                                while ($vetor_referenciasfotograficas = mysqli_fetch_array($sql_referenciasfotograficas)) {

                                                    $sql_evento_ref = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_referenciasfotograficas[id_evento]'");
                                                    $vetor_evento_ref = mysqli_fetch_array($sql_evento_ref);

                                                    ?>

                                                    <h4 class="card-title"><?php echo $vetor_evento_ref['nome']; ?></h4>

                                                    <div class="row">

                                                        <?php

                                                        $sql_fotos_evento = mysqli_query($con, "select * from referenciasfotograficas_fotos where id_referencia = '$vetor_referenciasfotograficas[id_referencia]' order by id_fotos ASC");

                                                        while ($vetor_fotos_evento = mysqli_fetch_array($sql_fotos_evento)) {

                                                            ?>

                                                            <div class="col-md-2">

                                                                <div class="thumbnails grid">

                                                                    <a class="image-popup-vertical-fit"
                                                                       href="../sistema/arquivos/<?php echo $vetor_fotos_evento['foto']; ?>"><img
                                                                            src="../sistema/arquivos/<?php echo $vetor_fotos_evento['foto']; ?>"
                                                                            alt=""></a>

                                                                </div>

                                                            </div>
                                                        <?php } ?>

                                                    </div>

                                                    <br>
                                                    <br>

                                                <?php } ?>

                                            </div>

                                        <?php } ?>

                                    </div>

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
    <?php
} ?>