<?php

include"../includes/conexao.php";


$nome = ucwords(strtolower($_POST['nome']));

$sql = mysqli_query($con, "insert into tipos_produtos (nome) VALUES ('$nome')");

$idimp = $con->insert_id;

$x = $_POST[ 'processo' ];
$i = 0;
foreach($x as &$key){

    $processo = explode("_", $_POST['processo'][$i]);
    $processo1 = $processo[0];
    $processo2 = $processo[1];

    $sql_processo = mysqli_query($con, "insert into produtos_processos (id_produto, tipo, id_etapa, id_processo, dependencia) VALUES 
    ('$idimp', '1', '$processo2', '$processo1', '1')");

$i++;

}

echo"<script language=\"JavaScript\">
location.href=\"vendas_tiposprodutos.php\";
</script>";

?>