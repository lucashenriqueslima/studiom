<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);



include "../includes/conexao.php";

$id = $_GET['id'];
$descricao = $_POST['descricao'];
$validado = (isset($_POST['validado']) ? $_POST['validado'] : 10);
$usuario = $_SESSION['id'];
$data = date('Y-m-d H:i:s');
$auxTipo = mysqli_fetch_array(mysqli_query($con, "select tipo from suporte where id ='$id'"));
$tipo = $auxTipo['tipo'];
$diretorio = "arquivos/";

if ($validado == '1') {
    mysqli_query($con, "update suporte SET status = '3', data_entregue = now() where id = '$id'");
    mysqli_query($con, "insert into suporte_mensagens (id_suporte, id_cadastro, data, mensagem) VALUES ('$id', '$usuario','$data','<p><h5><strong>Validado</strong></h5></p>')");
} elseif ($validado != 10) {
    if ($tipo = 'suporte') {
        $suporte_sql = mysqli_fetch_array(mysqli_query($con, "select MIN(prioridade) as prioridade from suporte"));
        $prioridadeAux = $suporte_sql['prioridade'] - 1;
        mysqli_query($con, "update suporte set status='1',prioridade='$prioridadeAux' where id='$id'");
    } else {
        $suporte_sql = mysqli_fetch_array(mysqli_query($con, "select MAX(prioridade) as prioridade from suporte where tipo = 'suporte' and status='1'"));
        if ($suporte_sql['prioridade'] != null) {
            mysqli_query($con, "update suporte set prioridade = prioridade - 1 where tipo = 'suporte' and status='1'");
            $prioridadeAux = $suporte_sql['prioridade'];
        } else {
            $suporte_sql = mysqli_fetch_array(mysqli_query($con, "select MIN(prioridade) as prioridade from suporte where status = '1'"));
            if ($suporte_sql['prioridade'] != null) {
                $prioridadeAux = $suporte_sql['prioridade'];
            } else {
                $prioridadeAux = 0;
            }
            mysqli_query($con, "update suporte set status='1',prioridade='$prioridadeAux' where id='$id'");
        }
    }
    mysqli_query($con, "update suporte SET tempo_estimado='00:00:00' where id = '$id'");
    mysqli_query($con, "insert into suporte_mensagens (id_suporte, id_cadastro, data, mensagem) VALUES ('$id', '$usuario','$data','<p><h5><strong>Validado Com Ressalva</strong></h5></p>')");
}
if (!empty($descricao)) {
    $sql_interacoes = mysqli_query($con, "insert into suporte_mensagens (id_suporte, id_cadastro, data, mensagem) VALUES ('$id', '$_SESSION[id]', '$data', '$descricao')");
    $id_interacao = $con->insert_id;
}

$x = $_POST['nimagem'];

$i = 0;

foreach ($x as $keyyy) {
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

echo "<script language=\"JavaScript\">
location.href=\"ajustes_evolucoes.php\";
</script>";

?>