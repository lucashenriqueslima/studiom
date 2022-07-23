<?php
include "../includes/conexao.php";
session_start();
if(isset($_POST['quantidade'])){
    $id_tipo = $_POST['id_tipo'];
    $id_pacote = $_POST['id_pacote'];
    $quantidade = $_POST['quantidade'];
	$item_pacote = mysqli_fetch_array(mysqli_query($con, "SELECT
	pi2.id_item, pi2.id_tipo, pi2.qtdminima, pi2.valorun
FROM
	pacotes_itens pi2,
	(SELECT
 		id_tipo AS TIPO_MIM,
		MAX(qtdminima) AS QTD_MAX
		FROM pacotes_itens
		WHERE qtdminima <= '{$quantidade}' and id_pacote = '{$id_pacote}' and status='1'
 		GROUP BY id_tipo) A
 WHERE
 	pi2.id_tipo = A.TIPO_MIM AND pi2.qtdminima = A.QTD_MAX and pi2.id_tipo = '{$id_tipo}' and id_pacote='{$id_pacote}' and pi2.status='1'"));
	$response = '{' . '"id_item":' . $item_pacote['id_item'] . ',"valorun":'. $item_pacote['valorun'] .  '}';
	
	echo $response;
    die();
}
if ($_SESSION['id_formando'] == null || $_SESSION['id_formando'] == '') {
	echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";
}else {
	$id = $_GET['id'];
	$vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));
	$sql_itens = mysqli_query($con, "SELECT
	pi2.id_item, pi2.id_tipo, pi2.qtdminima, pi2.valorun
FROM
	pacotes_itens pi2,
	(SELECT
 		id_tipo AS TIPO_MIM,
		MIN(qtdminima) AS QTD_MIM
		FROM pacotes_itens
		where id_pacote = '{$id}' and status = '1'
 		GROUP BY id_tipo) A
 WHERE
 	pi2.id_tipo = A.TIPO_MIM AND pi2.qtdminima = A.QTD_MIM and pi2.id_pacote = '{$id}' and pi2.status='1'");
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

        <script
                type="text/javascript"
                src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"

        ></script>
        <script type="text/javascript">
            $(window).load(function () {

                function id(el) {
                    //return document.getElementById( el );
                    return $(el);
                }

                function calcTotal(un01, qnt01) {
                    return un01 * qnt01;
                }

                function getElementParent(event) {
                    return event.srcElement.parentNode.parentNode.getAttribute('id');
                }

                function getValorUnitario(elParent) {
                    return $('#' + elParent + ' .class_unit input').val();
                }

                function getQuantidade(elParent) {
                    return $('#' + elParent + ' .class_quant input').val();
                }

                function setFieldTotal(elParent, valueUnit, valueQuant) {
                    id('#' + elParent + ' .class_total input').val(calcTotal(valueUnit, valueQuant).toFixed(2));
                    setTotalFinal();
                }

                function setTotalFinal() {

                    var total = 0;
                    $('#table-shop tr .class_total input').each(function () {
                        if (this.value != '') {
                            var valor = this.value;
                            total += parseFloat(valor);
                        }
                    });
                    $('#total .value_total').html(total.toFixed(2));
                    $('#total .value_total').val(total.toFixed(2));
                }

                function atualizaCampos(elemenPai){
                    var valueQuant = getQuantidade(elemenPai);
                    var tipo = $('#' + elemenPai + ' .id_tipo').val();
                    var pacote = $('#pacote').val();
                    var fd = new FormData();
                    fd.append('quantidade',valueQuant);
                    fd.append('id_tipo',tipo);
                    fd.append('id_pacote',pacote);
                    $.ajax({
                        url: 'compra_pacote.php',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response){
                            var aux = JSON.parse(response);
                            $('#' + elemenPai + ' .id_item').val(aux.id_item);
                            $('#' + elemenPai + ' .valor_item').val(aux.valorun);
                            var f = aux.valorun.toLocaleString('en', {minimumFractionDigits: 2});
                            $('#' + elemenPai + ' .class_unit input').val(f);
                            var valueUnit = getValorUnitario(elemenPai);
                            setFieldTotal(elemenPai, valueUnit, valueQuant);
                        },
                    });
                }
                $(document).ready(function () {
                    // id('#table-shop tr .class_unit').keyup(function (event) {
                    //     var elemenPai = getElementParent(event);
                    //     var valueUnit = getValorUnitario(elemenPai);
                    //     var valueQuant = getQuantidade(elemenPai);
                    //
                    //     setFieldTotal(elemenPai, valueUnit, valueQuant);
                    // });
                    
                    $('.class_quant').click(function (event) {
                        var elemenPai = getElementParent(event);
                        atualizaCampos(elemenPai);
                    });
                    id('#table-shop tr .class_quant').keyup(function (event) {
                        var elemenPai = getElementParent(event);
                        atualizaCampos(elemenPai);
                    });
                });
            });

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
                                <form action="compra_etapa2_pacote.php?id_p=<?php echo $id; ?>" method="post"
                                      enctype="multipart/form-data">
                                    <input type="text" id="pacote" value="<?php echo $id; ?>" hidden>
                                    <table id="table-shop" width="100%">
																			<?php
																			$count = 1;
																			while ($vetor_itens = mysqli_fetch_array($sql_itens)) {
																				$sql_produto = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_itens[id_tipo]'");
																				$vetor_produto = mysqli_fetch_array($sql_produto);
																				?>
                                          <tr id="line<?php echo $count; ?>">
                                              <input type="hidden" class="id_item" name="id_item[]"
                                                     value="<?php echo $vetor_itens['id_item']; ?>">
                                              <input type="hidden" class="id_tipo"
                                                     value="<?php echo $vetor_produto['id_tipo']; ?>">
                                              <input type="hidden" class="valor_item" name="valor_item[]"
                                                     value="<?php echo $vetor_itens['valorun']; ?>">

                                              <td>
                                                  <strong>Produto:</strong>
                                                  <input type="text" name="produto[]"
                                                                                  value="<?php echo $vetor_produto['nome']; ?>"
                                                                                  class="form-control" disabled="">
                                              </td>
                                              <td width="2%"></td>

                                              <td class="class_unit"><strong>Valor Un.:</strong>R$<input type="text"
                                                                                                         name="valor_unitario0<?php echo $count; ?>"
                                                                                                         value="<?php echo $vetor_itens['valorun']; ?>"
                                                                                                         id="valor_unitario0<?php echo $count; ?>" class="form-control" disabled/>
                                              </td>

                                              <td width="2%"></td>
                                              <td class="class_quant"><strong>Quantidade:</strong> <input
                                                          type="number" name="qtd[]"
                                                          min="<?php echo $vetor_itens['qtdminima']; ?>"
                                                          id="<?php if ($count == 1) { ?>qnt01<?php }else { ?>qnt02<?php } ?>"
                                                          class="form-control"
																													<?php if ($vetor_itens['qtdminima'] > 0) { ?>required <?php } ?> />
                                              </td>
                                              <td width="2%"></td>
                                              <td class="class_total"><strong>Sub-Total: </strong>R$<input type="text"
                                                                                                           name="<?php if ($count == 1) { ?>total01<?php }else { ?>total02<?php } ?>"
                                                                                                           id="<?php if ($count == 1) { ?>total01<?php }else { ?>total02<?php } ?>"
                                                                                                           class="form-control"
                                                                                                           disabled=""/>
                                              </td>
                                          </tr>
																				<?php
																				$count++;
																			}
																			?>
                                        <tr>
                                            <td></td>
                                            <td width="2%"></td>
                                            <td></td>
                                            <td width="2%"></td>
                                            <td></td>
                                            <td width="2%"></td>
                                            <td><br></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td width="2%"></td>
                                            <td></td>
                                            <td width="2%"></td>
                                            <td><strong>
                                                    <div align="right">Total: R$</div>
                                                </strong></td>
                                            <td width="2%"></td>
                                            <td>
                                                <div id="total">
                                                    <input type="number" name="valor_total" class="value_total form-control"
                                                           readonly></input>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>


                                    <button type="submit" class="btn btn-primary" id="botaoenviar" style="float: left;">Avançar
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