<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id_formando'] == null || $_SESSION['id_formando'] == '') {
	echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";
}else {
	$id = $_GET['id'];
	$vetor_venda = mysqli_fetch_array(mysqli_query($con, "select * from vendas where id_venda = '$id'"));
	$sql_itens_venda = mysqli_query($con, "select * from itens_venda_individual where id_venda = '$id'");
	$vetor_formando = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$vetor_venda[id_formando]'"));
	$primeironome = explode(' ', rtrim($vetor_formando['nome']));
	$primeironomefinal = $primeironome[0];
	$nomele = (count($primeironome));
	if ($nomele > 1) {
		$firstName = $primeironome[0];
		$lastName = $primeironome[$nomele - 1];
		$espaco = ' ';
	}else {
		$firstName = $primeironome[0];
		$lastName = '';
		$espaco = '';
	}
	$telefone = preg_replace("/[^0-9]/", "", $vetor_formando['telefone']);
	$vetor_forma = mysqli_fetch_array(mysqli_query($con, "select * from formaspag where id_forma = '$vetor_venda[formapag]'"));
	$vetor_pacotes = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_itens_album where id_item = '$vetor_venda[id_pacote]' order by id_item ASC"));
	$vetor_banco = mysqli_fetch_array(mysqli_query($con, "select * from banco where id_banco = '1'"));
	if ($vetor_banco['ambiente'] == 1) {
		$clienteID = $vetor_banco['clientIdhomologacao'];
		$clienteSecret = $vetor_banco['clientSecrethomologacao'];
		$sellerid = $vetor_banco['selleridhomologacao'];
		$urlbase = $vetor_banco['urlhomologacao'];
		$urlchekout = $vetor_banco['urlchekouthomo'];
	}
	if ($vetor_banco['ambiente'] == 2) {
		$clienteID = $vetor_banco['clientId'];
		$clienteSecret = $vetor_banco['clientSecret'];
		$sellerid = $vetor_banco['sellerid'];
		$urlbase = $vetor_banco['urlproducao'];
		$urlchekout = $vetor_banco['urlchekout'];
	}
	$chaves = $clienteID.':'.$clienteSecret;
	$valorbase64 = base64_encode($chaves);
	$url = $urlbase.'/auth/oauth/v2/token';
	$request_body = 'scope=oob&grant_type=client_credentials';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Accept: application/json, text/plain, */*',
			'Content-Type: application/x-www-form-urlencoded',
			'Authorization: Basic '.$valorbase64.''
		)
	);
	$result = curl_exec($ch);
	curl_close($ch);
	$obj = json_decode($result);
	$chaveretorno = $obj->token_type.' '.$obj->access_token;
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
        <script async src="<?php echo $urlchekout; ?>/loader.js"
                data-getnet-sellerid="<?php echo $sellerid; ?>"
                data-getnet-token="<?php echo $chaveretorno; ?>"
                data-getnet-amount="<?php echo $vetor_venda['valorvenda']; ?>"
                data-getnet-customerid="<?php echo $id; ?>"
                data-getnet-orderid="<?php echo $id; ?>"
                data-getnet-button-class="classe-botao-abrir-checkout"
                data-getnet-installments="<?php echo $vetor_venda['qtdparcelas']; ?>"
                data-getnet-customer-first-name="<?php echo $primeironomefinal; ?>"
                data-getnet-customer-last-name="<?php echo $lastName; ?>"
                data-getnet-customer-document-type="CPF"
                data-getnet-customer-document-number="<?php echo $vetor_formando['cpf']; ?>"
                data-getnet-customer-email="<?php echo $vetor_formando['email']; ?>"
                data-getnet-customer-phone-number="<?php echo $telefone; ?>"
                data-getnet-customer-address-street="<?php echo $vetor_formando['endereco']; ?>"
                data-getnet-customer-address-street-number="<?php echo $vetor_formando['numero']; ?>"
                data-getnet-customer-address-complementary=""
                data-getnet-customer-address-neighborhood="<?php echo $vetor_formando['bairro']; ?>"
                data-getnet-customer-address-city="<?php echo $vetor_formando['cidade']; ?>"
                data-getnet-customer-address-state="<?php echo $vetor_formando['estado']; ?>"
                data-getnet-customer-address-zipcode="<?php echo $vetor_formando['cep']; ?>"
                data-getnet-customer-country="Brasil"
                data-getnet-shipping-address='[{ "first_name": "<?php echo $primeironomefinal; ?>", "name": "<?php echo $vetor_formando['nome']; ?>", "email": "<?php echo $vetor_formando['email']; ?>", "phone_number": "", "address": { "street": "<?php echo $vetor_formando['endereco']; ?>", "complement": "", "number": "<?php echo $vetor_formando['numero']; ?>", "district": "<?php echo $vetor_formando['bairro']; ?>", "city": "<?php echo $vetor_formando['cidade']; ?>", "state": "<?php echo $vetor_formando['estado']; ?>", "country": "Brasil", "postal_code": "12345678"}}]'
                data-getnet-items='[{"name": "","description": "", "value": 0, "quantity": 0,"sku": ""}]'
                data-getnet-url-callback=""
                data-getnet-payment-methods-disabled='["boleto"]'
                data-getnet-pre-authorization-credit="">
        </script>
        <!-- data-getnet-url-callback="https://studiomfotografia.com.br/51fs-retorno-credito.php" -->
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
                                        src="../sistema/arquivos/<?php echo $vetor_formando['imagem']; ?>" alt="user"
                                        class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img
                                                src="../sistema/arquivos/<?php echo $vetor_formando['imagem']; ?>"
                                                alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $vetor_formando['nome']; ?></h4>
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
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Ver Venda</li>
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
                                <div class="row">
                                    <div class="col-6">

                                    
                                        <h4 class="card-title">Dados de Sua compra:</h4>
                                        <?php if($vetor_venda['tipo'] == '1'){ ?>
                                        <table width="100%">
                                            <tr>
                                                <td><strong>Valor Compra:</strong>
                                                    R$<?php echo $num1 = number_format($vetor_venda['valorvenda'], 2, ',', '.'); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Data
                                                        Compra:</strong> <?php echo date('d/m/Y', strtotime($vetor_venda['data'])); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Qtd de Parcelas:</strong> <?php echo $vetor_venda['qtdparcelas']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Valor da Parcelas:</strong>
                                                    R$<?php $valorparcela = $vetor_venda['valorvenda'] / $vetor_venda['qtdparcelas'];
                                                                echo $num1 = number_format($valorparcela, 2, ',', '.'); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Forma de Pagamento:</strong> <?php echo $vetor_forma['nome']; ?>
                                                </td>
                                            </tr>
                                        </table>

                                        <br>
                                        <br>

                                        <h3>Produtos</h3>

                                        <table width="100%">
                                            <tr bgcolor="#e8e8e8">
                                                <td width="33%">Produto</td>
                                                <td width="33%">Quantidade</td>
                                                <td width="34%">Sub-Total</td>
                                            </tr>
                
                                                <?php
                                                $totalizador = 0;
                                                while ($vetor_itens = mysqli_fetch_array($sql_itens_venda)) {
                                                    if ($vetor_venda['id_pacote'] == null) {
                                                        $sql_produto = mysqli_query($con, "select * from produtos_turma_item where id_item = '$vetor_itens[id_item]'");
                                                        $vetor_produto = mysqli_fetch_array($sql_produto);
                                                    }else {
                                                        $sql_produto = mysqli_query($con, "select * from pacotes_itens where status = '1' and id_item = '$vetor_itens[id_item]'");
                                                        $vetor_produto = mysqli_fetch_array($sql_produto);
                                                    }
                                                    $sql_produto_nome = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_produto[id_tipo]'");
                                                    $vetor_produto_nome = mysqli_fetch_array($sql_produto_nome);
                                                    $subtotal = $vetor_itens['valor'] * $vetor_itens['qtd'];
                                                    $num = number_format($subtotal, 2, ',', '.');
                                                    ?>

                                            <tr>
                                                <td width="33%"><?php echo $vetor_produto_nome['nome']; ?></td>
                                                <td width="33%"><?php echo $vetor_itens['qtd']; ?></td>
                                                <td width="34%">R$<?php echo $num; ?></td>
                                            </tr>
                    
                                                    <?php
                                                    $totalizador += $subtotal;
                                                }
                                                $num1 = number_format($totalizador, 2, ',', '.');
                                                ?>

                                            <tr>
                                                <td width="33%"></td>
                                                <td width="33%"></td>
                                                <td width="34%">Total: R$<?php echo $num1; ?></td>
                                            </tr>
                                        </table>
                                        <?php }else{ ?>
                                            <table width="100%">
                                                <tr>
                                                    <td><strong>Produto:</strong> <?php echo $vetor_pacotes['titulo']; ?></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Valor Compra:</strong>
                                                        R$<?php echo $num1 = number_format($vetor_venda['valorvenda'], 2, ',', '.'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Data
                                                            Compra:</strong> <?php echo date('d/m/Y', strtotime($vetor_venda['data'])); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Qtd de Parcelas:</strong> <?php echo $vetor_venda['qtdparcelas']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Valor da Parcelas:</strong>
                                                        R$<?php $valorparcela = $vetor_venda['valorvenda'] / $vetor_venda['qtdparcelas'];
                                                                    echo $num1 = number_format($valorparcela, 2, ',', '.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Forma de Pagamento: </strong> <?php echo $vetor_forma['nome']; ?>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        <?php } ?>
                                        <br>
                                        <br>

                                        <button type="button" class="btn btn-success classe-botao-abrir-checkout"
                                                style="float: left;">Efetuar Pagamento
                                        </button>
                                    </div>
                                
                                    <div class="col-6" >
                                        <h4 class="card-title">Imprimir Contrato</h4>
                                        
                                        <button type="button" class="btn btn-success " onclick="location.href='mensagemfinalizacaoalbum.php?id=<?= $id?>'"
                                                style="position: absolute; bottom: 0; ">Imprimir Contrato
                                        </button>
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