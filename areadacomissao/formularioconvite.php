<?php

include "../includes/conexao.php";

session_start();

$id = $_GET['id'];

if ($_SESSION['id_formando'] == NULL && $_SESSION['comissao'] == NULL) {

    echo "<script language=\"JavaScript\">
	location.href=\"inicio.php\";
	</script>";

} else {



    ?>

<?php } ?>