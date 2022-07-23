<?php
	 include"../includes/conexao.php";

	 
	 session_start();

	if($_SESSION['id'] == NULL) {
	
	echo"<script language=\"JavaScript\">
	location.href=\"index.php\";
	</script>";
	
	} else {
	
	$id = $_GET['id'];
  $id1 = $_GET['id1'];
  $id_formando = $_GET['id_formando'];
	
	$sql = mysqli_query($con, "select * from minhas_aprovacoes where id_minhaaprovacao = '$id'");
	$vetor = mysqli_fetch_array($sql);

  $sql_contrato = mysqli_query($con, "select * from formandos where id_formando = '$vetor[id_formando]'");
  $vetor_contrato = mysqli_fetch_array($sql_contrato);
		
	$sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);
	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>StudioM Fotografia</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../layout/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../layout/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../layout/bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../layout/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../layout/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../layout/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="../layout/assets/css/custom.css">
  
  <link rel="icon" type="image/png" sizes="32x32" href="imgs/logo1.png">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<script type="text/javascript" src="aplicacoes/aplicjava.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>  
<!-- Adicionando JQuery -->
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
<body class="hold-transition skin-yellow sidebar-collapse sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="imgs/logo1.png" width="40px"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="imgs/LOGOS-LOGIN-1.png" width="100px"></span>    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <?php include"includes/topo.php"; ?>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <?php include"includes/menu_sistema.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Seja bem-vindo,
        <small> <?php echo $_SESSION['nome']; ?></small>      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Aprovação Formando</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Exclusão de Aprovação Formando</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
            <table class="table table-bordered">
                <tbody>

                <tr style="    background: #FF6600;
    color: #fff;">
                  <th>Nome</th>
                  <th width="15%">Ação</th> 
                </tr>

                         <tr>
                              <td><?php echo $vetor_contrato['nome']; ?></td>
                              <td><a href="excluiraprovacaoformando.php?id=<?php echo $id; ?>&id1=<?php echo $id1; ?>&id_formando=<?php echo $id_formando; ?>"><button type="button" class="btn btn-inline btn-danger">Sim</button></a> <a href="listaraprovacoesformando.php?id=<?php echo $id1; ?>&id_formando=<?php echo $id_formando; ?>"><button type="button" class="btn btn-inline btn-success">Não</button></a></td>  
                          </tr>
                        
                       
              </tbody></table>
            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Versão</b> 1.0    </div>
    <strong>Todos direitos reservados StudioM Fotografia.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../layout/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../layout/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../layout/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../layout/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="../layout/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="layout/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="layout/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="../layout/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="../layout/bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../layout/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../layout/dist/js/demo.js"></script>
</body>
</html>
<?php } ?>