<?php
include "../includes/conexao.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
$mail = new PHPMailer(true);
session_start();
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
if ($_SESSION['id_formando'] == null || $_SESSION['id_formando'] == '') {
	echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";
}else {
    // Pegando itens adicionados anteriormente
	$produtos = array();
	$valor_total = 0;
	$i = 0;
	foreach ($_POST['id_item'] as $key) {
		array_push($produtos, [$_POST['id_item'][$i], $_POST['valor_item'][$i], $_POST['qtd'][$i]]);
		$valor_total += $_POST['qtd'][$i] * $_POST['valor_item'][$i];
		$i++;
	}
	
	// Tipos Produtos, nome
	$tipos_produtos = array();
	$sql = mysqli_query($con, "select * from tipos_produtos");
	while($tipo = mysqli_fetch_array($sql)){
	    $tipos_produtos[$tipo['id_tipo']] = $tipo['nome'];
    }
	
	$formando = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$_SESSION[id_formando]'"));
	$id_p = $_GET['id_p'];
	$formapag = $_POST['formapag'];
	$vencimento = $_POST['vencimento'];

//	$parcelamento = (isset($_POST['parcelamento_antecipado'])?$_POST['parcelamento_antecipado']:(isset($_POST['parcelamento_pos'])?$_POST['parcelamento_pos']:0));
	$parcelamento = (isset($_POST['parcelamento_antecipado'])?$_POST['parcelamento_antecipado']:'0');

	

	$sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$formapag'");
	$vetor_forma = mysqli_fetch_array($sql_forma);
    
    //contrato 
    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));
    $vetor_turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '{$vetor_cadastro['turma']}'"));

    $sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '{$vetor_turma['id_instituicao']}'");
    $vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
    $sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '{$vetor_turma['curso']}'");
    $vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
    $cpf = Mask("###.###.###-##",$vetor_cadastro['cpf']);
    $dataaceite = date('d/m/Y');
    $horaatual = date('H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];


    $vetor_pacote_turma = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_turma where id_pacote = '{$id_p}'"));
    $vetor_produtos_turma = mysqli_fetch_array(mysqli_query($con, "select * from produtos_turma where id_produto = '{$vetor_pacote_turma['id_produto']}'"));
    ?>
    <!DOCTYPE html>
    <html dir="ltr" lang="en">

    <head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="../layout/assets/images/favicon.png">
        <title>Studio M Fotografia</title>
        <!-- Custom CSS -->
        <link href="../layout/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
        <link href="../layout/assets/extra-libs/c3/c3.min.css" rel="stylesheet">

        <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../layout/dist/css/style.min.css" rel="stylesheet">

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="../layout/assets/libs/tinymce/tinymce.min.js"></script>

        <script>
            $(function () {
                if ($("#mymce").length > 0) {
                    tinymce.init({
                        selector: "textarea#mymce",
                        menubar: false,
                        toolbar: false,
                        branding: false,
                        readonly: true,
                        height: 500,
                        alignjustify: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full' }
                    });
                }
                if ($("#mymce2").length > 0) {
                    tinymce.init({
                        selector: "textarea#mymce2",
                        menubar: false,
                        toolbar: false,
                        branding: false,
                        readonly: true,
                        height: 500,
                        alignjustify: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full' }
                    });
                }
            });
        </script>
        <style type="text/css">
            #license-box {
                font-family: Verdana, Arial, Sans-Serif;
                width: 100%;
                padding: 20px 30px;
                border-radius: 5px;
                box-shadow: 1px 1px 10px #999;
                margin: auto;

                background: #ffffff; /* Old browsers */
                background: -moz-linear-gradient(top, #ffffff 0%, #f3f3f3 50%, #ededed 51%, #ffffff 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ffffff), color-stop(50%, #f3f3f3), color-stop(51%, #ededed), color-stop(100%, #ffffff)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top, #ffffff 0%, #f3f3f3 50%, #ededed 51%, #ffffff 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top, #ffffff 0%, #f3f3f3 50%, #ededed 51%, #ffffff 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top, #ffffff 0%, #f3f3f3 50%, #ededed 51%, #ffffff 100%); /* IE10+ */
                background: linear-gradient(to bottom, #ffffff 0%, #f3f3f3 50%, #ededed 51%, #ffffff 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#ffffff', GradientType=0); /* IE6-9 */
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
                background: -moz-linear-gradient(top, #b4e391 0%, #61c419 50%, #b4e391 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #b4e391), color-stop(50%, #61c419), color-stop(100%, #b4e391)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top, #b4e391 0%, #61c419 50%, #b4e391 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top, #b4e391 0%, #61c419 50%, #b4e391 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top, #b4e391 0%, #61c419 50%, #b4e391 100%); /* IE10+ */
                background: linear-gradient(to bottom, #b4e391 0%, #61c419 50%, #b4e391 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b4e391', endColorstr='#b4e391', GradientType=0); /* IE6-9 */
            }

            #license-box .next input:disabled {
                background: #e2e2e2; /* Old browsers */
                background: -moz-linear-gradient(top, #e2e2e2 0%, #dbdbdb 50%, #d1d1d1 51%, #fefefe 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #e2e2e2), color-stop(50%, #dbdbdb), color-stop(51%, #d1d1d1), color-stop(100%, #fefefe)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top, #e2e2e2 0%, #dbdbdb 50%, #d1d1d1 51%, #fefefe 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top, #e2e2e2 0%, #dbdbdb 50%, #d1d1d1 51%, #fefefe 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top, #e2e2e2 0%, #dbdbdb 50%, #d1d1d1 51%, #fefefe 100%); /* IE10+ */
                background: linear-gradient(to bottom, #e2e2e2 0%, #dbdbdb 50%, #d1d1d1 51%, #fefefe 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e2e2e2', endColorstr='#fefefe', GradientType=0); /* IE6-9 */
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

            p{
                text-align: justify !important;
                display:inline-block !important;
            }
        </style>
        
    </head>

    <body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                                class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="inicio.php">
                        <b class="logo-icon">

                            <img src="../layout/assets/images/logo-2.png" alt="homepage" class="dark-logo"
                                 width="110px"/>

                            <img src="../layout/assets/images/logo-icon.png" alt="homepage" class="light-logo"
                                 width="50px"/>
                        </b>

                    </a>

                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                       data-toggle="collapse" data-target="#navbarSupportedContent"
                       aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                                class="ti-more"></i></a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                    class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                    data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>


                    </ul>

                    <ul class="navbar-nav float-right">


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                        src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>" alt="user"
                                        class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img
                                                src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"
                                                alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $vetor_cadastro['nome']; ?></h4>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="sair.php"><i class="fa fa-power-off m-r-5 m-l-5"></i>
                                    Sair</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
			<?php include "includes/menu.php"; ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Minhas Compras</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <!--<form method="post" action="recebe_finaliza_convite.php?id_p=<?php //echo $id_p; ?>">-->
                                <form method="post" action="compra_assinatura_convite.php?id_p=<?php echo $id_p; ?>">
                                    <div id="license-box">
                                        <h1>Compra de Convites</h1>
                                        <div class="text">
                                    <textarea id="mymce2" disabled="true">
                                    
                                    
                                        <table width="100%">
                                                <tr>
                                                    <td width="50%"><img src="data:image/png;base64,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" alt="" width="250px" /></td>
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

                                        <p><strong><div align="center" style="text-decoration: underline;">CONTRATO DE COMPRA E VENDA DE CONVITES DE FORMATURA</div></strong></p>

                                        <p> Pelo presente documento e na melhor forma de direito, de um lado <strong style="text-decoration: underline">STUDIO M FOTOGRAFIA EIRELI ME</strong>, pessoa jurídica de direito privado, inscrita no CNPJ sob o n° 16.683.613/0001-00, com sede na Rua 93 nº 296  qd. F-14 lt. 36, Setor Sul, Goiânia-Goiás, ora denominada CONTRATADA.
                                        </p>
                                        <p>Noutro lado, denominada CONTRATANTE, <?= $vetor_cadastro['nome']?>, brasileiro, portador do RG n.º <?= $vetor_cadastro['rg']?>, inscrito no CPF n° <?=$cpf?>, residente e domiciliado à:   
                                        <br>
                                        Cidade: <?=$vetor_cadastro['cidade']?>   UF: <?=$vetor_cadastro['estado']?>   CEP: <?=$vetor_cadastro['cep']?>
                                        <br>
                                        Rua: <?=$vetor_cadastro['endereco']?> <?=$vetor_cadastro['complemento']?> <?=$vetor_cadastro['numero']?>
                                        <br>
                                        Setor: <?=$vetor_cadastro['bairro']?>
                                        <br>
                                        Telefone Resid.: <?=$vetor_cadastro['telefone']?>   Celular: <?=$vetor_cadastro['celular']?>
                                        <br>
                                        E-mail: <?=$vetor_cadastro['email']?>

                                        </p>
                                        <p>
                                            <strong>Cláusula 1 - DA REPRESENTAÇÃO</strong>
                                            <p>1.1 A CONTRANTE declara, neste ato, que é representada pela  COMISSÃO DE FORMATURA, constituída pelos formandos do curso de <?= $vetor_curso_inicio['nome']?>, da Instituição de Ensino <?=$vetor_instituicao_inicio['nome']?> com ano de conclusão em <?=$vetor_turma['ano']?>. Logo, lhe foi apresentada todas informações sobre as condições, especificações e valores  do contrato de prestação de serviços de confecção de convite de formatura. </p>
                                            <p>1.2 O CONTRATANTE reconhece que o layout e/ou projeto completo do convite, incluindo todas as modalidades de convites contratados, lhe foi previamente apresentado pela CONTRATADA, por conseguinte, devidamente aprovado por ele e pela comissão de formatura, que também lhe representa.</p>
                                            <p>1.3 Fixadas as considerações iniciais, as partes têm entre si, justas e contratadas, o seguinte que mutuamente aceitam e outorgam.</p>
                                        </p>
                                        <p>
                                        <strong>Cláusula 2 – DO OBJETO</strong>
                                        <p>2.1 O presente instrumento tem por finalidade a compra e venda de convites de formatura, dentro da quantidade, valores e condições a seguir:</p>
                                        </p>
                                        <table width="70%">
                                            <thead bgcolor="#e8e8e8">
                                                <tr>
                                                    <th style="text-align: center"><strong><h3>Produto</h3></strong></th>
                                                    <th style="text-align: center"><strong><h3>Quantidade</h3></strong></th>
                                                    <th style="text-align: center"><strong><h3>Sub-Total</h3></strong></th>
                                                </tr>
                                            </thead>
                                            <?php
                                            foreach ($produtos as $produto) {
                                                $sql_produto = mysqli_query($con, "select * from pacotes_itens where status = '1' and id_item = '{$produto[0]}'");
                                                $vetor_produto = mysqli_fetch_array($sql_produto);
                                                $sql_produto_nome = mysqli_query($con, "select * from tipos_produtos where id_tipo = '{$vetor_produto['id_tipo']}'");
                                                $vetor_produto_nome = mysqli_fetch_array($sql_produto_nome);
                                                $num = number_format(($produto[1] * $produto[2]), 2, ',', '.');
                                                $gerarpdf_contrato .= '<tr>
                                                  <td width="33%">' . $vetor_produto_nome['nome'] . '</td>
                                                  <td width="33%">' . $produto[2] . ' un.</td>
                                                  <td width="34%">R$' . $num . '</td>
                                              </tr>';
                                            }
                                            $num1 = number_format($valor_total, 2, ',', '.');
                                            $sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '{$formapag}'");
                                            $vetor_forma = mysqli_fetch_array($sql_forma);
                                            $parcelas_extenso = str_replace(array(" real"," reais"," centavo"," centavos"),'',strtolower(Monetary::numberToExt((isset($parcelamento) && $parcelamento != 0 ? $parcelamento : '1'))));
                                            ?>
                                            <tr>
                                            <td width="33%"></td>
                                            <td width="33%"></td>
                                            <td width="34%">Total: R$ <?=$num1?></td>
                                        </tr>
                                        </table>
                                        <p>
                                            <strong>Cláusula 3 – DO VALOR e FORMA DE PAGAMENTO</strong>
                                            <p>3.1 Pela aquisição dos convites de formatura acima relacionados, a CONTRANTE pagará a CONTRATADA a importância liquida de R$ <?=$num1?> (<?=strtolower(Monetary::numberToExt($valor_total))?>).</p>
                                            <p>3.2 O Pagamento será realizado em <?=(isset($parcelamento) && $parcelamento != 0 ? $parcelamento : '1')?> (<?=$parcelas_extenso?>) parcela (s) de R$'. <?=number_format($valor_total/(isset($parcelamento) && $parcelamento != 0 ? (int)$parcelamento : 1),2,',','.')?> .' (<?=strtolower(Monetary::numberToExt($valor_total/(isset($parcelamento) && $parcelamento != 0 ? (int)$parcelamento : 1)))?>), através da seguinte opção: 
                                            <br>
                                            <?=$vetor_forma['nome']?>
                                            </p>
                                        </p>
                                        <p>
                                            3.3 O não pagamento de qualquer parcela na (s) data (s) ajustada (s), implicará em mora do CONTRATANTE, com incidência de multa de 2% (dois por cento), sobre as parcelas remanescente, acrescido de juros à taxa de 1% (um por cento) ao mês, e atualização monetária pelos índices dado pelo INPC - Índice Nacional Preço ao Consumidor. 
                                        </p>
                                        <p>
                                            <strong>Cláusula 4 - DA ENTREGA DOS CONVITES</strong>
                                            <p>4.1 A <strong>CONTRATADA</strong> deverá entregar os convites para o representante legal da Comissão de Formatura, na cidade da  instituição de ensino da <strong>CONTRANTE</strong>, no prazo previsto no <i>cronograma de execução de serviços</i>,qual seja, <?=date('d/m/Y',strtotime($vetor_produtos_turma['dataentrega']))?>. </p>
                                            <p>4.1.1 O prazo de entrega poderá sofrer alteração caso os prazos previstos no cronograma de execução de serviços não sejam respeitados pelo CONTRATANTE e pela comissão de formatura.</p>
                                                
                                            <p>4.2 O CONTRATANTE aprova a entrega dos seus convites de formatura para a Comissão de Formatura, que ficará responsável pela guarda e entrega dos convites à CONTRATANTE na cidade da Instituição de Ensino Superior.</p>
                                            <p>4.2.1 Entregue o convite de formatura para a comissão de formatura, essa ficará responsável por todos os danos e prejuízos que venha causar ao CONTRATANTE, seja pela não entrega do produto ou pela entrega do produto danificado.</p>
                                        </p>
                                        <p>
                                            <strong>Cláusula 5 – DAS MULTA E PENALIDADES</strong>
                                            <p>5.1 Em caso de rescisão contratual em até 30 dias, contados da assinatura do presente instrumento, fica ajustado a incidência de multa contratual equivalente a 50% (cinquenta por cento) da totalidade do preço ajustado neste instrumento, cuja penalidade servirá para custear as despesas operacionais/administrativas, bem como a criação e aprovação do projeto do convite de formatura.</p>
                                            <p>5.2 Em caso de rescisão contratual após os 30 dias da assinatura deste contrato, fica ajustado a incidência de multa contratual equivalente a 100% (cem por cento) da totalidade do preço ajustado neste instrumento, cuja penalidade servirá para custear além daquelas descritas no item anterior (5.1), aquelas provenientes da imprescindível aquisição antecipada dos insumos para produção do convite contratado, visto que  o objeto contratado trata-se de um projeto personalizado para o CONTRATANTE.</p>
                                            <p>5.3 É permitido a redução da quantidade estabelecida no objeto do contrato, desde que a CONTRATANTE solicite à CONTRATADA no prazo de 30 dias contados da assinatura do presente instrumento. Após esse período, não será mais permitida tal redução ou qualquer alteração que implique na quantidade de convites contratada.</p>
                                            <p>5.3.1 A redução não poderá implicar na desistência total dos convites Super Luxos, devendo resguardar a contratação de no mínimo uma unidade dessa modalidade de convite.</p>
                                            <p>5.4 Em atenção ao princípio da boa fé contratual, as multas ajustadas nos itens anteriores têm por finalidade cobrir as despesas descritas nos itens 5.1 e 5.2.</p>
                                        </p>
                                        <p>
                                            <strong>Cláusula 6 – DISPOSIÇÕES FINAIS</strong>
                                            <p>6.1 A obrigação ora reconhecida e assumida pelas partes, aplica-se o disposto no artigo 784, III do Código de Processo Civil, como líquida, certa e exigível, vez que possui força de Título Executivo Extrajudicial.</p>
                                            <p>6.2 O presente instrumento, obriga em todos os termos, relações e dizeres, além das partes contratantes, os seus herdeiros e sucessores.</p>
                                            <p>6.3 A eventual tolerância à infringência de qualquer das cláusulas deste instrumento ou o não exercício de qualquer direito nele previsto constituirá mera liberalidade, não implicando em novação ou transação de qualquer espécie.</p>
                                            <p>6.4 As partes elegem o foro da comarca da Instituição de Ensino do Contratante para dirimir quaisquer dúvidas oriundas do presente contrato, com renúncia de qualquer outro, por mais privilegiado que seja.</p>
                                            <p>6.5 Estando assim justos e contratados, firmam o presente instrumento em 02 (duas) vias de igual teor na presença de duas testemunhas.</p>
                                        </p>    
                                        <br>
                                            <p align="right" style="text-justify: none;text-align: right">Goiânia, <?=date('d')?> de <?=str_replace('?','ç',strtr(utf8_decode(strftime('%B')), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-"))?> de <?=date('Y')?>.</p>
                                        <br>
                                        
                                        <table width="100%" BORDER="1" style="border-collapse: collapse">
                                        <tr>
                                        
                                        
                                        <td  style="text-align: center; width: 50%;">

                                        <!--<img style="width: 50%;" src="../imgs/assinaturas/Assinatura_Lanucia_CONTRATADA.png" alt="">-->
                                        Lanúcia Evangelista da Costa Moraes
                                        <br>        
                                        Data Aceite: <?= $dataaceite ?> 
                                        <br>
                                        Hora Aceite: <?= $horaatual ?>
                                        <br>
                                        IP de Acesso: <?= gethostbyname('www.studiomfotografia.com.br')?>
                                        <p>_______________________________</p>
                                        CONTRATADA
                                        </td>
                                        
                                        
                                        <td style="text-align: center; width: 50%;">
                                        <p>
                                        <?= $vetor_cadastro['nome']; ?>
                                        <br> 
                                        <?= $formando['email']  ?>
                                        <br> 
                                        Data Aceite: <?= $dataaceite ?> 
                                        <br>
                                        Hora Aceite: <?= $horaatual ?>
                                        <br>
                                        IP de Acesso: <?= $ip ?>
                                        <p>_______________________________</p>
                                        CONTRATANTE
                                        </td>
                                       
                                        </tr>
                                            
                                        </table>
                                        
                                        <table width="100%" BORDER="1" style="border-collapse: collapse">
                                            <tr>
                                                <td style="text-align: center; width: 50%;">
                                                    <img style="width: 50%;" src="../imgs/assinaturas/Assinatura_Andressa_TESTEMUNHA1.png" alt="">
                                                    <p>_______________________________</p>
                                                    TESTEMUNHA 1                               
                                                </td>
                                                
                                                <td style="text-align: center; width: 50%;">
                                                    <img style="width: 50%;" src="../imgs/assinaturas/Assinatura_Carol_TESTEMUNHA2.png" alt="">
                                                    <p>_______________________________</p>
                                                    TESTEMUNHA 2
                                                </td>
                                            </tr>
                                        </table>
                                    </textarea>
                                    </div>

                                    <input id="license-check" type="checkbox" value="2" required="" onclick='return pergunta();'/>
                                    <label for="license-check">Concordo com os termos apresentados neste contrato.</label>

                                    <input id="btn-next" class="btn btn-success" type="submit" value="Avançar"/>
           
	                                <?php
                                    echo "<input type='hidden' name='formapag' value='".$formapag."'>";
                                    echo "<input type='hidden' name='vencimento' value='".$vencimento."'>";
                                    if($parcelamento != 0){
	                                    echo "<input type='hidden' name='parcelamento' value='".$parcelamento."'>";
                                    }
	                                foreach ($_POST['id_item'] as $key) {
		                                echo "<input type='hidden' name='id_item[]' value='".$key."'>";
	                                }
	                                foreach ($_POST['valor_item'] as $key) {
		                                echo "<input type='hidden' name='valor_item[]' value='".$key."'>";
	                                }
	                                foreach ($_POST['qtd'] as $key) {
		                                echo "<input type='hidden' name='qtd[]' value='".$key."'>";
	                                }
	                                ?>
                                </form>

                                <br>
                                <br>

                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal-->
                <div class="modal fade" id="modalTermo" tabindex="-1" role="dialog" aria-labelledby="modalTermo" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p><strong><h5>Concordo com os termos apresentados.</h5></strong></p>   
                            </div>                                                   
                            <div class="modal-body">
                                <p>O Studio M declara a utilização dos Dados Pessoais com base no interesse legítimo ou execução de contrato para fins internos. Asseguramos que o Studio M está empenhado na proteção dos seus dados, em observância à legislação de proteção de dados. </p>
                                <p>O Studio M poderá compartilhar os Dados Pessoais quando necessário em decorrência de obrigação legal, determinação de autoridade competente ou decisão judicial, sendo certo que notificará os Titulares sobre a solicitação. O compartilhamento com as autoridades e órgãos reguladores poderá ter como objetivo, ainda, o auxílio em investigações e medidas de prevenção e combate a ilícitos, o exercício regular de direitos do Studio M ou o cumprimento de obrigação legal ou regulatória. Em todas as previsões, há o comprometimento de revelação somente das informações e Dados Pessoais estritamente necessários, limitando-se ao mínimo exigido.</p>
                                <p>Não manteremos seus dados pessoais por mais tempo do que o necessário para as finalidades declaradas acima, nem utilizaremos seus dados para outros fins, exceto nas hipóteses autorizadas por Lei.</p>
                                <p>Para exercer seu direito como titular dos dados pessoais, você pode entrar em contato com o Encarregado de Dados, através do e-mail: <a href="mailto:cliente@studiomfotografia.com.br">cliente@studiomfotografia.com.br</a></p>                                                       
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" onclick='marcar(); ' data-dismiss="modal">Concordar
                                </button>
                                <button type="button" class="btn btn-secondary" onclick='desmarcar();' data-dismiss="modal">Discordar
                                </button>                                                 
                            </div>
                        </div>
                        </div>
                </div>

            </div>

            <footer class="footer text-center">
                Todos direitos reservados. <a href="https://studiomfotografia.com.br">Studio M Fotografia</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->

    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="../layout/dist/js/app.min.js"></script>
    <!-- minisidebar -->
    <script>
        $(function () {
            "use strict";
            $("#main-wrapper").AdminSettings({
                Theme: false, // this can be true or false ( true means dark and false means light ),
                Layout: 'vertical',
                LogoBg: 'skin5', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                NavbarBg: 'skin5', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarType: 'mini-sidebar', // You can change it full / mini-sidebar / iconbar / overlay
                SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarPosition: false, // it can be true / false ( true means Fixed and false means absolute )
                HeaderPosition: false, // it can be true / false ( true means Fixed and false means absolute )
                BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid )
            });
        });
    </script>
    
    <script>
        function pergunta(){ 
        // retorna true se confirmado, ou false se cancelado
        $('input[type="checkbox"]').on('change', function(e){
            if(e.target.checked){
                $('#modalTermo').modal();
                $('#license-check').prop('checked', false);
            }   
            
        });
            //var mensagem = new String("Concordo com os termos apresentados. \n\ \n\O Studio M declara a utilização dos Dados Pessoais com base no interesse legítimo ou execução de contrato para fins internos. Asseguramos que o Studio M está empenhado na proteção dos seus dados, em observância à legislação de proteção de dados. \n\ \n\O Studio M poderá compartilhar os Dados Pessoais quando necessário em decorrência de obrigação legal, determinação de autoridade competente ou decisão judicial, sendo certo que notificará os Titulares sobre a solicitação. O compartilhamento com as autoridades e órgãos reguladores poderá ter como objetivo, ainda, o auxílio em investigações e medidas de prevenção e combate a ilícitos, o exercício regular de direitos do Studio M ou o cumprimento de obrigação legal ou regulatória. Em todas as previsões, há o comprometimento de revelação somente das informações e Dados Pessoais estritamente necessários, limitando-se ao mínimo exigido. \n\ \n\Não manteremos seus dados pessoais por mais tempo do que o necessário para as finalidades declaradas acima, nem utilizaremos seus dados para outros fins, exceto nas hipóteses autorizadas por Lei. \n\ \n\Para exercer seu direito como titular dos dados pessoais, você pode entrar em contato com o Encarregado de Dados, através do e-mail: cliente@studiomfotografia.com.br");
            //return confirm(mensagem);
        }  
        
        function marcar(){
            $('#license-check').prop('checked', true); 
        }
        function desmarcar(){
            $('#license-check').prop('checked', false); 
        }
    </script>
    <script src="../layout/dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../layout/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../layout/assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../layout/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../layout/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../layout/dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    </body>

    </html>
<?php } ?> 