<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));

$sql = mysqli_query($con, "update categorias SET nome='$nome' where id_categoria = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"cadastros_categorias.php\";
</script>";

?>