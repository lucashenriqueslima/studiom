<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));

$sql = mysqli_query($con, "update tipos_arquivos SET nome='$nome' where id_tipo = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"cadastros_tiposarquivos.php\";
</script>";

?>