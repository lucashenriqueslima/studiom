<?php

function Mask($mask,$str){
    $str = str_replace(" ","",$str);
    for($i=0;$i<strlen($str);$i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }
    return $mask;
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

include"../includes/conexao.php";


$id = $_GET['id'];

$sql = mysqli_query($con, "select * from duplicatas where id_duplicata = '$id'");
$vetor = mysqli_fetch_array($sql);

$sql_duplicatas = mysqli_query($con, "select * from duplicatas_faturas where id_duplicata = '$id' and status='1' order by data ASC");

$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor[id_formando]'");
$vetor_formando = mysqli_fetch_array($sql_formando);

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor_formando[turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<table width="100%" BORDER="1" style="border-collapse: collapse">
  <tr>
    <td width="50%" valign="top">

      <strong>STUDIO M FOTOGRAFIA EIRELI</strong>
      <br>
      <font size="2">RUA 93 296 QD 7-14 LT 36 SETOR SUL GOIANIA - GO CEP 74083-120</font>
      <br>
      <font size="2">FONE: (62) 3218-3476</font>
      <br>
      <font size="2">CNPJ: 16.683.613/0001-00</font>
      <br>
      <br>
      <font size="2"><?php echo $vetor_turma['ncontrato']; ?> - <?php echo $vetor_curso_inicio['nome']; ?> <?php echo $vetor_turma['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?></font>
      <br>
      
    </td>
    <td width="50%" valign="top">
      
      <div align="right"><strong>DUPLICATA</strong></div>

      <br>
      <br>
      <br>
      <br>
      <br>

      Emissão: <?php $data = date('Y-m-d'); echo date('d/m/Y', strtotime($data)); ?>

    </td>
  </tr>
</table>
<table width="100%" BORDER="1" style="border-collapse: collapse">
  <tr>
    <td>
      <br>
      <table width="100%">
        <tr>
          <td width="2%"></td>
          <td width="96">
            
            <table width="100%" BORDER="1" style="border-collapse: collapse">
              
              <tr>

                <td width="80%" valign="top">
                  
                  <table width="100%" BORDER="1" style="border-collapse: collapse">

                    <tr bgcolor="#e8e8e8">
                      
                      <td width="20%"><font size="2">NF-Fatura nº</font></td>
                      <td width="20%"><font size="2">NF-Fatura – Valor Total</font></td>
                      <td width="20%"><font size="2">Duplicata nº</font></td>
                      <td width="20%"><font size="2">Duplicata - Valor</font></td>
                      <td width="20%"><font size="2">Vencimento</font></td>

                    </tr>
                    <?php 

                    $i = 1;
                    $total = 0;
                    while($vetor_duplicatas = mysqli_fetch_array($sql_duplicatas)) {
                        $total += $vetor_duplicatas['valor'];
                    ?>
                    <tr>
                      
                      <td><?php echo $vetor_turma['ncontrato']; ?> - <?php echo $vetor_formando['id_cadastro']; ?></td>
                      <td><?php echo $num = number_format($vetor_duplicatas['valor'],2,',','.'); ?></td>
                      <td><?php echo $vetor_turma['ncontrato']; ?> - <?php echo $vetor_formando['id_cadastro']; ?> <img src="imgs/transp.png"> <?php echo $i; ?>/<?php echo mysqli_num_rows($sql_duplicatas); ?></td>
                      <td><?php echo $num = number_format($vetor_duplicatas['valor'],2,',','.'); ?></td>
                      <td><?php echo date('d/m/Y', strtotime($vetor_duplicatas['data'])); ?></td>
                      
                    </tr>
                    <?php $i++; } ?>
                  </table>

                  <table width="100%">
                    <tr>
                      
                      <td>
                        <br>
                        <br>
                        <font size="3">
                        Nome do sacado: <?php echo $vetor_formando['nome']; ?>
                        <br>
                        Telefone: <?php echo $vetor_formando['telefone']; ?>
                        <br>
                        E-mail: <?php echo $vetor_formando['email']; ?>
                        <br>
                        Endereço: <?php echo $vetor_formando['endereco']; ?>, N.<?php echo $vetor_formando['numero']; ?>
                        <br>
                        BAIRRO: <?php echo $vetor_formando['bairro']; ?>
                        <br>
                        CIDADE: <?php echo $vetor_formando['cidade']; ?>
                        <br>
                        CEP:  <?php echo $vetor_formando['cep']; ?>   Estado: <?php echo $vetor_formando['estado']; ?>
                        <br>
                        Praça de Pagamento:    A MESMA                                                       
                        <br>
                        CPF:  <?php 
                
                              $qtddoc = strlen($vetor_formando['cpf']);

                              if($qtddoc == 14) {
                              
                              echo Mask("##.###.###/####-##",$vetor_formando['cpf']); 
                              
                              }
                              
                              if($qtddoc == 11) {
                              
                              echo Mask("###.###.###-##",$vetor_formando['cpf']); 
                              
                              }
                              
                              
                              ?>
                              <br>
                              <br>
                              <br>
                        </font>
                      </td>

                    </tr>
                  </table>

                </td>
                <td width="20%" valign="top">
                  <font size="2">
                  <div align="center">
                  Para uso da instituição
                  <br>
                  <br>
                  financeira
                  </div>
                  </font>
                </td>

              </tr>

            </table>
            <table width="100%" BORDER="1" style="border-collapse: collapse">
              <tr>
                <td width="15%" bgcolor="#e8e8e8"><div align="center"><font size="2">Valor por extenso</font></div></td>
                <td width="85%"><strong><?php echo strtoupper(Monetary::numberToExt($total)); ?></strong></td>
              </tr>
            </table>

            <br>
            <br>
            <br>

            <table width="100%">
              <tr>
                <td width="27%">
                  Em: <?php $data = date('Y-m-d'); echo date('d/m/Y', strtotime($data)); ?>
                </td>
                <td width="40%">Aceite: _______________________</td>
                <td width="33%">
                  <table width="100%" BORDER="1" style="border-collapse: collapse">
                    <tr>
                      <td><p class=MsoNormal align=center style='text-align:center;'><span
                      style='font-size:6.0pt;;font-family:"Gill Sans",sans-serif'>NÃO
                      SENDO PAGA NO VENCIMENTO, COBRAR JUROS DE MORA E DESPESAS FINANCEIRAS. NÃO
                      CONCEDER DES-CONTOS, MESMO CONDICIONALMENTE.</span></p></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

          </td>
          <td width="2%"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
<!--
        print();
-->
</script>