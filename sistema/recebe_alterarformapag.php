<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));

$sql = mysqli_query($con, "update formaspag SET nome='$nome' where id_forma = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"vendas_formas.php\";
</script>";

?>