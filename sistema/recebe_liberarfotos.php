<?php
include "../includes/conexao.php";
$id_turma = $_POST['id_turma'];
$id_formando = $_POST['id_formando'];
$sql_venda = mysqli_query($con, "update formandos SET album = '1' where id_formando = '$id_formando'");
echo "<script language=\"JavaScript\">
location.href=\"vendas_liberarfotos.php\";
</script>";
?>