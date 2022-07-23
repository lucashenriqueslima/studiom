<?php

include "../includes/conexao.php";

session_start();

if ($_SESSION['id_formando'] == NULL && $_SESSION['comissao'] == NULL) {

    echo "<script language=\"JavaScript\">
	location.href=\"inicio.php\";
	</script>";

} else {

    if ($_SESSION['comissao'] != 2) {

        echo "<script language=\"JavaScript\">
  location.href=\"inicio.php\";
  </script>";

    }

    $sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);

    $sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor_cadastro[turma]'");
    $vetor_turma = mysqli_fetch_array($sql_turma);

    $sql = mysqli_query($con, "select * from dados_convite where id_turma = '$vetor_cadastro[turma]'");
    $vetor = mysqli_fetch_array($sql);

    
    ?>
    <!DOCTYPE HTML>
    <html>
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
    <body onload="expandetextarea()">
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
                                
 
                               

                                    <h5>CADASTRO de EVENTOS</h5>

                                    <br>
                                   
                                        <div class="row">

<div class="col-lg-12">
    <fieldset class="form-group">
        <label class="form-label semibold"
            for="exampleInput">Eventos</label>
        
        <select id="categorias" name="id_categoria" class="form-control" onchange="myFunction(this.value)">
            <option value="" selected="selected">Selecione...</option>
                <?php
                    //$sql_evento = mysqli_query($con, "select * from categoriaevento a, eventos_turma_lista b where a.id_categoria = b.id_evento and b.id_turma = '$vetor_cadastro[turma]' and status != 1 ");
                    
                    if ($vetor_turma['tipo'] == 2) {
                        $sql_evento = mysqli_query($con, "select * from categoriaevento");
                        while ($vetor_evento = mysqli_fetch_array($sql_evento)) { ?>
                            <option value="<?php echo $vetor_evento['id_categoria']; ?>"><?= $vetor_evento['nome']; ?></option>
                        
                        <?php
                        }
                    }else{
                        
                    $sql_evento = mysqli_query($con, "select * from categoriaevento a, eventos_turma_lista b where a.id_categoria = b.id_evento and b.id_turma = '$vetor_cadastro[turma]'");
                    while ($vetor_evento = mysqli_fetch_array($sql_evento)) { ?>
                        <option value="<?php echo $vetor_evento['id_evento_turma']; ?>"><?php if ($vetor_evento['nome'] == 'Pré-evento'){ echo $vetor_evento['nome'].' - '.$vetor_evento['preevento']; }else { echo $vetor_evento['nome']; }?></option>
                        
                <?php } }?>
        </select>
        
    </fieldset>
</div>

