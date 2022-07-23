<?php

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

    $dataatual = date('Y-m-d');

   $sql_consulta = mysqli_query($con, "select * from vendas where id_venda = '$id' and status = '3'");

   if(mysqli_num_rows($sql_consulta) != 0) {

    echo "<script> alert('Compra já gravada, favor entrar em suas compras!')</script>";
    echo "<script> window.location.href='minhascompras.php'</script>";

    } else { 

   $id = $_GET['id'];

   $sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
   $vetor_venda = mysqli_fetch_array($sql_venda);

   $x = $_POST[ 'id_item' ];
   $i = 0;

   if($vetor_venda['status'] == 1) { 

    foreach($x as &$key){

    $id_item = $_POST['id_item'][$i];
    $qtd = $_POST['qtd'][$i];

  if($vetor_venda['tipo'] == '1') { 

    $sql_valor = mysqli_query($con, "select * from produtos_turma_item where id_item = '$id_item'");
    $vetor_valor = mysqli_fetch_array($sql_valor);

    $valorun = $vetor_valor['valorun'];

  }

  if($vetor_venda['tipo'] == '2') { 

  $sql_valor = mysqli_query($con, "select * from pacotes_itens where status = '1' and id_pacote = '$vetor_venda[id_pacote]'");
  $vetor_valor = mysqli_fetch_array($sql_valor);

  $valorun = $vetor_valor['valorun'];

  }

    $sql_ref = "insert into itens_venda_individual (id_venda, tipo, id_item, qtd, valor) VALUES ('$id', '$vetor_venda[tipo]', '$id_item', '$qtd', '$valorun')";
    $res_ref = mysqli_query($con, $sql_ref) or die (mysqli_error($con));

    $i++;

    }

    }

   $selec1 = mysqli_query($con, "SELECT SUM(valor*qtd) as total FROM itens_venda_individual where id_venda = '$id'");
   $totalizador = mysqli_fetch_array($selec1);

   $sql_atualiza = mysqli_query($con, "update vendas SET valorvenda = '$totalizador[total]', status='2', iniciada = '2' where id_venda = '$id'");

   $sql_turma = mysqli_query($con, "select * from produtos_turma where id_turma = '$vetor_cadastro[turma]' order by id_produto DESC");
   $vetor_turma = mysqli_fetch_array($sql_turma);

   $data_inicial    = date('Y-m-d');
   $data_final  = $vetor_turma['dataentrega'];
     
    // Cria uma função que retorna o timestamp de uma data no formato AAAA-MM-DD
    function geraTimestamp($data) {
      $partes = explode('-',$data);
      return mktime(0, 0, 0, $partes[1], $partes[2], $partes[0]);
    }
     
    // Usa a função criada e pega o timestamp das duas datas:
    $time_inicial = geraTimestamp($data_inicial);
    $time_final = geraTimestamp($data_final);
     
    // Calcula a diferença de segundos entre as duas datas:
    $diferenca = $time_final - $time_inicial; // 19522800 segundos
     
    // Calcula a diferença de dias
    $dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
     
    // Exibe uma mensagem de resultado:
    $dias;

    $meses = $dias / 30;

    $mesesfinal = floor($meses);

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
        $("#palco > div").hide();  
        $("#produto").change(function(){  
                $("#palco > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
        $("#palco1 > div").hide(); 
        $("#tipobusca").change(function(){  
                $("#palco1 > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
        $("input[name='rd-sexo']").click(function(){  
                $("#palco > div").hide();  
                $( '#'+$( this ).val() ).show('fast');    
        });  
});  


</script>

<script>
    
      function ativarInputDataContrato(){
        var lista = document.getElementById("tipobusca");
        
        var input = document.getElementById("anexo");
        if(lista.value == "4"){
          input.disabled = false;
          input.required = true;
        }else{
          input.disabled = true;
          input.required = false;
        }
      }
      
      
    </script>

    <script type="text/javascript">
              $(document).ready(function(){
                  $('#mesano').change(function(){
                      $('#parcelas').load('buscameses.php?mesano='+$('#mesano').val() );

                  });

              });

    </script>

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

                            <a href="compra_etapa1_altqtd.php?id=<?php echo $id; ?>"><button type="button" class="btn btn-success"  style="    float: left;">Alterar Quantidades de Convites</button></a>

            <br>
            <br>
            
            <form action="compra_finaliza.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

            <input type="hidden" name="cpf" value="<?php echo $cpf; ?>">

            <div class="row">
              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="exampleInput">Forma de Pagamento</label>
                  <select name="formapag" id="tipobusca" class="form-control" onchange="ativarInputDataContrato()" required="">
                    <option value="" selected="">Selecione...</option>
                    <?php

                    $sql_formas = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]'");

                    while($vetor_formas = mysqli_fetch_array($sql_formas)) { 

                    $sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_formas[id_forma]'");
                    $vetor_forma = mysqli_fetch_array($sql_forma);

                    ?>
                    <option value="<?php echo $vetor_forma['id_forma']; ?>"><?php echo $vetor_forma['nome']; ?></option>
                    <?php } ?>
                  </select>
                </fieldset>
              </div>
            </div>

          <div id="palco1">
            <div id="2">
              
              <?php

              if($vetor_turma['mesano'] == 1) { 

              $sql_forma_item = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]' and id_forma = '2'");
              $vetor_forma_item = mysqli_fetch_array($sql_forma_item);

              ?>

              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas" id = "qtdparcelas" class="form-control" disabled required="true">
                  <option value="" selected="">Selecione...</option>

                  <?php

                  if($mesesfinal <= $vetor_forma_item['qtdparcelas']) { 

                  for($f=1; $f<=$mesesfinal; $f++) { 

                  $totalparcela = $totalizador['total'] / $f;

                  if($totalparcela < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php } } 

                  } else { 
                  
                  for($f=1; $f<=$vetor_forma_item['qtdparcelas']; $f++) { 

                  $totalparcela = $totalizador['total'] / $f;

                  if($totalparcela < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f; ?>"><?php echo $f; ?>x R$<?php echo $num = number_format($totalparcela,2,',','.'); ?></option>

                  <?php } } } ?>

                </select>

              </div>
              </div>

          </div>

          <?php 

          } if($vetor_turma['mesano'] == 2) {  

          $sql_forma_item = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]' and id_forma = '2'");
          $vetor_forma_item = mysqli_fetch_array($sql_forma_item);

          ?>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Mês Início Pagamento</label>
                
                <select name="mesano" id="mesano" class="form-control">
                    <option value="" selected="selected">Selecione...</option>
                    <?php 

                    $startDate = strtotime($vetor_turma['dataencerramento']);
                    $endDate   = strtotime($vetor_turma['dataabertura']);

                    $currentDate = $endDate;

                    while ($currentDate <= $startDate) {

                    ?>
                    <option value="<?php echo date('Y-m',$currentDate); ?>_<?php echo $vetor_forma_item[id_item]; ?>_<?php echo $id; ?>"><?php $mes = date('m',$currentDate); $ano = date('Y',$currentDate); if($mes == 1) { echo "Janeiro de ".$ano; } if($mes == 2) { echo "Fevereiro de ".$ano; } if($mes == 3) { echo "Março de ".$ano; } if($mes == 4) { echo "Abril de ".$ano; } if($mes == 5) { echo "Maio de ".$ano; } if($mes == 6) { echo "Junho de ".$ano; } if($mes == 7) { echo "Julho de ".$ano; } if($mes == 8) { echo "Agosto de ".$ano; } if($mes == 9) { echo "Setembro de ".$ano; } if($mes == 10) { echo "Outubro de ".$ano; } if($mes == 11) { echo "Novembro de ".$ano; } if($mes == 12) { echo "Dezembro de ".$ano; } ?></option>
                    <?php $currentDate = strtotime( date('Y-m-d',$currentDate).' +1 month'); } ?>
                  </select>

              </div>
              </div>

          </div>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas" id="parcelas" class="form-control">
                <option value="">Escolha um Mês</option>
              </select>

              </div>
              </div>

          </div>

          <?php } ?>

          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Datas de Vencimento</label>
                
                <select name="diavencimento" id = "diavencimento" class="form-control">
                  <option value="" selected="">Selecione...</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                </select>

              </div>
              </div>

          </div>
          </div>

          <div id="3">

            <?php

              $sql_forma_item = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]' and id_forma = '3'");
              $vetor_forma_item = mysqli_fetch_array($sql_forma_item);

              ?>

            <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas2" id = "qtdparcelas2" class="form-control" disabled required="true">
                  <option value="" selected="">Selecione...</option>

                  <?php

                  if($mesesfinal <= $vetor_forma_item['qtdparcelas']) { 

                  for($f2=1; $f2<=$mesesfinal; $f2++) { 

                  $totalparcela2 = $totalizador['total'] / $f;

                  if($totalparcela2 < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f2; ?>"><?php echo $f2; ?>x R$<?php echo $num = number_format($totalparcela2,2,',','.'); ?></option>

                  <?php } } 

                  } else { 
                  
                  for($f2=1; $f2<=$vetor_forma_item['qtdparcelas']; $f2++) { 

                  $totalparcela2 = $totalizador['total'] / $f;

                  if($totalparcela2 < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f2; ?>"><?php echo $f2; ?>x R$<?php echo $num = number_format($totalparcela2,2,',','.'); ?></option>

                  <?php } } } ?>

                </select>

              </div>
              </div>

          </div>

          </div>

          <div id="4">

            <?php

              $sql_forma_item = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]' and id_forma = '4'");
              $vetor_forma_item = mysqli_fetch_array($sql_forma_item);

              ?>

            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-danger">
                 Para finalizar seu pedido favor efetuar a transferência e anexe o comprovante para finalizar seu termo de adesão individual.
                 <br>
                 Valor para transferência tem desconto de: <?php echo $vetor_turma['desconto']; ?>%.
                 <br>
                 <strong>Valor final para transferência: 
                 <?php 

                 $percentual = $vetor_turma['desconto'] / 100.0; 

                 $valorfinal = $totalizador['total'] - ($percentual * $totalizador['total']);

                 echo "R$".number_format($valorfinal,2,',','.');

                 ?>
                </strong>
                </div>
              </div>
              </div>
              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Comprovante de Transferência</label>

                <br>
                
                <input type="file" name="anexo" id="anexo" class="form-control" disabled required="true">

              </div>
              </div>

          </div>
          
          </div>

          <div id="5">

            <?php

              $sql_forma_item = mysqli_query($con, "select * from formaspag_produto where id_produto = '$vetor_venda[produto]' and id_forma = '5'");
              $vetor_forma_item = mysqli_fetch_array($sql_forma_item);

              ?>
              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Quantidade de Parcelas</label>
                
                <select name="qtdparcelas1" id = "qtdparcelas1" class="form-control" disabled required="true">
                  <option value="" selected="">Selecione...</option>

                  <?php

                  if($mesesfinal <= $vetor_forma_item['qtdparcelas']) { 

                  for($f1=1; $f1<=$mesesfinal; $f1++) { 

                  $totalparcela1 = $totalizador['total'] / $f1;

                  if($totalparcela1 < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f1; ?>"><?php echo $f1; ?>x R$<?php echo $num = number_format($totalparcela1,2,',','.'); ?></option>

                  <?php } } 

                  } else { 
                  
                  for($f1=1; $f1<=$vetor_forma_item['qtdparcelas']; $f1++) { 

                  $totalparcela1 = $totalizador['total'] / $f1;

                  if($totalparcela1 < '50') { 

                  } else { 

                  ?>

                  <option value="<?php echo $f1; ?>"><?php echo $f1; ?>x R$<?php echo $num = number_format($totalparcela1,2,',','.'); ?></option>

                  <?php } } } ?>

                </select>

              </div>
              </div>

          </div>
          <div class="row">
              <div class="col-md-12">
              <div class="form-group">
                <label>Datas de Vencimento</label>
                
                <select name="diavencimento1" id = "diavencimento1" class="form-control" disabled required="true">
                  <option value="" selected="">Selecione...</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                </select>

              </div>
              </div>

          </div>
          </div>

          </div>
                
            <button type="submit" class="btn btn-primary"  style="    float: left;">Avançar</button>
                
              </form>

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
<?php } } ?>