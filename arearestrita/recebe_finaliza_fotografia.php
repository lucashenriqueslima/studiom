<?php

include "../includes/conexao.php";
require '../vendor/autoload.php';

use Dompdf\Dompdf;

session_start();
$dompdf = new Dompdf();
$id_item = $_GET['id'];

$formapag = $_POST['formapag'];
$qtdparcelas = $_POST['qtdparcelas'];
$formando = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));
$pacote_itens = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_itens_album where id_item = '{$id_item}'"));
$pacote = mysqli_fetch_array(mysqli_query($con, "select * from pacotes where id_pacote = '{$pacote_itens['id_pacote']}'"));
$turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '{$formando['turma']}'"));
$vetor_forma = mysqli_fetch_array(mysqli_query($con, "select * from formaspag_pacote where id_pacote = '{$pacote_itens['id_pacote']}' AND id_forma = '{$formapag}'"));
if($formapag == '22'){
   $diavencimento = date('d',strtotime('-5 days',strtotime($pacote_itens['data_limite'])));
}else {
    $diavencimento = $_POST['diavencimento'];
}
$valorfinal = 0;
if ($formando['comissao'] == 2) {
    $valorfinal = $pacote_itens['valorcomissao'];
}else {
    $valorfinal = $pacote_itens['valor'];
}
if ($formapag == '18') {
    $datadesconto = $pacote['dataabertura'];
    $dataatual = date('Y-m-d');
    $calcula_dias = strtotime($dataatual) - strtotime($datadesconto);
    $diferenca_dias = (int)floor($calcula_dias / (60 * 60 * 24));
    if ($diferenca_dias <= 30 && ($pacote_itens['pacote_especial'] == '2' || $pacote_itens['pacote_especial'] == '1')) {
        $valorfinal = $valorfinal - ($valorfinal * $pacote['desconto'] / 100);
    }
}
if (isset($_POST['qtdparcelas']) and $_POST['qtdparcelas'] > 0) {
    $qtdparcelas = $_POST['qtdparcelas'];
}else {
    $qtdparcelas = 1;
}
$dataatual = date('Y-m-d');
$horaatual = date('H:i:s');
$ip = $_SERVER['REMOTE_ADDR'];
if($pacote_itens['pacote_especial'] == '3'){
    $tipo = 4;
}else{
    $tipo = 2;
}
$sql_venda = mysqli_query($con, "select id_venda from vendas where id_formando = '{$formando['id_formando']}' and produto = '{$pacote_itens['id_pacote']}' and id_pacote = '{$pacote_itens['id_item']}' and `data` = '{$dataatual}' and qtdparcelas = '{$qtdparcelas}' and valorvenda = '{$valorfinal}' and diavencimento = '{$diavencimento}'");

