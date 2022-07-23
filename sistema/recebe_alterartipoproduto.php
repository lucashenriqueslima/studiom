<?php

include"../includes/conexao.php";


$id = $_GET['id'];
$nome = ucwords(strtolower($_POST['nome']));

$sql = mysqli_query($con, "update tipos_produtos SET nome='$nome' where id_tipo = '$id'");

$x = $_POST[ 'processo' ];
$i = 0;
foreach($x as &$key){

    $processo = explode("_", $_POST['processo'][$i]);
    $processo1 = $processo[0];
    $processo2 = $processo[1];

    $sql_consulta = mysqli_query($con, "select * from produtos_processos where tipo = '1' and id_produto = '$id' and id_etapa = '$processo2' and id_processo = '$processo1'");

    if(mysqli_num_rows($sql_consulta) == 0) {

    $sql_processo = mysqli_query($con, "insert into produtos_processos (id_produto, tipo, id_etapa, id_processo, dependencia) VALUES 
    ('$id', '1', '$processo2', '$processo1', '1')");

	}

$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"vendas_tiposprodutos.php\";
</script>";

?>