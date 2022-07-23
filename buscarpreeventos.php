<?php
    $id_turma = $_GET['id_turma'];
    include "includes/conexao.php";
    $result_pre = mysqli_query($con, "SELECT * FROM preeventos WHERE id_turma = '$id_turma'");
    echo "<option value=\"\" selected=\"selected\">Produtos o Pré-Evento</option>";
    while ($row_pre = mysqli_fetch_array($result_pre)) {
        echo "<option value='".$row_pre['id_pre']."'>".$row_pre['titulo']."</option>";
    }
?>