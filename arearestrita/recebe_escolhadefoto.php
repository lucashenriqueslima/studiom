<?php 

session_start();

include"../includes/conexao.php";




$data = date('Y-m-d');

$id = $_GET['id'];
$id_escolha = $_GET['id_escolha'];
$observacoes = addslashes($_POST['observacoes']);
$x = $_POST['foto'];

$sql = mysqli_query($con, "update escolha_fotos_itens SET observacoes = '$observacoes', status = '2' where id_item = '$id'");

$sql_update_escolha = mysqli_query($con, "update escolha_fotos SET status = '2' where id_escolha = '$id_escolha'");

$diretorio = "../sistema/arquivos/";

$y = $_FILES['imagem_up'];

$f = 0;

foreach($y as $keyyyyy) {

$imagem_up = $_FILES['imagem_up']['name'][$f];  
$tmp = $_FILES['imagem_up']['tmp_name'][$f];
$ext = strrchr($imagem_up, '.'); 
$imagem_up = time().uniqid(md5()).$ext;
$upload_final = $diretorio.$imagem_up;
move_uploaded_file($tmp, $upload_final);

if(!empty($ext)) {

$titulograva = $diretorio.$imagem_up;

$sql = mysqli_query($con, "insert into escolha_fotos_escolhidas (id_escolha, foto) VALUES ('$id', '$titulograva')");

}

$f++;

}

$i = 0;

foreach($x as $key) {

	$foto = $_POST['foto'][$i];

	$sql_fotos = mysqli_query($con, "insert into escolha_fotos_escolhidas (id_escolha, foto) VALUES ('$id', '$foto')");

	$i++;

}

$sql_total = mysqli_query($con, "select * from escolha_fotos_itens where id_escolha = '$id_escolha'");
$total = mysqli_num_rows($sql_total);

$sql_total2 = mysqli_query($con, "select * from escolha_fotos_itens where id_escolha = '$id_escolha' and status = '2'");
$total2 = mysqli_num_rows($sql_total2);

header("Location: escolhafotos.php?id=$id_escolha#Lamina-$id");
// echo"<script language=\"JavaScript\">
// location.href=\"escolhafotos.php?id=$id_escolha#Lamina-$id\";
// </script>";

?>