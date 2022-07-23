<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];

$sql = mysqli_query($con, "update formandos SET status = '2' where id_formando = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"alterarturma.php?id=$id1\";
</script>";

?>