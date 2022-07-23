    <?php

        $id_departamento = $_GET['id_departamento'];

        include"../includes/conexao.php";



       $result_etapas = mysqli_query($con, "SELECT * FROM jobs_departamentos a, jobs b WHERE a.id_departamento = '$id_departamento' and a.id_job = b.id_job order by b.titulo ASC");
       echo "<option value='' selected>Selecione a Job</option>";
       while($row_etapa = mysqli_fetch_array($result_etapas) ){

            echo "<option value='".$row_etapa['id_job']."'>".$row_etapa['titulo']."</option>";


       }

    ?>