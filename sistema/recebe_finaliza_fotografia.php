<?php



include"../includes/conexao.php";


require '../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$id = $_GET['id'];

$data = date('Y-m-d');
$hora = date('H:i:s');
$ip = $_SERVER['REMOTE_ADDR'];

$sql_atualiza = mysqli_query($con, "update vendas SET pagamento = '1', aceite = '2', dataaceite = '{$data}', horaaceite='{$hora}', ip='{$ip}', iniciada = '2' where id_venda = '{$id}'");

$sql_venda = mysqli_query($con, "select * from vendas where id_venda = '{$id}'");
$vetor_venda = mysqli_fetch_array($sql_venda);

$sql_pacotes = mysqli_query($con, "select * from pacotes_itens_album where id_item = '{$vetor_venda['id_pacote']}' order by id_item ASC");
  $vetor_pacotes = mysqli_fetch_array($sql_pacotes);

  $sql_pacote_venda = mysqli_query($con, "select * from pacotes where id_pacote = '{$vetor_pacotes['id_pacote']}'");
  $vetor_pacote_venda = mysqli_fetch_array($sql_pacote_venda);

  $qtdparcelas = $vetor_venda['qtdparcelas'];

  if($vetor_venda['formapag'] == 4 || $vetor_venda['formapag'] == 12 || $vetor_venda['formapag'] == 13) { 

      $percentual = $vetor_pacote_venda['desconto'] / 100.0; 
      $valorfinal = $vetor_venda['valorvenda'] - ($percentual * $vetor_venda['valorvenda']); 

  } else { 

      $valorfinal = $vetor_venda['valorvenda'];

  }

$num1 = number_format($valorfinal,2,',','.');

$sql = mysqli_query($con, "select * from formandos where id_formando = '{$vetor_venda['id_formando']}'");
$vetor = mysqli_fetch_array($sql);

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '{$vetor['turma']}'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$nomedapasta = $vetor_turma['ncontrato'].' '.$vetor['id_cadastro'].' '.$vetor['nome'];

if($vetor['topfotos'] == NULL) {

$pasta = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomedapasta)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

$sql_update_formando = mysqli_query($con, "update formandos SET topfotos = '{$pasta}' where id_formando = '{$vetor_venda['id_formando']}'");

mkdir ("/home/studioms/public_html/sistema/arquivos/topfotos/$pasta", 0755 );

}

$sql_eventos_pacote = mysqli_query($con, "select * from eventos_pacote WHERE id_pacote = '{$vetor_venda['id_pacote']}' order by id_evento_pacote ASC");

