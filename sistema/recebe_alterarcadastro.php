<?php
	  
include"../includes/conexao.php";


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

  		$id = $_GET['id'];
		$nome = ucwords(strtolower($_POST['nome']));
		$nomefant = $_POST['nomefant'];
		$cpfcnpj = $_POST['cpfcnpj'];
		$nomeresp = $_POST['nomeresp'];
		$inscmunicipal = $_POST['inscmunicipal'];
		$isento = $_POST['isento'];
		$ie = $_POST['inscestadual'];
		$inscsubst = $_POST['inscsubst'];
		$inscsuframa = $_POST['inscsuframa'];
		$cep = $_POST['cep'];
		$endereco = $_POST['endereco'];
		$numero = $_POST['numero'];
		$complemento = $_POST['complemento'];
		$bairro = $_POST['bairro'];
		$cidade = $_POST['cidade'];
		$estado = $_POST['estado'];
		$cep1 = $_POST['cep1'];
		$endereco1 = $_POST['endereco1'];
		$numero1 = $_POST['numero1'];
		$complemento1 = $_POST['complemento1'];
		$bairro1 = $_POST['bairro1'];
		$cidade1 = $_POST['cidade1'];
		$estado1 = $_POST['estado1'];
		$pais = $_POST['pais'];
		$telefone = $_POST['telefone'];
		$celular = $_POST['celular'];
		$email = $_POST['email'];
		$contrato = $_POST['contrato'];
		$diavenc = $_POST['diavenc'];
		$dataprimeiro = $_POST['dataprimeiro'];
		$valorcontrato =  moeda($_POST['valorcontrato']);
		$boleto = $_POST['boleto'];
		$anotacoes = $_POST['anotacoes'];  
		
		$sql = "update clientes SET nome='$nome', nomefant='$nomefant', cpfcnpj='$cpfcnpj', nomeresp='$nomeresp', inscmun='$inscmunicipal', isento = '$isento', inscest='$ie', inscestsubst='$inscsubst', inscsuframa='$inscsuframa', cep='$cep', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', pais='$pais', telefone='$telefone', celular='$celular', email='$email', anotacoes='$anotacoes', contrato='$contrato', diavenc='$diavenc', dataprimeiro='$dataprimeiro', boleto='$boleto', valorcontrato='$valorcontrato' where id_cli = '$id'";
		
		$res = mysqli_query($con, $sql);
		
		$sql_cliente = "select * from clientes where id_cli = '$id'";
		$res1 = mysqli_query($con, $sql_cliente);
		$vetor = mysqli_fetch_array($res1);
		
		if($vetor['tipocad'] == 1) {
		
			echo"<script language=\"JavaScript\">
			location.href=\"listarclientes.php\";
			</script>";
			
		} else {
		
			echo"<script language=\"JavaScript\">
			location.href=\"cadastros_fornecedores.php\";
			</script>";
		
		}
				
?>