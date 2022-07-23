<?php

include"../includes/conexao.php";


$nome = ucwords(strtolower($_POST['nome']));

$sql = mysqli_query($con, "insert into formaspag (nome) VALUES ('$nome')");

echo"<script language=\"JavaScript\">
location.href=\"vendas_formas.php\";
</script>";

?>