<?php

include"../includes/conexao.php";


session_start();

$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
$res_cadastro = mysqli_query($con, $sql_cadastro);
$vetor_cadastro = mysqli_fetch_array($res_cadastro);

$id = $_GET['id'];

if($id == 1) {

$comentario = $_POST['comentario'];

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, texto) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '$comentario')");

} if($id == 2) {

$comentario = $_POST['comentario'];

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, texto) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '$comentario')");

} if($id == 3) {

$diretorio = "../sistema/arquivos/";
$nomeimagem = $_FILES['imagem']['name'];  
$tmp = $_FILES['imagem']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, upload, imagem) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '2', '$imagem')");

} if($id == 4) {

$upload = $_POST['upload'];

if($upload == 2) {

$diretorio = "../sistema/arquivos/";

$contaimagem = $_POST['contaimagem'];

$i = 0;

foreach($contaimagem as $keyy) {

$nomeimagem = $_FILES['imagem_up']['name'][$i];  
$tmp = $_FILES['imagem_up']['tmp_name'][$i];
$ext = strrchr($nomeimagem, '.'); 
$imagem_up = time().uniqid(md5()).$ext;
$upload_final = $diretorio.$imagem_up;
move_uploaded_file($tmp, $upload_final);

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, upload, imagem) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '2', '$imagem_up')");

$i++;

}

} else {

$imagem1 = $_POST['imagem'];

$i = 0;

foreach($imagem1 as $key) {

$imagem = $_POST['imagem'][$i];

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, upload, imagem) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '1', '$imagem')");

$i++;

}

}

} if($id == 5) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, upload, imagem) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '1', '$imagem')");

} if($id == 6) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, upload, imagem) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '1', '$imagem')");

} if($id == 7) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, upload, imagem) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '1', '$imagem')");

} if($id == 8) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, upload, imagem) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '1', '$imagem')");

} if($id == 9) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, upload, imagem) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '1', '$imagem')");

} if($id == 10) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, upload, imagem) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '1', '$imagem')");

} if($id == 11) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, upload, imagem) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '1', '$imagem')");

} if($id == 12) {

$imagem = $_POST['imagem'];

$sql = mysqli_query($con, "insert into dadosconvite (id_formando, id_turma, id_tipo, upload, imagem) VALUES ('$_SESSION[id_formando]', '$vetor_cadastro[turma]', '$id', '1', '$imagem')");

}

echo"<script language=\"JavaScript\">
location.href=\"dadosconvite.php\";
</script>";

?>