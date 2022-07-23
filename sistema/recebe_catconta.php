<?php
include "../includes/conexao.php";
if (isset($_GET['remover'])) {
	$remover = $_GET['remover'];
	mysqli_query($con,"update categorias_contas set status='0' where id_catconta='{$remover}'");
}elseif(isset($_GET['alterar'])){
	$alterar = $_GET['alterar'];
	$titulo = strtoupper($_POST['titulo']);
	mysqli_query($con,"update categorias_contas set titulo='{$titulo}' where id_catconta='{$alterar}'");
}else{

	function createTree($array, $currentParent) {
		$i = 1;
		foreach ($array as $categoryId => $category) {
			if($currentParent == $category['cat_pai']){
				if($categoryId == $GLOBALS['cat_pai']){
					$GLOBALS['numeracao'] = '.' . $i . $GLOBALS['numeracao'];
					return true;
				}else {
					$retorno = createTree($array, $categoryId);
					if ($retorno) {
						$GLOBALS['numeracao'] = ($currentParent == 0?$i . $GLOBALS['numeracao']:'.' . $i . $GLOBALS['numeracao']);
						return true;
					}
				}
				$i++;
			}
		}
		return false;
	}
	$numeracao = '';
	$titulo = strtoupper($_POST['titulo']);
	$cat_pai = $_POST['cat_pai'];

	$i = 0;
	$sql = mysqli_query($con,"select * from studioms_sistema.categorias_contas where status = '1' order by cat_pai ASC,numero ASC");
	while($aux = mysqli_fetch_array($sql)){
		$arvoreCategoria[$aux['id_catconta']] = array("cat_pai" => $aux['cat_pai'], "titulo" =>
			$aux['titulo']);
	}
	createTree($arvoreCategoria,0);
	$vetor = mysqli_fetch_array(mysqli_query($con,"select MAX(numero) as maxnumero from categorias_contas where cat_pai='{$cat_pai}'"));
	$numero = (int)$vetor['maxnumero'] + 1;
	$numeracao = $numeracao . '.' . $numero;
	$nome = $numeracao . ' - ' . $titulo;
	$sql = mysqli_query($con,"insert into categoriafornecedor (nome)VALUES('{$nome}')");
	$id_fornecedor = $con->insert_id;
	$sql = mysqli_query($con,"insert into categorias_contas (titulo,cat_pai,status,numeracao,numero,cat_filha,categoria_fornecedor)VALUES('{$titulo}','{$cat_pai}','1','{$numeracao}','{$numero}','1','{$id_fornecedor}')");
	mysqli_query($con,"UPDATE categorias_contas SET cat_filha = 0 WHERE id_catconta = '{$cat_pai}'");

}
echo "<script language=\"JavaScript\">
location.href=\"financeiro_cadastros.php#ch2\";
</script>";
?>
