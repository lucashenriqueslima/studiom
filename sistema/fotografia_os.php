<?php
include "../includes/conexao.php";
session_start();
$id_pagina = 130;

if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
}else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_arquivo = mysqli_query($con, "select arquivopdf from ordem_servico where id_os = '$id'");
        $vetor_arquivo = mysqli_fetch_array($sql_arquivo);
        unlink("arquivos/os/Fotografia/$vetor_arquivo[arquivopdf]");
        $res2 = mysqli_query($con, "delete FROM ordem_servico where id_os = '$id'");
    
        echo 'OK';
        die();
    }
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
		?>
         <!DOCTYPE html>
        <html dir="ltr" lang="pt-br">

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
            <!-- This Page CSS -->
            <link rel="stylesheet" type="text/css" href="../layout/assets/libs/select2/dist/css/select2.min.css">
            <link rel="stylesheet" type="text/css" href="../layout/assets/extra-libs/prism/prism.css">
            <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
            <!-- Custom CSS -->
            <link href="../layout/dist/css/style.min.css" rel="stylesheet">
            
            <style></style>
            <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
            <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

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
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Fotografia</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">O.S</li>
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
                    <!-- Sales chart -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                
                                <?php if ($vetor_permissao['cadastro'] == 1) {
                                    } else { ?><a href="cadastro_osfotografia.php">
                                        <button type="button" class="btn waves-effect waves-light btn-warning">Nova
                                            OS
                                        </button>
                                    </a>

                                        <br>
                                        <br>
                                        <br>

                                    <?php } ?>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="lang_opt" class="table table-bordered table-striped display" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th width="5%"></th>
                                                        <th style="text-align: center"><h5><strong>Cód. OS</strong></h5></th>
                                                        <th style="text-align: center"><h5><strong>Contrato</strong></h5></th>
                                                        <th style="text-align: center"><h5><strong>Cód. Formando</strong></h5></th>
                                                        <th style="text-align: center"><h5><strong>Nome Formando</strong></h5></th>
                                                        <th style="text-align: center"><h5><strong>Data Expedição</strong></h5></th>
                                                        <th style="text-align: center"><h5><strong>Data Final Produção</strong></h5></th>
                                                        <th style="text-align: center"><h5><strong>Ação</strong></h5></th>
                                                        
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $sql_atual = mysqli_query($con, "select os.id_os, t.ncontrato, f.id_cadastro, f.nome, os.data_expedicao, os.data_finalProducao, os.arquivopdf from ordem_servico os 
                                                                                                                            left join formandos f on f.id_formando = os.id_formando
                                                                                                                            left join turmas t on t.id_turma = f.turma 
                                                                                                                            where os.id_depemissor = 10");
                                                    while ($vetor = mysqli_fetch_array($sql_atual)) {
                                                        ?>
                                                        <tr>
                                                            <td align="center"><button id="arquivoos" name="arquivoos"  data-arq="arquivos/os/Fotografia/<?= $vetor['arquivopdf']?>" 
                                                                    onClick="pegararq('<?= $vetor['arquivopdf']?>')"
                                                                    type="button" class="btn" style=" border-bottom: 0px; border:none!important;" 
                                                                    data-toggle="modal" data-target="#modalArquivo"><span><i class="fas fa-minus-circle fa-plus-circle"></i></span></button></td>
                                                            <td align="center"><?= $vetor['id_os'] ?></td>
                                                            <td align="center"><?= $vetor['ncontrato']?></td>
                                                            <td align="center"><?= $vetor['id_cadastro']?></td>
                                                            <td align="center"><?= $vetor['nome'] ?></td>
                                                            <td align="center"><?= date('d/m/Y', strtotime($vetor['data_expedicao'])) ?></td>
                                                            <td align="center"><?= date('d/m/Y', strtotime($vetor['data_finalProducao'])) ?></td>
                                                            <td align="center">
                                                                <a type="button" class="btn btn-outline-danger" href="arquivos/os/Fotografia/<?= $vetor['arquivopdf']?>" download="<?= 'OS '.$vetor['ncontrato'].'-'.$vetor['id_cadastro'].' '.$vetor['nome'].'.pdf' ?>">Download</a>
                                                                <?php  if ($vetor_permissao['exclusao'] != 1) { ?>
                                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmaExcluir" title="Excluir os" onclick="arrumaModalP(<?php echo $vetor['id_os']; ?>)">
                                                                    <i class="mdi mdi-window-close"></i>
                                                                </button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div id="confirmaExcluir" class="modal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-md" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Exclusão de OS</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Você tem certeza que deja excluir a OS?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="confirmouExclusao" type="button"
                                                                class="btn btn-danger"
                                                                onclick="excluiCadastro()">Excluir OS
                                                        </button>
                                                        <button type="button" class="btn btn-success"
                                                                data-dismiss="modal">Voltar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            
                                            <object data=" " type="application/pdf" data-add="1" id="varq">
                                                    <p>Seu navegador não tem um plugin pra PDF</p>
                                            </object>
                                           <!-- Modal -->
                                            <div class="modal fade " id="modalArquivo" tabindex="-1" role="dialog" aria-labelledby="modalArquivoLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-xl " role="document" >
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" >
                                                <div class="voudesistir"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                   
                                                </div>
                                                </div>
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

        <script type="text/javascript">
        // jquery para chamar a modal
           /**  $( "#arquivoos" ).click(function() {
                var arquivo = $(this).attr('data-arq');  // pega o arquivo do botão
                console.log(arquivo);
                $(function() { $('object[data-add="1"]')
                    .attr('data', arquivo);
                });
            });*/
            
            function pegararq(arq){
                
                var arquivo = 'arquivos/os/Fotografia/'+arq;  // pega o arquivo do botão
                //$('.varq').setAttribute('data', arquivo)
                //$('object[data-add="1"]').attr('data', arquivo);
                $(".voudesistir").html('<object data="'+arquivo+' " type="application/pdf" style="width : 100%; height: 40em " id="varq"> <p>Seu navegador não tem um plugin pra PDF</p> </object>');
            }

            function arrumaModalP(id) {
                $('#confirmouExclusao').attr('onclick', 'excluiCadastroP(' + id + ')')
            }
            function excluiCadastroP(id) {
                    $.ajax({
                        url: 'fotografia_os.php?id=' + id,
                        type: "POST",
                        success: function (rep) {
                            if (rep == 'OK') {
                                alert('Excluido com Sucesso');
                                window.location.reload(true);
                            } else {
                                alert('Erro na Modificação do banco de dados');
                            }
                        }
                    });
            }
        </script>
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
        <!-- This Page JS -->
        <script src="../layout/assets/libs/select2/dist/js/select2.min.js"></script>
        <script src="../layout/dist/js/app-style-switcher.js"></script>
        <script src="../layout/assets/extra-libs/prism/prism.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="../layout/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
        <script src="../layout/assets/extra-libs/sparkline/sparkline.js"></script>
        <!--Wave Effects -->
        <script src="../layout/dist/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="../layout/dist/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="../layout/dist/js/custom.min.js"></script>
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
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="../layout/dist/js/pages/datatable/datatable-basic.init.js"></script>
        <script src="../layout/assets/libs/moment/min/moment.min.js"></script>

     
        </body>

        </html>
    <?php }
} ?>