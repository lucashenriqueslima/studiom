<?php

session_start();

include "../includes/conexao.php";

if (isset($_GET['formando'])) {
    $nomecompleto = $_POST['nomecompleto'];
    mysqli_query($con, "update formandos set nome='$nomecompleto' where id_formando = '$_SESSION[id_formando]'");
    echo "<script language=\"JavaScript\">
location.href=\"dadosconvite.php\";
</script>";
} elseif (isset($_GET['pais'])) {
    $i = 0;
    foreach ($_POST['pais'] as $dado){
        $nome = $_POST['pais'][$i];
        $id_nomes = $_POST['id_nomes'][$i];
        $inmemoriam = $_POST['inmemoriam'][$i];
        if ($id_nomes == '') {
            $sql = mysqli_query($con, "insert into dadosconvite_nomes (id_formando, tipo, nome,inmemoriam) VALUES ('$_SESSION[id_formando]', '0', '$nome','$inmemoriam')");
        } else {
            $sql = mysqli_query($con, "update dadosconvite_nomes SET nome='$nome',tipo='0',inmemoriam='$inmemoriam' where id_nomes = '$id_nomes'");
        }
        $i++;
    }
    echo "<script language=\"JavaScript\">
location.href=\"dadosconvite.php\";
</script>";
}elseif(isset($_GET['id_nomes'])){
    $id_nomes = $_GET['id_nomes'];
    mysqli_query($con, "DELETE FROM dadosconvite_nomes where id_nomes = '$id_nomes'");
}

?>