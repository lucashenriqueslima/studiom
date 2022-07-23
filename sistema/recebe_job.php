<?php
include "../includes/conexao.php";
session_start();
function numeroFeriados($data_inicial, $tempo_estimado, $con)
{
    $data_inicio_feriados = '2021' . substr($data_inicial, 4, 10);
    $data_final_feriados = '2021' . substr(date('Y-m-d', strtotime('+' . $tempo_estimado . ' weekdays', strtotime($data_inicial))), 4, 10);
    $sql_feriados = mysqli_query($con, "select * from feriados where status = 1 and `data` between '{$data_inicio_feriados}' and '{$data_final_feriados}'");
    while (mysqli_num_rows($sql_feriados) > 0) {
        $tempo_estimado += mysqli_num_rows($sql_feriados);
        $data_final_feriados = date('Y-m-d', strtotime('+1 weekday', strtotime($data_final_feriados)));
        $sql_feriados = mysqli_query($con, "select * from feriados where status = 1 and `data`  = '{$data_final_feriados}'");
    }
    return $tempo_estimado;
}

if (isset($_POST['prioridade'])) {
    $id_pcp = explode(',', $_POST['id_pcp']);
    $prioridade = explode(',', $_POST['prioridade']);
    $sql = '';
    $i = 0;
    foreach ($id_pcp as $pcp) {
        $sql .= "UPDATE pcp SET prioridade=" . $prioridade[$i] . " WHERE id_pcp=" . $id_pcp[$i] . ";";
        $i++;
    }
    $resposta = mysqli_multi_query($con, $sql);
    if (!$resposta) {
        echo '0';
    } else {
        echo '1';
    }
    die();
}
$id_usuario = $_SESSION['id'];
$usuarios_permitidos = array(1, 2, 67);
if (in_array($id_usuario, $usuarios_permitidos)) {
    $limita = 0;
} else {
    $limita = 1;
}
if (isset($_POST['usuario'])) {
    $id_depto_atual = $_POST['id'];
    $usuario = $_POST['usuario'];
    $data = date('Y-m-d H:i:s');
    $sql = mysqli_query($con, "update departamento_atual_pcp set id_responsavel='{$usuario}',data_direcionamento='{$data}' where id_depto_atual = '{$id_depto_atual}'");
    $nome = mysqli_fetch_array(mysqli_query($con, "SELECT u.* FROM usuarios u where u.id_usuario = '{$usuario}'"));
    echo '<button type="button" onclick="openModal(' . $id_depto_atual . ')" class="btn btn-info btn-block">' . $nome['nome'] . '</button>';
}
if (isset($_GET['ativar'])) {
    $id_depto_atual = $_GET['ativar'];
    $data = date('Y-m-d H:i:s');
    $sql = mysqli_query($con, "update departamento_atual_pcp set status='0',data_inicio='{$data}' where id_depto_atual = '{$id_depto_atual}'");
    $vetor_job = mysqli_fetch_array(mysqli_query($con, "SELECT dap.*,p.data_calculo as pdata_criado,p.id_job,t.ncontrato,j.titulo,u.nome as unome,p.prioridade from departamento_atual_pcp dap left join pcp p on p.id_pcp = dap.id_pcp left join jobs j on j.id_job = p.id_job left join turmas t on t.id_turma = p.id_turma left join usuarios u on u.id_usuario = dap.id_responsavel where dap.id_depto_atual = '{$id_depto_atual}'"));
    $sql_etapas = mysqli_query($con, "select * from jobs_etapas where id_job = '{$vetor_job['id_job']}' and status = '1' and etapa <= (SELECT etapa from jobs_etapas where id_job='{$vetor_job['id_job']}' and id_departamento = '{$vetor_job['id_departamento']}' and status = '1')");
    $tempo_estimado = 0;
    $tempo_trabalhado = 0;
    while ($vetor_etapas = mysqli_fetch_array($sql_etapas)) {
        $tempo_estimado += (int)$vetor_etapas['prazo_geral'];
        if ($vetor_etapas['id_departamento'] == $vetor_job['id_departamento']) {
            $tempo_trabalhado = $vetor_etapas['tempo_estimado'];
        }
    }
    $tempo_estimado = numeroFeriados(substr($vetor_job['pdata_criado'], 0, 10), $tempo_estimado, $con);
    $data_limite = date('d/m/Y', strtotime('+' . $tempo_estimado . ' weekdays', strtotime(substr($vetor_job['pdata_criado'], 0, 10))));
    if ($vetor_job['id_responsavel'] == null && $limita == 0) {
        $responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal(' . $vetor_job['id_depto_atual'] . ')"
                                                                                      class="btn btn-info btn-block">Enviar</button>';
    } elseif ($limita == 0) {
        $responsavel = '<div hidden>ZZ</div><button type="button" onclick="openModal(' . $vetor_job['id_depto_atual'] . ')"
                                                                                      class="btn btn-info btn-block">' . $vetor_job['unome'] . '</button>';
    } else {
        $responsavel = $vetor_job['unome'];
    }
    if ($vetor_job['data_inicio'] == null) {
        $botao = "<button type='button' onclick='iniciarPCP({$vetor_job['id_depto_atual']})' class='btn btn-success'><i class='fas fa-play'></i></button>";
    } else {
        $botao = "<button type='button' onclick='finalizarPCP({$vetor_job['id_depto_atual']})' class='btn btn-warning'>Finalizar</button>";
    }
    echo $vetor_job['prioridade'] . ";" . $vetor_job['ncontrato'] . ";" . $vetor_job['titulo'] . ";" . date('d/m/Y', strtotime($vetor_job['data_criado'])) . ";" . $data_limite . ";" . ($vetor_job['data_inicio'] != null ? date('d/m/Y', strtotime($vetor_job['data_inicio'])) : '') . ";" . $tempo_trabalhado . ";" . $responsavel . ";" . $botao . ";" . $vetor_job['id_depto_atual'];
}
if (isset($_GET['finalizar'])) {
    $id_depto_atual = $_GET['finalizar'];
    if (isset($_GET['qtd_fotos'])) {
        $qtd_fotos = $_GET['qtd_fotos'];
        $metrica = mysqli_fetch_array(mysqli_query($con, "select * from pcp_metricas where chave_metrica = '4'"));
        $pcp = mysqli_fetch_array(mysqli_query($con, "select * from departamento_atual_pcp where id_depto_atual = '{$id_depto_atual}'"));
        $tempo_especifico = (int)$qtd_fotos * $metrica['tempo_estimado'];
        mysqli_query($con, "UPDATE pcp SET tempo_especifico = '{$tempo_especifico}' where id_pcp = '{$pcp['id_pcp']}'");
    }
    $data = date('Y-m-d H:i:s');
    $sql = mysqli_query($con, "update departamento_atual_pcp set status='1',data_termino='{$data}' where id_depto_atual = '{$id_depto_atual}'");
}
if (isset($_GET['moverpcp'])) {
    $id_depto_atual = $_GET['moverpcp'];
    $data = date('Y-m-d H:i:s');
    $sql = mysqli_query($con, "update departamento_atual_pcp set data_movimento_pcp='{$data}' where id_depto_atual = '{$id_depto_atual}'");
    $etapa_atual = mysqli_fetch_array(mysqli_query($con, "select je.etapa,p.id_pcp,p.prioridade from jobs_etapas je
                                                               left join jobs j on j.id_job = je.id_job
                                                               left join pcp p on p.id_job = j.id_job
                                                               left join departamento_atual_pcp dap on dap.id_pcp = p.id_pcp
                                                               where dap.id_depto_atual = '{$id_depto_atual}' and dap.id_departamento = je.id_departamento and je.status = '1' order by je.etapa"));
    $sql_job = mysqli_query($con, "select p.id_pcp,je.id_departamento from jobs_etapas je left join jobs j on j.id_job = je.id_job left join pcp p on p.id_job = j.id_job left join departamento_atual_pcp dap on dap.id_pcp = p.id_pcp where dap.id_depto_atual = '{$id_depto_atual}' and je.etapa > '{$etapa_atual['etapa']}' and je.status = '1' order by je.etapa");
    $data = date('Y-m-d H:i:s');
    if (mysqli_num_rows($sql_job) > 0) {
        $vetor_job = mysqli_fetch_array($sql_job);
        mysqli_query($con, "update pcp set etapa='{$etapa_atual['etapa']}' where id_pcp = '{$etapa_atual['id_pcp']}'");
        mysqli_query($con, "insert into departamento_atual_pcp (id_pcp,id_departamento,data_criado)VALUES('{$vetor_job['id_pcp']}','{$vetor_job['id_departamento']}','{$data}')");
    } else {
        mysqli_query($con, "update pcp set status='1' where id_pcp = '{$etapa_atual['id_pcp']}'");
        mysqli_query($con, "update pcp set prioridade = prioridade - 1 where prioridade > '{$etapa_atual['prioridade']}'");
    }
}
if (isset($_POST['tipo_job'])) {
    $id_turma = $_POST['id_turma'];
    $tipo_calculo = $_POST['tipo_calculo'];
    $id_formando = 0;
    $tempo = 0;
    $data_calculo = date('Y-m-d');
    $data_entrega = 'NULL';
    $id_trabalho = 'NULL';
    switch ($tipo_calculo) {
        case '0':
            $tipo_job = $_POST['tipo_job'];
            break;
        case '1':
            $tipo_job = $_POST['tipo_job'];
            $data_entrega = $_POST['data_entrega'];
            $sql = mysqli_query($con, "select SUM(prazo_geral) as prazo_geral,MAX(etapa) as maxetapa from jobs_etapas where id_job = '{$tipo_job}'") or die (mysqli_error($con));
            $etapas = mysqli_fetch_array($sql);
            $prazo_geral = $etapas['prazo_geral'] + $etapas['maxetapa'] - 1;
            $data_calculo = date('Y-m-d', strtotime('-' . $prazo_geral . ' weekdays', strtotime($data_entrega)));
            $prazo_geral = numeroFeriados($data_calculo, $prazo_geral, $con);
            $data_calculo = date('Y-m-d', strtotime('-' . $prazo_geral . ' weekdays', strtotime($data_entrega)));
            $data_entrega = "'".$data_entrega."'";
            break;
        default:
            $id_trabalho = $_POST['id_trabalho'];
            $id_formando = $_POST['id_formando'];
            $tempo = $_POST['tempo'];
            $sql = mysqli_query($con, "select j.id_job from jobs j where j.tipo_calculo = '{$tipo_calculo}'") or die (mysqli_error($con));
            $job = mysqli_fetch_array($sql);
            $tipo_job = $job['id_job'];
            break;
    }
    $data_criado = date('Y-m-d H:i:s');
    $sql = mysqli_query($con, "select MAX(prioridade) as max_prioridade from pcp where status = '0'") or die (mysqli_error($con));
    if ($sql) {
        $vetor_prioridade = mysqli_fetch_array($sql);
        $prioridade = (int)$vetor_prioridade['max_prioridade'] + 1;
    } else {
        $prioridade = 1;
    }
    $sql = mysqli_query($con, "insert into pcp (id_job,id_formando,id_turma,etapa,data_calculo,data_criado,status,prioridade,tempo_especifico,data_entrega,id_trabalho)VALUES('{$tipo_job}','{$id_formando}','{$id_turma}','1','{$data_calculo}','{$data_criado}','0','{$prioridade}','{$tempo}',{$data_entrega},{$id_trabalho})") or die (mysqli_error($con));
    $id_pcp = $con->insert_id;
    $vetor_job = mysqli_fetch_array(mysqli_query($con, "select je.* from jobs_etapas je left join jobs j on j.id_job = je.id_job left join pcp p on p.id_job = j.id_job where p.id_pcp = '{$id_pcp}' and je.etapa = '1' and je.status='1'"));
    $data = date('Y-m-d H:i:s');
    mysqli_query($con, "insert into departamento_atual_pcp (id_pcp,id_departamento,data_criado)VALUES('{$id_pcp}','{$vetor_job['id_departamento']}','{$data}')") or die (mysqli_error($con));
    echo "<script> window.location.href='pcp_geral.php'</script>";
}

if (isset($_GET['cancelar'])) {
    $id_pcp = $_GET['cancelar'];
    $sql = mysqli_query($con, "UPDATE pcp SET status=NULL WHERE id_pcp = {$id_pcp}");
    $sql = mysqli_query($con, "UPDATE departamento_atual_pcp SET status=99 WHERE id_pcp = {$id_pcp}");
}
