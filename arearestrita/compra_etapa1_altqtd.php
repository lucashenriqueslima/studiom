<?php

include"../includes/conexao.php";


session_start();

if($_SESSION['id_formando'] == NULL || $_SESSION['id_formando'] == '') {

echo"<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";

} else {

$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
$res_cadastro = mysqli_query($con, $sql_cadastro);
$vetor_cadastro = mysqli_fetch_array($res_cadastro);

$id = $_GET['id'];

$sql_consulta = mysqli_query($con, "select * from vendas where id_venda = '$id' and status = '3'");

if(mysqli_num_rows($sql_consulta) != 0) {

echo "<script> alert('Compra já gravada, favor entrar em suas compras!')</script>";
echo "<script> window.location.href='minhascompras.php'</script>";

} else { 

$sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
$vetor_venda = mysqli_fetch_array($sql_venda);

$sql_turma = mysqli_query($con, "select * from produtos_turma where id_turma = '$vetor_cadastro[turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$sql_itens = mysqli_query($con, "select * from produtos_turma_item where id_produto = '$vetor_venda[produto]'");

$sql_itens_pacotes = mysqli_query($con, "select * from pacotes_turma where id_produto = '$vetor_turma[id_produto]'");

$tipo = $vetor_venda['tipo'];

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
<script type="text/javascript" >
$(window).load(function(){
      
function id( el ){
        //return document.getElementById( el );
        return $( el );
}
function calcTotal( un01, qnt01 )
{
        return un01 * qnt01;
}
function getElementParent(event){
    return event.srcElement.parentNode.parentNode.getAttribute('id');
}
function getValorUnitario(elParent){
    return $('#'+elParent+' .class_unit input').val();
}
function getQuantidade(elParent){
    return $('#'+elParent+' .class_quant input').val();
}
function setFieldTotal(elParent, valueUnit, valueQuant){
    id('#'+elParent+' .class_total input').val(calcTotal( valueUnit , valueQuant).toFixed(2));
    setTotalFinal();
}
function setTotalFinal(){
    
    var total = 0;
    $('#table-shop tr .class_total input').each(function(){
        if(this.value != ''){
        var valor = this.value;
        total += parseFloat(valor);
        }
    });
    $('#total .value_total').html(total.toFixed(2));
    $('#total .value_total').val(total.toFixed(2));
}
$(document).ready(function(){
        id('#table-shop tr .class_unit').keyup(function(event)
        {
            var elemenPai = getElementParent(event);
            var valueUnit = getValorUnitario(elemenPai);
            var valueQuant = getQuantidade(elemenPai);

            setFieldTotal(elemenPai, valueUnit , valueQuant);
        });      
       
        id('#table-shop tr .class_quant').keyup(function(event)
        {
            var elemenPai = getElementParent(event);
            var valueUnit = getValorUnitario(elemenPai);
            var valueQuant = getQuantidade(elemenPai);

            setFieldTotal(elemenPai, valueUnit , valueQuant);
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
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="inicio.php">
                        <b class="logo-icon">

                            <img src="../layout/assets/images/logo-2.png" alt="homepage" class="dark-logo" width="110px" />

                            <img src="../layout/assets/images/logo-icon.png" alt="homepage" class="light-logo" width="50px" />
                        </b>

                    </a>

                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>

                        
                    </ul>

                    <ul class="navbar-nav float-right">


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>" alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $vetor_cadastro['nome']; ?></h4>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="sair.php"><i class="fa fa-power-off m-r-5 m-l-5"></i> Sair</a>
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
        <?php include"includes/menu.php"; ?>
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

                            <?php 

                            if($tipo == '1') { 

                            ?>

                            <form action="compra_etapa2_altqtd.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

                            <input type="hidden" name="cpf" value="<?php echo $cpf; ?>">

                            <table id="table-shop" width="100%">
                              <?php

                            $count=1;

                            while($vetor_itens = mysqli_fetch_array($sql_itens)) {

                            $sql_produto = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_itens[id_tipo]'");
                            $vetor_produto = mysqli_fetch_array($sql_produto);

                            $sql_itens_adquiridos = mysqli_query($con, "select * from itens_venda_individual where id_venda = '$id' and id_item = '$vetor_itens[id_item]' and tipo = '1'");
                            $vetor_item = mysqli_fetch_array($sql_itens_adquiridos);

                         ?>
                                <input type="hidden" name="id_item[]" value="<?php echo $vetor_itens['id_item']; ?>">

                                <tr id="line<?php echo $count; ?>">
                                    <td><strong>Produto:</strong><input type="text" name="produto[]" value="<?php echo $vetor_produto['nome']; ?>" class="form-control" disabled=""></td>
                                    <td width="2%"></td>
                                    <td class="class_unit"><strong>Valor Un.:</strong>R$<input type="text" name="<?php if($count == 1) { ?>valor_unitario01<?php } else { ?>valor_unitario0<?php echo $count; ?><?php } ?>"" value="<?php echo $vetor_itens['valorun']; ?>" id="<?php if($count == 1) { ?>valor_unitario01<?php } else { ?>valor_unitario0<?php echo $count; ?><?php } ?>" class="form-control" disabled /></td>
                                    <td width="2%"></td>
                                    <td class="class_quant"><strong>Quantidade:</strong> <input type="number" name="qtd[]" value="<?php echo $vetor_item['qtd']; ?>" min="<?php echo $vetor_itens['qtdminima']; ?>" id="<?php if($count == 1) { ?>qnt01<?php } else { ?>qnt02<?php } ?>" class="form-control" <?php if($vetor_itens['qtdminima'] > 0) { ?>required <?php } ?> /></td>
                                    <td width="2%"></td>
                                    <td class="class_total"><strong>Sub-Total: </strong>R$<input type="text" name="<?php if($count == 1) { ?>total01<?php } else { ?>total02<?php } ?>" id="<?php if($count == 1) { ?>total01<?php } else { ?>total02<?php } ?>" value="<?php echo $vetor_item['valor'] * $vetor_item['qtd']; ?>" class="form-control" disabled="" /></td>
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
                                    <td><strong><div align="right">Total: R$</div></strong></td>
                                    <td width="2%"></td>
                                    <td><div id="total"><input class="value_total form-control" readonly></input></strong></div></td>
                                </tr>
                            </table>
                            <br>
                          

                            <button type="submit" class="btn btn-primary"  style="    float: left;">Avançar</button>
                                
                            </form>

                            <?php 

                            }

                            if($tipo == '2') { 

                            ?>

                            <form action="compra_etapa2_pacote.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

                            <input type="hidden" name="cpf" value="<?php echo $cpf; ?>">

                            <div class="row">
                              <div class="col-lg-12">
                                <fieldset class="form-group">
                                  <label class="form-label semibold" for="exampleInput">Pacotes</label>
                                  <select name="id_pacote" id="tipobusca" class="form-control" onchange="ativarInputDataContrato()" required="">
                                    <option value="" selected="">Selecione...</option>
                                    <?php

                                    $sql_pacotes = mysqli_query($con, "select * from pacotes_turma where id_produto = '$produto'");

                                    while($vetor_pacotes = mysqli_fetch_array($sql_pacotes)) { 

                                    ?>
                                    <option value="<?php echo $vetor_pacotes['id_pacote']; ?>"><?php echo $vetor_pacotes['titulo']; ?></option>
                                    <?php } ?>
                                  </select>
                                </fieldset>
                              </div>
                            </div>

                            <button type="submit" class="btn btn-primary"  style="    float: left;">Avançar</button>
                                
                            </form>

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
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="../layout/dist/js/app.min.js"></script>
    <!-- minisidebar -->
    <script>
    $(function() {
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
<?php } } ?>