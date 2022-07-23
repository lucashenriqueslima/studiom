<?php

include"../includes/conexao.php";


$id = $_GET['id'];

$sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$id'");
$vetor_venda = mysqli_fetch_array($sql_venda);

$num1 = number_format($vetor_venda['valorvenda'],2,',','.');

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
              <img src="https://studiomfotografia.impactasistemas.com.br/imgs/LOGOS-LOGIN.png" width="200px">
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

      Sua compra do Álbum ficou no total de:

      <br>
      Total: R$'.$num1.'

      <br>
      <br>

      <strong>Sua forma de pagamento foi: '.$vetor_forma[nome].' em '.$vetor_venda[qtdparcelas].' parcela(s).</strong>

      <p>
      </p>
      <p>
      Declaro para todos os fins de direito que, efetuei a compra dos convites de formatura e após ler o instrumento contratual que segue anexo a este e-mail, não tenho qualquer objeto quanto as cláusulas inseridas no referido contrato de prestação de serviços. 

      </p>
      <p>
      Assim sendo, na condição de contratante, ciente das minhas obrigações contratuais, firmo meu ACEITE no presente contrato de prestação de serviços gráficos de álbum de formatura.

      </p>
      <p>
      Aceite da compra feito por meio de confirmação via sistema recebido pelo link de confirmação:
      </p>
      <p>
      E-mail: '.$vetor[email].'
      <br>
      Data Aceite: '.$dataaceite.'
      <br>
      Hora Aceite: '.$vetor_venda[horaaceite].'
      <br>
      IP de Acesso: '.$vetor_venda[ip].'
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

  echo $message;

?>

<script type="text/javascript">
<!--
        print();
-->
</script>