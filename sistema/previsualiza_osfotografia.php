<?php
    include "../includes/conexao.php";

    $formando = $_GET['formando']; 

    $sql_atual = mysqli_query($con, "select f.id_formando as id_formando, t.ncontrato as ncontrato, f.id_cadastro as codformando, to2.nome as produto, pip.qtdpaginas as qtdpaginas from pacotes_itens_produtos pip 
                                        left join tipo_opcionais to2 on to2.id_tipo = pip.id_produto 
                                        left join vendas v on v.id_pacote = pip.id_pacote 
                                        left join formandos f on f.id_formando = v.id_formando
                                        left join turmas t on t.id_turma = f.turma 
                                        where f.id_formando = '$formando' order by to2.nome ASC");
                                        
    while ($vetor = mysqli_fetch_array($sql_atual)) {
        if ($vetor['qtdpaginas'] == 0) {
            $vetorprodutos[] = $vetor['produto'];
        }else{
            $vetorprodutos[] = $vetor['produto'].' - '.$vetor['qtdpaginas'].' páginas';
        }
    }

    $quantidade = array_count_values($vetorprodutos); 
    $vetorprodutos = array_unique($vetorprodutos);

    $message = '
    <table id="lang_opt" class="table table-striped table-bordered display"
    style="width:100%; text-align: center; " > 
    <thead>
        <tr>
            <td>Produtos(s)</td>
            <td>Quantidade</td>
            <td>Conferência</td>
        </tr>
    </thead>
    <tbody>';

    foreach ($vetorprodutos as $vetorprodutos) {

        $message .='<tr>
                        <td>'.$vetorprodutos.'</td>
                        <td>'.$quantidade[$vetorprodutos].'</td>
                        <td><input type="checkbox" name="check['.$vetorprodutos.']" ></td>
                    </tr>';

    }

    $message .= '</tbody>
    </table>';

    echo $message;

?>
