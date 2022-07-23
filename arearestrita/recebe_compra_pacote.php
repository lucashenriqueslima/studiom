<?php

session_start();

$id = $_GET['id'];
$produto = $_POST['produto'];

if($produto == 1) { 

echo"<script language=\"JavaScript\">
location.href=\"compra_etapa_pagamento.php?id=$id\";
</script>";

} if($produto == 2) { 

echo"<script language=\"JavaScript\">
location.href=\"compra_produtos_adicionais.php?id=$id\";
</script>";

}

?>