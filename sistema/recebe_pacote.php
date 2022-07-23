<?php
session_start();

include "../includes/conexao.php";
$id_turma = $_POST['id_turma'];
$dataabertura = $_POST['dataabertura'];
$termino = $_POST['termino'];
$dataentrega = $_POST['dataentrega'].'-15';
$desconto = $_POST['desconto'];
$tipocontrato = $_POST['tipocontrato'];
$valorcontrato = $_POST['valorcontrato'];
$tipopagamento = $_POST['tipopagamento'];
$tipopagamentocartao = $_POST['tipopagamentocartao'];
$tipo = 2;
$data = date('Y-m-d');
$horaatual = date('H:i:s');
$diretorio = "arquivos/";
$nomeimagem = $_FILES['arquivo']['name'];
$tmp = $_FILES['arquivo']['tmp_name'];
$ext = strrchr($nomeimagem, '.');
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);
if (!empty($nomeimagem)) {
	$sql = mysqli_query($con, "insert into pacotes (id_turma, tipo, dataabertura, termino, dataentrega, desconto, tipopagamento, tipopagamentocartao, arquivo, tipoContrato, valorContrato) VALUES ('$id_turma', '$tipo', '$dataabertura', '$termino', '$dataentrega', '$desconto', '$tipopagamento', '$tipopagamentocartao', '$imagem' , '$tipocontrato', '$valorcontrato')");
	$id_cadastro = $con->insert_id;
	$sql_grava = mysqli_query($con, "insert into arquivos_contratos (id_cliente, id_usuario, titulo, data, hora, tipo, emailcompra, arquivo) VALUES ('$id_turma', '$_SESSION[id]', 'Documento Venda de Fotografia', '$data', '$horaatual', '1', '1', '$imagem')");
}else {
	$sql = mysqli_query($con, "insert into pacotes (id_turma, tipo, dataabertura, termino, dataentrega, desconto, tipopagamento, tipopagamentocartao, tipoContrato, valorContrato) VALUES ('$id_turma', '$tipo', '$dataabertura', '$termino', '$dataentrega', '$desconto', '$tipopagamento', '$tipopagamentocartao' , '$tipocontrato', '$valorcontrato')");
	$id_cadastro = $con->insert_id;
}
echo "<script language=\"JavaScript\">
	location.href=\"alterarpacote.php?id=$id_cadastro\";
	</script>";
?>