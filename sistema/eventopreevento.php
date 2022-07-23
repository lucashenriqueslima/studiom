    <?php

        $tipoevento = $_GET['tipo'];
        $tipo = explode('_', $tipoevento);
        $tipodoevento = $tipo[0];
        $id_turma = $tipo[1];

        include"../includes/conexao.php";


       if($tipodoevento == 1) {

       $result_preeventos = mysqli_query($con, "SELECT * FROM preeventos_turma WHERE id_turma = '$id_turma' order by id_preevento ASC");

       echo "<option value='' selected>Escolha o Pré Evento</option>";
       while($row_preeventos = mysqli_fetch_array($result_preeventos) ){

            echo "<option value='".$row_preeventos['titulo']."'>".$row_preeventos['titulo']."</option>";

        }

       }

       if($tipodoevento == 2) {

       $result_eventos = mysqli_query($con, "SELECT * FROM eventos_turma_lista WHERE id_turma = '$id_turma' order by id_evento_turma ASC");

       echo "<option value='' selected>Escolha o Evento</option>";
       while($row_eventos = mysqli_fetch_array($result_eventos) ){

       $sql_evento = mysqli_query($con, "select * from categoriaevento where id_categoria = '$row_eventos[id_evento]'");
       $vetor_evento = mysqli_fetch_array($sql_evento);

            echo "<option value='".$vetor_evento['nome']."'>".$vetor_evento['nome']."</option>";

        }

       }       

    ?>