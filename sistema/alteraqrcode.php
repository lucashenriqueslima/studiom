<?php

include "../includes/conexao.php";
session_start();




$id_turma = $_POST['id_turma'];

$imagemQueVaiDeletada = mysqli_query($con,"select * from qr_convite where turma_fk = '$id_turma'");

    while ($vetor = mysqli_fetch_array($imagemQueVaiDeletada)) {
          //print_r($vetor['imagemQRcode']);
     
        $deleta1 = unlink($vetor['imagem_turma']);
        $deleta2 = unlink($vetor['imagem_brasao']);
        if ($deleta1 & $deleta2) {
            $sql_exclui = "delete FROM qr_convite where turma_fk = '$id_turma'";
            $res2 = mysqli_query($con, $sql_exclui);
        }
}


$formandos = $_POST['lista_nometurma'];


$latitudeColacaoOfc = $_POST['latitudeColacaoOfc'];
$longitudeColacaoOfc = $_POST['longitudeColacaoOfc'];

$latitudeJantar = $_POST['latitudeJantar'];
$longitudeJantar = $_POST['longitudeJantar'];

$longitudeCulto = $_POST['longitudeCulto'];
$latitudeCulto = $_POST['latitudeCulto'];

$longitudeColacao = $_POST['longitudeColacao'];
$latitudeColacao = $_POST['latitudeColacao'];

$longitudeBaile = $_POST['longitudeBaile'];
$latitudeBaile = $_POST['latitudeBaile'];


     //echo "<script> alert('Excluido com sucesso!')</script>";
	 //echo "<script> window.location.href='solenidades_qrcode.php'</script>";



    
    $turma = mysqli_fetch_array(mysqli_query($con, "select ncontrato from turmas where id_turma = '$id_turma'"));
    $pasta_turma = $turma['ncontrato'];
    //echo ($pasta_turma);
    //$diretorio = $SERVER_ROOT.'/studiomfotografia/sistema/arquivos/formandos/'.$pasta_turma.'/';
    $diretorio = $SERVER_ROOT.'/sistema/arquivos/formandos/'.$pasta_turma.'/';
    //echo ($diretorio);
    if (!file_exists($diretorio)) {
        mkdir($diretorio);
       // mkdir($pasta_turma);
    }
   

    $arquivo_brasao = $_FILES['images']['name'][0];
    $tmp_brasao = $_FILES['images']['tmp_name'][0];
    $ext_brasao = strrchr($arquivo_brasao, '.');
    $nomegrava_brasao = 'imagembrasao' . time().uniqid().$ext_brasao;
    $upload_brasao = $diretorio.$nomegrava_brasao;
    move_uploaded_file($tmp_brasao, $upload_brasao);
    $grava_pasta_brasao = "arquivos/formandos/".$pasta_turma."/".$nomegrava_brasao;


    $arquivo_turma = $_FILES['images']['name'][1];
    $tmp_turma = $_FILES['images']['tmp_name'][1];
    $ext_turma = strrchr($arquivo_turma, '.');
    $nomegrava_turma = 'imagemturma' . time().uniqid().$ext_turma;
    $upload_brasao = $diretorio.$nomegrava_turma;
    move_uploaded_file($tmp_turma, $upload_brasao);
    $grava_pasta_turma = "arquivos/formandos/".$pasta_turma."/".$nomegrava_turma;
    





$sql_formandos = mysqli_query($con, "SELECT * FROM formandos WHERE turma = '$id_turma'");

$sql_convite = mysqli_query($con, "SELECT * FROM dados_convite WHERE id_turma = '$id_turma'"); 

$sql_instituicoes = mysqli_query($con, "SELECT * FROM instituicoes as i INNER JOIN turmas as t  on i.id_instituicao = t.id_instituicao and t.id_turma = '$id_turma'");

$sql_turma = mysqli_query($con, "SELECT * FROM turmas WHERE id_turma = '$id_turma'");

$sql_redesociasis = mysqli_query($con, "SELECT * FROM redessociais_turmas WHERE  id_turma = '$id_turma' AND tipo = 'Instagram'");

