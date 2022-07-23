<?php
include "includes/conexao.php";

use PHPMailer\PHPMailer\PHPMailer;
$nome = ucwords(strtolower($_POST['nome']));
$email = $_POST['email'];
$celular = $_POST['celular'];
$instituicao = $_POST['instituicao'];
$servico1 = (isset($_POST['servico1'])?'Convite':'');
$servico2 = (isset($_POST['servico2'])?'Fotografia':'');
$conteudo = $_POST['conteudo'];

require 'vendor/autoload.php';
$mail = new PHPMailer(true);

$to = 'marketing@studiomfotografia.com.br';
$subject = 'Fale Conosco - SITE';
$message = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<style>
    #corpo{
        text-align: justify;
        font-family: "Nunito Sans",sans-serif;
    }
    #corpo img{
        width: 10%;
        height: auto;
    }
</style>
<body>
<div id="corpo">
    <img src="https://studiomfotografia.com.br/sistema/imgs/Studio%20M%20-%20Logo-01.png">
    <br>
    <br>
    <br>
    <div>
        Nome Completo: '. $nome .'
        <br>
        <br>
        E-mail: ' . $email . '
        <br>
        <br>
        Celular: ' . $celular . '
        <br>
        <br>
        Instituição de Ensino: ' . $instituicao . '
        <br>
        <br>
        Serviço: ' . $servico1 . ' | ' . $servico2 . '
        <br>
        <br>
        <p>Assunto: ' . $conteudo . '</p>
        <br>
        <br>
        <br>
        <br>
        <br>
        Studio M Fotografia
    </div>
</div>


</table>
</body>
</html>';
$remetente = 'cadastro@studiomfotografia.com.br';                       // Enable verbose debug output
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
//    if ($vetor_venda['arquivo'] != NULL) {
//        $mail->addAttachment($caminho, $nomearquivo);
//    }

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->MsgHTML($message);

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}

echo "<script language=\"JavaScript\">alert('Obrigado pelo contato. Sua mensagem enviada com sucesso!');
location.href=\"index.html\";
</script>";
?>