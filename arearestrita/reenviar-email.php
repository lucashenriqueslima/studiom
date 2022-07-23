<?php



session_start();

include "../includes/conexao.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SESSION['id_formando'] == NULL || $_SESSION['id_formando'] == '') {

    echo "<script language=\"JavaScript\">
  location.href=\"index.php\";
  </script>";

} else {



    require '../vendor/autoload.php';

    $mail = new PHPMailer(true);

    $id = $_GET['id'];

    $sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
    $vetor_venda = mysqli_fetch_array($sql_venda);

    $sql = mysqli_query($con, "select * from formandos where id_formando = '$vetor_venda[id_formando]'");
    $vetor = mysqli_fetch_array($sql);

    $sql_itens_venda = mysqli_query($con, "select * from itens_venda_individual where id_venda = '$id'");

    $to = $vetor['email'];

    $subject = 'Compra de Convites';

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
      Parabéns por sua aquisição ' . $vetor[nome] . '.

      <br>

      Este é o extrato de sua compra:

      <br>

      <table width="100%">
      <tr bgcolor="#e8e8e8">
          <td width="33%">Produto</td>
          <td width="33%">Quantidade</td>
          <td width="34%">Sub-Total</td>
      </tr>';

    while ($vetor_itens = mysqli_fetch_array($sql_itens_venda)) {

        if ($vetor_venda['id_pacote'] == NULL) {

            $sql_produto = mysqli_query($con, "select * from produtos_turma_item where id_item = '$vetor_itens[id_item]'");
            $vetor_produto = mysqli_fetch_array($sql_produto);

        } else {

            $sql_produto = mysqli_query($con, "select * from pacotes_itens where status = '1' and id_item = '$vetor_itens[id_item]'");
            $vetor_produto = mysqli_fetch_array($sql_produto);

        }

        $sql_produto_nome = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_produto[id_tipo]'");
        $vetor_produto_nome = mysqli_fetch_array($sql_produto_nome);

        $subtotal = $vetor_itens['valor'] * $vetor_itens['qtd'];

        $num = number_format($subtotal, 2, ',', '.');

        $message .= '<tr>
          <td width="33%">' . $vetor_produto_nome[nome] . '</td>
          <td width="33%">' . $vetor_itens[qtd] . '</td>
          <td width="34%">R$' . $num . '</td>
      </tr>';
        $totalizador += $subtotal;
    }

    $num1 = number_format($totalizador, 2, ',', '.');

    $sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_venda[formapag]'");
    $vetor_forma = mysqli_fetch_array($sql_forma);

    $message .= '

      <tr>
          <td width="33%"></td>
          <td width="33%"></td>
          <td width="34%">Total: R$' . $num1 . '</td>
      </tr>
      </table>

      <br>
      <br>

      <strong>Sua forma de pagamento foi: ' . $vetor_forma[nome] . ' em ' . $vetor_venda[qtdparcelas] . ' parcela(s).</strong>

      <p>
      </p>
      <p>
      Declaro para todos os fins de direito que, efetuei a compra dos convites de formatura e após ler o instrumento contratual que segue anexo a este e-mail, não tenho qualquer objeto quanto as cláusulas inseridas no referido contrato de prestação de serviços. 

      </p>
      <p>
      Assim sendo, na condição de contratante, ciente das minhas obrigações contratuais, firmo meu ACEITE no presente contrato de prestação de serviços gráficos de convites de formatura.

      </p>
      <p>
      Clique no link abaixo para confirmar sua aceitação ao contrato:
      </p>
      <p>
      <a href="https://studiomfotografia.com.br/confirmacao-aceite.php?id=' . $id . '" target="_blank"><img src="https://studiomfotografia.com.br/sistema/imgs/clique.png"></a>
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

    if ($vetor_venda['tipo'] == 1) {

        $sql_documentos = mysqli_query($con, "select * from arquivos_contratos where id_cliente = '$vetor[turma]' and tipo = '2' and emailcompra = '2'");
        $vetor_documentos = mysqli_fetch_array($sql_documentos);

    }

    if ($vetor_venda['tipo'] == 2) {

        $sql_documentos = mysqli_query($con, "select * from arquivos_contratos where id_cliente = '$vetor[turma]' and tipo = '1' and emailcompra = '2'");
        $vetor_documentos = mysqli_fetch_array($sql_documentos);

    }

    $caminho = '../sistema/arquivos/' . $vetor_documentos['arquivo'];
    $nomearquivo = 'Contrato';

    $remetente = 'compras@studiomfotografia.com.br';
    try {
        //Server settings
//    $mail->SMTPDebug = 1;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'studiomfotografia.com.br';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'contato@studiomfotografia.com.br';                 // SMTP username
        $mail->Password = 'c&GM^NM20gLE';                           // SMTP password
        $mail->SMTPSecure = 'TLS';                            // SMTP password
        $mail->Port = 587;                                    // TCP port to connect to
        $mail->CharSet = "UTF-8";

        //Recipients
        $mail->setFrom($remetente, 'StudioM Fotografia');
        $mail->addAddress($to, $vetor['nome']);    // Add a recipient
        if ($vetor_venda['arquivo'] != NULL) {
            $mail->addAttachment($caminho, $nomearquivo);
        }

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->MsgHTML($message);

        $mail->send();
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

}

?>