<?php

include "../includes/conexao.php";
session_start();

$id_contrato = $_POST['ncontratoQRcode']; 

$pasta_turma = $id_contrato;
        //echo ($pasta_turma);
        //$diretorio = $SERVER_ROOT.'/studiomfotografia/sistema/arquivos/formandos/'.$pasta_turma.'/';
        $diretorio = $SERVER_ROOT.'/sistema/arquivos/formandos/'.$pasta_turma.'/';
        
        //echo ($diretorio);
        if (!file_exists($diretorio)) {
            mkdir($diretorio);
           // mkdir($pasta_turma);
        }
       

        $arquivo_QRcode = $_FILES['images']['name'][0];
        $tmp_QRcode = $_FILES['images']['tmp_name'][0];
        $ext_QRcode = strrchr($arquivo_QRcode, '.');
        $nomegrava_QRcode = 'imagemQRcode' . time().uniqid().$ext_QRcode;
        $upload_QRcode = $diretorio.$nomegrava_QRcode;
        move_uploaded_file($tmp_QRcode, $upload_QRcode);
        $grava_pasta_QRcode = "arquivos/formandos/".$pasta_turma."/".$nomegrava_QRcode;


        $sql_verifica_QRcode = mysqli_query($con, "SELECT * FROM imagem_QRcode WHERE ncontrato = '$id_contrato'");

        if (mysqli_num_rows($sql_verifica_QRcode)>0) {
            $message = 'QR-code já criado.';
            echo "<SCRIPT> //not showing me this
                    alert('$message')
                    window.location.replace('solenidades_qrcode.php');
                </SCRIPT>";
            //header("Location:cadastrar_solenidades.php");
            //echo "já criado";
            //echo "<script type='javascript'>alert('Convite Já existente!');";
        }else {   
    
            $sql_inserir = mysqli_query($con,"insert into imagem_QRcode (imagemQRcode, ncontrato) values('$grava_pasta_QRcode','$id_contrato')");

            $message = 'QR-code inserido.';

            echo "<SCRIPT> //not showing me this
            alert('$message')
            window.location.replace('solenidades_qrcode.php');
            </SCRIPT>";
        
            # code...
        }



?>