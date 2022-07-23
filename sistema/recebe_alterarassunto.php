<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));

$sql = mysqli_query($con, "update assuntos SET nome='$nome' where id_assunto = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"cadastros_assuntos.php\";
</script>";

?>