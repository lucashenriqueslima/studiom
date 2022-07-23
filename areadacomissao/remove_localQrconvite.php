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

 $id_categoria = $_GET['idcategoria'];


 $sql_verifica = mysqli_query($con,"select * from dados_evento_qrconvite where id_turma_fk = '$id_turma' and id_categoriaEvento_fk = '$id_categoria'");
 $vetor_sql_verifica = mysqli_fetch_array($sql_verifica);
 if (mysqli_num_rows($sql_verifica) == 0) {
         echo "evento não existente";
 
 }else {
               
        $sql = mysqli_query($con, "delete from dados_evento_qrconvite where id_turma_fk = '$id_turma' and id_categoriaEvento_fk = '$id_categoria'");
        $sql_staus_evento = mysqli_query($con, "update eventos_turma_lista set status = 0 where id_evento_turma = '{$vetor_sql_verifica['id_evento_turma_lista_fk']}'");
        echo "<script> alert('Excluido com sucesso!')</script>";
        echo "<script> window.location.href='dadosconvite.php'</script>";
 }
}

?>