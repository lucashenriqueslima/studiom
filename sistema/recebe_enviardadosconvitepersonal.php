<?php

include"../includes/conexao.php";


session_start();

$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
$res_cadastro = mysqli_query($con, $sql_cadastro);
$vetor_cadastro = mysqli_fetch_array($res_cadastro);

$id = $_GET['id'];
$id1 = $_GET['id1'];

$data = date('Y-m-d');

$sql_item = mysqli_query($con, "select * from convite_personal_itens where id_item = '$id'");
$vetor_item = mysqli_fetch_array($sql_item);

$sql_update = mysqli_query($con, "update convite_personal SET datafinalizacao = '$data', status = '2' where id_convite = '$id1'");

$sql_update1 = mysqli_query($con, "update convite_personal_itens SET status = '1' where id_item = '$id'");

if($vetor_item['id_tipo'] == 3) {

$diretorio = "../sistema/arquivos/";
$nomeimagem = $_FILES['imagem']['name'];  
$tmp = $_FILES['imagem']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$imagemgrava = $diretorio.$imagem;

$sql = mysqli_query($con, "insert into convite_personal_escolhas (id_item, id_tipo, imagem) VALUES ('$id', '1', '$imagemgrava')");

} if($vetor_item['id_tipo'] == 4) {

$upload = $_POST['upload'];

if($upload == 2) {

$diretorio = "../sistema/arquivos/";

$contaimagem = $_POST['contaimagem'];

$i = 0;

foreach($contaimagem as $keyy) {

$imagem_up = $_FILES['imagem_up']['name'][$i];  
$tmp = $_FILES['imagem_up']['tmp_name'][$i];
$ext = strrchr($imagem_up, '.'); 
$imagem_up = time().uniqid(md5()).$ext;
$upload_final = $diretorio.$imagem_up;
move_uploaded_file($tmp, $upload_final);

$imagemgrava = $diretorio.$imagem_up;

$sql = mysqli_query($con, "insert into convite_personal_escolhas (id_item, id_tipo, imagem) VALUES ('$id', '1', '$imagemgrava')");

$i++;

}

} else {

$imagem1 = $_POST['imagem'];

$i = 0;

foreach($imagem1 as $key) {

$imagem = $_POST['imagem'][$i];

$sql = mysqli_query($con, "insert into convite_personal_escolhas (id_item, id_tipo, imagem) VALUES ('$id', '2', '$imagem')");

$i++;

}

}

} if($vetor_item['id_tipo'] == 5) {

$imagem1 = $_POST['imagem'];

$i = 0;

foreach($imagem1 as $key) {

$imagem = $_POST['imagem'][$i];

$sql = mysqli_query($con, "insert into convite_personal_escolhas (id_item, id_tipo, imagem) VALUES ('$id', '2', '$imagem')");

$i++;

}

} if($vetor_item['id_tipo'] == 6) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into convite_personal_escolhas (id_item, id_tipo, imagem) VALUES ('$id', '2', '$imagem')");

} if($vetor_item['id_tipo'] == 7) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into convite_personal_escolhas (id_item, id_tipo, imagem) VALUES ('$id', '2', '$imagem')");

} if($vetor_item['id_tipo'] == 8) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into convite_personal_escolhas (id_item, id_tipo, imagem) VALUES ('$id', '2', '$imagem')");

} if($vetor_item['id_tipo'] == 9) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into convite_personal_escolhas (id_item, id_tipo, imagem) VALUES ('$id', '2', '$imagem')");

} if($vetor_item['id_tipo'] == 10) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into convite_personal_escolhas (id_item, id_tipo, imagem) VALUES ('$id', '2', '$imagem')");

} if($vetor_item['id_tipo'] == 11) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into convite_personal_escolhas (id_item, id_tipo, imagem) VALUES ('$id', '2', '$imagem')");

} if($vetor_item['id_tipo'] == 12) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into convite_personal_escolhas (id_item, id_tipo, imagem) VALUES ('$id', '2', '$imagem')");

}

echo"<script language=\"JavaScript\">
location.href=\"convitepersonal.php?id=$id1\";
</script>";

?>