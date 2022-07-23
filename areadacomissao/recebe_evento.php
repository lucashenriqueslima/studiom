<?php

session_start();

include "../includes/conexao.php";

$vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));

$id_turma = $vetor_cadastro['turma'];
$solicitante = $_SESSION['id_formando'];
$id_evento_turma_lista = $_POST['id_categoria'];
$vetor_evento_turma_lista = mysqli_fetch_array(mysqli_query($con, "select * from eventos_turma_lista where id_evento_turma = $id_evento_turma_lista"));
$id_categoria = $vetor_evento_turma_lista['id_evento'];
$titulo = mb_convert_case( $_POST['titulo'], MB_CASE_TITLE);

//local do evento

$nomelocal = mb_convert_case( $_POST['nome'], MB_CASE_TITLE);
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];

$longitudeEvento = $_POST['longitudeEvento'];
$latitudeEvento = $_POST['latitudeEvento'];


$sql = mysqli_query($con, "insert into locais (nome, estado, cidade, cep, endereco, complemento, bairro, tipo, latitudeEvento, longitudeEvento) VALUES ('{$nomelocal}', '{$estado}', '{$cidade}', '{$cep}', '{$endereco}', '{$complemento}', '{$bairro}', '1', '{$latitudeEvento}', '{$longitudeEvento}')");

$id_local = $con->insert_id;
$data = $_POST['data'];
$horainicio = $_POST['horainicio'];
$horafim = $_POST['horafim'];
$qtdalunos = $_POST['qtdalunos'];
$qtdpessoas = $_POST['qtdpessoas'];
$responsavel = $_POST['responsavel'];
$observacoes = $_POST['observacoes'];

$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '{$id_turma}'");
$vetor_turma = mysqli_fetch_array($sql_turma);

$sql_categoria = mysqli_query($con, "select * from categoriaevento where id_categoria = '{$id_categoria}'");
$vetor_categoria = mysqli_fetch_array($sql_categoria);

if ($id_categoria == 2) {
    $nome = $vetor_turma['ncontrato'] . ' / ' . $cidade . ' - ' . $estado . ' / ' . $nomelocal . ' - ' . $vetor_categoria['nome'] .' ('.$titulo.')';
}else{
    $nome = $vetor_turma['ncontrato'] . ' / ' . $cidade . ' - ' . $estado . ' / ' . $nomelocal . ' - ' . $vetor_categoria['nome'];
}



$sql = mysqli_query($con, "insert into eventos_turma (nome, id_turma, id_eventos_turma_lista, solicitante, id_categoria, titulo, id_local, data, horainicio, horafim, qtdalunos, qtdpessoas, responsavel, observacoes,status) VALUES ('{$nome}', '{$id_turma}', '{$id_evento_turma_lista}', '{$solicitante}', '{$id_categoria}', '{$titulo}', '{$id_local}', '{$data}', '{$horainicio}', '{$horafim}', '{$qtdalunos}', '{$qtdpessoas}', '{$responsavel}', '{$observacoes}','0')");
$id_cadastro = $con->insert_id;
$sql = mysqli_query($con,"update eventosformando set id_evento_turma = $id_cadastro where id_evento_turma_lista = $id_evento_turma_lista");
if ($id_categoria == 2) {
    $sql_preevento = mysqli_query($con, "insert into preeventos_turma (id_turma, titulo) VALUES ('{$id_turma}', '{$titulo}')");
}
$sql_tarefa = mysqli_query($con, "insert into calendario (tipo, id, departamento, departamentosolicitante, titulo, descricao, data,datafim, hora, horafim, contrato) VALUES ('3', '{$id_cadastro}', '2', '18', '{$nome}', '{$observacoes}', '{$data}','{$data}', '{$horainicio}', '{$horafim}', '{$id_turma}')");

