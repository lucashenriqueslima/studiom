<?php

session_start();



include"../includes/conexao.php";


function moeda($get_valor) { 
                $source = array('.', ',');  
                $replace = array('', '.'); 
                $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
                return $valor; //retorna o valor formatado para gravar no banco 
}

$titulo = ucwords(strtolower($_POST['titulo']));
$datainicio = $_POST['datainicio'];
$datafim = $_POST['datafim'];
$tipo = $_POST['tipo'];
$status = $_POST['status'];
$investimento = moeda($_POST['investimento']);
$descricao = $_POST['descricao'];
$ativa = $_POST['ativa'];

$sql = mysqli_query($con, "insert into campanhas (titulo, datainicio, datafim, tipo, status, investimento, descricao, ativa) VALUES ('$titulo', '$datainicio', '$datafim', '$tipo', '$status', '$investimento', '$descricao', '$ativa')");

echo"<script language=\"JavaScript\">
location.href=\"comercial_campanhas.php\";
</script>";

?>