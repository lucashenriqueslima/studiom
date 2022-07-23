<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id_categoria = $_POST['id_categoria'];
$nome = ucwords(strtolower($_POST['nome']));
$posicao = $_POST['posicao'];

$sql = mysqli_query($con, "update sub_categorias SET nome='$nome', id_categoria='$id_categoria', posicao='$posicao' where id_sub = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"cadastros_status.php\";
</script>";

?>