</div> 
                                           
                                        <input type="hidden" id="idTipoEvento">
                                        
                                       

                                            <div class="dependentes">
                                            <div id="btnAdicionarDependentes"></div>
                                            <div class="container" id="dependentesContainer">
                                            </div>
                                            
                                            </div>
                                            <div id="destino">
                                        </div>
                                        <br>
                                        <input type="button" value="Adicionar Evento" onclick="adicionarEvento();" id="adicionarEvento"
                                            class="btn btn-warning">
                                        

                                        <br>
                                        <br>
                                        
                                        <div class="table-responsive">
                                            <table id="lang_opt" class="table table-striped table-bordered display"
                                                    style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th data-priority="1">Eventos</th>
                                                    
                                                    <th width="13%">Ação</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql_atual_qrconvite = mysqli_query($con, "select * from dados_evento_qrconvite where id_turma_fk = '$vetor_cadastro[turma]'");
                                                        while ($vetor_qrconvite = mysqli_fetch_array($sql_atual_qrconvite)) {
                                                            $sql_categoriaEventos = mysqli_query($con, "select * from categoriaevento where id_categoria = '{$vetor_qrconvite['id_categoriaEvento_fk']}'");
                                                            $vetor_categoriaEventos = mysqli_fetch_array($sql_categoriaEventos);
                                                                                                
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $vetor_categoriaEventos['nome']; ?></td>
                                                            
                                                            
                                                            
                                                            <td><a class="fancybox fancybox.ajax"
                                                                    href="editarEvento.php?evento=<?php echo $vetor_qrconvite['id_categoriaEvento_fk']; ?>"
                                                                    target="_blank">
                                                                    <button type="button" class="btn btn-success mesmo-tamanho"
                                                                            title="Ver ou Alterar Cadastro"><i
                                                                                class="mdi mdi-tooltip-edit"></i></button>
                                                                </a> <a class="fancybox fancybox.ajax"
                                                                            href=" remove_localQrconvite.php?idturma=<?php echo $vetor_cadastro['turma']; ?>&idcategoria=<?php echo $vetor_qrconvite['id_categoriaEvento_fk'];?>">
                                                                        <button type="button" class="btn btn-danger mesmo-tamanho"
                                                                                title="Excluir Cadastro"><i
                                                                                    class="mdi mdi-window-close"></i></button>
                                                                    </a></td>
                                                        </tr>
                                                    <?php } ?>
                                                                                            
                                                </tbody>
                                            </table>

                                        </div> 
                                        <br>   
                                        

                                  
                    
                                <form action="recebe_dadosconvite.php" method="post" name="cliente" enctype="multipart/form-data" onSubmit="return verificarCPF()" id="formID">
                                <h5>HOMENAGEADOS</h5>
                                  <br>
                                  <div class="table-responsive">
                                            <table id="lang_opt" class="table table-striped table-bordered display"
                                                    style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th data-priority="1">Corpo de homenageados</th>
                                                    <th data-priority="1">Título</th>
                                                    <th data-priority="1">Nome</th>
                                                    <th width="13%">Ação</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $sql_homenageados = mysqli_query($con, "select * from homenageados where id_turma_fk = '$vetor_cadastro[turma]' order by corpoHomenageados asc ");
                                                    while ($vetor_homenageados = mysqli_fetch_array($sql_homenageados)) {
                                                        // $sql_categoriaEventos = mysqli_query($con, "select * from categoriaevento where id_categoria = '{$vetor['id_categoriaEvento_fk']}'");
                                                        // $vetor_categoriaEventos = mysqli_fetch_array($sql_categoriaEventos);
                                                                                                
                                                ?>
                                                                                               
                                                                                           
                                                    <tr>
                                                        <td><?php echo $vetor_homenageados['corpoHomenageados']; ?></td>

                                                        <td><?php echo $vetor_homenageados['titulo']; ?></td>
                                                        
                                                        <td><?php echo $vetor_homenageados['nome_homenageado']; ?></td>
                                                        
                                                        <td> <a class="fancybox fancybox.ajax"
                                                                        href=" remove_homenageado.php?idturma=<?php echo $vetor_homenageados['id_turma_fk']; ?>&nome=<?php echo $vetor_homenageados['nome_homenageado'];?>">
                                                                    <button type="button" class="btn btn-danger mesmo-tamanho"
                                                                            title="Excluir Cadastro"><i
                                                                                class="mdi mdi-window-close"></i></button>
                                                                </a></td>
                                                    </tr>
                                                                                            <?php } ?>
                                                </tbody>
                                            </table>

                                        </div> 

                                    <br>

                                    <!-- Patrono -->                                                    
                                    <div id="origemHomenageado">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Corpo de Homenageados</label>
                                                    <select name="corpo[]" class="form-control">
                                                        <option value="" selected="selected">Selecione...</option>

                                                        <option value="Professor">
                                                            Professor
                                                        </option>
                                                        <option value="Professora">
                                                            Professora
                                                        </option>
                                                        <option value="Patrono">
                                                            Patrono
                                                        </option>
                                                        <option value="Patronesse">
                                                            Patronesse
                                                        </option>
                                                        <option value="Patrona">
                                                            Patrona
                                                        </option>
                                                        <option value="Paraninfo">
                                                            Paraninfo
                                                        </option>
                                                        <option value="Paraninfa">
                                                            Paraninfa
                                                        </option>
                                                        <option value="Padrinho">
                                                            Padrinho
                                                        </option>
                                                        <option value="Madrinha">
                                                            Madrinha
                                                        </option>
                                                        <option value="Nome da Turma">
                                                            Nome da Turma
                                                        </option>
                                                        <option value="Funcionário Homenageado">
                                                            Funcionário Homenageado
                                                        </option>
                                                        <option value="Funcionária Homenageada">
                                                            Funcionária Homenageada
                                                        </option>
                                                        <option value="Residente Homenageado">
                                                            Residente Homenageado
                                                        </option>
                                                    </select>
                                                </fieldset>
                                            </div>   
                                            <div class="col-lg-3">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Título</label>
                                                    <select name="titulo[]" class="form-control">
                                                        <option value="" selected="selected">Selecione...</option>

                                                        <option value="Me.">
                                                            Mestre (Me.)
                                                        </option>
                                                        <option value="Ma.">
                                                            Mestra (Ma.)
                                                        </option>
                                                        <option value="Dr.">
                                                            Doutor (Dr.)
                                                        </option>
                                                        <option value="Dra.">
                                                            Doutora (Dra.)
                                                        </option>
                                                        <option value="PhD.">
                                                            Pós-doutorado (PhD.)
                                                        </option>
                                                        <option value=" ">
                                                            Sem título
                                                        </option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Nome</label>
                                                    <input type="text" name="nome[]" class="form-control">
                                                
                                            </fieldset>
                                            </div>

                                        </div>

                                    </div>

                                    <div id="destinoHomenageado">
                                    </div>
                                    <br>
                                    <input type="button" value="Adicionar Homenageado" onclick="duplicarHomenageado();"
                                           class="btn btn-warning">
                                    <input type="button" value="Excluir Homenageado" onclick="removerHomenageado(this);"
                                           class="btn btn-danger">

                                    <br>
                                    <br>
                                    <br>
                                    <h5>CORPO ADMINISTRATIVO</h5>
                                  <br>
                                  <div class="table-responsive">
                                            <table id="lang_opt" class="table table-striped table-bordered display"
                                                    style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th data-priority="1">Corpo Administrativo</th>
                                                    <th data-priority="1">Título</th>
                                                    <th data-priority="1">Nome</th>
                                                    <th width="13%">Ação</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $sql_corpoAdministrativo = mysqli_query($con, "select * from corpoadministrativo where id_turma_fk = '$vetor_cadastro[turma]' order by nome_corpoAdministrativo asc ");
                                                    while ($vetor_corpoAdministrativo = mysqli_fetch_array($sql_corpoAdministrativo)) {
                                                        // $sql_categoriaEventos = mysqli_query($con, "select * from categoriaevento where id_categoria = '{$vetor['id_categoriaEvento_fk']}'");
                                                        // $vetor_categoriaEventos = mysqli_fetch_array($sql_categoriaEventos);
                                                                                                
                                                ?>
                                                                                               
                                                                                           
                                                    <tr>
                                                        <td><?php echo $vetor_corpoAdministrativo['corpoAdministrativo']; ?></td>

                                                        <td><?php echo $vetor_corpoAdministrativo['titulo']; ?></td>
                                                        
                                                        <td><?php echo $vetor_corpoAdministrativo['nome_corpoAdministrativo']; ?></td>
                                                        
                                                        <td> <a class="fancybox fancybox.ajax"
                                                                        href="remove_corpoadministrativo.php?idturma=<?php echo $vetor_corpoAdministrativo['id_turma_fk']; ?>&nome=<?php echo $vetor_corpoAdministrativo['nome_corpoAdministrativo'];?>">
                                                                    <button type="button" class="btn btn-danger mesmo-tamanho"
                                                                            title="Excluir Cadastro"><i
                                                                                class="mdi mdi-window-close"></i></button>
                                                                </a></td>
                                                    </tr>
                                                                                            <?php } ?>
                                                </tbody>
                                            </table>

                                        </div> 

                                    <br>

                                    <!-- Patrono -->                                                    
                                    <div id="origemCorpoAdministrativo">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Corpo Administrativo</label>
                                                    <select name="corpoAdm[]" class="form-control">
                                                        <option value="" selected="selected">Selecione...</option>

                                                        <option value="Pró-Reitor">
                                                            Pró-Reitor
                                                        </option>
                                                        <option value="Reitor">
                                                            Reitor
                                                        </option>
                                                        <option value="Vice-Reitor">
                                                            Vice-Reitor
                                                        </option>
                                                        <option value="Diretor">
                                                            Diretor
                                                        </option>
                                                        <option value="Vice-Diretor">
                                                            Vice-Diretor
                                                        </option>
                                                        <option value="Superintendente">
                                                            Superintendente
                                                        </option>
                                                        <option value="Secretário">
                                                            Secretário
                                                        </option>
                                                        <option value="Coordenador do Curso">
                                                            Coordenador do Curso
                                                        </option>
                                                        <option value="Vice-Coordenador do Curso">
                                                            Vice-Coordenador do Curso
                                                        </option>
                                                        <option value="Coordenador Operacional Acadêmica">
                                                            Coordenador Operacional Acadêmica
                                                        </option>
                                                        <option value="Coordenador do internato">
                                                            Coordenador do internato
                                                        </option>
                                                        <option value="Gestor da Unidade">
                                                            Gestor da Unidade
                                                        </option>
                                                        <option value="Presidente da Comissão de Graduação">
                                                            Presidente da Comissão de Graduação
                                                        </option>
                                                        <option value="Vice-Presidente da Comissão de Graduação">
                                                            Vice-Presidente da Comissão de Graduação
                                                        </option>
                                                        <option value="Assistente Técnico Acadêmica">
                                                            Assistente Técnico Acadêmica
                                                        </option>
                                                        <option value="Chefe da Seção de Alunos e Cursos">
                                                            Chefe da Seção de Alunos e Cursos
                                                        </option>
                                                        

                                                    </select>
                                                </fieldset>
                                            </div>   
                                            <div class="col-lg-3">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Título</label>
                                                    <select name="tituloAdm[]" class="form-control">
                                                        <option value="" selected="selected">Selecione...</option>

                                                        <option value="Me.">
                                                            Mestre (Me.)
                                                        </option>
                                                        <option value="Ma.">
                                                            Mestra (Ma.)
                                                        </option>
                                                        <option value="Dr.">
                                                            Doutor (Dr.)
                                                        </option>
                                                        <option value="Dra.">
                                                            Doutora (Dra.)
                                                        </option>
                                                        <option value="PhD.">
                                                            Pós-doutorado (PhD.)
                                                        </option>
                                                        <option value=" ">
                                                            Sem título
                                                        </option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Nome</label>
                                                    <input type="text" name="nomeAdm[]" class="form-control">
                                                
                                            </fieldset>
                                            </div>

                                        </div>

                                    </div>

                                    <div id="destinoCorpoAdministrativo">
                                    </div>
                                    <br>
                                    <input type="button" value="Adicionar Corpo Administrativo" onclick="duplicarCorpoAdministrativo();"
                                           class="btn btn-warning">
                                    <input type="button" value="Excluir Corpo Administrativo" onclick="removerCorpoAdministrativo(this);"
                                           class="btn btn-danger">

                                    <br>
                                    <br>

                                    
                                    <br>

                                    <h5>MENSAGEM INICIAL</h5>

                                    <br>

                                    

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Mensagem
                                                    Inicial</label>
                                                    
                                                <textarea rows="5" name="mensageminicial" class="form-control" maxlength="1500" ><?php echo $vetor['mensageminicial']?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <br>

                                    <h5>MENSAGENS e AGRADECIMENTOS</h5>

                                    <br>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">A Deus</label>
                                                <textarea rows="5" name="adeus"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['adeus']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos Pais</label>
                                                <textarea rows="5" name="aospais"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['aospais']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos Pais
                                                    Ausentes</label>
                                                <textarea rows="5" name="aospaisausentes"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['aospaisausentes']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">À Família</label>
                                                <textarea rows="5" name="afamilia"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['afamilia']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos que Amamos</label>
                                                <textarea rows="5" name="aosqueamamos"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['aosqueamamos']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos Amigos</label>
                                                <textarea rows="5" name="aosamigos"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['aosamigos']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos Mestres</label>
                                                <textarea rows="5" name="aosmestres"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['aosmestres']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos
                                                    Funcionários</label>
                                                <textarea rows="5" name="aosfuncionarios"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['aosfuncionarios']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos Pacientes
                                                    (Medicina)</label>
                                                <textarea rows="5" name="aospacientes"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['aospacientes']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Ao Cadáver
                                                    Desconhecido (Medicina)</label>
                                                <textarea rows="5" name="aocadaver"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['aocadaver']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Juramento</label>
                                                <textarea rows="5" name="juramento"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['juramento']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <br>

                                    <h5>MENSAGENS FINAIS</h5>

                                    <br>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Mensagem da
                                                    Comissão</label>
                                                <textarea rows="5" name="mensagemcomissao"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['mensagemcomissao']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Mensagem Final</label>
                                                <textarea rows="5" name="mensagemfinal"  maxlength="1500"
                                                        class="form-control"><?php echo $vetor['mensagemfinal']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <br>

                                    <h5>CRÉDITOS</h5>

                                    <br>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Logo
                                                    Instituição</label>
                                                <?php if ($vetor['logoinstituicao'] == NULL) { ?>
                                                    <input type="file" name="logoinstituicao">
                                                <?php } else { ?>
                                                    <img src="../sistema/arquivos/<?php echo $vetor['logoinstituicao']; ?>">
                                                <?php } ?>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Logo
                                                    Cerimonial</label>
                                                <?php if ($vetor['logocerimonial'] == NULL) { ?>
                                                    <input type="file" name="logocerimonial">
                                                <?php } else { ?>
                                                    <img src="../sistema/arquivos/<?php echo $vetor['logocerimonial']; ?>">
                                                <?php } ?>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Logo Empresa
                                                    Fotográfica</label>
                                                <?php 
                                                
                                                    if (($vetor_turma['tipo'] == 1) || ($vetor_turma['tipo'] == 3)) {
                                                ?>       
                                                    <img style="width:10%; height:auto !important;" src="../sistema/arquivos/StudioLogo.png">
                                                <?php        
                                                    }else{ 
                                                                                           
                                                if ($vetor['empresafotografica'] == NULL) { ?>
                                                    <input type="file" name="empresafotografica">
                                                <?php } else { ?>
                                                    <img src="../sistema/arquivos/<?php echo $vetor['empresafotografica']; ?>">
                                                <?php }}?>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Logo Outra</label>
                                                <?php if ($vetor['outra'] == NULL) { ?>
                                                    <input type="file" name="outra">
                                                <?php } else { ?>
                                                    <img src="../sistema/arquivos/<?php echo $vetor['outra']; ?>">
                                                <?php } ?>
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
        //var acaoo = "input";
        

        $("textarea").keyup(function(e) {
            while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
                $(this).height($(this).height()+1);
            };
        }); 
        /**
        $("textarea").bind(acaoo, function(e) {
            while( $(this).outerHeight() < this.scrollHeight +
                                        parseFloat($(this).css("borderTopWidth")) +
                                        parseFloat($(this).css("borderBottomWidth"))
                && $(this).height() < 500 // Altura máxima
            ) {
                $(this).height($(this).height()+1);
            };
        });
     
        function myFunction(val) {
                                                                                            
            evento_selecionadojss = val;
            //console.log(val);
            console.log(evento_selecionadojss);
            return evento_selecionadojss;
            $("#divEvento").hide();    
            $("#divMostraEventoColacaograu").hide();
            $("#divMostraEventoJantardospais").hide();
            $("#divMostraEventoCultoecumenico").hide();
            $("#divMostraEventoBailedeformatura").hide();
                                                                                        
            if (evento_selecionadojss == 13) {
                
                if ((document.getElementById('jantardospaisinput').value)=="") {
                    $("#divEvento").show();
                }else{
                    $("#divMostraEventoJantardospais").show();
                }
            }
            if (evento_selecionadojss == 12) {
                if ((document.getElementById('colacaograuinput').value)=="") {
                    $("#divEvento").show();
                }else{
                    $("#divMostraEventoColacaograu").show();
                }
            }
            if (evento_selecionadojss == 9) {
                if ((document.getElementById('cultoecumenicoinput').value)=="") {
                    $("#divEvento").show();
                }else{
                    $("#divMostraEventoCultoecumenico").show();
                }
            }
            if (evento_selecionadojss == 14) {
                if ((document.getElementById('bailedeformaturainput').value)=="") {
                    $("#divEvento").show();
                }else{
                    $("#divMostraEventoBailedeformatura").show();
                }
            }
            
            
        }**/

        
    </script> 
    
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

    function adicionarEvento() {
        document.getElementById("idTipoEvento").value = evento_selecionadojss;
        var passaValor= function(valor){window.location = "adicionarEvento.php?evento="+valor;}
        let dependente_container = passaValor(evento_selecionadojss); 
        
    }

  
    function duplicarHomenageado(){
        var clone = document.getElementById('origemHomenageado').cloneNode(true);
        var destino = document.getElementById('destinoHomenageado');
        destino.appendChild(clone);
        var camposClonados = clone.getElementsByTagName('input');
        for (i = 0; i < camposClonados.length; i++) {
            camposClonados[i].value = '';
             
        }
    }
    function removerHomenageado(id) {
        var node1 = document.getElementById('destinoHomenageado');
        node1.removeChild(node1.childNodes[0]);
    }    
    
    function duplicarCorpoAdministrativo(){
        var clone = document.getElementById('origemCorpoAdministrativo').cloneNode(true);
        var destino = document.getElementById('destinoCorpoAdministrativo');
        destino.appendChild(clone);
        var camposClonados = clone.getElementsByTagName('input');
        for (i = 0; i < camposClonados.length; i++) {
            camposClonados[i].value = '';
             
        }
    }
    function removerCorpoAdministrativo(id) {
        var node1 = document.getElementById('destinoCorpoAdministrativo');
        node1.removeChild(node1.childNodes[0]);
    }    
    </script>
    <script>
        
            
        function myFunction(val) { 
                evento_selecionadojss = val;
                console.log(evento_selecionadojss);
                document.getElementById("idTipoEvento").value = evento_selecionadojss;

                /**var dependentes = [{ identificador: 13, nome: "Joana da Silva", evento: evento_selecionadojss, }];
                
                function carregarDependentes(){
                let dependentes_container = document.querySelector("#dependentesContainer");
                    dependentes_container.innerHTML = "";

              
                dependentes.forEach((el)=>{
                    let identificador = el.identificador;
                    let nome = el.nome;
                    let evento = el.evento;**/
                    
                   
                    
                    /**`
                    <div class="dependente" data-id="${identificador}"> 
                        
                        
                        <div id="origem">
                            <input class="nome" placeholder="Digite o nome" type="text" value="${nome}"/>
                            <input class="idade" placeholder="Digite a idade" type="number" value="${evento}"/>
                            
                        </div>  
                        <div id="div12" ></div>
                        
                       <!-- <div class="action">
                            <a href="#" class="salvar">salvar 💾</a>
                            <a href="#" class="remover">❌</a>
                        </div> -->                   
                    </div>`;**/
                        
                    
                    dependentes_container.innerHTML += dependente_container;
               /**  });
                
                    
                
                //salvarDependentes();
                //removerDependentes();
                travarOutros(false);
            }

            function removerDependentes(){
                document.querySelectorAll("#dependentesContainer .remover").forEach((el, i)=>{
                el.addEventListener("click", ()=>{
                    dependentes.splice(i, 1);  	
                carregarDependentes();
                });
            });
            }

            function adicionarDependentes(){
            dependentes.push({identificador:"", nome:"", idade: ""});
            carregarDependentes();
            travarOutros(document.querySelector("#dependentesContainer > div:last-child"));
            }
           
            function salvarDependentes(){
                    document.querySelectorAll("#dependentesContainer .salvar").forEach((el, i)=>{
                el.addEventListener("click", ()=>{
                let identificador = el.parentElement.parentElement.getAttribute("data-id");
                let nome = el.parentElement.parentElement.querySelector(".nome").value;
                let idade = el.parentElement.parentElement.querySelector(".idade").value;
                    
                if(!nome.length || !idade.length){
                    alert("Nome e idade precisam ser preenchidos para salvar.");
                    return false;
                }
                    dependentes.splice(i, 1, {identificador: identificador, nome: nome, idade: idade});
                carregarDependentes();
                travarOutros(false);
                });
            });
            }

            function travarOutros(element){
                if(element == false){
                document.querySelectorAll(".dependentes button, .dependentes .container > div").forEach((el)=>{
                    el.classList.remove("disabled");
                });
                document.querySelector("#containerDados").innerHTML = "";
                return false;
            }
            document.querySelectorAll(".dependentes button, .dependentes .container > div").forEach((el)=>{
                if(el != element){
                    el.classList.add("disabled");
                }
            });
            }

            //init
            document.querySelector("#btnAdicionarDependentes").addEventListener("click", adicionarDependentes);
            carregarDependentes();

            //capturarDados
            document.querySelector("#btnCapturarDados").addEventListener("click", ()=>{
                document.querySelector("#containerDados").innerHTML = JSON.stringify(dependentes, undefined, 4);
            }); **/
        };

        

               
            


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