<?php
include "../includes/conexao.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$mail = new PHPMailer(true);
session_start();
$id = $_GET['id'];
$sql = mysqli_query($con, "select * from arquivos where id_cliente = '$id'");
$arquivo = mysqli_fetch_array($sql);
if($arquivo['arquivo'] == ''){
    $nomeRelatorio = time().uniqid(md5()).'.pdf';
}else{
    $nomeRelatorio = $arquivo['arquivo'];
}
$sql = mysqli_query($con, "select * from formandos where id_formando = '$id'");
$formando = mysqli_fetch_array($sql);

$sql = mysqli_query($con, "select * from turmas where id_turma = '$formando[turma]'");
$turma = mysqli_fetch_array($sql);

$sql = mysqli_query($con, "select * from instituicoes where id_instituicao = '$turma[id_instituicao]'");
$instituicao = mysqli_fetch_array($sql);

$sql = mysqli_query($con, "select * from cursos where id_curso = '$turma[curso]'");
$curso = mysqli_fetch_array($sql);

$sql = mysqli_query($con, "select * from vendas where dataaceite = '$arquivo[data]' and horaaceite = '$arquivo[hora]'");
if(mysqli_num_rows($sql) > 0){
    $venda = mysqli_fetch_array($sql);
}else{
    $dataatual = date('Y-m-d');
    $horaatual = date('H:i:s');
    mysqli_query($con, "insert into arquivos (id_cliente,titulo,data,hora,tipo,arquivo)VALUES('$id','Compra Convite Contrato','$dataatual','$horaatual','2','$nomeRelatorio')");
    mysqli_query($con, "UPDATE vendas SET dataaceite='$dataatual',horaaceite='$horaatual' WHERE id_formando = '$id' and aceite = '2' and iniciada = '2' and tipo = '1'");
    $venda = mysqli_fetch_array($sql = mysqli_query($con, "select * from vendas where aceite = '2' and iniciada = '2' and tipo = '1'"));
}

$sql_itens_venda = mysqli_query($con, "select * from itens_venda_individual where id_venda = '$venda[id_venda]'");

$gerarpdf = '<!DOCTYPE html>
  <html>
  <head>
      <title></title>
  </head>
  <body>
  <table width="100%">
      <tr>
          <td>
              <img src="../imgs/Studio M - Logo-01.png" width="200px">
          </td>
      </tr>
      <tr>
          <td><br><br></td>
      </tr>
      <tr>
          <td>
      Parabéns por sua aquisição ' . $formando['nome'] . '.

      <br>
      Contrato: ' . $turma['ncontrato'] . ' - ' . $curso['nome'] . ' ' . $turma['ano'] . ' ' . $instituicao['nome'] . '

      <br>
      <br>

      Este é seu termo de adesão e extrato de sua compra:

      <br>

      <table width="100%">
      <tr bgcolor="#e8e8e8">
          <td width="33%">Produto</td>
          <td width="33%">Quantidade</td>
          <td width="34%">Sub-Total</td>
      </tr>';
$totalizador=0;
while ($itens = mysqli_fetch_array($sql_itens_venda)) {
    if ($venda['id_pacote'] == null) {
        $sql_produto = mysqli_query($con, "select * from produtos_turma_item where id_item = '$itens[id_item]'");
        $vetor_produto = mysqli_fetch_array($sql_produto);
    }else {
        $sql_produto = mysqli_query($con, "select * from pacotes_itens where status = '1' and id_item = '$itens[id_item]'");
        $vetor_produto = mysqli_fetch_array($sql_produto);
    }

    $sql_produto_nome = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_produto[id_tipo]'");
    $vetor_produto_nome = mysqli_fetch_array($sql_produto_nome);
    $subtotal = $itens['valor'] * $itens['qtd'];
    $num = number_format($subtotal, 2, ',', '.');
    $gerarpdf .= '<tr>
          <td width="33%">' . $vetor_produto_nome['nome'] . '</td>
          <td width="33%">' . $itens['qtd'] . '</td>
          <td width="34%">R$' . $num . '</td>
      </tr>';
    $totalizador += $subtotal;

}

$num1 = number_format($totalizador, 2, ',', '.');
$sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$venda[formapag]'");
$vetor_forma = mysqli_fetch_array($sql_forma);
$gerarpdf .= '

      <tr>
          <td width="33%"></td>
          <td width="33%"></td>
          <td width="34%">Total: R$' . $num1 . '</td>
      </tr>
      </table>

      <br>
      <br>

      <strong>Sua forma de pagamento foi: ' . $vetor_forma['nome'] . ' em ' . $venda['qtdparcelas'] . ' parcela(s).</strong>

      <p>
      </p>
      <p>
      Declaro para todos os fins de direito que, efetuei a compra dos convites de formatura e após ler o instrumento contratual que segue anexo a este e-mail, não tenho qualquer objeto quanto as cláusulas inseridas no referido contrato de prestação de serviços. 

      </p>
      <p>
      Ficará a cargo da comissão de formatura supervisionar os serviços contratados pela empresa Studio M Fotografia para a confecção dos convites de formatura, bem como se responsabilizará pelo repasse de informações que constarão no convite, tais como nomes (alunos/professores/homenageados/demais), mensagens, textos, imagens, tema e revisão final (ortográfica/visual) do material a ser confeccionado e, também, da solicitação de agendamento dos dias das fotos de convite da turma. 
      </p><p>
O associado que, por qualquer motivo, cancelar o contrato não terá direito a ressarcimento. </p>
<p>Caso não haja nenhum pagamento, o associado haverá de pagar 50% do valor contratado em caso de desligamento. </p>
<p>
Declaro para os devidos fins estar ciente com todos os compromissos que a comissão de formatura venha assumir em meu nome para a realização e confecção dos convites gráficos de formatura de nossa turma e acatar as decisões e medidas por ela tomadas, e, por ser verdade, dato e assino o presente termo de adesão individual.
</p>

      <p>
      Assim sendo, na condição de contratante, ciente das minhas obrigações contratuais, firmo meu ACEITE no presente contrato de prestação de serviços gráficos de convites de formatura.

      </p>
      <p>
      Aceite da compra feito por meio de confirmação via sistema recebido pelo link de confirmação:
      </p>
      <p>
      <p>
      E-mail: ' . $formando['email'] . '
      </p>
      <p>
      Data Aceite: ' . date('d/m/Y', strtotime($venda['dataaceite'])) . '
      <p/>
      <p>
      Hora Aceite: ' . $venda['horaaceite'] . '
      <p/>
      <p>
      IP de Acesso: ' . $venda['ip'] . '
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

$dompdf->loadHtml($gerarpdf);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$output = $dompdf->output();
file_put_contents("../sistema/arquivos/$nomeRelatorio", $output);
header('Location:alterarformando.php?id=' . $id);
?>