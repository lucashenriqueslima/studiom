<?php
include "../includes/conexao.php";

$_POST['pcp'] = (isset($_POST['pcp']) && $_POST['pcp'] == 'on'?1:0);
$id = $_GET['id'];
$tipocad = $_POST['tipocad'];
$usuario = $_POST['usuario'];
$password = $_POST['senha'];
if($password != ''){
    $senha = password_hash($password,PASSWORD_DEFAULT);
    $senha = ",senha = '".$senha."'";
}else{
    $senha = '';
}
$departamento = $_POST['departamento'];
$vendedor = $_POST['vendedor'];
$nivel = $_POST['nivel'];
$id_perfil = $_POST['id_perfil'];
$nome = ucwords(strtolower($_POST['nome']));
$diretorio = "arquivos/";
$nomeimagem = $_FILES['imagem']['name'];
$tmp = $_FILES['imagem']['tmp_name'];
$ext = strrchr($nomeimagem, '.');
$imagem = time().uniqid(md5()).$ext;
$upload = $diretorio.$imagem;
$pcp = $_POST['pcp'];
move_uploaded_file($tmp, $upload);
if ($nomeimagem == null) {
	$sql = mysqli_query($con, "update usuarios SET nome='$nome', usuario='$usuario' {$senha}, departamento='$departamento', nivel='$nivel', id_colaborador = '$nome', vendedor='$vendedor',pcp='{$pcp}' where id_usuario = '$id'");
}else {
	$sql = mysqli_query($con, "update usuarios SET nome='$nome', usuario='$usuario' {$senha}, departamento='$departamento', nivel='$nivel', id_colaborador = '$nome', imagem='$imagem', vendedor='$vendedor',pcp='{$pcp}' where id_usuario = '$id'");
}
echo "<script language=\"JavaScript\">
location.href=\"usuarios.php\";
</script>";
?>