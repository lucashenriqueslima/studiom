<?php
include "../includes/conexao.php";
if (isset($_GET['remover'])) {
	$remover = $_GET['remover'];
	mysqli_query($con,"update fomentos set status='0' where id_fomento='$remover'");
}elseif(isset($_GET['alterar'])){
	$alterar = $_GET['alterar'];
	$status = $_POST['status'];
	$nome = ucwords(strtolower($_POST['nome']));
	mysqli_query($con,"update fomentos set nome='$nome',status='$status' where id_fomento='$alterar'");
}else{
	$nome = ucwords(strtolower($_POST['nome']));
	mysqli_query($con,"insert into fomentos (nome,status)VALUES('$nome','1')");
}

echo "<script language=\"JavaScript\">
location.href=\"financeiro_cadastros.php#ch1\";
</script>";
?>
