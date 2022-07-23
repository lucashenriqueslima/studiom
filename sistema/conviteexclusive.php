<?php

include"../includes/conexao.php";


session_start();

if($_SESSION['id_formando'] == NULL) {

echo"<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";

} else {

$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
$res_cadastro = mysqli_query($con, $sql_cadastro);
$vetor_cadastro = mysqli_fetch_array($res_cadastro);

$id = $_GET['id'];

$sql_escolha = mysqli_query($con, "select * from convite_exclusive where id_formando = '$_SESSION[id_formando]' and id_exclusive = '$id'");
$vetor_escolha = mysqli_fetch_array($sql_escolha);

$sql_itens = mysqli_query($con, "select * from convite_exclusive_itens where id_exclusive = '$vetor_escolha[id_exclusive]' order by npagina ASC");

$sql_itens_finaliza = mysqli_query($con, "select * from convite_exclusive_itens where id_exclusive = '$vetor_escolha[id_exclusive]' and bloqueio <> '2' order by npagina ASC");

$sql_itens2 = mysqli_query($con, "select * from convite_exclusive_itens where id_exclusive = '$vetor_escolha[id_exclusive]' and status = '2' order by npagina ASC");

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

    <link href="../layout/assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../layout/dist/css/style.min.css" rel="stylesheet">

    <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
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
    <script type="text/javascript">
/* MÃ¡scaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
    return v;
}
function id( el ){
    return document.getElementById( el );
}
window.onload = function(){  
    id('telefone').onkeypress = function(){  
        mascara( this, mtel);  
    }
    id('telefone2').onkeypress = function(){  
        mascara( this, mtel);  
    }
}


</script>

<style type="text/css">

.thumbnail {
  position: relative;
  width: 150px;
  height: 150px;
  overflow: hidden;
}
.thumbnail img {
  position: absolute;
  left: 50%;
  top: 50%;
  height: 100%;
  width: auto;
  -webkit-transform: translate(-50%,-50%);
      -ms-transform: translate(-50%,-50%);
          transform: translate(-50%,-50%);
}
.thumbnail img.portrait {
  width: 100%;
  height: auto;
}

</style>

<script src="../sistema/ckeditor/ckeditor.js"></script>

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
                    <a class="navbar-brand" href="dashboard.php">
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
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>" alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $_SESSION['nome']; ?></h4>
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
                        <h4 class="page-title">Escolha de Fotos</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Convite Exclusive</li>
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
                                <h4 class="card-title">Convite</h4>

                                <div align="center" style="width: 100%; background-color: #fff;">

                                <?php

                                if(mysqli_num_rows($sql_itens) > 0) { 

                                while($vetor_item = mysqli_fetch_array($sql_itens)) { 

                                ?>

                                <div id="<?php echo $vetor_item['id_item']; ?>">

                                <script type="text/javascript">
                                <!--
                                function Mudarestado(el) {
                                  var display = document.getElementById(el).style.display;
                                  if (display == "none")
                                    document.getElementById(el).style.display = 'block';
                                  else
                                    document.getElementById(el).style.display = 'none';
                                }
                                // -->
                                </script>

                                <div id="Lamina-<?php echo $vetor_item['id_item']; ?>">

                                <input type="hidden" name="id_item[]" value="<?php echo $vetor_item['id_pagina']; ?>">

                                <table width="100%">
                                    <tr>
                                        <td valign="top">

                                            <h4>Lâmina N° <?php echo $vetor_item['npagina']; ?></h4>

                                            <br>

                                            <img src="../sistema/arquivos/<?php echo $vetor_item['imagem']; ?>" height="450px">

                                            <br>
                                            <br>

                                            <?php 

                                            if($vetor_item['bloqueio'] != '2') { 

                                            if($vetor_item['status'] == 1) { 

                                            ?>

                                            <button type="button" class="btn waves-effect waves-light btn-secondary" onclick="Mudarestado('minhaDivcad<?php echo $vetor_item[id_item]; ?>')">Selecionar Foto(s)</button>
                                            <br>
                                            <br>

                                            <div id="minhaDivcad<?php echo $vetor_item[id_item]; ?>" style="display:none; background-color: #E8E8E8;">

                                            <form action="recebe_escolhadefotoconviteexclusive.php?id=<?php echo $vetor_item[id_item]; ?>&id_convite=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" name="form<?php echo $vetor_item['id_item']; ?>">

                                                <br>

                                                <?php if($vetor_item['tipo'] == 2) { ?>

                                                
                                                <div class="container-fluid">

                                                    <div class="alert alert-danger" role="alert">
                                                        <div align="justify">Através do sistema disponibilizamos duas formas de escolher suas fotos de família. Caso tenha participado do Ensaio Foto de Família realizado pela Studio M e queira escolher apenas estas fotos, basta apenas indicar as fotografias a serem escolhidas conforme a quantidade estabelecida para o convite de formatura. Se não tiver participado do Ensaio Foto de Família conosco ou quiser apenas escolher suas fotos pessoais, basta apenas optar por selecionar seus arquivos em "arquivos pessoais". Agora se tiver participado do Ensaio foto de Convite e mesmo assim quiser também utilizar fotos do seu arquivo pessoal, você precisará fazer o upload destes arquivos, apenas através de "arquivo pessoal". Como fazer: Você deverá fazer o download destas fotos para seu computador através do botão de download ou clicar com o botão direito sobre a fotografia e "salvar como". A partir do momento em que estas fotografias estiverem em seu computador, você deverá juntá-las às suas fotos do arquivo pessoal e a partir deste momento, selecionar "arquivo pessoal" e fazer o upload de todas as fotos juntas para o sistema em "fotos de família". Este procedimento deverá ser realizado, pois o sistema não permite com que façamos a seleção destes arquivos de locais distintos para upload.</div>
                                                    </div>

                                                </div>

                                                <script type="text/javascript">
                                                    $(document).ready(function(){  
                                                    $("#palco<?php echo $vetor_item[id_item]; ?> > div").hide(); 
                                                    $("#tipobusca<?php echo $vetor_item[id_item]; ?>").change(function(){  
                                                            $("#palco<?php echo $vetor_item[id_item]; ?> > div").hide();  
                                                            $( '#'+$( this ).val() ).show('fast');  
                                                    }); 
                                                    
                                                    });

                                                    function duplicarCampos<?php echo $vetor_item[id_item]; ?>(){
                                                        var clone = document.getElementById('origem<?php echo $vetor_item[id_item]; ?>').cloneNode(true);
                                                        var destino = document.getElementById('destino<?php echo $vetor_item[id_item]; ?>');
                                                        destino.appendChild (clone);
                                                        var camposClonados = clone.getElementsByTagName('input');
                                                        for(i=0; i<camposClonados.length;i++){
                                                          camposClonados[i].value = '';
                                                        }
                                                      }
                                                      function removerCampos<?php echo $vetor_item[id_item]; ?>(id){
                                                        var node1 = document.getElementById('destino<?php echo $vetor_item[id_item]; ?>');
                                                        node1.removeChild(node1.childNodes[0]);
                                                      }

                                                </script>

                                                <table width="100%">
                                                    <tr>
                                                        <td width="1%"></td>
                                                        <td>

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                   <div class="form-group">
                                                                       <label>Tipo da Foto</label>
                                                                       <select name="upload" id="tipobusca<?php echo $vetor_item[id_item]; ?>" class="form-control">
                                                                    
                                                                       <option value="" selected="">Selecione...</option>
                                                                       <option value="2_<?php echo $vetor_item[id_item]; ?>">Arquivo pessoal</option>
                                                                       <option value="1_<?php echo $vetor_item[id_item]; ?>">Arquivo Studio M</option>
                                                                    
                                                                       </select>
                                                                    
                                                                    </div>
                                                                </div>              
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </table>

                                                <div id="palco<?php echo $vetor_item[id_item]; ?>">

                                                    <div id="2_<?php echo $vetor_item[id_item]; ?>">

                                                        <table width="100%">
                                                        <tr>
                                                            <td width="1%"></td>
                                                            <td>

                                                        <?php for($quantidade = 1; $quantidade <= $vetor_item['qtdfotos']; $quantidade++) { ?>

                                                            <div class="row">

                                                              <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                  <label class="form-label semibold" for="exampleInput">Selecione a Foto</label>
                                                                  <input type="file" name="imagem_up[]" class="form-control">
                                                                </fieldset>
                                                              </div>

                                                            </div>

                                                        <?php } ?>

                                                        

                                                        </td>
                                                    </tr>
                                                </table> 

                                                    </div>

                                                    <div id="1_<?php echo $vetor_item[id_item]; ?>">

                                                <table width="100%">

                                                    <tr>

                                                    <td width="1%"></td>
                                                    <td>

                                                    <div class="row">

                                                              <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                  <select name="preeventos" id="preeventos<?php echo $vetor_item[id_item]; ?>" class="form-control" onchange="myFunction()">
                                                                        <option value="" selected="selected">Selecione...</option>
                                                                        <?php 

                                                                        $sql_eventos = mysqli_query($con, "SELECT * FROM eventosformando WHERE id_formando = '$vetor_cadastro[id_formando]' and (titulo = 'Ensaio - Fotos de Família' OR titulo = 'Ensaio - Fotos de Convite') order by id_evento DESC");

                                                                        while ($vetor_eventos=mysqli_fetch_array($sql_eventos)) { 

                                                                        $sql_eventos_turma = mysqli_query($con, "select * from eventos_turma where id_evento = '$vetor_eventos[id_evento_turma]'");
                                                                        $vetor_eventos_turma = mysqli_fetch_array($sql_eventos_turma);


                                                                        ?>
                                                                        <option value="<?php echo $vetor_eventos['id_evento']; ?>_<?php echo $vetor_item['id_item']; ?>"><?php echo $vetor_eventos['titulo'] ?></option>
                                                                        <?php } ?>
                                                                      </select>
                                                                </fieldset>
                                                              </div>
                                                    </div>

                                                    </td>

                                                    </tr>

                                                    </table>

                                                    <script type="text/javascript">
                                                          var CheckMaximo<?php echo $vetor_item['id_item']; ?> = <?php echo $vetor_item['qtdfotos']; ?>;



                                                          function verificar<?php echo $vetor_item['id_item']; ?>() {
                                                          var Marcados = 1;
                                                          var objCheck = document.forms['form<?php echo $vetor_item['id_item']; ?>'].elements['imagem'];

                                                          //Percorrendo os checks para ver quantos foram selecionados:
                                                          for (var iLoop=0; iLoop<objCheck.length; iLoop++) {
                                                          //Se o número máximo de checkboxes ainda não tiver sido atingido, continua a verificação:
                                                            if (objCheck[iLoop].checked) {
                                                                Marcados++;
                                                            }
                                                            
                                                            if (Marcados <= CheckMaximo<?php echo $vetor_item['id_item']; ?>) {
                                                            //Habilitando todos os checkboxes, pois o máximo ainda não foi alcançado.
                                                              for (var i=0; i<objCheck.length; i++) {
                                                                objCheck[i].disabled = false;
                                                              }       
                                                              //Caso contrário, desabilitar o checkbox;
                                                              //Nesse caso, é necessário percorrer todas as opções novamente, desabilitando as não checadas;
                                                              
                                                            } else {
                                                              for (var i=0; i<objCheck.length; i++) {
                                                                if(objCheck[i].checked == false) {
                                                                  objCheck[i].disabled = true;
                                                                }       
                                                                }
                                                              }
                                                          }
                                                          }
                                                    </script>

                                                                <div class="row">
                                                                <div class="col-md-12">
                                                                <div id="resultado<?php echo $vetor_item[id_item]; ?>" style="margin-left: 1%; float: center; width: 800px;"></div>
                                                                </div>
                                                                </div>

                                                                <script type="text/javascript">
                                                                
                                                                //Fica monitorando o evento 'change' do id=cursos, ao ocorrer este evento é disparado a função
                                                                document.getElementById('preeventos<?php echo $vetor_item[id_item]; ?>').addEventListener('change', function() {
                                                                    //Caso queira passar mais de fique com o exemplo abaixo:
                                                                    //var params = "lorem=ipsum&name=binny"; 
                                                                    
                                                                    //Porem só precisamos passar o value do 'cursos'
                                                                    var params = "preeventos=" + document.getElementById('preeventos<?php echo $vetor_item[id_item]; ?>').value;
                                                                    
                                                                    var ajax = new XMLHttpRequest();
                                                                    ajax.open('POST', 'selecionaeventoescolha_qtd.php', true);
                                                                    ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                                                    ajax.send(params);
                                                                        
                                                                    ajax.onreadystatechange = function() {
                                                                        if(ajax.readyState == 4 && ajax.status == 200) {
                                                                            document.getElementById('resultado<?php echo $vetor_item[id_item]; ?>').innerHTML = ajax.responseText;
                                                                        }
                                                                    }
                                                                });
                                                            
                                                                </script>

                                                    </div>

                                                    </div>

                                                    <?php } else { ?>

                                                    <table width="100%">

                                                    <tr>

                                                    <td width="1%"></td>
                                                    <td>

                                                    <div class="row">

                                                              <div class="col-lg-3">
                                                                <fieldset class="form-group">
                                                                  <select name="preeventos" id="preeventos<?php echo $vetor_item[id_item]; ?>" class="form-control" onchange="myFunction()">
                                                                        <option value="" selected="selected">Selecione...</option>
                                                                        <?php 

                                                                        $sql_eventos = mysqli_query($con, "SELECT * FROM eventosformando WHERE id_formando = '$vetor_cadastro[id_formando]' and (titulo = 'Ensaio - Fotos de Família' OR titulo = 'Ensaio - Fotos de Convite') order by id_evento DESC");

                                                                        while ($vetor_eventos=mysqli_fetch_array($sql_eventos)) { 

                                                                        $sql_eventos_turma = mysqli_query($con, "select * from eventos_turma where id_evento = '$vetor_eventos[id_evento_turma]'");
                                                                        $vetor_eventos_turma = mysqli_fetch_array($sql_eventos_turma);

                                                                        ?>
                                                                        <option value="<?php echo $vetor_eventos['id_evento']; ?>_<?php echo $vetor_item['id_item']; ?>"><?php echo $vetor_eventos['titulo'] ?></option>
                                                                        <?php } ?>
                                                                      </select>
                                                                </fieldset>
                                                              </div>
                                                    </div>

                                                    </td>

                                                    </tr>

                                                    </table>

                                                    <script type="text/javascript">
                                                          var CheckMaximo<?php echo $vetor_item['id_item']; ?> = <?php echo $vetor_item['qtdfotos']; ?>;



                                                          function verificar<?php echo $vetor_item['id_item']; ?>() {
                                                          var Marcados = 1;
                                                          var objCheck = document.forms['form<?php echo $vetor_item['id_item']; ?>'].elements['imagem<?php echo $id_item; ?>'];

                                                          //Percorrendo os checks para ver quantos foram selecionados:
                                                          for (var iLoop=0; iLoop<objCheck.length; iLoop++) {
                                                          //Se o número máximo de checkboxes ainda não tiver sido atingido, continua a verificação:
                                                            if (objCheck[iLoop].checked) {
                                                                Marcados++;
                                                            }
                                                            
                                                            if (Marcados <= CheckMaximo<?php echo $vetor_item['id_item']; ?>) {
                                                            //Habilitando todos os checkboxes, pois o máximo ainda não foi alcançado.
                                                              for (var i=0; i<objCheck.length; i++) {
                                                                objCheck[i].disabled = false;
                                                              }       
                                                              //Caso contrário, desabilitar o checkbox;
                                                              //Nesse caso, é necessário percorrer todas as opções novamente, desabilitando as não checadas;
                                                              
                                                            } else {
                                                              for (var i=0; i<objCheck.length; i++) {
                                                                if(objCheck[i].checked == false) {
                                                                  objCheck[i].disabled = true;
                                                                }       
                                                                }
                                                              }
                                                          }
                                                          }
                                                    </script>

                                                                <div class="row">
                                                                <div class="col-md-12">
                                                                <div id="resultado<?php echo $vetor_item[id_item]; ?>" style="margin-left: 1%; float: center; width: 800px;"></div>
                                                                </div>
                                                                </div>

                                                                <script type="text/javascript">
                                                                
                                                                //Fica monitorando o evento 'change' do id=cursos, ao ocorrer este evento é disparado a função
                                                                document.getElementById('preeventos<?php echo $vetor_item[id_item]; ?>').addEventListener('change', function() {
                                                                    //Caso queira passar mais de fique com o exemplo abaixo:
                                                                    //var params = "lorem=ipsum&name=binny"; 
                                                                    
                                                                    //Porem só precisamos passar o value do 'cursos'
                                                                    var params = "preeventos=" + document.getElementById('preeventos<?php echo $vetor_item[id_item]; ?>').value;
                                                                    
                                                                    var ajax = new XMLHttpRequest();
                                                                    ajax.open('POST', 'selecionaeventoescolha_qtd.php', true);
                                                                    ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                                                    ajax.send(params);
                                                                        
                                                                    ajax.onreadystatechange = function() {
                                                                        if(ajax.readyState == 4 && ajax.status == 200) {
                                                                            document.getElementById('resultado<?php echo $vetor_item[id_item]; ?>').innerHTML = ajax.responseText;
                                                                        }
                                                                    }
                                                                });
                                                            
                                                                </script>

                                                    <?php } ?>

                                                    <?php if($vetor_escolha['status'] != 4) { ?>

                                                    <table width="100%">
                                                        <tr>
                                                            <td width="1%"></td>
                                                            <td>
                                                                
                                                                <div class="row">
                                                                <div class="col-md-12">
                                                                  <div class="form-group">
                                                                        <label>Observações</label>
                                                                        <textarea name="observacoes" class="form-control"><?php echo $vetor['observacoes']; ?></textarea>
                                                                  </div>
                                                                  </div>
                                                                </div>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td><button type="submit" class="btn btn-primary"  style="    float: left;">Salvar Escolha(s)</button></td>
                                                        </tr>
                                                    </table>

                                                    <?php } ?>

                                                    </form>

                                                    <br>

                                                    </div>

                                            </div>
                                            
                                            <?php } else { ?>

                                            <button type="button" class="btn btn-primary" onclick="Mudarestado('minhaDivfotos<?php echo $vetor_item[id_item]; ?>')">Mostrar Foto(s) Cadastradas</button>
                                            <br>
                                            <br>
                                            <div id="minhaDivfotos<?php echo $vetor_item[id_item]; ?>"  style="display:none; overflow-y: scroll; background-color: #E8E8E8;">

                                                <div class="table-responsive">
                                                <table class="table">
                                                <tbody>
                                                <tr>

                                                <?php 

                                                $sql_fotos_cadastradas = mysqli_query($con, "select * from convite_exclusive_escolhidas where id_exclusive = '$vetor_item[id_item]'");

                                                while($vetor_fotos_cadastradas = mysqli_fetch_array($sql_fotos_cadastradas)){ 

                                                ?>

                                                <td>

                                                <?php if($vetor_fotos_cadastradas['tipo'] == 2) { ?>

                                                <div class="thumbnail">


                                                <a class="image-popup-vertical-fit" href="../sistema/arquivos/<?php echo $vetor_fotos_cadastradas['foto']; ?>"><img alt="" src="../sistema/arquivos/<?php echo $vetor_fotos_cadastradas['foto']; ?>" /></a>

                                                </div>

                                                <?php } else { ?>

                                                <div class="thumbnail">


                                                <a class="image-popup-vertical-fit" href="<?php echo $vetor_fotos_cadastradas['foto']; ?>"><img alt="" src="<?php echo $vetor_fotos_cadastradas['foto']; ?>" /></a>

                                                </div>

                                                <?php } ?>
                                                                
                                                </td>

                                                <?php } ?>

                                                </tr>
                                                </tbody>
                                                </table>
                                                <table class="table">
                                                    <tr>
                                                        <td>Observações: <?php echo $vetor_item['observacoes']; ?></td>
                                                    </tr>
                                                </table>

                                                <br>

                                                <?php if($vetor_escolha['status'] != 4) { ?>

                                                <a href="excluirescolhasconviteexclusive.php?id=<?php echo $vetor_item[id_item]; ?>&id_convite=<?php echo $id; ?>"><button type="button" class="btn btn-danger"  style="    float: left;">Excluir Escolha(s)</button></a>

                                                <?php } ?>

                                                </div>

                                                

                                            </div>

                                            <?php } } ?>

                                        </td>
                                        
                                    </tr>
                                </table>

                                <br>

                                </div>

                                </div>

                                <?php } ?>

                                <div style="background: #ffffff">

                                <br>



                                <?php 

                                if($vetor_aprovacao['datafinal'] < $dataatual) {

                                if(mysqli_num_rows($sql_itens_finaliza) == mysqli_num_rows($sql_itens2) && $vetor_escolha['status'] != 4) { 

                                ?>

                                <table width="100%">
                                    <tr>
                                        <td><div class="alert alert-danger" role="alert">
                                                Caro(a) Formando(a), antes de finalizar a (s) escolha (s) favor confirme se foram realizadas em todas lâminas.
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><a href="finalizarescolhasconviteexclusive.php?id_escolha=<?php echo $vetor_escolha['id_exclusive']; ?>"><button type="button" class="btn btn-success" >Finalizar Escolha(s)</button></a></td>
                                    </tr>
                                </table>

                                <?php } } } ?>

                                <br>
                                <br>

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

    <script src="../layout/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="../layout/assets/libs/magnific-popup/meg.init.js"></script>

</body>

</html>
<?php } ?>