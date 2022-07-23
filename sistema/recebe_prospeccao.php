<?php

include "../includes/conexao.php";


$id_turma = (int)$_POST['id_turma'];

if (!isset($_GET['id'])) {
    $nome_contato = $_POST['nome_contato'];
    $email_contato = $_POST['email_contato'];
    $telefone_contato = $_POST['telefone_contato'];
    $meio_comunicacao = $_POST['meio_comunicacao'];//tipo contato
    $rede_social = $_POST['rede_social'];
    $link = $_POST['link'];
    $membro_comissao = (int)$_POST['membro_comissao'];
    if ($membro_comissao == 2) {
        $cargo = $_POST['cargo'];
    } else {
        $cargo = '';
    }
}


$tipo_comunicacao = $_POST['tipo_comunicacao'];
$indicacao = (int)$_POST['indicacao'];
if ($indicacao != 0) {
    if (isset($_POST['nome_indicacao']) and $_POST['nome_indicacao'] != null) {
        $nome_indicacao = $_POST['nome_indicacao'];
    } else {
        $nome_indicacao = $_POST['nome_indicacaocontrato'];
    }
} else {
    $nome_indicacao = '';
}
$empresa_cerimonial = (int)$_POST['empresa_cerimonial'];
$nome_cerimonial = $_POST['nome_cerimonial'];
$observacao = $_POST['observacao'];


//Fotografia
$viabilidade_fotografia = (int)$_POST['viabilidade_fotografia'];
if ($viabilidade_fotografia == 2) {
    $viabilidade_fotografia = "inviavel";
    $fotografia_motivo = $_POST['fotografia_motivo'];
    if ($fotografia_motivo == 1) {
        $fotografia_motivo = "Contrato Fechado com outra Empresa";
        $fotografia_empresa = $_POST['fotografia_empresa'];
    } else {
        $fotografia_motivo = "Fora do Perfil de atendimento";
        $fotografia_empresa = '';
    }
} elseif($viabilidade_fotografia == 1){
    $viabilidade_fotografia = "viavel";
    $fotografia_motivo = '';
    $fotografia_empresa = '';
}else{
    $viabilidade_fotografia = "";
    $fotografia_motivo = '';
    $fotografia_empresa = '';
}

//Convite
$viabilidade_convite = (int)$_POST['viabilidade_convite'];
if ($viabilidade_convite == 2) {
    $viabilidade_convite = "inviavel";
    $convite_motivo = $_POST['convite_motivo'];
    if ($convite_motivo == 1) {
        $convite_motivo = "Contrato Fechado com outra Empresa";
        $convite_empresa = $_POST['convite_empresa'];
    } else {
        $convite_motivo = "Fora do Perfil de atendimento";
        $convite_empresa = '';
    }
} elseif($viabilidade_convite == 1) {
    $viabilidade_convite = "viavel";
    $convite_motivo = '';
    $convite_empresa = '';
}else{
    $viabilidade_convite = "";
    $convite_motivo = '';
    $convite_empresa = '';
}

//Ensaio
$viabilidade_ensaio = (int)$_POST['viabilidade_ensaio'];
if ($viabilidade_ensaio == 2) {
    $viabilidade_ensaio = "inviavel";
    $ensaio_motivo = $_POST['ensaio_motivo'];
    if ($ensaio_motivo == 1) {
        $ensaio_motivo = "Contrato Fechado com outra Empresa";
        $ensaio_empresa = $_POST['ensaio_empresa'];
    } else {
        $ensaio_motivo = "Fora do Perfil de atendimento";
        $ensaio_empresa = '';
    }
} elseif($viabilidade_ensaio == 1) {
    $viabilidade_ensaio = "viavel";
    $ensaio_motivo = '';
    $ensaio_empresa = '';
}else{
    $viabilidade_ensaio = "";
    $ensaio_motivo = '';
    $ensaio_empresa = '';

}

//Placa
$viabilidade_placa = (int)$_POST['viabilidade_placa'];
if ($viabilidade_placa == 2) {
    $viabilidade_placa = "inviavel";
    $placa_motivo = $_POST['placa_motivo'];
    if ($placa_motivo == 1) {
        $placa_motivo = "Contrato Fechado com outra Empresa";
        $placa_empresa = $_POST['placa_empresa'];
    } else {
        $placa_motivo = "Fora do Perfil de atendimento";
        $placa_empresa = '';
    }
} elseif($viabilidade_placa == 1) {
    $viabilidade_placa = "viavel";
    $placa_motivo = '';
    $placa_empresa = '';
}else{
    $viabilidade_placa = "";
    $placa_motivo = '';
    $placa_empresa = '';

}

