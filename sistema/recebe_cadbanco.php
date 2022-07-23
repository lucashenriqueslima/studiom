<?php
include "../includes/conexao.php";
$banco = $_POST['banco'];
$sql = mysqli_query($con, "insert into bancos (banco) VALUES ('$banco')");
echo "<script language=\"JavaScript\">
location.href=\"cadastros_cadbancos.php\";
</script>";
?>