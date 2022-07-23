<?php



if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    if ($tipo == 1) {
        cadastraNF();
    }
    if ($tipo == 2) {
        cadastraCG();
    }    
} 

if (isset($_GET['idnf'])) {
    deletaNF();
}

if (isset($_GET['idcg'])) {
    deletaCG();
}



function cadastraNF(){
    include "../includes/conexao.php";
        
        $id_dispositivonf = $_POST['id_dispositivonf'];
        


        $sql_verifica_NF = mysqli_query($con, "SELECT * FROM dispositivos WHERE id_dispositivo = '$id_dispositivonf'");
        $vetor = mysqli_fetch_array($sql_verifica_NF);

        if (($vetor['nfDispositivo'] != null) || ($vetor['nfDispositivo'] != '')) {
            $message = 'Nota Fiscal já criada.';
            echo "<SCRIPT> //not showing me this
                    alert('$message')
                    window.location.replace('cadastro_dispositivo.php');
                </SCRIPT>";
          
        }else {   

            $diretorio = $SERVER_ROOT.'/studiomfotografia/sistema/arquivos/dispositivos/';
            //$diretorio = $SERVER_ROOT.'/sistema/arquivos/dispositivos/';
            
            //echo ($diretorio);
            if (!file_exists($diretorio)) {
                mkdir($diretorio);
            // mkdir($pasta_turma);
            }
        

            $arquivoNF = $_FILES['nf']['name'][0];
            $tmp_NF = $_FILES['nf']['tmp_name'][0];
            $ext_NF = strrchr($arquivoNF, '.');
            $nomegrava_NF = "NotaFiscal_STM".$vetor['id_dispositivo'].$ext_NF;
            $upload_NF = $diretorio.$nomegrava_NF;
            move_uploaded_file($tmp_NF, $upload_NF);
            $grava_pasta_NF = "arquivos/dispositivos/".$nomegrava_NF;
    
            $sql_inserir = "UPDATE dispositivos SET nfDispositivo = '$grava_pasta_NF' WHERE id_dispositivo = '$id_dispositivonf'";
            $stmt = mysqli_prepare($con, $sql_inserir);
            
            
            if (mysqli_stmt_execute($stmt)) {
                # code...
                $message = 'Nota Fiscal inserida.';

                echo "<SCRIPT> //not showing me this
                alert('$message')
                window.location.replace('cadastro_dispositivo.php');
                </SCRIPT>";
            } 
            # code...
        }

}

function deletaNF(){
    include "../includes/conexao.php";

    $id = $_GET[ 'idnf' ];

    $nfDeletada = mysqli_query($con,"SELECT * FROM dispositivos WHERE id_dispositivo= '$id'");

    while ($vetor = mysqli_fetch_array($nfDeletada)) {
        //print_r($vetor['imagemQRcode']);

        $deleta = unlink($vetor['nfDispositivo']);
        if ($deleta) {

            $sql_exclui = "UPDATE dispositivos SET nfDispositivo = '' WHERE id_dispositivo = '$id'";
            $res2 = mysqli_query($con, $sql_exclui);

            if ($res2) {
                
                $res2 = mysqli_query($con, $sql_exclui);
                echo "<script> alert('Excluido com sucesso!')
                window.location.href='cadastro_dispositivo.php'</script>";
            }else {
                
                echo "<script> alert('Arquivo não existe!')
                window.location.href='cadastro_dispositivo.php'</script>";
            }
        }else {
            echo "<script> alert('Arquivo não existe!')
            window.location.href='cadastro_dispositivo.php'</script>";
        }
    }
}

function cadastraCG(){
    include "../includes/conexao.php";
        
        $id_dispositivocg = $_POST['id_dispositivocg'];
        


        $sql_verifica_CG = mysqli_query($con, "SELECT * FROM dispositivos WHERE id_dispositivo = '$id_dispositivocg'");
        $vetor = mysqli_fetch_array($sql_verifica_CG);

        print_r($vetor['garantiaDispositivo']);
        echo "<br>";

        if (($vetor['garantiaDispositivo'] != null) || ($vetor['garantiaDispositivo'] != '')) {
            $message = 'Certificado de Garantia já inserido.';
            echo "<SCRIPT> //not showing me this
                    alert('$message')
                    window.location.replace('cadastro_dispositivo.php');
                </SCRIPT>";
          
        }else {   

            $diretorio = $SERVER_ROOT.'/studiomfotografia/sistema/arquivos/dispositivos/';
            //$diretorio = $SERVER_ROOT.'/sistema/arquivos/dispositivos/';
            
            //echo ($diretorio);
            if (!file_exists($diretorio)) {
                mkdir($diretorio);
            // mkdir($pasta_turma);
            }
        

            $arquivoCG = $_FILES['cg']['name'][0];
            $tmp_CG = $_FILES['cg']['tmp_name'][0];
            $ext_CG = strrchr($arquivoCG, '.');
           // $nomegrava_CG = time().uniqid().$ext_CG;
            $nomegrava_CG = "CertificadoDeGarantia_STM".$vetor['id_dispositivo'].$ext_CG;
            $upload_CG = $diretorio.$nomegrava_CG;
            move_uploaded_file($tmp_CG, $upload_CG);
            $grava_pasta_CG = "arquivos/dispositivos/".$nomegrava_CG;
    
            $sql_inserir = "UPDATE dispositivos SET garantiaDispositivo = '$grava_pasta_CG' WHERE id_dispositivo = '$id_dispositivocg'";
            $stmt = mysqli_prepare($con, $sql_inserir);
            
            
            if (mysqli_stmt_execute($stmt)) {
                # code...
                $message = 'Certificado de Garantia inserido.';

                echo "<SCRIPT> //not showing me this
                alert('$message')
                window.location.replace('cadastro_dispositivo.php');
                </SCRIPT>";
            } 
            # code...
        }
}

function deletaCG(){
    include "../includes/conexao.php";

    $id = $_GET[ 'idcg' ];

    $nfDeletada = mysqli_query($con,"SELECT * FROM dispositivos WHERE id_dispositivo= '$id'");

    while ($vetor = mysqli_fetch_array($nfDeletada)) {
        //print_r($vetor['imagemQRcode']);

        $deleta = unlink($vetor['garantiaDispositivo']);
        if ($deleta) {

            $sql_exclui = "UPDATE dispositivos SET garantiaDispositivo = '' WHERE id_dispositivo = '$id'";
            $res2 = mysqli_query($con, $sql_exclui);

            if ($res2) {
                
                $res2 = mysqli_query($con, $sql_exclui);
                echo "<script> alert('Excluido com sucesso!')
                window.location.href='cadastro_dispositivo.php'</script>";
            }else {
                
                echo "<script> alert('Arquivo não existe!')
                window.location.href='cadastro_dispositivo.php'</script>";
            }
        }else {
            echo "<script> alert('Arquivo não existe!')
            window.location.href='cadastro_dispositivo.php'</script>";
        }
    }
}
?>