if(mysqli_num_rows($sql_venda) == 0) {
    $sql_grava = mysqli_query($con, "insert into vendas (id_formando, produto, id_pacote, tipo, tipopagamento, data, valorvenda, status, aceite, iniciada, formapag,qtdparcelas,diavencimento,duplicata,dataaceite,horaaceite,ip)
    VALUES                                                  ('{$formando['id_formando']}', '{$pacote_itens['id_pacote']}', '{$pacote_itens['id_item']}', '{$tipo}', '{$pacote['tipopagamento']}', '{$dataatual}', '{$valorfinal}', '3', '2', '2','{$formapag}','{$qtdparcelas}','{$diavencimento}','1','{$dataatual}','{$horaatual}','{$ip}')") or die (mysqli_error($con));
    $id_venda = $con->insert_id;
    $sql_duplicata = mysqli_query($con, "insert into duplicatas (id_formando, data, id_venda, valor, status) VALUES ('{$formando['id_formando']}', '{$dataatual}', '{$id_venda}', '{$valorfinal}', '1')");
    $valorparcela = $valorfinal / $qtdparcelas;
    $id_duplicata = $con->insert_id;
    $aux = date('Y-m') . '-01';
    for ($i = 1; $i <= $qtdparcelas; $i++) {
        if ($formapag == '18') {
            $datagerada = date('Y-m-d', strtotime('+4 days'));
        } else {
            if ($formapag == '22') {
                $datagerada = date('Y-m-d', strtotime('-5 days', strtotime($pacote_itens['data_limite'])));
            } else {
                if ($formapag != '8') {
                    $data = date('Y-m', strtotime('+' . $i . ' months', strtotime($aux)));
                } else {
                    $data = date('Y-m', strtotime('+' . $i . ' months', strtotime(substr($pacote['dataentrega'], 0, 7))));
                }
                if ($diavencimento == 30 && substr($data, 5, 2) == '02') {
                    $datagerada = $data . "-28";
                } else {
                    $datagerada = $data . "-" . $diavencimento;
                }
            }
        }
        $sql_itens = mysqli_query($con, "insert into duplicatas_faturas (id_duplicata, posicao, data, valor, status, formapag) VALUES ('{$id_duplicata}', '{$i}', '{$datagerada}', '{$valorparcela}', '1', '{$formapag}')");
    }
    
    $nomedapasta = $turma['ncontrato'] . ' ' . $formando['id_cadastro'] . ' ' . $formando['nome'];
    
    if ($formando['topfotos'] == null) {
        $pasta = strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomedapasta)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
        $sql_update_formando = mysqli_query($con, "update formandos SET topfotos = '{$pasta}' where id_formando = '{$formando['id_formando']}'");
        //mkdir("/home/studioms/public_html/sistema/arquivos/topfotos/$pasta", 0755);
        mkdir("../sistema/arquivos/topfotos/$pasta", 0755);
    }
    //libera top fotos
    $sql_update_formando = mysqli_query($con, "update formandos SET album = 1 where id_formando = '{$formando['id_formando']}'");

    $num1 = number_format($valorfinal, 2, ',', '.');
    $sql_eventos_pacote = mysqli_query($con, "select * from eventos_pacote WHERE id_pacote = '{$pacote_itens['id_item']}' order by id_evento_pacote ASC");

    $pasta_turma = $turma['ncontrato'];
    ///$diretorio = $SERVER_ROOT . '/sistema/arquivos/formandos/' . $pasta_turma;
    $diretorio = '../sistema/arquivos/formandos/' . $pasta_turma;
    if (!file_exists($diretorio)) mkdir($diretorio);

    $pasta_formando = $pasta_turma . '-' . $formando['id_cadastro'] . '-' . strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($formando['nome'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
    //$diretorio = $SERVER_ROOT . '/sistema/arquivos/formandos/' . $pasta_turma . '/' . $pasta_formando;
    $diretorio = '../sistema/arquivos/formandos/' . $pasta_turma . '/' . $pasta_formando;
    if (!file_exists($diretorio)) mkdir($diretorio);
    
    while ($vetor_eventos_pacote = mysqli_fetch_array($sql_eventos_pacote)) {

    
        $sql_evento = mysqli_query($con, "select * from eventos_turma_lista where id_evento_turma = '{$vetor_eventos_pacote['id_evento']}'");
        $vetor_evento = mysqli_fetch_array($sql_evento);
        $sql_evento_marcado = mysqli_query($con, "select * from eventos_turma where id_turma = '{$formando['turma']}' and id_categoria = '{$vetor_evento['id_evento']}'");
        $vetor_evento_marcado = mysqli_fetch_array($sql_evento_marcado);
        $sql_evento_nome = mysqli_query($con, "select * from categoriaevento where id_categoria = '{$vetor_evento['id_evento']}'");
        $vetor_evento_nome = mysqli_fetch_array($sql_evento_nome);
        $sql_consulta_eventos = mysqli_query($con, "select * from eventosformando where titulo = '{$vetor_evento_nome['nome']}' and id_formando = '{$formando['id_formando']}' and id_evento_turma_lista = '{$vetor_evento['id_evento_turma']}'");
        if (mysqli_num_rows($sql_consulta_eventos) == 0) {
            $pasta_evento = strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($vetor_evento_nome['nome']." ".$vetor_evento['preevento'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));;
            //$diretorio = $SERVER_ROOT . '/sistema/arquivos/formandos/' . $pasta_turma . '/' . $pasta_formando . '/' . $pasta_evento;
            $diretorio = '../sistema/arquivos/formandos/' . $pasta_turma . '/' . $pasta_formando . '/' . $pasta_evento;
            if (!file_exists($diretorio)) mkdir($diretorio);
            
            $grava_pasta = $pasta_turma . '/' . $pasta_formando . '/' . $pasta_evento;
            if ($vetor_evento_nome['id_categoria'] != 2) {
                $sql_grava_pasta = mysqli_query($con, "insert into eventosformando (id_formando, id_evento_turma, id_evento_turma_lista, tipo, titulo, pasta) VALUES ('{$formando['id_formando']}', '{$vetor_evento_marcado['id_evento']}','{$vetor_evento['id_evento_turma']}', '2', '{$vetor_evento_nome['nome']} {$vetor_evento['preevento']}', '{$grava_pasta}')");
            }else {
                $vetor_verifica_preevento = mysqli_fetch_array(mysqli_query($con,"select * from eventosformando where id_evento_turma_lista = '{$vetor_evento['id_evento_turma']}' and tipo = '1' and id_formando = '{$formando['id_formando']}'"));
                
                $titulo = "{$vetor_evento_nome['nome']} {$vetor_evento['preevento']}";
                
                if ($vetor_verifica_preevento['titulo'] != $titulo) {
                    $sql_grava_pasta = mysqli_query($con, "insert into eventosformando (id_formando, id_evento_turma, id_evento_turma_lista, tipo, titulo, pasta) VALUES ('{$formando['id_formando']}', '{$vetor_evento_marcado['id_evento']}','{$vetor_evento['id_evento_turma']}', '1', '{$vetor_evento_nome['nome']} {$vetor_evento['preevento']}', '{$grava_pasta}')");
                }
            }
        }
        $sql_consulta_escolha = mysqli_query($con, "select * from turmas_escolha where id_turma = '{$turma['id_turma']}' and id_evento = '{$vetor_evento_marcado['id_evento']}'");
        if (mysqli_num_rows($sql_consulta_escolha) > 0) {
            $vetor_consulta_escolha = mysqli_fetch_array($sql_consulta_escolha);
            $vetor_consulta_escolha['id_evento'];
            $sql_compara_cadastro = mysqli_query($con, "select * from turmas_escolha_formandos where id_formando = '{$formando['id_formando']}' and id_evento = '{$vetor_consulta_escolha['id_evento']}' and id_tipo = '{$vetor_evento_marcado['id_categoria']}'");
            if (mysqli_num_rows($sql_compara_cadastro) == 0) {
                $sql_grava = mysqli_query($con, "insert into turmas_escolha_formandos (id_turma, id_turma_escolha, id_formando, id_evento, id_tipo, qtd) VALUES ('{$turma['id_turma']}', '{$vetor_consulta_escolha['id_turma_escolha']}', '{$formando['id_formando']}', '{$vetor_consulta_escolha['id_evento']}', '{$vetor_evento_marcado['id_categoria']}', '{$vetor_consulta_escolha['qtd']}')");
            }
        }
    }


   /* $sql_preeventos = mysqli_query($con, "select et.*,c.nome as cnome from eventos_turma et left join categoriaevento c on c.id_categoria = et.id_categoria where et.id_turma = '{$formando['turma']}' and et.id_categoria = '2'");
    while ($vetor_preeventos = mysqli_fetch_array($sql_preeventos)) {
        
        $sql_consulta_eventos = mysqli_query($con, "select * from eventosformando where titulo = '{$vetor_preeventos['nome']}' and id_formando = '{$formando['id_formando']}' ");
        if (mysqli_num_rows($sql_consulta_eventos) == 0) {
            
            $pasta_evento = strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($vetor_preeventos['cnome'])), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));;
            //$diretorio = $SERVER_ROOT . '/sistema/arquivos/formandos/' . $pasta_turma . '/' . $pasta_formando . '/' . 'pre-evento ' . $pasta_evento;
            $diretorio = '../sistema/arquivos/formandos/' . $pasta_turma . '/' . $pasta_formando . '/' . 'pre-evento ' . $pasta_evento;
            if (!file_exists($diretorio)) mkdir($diretorio);

            $grava_pasta = $pasta_turma . '/' . $pasta_formando . '/' . $pasta_evento;
            $sql_grava_pasta = mysqli_query($con, "insert into eventosformando (id_formando, id_evento_turma, tipo, titulo, pasta) VALUES ('{$formando['id_formando']}', '{$vetor_preeventos['id_evento']}', '1', '{$vetor_preeventos['nome']}', '{$grava_pasta}')");
        }
        $sql_consulta_escolha = mysqli_query($con, "select * from turmas_escolha where id_turma = '{$turma['id_turma']}' and id_evento = '{$vetor_preeventos['id_evento']}'");
        if (mysqli_num_rows($sql_consulta_escolha) > 0) {
            $vetor_consulta_escolha = mysqli_fetch_array($sql_consulta_escolha);
            $vetor_consulta_escolha['id_evento'];
            $sql_compara_cadastro = mysqli_query($con, "select * from turmas_escolha_formandos where id_formando = '{$formando['id_formando']}' and id_evento = '{$vetor_consulta_escolha['id_evento']}' and id_tipo = '{$vetor_preeventos['id_categoria']}'");
            if (mysqli_num_rows($sql_compara_cadastro) == 0) {
                $sql_grava = mysqli_query($con, "insert into turmas_escolha_formandos (id_turma, id_turma_escolha, id_formando, id_evento, id_tipo, qtd) VALUES ('{$turma['id_turma']}', '{$vetor_consulta_escolha['id_turma_escolha']}', '{$formando['id_formando']}', '{$vetor_consulta_escolha['id_evento']}', '{$vetor_preeventos['id_categoria']}', '{$vetor_consulta_escolha['qtd']}')");
            }
        }
    }
    */
    if ($pacote_itens['pacote_especial'] != '3') {
        $vetor_instituicao_inicio = mysqli_fetch_array(mysqli_query($con, "select * from instituicoes where id_instituicao = '{$turma['id_instituicao']}'"));
        $vetor_curso_inicio = mysqli_fetch_array(mysqli_query($con, "select * from cursos where id_curso = '{$turma['curso']}'"));
        $dataaceite = date('d/m/Y');
        $message = '<!DOCTYPE html>
        <html>
        <head>
            <title></title>
        </head>
        <body>
        <table width="100%">
            <tr>
                <td>
                    <img src="../imgs/logo1.png" width="200px">
                </td>
            </tr>
            <tr>
                <td><br><br></td>
            </tr>
            <tr>
                <td>
            Parabéns por sua aquisição ' . $formando['nome'] . '.

            <br>
            Contrato: ' . $turma['ncontrato'] . ' - ' . $vetor_curso_inicio['nome'] . ' ' . $turma['ano'] . ' ' . $vetor_instituicao_inicio['nome'] . '

            <br>
            <br>

            Sua compra do Álbum ficou no total de:

            <br>
            Total: R$' . $num1 . '

            <br>
            <br>

            <strong>Sua forma de pagamento foi: ' . $vetor_forma['nome'] . ' em ' . $qtdparcelas . ' parcela(s).</strong>

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
            E-mail: ' . $formando['email'] . '
            <br>
            Data Aceite: ' . $dataaceite . '
            <br>
            Hora Aceite: ' . $horaatual . '
            <br>
            IP de Acesso: ' . $ip . '
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
        $nomeRelatorio = time() . uniqid(md5());
        $nomegravabanco = $nomeRelatorio . '.pdf';
        $resultado = $diretorio . $nomeRelatorio;
        $dompdf->loadHtml($message);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("../sistema/arquivos/$nomeRelatorio.pdf", $output);
        $sql_grava_arquivo = mysqli_query($con, "insert into arquivos (id_cliente, titulo, data, hora, tipo, arquivo) VALUES ('{$formando['id_formando']}', 'Confirmação de Compra Formando', '{$dataatual}', '{$horaatual}', '1', '{$nomegravabanco}')");
        $sql_interacoes = mysqli_query($con, "insert into interacao (id_cliente, data, hora, tipo, assunto, ocorrencia, departamento) VALUES ('{$formando['id_formando']}', '{$dataatual}', '{$horaatual}', '12', '18', 'Compra álbum', '4')");
        $id_cadastro = $con->insert_id;
        $sql_tipo = mysqli_query($con, "select * from tipo_interacao where id_tipo = '12'");
        $vetor_tipo = mysqli_fetch_array($sql_tipo);
        $sql_calendario = mysqli_query($con, "insert into calendario (tipo, id, departamento, titulo, descricao, data) VALUES ('2', '{$id_cadastro}', '4', '{$vetor_tipo['nome']}', 'Compra álbum', '{$dataatual}')");
    }
    
    echo "<script> window.location.href='gerarcontratopasta.php?id={$id_venda}'</script>";
    
}else{
    $vetor_venda = mysqli_fetch_array($sql_venda);
    if($formapag == '3'){
        echo "<script> mensagem = 'Parabéns, {$formando['nome']}. Seu contrato foi validado com sucesso. Você é o mais novo cliente Studio M. Logo abaixo você pode conferir seu contrato assinado.  Ele está disponível aqui  na sua área do formando em Meus Docs, mas por segurança, também foi enviado para o seu e-mail. Caso não o encontre na caixa de entrada é bom que verifique na caixa de SPAM ou na Lixeira, pois às vezes seu provedor de e-mail poderá ter feito esse direcionamento de forma automática.  Ou se preferir, você também poderá imprimir seu contrato.'; window.alert(mensagem);  window.location.href='pagamento-cartao.php?id={$vetor_venda['id_venda']}'</script>";
    }else{
        echo "<script> mensagem = 'Parabéns, {$formando['nome']}. Seu contrato foi validado com sucesso.  Você é o mais novo cliente Studio M. Logo abaixo você pode conferir seu contrato assinado.  Ele está disponível aqui  na sua área do formando em Meus Docs, mas por segurança, também foi enviado para o seu e-mail. Caso não o encontre na caixa de entrada é bom que verifique na caixa de SPAM ou na Lixeira, pois às vezes seu provedor de e-mail poderá ter feito esse direcionamento de forma automática.  Ou se preferir, você também poderá imprimir seu contrato.'; window.alert(mensagem); window.location.href='mensagemfinalizacaoalbum.php?id={$vetor_venda['id_venda']}'</script>";
    }
}

?>