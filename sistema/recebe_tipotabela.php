<?php

include"../includes/conexao.php";


$tipo = $_POST['tipo'];
$titulo = ucwords(strtolower($_POST['titulo']));

$sql = mysqli_query($con, "insert into tabela_tipos (tipo, titulo) VALUES ('$tipo', '$titulo')");

echo"<script language=\"JavaScript\">
location.href=\"comercial_itenstabelaconvite.php\";
</script>";

?>