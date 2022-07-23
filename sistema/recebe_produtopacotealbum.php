<?php
include "../includes/conexao.php";

$id = $_GET['id'];
$id1 = $_GET['id1'];
$x = $_POST['id_produto'];
$i = 0;

foreach ($x as $key) {
    $id_produto = $_POST['id_produto'][$i];
    $qtdpaginas = $_POST['qtdpaginas'][$i];
    $res_ref = mysqli_query($con, "insert into pacotes_itens_produtos (id_pacote, id_produto, qtdpaginas) VALUES ('$id', '$id_produto', '$qtdpaginas')") or die (mysqli_error($con));
    $i++;

}

echo "<script language=\"JavaScript\">
location.href=\"alterarprodutopacotealbum.php?id=$id&id1=$id1\";
</script>";

?>