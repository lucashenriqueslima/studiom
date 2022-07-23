<?php

session_start();



include"../includes/conexao.php";


$filename = $_POST['filename'];
$img = $_POST['pngimageData'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$imagemfinal = file_put_contents($filename, $data);

rename("$filename", "../sistema/arquivos/$filename");

$sql_update = mysqli_query($con, "update formandos SET imagem = '$filename' where id_formando = '$_SESSION[id_formando]'");

?>