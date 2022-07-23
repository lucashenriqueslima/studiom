<?php 
    $id = $_GET['id_turma'];
  
    include "../includes/conexao.php";

    $sql_eventos = mysqli_query($con, "select * from eventos_turma_lista WHERE id_turma = '$id' ");
    $i = 0;
    echo "<option value=\"\" selected=\"selected\">Eventos </option>";
    while ($vetor_eventos = mysqli_fetch_array($sql_eventos)) {
        $sql_evento = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_eventos[id_evento]' ");
        $vetor_evento = mysqli_fetch_array($sql_evento);

        if ($vetor_evento['nome'] == 'Pré-evento'){
            
            echo "<option value='{$vetor_eventos['id_evento_turma']}'> {$vetor_evento['nome']} {$vetor_eventos['preevento']} </option>";
        }else { 
            echo "<option value='{$vetor_eventos['id_evento_turma']}'> {$vetor_evento['nome']} </option>";
        }
        
    // echo "<option value='$reg->id_cidade'>$reg->nome_cidade</option>";
    }
 

?>