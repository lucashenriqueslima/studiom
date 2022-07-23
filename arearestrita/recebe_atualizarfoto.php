<?php 

session_start();



include"../includes/conexao.php";


$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
$res_cadastro = mysqli_query($con, $sql_cadastro);
$vetor_cadastro = mysqli_fetch_array($res_cadastro);

$diretorio = "../sistema/arquivos/";
$nomeimagem = $_FILES['imagem']['name'];  
$tmp = $_FILES['imagem']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$sql_update = mysqli_query($con, "update formandos SET imagem = '$imagem' where id_formando = '$_SESSION[id_formando]'");

echo"<script language=\"JavaScript\">
location.href=\"editarfoto.php\";
</script>";

?>