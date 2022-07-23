<?php

include"../includes/conexao.php";




$id_convite = $_POST['id_convite'];
$data = date('Y-m-d');

$x = $_POST['id_item'];

$i = 0;

foreach($x as $key) {

	$id_item = $_POST['id_item'][$i];
	$descricao = addslashes($_POST['descricao'][$i]);
	$status = $_POST['status'][$i];

	$sql = mysqli_query($con, "update meu_convite_paginas SET descricao = '$descricao', status = '$status' where id_pagina = '$id_item'");

	$i++;

}

$sql_consulta = mysqli_query($con, "SELECT * FROM meu_convite_paginas WHERE id_meuconvite = '$id_convite' and  bloqueio <> 2 and status <> 1"); // Somente itens com alterações
if(mysqli_num_rows($sql_consulta) > 0){
    $sql_consulta = mysqli_query($con, "SELECT * FROM meu_convite_paginas WHERE id_meuconvite = '$id_convite' and  bloqueio <> 2 and status <> 2"); // Itens que não tenham sidos finalizados
    if(mysqli_num_rows($sql_consulta) > 0) {
        $sql_consulta = mysqli_query($con, "SELECT * FROM meu_convite_paginas WHERE id_meuconvite = '$id_convite' and  bloqueio <> 2 and status = 1"); // Itens sem alterações
        if(mysqli_num_rows($sql_consulta) == 0) {
            $sql_update = mysqli_query($con, "update meu_convite SET status = '3', dataaprovacao = '$data' where id_meuconvite = '$id_convite'");
        }else{
            $sql_update = mysqli_query($con, "update meu_convite SET status = '2' where id_meuconvite = '$id_convite'");
        }
    }else{
        $sql_update = mysqli_query($con, "update meu_convite SET status = '4', dataaprovacao = '$data' where id_meuconvite = '$id_convite'");
    }
}else{
    $sql_update = mysqli_query($con, "update meu_convite SET status = '1' where id_meuconvite = '$id_convite'");
}

echo"<script language=\"JavaScript\">
location.href=\"formularioconvite.php?id=$id_convite\";
</script>";

?>