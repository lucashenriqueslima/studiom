<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));
$escala = $_POST['escala'];

$sql = mysqli_query($con, "update categoriafornecedor SET nome='$nome', escala='$escala' where id_categoria = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"cadastros_categoriasfornecedores.php\";
</script>";

?>