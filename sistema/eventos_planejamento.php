    <?php

        $id_turma = $_GET['id_turma'];

        include"../includes/conexao.php";


       // $dataatual = date('Y-m-d');

        //$result_formandos = mysqli_query($con, "SELECT * FROM eventos_turma WHERE id_turma = '$id_turma' and data >= '$dataatual' order by data ASC");
        //$result_formandos = mysqli_query($con, "SELECT * FROM eventos_turma WHERE data  >= '$dataatual' and id_turma = '$id_turma' order by data ASC");
        $result_formandos = mysqli_query($con, "SELECT * FROM eventos_turma WHERE id_turma = '$id_turma' order by data ASC");
        //echo "<option>$dataatual</option>";
        //echo "<option>$dataatual</option>";
        while($row_formando = mysqli_fetch_array($result_formandos) ){
                echo "<option value='".$row_formando['id_evento']."'>".date('d/m/Y', strtotime($row_formando['data'])) . ' - '.$row_formando['nome']."</option>";
        }

    ?>