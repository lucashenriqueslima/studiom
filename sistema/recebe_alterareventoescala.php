<?php 

include"../includes/conexao.php";


$id = $_GET['id'];
$id1 = $_GET['id1'];
$orientacoes = $_POST['orientacoes'];
$relatorioevento = $_POST['relatorioevento'];

$sql = mysqli_query($con, "update escala_eventos_itens SET orientacoes = '$orientacoes', relatorioevento='$relatorioevento' where id_escala_item = '$id'");

echo"<script language=\"JavaScript\">
location.href=\"alterarplanejamentoevento.php?id=$id1\";
</script>";

?>