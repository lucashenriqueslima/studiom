<?php

include"../includes/conexao.php";


$nome_produto = $_POST['nome_produto'];
$aprovacao = $_POST['aprovacao'];
$informacoes = (isset($_POST['esquerda']) ? $_POST['esquerda'] : '');
$diretorio = "../sistema/arquivos/imagens_produtos/";

$sql = mysqli_query($con, "insert into tipo_opcionais (nome,aprovacao)values('$nome_produto','$aprovacao')");
$id = $con->insert_id;
$i = 0;
if (isset($_POST['esquerda'])) {
    foreach ($informacoes as $info) {
        $esquerda = $_POST['esquerda'][$i];
        $direita = $_POST['direita'][$i];
        $sql = mysqli_query($con, "insert into produtos_especificacoes (id_tipo_produto,esquerda,direita)VALUES('$id','$esquerda','$direita')");
        $i++;
    }
}

echo "<script language=\"JavaScript\">
location.href=\"alterartipoprodutoop.php?id=$id\";
</script>";

?>