<?php
include "../includes/conexao.php";
if (isset($_GET['id_produto'])) {
    $id_produto = $_GET['id_produto'];
    $valor_venda = $_GET['valor_venda'];
    $forma_pag = $_GET['forma_pagamento'];
    $produto_turma = mysqli_fetch_array(mysqli_query($con, "select * from produtos_turma where id_produto = '{$id_produto}'"));
    $qtdparcelas_credito = mysqli_fetch_array(mysqli_query($con, "select * from formaspag_produto where id_forma = '{$forma_pag}' and id_produto = '{$id_produto}'"));
    if($forma_pag == '3'){
        $vencimento = '10';
    }else{
        $vencimento = $_GET['vencimento'];
    }
    //$data_final_parcelamento = date('Y-m-d', strtotime('-15 days', strtotime($produto_turma['dataentrega'])));
    $data_final_parcelamento = $produto_turma['dataencerramento'];
    if ($produto_turma['mesinicio'] == '' || $produto_turma['mesinicio'] == null) {
       $dataatual = date('Y-m', strtotime('+1 month')).'-'.$vencimento; // Montando a data do 1 boleto
    }else {
        $dataatual = $produto_turma['mesinicio'].'-'.$vencimento; // Montando a data do 1 boleto
    }
    
    //condição qtd parcelas por cartão
    if ($forma_pag == '3') {
        $parcelas = $qtdparcelas_credito['qtdparcelas'];
    }else {
        $calcula_parcelas = strtotime($data_final_parcelamento) - strtotime($dataatual);
        $parcelas = (int)floor($calcula_parcelas / (60 * 60 * 24 * 30));
    }
    
    if ($parcelas >= 6 && (int)$qtdparcelas_credito['qtdparcelas'] == 0) {
        $parcelas = 6;
    }elseif((int)$qtdparcelas_credito['qtdparcelas'] > 0 && $parcelas >= (int)$qtdparcelas_credito['qtdparcelas']){
        $parcelas = (int)$qtdparcelas_credito['qtdparcelas'];
    }else {
        $parcelas += 1;
    }
    $i = 1;
    echo "<option value='' selected=''>Selecione um parcelamento</option>";
    while ($parcelas >= $i) {
        $valor_parcelado = number_format(($valor_venda / $i), 2, ',', '.');
        if (($valor_venda / $i) < 50) {
            $i++;
        }else {
            echo "<option value='".$i."'>"."(".$i."x) R$".$valor_parcelado."</option>";
            $i++;
        }
    }
    die();
}
session_start();
if ($_SESSION['id_formando'] == null || $_SESSION['id_formando'] == '') {
    echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";
}else {
    if ((int)$_POST['valor_total'] < 50) {
        echo "<script language=\"JavaScript\">
alert('Não é possivel realizar uma compra de valores inferiores a R$ 50,00.');
history.back();
</script>";
    }
    // Pegando itens adicionados anteriormente
    $produtos = array();
    $valor_total = 0;
    $i = 0;
    foreach ($_POST['id_item'] as $key) {
        array_push($produtos, [$_POST['id_item'][$i], $_POST['valor_item'][$i], $_POST['qtd'][$i]]);
        $valor_total += $_POST['qtd'][$i] * $_POST['valor_item'][$i];
        $i++;
    }
    $id_p = $_GET['id_p'];
    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$_SESSION[id_formando]'"));
    $pacote_turma = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_turma where id_pacote = '$id_p'"));
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

        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#forma_pagamento").change(function () {
                    switch ($('#forma_pagamento').val()) {
                        case '':
                            $('#parcelamento_antecipado').attr('hidden', 'hidden');
                            $('#vencimento').attr('hidden', 'hidden');
                            //Limpa
                            break;
                        case '2':
                            $('#parcelamento_antecipado').removeAttr('hidden');
                            $('#vencimento').removeAttr('hidden');
                            $('#parcelamento_antecipado').val('');
                            $('#dia_vencimento').trigger('change');
                            $('#dia_vencimento').attr('required','required');
                            //Boleto Bancário Antecipado
                            break;
                        case '8':
                            $('#parcelamento_antecipado').attr('hidden', 'hidden');
                            $('#vencimento').removeAttr('hidden');
                            //Boleto Bancário Pós formatura
                            break;
                        case '18':
                            $('#parcelamento_antecipado').attr('hidden', 'hidden');
                            $('#vencimento').attr('hidden', 'hidden');
                            $('#dia_vencimento').val('1');
                            //Boleto Bancário à vista
                            break;
                        case '3':
                            $('#dia_vencimento').val('10');
                            $('#parcelamento_antecipado').removeAttr('hidden');
                            $('#vencimento').attr('hidden', 'hidden');
                            $('#dia_vencimento').trigger('change');
                            //Cartão de Crédito
                            break;
                    }
                });
                $('#vencimento').change(function () {
                    $('#parcelas_antecipado').load('compra_etapa2_pacote.php?id_produto=<?php echo $pacote_turma['id_produto']; ?>&valor_venda=<?php echo (int)floor($valor_total); ?>&vencimento=' + $('#dia_vencimento').val() + '&forma_pagamento=' + $('#forma_pagamento').val());
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
                                
                                <form action="compra_finaliza.php?id_p=<?php echo $id_p; ?>"
                                      method="post"
                                      enctype="multipart/form-data">

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Forma de
                                                    Pagamento</label>
                                                <select name="formapag" id="forma_pagamento" class="form-control" onchange="javascript:mostraAlerta(this);" 
                                                     data-toggle="tooltip"  title='O pagamento à vista consiste em uma única parcela a ser paga em até 01 dia útil a partir da compra. Antes de finalizar a compra, certifique-se de que escolheu a opção de pagamento correta.'
                                                        required="">
                                                    <option value="" selected="">Selecione...</option>
                                                    <?php
                                                    $sql_formas = mysqli_query($con, "select * from formaspag_produto where id_produto = '$pacote_turma[id_produto]'");
                                                    while ($vetor_formas = mysqli_fetch_array($sql_formas)) {
                                                        $sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_formas[id_forma]'");
                                                        $vetor_forma = mysqli_fetch_array($sql_forma);
                                                        ?>
                                                        <option value="<?php echo $vetor_forma['id_forma']; ?>"><?php echo $vetor_forma['nome']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row" id="vencimento" hidden>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Datas de Vencimento</label>

                                                <select name="vencimento" id="dia_vencimento"
                                                        class="form-control">
                                                    <option value="" selected="">Selecione...</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="parcelamento_antecipado" hidden>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Quantidade de Parcelas</label>

                                                <select name="parcelamento_antecipado" id="parcelas_antecipado"
                                                        class="form-control">
                                                    <option value="">Escolha uma Data de Vencimento</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    foreach ($_POST['id_item'] as $key) {
                                        echo "<input type='hidden' name='id_item[]' value='".$key."'>";
                                    }
                                    foreach ($_POST['valor_item'] as $key) {
                                        echo "<input type='hidden' name='valor_item[]' value='".$key."'>";
                                    }
                                    foreach ($_POST['qtd'] as $key) {
                                        echo "<input type='hidden' name='qtd[]' value='".$key."'>";
                                    }
                                    ?>

                                    <button type="submit" class="btn btn-primary" style="    float: left;">Avançar
                                    </button>

                                </form>
                            </div>
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