if (!isset($_GET['id'])) {
    $sql = mysqli_query($con, "insert into prospeccoes (id_turma,tipo_comunicacao, indicacao, nome_indicacao, empresa_cerimonial, nome_cerimonial, observacao,fotografia_viabilidade,fotografia_motivo,fotografia_empresa,convite_viabilidade,convite_motivo,convite_empresa,ensaio_viabilidade,ensaio_motivo,ensaio_empresa,placa_viabilidade,placa_motivo,placa_empresa) VALUES ('{$id_turma}', '{$tipo_comunicacao}','{$indicacao}', '{$nome_indicacao}', '{$empresa_cerimonial}', '{$nome_cerimonial}', '{$observacao}','{$viabilidade_fotografia}','{$fotografia_motivo}','{$fotografia_empresa}','{$viabilidade_convite}','{$convite_motivo}','{$convite_empresa}','{$viabilidade_ensaio}','{$ensaio_motivo}','{$ensaio_empresa}','{$viabilidade_placa}','{$placa_motivo}','{$placa_empresa}')");
    $id_prospeccao = $con->insert_id;
    if (isset($_GET['aux'])) {
        $aux = $_GET['aux'];
        mysqli_query($con, "UPDATE arquivos_mkt set id_prospeccao='{$id_prospeccao}' where id_prospeccao = '{$aux}'");
        mysqli_query($con, "UPDATE contatos_mkt set id_prospeccao='{$id_prospeccao}' where id_prospeccao = '{$aux}'");
        mysqli_query($con, "UPDATE interacao_mkt set id_prospeccao='{$id_prospeccao}' where id_prospeccao = '{$aux}'");
        mysqli_query($con, "DELETE FROM marketing where id_mkt = '{$aux}'");
    } else {
        $insert = mysqli_query($con, "insert into contatos_mkt (id_prospeccao,nome,email,telefone,meio_comunicacao,redesocial,link,cargo,comissao) values ('{$id_prospeccao}','{$nome_contato}', '{$email_contato}', '{$telefone_contato}', '{$meio_comunicacao}', '{$rede_social}', '{$link}', '{$cargo}','{$membro_comissao}')");
    }
    echo "<script language=\"JavaScript\">
	location.href=\"marketing_prospeccao.php\";
	</script>";
} else {
    $sql = mysqli_query($con, "insert into prospeccoes (id_turma,tipo_comunicacao, indicacao, nome_indicacao, empresa_cerimonial, nome_cerimonial, observacao,fotografia_viabilidade,fotografia_motivo,fotografia_empresa,convite_viabilidade,convite_motivo,convite_empresa,ensaio_viabilidade,ensaio_motivo,ensaio_empresa,placa_viabilidade,placa_motivo,placa_empresa) VALUES ('{$id_turma}', '{$tipo_comunicacao}','{$indicacao}', '{$nome_indicacao}', '{$empresa_cerimonial}', '{$nome_cerimonial}', '{$observacao}','{$viabilidade_fotografia}','{$fotografia_motivo}','{$fotografia_empresa}','{$viabilidade_convite}','{$convite_motivo}','{$convite_empresa}','{$viabilidade_ensaio}','{$ensaio_motivo}','{$ensaio_empresa}','{$viabilidade_placa}','{$placa_motivo}','{$placa_empresa}')");
    $id_prospeccao = $con->insert_id;
    $oportunidade = mysqli_fetch_array(mysqli_query($con, "select * from oportunidades where id_oportunidade = '{$_GET['id']}'"));
    mysqli_query($con, "UPDATE arquivos_mkt set id_prospeccao='$id_prospeccao' where id_prospeccao = '{$oportunidade['id_prospeccao']}'");
    mysqli_query($con, "UPDATE contatos_mkt set id_prospeccao='$id_prospeccao' where id_prospeccao = '{$oportunidade['id_prospeccao']}'");
    mysqli_query($con, "UPDATE interacao_mkt set id_prospeccao='$id_prospeccao' where id_prospeccao = '{$oportunidade['id_prospeccao']}'");
    mysqli_query($con, "DELETE FROM marketing where id_mkt = '{$oportunidade['id_prospeccao']}'");

    $turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas_mkt where id_turma = '{$id_turma}'"));
    mysqli_query($con, "insert into turmas_leads (id_prospeccao,id_curso,ano_conclusao,semestre,id_fotografia,id_convite,id_ensaio,id_placa,num_formandos,tipo_comunicacao) VALUES ('{$id_prospeccao}','{$turma['id_curso']}','{$turma['conclusao']}','{$turma['semestre']}','','','','','','')");
    $id_turma_lead = $con->insert_id;
    mysqli_query($con, "UPDATE contatos_oportunidade set id_oportunidade='{$id_turma_lead}' where id_oportunidade = '{$oportunidade['id_oportunidade']}'");
    mysqli_query($con, "DELETE FROM oportunidades where id_oportunidade = '{$_GET['id']}'");
    echo "<script language=\"JavaScript\">
	location.href=\"alterarprospeccao.php?id=". $id_prospeccao . "\";
	</script>";
}
?>