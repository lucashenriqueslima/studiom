<?php
include "../includes/conexao.php";
$escala = $_POST['escala'];
$id_catconta = $_POST['cat_pai'];
$vetor = mysqli_fetch_array(mysqli_query($con, "select * from categorias_contas where id_catconta = '$id_catconta'"));
$nome = $vetor['titulo'];
$sql = mysqli_query($con, "insert into categoriafornecedor (nome, escala) VALUES ('$nome', '$escala')");
$id_categoria = $con->insert_id;
$cat_pai = $_POST['produto'];
$sql = mysqli_query($con,"select MAX(numero) as maxnumero from ficha_tecnica where cat_pai='$cat_pai'");
if(mysqli_num_rows($sql) > 0){
    $vetor = mysqli_fetch_array($sql);
    $numero = (int)$vetor['maxnumero'] + 1;
}else{
    $numero = 1;
}

$sql = mysqli_query($con,"insert into ficha_tecnica (titulo,cat_pai,status,id_catconta,numero,categoria_fornecedor)VALUES('$nome','$cat_pai','1','$id_catconta','$numero','$id_categoria')");
echo "<script language=\"JavaScript\">
location.href=\"cadastros_categoriasfornecedores.php\";
</script>";
?>