<?php

include "../includes/conexao.php";

session_start();

if ($_SESSION['id_formando'] == NULL) {

    echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";

} else {

    $sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);

    $id = $_GET['id'];

    $result_pre = mysqli_query($con, "SELECT * FROM eventosformando WHERE id_evento_turma = '$id' and id_formando = '$_SESSION[id_formando]'");
    $row_pre = mysqli_fetch_array($result_pre);

    $sql_qtd = mysqli_query($con, "select * from turmas_escolha_formandos where id_evento = '$row_pre[id_evento_turma]' and id_formando = '$_SESSION[id_formando]'");
    $vetor_qtd = mysqli_fetch_array($sql_qtd);

    $caminho = "../sistema/arquivos/formandos/$row_pre[pasta]/";
    $img = glob($caminho . "*.{JPG,jpg,png,gif}", GLOB_BRACE);
    $contador = count($img);

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

        <link href="../layout/assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">

        <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../layout/dist/css/style.min.css" rel="stylesheet">

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function () {

                function limpa_formulário_cep() {
                    // Limpa valores do formulário de cep.
                    $("#rua").val("");
                    $("#bairro").val("");
                    $("#cidade").val("");
                    $("#uf").val("");
                    $("#ibge").val("");
                }

                //Quando o campo cep perde o foco.
                $("#cep").blur(function () {

                    //Nova variável "cep" somente com dígitos.
                    var cep = $(this).val().replace(/\D/g, '');

                    //Verifica se campo cep possui valor informado.
                    if (cep != "") {

                        //Expressão regular para validar o CEP.
                        var validacep = /^[0-9]{8}$/;

                        //Valida o formato do CEP.
                        if (validacep.test(cep)) {

                            //Preenche os campos com "..." enquanto consulta webservice.
                            $("#rua").val("...")
                            $("#bairro").val("...")
                            $("#cidade").val("...")
                            $("#uf").val("...")
                            $("#ibge").val("...")

                            //Consulta o webservice viacep.com.br/
                            $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                                if (!("erro" in dados)) {
                                    //Atualiza os campos com os valores da consulta.
                                    $("#rua").val(dados.logradouro);
                                    $("#bairro").val(dados.bairro);
                                    $("#cidade").val(dados.localidade);
                                    $("#uf").val(dados.uf);
                                    $("#ibge").val(dados.ibge);
                                } //end if.
                                else {
                                    //CEP pesquisado não foi encontrado.
                                    limpa_formulário_cep();
                                    alert("CEP não encontrado.");
                                }
                            });
                        } //end if.
                        else {
                            //cep é inválido.
                            limpa_formulário_cep();
                            alert("Formato de CEP inválido.");
                        }
                    } //end if.
                    else {
                        //cep sem valor, limpa formulário.
                        limpa_formulário_cep();
                    }
                });
            });

        </script>
        <script type="text/javascript">
            var CheckMaximo = <?php echo $vetor_qtd['qtd']; ?>;


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
                height: 380px;
                margin: 2px;
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
                        <h4 class="page-title">Escolha de Fotos - Top Fotos</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page"><?php if ($row_pre['tipo'] == 1) {
                                            echo "Pré-Eventos";
                                        }
                                        if ($row_pre['tipo'] == 2) {
                                            echo "Eventos";
                                        } ?></li>
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
                                <h4 class="card-title"><?php echo $row_pre['titulo']; ?></h4>

                                <?php

                                $sql_consulta = mysqli_query($con, "select * from escolha_fotos_tratamento where id_evento = '$id' and id_formando = '$vetor_cadastro[id_formando]' and tipo IN ('1', '2')");

                                if (mysqli_num_rows($sql_consulta) > 0) {

                                    $sql_escolhidas = mysqli_query($con, "SELECT * FROM escolha_fotos_tratamento WHERE id_formando = '$vetor_cadastro[id_formando]' and id_evento = '$id' and tipo IN ('1', '2')");

                                    ?>

                                    <div class="alert alert-info" role="alert">
                                        Olá, <?php echo $_SESSION['nome']; ?>, suas fotos escolhidas já foram enviadas
                                        para o tratamento. Para ter acesso às imagens tratadas, você deverá acessar o
                                        menu "Top Fotos".
                                    </div>

                                    <br>

                                    <div class="row">

                                        <?php while ($vetor_escolhidas = mysqli_fetch_array($sql_escolhidas)) { ?>

                                            <div class="col-md-3">

                                                <div class="thumbnails grid">

                                                    <a class="image-popup-vertical-fit"
                                                       href="<?php echo $vetor_escolhidas['foto']; ?>"><img
                                                                src="<?php echo $vetor_escolhidas['foto']; ?>"
                                                                alt=""></a>

                                                </div>

                                            </div>

                                        <?php } ?>

                                    </div>

                                <?php } else { ?>

                                    <div class="alert alert-danger" role="alert">
                                        Para este evento você poderá escolher “<?php echo $vetor_qtd['qtd']; ?>”
                                        fotografias para receber um tratamento top.
                                    </div>

                                    <br>

                                    <div class="row">

                                        <?php

                                        $i = 0;

                                        foreach ($img as $img) {

                                            $imagem = explode("/", $img);
                                            $imagemfinal = $imagem[5];

                                            $nomeimagem = explode(".", $imagemfinal);

                                            ?>

                                            <script type="text/javascript">//<![CDATA[

                                                $(window).load(function () {


                                                    $('input[name="bn"]').change(function () {
                                                        if ($(this).is(':checked') && $(this).val() == '<?php echo $img; ?>') {
                                                            $('#myModal-<?php echo $i; ?>').modal('show');
                                                        }
                                                    });

                                                });

                                                //]]></script>

                                            <div class="col-md-3">

                                                <div class="thumbnails grid">

                                                    <a class="image-popup-vertical-fit" href="<?php echo $img; ?>"><img
                                                                src="<?php echo $img; ?>" alt=""></a>

                                                </div>

                                                <p>
                                                <div align="center"><h4 class="mb-0"><input type="radio" id="imagem"
                                                                                            name="bn"
                                                                                            value="<?php echo $img; ?>">
                                                        Selecionar esta imagem!!!</h4></div>
                                                </p>

                                            </div>

                                            <div class="modal fade" id="myModal-<?php echo $i; ?>" tabindex="-1"
                                                 role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">Salvar Imagem</h4>
                                                        </div>
                                                        <div class="modal-body" style="text-align:center;">
                                                            <form action="recebe_enviarescolhafotoseventos.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>"
                                                                  name="form1" method="post"
                                                                  enctype="multipart/form-data">
                                                                <p>Você possui alguma recomendação para o tratamento
                                                                    desta imagem? Cor, Brilho, Enquadramento ou algum
                                                                    ajuste específico? Esteja à vontade para nos dizer
                                                                    como deseja o tratamento desta fotografia.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"
                                                                    style="    float: left;">Salvar
                                                            </button>
                                                            </form>
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php $i++;
                                        } ?>


                                    </div>

                                    <br>


                                <?php } ?>

                                <br>
                                <br>
                                <br>

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

    <script src="../layout/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="../layout/assets/libs/magnific-popup/meg.init.js"></script>
    </body>

    </html>
<?php } ?>