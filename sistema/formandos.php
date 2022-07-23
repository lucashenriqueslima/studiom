    <?php

        $id_turma = $_GET['id_turma'];

        include"../includes/conexao.php";



       $result_formandos = mysqli_query($con, "SELECT * FROM formandos WHERE turma = '$id_turma' AND comissao = '2' order by nome ASC");

		echo "<option value=\"\" selected=\"selected\">Membro da Comissão</option>";
       while($row_formando = mysqli_fetch_array($result_formandos) ){
            echo "<option value='".$row_formando['id_formando']."'>".$row_formando['nome']."</option>";

       }

    ?>