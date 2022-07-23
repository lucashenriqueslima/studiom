<?php

include "../includes/conexao.php";
session_start();
$id_pagina = 33;
if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
}else {
    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from usuarios where id_usuario = '$_SESSION[id]'"));
    $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
    $vetor_permissao = mysqli_fetch_array($sql_permissao);
    if ($vetor_permissao['listar'] != 2) {
        echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
    }
    if ($vetor_permissao['listar'] == 2) {
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

            <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
            <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

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
                            <!--                          <h4 class="page-title">Financeiro</h4>-->
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Financeiro</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Duplicatas</li>
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
                                    <!--                                  <h4 class="card-title">Duplicatas</h4>-->
                                    <br>
                                    <h4>Filtrar Data</h4>
                                    <div class="form-row">
                                        <div class="form-group col-lg-2 col-md-3 col-sm-4"
                                             style="margin-bottom: 0px !important;">
                                            <label for="">De</label>
                                            <input type="date" id="min" onchange="filtraData()"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3 col-sm-4"
                                             style="margin-bottom: 0px !important;">
                                            <label for="">Até</label>
                                            <input type="date" id="max" onchange="filtraData()"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table id="tabela" class="table table-striped table-bordered display"
                                               style="width:100%">
                                            <thead align="center">
                                            <tr>
                                                <th><strong><h5>Formando</h5></strong></th>
                                                <th><strong><h5>1° Vencimento</h5></strong></th>
                                                <th><strong><h5>NF-Fatura nº</h5></strong></th>
                                                <th><strong><h5>NF-Fatura<br>Valor Não Recebido</h5></strong></th>
                                                <th><strong><h5>NF-Fatura<br>Valor Total</h5></strong></th>
                                                <th width="13%"><strong><h5>Ação</h5></strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql_atual = mysqli_query($con, "select d.id_duplicata,
	f.nome as fnome,
	t.ncontrato,
	f.id_cadastro,
	d.valor,
	(select `data` from duplicatas_faturas df where df.id_duplicata = d.id_duplicata order by df.posicao ASC limit 0,1 ) as data
	from duplicatas d
	    left join vendas v on v.id_venda = d.id_venda
	    left join formandos f on f.id_formando = v.id_formando
	    left join turmas t on t.id_turma = f.turma
	    where v.status = '3'");
                                            while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                $valor_nrecebido = mysqli_fetch_array(mysqli_query($con,"select SUM(valor) as valor_n from duplicatas_faturas where status <> 2 and id_duplicata='{$vetor['id_duplicata']}'"));
                                                ?>
                                                <tr>
                                                    <td><?php echo $vetor['ncontrato'].'-'.$vetor['id_cadastro'].' - '.strtoupper($vetor['fnome']); ?></td>
                                                    <td align="center"><?php echo date('d/m/Y',strtotime($vetor['data'])); ?></td>
                                                    <td align="center"><?php echo $vetor['id_duplicata']; ?></td>
                                                    <td align="center"><?php echo ((int)$valor_nrecebido['valor_n'] > 0?$valor_nrecebido['valor_n']:'0'); ?></td>
                                                    <td align="center"><?php echo $vetor['valor']; ?></td>
                                                    <td align="center">
                                                        <a href="imprimirduplicata.php?id=<?php echo $vetor['id_duplicata']; ?>"
                                                           target="_blank">
                                                            <button type="button" class="btn btn-success mesmo-tamanho"
                                                                    title="Imprimir Cadastro"><i
                                                                        class="mdi mdi-cloud-print"></i></button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                            <tfoot align="center">
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </tfoot>
                                        </table>

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
        <script src="../layout/assets/libs/moment/min/moment.min.js"></script>
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
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var valid = true;
                    var min = moment($("#min").val());
                    if (!min.isValid()) {
                        min = null;
                    }

                    var max = moment($("#max").val());
                    if (!max.isValid()) {
                        max = null;
                    }

                    if (min === null && max === null) {
                        // no filter applied or no date columns
                        valid = true;
                    } else {

                        $.each(settings.aoColumns, function (i, col) {

                            if (col.type == "date-br") {
                                var cDate = moment(data[i], 'DD/MM/YYYY');

                                if (cDate.isValid()) {
                                    if (max !== null && max.isBefore(cDate)) {
                                        valid = false;
                                    }
                                    if (min !== null && cDate.isBefore(min)) {
                                        valid = false;
                                    }
                                } else {
                                    valid = false;
                                }
                            }
                        });
                    }
                    return valid;
                });

            function formatarCampo(dado) {
                var aux = parseFloat(dado);
                return aux.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
            }
            $(document).ready(function () {
                var tabela = $('#tabela').DataTable({
                    destroy: false,
                    "pageLength": 50,
                    scrollCollapse: true,
                    ordering: true,
                    info: true,
                    searching: true,
                    paging: true,
                    dom: 'Bfrtip',
                    columnDefs: [
                        {
                            type: 'date-br',
                            targets: 1
                        },
                        {
                            render: function (data, type, row) {
                                return formatarCampo(data);
                            },
                            targets: 3
                        },
                        {
                            render: function (data, type, row) {
                                return formatarCampo(data);
                            },
                            targets: 4
                        }
                    ],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(), data;

                        // Remove the formatting to get integer data for summation
                        var parseFloat = function (i) {
                            return typeof i === 'string' ?
                                i.replace(/[$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        // // Total over this page
                        pageTotal = api
                            .column(3, {filter: 'applied'})
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);

                        pageTotal2 = api
                            .column(4, {filter: 'applied'})
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0);

                        // Update footer
                        $(api.column(3).footer()).html('<strong>Total: ' + pageTotal.toLocaleString('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        }));
                        $(api.column(4).footer()).html('<strong>Total: ' + pageTotal2.toLocaleString('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        }));

                    }
                });
            });
            function filtraData() {
                $('#tabela').DataTable().draw();
            }
        </script>
        </body>

        </html>
    <?php }
} ?>