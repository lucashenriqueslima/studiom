<?php

	include "../includes/conexao.php";

	 
	 session_start();

	if($_SESSION['id_formando'] == NULL && $_SESSION['comissao'] == NULL) {
	
	echo"<script language=\"JavaScript\">
	location.href=\"inicio.php\";
	</script>";
	
	} else {

	if($_SESSION['comissao'] != 2) {

	echo"<script language=\"JavaScript\">
	location.href=\"inicio.php\";
	</script>";

	}
		
    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));

    $vetor_turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '{$vetor_cadastro['turma']}'"));

    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));

    $id_turma = $vetor_cadastro['turma'];   
    

    if ($vetor_turma['tipo'] == 2){
        $id_categoria = $_GET['evento'];
    }else{
        $id_evento_turma = $_GET['evento'];

        $vetor_evento_turma = mysqli_fetch_array(mysqli_query($con, "select * from eventos_turma_lista where id_evento_turma = $id_evento_turma"));

        $id_categoria = $vetor_evento_turma['id_evento'];
    }

    $sql_local = mysqli_query($con, "select *, l.nome as nomelocal from locais l inner join eventos_turma et on et.id_turma = '$id_turma' and et.id_local = l.id_local and et.id_categoria = '$id_categoria'");
    $vetor_local = mysqli_fetch_array($sql_local);
    
    $sql_eventos_turma = mysqli_query($con, "select * from eventos_turma et inner join locais l on et.id_turma = '$id_turma' and et.id_local = l.id_local and et.id_categoria = '$id_categoria'");
    $vetor_eventos_turma = mysqli_fetch_array($sql_eventos_turma);
    
    $id_categoria_consulta = $vetor_local['id_categoria'];
    $tipo_local = $vetor_local['tipo'];
    //echo $id_categoria_consulta;
   
   // echo $id_turma;
    //echo "<br>";
    //echo $id_categoria;
    $local =  "";
    $cep = "";
    $endereco = "";
    $complemento = "";
    $bairro = "";
    $cidade = "";
    $estado = "";
    $data = "";
    $horainicio = "";
    $horafim = "";
    $observacao = "";
    $latitudeEvento = "";
    $longitudeEvento = "";
    if ($tipo_local == 1 ||  $tipo_local == 3 ) {
    
        if (mysqli_num_rows($sql_local) != 0) {
            $local = $vetor_local['nomelocal'];
            $cep = $vetor_local['cep'];
            $endereco = $vetor_local['endereco'];
            $complemento = $vetor_local['complemento'];
            $bairro = $vetor_local['bairro'];
            $cidade = $vetor_local['cidade'];
            $estado = $vetor_local['estado'];
            $data = $vetor_local['data'];
            $horainicio = $vetor_local['horainicio'];
            $horafim = $vetor_local['horafim'];
            $observacao = $vetor_local['observacoes'];
            $latitudeEvento = $vetor_local['latitudeEvento'];
            $longitudeEvento = $vetor_local['longitudeEvento'];
        }
        
    }

?>
<!DOCTYPE html>
<html dir="ltr" lang="pt-br">


