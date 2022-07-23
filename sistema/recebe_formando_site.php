<?php

include"../includes/conexao.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

$conclusao = $_POST['conclusao'];
$nome = htmlspecialchars(ucwords(strtolower($_POST['nome'])));
$sexo = $_POST['sexo'];
$estadocivil = $_POST['estadocivil'];
$cpf = $_POST['cpf'];
$rg = $_POST['rg'];
$oe = $_POST['oe'];
$datanasc = $_POST['datanasc'];
$localnasc = $_POST['localnasc'];
$turma = $_POST['turma'];
$cep = $_POST['cep'];
$endereco = htmlspecialchars($_POST['endereco']);
$numero = $_POST['numero'];
$complemento = htmlspecialchars($_POST['complemento']);
$bairro = htmlspecialchars($_POST['bairro']);
$cidade = htmlspecialchars($_POST['cidade']);
$estado = $_POST['estado'];
$telefone = $_POST['telefone'];
$celular = $_POST['celular'];
$email = $_POST['email'];
$email1 = $_POST['email1'];
$observacao = $_POST['observacao'];
$tipo = $_POST['tipo'];
$pai = htmlspecialchars($_POST['pai']);
$tipo1 = $_POST['tipo1'];
$telresidencial1 = $_POST['telresidencial1'];
$emailmae = $_POST['emailmae'];
$mae = htmlspecialchars($_POST['mae']);
$cep1 = $_POST['cep1'];
$endereco1 = htmlspecialchars($_POST['endereco1']);
$numero1 = $_POST['numero1'];
$complemento1 = htmlspecialchars($_POST['complemento1']);
$bairro1 = htmlspecialchars($_POST['bairro1']);
$cidade1 = htmlspecialchars($_POST['cidade1']);
$estado1 = $_POST['estado1'];
$celularpai = $_POST['celularpai'];
$celularmae = $_POST['celularmae'];
$telresidencial = $_POST['telresidencial'];
$cep2 = $_POST['cep2'];
$endereco2 = htmlspecialchars($_POST['endereco2']);
$complemento2 = htmlspecialchars($_POST['complemento2']);
$numero2 = $_POST['numero2'];
$bairro2 = htmlspecialchars($_POST['bairro2']);
$estado2 = $_POST['estado2'];
$estado2 = $_POST['estado2'];
$comissao = $_POST['comissao'];
$cargo = $_POST['cargo'];

$diretorio = "sistema/arquivos/";
$nomeimagem = $_FILES['imagem']['name'];
$tmp = $_FILES['imagem']['tmp_name'];
$ext = substr($nomeimagem, -4, 4); // vai retornar a extensão final do arquivo ex: ".png"
$newnome = date("Ymdhis").md5($nomeimagem);
$nomefinalfoto = $newnome.$ext;
$upload = $diretorio.$newnome.$ext;
move_uploaded_file($tmp, $upload);

$sql_consulta1 = mysqli_query($con, "select * from formandos where cpf = '$cpf'");
$vetor_consulta1 = mysqli_fetch_array($sql_consulta1);

