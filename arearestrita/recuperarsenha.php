<?php

include "../includes/conexao.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

$email = $_POST['email'];

$vetor = mysqli_fetch_array(mysqli_query($con, "select * from formandos where email = '$email'"));
$password = $vetor['cpf'];
$hash = password_hash($password,PASSWORD_DEFAULT);
$sql = mysqli_query($con, "update formandos SET senha = '$hash' where email = '$email'");
if (mysqli_num_rows($sql) == 0) {

    echo "<script> alert('E-mail não encontrado, favor verificar!')</script>";
    echo "<script> window.location.href='recuperarsenha.php.html'</script>";

} else {


    $to = $email;

    $subject = 'Recuperação de Senha';

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
      Caro(a) ' . $vetor['nome'] . ', senha login e senha de acesso a Area do Formando é:

      <br>

	  <br>

      <strong>Login: ' . $vetor['email'] . '</strong>
      <br>
      <strong>Senha: ' . $vetor['cpf'] . '</strong>

      <br>
      <br>
      <br>

      Para alterar sua senha basta acessar o sistema e em meu cadastro clicar em alterar senha.

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
//    $mail->addAttachment ($caminho, $nome);

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->MsgHTML($message);

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
