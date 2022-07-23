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
                                    
                                        

                                           
                                        
                                        
                                        <input id="jantardospaisinput" type="hidden" value="<?php echo $vetor['jantardospais']; ?>">
                                        <input id="colacaograuinput" type="hidden" value="<?php echo $vetor['colacaograu']; ?>"> 
                                        <input id="cultoecumenicoinput" type="hidden" value="<?php echo $vetor['cultoecumenico']; ?>">
                                        <input id="bailedeformaturainput" type="hidden" value="<?php echo $vetor['bailedeformatura']; ?>">                                               
                                                                                                                   
                                            
                                            <div id="divEvento" class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <?php 
                                                            include "adicionarEvento.php";       
                                                        ?>
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->

                                <form action="recebe_dadosconvite.php" method="post" name="cliente" enctype="multipart/form-data" onSubmit="return verificarCPF()" id="formID">
                                <div class="row">

                                <div class="col-lg-12">
                                    <fieldset class="form-group">
                                        <label class="form-label semibold"
                                            for="exampleInput">Eventos</label>
                                        
                                        <select id="categorias" name="id_categoria" class="form-control" onchange="myFunction(this.value)">
                                            <option value="" selected="selected">Selecione...</option>
                                                                                                <?php
                                                                                                $sql_evento = mysqli_query($con, "select * from categoriaevento order by nome ASC");
                                                                                                while ($vetor_evento = mysqli_fetch_array($sql_evento)) {
                                                                                                    ?>
                                            <option value="<?php echo $vetor_evento['id_categoria']; ?>" ><?php echo $vetor_evento['nome'] ?></option>
                                                                                                <?php } ?>
                                        </select>
                                        
                                    </fieldset>
                                </div>

                                </div>     
                                <div id="origem">
                                            
                                            <div id="divMostraEventoJantardospais" class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                            
                                                        <textarea name="jantardospais" class="form-control"><?php echo $vetor['jantardospais']; ?></textarea>
                                                            
                                                        
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->
                                            <div id="divMostraEventoColacaograu" class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                            
                                                        <textarea name="colacaograu" class="form-control"><?php echo $vetor['colacaograu']; ?></textarea>
                                                            
                                                        
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->
                                            <div id="divMostraEventoCultoecumenico" class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                            
                                                        <textarea name="colacaograu" class="form-control"><?php echo $vetor['cultoecumenico']; ?></textarea>
                                                            
                                                        
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->
                                            <div id="divMostraEventoBailedeformatura" class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                            
                                                        <textarea name="colacaograu" class="form-control"><?php echo $vetor['bailedeformatura']; ?></textarea>
                                                            
                                                        
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->
                                            
                                                                                                                
                                        </div>

                                        <div id="destino">
                                        </div>
                                        <br>
                                        <input type="button" value="Adicionar Evento" onclick="duplicarCampos();"
                                            class="btn btn-warning">
                                        <input type="button" value="Excluir Evento" onclick="removerCampos(this);"
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
                                                <textarea name="mensageminicial"
                                                        class="form-control"><?php echo $vetor['mensageminicial']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <br>

                                    <h5>HOMENAGEADOS</h5>

                                    <br>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Patrono /
                                                    Patronesse</label>
                                                <textarea name="patrono"
                                                        class="form-control"><?php echo $vetor['patrono']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Paraninfo (a)</label>
                                                <textarea name="parainfo"
                                                        class="form-control"><?php echo $vetor['parainfo']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Professores
                                                    Homenageados</label>
                                                <textarea name="professores"
                                                        class="form-control"><?php echo $vetor['professores']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Nome da Turma</label>
                                                <input type="text" name="nometurma" class="form-control"
                                                    value="<?php echo $vetor['nometurma']; ?>">
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <br>

                                    <h5>AGRADECIMENTOS / MENSAGENS</h5>

                                    <br>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">A Deus</label>
                                                <textarea name="adeus"
                                                        class="form-control"><?php echo $vetor['adeus']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos Pais</label>
                                                <textarea name="aospais"
                                                        class="form-control"><?php echo $vetor['aospais']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos Pais
                                                    Ausentes</label>
                                                <textarea name="aospaisausentes"
                                                        class="form-control"><?php echo $vetor['aospaisausentes']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">À Família</label>
                                                <textarea name="afamilia"
                                                        class="form-control"><?php echo $vetor['afamilia']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos que Amamos</label>
                                                <textarea name="aosqueamamos"
                                                        class="form-control"><?php echo $vetor['aosqueamamos']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos Amigos</label>
                                                <textarea name="aosamigos"
                                                        class="form-control"><?php echo $vetor['aosamigos']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos Mestres</label>
                                                <textarea name="aosmestres"
                                                        class="form-control"><?php echo $vetor['aosmestres']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos
                                                    Funcionários</label>
                                                <textarea name="aosfuncionarios"
                                                        class="form-control"><?php echo $vetor['aosfuncionarios']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Aos Pacientes
                                                    (Medicina)</label>
                                                <textarea name="aospacientes"
                                                        class="form-control"><?php echo $vetor['aospacientes']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Ao Cadáver
                                                    Desconhecido (Medicina)</label>
                                                <textarea name="aocadaver"
                                                        class="form-control"><?php echo $vetor['aocadaver']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Juramento</label>
                                                <textarea name="juramento"
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
                                                <textarea name="mensagemcomissao"
                                                        class="form-control"><?php echo $vetor['mensagemcomissao']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Mensagem Final</label>
                                                <textarea name="mensagemfinal"
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
                                                <?php if ($vetor['empresafotografica'] == NULL) { ?>
                                                    <input type="file" name="empresafotografica">
                                                <?php } else { ?>
                                                    <img src="../sistema/arquivos/<?php echo $vetor['empresafotografica']; ?>">
                                                <?php } ?>
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
        function myFunction(val) {
                                                                                            
            evento_selecionadojss = val;
            //console.log(val);
            console.log(evento_selecionadojss);
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
            
            
        }

        
    </script> 
    <script>
         $(document).ready(function(){
             
            $("#localizacao").hide();
            $("#divEvento").hide();
            $("#divMostraEventoColacaograu").hide();
            $("#divMostraEventoJantardospais").hide();
            $("#divMostraEventoCultoecumenico").hide();
            $("#divMostraEventoBailedeformatura").hide();

            $("#localizacaoBtn").click(function(){
                $("#localizacao").show();
                document.getElementById("localizacao").scrollIntoView(true);
            })
            $("#cadastrarLocalizacao").click(function(){
                $("#localizacao").hide();
            })
            
        });
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