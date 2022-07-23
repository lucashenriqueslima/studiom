<?php

include"../includes/conexao.php";


$id_turma = $_GET['id_turma'];
$data = date('Y-m-d');
$vetor_turma = mysqli_fetch_array(mysqli_query($con, "select * from turmas where id_turma = '$id_turma'"));
$sql_formando =  mysqli_query($con, "select * from formandos where turma = '$id_turma'");
while($vetor_formando = mysqli_fetch_array($sql_formando)){
    $verifica_venda = mysqli_query($con, "SELECT * FROM vendas WHERE id_formando = '$vetor_formando[id_formando]' and tipo = '1'");
    if(mysqli_num_rows($verifica_venda) > 0){
        $verifica_convite = mysqli_query($con, "SELECT * FROM convite_personal WHERE id_formando = '$vetor_formando[id_formando]'");
        if (mysqli_num_rows($verifica_convite) == 0) {
            $sql = mysqli_query($con, "insert into convite_personal (id_formando, data, datafinal, status) VALUES ('$vetor_formando[id_formando]', '$data', '$vetor_turma[datafinal]', '1')");
            $id_convite_personal = $con->insert_id;
        }else{
            $convite = mysqli_fetch_array($verifica_convite);
            $id_convite_personal = $convite['id_convite'];
        }

        $sql_tipos_arquivos = mysqli_query($con, "select * from tipos_arquivos_turma where id_turma = '$id_turma'");
        while ($vetor_tipos_arquivos = mysqli_fetch_array($sql_tipos_arquivos)) {
            $sql_consulta = mysqli_query($con, "select * from tipos_arquivos_formando where id_formando = '$vetor_formando[id_formando]' and id_tipo = '$vetor_tipos_arquivos[id_tipo]'");
            if (mysqli_num_rows($sql_consulta) == 0) {
                $sql_tipo = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '$vetor_tipos_arquivos[id_tipo]'");
                $vetor_tipo = mysqli_fetch_array($sql_tipo);
                $nomedapasta = $vetor_turma['ncontrato'] . ' ' . $vetor_formando['id_cadastro'] . ' ' . $vetor_formando['nome'] . ' ' . $vetor_tipo['nome'] . ' ' . $data;
                $pasta = strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomedapasta)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
                mkdir("/home/studioms/public_html/sistema/arquivos/formandos/fotosconvite/$pasta", 0755);
                $sql_grava = mysqli_query($con, "insert into tipos_arquivos_formando (id_formando, id_tipo, pasta) VALUES ('$vetor_formando[id_formando]', '$vetor_tipos_arquivos[id_tipo]', '$pasta')");
            }
            if ($vetor_tipos_arquivos['id_tipo'] > 2) {
	            $sql_consulta = mysqli_query($con, "select * from convite_personal_itens where id_convite = '$id_convite_personal' and id_tipo = '$vetor_tipos_arquivos[id_tipo]'");
	            if (mysqli_num_rows($sql_consulta) == 0) {
		            $sql_itens = mysqli_query($con, "insert into convite_personal_itens (id_convite, id_tipo, qtd) VALUES ('$id_convite_personal', '$vetor_tipos_arquivos[id_tipo]', '$vetor_tipos_arquivos[qtd]')");
	            }
            }
        }
    }
}
die();
?>