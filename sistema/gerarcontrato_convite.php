<?php

session_start();



include"../includes/conexao.php";


require '../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

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

function Mask($mask,$str){

    $str = str_replace(" ","",$str);

    for($i=0;$i<strlen($str);$i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }

    return $mask;

}

$data = date('Y-m-d');
$hora = date('H:i:s');

$id = $_GET['id'];

$sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
$vetor_venda = mysqli_fetch_array($sql_venda);

$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor_venda[id_formando]'");
$vetor_formando = mysqli_fetch_array($sql_formando);

$sql_itens_venda = mysqli_query($con, "select * from itens_venda_individual where id_venda = '$id'");

$cpf = Mask("###.###.###-##",$vetor_formando['cpf']);

$message = '<!DOCTYPE html>
<html>
<head>
	<title>Impressão de Contrato</title>
</head>
<body>
<div align="right"><b>CONTRATO COMPRA E VENDA DE CONVITES DE FORMATURA</b></div>
<br>
<div align="right">Convites Gráficos</div>
<br>
<br>
<table>

<tr>
<td>
<p><div align="justify">Pelo presente documento e na melhor forma de direito, de um lado <strong>STUDIO M FOTOGRAFIA EIRELI ME</strong>, pessoa jurídica de direito privado, inscrita no CNPJ sob o n° 16.683.613/0001-00, com sede na Rua 93 nº 296  qd. F-14 lt. 36, Setor Sul, Goiânia-Goiás, ora denominada CONTRATADA.</div>
</td>
</tr>

<tr>
<td>
<p><div align="justify">Noutro lado, denominada CONTRATANTE, '.$vetor_formando[nome].', brasileiro, portador da C.I n.º '.$vetor_formando[rg].', inscrito no CPF n, '.$cpf.', residente e domiciliado à '.$vetor_formando[endereco].' '.$vetor_formando[complemento].' '.$vetor_formando[numero].', Bairro: '.$vetor_formando[bairro].', Cidade: '.$vetor_formando[cidade].' UF: '.$vetor[estado].'. </div>
</td>
</tr>

<tr>
<td>
<p></p>
</td>
</tr>

<tr>
<td>
<p><strong>Cláusula 1 - DA REPRESENTAÇÃO</strong></p>
</td>
</tr>

<tr>
<td>
<p></p>
</td>
</tr>

</table>
</body>
</html>';

echo $message;

?>