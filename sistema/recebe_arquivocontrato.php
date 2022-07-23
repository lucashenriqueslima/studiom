<?php

session_start();



include"../includes/conexao.php";


$id = $_GET['id'];

$titulo = ucwords(strtolower($_POST['titulo']));
$data = date('Y-m-d');
$horaatual = date('H:i:s');
$tipo = $_POST['tipo'];
$emailcompra = $_POST['emailcompra'];
$comissao = $_POST['comissao'];
$diretorio = "arquivos/";
$nomeimagem = $_FILES['arquivo']['name'];  
$tmp = $_FILES['arquivo']['tmp_name'];
$ext = strrchr($nomeimagem, '.'); 
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
move_uploaded_file($tmp, $upload);

$sql_grava = mysqli_query($con, "insert into arquivos_contratos (id_cliente, id_usuario, titulo, data, hora, tipo, emailcompra, comissao, arquivo) VALUES ('$id', '$_SESSION[id]', '$titulo', '$data', '$horaatual', '$tipo', '$emailcompra', '$comissao', '$imagem')");

if($tipo = '1'){
    echo"<script language=\"JavaScript\">
location.href=\"alterarturma.php?id=$id#fotografia#documentosfotografia\";
</script>";
}else{
    echo"<script language=\"JavaScript\">
location.href=\"alterarturma.php?id=$id#convite#documentosconvite\";
</script>";
}

?>