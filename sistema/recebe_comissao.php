<?php
include "../includes/conexao.php";
if (isset($_GET['remover'])) {
    $remover = $_GET['remover'];
    mysqli_query($con,"update comissoes set status='0' where id_comissao='$remover'");
}else{
    $id_conta = $_POST['conta'];
    $base_calculo = $_POST['base'];
    mysqli_query($con,"insert into comissoes (id_conta,base_calculo,status)VALUES('$id_conta','$base_calculo','1')");
}

echo "<script language=\"JavaScript\">
location.href=\"financeiro_cadastros.php#ch6\";
</script>";
?>
