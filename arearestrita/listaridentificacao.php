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

  $sql_etapas = mysqli_query($con, "select * from  order by nome ASC");

  $id_pagina = 100;

  $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
  $vetor_permissao = mysqli_fetch_array($sql_permissao);

  if($vetor_permissao['listar'] != 2) { 

    echo"<script language=\"JavaScript\">
    location.href=\"sempermissao.php\";
    </script>";

  } if($vetor_permissao['listar'] == 2) {
	
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
  <link rel="stylesheet" href="layout/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="layout/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="layout/assets/css/custom.css">

  <link rel="stylesheet" href="../layout/bower_components/select2/dist/css/select2.min.css">
  
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
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>
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

</script>
<body class="hold-transition skin-yellow sidebar-collapse sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="inicio.php" class="logo">
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
        <small> <?php echo $vetor_cadastro['nome']; ?></small>      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Fotografia</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Indentificação de Formandos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
            <form action="recebe_identificacaoformando.php" method="post" name="cliente" enctype="multipart/form-data" onSubmit="return verificarCPF()" id="formID">

				<div class="row">

          <div class="col-lg-12">
            <fieldset class="form-group">
              <label class="form-label semibold" for="exampleInput">Contrato</label>
              <select name="id_turma" id="turmas" class="form-control">
                    <option value="" selected="selected">Selecione...</option>
                    <?php 

                    $sql_cursos = mysqli_query($con, "select * from turmas order by ncontrato ASC");

                    while ($vetor_curso=mysqli_fetch_array($sql_cursos)) { 

                    $sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
                    $vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

                    $sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_curso[curso]'");
                    $vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);


                    ?>
                    <option value="<?php echo $vetor_curso['id_turma']; ?>" <?php if (strcasecmp($vetor['id_turma'], $vetor_curso['id_turma']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_curso['ncontrato'] ?> - <?php echo $vetor_curso['nome'] ?> <?php echo $vetor_curso['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?></option>
                    <?php } ?>
                  </select>
            </fieldset>
          </div>

        </div>

        <div class="row">

           <div class="col-md-12">
           
           <div class="form-group">
           <label>Evento(s)</label>
           <select name="id_evento" id="eventos" class="form-control" required="">
                <option value="">Escolha um Contrato</option>
           </select>
           </div>
           </div>
              
        </div>
        
        <button type="submit" class="btn btn-primary"  style="float: left;">Abrir</button>
                
              </form>
            
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
<script src="layout/dist/js/adminlte.min.js"></script>
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
<script src="layout/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="layout/dist/js/demo.js"></script>

<script src="../layout/bower_components/select2/dist/js/select2.full.min.js"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>

</body>
</html>
<?php } } ?>