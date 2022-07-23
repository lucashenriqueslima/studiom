<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));

$sql = mysqli_query($con, "update perfil SET nome='$nome' where id_perfil = '$id'");
$id = $con->insert_id;

echo"<script language=\"JavaScript\">
location.href=\"listarperfil.php\";
</script>";

?>