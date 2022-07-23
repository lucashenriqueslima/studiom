<?php
include "../includes/conexao.php";

session_start();
$categoria = $_GET['categoria'];
$ordem = array();
$id_usuario = $_SESSION['id'];
$usuarios_permitidos = array(1, 2,89, 88, 67, 72);
$res_subcategoria = mysqli_query($con, "select * from sub_categorias where id_categoria='{$categoria}'" . (in_array($id_usuario, $usuarios_permitidos) ? "" : " and posicao > 1") . " order by posicao ASC");
$numero = mysqli_num_rows($res_subcategoria);
$ano_convite = (int)date('Y') + 1;
?>
<div class="table-responsive">
    <table class="table table-responsive table-striped"
           style="width: <?php echo $numero * 325; ?>px;height: 600px;position:relative;overflow: initial">
        <thead align="center">
        <tr>
            <?php
            if (in_array($id_usuario, $usuarios_permitidos)) {
                $max_vendedores = mysqli_num_rows(mysqli_query($con, "select l.id_responsavel from leads l where l.deletado is null and l.id_responsavel is not null and l.id_categoria_crm = '{$categoria}' GROUP BY l.id_responsavel"));
            }
            while ($vetor = mysqli_fetch_array($res_subcategoria)) {
                $sql_oportunidadesAux = mysqli_query($con, "select *,SUM(valor_venda) as total_venda from leads where deletado is null and id_categoria_crm = '{$categoria}' AND id_status = '{$vetor['id_sub']}'" . (in_array($id_usuario, $usuarios_permitidos) ? "" : " and id_responsavel='{$id_usuario}'"));
                $sql_oportunidades = mysqli_query($con, "select tl.id_turma_lead,l.* from leads l
left join turmas_leads tl on tl.id_fotografia = l.id_lead 
							or tl.id_ensaio = l.id_lead 
							or tl.id_placa = l.id_lead 
							or tl.id_convite = l.id_lead 
where l.deletado is null and l.id_categoria_crm = '{$categoria}' AND l.id_status = '{$vetor['id_sub']}'" . (in_array($id_usuario, $usuarios_permitidos) ? "" : " and l.id_responsavel='{$id_usuario}'") . ($categoria == '3' ? " and tl.ano_conclusao >= " . $ano_convite : '') . " order by tl.ano_conclusao ASC, tl.semestre ASC");
                $total_qtd = mysqli_num_rows($sql_oportunidades);
                $vetor_oportunidades = mysqli_fetch_array($sql_oportunidadesAux);
                $total_valor = $vetor_oportunidades['total_venda'];
                array_push($ordem, $vetor['id_sub']);
                if (in_array($id_usuario, $usuarios_permitidos)) {
                    $sql_vendedores = mysqli_query($con, "select u.id_usuario,u.nome,u.cor,sum(l.valor_venda) as total_vendedor from leads l left join usuarios u on u.id_usuario = l.id_responsavel where deletado is null and l.id_responsavel is not null and id_categoria_crm = '{$categoria}' AND id_status = '{$vetor['id_sub']}' group by l.id_responsavel order by u.nome");
                }
                ?>
                <th style="width: 325px;position: sticky;top: 0px;">
                    <table>
                        <tr>
                            <td bgcolor="#E8E8E8" width="285px">
                                <h4 align="center">
                                    <strong><?php echo $vetor['nome']; ?></strong></h4>
                                <h6>Total no Status: <?php echo $total_qtd; ?></h6>
                                <h6>Valor no Status: R$<?php echo number_format($total_valor, 2, ',', '.'); ?></h6>
                                <?php if (in_array($id_usuario, $usuarios_permitidos)) {
                                    $cont = 0;
                                    while ($vendedores = mysqli_fetch_array($sql_vendedores)) {
                                        if ($vendedores['nome'] != null) {
                                            $words = explode(" ", $vendedores['nome']);
                                            $acronym = $words[0][0] . $words[1][0];
                                            echo "<style>
                                                h6[data-letters=" . $acronym . "]:before{
                                                    background:" . $vendedores['cor'] . ";
                                                }
                                                </style>";
                                            echo "<h6 id='usuario_" . $vendedores['id_usuario'] . "' data-letters='" . $acronym . "'>R$" . number_format($vendedores['total_vendedor'], 2, ',', '.') . "</h6>";
                                            $cont++;
                                        }
                                    }
                                    while ($cont < $max_vendedores) {
                                        echo "<style>
                                            h6[data-letters=YW]:before{
                                                background:rgb(232, 232, 232);
                                                color:rgb(232, 232, 232);
                                            }
                                            </style>";
                                        echo "<h6 data-letters='YW'></h6>";
                                        $cont++;
                                    }
                                } ?>
                            </td>
                            <td bgcolor="#ff4500" style="vertical-align: middle">
                                <div class="seta-1"
                                     style="border-left: 18px solid #E8E8E8; border-top: 18px solid transparent;  border-bottom: 18px solid transparent; float:left">

                                </div>
                            </td>
                        </tr>
                    </table>
                </th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            foreach ($ordem as $id_sub) {
                ?>
                <td style="background-color: white;">
                    <?php
                    $sql_oportunidades = mysqli_query($con, "select u.id_usuario,u.nome,u.cor,tl.id_turma_lead,l.* from leads l
left join turmas_leads tl on tl.id_fotografia = l.id_lead 
							or tl.id_ensaio = l.id_lead 
							or tl.id_placa = l.id_lead 
							or tl.id_convite = l.id_lead
left join usuarios u on u.id_usuario = l.id_responsavel
where l.deletado is null and l.id_categoria_crm = '{$categoria}' AND l.id_status = '{$id_sub}'" . (in_array($id_usuario, $usuarios_permitidos) ? "" : " and l.id_responsavel='{$id_usuario}'") . ($categoria == '3' ? " and tl.ano_conclusao >= " . $ano_convite : '') . " order by tl.ano_conclusao ASC, tl.semestre ASC");
                    while ($vetor_oportunidades = mysqli_fetch_array($sql_oportunidades)) {

                        switch ($vetor_oportunidades['produto']) {
                            case 'fotografia':
                                $vetor_turma_lead = mysqli_fetch_array(mysqli_query($con, "select * from turmas_leads where id_fotografia = '{$vetor_oportunidades['id_lead']}'"));
                                break;
                            case 'convite':
                                $vetor_turma_lead = mysqli_fetch_array(mysqli_query($con, "select * from turmas_leads where id_convite = '{$vetor_oportunidades['id_lead']}'"));
                                break;
                            case 'ensaio':
                                $vetor_turma_lead = mysqli_fetch_array(mysqli_query($con, "select * from turmas_leads where id_ensaio = '{$vetor_oportunidades['id_lead']}'"));
                                break;
                            case 'placa':
                                $vetor_turma_lead = mysqli_fetch_array(mysqli_query($con, "select * from turmas_leads where id_placa = '{$vetor_oportunidades['id_lead']}'"));
                                break;
                        }
                        $vetor_prospeccao = mysqli_fetch_array(mysqli_query($con, "select * from prospeccoes where id_prospeccao = '{$vetor_turma_lead['id_prospeccao']}'"));
                        $sql_turma = mysqli_query($con, "select * from turmas_mkt where id_turma = '{$vetor_prospeccao['id_turma']}'");
                        $vetor_turma = mysqli_fetch_array($sql_turma);
                        $sql_curso = mysqli_query($con, "select * from cursos where id_curso = '{$vetor_turma['id_curso']}'");
                        $vetor_curso = mysqli_fetch_array($sql_curso); ?>
                        <br>
                        <?php echo $vetor_curso['nome']; ?>
                        / <?php echo $vetor_curso['sigla']; ?>
                        / <?php echo $vetor_turma['conclusao']; ?>
                        -<?php echo $vetor_turma['semestre']; ?>
                        <br>
                        R$<?php echo $num = number_format($vetor_oportunidades['valor_venda'], 2, ',', '.'); ?>
                        <a href="alteraroportunidade.php?id=<?php echo $vetor_turma_lead['id_turma_lead']; ?>"
                           target="_blank"><i
                                    class="fa fa-edit"></i></a>
                        <?php if (in_array($id_usuario, $usuarios_permitidos)) {
                            if ($vetor_oportunidades['nome'] != null) {
                                $words = explode(" ", $vetor_oportunidades['nome']);
                                $acronym = $words[0][0] . $words[1][0];
                                echo "<style>
                                        span[data-letters=" . $acronym . "]:before{
                                            background:" . $vetor_oportunidades['cor'] . ";
                                        }
                                        </style>";
                                echo "<span data-letters='" . $acronym . "' style='position: static;float:right;margin-top: -10px'></span>";
                            }
                        } ?>
                        <hr style="height:1px; border:none; color:#000; background-color:#000; margin-top: 0px; margin-bottom: 0px;"/>
                        <br>
                    <?php } ?>
                </td>
                <?php
            }
            ?>
        </tr>
        </tbody>
    </table>
</div>
