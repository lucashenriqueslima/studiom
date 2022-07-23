<?php

include"../includes/conexao.php";


$id_turma = $_POST['id_turma'];
$solicitante = $_POST['solicitante'];
$id_eventos_turma = $_POST['categoriasevento'];
$sql_eventos = mysqli_query($con, "select * from eventos_turma_lista WHERE id_evento_turma = '$id_eventos_turma' ");
$vetor_eventos = mysqli_fetch_array($sql_eventos);
 $id_categoria = $vetor_eventos['id_evento'];
$titulo = ucwords(strtolower($_POST['titulo']));
//local do evento

$nomelocal = ucwords(strtolower($_POST['nome']));
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];

$sql_local = mysqli_query($con, "insert into locais (nome, estado, cidade, cep, endereco, complemento, bairro, tipo) VALUES ('$nomelocal', '$estado', '$cidade', '$cep', '$endereco', '$complemento', '$bairro', '1')");

$id_local = $con->insert_id;

$data = $_POST['data'];
$horainicio = $_POST['horainicio'];
$horafim = $_POST['horafim'];
$qtdalunos = $_POST['qtdalunos'];
$qtdpessoas = $_POST['qtdpessoas'];
$responsavel = $_POST['responsavel'];
$telefone = $_POST['telefone'];
$nomeresponsavel = $_POST['nomeresponsavel'];
$telefoneresponsavel = $_POST['telefoneresponsavel'];
$tarefa = $_POST['tarefa'];
$departamento = $_POST['departamento'];
$observacoes = $_POST['observacoes'];

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$id_turma'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);

$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);

$sql_categoria = mysqli_query($con, "select * from categoriaevento where id_categoria = '$id_categoria'");
$vetor_categoria = mysqli_fetch_array($sql_categoria);

$sql_local = mysqli_query($con, "select * from locais where id_local = '$id_local'");
$vetor_local = mysqli_fetch_array($sql_local);


if ($id_categoria == 2) {
    $nome = $vetor_turma['ncontrato'].' / '.$vetor_local['cidade'].' - '.$vetor_local['estado'].' / '. $_POST['nome'] . ' - ' . $vetor_categoria['nome'] .' ('.$titulo.')';
}else{
    $nome = $vetor_turma['ncontrato'].' / '.$vetor_local['cidade'].' - '.$vetor_local['estado'].' / '. $_POST['nome'] . ' - ' .$vetor_categoria['nome'];
}



$sql = mysqli_query($con, "insert into eventos_turma (nome, id_turma, id_eventos_turma_lista, solicitante, id_categoria, titulo, id_local, data, horainicio, horafim, qtdalunos, qtdpessoas, responsavel, telefone, nomeresponsavel, telefoneresponsavel, tarefa, departamento, observacoes,status) VALUES ('$nome', '$id_turma', '{$vetor_eventos['id_evento_turma']}', '$solicitante', '$id_categoria', '$titulo', '$id_local', '$data', '$horainicio', '$horafim', '$qtdalunos', '$qtdpessoas', '$responsavel', '$', '$nomeresponsavel', '$telefoneresponsavel', '$tarefa', '$departamento', '$observacoes', '0')");

$id_cadastro = $con->insert_id;
$sql = mysqli_query($con,"update eventosformando set id_evento_turma = $id_cadastro where id_evento_turma_lista = '{$vetor_eventos['id_evento_turma']}'");

//CURL para fazer a inserção no PCP
$url = 'https://studiomfotografia.com.br/sistema/recebe_job.php';
$data = array('id_turma' => $id_turma,'tipo_job'=> '99','id_trabalho' => $id_cadastro, 'tipo_calculo' => '42');

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

//CURL para fazer a inserção no PCP
$data = array('id_turma' => $id_turma,'tipo_job'=> '99','id_trabalho' => $id_cadastro, 'tipo_calculo' => '4');

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if($tarefa == '1') { 

$sql_tarefa = mysqli_query($con, "insert into calendario (tipo, id, departamento, departamentosolicitante, titulo, descricao, data, hora, horafim) VALUES ('3', '$id_cadastro', '2', '3', '$nome', '$observacoes', '$data', '$horainicio', '$horafim')");

$sql_tarefa = mysqli_query($con, "insert into calendario (tipo, id, departamento, departamentosolicitante, titulo, descricao, data, hora, horafim) VALUES ('3', '$id_cadastro', '3', '3', '$nome', '$observacoes', '$data', '$horainicio', '$horafim')");

$sql_tarefa = mysqli_query($con, "insert into calendario (tipo, id, departamento, departamentosolicitante, titulo, descricao, data, hora, horafim) VALUES ('3', '$id_cadastro', '8', '3', '$nome', '$observacoes', '$data', '$horainicio', '$horafim')");

}

if($tarefa == '2') { 

$sql_tarefa =mysqli_query($con, "insert into calendario (tipo, id, departamento, departamentosolicitante, titulo, descricao, data, hora, horafim) VALUES ('3', '$id_cadastro', '$departamento', '2', '$nome', '$observacoes', '$data', '$horainicio', '$horafim')");

}

/**$sql_formandos = mysqli_query($con, "select * from formandos where turma = '$id_turma'");

while($vetor_formandos = mysqli_fetch_array($sql_formandos)) {

//$nomedapasta = $vetor_turma['ncontrato'].' '.$vetor_formandos['id_cadastro'].' '.$vetor_formandos['nome'].' '.$titulo.$data;
$nomedapasta = $vetor_turma['ncontrato'].'/'.$vetor_turma['ncontrato'].'-'.$vetor_formandos['id_cadastro'].'-'.$vetor_formandos['nome'].'/'.$data;

echo $pasta = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomedapasta)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

//mkdir ("/home/studioms/public_html/sistema/arquivos/formandos/$pasta", 0755 );

$diretorio = "/arquivos/formandos/$pasta";

if (!file_exists($diretorio)) mkdir($diretorio);
//mkdir ("/arquivos/formandos/$pasta", 0755 );

if($id_categoria == 2) {

$tipo = 1;

} else {

$tipo = 2;

}

$sql_grava = mysqli_query($con, "insert into eventosformando (id_formando, id_evento_turma, tipo, titulo, pasta) VALUES ('$vetor_formandos[id_formando]', '$id_cadastro', '$tipo', '$titulo', '$pasta')");

}
*/
echo"<script language=\"JavaScript\">location.href=\"fotografia_eventos.php\";</script>";

?>