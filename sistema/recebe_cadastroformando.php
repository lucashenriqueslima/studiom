<?php

include"../includes/conexao.php";


$ncontrato = $_POST['ncontrato'];

$sql_turma = mysqli_query($con, "select * from turmas where ncontrato = '$ncontrato'");
$vetor = mysqli_fetch_array($sql_turma);

if(mysqli_num_rows($sql_turma) == 0) {

echo "<script> alert('Turma nao encontrada, favor digitar novamente o numero da turma!')</script>";
echo "<script> window.location.href='efetuarcadastro.html'</script>";

}

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
  <!-- Theme style -->
  <link rel="stylesheet" href="../layout/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="layout/plugins/iCheck/square/blue.css">
  
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
  id('telefone5').onkeypress = function(){  
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
<body class="wrapper">
<section class="content">
  <!-- /.login-logo -->
  <div class="box-body">
            
            <?php

include"../includes/conexao.php";


$conclusao = $_POST['conclusao'];
$nome = ucwords(strtolower($_POST['nome']));
$sexo = $_POST['sexo'];
$cpf = $_POST['cpf'];
$rg = $_POST['rg'];
$oe = $_POST['oe'];
$datanasc = $_POST['datanasc'];
$turma = $_POST['turma'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$telefone = $_POST['telefone'];
$celular = $_POST['celular'];
$email = $_POST['email'];
$observacao = $_POST['observacao'];
$pai = $_POST['pai'];
$mae = $_POST['mae'];
$cep1 = $_POST['cep1'];
$endereco1 = $_POST['endereco1'];
$numero1 = $_POST['numero1'];
$complemento1 = $_POST['complemento1'];
$bairro1 = $_POST['bairro1'];
$cidade1 = $_POST['cidade1'];
$estado1 = $_POST['estado1'];
$celularpai = $_POST['celularpai'];
$celularmae = $_POST['celularmae'];
$telresidencial = $_POST['telresidencial'];
$comissao = $_POST['comissao'];
$cargo = $_POST['cargo'];

$diretorio = "arquivos/";
$nomeimagem = $_FILES['imagem']['name'];
$tmp = $_FILES['imagem']['tmp_name'];
$ext = substr($nomeimagem, -4, 4); // vai retornar a extensão final do arquivo ex: ".png"
$newnome = date("Ymdhis").md5($nomeimagem);
$nomefinalfoto = $newnome.$ext;
$upload = $diretorio.$newnome.$ext;
move_uploaded_file($tmp, $upload);

$sql_consulta = mysqli_query($con, "select * from formandos where turma = '$turma' order by id_formando DESC limit 0,1");
$vetor_consulta = mysqli_fetch_array($sql_consulta);

$id_cadastro = $vetor_consulta['id_cadastro'] + 1;

$sql = mysqli_query($con, "insert into formandos (id_cadastro, conclusao, nome, sexo, cpf, rg, oe, datanasc, turma, cep, endereco, numero, complemento, bairro, cidade, estado, telefone, celular, email, observacoes, imagem, pai, mae, cep1, endereco1, numero1, complemento1, bairro1, cidade1, estado1, celularpai, celularmae, telresidencial, comissao, cargo) VALUES ('$id_cadastro', '$conclusao', '$nome', '$sexo', '$cpf', '$rg', '$oe', '$datanasc', '$turma', '$cep', '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$telefone', '$celular', '$email', '$observacao', '$nomefinalfoto', '$pai', '$mae', '$cep1', '$endereco1', '$numero1', '$complemento1', '$bairro1', '$cidade1', '$estado1', '$celularpai', '$celularmae', '$telresidencial', '$comissao', '$cargo')");

$idimp11 = $con->insert_id;

$sql_consulta = mysqli_query($con, "select * from turmas where id_turma = '$turma'");
$vetor_turma = mysqli_fetch_array($sql_consulta);

?>

<div class="row">
      <div class="col-lg-12">
        <div class="alert alert-info">
          Cadastro realizado com sucesso.
          <br>
          Seja bem vindo, <?php echo $nome; ?>.
          Obrigado pelo cadastro. Seu número de identificação de cliente é (<?php echo $vetor_turma['ncontrato']; ?> – <?php echo $idimp11; ?>)
        </div>
      </div>
      </div>
            
            </div>
  <!-- /.login-box-body -->
</section>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="../layout/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../layout/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="layout/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
