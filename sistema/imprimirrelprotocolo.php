<?php

	 include"../includes/conexao.php";


?>
<!DOCTYPE html>
<html>
<head>
	<title>Relação de Entrega dos Convites Gráficos</title>
	<link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
</head>
<body>

<font size="1px">
<table width="100%">
  <tr>
    <td width="1%"></td>
    <td><?php

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
            
            <table width="100%">
              <tr>
                <td width="50%" valign="top" align="left"><img src="imgs/logo.png" width="120px"></td>
                <td width="50%" valign="top" align="right">
                (62)3218-3476
                <br>
                Rua 93, 296, Qd. F-14, Lt. 36
                <br>
                St. Sul - Goiânia-GO Cep: 74083-120
                <br>
                financeiro@studiomfotografia.com.br
                </td>
              </tr>
            </table>
</font>
            <div align="center">
            
            <font size="2px"><strong><?php echo $vetor_turma['ncontrato']; ?> - <?php echo $vetor_curso_inicio['nome']; ?> <?php echo $vetor_turma['ano']; ?> <?php echo $vetor_instituicao_inicio['nome']; ?></strong></font>
            </div>
            <font size="1px">

            <br>

            <br>
            <br>

            <table width="100%" BORDER="1" style="border-collapse: collapse">
                <thead>
                <tr bgcolor="#e8e8e8">
                  <th width="1%">Item</th>
                  <th width="20%">Formando</th>
                  <?php 

                  while($vetor_itens = mysqli_fetch_array($sql_itens)) {

                  $sql_nome_produto = mysqli_query($con, "select * from tipos_produtos where id_tipo = '$vetor_itens[id_tipo]'");
                  $vetor_nome_produto = mysqli_fetch_array($sql_nome_produto); 

                  ?>
                  <th width="5%"><?php echo $vetor_nome_produto['nome']; ?></th>
                  <?php } ?>
                  <th width="8%">Data</th>
                  <th width="15%">Assinatura</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                          
                  $sql_atual = mysqli_query($con, "select * from formandos where turma = '$id_turma' order by nome ASC");

                  $i = 1;
                
                  while ($vetor_atual=mysqli_fetch_array($sql_atual)) {

                  $sql_itens1 = mysqli_query($con, "select * from produtos_turma_item where id_produto = '$vetor_produtos_turma[id_produto]' order by id_item ASC");

                  $sql_venda = mysqli_query($con, "select * from vendas where id_formando = '$vetor_atual[id_formando]' order by id_venda DESC limit 0,1");
                  $vetor_venda = mysqli_fetch_array($sql_venda);

                  $sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '$vetor_venda[formapag]'");
                  $vetor_forma = mysqli_fetch_array($sql_forma);

                  $sql_vencimentos = mysqli_query($con, "select a.id_duplicata, a.id_venda, b.id_duplicata, b.data, b.posicao from duplicatas a, duplicatas_faturas b where a.id_duplicata = b.id_duplicata and a.id_venda = '$vetor_venda[id_venda]' order by b.posicao ASC limit 0,1");
                  $vetor_vencimento = mysqli_fetch_array($sql_vencimentos);
                
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $vetor_atual['nome']; ?></td>
                  <?php 

                  while($vetor_itens1 = mysqli_fetch_array($sql_itens1)) {

                  $sql_soma_qtd = mysqli_query($con, "SELECT SUM(b.qtd) as total FROM vendas a, itens_venda_individual b where a.id_venda = b.id_venda and a.id_formando = '$vetor_atual[id_formando]' and b.id_item = '$vetor_itens1[id_item]'");
                  $vetor_soma_qtd = mysqli_fetch_array($sql_soma_qtd); 

                  ?>
                  <td><?php echo $vetor_soma_qtd['total']; ?></td>
                  <?php 

                  } 

                  $sql_soma_valor = mysqli_query($con, "SELECT SUM(a.valorvenda) as total FROM vendas where id_formando = '$vetor_atual[id_formando]'");
                  $vetor_soma_valor = mysqli_fetch_array($sql_soma_valor);

                  ?>
                  <td></td>
                  <td></td>
                </tr>
                <?php $i++; } ?>
                </tbody>
              </table>
              </font></td>
    <td width="1%"></td>
  </tr>
</table>
            
</body>
</html>
<script type="text/javascript">
<!--
        print();
-->
</script>