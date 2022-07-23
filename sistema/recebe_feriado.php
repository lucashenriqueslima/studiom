<?php
include "../includes/conexao.php";

$i = 0;
foreach ($_POST['titulo'] as $key){
	$titulo = ucwords(strtolower($_POST['titulo'][$i]));
	$data = $_POST['data'][$i];
	$res_ref = mysqli_query($con, "insert into feriados (titulo,data,status)VALUES('$titulo','$data','1')");
	$i++;
}


echo "<script language=\"JavaScript\">
location.href=\"interatividade_feriados.php\";
</script>";

?>