<?php

include"../includes/conexao.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

$mail = new PHPMailer(true);

$message = '<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
Testando o envio de e-mail;
</body>
</html>';

$subject = 'Testando o email';

//$caminho = 'arquivos/15470602775c3644357190e.pdf';
$nome = 'Contrato';

$remetente = 'contato@studiomfotografia.com.br';

    try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
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
    $mail->addAddress('alexflash1996@gmail.com', 'Alexandre Rocha');     // Add a recipient
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

?>