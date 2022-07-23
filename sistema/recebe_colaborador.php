<?php

include"../includes/conexao.php";


function moeda($get_valor) { 
                $source = array('.', ',');  
                $replace = array('', '.'); 
                $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
                return $valor; //retorna o valor formatado para gravar no banco 
}

$nome = ucwords(strtolower($_POST['nome']));
$cpfcnpj = $_POST['cpfcnpj'];
$rg = $_POST['rg'];
$datanasc = $_POST['datanasc'];
$localnasc = $_POST['localnasc'];
$estadonasc = $_POST['estadonasc'];
$carteiratrabalho = $_POST['carteiratrabalho'];
$seriecarteiratrabalho = $_POST['seriecarteiratrabalho'];
$tituloeleitor = $_POST['tituloeleitor'];
$zona = $_POST['zona'];
$secao = $_POST['secao'];
$estadosecao = $_POST['estadosecao'];
$orgaoemissor = $_POST['orgaoemissor'];
$dataemissao = $_POST['dataemissao'];
$certidaoreservista = $_POST['certidaoreservista'];
$seriereservista = $_POST['seriereservista'];
$categoria = $_POST['categoria'];
$pis = $_POST['pis'];
$datacadastro = $_POST['datacadastro'];
$nomepai = $_POST['nomepai'];
$telefonepai = $_POST['telefonepai'];
$nomemae = $_POST['nomemae'];
$telefonemae = $_POST['telefonemae'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$telefone = $_POST['telefone'];
$celular = $_POST['celular'];
$telefonerecado = $_POST['telefonerecado'];
$email = $_POST['email'];
$dataadmissao = $_POST['dataadmissao'];
$banco = $_POST['banco'];
$agencia = $_POST['agencia'];
$conta = $_POST['conta'];
$tipoconta = $_POST['tipoconta'];
$grauinstrucao = $_POST['grauinstrucao'];
$estadocivil = $_POST['estadocivil'];
$conjuge = $_POST['conjuge'];
$filhosmenores = $_POST['filhosmenores'];
$quantos = $_POST['quantos'];
$alergias = $_POST['alergias'];
$medicacao = $_POST['medicacao'];
$outros = $_POST['outros'];
$medico = $_POST['medico'];
$telefonemedico = $_POST['telefonemedico'];
$nomeemergencia1 = $_POST['nomeemergencia1'];
$telefoneemergencia1 = $_POST['telefoneemergencia1'];
$nomeemergencia2 = $_POST['nomeemergencia2'];
$telefoneemergencia2 = $_POST['telefoneemergencia2'];
$outrasinformacoes = $_POST['outrasinformacoes'];
$funcao = $_POST['funcao'];
$nponto = $_POST['nponto'];
$dataexame = $_POST['dataexame'];
$apto = $_POST['apto'];
$cbo = $_POST['cbo'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$salario =  moeda($_POST['salario']);
$por = $_POST['por'];
$contratoexperiencia = $_POST['contratoexperiencia'];
$periodoexperiencia = $_POST['periodoexperiencia'];
$armario = $_POST['armario'];
$observacoes = $_POST['observacoes'];

$sql = mysqli_query($con, "insert into colaboradores (nome, cpfcnpj, rg, orgaoemissor, dataemissao, certidaoreservista, seriereservista, categoria, pis, datacadastro, datanasc, localnasc, estadonasc, carteiratrabalho, seriecarteiratrabalho, tituloeleitor, zona, secao, estadosecao, nomepai, telefonepai, nomemae, telefonemae, cep, endereco, numero, complemento, bairro, cidade, estado, telefone, celular, telefonerecado, email, dataadmissao, banco, agencia, conta, tipoconta, grauinstrucao, estadocivil, conjuge, filhosmenores, quantos, alergias, medicacao, outros, medico, telefonemedico, nomeemergencia1, telefoneemergencia1, nomeemergencia2, telefoneemergencia2, outrasinformacoes, funcao, nponto, dataexame, apto, cbo, salario, por, contratoexperiencia, periodoexperiencia, armario, observacoes, status) VALUES ('$nome', '$cpfcnpj', '$rg', '$orgaoemissor', '$dataemissao', '$certidaoreservista', '$seriereservista', '$categoria', '$pis', '$datacadastro', '$datanasc', '$localnasc', '$estadonasc', '$carteiratrabalho', '$seriecarteiratrabalho', '$tituloeleitor', '$zona', '$secao', '$estadosecao', '$nomepai', '$telefonepai', '$nomemae', '$telefonemae', '$cep', '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$telefone', '$celular', '$telefonerecado', '$email', '$dataadmissao', '$banco', '$agencia', '$conta', '$tipoconta', '$grauinstrucao', '$estadocivil', '$conjuge', '$filhosmenores', '$quantos', '$alergias', '$medicacao', '$outros', '$medico', '$telefonemedico', '$nomeemergencia1', '$telefoneemergencia1', '$nomeemergencia2', '$telefoneemergencia2', '$outrasinformacoes', '$funcao', '$nponto', '$dataexame', '$apto', '$cbo', '$salario', '$por', '$contratoexperiencia', '$periodoexperiencia', '$armario', '$observacoes', '1')");

$id_gerado_cad = $con->insert_id;

$i = 0;

if($filhosmenores == 1) {

$diretorio = "arquivos/";

	foreach($_POST['nomefilho'] as $key) {

		$nomefilho = $_POST['nomefilho'][$i];
		$datanascfilho = $_POST['datanascfilho'][$i];
		$nomeimagem = $_FILES['anexos']['name'][$i];  
		$tmp = $_FILES['anexos']['tmp_name'][$i];
		$ext = strrchr($nomeimagem, '.'); 
		$imagem = time().uniqid(md5()).$ext;
		$upload = $diretorio.$imagem;
		move_uploaded_file($tmp, $upload);

		$sql_grava = mysqli_query($con, "insert into filhos_colaboradores (id_colaborador, nome, datanasc, imagem) VALUES ('$id_gerado_cad', '$nomefilho', '$datanascfilho', '$imagem')");
		
		$i++;

	}

}

$sql_usuario = "insert into usuarios (tipocad, id_colaborador, nome, usuario, senha) VALUES ('1', '$id_gerado_cad', '$nome', '$usuario', '$senha')";
$res_usuario = mysqli_query($con, $sql_usuario) or die (mysqli_error($con));

echo"<script language=\"JavaScript\">
			location.href=\"rh_colaboradores.php\";
			</script>";

?>