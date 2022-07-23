<?php

include"../includes/conexao.php";

$id = $_GET[ 'id' ];
$res2 = mysqli_query($con, "delete FROM pacotes_itens_album where id_item = '$id'");
echo "OK";
?>