while($vetor_eventos_pacote = mysqli_fetch_array($sql_eventos_pacote)) { 

$sql_evento = mysqli_query($con, "select * from eventos_turma_lista where id_evento_turma = '{$vetor_eventos_pacote['id_evento']}'");
$vetor_evento = mysqli_fetch_array($sql_evento);

$sql_evento_marcado = mysqli_query($con, "select * from eventos_turma where id_turma = '{$vetor['turma']}' and id_categoria = '{$vetor_evento['id_evento']}'");
$vetor_evento_marcado = mysqli_fetch_array($sql_evento_marcado);

$sql_evento_nome = mysqli_query($con, "select * from categoriaevento where id_categoria = '{$vetor_evento['id_evento']}'");
$vetor_evento_nome = mysqli_fetch_array($sql_evento_nome);

$sql_consulta_eventos = mysqli_query($con, "select * from eventosformando where titulo = '{$vetor_evento_nome['nome']}' and id_formando = '{$vetor_venda['id_formando']}'");

if(mysqli_num_rows($sql_consulta_eventos) == 0) {

$nomedapastaeventos = $vetor_turma['ncontrato'].' '.$vetor['id_cadastro'].' '.$vetor['nome'].' '.$vetor_evento_nome['nome'].$data;

$pastaeventos = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomedapastaeventos)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

mkdir ("/home/studioms/public_html/sistema/arquivos/formandos/$pastaeventos", 0755 );

$sql_grava_pasta = mysqli_query($con, "insert into eventosformando (id_formando, id_evento_turma, tipo, titulo, pasta) VALUES ('{$vetor_venda['id_formando']}', '{$vetor_evento_marcado['id_evento']}', '2', '{$vetor_evento_nome['nome']}', '{$pastaeventos}')");

$sql_consulta_escolha = mysqli_query($con, "select * from turmas_escolha where id_turma = '{$vetor['turma']}' and id_evento = '{$vetor_evento_marcado['id_evento']}'");

if(mysqli_num_rows($sql_consulta_escolha)) {

  $vetor_consulta_escolha = mysqli_fetch_array($sql_consulta_escolha);

  $sql_compara_cadastro = mysqli_query($con, "select * from turmas_escolha_formandos where id_formando = '{$vetor_venda['id_formando']}' and id_evento = '{$vetor_consulta_escolha['id_evento']}' and id_tipo = '{$vetor_evento_marcado['id_categoria']}'");

  if(mysqli_num_rows($sql_compara_cadastro) == 0) {

  $sql_grava = mysqli_query($con, "insert into turmas_escolha_formandos (id_turma, id_turma_escolha, id_formando, id_evento, id_tipo, qtd) VALUES ('{$id_turma}', '{$vetor_consulta_escolha['id_turma_escolha']}', '{$vetor_venda['id_formando']}', '{$vetor_consulta_escolha['id_evento']}', '{$vetor_evento_marcado['id_categoria']}', '{$vetor_consulta_escolha['qtd']}')");

  }

}

}

}

$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '{$vetor_turma['id_instituicao']}'");
$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '{$vetor_turma['curso']}'");
$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

$sql_itens_venda = mysqli_query($con, "select * from itens_venda_individual where id_venda = '{$id}'");

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
              <img src="https://studiomfotografia.com.br/sistema/imgs/LOGOS-LOGIN.png" width="200px">
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
      Declaro para todos os fins de direito que, efetuei a compra de serviços gráficos de álbum de formatura e após ler o instrumento contratual que segue anexo a este e-mail, não tenho qualquer objeto quanto as cláusulas inseridas no referido contrato de prestação de serviços. 

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

$diretorio = "../sistema/arquivos/"; 
$nomeRelatorio = time().uniqid(md5());
$nomegravabanco = $nomeRelatorio.'.pdf';
$resultado = $diretorio.$nomeRelatorio;

$dompdf->loadHtml($message);

$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$output = $dompdf->output();
file_put_contents("../sistema/arquivos/$nomeRelatorio.pdf", $output);

$sql_grava_arquivo = mysqli_query($con, "insert into arquivos (id_cliente, titulo, data, hora, tipo, arquivo) VALUES ('{$vetor_venda['id_formando']}', 'Confirmação de Compra Formando', '{$data}', '{$hora}', '1', '{$nomegravabanco}')");

$sql_interacoes = mysqli_query($con, "insert into interacao (id_cliente, data, hora, tipo, assunto, categoria, status, ocorrencia, departamento) VALUES ('{$vetor_venda['id_formando']}', '{$data}', '{$hora}', '12', '18', '{$categoria}', '{$status}', 'Compra álbum', '4')");

$id_cadastro = $con->insert_id;

$sql_tipo = mysqli_query($con, "select * from tipo_interacao where id_tipo = '12'");
$vetor_tipo = mysqli_fetch_array($sql_tipo);

$sql_calendario = mysqli_query($con, "insert into calendario (tipo, id, departamento, titulo, descricao, data) VALUES ('2', '{$id_cadastro}', '4', '{$vetor_tipo['nome']}', 'Compra álbum', '{$data}')");

echo "<script> window.location.href='gerarcontratopasta.php?id=$id'</script>";

?>