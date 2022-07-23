<?php
include "../includes/conexao.php";
if(isset($_GET['f'])){
    $titulo = ucwords(strtolower($_POST['titulo']));
    $cat_pai = $_POST['cat_pai'];
    $sql = mysqli_query($con,"select MAX(numero) as maxnumero from ficha_tecnica where cat_pai='$cat_pai'");
    if(mysqli_num_rows($sql) > 0){
        $vetor = mysqli_fetch_array($sql);
        $numero = (int)$vetor['maxnumero'] + 1;
    }else{
        $numero = 1;
    }
    $sql = mysqli_query($con,"insert into ficha_tecnica (titulo,cat_pai,status,id_catconta,numero,categoria_fornecedor)VALUES('$titulo','$cat_pai','1','0','$numero','0')");
}elseif (isset($_GET['remover'])) {
    $remover = $_GET['remover'];
    mysqli_query($con,"update ficha_tecnica set status='0' where id_ficha='$remover'");
}elseif(isset($_GET['alterar'])){
    $alterar = $_GET['alterar'];
    $status = $_POST['status'];
    $titulo = ucwords(strtolower($_POST['titulo']));
    $cat_pai = $_POST['cat_pai'];
    mysqli_query($con,"update ficha_tecnica set titulo='$titulo',cat_pai='$cat_pai' where id_ficha='$alterar'");
}elseif(isset($_POST['cat_fornecedor'])){
    $id_categoria = $_POST['cat_fornecedor'];
    $vetor = mysqli_fetch_array(mysqli_query($con, "select * from categoriafornecedor where id_categoria = '$id_categoria'"));
    $titulo = $vetor['nome'];
    $cat_pai = $_POST['produto'];
    $id_catconta = $_POST['cat_pai'];
    $sql = mysqli_query($con,"select MAX(numero) as maxnumero from ficha_tecnica where cat_pai='$cat_pai'");
    if(mysqli_num_rows($sql) > 0){
        $vetor = mysqli_fetch_array($sql);
        $numero = (int)$vetor['maxnumero'] + 1;
    }else{
        $numero = 1;
    }

    $sql = mysqli_query($con,"insert into ficha_tecnica (titulo,cat_pai,status,id_catconta,numero,categoria_fornecedor)VALUES('$titulo','$cat_pai','1','$id_catconta','$numero','$id_categoria')");
}
echo "<script language=\"JavaScript\">
location.href=\"financeiro_cadastros.php#ch3\";
</script>";
?>
