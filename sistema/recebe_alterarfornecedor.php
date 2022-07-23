<?php
	  
include"../includes/conexao.php";


function removeAcentos($string, $slug = false) {
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
  foreach ($ascii as $key=>$item) {
    $acentos = '';
    foreach ($item AS $codigo) $acentos .= chr($codigo);
    $troca[$key] = '/['.$acentos.']/i';
  }
  $string = preg_replace(array_values($troca), array_keys($troca), $string);
  // Slug?
  if ($slug) {
    // Troca tudo que não for letra ou número por um caractere ($slug)
    $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
    // Tira os caracteres ($slug) repetidos
    $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
    $string = trim($string, $slug);
  }
  return $string;
}
function camelCase($entrada){
	return ucwords(strtolower($entrada));
}
function reverse_date( $date )
        {
    return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
        }
		
		function moeda($get_valor) { 
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

  		$id = $_GET['id'];
		$nome = removeAcentos(ucwords(strtolower($_POST['nome'])));
		$nomefinal = strtr($nome, $map);
		$nomefinal1 = camelCase($nomefinal);
		$tipo = $_POST['tipo'];

		if($tipo == 1) {

			$datafinal = $_POST['datanasc'];
			$cpfcnpj = $_POST['cpfcnpj'];

		}

		if($tipo == 2) {

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

		$nomefant = removeAcentos($_POST['nomefant']);
		$nomefantfinal = strtr($nomefant, $map);
		$nomefantfinal1 = camelCase($nomefantfinal);
		
		$nomeresp = $_POST['nomeresp'];
		$nomerespfinal = strtr($nomeresp, $map);
		$nomerespfinal1 = camelCase($nomerespfinal);
		$inscmunicipal = $_POST['inscmunicipal'];
		$contribuinte = $_POST['contribuinte'];
		
		if (empty($contribuinte)) {
		$isento = 2;
		}
		else {
		$isento = 1;
		}
		
		$inscestadual = $_POST['inscestadual'];
		$inscsubst = $_POST['inscsubst'];
		$inscsuframa = $_POST['inscsuframa'];
		$cep = $_POST['cep'];
		$endereco = removeAcentos($_POST['endereco']);
		$enderecofinal = strtr($endereco, $map);
		$enderecofinal1 = strtoupper($enderecofinal);
		$numero = $_POST['numero'];
		$complemento = removeAcentos($_POST['complemento']);
		$complementofinal = strtr($endereco, $map);
		$complementofinal1 = strtoupper($complementofinal);
		$bairro = $_POST['bairro'];
		$bairrofinal = strtr($bairro, $map);
		$bairrofinal1 = camelCase($bairrofinal);
		$cidade =  removeAcentos($_POST['cidade']);
		$cidadefinal = strtr($cidade, $map);
		$cidadefinal1 = camelCase($cidadefinal);
		$estado = $_POST['estado'];
		$estadofinal = strtr($estado, $map);
		$estadofinal1 = strtoupper($estadofinal);
		$codigoibge = $_POST['codigoibge'];
		$pais = $_POST['pais'];
		$telefone = $_POST['telefone'];
		$celular = $_POST['celular'];
		$email = $_POST['email'];
		$tipocad = $_POST['tipocad'];
		$contrato = $_POST['contrato'];
		$diavenc = $_POST['diavenc'];
		$dataprimeiro = $_POST['dataprimeiro'];
		$boleto = $_POST['boleto'];
		$valorcontrato =  moeda($_POST['valorcontrato']);
		$anotacoes = $_POST['anotacoes'];  

		$classificacao = $_POST['classificacao'];
		$banco = $_POST['banco'];
		$agencia = $_POST['agencia'];
		$conta = $_POST['conta'];
		$tipoconta = $_POST['tipoconta']; 

		if($tipo == 1) {
		
		$sql = "update clientes SET nome='$nome', nomefant='$nomefant', tipo='$tipo', cpfcnpj='$cpfcnpj', datanasc='$datanasc', nomeresp='$nomeresp', inscmun='$inscmunicipal', isento = '$isento', inscest='$ie', inscestsubst='$inscsubst', inscsuframa='$inscsuframa', cep='$cep', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', pais='$pais', telefone='$telefone', celular='$celular', email='$email', anotacoes='$anotacoes', contrato='$contrato', diavenc='$diavenc', dataprimeiro='$dataprimeiro', boleto='$boleto', valorcontrato='$valorcontrato', classificacao='$classificacao', banco='$banco', agencia='$agencia', conta='$conta', tipoconta='$tipoconta' where id_cli = '$id'";
		
		$res = mysqli_query($con, $sql);

		} if($tipo == 2) {

		if($nomeimagem == NULL) {

		$sql = "update clientes SET nome='$nome', nomefant='$nomefant', tipo='$tipo', cpfcnpj='$cpfcnpj', datanasc='$datanasc', nomeresp='$nomeresp', inscmun='$inscmunicipal', isento = '$isento', inscest='$ie', inscestsubst='$inscsubst', inscsuframa='$inscsuframa', cep='$cep', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', pais='$pais', telefone='$telefone', celular='$celular', email='$email', anotacoes='$anotacoes', contrato='$contrato', diavenc='$diavenc', dataprimeiro='$dataprimeiro', boleto='$boleto', valorcontrato='$valorcontrato', classificacao='$classificacao', banco='$banco', agencia='$agencia', conta='$conta', tipoconta='$tipoconta' where id_cli = '$id'";
		
		$res = mysqli_query($con, $sql);

		} else { 

		$sql = "update clientes SET nome='$nome', nomefant='$nomefant', tipo='$tipo', cpfcnpj='$cpfcnpj', datanasc='$datanasc', logo='$logo', nomeresp='$nomeresp', inscmun='$inscmunicipal', isento = '$isento', inscest='$ie', inscestsubst='$inscsubst', inscsuframa='$inscsuframa', cep='$cep', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', pais='$pais', telefone='$telefone', celular='$celular', email='$email', anotacoes='$anotacoes', contrato='$contrato', diavenc='$diavenc', dataprimeiro='$dataprimeiro', boleto='$boleto', valorcontrato='$valorcontrato', classificacao='$classificacao', banco='$banco', agencia='$agencia', conta='$conta', tipoconta='$tipoconta' where id_cli = '$id'";
		
		$res = mysqli_query($con, $sql);

		}

		}
		
		$x = $_POST['categorias'];
		
		$i = 0;

		foreach($x as $key) {

			$categorias = $_POST['categorias'][$i];

			$sql_consulta = mysqli_query($con, "select * from fornecedor_categoria where id_categoria = '$categorias' and id_fornecedor = '$id'");

			if(mysqli_num_rows($sql_consulta) == 0) { 

			$sql_categorias = mysqli_query($con, "insert into fornecedor_categoria (id_categoria, id_fornecedor) VALUES ('$categorias', '$id')");

			}


			$i++;

		}
		
		
			echo"<script language=\"JavaScript\">
			location.href=\"cadastros_fornecedores.php\";
			</script>";
		
				
?>