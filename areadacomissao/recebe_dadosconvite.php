<?php

include "../includes/conexao.php";

	 
session_start();

$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
$res_cadastro = mysqli_query($con, $sql_cadastro);
$vetor_cadastro = mysqli_fetch_array($res_cadastro);


//$jantardospais = addslashes($_POST['jantardospais']);
$sql_dados_qrconvite_jantardospais = mysqli_query($con, "select * from dados_evento_qrconvite  where id_turma_fk = '$vetor_cadastro[turma]' and id_categoriaEvento_fk = 13 ");
$vetor_dados_qrconvite_jantardospais = mysqli_fetch_array($sql_dados_qrconvite_jantardospais);
$jantardospais = '';
if (mysqli_num_rows($sql_dados_qrconvite_jantardospais) > 0) {
    $jantardospais = $vetor_dados_qrconvite_jantardospais['dataQrconvite']." as ".$vetor_dados_qrconvite_jantardospais['horainicio']." - ".$vetor_dados_qrconvite_jantardospais['nomeLocal']." (".$vetor_dados_qrconvite_jantardospais['endereco']." - ".$vetor_dados_qrconvite_jantardospais['cidade']." - ".$vetor_dados_qrconvite_jantardospais['estado'].")";
}

//$colacaograu = addslashes($_POST['colacaograu']);
$sql_dados_qrconvite_colacaograu = mysqli_query($con, "select * from dados_evento_qrconvite where id_turma_fk = '$vetor_cadastro[turma]' and id_categoriaEvento_fk = 12 ");
$vetor_dados_qrconvite_colacaograu = mysqli_fetch_array($sql_dados_qrconvite_colacaograu);
$colacaograu = ' ';
if (mysqli_num_rows($sql_dados_qrconvite_colacaograu) > 0) {
    $colacaograu = $vetor_dados_qrconvite_jantardospais['dataQrconvite']." as ".$vetor_dados_qrconvite_jantardospais['horainicio']." - ".$vetor_dados_qrconvite_jantardospais['nomeLocal']." (".$vetor_dados_qrconvite_jantardospais['endereco']." - ".$vetor_dados_qrconvite_jantardospais['cidade']." - ".$vetor_dados_qrconvite_jantardospais['estado'].")";
}

//$cultoecumenico = addslashes($_POST['cultoecumenico']);
$sql_dados_qrconvite_cultoecumenico = mysqli_query($con, "select * from dados_evento_qrconvite where id_turma_fk = '$vetor_cadastro[turma]' and id_categoriaEvento_fk = 9 ");
$vetor_dados_qrconvite_cultoecumenico = mysqli_fetch_array($sql_dados_qrconvite_cultoecumenico);
$cultoecumenico = ' ';
if (mysqli_num_rows($sql_dados_qrconvite_cultoecumenico) > 0) {
    $cultoecumenico = $vetor_dados_qrconvite_jantardospais['dataQrconvite']." as ".$vetor_dados_qrconvite_jantardospais['horainicio']." - ".$vetor_dados_qrconvite_jantardospais['nomeLocal']." (".$vetor_dados_qrconvite_jantardospais['endereco']." - ".$vetor_dados_qrconvite_jantardospais['cidade']." - ".$vetor_dados_qrconvite_jantardospais['estado'].")";
}

//$bailedeformatura = addslashes($_POST['bailedeformatura']);
$sql_dados_qrconvite_bailedeformatura = mysqli_query($con, "select * from dados_evento_qrconvite where id_turma_fk = '$vetor_cadastro[turma]' and id_categoriaEvento_fk = 14 ");
$vetor_dados_qrconvite_bailedeformatura = mysqli_fetch_array($sql_dados_qrconvite_bailedeformatura);
$bailedeformatura = ' ';
if (mysqli_num_rows($sql_dados_qrconvite_bailedeformatura) > 0) {
    $bailedeformatura = $vetor_dados_qrconvite_jantardospais['dataQrconvite']." as ".$vetor_dados_qrconvite_jantardospais['horainicio']." - ".$vetor_dados_qrconvite_jantardospais['nomeLocal']." (".$vetor_dados_qrconvite_jantardospais['endereco']." - ".$vetor_dados_qrconvite_jantardospais['cidade']." - ".$vetor_dados_qrconvite_jantardospais['estado'].")";
}

