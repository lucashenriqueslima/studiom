<?php

    include"../includes/conexao.php";

     
     session_start();

    if($_SESSION['id'] == NULL) {
    
    echo"<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
    
    } else {
        
    $id = $_GET['id'];
    
    $sql = mysqli_query($con, "select * from usuarios where id_usuario = '$id'");
    $vetor = mysqli_fetch_array($sql);
        
    $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);

    $sql_modulos = mysqli_query($con, "select * from paginas_modulos order by nome ASC");

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
                        <h4 class="page-title">Usuários</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Usuários</li>
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
                                <h4 class="card-title">Permissões de Usuário - <?php echo $vetor['nome']; ?></h4>

                                <form action="recebe_permissao.php?id=<?php echo $id; ?>" method="post">
            
            <?php while($vetor_modulo = mysqli_fetch_array($sql_modulos)) { ?>

            <table class="table table-bordered">
                <tbody>

                <tr style="    background: #CCCCCC;
    color: #000;">
                  <th><?php echo $vetor_modulo['nome']; ?></th>
                </tr>                       
                       
            </tbody></table>

            <br>

            <table class="table table-bordered table-striped">
                <tbody>

                <?php

                $sql_paginas = mysqli_query($con, "select * from paginas where id_modulo = '$vetor_modulo[id_modulo]'");

                while($vetor_paginas = mysqli_fetch_array($sql_paginas)) { 

                $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_usuario = '$id' and id_pagina = '$vetor_paginas[id_pagina]'");
                $vetor_permissao = mysqli_fetch_array($sql_permissao);

                ?>

                <input type="hidden" name="id_pagina[]" value="<?php echo $vetor_paginas['id_pagina']; ?>">

                <tr>
                  <th width="20%"><?php echo $vetor_paginas['nome']; ?></th>
                  <th>
                    <table width="100%">
                      <tr>
                        <td width="23%">
                          <strong>Listar:</strong>
                          <br>
                          <select name="listar[]" class="form-control">
                            <option value="2" <?php if (strcasecmp($vetor_permissao['listar'], '2') == 0) : ?>selected="selected"<?php endif; ?>>Sim</option>
                            <option value="1" <?php if (strcasecmp($vetor_permissao['listar'], '1') == 0) : ?>selected="selected"<?php endif; ?>>Não</option>
                          </select>
                        </td>
                        <td width="2%"></td>
                        <td width="23%">
                          <strong>Cadastro:</strong>
                          <br>
                          <select name="cadastro[]" class="form-control">
                            <option value="2" <?php if (strcasecmp($vetor_permissao['cadastro'], '2') == 0) : ?>selected="selected"<?php endif; ?>>Sim</option>
                            <option value="1" <?php if (strcasecmp($vetor_permissao['cadastro'], '1') == 0) : ?>selected="selected"<?php endif; ?>>Não</option>
                            
                          </select>
                        </td>
                        <td width="2%"></td>
                        <td width="24%">
                          <strong>Alteração:</strong>
                          <br>
                          <select name="alteracao[]" class="form-control">
                            <option value="2" <?php if (strcasecmp($vetor_permissao['alteracao'], '2') == 0) : ?>selected="selected"<?php endif; ?>>Sim</option>
                            <option value="1" <?php if (strcasecmp($vetor_permissao['alteracao'], '1') == 0) : ?>selected="selected"<?php endif; ?>>Não</option>
                          </select>
                        </td>
                        <td width="2%"></td>
                        <td width="24%">
                          <strong>Exclusão:</strong>
                          <br>
                          <select name="exclusao[]" class="form-control">
                            <option value="2" <?php if (strcasecmp($vetor_permissao['exclusao'], '2') == 0) : ?>selected="selected"<?php endif; ?>>Sim</option>
                            <option value="1" <?php if (strcasecmp($vetor_permissao['exclusao'], '1') == 0) : ?>selected="selected"<?php endif; ?>>Não</option>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </th>
                </tr>

                <?php } ?>                       
                       
            </tbody></table>

            <?php } ?>

            <button type="submit" class="btn btn-primary"  style="    float: left;">Liberar</button>

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