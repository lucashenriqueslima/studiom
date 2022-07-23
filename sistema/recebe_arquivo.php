<?php

session_start();

include"../includes/conexao.php";

$id = $_GET['id'];


$titulo = ucwords(strtolower($_POST['titulo']));
$data = date('Y-m-d');
$horaatual = date('H:i:s');
$tipo = $_POST['tipo'];
$diretorio = "arquivos/";
$nomeimagem = $_FILES['arquivo']['name'];  
$tmp = $_FILES['arquivo']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$sql_grava = mysqli_query($con, "insert into arquivos (id_cliente, id_usuario, titulo, data, hora, tipo, arquivo) VALUES ('$id', '$_SESSION[id]', '$titulo', '$data', '$horaatual', '$tipo', '$imagem')");

$sql_formando = mysqli_query($con, "select nome, telefone, email from formandos where id_formando = '$id'");
$sql_user = mysqli_query($con, "select nome, usuario from usuarios where id_usuario = '$_SESSION[id]'");
$formando = mysqli_fetch_array($sql_formando);
$user = mysqli_fetch_array($sql_user);


//D4Sign
//use D4sign\Client;
//require '../vendor/autoload.php';
//include '../d4sign/functions/functions.php';

//$client = new Client();
//$client->setAccessToken("live_61443c5531164ba1e1fa2b5f88bc02dd8df49ad428317d08ab3ea4792a78b714");
//$client->setCryptKey("live_crypt_34gRk77yQWLS2YsxbC9qEPf0kCzds1RU");

//documento
//$path_file = $diretorio.$imagem;


//cofre
/*echo "<pre>";
var_dump(lista_cofres($client));
echo "</pre>"; */

//$cofre = lista_cofres($client);
//$cofreId = $cofre[0]->uuid_safe;

//upload
#$id_doc = upload($client, $path_file, $cofreId);
//$id_doc = "73251ed0-c818-4a36-a1d5-90bb65fd1245";

//signatarios
//$signatarios = array(
//    array($formando['email'], "1","0","0","0","email", $formando['telefone']),
//);

//if($_POST['testemunha01']){
//   $signatarios[] = array($_POST['testemunha01'],"1","0","0","0","email", "");
//}if($_POST['testemunha02']){
//    $signatarios[]  = array($_POST['testemunha02'],"1","0","0","0","email", "");
//}

//signatarios($signatarios,$client, $id_doc);
//solicitar_assinatura($client, $id_doc);

echo"<script language=\"JavaScript\">
location.href=\"alterarformando.php?id=$id\";
</script>";

?>