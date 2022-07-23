<?php 

session_start();

include"../includes/conexao.php";


$id_item = $_GET['id_item'];
$foto = $_POST['foto'];


$sql = mysqli_query($con, "update escolha_fotos_itens SET foto = '$foto', status = '2' where id_item = '$id_item'");

echo"<script>opener.location.reload(); window.close();</script>";

?>