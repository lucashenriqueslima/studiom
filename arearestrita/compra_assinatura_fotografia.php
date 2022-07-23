<?php

class Monetary
{
    const MIN = 0.01;
    const MAX = 2147483647.99;
    const MOEDA = " real ";
    const MOEDAS = " reais ";
    const CENTAVO = " centavo ";
    const CENTAVOS = " centavos ";
    private static $unidades = array(
        "um",
        "dois",
        "três",
        "quatro",
        "cinco",
        "seis",
        "sete",
        "oito",
        "nove",
        "dez",
        "onze",
        "doze",
        "treze",
        "quatorze",
        "quinze",
        "dezesseis",
        "dezessete",
        "dezoito",
        "dezenove"
    );
    private static $dezenas = array(
        "dez",
        "vinte",
        "trinta",
        "quarenta",
        "cinqüenta",
        "sessenta",
        "setenta",
        "oitenta",
        "noventa"
    );
    private static $centenas = array(
        "cem",
        "duzentos",
        "trezentos",
        "quatrocentos",
        "quinhentos",
        "seiscentos",
        "setecentos",
        "oitocentos",
        "novecentos"
    );
    private static $milhares = array(
        array("text" => "mil", "start" => 1000, "end" => 999999, "div" => 1000),
        array("text" => "milhão", "start" => 1000000, "end" => 1999999, "div" => 1000000),
        array("text" => "milhões", "start" => 2000000, "end" => 999999999, "div" => 1000000),
        array("text" => "bilhão", "start" => 1000000000, "end" => 1999999999, "div" => 1000000000),
        array("text" => "bilhões", "start" => 2000000000, "end" => 2147483647, "div" => 1000000000)
    );

    static function numberToExt($number, $moeda = true)
    {
        if ($number >= self::MIN && $number <= self::MAX) {
            $value = self::conversionR((int)$number);
            if ($moeda) {
                if (floor($number) == 1) {
                    $value .= self::MOEDA;
                }else {
                    if (floor($number) > 1) {
                        $value .= self::MOEDAS;
                    }
                }
            }
            $decimals = self::extractDecimals($number);
            if ($decimals > 0.00) {
                $decimals = round($decimals * 100);
                $value .= " e ".self::conversionR($decimals);
                if ($moeda) {
                    if ($decimals == 1) {
                        $value .= self::CENTAVO;
                    }else {
                        if ($decimals > 1) {
                            $value .= self::CENTAVOS;
                        }
                    }
                }
            }
        }
        return trim($value);
    }

