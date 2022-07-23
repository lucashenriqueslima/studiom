<?php

include"../includes/conexao.php";


$id = $_GET['id'];

$sql = mysqli_query($con, "update formandos SET status = '1' where id_formando = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"cadastros_formandos.php\";
</script>";

?>