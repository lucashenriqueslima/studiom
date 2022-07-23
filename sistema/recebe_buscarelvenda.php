<?php
function formatarCPF_CNPJ($campo, $formatado = true)
{
    //retira formato
    $codigoLimpo = preg_replace("[' '-./ t]", '', $campo);
    // pega o tamanho da string menos os digitos verificadores
    $tamanho = (strlen($codigoLimpo) - 2);
    //verifica se o tamanho do cÃ³digo informado Ã© vÃ¡lido
    if ($tamanho != 9 && $tamanho != 12) {
        return false;
    }
    if ($formatado) {
        // seleciona a mÃ¡scara para cpf ou cnpj
        $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';
        $indice = -1;
        for ($i = 0; $i < strlen($mascara); $i++) {
            if ($mascara[$i] == '#') {
                $mascara[$i] = $codigoLimpo[++$indice];
            }
        }
        //retorna o campo formatado
        $retorno = $mascara;
    } else {
        //se nÃ£o quer formatado, retorna o campo limpo
        $retorno = $codigoLimpo;
    }
    return $retorno;
}

include "../includes/conexao.php";
session_start();
$id_pagina = 31;
if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
} else {
    $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);
    $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
    $vetor_permissao = mysqli_fetch_array($sql_permissao);
    if ($vetor_permissao['listar'] != 2) {
        echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
    }
    if ($vetor_permissao['listar'] == 2) {
        $datainicio = $_POST['datainicio'];
        $datafim = $_POST['datafinal'];
        $sql_atual = mysqli_query($con, "select * from vendas where data between '$datainicio' AND '$datafim' and iniciada = '2' and (tipo = '2' or tipo = '3' or tipo = '4') order by tipo ASC");
        $sql_soma = mysqli_query($con, "select SUM(valorvenda) as total FROM vendas where data between '$datainicio' AND '$datafim' and status <> '4' and iniciada = '2' and (tipo = '2' or tipo = '3' or tipo = '4')");
        $vetor_soma = mysqli_fetch_array($sql_soma);
        $sql_atual1 = mysqli_query($con, "select * from vendas where data between '$datainicio' AND '$datafim' and iniciada = '2' and tipo = '1' order by tipo ASC");
        $sql_soma1 = mysqli_query($con, "select SUM(valorvenda) as total FROM vendas where data between '$datainicio' AND '$datafim' and iniciada = '2' and status <> '4' and tipo = '1'");
        $vetor_soma1 = mysqli_fetch_array($sql_soma1);
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
                           aria-controls="navbarSupportedContent" aria-expanded="false"
                           aria-label="Toggle navigation"><i
                                    class="ti-more"></i></a>
                    </div>

                    <div class="navbar-collapse collapse" id="navbarSupportedContent">

                        <ul class="navbar-nav float-left mr-auto">
                            <li class="nav-item d-none d-md-block"><a
                                        class="nav-link sidebartoggler waves-effect waves-light"
                                        href="javascript:void(0)"
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
                            <h4 class="page-title">Vendas</h4>
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Relatório de Vendas</li>
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
                                    <h4 class="card-title">Relatório de Vendas</h4>

                                    <ul class="nav nav-tabs" role="tablist">

                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                href="#fotografia" role="tab"><span
                                                        class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                                        class="hidden-xs-down">Fotografia</span></a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#convite"
                                                                role="tab"><span class="hidden-sm-up"><i
                                                            class="ti-email"></i></span> <span class="hidden-xs-down">Convite</span></a>
                                        </li>

                                    </ul>

                                    <div class="tab-content tabcontent-border">

                                        <div class="tab-pane active" id="fotografia" role="tabpanel">

                                            <br>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="lang_opt" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th width="10%"></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Total:</th>
                                                        <th>
                                                            R$ <?php echo $num = number_format($vetor_soma['total'], 2, ',', '.'); ?></th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <thead align="center">
                                                    <tr>
                                                        <th width="10%"><strong><h5>Código</h5></strong></th>
                                                        <th><strong><h5>Formando</h5></strong></th>
                                                        <th><strong><h5>Tipo da Venda</h5></strong></th>
                                                        <th><strong><h5>Data da Venda</h5></strong></th>
                                                        <th><strong><h5>Data de Vencimento</h5></strong></th>
                                                        <th><strong><h5>Data 1° Vencimento</h5></strong></th>
                                                        <th><strong><h5>Parcelas</h5></strong></th>
                                                        <th><strong><h5>Forma de Pagamento</h5></strong></th>
                                                        <th><strong><h5>Valor da Venda</h5></strong></th>
                                                        <th><strong><h5>Status</h5></strong></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    while ($vetor_venda = mysqli_fetch_array($sql_atual)) {
                                                        $sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor_venda[id_formando]'");
                                                        $vetor_formando = mysqli_fetch_array($sql_formando);
                                                        $sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_venda[formapag]'");
                                                        $vetor_forma = mysqli_fetch_array($sql_forma);
                                                        $sql_vencimentos = mysqli_query($con, "select a.id_duplicata, a.id_venda, b.id_duplicata, b.data, b.posicao from duplicatas a, duplicatas_faturas b where a.id_duplicata = b.id_duplicata and a.id_venda = '$vetor_venda[id_venda]' order by b.posicao ASC limit 0,1");
                                                        $vetor_vencimento = mysqli_fetch_array($sql_vencimentos);
                                                        $sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor_formando[turma]'");
                                                        $vetor_turma = mysqli_fetch_array($sql_turma);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $vetor_venda['id_venda']; ?></td>
                                                            <td><?php echo $vetor_turma['ncontrato']; ?>
                                                                -<?php echo $vetor_formando['id_cadastro']; ?>
                                                                - <?php echo $vetor_formando['nome']; ?></td>
                                                            <td><?php if ($vetor_venda['tipo'] == 4) {
                                                                    echo "Taxa de Estúdio";
                                                                }
                                                                if ($vetor_venda['tipo'] == 2) {
                                                                    echo "Fotografias";
                                                                }
                                                                if ($vetor_venda['tipo'] == 3) {
                                                                    echo "Venda Avulsa";
                                                                } ?></td>
                                                            <td><?php echo date('d/m/Y', strtotime($vetor_venda['data'])); ?></td>
                                                            <td><?php echo $vetor_venda['diavencimento']; ?></td>
                                                            <td><?php if ($vetor_vencimento['data'] == null) {
                                                                } else {
                                                                    echo date('d/m/Y', strtotime($vetor_vencimento['data']));
                                                                } ?></td>
                                                            <td><?php echo $vetor_venda['qtdparcelas']; ?></td>
                                                            <td><?php echo $vetor_forma['nome']; ?></td>
                                                            <td><?php echo $vetor_venda['valorvenda']; ?></td>
                                                            <td><?php if($vetor_venda['status'] == '4'){
                                                                    echo "Cancelado";
                                                                }elseif(($vetor_venda['formapag'] == '3' && $vetor_venda['pagamento'] == '1') || $vetor_venda['formapag'] != '3'){
                                                                    echo "Compra Finalizada";
                                                                }else{
                                                                    echo "Aguardando Pagamento";
                                                                }?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="convite" role="tabpanel">

                                            <br>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="lang_opt2" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th width="10%"></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Total:</th>
                                                        <th>
                                                            R$ <?php echo $num = number_format($vetor_soma1['total'], 2, ',', '.'); ?></th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <thead align="center">
                                                    <tr>
                                                        <th width="10%"><strong><h5>Código</h5></strong></th>
                                                        <th><strong><h5>Formando</h5></strong></th>
                                                        <th><strong><h5>Tipo da Venda</h5></strong></th>
                                                        <th><strong><h5>Data da Venda</h5></strong></th>
                                                        <th><strong><h5>Data de Vencimento</h5></strong></th>
                                                        <th><strong><h5>Data 1° Vencimento</h5></strong></th>
                                                        <th><strong><h5>Parcelas</h5></strong></th>
                                                        <th><strong><h5>Forma de Pagamento</h5></strong></th>
                                                        <th><strong><h5>Valor da Venda</h5></strong></th>
                                                        <th><strong><h5>Status</h5></strong></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    while ($vetor_venda1 = mysqli_fetch_array($sql_atual1)) {
                                                        $sql_formando1 = mysqli_query($con, "select * from formandos where id_formando = '$vetor_venda1[id_formando]'");
                                                        $vetor_formando1 = mysqli_fetch_array($sql_formando1);
                                                        $sql_forma1 = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_venda1[formapag]'");
                                                        $vetor_forma1 = mysqli_fetch_array($sql_forma1);
                                                        $sql_vencimentos1 = mysqli_query($con, "select a.id_duplicata, a.id_venda, b.id_duplicata, b.data, b.posicao from duplicatas a, duplicatas_faturas b where a.id_duplicata = b.id_duplicata and a.id_venda = '$vetor_venda1[id_venda]' order by b.posicao ASC limit 0,1");
                                                        $vetor_vencimento1 = mysqli_fetch_array($sql_vencimentos1);
                                                        $sql_turma1 = mysqli_query($con, "select * from turmas where id_turma = '$vetor_formando1[turma]'");
                                                        $vetor_turma1 = mysqli_fetch_array($sql_turma1);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $vetor_venda1['id_venda']; ?></td>
                                                            <td><?php echo $vetor_turma1['ncontrato']; ?>
                                                                -<?php echo $vetor_formando1['id_cadastro']; ?>
                                                                - <?php echo $vetor_formando1['nome']; ?></td>
                                                            <td><?php if ($vetor_venda1['tipo'] == 1) {
                                                                    echo "Convites";
                                                                }
                                                                if ($vetor_venda1['tipo'] == 2) {
                                                                    echo "Fotografias";
                                                                }
                                                                if ($vetor_venda1['tipo'] == 3) {
                                                                    echo "Venda Avulsa";
                                                                } ?></td>
                                                            <td><?php echo date('d/m/Y', strtotime($vetor_venda1['data'])); ?></td>
                                                            <td><?php echo $vetor_venda1['diavencimento']; ?></td>
                                                            <td><?php if ($vetor_vencimento1['data'] == null) {
                                                                } else {
                                                                    echo date('d/m/Y', strtotime($vetor_vencimento1['data']));
                                                                } ?></td>
                                                            <td><?php echo $vetor_venda1['qtdparcelas']; ?></td>
                                                            <td><?php echo $vetor_forma1['nome']; ?></td>
                                                            <td><?php echo $num = number_format($vetor_venda1['valorvenda'], 2, ',', '.'); ?></td>
                                                            <td><?php if($vetor_venda1['status'] == '4'){
                                                                    echo "Cancelado";
                                                                }elseif(($vetor_venda1['formapag'] == '3' && $vetor_venda1['pagamento'] == '1') || $vetor_venda1['formapag'] != '3'){
                                                                    echo "Compra Finalizada";
                                                                }else{
                                                                    echo "Aguardando Pagamento";
                                                                }?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
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
        <script type="text/javascript">
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "date-br-pre": function (a) {
                    if (a == null || a == "") {
                        return 0;
                    }
                    var brDatea = a.split('/');
                    return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
                },

                "date-br-asc": function (a, b) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },

                "date-br-desc": function (a, b) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });
            var init_data_Table = function () {
                var tabelaNcms = null;
                if ($.fn.dataTable.isDataTable('#lang_opt')) {
                    $('#lang_opt').dataTable().fnDestroy();
                    init_data_Table();
                } else {
                    tabelaNcms = $('#lang_opt').DataTable({
                        destroy: false,
                        scrollCollapse: true,
                        ordering: true,
                        info: true,
                        searching: true,
                        paging: true,
                        dom: 'Bfrtip',
                        columnDefs: [
                            {
                                type: 'date-br',
                                targets: 3
                            },
                            {
                                type: 'date-br',
                                targets: 5
                            }
                        ],
                    });
                }
            };
            var init_data_Table2 = function () {
                var tabelaNcms = null;
                if ($.fn.dataTable.isDataTable('#lang_opt2')) {
                    $('#lang_opt2').dataTable().fnDestroy();
                    init_data_Table2();
                } else {
                    tabelaNcms = $('#lang_opt2').DataTable({
                        destroy: false,
                        scrollCollapse: true,
                        ordering: true,
                        info: true,
                        searching: true,
                        paging: true,
                        dom: 'Bfrtip',
                        "order": [[3, "desc"]],
                        columnDefs: [
                            {
                                type: 'date-br',
                                targets: 3
                            },
                            {
                                type: 'date-br',
                                targets: 5
                            }
                        ],
                    });
                }
            };

            $(document).ready(function () {
                init_data_Table();
                init_data_Table2();
            });
        </script>
        </body>

        </html>
    <?php }
} ?>