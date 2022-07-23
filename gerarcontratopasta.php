<?php

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');


include"includes/conexao.php";

require 'vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$id = $_GET['id'];

$data = date('Y-m-d');
$hora = date('H:i:s');

$sql = mysqli_query($con, "select * from contratos_convite where id_contrato = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_orcamento = mysqli_query($con, "select * from orcamento_convite where id_orcamento = '$vetor[id_orcamento]'");
$vetor_orcamento = mysqli_fetch_array($sql_orcamento);

if($vetor_orcamento['tipo'] == 1) {

$sql_oportunidade = mysqli_query($con, "select * from oportunidades where id_oportunidade = '$vetor_orcamento[id_oportunidade]'");
$vetor_oportunidade = mysqli_fetch_array($sql_oportunidade);

$sql_mkt = mysqli_query($con, "select * from prospeccao where id_prospeccao = '$vetor_oportunidade[id_prospeccao]'");
$vetor_mkt = mysqli_fetch_array($sql_mkt);

$sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '$vetor_mkt[id_turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[id_curso]'");
$vetor_curso = mysqli_fetch_array($sql_curso);

$sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
$vetor_instituicao = mysqli_fetch_array($sql_instituicao);

} if($vetor_orcamento['tipo'] == 2) {

$sql_oportunidade = mysqli_query($con, "select * from turmas where id_turma = '$vetor_orcamento[id_oportunidade]'");
$vetor_oportunidade = mysqli_fetch_array($sql_oportunidade);

$sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_oportunidade[id_instituicao]'");
$vetor_instituicao = mysqli_fetch_array($sql_instituicao);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_oportunidade[curso]'");
$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

}

class Monetary {
    private static $unidades = array("um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze",
                                     "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove");
    private static $dezenas = array("dez", "vinte", "trinta", "quarenta","cinqüenta", "sessenta", "setenta", "oitenta", "noventa");
    private static $centenas = array("cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", 
                                     "seiscentos", "setecentos", "oitocentos", "novecentos");
    private static $milhares = array(
        array("text" => "mil", "start" => 1000, "end" => 999999, "div" => 1000),
        array("text" => "milhão", "start" =>  1000000, "end" => 1999999, "div" => 1000000),
        array("text" => "milhões", "start" => 2000000, "end" => 999999999, "div" => 1000000),
        array("text" => "bilhão", "start" => 1000000000, "end" => 1999999999, "div" => 1000000000),
        array("text" => "bilhões", "start" => 2000000000, "end" => 2147483647, "div" => 1000000000)        
    );
    const MIN = 0.01;
    const MAX = 2147483647.99;
    const MOEDA = " real ";
    const MOEDAS = " reais ";
    const CENTAVO = " centavo ";
    const CENTAVOS = " centavos ";    
     
    static function numberToExt($number, $moeda = true) {
        if ($number >= self::MIN && $number <= self::MAX) {
            $value = self::conversionR((int)$number);       
            if ($moeda) {
                if (floor($number) == 1) {
                    $value .= self::MOEDA;
                }
                else if (floor($number) > 1) $value .= self::MOEDAS;
            }
 
            $decimals = self::extractDecimals($number);            
            if ($decimals > 0.00) {
                $decimals = round($decimals * 100);
                $value .= " e ".self::conversionR($decimals);
                if ($moeda) {
                    if ($decimals == 1) {
                        $value .= self::CENTAVO;
                    }   
                    else if ($decimals > 1) $value .= self::CENTAVOS;
                }
            }
        }
        return trim($value);
    }
     
    private static function extractDecimals($number) {
        return $number - floor($number);
    }
     
    static function conversionR($number) {
        if (in_array($number, range(1, 19))) {
            $value = self::$unidades[$number-1];
        }
        else if (in_array($number, range(20, 90, 10))) {
             $value = self::$dezenas[floor($number / 10)-1]." ";           
        }     
        else if (in_array($number, range(21, 99))) {
             $value = self::$dezenas[floor($number / 10)-1]." e ".self::conversionR($number % 10);           
        }     
        else if (in_array($number, range(100, 900, 100))) {
             $value = self::$centenas[floor($number / 100)-1]." ";           
        }          
        else if (in_array($number, range(101, 199))) {
             $value = ' cento e '.self::conversionR($number % 100);         
        }   
        else if (in_array($number, range(201, 999))) {
             $value = self::$centenas[floor($number / 100)-1]." e ".self::conversionR($number % 100);        
        }  
        else {
            foreach (self::$milhares as $item) {
                if ($number >= $item['start'] && $number <= $item['end']) {
                    $value = self::conversionR(floor($number / $item['div']))." ".$item['text']." ".self::conversionR($number % $item['div']);
                    break;
                }
            }
        }        
        return $value;
    }
}


class Extenso
{
    public static function removerFormatacaoNumero( $strNumero )
    {
        $strNumero = trim( str_replace( "R$", null, $strNumero ) );
        $vetVirgula = explode( ",", $strNumero );
        if ( count( $vetVirgula ) == 1 )
        {
            $acentos = array(".");
            $resultado = str_replace( $acentos, "", $strNumero );
            return $resultado;
        }
        else if ( count( $vetVirgula ) != 2 )
        {
            return $strNumero;
        }
        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr( $vetVirgula[1], 0, 2 );
        $acentos = array(".");
        $resultado = str_replace( $acentos, "", $strNumero );
        $resultado = $resultado . "." . $strDecimal;
        return $resultado;
    }
    public static function converte( $valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false )
    {
        $valor = self::removerFormatacaoNumero( $valor );
        $singular = null;
        $plural = null;
        if ( $bolExibirMoeda )
        {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        else
        {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
        if ( $bolPalavraFeminina )
        {
            if ($valor == 1)
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            else
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
        }
        $z = 0;
        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );
        for ( $i = 0; $i < count( $inteiro ); $i++ )
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ )
                $inteiro[$i] = "0" . $inteiro[$i];
        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;
            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
        $rt = mb_substr( $rt, 1 );
        return($rt ? trim( $rt ) : "zero");
    }
}

$formandosextenso = Extenso::converte($vetor_orcamento['qtdformandos'], false, true);
$datahoje = $data_extenso = strftime('%d de %B de %Y', strtotime('today'));

$message = '<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
	<title>Imprimir Contrato</title>
</head>
<link rel="stylesheet" href="layout/bower_components/bootstrap/dist/css/bootstrap.min.css">
<body>
<table width="100%">
	<tr>
		<td>
			<div align="right">

				<strong><u>CONTRATO DE PRESTAÇÃO DE SERVIÇOS</u></strong>
			
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div align="right">

				Convites Gráficos
			
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div align="right">

				 n° '.$id.'
			
			</div>
		</td>
	</tr>
</table>

<table width="100%">
	<tr>
		<td>

		<p align="justify">Pelo presente documento e na melhor forma de direito, de um lado STUDIO M FOTOGRAFIA EIRELI ME, pessoa jurídica de direito privado, inscrita no CNPJ sob o n° 16.683.613/0001-00, com sede na Rua 93 nº 296 qd. F-14 lt. 36, Setor Sul CEP: 74083-120, Goiânia-Goiás, ora denominada CONTRATADA.</p>

		</td>

	</tr>

	<tr>
		<td>

		<p align="justify">Noutro lado, denominada CONTRATANTE, a <strong>COMISSÃO DE FORMATURA</strong>, constituída e representada pelos formandos abaixo qualificados do curso de ';

		if($vetor_orcamento['tipo'] == 1) {

		$message .= ''.$vetor_curso[nome].' da  Instituição  de  Ensino '.$vetor_curso[sigla].' – '.$vetor_instituicao[nome].', com ano e semestre de conclusão em '.$vetor_turma[conclusao].'-'.$vetor_turma[semestre].'.';

		} if($vetor_orcamento['tipo'] == 2) {

		$message .= ''.$vetor_curso_inicio[nome].' da  Instituição  de  Ensino '.$vetor_instituicao[sigla].' - '.$vetor_instituicao[nome].', com ano e semestre de conclusão em '.$vetor_oportunidade[ano].'.';

		}

		$message .= '</p></td>

	</tr>

</table>

<table width="100%">';

$i = 1;

$sql_contratos = mysqli_query($con, "select * from contratos_aprovacao where id_contrato = '$id'");

while($vetor_contratos = mysqli_fetch_array($sql_contratos)) { 

$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor_contratos[id_formando]'");
$vetor_formando = mysqli_fetch_array($sql_formando);

$message .= '
<tr>
<td>

<table width="100%">
<tr>
<td>
Nome('.$i.'): <strong>'.$vetor_formando[nome].'</strong>
</td>
</tr>
<tr>
<td>
Cargo: <strong>'.$vetor_formando[cargo].'</strong>
</td>
</tr>
<tr>
<td>
Endereço Completo: <strong>'.$vetor_formando[endereco].'</strong> Bairro: <strong>'.$vetor_formando[bairro].'</strong>
</td>
</tr>
<tr>
<td>
Cidade: <strong>'.$vetor_formando[cidade].'</strong> UF: <strong>'.$vetor_formando[estado].'</strong>  CEP: <strong>'.$vetor_formando[cep].'</strong>
</td>
</tr>
<tr>
<td>
Telefone Resid.: <strong>'.$vetor_formando[telefone].'</strong> Comercial.: <strong>'.$vetor_formando[telcomercial].'</strong> Celular.: <strong>'.$vetor_formando[celular].'</strong>
</td>
</tr>
<tr>
<td>
E-mail: <strong>'.$vetor_formando[email].'</strong>
</td>
</tr>
<tr>
<td>
RG: <strong>'.$vetor_formando[rg].'</strong> CPF: <strong>'.$vetor_formando[cpf].'</strong>
</td>
</tr>
<img src="sistema/imgs/transp.png" height="20px">
</table>
</td>
</tr>';

$i++; }

$message .= '</table>


<p><strong>Cláusula I - DA REPRESENTAÇÃO</strong></p>

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<p align="justify">1.1 Os formandos acima qualificados, na qualidade de Membros da Diretoria da Associação da Comissão de Formatura, que aqui é a CONTRATANTE, atuarão como legítimos representantes dos formandos do curso supracitado.</p>
<p align="justify">1.2 Estabelecidas as diretrizes contratuais abaixo alinhadas (condições, produtos, prazos e preços), os formandos deverão, individualmente, contratar os convites de formatura mediante assinatura do <strong><u>CONTRATO INDIVIDUAL DE COMPRA E VENDA DE CONVITE DE FORMATURA</u></strong>.</p>
<p align="justify">1.3 Fixadas as considerações iniciais, as partes têm entre si, justas e contratadas, o seguinte que mutuamente aceitam e outorgam.</p>

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<p><strong>Cláusula 2 – DO OBJETO</strong></p>
<p align="justify">2.1 O presente instrumento tem por finalidade delimitar a prestação de serviços de confecção de convite de formatura, bem como ajustar os preços e especificar os produtos que serão colocados à disposição do (a) formando (a)  interessado (a)  que serão objetos de contratação por meio de instrumento particular de compra e venda de convite de formatura.</p>
<p align="justify">2.2 Para este fim, a Comissão de Formatura <strong><u>APROVA EXPRESSAMENTE</u></strong> a última proposta de confecção de convite de formatura encaminhada pela Contratada, cujo teor faz parte integrante deste instrumento. </p>
<p align="justify">2.3 A CONTRANTE informa para os devidos fins contratuais, que o convite de formatura será composto por <strong><u>'.$vetor_orcamento[qtdformandos].'</u> ('.$formandosextenso.')</strong> formandos.</p>

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<p><strong>Cláusula 3 - ESPECIFICAÇÃO</strong></p>
<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">
3.1 A CONTRATADA, por conta e ordem exclusiva da CONTRATANTE, encarregar-se-á da prestação dos serviços de criação, arte-finalização, impressão e acabamento dos convites gráficos de formatura especificados abaixo:
<br>
<br>';

$sql_produtos = mysqli_query($con, "select * from orcamento_produto where id_orcamento = '$vetor_orcamento[id_orcamento]'");

while($vetor_produtos = mysqli_fetch_array($sql_produtos)) {

if($vetor_produtos['id_produto'] == 2) {

//pega tamanho

$sql_tamanho = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '1'");
$vetor_tamanho = mysqli_fetch_array($sql_tamanho);

$result_tabela = mysqli_query($con, "SELECT * FROM tabela_basico WHERE id_basico = '$vetor_tamanho[id_itemtabela]'");
$vetor_tabela_final = mysqli_fetch_array($result_tabela);

$sql_tipo_final = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_final[id_tamanho]'");
$vetor_tipo_final = mysqli_fetch_array($sql_tipo_final);

// pega embalagem

$sql_embalagem = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '2'");
$vetor_embalagem = mysqli_fetch_array($sql_embalagem);

$result_embalagem = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_embalagem[id_itemtabela]'");
$vetor_tabela_embalagem = mysqli_fetch_array($result_embalagem);

$sql_tipo_final_embalagem = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_embalagem[id_itemtabela]'");
$vetor_tipo_final_embalagem = mysqli_fetch_array($sql_tipo_final_embalagem);

$message .= '<table width="100%">
	<tr>
		<td width="15%"></td>
		<td><strong>'.$vetor_produtos[qtd].' Super Luxo – '.$vetor_tipo_final[titulo].'</strong></td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>Embalagem do Convite: '.$vetor_tipo_final_embalagem[titulo].'</strong></td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>
			<table width="100%">
				<tr>
					<td width="15%"></td>
					<td width="85%"><strong>Acabamento Interno da Embalagem:</strong></td>
				</tr>
				<tr>
					<td></td>
					<td>

						<br>';
					

							$sql_acabamento_interno = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '3'");

							$total_acabamento_interno = mysqli_num_rows($sql_acabamento_interno);

							$i = 1;

							while($vetor_acabamento_interno = mysqli_fetch_array($sql_acabamento_interno)) { 

							$result_acabamento_interno = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_acabamento_interno[id_itemtabela]'");
							$vetor_tabela_acabamento_interno = mysqli_fetch_array($result_acabamento_interno);

							$sql_tipo_final_acabamento_interno = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_acabamento_interno[id_itemtabela]'");
							$vetor_tipo_final_acabamento_interno = mysqli_fetch_array($sql_tipo_final_acabamento_interno);

						
						$message .= ''.$vetor_tipo_final_acabamento_interno[titulo].'';

						if($total_acabamento_interno > $i) { 

						$message .= ', '; 

						} if($total_acabamento_interno == $i) { 

						$message .= '.'; 

						}

						$i++; }

					$message .= '</td>
				</tr>
				<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><strong>Acabamento Externo da Embalagem:</strong></td>
				</tr>
				<tr>
					<td></td>
					<td>

						<br>';
						
							$sql_acabamento_externo = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '8'");

							$total_acabamento_externo = mysqli_num_rows($sql_acabamento_externo);

							$f = 1;

							while($vetor_acabamento_externo = mysqli_fetch_array($sql_acabamento_externo)) { 

							$result_acabamento_externo = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$total_acabamento_externo[id_itemtabela]'");
							$vetor_tabela_acabamento_externo = mysqli_fetch_array($result_acabamento_externo);

							$sql_tipo_final_acabamento_externo = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_acabamento_externo[id_itemtabela]'");
							$vetor_tipo_final_acabamento_externo = mysqli_fetch_array($sql_tipo_final_acabamento_externo);
						
						$message .= ''.$vetor_tipo_final_acabamento_externo[titulo].'';

						if($total_acabamento_externo > $f) { 

						$message .= ', '; 

						} if($total_acabamento_externo == $f) { 

						$message .= '.'; 

						} 

						$f++; }

					$message .= '</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>Convite</strong></td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>
			<table width="100%">
				<tr>
					<td width="15%"></td>
					<td width="85%"><strong>Capa:</strong></td>
				</tr>
				<tr>
					<td></td>
					<td>

						<br>';
						
							$sql_capa = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and (id_tipo = '5' OR id_tipo = '6') order by id_item ASC");

							$sql_sobrecapa = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '4'");
							$vetor_sobrecapa = mysqli_fetch_array($sql_sobrecapa);

							$sql_tipo_final_sobrecapa = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_sobrecapa[id_itemtabela]'");
							$vetor_tipo_final_sobrecapa = mysqli_fetch_array($sql_tipo_final_sobrecapa);

							$total_capa = mysqli_num_rows($sql_capa);

							$g = 1;

							while($vetor_capa = mysqli_fetch_array($sql_capa)) { 

							$result_acabamento_interno = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_capa[id_itemtabela]'");
							$vetor_tabela_capa = mysqli_fetch_array($result_capa);

							$sql_tipo_final_capa = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_capa[id_itemtabela]'");
							$vetor_tipo_final_capa = mysqli_fetch_array($sql_tipo_final_capa);

						
						$message .= ''.$vetor_tipo_final_capa[titulo].'';

						if($total_capa > $g) { 

						$message .= ', '; 

						} if($total_capa == $g) { 

						$message .= '.'; 

						}

						$g++; }

					$message .= '</td>
				</tr>';

				if(mysqli_num_rows($sql_sobrecapa) > 0) {

				$message .= '<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td width="15%"></td>
					<td width="85%"><strong>Sobrecapa/Encarte:</strong></td>
				</tr>
				<tr>
					<td></td>
					<td>'.$vetor_tipo_final_sobrecapa[titulo].'</td>
				</tr>';
				}
				$message .= '<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><strong>Componentes Padrão do Miolo</strong></td>
				</tr>
				<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>1 Capa do Bloco (Capa Mole) - Couchê Fosco 250g</td>
				</tr>
				<tr>
					<td></td>
					<td>'.$vetor_tabela_final[paginas].' Páginas Padrão - Couchê Fosco 170g</td>
				</tr>
				<tr>
					<td></td>
					<td>'.$vetor_tabela_final[paginaspersonalizadas].'';

					 if($vetor_tabela_final['paginaspersonalizadas'] > 1) { 

					 $message .= ' Páginas'; 

					 } else { 

					 $message .= ' Página'; 

					 }

					 $message .= ' Personalizadas - Couchê Fosco 170g</td>
				</tr>
				<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><strong>Componentes Extras do Miolo</strong></td>
				</tr>
				<tr>
					<td><br></td>
					<td></td>
				</tr>';

                    $tabela_paginasextras = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '34'");
                    $vetor_tabela_paginasextras = mysqli_fetch_array($tabela_paginasextras);

                    if(mysqli_num_rows($tabela_paginasextras) > 0) {

                $message .= '<tr>
					<td></td>
					<td>'.$vetor_tabela_paginasextras[qtd].''; 

					if($vetor_tabela_paginasextras['qtd'] > 1) { 

					$message .= ' Páginas'; 

					} else { 

					$message .= ' Página'; 

					} 

					$message .= ' Extras - Couchê Fosco 170g</td>
				</tr>';

					}

                    $tabela_paginasextraspersonalizadas = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '75'");
                    $vetor_tabela_paginasextraspersonalizadas = mysqli_fetch_array($tabela_paginasextraspersonalizadas);

                    if(mysqli_num_rows($tabela_paginasextraspersonalizadas) > 0) {

                $message .= '<tr>
					<td></td>
					<td>'.$vetor_tabela_paginasextraspersonalizadas[qtd].'';

					if($vetor_tabela_paginasextraspersonalizadas['qtd'] > 1) { 

					$message .= ' Páginas'; 

					} else { 

					$message .= ' Página'; 

					} 

					$message .= ' Extras Personalizadas - Couchê Fosco 170g</td>
				</tr>';

					}

                    $tabela_miniposter = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '36'");
                    $vetor_tabela_miniposter = mysqli_fetch_array($tabela_miniposter);

                    if(mysqli_num_rows($tabela_miniposter) > 0) {

                $message .= '<tr>
					<td></td>
					<td>'.$vetor_tabela_miniposter[qtd].' Mini Poster - Couchê Fosco 170g</td>
				</tr>';

					}

                    $tabela_vegetalcomum = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '37'");
                    $vetor_tabela_vegetalcomum = mysqli_fetch_array($tabela_vegetalcomum);

                    if(mysqli_num_rows($tabela_vegetalcomum) > 0) {

                $message .= '<tr>
					<td></td>
					<td>'.$vetor_tabela_vegetalcomum[qtd].''; 

					if($vetor_tabela_vegetalcomum['qtd'] > 1) { 

					$message .= ' Páginas'; 

					} else { 

					$message .= ' Página'; 

					} 

					$message .= ' Vegetal Comum - Vegetal 90g</td>
				</tr>';

					}

                    $tabela_vegetalpersonalizado = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '38'");
                    $vetor_tabela_vegetalpersonalizado = mysqli_fetch_array($tabela_vegetalpersonalizado);

                    if(mysqli_num_rows($tabela_vegetalpersonalizado) > 0) {

                $message .= '<tr>
					<td></td>
					<td>'.$vetor_tabela_vegetalpersonalizado[qtd].''; 

					if($vetor_tabela_vegetalpersonalizado['qtd'] > 1) { 

					$message .= ' Páginas'; 

					} else { 

					$message .= ' Página'; 

					} 

					$message .= ' Vegetal Personalizado - Vegetal 90g</td>
				</tr>';

					}

                    $tabela_acetatocomum = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '71'");
                    $vetor_tabela_acetatocomum = mysqli_fetch_array($tabela_acetatocomum);

                    if(mysqli_num_rows($tabela_acetatocomum) > 0) {

                $message .= '<tr>
					<td></td>
					<td>'.$vetor_tabela_acetatocomum[qtd].''; 

					if($vetor_tabela_acetatocomum['qtd'] > 1) { 

					$message .= ' Páginas'; 

					} else { 

					$message .= ' Página'; 

					} 

					$message .= ' Transparência Comum - Acetato transparente</td>
				</tr>';

					}

                    $tabela_acetatopersonalizado = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '72'");
                    $vetor_tabela_acetatopersonalizado = mysqli_fetch_array($tabela_acetatopersonalizado);

                    if(mysqli_num_rows($tabela_acetatopersonalizado) > 0) {

                $message .= '<tr>
					<td></td>
					<td>'.$vetor_tabela_acetatopersonalizado[qtd].''; 

					if($vetor_tabela_acetatopersonalizado['qtd'] > 1) { 

					$message .= ' Páginas'; 

					} else { 

					$message .= ' Página'; 

					} 

					$message .= 'Transparência Personalizado - Acetato transparente</td>
				</tr>';
				
				}

			$message .= '</table>

		</td>
	</tr>
</table>';

$sql_soma_calculo = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' and id_produto = '$vetor_produtos[id_item]'");
$vetor_soma_calculo = mysqli_fetch_array($sql_soma_calculo);

$sql_tributos = mysqli_query($con, "select * from tabela_tributos where id_tributo = '2'");
$vetor_tributos = mysqli_fetch_array($sql_tributos);

if($vetor_tributos['tipo'] == 1) {

$percentual = $vetor_tributos['valor'] / 100;
$valorfinalcomissao = $vetor_soma_calculo['total'] * $percentual;

} if($vetor_tributos['tipo'] == 2) {

$valorfinalcomissao = $vetor_tributos['valor'];

}

$sql_tributos1 = mysqli_query($con, "select * from tabela_tributos where id_tributo = '3'");
$vetor_tributos1 = mysqli_fetch_array($sql_tributos1);

if($vetor_tributos1['tipo'] == 1) {

$percentual1 = $vetor_tributos1['valor'] / 100;
$valorfinalimposto1 = $vetor_soma_calculo['total'] * $percentual1;

} if($vetor_tributos1['tipo'] == 2) {

$valorfinalimposto1 = $vetor_tributos1['valor'];

} 

$totalproduto = $vetor_soma_calculo['total'] + $valorfinalcomissao + $valorfinalimposto1;

$totalunproduto = $totalproduto / $vetor_produtos['qtd'];

//calculo total paginas

$totalpaginas = $vetor_tabela_final['paginas'] + $vetor_tabela_final['paginaspersonalizadas'] + $vetor_tabela_paginasextras['qtd'] + $vetor_tabela_paginasextraspersonalizadas['qtd'] + $vetor_tabela_vegetalcomum['qtd'] + $vetor_tabela_vegetalpersonalizado['qtd'] + $vetor_tabela_acetatocomum['qtd'] + $vetor_tabela_acetatopersonalizado['qtd'];

$valorun = number_format($totalunproduto,2,',','.');
$valortotal = number_format($totalproduto,2,',','.');

$message .= '<table width="100%">
	<tr>
		<td width="15%"><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>Total de Páginas: '.$totalpaginas.'</strong></td>
	</tr>
	<tr>
		<td width="15%"><br></td>
		<td><br></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>Valor Unitário: R$ '.$valorun.' Total: R$ '.$valortotal.'</strong></td>
	</tr>	
</table>

<br>
<br>';

} if($vetor_produtos['id_produto'] == 4) { 

//pega tamanho

$sql_tamanho = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '1'");
$vetor_tamanho = mysqli_fetch_array($sql_tamanho);

$result_tabela = mysqli_query($con, "SELECT * FROM tabela_basico WHERE id_basico = '$vetor_tamanho[id_itemtabela]'");
$vetor_tabela_final = mysqli_fetch_array($result_tabela);

$sql_tipo_final = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_final[id_tamanho]'");
$vetor_tipo_final = mysqli_fetch_array($sql_tipo_final);

// pega embalagem

$sql_embalagem = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '2'");
$vetor_embalagem = mysqli_fetch_array($sql_embalagem);

$result_embalagem = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_embalagem[id_itemtabela]'");
$vetor_tabela_embalagem = mysqli_fetch_array($result_embalagem);

$sql_tipo_final_embalagem = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_embalagem[id_itemtabela]'");
$vetor_tipo_final_embalagem = mysqli_fetch_array($sql_tipo_final_embalagem);

$message .= '<table width="100%">
	<tr>
		<td width="15%"></td>
		<td><strong>'.$vetor_produtos[qtd].' Convite Simples – '.$vetor_tipo_final[titulo].'</strong></td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>Embalagem do Convite: '.$vetor_tipo_final_embalagem[titulo].'</strong></td>
	</tr>
	<tr>
		<td><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>
			<table width="100%">
				<tr>
					<td width="15%"></td>
					<td width="85%">

						<strong>Acabamento da Embalagem:</strong>';

							$sql_acabamento_interno = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '3'");

							$total_acabamento_interno = mysqli_num_rows($sql_acabamento_interno);

							$i = 1;

							while($vetor_acabamento_interno = mysqli_fetch_array($sql_acabamento_interno)) { 

							$result_acabamento_interno = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_acabamento_interno[id_itemtabela]'");
							$vetor_tabela_acabamento_interno = mysqli_fetch_array($result_acabamento_interno);

							$sql_tipo_final_acabamento_interno = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_acabamento_interno[id_itemtabela]'");
							$vetor_tipo_final_acabamento_interno = mysqli_fetch_array($sql_tipo_final_acabamento_interno);

						
						$message .= ''.$vetor_tipo_final_acabamento_interno[titulo].'';

						if($total_acabamento_interno > $i) { 

						$message .= ', '; 

						} if($total_acabamento_interno == $i) { 

						$message .= '.'; 

						}

						$i++; }

					$message .= '</td>
				</tr>
				<tr>
					<td><br></td>
					<td></td>
				</tr>
				<tr>
					<td width="15%"></td>
					<td width="85%">

						<strong>Quantidade de Paginas:</strong>';

							$sql_paginas = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '10'");
							$vetor_paginas = mysqli_fetch_array($sql_paginas);

							$sql_tipo_final_paginas = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_paginas[id_itemtabela]'");
							$vetor_tipo_final_paginas = mysqli_fetch_array($sql_tipo_final_paginas);

						
						$message .= ''.$vetor_tipo_final_paginas[titulo].'

					</td>
				</tr>

			</table>

		</td>

	</tr>

</table>';

$sql_soma_calculo = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' and id_produto = '$vetor_produtos[id_item]'");
$vetor_soma_calculo = mysqli_fetch_array($sql_soma_calculo);

$sql_tributos = mysqli_query($con, "select * from tabela_tributos where id_tributo = '2'");
$vetor_tributos = mysqli_fetch_array($sql_tributos);

if($vetor_tributos['tipo'] == 1) {

$percentual = $vetor_tributos['valor'] / 100;
$valorfinalcomissao = $vetor_soma_calculo['total'] * $percentual;

} if($vetor_tributos['tipo'] == 2) {

$valorfinalcomissao = $vetor_tributos['valor'];

}

$sql_tributos1 = mysqli_query($con, "select * from tabela_tributos where id_tributo = '3'");
$vetor_tributos1 = mysqli_fetch_array($sql_tributos1);

if($vetor_tributos1['tipo'] == 1) {

$percentual1 = $vetor_tributos1['valor'] / 100;
$valorfinalimposto1 = $vetor_soma_calculo['total'] * $percentual1;

} if($vetor_tributos1['tipo'] == 2) {

$valorfinalimposto1 = $vetor_tributos1['valor'];

} 

$totalproduto = $vetor_soma_calculo['total'] + $valorfinalcomissao + $valorfinalimposto1;

$totalunproduto = $totalproduto / $vetor_produtos['qtd'];

$valorunitario = number_format($totalunproduto,2,',','.');
$valortotal = number_format($totalproduto,2,',','.');

$message .= '<table width="100%">
	<tr>
		<td width="15%"><br></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>Valor Unitário: R$ '.$valorunitario.' Total: R$ '.$valortotal.'</strong></td>
	</tr>
</table>

<br>
<br>';

}

}
$message .= '
<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<p><strong>Cláusula 4- PREÇO E PAGAMENTO</strong></p>

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<p align="justify">4.1 Para execução dos serviços relacionados na cláusula 2º, a CONTRANTE garantirá a CONTRATADA à aquisição por formando, por meio de contratação individual:</p>

<img src="sistema/imgs/transp.png" height="20px">';

$sql_produtos_orc = mysqli_query($con, "select * from orcamento_produto where id_orcamento = '$vetor[id_orcamento]'");

while($vetor_produtos_orc = mysqli_fetch_array($sql_produtos_orc)) { 

//pega tamanho

$sql_tamanho_prod = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos_orc[id_item]' and id_tipo = '1'");
$vetor_tamanho_prod = mysqli_fetch_array($sql_tamanho_prod);

$result_tabela_prod = mysqli_query($con, "SELECT * FROM tabela_basico WHERE id_basico = '$vetor_tamanho_prod[id_itemtabela]'");
$vetor_tabela_prod = mysqli_fetch_array($result_tabela_prod);

$sql_tipo_final_prod = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_prod[id_tamanho]'");
$vetor_tipo_final_prod = mysqli_fetch_array($sql_tipo_final_prod);

$sql_soma_calculo = mysqli_query($con, "select SUM(valorun*qtd) as total FROM orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' and id_produto = '$vetor_produtos_orc[id_item]'");
$vetor_soma_calculo = mysqli_fetch_array($sql_soma_calculo);

$sql_tributos = mysqli_query($con, "select * from tabela_tributos where id_tributo = '2'");
$vetor_tributos = mysqli_fetch_array($sql_tributos);

if($vetor_tributos['tipo'] == 1) {

$percentual = $vetor_tributos['valor'] / 100;
$valorfinalcomissao = $vetor_soma_calculo['total'] * $percentual;

} if($vetor_tributos['tipo'] == 2) {

$valorfinalcomissao = $vetor_tributos['valor'];

}

$sql_tributos1 = mysqli_query($con, "select * from tabela_tributos where id_tributo = '3'");
$vetor_tributos1 = mysqli_fetch_array($sql_tributos1);

if($vetor_tributos1['tipo'] == 1) {

$percentual1 = $vetor_tributos1['valor'] / 100;
$valorfinalimposto1 = $vetor_soma_calculo['total'] * $percentual1;

} if($vetor_tributos1['tipo'] == 2) {

$valorfinalimposto1 = $vetor_tributos1['valor'];

} 

$totalproduto = $vetor_soma_calculo['total'] + $valorfinalcomissao + $valorfinalimposto1;

$totalunproduto = $totalproduto / $vetor_produtos_orc['qtd'];

$qtdporformando = $vetor_orcamento['qtdformandos'] / $vetor_produtos_orc['qtd'];
$qtdporformandoar = ceil($qtdporformando);

$valorunformando = number_format($totalunproduto,2,',','.');

if($vetor_produtos_orc['id_produto'] == 2) {

$nomeproduto = 'Super Luxo';

} else {

$nomeproduto = 'Convite Simples';

}

$message .= '<table width="30% BORDER="1" style="border-collapse: collapse">
<tr>
<td>
<strong>'.$nomeproduto.' - '.$vetor_tipo_final_prod[titulo].'</strong>
</td>
</tr>
</table>
<table width="30% BORDER="1" style="border-collapse: collapse">
<tr>
<td><strong>Quant.</strong></td>
<td><strong>Valor Un.</strong></td>
</tr>
<tr>
<td>'.$qtdporformandoar.'</td>
<td>'.$valorunformando.'</td>
</tr>
</table>';

$totalprodutosfinal += $totalproduto; }

$valoruntotalizado = number_format($totalprodutosfinal,2,',','.');
$valorporextenso = strtoupper(Monetary::numberToExt($totalprodutosfinal));

$message .= '<img src="sistema/imgs/transp.png" height="20px">
<p align="justify">4.2	Fica ajustado entre as partes o valor de R$ '.$valoruntotalizado.' ('.$valorporextenso.') cuja base calculo é a quantidade de formandos indicado pela Contratada (item 2.3),  multiplicado pela quantidade mínima de Convite Super Luxo por contrato individual (item 4.1).</p>
<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<p><strong>Cláusula V - DA CONTRATAÇÃO INDIVIDUAL</strong></p>
<p align="justify">5.1 Em período acordado entre CONTRATANTE e CONTRATADA, serão firmados os contratos individuais com os formandos.</p>
<p align="justify">5.2 Os valores acima referenciados serão pagos através de transferência bancária, cartões de crédito, boleto bancário,  em data acordada entre as partes, de forma online mediante assinatura eletrônica  do contrato individual pelo interessado.</p>
<p align="justify">5.3 Caso a quantidade de convites solicitados pela turma seja inferior ao acordado neste contrato, poderá haver a readequação das especificações dos convites ou dos valores ora acordados, cabendo as partes definir as novas especificações e/ou novos valores, sem prejuízos de incidência de multa contratual.</p>
<p align="justify">5.4 Quaisquer serviços relacionados aos convites de formatura não previsto neste contrato deverão ser objeto de aditivo contratual devidamente assinado pelas partes.</p>
<p align="justify">5.5 A CONTRATADA deverá entregar os convites de formatura para o representante legal da Comissão e Formatura, na cidade da Instituição de Ensino da CONTRANTE, no prazo previsto no cronograma de execução de serviços.</p>
<p align="justify">5.6 Um membro representante legal da Comissão de Formatura ficará responsável pelo recebimento dos convites de formatura, por consequência entregará os convites aos contratantes individuais. Para tanto, deverá a CONTRATANTE nomear um de seus representantes legais para receber os convites de formatura contratados.</p>
<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">
<p><strong>Cláusula 6 - CONDIÇÕES GERAIS</strong></p>
<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">
<p align="justify">6.1 A CONTRATADA se reserva no direito de posicionar sua marca na última página do convite de formatura, indicando sua autoria sobre o projeto.</p>
<p align="justify">6.2 Caso o layout do convite venha a ser modificado ou substituído após aprovação pela CONTRATANTE, será cobrada taxa adicional de R$ 2.200,00 (dois mil e duzentos reais) a título de novo serviço de criação prestado à turma;</p>
<p align="justify">6.3 Os  CONTRATANTES responsabilizam-se, desde já, pelo repasse de informações que constarão no convite, tais como: nomes (alunos/professores/homenageados/demais), mensagens, textos, imagens, tema e revisão final (ortográfica/visual) do material a ser confeccionado. A CONTRATANTE exime a empresa de qualquer responsabilidade pela falta de informações essenciais requeridas para o convite de formatura, advindas da Comissão de Formatura e/ou dos formandos;</p>
<p align="justify">6.4 Os textos e demais dados pertinentes à elaboração do objeto deste contrato deverão ser encaminhados a CONTRATADA até a data acordada. Em eventual atraso, as datas serão reajustadas proporcionalmente.</p>
<p align="justify">6.5 O prazo para entrega dos convites e seus acessórios será de 45 (quarenta e cinco) dias contados da data de aprovação final, significando assim, neste ato, que a CONTRATANTE autoriza a CONTRATADA a seguir com os convites para a impressão gráfica.</p>
<p align="justify">6.6 A CONTRATADA não se responsabiliza por promessas, indicações de terceiros, ou ainda, outro tipo de agenciamento de serviços que não estejam explicitados neste contrato;</p>
<p align="justify">6.7 Os CONTRATANTES se comprometem penalmente e na forma da lei dos Direitos Autorais a não copiar, reproduzir, alugar, emprestar ou transferir, de qualquer maneira que seja, o material/serviço descrito na Cláusula 2.</p>
<p align="justify">6.8 Na hipótese dos CONTRATANTES ficarem inadimplentes com as obrigações financeiras, advindas dos convites, acessórios ou débitos adquiridos através das solicitações para produção dos produtos contratados - descritos e estipulados neste termo ou em adendo , o objeto deste contrato ficará retido até a solução de tais pendências;</p>';

$message .= '<p align="justify">6.9 A presente contratação da prestação dos serviços gráficos relacionados a confecção dos convites de formatura, conforme pactuado logo acima, gerará os seguintes bônus extras, direcionados a:</p>';

$sql_extras = mysqli_query($con, "select * from orcamento_extras where id_orcamento = '$vetor[id_orcamento]' and tipo = '1'");

if(mysqli_num_rows($sql_extras) > 0) {

$message .= '<p align="justify">Comissão de Formatura: ';

$i = 0;

while($vetor_extras = mysqli_fetch_array($sql_extras)) {	

if($vetor_extras['id_produto'] == 2) {

if($i == 0) {

$message .= '('.$vetor_extras[qtd].') convite (s) Super Luxo';

}

} if($vetor_extras['id_produto'] == 4) {

if($i == 0) {

$message .= '('.$vetor_extras[qtd].') Convite Simples';

} if($i > 0) {

$message .= '('.$vetor_extras[qtd].') Convite Simples';

}

}

$i++; 

}

$message .= ';</p>';

}

$sql_extras1 = mysqli_query($con, "select * from orcamento_extras where id_orcamento = '$vetor[id_orcamento]' and tipo = '2'");

if(mysqli_num_rows($sql_extras1) > 0) {

$message .= '<p align="justify">Mesa diretiva: ';

$z = 0;

while($vetor_extras1 = mysqli_fetch_array($sql_extras1)) {	

if($vetor_extras1['id_produto'] == 2) {

if($z == 0) {

$message .= '('.$vetor_extras1[qtd].') convite (s) Super Luxo';

}

} if($vetor_extras1['id_produto'] == 4) {

if($z == 0) {

$message .= '('.$vetor_extras1[qtd].') Convite Simples';

} if($z > 0) {

$message .= ' ('.$vetor_extras1[qtd].') Convite Simples';

}

}

$z++; 

}

$message .= ';</p>';

}

$message .= '<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<p><strong>Cláusula 7 – DAS MULTA E PENALIDADES</strong></p>

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<p align="justify">7.1 Em caso de rescisão contratual durante o desenvolvimento do layout geral ou dos convites individuais, fica ajustado a incidência de multa contratual equivalente a 50% (cinquenta por cento) da totalidade do preço ajustado neste instrumento ( Cláusula 4 - item “ 4.2”)</p>
<p align="justify">7.2 Em caso de rescisão contratual durante a confecção gráfica dos convites, fica ajustado a incidência de multa contratual equivalente a 100% (cem por cento) da totalidade do preço ajustado neste instrumento ( Cláusula 4 - item “ 4.2”).</p>

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<p><strong>Cláusula 8 – DO CRONOGRAMA</strong></p>

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<p align="justify">8.1  A execução do presente contrato deverá obedecer o cronograma de execução de serviços.</p>
<p align="justify">Para tanto, em comum acordo, ajustam as partes:</p>';

if($vetor_orcamento['dataentrega'] != NULL) {

$data1 = date('d/m/Y', strtotime($vetor_orcamento['questionario1']));
$data2 = date('d/m/Y', strtotime($vetor_orcamento['questionario']));
$data3 = date('d/m/Y', strtotime($vetor_orcamento['confeccaotematica1']));
$data4 = date('d/m/Y', strtotime($vetor_orcamento['confeccaotematica']));
$data5 = date('d/m/Y', strtotime($vetor_orcamento['aprovacaofinaltematica']));
$data6 = date('d/m/Y', strtotime($vetor_orcamento['prazolimiteentrega']));
$data7 = date('d/m/Y', strtotime($vetor_orcamento['datalimiteconvextras']));
$data8 = date('d/m/Y', strtotime($vetor_orcamento['dataaprovacaofinal']));
$data9 = date('d/m/Y', strtotime($vetor_orcamento['dataenviomaterial']));
$data10 = date('d/m/Y', strtotime($vetor_orcamento['dataentrega']));

$message .= '<div class="row">

<div class="col-lg-6">

              <table width="100%" class="table table-bordered table-striped">
                <tr>
                  <td width="3%"></td>
                  <td><div align="center">ETAPAS</div></td>
                  <td>
                    <table width="100%">
                      <tr>
                        <td>
                          <div align="center">DATA DO ENVIO</div>
                        </td>
                        <td>
                          <div align="center">CONCLUSÃO</div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>Questionário de Identidade Visual.</td>
                  <td>
                    <table width="100%">
                      <tr>
                        <td>
                          <div align="center">'.$data1.'</div>
                        </td>
                        <td>
                          <div align="center">'.$data2.'</div>
                        </td>
                      </tr>
                    </table>
                    </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Confecção da Temática.</td>
                  <td>
                    <table width="100%">
                      <tr>
                        <td>
                          <div align="center">'.$data3.'</div>
                        </td>
                        <td>
                          <div align="center">'.$data4.'</div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Aprovação final da Temática do Convite.</td>
                  <td><div align="center">'.$data5.'</div></td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Prazo limite para entrega dos Dados do Convite Gráfico.</td>
                  <td><div align="center">'.$data6.'</div></td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>Data limite para acréscimo de convites extras.</td>
                  <td><div align="center">'.$data7.'</div></td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>Data da Aprovação Final do Convite.</td>
                  <td><div align="center">'.$data8.'</div></td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>Data de envio do material para impressão.</td>
                  <td><div align="center">'.$data9.'</div></td>
                </tr>
                <tr>
                  <td>8</td>
                  <td>Entrega dos Convites.</td>
                  <td><div align="center">'.$data10.'</div></td>
                </tr>
              </table>

              </div>
              </div>';

              }
$message .= '<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">
<p><strong>Cláusula 9 – DISPOSIÇÕES FINAIS</strong></p>

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<p align="justify">9.1 A obrigação ora reconhecida e assumida pelas partes, aplica-se o disposto no artigo 784, III do Código de Processo Civil, vez que possui força de Título Executivo Extrajudicial.</p>
<p align="justify">9.2 As partes elegem o foro da comarca da Instituição de Ensino para dirimir quaisquer dúvidas oriundas do presente contrato, com renúncia de qualquer outro, por mais privilegiado que seja.</p>
<p align="justify">9.3 Estando assim justos e contratados, firmam o presente instrumento em 02 (duas) vias de igual teor na presença de duas testemunhas.</p>
<p align="justify">9.4 As partes declaram que tiveram prévio conhecimento do conteúdo do presente Contrato.</p>

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<div align="right">Goiânia, '.$datahoje.'</div>

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<div align="center">
	____________________________________
	<p>STUDIO M FOTOGRAFIA EIRELI ME</p>
</div>

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<table width="100%"><tr>';

$sql_contratos1 = mysqli_query($con, "select * from contratos_aprovacao where id_contrato = '$id'");

$cont = "0";

while($vetor_contratos1 = mysqli_fetch_array($sql_contratos1)) { 

$sql_formando1 = mysqli_query($con, "select * from formandos where id_formando = '$vetor_contratos1[id_formando]'");
$vetor_formando1 = mysqli_fetch_array($sql_formando1);

if($cont == "2"){

$message .= '</tr><tr>';

}

$message .= '<td>

<p align="center">_________________________________</p>
<p align="center">'.$vetor_formando1[nome].'
<p align="center">Assinatura Digital Via IP: '.$vetor_contratos1[ip].'

</td>';

$cont++;

}
$message .= '</tr></table><img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<div align="justify">IX.V- Declaram, ainda, as testemunhas abaixo qualificadas que presenciou todas tratativas do instrumento de contrato acima firmado entre as partes.</div> 

<img src="sistema/imgs/transp.png" height="20px">
<img src="sistema/imgs/transp.png" height="20px">

<table width="100%" BORDER="1" style="border-collapse: collapse">

	<tr>
		<td>
			<table width="100%">
				<tr>
					<td width="2%"></td>
					<td>
						<br>
						Nome:_____________________________________________ CPF nº____________________________

						<br>
						<br>
						<br>

						Assinatura:_________________________________________

						<br>
						<br>
						<br>

						Nome:_____________________________________________ CPF nº____________________________

						<br>
						<br>
						<br>

						Assinatura:_________________________________________

						<br>
						<br>
					</td>
					<td width="2%"></td>
				</tr>
			</table>

		</td>
	</tr>

</table>
</body>
</html>';

$diretorio = "arquivos/"; 
$nomeRelatorio = time().uniqid(md5());
$nomegravabanco = $nomeRelatorio.'.pdf';
$resultado = $diretorio.$nomeRelatorio;

$dompdf->loadHtml($message);

$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$output = $dompdf->output();
file_put_contents("sistema/arquivos/$nomeRelatorio.pdf", $output);

$sql_grava_arquivo = mysqli_query($con, "insert into arquivos_contratos (id_cliente, titulo, data, hora, tipo, comissao, arquivo) VALUES ('$vetor[id_turma]', 'Contrato Convite', '$data', '$hora', '2', '1', '$nomegravabanco')");

echo"<script language=\"JavaScript\">
location.href=\"https://studiomfotografia.com.br/areadacomissao/docscomissao.php\";
</script>";

?>