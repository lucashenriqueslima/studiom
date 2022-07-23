<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];
$x = $_POST['id_evento'];

$i = 0;

foreach($x as $keyy) {

	$id_evento = $_POST['id_evento'][$i];

	$sql = mysqli_query($con, "insert into eventos_pacote (id_evento, id_pacote) VALUES ('$id_evento', '$id')");

	$i++;
}

echo"<script language=\"JavaScript\">
location.href=\"alterarprodutopacotealbum.php?id=$id&id1=$id1\";
</script>";	

?>