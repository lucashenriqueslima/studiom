<?php

include"../includes/conexao.php";


$nome = ucwords(strtolower($_POST['nome']));

$sql = mysqli_query($con, "insert into perfil (nome) VALUES ('$nome')");
$id = $con->insert_id;

echo"<script language=\"JavaScript\">
location.href=\"liberarpermissoes_perfil.php?id=$id\";
</script>";

?>