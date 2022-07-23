<?php

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');


include"includes/conexao.php";

$id = $_GET['id'];
$id_formando = $_GET['id_formando'];

$sql_contrato_convite = mysqli_query($con, "select * from contratos_convite where id_turma = '$id' and status = '1'");
$vetor_contrato_convite = mysqli_fetch_array($sql_contrato_convite);

$sql_orcamento = mysqli_query($con, "select * from orcamento_convite where id_orcamento = '$vetor_contrato_convite[id_orcamento]'");
$vetor_orcamento = mysqli_fetch_array($sql_orcamento);

if($vetor_orcamento['tipo'] == 1) {

$sql_oportunidade = mysqli_query($con, "select * from oportunidades where id_oportunidade = '$vetor_orcamento[id_oportunidade]'");
$vetor_oportunidade = mysqli_fetch_array($sql_oportunidade);

$sql_mkt = mysqli_query($con, "select * from prospeccoes where id_prospeccao = '$vetor_oportunidade[id_prospeccao]'");
$vetor_prospeccao = mysqli_fetch_array($sql_mkt);

$sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '$vetor_prospeccao[id_turma]'");
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

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>StudioM Fotografia</title>
</head>
<link rel="stylesheet" href="layout/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="icon" type="image/png" sizes="32x32" href="imgs/logo1.png">

<style>

          body {
		  background-image: url("imgs/fundo.png");
		  }

          #box {
          width:240px;
          height:100%;
          border-radius: 10px;
          margin: auto;
          padding:10px;
          margin-bottom: 20px;
          }

          #license-box {
    font-family: Verdana, Arial, Sans-Serif;
    width: 100%;
    padding: 20px 30px;
    border-radius: 5px;
    box-shadow: 1px 1px 10px #999;
    margin: auto;

    background: #ffffff; /* Old browsers */
    background: -moz-linear-gradient(top,  #ffffff 0%, #f3f3f3 50%, #ededed 51%, #ffffff 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(50%,#f3f3f3), color-stop(51%,#ededed), color-stop(100%,#ffffff)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* IE10+ */
    background: linear-gradient(to bottom,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
  }

  #license-box h1 {
    font-size: 20px;
    color: #333333;
    text-transform: uppercase;
    text-align: center;
  }

  #license-box .text textarea {
    width: 100%;
    height: 400px;
    border-color: #f1f1f1;
    background-color: #fff;
  }

  #license-box .next {
    padding: 15px 0 0 0;
    float: right;
  }

  #license-box .next input {
    padding: 5px 20px;
    color: #fff;
    font-weight: bold;
    border-width: 0;
    border-radius: 5px;
    box-shadow: 1px 1px 5px #666;
    cursor: pointer;
    background: #b4e391; /* Old browsers */
    background: -moz-linear-gradient(top,  #b4e391 0%, #61c419 50%, #b4e391 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b4e391), color-stop(50%,#61c419), color-stop(100%,#b4e391)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* IE10+ */
    background: linear-gradient(to bottom,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4e391', endColorstr='#b4e391',GradientType=0 ); /* IE6-9 */
  }

  #license-box .next input:disabled {
    background: #e2e2e2; /* Old browsers */
    background: -moz-linear-gradient(top,  #e2e2e2 0%, #dbdbdb 50%, #d1d1d1 51%, #fefefe 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e2e2e2), color-stop(50%,#dbdbdb), color-stop(51%,#d1d1d1), color-stop(100%,#fefefe)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* IE10+ */
    background: linear-gradient(to bottom,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#fefefe',GradientType=0 ); /* IE6-9 */
  }

  #license-box .checkbox {
    padding: 20px 0;
  }

  #license-box .checkbox input {
    margin-right: 5px;
  }

  #license-box .checkbox label {
    font-size: 12px;
    font-weight: bold;
  }

  .circle img {
    background-color: #ddd;
    border-radius: 100%;
    height: 100px;
    width: 100px;
    object-fit: cover;
  }

</style>

<body>

<br>
<br>
<br>
<br>

<div class="container">

