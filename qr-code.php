<!--

=========================================================
* Gaia Bootstrap Template - v1.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/gaia-bootstrap-template
* Licensed under MIT (https://github.com/creativetimofficial/gaia-bootstrap-template/blob/master/LICENSE.md)
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<?php

include "includes/conexao.php";
session_start();
    
    if (isset($_GET['contrato']) && !empty($_GET['contrato'])) {
        $id_contrato = $_GET['contrato'] ;
    }else {
        $id_contrato = $_GET['id'] ;
    }
    //$id_turma = $_GET['turma'] ;
    //$id_qrconvite= $_GET['qrconvite'];

    $sql_idContrato = mysqli_query($con, "SELECT * FROM turmas WHERE ncontrato = '$id_contrato'");
            
    if (mysqli_num_rows($sql_idContrato)>0) {
        while($row_ncontrato = mysqli_fetch_assoc($sql_idContrato)){
            $resultcontrato= $row_ncontrato["id_turma"]; 
        } 
       
        $id_turma = $resultcontrato;
    }  
      

    

    $sql_instituicoes = mysqli_query($con, "SELECT * FROM instituicoes as i INNER JOIN turmas as t  on i.id_instituicao = t.id_instituicao and t.id_turma = '$id_turma'");

    $sql_turma = mysqli_query($con, "SELECT * FROM turmas WHERE id_turma = '$id_turma'");

    $sql_redesociasis = mysqli_query($con, "SELECT * FROM redessociais_turmas WHERE  id_turma = '$id_turma' AND tipo = 'Instagram'");

    //$sql_imagens = mysqli_query($con, "SELECT * FROM qr_convite WHERE turma_fk = '$id_turma' AND id_qrconvite = '$id_qrconvite'");
    $sql_imagens = mysqli_query($con, "SELECT * FROM qr_convite WHERE turma_fk = '$id_turma'");
    

    
    if (mysqli_num_rows($sql_imagens)>0) {
    
        while($row_imagens = mysqli_fetch_assoc($sql_imagens)){
            $result3= $row_imagens["imagem_turma"]; 
            $result4= $row_imagens["imagem_brasao"]; 

            
            
        }        
        $imagem_turma = $result3;
        $imagem_brasao = $result4;
       
        
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

    function dataformatada($dataformatada){
        return date("d-m-Y", strtotime($dataformatada));
    }
    
?>
<!DOCTYPE html>
<html  lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta media="viewport" content="width=devide-width">    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!--     Fonts and icons     -->
    <link href='https://fonts.googleapis.com/css?family=Cambo|Poppins:400,600' rel='stylesheet' type='text/css'>
    
    <link href="layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
        
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="layout/assets/images/favicon.png">
    <title>Studio M Fotografia</title>
    <!-- Custom CSS -->
    
    <!-- Custom CSS -->
    <link href="layout/dist/css/style.min.css" rel="stylesheet">

    <script type="text/javascript" src="aplicacoes/aplicjava.js"></script>

    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

    

</head>

<body>

<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->

 
        <nav class="navbar navbar-default  navbar-fixed-top" color-on-scroll="200" style="text-align: center;"  >
            <!-- if you want to keep the navbar hidden you can add this class to the navbar "navbar-burger"-->
            
            <div class="col-md-3 col-sm-2 col-0"></div>
            <div class="col-md-6 col-sm-8 col-12">
                                
                    <a href="#formandos" class="navbar-brand" id="formandos" name="formandos">
                        Formandos
                    </a>
                    
                                
                    <a href="#homenageados"  class="navbar-brand" id="homenageados" name="homenageados">
                        Homenageados
                    </a>
                   
                                
                    <a href="#solenidades" class="navbar-brand" id="solenidades" name="solenidades">
                        Solenidades
                    </a>
                   
            
            </div>
            <div class="col-md-3 col-sm-2 col-0"></div>
        </nav>
    


    <div class="section section-header ">    
        <div class="" style="width: 100% !important;">
            <img class=" img-fluid" src="sistema/<?=$imagem_turma?>" alt=""style="width: 100% !important;">
            <div class="container" style="width: 15% !important;  position: absolute; top: 6%; left: 15%; transform: translate(-50%, -50%); ">
                <div class="panel imgbrasao" style=" border-radius: 13%;" >
                    <?='<img class="img-fluid "  src="sistema/'.$imagem_brasao.'"  alt="">'?>
                </div>   
            
            
            </div>
        </div>
    </div>


    <div class="section" >
        <div class="container-fluid" >
          
            <div class="row" id="option1" class="group">
                <div class="col-md-3 col-1" ></div>
                <div class="col-md-6 col-10">
                    <div class="info-icon" >
                        <div class="icon text-danger">
                            <i class="pe-7s-graph1"></i>
                        </div>
                        <h2 style="text-align: center;">Formandos</h2>
                        <br>
                        <div style="column-count: 3;">
                            <?php 
                            $sql_turma = mysqli_query($con, "SELECT * FROM formandos WHERE turma = '$id_turma' order by nome asc");
                            while($row_turma = mysqli_fetch_assoc($sql_turma)){ ?>
                                <p style="text-align: center;"><?= mb_convert_case($row_turma["nome"], MB_CASE_TITLE)?></p>
                            
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-1"></div>
            </div>
            <div class="row" id="option2" class="group">
                    <div class="col-md-3 col-1"></div>
                    <div class="col-md-6 col-10">
                    <div class="container">
                        <div class="row">
                            <div class="info-icon col " >
                                <div class="icon text-danger">
                                    <i class="pe-7s-graph1"></i>
                                </div>
                                
                                <h2 style="text-align: center;">Homenageados</h2>
                                <br>
                                <div>
                                
                                </div>   
                            </div>
                        </div>

                        <?php
                         $sql_verifica_professores = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and (corpoHomenageados = 'Professor' || corpoHomenageados = 'Professora') order by nome_homenageado asc");
                         $row_verifica_professores = mysqli_fetch_assoc($sql_verifica_professores);
                         if (is_null($row_verifica_professores["nome_homenageado"])  || $row_verifica_professores["nome_homenageado"] == ""){ 

                         }else{
                        ?>
                        <div class="row">
                        <div class="info-icon col" >
                            <div class="icon text-danger">
                                <i class="pe-7s-graph1"></i>
                            </div>
                            
                            <div class="col ">
                                <h4 style="text-align: center;">PROFESSORES HOMENAGEADOS</h4><br>
                                <?php 
                                    $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and (corpoHomenageados = 'Professor' || corpoHomenageados = 'Professora') order by nome_homenageado asc");

                                    while($row_convite = mysqli_fetch_assoc($sql_convite)){ 
                                        $row = explode(";",mb_convert_case($row_convite["nome_homenageado"], MB_CASE_TITLE));
                                        foreach ($row as $value) {
                                            $value = trim($value);
                                            if (is_null($value) || empty($value) || is_null($value)) {
                                                # code...
                                            }else {
                                                # code...
                                            
                                ?>
                                    <p  style=" text-align: center;"><?= $row_convite["titulo"]?> <?= $value;?></p>
                                        
                                <?php } } }?> <br>
                            </div>
                            
                        </div>
                        </div>
                        <?php }?>
                                            
                        <?php
                         $sql_verifica_paraninfo = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and (corpoHomenageados = 'Paraninfo' || corpoHomenageados = 'Paraninfa') order by nome_homenageado asc");
                         $row_verifica_paraninfo = mysqli_fetch_assoc($sql_verifica_paraninfo);
                         if (is_null($row_verifica_paraninfo["nome_homenageado"])  || $row_verifica_paraninfo["nome_homenageado"] == "" ){ 

                         }else{
                        ?>
                        <div class="row">
                        <div class="info-icon col" >
                            <div class="icon text-danger">
                                <i class="pe-7s-graph1"></i>
                            </div>
                            
                            <div class="col ">
                                <h4 style="text-align: center;">PARANINFO</h4><br>
                                <?php 
                                $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and (corpoHomenageados = 'Paraninfo' || corpoHomenageados = 'Paraninfa') order by nome_homenageado asc");
                                while($row_convite = mysqli_fetch_assoc($sql_convite)){
                                    $row = explode(";",mb_convert_case($row_convite["nome_homenageado"], MB_CASE_TITLE));
                                        foreach ($row as $value) { 
                                            $value = trim($value);
                                            if (is_null($value) || empty($value) || is_null($value)) {
                                                # code...
                                            }else {?>
                                        
                                    <p style="text-align: center;"><?= $row_convite["titulo"]?> <?= $value?></p>
                                
                                <?php }}} ?> <br>
                            </div>
                            
                        </div>
                        </div>
                        <?php }?>
                                            
                        <?php
                         $sql_verifica_homenageados = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and (corpoHomenageados = 'Patrono' || corpoHomenageados = 'Patrona' || corpoHomenageados = 'patronesse') order by nome_homenageado asc");
                         $row_verifica_homenageados = mysqli_fetch_assoc($sql_verifica_homenageados);
                         if (is_null($row_verifica_homenageados["nome_homenageado"])  || $row_verifica_homenageados["nome_homenageado"] == "" ){ 

                         }else{
                        ?>
                        <div class="row">
                        <div class="info-icon col" >
                            <div class="icon text-danger">
                                <i class="pe-7s-graph1"></i>
                            </div>
                            
                            <h4 style="text-align: center;">PATRONO</h4><br>
                                
                            <?php 
                                $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and (corpoHomenageados = 'Patrono' || corpoHomenageados = 'Patrona' || corpoHomenageados = 'patronesse') order by nome_homenageado asc");
                                while($row_convite = mysqli_fetch_assoc($sql_convite)){ 
                                   
                                    $row = explode(";",mb_convert_case($row_convite["nome_homenageado"], MB_CASE_TITLE));
                                        foreach ($row as $value) {
                                            $value = trim($value);
                                            if (is_null($value) || empty($value) || is_null($value)) {
                                                # code...
                                            }else {?>
                                <p style="text-align: center;"><?= $row_convite["titulo"]?> <?= $value?></p>
                                    
                            <?php }}} ?> <br>
                        </div>
                        </div>
                        <?php }?>     
                        
                        <?php
                         $sql_verifica_madrinha = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and corpoHomenageados = 'Madrinha' order by nome_homenageado asc");
                         $row_verifica_madrinha = mysqli_fetch_assoc($sql_verifica_madrinha);
                         if (is_null($row_verifica_madrinha["nome_homenageado"])  || $row_verifica_madrinha["nome_homenageado"] == "" ){ 

                         }else{
                        ?>
                        <div class="row">
                        <div class="info-icon col" >
                            <div class="icon text-danger">
                                <i class="pe-7s-graph1"></i>
                            </div>
                            
                            <h4 style="text-align: center;">MADRINHA</h4><br>
                                
                            <?php 
                                $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and corpoHomenageados = 'Madrinha' order by nome_homenageado asc");
                                while($row_convite = mysqli_fetch_assoc($sql_convite)){ 
                                   
                                    $row = explode(";",mb_convert_case($row_convite["nome_homenageado"], MB_CASE_TITLE));
                                        foreach ($row as $value) {
                                            $value = trim($value);
                                            if (is_null($value) || empty($value) || is_null($value)) {
                                                # code...
                                            }else {?>
                                <p style="text-align: center;"><?= $row_convite["titulo"]?> <?= $value?></p>
                                    
                            <?php }}} ?> <br>
                        </div>
                        </div>
                        <?php }?> 

                        <?php
                         $sql_verifica_padrinho = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and corpoHomenageados = 'Padrinho' order by nome_homenageado asc");
                         $row_verifica_padrinho = mysqli_fetch_assoc($sql_verifica_padrinho);
                         if (is_null($row_verifica_padrinho["nome_homenageado"])  || $row_verifica_padrinho["nome_homenageado"] == "" ){ 

                         }else{
                        ?>
                        <div class="row">
                        <div class="info-icon col" >
                            <div class="icon text-danger">
                                <i class="pe-7s-graph1"></i>
                            </div>
                            
                            <h4 style="text-align: center;">PADRINHO</h4><br>
                                
                            <?php 
                                $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and corpoHomenageados = 'Padrinho' order by nome_homenageado asc");
                                while($row_convite = mysqli_fetch_assoc($sql_convite)){ 
                                   
                                    $row = explode(";",mb_convert_case($row_convite["nome_homenageado"], MB_CASE_TITLE));
                                        foreach ($row as $value) {
                                            $value = trim($value);
                                            if (is_null($value) || empty($value) || is_null($value)) {
                                                # code...
                                            }else {?>
                                <p style="text-align: center;"><?= $row_convite["titulo"]?> <?= $value?></p>
                                    
                            <?php }}} ?> <br>
                        </div>
                        </div>
                        <?php }?> 

                        <?php
                         $sql_verifica_padrinho = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and corpoHomenageados = 'Residente Homenageado' order by nome_homenageado asc");
                         $row_verifica_padrinho = mysqli_fetch_assoc($sql_verifica_padrinho);
                         if (is_null($row_verifica_padrinho["nome_homenageado"])  || $row_verifica_padrinho["nome_homenageado"] == "" ){ 

                         }else{
                        ?>
                        <div class="row">
                        <div class="info-icon col" >
                            <div class="icon text-danger">
                                <i class="pe-7s-graph1"></i>
                            </div>
                            
                            <h4 style="text-align: center;">RESIDENTE HOMENAGEADO</h4><br>
                                
                            <?php 
                                $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and corpoHomenageados = 'Residente Homenageado' order by nome_homenageado asc");
                                while($row_convite = mysqli_fetch_assoc($sql_convite)){ 
                                   
                                    $row = explode(";",mb_convert_case($row_convite["nome_homenageado"], MB_CASE_TITLE));
                                        foreach ($row as $value) {
                                            $value = trim($value);
                                            if (is_null($value) || empty($value) || is_null($value)) {
                                                # code...
                                            }else {?>
                                <p style="text-align: center;"><?= $row_convite["titulo"]?> <?= $value?></p>
                                    
                            <?php }}} ?> <br>
                        </div>
                        </div>
                        <?php }?> 
                    
                        <?php
                         $sql_verifica_funcionario = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and (corpoHomenageados = 'Funcionário Homenageado' || corpoHomenageados = 'Funcionária Homenageada')  order by nome_homenageado asc");
                         $row_verifica_funcionario = mysqli_fetch_assoc($sql_verifica_funcionario);
                         if (is_null($row_verifica_funcionario["nome_homenageado"])  || $row_verifica_funcionario["nome_homenageado"] == "" ){ 

                         }else{
                        ?>                    
                        <div class="row">
                        <div class="info-icon col" >
                            <div class="icon text-danger">
                                <i class="pe-7s-graph1"></i>
                            </div>
                            
                            <h4 style="text-align: center;">FUNCIONÁRIO HOMENAGEADO</h4><br>
                                
                            <?php 
                                $sql_convite = mysqli_query($con, "SELECT * FROM homenageados WHERE id_turma_fk = '$id_turma' and (corpoHomenageados = 'Funcionário Homenageado' || corpoHomenageados = 'Funcionária Homenageada')  order by nome_homenageado asc");
                                while($row_convite = mysqli_fetch_assoc($sql_convite)){ 
                                    $row = explode(";",mb_convert_case($row_convite["nome_homenageado"], MB_CASE_TITLE));
                                        foreach ($row as $value) {
                                            $value = trim($value);
                                            if (is_null($value) || empty($value) || is_null($value)) {
                                                # code...
                                            }else {?>
                                <p style="text-align: center;"><?= $row_convite["titulo"]?> <?= $value?></p>
                                    
                            <?php }}} ?>
                        </div>
                        </div>
                        <?php }?>
                        
                        
                        
                    </div>
                    </div>
                    <div class="col-md-3 col-1"></div>
            </div>

            <div class="row" id="option3" class="group">
                <div class="col-md-3 col-1"></div>
                    <div class="col-md-6 col-10">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <h2 style="text-align: center;">Solenidades</h2>
                                    <br>
                                </div>
                            </div>
                            <div class="row" >
                                    
                                    <?php
                                    $sql_dados_evento_qrconvite_TURMA =  mysqli_query($con, "SELECT * FROM dados_evento_qrconvite WHERE id_turma_fk = '$id_turma'");
                                    
                                    for ($i=0; $i < mysqli_num_rows($sql_dados_evento_qrconvite_TURMA)  ; $i++) { 
                                       
                                        while ($vetor_solenidades = mysqli_fetch_array($sql_dados_evento_qrconvite_TURMA)) {
                                            $vetor_categoriaevento = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM categoriaevento WHERE id_categoria = $vetor_solenidades[id_categoriaEvento_fk]")) ;
                                            
                                            ?>
                                            <div class="col-md-12 col-lg-6 col-sm-12 col-xs-12">
                                                <h4 style="text-align: center;">
                                                    <button id="localizacaolop" name="localizacaolop"  data-lat = "<?= $vetor_solenidades['latitudeEvento']?>"
                                                                data-lng = "<?= $vetor_solenidades['longitudeEvento']?>"
                                                                    type="button" class="btn btn-outline-danger" 
                                                                    style=" border-bottom: 0px; border:none!important;" 
                                                                    data-toggle="modal" data-target="#modalLocalizacaoJantar">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16" style="pointer-events: none;">
                                                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                                                </svg>
                                                                </button>
                                                    <?= $vetor_categoriaevento['nome']?>
                                                </h4>


                                                <p style="text-align: center;"><?= dataformatada($vetor_solenidades["dataQrconvite"])?> as <?= $vetor_solenidades["horainicio"]?> - <?= $vetor_solenidades["nomeLocal"]?> (<?= $vetor_solenidades["endereco"]?> - <?= $vetor_solenidades["cidade"]?> - <?= $vetor_solenidades["estado"]?>)</p>

                                            </div>    
                                            <?php

                                        }
                                    }?>
                                
                            </div>
                                
                        </div>        
                        <br>
                        <br>
                    </div>
                </div>
                <div class="col-md-3 col-1"></div>
            </div>

            
                                                
                <div id="maplop"  style="width: 100%; height: 500px"> </div>
                                                                
            



        </div>
    </div>

                                    
    <br><br>                                        

    <div  style="background-color: #dadada;" class="mt-5">
        <footer style="text-align: center;">
            <div class="container">
                <div class="row" >
                    <div class="col-md-3 col-sm-3 col-1"></div>
                    <div class="col-md-6 col-sm-6 col-10">
                        <div class="info">
                        <h5 class="title">E-mail</h5>
                            <a href="mailto:<?=$emailcomissao?>" class="btn btn-social btn-reddit btn-simple">
                                
                                <nav>
                                <?=$emailcomissao?>
                                </nav>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-1"></div>
                    <!--
                    <div class="col-md-6  col-sm-6" >
                        
                            <h5 class="">Rede Social</h5>
                            <a href="https://www.instagram.com/<?=$instagram?>" class="btn btn-social btn-reddit btn-simple">
                                
                                <nav>
                                    <img alt="Instagram" src="https://static.wixstatic.com/media/9f9c321c774844b793180620472aa4f1.png/v1/fill/w_66,h_66,al_c,q_85,usm_0.66_1.00_0.01/9f9c321c774844b793180620472aa4f1.webp" style="width: 40px; height: 40px; object-fit: cover;">  
                                    @<?=$instagram?>
                                </nav>
                            </a>
                        
                    </div>

                </div>
                -->
                
            </div>
        </footer>
    </div>

</body>

<script>

$(document).ready(function(){
    $("#option1").show();
    $("#option2").hide();
    $("#option3").hide();
    $("#maplop").hide();

    $("#formandos").click(function(){
        $("#option1").show();
        $("#option2").hide();
        $("#option3").hide();
        
        $("#maplop").hide();
        document.getElementById("option1").scrollIntoView(true);

    });

  $("#homenageados").click(function(){
        $("#option1").hide();
        $("#option2").show();
        $("#option3").hide();
        
        $("#maplop").hide();
        document.getElementById("option2").scrollIntoView(true);
   
    });   

  $("#solenidades").click(function(){
        $("#option1").hide();
        $("#option2").hide();
        $("#option3").show();
        
        $("#maplop").hide();
        document.getElementById("option3").scrollIntoView(true);

    });
});

        document.querySelectorAll("#localizacaolop").forEach(localizacaolop => 
        localizacaolop.addEventListener("click", function(e) {
            //let clicked_btn = e.target;
            $("#maplop").show();
            document.getElementById("maplop").scrollIntoView(true);
            let latidute = parseFloat(e.target.dataset.lat);
            let longitude = parseFloat(e.target.dataset.lng);

            
            //console.log(clicked_btn);
            //console.log(latidute);
            //console.log(longitude);  
            
            const myLatlng = {lat: latidute, lng: longitude};
                
            //const myLatlng = {lat: -16.681773, lng: -49.2512037};

                    
            // The map, centered at myLatlng
            const map = new google.maps.Map(document.getElementById("maplop"), {
                zoom: 18,
                center: myLatlng,
            });
                    // The marker, positioned at myLatlng
            const marker = new google.maps.Marker({
                        
                position: myLatlng,
                map: map,
                animation: google.maps.Animation.BOUNCE,
             });
        })
        )


// </script>

    <!--Api Google-->    
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWrHlvID_j9Be0a6RstCXfK6FW5OfMAyk"  type="text/javascript"></script> 


<style>



/* =========================================================
* Gaia Bootstrap Template - v1.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/gaia-bootstrap-template
* Licensed under MIT (https://github.com/creativetimofficial/gaia-bootstrap-template/blob/master/LICENSE.md)
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. */

/*      light colors        



*/


h1,
.h1,
h2,
.h2,
h3,
.h3,
h4,
.h4,
h5,
.h5,
h6,
.h6,
.content-blog p {
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
 
}
h1 a,
.h1 a,
h2 a,
.h2 a,
h3 a,
.h3 a,
h4 a,
.h4 a,
h5 a,
.h5 a,
h6 a,
.h6 a,
.content-blog p a {
  font-size: inherit;
 
}

.content-blog {
  padding: 30px 0;
}
.content-blog p {
  font-size: 18px;
  margin-bottom: 30px;
}

h1, .h1 {
  font-size: 3em;
  line-height: 1.213483146em;
  font-weight: bold;
}

h2, .h2 {
  font-size: 2.1em;
  line-height: 1.25;
  margin: 0.4em 0;
  font-weight: bold;
}

h3, .h3 {
  font-size: 1.4em;
  line-height: 1.05em;
  margin-top: 15px;
  margin-bottom: 15px;
}

h4, .h4 {
  font-size: 1.3em;
  line-height: 1.714285714em;
}

h5 {
  font-size: 1.2em;
}

p {
  font-size: 14px;
  line-height: 1.6em;
  font-weight: 400;
  margin: 0 0 .75em;
}
@media only screen and (max-width: 479px) {
    p{
        font-size: 1.3em !important;
    }

    a{
        font-size: 1.4em !important;
    }
}

a {
  color: #646363 !important;
  
  font-size: 14px;
}
a:hover {
  color: #646363 !important;
  
}

.btn,
.navbar .navbar-nav > li > a.btn {
  
  
  font-weight: 600;
  border-radius: 3px;
  font-size: 12px;
  line-height: 1.6em;
  

  text-transform: uppercase;
}


.btn-simple {
  border: 0;
  font-size: 14px;
  padding: 10px 20px;
}

.section {
  padding: 50px 0;
  position: relative;
  
}

.navbar .navbar-brand {
  margin: 10px 0px;
  padding: 15px 15px;
  font-size: 20px;
  line-height: 22px;
}

.section-header,
.section-header-blog,
.section-presentation-page {
  padding: 0;
}



body, html, .panel{ 
    background-color:  #f6f6f6 !important;
    color: #646363 !important;
}

footer{
    background-color: #dadada;
    position: absolute;
    bottom: -1%;
    width: 100%;
    margin: 10px 0px;
    padding: 15px 15px;
}


</style>
</html>
