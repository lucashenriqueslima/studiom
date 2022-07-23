<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$banco = $_POST['banco'];

$sql = mysqli_query($con, "update bancos SET banco='$banco' where cod = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"cadastros_cadbancos.php\";
</script>";

?>