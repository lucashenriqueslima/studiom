<?php

include "../includes/conexao.php";

session_start();
if (isset($_GET['id_item'])) {
    $id_item = $_GET['id_item'];
    $max_parcela = 0;
    $pagamento_sql = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '{$id_item}' and id_forma = '{$_GET['tipo']}'");
    $forma_pagamento = mysqli_fetch_array($pagamento_sql);
    switch ($_GET['tipo']) {
        case '3':
            $max_parcela = ($forma_pagamento['qtdparcelas'] == null||(int)$forma_pagamento['qtdparcelas'] < 1?12:$forma_pagamento['qtdparcelas']);
            break;
        case '2':
            $max_parcela = ($forma_pagamento['qtdparcelas'] == null||(int)$forma_pagamento['qtdparcelas'] < 1?500:$forma_pagamento['qtdparcelas']);
            break;
        case '8':
            $max_parcela = ($forma_pagamento['qtdparcelas'] == null||(int)$forma_pagamento['qtdparcelas'] < 1?6:$forma_pagamento['qtdparcelas']);
            break;
        case '18':
            $max_parcela = ($forma_pagamento['qtdparcelas'] == null||(int)$forma_pagamento['qtdparcelas'] < 1?1:$forma_pagamento['qtdparcelas']);
            break;
        case '':
            echo "<option value=\"\" selected>Selecione uma Forma de Pagamento</option>";
            die();
    }

    $pacote_itens = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_itens_album where id_item = '{$id_item}'"));
    $pacote = mysqli_fetch_array(mysqli_query($con, "select * from pacotes where id_pacote = '{$pacote_itens['id_pacote']}'"));
    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));
    if ($vetor_cadastro['comissao'] == 2) {
        $valor_venda = $pacote_itens['valorcomissao'];
    } else {
        $valor_venda = $pacote_itens['valor'];
    }
    if($_GET['tipo'] == '22'){
        echo "<option value='1'>(1x) R$" . $valor_venda . "</option>";
        die();
    }
    if ($_GET['tipo'] != '18') {
        if ($pacote_itens['pacote_especial'] != 2) {
            if($pacote_itens['pacote_especial'] == 3){
                $data_final_parcelamento = strtotime($pacote_itens['data_limite']);
                $dataatual = strtotime(date('Y-m',strtotime('+1 month',strtotime(date('Y-m')))) . '-' . $_GET['dia']);
                $calcula_parcelas = (int)floor(($data_final_parcelamento - $dataatual)/(60 * 60 * 24 * 30));
                if($calcula_parcelas >= $pacote_itens['qtdparcelas']){
                    $parcelas = $pacote_itens['qtdparcelas'];
                }else{
                    $parcelas = $calcula_parcelas + 1;
                }
            }else{
                switch ($_GET['tipo']) {
                    case '3':
                        $max_parcela = ($forma_pagamento['qtdparcelas'] == null||(int)$forma_pagamento['qtdparcelas'] < 1?$pacote_itens['qtdparcelas']:$forma_pagamento['qtdparcelas']);
                        break;
                    case '2':
                        $max_parcela = ($forma_pagamento['qtdparcelas'] == null||(int)$forma_pagamento['qtdparcelas'] < 1?$pacote_itens['qtdparcelas']:$forma_pagamento['qtdparcelas']);
                        break;
                    case '8':
                        $max_parcela = ($forma_pagamento['qtdparcelas'] == null||(int)$forma_pagamento['qtdparcelas'] < 1?$pacote_itens['qtdparcelas']:$forma_pagamento['qtdparcelas']);
                        break;
                    case '18':
                        $max_parcela = ($forma_pagamento['qtdparcelas'] == null||(int)$forma_pagamento['qtdparcelas'] < 1?$pacote_itens['qtdparcelas']:$forma_pagamento['qtdparcelas']);
                        break;
                    case '':
                        echo "<option value=\"\" selected>Selecione uma Forma de Pagamento</option>";
                        die();
                }
                $parcelas = $max_parcela;
            }
        } else {
            $data_final_parcelamento = date('Y-m', strtotime('+6 months', strtotime(substr($pacote['dataentrega'], 0, 7))));

            $dataatual = date('Y-m', strtotime('+1 month')); // Montando a data do 1 boletos
            $calcula_parcelas = strtotime($data_final_parcelamento) - strtotime($dataatual);
            $parcelas = (int)floor($calcula_parcelas / (60 * 60 * 24 * 30));
            if ($parcelas >= $max_parcela) {
                $parcelas = $max_parcela;
            } else {
                $parcelas += 1;
            }
        }
        $i = 1;

        echo "<option value='' selected=''>Selecione um parcelamento</option>";
        while ($parcelas >= $i) {
            $valor_parcelado = number_format(($valor_venda / $i), 2, ',', '.');
            if (($valor_venda / $i) < 50) {
                $i++;
            } else {
                echo "<option value='" . $i . "'>" . "(" . $i . "x) R$" . $valor_parcelado . "</option>";
                $i++;
            }
        }
    } else {
        $datadesconto = $pacote['dataabertura'];
        $dataatual = date('Y-m-d');
        $calcula_dias = strtotime($dataatual) - strtotime($datadesconto);
        $diferenca_dias = (int)floor($calcula_dias / (60 * 60 * 24));
        if ($diferenca_dias <= 30 && ($pacote_itens['pacote_especial'] == 2 || $pacote_itens['pacote_especial'] == 1)) {
            $valor_venda = $valor_venda - ($valor_venda * $pacote['desconto'] / 100);
        }
        echo "<option value='1'>(1x) R$" . number_format($valor_venda, 2, ',', '.') . "</option>";
    }
    die();
}
if ($_SESSION['id_formando'] == NULL || $_SESSION['id_formando'] == '') {

    echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";

} else {
    $id_pacote = $_GET['id_pacote'];
    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$_SESSION[id_formando]'"));
    $pacote_itens = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_itens_album where id_item = '$id_pacote'"));
    $pagamentos = 1;
    if($pacote_itens['pacote_especial'] == 3){
        $data_final_parcelamento = strtotime($pacote_itens['data_limite']);
        $dataatual = strtotime(date('Y-m-d',strtotime('+1 month',strtotime(date('Y-m-d')))));
        $pagamentos = (int)floor(($data_final_parcelamento - $dataatual)/(60*60*24));
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

        <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#diavencimento').change(function () {
                    $('#qtdparcelas').load('compra_album_pagamento.php?id_item=<?php echo $id_pacote; ?>' + '&tipo=' + $('#tipobusca').val() + '&dia=' + $('#diavencimento').val());
                });
                $('#tipobusca').change(function () {
                    if($('#tipobusca').val() == '22' || $('#tipobusca').val() == '18'){
                        $('#qtdparcelas').load('compra_album_pagamento.php?id_item=<?php echo $id_pacote; ?>' + '&tipo=' + $('#tipobusca').val());
                        $('#diavencimento').removeAttr('required');
                        $('#diavencimentorow').attr('hidden','hidden');
                    }else if($('#tipobusca').val() == '3'){
                        $('#diavencimento').removeAttr('required');
                        $('#diavencimentorow').attr('hidden','hidden');
                        $('#diavencimento').val('10');
                        $('#diavencimento').trigger('change');
                    }else{
                        $('#diavencimento').attr('required');
                        $('#diavencimentorow').removeAttr('hidden','hidden');
                        $('#qtdparcelas').html('<option value="" selected>Selecione uma Data de Vencimento</option>');
                        $('#diavencimento').val('');
                    }
                });
            });
        </script>
        <style>
            .tooltip-inner {
                background-color: #4a148c !important;
                box-shadow: 0px 0px 4px black !important;
                padding: 10px !important;
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
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Minhas Compras</h4>

                                <form action="compra_finaliza_fotografia.php" method="post"
                                      enctype="multipart/form-data">
                                    <input type="text" name="id_item" value="<?php echo $id_pacote; ?>" hidden>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Forma de
                                                    Pagamento</label>
                                                <select name="formapag" id="tipobusca" class="form-control" onchange="javascript:mostraAlerta(this);" 
                                                    data-toggle="tooltip"  title='O pagamento à vista consiste em uma única parcela a ser paga em até 02 dias úteis a partir da compra. Antes de finalizar a compra, certifique-se de que escolheu a opção de pagamento correta.'
                                                    required="">
                                                    <option value="" selected="">Selecione...</option>
                                                    <?php
                                                    //if($pagamentos < 1){
                                                      //  echo "<option value='18'>Boleto Bancário à vista</option>";
                                                        //echo "<option value='22'>Boleto Bancário Data Limite de Pagamento</option>";
                                                    //}else{
                                                        $sql_formas = mysqli_query($con, "select * from formaspag_pacote where id_pacote = '$id_pacote'");

                                                        while ($vetor_formas = mysqli_fetch_array($sql_formas)) {

                                                            $sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_formas[id_forma]'");
                                                            $vetor_forma = mysqli_fetch_array($sql_forma);

                                                            ?>
                                                            <option value="<?php echo $vetor_forma['id_forma']; ?>"><?php echo $vetor_forma['nome']; ?></option>
                                                            <?php
                                                        }
                                                    //}
                                                    ?>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row" id="diavencimentorow">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Datas de Vencimento</label>
                                                <select name="diavencimento" id="diavencimento"
                                                        class="form-control" required="">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Quantidade de Parcelas</label>
                                                <select name="qtdparcelas" id="qtdparcelas"
                                                        class="form-control" required="">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="    float: left;">Avançar
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
    <script>
        $('[data-toggle="tooltip"]').tooltip({
                placement: "right",
                trigger: "focus"
            });
        $('[data-toggle="tooltip"]').tooltip('disable');
        $('[data-toggle="tooltip"]').tooltip('hide');
        function mostraAlerta(elemento){
            if (elemento.value == 18) {
                
                $('[data-toggle="tooltip"]').tooltip('enable');
                
                $('[data-toggle="tooltip"]').tooltip('show');
                
            }else{
                $('[data-toggle="tooltip"]').tooltip('disable');
                
                
            }        
        }
        

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
    </body>

    </html>
<?php } ?>