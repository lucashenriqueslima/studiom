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
    $sql = mysqli_query($con, "select * from escala_eventos where id_escala = '$id'");
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
        
        $(document).ready(function() {

            function limpa_formulário_cep1() {
                // Limpa valores do formulário de cep.
                $("#rua1").val("");
                $("#bairro1").val("");
                $("#cidade1").val("");
                $("#uf1").val("");
                $("#ibge1").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep1").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua1").val("...")
                        $("#bairro1").val("...")
                        $("#cidade1").val("...")
                        $("#uf1").val("...")
                        $("#ibge1").val("...")

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua1").val(dados.logradouro);
                                $("#bairro1").val(dados.bairro);
                                $("#cidade1").val(dados.localidade);
                                $("#uf1").val(dados.uf);
                                $("#ibge1").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep1();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep1();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep1();
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
    id('telefone3').onkeypress = function(){  
        mascara( this, mtel);  
    }
    id('telefone4').onkeypress = function(){  
        mascara( this, mtel);  
    }
}
</script>
    <style type="text/css">
<!--
.style1 {
    font-size: 18px;
    font-weight: bold;
}
-->
    </style>

    <script type="text/javascript">  
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
        $("input[name='rd-sexo']").click(function(){  
                $("#palco > div").hide();  
                $( '#'+$( this ).val() ).show('fast');    
        });  
});  
</script>
</head>
<script type="text/javascript">
          $(document).ready(function(){
              $('#turmas').change(function(){
                  $('#eventos').load('eventos_planejamento.php?id_turma='+$('#turmas').val() );

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
            var node11 = document.getElementById('destino1');
            node11.removeChild(node11.childNodes[0]);
          }

</script>
<script src="ckeditor/ckeditor.js"></script>

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
                        <h4 class="page-title">Fotografia</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Faturamento de Eventos</li>
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
                                <h4 class="card-title">Faturamento de Evento(s)</h4>

                                <form action="recebe_alterarfaturamentoevento.php?id=<?php echo $id; ?>" method="post" name="cliente" enctype="multipart/form-data" onSubmit="return verificarCPF()" id="formID">

                <div class="row">

          <div class="col-lg-12">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Contrato</label>
              <select name="id_turma" id="turmas" class="form-control" disabled="">
                    <option value="" selected="selected">Selecione...</option>
                    <?php 

                    $sql_cursos = mysqli_query($con, "select * from turmas order by ncontrato ASC");

                    while ($vetor_curso=mysqli_fetch_array($sql_cursos)) { 

                    $sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
                    $vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

                    $sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_curso[curso]'");
                    $vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);


                    ?>
                    <option value="<?php echo $vetor_curso['id_turma']; ?>" <?php if (strcasecmp($vetor['id_contrato'], $vetor_curso['id_turma']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_curso['ncontrato'] ?> - <?php echo $vetor_curso['nome'] ?> <?php echo $vetor_curso['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?></option>
                    <?php } ?>
                  </select>
            </fieldset>
          </div>

        </div>

        <h3>Gastos Evento(s)</h3>

        <div id="origem">

        <div class="row">

          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Gastos Evento(s)</label>
              <select name="id_funcao[]" id="categorias" class="form-control">
                    
                    <option value="" selected="">Selecione...</option>
                    <?php 
                    $sql_categoria = mysqli_query($con, "select * from tabela_fotografia where planejamento IS NULL order by titulo ASC");
                    while ($vetor_categoria=mysqli_fetch_array($sql_categoria)) { ?>
                    <option value="<?php echo $vetor_categoria['id_tabela']; ?>" <?php if (strcasecmp($vetor['id_funcao'], $vetor_categoria['id_tabela']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_categoria['titulo'] ?></option>
                    <?php } ?>
                  </select>
            </fieldset>
          </div>

          <div class="col-lg-6">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Quantidade</label>
              <input type="number" name="qtd[]" class="form-control">
            </fieldset>
          </div>

        </div>

        </div>

        <div id="destino">
        </div>
        <br>
        <input type="button" value="Adicionar Função" onclick="duplicarCampos();" class="btn btn-warning">
        <input type="button" value="Excluir Função" onclick="removerCampos(this);" class="btn btn-danger">

        <br>
        <br>

        <h3>Gastos Cadastrados</h3>

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><div align="center">Nome</div></th>
                  <th><div align="center">Serviço</div></th>
                  <th><div align="center">Qtd (diárias)</div></th>
                  <th><div align="center">Pré-Orçado</div></th>
                  <th><div align="center">Orçado</div></th>
                  <th width="13%"><div align="center">Ação</div></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                
                $sql_escala_profissionais = mysqli_query($con, "select * from escala_faturamento where id_escala = '$id' order by id_escala_faturamento ASC");

                while ($vetor_escala_profissionais=mysqli_fetch_array($sql_escala_profissionais)) {

                $sql_tabela = mysqli_query($con, "select * from tabela_fotografia where id_tabela = '$vetor_escala_profissionais[id_tabela]'");
                $vetor_tabela = mysqli_fetch_array($sql_tabela);

                $sql_escala = mysqli_query($con, "select * from escala_profissionais where id_escala_profissional = '$vetor_escala_profissionais[id_colaborador]'");
                $vetor_escala = mysqli_fetch_array($sql_escala);

                $sql_fornecedor = mysqli_query($con, "select * from clientes where id_cli = '$vetor_escala[id_colaborador]'");
                $vetor_fornecedor = mysqli_fetch_array($sql_fornecedor);

                if($vetor_escala_profissionais['id_tabela'] == 1) {

                $calculokm = $vetor_escala_profissionais['qtdtotal'] / 10;
                $mediakm = floor($calculokm);

                $calculo = $mediakm * $vetor_escala_profissionais['valor'];
                $valorfinal = $calculo * $vetor_escala_profissionais['qtd'];

                } else {

                $calculo = $vetor_escala_profissionais['qtdtotal'] * $vetor_escala_profissionais['valor'];
                $valorfinal = $calculo * $vetor_escala_profissionais['qtd'];

                }
        
                ?>
                <tr>
                  <td><?php echo $vetor_fornecedor['nome']; ?></td>
                  <td><?php echo $vetor_escala_profissionais['qtd']; ?> (un.) <?php echo $vetor_tabela['titulo']; ?></td>
                  <td><?php echo $vetor_escala_profissionais['qtdtotal']; ?> <?php if($vetor_escala_profissionais['id_tabela'] == 1) { echo "KM"; } ?></td>
                  <td>R$ <?php echo $num = number_format($valorfinal,2,',','.'); ?></td>
                  <td>R$ <?php echo $num = number_format($vetor_escala_profissionais['valorfinal'],2,',','.'); ?></td>
                  <td><a href="alteraritemfaturamentoevento.php?id=<?php echo $vetor_escala_profissionais['id_escala_faturamento']; ?>&id1=<?php echo $id; ?>" target="_blank"><button type="button" class="btn btn-info mesmo-tamanho" title="Ver ou Alterar Cadastro"><i class="fa fa-edit"></i></button></a> <a href="confexcluiritemfaturamentoevento.php?id=<?php echo $vetor_escala_profissionais['id_escala_faturamento']; ?>&id1=<?php echo $id; ?>" ><button type="button" class="btn btn-danger mesmo-tamanho" title="Excluir Cadastro"><i class="mdi mdi-window-close"></i></button></a></td> 
                </tr>
                <?php $totalizador += $valorfinal; $totalizador1 += $vetor_escala_profissionais['valorfinal']; } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th><div align="center">Total</div></th>
                  <th></th>
                  <th></th>
                  <th><div align="center">R$ <?php echo $num = number_format($totalizador,2,',','.'); ?></div></th>
                  <th><div align="center">R$ <?php echo $num = number_format($totalizador1,2,',','.'); ?></div></th>
                  <th width="13%"></th>
                </tr>
                </tfoot>
              </table>
        
        <button type="submit" class="btn btn-primary"  style="    float: left;">Alterar / Salvar</button>
                
              </form>
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