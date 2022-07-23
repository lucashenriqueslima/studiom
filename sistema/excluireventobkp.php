<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id1 = $_GET['id1'];
$tab = $_GET['tab'];
$tab1 = $_GET['tab1'];

$sql_evento = mysqli_query($con, "select * from eventos_bkp where id_evento = '$id'");
$vetor_evento = mysqli_fetch_array($sql_evento);

function excluiDir($dir){
    
    if ($dd = opendir($dir)) {
        while (false !== ($arq = readdir($dd))) {
            if($arq != "." && $arq != ".."){
                $path = "$dir/$arq";
                if(is_dir($path)){
                    self::excluiDir($path);
                }elseif(is_file($path)){
                    unlink($path);
                }
            }
        }
        closedir($dd);
    }
    rmdir($dir);
}

$pasta = '/home/studioms/public_html/sistema/arquivos/eventosbkp/'.$vetor_evento['pasta'];

excluiDir($pasta);

$sql_exclui = "delete FROM eventos_bkp where id_evento = '$id'";
$res2 = mysqli_query($con, $sql_exclui);
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='alterarturma.php?id=$id1&tab=$tab&tab1=$tab1'</script>";

?>