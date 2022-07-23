<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id_formando'] == null || $_SESSION['id_formando'] == '') {
	echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";
}else {
    
	$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);
	$sql_chamados = mysqli_query($con, "select * from chamados where id_formando = '$_SESSION[id_formando]' order by id_chamado DESC");
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
    <script type="text/javascript">
        $(document).ready(function () {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }

            //Quando o campo cep perde o foco.
            $("#cep").blur(function () {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...")
                        $("#bairro").val("...")
                        $("#cidade").val("...")
                        $("#uf").val("...")
                        $("#ibge").val("...")

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });
    </script>
    <script type="text/javascript">
        /* MÃ¡scaras ER */
        function mascara(o, f) {
            v_obj = o
            v_fun = f
            setTimeout("execmascara()", 1)
        }

        function execmascara() {
            v_obj.value = v_fun(v_obj.value)
        }

        function mtel(v) {
            v = v.replace(/\D/g, ""); //Remove tudo o que nÃ£o Ã© dÃ­gito
            v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
            v = v.replace(/(\d)(\d{4})$/, "$1-$2"); //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
            return v;
        }

        function id(el) {
            return document.getElementById(el);
        }

        window.onload = function () {
            id('telefone').onkeypress = function () {
                mascara(this, mtel);
            }
            id('telefone2').onkeypress = function () {
                mascara(this, mtel);
            }
        }

        $(document).ready(function () {
            $("#palco > div").hide();
            $("#produto").change(function () {
                $("#palco > div").hide();
                $('#' + $(this).val()).show('fast');
            });
            $("#palco1 > div").hide();
            $("#tipobusca").change(function () {
                $("#palco1 > div").hide();
                $('#' + $(this).val()).show('fast');
            });
            $("#palco2 > div").hide();
            $("#tipobusca1").change(function () {
                $("#palco2 > div").hide();
                $('#' + $(this).val()).show('fast');
            });
            $("#palco3 > div").hide();
            $("#tipobusca2").change(function () {
                $("#palco3 > div").hide();
                $('#' + $(this).val()).show('fast');
            });
            $("input[name='rd-sexo']").click(function () {
                $("#palco > div").hide();
                $('#' + $(this).val()).show('fast');
            });
        });

        function duplicarCampos() {
            var clone = document.getElementById('origem').cloneNode(true);
            var destino = document.getElementById('destino');
            destino.appendChild(clone);
            var camposClonados = clone.getElementsByTagName('input');
            for (i = 0; i < camposClonados.length; i++) {
                camposClonados[i].value = '';
            }
        }

        function removerCampos(id) {
            var node1 = document.getElementById('destino');
            node1.removeChild(node1.childNodes[0]);
        }

        function duplicarCampos1() {
            var clone1 = document.getElementById('origem1').cloneNode(true);
            var destino1 = document.getElementById('destino1');
            destino1.appendChild(clone1);
            var camposClonados1 = clone1.getElementsByTagName('input');
            for (i = 0; i < camposClonados1.length; i++) {
                camposClonados1[i].value = '';
            }
        }

        function removerCampos1(id) {
            var node1 = document.getElementById('destino1');
            node1.removeChild(node1.childNodes[0]);
        }

        function duplicarCampos2() {
            var clone2 = document.getElementById('origem2').cloneNode(true);
            var destino2 = document.getElementById('destino2');
            destino2.appendChild(clone2);
            var camposClonados2 = clone2.getElementsByTagName('input');
            for (i = 0; i < camposClonados2.length; i++) {
                camposClonados2[i].value = '';
            }
        }

        function removerCampos2(id) {
            var node2 = document.getElementById('destino2');
            node2.removeChild(node2.childNodes[0]);
        }
    </script>

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
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
                                width="110px" />

                            <img src="../layout/assets/images/logo-icon.png" alt="homepage" class="light-logo"
                                width="50px" />
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
                                    <li class="breadcrumb-item active" aria-current="page">Meus Documentos</li>
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
                                <h4 class="card-title">Meus Documentos</h4>

                                <ul class="nav nav-tabs" role="tablist">

                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#convite"
                                            role="tab"><span class="hidden-sm-up"><i class="ti-layers-alt"></i></span>
                                            <span class="hidden-xs-down">Convite</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fotografia"
                                            role="tab"><span class="hidden-sm-up"><i class="ti-camera"></i></span> <span
                                                class="hidden-xs-down">Fotografia</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#termo"
                                            role="tab"><span class="hidden-sm-up"><i class="ti-id-badge"></i></span>
                                            <span class="hidden-xs-down">Termo LGPD</span></a>
                                    </li>


                                </ul>

                                <div class="tab-content tabcontent-border">

                                    <div class="tab-pane active" id="convite" role="tabpanel">

                                        <br>
                                        <br>

                                        <div class="table-responsive">
                                            <table id="lang_opt" class="table table-striped table-bordered display"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Titulo</th>
                                                        <th>Data</th>
                                                        <th>Hora</th>
                                                        <th>Arquivo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
																								$sql_arquivos = mysqli_query($con, "select * from arquivos where id_cliente = '$_SESSION[id_formando]' and tipo = '2' order by id_arquivo DESC");
																								while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
																									$sql_formando = mysqli_query($con, "select * from formando where id_formando = '$vetor_arquivo[id_cliente]'");
																									$vetor_formando = mysqli_fetch_array($sql_formando);
																									?>
                                                    <tr>
                                                        <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?>
                                                        </td>
                                                        <td><?php echo $vetor_arquivo['hora']; ?></td>
                                                        <td>
                                                            <a href="../sistema/arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                                target="_blank">
                                                                <button type="button" class="btn btn-default">Arquivo
                                                                </button>
                                                            </a></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                    <div class="tab-pane" id="fotografia" role="tabpanel">

                                        <br>
                                        <br>

                                        <div class="table-responsive">
                                            <table id="lang_opt1" class="table table-striped table-bordered display"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Titulo</th>
                                                        <th>Data</th>
                                                        <th>Hora</th>
                                                        <th>Arquivo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
																								$sql_arquivos = mysqli_query($con, "select * from arquivos where id_cliente = '$_SESSION[id_formando]' and tipo = '1' order by id_arquivo DESC");
																								while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
																									$sql_formando = mysqli_query($con, "select * from formando where id_formando = '$vetor_arquivo[id_cliente]'");
																									$vetor_formando = mysqli_fetch_array($sql_formando);
																									?>
                                                    <tr>
                                                        <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?>
                                                        </td>
                                                        <td><?php echo $vetor_arquivo['hora']; ?></td>
                                                        <td>
                                                            <a href="../sistema/arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                                target="_blank">
                                                                <button type="button" class="btn btn-default">Arquivo
                                                                </button>
                                                            </a></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                    <div class="tab-pane" id="termo" role="tabpanel">

                                        <br>
                                        <br>

                                        <div class="table-responsive">
                                            <table id="lang_opt1" class="table table-striped table-bordered display"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Titulo</th>
                                                        <th>Data</th>
                                                        <th>Hora</th>
                                                        <th>Arquivo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $vetor_arquivo = mysqli_fetch_all(mysqli_query($con, "SELECT 
                                                        a.titulo,
                                                        DATE_FORMAT(a.`data`, '%d/%m/%Y') data,
                                                        a.hora,
                                                        a.arquivo
                                                        FROM arquivos a 
                                                        WHERE a.tipo = 3
                                                        AND a.id_cliente = ".$_SESSION['id_formando']."
                                                        ORDER BY a.id_arquivo DESC"), MYSQLI_ASSOC);
                                                        for($i = 0; $i < count($vetor_arquivo); $i++){

                                                            ?>
                                                    <tr>

                                                        <td><?php echo $vetor_arquivo[$i]['titulo']; ?></td>
                                                        <td><?php echo $vetor_arquivo[$i]['data']; ?>
                                                        </td>
                                                        <td><?php echo $vetor_arquivo[$i]['hora']; ?></td>
                                                        <td>

                                                            <a href="../sistema/arquivos/<?= $vetor_arquivo[$i]['arquivo']; ?>"
                                                                target="_blank">
                                                                <button type="button" class="btn btn-default">Arquivo
                                                                </button>
                                                            </a></td>
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
</body>

</html>
<?php } ?>