<head>
<title>Studio M Fotografia</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="keywords" content="Studiom Fotografia"/>
        <script type="application/x-javascript"> addEventListener("load", function () {
                setTimeout(hideURLbar, 0);
            }, false);

            function hideURLbar() {
                window.scrollTo(0, 1);
            } </script>
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



        <script src="js/custom.js"></script>
        <script src="js/screenfull.js"></script>

        <!-- Mainly scripts -->
        <script src="js/jquery.metisMenu.js"></script>
        <script src="js/jquery.slimscroll.min.js"></script>
        <!-- Custom and plugin javascript -->
        <link href="css/custom.css" rel="stylesheet">
        <script src="js/custom.js"></script>
        <script src="js/screenfull.js"></script>
        <script>
            $(function () {
                $('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

                if (!screenfull.enabled) {
                    return false;
                }


                $('#toggle').click(function () {
                    screenfull.toggle($('#container')[0]);
                });


            });
        </script>

        <!----->

        <!--pie-chart--->
        <script src="js/pie-chart.js" type="text/javascript"></script>
        <script type="text/javascript">

            $(document).ready(function () {
                $('#demo-pie-1').pieChart({
                    barColor: '#3bb2d0',
                    trackColor: '#eee',
                    lineCap: 'round',
                    lineWidth: 8,
                    onStep: function (from, to, percent) {
                        $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                    }
                });

                $('#demo-pie-2').pieChart({
                    barColor: '#fbb03b',
                    trackColor: '#eee',
                    lineCap: 'butt',
                    lineWidth: 8,
                    onStep: function (from, to, percent) {
                        $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                    }
                });

                $('#demo-pie-3').pieChart({
                    barColor: '#ed6498',
                    trackColor: '#eee',
                    lineCap: 'square',
                    lineWidth: 8,
                    onStep: function (from, to, percent) {
                        $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                    }
                });


            });

        </script>
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
        <script type="text/javascript" >


$(document).ready(function() {

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
        $("#ibge").val("");
    }
    
    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...")
                $("#bairro").val("...")
                $("#cidade").val("...")
                $("#uf").val("...")
                $("#ibge").val("...")

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

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


        <!--skycons-icons-->
        <script src="js/skycons.js"></script>

        <style type="text/css">
            .img-circle {
                border-radius: 50%;
            }
        </style>
        <!--//skycons-icons-->
        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
</head>

<body>
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
                        <h4 class="page-title">Plataforma Digital</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="inicio.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Arquivos de Convite</li>
                                    <li class="breadcrumb-item active" aria-current="page">Adicionar Evento</li>
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
                        <div class="card ">
                            <div class="card-body">
                                
                                    <form action="recebe_localQrconvite.php?evento=<?=$id_categoria?>" method="post" name="cliente" enctype="multipart/form-data"
                                        onSubmit="return verificarCPF()" id="formID">
                                        <!--
                                        <h3>Solicitação de Eventos</h3>

                                        <div class="row">

                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Categoria de Eventos</label>
                                                    <select name="id_categoria" id="categorias" class="form-control select2">
                                                        <option value="" selected="selected">Selecione...</option>
                                                        <?php
                                                        $sql = mysqli_query($con, "select * from dados_convite where id_turma = '$vetor_cadastro[turma]'");
                                                        $vetor = mysqli_fetch_array($sql);
                                                        $sql_categoria = mysqli_query($con, "select * from categoriaevento order by nome ASC");
                                                        while ($vetor_categoria = mysqli_fetch_array($sql_categoria)) { ?>
                                                            <option value="<?php echo $vetor_categoria['id_categoria']; ?>"><?php echo $vetor_categoria['nome'] ?></option>

                                                            
                                                        <?php } ?>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            
                                            <div class="col-lg-6" id="hidden_div" style="display: none;">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Título</label>
                                                    <input type="text" name="titulo" class="form-control">
                                                </fieldset>
                                            </div>
                                            
                                        </div>
-->
                                        <h3>Dados do Evento</h3>

                                        <div class="row">
                                            
                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Local</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="nome" value="<?= $local?>"
                                                            class="form-control" id="nome" placeholder="Digite o nome"
                                                            required>
                                                        <div class="input-group-append">
                                                        <button id="localizacaoBtn" name="localizacaoBtn"
                                                            type="button" class="btn btn-outline-danger" 
                                                            style=" border-bottom: 0px; border:none!important;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                                            </svg>
                                                        </button>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>

                                        </div><!--.row-->
                                        <input class="form-control" type="hidden" id="longitudeEvento" name="longitudeEvento" value="<?= $longitudeEvento?>">
                                        <input class="form-control" type="hidden" id="latitudeEvento" name="latitudeEvento" value="<?= $latitudeEvento?>">
                                        <?php if ($vetor_turma['tipo'] != 2) {?>
                                        <input class="form-control" type="hidden" id="id_evento_turma" name="id_evento_turma" value="<?=$id_evento_turma?>">
                                        <?php }?>

                                        <div class="row" id="localizacao" name="localizacao" class="group alert ">
                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <?php include "../sistema/pegarlocal.php"; ?>
                                                    
                                                    <!--<div id="map"  style="width: 100%; height: 500px"> </div>-->
                                                    <button id="cadastrarLocalizacao" name="cadastrarLocalizacao"
                                                                    type="button" class="btn btn-outline-danger">
                                                                    Cadastrar Localização
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                                                    </svg>
                                                                </button>  
                                                </fieldset>
                                            </div>          
                                        </div><!--.row-->

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInputEmail1">CEP</label>
                                                    <input type="text" name="cep" id="cep" class="form-control" value="<?=$cep?>"
                                                        placeholder="CEP" required>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInputPassword1">Endereço</label>
                                                    <input type="text" name="endereco" id="rua" class="form-control"  value="<?=$endereco?>"
                                                        placeholder="Endereço" required>
                                                </fieldset>
                                            </div>
                                        </div><!--.row-->

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInputEmail1">Complemento</label>
                                                    <input type="text" name="complemento" id="complemento" class="form-control"  value="<?=$complemento?>"
                                                        placeholder="Complemento">
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInputPassword1">Bairro</label>
                                                    <input type="text" name="bairro" id="bairro" class="form-control"  value="<?=$bairro?>"
                                                        placeholder="Bairro" required>
                                                </fieldset>
                                            </div>
                                        </div><!--.row-->


                                        <div class="row">
                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Cidade</label>
                                                    <input type="text" name="cidade" id="cidade" class="form-control"  value="<?=$cidade?>"
                                                        placeholder="Cidade" required>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInputEmail1">UF</label>
                                                    <input type="text" name="estado"  value="<?=$estado?>"
                                                        id="uf" class="form-control" placeholder="Estado" required>
                                                </fieldset>
                                            </div>

                                        </div><!--.row-->

                                        <div class="row">

                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Data</label>
                                                    <input type="date" name="data"  value="<?=$data?>"
                                                        
                                                        class="form-control" id="exampleInput" placeholder="Data">
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Hora de início do
                                                        evento</label>
                                                    <input type="time" name="horainicio"
                                                        value="<?=$horainicio?>" class="form-control"
                                                        id="horainicio" placeholder="Data">
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Hora de Término do
                                                        Evento (previsão)</label>
                                                    <input type="time" name="horafim"  value="<?=$horafim?>"
                                                        class="form-control" id="horafim" placeholder="Data">
                                                </fieldset>
                                            </div>

                                        </div>

                                        

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput" id="observacoes">Observações
                                                        Adicionais</label>
                                                    <textarea name="observacoes" class="form-control" ><?= $observacao?></textarea>
                                                </fieldset>
                                            </div>
                                        </div><!--.row-->

                                        


                                        <button type="submit" class="btn btn-primary" style="    float: left;">Cadastrar
                                        </button>

                                    </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <footer class="footer text-center ">
        Todos direitos reservados. <a href="https://studiomfotografia.com.br">Studio M Fotografia</a>.
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
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

 
                                                          
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWrHlvID_j9Be0a6RstCXfK6FW5OfMAyk&libraries=places&callback=initMap"  type="text/javascript"></script> 
    <script>
         $(document).ready(function(){
             
            $("#localizacao").hide();
            $("#divEvento").hide();
            $("#divMostraEventoColacaograu").hide();
            $("#divMostraEventoJantardospais").hide();
            $("#divMostraEventoCultoecumenico").hide();
            $("#divMostraEventoBailedeformatura").hide();

            $("#localizacaoBtn").click(function(){
                //$("#localizacao").show();
                var x = document.getElementById("localizacao");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
                
               // document.getElementById("localizacao").scrollIntoView(true);
                
            })
            $("#cadastrarLocalizacao").click(function(){
                $("#localizacao").hide();
            })
            
        });
    </script>                                                        
    <script>
        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
      
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: {  lat: -16.681773, lng: -49.2512037 },
            zoom: 5,
            mapTypeControl: false,
        });
        
        const card = document.getElementById("pac-card");
        const input = document.getElementById("pac-input");
        const biasInputElement = document.getElementById("use-location-bias");
        const strictBoundsInputElement = document.getElementById("use-strict-bounds");
        const options = {
            fields: ["formatted_address", "geometry", "name"],
            strictBounds: false,
            types: ["establishment"],
        };

        // sobrepõem o card do mapa
       // map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

        const autocomplete = new google.maps.places.Autocomplete(input, options);

        

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo("bounds", map);

        const infowindow = new google.maps.InfoWindow();
        const infowindowContent = document.getElementById("infowindow-content");

        infowindow.setContent(infowindowContent);

        const marker = new google.maps.Marker({
            map,
            anchorPoint: new google.maps.Point(0, -29),
        });

        autocomplete.addListener("place_changed", () => {
            infowindow.close();
            marker.setVisible(false);

            const place = autocomplete.getPlace();

            if (!place.geometry || !place.geometry.location) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
            } else {
            map.setCenter(place.geometry.location);
            map.setZoom(20);
            }

            //marker.setPosition(place.geometry.location);
            //marker.setVisible(true);
            //infowindowContent.children["place-name"].textContent = place.name;
            //infowindowContent.children["place-address"].textContent =place.formatted_address;
            infowindow.open(map, marker);
        });



        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        

        
       

        // Create the initial InfoWindow.

        var latitude = document.getElementById("latitudeEvento").value;
        var longitude = document.getElementById("longitudeEvento").value;
        const center = new google.maps.LatLng(latitude, longitude);
        const svgMarker = {
            path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
            fillColor: "red",
            fillOpacity: 1,
            strokeWeight: 0,
            rotation: 0,
            scale: 2,
            anchor: new google.maps.Point(15, 30),
            //zoom: 20,
                                    
        };

        new google.maps.Marker({
            position: center,
            icon: svgMarker,
            map: map,
            //center: center,
            //zoom: 20,
        });
        
        
        console.log(latitude);
        console.log(longitude);
                        
                        //passando latitude e longitude para o form
                        google.maps.event.addListener(map, 'click', function( event ){
                            var latitude = event.latLng.lat();
                            var longitude = event.latLng.lng();                   
                            alert("Selecionado com sucesso");
                            
                            
                            //recuperando cep
                            var latlng = new google.maps.LatLng(latitude, longitude);
                            geocoder = new google.maps.Geocoder();

                                geocoder.geocode({'latLng': latlng}, function(results, status) {
                                    if (status == google.maps.GeocoderStatus.OK) {
                                        if (results[0]) {
                                            for (j = 0; j < results[0].address_components.length; j++) {
                                                if (results[0].address_components[j].types[0] == 'postal_code'){
                                                    cep = results[0].address_components[j].short_name;
                                                }
                                            }
                                        }
                                    } else {
                                        alert("CEP não encontrado");
                                    }
                                });
                           
                            

                            $("#cadastrarLocalizacao").click(function ( ){
                                
                                console.log(latitude);
                                console.log(longitude);
                                console.log(cep);
                               
                                const center = new google.maps.LatLng(latitude, longitude);
                                const svgMarker = {
                                    //path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                                    fillColor: "red",
                                    fillOpacity: 1,
                                    strokeWeight: 0,
                                    rotation: 0,
                                    scale: 2,
                                    anchor: new google.maps.Point(15, 30),
                                    
                                };

                                new google.maps.Marker({
                                    position: center,
                                    icon: svgMarker,
                                    map: map,
                                    
                                });
                                
                                document.getElementById('latitudeEvento').value = event.latLng.lat();
                                document.getElementById('longitudeEvento').value = event.latLng.lng();
                                //console.log(document.getElementById('latitudeJantar').value);
                               // console.log(document.getElementById('longitudeJantar').value);
                               var nextInput = document.getElementById('cep').value = cep;
                               if (nextInput) {
                                    document.getElementById('cep').select();
                                    //document.getElementById('cep').next();     
                                }

                                
                            });
                            
                        });  
                        
                       

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
    <script src="../layout/assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../layout/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 charts -->
    <script src="../layout/assets/extra-libs/c3/d3.min.js"></script>
    <script src="../layout/assets/extra-libs/c3/c3.min.js"></script>
    <!--chartjs -->
    <script src="../layout/assets/libs/chart.js/dist/Chart.min.js"></script>
    <script src="../layout/dist/js/pages/dashboards/dashboard1.js"></script>

    <script>
  
      $(function() {
                
                $('#example1').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false,
                    "order": [[ 0, "asc" ]]
                });
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false,
                    "order": [[ 1, "asc" ]]
                });
                $('#example3').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false,
                    "order": [[ 1, "asc" ]]
                });
      });
    </script>
        
</body>

</html>
<?php } ?>