if (mysqli_num_rows($sql_formandos)>0) {
    
    while($row_formandos = mysqli_fetch_assoc($sql_formandos)){
        $result1= $row_formandos["id_formando"]; 
    } 
    
    $formandos_fk = $result1 ;
    
}
if (mysqli_num_rows($sql_convite)>0) {

    while($row_convite = mysqli_fetch_assoc($sql_convite)){
        $result2= $row_convite["id_dados"]; 
    }   
    
    $dados_convite_fk = $result2;
}
if (mysqli_num_rows($sql_instituicoes)>0) {

    while($row_instituicoes = mysqli_fetch_assoc($sql_instituicoes)){
        $result3= $row_instituicoes["cidade"]; 
        $result4= $row_instituicoes["estado"]; 
        
    }        
    $cidade = $result3;
    $estado = $result4;
}
if (mysqli_num_rows($sql_turma)>0) {
    
    while($row_turma = mysqli_fetch_assoc($sql_turma)){
        $result5= $row_turma["emailcomissao"]; 
    } 
    $emailcomissao = $result5;
}
if (mysqli_num_rows($sql_redesociasis)>0) {
    
    while($row_redesocial = mysqli_fetch_assoc($sql_redesociasis)){
        $result6= $row_redesocial["link"]; 
    } 
    $instagram = $result6;
}

    $sql_verifica_qrconvite = mysqli_query($con, "SELECT * FROM qr_convite WHERE turma_fk = '$id_turma'");
    $sql_idContrato = mysqli_query($con, "SELECT * FROM turmas WHERE id_turma = '$id_turma'");
    
    if (mysqli_num_rows($sql_idContrato)>0) {
        while($row_ncontrato = mysqli_fetch_assoc($sql_idContrato)){
            $result7= $row_ncontrato["ncontrato"]; 
        }
        $id_contrato = $result7;
    }
    if (mysqli_num_rows($sql_verifica_qrconvite)>0) {
        $vetor_qrconvite = mysqli_fetch_array($sql_verifica_qrconvite);
        $sql_inserir = mysqli_query($con, "update qr_convite set longitudeColacaoOfc = '$longitudeColacaoOfc', latitudeColacaoOfc = '$latitudeColacaoOfc', longitudeJantar = '$longitudeJantar', latitudeJantar = '$latitudeJantar', 
        longitudeCulto = '$longitudeCulto', latitudeCulto = '$latitudeCulto', longitudeColacao = '$longitudeColacao', latitudeColacao = '$latitudeColacao', longitudeBaile = '$longitudeBaile', latitudeBaile = '$latitudeBaile', 
        imagem_turma = '$grava_pasta_turma', imagem_brasao = '$grava_pasta_brasao', formandos_fk = '$formandos_fk', dados_convite_fk = '$dados_convite_fk', turma_fk = '$id_turma' 
        where id_qrconvite = '$vetor_qrconvite[id_qrconvite]'");

        $message = 'Alterado com sucesso!';
        echo "<SCRIPT> //not showing me this
                alert('$message')
                window.location.replace('solenidades_qrcode.php');
            </SCRIPT>";
        //header("Location:cadastrar_solenidades.php");
        //echo "já criado";
       // echo "<script type='javascript'>alert('Convite Já existente!');";
    }else {
        
        $sql_inserir = mysqli_query($con, "insert into qr_convite (longitudeColacaoOfc, latitudeColacaoOfc, longitudeJantar, latitudeJantar, longitudeCulto, latitudeCulto, longitudeColacao, latitudeColacao, longitudeBaile, latitudeBaile, imagem_turma, imagem_brasao, formandos_fk, dados_convite_fk, turma_fk) values('$longitudeColacaoOfc','$latitudeColacaoOfc','$longitudeJantar','$latitudeJantar','$longitudeCulto','$latitudeCulto','$longitudeColacao','$latitudeColacao','$longitudeBaile','$latitudeBaile','$grava_pasta_turma', '$grava_pasta_brasao', '$formandos_fk', '$dados_convite_fk', '$id_turma') ");
        
         
            echo "<script> alert('Cadastrado com sucesso!')</script>";
	        echo "<script> window.location.href='solenidades_qrcode.php'</script>";
        
            //header("Location:/teste/qr-code.php?id=".$id_contrato);
            //header("Location:/studiomfotografia/qr-code.php?id=".$id_turma);
            //echo "<script type='javascript'>alert('Convite criado com sucesso!');";
        
    }
    
?>

