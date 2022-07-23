<?php

function getListaDiasFeriado($ano = null)
{

    if ($ano === null) {
        $ano = intval(date('Y'));
    }

    $pascoa = easter_date($ano); // retorna data da pascoa do ano especificado
    $diaPascoa = date('j', $pascoa);
    $mesPacoa = date('n', $pascoa);
    $anoPascoa = date('Y', $pascoa);

    $feriados = [
        // Feriados nacionais fixos
        mktime(0, 0, 0, 1, 1, $ano),   // Confraternização Universal
        mktime(0, 0, 0, 4, 21, $ano),  // Tiradentes
        mktime(0, 0, 0, 5, 1, $ano),   // Dia do Trabalhador
        mktime(0, 0, 0, 9, 7, $ano),   // Dia da Independência
        mktime(0, 0, 0, 10, 12, $ano), // N. S. Aparecida
        mktime(0, 0, 0, 11, 2, $ano),  // Todos os santos
        mktime(0, 0, 0, 11, 15, $ano), // Proclamação da republica
        mktime(0, 0, 0, 12, 25, $ano), // Natal
        mktime(0, 0, 0, 10, 22, $ano), // Avulso
        //
        // Feriados variaveis
        mktime(0, 0, 0, $mesPacoa, $diaPascoa - 48, $anoPascoa), // 2º feria Carnaval
        mktime(0, 0, 0, $mesPacoa, $diaPascoa - 47, $anoPascoa), // 3º feria Carnaval 
        mktime(0, 0, 0, $mesPacoa, $diaPascoa - 2, $anoPascoa),  // 6º feira Santa  
        mktime(0, 0, 0, $mesPacoa, $diaPascoa, $anoPascoa),      // Pascoa
        mktime(0, 0, 0, $mesPacoa, $diaPascoa + 60, $anoPascoa), // Corpus Christ
    ];

    sort($feriados);

    $listaDiasFeriado = [];
    foreach ($feriados as $feriado) {
        $data = date('Y-m-d', $feriado);
        $listaDiasFeriado[$data] = $data;
    }

    return $listaDiasFeriado;
}

function isFeriado($data)
{
    $listaFeriado = getListaDiasFeriado(date('Y', strtotime($data)));
    if (isset($listaFeriado[$data])) {
        return true;
    }

    return false;
}

function getDiasUteis($aPartirDe, $quantidadeDeDias = 30)
{
    $dateTime = new DateTime($aPartirDe);

    $listaDiasUteis = [];
    $contador = 0;
    while ($contador < $quantidadeDeDias) {
        $dateTime->modify('+1 weekday'); // adiciona um dia pulando finais de semana
        $data = $dateTime->format('Y-m-d');
        if (!isFeriado($data)) {
            $listaDiasUteis[] = $data;
            $contador++;
        }
    }

    return $listaDiasUteis;
}

include "../includes/conexao.php";

$id = $_GET['id'];
$status = $_POST['status'];
$data = date('Y-m-d');

$questinario_gera = getDiasUteis($data, 3);
$questinario = end($questinario_gera);

$questinariofinal_gera = getDiasUteis($data, 7);
$questinariofinal = end($questinariofinal_gera);

$sql = mysqli_query($con, "select * from orcamento_convite where id_orcamento = '$id'");
$vetor = mysqli_fetch_array($sql);

if ($vetor['tipo'] == 1) {

    $sql_oportunidade = mysqli_query($con, "select * from oportunidades where id_oportunidade = '$vetor[id_oportunidade]'");
    $vetor_oportunidade = mysqli_fetch_array($sql_oportunidade);

    $sql_prospeccao = mysqli_query($con, "select * from prospeccoes where id_prospeccao = '$vetor_oportunidade[id_prospeccao]'");
    $vetor_prospeccao = mysqli_fetch_array($sql_prospeccao);

    $sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '$vetor_prospeccao[id_turma]'");
    $vetor_turma = mysqli_fetch_array($sql_turma);

    $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[id_curso]'");
    $vetor_curso = mysqli_fetch_array($sql_curso);

    $sql_instituicao = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
    $vetor_instituicao = mysqli_fetch_array($sql_instituicao);

    $sql_consulta = mysqli_query($con, "SELECT * FROM turmas order by ncontrato DESC limit 0,1");
    $vetor_consulta = mysqli_fetch_array($sql_consulta);

    $ncontrato = $vetor_consulta['ncontrato'] + 1;
    $ano = $vetor_turma['conclusao'] . '-' . $vetor_turma['semestre'];

//CONSERTAR PROSPECCAO
    $sql_grava = mysqli_query($con, "insert into turmas (tipo, nome, ncontrato, curso, ano, qtdformandos, qtdcomissao, qtdalunos, id_instituicao, cep, endereco, numero, complemento, bairro, cidade, estado, emailcomissao, cerimonial, contrato) VALUES ('1', '$vetor_curso[nome]', '$ncontrato', '$vetor_curso[id_curso]', '$ano', '$vetor_oportunidade[qtdformandos]', '$vetor_oportunidade[qtdcomissao]', '$vetor_curso[vagas1]', '$vetor_instituicao[id_instituicao]', '$vetor_instituicao[cep]', '$vetor_instituicao[endereco]', '$vetor_instituicao[numero]', '$vetor_instituicao[complemento]', '$vetor_instituicao[bairro]', '$vetor_instituicao[cidade]', '$vetor_instituicao[estado]', '$vetor_oportunidade[email]', '$vetor_prospeccao[nome_cerimonial]', '1')");

    $id_gerado = $con->insert_id;

    $sql_contrato = mysqli_query($con, "insert into contratos_convite (id_orcamento, id_turma, data, status) VALUES ('$id', '$id_gerado', '$data', '1')");

    $sql_update = mysqli_query($con, "update orcamento_convite SET questionario = '$questinario', questionario1 = '$questionariofinal', status = '$status' where id_orcamento = '$id'");

    echo "<script language=\"JavaScript\">
location.href=\"gerarpcp_orcamento.php?id=$id&id_turma=$id_gerado\";
</script>";

} else {

    $sql_contrato = mysqli_query($con, "insert into contratos_convite (id_orcamento, id_turma, data, status) VALUES ('$id', '$vetor[id_oportunidade]', '$data', '1')");

    $sql_update = mysqli_query($con, "update orcamento_convite SET questionario = '$questinario', questionario1 = '$questionariofinal', status = '$status' where id_orcamento = '$id'");

    echo "<script language=\"JavaScript\">
location.href=\"gerarpcp_orcamento.php?id=$id&id_turma=$vetor[id_oportunidade]\";
</script>";

}

?>