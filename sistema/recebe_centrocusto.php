<?php
include "../includes/conexao.php";
if (isset($_GET['remover'])) {
    $remover = $_GET['remover'];
    mysqli_query($con,"update centro_custo set status='0' where id_centro='$remover'");
}elseif(isset($_GET['alterar'])){
    $alterar = $_GET['alterar'];
    $status = $_POST['status'];
    $nome = ucwords(strtolower($_POST['nome']));
    $sigla = $_POST['sigla'];
    mysqli_query($con,"update centro_custo set nome='$nome',sigla='$sigla',status='$status' where id_centro='$alterar'");
}else{
    $nome = ucwords(strtolower($_POST['nome']));
    $sigla = $_POST['sigla'];
    $sql = mysqli_query($con,"insert into centro_custo (nome,sigla,status)VALUES('$nome','$sigla','1')");
}
echo "<script language=\"JavaScript\">
location.href=\"financeiro_cadastros.php#ch4\";
</script>";
?>
