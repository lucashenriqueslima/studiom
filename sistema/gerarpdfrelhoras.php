<?php



include"../includes/conexao.php";


require '../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$id_programador = $_GET['id_programador'];
$datainicio = $_GET['datainicio'];
$datafim = $_GET['datafim'];

if(!empty($id_programador)) { $where .= " AND id_responsavel = '".$id_programador."'"; }
if(!empty($datainicio) && !empty($datafim)) { $where .= " AND data_entregue BETWEEN '".$datainicio."' AND '".$datafim."'"; }

$sql_programador = mysqli_query($con, "select * from usuarios WHERE id_usuario = '$id_programador'");
$vetor_programador = mysqli_fetch_array($sql_programador);

$sql_atual = mysqli_query($con, "select * from suporte WHERE 1".$where." order by data_entregue ASC");

$message = '<!DOCTYPE html>
  <html>
  <head>
      <title></title>
  </head>
  <body>
  <div align="center"><strong>Relatório de Horas Trabalhadas</strong></div>
  
  <br>
  <br>

  <table width="100%" BORDER="1" style="border-collapse: collapse">
  <tr bgcolor="#e8e8e8">
    <td>Programador</td>
    <td>Data Pedido</td>
    <td>Data Entrega</td>
    <td>Serviço</td>
    <td>Tempo Estimado</td>
    <td>Tempo Realizado</td>
  </tr>';

  while ($vetor = mysqli_fetch_array($sql_atual)) {

  $sql_programador = mysqli_query($con, "select * from usuarios WHERE id_usuario = '$vetor[id_responsavel]'");
  $vetor_programador = mysqli_fetch_array($sql_programador);

  if($vetor['nomedesenvolvedor'] == '') { if($vetor['id_responsavel'] == 100) { $programador = 'Conte Tecnologia: '.$vetor_programador['nome']; } else { $programador = 'StudioM: '.$vetor_programador['nome']; } } else { if($vetor['id_responsavel'] == 100) { $programador = 'Conte Tecnologia: '.$vetor['nomedesenvolvedor']; } else { $programador = 'StudioM: '.$vetor['nomedesenvolvedor']; } }

  $datapedido = date('d/m/Y', strtotime($vetor['data_pedido']));
  $dataentregue = date('d/m/Y', strtotime($vetor['data_entregue']));

  $message .= '<tr>
    <td>'.$programador.'</td>
    <td>'.$datapedido.'</td>
    <td>'.$dataentregue.'</td>
    <td>'.$vetor[assunto].'</td>
    <td>'.$vetor[tempo_estimado].'</td>
    <td>'.$vetor[tempo_total].'</td>
  </tr>';

  $totalhorasexplode = explode(':', $vetor['tempo_total']);
  $horas += $totalhorasexplode[0];
  $minutos += $totalhorasexplode[1];

  }

  $horaspminutos = $horas * 60;

  $totalminutos = $horaspminutos + $minutos;

  function mintohora($minutos)
  {
  $hora = floor($minutos/60);
  $resto = $minutos%60;
  return $hora.':'.$resto;
  }

  $totalhoras = mintohora($totalminutos); 

  $totalhorasexp = explode(':', $totalhoras);

  if($totalhorasexp[0] == 0) {

    if($totalhorasexp[1] == 1) {

      $horasresultantes .= $totalhorasexp[1].' minuto.';

    } if($totalhorasexp[1] > 1) {

      $horasresultantes .= $totalhorasexp[1].' minutos.';

    }

  }

  if($totalhorasexp[0] == 1) {

    $horasresultantes .= $totalhorasexp[0];

    if($totalhorasexp[1] == 0) {

      $horasresultantes .= ' hora.';

    } if($totalhorasexp[1] == 1) {

      $horasresultantes .= ' hora '.$totalhorasexp[1].' minuto.';

    } if($totalhorasexp[1] > 1) {

      $horasresultantes .= ' hora '.$totalhorasexp[1].' minutos.';

    }

  }

  if($totalhorasexp[0] > 1) {

    $horasresultantes .= $totalhorasexp[0];

    if($totalhorasexp[1] == 0) {

      $horasresultantes .= ' horas.';

    } if($totalhorasexp[1] == 1) {

      $horasresultantes .= ' horas '.$totalhorasexp[1].' minuto.';

    } if($totalhorasexp[1] > 1) {

      $horasresultantes .= ' horas '.$totalhorasexp[1].' minutos.';

    }

  }

  $message .= '<tr bgcolor="#e8e8e8">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>'.$horasresultantes.'</td>
  </tr>
  </table>
  </body>
  </html>';

$dompdf->loadHtml($message);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream();
