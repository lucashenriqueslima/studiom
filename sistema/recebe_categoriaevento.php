<?php
include "../includes/conexao.php";
$nome = ucwords(strtolower($_POST['nome']));
$sigla = $_POST['sigla'];
$tipo = $_POST['tipo'];
$sql = mysqli_query($con, "insert into categoriaevento (nome, sigla, tipo) VALUES ('$nome', '$sigla', '$tipo')");
echo "<script language=\"JavaScript\">
location.href=\"cadastros_categoriaseventos.php\";
</script>";
?>