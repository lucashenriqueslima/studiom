<?php
include "../includes/conexao.php";
session_start();
function removeAcentos($string, $slug = false)
{
	$string = strtolower($string);
	// Código ASCII das vogais
	$ascii['a'] = range(224, 230);
	$ascii['e'] = range(232, 235);
	$ascii['i'] = range(236, 239);
	$ascii['o'] = array_merge(range(242, 246), array(240, 248));
	$ascii['u'] = range(249, 252);
	// Código ASCII dos outros caracteres
	$ascii['b'] = array(223);
	$ascii['c'] = array(231);
	$ascii['d'] = array(208);
	$ascii['n'] = array(241);
	$ascii['y'] = array(253, 255);
	foreach ($ascii as $key => $item) {
		$acentos = '';
		foreach ($item as $codigo) {
			$acentos .= chr($codigo);
		}
		$troca[$key] = '/['.$acentos.']/i';
	}
	$string = preg_replace(array_values($troca), array_keys($troca), $string);
	// Slug?
	if ($slug) {
		// Troca tudo que não for letra ou número por um caractere ($slug)
		$string = preg_replace('/[^a-z0-9]/i', $slug, $string);
		// Tira os caracteres ($slug) repetidos
		$string = preg_replace('/'.$slug.'{2,}/i', $slug, $string);
		$string = trim($string, $slug);
	}
	return $string;
}

function reverse_date($date)
{
	return (strstr($date, '-')) ? implode('/', array_reverse(explode('-', $date))) : implode('-', array_reverse(explode('/', $date)));
}

function moeda($get_valor)
{
	$source = array('.', ',');
	$replace = array('', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
}

$map = array(
	'á' => 'a',
	'à' => 'a',
	'ã' => 'a',
	'â' => 'a',
	'é' => 'e',
	'ê' => 'e',
	'í' => 'i',
	'ó' => 'o',
	'ô' => 'o',
	'õ' => 'o',
	'ú' => 'u',
	'ü' => 'u',
	'ç' => 'c',
	'Á' => 'A',
	'À' => 'A',
	'Ã' => 'A',
	'Â' => 'A',
	'É' => 'E',
	'Ê' => 'E',
	'Í' => 'I',
	'Ó' => 'O',
	'Ô' => 'O',
	'Õ' => 'O',
	'Ú' => 'U',
	'Ü' => 'U',
	'Ç' => 'C'
);

function camelCase($entrada){
	return ucwords(strtolower($entrada));
}

$nome = removeAcentos(ucwords(strtolower($_POST['nome'])));
$nomefinal = strtr($nome, $map);
$nomefinal1 = camelCase($nomefinal);
$tipo = $_POST['tipo'];
if ($tipo == 1) {
	$datafinal = $_POST['datanasc'];
	$cpfcnpj = $_POST['cpfcnpj'];
	$imagem = '';
}
if ($tipo == 2) {
	$datafinal = $_POST['datanasc1'];
	$cpfcnpj = $_POST['cpfcnpj1'];
	$diretorio = "arquivos/";
	$nomeimagem = $_FILES['logo']['name'];
	$tmp = $_FILES['logo']['tmp_name'];
	$ext = strrchr($nomeimagem, '.');
	$imagem = time().uniqid(md5()).$ext;
	$upload = $diretorio.$imagem;
	move_uploaded_file($tmp, $upload);
}
$nomeresp = $_POST['nomeresp'];
$nomerespfinal = strtr($nomeresp, $map);
$nomerespfinal1 = camelCase($nomerespfinal);
$cep = $_POST['cep'];
$endereco = removeAcentos($_POST['endereco']);
$enderecofinal = strtr($endereco, $map);
$enderecofinal1 = camelCase($enderecofinal);
$numero = $_POST['numero'];
$complemento = removeAcentos($_POST['complemento']);
$complementofinal = strtr($endereco, $map);
$complementofinal1 = camelCase($complementofinal);
$bairro = $_POST['bairro'];
$bairrofinal = strtr($bairro, $map);
$bairrofinal1 = camelCase($bairrofinal);
$cidade = removeAcentos($_POST['cidade']);
$cidadefinal = strtr($cidade, $map);
$cidadefinal1 = camelCase($cidadefinal);
$estado = $_POST['estado'];
$estadofinal = strtr($estado, $map);
$estadofinal1 = strtoupper($estadofinal);
$codigoibge = $_POST['codigoibge'];
$telefone = $_POST['telefone'];
$celular = $_POST['celular'];
$email = $_POST['email'];
$tipocad = $_POST['tipocad'];
$anotacoes = $_POST['anotacoes'];
$classificacao = $_POST['classificacao'];
$banco = $_POST['banco'];
$agencia = $_POST['agencia'];
$conta = $_POST['conta'];
$tipoconta = $_POST['tipoconta'];
$res = mysqli_query($con, "insert into clientes (nome, tipo, cpfcnpj, datanasc, logo, nomeresp, cep, endereco, numero, complemento, bairro, cidade, codigoibge, estado, telefone, celular, email, tipocad, anotacoes, classificacao, banco, agencia, conta, tipoconta) VALUES
('$nomefinal1', '$tipo', '$cpfcnpj', '$datafinal', '$imagem', '$nomerespfinal1', '$cep', '$enderecofinal1', '$numero', '$complementofinal1', '$bairrofinal1', '$cidadefinal1', '$codigoibge', '$estadofinal1','$telefone', '$celular', '$email', '$tipocad', '$anotacoes', '$classificacao', '$banco', '$agencia', '$conta', '$tipoconta')");
$id_gerado = $con->insert_id;
$x = $_POST['categorias'];
$i = 0;
foreach ($x as $key) {
	$categorias = $_POST['categorias'][$i];
	$sql_categorias = mysqli_query($con, "insert into fornecedor_categoria (id_categoria, id_fornecedor) VALUES ('$categorias', '$id_gerado')");
	$i++;
}
echo "<script language=\"JavaScript\">
			location.href=\"cadastros_fornecedores.php\";
			</script>";
?>