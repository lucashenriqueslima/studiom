    <?php

        $id_turma = $_GET['id_turma'];

        include"../includes/conexao.php";



       $result_formando = mysqli_query($con, "SELECT * FROM formandos WHERE turma = '$id_turma' order by nome ASC");

		echo "<option value=\"\" selected=\"selected\">Escolha uma Turma</option>";
       while($row_formando = mysqli_fetch_array($result_formando) ){
            echo "<option value='".$row_formando['id_formando']."'>".$row_formando['nome']."</option>";

       }

    ?>