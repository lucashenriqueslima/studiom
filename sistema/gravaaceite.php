<?php



include"../includes/conexao.php";


require '../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$id = $_GET['id'];

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

$sql_itens_venda = mysqli_query($con, "select * from itens_venda_individual where id_venda = '$id'");

$dataaceite = date('d/m/Y', strtotime($vetor_venda['dataaceite']));

$message = '<!DOCTYPE html>
  <html>
  <head>
      <title></title>
  </head>
  <body>
  <table width="100%">
      <tr>
          <td>
              <img src="imgs/LOGOS-LOGIN.png" width="200px">
          </td>
      </tr>
      <tr>
          <td><br><br></td>
      </tr>
      <tr>
          <td>
      Parabéns por sua aquisição '.$vetor[nome].'.

      <br>
      Contrato: '.$vetor_turma[ncontrato].' - '.$vetor_curso_inicio[nome].' '.$vetor[ano].' '.$vetor_instituicao_inicio[nome].'

      <br>
      <br>

      Este é o extrato de sua compra:

      <br>

      <table width="100%">
      <tr bgcolor="#e8e8e8">
          <td width="33%">Produto</td>
          <td width="33%">Quantidade</td>
          <td width="34%">Sub-Total</td>
      </tr>';

      while($vetor_itens = mysqli_fetch_array($sql_itens_venda)) {

      if($vetor_itens['tipo'] == 1) { 

      $sql_produto = mysqli_query($con, "select * from produtos_turma_item where id_item = '$vetor_itens[id_item]'");
      $vetor_produto = mysqli_fetch_array($sql_produto);

      }

      if($vetor_itens['tipo'] == 2) { 
        
      $sql_produto = mysqli_query($con, "select * from pacotes_itens where status = '1' and id_item = '$vetor_itens[id_item]'");
      $vetor_produto = mysqli_fetch_array($sql_produto);

      }

      $sql_produto_nome = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_produto[id_tipo]'");
      $vetor_produto_nome = mysqli_fetch_array($sql_produto_nome);

      $subtotal = $vetor_itens['valor'] * $vetor_itens['qtd'];

      $num = number_format($subtotal,2,',','.');

      $message .= '<tr>
          <td width="33%">'.$vetor_produto_nome[nome].'</td>
          <td width="33%">'.$vetor_itens[qtd].'</td>
          <td width="34%">R$'.$num.'</td>
      </tr>';
      $totalizador += $subtotal;
    }

    $num1 = number_format($totalizador,2,',','.');

    $sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_venda[formapag]'");
    $vetor_forma = mysqli_fetch_array($sql_forma);

  $message .= '

      <tr>
          <td width="33%"></td>
          <td width="33%"></td>
          <td width="34%">Total: R$'.$num1.'</td>
      </tr>
      </table>

      <br>
      <br>

      <strong>Sua forma de pagamento foi: '.$vetor_forma[nome].' em '.$vetor_venda[qtdparcelas].' parcela(s).</strong>

      <p>
      </p>
      <p>
      Declaro para todos os fins de direito que, efetuei a compra dos convites de formatura e após ler o instrumento contratual que segue anexo a este e-mail, não tenho qualquer objeto quanto as cláusulas inseridas no referido contrato de prestação de serviços. 

      </p>
      <p>
      Assim sendo, na condição de contratante, ciente das minhas obrigações contratuais, firmo meu ACEITE no presente contrato de prestação de serviços gráficos de convites de formatura.

      </p>
      <p>
      Aceite da compra feito por meio de confirmação via sistema recebido pelo link de confirmação:
      </p>
      <p>
      <p>
      E-mail: '.$vetor[email].'
      </p>
      <p>
      Data Aceite: '.$dataaceite.'
      <p/>
      <p>
      Hora Aceite: '.$vetor_venda[horaaceite].'
      <p/>
      <p>
      IP de Acesso: '.$vetor_venda[ip].'
      <p/>
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
$resultado = $diretorio.$nomeRelatorio;

$dompdf->loadHtml($message);

$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$output = $dompdf->output();
file_put_contents("arquivos/$nomeRelatorio.pdf", $output);

?>