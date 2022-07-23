<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];

$qtd = $_POST['qtd'];

$sql = mysqli_query($con, "update turmas_escolha_formandos SET qtd='$qtd' where id_formando_escolha = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"alterarescolhafotosturma.php?id=$id1\";
</script>";

?>