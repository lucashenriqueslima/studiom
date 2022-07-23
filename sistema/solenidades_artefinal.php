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

include "../includes/conexao.php";
session_start();
    
    $id_turma = $_GET['turma'] ;
    //$id_qrconvite= $_GET['qrconvite'];

    
        
          
       
      

    

    $sql_instituicoes = mysqli_query($con, "SELECT * FROM instituicoes as i INNER JOIN turmas as t  on i.id_instituicao = t.id_instituicao and t.id_turma = '$id_turma'");

    $sql_turma = mysqli_query($con, "SELECT * FROM turmas WHERE id_turma = '$id_turma'");

    $sql_redesociasis = mysqli_query($con, "SELECT * FROM redessociais_turmas WHERE  id_turma = '$id_turma' AND tipo = 'Instagram'");

    //$sql_imagens = mysqli_query($con, "SELECT * FROM qr_convite WHERE turma_fk = '$id_turma' AND id_qrconvite = '$id_qrconvite'");
    $sql_imagens = mysqli_query($con, "SELECT * FROM qr_convite WHERE turma_fk = '$id_turma'");
    

    
    if (mysqli_num_rows($sql_imagens)>0) {
    
        while($row_imagens = mysqli_fetch_assoc($sql_imagens)){
            $result3= $row_imagens["imagem_turma"]; 
            $result4= $row_imagens["imagem_brasao"]; 

            $result5=$row_imagens["longitudeColacaoOfc"]; 
            $result6=$row_imagens["latitudeColacaoOfc"]; 

            $result7=$row_imagens['latitudeJantar'];
            $result8=$row_imagens['longitudeJantar'];

            $result9=$row_imagens['longitudeCulto'];
            $result10=$row_imagens['latitudeCulto'];

            $result11=$row_imagens['longitudeColacao'];
            $result12=$row_imagens['latitudeColacao'];

            $result13=$row_imagens['longitudeBaile'];
            $result14=$row_imagens['latitudeBaile'];
            
        }        
        $imagem_turma = $result3;
        $imagem_brasao = $result4;
        $longitudeColacaoOfc = $result5;
        $latitudeColacaoOfc = $result6;
        $latitudeJantar=$result7;
        $longitudeJantar=$result8;

        $longitudeCulto=$result9;
        $latitudeCulto=$result10;

        $longitudeColacao=$result11;
        $latitudeColacao=$result12;

        $longitudeBaile=$result13;
        $latitudeBaile=$result14;
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


?>
<!DOCTYPE html>
<html  lang="pt-br">

<head>
    
    <meta charset="utf-8">


    <!--     Fonts and icons     -->
    <link href='https://fonts.googleapis.com/css?family=Cambo|Poppins:400,600' rel='stylesheet' type='text/css'>
    
    <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
        
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../layout/assets/images/favicon.png">
    <title>Studio M Fotografia</title>
    <!-- Custom CSS -->
    
    <!-- Custom CSS -->
    <link href="../layout/dist/css/style.min.css" rel="stylesheet">

    <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

</head>

<body>

<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->

 
        <nav class="navbar navbar-default  navbar-fixed-top" color-on-scroll="200"  >
            <!-- if you want to keep the navbar hidden you can add this class to the navbar "navbar-burger"-->
            <div class="col-md-4"></div>
            <div class="container col-md-4">
                <div class="navbar-header">                 
                    <a href="#formandos" class="navbar-brand" id="formandos" name="formandos">
                        Formandos
                    </a>
                    
                </div>
                <div class="navbar-header">                 
                    <a href="#homenageados"  class="navbar-brand" id="homenageados" name="homenageados">
                        Homenageados
                    </a>
                   
                </div>
                <div class="navbar-header">                 
                    <a href="#solenidades" class="navbar-brand" id="solenidades" name="solenidades">
                        Solenidades
                    </a>
                   
                </div>
                
            </div>
            <div class="col-md-4"></div>
        </nav>
    


    <div class="section section-header ">    
        <div class="" style="width: 100% !important;">
            <img class=" img-fluid" src="<?=$imagem_turma?>" alt=""style="width: 100% !important;">
            <div class="container" style="width: 15% !important;  position: absolute; top: 6%; left: 15%; transform: translate(-50%, -50%); ">
                <div class="panel imgbrasao" style=" border-radius: 13%;" >
                    <?='<img class="img-fluid "  src="'.$imagem_brasao.'"  alt="">'?>
                </div>   
            
            
            </div>
        </div>
    </div>


    <div class="section" >
        <div class="container-fluid" >
          
            <div class="row" id="option1" class="group">
                <div class="col-md-3"></div>
               <div class="col-md-6">
                    <div class="info-icon" >
                        <div class="icon text-danger">
                            <i class="pe-7s-graph1"></i>
                        </div>
                        <h3 style="text-align: center;">Formandos</h3>
                        <br>
                        <div style="column-count: 3;">
                            <?php 
                            $sql_turma = mysqli_query($con, "SELECT * FROM formandos WHERE turma = '$id_turma'");
                            while($row_turma = mysqli_fetch_assoc($sql_turma)){ ?>
                                <p style="text-align: center;"><?= $row_turma["nome"]?></p>
                            
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row" id="option2" class="group">
                <div class="col-md-3"></div>
               <div class="col-md-6">
                    <div class="info-icon" >
                        <div class="icon text-danger">
                            <i class="pe-7s-graph1"></i>
                        </div>
                        <h3 style="text-align: center;">Homenageados</h3>
                        <br>
                        <div class="col">
                            <h4 style="text-align: center;">PARANINFO</h4>
                            <?php 
                            $sql_convite = mysqli_query($con, "SELECT * FROM dados_convite WHERE id_turma = '$id_turma'");
                            while($row_convite = mysqli_fetch_assoc($sql_convite)){ ?>
                                <p style="text-align: center;"><?= $row_convite["parainfo"]?></p>
                            
                            <?php } ?> <br>
                        </div>
                        
                    </div>
                    <div class="info-icon" >
                        <div class="icon text-danger">
                            <i class="pe-7s-graph1"></i>
                        </div>
                        
                        <h4 style="text-align: center;">PROFESSORES</h4><br>
                            
                        <?php 
                            $sql_convite = mysqli_query($con, "SELECT * FROM dados_convite WHERE id_turma = '$id_turma'");
                            while($row_convite = mysqli_fetch_assoc($sql_convite)){ 
                        ?>
                            <p  style="column-count:2;" style="text-align: center;"><?= $row_convite["professores"]?></p>
                                
                        <?php } ?>
                    </div>
                    <div class="info-icon" >
                        <div class="icon text-danger">
                            <i class="pe-7s-graph1"></i>
                        </div>
                        
                        <h4 style="text-align: center;">PATRONO</h4><br>
                            
                        <?php 
                            $sql_convite = mysqli_query($con, "SELECT * FROM dados_convite WHERE id_turma = '$id_turma'");
                            while($row_convite = mysqli_fetch_assoc($sql_convite)){ 
                        ?>
                            <p  style="text-align: center;"><?= $row_convite["patrono"]?></p>
                                
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>

            <div class="row" id="option3" class="group">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h3 style="text-align: center;">Solenidades</h3>
                                <br>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-6" >
                            <h4 style="text-align: center;">
                            
                                <button id="localizacaoColacaoOfc" name="localizacaoColacaoOfc"
                                    type="button" class="btn btn-outline-danger" 
                                    style=" border-bottom: 0px; border:none!important;" 
                                    data-toggle="modal" data-target="#modalLocalizacaoColacaoOfc">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                                </button>
                                COLAÇÃO DE GRAU OFICIAL
                            </h4>
                            
                                <?php 
                                $sql_convite = mysqli_query($con, "SELECT * FROM dados_convite WHERE id_turma = '$id_turma'");
                                while($row_convite = mysqli_fetch_assoc($sql_convite)){ ?>
                                    <p style="text-align: center;"><?= $row_convite["colacaograu"]?></p>
                                
                                <?php } ?> 
                                
                            </div>
                            <div class="col-md-6">
                                <h4 style="text-align: center;">
                                INSTITUIÇÃO</h4>
                                <img src="/sistema/arquivos/<?php echo $row_convite['logoinstituicao']; ?>">
                        
                            </div>
                            
                        </div>
                        <br>
                        <div class="row" >
                            <div class="col-md-6" >
                                <h4 style="text-align: center;">
                                    <button id="localizacaoJantar" name="localizacaoJantar"
                                        type="button" class="btn btn-outline-danger" 
                                        style=" border-bottom: 0px; border:none!important;" 
                                        data-toggle="modal" data-target="#modalLocalizacaoJantar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    </svg>
                                    </button>
                                    JANTAR DOS PAIS
                                </h4>
                                <?php 
                                $sql_convite = mysqli_query($con, "SELECT * FROM dados_convite WHERE id_turma = '$id_turma'");
                                while($row_convite = mysqli_fetch_assoc($sql_convite)){ ?>
                                    <p style="text-align: center;"><?= $row_convite["jantardospais"]?></p>
                                
                                <?php } ?> 
                                
                            </div>
                            <div class="col-md-6">
                                <h4 style="text-align: center;">
                                    <button id="localizacaoCulto" name="localizacaoCulto"
                                            type="button" class="btn btn-outline-danger" 
                                            style=" border-bottom: 0px; border:none!important;" 
                                            data-toggle="modal" data-target="#modalLocalizacaoJantar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                        </svg>
                                        </button>
                                    CULTO ECUMÊNICO
                                </h4>
                                <?php 
                                $sql_convite = mysqli_query($con, "SELECT * FROM dados_convite WHERE id_turma = '$id_turma'");
                                while($row_convite = mysqli_fetch_assoc($sql_convite)){ ?>
                                    <p style="text-align: center;"><?= $row_convite["cultoecumenico"]?></p>
                                
                                <?php } ?> 
                            </div>
                            
                        </div>
                        <br>
                        <div class="row" >
                            <div class="col-md-6" >
                                <h4 style="text-align: center;">
                                    <button id="localizacaoColacao" name="localizacaoColacao"
                                                type="button" class="btn btn-outline-danger" 
                                                style=" border-bottom: 0px; border:none!important;" 
                                                data-toggle="modal" data-target="#modalLocalizacaoJantar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                            </svg>
                                            </button>
                                    COLAÇÃO DE GRAU
                                </h4>
                                <?php 
                                $sql_convite = mysqli_query($con, "SELECT * FROM dados_convite WHERE id_turma = '$id_turma'");
                                while($row_convite = mysqli_fetch_assoc($sql_convite)){ ?>
                                    <p style="text-align: center;"><?= $row_convite["colacaograu"]?></p>
                                
                                <?php } ?> 
                                
                            </div>
                            <div class="col-md-6">
                                <h4 style="text-align: center;">
                                    <button id="localizacaoBaile" name="localizacaoBaile"
                                                    type="button" class="btn btn-outline-danger" 
                                                    style=" border-bottom: 0px; border:none!important;" 
                                                    data-toggle="modal" data-target="#modalLocalizacaoJantar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                                </svg>
                                                </button>
                                    BAILE DE FORMATURA
                                </h4>
                                <?php 
                                $sql_convite = mysqli_query($con, "SELECT * FROM dados_convite WHERE id_turma = '$id_turma'");
                                while($row_convite = mysqli_fetch_assoc($sql_convite)){ ?>
                                    <p style="text-align: center;"><?= $row_convite["bailedeformatura"]?></p>
                                
                                <?php } ?> 
                            </div>
                            
                        </div>
                        <br>
                        
                        <br>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>

            <!-- Modal -->
            <div class="row" id="option4" class="group alert ">
            
                <div id="map"  style="width: 100%; height: 500px"> </div>
                            
            </div>
            <!-- Modal -->
            <div class="row" id="option5" class="group alert ">
            
                <div id="map2"  style="width: 100%; height: 500px"> </div>
                            
            </div>
            <!-- Modal -->
            <div class="row" id="option6" class="group alert ">
            
                <div id="map3"  style="width: 100%; height: 500px"> </div>
                            
            </div>
            <!-- Modal -->
            <div class="row" id="option7" class="group alert ">
            
                <div id="map4"  style="width: 100%; height: 500px"> </div>
                            
            </div>
            <!-- Modal -->
            <div class="row" id="option8" class="group alert ">
            
                <div id="map5"  style="width: 100%; height: 500px"> </div>
                            
            </div>




        </div>
    </div>

                                    
    

    <div class="footer" style="padding: 15px 0; position: relative;" >
        <footer style="text-align: center;">
            <div class="container">
                <div class="row" >

                    <div class="col-md-6 col-sm-6">
                        <div class="info">
                        <h5 class="title">E-mail</h5>
                            <a href="mailto:<?=$emailcomissao?>" class="btn btn-social btn-reddit btn-simple">
                                
                                <nav>
                                <?=$emailcomissao?>
                                </nav>
                            </a>
                        </div>
                    </div>
                    
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
                
                
            </div>
        </footer>
    </div>
  
</body>

<script>
$(document).ready(function(){
    $("#option1").show();
    $("#option2").hide();
    $("#option3").hide();
    $("#option4").hide();
    $("#option5").hide();
    $("#option6").hide();
    $("#option7").hide();
    $("#option8").hide();

    $("#formandos").click(function(){
        $("#option1").show();
        $("#option2").hide();
        $("#option3").hide();
        $("#option4").hide();
        $("#option5").hide();
        $("#option6").hide();
        $("#option7").hide();
        $("#option8").hide();
        document.getElementById("option1").scrollIntoView(true);

    });

  $("#homenageados").click(function(){
        $("#option1").hide();
        $("#option2").show();
        $("#option3").hide();
        $("#option4").hide();
        $("#option5").hide();
        $("#option6").hide();
        $("#option7").hide();
        $("#option8").hide();   
        document.getElementById("option2").scrollIntoView(true);
   
    });   

  $("#solenidades").click(function(){
        $("#option1").hide();
        $("#option2").hide();
        $("#option3").show();
        $("#option4").hide();
        $("#option5").hide();
        $("#option6").hide();
        $("#option7").hide();
        $("#option8").hide();
        document.getElementById("option3").scrollIntoView(true);

    });

    $("#localizacaoColacaoOfc").click(function(){
        var latitudeColacaoOfc = parseFloat("<?php echo($latitudeColacaoOfc); ?>");
        var longitudeColacaoOfc = parseFloat("<?php echo($longitudeColacaoOfc); ?>");    
         console.log(latitudeColacaoOfc);       
        const myLatlng = {lat: latitudeColacaoOfc, lng: longitudeColacaoOfc};
                
        //const myLatlng = {lat: -16.681773, lng: -49.2512037};

                    
            // The map, centered at myLatlng
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: myLatlng,
            });
                    // The marker, positioned at myLatlng
            const marker = new google.maps.Marker({
                        
                position: myLatlng,
                map: map,
                animation: google.maps.Animation.BOUNCE,
            });

        $("#option4").show();
        
        $("#option5").hide();
        $("#option6").hide();
        $("#option7").hide();
        $("#option8").hide();
        document.getElementById("option4").scrollIntoView(true);

    });

    $("#localizacaoJantar").click(function(){
        var latitudeJantar = parseFloat("<?php echo($latitudeJantar); ?>");
        var longitudeJantar = parseFloat("<?php echo($longitudeJantar); ?>");    
        console.log(latitudeJantar);       
        const myLatlng = {lat: latitudeJantar, lng: longitudeJantar};
                
        //const myLatlng = {lat: -16.681773, lng: -49.2512037};

                    
            // The map, centered at myLatlng
            const map = new google.maps.Map(document.getElementById("map2"), {
                zoom: 15,
                center: myLatlng,
            });
                    // The marker, positioned at myLatlng
            const marker = new google.maps.Marker({
                        
                position: myLatlng,
                map: map,
                animation: google.maps.Animation.BOUNCE,
            });

        $("#option5").show();

        $("#option4").hide();
    
        $("#option6").hide();
        $("#option7").hide();
        $("#option8").hide();
        document.getElementById("option5").scrollIntoView(true);

    });

    $("#localizacaoCulto").click(function(){
        var latitudeCulto = parseFloat("<?php echo($latitudeCulto); ?>");
        var longitudeCulto = parseFloat("<?php echo($longitudeCulto); ?>");    
                
        const myLatlng = {lat: latitudeCulto, lng: longitudeCulto};
                
        //const myLatlng = {lat: -16.681773, lng: -49.2512037};

                    
            // The map, centered at myLatlng
            const map = new google.maps.Map(document.getElementById("map3"), {
                zoom: 15,
                center: myLatlng,
            });
                    // The marker, positioned at myLatlng
            const marker = new google.maps.Marker({
                        
                position: myLatlng,
                map: map,
                animation: google.maps.Animation.BOUNCE,
            });

        $("#option6").show();

        $("#option4").hide();
        $("#option5").hide();
        
        $("#option7").hide();
        $("#option8").hide();
        document.getElementById("option6").scrollIntoView(true);

    });

    $("#localizacaoColacao").click(function(){
        var latitudeColacao = parseFloat("<?php echo($latitudeColacao); ?>");
        var longitudeColacao = parseFloat("<?php echo($longitudeColacao); ?>");    
                
        const myLatlng = {lat: latitudeColacao, lng: longitudeColacao};
                
        //const myLatlng = {lat: -16.681773, lng: -49.2512037};

                    
            // The map, centered at myLatlng
            const map = new google.maps.Map(document.getElementById("map4"), {
                zoom: 15,
                center: myLatlng,
            });
                    // The marker, positioned at myLatlng
            const marker = new google.maps.Marker({
                        
                position: myLatlng,
                map: map,
                animation: google.maps.Animation.BOUNCE,
            });

        $("#option7").show();

        $("#option4").hide();
        $("#option5").hide();
        $("#option6").hide();
        
        $("#option8").hide();
        document.getElementById("option7").scrollIntoView(true);

    });

    $("#localizacaoBaile").click(function(){
        var latitudeBaile = parseFloat("<?php echo($latitudeBaile); ?>");
        var longitudeBaile = parseFloat("<?php echo($longitudeBaile); ?>");    
                
        const myLatlng = {lat: latitudeBaile, lng: longitudeBaile};
                
        //const myLatlng = {lat: -16.681773, lng: -49.2512037};

                    
            // The map, centered at myLatlng
            const map = new google.maps.Map(document.getElementById("map5"), {
                zoom: 15,
                center: myLatlng,
            });
                    // The marker, positioned at myLatlng
            const marker = new google.maps.Marker({
                        
                position: myLatlng,
                map: map,
                animation: google.maps.Animation.BOUNCE,
            });

        

        $("#option4").hide();
        $("#option5").hide();
        $("#option6").hide();
        $("#option7").hide();
        $("#option8").show();
        
        document.getElementById("option8").scrollIntoView(true);

    });

});
</script>

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
  font-size: 2.4em;
  line-height: 1.25;
  margin: 0.4em 0;
  font-weight: bold;
}

h3, .h3 {
  font-size: 1.61em;
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
@media only screen and (max-width: 425px) {
    p,a {
        font-size: 1em !important;
        
    }

    .imgbrasao{
        width: 50% !important;
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

footer, .footer{
    background-color: #dadada;
}


</style>
</html>
