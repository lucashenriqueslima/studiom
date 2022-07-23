<?php
include "../includes/conexao.php";
// $conclusao = $_POST['conclusao'];
// $oe = $_POST['oe'];
// $localnasc = $_POST['localnasc'];
// $observacao = $_POST['observacao'];
// $tipo = $_POST['tipo'];
// $tipo1 = $_POST['tipo1'];
$cargo = (isset($_POST['cargo']) ? $_POST['cargo'] : null);
$facebook = $_POST['facebook'];
$outroresponsavel = (isset($_POST['outroresponsavel']) ? $_POST['outroresponsavel'] : null);
$nome = htmlspecialchars(ucwords(strtolower($_POST['nome'])));
$sexo = $_POST['sexo'];
$estadocivil = $_POST['estadocivil'];
$cpf = $_POST['cpf'];
$rg = $_POST['rg'];
$datanasc = $_POST['datanasc'];
$turma = $_POST['turma'];
$cep = $_POST['cep'];
$endereco = htmlspecialchars($_POST['endereco']);
$numero = $_POST['numero'];
$complemento = htmlspecialchars($_POST['complemento']);
$bairro = htmlspecialchars($_POST['bairro']);
$cidade = htmlspecialchars($_POST['cidade']);
$estado = $_POST['estado'];
$telefone = $_POST['telefone'];
$celular = $_POST['celular'];
$email = $_POST['email'];
$email1 = $_POST['email1'];
$pai = htmlspecialchars($_POST['pai']);
$telresidencial1 = $_POST['telresidencial1'];
$emailpai = $_POST['emailpai'];
$emailmae = $_POST['emailmae'];
$mae = htmlspecialchars($_POST['mae']);
$cep1 = $_POST['cep1'];
$endereco1 = htmlspecialchars($_POST['endereco1']);
$numero1 = $_POST['numero1'];
$complemento1 = htmlspecialchars($_POST['complemento1']);
$bairro1 = htmlspecialchars($_POST['bairro1']);
$cidade1 = htmlspecialchars($_POST['cidade1']);
$estado1 = $_POST['estado1'];
$celularpai = $_POST['celularpai'];
$celularmae = $_POST['celularmae'];
$telresidencial = $_POST['telresidencial'];
$cep2 = $_POST['cep2'];
$endereco2 = htmlspecialchars($_POST['endereco2']);
$complemento2 = htmlspecialchars($_POST['complemento2']);
$numero2 = $_POST['numero2'];
$bairro2 = htmlspecialchars($_POST['bairro2']);
$cidade2 = $_POST['cidade2'];
$estado2 = $_POST['estado2'];
$nomeresponsavel = $_POST['nomeresponsavel'];
$telefoneresponsavel = $_POST['telefoneresponsavel'];
$tiporesponsavel = $_POST['tiporesponsavel'];
$comissaoexplode = explode("_", $_POST['comissao']);
$comissão = $comissaoexplode[0];
$instagram = $_POST['instagram'];
if ($_POST['mostrarpai']) {
	$mostrarpai = 1;
}else {
	$mostrarpai = 0;
}
if ($_POST['inmemorianpai']) {
	$inmemorianpai = 1;
}else {
	$inmemorianpai = 0;
}
if ($_POST['inmemorianmae']) {
	$inmemorianmae = 1;
}else {
	$inmemorianmae = 0;
}
$diretorio = "sistema/arquivos/";
if (isset($_FILES['imagem'])) {
	$nomeimagem = $_FILES['imagem']['name']; // tratar
	$tmp = $_FILES['imagem']['tmp_name']; // tratar
	$ext = substr($nomeimagem, -4, 4); // vai retornar a extensão final do arquivo ex: ".png"
	$newnome = date("Ymdhis").md5($nomeimagem);
	$nomefinalfoto = $newnome.$ext;
	$upload = $diretorio.$newnome.$ext;
	move_uploaded_file($tmp, $upload);
}else {
	$nomefinalfoto = 'erro'.$cpf.'.txt';
}
$sql_consulta1 = mysqli_query($con, "select * from formandos where cpf = '$cpf'");
$vetor_consulta1 = mysqli_fetch_array($sql_consulta1);
if (mysqli_num_rows($sql_consulta1) != 0) {
	echo "<script> alert('CPF ja cadastrado em nosso sistema.')</script>";
	echo "<script> window.location.href='javascript:window.history.go(-1)'</script>";
}else {
	$sql_consulta = mysqli_query($con, "select * from formandos where turma = '$turma' order by id_formando DESC limit 0,1");
	$vetor_consulta = mysqli_fetch_array($sql_consulta);
	$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$turma'");
	$vetor_turma = mysqli_fetch_array($sql_turma);
	$id_cadastro = $vetor_consulta['id_cadastro'] + 1;
	$sql = mysqli_query($con, "insert into formandos (id_cadastro, conclusao, nome, estadocivil, sexo, localnasc, cpf, rg, oe, datanasc, turma, cep, endereco, numero, complemento, bairro, cidade, estado, telefone, celular, email, senha, email1,mostrarpai, observacoes, emailpai, pai, tipo1, mae, cep1, endereco1, numero1, complemento1, bairro1, cidade1, estado1, celularpai, celularmae, telresidencial, telresidencial1, emailmae, cep2, endereco2, complemento2, numero2, bairro2, cidade2, estado2, nomeresponsavel, telefoneresponsavel, tiporesponsavel, outroresponsavel, comissao, cargo, status, facebook, instagram, inmemorianpai, inmemorianmae) VALUES ('$id_cadastro', '$vetor_turma[ano]', '$nome', '$estadocivil', '$sexo', '', '$cpf', '$rg', '', '$datanasc', '$turma', '$cep', '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$telefone', '$celular', '$email', '$cpf', '$email1','$mostrarpai', '', '$emailpai', '$pai', '', '$mae', '$cep1', '$endereco1', '$numero1', '$complemento1', '$bairro1', '$cidade1', '$estado1', '$celularpai', '$celularmae', '$telresidencial', '$telresidencial1', '$emailmae', '$cep2', '$endereco2', '$complemento2', '$numero2', '$bairro2', '$cidade2', '$estado2', '$nomeresponsavel', '$telefoneresponsavel', '$tiporesponsavel', '$outroresponsavel', '$comissao', '$cargo', '1', '$facebook', '$instagram', '$inmemorianpai', '$inmemorianmae')") or die (mysqli_error($con));
}
echo "<script language=\"JavaScript\">
location.href=\"cadastros_formandos.php\";
</script>";
?>