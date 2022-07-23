<?php

include"sistema/includes/conexao.php";

echo $id_turma = $_POST['id_turma'];
echo $titulo = ucwords(strtolower($_POST['titulo']));

$sql = mysqli_query($con, "select * from turmas where id_turma = '$id_turma'");
$vetor = mysqli_fetch_array($sql);

echo $pasta = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($titulo)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

echo $pastafinal = $vetor['ncontrato'].'-'.$pasta;

mkdir ("/home/studioms/public_html/imagem/$pastafinal", 0755 );

$sql_grava = mysqli_query($con, "insert into preeventos (id_turma, titulo, pasta) VALUES ('$id_turma', '$titulo', '$pastafinal')");



?>