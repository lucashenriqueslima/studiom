<?php

session_start();

include"../includes/conexao.php";




$tipo = $_POST['tipo'];

if($tipo == 1) { 

$id_oportunidade = $_POST['id_oportunidade'];

} if($tipo == 2) { 
	
$id_oportunidade = $_POST['id_turma'];

}

$qtdformandos = $_POST['qtdformandos'];
$data = date('Y-m-d');
$hora = date('H:i:s');

$sql = mysqli_query($con, "insert into orcamento_convite (id_vendedor, tipo, id_oportunidade, qtdformandos, data, hora, valortotal, status) VALUES ('$_SESSION[id]', '$tipo', '$id_oportunidade', '$qtdformandos', '$data', '$hora', '0.00', '1')");

$id = $con->insert_id;

echo"<script language=\"JavaScript\">
location.href=\"cadastroorcconvite_produtos.php?id=$id\";
</script>";

?>