<?php



session_start();

include "../includes/conexao.php";

$id = $_GET['id'];
$departamento = $_GET['departamento'];
$status = $_POST['status'];
$quemconcluiu = $_POST['quemconcluiu'];
$relatorio = $_POST['relatorio'];
$dataatual = date('Y-m-d');
$horaatual = date('H:i:s');
$descricao = $_POST['descricao'];

$sql = mysqli_query($con, "select * from calendario where id_calendario = '$id'");
$vetor = mysqli_fetch_array($sql);

if ($status == '2') {
    $sql_atualiza = mysqli_query($con, "update calendario SET descricao='$descricao',status = '$status', quemconcluiu='$quemconcluiu', relatorio='$relatorio', datatermino = '$dataatual', horatermino='$horaatual' where id_calendario = '$id'");
} else {
    $sql_atualiza = mysqli_query($con, "update calendario SET descricao='$descricao', quemconcluiu='$quemconcluiu', relatorio='$relatorio', datatermino = '$dataatual', horatermino='$horaatual' where id_calendario = '$id'");
}
if(isset($_GET['calendario'])){

    echo "<script language=\"JavaScript\">
location.href=\"interatividade_calendario.php\";
</script>";

}elseif ($departamento == NULL) {

    echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=1\";
</script>";

}elseif ($departamento == 1) {

    echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=1\";
</script>";

}elseif ($departamento == 2) {

    echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=2\";
</script>";

}elseif ($departamento == 3) {

    echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=3\";
</script>";

}elseif ($departamento == 4) {

    echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=4\";
</script>";

}elseif ($departamento == 5) {

    echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=5\";
</script>";

}elseif ($departamento == 7) {

    echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=7\";
</script>";

}elseif ($departamento == 9) {

    echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=9\";
</script>";

}elseif ($departamento == 10) {

    echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=10\";
</script>";

}elseif ($departamento == 11) {

    echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=11\";
</script>";

}elseif ($departamento == 12) {

    echo "<script language=\"JavaScript\">
location.href=\"tarefas.php?departamento=12\";
</script>";

}

?>