<?php

function moeda($get_valor) { 
    $source = array('.', ',');  
    $replace = array('', '.'); 
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
    return $valor; //retorna o valor formatado para gravar no banco 
}

include"../includes/conexao.php";


$id = $_GET['id'];
$tipo = $_POST['tipo'];
$nome = ucwords(strtolower($_POST['nome']));
$ncontrato = $_POST['ncontrato'];
$curso = $_POST['curso'];
$ano = $_POST['ano'];
$qtdformandos = $_POST['qtdformandos'];
$qtdcomissao = $_POST['qtdcomissao'];
$qtdalunos = $_POST['qtdalunos'];
$id_instituicao = $_POST['id_instituicao'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$mesrealizacao = $_POST['mesrealizacao'];
$anorealizacao = $_POST['anorealizacao'];
$turma = $_POST['turma'];
$valorfoto = moeda($_POST['valorfoto']);
$valorfoto1 = moeda($_POST['valorfoto1']);
$valorencadernacao = moeda($_POST['valorencadernacao']);
$valoralbum = moeda($_POST['valoralbum']);
$emailcomissao = $_POST['emailcomissao'];
$cerimonial = $_POST['cerimonial'];
$telefonecerimonial = $_POST['telefonecerimonial'];
$nomeresponsavel = $_POST['nomeresponsavel'];
$telefoneresponsavel = $_POST['telefoneresponsavel'];
$observacoes = $_POST['observacoes'];
$preevento = $_POST['preevento'];

$diretorio = "arquivos/";
$nomeimagem = $_FILES['logo']['name'];  
$tmp = $_FILES['logo']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$sql_cursos = mysqli_query($con, "select * from cursos where id_curso = '$curso'");
$vetor_curso = mysqli_fetch_array($sql_cursos);

$sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$id_instituicao'");
$vetor_instituicao = mysqli_fetch_array($sql_instituicao);

$sql = mysqli_query($con, "update turmas SET tipo='$tipo', nome='$vetor_curso[nome]', ncontrato='$ncontrato', curso='$curso', ano='$ano', qtdformandos='$qtdformandos', qtdcomissao='$qtdcomissao', qtdalunos='$qtdalunos', id_instituicao='$id_instituicao', mesrealizacao='$mesrealizacao', anorealizacao='$anorealizacao', turma='$turma', valorfoto='$valorfoto', valorfoto1='$valorfoto1', valorencadernacao='$valorencadernacao', valoralbum='$valoralbum', emailcomissao='$emailcomissao', cerimonial='$cerimonial', telefonecerimonial='$telefonecerimonial', nomeresponsavel='$nomeresponsavel', telefoneresponsavel='$telefoneresponsavel', logo='$imagem', observacoes='$observacoes', preevento='$preevento' where id_turma = '$id'")  or die (mysqli_error($con));

$x = $_POST['id_evento'];

$i = 0;

foreach ($x as $value) {

	$id_evento = $_POST['id_evento'][$i];

	if(!empty($id_evento)) { 

	$sql_consulta = mysqli_query($con, "select * from eventos_turma_lista where id_evento = '$id_evento' and id_turma = '$id'");

	if(mysqli_num_rows($sql_consulta) == 0) {

	$sql_evento = mysqli_query($con, "insert into eventos_turma_lista (id_turma, id_evento) VALUES ('$id', '$id_evento')");

	}

	}

	$i++;
	
}

echo"<script language=\"JavaScript\">
location.href=\"alterarturma.php?id=$id\";
</script>";

?>