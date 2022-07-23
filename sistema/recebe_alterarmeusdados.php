<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$departamento = $_POST['departamento'];

$diretorio = "arquivos/";
$nomeimagem = $_FILES['imagem']['name'];  
$tmp = $_FILES['imagem']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

if($nomeimagem == NULL) {

$sql = mysqli_query($con, "update usuarios SET senha='$senha' where id_usuario = '$id'");

} else { 

$sql = mysqli_query($con, "update usuarios SET senha='$senha', imagem='$imagem' where id_usuario = '$id'");

}


echo"<script language=\"JavaScript\">
location.href=\"meusdados.php\";
</script>";

?>