    static function conversionR($number)
    {
        if (in_array($number, range(1, 19))) {
            $value = self::$unidades[$number - 1];
        }else {
            if (in_array($number, range(20, 90, 10))) {
                $value = self::$dezenas[floor($number / 10) - 1]." ";
            }else {
                if (in_array($number, range(21, 99))) {
                    $value = self::$dezenas[floor($number / 10) - 1]." e ".self::conversionR($number % 10);
                }else {
                    if (in_array($number, range(100, 900, 100))) {
                        $value = self::$centenas[floor($number / 100) - 1]." ";
                    }else {
                        if (in_array($number, range(101, 199))) {
                            $value = ' cento e '.self::conversionR($number % 100);
                        }else {
                            if (in_array($number, range(201, 999))) {
                                $value = self::$centenas[floor($number / 100) - 1]." e ".self::conversionR($number % 100);
                            }else {
                                foreach (self::$milhares as $item) {
                                    if ($number >= $item['start'] && $number <= $item['end']) {
                                        $value = self::conversionR(floor($number / $item['div']))." ".$item['text']." ".self::conversionR($number % $item['div']);
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $value;
    }

    private static function extractDecimals($number)
    {
        return $number - floor($number);
    }
}

function Mask($mask, $str)
{
    $str = str_replace(" ", "", $str);
    for ($i = 0; $i < strlen($str); $i++) {
        $mask[strpos($mask, "#")] = $str[$i];
    }
    return $mask;
}

include "../includes/conexao.php";
session_start();
if ($_SESSION['id_formando'] == null || $_SESSION['id_formando'] == '') {
    echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
    $id_item = $_GET['id'];
    $formapag = $_POST['formapag'];
    $diavencimento = $_POST['diavencimento'];
    $qtdparcelas = $_POST['qtdparcelas'];
    if (isset($_POST['qtdparcelas']) and $_POST['qtdparcelas'] > 0) {
        $qtdparcelas = $_POST['qtdparcelas'];
    }else {
        $qtdparcelas = 1;
    }
    $id_venda = $_GET['id'];
    $formando = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));
    $dataaceite = date('d/m/Y');
   
    $horaatual = date('H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];

    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '$_SESSION[id_formando]'"));
    $vetor_turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '$vetor_cadastro[turma]'"));
    $vetor_curso = mysqli_fetch_array(mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'"));
    $vetor_instituicao = mysqli_fetch_array(mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'"));
    $dataatual = date('Y-m-d');
    $vetor_forma = mysqli_fetch_array(mysqli_query($con, "select * from formaspag where id_forma = '$formapag'"));
    $pacote_itens = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_itens_album where id_item = '$id_item'"));
    $pacote = mysqli_fetch_array(mysqli_query($con, "select * from pacotes where id_pacote = '$pacote_itens[id_pacote]'"));
    $valorfinal = 0;
    if ($vetor_cadastro['comissao'] == 2) {
        $valorfinal = $pacote_itens['valorcomissao'];
    }else {
        $valorfinal = $pacote_itens['valor'];
    }
    if ($formapag == '18') {
        $datadesconto = $pacote['dataabertura'];
        $dataatual = date('Y-m-d');
        $calcula_dias = strtotime($dataatual) - strtotime($datadesconto);
        $diferenca_dias = (int)floor($calcula_dias / (60 * 60 * 24));
        if ($diferenca_dias <= 30 && ($pacote_itens['pacote_especial'] == 2 || $pacote_itens['pacote_especial'] == 1)) {
            $valorfinal = $valorfinal - ($valorfinal * $pacote['desconto'] / 100);
        }
    }


function extenso($value, $uppercase = 0)
{
    if (strpos($value, ",") > 0) {
        $value = str_replace(".", "", $value);
        $value = str_replace(",", ".", $value);
    }
    $singular = ["centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"];
    $plural = ["centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões"];
 
    $c = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
    $d = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
    $d10 = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove"];
    $u = ["", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"];
 
    $z = 0;
 
    $value = number_format($value, 2, ".", ".");
    $integer = explode(".", $value);
    $cont = count($integer);
    for ($i = 0; $i < $cont; $i++)
        for ($ii = strlen($integer[$i]); $ii < 3; $ii++)
            $integer[$i] = "0" . $integer[$i];
 
    $fim = $cont - ($integer[$cont - 1] > 0 ? 1 : 2);
    $rt = '';
    for ($i = 0; $i < $cont; $i++) {
        $value = $integer[$i];
        $rc = (($value > 100) && ($value < 200)) ? "cento" : $c[$value[0]];
        $rd = ($value[1] < 2) ? "" : $d[$value[1]];
        $ru = ($value > 0) ? (($value[1] == 1) ? $d10[$value[2]] : $u[$value[2]]) : "";
 
        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                $ru) ? " e " : "") . $ru;
        $t = $cont - 1 - $i;
        $r .= $r ? " " . ($value > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($value == "000"
        )
            $z++;
        elseif ($z > 0)
            $z--;
        if (($t == 1) && ($z > 0) && ($integer[0] > 0))
            $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
        if ($r)
            $rt = $rt . ((($i > 0) && ($i <= $fim) &&
                    ($integer[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
    }
 
    if (!$uppercase) {
        return trim($rt ? $rt : "zero");
    } elseif ($uppercase == "2") {
        return trim(strtoupper($rt) ? strtoupper(strtoupper($rt)) : "Zero");
    } else {
        return trim(ucwords($rt) ? ucwords($rt) : "Zero");
    }
}

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
        <link rel="stylesheet" href="cropper.min.css">

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        <style>
            /* necessário para funcionar o cropperjs */
            img {
                display: block;
                max-width: 100%;
            }

            #divCorpo {
                display: flex;
                flex-direction: row;
                justify-content: center;
                position: absolute;
                z-index: 1000;
            }

            img {
                display: block;
                max-width: 100%;
            }

            .img-container,
            .img-preview {
                text-align: center;
                width: 100%;
            }

            .img-container {
                margin-bottom: 1rem;
                max-height: 497px;
                min-height: 200px;
            }

            @media (min-width: 768px) {
                .img-container {
                    min-height: 497px;
                }
            }

            .img-container > img {
                max-width: 100%;
            }
        </style>

    </head>

    <body onLoad="instrucao();">
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
                        <h4 class="page-title">Minhas Compras</h4>
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
                                <h4 class="page-title">Assinatura Digital</h4> <br>
                                    <div class="alert alert-warning" role="alert">
                                    <p><?php echo $vetor_cadastro['nome']; ?>, estamos quase lá!!!</p> <br>
                                    <p>Agora falta concluir sua assinatura digital. Para isso você precisará fazer o upload de um documento com foto.</p>
                                    </div>
                                    <div id="license-box">
                                    <h4 class="card-title">Editar Foto</h4>

                                    <div class="row">
                                        <div class="col-md-6 offset-md-3">
                                            <div class="img-container">

                                                <div id="divCorpo"></div>

                                                <img id="image" src="sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"
                                                    alt="">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="actions">
                                        <div class="col-md-8 offset-md-2 text-center docs-buttons">
                                            <br>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-md" data-method="setDragMode"
                                                        data-option="move" title="Move">
                                                    <span class="docs-tooltip" data-toggle="tooltip"
                                                        title="cropper.setDragMode(&quot;move&quot;)">
                                                    <span class="fa fa-arrows-alt"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary btn-md" data-method="setDragMode"
                                                        data-option="crop" title="Crop">
                                                    <span class="docs-tooltip" data-toggle="tooltip"
                                                        title="cropper.setDragMode(&quot;crop&quot;)">
                                                    <span class="fa fa-crop-alt"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-md" data-method="zoom"
                                                        data-option="0.1" title="Zoom In">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
                                                    <span class="fa fa-search-plus"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary btn-md" data-method="zoom"
                                                        data-option="-0.1" title="Zoom Out">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
                                                    <span class="fa fa-search-minus"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-md" data-method="rotate"
                                                        data-option="-45" title="Rotate Left">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
                                                    <span class="fa fa-undo-alt"></span>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-primary btn-md" data-method="rotate"
                                                        data-option="45" title="Rotate Right">
                                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
                                                    <span class="fa fa-redo-alt"></span>
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <label class="btn btn-primary btn-upload"
                                                    for="inputImage" title="Upload image file">
                                                    <input type="file" class="sr-only" id="inputImage" name="file"
                                                        accept="image/*">
                                                    <span class="docs-tooltip" data-toggle="tooltip">
                                                    <span class="fa fa-upload"></span> Selecionar Documento
                                                </span>
                                                </label>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success" data-method="getCroppedCanvas"
                                                        data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }">
                                                    <span class="docs-tooltip" data-toggle="tooltip">
                                                    <span class="fa fa-check"></span> Salvar Documento
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    </div>

                                    <form method="post" action="recebe_finaliza_fotografia.php?id=<?=$id_item?>">
                                        
                                        <input type="text"  id="id_item" value="<?= $id_item?>" hidden> 
                                        <input type="text" id="formapag" name="formapag"  value="<?php echo $formapag; ?>" hidden>
                                        <input type="text" id="diavencimento" name="diavencimento" value="<?php echo $diavencimento; ?>" hidden>
                                        <input type="text" id="qtdparcelas" name="qtdparcelas" value="<?php echo $qtdparcelas; ?>" hidden> 
                                        <input id="verifica" type="text" value="" hidden required> 
                                        <input type="text" id="tipo" value="1" hidden>  
                                        <button class="btn btn-success" type="submit" value="Submit" onclick="return verificar();" data-whatever="finaliza">Finalizar Assinatura</button>
                                    </form>
                                                                  
                                  
                                <br>
                                <br>
                                <br>
                                <br>

                            </div>
                            
                        </div>
                    </div>
                </div>


                
                <!--Modal-->
                <div class="modal fade" id="modalInfom" tabindex="-1" role="dialog" aria-labelledby="modalInform" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>  
                            </div>                                                   
                        
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"  data-dismiss="modal">Prosseguir</button>                                                 
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
    <script src="../layout/dist/js/app.min.js">
       
    </script>
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
    <script type="text/javascript">
        $(window).on("load", function(){
            /*setTimeout(function(){
                // página totalmente carregada (DOM, imagens etc.)
                alert("Aqui você pode enquadrar seu documento e depois salvar para que possamos incluí-lo em seu contrato.");
            },400);  */
            $('#modalInfom').on('show.bs.modal', function (event) {
                recipient = "Aqui você pode enquadrar seu documento e depois salvar para que possamos incluí-lo em seu contrato.";
                var modal = $(this);
                modal.find('.modal-title').text(recipient);
                modal.find('.modal-body input').val(recipient); 
            });
            $('#modalInfom').modal();

        });

        function verificar(){
            if (document.getElementById("verifica").value == "") {
                $('#modalInfom').on('show.bs.modal', function (event) {
                    recipient = "É necessário que selecione e salve um documento para finalizar sua assinatura.";
                    var modal = $(this);
                    modal.find('.modal-title').text(recipient);
                    modal.find('.modal-body input').val(recipient); 
                });
                $('#modalInfom').modal();
            }
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
    <script src="cropper.min.js"></script>
    <script src="cropperconfigdocumento.js">
    </script>
    </body>

    </html>
<?php } ?>