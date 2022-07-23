<?php
include "../includes/conexao.php";
$id_categoria = $_POST['id_categoria'];
$nome = ucwords(strtolower($_POST['nome']));
$posicao = $_POST['posicao'];
$sql = mysqli_query($con, "insert into sub_categorias (nome, id_categoria, posicao) VALUES ('$nome', '$id_categoria', '$posicao')");
echo "<script language=\"JavaScript\">
location.href=\"cadastros_status.php\";
</script>";
?>