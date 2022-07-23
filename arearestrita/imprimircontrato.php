
<?php


session_start();

include"../includes/conexao.php";

$id = $_GET['id'];


$sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
$vetor_venda = mysqli_fetch_array($sql_venda);

$id_arquivos = mysqli_query($con,  'SELECT * FROM arquivos where id_arquivo = (SELECT MAX(id_arquivo) FROM arquivos) ORDER BY id_arquivo DESC');
$vetor_arquivos = mysqli_fetch_array($id_arquivos);

$vetor = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$vetor_venda[id_formando]'"));
$vetor_turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '{$vetor['turma']}'"));

$pasta_turma = $vetor_turma['ncontrato'];
//$pasta_formando = $pasta_turma.'-'.$vetor['id_cadastro'].'-'.strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($vetor['nome'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));

//$diretorio = '../sistema/arquivos/formandos/'.$pasta_turma."/".$pasta_formando;
$file = "../sistema/arquivos/".$vetor_arquivos['arquivo'];

$filename = 'Contrato.pdf'; /* Note: Always use .pdf at the end. */
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
            function $(id){
                return document.getElementById(id);
            }
            window.onload=function(){                
                    window.location="'.$file.'";                
            }
        </script>
</head>
<body>
</body>
</html>';
/*
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file));
header('Accept-Ranges: bytes');

@readfile($file);



/*
class Monetary {
    private static $unidades = array("um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze",
                                     "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove");
    private static $dezenas = array("dez", "vinte", "trinta", "quarenta","cinquenta", "sessenta", "setenta", "oitenta", "noventa");
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

$id = $_GET['id'];

$sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
$vetor_venda = mysqli_fetch_array($sql_venda);

$sql = mysqli_query($con, "select * from formandos where id_formando = '$vetor_venda[id_formando]'");
$vetor = mysqli_fetch_array($sql);

$cpf = Mask("###.###.###-##",$vetor['cpf']);

$sql_dup = mysqli_query($con, "select * from duplicatas where id_venda = '$id'");
$vetor_dup = mysqli_fetch_array($sql_dup);

$sql_duplicatas = mysqli_query($con, "select * from duplicatas_faturas where id_duplicata = '$vetor_dup[id_duplicata]' order by id_item ASC");

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_venda[formapag]'");
$vetor_forma = mysqli_fetch_array($sql_forma);

$sql_pacotes = mysqli_query($con, "select * from pacotes_itens_album where id_item = '$vetor_venda[id_pacote]' order by id_item ASC");
$vetor_pacotes = mysqli_fetch_array($sql_pacotes);

$sql_pacote_venda = mysqli_query($con, "select * from pacotes where id_pacote = '$vetor_pacotes[id_pacote]'");
$vetor_pacote_venda = mysqli_fetch_array($sql_pacote_venda);

$qtdparcelas = $vetor_venda['qtdparcelas'];

if($vetor_venda['formapag'] == 4 || $vetor_venda['formapag'] == 12 || $vetor_venda['formapag'] == 13) { 

    $percentual = $vetor_pacote_venda['desconto'] / 100.0; 
    $valorfinal = $vetor_venda['valorvenda'] - ($percentual * $vetor_venda['valorvenda']); 

} else { 

    $valorfinal = $vetor_venda['valorvenda'];

}

$valorfoto = number_format($vetor_turma['valorfoto'],2,',','.');
$valorextenso = strtoupper(Monetary::numberToExt($vetor_turma['valorfoto']));
$valorencadernacao = number_format($vetor_turma['valorencadernacao'],2,',','.');
$valorencadernacaoextenso = strtoupper(Monetary::numberToExt($vetor_turma['valorencadernacao']));
$arquivodigital = number_format($vetor_turma['valoralbum'],2,',','.');
$arquivodigitalextenso = strtoupper(Monetary::numberToExt($vetor_turma['valoralbum']));
$valorvenda = number_format($valorfinal,2,',','.');
$valorvendaextenso = strtoupper(Monetary::numberToExt($vetor_venda['valorvenda']));
$valorparcela = $valorfinal / $qtdparcelas;
$valorparcelaconv = number_format($valorparcela,2,',','.');
$valorparcelaconvextenso = strtoupper(Monetary::numberToExt($valorparcela));

$mes = date('m'); if($mes == 1) { $mesgerado = "Janeiro"; } if($mes == 2) { $mesgerado = "Fevereiro"; } if($mes == 3) { $mesgerado = "Março"; } if($mes == 4) { $mesgerado = "Abril"; } if($mes == 5) { $mesgerado = "Maio"; } if($mes == 6) { $mesgerado = "Junho"; } if($mes == 7) { $mesgerado = "Julho"; } if($mes == 8) { $mesgerado = "Agosto"; } if($mes == 9) { $mesgerado = "Setembro"; } if($mes == 10) { $mesgerado = "Outubro"; } if($mes == 11) { $mesgerado = "Novembro"; } if($mes == 12) { $mesgerado = "Dezembro"; }

$message = '<!DOCTYPE html>
<html>
<head>
    <title>Impressão de Contrato</title>
</head>
<body>
<table width="100%">
    <tr>
        <td width="50%"><img src="../imgs/LOGOS-LOGIN.png"></td>
        <td width="50%">(62)3218-3476
            <br>
Rua 93 nº 296 qd. F-14 lt. 36
<br>
St. Sul, Goiânia-GO - CEP 74083-120
<br>
cliente@studiomfotografia.com.br
</td>
    </tr>
</table>
<br>
<div align="right">Contrato n° '.$vetor_turma['ncontrato'].'</div>
<p>
</p>
<p>
</p>

<p><strong><div align="center">CONTRATO INDIVIDUAL DE PRESTAÇÃO DE SERVIÇOS FOTOGRÁFICOS</div></strong></p>

<p>
</p>
<table>

<tr>
<td>
<p><strong>Cláusula Primeira - PARTES CONTRATANTES</strong></p>
</td>
</tr>

<tr>
<td>
<p><strong>a) VENDEDORA CONTRATADA</strong>, doravante denominada simplesmente por STUDIO M FOTOGRAFIA, razão social: Studio M Fotografia EIRELI, CNPJ: 16.683.613/0001-00 e endereço da sede à rua 93 nº 296 qd. F-14 lt. 36, Setor Sul, Goiânia-GO.</p>
</td>
</tr>

<tr>
<td>
<p><strong>b) COMPRADOR CONTRATANTE</strong>, doravante designado apenas CONTRATANTE:</p>
</td>
</tr>

<tr>
<td>
<strong>Nome:</strong> '.$vetor['nome'].'
</td>
</tr>

<tr>
<td>
RG: '.$vetor['rg'].'       CPF: '.$cpf.'
</td>
</tr>

<tr>
<td>
Endereço Completo: '.$vetor['endereco'].' '.$vetor['complemento'].' '.$vetor['numero'].'
</td>
</tr>

<tr>
<td>
Setor: '.$vetor['bairro'].'
</td>
</tr>

<tr>
<td>
Cidade: '.$vetor['cidade'].'   UF: '.$vetor['estado'].'   CEP: '.$vetor['cep'].'
</td>
</tr>

<tr>
<td>
Telefone Resid.: '.$vetor['telefone'].'    Comercial: '.$vetor['telcomercial'].'   Celular: '.$vetor['celular'].'
</td>
</tr>

<tr>
<td>
E-mail: '.$vetor['email'].'
</td>
</tr>

<tr>
<td>
<p><strong>Cláusula Segunda - OBJETO DO CONTRATO</strong></p>
</td>
</tr>

<tr>
<td>
<p>O presente instrumento de Contrato de Prestação de Serviços tem por objeto a Comercialização de álbum de fotografia, nas condições abaixo estabelecidas.</p>
</td>
</tr>

<tr>
<td>
<p><strong>Cláusula Terceira – DA PARTICIPAÇÃO DOS EVENTOS</strong></p>
</td>
</tr>

<tr>
<td>
<p>O álbum de fotografia e produto (s) adquirido (s), tão quanto pacotes negociados conforme contrato de prestação de serviços fotográficos e/ou constantes nos informativos de venda negociados com a turma, terá seu valor definido conforme a participação do formando nos eventos e consequente contratação, como segue abaixo:</p>
</td>
</tr>

<tr>
<td>
<p><strong>Eventos.</strong></p>
</td>
</tr>

<tr>
<td>
<table width="40%" class="table table-bordered table-striped">';

$sql_eventos = mysqli_query($con, "select * from eventos_pacote WHERE id_pacote = '$vetor_pacotes[id_item]' order by id_evento_pacote ASC");
                
while ($vetor_eventos=mysqli_fetch_array($sql_eventos)) {

$sql_evento = mysqli_query($con, "select * from eventos_turma_lista where id_evento_turma = '$vetor_eventos[id_evento]'");
$vetor_evento = mysqli_fetch_array($sql_evento);

$sql_evento_nome = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_evento[id_evento]'");
$vetor_evento_nome = mysqli_fetch_array($sql_evento_nome);
                

$message .= '<tr>
<td>'.$vetor_evento_nome['nome'].'</td> 
</tr>';

}

$message .= '</table>
</td>
</tr>

<tr>
<td>
<p><strong>Cláusula Quarta - DOS PRODUTOS ADQUIRIDOS E PREÇO</strong></p>
</td>
</tr>

<tr>
<td>
<table width="100%" class="table table-bordered table-striped">
<tr style="    background: #000000; color: #fff;">
<td width="5%">Item</td>
<td width="95%">Produtos</td>
</tr>';

$sql_itens = mysqli_query($con, "select * from pacotes_itens_produtos WHERE id_pacote = '$vetor_pacotes[id_item]' order by id_produto_item ASC");

$i = 1;

while ($vetor_item=mysqli_fetch_array($sql_itens)) {

$sql_produto = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '$vetor_item[id_produto]'");
$vetor_produto = mysqli_fetch_array($sql_produto);

$valorun = number_format($vetor_item['valor'],2,',','.');
              
$message .= '<tr>
<td>'.$i.'</td>
<td>'.$vetor_produto['nome'].'';

if($vetor_produto['id_tipo'] == 10 || $vetor_produto['id_tipo'] == 11 || $vetor_produto['id_tipo'] == 12 || $vetor_produto['id_tipo'] == 13 || $vetor_produto['id_tipo'] == 15) { 

$message.= ' - '.$vetor_item['qtdpaginas'].' páginas</td>';

}

$i++; }

$message .= '</table>
</td>
</tr>

<tr>
<td>
Em razão dos produtos adquiridos, especificamente, pelo CONTRATANTE, as partes têm por certo e ajustado que o valor total dos produtos contratados é de R$ '.$valorvenda.'('.$valorvendaextenso.'), considerando os produto (s) acima referenciado (s).
</td>
</tr>

<tr>
<td>
<strong>Cláusula Quinta - FORMAS DE PAGAMENTO</strong>
</td>
</tr>

<tr>
<td>
<p>O Pagamento será realizado em '.$qtdparcelas.' parcela (s) de R$ '.$valorparcelaconv.' ('.$valorparcelaconvextenso.'),   através das seguintes opções:</p>
</td>
</tr>

<tr>
<td>
• '.$vetor_forma[nome].'.
</td>
</tr>

<tr>
<td>

<table width="100%" class="table table-bordered table-striped">

<tr style="    background: #000000; color: #fff;">
<td width="20%">Parcela</td>
<td width="20%">Valor</td>
<td width="60%">Data de Vencimento</td>
</tr>';

while ($vetor_item_dup=mysqli_fetch_array($sql_duplicatas)) {

$valorduplicata = number_format($vetor_item_dup['valor'],2,',','.');
$dataduplicata = date('d/m/Y', strtotime($vetor_item_dup['data']));

if($vetor_venda['formapag'] == 3 || $vetor_venda['formapag'] == 6 || $vetor_venda['formapag'] == 7 || $vetor_venda['formapag'] == 3 || $vetor_venda['formapag'] == 14 || $vetor_venda['formapag'] == 15) {

$dataexplode = explode('-', $vetor_item_dup['data']);
$mesdup = $dataexplode[1];

if($mesdup == 1) { $mesgerado1 = "Janeiro"; } if($mesdup == 2) { $mesgerado1 = "Fevereiro"; } if($mesdup == 3) { $mesgerado1 = "Março"; } if($mesdup == 4) { $mesgerado1 = "Abril"; } if($mesdup == 5) { $mesgerado1 = "Maio"; } if($mesdup == 6) { $mesgerado1 = "Junho"; } if($mesdup == 7) { $mesgerado1 = "Julho"; } if($mesdup == 8) { $mesgerado1 = "Agosto"; } if($mesdup == 9) { $mesgerado1 = "Setembro"; } if($mesdup == 10) { $mesgerado1 = "Outubro"; } if($mesdup == 11) { $mesgerado1 = "Novembro"; } if($mesdup == 12) { $mesgerado1 = "Dezembro"; }

$dataduplicata = $mesgerado1.'/'.$dataexplode[0];

} else {

$dataduplicata;

}

$message .= '<tr>
<td>'.$vetor_item_dup['posicao'].'/'.$qtdparcelas.'</td>
<td>R$ '.$valorduplicata.'</td>
<td>'.$dataduplicata.'</td>
</tr>';

}

$message .= '</table>

</td>
</tr>

<tr>
<td>
<p><strong>Cláusula Sexta - DO INADIMPLEMENTO DAS PARCELAS E OBRIGAÇÕES</strong></p>
</td>
</tr>

<tr>
<td>
<p>O não pagamento de qualquer parcela acima ajustado na data prevista caracterizará a mora da <strong>CONTRATANTE</strong> e, implicará no vencimento antecipado da dívida, independente de qualquer notificação do <strong>CONTRATANTE</strong>, com a incidência de multa de 2% (dois por cento), sobre a dívida original, acrescido de juros à taxa de 1% (um por cento) ao mês, bem como atualizaçãoo monetária pelo INPC - Índice Nacional Preço ao Consumidor, além das despesas judiciais e dos honorários advocatórios aqui estabelecidos entre as partes em 20% (vinte por cento), a serem pagos pela <strong>CONTRATANTE</strong> </p>
</td>
</tr>

<tr>
<td>
<p>A rescisão voluntária do contrato ou à que der causa à rescisão motivada da outra, aplicar-se-á multa rescisória de 30% (trinta por cento) sobre o valor do preço total dos produtos adquiridos, além das outras penalidades previstas neste instrumento, bem como aquelas previstas em lei (art. 389 do Código Civil);</p>
</td>
</tr>

<tr>
<td>
<p>A multa não será aplicada a contratante que por ventura não conseguir acompanhar a respectiva turma de formatura, devido a transferência de instituição ou que ficarem pendentes em alguma matéria que o impossibilite de participar da formatura o qual atende este contrato. Caso ocorra, será cobrado apenas o valor proporcional do serviço prestado, relativo aos eventos o qual o formando participou, ou seja, será cobrado apenas pelo serviço prestado e já entregue ao CONTRATANTE.</p>
</td>
</tr>

<tr>
<td>
<p><strong>Cláusula Sétima - DA ENTREGA DO PRODUTO</strong></p>
</td>
</tr>

<tr>
<td>
<p>É obrigação da CONTRATADA entregar os produtos adquiridos pelo CONTRATANTE dentro dos prazos estipulados nas seguintes condições: </p>
</td>
</tr>

<tr>
<td>
<p>Em até 45 dias úteis após o último evento da turma, as fotos dos eventos serão disponibilizadas para a escolha através da plataforma digital da Studio M Fotografia. Em conjunto com as fotografias, serão disponibilizados os mostruários piloto dos produtos no intuito de auxiliar a todos na escolha das fotos.
</p>
</td>
</tr>

<tr>
<td>
A partir da escolha das fotos para a diagramação/montagem do (s) produto (s), em até 30 dias úteis, serão disponibilizados o (s) produto (s) dos formandos, através da plataforma digital para que o (s) mesmo (s) sejam aprovados. Se tiverem alterações/ajustes a serem realizados, os mesmos deverão ser listados na própria plataforma digital para que sejam realizados e encaminhados novamente para a aprovação final. 

</td>
</tr>

<tr>
<td>
A partir da aprovação do (s) produto (s), em até 45 dias úteis, os produtos serão enviados para o endereço indicado pelo formando.

</td>
</tr>

<tr>
<td>
<p><strong>Parágrafo Primeiro:</strong> Para execução correta desse cronograma, o CONTRATANTE deve obedecer aos prazos estipulados naquilo que couber sua atuação (escolha das fotografias e resposta às solicitações) sob pena de ocasionar o atraso na entrega dos materiais por sua culpa exclusiva.  </p>
</td>
</tr>

<tr>
<td>
<p><strong>Parágrafo Segundo:</strong> A CONTRATADA não se responsabiliza por atraso na entrega dos materiais em razão da desídia do CONTRATANTE.</p>
</td>
</tr>

<tr>
<td>
<p><strong>Cláusula Oitava - DAS CONDIÇÕES GERAIS</strong></p>
</td>
</tr>

<tr>
<td>
<p>As partes firmam entre si que o presente contrato, modo que cabe apenas e tão somente ao CONTRATANTE escolher entre os produtos que adquirirá, não se configurando o presente acerto, sob qualquer ângulo, na chamada “venda casada”.</p>
</td>
</tr>

<tr>
<td>
Na hipótese de o CONTRATANTE ficar inadimplente com as obrigações financeiras, os produtos adquiridos por este contrato ficarão retidos até a resolução de tais pendências;
</td>
</tr>

<tr>
<td>
AS PARTES, devidamente nomeadas e qualificadas no preâmbulo deste instrumento, responsabilizam-se solidariamente, em caráter irrevogável e irretratável, pelo cumprimento deste contrato;
</td>
</tr>

<tr>
<td>
A obrigação ora reconhecida e assumida pelos CONTRATANTES, como líquida, certa e exigível, no valor acima mencionado – <strong>CLÁUSULA QUARTA</strong> - , aplica-se o disposto no artigo 784 ,III do Código de Processo Civil , vez que possui força de <strong>Título Executivo Extrajudicial o presente Instrumento de acordo</strong>. 
</td>
</tr>

<tr>
<td>
<p><strong>Cláusula Nona - Foro</strong></p>
</td>
</tr>

<tr>
<td>
Fica eleito o foro da Comarca da instituição de Ensino, com renúncia expressa de qualquer outro, por mais privilegiado que seja, para solucionar todas as questões divergentes, resultantes da interpretação deste instrumento e, para nele, serem demandados a execução do cumprimento de todas as obrigações oriundas deste contrato, não obstante qualquer mudança de domicílio.
</td>
</tr>

<tr>
<td>
<p>Por estarem assim, justos e acordados, assinam o presente instrumento em 02 (duas) vias de igual teor na presença de 02 (duas) testemunhas para que surta os efeitos jurídicos e legais.</p>
</td>
</tr>

<tr>
<td>
<p>Goiânia, '.date('d').' de '.$mesgerado.' de '.date('Y').'.</p>
</td>
</tr>

<tr>
<td>
<p></p>
</td>
</tr>

<tr>
<td>
<p></p>
</td>
</tr>

<tr>
<td>
<p></p>
</td>
</tr>

<tr>
<td>
<p>_______________________________</p>
</td>
</tr>

<tr>
<td>
CONTRATADA
</td>
</tr>

<tr>
<td>
Studio M Fotografia EIRELI
</td>
</tr>

<tr>
<td>
<p></p>
</td>
</tr>

<tr>
<td>
<p></p>
</td>
</tr>

<tr>
<td>
<p></p>
</td>
</tr>

<tr>
<td>
<p></p>
</td>
</tr>

<tr>
<td>
<p></p>
</td>
</tr>

<tr>
<td>
<p>_______________________________</p>
</td>
</tr>

<tr>
<td>
CONTRATANTE
</td>
</tr>

<tr>
<td>
'.$vetor['nome'].'
</td>
</tr>

</table>

<table width="100%" BORDER="1" style="border-collapse: collapse">
    <tr>
        <td width="50%"><br>_______________________________<br><br></td>
        <td width="50%"><br>_______________________________<br><br></td>
    </tr>
    <tr>
        <td>Testemunha 1</td>
        <td>Testemunha 2</td>
    </tr>
    <tr>
        <td>Nome:<br><br>CPF:<br><br></td>
        <td>Nome:<br><br>CPF:<br><br></td>
    </tr>
</table>

</body>
</html>';

echo $message;

?>

<script type="text/javascript">
<!--
        print();
-->
</script>