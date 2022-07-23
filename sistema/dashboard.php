<?php

include"../includes/conexao.php";


session_start();

if($_SESSION['id'] == NULL) {

echo"<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";

} else {
    $dashboard = 'yes';

    include "interatividade_calendario.php";
}
?>