$sql_formandos = mysqli_query($con, "select * from formandos where turma = '{$id_turma}'");

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
/*
while ($vetor_formandos = mysqli_fetch_array($sql_formandos)) {
    $nomedapasta = $vetor_turma['ncontrato'] . ' ' . $vetor_formandos['id_cadastro'] . ' ' . $vetor_formandos['nome'] . ' ' . $titulo . $data;
    $pasta = strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomedapasta)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
    mkdir("/home/studioms/public_html/sistema/arquivos/formandos/$pasta", 0755);

    if ($id_categoria == 2) {
        $tipo = 1;
    } else {
        $tipo = 2;
    }
    $sql_grava = mysqli_query($con, "insert into eventosformando (id_formando, id_evento_turma, tipo, titulo, pasta) VALUES ('{$vetor_formandos['id_formando']}', '{$id_cadastro}', '{$tipo}', '{$titulo}', '{$pasta}')");
}
*/


$sql_consulta_qrconvite = mysqli_query($con, "select * from qr_convite where turma_fk = '{$id_turma}'");
$categorias_sql = mysqli_query($con, "select * from categoriaevento where id_categoria = '{$id_categoria}'");
//$vetor_qrconvite = mysqli_fetch_array($sql_consulta_qrconvite);
if (mysqli_num_rows($categorias_sql)>0) {
        
    while($row_categorias = mysqli_fetch_assoc($categorias_sql)){
        $result1= $row_categorias["nome"]; 
    } 
    
    $categorias = $result1 ;
    
}



if ($categorias == "Jantar Dos Pais") {
    
    if(mysqli_num_rows($sql_consulta_qrconvite) == 0) {

        $sql_grava_qrconvite = mysqli_query($con, "insert into qr_convite (longitudeJantar, latitudeJantar, turma_fk) VALUES ('$longitudeEvento','$latitudeEvento', '$id_turma')");
        
    } else {
        
        $sql_atualiza_qrconvite = mysqli_query($con, "update qr_convite SET longitudeJantar='$longitudeEvento', latitudeJantar='$latitudeEvento' where turma_fk = '$id_turma'");
        
    }
}
if ($categorias == "Culto Ecumênico") {
    
    if(mysqli_num_rows($sql_consulta_qrconvite) == 0) {

        $sql_grava_qrconvite = mysqli_query($con, "insert into qr_convite (longitudeCulto, latitudeCulto, turma_fk) VALUES ('$longitudeEvento','$latitudeEvento', '$id_turma')");
        
    } else {
        
        $sql_atualiza_qrconvite = mysqli_query($con, "update qr_convite SET longitudeCulto='$longitudeEvento', latitudeCulto='$latitudeEvento' where turma_fk = '$id_turma'");
        
    }
}
if ($categorias == "Colação de Grau Oficial") {
    
    if(mysqli_num_rows($sql_consulta_qrconvite) == 0) {

        $sql_grava_qrconvite = mysqli_query($con, "insert into qr_convite (longitudeColacaoOfc, latitudeColacaoOfc, turma_fk) VALUES ('$longitudeEvento','$latitudeEvento', '$id_turma')");
        
    } else {
        
        $sql_atualiza_qrconvite = mysqli_query($con, "update qr_convite SET longitudeColacaoOfc='$longitudeEvento', latitudeColacaoOfc='$latitudeEvento' where turma_fk = '$id_turma'");
        
    }
}
if ($categorias == "Colação de Grau Festiva") {
    
    if(mysqli_num_rows($sql_consulta_qrconvite) == 0) {

        $sql_grava_qrconvite = mysqli_query($con, "insert into qr_convite (longitudeColacao, latitudeColacao, turma_fk) VALUES ('$longitudeEvento','$latitudeEvento', '$id_turma')");
        
    } else {
        
        $sql_atualiza_qrconvite = mysqli_query($con, "update qr_convite SET longitudeColacao='$longitudeEvento', latitudeColacao='$latitudeEvento' where turma_fk = '$id_turma'");
        
    }
}
if ($categorias == "Baile De Gala") {
    
    if(mysqli_num_rows($sql_consulta_qrconvite) == 0) {

        $sql_grava_qrconvite = mysqli_query($con, "insert into qr_convite (longitudeBaile, latitudeBaile, turma_fk) VALUES ('$longitudeEvento','$latitudeEvento', '$id_turma')");
        
    } else {
        
        $sql_atualiza_qrconvite = mysqli_query($con, "update qr_convite SET longitudeBaile='$longitudeEvento', latitudeBaile='$latitudeEvento' where turma_fk = '$id_turma'");
        
    }
}
echo"<script language=\"JavaScript\"> location.href=\"listareventos.php\"; </script>";

?>