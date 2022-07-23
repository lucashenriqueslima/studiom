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
if(isset($_GET['id_oportunidade'])){
    $id_oportunidade = $_GET['id_oportunidade'];
}
$num_formandos = ($_POST['num_formandos'] != ''?$_POST['num_formandos']:null);
$qual_produto = $_POST['qual_produto'];

//pegando a turma
$sql_turma = mysqli_query($con, "select * from prospeccoes where id_prospeccao = '{$id}'");
$vetor = mysqli_fetch_array($sql_turma);
mysqli_query($con, "update prospeccoes set ".$qual_produto."_viabilidade='gerado',".$qual_produto."_motivo='',".$qual_produto."_empresa='' where id_prospeccao = '{$id}'");
$sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '{$vetor['id_turma']}'");
$vetor_turma = mysqli_fetch_array($sql_turma);
$sql_curso = mysqli_query($con, "select * from cursos where id_curso = '{$vetor_turma['id_curso']}'");
$vetor_curso = mysqli_fetch_array($sql_curso);
$sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '{$vetor_curso['id_instituicao']}'");
$vetor_instituicao = mysqli_fetch_array($sql_instituicao);

$sql_turma_lead = mysqli_query($con, "SELECT * from turmas_leads where id_prospeccao = '{$id}'");
if(mysqli_num_rows($sql_turma_lead) == 0){
    switch ($qual_produto){
        case 'fotografia':
            $sql = mysqli_query($con, "insert into leads (id_responsavel,id_categoria_crm,id_status,produto,num_formandos) VALUES ('0','10','15','{$qual_produto}','{$num_formandos}')");
            $id_lead = $con->insert_id;
            mysqli_query($con, "insert into turmas_leads (id_prospeccao,id_curso,ano_conclusao,semestre,id_fotografia,id_convite,id_ensaio,id_placa,tipo_comunicacao,num_alunos) VALUES ('{$vetor['id_prospeccao']}','{$vetor_curso['id_curso']}','{$vetor_turma['conclusao']}','{$vetor_turma['semestre']}','{$id_lead}','','','','{$vetor['tipo_comunicacao']}','{$vetor['num_alunos']}')");
            $id_turma_lead = $con->insert_id;
            break;
        case 'convite':
            $sql = mysqli_query($con, "insert into leads (id_responsavel,id_categoria_crm,id_status,produto,num_formandos) VALUES ('0','3','24','{$qual_produto}','{$num_formandos}')");
            $id_lead = $con->insert_id;
            mysqli_query($con, "insert into turmas_leads (id_prospeccao,id_curso,ano_conclusao,semestre,id_fotografia,id_convite,id_ensaio,id_placa,tipo_comunicacao,num_alunos) VALUES ('{$vetor['id_prospeccao']}','{$vetor_curso['id_curso']}','{$vetor_turma['conclusao']}','{$vetor_turma['semestre']}','','{$id_lead}','','','{$vetor['tipo_comunicacao']}','{$vetor['num_alunos']}')");
            $id_turma_lead = $con->insert_id;
            break;
        case 'ensaio':
            $sql = mysqli_query($con, "insert into leads (id_responsavel,id_categoria_crm,id_status,produto,num_formandos) VALUES ('0','12','27','$qual_produto','$num_formandos')");
            $id_lead = $con->insert_id;
            mysqli_query($con, "insert into turmas_leads (id_prospeccao,id_curso,ano_conclusao,semestre,id_fotografia,id_convite,id_ensaio,id_placa,tipo_comunicacao,num_alunos) VALUES ('$vetor[id_prospeccao]','$vetor_curso[id_curso]','$vetor_turma[conclusao]','$vetor_turma[semestre]','','','$id_lead','','$vetor[tipo_comunicacao]','$vetor[num_alunos]')");
            $id_turma_lead = $con->insert_id;
            break;
        case 'placa':
            $sql = mysqli_query($con, "insert into leads (id_responsavel,id_categoria_crm,id_status,produto,num_formandos) VALUES ('0','13','33','$qual_produto','$num_formandos')");
            $id_lead = $con->insert_id;
            mysqli_query($con, "insert into turmas_leads (id_prospeccao,id_curso,ano_conclusao,semestre,id_fotografia,id_convite,id_ensaio,id_placa,tipo_comunicacao,num_alunos) VALUES ('$vetor[id_prospeccao]','$vetor_curso[id_curso]','$vetor_turma[conclusao]','$vetor_turma[semestre]','','','','$id_lead','$vetor[tipo_comunicacao]','$vetor[num_alunos]')");
            $id_turma_lead = $con->insert_id;
            break;
    }
    $sql = mysqli_query($con, "select * from contatos_mkt where id_prospeccao = '$id'");
    while($vetor_contatos = mysqli_fetch_array($sql)){
        mysqli_query($con, "insert into contatos_oportunidade (id_oportunidade,nome,telefone,email,redesocial,link,comissao,cargo,meio_comunicacao)VALUES('$id_turma_lead','$vetor_contatos[nome]','$vetor_contatos[telefone]','$vetor_contatos[email]','$vetor_contatos[redesocial]','$vetor_contatos[link]','$vetor_contatos[comissao]','$vetor_contatos[cargo]','$vetor_contatos[meio_comunicacao]')");
    }
}else{
    switch ($qual_produto){
        case 'fotografia':
            $sql = mysqli_query($con, "insert into leads (id_responsavel,id_categoria_crm,id_status,produto,num_formandos) VALUES ('0','10','15','$qual_produto','$num_formandos')");
            $id_lead = $con->insert_id;
            break;
        case 'convite':
            $sql = mysqli_query($con, "insert into leads (id_responsavel,id_categoria_crm,id_status,produto,num_formandos) VALUES ('0','3','5','$qual_produto','$num_formandos')");
            $id_lead = $con->insert_id;
            break;
        case 'ensaio':
            $sql = mysqli_query($con, "insert into leads (id_responsavel,id_categoria_crm,id_status,produto,num_formandos) VALUES ('0','12','21','$qual_produto','$num_formandos')");
            $id_lead = $con->insert_id;
            break;
        case 'placa':
            $sql = mysqli_query($con, "insert into leads (id_responsavel,id_categoria_crm,id_status,produto,num_formandos) VALUES ('0','13','22','$qual_produto','$num_formandos')");
            $id_lead = $con->insert_id;
            break;
    }
    $turma_lead = mysqli_fetch_array($sql_turma_lead);
    mysqli_query($con, "UPDATE turmas_leads SET id_" . $qual_produto . "= '$id_lead' WHERE id_turma_lead='$turma_lead[id_turma_lead]'");
}
if(isset($_GET['id_oportunidade'])){
    echo "<script language=\"JavaScript\">
location.href=\"alteraroportunidade.php?id=$id_oportunidade\";
</script>";
}else{
    echo "<script language=\"JavaScript\">
location.href=\"alterarprospeccao.php?id=$id\";
</script>";
}


?>