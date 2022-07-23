<?php

include "../includes/conexao.php";
require '../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$id_turma = $_POST['id_turma'];
$produto = $_POST['produto'];
$sql_consulta = mysqli_query($con, "select * from vendas a, turmas b, formandos c where a.id_formando = c.id_formando and b.id_turma = '$id_turma' and c.turma = '$id_turma' and a.produto = '$produto' and a.aceite = '1' and a.status = '3' and a.iniciada = '2' order by a.id_venda asc limit 0,1");
$vetor_consulta = mysqli_fetch_array($sql_consulta);
if (mysqli_num_rows($sql_consulta) == 0) {
	echo "<script language=\"JavaScript\">
  location.href=\"vendas_aceites.php\";
  </script>";
}else {
	$data = date('Y-m-d');
	$hora = date('H:i:s');
	$ip = $_SERVER['REMOTE_ADDR'];
	$sql_atualiza = mysqli_query($con, "update vendas SET aceite = '2', dataaceite = '$data', horaaceite='$hora', ip='$ip' where id_venda = '$vetor_consulta[id_venda]'");
	$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '$vetor_consulta[id_formando]'");
	$vetor_formando = mysqli_fetch_array($sql_formando);
	$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor_formando[turma]'");
	$vetor_turma = mysqli_fetch_array($sql_turma);
	$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
	$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
	$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
	$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
	$num = number_format($vetor_consulta['valorvenda'], 2, ',', '.');
	$sql_venda = mysqli_query($con, "select * from vendas where id_venda = '$vetor_consulta[id_venda]'");
	$vetor_venda = mysqli_fetch_array($sql_venda);
	$sql = mysqli_query($con, "select * from formandos where id_formando = '$vetor_venda[id_formando]'");
	$vetor = mysqli_fetch_array($sql);
	$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[turma]'");
	$vetor_turma = mysqli_fetch_array($sql_turma);
	$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
	$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
	$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
	$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
	$sql_itens_venda = mysqli_query($con, "select * from itens_venda_individual where id_venda = '$vetor_consulta[id_venda]'");
	$dataaceite = date('d/m/Y', strtotime($vetor_venda['dataaceite']));
	$gerarpdf = '<!DOCTYPE html>
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
	while ($vetor_itens = mysqli_fetch_array($sql_itens_venda)) {
		if ($vetor_itens['tipo'] == 1) {
			$sql_produto = mysqli_query($con, "select * from produtos_turma_item where id_item = '$vetor_itens[id_item]'");
			$vetor_produto = mysqli_fetch_array($sql_produto);
		}
		if ($vetor_itens['tipo'] == 2) {
			$sql_produto = mysqli_query($con, "select * from pacotes_itens where status = '1' and id_item = '$vetor_itens[id_item]'");
			$vetor_produto = mysqli_fetch_array($sql_produto);
		}
		$sql_produto_nome = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_produto[id_tipo]'");
		$vetor_produto_nome = mysqli_fetch_array($sql_produto_nome);
		$subtotal = $vetor_itens['valor'] * $vetor_itens['qtd'];
		$num = number_format($subtotal, 2, ',', '.');
		$gerarpdf .= '<tr>
          <td width="33%">'.$vetor_produto_nome[nome].'</td>
          <td width="33%">'.$vetor_itens[qtd].'</td>
          <td width="34%">R$'.$num.'</td>
      </tr>';
		$totalizador += $subtotal;
	}
	$num1 = number_format($totalizador, 2, ',', '.');
	$sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_venda[formapag]'");
	$vetor_forma = mysqli_fetch_array($sql_forma);
	$gerarpdf .= '

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
	$nomegravabanco = $nomeRelatorio.'.pdf';
	$resultado = $diretorio.$nomeRelatorio;
	$dompdf->loadHtml($gerarpdf);
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->render();
	$output = $dompdf->output();
	file_put_contents("arquivos/$nomeRelatorio.pdf", $output);
	$sql_grava_arquivo = mysqli_query($con, "insert into arquivos (id_cliente, titulo, data, hora, tipo, arquivo) VALUES ('$vetor_venda[id_formando]', 'Confirmação de Compra Formando', '$data', '$hora', '2', '$nomegravabanco')");
	$sql_interacoes = mysqli_query($con, "insert into interacao (id_cliente, data, hora, tipo, assunto, categoria, status, ocorrencia, departamento) VALUES ('$vetor_venda[id_formando]', '$data', '$hora', '12', '17', '$categoria', '$status', 'Compra Convite', '4')");
	$id_cadastro = $con->insert_id;
	$sql_tipo = mysqli_query($con, "select * from tipo_interacao where id_tipo = '12'");
	$vetor_tipo = mysqli_fetch_array($sql_tipo);
	$sql_calendario = mysqli_query($con, "insert into calendario (tipo, id, departamento, titulo, descricao, data) VALUES ('2', '$id_cadastro', '4', '$vetor_tipo[nome]', 'Compra Convite', '$data')");
	echo "<script language=\"JavaScript\">
  location.href=\"recebe_geraaceite1.php?id_turma=$id_turma&produto=$produo\";
  </script>";
}
?>