$mensageminicial = addslashes($_POST['mensageminicial']);
//$patrono = addslashes($_POST['patrono']);
//$parainfo = addslashes($_POST['parainfo']);
//$professores = addslashes($_POST['professores']);
//$nometurma = addslashes($_POST['nometurma']);
$adeus = addslashes($_POST['adeus']);
$aospais = addslashes($_POST['aospais']);
$aospaisausentes = addslashes($_POST['aospaisausentes']);
$afamilia = addslashes($_POST['afamilia']);
$aosqueamamos = addslashes($_POST['aosqueamamos']);
$aosamigos = addslashes($_POST['aosamigos']);
$aosmestres = addslashes($_POST['aosmestres']);
$aosfuncionarios = addslashes($_POST['aosfuncionarios']);
$aospacientes = addslashes($_POST['aospacientes']);
$aocadaver = addslashes($_POST['aocadaver']);
$juramento = addslashes($_POST['juramento']);
$mensagemcomissao = addslashes($_POST['mensagemcomissao']);
$mensagemfinal = addslashes($_POST['mensagemfinal']);

$diretorio = "../sistema/arquivos/";

$logoinstituicao = $_FILES['logoinstituicao']['name'];  
$tmp = $_FILES['logoinstituicao']['tmp_name'];
$ext = strrchr($logoinstituicao, '.'); 
//$imagemlogoinstituicao = time().uniqid(md5()).$ext;
$imagemlogoinstituicao = time().uniqid().$ext;
$uploadlogoinstituicao = $diretorio.$imagemlogoinstituicao;
move_uploaded_file($tmp, $uploadlogoinstituicao);

$logocerimonial = $_FILES['logocerimonial']['name'];  
$tmplogocerimonial = $_FILES['logocerimonial']['tmp_name'];



