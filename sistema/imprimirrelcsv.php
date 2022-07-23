<?php
include "../includes/conexao.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Balanço dos Convites Gráficos</title>
    <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
</head>
<body onload="ExportToExcel('xlsx');">
<?php
							$id_turma = $_GET['id_turma'];
							$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$id_turma'");
							$vetor_turma = mysqli_fetch_array($sql_turma);
							$sql_produtos_turma = mysqli_query($con, "select * from produtos_turma where id_turma = '$id_turma'");
							$vetor_produtos_turma = mysqli_fetch_array($sql_produtos_turma);
							$sql_itens = mysqli_query($con, "select * from produtos_turma_item where id_produto = '$vetor_produtos_turma[id_produto]' order by id_item ASC");
							$sql_itens2 = mysqli_query($con, "select * from produtos_turma_item where id_produto = '$vetor_produtos_turma[id_produto]' order by id_item ASC");
							$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_turma[id_instituicao]'");
							$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
							$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_turma[curso]'");
							$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
							?>


									<table id="tbl_exporttable_to_xls" class="table table-bordered table-striped">
                                        <thead>
                                        <tr bgcolor="#e8e8e8">
                                            
                                            <th width="15%">Formando</th>
                                            <th>Data de Vencimento</th>
                                            <th>Data 1° Vencimento</th>
                                            <th>Parcelas</th>
                                            <th>Forma de Pagamento</th>
                                            <th>Valor:</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $sql_atual = mysqli_query($con, "select * from formandos where turma = '{$id_turma}' order by nome ASC");

                                        $i = 1;

                                        while ($vetor_atual=mysqli_fetch_array($sql_atual)) {
                                            $sql_venda = mysqli_query($con, "select *,SUM(valorvenda) as total from vendas where id_formando = '{$vetor_atual['id_formando']}' and tipo = '1' and status <> '4' and iniciada = '2' order by id_venda");
                                            $vetor_venda = mysqli_fetch_array($sql_venda);

                                            $sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '{$vetor_venda['formapag']}'");
                                            $vetor_forma = mysqli_fetch_array($sql_forma);

                                            $sql_vencimentos = mysqli_query($con, "select a.id_duplicata, a.id_venda, b.id_duplicata, b.data, b.posicao from duplicatas a, duplicatas_faturas b where a.id_duplicata = b.id_duplicata and a.id_venda = '{$vetor_venda['id_venda']}' order by b.posicao ASC limit 0,1");
                                            $vetor_vencimento = mysqli_fetch_array($sql_vencimentos);

                                            ?>
                                            <tr>
                                                
                                                <td><?php echo $vetor_turma['ncontrato']; ?>-<?php echo $vetor_atual['id_cadastro']; ?> - <?php echo $vetor_atual['nome']; ?></td>
                                                <td><?php echo $vetor_venda['diavencimento']; ?></td>
                                                <td><?php if($vetor_vencimento['data'] == NULL) { } else { echo date('d/m/Y', strtotime($vetor_vencimento['data'])); } ?></td>
                                                <td><?php echo $vetor_venda['qtdparcelas']; ?></td>
                                                <td><?php echo $vetor_forma['nome']; ?></td>
                                                <td>R$ <?php echo $num = number_format($vetor_venda['total'],2,',','.'); ?></td>
                                                <td><?php if($vetor_venda['duplicata'] == 1) { ?><a href="confirmarcompra.php?id=<?php echo $vetor_venda['id_venda']; ?>"><i class="fas fa-check-circle" title="Confirmar Venda"></i></a><?php } ?></td>
                                            </tr>
                                            <?php  } ?>
                                        </tbody>
										<tfoot>
                                        <tr >
                                            
                                            <th width="15%"></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
	                                        <?php
	                                        $vetor_soma_qtd2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(v.valorvenda) as total from vendas v
												left join formandos f on f.id_formando = v.id_formando
												left join turmas t on t.id_turma = f.turma
												where t.id_turma = '{$id_turma}' and v.tipo = '1' and v.status <> '4' and iniciada = '2'"));
	                                        ?>
                                            <th>Total: R$ <?php echo $num = number_format($vetor_soma_qtd2['total'],2,',','.'); ?></th>
                                            <th></th>
                                        </tr>
										</tfoot>
                                    </table>



<br>
<br>
<!-- <button id="download-button">Baixar CSV</button>-->
<!--<button onclick="ExportToExcel('xlsx')">Exportar em XLS</button>-->
</body>
</html>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<script>
	function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tbl_exporttable_to_xls');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Gestão Parcial da Venda - Contrato <?= $vetor_turma['ncontrato']?>.' + (type || 'xlsx')));
    }
</script>
<script>
/**function htmlToCSV(html, filename) {
	var data = [];
	var rows = document.querySelectorAll("table tr");
			
	for (var i = 0; i < rows.length; i++) {
		var row = [], cols = rows[i].querySelectorAll("td, th");
				
		for (var j = 0; j < cols.length; j++) {
		    row.push(cols[j].innerText);
        }
		        
		data.push(row.join(",")); 		
	}

	downloadCSVFile(data.join("\n"), filename);
}*/
</script>

<script>
/**function downloadCSVFile(csv, filename) {
	var csv_file, download_link;

	csv_file = new Blob([csv], {type: "text/csv"});

	download_link = document.createElement("a");

	download_link.download = filename;

	download_link.href = window.URL.createObjectURL(csv_file);

	download_link.style.display = "none";

	document.body.appendChild(download_link);

	download_link.click();
}*/
</script>

<script>
/**document.getElementById("download-button").addEventListener("click", function () {
	var html = document.querySelector("table").outerHTML;
	htmlToCSV(html, "Gestão Parcial da Venda - Contrato <?//= $vetor_turma['ncontrato']?>.csv");
});*/
</script>