if(mysqli_num_rows($sql_consulta1) != 0) { 

echo "<script> alert('CPF ja cadastrado em nosso sistema.')</script>";
echo "<script> window.location.href='javascript:window.history.go(-1)'</script>";

} else { 

$sql_consulta = mysqli_query($con, "select * from formandos where turma = '$turma' order by id_formando DESC limit 0,1");
$vetor_consulta = mysqli_fetch_array($sql_consulta);

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$turma'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$id_cadastro = $vetor_consulta['id_cadastro'] + 1;

$sql = mysqli_query($con, "insert into formandos (id_cadastro, conclusao, nome, estadocivil, sexo, localnasc, cpf, rg, oe, datanasc, turma, cep, endereco, numero, complemento, bairro, cidade, estado, telefone, celular, email, email1, observacoes, imagem, emailpai, pai, tipo1, mae, cep1, endereco1, numero1, complemento1, bairro1, cidade1, estado1, celularpai, celularmae, telresidencial, telresidencial1, emailmae, cep2, endereco2, complemento2, numero2, bairro2, cidade2, estado2, comissao, cargo) VALUES ('$id_cadastro', '$vetor_turma[ano]', '$nome', '$estadocivil', '$sexo', '$localnasc', '$cpf', '$rg', '$oe', '$datanasc', '$turma', '$cep', '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$telefone', '$celular', '$email', '$email1', '$observacao', '$nomefinalfoto', '$emailpai', '$pai', '$tipo1', '$mae', '$cep1', '$endereco1', '$numero1', '$complemento1', '$bairro1', '$cidade1', '$estado1', '$celularpai', '$celularmae', '$telresidencial', '$telresidencial1', '$emailmae', '$cep2', '$endereco2', '$complemento2', '$numero2', '$bairro2', '$cidade2', '$estado2', '$comissao', '$cargo')") or die (mysqli_error($con));

$data = date('Y-m-d');

$sql_produtos_turma = mysqli_query($con, "select * from produtos_turma where id_turma = '$turma' and dataabertura <= '$data' and termino >= '$data'");

$to = $email;

$subject = 'Confirmação de Cadastro';

$message = '<!DOCTYPE html>
  <html>
  <head>
      <title></title>
  </head>
  <body>
  <table width="100%">
      <tr>
          <td>
              <img src="https://studiomfotografia.com.br/sistema/imgs/LOGOS-LOGIN.png" width="200px">
          </td>
      </tr>
      <tr>
          <td><br><br></td>
      </tr>
      <tr>
          <td>
      Parabéns!

      <br>

      '.$nome.'

      <br>

	  <br>

      Seu número de cadastro é ('.$vetor_turma[ncontrato].' - '.$id_cadastro.')

      <br>
      <br>
      <br>

      Obrigado.

	  <br>
	  <br>
	  <br>

	  Studio M Fotografia
	  </td>
	      </tr>
	  </table>
	  </body>
	  </html>';

	$caminho = 'sistema/arquivos/'.$vetor_documentos['arquivo'];
  $nomearquivo = 'Contrato';

  $remetente = 'cadastro@studiomfotografia.com.br';

    try {
        //Server settings
//    $mail->SMTPDebug = 1;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'studiomfotografia.com.br';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'contato@studiomfotografia.com.br';                 // SMTP username
        $mail->Password = 'c&GM^NM20gLE';                           // SMTP password
        $mail->SMTPSecure = 'TLS';                            // SMTP password
        $mail->Port = 587;                                    // TCP port to connect to
        $mail->CharSet = "UTF-8";

        //Recipients
        $mail->setFrom($remetente, 'StudioM Fotografia');
        $mail->addAddress($to, $vetor['nome']);    // Add a recipient
//            if ($vetor_venda['arquivo'] != NULL) {
//                $mail->addAttachment($caminho, $nomearquivo);
//            }

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->MsgHTML($message);

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>StudioM Fotografia</title>
</head>
<link rel="stylesheet" href="../layout/bower_components/bootstrap/dist/css/bootstrap.min.css">
<style>

          body {
		  background-image: url("imgs/fundo.png");
		  }

          #box {
          width:500px;
          height:100%;
          border-radius: 10px;
          margin: auto;
          padding:10px;
          margin-bottom: 20px;
          }

</style>
<body>
<br>
<br>
<br>
<br>
<div class="container">
	<div id="box" align="center">

		<img src="imgs/LOGOS-LOGIN.png">

		<br>
		<br>
		<h4><strong>Cadastro realizado com sucesso!</strong></h4>
		<p><h4><strong><?php echo $nome; ?>.</strong></h4></p>
		<strong>Seu número de identificação é:
		<br>
		<font size="4px" style="background-color:#FF6600" color="#000000"><?php echo $vetor_turma['ncontrato']; ?>/<?php echo $id_cadastro; ?></font>
		<br>
		Enviamos para seu e-mail a confirmação de cadastro em nosso sistema. Caso não o localize na sua caixa de entrada, favor verificar na sua caixa de Spam.
		<br>
		Para confirmar seu cadastro, acesse seu e-mail.</strong>


	</div>
</div>
</body>
</html>
<?php } ?>