<?php

    include"../includes/conexao.php";

     
     session_start();

    if($_SESSION['id'] == NULL) {
    
    echo"<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
    
    } else {
        
    $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);

    $id = $_GET['id'];
    $sql = mysqli_query($con, "select * from orcamento_convite where id_orcamento = '$id'");
    $vetor = mysqli_fetch_array($sql);

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

$(document).ready(function(){  
        $("#palco > div").hide();  
        $("#produto").change(function(){  
                $("#palco > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
        $("#palco1 > div").hide(); 
        $("#tipobusca").change(function(){  
                $("#palco1 > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
        $("#palco2 > div").hide(); 
        $("#tipobusca1").change(function(){  
                $("#palco2 > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        });
        $("#palco3 > div").hide(); 
        $("#tipobusca2").change(function(){  
                $("#palco3 > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        });
        $("input[name='rd-sexo']").click(function(){  
                $("#palco > div").hide();  
                $( '#'+$( this ).val() ).show('fast');    
        });  
});

function duplicarCampos(){
            var clone = document.getElementById('origem').cloneNode(true);
            var destino = document.getElementById('destino');
            destino.appendChild (clone);
            var camposClonados = clone.getElementsByTagName('input');
            for(i=0; i<camposClonados.length;i++){
              camposClonados[i].value = '';
            }
          }
          function removerCampos(id){
            var node1 = document.getElementById('destino');
            node1.removeChild(node1.childNodes[0]);
          }

          function duplicarCampos1(){
            var clone1 = document.getElementById('origem1').cloneNode(true);
            var destino1 = document.getElementById('destino1');
            destino1.appendChild (clone1);
            var camposClonados1 = clone1.getElementsByTagName('input');
            for(i=0; i<camposClonados1.length;i++){
              camposClonados1[i].value = '';
            }
          }
          function removerCampos1(id){
            var node1 = document.getElementById('destino1');
            node1.removeChild(node1.childNodes[0]);
          }

          function duplicarCampos2(){
            var clone2 = document.getElementById('origem2').cloneNode(true);
            var destino2 = document.getElementById('destino2');
            destino2.appendChild (clone2);
            var camposClonados2 = clone2.getElementsByTagName('input');
            for(i=0; i<camposClonados2.length;i++){
              camposClonados2[i].value = '';
            }
          }
          function removerCampos2(id){
            var node2 = document.getElementById('destino2');
            node2.removeChild(node2.childNodes[0]);
          }
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
                        <h4 class="page-title">Comercial</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Orçamentos Convite</li>
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
                                <h4 class="card-title">Cadastro de Orçamento Convite</h4>

                                <form action="recebe_alterarorcconvite.php?id=<?php echo $id; ?>" method="post" name="cliente" enctype="multipart/form-data" onSubmit="return verificarCPF()" id="formID">
                    
                                <div class="row">
                                            
                                  <?php if($vetor['tipo'] == 1) { ?>

                                  <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Oportunidade</label>
                                                    <select name="id_oportunidade" class="form-control" required="">
                                          
                                          <option value="" selected="">Selecione...</option>

                                          <?php

                                          $sql_oportunidades = mysqli_query($con, "select * from oportunidades where negociacao = '1' order by id_oportunidade DESC");

                                          while($vetor_oportunidade = mysqli_fetch_array($sql_oportunidades)) { 

                                          $sql_mkt = mysqli_query($con, "select * from prospeccoes where id_prospeccao = '$vetor_oportunidade[id_prospeccao]'");
                                          $vetor_prospeccao = mysqli_fetch_array($sql_mkt);

                                          $sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '$vetor_prospeccao[id_turma]'");
                                          $vetor_turma = mysqli_fetch_array($sql_turma);

                                          $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[id_curso]'");
                                          $vetor_curso = mysqli_fetch_array($sql_curso);

                                          $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
                                          $vetor_instituicao = mysqli_fetch_array($sql_instituicao);

                                          ?>

                                          <option value="<?php echo $vetor_oportunidade['id_oportunidade']; ?>" <?php if (strcasecmp($vetor['id_oportunidade'], $vetor_oportunidade['id_oportunidade']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_oportunidade['id_oportunidade']; ?> - <?php echo $vetor_curso['nome']; ?> / <?php echo $vetor_curso['sigla']; ?> / <?php echo $vetor_turma['conclusao']; ?>-<?php echo $vetor_turma['semestre']; ?></option>

                                          <?php } ?>

                                      </select>
                                                </fieldset>
                                            </div>

                                  <?php } if($vetor['tipo'] == 2) { ?>

                                  <div class="col-lg-4">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Contrato</label>
                                      <select name="id_oportunidade" id="turmas" class="form-control">
                                            <option value="" selected="selected">Selecione...</option>
                                            <?php 

                                            $sql_cursos = mysqli_query($con, "select * from turmas order by nome ASC");

                                            while ($vetor_curso=mysqli_fetch_array($sql_cursos)) { 

                                            $sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
                                            $vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

                                            $sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_curso[curso]'");
                                            $vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);


                                            ?>
                                            <option value="<?php echo $vetor_curso['id_turma']; ?>" <?php if (strcasecmp($vetor['id_oportunidade'], $vetor_curso['id_turma']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_curso['ncontrato'] ?> - <?php echo $vetor_curso['nome'] ?> <?php echo $vetor_curso['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?></option>
                                            <?php } ?>
                                          </select>
                                    </fieldset>
                                  </div>

                                  <?php } ?>

                                  <div class="col-lg-4">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Qtd de Formandos</label>
                                      <input type="number" name="qtdformandos" class="form-control" value="<?php echo $vetor['qtdformandos']; ?>" id="exampleInput" placeholder="Digite a Quantidade" required>
                                    </fieldset>
                                  </div>

                                  <div class="col-lg-4">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Valor Total Orçamento</label>
                                      <input type="text" name="valoratual" class="form-control" value="<?php echo $num = number_format($vetor['valortotal'],2,',','.'); ?>" id="exampleInput" disabled>
                                    </fieldset>
                                  </div>

                                        </div><!--.row-->

                                <div class="row">

                                <div class="col-lg-6">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Job</label>
                                      <select name="id_job" class="form-control">
                                        <option value="" selected="">Selecione...</option>
                                        <option value="5" <?php if (strcasecmp($vetor['id_job'], '5') == 0) : ?>selected="selected"<?php endif; ?>>Convite - Foto Studio M</option>
                                        <option value="6" <?php if (strcasecmp($vetor['id_job'], '6') == 0) : ?>selected="selected"<?php endif; ?>>Convite - Foto Empresa Terceira</option>
                                      </select>
                                    </fieldset>
                                  </div>

                                </div>

                                <div class="row">

                                  <div class="col-lg-6">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Tipo de Convite</label>
                                      <select name="id_produto" id="tipo" class="form-control">
                                            <option value="" selected="selected">Selecione...</option>
                                            <option value="2">Super Luxo</option>
                                            <option value="4">Simples</option>
                                          </select>
                                    </fieldset>
                                  </div>

                                </div><!--.row-->

                                <div id="palco">

                                  <div id="2">

                                    <div class="row">

                                      <div class="col-lg-6">
                                        <fieldset class="form-group">
                                          <label class="form-label semibold" for="exampleInput">Quantidade</label>
                                          <input type="number" name="qtdconvites" class="form-control">
                                        </fieldset>
                                      </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Tamanho</label>
                                          <select name="tamanho" id="tamanhos" class="form-control">
                                            <option value="">Escolha o Tipo de Convite</option>
                                          </select>
                                        </div>
                                      </div>

                                    </div>

                                    <h3>Embalagem do Convite</h3>

                                    <hr>

                                    <div class="row">

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Tipo de Embalagem</label>
                                          <select name="tipoembalagem" id="tipoembalagem" class="form-control">
                                            <option value="" selected="">Selecione...</option>
                                            <option value="1">Envelope</option>
                                            <option value="2">Caixa</option>
                                          </select>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Embalagem</label>
                                          <select name="embalagem" id="embalagens" class="form-control">
                                            <option value="">Escolha o Tamanho</option>
                                          </select>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Acabamento Interno da Embalagem</label>
                                          <select name="acabamentoembalagem[]" multiple="" id="acabamentoembalagens" class="form-control select2">
                                            <option value="">Escolha o Tamanho</option>
                                          </select>
                                        </div>
                                      </div>

                                    </div>

                                    <div class="row">

                                      <div class="col-md-6">
                                        <div class="form-group">

                                          <label>Acabamento Externo da Embalagem</label>

                                          <select name="acabamentoexternoembalagem[]" multiple="" class="form-control select2">
                                            <?php

                                            $sql_acabamento_externo = mysqli_query($con, "select DISTINCT(id_itemtabela) from tabela_basico_acabamentos where acabamentoembalagem = '2' order by id_item ASC");

                                            while($vetor_acabamento_externo = mysqli_fetch_array($sql_acabamento_externo)) {

                                            $sql_tipo = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_acabamento_externo[id_itemtabela]'");
                                            $vetor_tipo = mysqli_fetch_array($sql_tipo);

                                            ?>
                                            <option value="<?php echo $vetor_acabamento_externo['id_itemtabela']; ?>"><?php echo $vetor_tipo['titulo']; ?></option>
                                            <?php } ?>
                                          </select>

                                        </div>
                                      </div>

                                    </div>

                                    <h3>Convite</h3>

                                    <hr>

                                    <div class="row">

                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Capa</label>
                                          <select name="capa" id="capa" class="form-control">
                                            <option value="">Escolha o Tamanho</option>
                                          </select>
                                        </div>
                                      </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Acabamento da Capa</label>
                                          <select name="acabamentocapa[]" multiple="" id="acabamentocapa" class="form-control select2">
                                            <?php

                                            $sql_acabamento_capa = mysqli_query($con, "select DISTINCT(id_itemtabela) from tabela_basico_acabamentos where acabamentodacapa = '2' order by id_item ASC");

                                            while($vetor_acabamento_capa = mysqli_fetch_array($sql_acabamento_capa)) {

                                            $sql_tipo1 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_acabamento_capa[id_itemtabela]'");
                                            $vetor_tipo1 = mysqli_fetch_array($sql_tipo1);

                                            ?>
                                            <option value="<?php echo $vetor_acabamento_capa['id_itemtabela']; ?>"><?php echo $vetor_tipo1['titulo']; ?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                      </div>

                                    </div>

                                    <div class="row">

                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Sobrecapa/Encarte</label>
                                          <select name="sobrecapaencarte" id="sobrecapaencarte" class="form-control">
                                            <option value="">Escolha o Tamanho</option>
                                          </select>
                                        </div>
                                      </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Personalizada </label>
                                          <select name="personalizada" class="form-control">
                                            <option value="" selected="">Selecione...</option>
                                            <option value="1">Sim</option>
                                            <option value="2">Não</option>
                                          </select>
                                        </div>
                                      </div>

                                    </div>

                                    <h3>Componentes Padrão do Miolo</h3>

                                    <hr>

                                    <div class="row">
                                      
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          
                                          <table width="60%" class="table table-bordered table-striped">
                                            <tr>
                                              <td  width="10%"><strong>Check</strong></td>
                                              <td><strong>Itens</strong></td>
                                              <td><strong>Papel (Cadastrar)</strong></td>
                                              <td width="15%"><strong>Quant.</strong></td>
                                            </tr>
                                            <tr>
                                              <td><input type="checkbox" name="capabloco" checked=""></td>
                                              <td>Capa do Bloco (Capa Mole)</td>
                                              <td>Couchê Fosco 250g</td>
                                              <td>
                                                <select name="qtdcapabloco" id="qtdcapabloco" class="form-control">
                                                  <option value="1">1</option>
                                                </select>
                                            </tr>
                                            <tr>
                                              <td><input type="checkbox" name="paginaspadrao" checked=""></td>
                                              <td>Páginas Padrão</td>
                                              <td>Couchê Fosco 170g</td>
                                              <td>
                                                <select name="qtdpaginaspadrao" id="qtdpaginaspadrao" class="form-control">
                                                </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td><input type="checkbox" name="paginaspersonalizadas" checked=""></td>
                                              <td>Páginas Personalizadas</td>
                                              <td>Couchê Fosco 170g</td>
                                              <td>
                                                <select name="qtdpaginaspersonalizadas" id="qtdpaginaspersonalizadas" class="form-control">
                                                </select>
                                            </tr>
                                            
                                          </table>

                                        </div>
                                      </div>

                                    </div>

                                    <h3>Componentes Extras do Miolo</h3>

                                    <hr>

                                    <div class="row">
                                      
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          
                                          <table width="60%" class="table table-bordered table-striped">
                                            <tr>
                                              <td  width="10%"><strong>Check</strong></td>
                                              <td><strong>Itens</strong></td>
                                              <td><strong>Papel (Cadastrar)</strong></td>
                                              <td width="15%"><strong>Quant.</strong></td>
                                            </tr>

                                            <tr>
                                              <td><input type="checkbox" name="paginasextras" value="34"></td>
                                              <td>Páginas Extras</td>
                                              <td>Couchê Fosco 170g</td>
                                              <td><input type="number" name="qtdpaginasextras" class="form-control"></td>
                                            </tr>
                                            <tr>
                                              <td><input type="checkbox" name="paginasextraspersonalizadas" value="75"></td>
                                              <td>Páginas Extras Personalizadas</td>
                                              <td>Couchê Fosco 170g</td>
                                              <td><input type="number" name="qtdpaginasextraspersonalizadas" class="form-control"></td>
                                            </tr>
                                            <tr>
                                              <td><input type="checkbox" name="miniposter" value="36"></td>
                                              <td>Mini Poster</td>
                                              <td>Couchê Fosco 170g</td>
                                              <td><input type="number" name="qtdminiposter" class="form-control"></td>
                                            </tr>
                                            <tr>
                                              <td><input type="checkbox" name="vegetalcomum" value="37"></td>
                                              <td>Página Vegetal Comum</td>
                                              <td>Vegetal 90g</td>
                                              <td><input type="number" name="qtdvegetalcomum" class="form-control"></td>
                                            </tr>
                                            <tr>
                                              <td><input type="checkbox" name="vegetalpersonalizado" value="38"></td>
                                              <td>Página Vegetal Personalizado</td>
                                              <td>Vegetal 90g</td>
                                              <td><input type="number" name="qtdvegetalpersonalizado" class="form-control"></td>
                                            </tr>
                                            <tr>
                                              <td><input type="checkbox" name="acetatocomum" value="71"></td>
                                              <td>Página Transparência Comum</td>
                                              <td>Acetato transparente</td>
                                              <td><input type="number" name="qtdacetatocomum" class="form-control"></td>
                                            </tr>
                                            <tr>
                                              <td><input type="checkbox" name="acetatopersonalizado" value="72"></td>
                                              <td>Página Transparência Personalizado</td>
                                              <td>Acetato transparente</td>
                                              <td><input type="number" name="qtdacetatopersonalizado" class="form-control"></td>
                                            </tr>
                                            </table>

                                        </div>
                                      </div>

                                    </div>

                                    <hr>

                                  </div>

                                  <div id="4">

                                    <div class="row">

                                      <div class="col-lg-4">
                                        <fieldset class="form-group">
                                          <label class="form-label semibold" for="exampleInput">Quantidade</label>
                                          <input type="number" name="qtdconvites1" class="form-control">
                                        </fieldset>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Tamanho</label>
                                          <select name="tamanho1" id="tamanhos1" class="form-control">
                                            <option value="">Escolha o Tipo de Convite</option>
                                          </select>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Embalagem</label>
                                          <select name="embalagem1" id="embalagens1" class="form-control">
                                            <option value="">Escolha o Tamanho</option>
                                          </select>
                                        </div>
                                      </div>

                                    </div>

                                    <div class="row">

                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Acabamento da Embalagem</label>
                                          <select name="acabamentoembalagem1[]" multiple="" id="acabamentoembalagens1" class="form-control select2">
                                            <option value="">Escolha o Tamanho</option>
                                          </select>
                                        </div>
                                      </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Páginas (capas e contracapas inclusas)</label>
                                          <select name="paginas" id="paginas" class="form-control">
                                            <option value="">Escolha o Tamanho</option>
                                          </select>
                                        </div>
                                      </div>

                                    </div>

                                  </div>

                                </div>

                                <div class="row">

                                  <div class="col-lg-6">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Data Entrega dos Convites</label>
                                      <input type="date" name="dataentrega" class="form-control" value="<?php echo $vetor['dataentrega']; ?>" id="exampleInput">
                                    </fieldset>
                                  </div>

                                </div>

                                <hr>

                                <h3>Convites Extras</h3>
                                
                                <div id="origem">

                                <div class="row">

                                  <div class="col-lg-4">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Destino Convite Extra</label>
                                      <select name="tipo[]" class="form-control">
                                        <option selected="" value="">Selecione...</option>
                                        <option value="1">Comissão de Formatura</option>
                                        <option value="2">Mesa Diretiva</option>
                                      </select>
                                    </fieldset>
                                  </div>

                                  <div class="col-lg-4">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Tipo de Convite</label>
                                      <select name="tipoconvite[]" class="form-control">
                                        <option value="" selected="">Selecione...</option>
                                        <?php

                                        $sql_produto_convite = mysqli_query($con, "select * from orcamento_produto WHERE id_orcamento = '$id' order by id_item ASC");

                                        while($vetor_produto_convite = mysqli_fetch_array($sql_produto_convite)) {

                                        $sql_produto_nome = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_produto_convite[id_produto]'");
                                        $vetor_produto_nome = mysqli_fetch_array($sql_produto_nome);

                                        $sql_tamanho1 = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produto_convite[id_item]' and id_tipo = '1'");
                                        $vetor_tamanho1 = mysqli_fetch_array($sql_tamanho1);

                                        $result_tabela1 = mysqli_query($con, "SELECT * FROM tabela_basico WHERE id_basico = '$vetor_tamanho1[id_itemtabela]'");
                                        $vetor_tabela_final1 = mysqli_fetch_array($result_tabela1);

                                        $sql_tipo_final1 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_final1[id_tamanho]'");
                                        $vetor_tipo_final1 = mysqli_fetch_array($sql_tipo_final1);

                                        ?>
                                        <option value="<?php echo $vetor_produto_convite['id_item']; ?>_<?php echo $vetor_produto_convite['id_produto']; ?>"><?php if($vetor_produto_convite['id_produto'] == 2) { echo "Super Luxo"; } else { echo "Simples"; } ?> - <?php echo $vetor_tipo_final1['titulo']; ?></option>
                                        <?php } ?>
                                      </select>
                                    </fieldset>
                                  </div>

                                  <div class="col-lg-4">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Quantidade</label>
                                      <input type="number" name="qtd[]" class="form-control">
                                    </fieldset>
                                  </div>

                                </div>

                                <hr>

                                </div>

                                <div id="destino">
                                </div>
                                <br>
                                <input type="button" value="Adicionar Item" onclick="duplicarCampos();" class="btn btn-warning">
                                <input type="button" value="Excluir Item" onclick="removerCampos(this);" class="btn btn-danger">
                                     
                                <br>
                                <br>

                                <hr>

                                <div class="row">

                                  <div class="col-lg-4">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Quantidade de Parcelas</label>
                                      <input type="number" name="qtdparcelas" class="form-control" <?php if($vetor_cadastro['nivel'] != 1) { ?>max="6" <?php } ?> id="exampleInput">
                                    </fieldset>
                                  </div>

                                  <div class="col-lg-4">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Forma de Pagamento</label>
                                      <select name="id_forma" class="form-control">
                                        <option value="" selected="selected">Selecione...</option>
                                        <?php 

                                        $sql_formas = mysqli_query($con, "select * from formaspag where status='1' order by nome ASC");

                                        while ($vetor_forma=mysqli_fetch_array($sql_formas)) { 

                                        ?>
                                        <option value="<?php echo $vetor_forma['id_forma']; ?>" <?php if (strcasecmp($vetor['id_forma'], $vetor_forma['id_forma']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_forma['nome'] ?></option>
                                        <?php } ?>
                                      </select>
                                    </fieldset>
                                  </div>

                                  <div class="col-lg-4">
                                    <fieldset class="form-group">
                                      <label class="form-label semibold" for="exampleInput">Proposta Valida</label>
                                      <input type="text" name="validadeproposta" class="form-control" id="exampleInput">
                                    </fieldset>
                                  </div>

                                </div>
                                
                                <button type="submit" class="btn btn-primary"  style="    float: left;">Alterar / Incluir Produto</button>
                                    
                                </form>

                                <br>
                                <br>

                                <hr>

                                <h3>Produtos Cadastrados</h3>

                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                      <th width="8%"><div align="center">Quantidade</div></th>
                                      <th width="11%"><div align="center">Produto</div></th>
                                      <th><div align="center">Tamanho</div></th>
                                      <th><div align="center">Valor Un.</div></th>
                                      <th><div align="center">Valor Total</div></th>
                                      <th width="10%"><div align="center">Ação</div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                            
                                    $sql_valores = mysqli_query($con, "select * from orcamento_produto WHERE id_orcamento = '$id' order by id_item ASC");
                            
                                    while ($vetor_valores=mysqli_fetch_array($sql_valores)) {

                                    $sql_produto = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_valores[id_produto]'");
                                    $vetor_produto = mysqli_fetch_array($sql_produto);

                                    $sql_soma_calculo = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$id' and id_produto = '$vetor_valores[id_item]'");
                                    $vetor_soma_calculo = mysqli_fetch_array($sql_soma_calculo);

                                    $sql_tributos = mysqli_query($con, "select * from tabela_tributos where id_tributo = '2'");
                                    $vetor_tributos = mysqli_fetch_array($sql_tributos);

                                      if($vetor_tributos['tipo'] == 1) {

                                        $percentual = $vetor_tributos['valor'] / 100;
                                        $valorfinalcomissao = $vetor_soma_calculo['total'] * $percentual;

                                      } if($vetor_tributos['tipo'] == 2) {

                                        $valorfinalcomissao = $vetor_tributos['valor'];

                                      }

                                    $sql_tributos1 = mysqli_query($con, "select * from tabela_tributos where id_tributo = '3'");
                                    $vetor_tributos1 = mysqli_fetch_array($sql_tributos1);

                                      if($vetor_tributos1['tipo'] == 1) {

                                        $percentual1 = $vetor_tributos1['valor'] / 100;
                                        $valorfinalimposto1 = $vetor_soma_calculo['total'] * $percentual1;

                                      } if($vetor_tributos1['tipo'] == 2) {

                                        $valorfinalimposto1 = $vetor_tributos1['valor'];

                                      } 

                                    $totalproduto = $vetor_soma_calculo['total'] + $valorfinalcomissao + $valorfinalimposto1;

                                    $totalunproduto = $totalproduto / $vetor_valores['qtd'];

                                    $sql_tamanho = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_valores[id_item]' and id_tipo = '1'");
                                    $vetor_tamanho = mysqli_fetch_array($sql_tamanho);

                                    $result_tabela = mysqli_query($con, "SELECT * FROM tabela_basico WHERE id_basico = '$vetor_tamanho[id_itemtabela]'");
                                    $vetor_tabela_final = mysqli_fetch_array($result_tabela);

                                    $sql_tipo_final = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_final[id_tamanho]'");
                                    $vetor_tipo_final = mysqli_fetch_array($sql_tipo_final);
                            
                                    ?>
                                    <tr>
                                      <td><?php echo $vetor_valores['qtd']; ?></td>
                                      <td>Convite <?php if($vetor_valores['id_produto'] == 2) { echo "Super Luxo"; } else { echo "Simples"; } ?></td>
                                      <td><?php echo $vetor_tipo_final['titulo']; ?></td>
                                      <td>R$ <?php echo $num = number_format($totalunproduto,2,',','.'); ?></td>
                                      <td>R$ <?php echo $num = number_format($totalproduto,2,',','.'); ?></td>
                                      <td><a href="alterarproducoorcconvite.php?id=<?php echo $vetor_valores['id_item']; ?>&id1=<?php echo $id; ?>" target="_blank"><button type="button" class="btn btn-info mesmo-tamanho" title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i></button></a> <?php if($vetor_permissao['exclusao'] == 1) { } else { ?><a href="excluirproducoorcconvite.php?id=<?php echo $vetor_valores['id_item']; ?>&id1=<?php echo $id; ?>" ><button type="button" class="btn btn-danger mesmo-tamanho" title="Excluir Cadastro"><i class="fa fa-close"></i></button></a><?php } ?></td> 
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                  </table>

                                  <hr>

                                  <h3>Convites Extras Cadastrados</h3>

                                  <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                      <th><div align="center">Quantidade</div></th>
                                      <th><div align="center">Produto</div></th>
                                      <th><div align="center">Tamanho</div></th>
                                      <th width="10%"><div align="center">Ação</div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                            
                                    $sql_extras = mysqli_query($con, "select * from orcamento_extras WHERE id_orcamento = '$id' order by id_extras ASC");
                            
                                    while ($vetor_extras=mysqli_fetch_array($sql_extras)) {

                                    $sql_produto_orcamento = mysqli_query($con, "select * from orcamento_produto where id_item = '$vetor_extras[tipoconvite]'");
                                    $vetor_produto_orcamento = mysqli_fetch_array($sql_produto_orcamento);

                                    $sql_tamanho2 = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$id' AND id_produto = '$vetor_produto_orcamento[id_item]' and id_tipo = '1'");
                                    $vetor_tamanho2 = mysqli_fetch_array($sql_tamanho2);

                                    $result_tabela2 = mysqli_query($con, "SELECT * FROM tabela_basico WHERE id_basico = '$vetor_tamanho2[id_itemtabela]'");
                                    $vetor_tabela_final2 = mysqli_fetch_array($result_tabela2);

                                    $sql_tipo_final2 = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_final2[id_tamanho]'");
                                    $vetor_tipo_final2 = mysqli_fetch_array($sql_tipo_final2);
                            
                                    ?>
                                    <tr>
                                      <td><?php echo $vetor_extras['qtd']; ?></td>
                                      <td>Convite <?php if($vetor_produto_orcamento['id_produto'] == 2) { echo "Super Luxo"; } else { echo "Simples"; } ?></td>
                                      <td><?php echo $vetor_tipo_final2['titulo']; ?></td>
                                      <td><a href="alterarprodutoextraorcconvite.php?id=<?php echo $vetor_extras['id_extra']; ?>&id1=<?php echo $id; ?>" target="_blank"><button type="button" class="btn btn-info mesmo-tamanho" title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i></button></a> <?php if($vetor_permissao['exclusao'] == 1) { } else { ?><a href="excluirprodutoextraorcconvite.php?id=<?php echo $vetor_extras['id_extra']; ?>&id1=<?php echo $id; ?>" ><button type="button" class="btn btn-danger mesmo-tamanho" title="Excluir Cadastro"><i class="fa fa-close"></i></button></a><?php } ?></td> 
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                  </table>

                                  <hr>

                                  <?php if($vetor['dataentrega'] != NULL) { ?>

                                  <h3>Cronograma</h3>

                                  <div class="row">

                                  <div class="col-lg-6">

                                  <table width="100%" class="table table-bordered table-striped">
                                    <tr>
                                      <td width="3%"></td>
                                      <td><div align="center">ETAPAS</div></td>
                                      <td>
                                        <table width="100%">
                                          <tr>
                                            <td>
                                              <div align="center">DATA DO ENVIO</div>
                                            </td>
                                            <td>
                                              <div align="center">CONCLUSÃO</div>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>1</td>
                                      <td>Questionário de Identidade Visual.</td>
                                      <td>
                                        <table width="100%">
                                          <tr>
                                            <td>
                                              <div align="center"><?php echo date('d/m/Y', strtotime($vetor['questionario1'])); ?></div>
                                            </td>
                                            <td>
                                              <div align="center"><?php echo date('d/m/Y', strtotime($vetor['questionario'])); ?></div>
                                            </td>
                                          </tr>
                                        </table>
                                        </td>
                                    </tr>
                                    <tr>
                                      <td>2</td>
                                      <td>Criação - Elaboração e Aprovação de Layout.</td>
                                      <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['confeccaotematica'])); ?></div></td>
                                    </tr>
                                    <tr>
                                      <td>3</td>
                                      <td>Fotografia.</td>
                                      <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['datafotografia'])); ?></div></td>
                                    </tr>
                                    <tr>
                                      <td>4</td>
                                      <td>Prazo limite para entrega dos Dados e fotos do Convite Gráfico.</td>
                                      <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['prazolimiteentrega'])); ?></div></td>
                                    </tr>
                                    <tr>
                                      <td>5</td>
                                      <td>Data limite para acréscimo de convites extras.</td>
                                      <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['datalimiteconvextras'])); ?></div></td>
                                    </tr>
                                    <tr>
                                      <td>6</td>
                                      <td>Data da Aprovação Final do Convite.</td>
                                      <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['dataaprovacaofinal'])); ?></div></td>
                                    </tr>
                                    <tr>
                                      <td>7</td>
                                      <td>Data de envio do material para impressão.</td>
                                      <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['dataenviomaterial'])); ?></div></td>
                                    </tr>
                                    <tr>
                                      <td>8</td>
                                      <td>Entrega dos Convites.</td>
                                      <td><div align="center"><?php echo date('d/m/Y', strtotime($vetor['dataentrega'])); ?></div></td>
                                    </tr>
                                  </table>

                                  </div>
                                  </div>

                                  <?php } ?>
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
</body>

</html>
<?php } ?>