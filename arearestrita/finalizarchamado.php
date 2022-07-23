<?php 

session_start();



include"../includes/conexao.php";


$id = $_GET['id'];

$sql = mysqli_query($con, "update chamados SET status = '3' where id_chamado = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"verchamado.php?id=$id\";
</script>";

?>