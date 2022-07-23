<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$id = $_GET['id'];
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
        <script src="../layout/assets/libs/tinymce/tinymce.min.js"></script>

        <script>
            $(function () {

                if ($("#mymce").length > 0) {
                    tinymce.init({
                        selector: "textarea#mymce",
                        theme: "modern",
                        height: 150,
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                            "save table contextmenu directionality emoticons template paste textcolor"
                        ],
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

                    });
                }
                // ==============================================================
                // Our Visitor
                // ==============================================================

                var chart = c3.generate({
                    bindto: '#visitor',
                    data: {
                        columns: [
                            ['Open', 4],
                            ['Closed', 2],
                            ['In progress', 2],
                            ['Other', 0],
                        ],

                        type: 'donut',
                        tooltip: {
                            show: true
                        }
                    },
                    donut: {
                        label: {
                            show: false
                        },
                        title: "Tickets",
                        width: 35,

                    },

                    legend: {
                        hide: true
                        //or hide: 'data1'
                        //or hide: ['data1', 'data2']

                    },
                    color: {
                        pattern: ['#40c4ff', '#2961ff', '#ff821c', '#7e74fb']
                    }
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
                                    <li class="breadcrumb-item">Financeiro</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cobrança</li>
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
                                <h3>Nova Interação</h3>
                                <form action="recebe_gestaotitulos.php?id=<?php echo $id; ?>" enctype="multipart/form-data"
                                      method="post">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meio</label>
                                                <select name="tipo_interacao" class="form-control" required="">
                                                    <option value="0" selected="">Selecione...</option>
																									<?php
																									$sql_tipo = mysqli_query($con, "select * from tipo_interacao order by nome ASC");
																									while ($vetor_tipo = mysqli_fetch_array($sql_tipo)) {
																										?>
                                                      <option value="<?php echo $vetor_tipo['id_tipo']; ?>"><?php echo $vetor_tipo['nome']; ?></option>
																									<?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Assunto</label>
                                                <select name="assunto" class="form-control" required="">
                                                    <option value="21" selected="">Cobrança</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Ocorrência</label>
                                                <textarea id="mymce" name="ocorrencia" class="form-control"
                                                          rows="2"></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary" style="    float: left;">Cadastrar
                                    </button>

                                </form>
                                <br>
                                <br>
                                <br>
                                <h3>Interações</h3>
                                <div class="table-responsive">
                                    <table id="lang_opt" class="table table-bordered table-striped">
                                        <thead align="center">
                                        <tr>
                                            <th><strong><h4>Data Inserção</h4></strong></th>
                                            <th><strong><h4>Hora Inserção</h4></strong></th>
                                            <th><strong><h4>Meio</h4></strong></th>
                                            <th><strong><h4>Assunto</h4></strong></th>
                                            <th><strong><h4>Ocorrência</h4></strong></th>
                                        </tr>
                                        </thead>
                                        <tbody>
						                            <?php
						                            $sql_interacoes = mysqli_query($con, "select t.nome as tnome,a.nome as anome,i.* from interacao_cobranca i
                                                    left join tipo_interacao t on t.id_tipo = i.id_tipo_interacao
                                                    left join assuntos a on a.id_assunto = i.id_assunto
                                                    where id_duplicata_fatura = '$id' order by data_insercao DESC");
						                            while ($vetor = mysqli_fetch_array($sql_interacoes)) {
							                            ?>
                                            <tr>
                                                <td align="center"><?php echo date('d/m/Y', strtotime(substr($vetor['data_insercao'],0,10))); ?></td>
                                                <td align="center"><?php echo substr($vetor['data_insercao'], 11, 5); ?></td>
                                                <td align="center"><?php echo $vetor['tnome']; ?></td>
                                                <td align="center"><?php echo $vetor['anome']; ?></td>
                                                <td align="center">
                                                    <button type='button'
                                                            class='btn btn-success btn-xs'
                                                            style='padding: 3px;height: 30px;vertical-align: middle'
                                                            data-toggle="modal"
                                                            data-target="#ocorrencia<?php echo $vetor['id_interacao']; ?>">
                                                        <i class='mdi mdi-24px mdi-eye'
                                                           style='position: relative;top: -6px'></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <div id='ocorrencia<?php echo $vetor['id_interacao']; ?>'
                                                 class='modal' tabindex='-1' role='dialog'>
                                                <div class='modal-dialog modal-lg' role='document'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title'>Ocorrência</h5>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <div class='row'>
                                                                <div class='col-lg-12'>
																			                            <?php echo $vetor['ocorrencia']; ?>
                                                                </div>
                                                            </div><!--.row-->
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button type='button'
                                                                    class='btn btn-secondary'
                                                                    data-dismiss='modal'>Fechar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
						                            <?php } ?>
                                        </tbody>
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
                    "order": [[0, "asc"]],
                    columnDefs: [
                        {
                            type: 'date-br',
                            targets: 0
                        }
                    ],
                });
            }
        };
        $(document).ready(function () {
            init_data_Table();
        });
    </script>
    </body>

    </html>
<?php } ?>