<?php
include "../includes/conexao.php";
$nome = ucwords(strtolower($_POST['nome']));
$sql = mysqli_query($con, "insert into categorias (nome) VALUES ('$nome')");
echo "<script language=\"JavaScript\">
location.href=\"cadastros_categorias.php\";
</script>";
?>