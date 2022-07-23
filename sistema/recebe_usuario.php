<?php

include"../includes/conexao.php";

$tipocad = $_POST['tipo'];
$_POST['pcp'] = (isset($_POST['pcp']) && $_POST['pcp'] == 'on'?1:0);
if($tipocad == 1) {

$nome = ucwords(strtolower($_POST['nome']));

$sql_colaborador = mysqli_query($con, "select * from colaboradores where id_cadastro = '$nome'");
$vetor_colaborador = mysqli_fetch_array($sql_colaborador);

} if($tipocad == 2) {

$nome = $_POST['nome1'];

$sql_colaborador = mysqli_query($con, "select * from clientes where id_cli = '$nome'");
$vetor_colaborador = mysqli_fetch_array($sql_colaborador);

}

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$hash = password_hash($senha,PASSWORD_DEFAULT);
$departamento = $_POST['departamento'];
$vendedor = $_POST['vendedor'];
$nivel = $_POST['nivel'];
$id_perfil = $_POST['id_perfil'];
$pcp = $_POST['pcp'];

$sql = mysqli_query($con, "insert into usuarios (nome, usuario, senha, departamento, id_colaborador, nivel, vendedor, id_perfil,pcp) VALUES ('{$vetor_colaborador['nome']}', '{$usuario}', '{$hash}', '{$departamento}', '{$nome}', '{$nivel}', '{$vendedor}', '{$id_perfil}','{$pcp}')");

echo"<script language=\"JavaScript\">
location.href=\"usuarios.php\";
</script>";

?>