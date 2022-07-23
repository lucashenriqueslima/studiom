<?php
include "../includes/conexao.php";
$nome = ucwords(strtolower($_POST['nome']));
$sql = mysqli_query($con, "insert into assuntos (nome) VALUES ('$nome')");
echo "<script language=\"JavaScript\">
location.href=\"cadastros_assuntos.php\";
</script>";
?>