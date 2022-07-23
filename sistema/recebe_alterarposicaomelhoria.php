<?php 



include"../includes/conexao.php";


$id = $_GET['id'];
$posicao = $_POST['posicao'];
$dataatual = date('Y-m-d');

$sql = mysqli_query($con, "update suporte SET posicao = '$posicao' where id = '$id'");
$vetor = mysqli_fetch_array($sql);

echo"<script language=\"JavaScript\">
location.href=\"ajustes_evolucoes.php\";
</script>";

?>