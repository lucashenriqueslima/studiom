<?php

include"../includes/conexao.php";


$id = $_GET[ 'id' ];
$id1 = $_GET[ 'id1' ];

$sql_evento = mysqli_query($con, "select * from eventosformando where id_evento = '$id'");
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

$pasta = '/home/studioms/public_html/sistema/arquivos/formandos/'.$vetor_evento['pasta'];

excluiDir($pasta);

$sql_exclui = "delete FROM eventosformando where id_evento = '$id'";
$res2 = mysqli_query($con, $sql_exclui);
     echo "<script> alert('Excluido com sucesso!')</script>";
	 echo "<script> window.location.href='alterarformando.php?id=$id1'</script>";

?>