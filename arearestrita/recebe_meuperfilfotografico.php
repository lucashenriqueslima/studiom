<?php 

include"../includes/conexao.php";


session_start();

$diretorio = "../sistema/arquivos/";

$sql_consulta = mysqli_query($con, "select * from meuperfilfotografico where id_formando = '$_SESSION[id_formando]'");

$gostafotografico = $_POST['gostafotografico'];
$sexofotografo = $_POST['sexofotografo'];
$qualparte = $_POST['qualparte'];
$parteincomoda = $_POST['parteincomoda'];
$qual = $_POST['qual'];
$podemosfazeralgo = $_POST['podemosfazeralgo'];
$close = $_POST['close'];
$close1 = $_POST['close1'];
$close2 = $_POST['close2'];
$tratamento = $_POST['tratamento'];
$coloracao = $_POST['coloracao'];

if($nomeimagem == NULL) { 

$sql = mysqli_query($con, "update meuperfilfotografico SET gostafotografico='$gostafotografico', sexofotografo='$sexofotografo', qualparte='$qualparte', parteincomoda='$parteincomoda', qual='$qual', podemosfazeralgo='$podemosfazeralgo', close='$close', meiocorpo='$close1', corpointeiro='$close2', tratamento='$tratamento', coloracao='$coloracao',status='1' where id_formando = '$_SESSION[id_formando]'");

} else {

$sql = mysqli_query($con, "update meuperfilfotografico SET gostafotografico='$gostafotografico', sexofotografo='$sexofotografo', qualparte='$qualparte', parteincomoda='$parteincomoda', qual='$qual', podemosfazeralgo='$podemosfazeralgo', close='$close', meiocorpo='$close1', corpointeiro='$close2', tratamento='$tratamento', ladodorosto='$imagem', coloracao='$coloracao',status='1' where id_formando = '$_SESSION[id_formando]'");

}

$y = $_FILES['fotolado'];

if(!empty($y)) {

$l = 0;

foreach($y as $keyyyyy) {

  $nomeimagem2 = $_FILES['fotolado']['name'][$l];  
  $tmp2 = $_FILES['fotolado']['tmp_name'][$l];
  $ext2 = strrchr($nomeimagem2, '.'); 
  $imagem2 = time().uniqid(md5()).$ext2;
  $upload2 = $diretorio.$imagem2;
  move_uploaded_file($tmp2, $upload2);

  if($ext2 != NULL) { 

  $sql_imagem = mysqli_query($con, "insert into fotoslado (id_formando, foto) VALUES ('$_SESSION[id_formando]', '$imagem2')");

  }

  $l++;

}

}

$x = $_FILES['foto'];

if(!empty($x)) {

$i = 0;

foreach($x as $key) {

  $nomeimagem1 = $_FILES['foto']['name'][$i];  
  $tmp1 = $_FILES['foto']['tmp_name'][$i];
  $ext1 = strrchr($nomeimagem1, '.'); 
  $imagem1 = time().uniqid(md5()).$ext1;
  $upload1 = $diretorio.$imagem1;
  move_uploaded_file($tmp1, $upload1);

  if($ext1 != NULL) { 

  $sql_imagem = mysqli_query($con, "insert into fotospreferidas (id_formando, foto) VALUES ('$_SESSION[id_formando]', '$imagem1')");

  }

  $i++;

}

}

$z = $_POST['id_evento'];

if(!empty($z)) {

$f = 0;

foreach($z as $keyy) {

$id_evento = $_POST['id_evento'][$f];

$sql_consulta_referencia = mysqli_query($con, "select * from referenciasfotograficas where id_formando = '$_SESSION[id_formando]' and id_evento='$id_evento'");
$vetor_consulta_referencia = mysqli_fetch_array($sql_consulta_referencia);

if(mysqli_num_rows($sql_consulta_referencia) == 0) { 

$sql_evento = mysqli_query($con, "insert into referenciasfotograficas (id_formando, id_evento) VALUES ('$_SESSION[id_formando]', '$id_evento')");
$id_referencia = $con->insert_id;

} else {

$id_referencia = $vetor_consulta_referencia['id_referencia'];

}

	$nomeimagem2 = $_FILES['imagem']['name'][$f];  
  	$tmp2 = $_FILES['imagem']['tmp_name'][$f];
  	$ext2 = strrchr($nomeimagem2, '.'); 
  	$imagem2 = time().uniqid(md5()).$ext2;
  	$upload2 = $diretorio.$imagem2;
  	move_uploaded_file($tmp2, $upload2);

	if($ext2 != NULL) { 


	$sql_imagens = mysqli_query($con, "insert into referenciasfotograficas_fotos (id_referencia, foto) VALUES ('$id_referencia', '$imagem2')");

	}

	$f++;

}

}

echo"<script language=\"JavaScript\">
location.href=\"meuperfilfotografico.php\";
</script>";

?>