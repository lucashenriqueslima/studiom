    <?php

        $id_turma = $_GET['id_turma'];

        include"../includes/conexao.php";



       $result_formandos = mysqli_query($con, "SELECT * FROM formandos where turma = '$id_turma' order by nome ASC");
       echo "<option value='' selected>Selecione o Formando</option>";
       while($row_formando = mysqli_fetch_array($result_formandos) ){

       $sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$id_turma'");
       $vetor_turma = mysqli_fetch_array($sql_turma);

            echo "<option value='".$row_formando['id_formando']."'>".$vetor_turma['ncontrato'].' - '.$row_formando['id_cadastro'].' '.$row_formando['nome']."</option>";


       }

    ?>