<?php

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

function formatarCPF_CNPJ($campo, $formatado = true){
  //retira formato
  $codigoLimpo = preg_replace("[' '-./ t]",'',$campo);
  // pega o tamanho da string menos os digitos verificadores
  $tamanho = (strlen($codigoLimpo) -2);
  //verifica se o tamanho do cÃ³digo informado Ã© vÃ¡lido
  if ($tamanho != 9 && $tamanho != 12){
    return false; 
  }
 
  if ($formatado){ 
    // seleciona a mÃ¡scara para cpf ou cnpj
    $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##'; 
 
    $indice = -1;
    for ($i=0; $i < strlen($mascara); $i++) {
      if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
    }
    //retorna o campo formatado
    $retorno = $mascara;
 
  }else{
    //se nÃ£o quer formatado, retorna o campo limpo
    $retorno = $codigoLimpo;
  }
 
  return $retorno;
 
}

    include"../includes/conexao.php";

     
     session_start();

    if($_SESSION['id_formando'] == NULL || $_SESSION['id_formando'] == '') {
    
    echo"<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
    
    } else {
        
    $sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);

    $id = $_GET['id'];

  $sql_duplicatas = mysqli_query($con, "select * from duplicatas where id_venda = '$id'");
  $vetor_duplicata = mysqli_fetch_array($sql_duplicatas);

  $sql_itens = mysqli_query($con, "select * from duplicatas_faturas where id_duplicata = '$vetor_duplicata[id_duplicata]' and link IS NULL");

  if(mysqli_num_rows($sql_itens) == 0) {

  $sql_venda = mysqli_query($con, "update vendas SET pagamento = '1' where id_venda = '$id'");

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

<script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">  
$(document).ready(function(){  

        $("#palco1 > div").hide(); 
        $("#tipobusca").change(function(){  
                $("#palco1 > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
        $("#palco_cartao > div").hide();  
        $("#cartao").change(function(){  
                $("#palco_cartao > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        });
        $("#palco_boleto > div").hide();  
        $("#boleto").change(function(){  
                $("#palco_boleto > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        });   
});  


</script>
<script>
    
      function ativarInputDataContrato(){
        var lista = document.getElementById("tipobusca");
        var input = document.getElementById("qtdparcelas");
        if(lista.value == "2"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("diavencimento");
        if(lista.value == "2"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("anexo");
        if(lista.value == "4"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("qtdparcelas1");
        if(lista.value == "5"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("diavencimento1");
        if(lista.value == "5"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("qtdparcelas2");
        if(lista.value == "3"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("diavencimento2");
        if(lista.value == "3"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("qtdparcelas3");
        if(lista.value == "5"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
        var input = document.getElementById("diavencimento3");
        if(lista.value == "5"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }

        var lista = document.getElementById("tipobusca");
      }
      
      
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
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="inicio.php">
                        <b class="logo-icon">

                            <img src="../layout/assets/images/logo-2.png" alt="homepage" class="dark-logo" width="110px" />

                            <img src="../layout/assets/images/logo-icon.png" alt="homepage" class="light-logo" width="50px" />
                        </b>

                    </a>

                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>

                        
                    </ul>

                    <ul class="navbar-nav float-right">


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>" alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $vetor_cadastro['nome']; ?></h4>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="sair.php"><i class="fa fa-power-off m-r-5 m-l-5"></i> Sair</a>
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
        <?php include"includes/menu.php"; ?>
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
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                            <h4 class="card-title">Minhas Compras</h4>

                            Caro(a), <?php echo $vetor_cadastro['nome']; ?> sua compra foi finalizada com sucesso!!!

                            <br>
                            <br>

                            <strong>Deseja imprimir seu contrato?</strong>

                            <br>
                            <br>
                            <table width="100%">
                              <tr>
                                <td width="1%"><a href="imprimircontrato.php?id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn btn-success"  style="    float: left;">Sim</button></a></td>
                                <td width="1%"></td>
                                <td><a href="meuscontratos.php"><button type="button" class="btn btn-danger"  style="    float: left;">Não</button></a></td>
                              </tr>
                            </table>

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
    $(function() {
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