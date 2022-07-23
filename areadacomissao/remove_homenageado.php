<?php

include "../includes/conexao.php";

	 
session_start();

if($_SESSION['id_formando'] == NULL && $_SESSION['comissao'] == NULL) {

   echo"<script language=\"JavaScript\">
   location.href=\"inicio.php\";
   </script>";

} else {

if($_SESSION['comissao'] != 2) {

   echo"<script language=\"JavaScript\">
   location.href=\"inicio.php\";
   </script>";

}

 $id_turma = $_GET['idturma'];

 $nome = $_GET['nome'];


 $sql_verifica = mysqli_query($con,"select * from homenageados where id_turma_fk = '$id_turma' and nome_homenageado = '$nome'");
 if (mysqli_num_rows($sql_verifica) == 0) {
         echo "Homenageado não existente";
 
 }else {
               
        $sql = mysqli_query($con, "delete from homenageados where id_turma_fk = '$id_turma' and nome_homenageado = '$nome'");
        echo "<script> alert('Excluido com sucesso!')</script>";
        echo "<script> window.location.href='dadosconvite.php'</script>";
 }
}

?>