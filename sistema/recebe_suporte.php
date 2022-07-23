<?php


include "../includes/conexao.php";
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

$usuario = $_SESSION['id'];
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_GET['muda'])) {
        $suporte = mysqli_fetch_array(mysqli_query($con, "select * from suporte where id='$id'"));
        if ($_GET['muda'] == 'cima') { // para baixo
            $prioridade = (int)($suporte['prioridade']) - 1;
            $auxSuporte = mysqli_fetch_array(mysqli_query($con, "select * from suporte where prioridade='$prioridade' and status='$suporte[status]'"));
            if ($auxSuporte != NULL) {
                mysqli_query($con, "update suporte set prioridade='$prioridade' where id='$suporte[id]'");
                $prioridade++;
                mysqli_query($con, "update suporte set prioridade='$prioridade' where id='$auxSuporte[id]'");
            } else {
                $result = mysqli_query($con, "update suporte set prioridade='$prioridade' where id='$suporte[id]'");
            }
        } else { // para cima
            $prioridade = (int)($suporte['prioridade']) + 1;
            $auxSuporte = mysqli_fetch_array(mysqli_query($con, "select * from suporte where prioridade='$prioridade' and status='$suporte[status]'"));
            if ($auxSuporte != NULL) {
                mysqli_query($con, "update suporte set prioridade='$prioridade' where id='$suporte[id]'");
                $prioridade--;
                mysqli_query($con, "update suporte set prioridade='$prioridade' where id='$auxSuporte[id]'");
            } else {
                mysqli_query($con, "update suporte set prioridade='$prioridade' where id='$suporte[id]'");
            }
        }
    } else {
        $data = date('Y-m-d');
        $hora = date('H:i:s');
        if ($_GET['lado'] == 'left') {
            $suporte = mysqli_fetch_array(mysqli_query($con, "select * from suporte where id='$id'"));
            $status = $suporte['status'] - 1;
            $minimo = mysqli_fetch_array(mysqli_query($con, "select MIN(prioridade) AS minimo from suporte where status='$status'"));
            $minimo = $minimo['minimo'] - 1;
            mysqli_query($con, "update suporte set prioridade='$minimo',status='$status',data_entregue='$data' where id='$suporte[id]'");
        } else {
            $suporte = mysqli_fetch_array(mysqli_query($con, "select * from suporte where id='$id'"));
            $status = $suporte['status'] + 1;
            $maximo = mysqli_fetch_array(mysqli_query($con, "select MAX(prioridade) AS maximo from suporte where status='$status'"));
            $maximo = $maximo['maximo'] + 1;
            mysqli_query($con, "update suporte set prioridade='$maximo',status='$status',data_entregue='$data' where id='$suporte[id]'");
            $dataAux = date('Y-m-d H:i:s');
            $mensagemAux = '';
            switch ($suporte['tipo']){
                case 'ajuste':
                    $mensagemAux = '<p><h5><strong>Ajuste Concluido</strong></h5></p>';
                    break;
                case 'suporte':
                    $mensagemAux = '<p><h5><strong>Suporte Concluido</strong></h5></p>';
                    break;
                case 'desenv':
                    $mensagemAux = '<p><h5><strong>Desenvolvimento Concluido</strong></h5></p>';
                    break;
            }
            mysqli_query($con, "insert into suporte_mensagens (id_suporte, id_cadastro, data, mensagem) VALUES ('$id', '$usuario','$dataAux','$mensagemAux')");
        }
    }
    die();
}
$departamento = $_POST['departamento'];
$assunto = $_POST['assunto'];
$descricao = $_POST['descricao'];
$tipo = $_POST['tipo'];
$link = $_POST['link'];
$usuario = $_SESSION['id'];
$auxPrioridade;
if ($tipo == 'suporte') {
    $auxPrioridade = mysqli_query($con, "select MIN(prioridade) AS menor from suporte where status='1'");
    $auxPrioridade = mysqli_fetch_array($auxPrioridade);
    $auxPrioridade = $auxPrioridade['menor'] - 1;
} else {
    $auxPrioridade = mysqli_query($con, "select MAX(prioridade) AS maior from suporte where status='1'");
    $auxPrioridade = mysqli_fetch_array($auxPrioridade);
    $auxPrioridade = $auxPrioridade['maior'] + 1;
}

$diretorio = "arquivos/";
$data = date('Y-m-d H:i:s');

$sql = mysqli_query($con, "insert into suporte (tipo, id_departamento, prioridade, id_usuario,assunto, status, descricao, link,tempo_estimado,tempo_total,data_pedido) VALUES ('$tipo', '$departamento', '$auxPrioridade','$usuario', '$assunto', '1', '$descricao', '$link','00:00:00','00:00:00','$data')");
$id_gerado = $con->insert_id;

$sql_interacoes = mysqli_query($con, "insert into suporte_mensagens (id_suporte, id_cadastro, data, mensagem) VALUES ('$id_gerado', '$_SESSION[id]', '$data', '$descricao')");
$id_interacao = $con->insert_id;

$x = $_POST['nimagem'];

$i = 0;

foreach ($x as $key) {
    $nomeimagem = $_FILES['arquivo']['name'][$i];
    $tmp = $_FILES['arquivo']['tmp_name'][$i];
    $ext = strrchr($nomeimagem, '.');
    $imagem = time() . uniqid(md5()) . $ext;
    $upload = $diretorio . $imagem;
    move_uploaded_file($tmp, $upload);
    if ($nomeimagem != NULL) {
        $sql_anexo = mysqli_query($con, "insert into suporte_mensagens_anexos (id_mensagem, anexo) VALUES ('$id_interacao', '$imagem')");
    }
    $i++;
}

$sql_usuario = mysqli_query($con, "select * from usuarios where id_usuario = '$usuario'");
$vetor_usuario = mysqli_fetch_array($sql_usuario);

$to = 'bruno@contetecnologia.com.br';
$nome = 'Bruno Conte';

$to1 = 'marcellorodrigo@studiomfotografia.com.br';
$nome1 = 'Marcello Rodrigo';

$subject = 'Ajuste e Evoluções Cadastrada.';
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
      Foi feito um cadastro em Ajuste e Evoluções.

      <br>

      Título ' . $assunto . '

      <br>

      <br>
      Usuário: ' . $vetor_usuario[nome] . '

      <br>
      <br>
      <br>

      Studio M Fotografia
      </td>
          </tr>
      </table>
      </body>
      </html>';
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
            $mail->addAddress($to, $nome);    // Add a recipient
            $mail->addAddress($to1, $nome1);    // Add a recipient
//            if ($vetor_venda['arquivo'] != NULL) {
//                $mail->addAttachment($caminho, $nomearquivo);
//            }

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->MsgHTML($message);

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

echo "<script language=\"JavaScript\">
location.href=\"ajustes_evolucoes.php\";
</script>";

?>