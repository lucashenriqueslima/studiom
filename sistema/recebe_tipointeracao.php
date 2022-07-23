<?php
include "../includes/conexao.php";
$nome = ucwords(strtolower($_POST['nome']));
$sql = mysqli_query($con, "insert into tipo_interacao (nome) VALUES ('$nome')");
echo "<script language=\"JavaScript\">
location.href=\"cadastros_tiposinteracao.php\";
</script>";
?>