$sql_dados_qrconvite_bailedeformatura = mysqli_query($con, "select * from dados_evento_qrconvite where id_turma_fk = '$vetor_cadastro[turma]' and id_categoriaEvento_fk = 14 ");
$vetor_dados_qrconvite_bailedeformatura = mysqli_fetch_array($sql_dados_qrconvite_bailedeformatura);



 
        $x = $_POST['nome'];   
        $i = 0;
        foreach ($x as $key) {
                    
            $nome = $_POST['nome'][$i];
            $titulo = $_POST['titulo'][$i];
            $corpo = $_POST['corpo'][$i];

            $verifica_homenageado = mysqli_query($con, "select * from homenageados where id_turma_fk = '$vetor_cadastro[turma]' and nome_homenageado = '$nome'  and corpoHomenageados = '$corpo'");
            
            if (mysqli_num_rows($verifica_homenageado) == 0){
                if ($nome != '') {
                
                    $sql_rede = mysqli_query($con, "insert into homenageados (corpoHomenageados, titulo, nome_homenageado, id_turma_fk) VALUES ('$corpo', '$titulo', '$nome', '$vetor_cadastro[turma]')");
                    $i++;
                    
                   
                }
            }
        }

        $y = $_POST['nomeAdm'];   
        $j = 0;
        foreach ($y as $key) {
                    
            $nomeAdm = $_POST['nomeAdm'][$j];
            $tituloAdm = $_POST['tituloAdm'][$j];
            $corpoAdm = $_POST['corpoAdm'][$j];

            
            
            $verifica_corpoAdministrativo = mysqli_query($con, "select * from corpoadministrativo where id_turma_fk = '$vetor_cadastro[turma]' and nome_corpoAdministrativo = '$nome'");
            
            if (mysqli_num_rows($verifica_corpoAdministrativo) == 0){
                if ($nomeAdm != '') {
                  
                    $sql_insere = mysqli_query($con, "insert into corpoadministrativo (corpoAdministrativo,  nome_corpoAdministrativo, titulo, id_turma_fk) VALUES ('$corpoAdm', '$nomeAdm', '$tituloAdm', '$vetor_cadastro[turma]')");
                    $j++;
                    
                }
            }
        }
        
        $sql_nomeListaProfessores =  mysqli_query($con, "select * from homenageados  where id_turma_fk = '$vetor_cadastro[turma]' and (corpoHomenageados = 'Professor' or corpoHomenageados = 'Professora')");
        $vetor_nomeListaProfessores = mysqli_fetch_array($sql_nomeListaProfessores);
        
        //print_r($vetor_nomeListaProfessores[0]);
        //echo $sql_nomeListaProfessores->fetch_array();

        if ($vetor_nomeListaProfessores > 0) {
            $nomeListaProfessores = '';
            while($row_nomeListaProfessores = mysqli_fetch_assoc($sql_nomeListaProfessores)){ 
                $row = explode("; ",$row_nomeListaProfessores["nome_homenageado"]);
                
                foreach ($row as $value) {
                    $nomeListaProfessores .= $value.'; ';
                }
            }
            $nomeListaProfessores .=  $vetor_nomeListaProfessores[2]."; ".$nomeListaProfessoress;
        }
        

        $sql_nomeListaPatrono = mysqli_query($con, "select * from homenageados  where id_turma_fk = '$vetor_cadastro[turma]' and (corpoHomenageados = 'Patrono' or corpoHomenageados = 'Patrona' or  corpoHomenageados = 'Patronesse')");
        $vetor_nomeListaPatrono = mysqli_fetch_array($sql_nomeListaPatrono);
        
        if ($vetor_nomeListaPatrono > 0) {
            $nomeListaPatrono = ' ';
            while($row_nomeListaPatrono = mysqli_fetch_assoc($sql_nomeListaPatrono)){ 
                $row = explode("; ",$row_nomeListaPatrono["nome_homenageado"]);
                
                foreach ($row as $value) {
                    $nomeListaPatronos .= $value.'; ';
                }
            }
            $nomeListaPatrono =  $vetor_nomeListaPatrono[2]."; ".$nomeListaPatronos;
        }
        
        
       
        
        
        $sql_nomeListaParaninfo = mysqli_query($con, "select * from homenageados  where id_turma_fk = '$vetor_cadastro[turma]' and (corpoHomenageados = 'Paraninfo' or corpoHomenageados = 'Paraninfa' )");
        $vetor_nomeListaParaninfo = mysqli_fetch_array($sql_nomeListaParaninfo);
        
        if ($vetor_nomeListaParaninfo > 0) {
            $nomeListaParaninfo = '';
            while($row_nomeListaParaninfo = mysqli_fetch_assoc($sql_nomeListaParaninfo)){ 
                $row = explode("; ",$row_nomeListaParaninfo["nome_homenageado"]);
                
                foreach ($row as $value) {
                    $nomeListaParaninfos .= $value.'; ';
                }
            }
            $nomeListaParaninfo =  $vetor_nomeListaParaninfo[2]."; ".$nomeListaParaninfos;
        }
        
        
        
        
        $sql_nomeListaNometurma = mysqli_query($con, "select * from homenageados  where id_turma_fk = '$vetor_cadastro[turma]' and corpoHomenageados = 'Nome da Turma'");
        $vetor_nomeListaNometurma = mysqli_fetch_array($sql_nomeListaNometurma);
        
        if ($vetor_nomeListaNometurma > 0) {
            $nomeListaNometurma = '';
            while($row_nomeListaNometurma = mysqli_fetch_assoc($sql_nomeListaNometurma)){ 
                $row = explode("; ",$row_nomeListaNometurma["nome_homenageado"]);
                
                foreach ($row as $value) {
                    $nomeListaNometurmas .= $value.'; ';
                }
            }
            $nomeListaNometurma =  $vetor_nomeListaNometurma[2]."; ".$nomeListaNometurmas;
        }
    
    if(!empty($logocerimonial)) {

        $extlogocerimonial = strrchr($logocerimonial, '.'); 
        //$imagemlogocerimonial = time().uniqid(md5()).$extlogocerimonial;
        $imagemlogocerimonial = time().uniqid().$extlogocerimonial;
        $uploadlogocerimonial = $diretorio.$imagemlogocerimonial;
        move_uploaded_file($tmplogocerimonial, $uploadlogocerimonial);
        
        }
        
        $empresafotografica = $_FILES['empresafotografica']['name'];  
        $tmpempresafotografica = $_FILES['empresafotografica']['tmp_name'];
        
        if(!empty($empresafotografica)) {
        
        $extempresafotografica = strrchr($empresafotografica, '.'); 
        //$imagemempresafotografica = time().uniqid(md5()).$extempresafotografica;
        $imagemempresafotografica = time().uniqid().$extempresafotografica;
        $uploadempresafotografica = $diretorio.$imagemempresafotografica;
        move_uploaded_file($tmpempresafotografica, $uploadempresafotografica);
        
        }
        
        $outra = $_FILES['outra']['name'];  
        $tmpoutra = $_FILES['outra']['tmp_name'];
        
        if(!empty($outra)) {
        
        $extoutra = strrchr($outra, '.'); 
        //$imagemoutra = time().uniqid(md5()).$extoutra;
        $imagemoutra = time().uniqid().$extoutra;
        $uploadoutra = $diretorio.$imagemoutra;
        move_uploaded_file($tmpoutra, $uploadoutra);
        
        }
        
        $sql_consulta = mysqli_query($con, "select * from dados_convite where id_turma = '$vetor_cadastro[turma]'");
        
        if(mysqli_num_rows($sql_consulta) == 0) {
        
            $sql_grava = mysqli_query($con, "insert into dados_convite (id_turma, jantardospais, colacaograu, cultoecumenico, bailedeformatura, mensageminicial, patrono, parainfo, professores, nometurma, adeus, aospais, aospaisausentes, afamilia, aosqueamamos, aosamigos, aosmestres, aosfuncionarios, aospacientes, aocadaver, juramento, mensagemcomissao, mensagemfinal, logoinstituicao, logocerimonial, empresafotografica, outra) VALUES ('$vetor_cadastro[turma]', '$jantardospais', '$colacaograu', '$cultoecumenico', '$bailedeformatura', '$mensageminicial', '$nomeListaPatrono', '$nomeListaParaninfo', '$nomeListaProfessores', '$nomeListaNometurma', '$adeus', '$aospais', '$aospaisausentes', '$afamilia', '$aosqueamamos', '$aosamigos', '$aosmestres', '$aosfuncionarios', '$aospacientes', '$aocadaver', '$juramento', '$mensagemcomissao', '$mensagemfinal', '$imagemlogoinstituicao', '$imagemlogocerimonial', '$imagemempresafotografica', '$imagemoutra')");
        
        } else {
        
            $sql_grava = mysqli_query($con, "update dados_convite SET jantardospais='$jantardospais', colacaograu='$colacaograu', cultoecumenico='$cultoecumenico', bailedeformatura='$bailedeformatura', mensageminicial='$mensageminicial', patrono='$nomeListaPatrono', parainfo='$nomeListaParaninfo', professores='$nomeListaProfessores', nometurma='$nomeListaNometurma', adeus='$adeus', aospais='$aospais', aospaisausentes='$aospaisausentes', afamilia='$afamilia', aosqueamamos='$aosqueamamos', aosamigos='$aosamigos', aosmestres='$aosmestres', aosfuncionarios='$aosfuncionarios', aospacientes='$aospacientes', aocadaver='$aocadaver', juramento='$juramento', mensagemcomissao='$mensagemcomissao', mensagemfinal='$mensagemfinal', logoinstituicao='$imagemlogoinstituicao', logocerimonial='$imagemlogocerimonial', empresafotografica='$imagemempresafotografica', outra='$imagemoutra' where id_turma = '$vetor_cadastro[turma]'");
        
        }


    echo"<script language=\"JavaScript\">location.href=\"dadosconvite.php\";</script>";

?>