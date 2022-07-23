<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id = $_GET['id'];

$x = $_POST['id_evento'];

//$y = $_POST['titulo'];

$i = 0;

foreach ($x as $value) {

	$id_evento = $_POST['id_evento'][$i];
	//$titulo = $_POST['titulo'][$i];
	
	if(!empty($id_evento)) { 

		$sql_consulta = mysqli_query($con, "select * from eventos_turma_lista where id_evento = '$id_evento' and id_turma = '$id'");
		$vetor_consulta = mysqli_fetch_array($sql_consulta);
		$vetor_consulta['id_evento'];

		if(mysqli_num_rows($sql_consulta) == 0) {
			
			if ($value == 2) {
				$sql_evento = mysqli_query($con, "insert into eventos_turma_lista (id_turma, id_evento, preevento) VALUES ('$id', '$id_evento', '1')");
			}else {			
				$sql_evento = mysqli_query($con, "insert into eventos_turma_lista (id_turma, id_evento) VALUES ('$id', '$id_evento')");
			}

		}

		if ((mysqli_num_rows($sql_consulta)>0)&($vetor_consulta['id_evento'] == 2)) {
			$cont = mysqli_num_rows($sql_consulta) + 1;
			$sql_evento = mysqli_query($con, "insert into eventos_turma_lista (id_turma, id_evento, preevento) VALUES ('$id', '$id_evento', '$cont')");	
		}
	}

	$i++;
	
}

echo"<script language=\"JavaScript\">location.href=\"alterarturma.php?id=$id#fotografia#eventosfotografia\";</script>";

?>