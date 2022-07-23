<?php 

include"includes/conexao.php";

$id = $_GET['id'];
$id_formando = $_GET['id_formando'];

$sql_eventos = mysqli_query($con, "SELECT * FROM eventos_turma WHERE id_evento = '$id'");
$vetor_eventos = mysqli_fetch_array($sql_eventos);

$diretorio = "sistema/arquivos/";
$nomeimagem = $_FILES['imagem']['name'];  
$tmp = $_FILES['imagem']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$sql_consulta = mysqli_query($con, "select * from identificacao_formandos where id_evento = '$id' and id_formando = '$id_formando'");

if(mysqli_num_rows($sql_consulta) == 0) {

$sql = mysqli_query($con, "insert into identificacao_formandos (id_evento, id_formando, imagem) VALUES ('$id', '$id_formando', '$imagem')");

echo "<script> alert('O Reconhecimento Facial do Evento: $vetor_eventos[nome] foi cadastrado com sucesso!')</script>";
echo "<script> window.location.href='identificacao_volta.php?id_formando=$id_formando'</script>";

} else {

echo "<script> alert('O Reconhecimento Facial do Evento: $vetor_eventos[nome] já cadastrado anteriormente!')</script>";
echo "<script> window.location.href='identificacao_volta.php?id_formando=$id_formando'</script>";

}

?>