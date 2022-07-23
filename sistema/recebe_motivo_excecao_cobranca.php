<?php
    include "../includes/conexao.php";
    if (isset($_GET['remover'])) {
        $remover = $_GET['remover'];
        mysqli_query($con,"delete from motivos_excecao_cobranca where id_motivo_excecao_cobranca='$remover'");
    }else{
        $motivo = ucwords(strtolower($_POST['motivo']));
        mysqli_query($con,"insert into motivos_excecao_cobranca VALUES( NULL, '$motivo')");
    }
    
    echo "<script language=\"JavaScript\">
    location.href=\"financeiro_cadastros.php#ch7\";
    </script>";
    ?>