<table width="100%">
	<tr>
		<td><img src="imgs/LOGOS-LOGIN.png"></td>
	</tr>
</table>

<br>
<br>
<br>

<form method="post" action="recebe_aprovacao_contrato.php?id=<?php echo $id; ?>&id_formando=<?php echo $id_formando; ?>&id_contrato=<?php echo $vetor_contrato_convite['id_contrato']; ?>">
    <div id="license-box">
        <h1>Contrato Convite</h1>
        <div class="text">
            <textarea disabled="true">

CONTRATO DE PRESTAÇÃO DE SERVIÇOS

Convites Gráficos n° <?php echo $id; ?>
			
Pelo presente documento e na melhor forma de direito, de um lado STUDIO M FOTOGRAFIA EIRELI ME, pessoa jurídica de direito privado, inscrita no CNPJ sob o n° 16.683.613/0001-00, com sede na Rua 93 nº 296 qd. F-14 lt. 36, Setor Sul CEP: 74083-120, Goiânia-Goiás, ora denominada CONTRATADA.

Noutro lado, denominada CONTRATANTE, a COMISSÃO DE FORMATURA, constituída e representada pelos formandos abaixo qualificados do curso de <?php if($vetor_orcamento['tipo'] == 1) { ?> <?php echo $vetor_curso['nome']; ?> da  Instituição  de  Ensino <?php echo $vetor_curso['sigla']; ?> – <?php echo $vetor_instituicao['nome']; ?>, com ano e semestre de conclusão em <?php echo $vetor_turma['conclusao']; ?>-<?php echo $vetor_turma['semestre']; ?>.<?php } if($vetor_orcamento['tipo'] == 2) { ?> <?php echo $vetor_curso_inicio['nome']; ?> da  Instituição  de  Ensino <?php echo $vetor_instituicao['sigla']; ?> - <?php echo $vetor_instituicao['nome']; ?>, com ano e semestre de conclusão em <?php echo $vetor_oportunidade['ano']; ?>.<?php } ?>



Cláusula I - DA REPRESENTAÇÃO

1.1 Os formandos acima qualificados, na qualidade de Membros da Diretoria da Associação da Comissão de Formatura, que aqui é a CONTRATANTE, atuarão como legítimos representantes dos formandos do curso supracitado.


1.2 Estabelecidas as diretrizes contratuais abaixo alinhadas (condições, produtos, prazos e preços), os formandos deverão, individualmente, contratar os convites de formatura mediante assinatura do CONTRATO INDIVIDUAL DE COMPRA E VENDA DE CONVITE DE FORMATURA.

1.3 Fixadas as considerações iniciais, as partes têm entre si, justas e contratadas, o seguinte que mutuamente aceitam e outorgam.

Cláusula 2 – DO OBJETO

2.1 O presente instrumento tem por finalidade delimitar a prestação de serviços de confecção de convite de formatura, bem como ajustar os preços e especificar os produtos que serão colocados à disposição do (a) formando (a)  interessado (a)  que serão objetos de contratação por meio de instrumento particular de compra e venda de convite de formatura.

2.2 Para este fim, a Comissão de Formatura APROVA EXPRESSAMENTE a última proposta de confecção de convite de formatura encaminhada pela Contratada, cujo teor faz parte integrante deste instrumento. 

2.3 A CONTRANTE informa para os devidos fins contratuais, que o convite de formatura será composto por <?php echo $vetor_orcamento['qtdformandos']; ?> (<?php echo Extenso::converte($vetor_orcamento['qtdformandos'], false, true); ?>) formandos.

Cláusula 3 - ESPECIFICAÇÃO

3.1 A CONTRATADA, por conta e ordem exclusiva da CONTRATANTE, encarregar-se-á da prestação dos serviços de criação, arte-finalização, impressão e acabamento dos convites gráficos de formatura especificados abaixo:


<?php

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

?>

<?php echo $vetor_produtos['qtd']; ?> Super Luxo – <?php echo $vetor_tipo_final['titulo']; ?>

Embalagem do Convite: <?php echo $vetor_tipo_final_embalagem['titulo']; ?>

