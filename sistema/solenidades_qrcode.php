<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$id = $_GET['id'];
	$id1 = $_GET['id1'];
	$sql = mysqli_query($con, "select * from tipos_arquivos_turma where id_tipo_formando = '$id'");
	$vetor = mysqli_fetch_array($sql);
	$sql_tipo = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '$vetor[id_tipo]'");
	$vetor_tipo = mysqli_fetch_array($sql_tipo);
	$sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);

   
	?>
        <!DOCTYPE html>
        <html dir="ltr" lang="pt-BR">

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
            <script type="text/javascript"
                    src="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"></script>
            <script type="text/javascript"
                    src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
            <!-- Custom CSS -->
            <link href="../layout/dist/css/style.min.css" rel="stylesheet">

            <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
            <script src="//cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>
            <script src="//cdn.datatables.net/plug-ins/1.10.21/sorting/data-eu.js"></script>


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
                            <!--                          <h4 class="page-title">Administrativo</h4>-->
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Arte Final</a></li>
                                    <li class="breadcrumb-item">QR-code</a></li>
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
                                    <!--                                  <h4 class="card-title">Eventos</h4>-->

                                    <a href="cadastrar_solenidades.php">
                                        <button type="button" class="btn waves-effect waves-light btn-warning">Novo QR-code
                                        </button>
                                    </a>

                                        <br>
                                        

                                    
                                    

                                    

                                        <div class="tab-pane active" id="emaberto" role="tabpanel">

                                            
                                            
                                            <div class="table-responsive">
                                                <table id="lang_opt_data"
                                                       class="table table-striped table-bordered display"
                                                       style="width:100%">
                                                    <thead align="center">
                                                    
                                                    <tr>
                                                        <th width="40%"><strong><h4>Contrato</strong></h4></th>
                                                        <th width="40%"><strong><h4>Link QR-code</strong></h4></th>
                                                        
                                                        <th width="20%"><strong><h4>Ação</strong></h4></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    
                                                    $sql_atual = mysqli_query($con, "SELECT * FROM qr_convite ");
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        $totalizador = 0;
                                                        
                                                        $sql_contrato = mysqli_query($con,  "SELECT * FROM turmas as t INNER JOIN qr_convite as q on t.id_turma = $vetor[turma_fk] order by t.ncontrato ASC ");
                                                        
                                                        $vetor_contrato = mysqli_fetch_array($sql_contrato);

                                                        $sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_contrato[id_instituicao]'");
														$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
                                                        
                                           
                                                        ?>
                                                        
                                                        <tr>
                                                            <td><?php echo $vetor_contrato['ncontrato'];?> - <?php echo $vetor_contrato['nome'];?> <?php echo $vetor_instituicao_inicio['sigla'];?> <?php echo $vetor_contrato['ano'];?></td>
                                                            <td> <a href="https://www.studiomfotografia.com.br/qr-code.php?id=<?php echo $vetor_contrato['ncontrato']; ?>">
                                                                https://www.studiomfotografia.com.br/qr-code.php?id=<?php echo $vetor_contrato['ncontrato']?>
                                                            </a>
                                                        
                                                        </td>
                                                            
                                                            <td><a class="fancybox fancybox.ajax"
                                                                   href="alterarsolenidades.php?id=<?php echo $vetor['turma_fk']; ?>"
                                                                   target="_blank">
                                                                    <button type="button"
                                                                            class="btn btn-success mesmo-tamanho"
                                                                            title="Alterar Convite"><i
                                                                                class="mdi mdi-tooltip-edit"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="../qr-code.php?id=<?php echo $vetor_contrato['ncontrato']; ?>"
                                                                   target="_blank">
                                                                    <button type="button"
                                                                            class="btn btn-primary mesmo-tamanho"
                                                                            title="Visualisar Convite"><i
                                                                                class="mdi mdi-cloud-print"></i>
                                                                    </button>
                                                                </a> 
                                                                
                                                                
                                                                        <button type="button" id="inserirImagemQRcode" data-toggle="modal" data-target="#modalInserirImagemQRcode<?php echo $vetor_contrato['ncontrato']; ?>"
                                                                                class="btn btn-secondary mesmo-tamanho"
                                                                                title="Adicionar QR-code">
                                                                                
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-qr-code" viewBox="0 0 16 16">
                                                                                    <path d="M2 2h2v2H2V2Z"/>
                                                                                    <path d="M6 0v6H0V0h6ZM5 1H1v4h4V1ZM4 12H2v2h2v-2Z"/>
                                                                                    <path d="M6 10v6H0v-6h6Zm-5 1v4h4v-4H1Zm11-9h2v2h-2V2Z"/>
                                                                                    <path d="M10 0v6h6V0h-6Zm5 1v4h-4V1h4ZM8 1V0h1v2H8v2H7V1h1Zm0 5V4h1v2H8ZM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8H6Zm0 0v1H2V8H1v1H0V7h3v1h3Zm10 1h-1V7h1v2Zm-1 0h-1v2h2v-1h-1V9Zm-4 0h2v1h-1v1h-1V9Zm2 3v-1h-1v1h-1v1H9v1h3v-2h1Zm0 0h3v1h-2v1h-1v-2Zm-4-1v1h1v-2H7v1h2Z"/>
                                                                                    <path d="M7 12h1v3h4v1H7v-4Zm9 2v2h-3v-1h2v-1h1Z"/>
                                                                                    </svg>
                                                                        </button>

                                                                
                                                                
                                                                
                                                                <a class="fancybox fancybox.ajax"
                                                                              href="excluirsolenidades.php?id=<?php echo $vetor['turma_fk']; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-danger mesmo-tamanho"
                                                                                title="Excluir Convite"><i
                                                                                    class="mdi mdi-window-close"></i>
                                                                        </button></a>
                                                                        
                                                                        
                                                                        
                                                                    
                                                                
                                                            </td>
                                                        </tr>

                                                        <div class="modal fade" id="modalInserirImagemQRcode<?php echo $vetor_contrato['ncontrato']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalInserirImagemQRcode<?php echo $vetor_contrato['ncontrato']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                    <div class="modal-content">
                                                                        <form action="recebe_ImagemQRcode.php" method="post" name="cliente"
                                                                            enctype="multipart/form-data" id="formID" >
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Enviar Imagem</h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div>
                                                                                        <input class="custom-file-input" type="file" name="images[]"
                                                                                                id="arquivoBrasao">
                                                                                        <label class="custom-file-label" id="labelarquivo"
                                                                                                for="arquivo">Selecione a imagem QR-code</label>
                                                                                    </div>
                                                                                    <div class="col-lg-12" name="hide" style="display:none;">
                                                                                        <fieldset class="form-group">
                                                                                            
                                                                                            <input id="ncontratoQRcode" name="ncontratoQRcode" type="text" value="<?php echo $vetor_contrato['ncontrato']?>">
                                                                                        </fieldset>
                                                                                    </div>
                                                                                    <div>
                                                                                        <?php
                                                                                            $ncontrato = $vetor_contrato['ncontrato'];
                                                                                            $sql_imagem = mysqli_query($con, "SELECT * FROM imagem_QRcode WHERE ncontrato = '$ncontrato'");
    

    
                                                                                            if (mysqli_num_rows($sql_imagem)>0) {
                                                                                            
                                                                                                while($row_imagem = mysqli_fetch_assoc($sql_imagem)){
                                                                                                    $result1= $row_imagem["imagemQRcode"]; 
                                                                                                    
                                                                                                    
                                                                                                }        
                                                                                                $imagem_qrcode = $result1;
                                                                                                
                                                                                            }

                                                                                            if (mysqli_num_rows($sql_imagem)>0) {
                                                                                                # code...
                                                                                            
                                                                                            
                                                                                            
                                                                                        ?>

                                                                                        <a href="<?=$imagem_qrcode?>" download="QRcode-<?=$ncontrato?>">
                                                                                        <img class=" img-fluid" src="<?=$imagem_qrcode?>" alt=""style="width: 20% !important;">
                                                                                        </a>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                <a class="fancybox fancybox.ajax"
                                                                                        href="excluirImagemQRcode.php?id=<?php echo $ncontrato; ?>">
                                                                                    <button type="button"
                                                                                            class="btn btn-danger mesmo-tamanho"
                                                                                            title="Excluir Convite">Excluir
                                                                                    </button></a>
                                                                                                                                                                
                                                                                <button type="submit" class="btn btn-primary" style="    float: left;">Cadastrar
                                                                                </button>
                                                                                <button type="button" class="btn btn-secondary"
                                                                                        data-dismiss="modal">Fechar
                                                                                </button>

                                                                        </form> 
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                        <?php
                                                    } ?>
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
                if ($.fn.dataTable.isDataTable('#lang_opt_data')) {
                    $('#lang_opt_data').dataTable().fnDestroy();
                    init_data_Table();
                } else {
                    tabelaNcms = $('#lang_opt_data').DataTable({
                        destroy: false,
                        scrollCollapse: true,
                        ordering: true,
                        info: true,
                        searching: true,
                        paging: true,
                        dom: 'Bfrtip',
                        "order": [[3, "asc"]],
                        columnDefs: [
                            {
                                type: 'date-br',
                                targets: 3
                            }
                        ],
                    });
                }
            };

            var init_data_Table1 = function () {
                var tabelaNcms = null;
                if ($.fn.dataTable.isDataTable('#lang_opt_data1')) {
                    $('#lang_opt_data1').dataTable().fnDestroy();
                    init_data_Table1();
                } else {
                    tabelaNcms = $('#lang_opt_data1').DataTable({
                        destroy: false,
                        scrollCollapse: true,
                        ordering: true,
                        info: true,
                        searching: true,
                        paging: true,
                        dom: 'Bfrtip',
                        "order": [[3, "asc"]],
                        columnDefs: [
                            {
                                type: 'date-br',
                                targets: 3
                            }
                        ],
                    });
                }
            };
            var init_data_Table2 = function () {
                var tabelaNcms = null;
                if ($.fn.dataTable.isDataTable('#lang_opt_data2')) {
                    $('#lang_opt_data2').dataTable().fnDestroy();
                    init_data_Table2();
                } else {
                    tabelaNcms = $('#lang_opt_data2').DataTable({
                        destroy: false,
                        scrollCollapse: true,
                        ordering: true,
                        info: true,
                        searching: true,
                        paging: true,
                        dom: 'Bfrtip',
                        "order": [[3, "asc"]],
                        columnDefs: [
                            {
                                type: 'date-br',
                                targets: 3
                            }
                        ],
                    });
                }
            };
            var tableToExcel = (function () {
                var uri = 'data:application/vnd.ms-excel;base64,',
                    template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40%22%3E<head><meta charset="utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
                    base64 = function (
                        s) {
                        return window.btoa(unescape(encodeURIComponent(s)))
                    }, format = function (s, c) {
                        return s.replace(/{(\w+)}/g, function (m, p) {
                            return c[p];
                        })
                    }
                return function (table, name) {
                    if (!table.nodeType)
                        table = document.getElementById(table)
                    var ctx = {
                        worksheet: name || 'Worksheet',
                        table: table.innerHTML
                    }
                    // window.location.href = uri + base64(format(template, ctx))
                    var link = document.createElement("a");
                    link.download = "relatorio.xls";
                    link.href = uri + base64(format(template, ctx));
                    link.click();
                }
            })()

            $(document).ready(function () {
                init_data_Table();
                init_data_Table1();
                init_data_Table2();

                $('#turmas').change(function () {
                    $('#formando').load('formandos_tarefa.php?id_turma=' + $('#turmas').val());

                });

            });

        </script>
        </body>

        </html>
    <?php }
 ?>