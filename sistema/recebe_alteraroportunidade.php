<?php

session_start();



include "../includes/conexao.php";

function moeda($get_valor)
{
    $source = array('.', ',');
    $replace = array('', '.');
    $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
    return $valor; //retorna o valor formatado para gravar no banco
}

$id = $_GET['id'];
$vetor = mysqli_fetch_array(mysqli_query($con, "select * from turmas_leads where id_turma_lead = '{$id}'"));
$sql_prospeccao = mysqli_query($con, "select * from prospeccoes where id_prospeccao = '{$vetor['id_prospeccao']}'");
$vetor_prospeccao = mysqli_fetch_array($sql_prospeccao);
$sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '{$vetor_prospeccao['id_turma']}'");
$vetor_turma = mysqli_fetch_array($sql_turma);
$sql_curso = mysqli_query($con, "select * from cursos where id_curso = '{$vetor_turma['id_curso']}'");
$vetor_curso = mysqli_fetch_array($sql_curso);
$sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '{$vetor_curso['id_instituicao']}'");
$vetor_instituicao = mysqli_fetch_array($sql_instituicao);
if (isset($_GET['dados_gerais'])) {
    $email_comissao = $_POST['email_comissao'];
    $num_comissao = $_POST['num_comissao'];
    $num_alunos = $_POST['num_alunos'];
    $empresa_cerimonial = $_POST['empresa_cerimonial'];
    $nome_cerimonial = $_POST['nome_cerimonial'];
    $observacao = $_POST['observacao'];
    $insert3 = mysqli_query($con, "update prospeccoes SET empresa_cerimonial='{$empresa_cerimonial}',nome_cerimonial='{$nome_cerimonial}',observacao='{$observacao}' where id_prospeccao='{$vetor['id_prospeccao']}'");
    $insert4 = mysqli_query($con, "update turmas_leads SET num_alunos='{$num_alunos}',num_comissao='{$num_comissao}',email_comissao='{$email_comissao}' where id_turma_lead='{$id}'");
} else {
    $num_formandos = $_POST['num_formandos'];
    if($_POST['vendedor'] != ''){
        $vendedor = $_POST['vendedor'];
    }else{
        $vendedor = "NULL";
    }
    $valor_venda = moeda($_POST['valor_venda']);
    $probabilidade_fechamento = substr($_POST['probabilidade_fechamento'],0,2);
    $statusCRM = $_POST['statusCRM'];
    $data_prevista = $_POST['data_prevista'];
    if (isset($_GET['dados_fotografia'])) {
        $lead = mysqli_fetch_array(mysqli_query($con, "select * from leads where id_lead = '{$vetor['id_fotografia']}'"));
        $calendario = mysqli_fetch_array(mysqli_query($con, "select * from calendario where id_calendario = '{$lead['id_calendario']}'"));
    } elseif (isset($_GET['dados_convite'])) {
        $lead = mysqli_fetch_array(mysqli_query($con, "select * from leads where id_lead = '{$vetor['id_convite']}'"));
        $calendario = mysqli_fetch_array(mysqli_query($con, "select * from calendario where id_calendario = '{$lead['id_calendario']}'"));
    } elseif (isset($_GET['dados_ensaio'])) {
        $lead = mysqli_fetch_array(mysqli_query($con, "select * from leads where id_lead = '{$vetor['id_ensaio']}'"));
        $calendario = mysqli_fetch_array(mysqli_query($con, "select * from calendario where id_calendario = '{$lead['id_calendario']}'"));
    } elseif (isset($_GET['dados_placa'])) {
        $lead = mysqli_fetch_array(mysqli_query($con, "select * from leads where id_lead = '{$vetor['id_placa']}'"));
        $calendario = mysqli_fetch_array(mysqli_query($con, "select * from calendario where id_calendario = '{$lead['id_calendario']}'"));
    }
    if($data_prevista != ''){
        if($calendario['data'] != $data_prevista){
            $dataatual = date('Y-m-d');
            $insert2 = mysqli_query($con, "insert into calendario (tipo, departamento, titulo, descricao, tarefa,datainclusao,data,hora,datafim,horafim) VALUES ('1', '1', 'Fechamento de Venda', 'Data prevista para fechamento da venda de ".strtoupper($lead['produto'])." do lead " . $vetor_curso['nome'] . "/" . $vetor_curso['sigla'] . "/" . $vetor_turma['conclusao'] . "-" . $vetor_turma['semestre'] . "', '1','{$dataatual}','{$data_prevista}','08:00:00','{$data_prevista}','18:00:00')");
            $id_calendario = $con->insert_id;
            $delete = mysqli_query($con, "delete from calendario where id_calendario='{$calendario['id_calendario']}'");
        }else{
            $id_calendario = $lead['id_calendario'];
        }
    }else{
        $id_calendario = $lead['id_calendario'];
    }
    if (isset($_GET['dados_fotografia'])) {
        $insert = mysqli_query($con, "update leads SET num_formandos='{$num_formandos}',id_responsavel=".$vendedor.",valor_venda='{$valor_venda}',probabilidade_fechamento='{$probabilidade_fechamento}',id_calendario='{$id_calendario}',id_status='{$statusCRM}' where id_lead='{$vetor['id_fotografia']}'") or die (mysqli_error($con));
    } elseif (isset($_GET['dados_convite'])) {
        $insert = mysqli_query($con, "update leads SET num_formandos='{$num_formandos}',id_responsavel=".$vendedor.",valor_venda='{$valor_venda}',probabilidade_fechamento='{$probabilidade_fechamento}',id_calendario='{$id_calendario}',id_status='{$statusCRM}' where id_lead='{$vetor['id_convite']}'") or die (mysqli_error($con));
    } elseif (isset($_GET['dados_ensaio'])) {
        $insert = mysqli_query($con, "update leads SET num_formandos='{$num_formandos}',id_responsavel=".$vendedor.",valor_venda='{$valor_venda}',probabilidade_fechamento='{$probabilidade_fechamento}',id_calendario='{$id_calendario}',id_status='{$statusCRM}' where id_lead='{$vetor['id_ensaio']}'") or die (mysqli_error($con));
    } elseif (isset($_GET['dados_placa'])) {
        $insert = mysqli_query($con, "update leads SET num_formandos='{$num_formandos}',id_responsavel=".$vendedor.",valor_venda='{$valor_venda}',probabilidade_fechamento='{$probabilidade_fechamento}',id_calendario='{$id_calendario}',id_status='{$statusCRM}' where id_lead='{$vetor['id_placa']}'") or die (mysqli_error($con));
    }
}
echo "<script language=\"JavaScript\">
location.href=\"alteraroportunidade.php?id=" . $id . "\";
</script>";


?>