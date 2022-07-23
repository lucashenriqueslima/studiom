<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";

$id = $_GET['id'];
$id1 = $_GET['id1'];
if(isset($_GET['id_item'])){
	$id_tipo=$_GET['tipo'];
	$id_item = $_GET['id_item'];
	$res_ref = mysqli_query($con, "UPDATE pacotes_itens SET status='0' WHERE id_item='{$id_item}'");
	echo"<script language=\"JavaScript\">
location.href=\"alterarprodutopacoteitem.php?&id=$id&id1=$id1&tipo=$id_tipo\";
</script>";
}else{
	$id_tipo = $_POST['id_tipo'];
	$i = 0;
	foreach ($_POST['id_item'] as $key){
		$id_item = $_POST['id_item'][$i];
		$qtdminima = $_POST['qtdminima'][$i];
		$valorun = moeda($_POST['valorun'][$i]);
		if($id_item == ''){
			$res_ref = mysqli_query($con, "INSERT INTO pacotes_itens (id_pacote,id_tipo,qtdminima,valorun,status)VALUES('{$id}','{$id_tipo}','{$qtdminima}','{$valorun}','1')");
		}else{
			$res_ref = mysqli_query($con, "update pacotes_itens SET qtdminima='{$qtdminima}', valorun='{$valorun}' where id_item = '{$id_item}'");
		}
		$i++;
	}
	echo"<script language=\"JavaScript\">
location.href=\"alterarproduto.php?&id=$id1\";
</script>";
}




?>