<?php
session_start();
include "../includes/conexao.php";

$id = $_POST['id'];
$contrato = $_POST['contrato'];
if($contrato != ''){
    mysqli_query($con, "update leads set contrato_fechado='$contrato' where id_lead = '$id'");
}

?>