Acabamento Interno da Embalagem:

						
						<?php

							$sql_acabamento_interno = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '3'");

							$total_acabamento_interno = mysqli_num_rows($sql_acabamento_interno);

							$i = 1;

							while($vetor_acabamento_interno = mysqli_fetch_array($sql_acabamento_interno)) { 

							$result_acabamento_interno = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_acabamento_interno[id_itemtabela]'");
							$vetor_tabela_acabamento_interno = mysqli_fetch_array($result_acabamento_interno);

							$sql_tipo_final_acabamento_interno = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_acabamento_interno[id_itemtabela]'");
							$vetor_tipo_final_acabamento_interno = mysqli_fetch_array($sql_tipo_final_acabamento_interno);

						?>
						
						<?php echo $vetor_tipo_final_acabamento_interno['titulo']; ?><?php if($total_acabamento_interno > $i) { echo ", "; } if($total_acabamento_interno == $i) { echo "."; } ?>

						<?php $i++; } ?>

					
					Acabamento Externo da Embalagem:

						
						<?php

							$sql_acabamento_externo = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '8'");

							$total_acabamento_externo = mysqli_num_rows($sql_acabamento_externo);

							$f = 1;

							while($vetor_acabamento_externo = mysqli_fetch_array($sql_acabamento_externo)) { 

							$result_acabamento_externo = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$total_acabamento_externo[id_itemtabela]'");
							$vetor_tabela_acabamento_externo = mysqli_fetch_array($result_acabamento_externo);

							$sql_tipo_final_acabamento_externo = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_acabamento_externo[id_itemtabela]'");
							$vetor_tipo_final_acabamento_externo = mysqli_fetch_array($sql_tipo_final_acabamento_externo);

						?>
						
						<?php echo $vetor_tipo_final_acabamento_externo['titulo']; ?><?php if($total_acabamento_externo > $f) { echo ", "; } if($total_acabamento_externo == $f) { echo "."; } ?>

						<?php $f++; } ?>

					
					Convite

					Capa:

						
						<?php

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

						?>
						
						<?php echo $vetor_tipo_final_capa['titulo']; ?><?php if($total_capa > $g) { echo ", "; } if($total_capa == $g) { echo "."; } ?>

						<?php $g++; } ?>

				<?php if(mysqli_num_rows($sql_sobrecapa) > 0) { ?>
				
				Sobrecapa/Encarte:

				<?php echo $vetor_tipo_final_sobrecapa['titulo']; ?>

				<?php } ?>
				
				Componentes Padrão do Miolo

				1 Capa do Bloco (Capa Mole) - Couchê Fosco 250g

				<?php echo $vetor_tabela_final['paginas']; ?> Páginas Padrão - Couchê Fosco 170g

				<?php echo $vetor_tabela_final['paginaspersonalizadas']; if($vetor_tabela_final['paginaspersonalizadas'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Personalizadas - Couchê Fosco 170g

				Componentes Extras do Miolo

				<?php

                    $tabela_paginasextras = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '34'");
                    $vetor_tabela_paginasextras = mysqli_fetch_array($tabela_paginasextras);

                    if(mysqli_num_rows($tabela_paginasextras) > 0) {

                ?>
                
                <?php echo $vetor_tabela_paginasextras['qtd']; if($vetor_tabela_paginasextras['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Extras - Couchê Fosco 170g

				<?php

					}

                    $tabela_paginasextraspersonalizadas = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '75'");
                    $vetor_tabela_paginasextraspersonalizadas = mysqli_fetch_array($tabela_paginasextraspersonalizadas);

                    if(mysqli_num_rows($tabela_paginasextraspersonalizadas) > 0) {

                ?>
                
                <?php echo $vetor_tabela_paginasextraspersonalizadas['qtd']; if($vetor_tabela_paginasextraspersonalizadas['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Extras Personalizadas - Couchê Fosco 170g

				<?php

					}

                    $tabela_miniposter = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '36'");
                    $vetor_tabela_miniposter = mysqli_fetch_array($tabela_miniposter);

                    if(mysqli_num_rows($tabela_miniposter) > 0) {

                ?>
                
                <?php echo $vetor_tabela_miniposter['qtd']; ?> Mini Poster - Couchê Fosco 170g

				<?php

					}

                    $tabela_vegetalcomum = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '37'");
                    $vetor_tabela_vegetalcomum = mysqli_fetch_array($tabela_vegetalcomum);

                    if(mysqli_num_rows($tabela_vegetalcomum) > 0) {

                ?>
                
                <?php echo $vetor_tabela_vegetalcomum['qtd']; if($vetor_tabela_vegetalcomum['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Vegetal Comum - Vegetal 90g

				<?php

					}

                    $tabela_vegetalpersonalizado = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '38'");
                    $vetor_tabela_vegetalpersonalizado = mysqli_fetch_array($tabela_vegetalpersonalizado);

                    if(mysqli_num_rows($tabela_vegetalpersonalizado) > 0) {

                ?>
                
                <?php echo $vetor_tabela_vegetalpersonalizado['qtd']; if($vetor_tabela_vegetalpersonalizado['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Vegetal Personalizado - Vegetal 90g

				<?php

					}

                    $tabela_acetatocomum = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '71'");
                    $vetor_tabela_acetatocomum = mysqli_fetch_array($tabela_acetatocomum);

                    if(mysqli_num_rows($tabela_acetatocomum) > 0) {

                ?>
                
                <?php echo $vetor_tabela_acetatocomum['qtd']; if($vetor_tabela_acetatocomum['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Transparência Comum - Acetato transparente

				<?php

					}

                    $tabela_acetatopersonalizado = mysqli_query($con, "select * from orcamento_itens where '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_itemtabela = '72'");
                    $vetor_tabela_acetatopersonalizado = mysqli_fetch_array($tabela_acetatopersonalizado);

                    if(mysqli_num_rows($tabela_acetatopersonalizado) > 0) {

                ?>
                
                <?php echo $vetor_tabela_acetatopersonalizado['qtd']; if($vetor_tabela_acetatopersonalizado['qtd'] > 1) { echo " Páginas"; } else { echo " Página"; } ?>  Transparência Personalizado - Acetato transparente

				<?php } ?>
			

<?php

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

?>


Total de Páginas: <?php echo $totalpaginas; ?> Valor Unitário: R$ <?php echo $num = number_format($totalunproduto,2,',','.'); ?> Total: R$ <?php echo $num = number_format($totalproduto,2,',','.'); ?>



<?php } if($vetor_produtos['id_produto'] == 4) { 

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

?>

<?php echo $vetor_produtos['qtd']; ?> Convite Simples – <?php echo $vetor_tipo_final['titulo']; ?>

Embalagem do Convite: <?php echo $vetor_tipo_final_embalagem['titulo']; ?>

			Acabamento da Embalagem:</strong>

						<?php

							$sql_acabamento_interno = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '3'");

							$total_acabamento_interno = mysqli_num_rows($sql_acabamento_interno);

							$i = 1;

							while($vetor_acabamento_interno = mysqli_fetch_array($sql_acabamento_interno)) { 

							$result_acabamento_interno = mysqli_query($con, "SELECT * FROM tabela_basico_itens WHERE id_itemtabela = '$vetor_acabamento_interno[id_itemtabela]'");
							$vetor_tabela_acabamento_interno = mysqli_fetch_array($result_acabamento_interno);

							$sql_tipo_final_acabamento_interno = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_tabela_acabamento_interno[id_itemtabela]'");
							$vetor_tipo_final_acabamento_interno = mysqli_fetch_array($sql_tipo_final_acabamento_interno);

						?>
						
						<?php echo $vetor_tipo_final_acabamento_interno['titulo']; ?><?php if($total_acabamento_interno > $i) { echo ", "; } if($total_acabamento_interno == $i) { echo "."; } ?>

						<?php $i++; } ?>

					
						Quantidade de Paginas:

						<?php

							$sql_paginas = mysqli_query($con, "select * from orcamento_itens where id_orcamento = '$vetor_orcamento[id_orcamento]' AND id_produto = '$vetor_produtos[id_item]' and id_tipo = '10'");
							$vetor_paginas = mysqli_fetch_array($sql_paginas);

							$sql_tipo_final_paginas = mysqli_query($con, "select * from tabela_tipos where id_tipo = '$vetor_paginas[id_itemtabela]'");
							$vetor_tipo_final_paginas = mysqli_fetch_array($sql_tipo_final_paginas);

						?>
						
						<?php echo $vetor_tipo_final_paginas['titulo']; ?>

					
<?php

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

?>


	Valor Unitário: R$ <?php echo $num = number_format($totalunproduto,2,',','.'); ?> Total: R$ <?php echo $num = number_format($totalproduto,2,',','.'); ?>

<?php } ?>

<?php } ?>

Cláusula 4- PREÇO E PAGAMENTO


Cláusula V - DA CONTRATAÇÃO INDIVIDUAL


5.1 Em período acordado entre CONTRATANTE e CONTRATADA, serão firmados os contratos individuais com os formandos.

5.2 Os valores acima referenciados serão pagos através de transferência bancária, cartões de crédito, boleto bancário,  em data acordada entre as partes, de forma online mediante assinatura eletrônica  do contrato individual pelo interessado. 

5.3 Caso a quantidade de convites solicitados pela turma seja inferior ao acordado neste contrato, poderá haver a readequação das especificações dos convites ou dos valores ora acordados, cabendo as partes definir as novas especificações e/ou novos valores, sem prejuízos de incidência de multa contratual. 

5.4 Quaisquer serviços relacionados aos convites de formatura não previsto neste contrato deverão ser objeto de aditivo contratual devidamente assinado pelas partes. 

5.5 A CONTRATADA deverá entregar os convites de formatura para o representante legal da Comissão e Formatura, na cidade da Instituição de Ensino da CONTRANTE, no prazo previsto no cronograma de execução de serviços. 

5.6 Um membro representante legal da Comissão de Formatura ficará responsável pelo recebimento dos convites de formatura, por consequência entregará os convites aos contratantes individuais. Para tanto, deverá a CONTRATANTE nomear um de seus representantes legais para receber os convites de formatura contratados.


Cláusula 6 - CONDIÇÕES GERAIS


6.1 A CONTRATADA se reserva no direito de posicionar sua marca na última página do convite de formatura, indicando sua autoria sobre o projeto.

6.2 Caso o layout do convite venha a ser modificado ou substituído após aprovação pela CONTRATANTE, será cobrada taxa adicional de R$ 2.200,00 (dois mil e duzentos reais) a título de novo serviço de criação prestado à turma;

6.3 Os  CONTRATANTES responsabilizam-se, desde já, pelo repasse de informações que constarão no convite, tais como: nomes (alunos/professores/homenageados/demais), mensagens, textos, imagens, tema e revisão final (ortográfica/visual) do material a ser confeccionado. A CONTRATANTE exime a empresa de qualquer responsabilidade pela falta de informações essenciais requeridas para o convite de formatura, advindas da Comissão de Formatura e/ou dos formandos;

6.4 Os textos e demais dados pertinentes à elaboração do objeto deste contrato deverão ser encaminhados a CONTRATADA até a data acordada. Em eventual atraso, as datas serão reajustadas proporcionalmente.

6.5 O prazo para entrega dos convites e seus acessórios será de 45 (quarenta e cinco) dias contados da data de aprovação final, significando assim, neste ato, que a CONTRATANTE autoriza a CONTRATADA a seguir com os convites para a impressão gráfica.

6.6 A CONTRATADA não se responsabiliza por promessas, indicações de terceiros, ou ainda, outro tipo de agenciamento de serviços que não estejam explicitados neste contrato;

6.7 Os CONTRATANTES se comprometem penalmente e na forma da lei dos Direitos Autorais a não copiar, reproduzir, alugar, emprestar ou transferir, de qualquer maneira que seja, o material/serviço descrito na Cláusula 2.

6.8 Na hipótese dos CONTRATANTES ficarem inadimplentes com as obrigações financeiras, advindas dos convites, acessórios ou débitos adquiridos através das solicitações para produção dos produtos contratados - descritos e estipulados neste termo ou em adendo , o objeto deste contrato ficará retido até a solução de tais pendências;


Cláusula 7 – DAS MULTA E PENALIDADES


7.1 Em caso de rescisão contratual durante o desenvolvimento do layout geral ou dos convites individuais, fica ajustado a incidência de multa contratual equivalente a 50% (cinquenta por cento) da totalidade do preço ajustado neste instrumento ( Cláusula 4 - item “ 4.2”)

7.2 Em caso de rescisão contratual durante a confecção gráfica dos convites, fica ajustado a incidência de multa contratual equivalente a 100% (cem por cento) da totalidade do preço ajustado neste instrumento ( Cláusula 4 - item “ 4.2”).


Cláusula 8 – DO CRONOGRAMA


8.1  A execução do presente contrato deverá obedecer o cronograma de execução de serviços.  

Para tanto, em comum acordo, ajustam as partes:

<?php if($vetor_orcamento['dataentrega'] != NULL) { ?>

ETAPAS      DATA DO ENVIO      CONCLUSÃO

1  Questionário de Identidade Visual.  <?php echo date('d/m/Y', strtotime($vetor_orcamento['questionario1'])); ?>  <?php echo date('d/m/Y', strtotime($vetor_orcamento['questionario'])); ?>

2  Confecção da Temática.  <?php echo date('d/m/Y', strtotime($vetor_orcamento['confeccaotematica1'])); ?>  <?php echo date('d/m/Y', strtotime($vetor_orcamento['confeccaotematica'])); ?>

3  Aprovação final da Temática do Convite.  <?php echo date('d/m/Y', strtotime($vetor_orcamento['aprovacaofinaltematica'])); ?>

4  Prazo limite para entrega dos Dados do Convite Gráfico.  <?php echo date('d/m/Y', strtotime($vetor_orcamento['prazolimiteentrega'])); ?>

5  Data limite para acréscimo de convites extras.  <?php echo date('d/m/Y', strtotime($vetor_orcamento['datalimiteconvextras'])); ?>

6  Data da Aprovação Final do Convite.  <?php echo date('d/m/Y', strtotime($vetor_orcamento['dataaprovacaofinal'])); ?>

7  Data de envio do material para impressão.  <?php echo date('d/m/Y', strtotime($vetor_orcamento['dataenviomaterial'])); ?>

8  Entrega dos Convites.  <?php echo date('d/m/Y', strtotime($vetor_orcamento['dataentrega'])); ?>

<?php } ?>


Cláusula 9 – DISPOSIÇÕES FINAIS


9.1 A obrigação ora reconhecida e assumida pelas partes, aplica-se o disposto no artigo 784, III do Código de Processo Civil, vez que possui força de Título Executivo Extrajudicial. 

9.2 As partes elegem o foro da comarca da Instituição de Ensino para dirimir quaisquer dúvidas oriundas do presente contrato, com renúncia de qualquer outro, por mais privilegiado que seja.

9.3 Estando assim justos e contratados, firmam o presente instrumento em 02 (duas) vias de igual teor na presença de duas testemunhas.

9.4 As partes declaram que tiveram prévio conhecimento do conteúdo do presente Contrato.


Goiânia, <?php echo $data_extenso = strftime('%d de %B de %Y', strtotime('today')); ?>



____________________________________
	STUDIO M FOTOGRAFIA EIRELI ME


IX.V- Declaram, ainda, as testemunhas abaixo qualificadas que presenciou todas tratativas do instrumento de contrato acima firmado entre as partes.

Nome:_____________________________________________ CPF nº____________________________


Assinatura:_________________________________________


Nome:_____________________________________________ CPF nº____________________________


Assinatura:_________________________________________


            </textarea>
        </div>
        <div>
            
            
        </div>
    </div>

    <input id="license-check" type="checkbox" value="2" required="" />
    <label for="license-check">Eu Aceito</label>

    <input id="btn-next" class="btn btn-success" type="submit" value="Avançar" />

    </form>	

</div>

</body>
</html>