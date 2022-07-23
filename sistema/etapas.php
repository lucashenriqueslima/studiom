    <?php

        $id_departamento = $_GET['id_departamento'];

        include"../includes/conexao.php";



       $result_etapas = mysqli_query($con, "SELECT * FROM etapas WHERE id_departamento = '$id_departamento' order by nome ASC");
       echo "<option value='' selected>Selecione a Etapa</option>";
       while($row_etapa = mysqli_fetch_array($result_etapas) ){

            echo "<option value='".$row_etapa['id_etapa']."'>".$row_etapa['nome']."</option>";


       }

    ?>