<?php
include "../includes/conexao.php";
$nome = ucwords(strtolower($_POST['nome']));
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];
$regiao = $_POST['regiao'];
$sigla = $_POST['sigla'];
$administracao = $_POST['administracao'];
$site = $_POST['site'];
$telefone = $_POST['telefone'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
$xml = simplexml_load_file('https://maps.googleapis.com/maps/api/distancematrix/xml?origins=74083120&destinations='.$cep.'&key=AIzaSyBe4D_Okn4llVtf1iIhLiVTaadViDgAmzw');
foreach ($xml->row as $rows) {
	$total1 = $rows->element->distance->value;
	$totalkm1 = $total1 / 1000;
}
$distancia = $_POST['distancia'];
$sql = mysqli_query($con, "insert into instituicoes (nome, estado, cidade, regiao, sigla, administracao, site, telefone, cep, endereco, distancia, complemento, bairro) VALUES ('$nome', '$estado', '$cidade', '$regiao', '$sigla', '$administracao', '$site', '$telefone', '$cep', '$endereco', '$distancia', '$complemento', '$bairro')");
echo "<script language=\"JavaScript\">
location.href=\"cadastros_instituicao.php\";
</script>";
?>