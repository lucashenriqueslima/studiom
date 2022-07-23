<?php
include "../includes/conexao.php";
session_start();
if (isset($_POST['estimaTempo'])) {
    $id_suporte = $_POST['id_suporte'];
    $estimaTempo = $_POST['estimaTempo'];
    mysqli_query($con, "update suporte set tempo_estimado = '$estimaTempo' where id = '$id_suporte'");
    $data = date('Y-m-d H:i:s');
    $hora = (int)substr($estimaTempo,0,2);
    $minuto = (int)substr($estimaTempo,3,2);
    mysqli_query($con, "insert into suporte_mensagens (id_suporte, id_cadastro, data, mensagem) VALUES ('$id_suporte', '$_SESSION[id]','$data','<p><h5><strong>Tempo Estimado: " . ($hora < 10 ?'0' . ($hora > 0 ?$hora:'0'):$hora) . "h e " . ($minuto < 10 ?'0' . ($minuto > 0 ?$minuto:'0'):$minuto) . "min" . "</strong></h5></p>')");
    die();
}
if (isset($_POST['tempo'])) {
    $tempo = $_POST['tempo'];
    $id_suporte = $_POST['id_suporte'];
    $data = date('Y-m-d');
    $tempo = explode(':', $tempo);
    $sql = mysqli_query($con, "insert into relatorioti (hora,minuto,id_suporte,dia_trabalhado)VALUES('$tempo[0]','$tempo[1]','$id_suporte','$data')");
    $tempo_total = mysqli_fetch_array(mysqli_query($con, "select tempo_total from suporte where id = '$id_suporte'"));
    $tempo_total = explode(':', $tempo_total['tempo_total']);
    $tempo_total[0] = (int)$tempo_total[0] + (int)$tempo[0];
    $tempo_total[1] = (int)$tempo_total[1] + (int)$tempo[1];
    if ($tempo_total[1] < 10) {
        $tempo_total[1] = '0' . $tempo_total[1];
    } elseif ($tempo_total[1] >= 60) {
        $tempo_total[1] = $tempo_total[1] - 60;
        $tempo_total[0] = $tempo_total[0] + 1;
    }
    if ($tempo_total[0] < 10) {
        $tempo_total[0] = '0' . $tempo_total[0];
    }

    $tempo_total = $tempo_total[0] . ':' . $tempo_total[1] . ':00';
    mysqli_query($con, "update suporte set tempo_total = '$tempo_total' where id = '$id_suporte'");
    die();
}
if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
}

//    Pegando os departamentos
$sql = mysqli_query($con, "select id_departamento,nome,corcalendario from departamentos");
$departamento = array();
while ($auxDepartmento = mysqli_fetch_assoc($sql)) {
    $departamento[$auxDepartmento['id_departamento']]['nome'] = $auxDepartmento['nome'];
    $departamento[$auxDepartmento['id_departamento']]['cor'] = $auxDepartmento['corcalendario'];
}
$sql = mysqli_query($con, "select * from usuarios where id_usuario = '$_SESSION[id]'");
$cadastro = mysqli_fetch_array($sql);
$datainicio = date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))));
$datafim = date('Y-m-d');

$sql = mysqli_query($con, "select * from suporte where data_entregue is null or data_entregue >= '$datainicio' and data_entregue <= '$datafim' order by status DESC, prioridade DESC");

$dados = array();
$tempo_total[0] = 0;
$tempo_total[1] = 0;
$tempo_total[2] = 0;
$validados = 0;
$finalizados = 0;
if ($sql) {
    while ($vetor = mysqli_fetch_array($sql)) {
        if ($vetor['status'] == '1') {
            $auxTempo = explode(':', substr($vetor['tempo_estimado'], 0, 5));
            $tempo_total[2] = $auxTempo[1] + $tempo_total[2];
            if ($tempo_total[2] > 60) {
                $tempo_total[2] = $tempo_total[2] - 60;
                $tempo_total[1] += 1;
            }
            $tempo_total[1] = $auxTempo[0] + $tempo_total[1];
        } elseif ($vetor['status'] == '2') $validados++;
        else {
            $finalizados++;
        }
        array_push($dados, $vetor);
    }
}

while ($tempo_total[1] > 8) {
    $tempo_total[0]++;
    $tempo_total[1] -= 8;
}

$sql = mysqli_query($con, "select distinct MONTH(dia_trabalhado) as mes from relatorioti;");
$dataRelatorio = array();
while ($vetor = mysqli_fetch_array($sql)) {
    array_push($dataRelatorio, $vetor['mes']);
}
$tempo_total[1] = $tempo_total[1] + $tempo_total[0] * 8;
$meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
//echo "<pre>";
//var_dump($dataRelatorio);
//echo "</pre>";
//die();
include "view_ajustes_evolucoes.php";
?>
