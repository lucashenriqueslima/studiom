<?php

include"../includes/conexao.php";


$sql = mysqli_query($con, "select * from formandos where senha IS NULL or senha = '' order by nome ASC");

$i = 0;

while($vetor = mysqli_fetch_array($sql)) {

	$sql_update = mysqli_query($con, "update formandos SET senha = '$vetor[cpf]' where id_formando = '$vetor[id_formando]'");

	echo $i.' - '.$vetor['nome'].': Atualizado com sucesso a senha';
	echo "<br>";

	$i++;

}