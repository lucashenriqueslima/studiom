<?php

include"../includes/conexao.php";


$id_avulsa = $_GET['id'];

$dataatual = date('Y-m-d');
$intervalo = 30;

$sql = mysqli_query($con, "select * from venda_avulsa where id_avulsa = '$id_avulsa'");
$vetor = mysqli_fetch_array($sql);

$sql_venda = mysqli_query($con, "insert into vendas (id_formando, produto, tipo, data, formapag, qtdparcelas, diavencimento, valorvenda, status, aceite, iniciada) VALUES ('$vetor[id_formando]', '$id_avulsa', '3', '$dataatual', '$vetor[formapag]', '$vetor[qtd]', '$vetor[diavencimento]', '$vetor[valor]', '3', '1', '2')");

$id = $con->insert_id;

$sql_duplicata = mysqli_query($con, "insert into duplicatas (id_formando, data, id_venda, valor, status) VALUES ('$vetor[id_formando]', '$dataatual', '$id', '$vetor[valor]', '2')");

$id_duplicata = $con->insert_id;

if($vetor['valorentrada'] == '0.00') {

    if($vetor['qtd'] == 1) { 

        $sql_itens = mysqli_query($con, "insert into duplicatas_faturas (id_duplicata, posicao, data, valor, status, formapag) VALUES ('$id_duplicata', '1', '$vetor[datavencimento]', '$vetor[valor]', '1', '$vetor[formapag]')");

    } else {

    $valorparcela_grava = $vetor['valor'] / $vetor['qtd'];

    $qtdparcelas = $vetor['qtd'];
    $diavencimento = $vetor['diavencimento'];
    $diavencimento1 = $vetor['diavencimento'];

    $data1mensalidade = $vetor['datavencimento'];

        $dataexplode = explode('-', $data1mensalidade);
        $ano = $dataexplode[0];
        $mes = $dataexplode[1];
        $diadata = $dataexplode[2];

        if($diavencimento1 == 30 && $mes == 02) {

        $criardata = $ano.'-'.$mes.'-28';

        } else {

        $criardata = $ano.'-'.$mes.'-'.$diavencimento1;

        }

        $datagerada = $criardata;

        for($i = 1; $i <= $qtdparcelas; $i++) {

            $posicao = $i;

            $sql_itens = mysqli_query($con, "insert into duplicatas_faturas (id_duplicata, posicao, data, valor, status, formapag) VALUES ('$id_duplicata', '$posicao', '$datagerada', '$valorparcela_grava', '1', '$vetor[formapag]')");

            if (!empty($diavencimento1)){

            $dia = $diavencimento1;

            }else{

            $dia = date("d",strtotime($datagerada));

            } 

            $mes = date("m",strtotime($datagerada)) + 1;  
            $ano = date("Y",strtotime($datagerada));

            if ($mes == 13) {

            $mes = 01;  
            $ano = $ano + 1;

            }

            if ($dia == 30 && $mes == 02){

            $datagerada = $ano."-".$mes."-28";

            }else{  

            $datagerada = $ano."-".$mes."-".$dia;

            } 
            
        }
            
  }

} else {

	if($vetor['formapag'] == 4 || $vetor['formapag'] == 13 || $vetor['formapag'] == 17) { 

        $sql_itens = mysqli_query($con, "insert into duplicatas_faturas (id_duplicata, posicao, data, valor, status, formapag) VALUES ('$id_duplicata', '1', '$dataatual', '$vetor[valor]', '1', '$vetor[formapag]')");

    } else {

    $sql_entrada = mysqli_query($con, "insert into duplicatas_faturas (id_duplicata, posicao, data, valor, status, formapag) VALUES ('$id_duplicata', '1', '$dataatual', '$vetor[valorentrada]', '1', '4')");

	$valoraparcelar = $vetor['valor'] - $vetor['valorentrada'];

    $qtdparcelas = $vetor['qtd'] - 1;

	$valorparcela_grava = $valoraparcelar / $qtdparcelas;

	$qtdparcelas = $vetor['qtd'] - 1;
    $diavencimento = $vetor['diavencimento'];
    $diavencimento1 = $vetor['diavencimento'];

    $data1mensalidade = $vetor['datavencimento'];

        $dataexplode = explode('-', $data1mensalidade);
        $ano = $dataexplode[0];
        $mes = $dataexplode[1];
        $diadata = $dataexplode[2];

        if($diavencimento1 == 30 && $mes == 02) {

        $criardata = $ano.'-'.$mes.'-28';

        } else {

        $criardata = $ano.'-'.$mes.'-'.$diavencimento1;

        }

        $datagerada = $criardata;

        for($i = 2; $i <= $vetor['qtd']; $i++) {

            $posicao = $i;

            $sql_itens = mysqli_query($con, "insert into duplicatas_faturas (id_duplicata, posicao, data, valor, status, formapag) VALUES ('$id_duplicata', '$posicao', '$datagerada', '$valorparcela_grava', '1', '$vetor[formapag]')");

            if (!empty($diavencimento1)){

            $dia = $diavencimento1;

            }else{

            $dia = date("d",strtotime($datagerada));

            } 

            $mes = date("m",strtotime($datagerada)) + 1;  
            $ano = date("Y",strtotime($datagerada));

            if ($mes == 13) {

            $mes = 01;  
            $ano = $ano + 1;

            }

            if ($dia == 30 && $mes == 02){

            $datagerada = $ano."-".$mes."-28";

            }else{  

            $datagerada = $ano."-".$mes."-".$dia;

            } 
            
        }

  }

}

echo "<script> window.location.href='geraraceite.php?id=$id'</script>";

?>