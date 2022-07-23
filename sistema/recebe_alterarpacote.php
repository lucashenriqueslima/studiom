<?php
session_start();

include "../includes/conexao.php";
$id = $_GET['id'];
$id_turma = $_POST['id_turma'];
$dataabertura = $_POST['dataabertura'];
$termino = $_POST['termino'];
$dataencerramento = $_POST['dataencerramento'];
$dataentrega = $_POST['dataentrega'].'-15';
$desconto = $_POST['desconto'];
$tipocontrato = $_POST['tipocontrato'];
$valorcontrato = $_POST['valorcontrato'];
$tipopagamento = $_POST['tipopagamento'];
$tipopagamentocartao = $_POST['tipopagamentocartao'];
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
	$sql = mysqli_query($con, "update pacotes SET id_turma='$id_turma', dataabertura='$dataabertura', termino='$termino', dataentrega='$dataentrega', desconto='$desconto', tipoContrato = '$tipocontrato', valorContrato='$valorcontrato', tipopagamento='$tipopagamento', tipopagamentocartao='$tipopagamentocartao', arquivo='$imagem' where id_pacote = '$id'");
	$sql_grava = mysqli_query($con, "insert into arquivos_contratos (id_cliente, id_usuario, titulo, data, hora, tipo, emailcompra, arquivo) VALUES ('$id', '$_SESSION[id]', 'Documento Venda de Fotografia', '$data', '$horaatual', '1', '1', '$imagem')");
}else {
	$sql = mysqli_query($con, "update pacotes SET id_turma='$id_turma', dataabertura='$dataabertura', termino='$termino', dataentrega='$dataentrega', desconto='$desconto', tipoContrato = '$tipocontrato', valorContrato='$valorcontrato', tipopagamento='$tipopagamento', tipopagamentocartao='$tipopagamentocartao' where id_pacote = '$id'");
}
echo "<script language=\"JavaScript\">
	location.href=\"alterarpacote.php?id=$id\";
	</script>";
?>