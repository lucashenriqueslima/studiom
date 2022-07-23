<?php

include"../includes/conexao.php";


$id = $_GET['id'];

$x = $_POST['id_pagina'];

$i = 0;

foreach ($x as $value) {

	$id_pagina = $_POST['id_pagina'][$i];
	$listar = $_POST['listar'][$i];
	$cadastro = $_POST['cadastro'][$i];
	$alteracao = $_POST['alteracao'][$i];
	$exclusao = $_POST['exclusao'][$i];

	$sql_consulta = mysqli_query($con, "select * from paginas_permissoes where id_usuario = '$id' and id_pagina = '$id_pagina'");

	if(mysqli_num_rows($sql_consulta) == 0) { 

		$sql_grava = mysqli_query($con, "insert into paginas_permissoes (id_usuario, id_pagina, listar, cadastro, alteracao, exclusao) VALUES ('$id', '$id_pagina', '$listar', '$cadastro', '$alteracao', '$exclusao')");

	} else { 

		$sql_atualiza = mysqli_query($con, "update paginas_permissoes SET listar='$listar', cadastro='$cadastro', alteracao='$alteracao', exclusao='$exclusao' where id_usuario = '$id' and id_pagina = '$id_pagina'");

	}

	$i++;
	
}

echo"<script language=\"JavaScript\">
location.href=\"liberarpermissoes.php?id=$id\";
</script>";

?>