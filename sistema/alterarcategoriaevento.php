<?php

include "../includes/conexao.php";

session_start();

if ($_SESSION['id'] == NULL) {

    echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";

} else {

    $id = $_GET['id'];
    $vetor = mysqli_fetch_array(mysqli_query($con, "select * from categoriaevento where id_categoria = '$id'"));

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
        <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">
        <script src="../layout/dist/js/lightbox-plus-jquery.min.js"></script>
        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        <script type="text/javascript">
            function removeImagem(id) {
                $.post('recebe_alterarcategoriaevento.php?id=' + id + '&remover=sim', function () {
                    window.location.reload(true);
                });

            }
            function duplicarCampos() {
                var clone = document.getElementById('origem').cloneNode(true);
                var destino = document.getElementById('destino');
                clone.removeAttribute('hidden');
                destino.appendChild(clone);
                var camposClonados = clone.getElementsByTagName('input');
                for (i = 0; i < camposClonados.length; i++) {
                    camposClonados[i].value = '';
                }
            }

            function removerCampos(id) {
                var node1 = document.getElementById('destino');
                node1.removeChild(node1.childNodes[0]);
            }
        </script>
        <style type="text/css">

            .thumbnail {
                position: relative;
                width: 100px;
                height: 100px;
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
                       aria-controls="navbarSupportedContent" aria-e    xpanded="false" aria-label="Toggle navigation"><i
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
                                    <div class=""><img src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>"
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
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Cadastros</a></li>
                                    <li class="breadcrumb-item">Categorias de Eventos</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Alterar Evento</li>
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
                                <div id="origem" hidden>
                                    <div class="row">
                                        <input type="text" name="id_imagem[]" value="" hidden>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Imagem</label>
                                                <input type="file" class="form-control"
                                                       name="imagem[]"
                                                       accept="image/*">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold"
                                                       for="exampleInput">Posição</label>
                                                <input type="number" class="form-control"
                                                       name="posicao[]">
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <form action="recebe_alterarcategoriaevento.php?id=<?php echo $id; ?>" method="post"
                                      name="cliente" enctype="multipart/form-data" onSubmit="return verificarCPF()"
                                      id="formID">

                                    <div class="row">

                                        <div class="col-lg-3">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Nome</label>
                                                <input type="text" name="nome" value="<?php echo $vetor['nome']; ?>"
                                                       class="form-control" id="exampleInput"
                                                       placeholder="Digite o nome" required>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-3">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Sigla</label>
                                                <input type="text" name="sigla" value="<?php echo $vetor['sigla']; ?>"
                                                       class="form-control" id="exampleInput"
                                                       placeholder="Digite a Sigla" required>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-3">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Tipo de
                                                    evento</label>
                                                <select name="tipo" class="form-control" required="">
                                                    <option value="">Selecione...</option>
                                                    <option value="1" <?php if ($vetor['tipo'] == 1) { ?> selected <?php } ?>>
                                                        Pré-evento
                                                    </option>
                                                    <option value="2" <?php if ($vetor['tipo'] == 2) { ?> selected <?php } ?>>
                                                        Evento oficial antes da formatura
                                                    </option>
                                                    <option value="3" <?php if ($vetor['tipo'] == 3) { ?> selected <?php } ?>>
                                                        Evento Oficial
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-3">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Posição no Álbum</label>
                                                <input type="number" name="posicao_album" value="<?php echo $vetor['posicao']; ?>"
                                                       class="form-control"
                                                       placeholder="Digite a Posição" required>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <h5><strong>Imagens</strong></h5>
                                    <?php
                                    $lock = 0;
                                    $sql_imagem = mysqli_query($con, "select * from imagens_produtos where chave_imagem = '$vetor[chave_imagem]' and id_evento='$id' order by posicao ASC");
                                    $maximo = mysqli_num_rows($sql_imagem);
                                    while ($imagem = mysqli_fetch_array($sql_imagem)) {
                                        if ($lock == 0) {
                                            echo "<div class='row'>";
                                        }
                                        ?>
                                        <input type="text" name="id_imagem_existente[]"
                                               value="<?php echo $imagem['id_imagem']; ?>" hidden>
                                        <div class="col-lg-1">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Imagem</label>
                                                <div class="thumbnail">
                                                    <a class="example-image-link"
                                                       href="<?php echo $imagem['imagem']; ?>"
                                                       data-lightbox="example-set"><img alt=""
                                                                                        src="<?php echo $imagem['imagem']; ?>"/></a>
                                                </div>
                                            </fieldset>

                                        </div>
                                        <div class="col-lg-1">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold"
                                                       for="exampleInput">Posição</label>
                                                <input type="number" class="form-control"
                                                       name="posicao_existente[]"
                                                       value="<?php echo $imagem['posicao']; ?>">
                                            </fieldset>
                                            <button type="submit" class="btn btn-danger btn-block"
                                                    onclick="removeImagem(<?php echo $imagem['id_imagem']; ?>)"
                                                    style="margin-top: 30px;">Excluir Imagem
                                            </button>
                                        </div>
                                        <div class="col-lg-1"></div>
                                        <?php
                                        if ($lock == 3) {
                                            echo "</div>";
                                            $lock = 0;
                                        } else {
                                            $lock++;
                                        }
                                        $maximo--;
                                        if($maximo == 0 && $lock != 0){
                                            echo "</div>";
                                        }
                                    } ?>
                                    <div id="destino"></div>
                                    <br>
                                    <br>
                                    <input type="button" value="Adicionar" onclick="duplicarCampos();"
                                           class="btn btn-warning">
                                    <input type="button" value="Remover" onclick="removerCampos(this);"
                                           class="btn btn-danger">
                                    <br>
                                    <br>

                                    <button type="submit" class="btn btn-primary" style="    float: left;">Salvar
                                    </button>

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