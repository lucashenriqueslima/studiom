<?php

$id_turma = $_GET['id_turma'];

include "../includes/conexao.php";
if (!isset($_GET['load'])) {
    ?>
    <table class="table table-bordered table-striped" id="tabela">
        <thead align="center">
        <tr>
            <th><strong><h4>Código</strong><h4></th>
            <th><strong><h4>Formando</strong><h4></th>
            <th><strong><h4>Status</strong><h4></th>
            <th><strong><h4>Ação</strong><h4></th>
        </tr>
        </thead>
        <tbody>

        <?php
        $sql = mysqli_query($con, "SELECT * FROM formandos WHERE turma = '$id_turma' order by id_cadastro ASC");
        $turma = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM turmas WHERE id_turma = '$id_turma'"));
        while ($formando = mysqli_fetch_array($sql)) {
            $id = $formando['id_formando'];
            $sql_perfil = mysqli_query($con, "SELECT * FROM meuperfilfotografico WHERE id_formando = '$id'");
            $perfil = mysqli_fetch_array($sql_perfil);

            if (!empty($perfil['id_formando'])) {
                $perfil = "SIM";
            } else {
                $perfil = "NÂO";
            }

            ?>
            <tr>
                <td align="center"><?php echo $turma['ncontrato'] . '-' . $formando['id_cadastro']; ?></td>
                <td><?php echo $formando['nome']; ?></td>
                <td align="center"><?php echo $perfil; ?></td>
                <td align="center"><a class="fancybox fancybox.ajax"
                                      href="recebe_perfilfotografico.php?id_turma=<?php echo $formando['turma']; ?>&id_formando=<?php echo $formando['id_formando']; ?>"
                                      target="_blank">
                        <button type="button" class="btn btn-success"
                                title="Ver Cadastroo"><i
                                    class="mdi mdi-tooltip-edit"></i></button>
                    </a>
                </td>
            </tr>
        <?php }
        ?>
        </tbody>
    </table>
<?php } else {
    $result_formandos = mysqli_query($con, "SELECT * FROM formandos WHERE turma = '$id_turma' order by nome ASC");

    echo "<option value='' selected>Selecione o Formando</option>";
    while ($row_formando = mysqli_fetch_array($result_formandos)) {
        echo "<option value='" . $row_formando['id_formando'] . "'>" . $row_formando['nome'] . "</option>";
    }
} ?>