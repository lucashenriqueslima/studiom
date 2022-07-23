<?php
include "../includes/conexao.php";
$data = $_GET['data'];
$data = substr($data, 0, 7);
$datainicio = '2020-' . $data . '-01';
$mes = substr($data, 5, 2);
$datafinal = '';
if ((int)$mes == 1 || (int)$mes == 3 || (int)$mes == 5 || (int)$mes == 7 || (int)$mes == 8 || (int)$mes == 10 || (int)$mes == 12)
    $datafinal = '2020-' . $data . '-31';
elseif ((int)$mes == 2)
    $datafinal = '2020-' . $data . '-29';
else {
    $datafinal = '2020-' . $data . '-30';
}
$sql = mysqli_query($con, "select * from suporte where data_entregue >= '$datainicio' and data_entregue <= '$datafinal' order by data_entregue ASC");
$total = 0;
$minuto = 0;
if ($sql != NULL) {
    ?>
    <table class="table table-bordered table-striped" id="imprimeRel">
        <thead>
        <tr>
            <th>Data Pedido</th>
            <th>Data Finalizado</th>
            <th>Serviço</th>
            <th>Tempo Estimado</th>
            <th>Tempo Realizado</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($vetor = mysqli_fetch_array($sql)) {
            $auxTempo = explode(':', $vetor['tempo_total']);
            $minuto = $minuto + (int)$auxTempo[1];
            $total = $total + (int)$auxTempo[0];
            if ($minuto > 60) {
                $minuto -= 60;
                $total++;
            }
            ?>
            <tr>
                <td align="center" width="10%"><?php echo $vetor['data_pedido']; ?></td>
                <td align="center" width="10%"><?php echo $vetor['data_entregue']; ?></td>
                <td align="center" width="60%"><?php echo $vetor['assunto']; ?></td>
                <td align="center"
                    width="10%"><?php echo substr($vetor['tempo_estimado'], 0, 2) . 'h e ' . substr($vetor['tempo_estimado'], 3, 2) . 'min'; ?></td>
                <td align="center"
                    width="10%"><?php echo substr($vetor['tempo_total'], 0, 2) . 'h e ' . substr($vetor['tempo_total'], 3, 2) . 'min'; ?></td>
            </tr>
        <?php }
        ?>
        <tr>
            <td>Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td align="center"><?php echo $total . 'horas e ' . $minuto . 'minutos' ?></td>
        </tr>
        </tbody>
    </table>
<?php } ?>