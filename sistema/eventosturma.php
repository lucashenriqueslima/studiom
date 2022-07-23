    <?php

        $id_turma = $_GET['id_turma'];

        include"../includes/conexao.php";



       $result_formandos = mysqli_query($con, "select * from categoriaevento a, eventos_turma_lista b where a.id_categoria = b.id_evento and b.id_turma = '$id_turma' order by b.id_evento_turma ASC");

		   echo "<option value=\"\" selected=\"selected\">Eventos da Turma</option>";
       while($row_formando = mysqli_fetch_array($result_formandos) ){

            echo "<option value='".$row_formando['id_evento_turma']."'>".$row_formando['nome']."</option>";

       }	

    ?>