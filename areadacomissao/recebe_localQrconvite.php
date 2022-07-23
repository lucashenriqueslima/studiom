<?php

    include "../includes/conexao.php";

	 
	 session_start();

	if($_SESSION['id_formando'] == NULL && $_SESSION['comissao'] == NULL) {
	
        echo"<script language=\"JavaScript\">
        location.href=\"inicio.php\";
        </script>";
	
	} else {

	if($_SESSION['comissao'] != 2) {

        echo"<script language=\"JavaScript\">
        location.href=\"inicio.php\";
        </script>";

	}

        $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));

        $id_turma = $vetor_cadastro['turma'];
        
        $id_categoria = $_GET['evento'];

        $sql_local = mysqli_query($con, "select * from locais l inner join eventos_turma et on et.id_turma = '$id_turma' and et.id_local = l.id_local and et.id_categoria = '$id_categoria'");
        $vetor_local = mysqli_fetch_array($sql_local);
        
        $sql_eventos_turma = mysqli_query($con, "select * from eventos_turma et inner join locais l on et.id_turma = '$id_turma' and et.id_local = l.id_local and et.id_categoria = '$id_categoria'");
        $vetor_eventos_turma = mysqli_fetch_array($sql_eventos_turma);
        
        $id_categoria_consulta = $vetor_local['id_categoria'];
        $tipo_local = $vetor_local['tipo'];

        $local = $_POST['nome'];       
        $cep = $_POST['cep'];       
        $endereco = $_POST['endereco'];       
        $complemento = $_POST['complemento'];       
        $bairro = $_POST['bairro'];       
        $cidade = $_POST['cidade'];       
        $estado = $_POST['estado'];       
        $data = $_POST['data'];       
        $horainicio = $_POST['horainicio'];       
        $horafim = $_POST['horafim'];       
        $observacoes = $_POST['observacoes'];   
        $latitudeEvento = $_POST['latitudeEvento'];
        $longitudeEvento = $_POST['longitudeEvento'];

        $sql_turma = mysqli_fetch_assoc(mysqli_query($con,"select tipo from turmas where id_turma = '$id_turma'"));
        echo "teste: ".$sql_turma['tipo'];

        if ($sql_turma['tipo'] != 2) {
                $id_evento_turma = $_POST['id_evento_turma'];
        }
       

        $acao = $_GET['acao'];

        $sql_verifica = mysqli_query($con,"select * from dados_evento_qrconvite where id_turma_fk = '$id_turma' and id_categoriaEvento_fk = '$id_categoria'");
        

        if (mysqli_num_rows($sql_verifica) > 0) {
                if ($acao == 1) {
                        $sql = mysqli_query($con, "update dados_evento_qrconvite set nomeLocal = '$local', cep = '$cep', endereco = '$endereco', complemento = '$complemento', 
                        bairro = '$bairro', cidade = '$cidade', estado = '$estado', dataQrconvite = '$data', horainicio = '$horainicio', horafim = '$horafim', 
                        observacoes = '$observacoes', latitudeEvento = '$latitudeEvento', longitudeEvento = '$longitudeEvento'
                        where id_turma_fk = '$id_turma' and id_categoriaEvento_fk = '$id_categoria' ");
                        
                        echo "<script> alert('Evento alterado com sucesso!')</script>";
                        echo "<script> window.location.href='dadosconvite.php'</script>";
                }else {
                        echo "<script> alert('Evento já cadastrado!')</script>";
                        echo "<script> window.location.href='dadosconvite.php'</script>";
                
                }
                
        }else {
                if ($sql_turma['tipo'] != 2) {              
                        $sql = mysqli_query($con, "insert into dados_evento_qrconvite(nomeLocal, cep, endereco, complemento, bairro, cidade, estado, dataQrconvite, horainicio, horafim, observacoes, id_local_fk, id_evento_turma_fk, id_categoriaEvento_fk, id_turma_fk, latitudeEvento, longitudeEvento, id_evento_turma_lista_fk) VALUES ('{$local}', '{$cep}', '{$endereco}', '{$complemento}', '{$bairro}', '{$cidade}', '{$estado}', '{$data}', '{$horainicio}', '{$horafim}', '{$observacoes}', '{$vetor_local['id_local']}', '{$vetor_eventos_turma['id_evento']}', '{$id_categoria}', '{$id_turma}', '{$latitudeEvento}', '{$longitudeEvento}', '{$id_evento_turma}')");
                        $sql_staus_evento = mysqli_query($con, "update eventos_turma_lista set status = 1 where id_evento_turma = $id_evento_turma");
                }else {
                        $sql = mysqli_query($con, "insert into dados_evento_qrconvite(nomeLocal, cep, endereco, complemento, bairro, cidade, estado, dataQrconvite, horainicio, horafim, observacoes, id_local_fk, id_evento_turma_fk, id_categoriaEvento_fk, id_turma_fk, latitudeEvento, longitudeEvento) VALUES ('{$local}', '{$cep}', '{$endereco}', '{$complemento}', '{$bairro}', '{$cidade}', '{$estado}', '{$data}', '{$horainicio}', '{$horafim}', '{$observacoes}', '{$vetor_local['id_local']}', '{$vetor_eventos_turma['id_evento']}', '{$id_categoria}', '{$id_turma}', '{$latitudeEvento}', '{$longitudeEvento}')");
                }
                echo "<script> alert('Cadastrado com sucesso!')</script>";
                echo "<script> window.location.href='dadosconvite.php'</script>";
        }
/***
        $sql_verifica_dados_evento = mysqli_query($con,"select * from dados_convite where id_turma = '$id_turma'");
        $vetor_dados_evento = mysqli_fetch_array($sql_verifica_dados_evento);
        $sql_verifica_dados_qrconvite = mysqli_query($con,"select * from dados_evento_qrconvite where id_turma_fk = '$id_turma'");
        $vetor_dados_qrconvite = mysqli_fetch_array($sql_verifica_dados_qrconvite);

        if (mysqli_num_rows($sql_verifica_dados_evento) > 0) {
                if ($vetor_dados_qrconvite['id_dados_convite_fk'] == 0) {

                        $sql = mysqli_query($con, "insert  into dados_evento_qrconvite(id_dados_convite_fk) value ('{$vetor_dados_evento['id_turma']}')");
                }
        }

*/

        
        
}
?>