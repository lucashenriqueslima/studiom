<?php 

session_start();



include"../includes/conexao.php";


$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
$res_cadastro = mysqli_query($con, $sql_cadastro);
$vetor_cadastro = mysqli_fetch_array($res_cadastro);

$id = $_GET['id'];
$descricao = $_POST['descricao'];

$data = date('Y-m-d');
$hora = date('H:i:s');

$sql_interacoes = mysqli_query($con, "insert into chamado_interacoes (id_chamado, tipo, id_cadastro, data, hora, texto) VALUES ('$id', '1', '$vetor_cadastro[id_formando]', '$data', '$hora', '$descricao')");
$id_interacao = $con->insert_id;

$x = $_POST['nimagem'];

$diretorio = "../sistema/arquivos/";

$i = 0;

foreach($x as $keyyy) {

$nomeimagem = $_FILES['arquivo']['name'][$i];  
$tmp = $_FILES['arquivo']['tmp_name'][$i];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

if($nomeimagem != NULL) {

$sql_anexo = mysqli_query($con, "insert into chamado_mensagens_anexos (id_mensagem, anexo) VALUES ('$id_interacao', '$imagem')");

}

$i++;


}


echo"<script language=\"JavaScript\">
location.href=\"verchamado.php?id=$id\";
</script>";

?>