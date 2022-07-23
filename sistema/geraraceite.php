<?php



include"../includes/conexao.php";


require '../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$id = $_GET['id'];

$data = date('Y-m-d');
$hora = date('H:i:s');
$ip = $_SERVER['REMOTE_ADDR'];

$sql_atualiza = mysqli_query($con, "update vendas SET aceite = '2', dataaceite = '$data', horaaceite='$hora', ip='$ip', iniciada = '2' where id_venda = '$id'");

$sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
$vetor_venda = mysqli_fetch_array($sql_venda);

$sql = mysqli_query($con, "select * from formandos where id_formando = '$vetor_venda[id_formando]'");
$vetor = mysqli_fetch_array($sql);

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

$dataaceite = date('d/m/Y', strtotime($vetor_venda['dataaceite']));

$num1 = number_format($vetor_venda['valorvenda'],2,',','.');

$sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_venda[formapag]'");
$vetor_forma = mysqli_fetch_array($sql_forma);

$message = '<!DOCTYPE html>
  <html>
  <head>
      <title></title>
  </head>
  <body>
  <table width="100%">
      <tr>
          <td>
              <img src="https://studiomfotografia.com.br/sistema/imgs/LOGOS-LOGIN.png" width="200px">
          </td>
      </tr>
      <tr>
          <td><br><br></td>
      </tr>
      <tr>
          <td>
      Parabéns por sua aquisição '.$vetor['nome'].'.

      <br>
      Contrato: '.$vetor_turma['ncontrato'].' - '.$vetor_curso_inicio['nome'].' '.$vetor_turma['ano'].' '.$vetor_instituicao_inicio['nome'].'

      <br>
      <br>

      Sua compra Avulsa ficou no total de:

      <br>
      Total: R$'.$num1.'

      <br>
      <br>

      <strong>Sua forma de pagamento foi: '.$vetor_forma['nome'].' em '.$vetor_venda['qtdparcelas'].' parcela(s).</strong>

      <p>
      </p>
      <p>
      Declaro para todos os fins de direito que, efetuei a compra dos serviços gráficos de álbum de formatura e após ler o instrumento contratual que segue anexo a este e-mail, não tenho qualquer objeto quanto as cláusulas inseridas no referido contrato de prestação de serviços. 

      </p>
      <p>
      Assim sendo, na condição de contratante, ciente das minhas obrigações contratuais, firmo meu ACEITE no presente contrato de prestação de serviços gráficos de álbum de formatura.

      </p>
      <p>
      Aceite da compra feito por meio de confirmação via sistema recebido pelo link de confirmação:
      </p>
      <p>
      E-mail: '.$vetor['email'].'
      <br>
      Data Aceite: '.$dataaceite.'
      <br>
      Hora Aceite: '.$vetor_venda['horaaceite'].'
      <br>
      IP de Acesso: '.$vetor_venda['ip'].'
      </p>
      <p>
      </p>

  Atenciosamente;

  <p>
  </p>
  <p>
  </p>

  StudioM Fotografia
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
file_put_contents("arquivos/$nomeRelatorio.pdf", $output);

$sql_grava_arquivo = mysqli_query($con, "insert into arquivos (id_cliente, titulo, data, hora, tipo, arquivo) VALUES ('$vetor_venda[id_formando]', 'Confirmação de Compra Formando', '$data', '$hora', '1', '$nomegravabanco')");

$sql_interacoes = mysqli_query($con, "insert into interacao (id_cliente, data, hora, tipo, assunto, ocorrencia, departamento) VALUES ('$vetor_venda[id_formando]', '$data', '$hora', '12', '18', 'Compra álbum', '4')");

$id_cadastro = $con->insert_id;

$sql_tipo = mysqli_query($con, "select * from tipo_interacao where id_tipo = '12'");
$vetor_tipo = mysqli_fetch_array($sql_tipo);

$sql_calendario = mysqli_query($con, "insert into calendario (tipo, id, departamento, titulo, descricao, data) VALUES ('2', '$id_cadastro', '4', '$vetor_tipo[nome]', 'Compra álbum', '$data')");

echo "<script> window.location.href='gerarcontratopasta.php?id=$id'</script>";

?>