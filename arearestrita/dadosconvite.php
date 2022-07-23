<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id_formando'] == null || $_SESSION['id_formando'] == '') {
    echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";
} else {
    $sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);
    $sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor_cadastro[turma]'");
    $vetor_turma = mysqli_fetch_array($sql_turma);
    $dataatual = date('Y-m-d');
    ?>
<!DOCTYPE html>
<html dir="ltr" lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../layout/assets/images/favicon.png">
    <title>Studio M Fotografia</title>
    <!-- Custom CSS -->
    <link href="../layout/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="../layout/assets/extra-libs/c3/c3.min.css" rel="stylesheet">

    <link href="../layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../layout/dist/css/style.min.css" rel="stylesheet">
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        textarea {
            background-color: #eef5f9;
            padding: 8px;
        }


        /** THUMBNAILS GLOBALS **/
        .thumbnails {
            display: flex;
            flex-wrap: wrap;
        }

        .thumbnails a {
            width: 200px;
            height: 200px;
            margin: 14px;
            border-radius: 2px;
            overflow: hidden;
        }

        .thumbnails img {
            height: 100%;
            object-fit: cover;
            transition: transform .3s;
        }

        .thumbnails a:hover img {
            transform: scale(1.05);
        }

        /** THUMBNAILS GRID **/
        .thumbnails.grid a.double {
            width: calc(50% - 4px);
        }

        .thumbnails.grid img {
            width: 100%;
        }

        /** THUMBNAILS MASONRY **/
        .thumbnails.masonry a {
            flex-grow: 1;
        }

        .thumbnails.masonry img {
            min-width: 100%;
        }

        .tooltip-inner {
            background-color: #4a148c !important;
            box-shadow: 0px 0px 4px black !important;
            padding: 10px !important;
        }



        .tooltip {
            position: absolute;
            z-index: 1070;
            display: block;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: left;
            text-align: start;
            text-decoration: none;
            text-shadow: none;
            text-transform: none;
            letter-spacing: normal;
            word-break: normal;
            word-spacing: normal;
            word-wrap: normal;
            white-space: normal;
            filter: alpha(opacity=0);
            opacity: 0;
            line-break: auto
        }

        .tooltip.in {
            filter: alpha(opacity=90);
            opacity: .9
        }

        .tooltip.top {
            padding: 5px 0;
            margin-top: -3px
        }

        .tooltip.right {
            padding: 0 5px;
            margin-left: 3px
        }

        .tooltip.bottom {
            padding: 5px 0;
            margin-top: 3px
        }

        .tooltip.left {
            padding: 0 5px;
            margin-left: -3px
        }

        .tooltip-inner {
            max-width: 200px;
            padding: 3px 8px;
            color: #fff;
            text-align: center;
            background-color: #000;
            border-radius: 4px
        }

        .tooltip-arrow {
            position: absolute;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid
        }

        .tooltip.top .tooltip-arrow {
            bottom: 0;
            left: 50%;
            margin-left: -5px;
            border-width: 5px 5px 0;
            border-top-color: #4a148c !important;
        }

        .tooltip.top-left .tooltip-arrow {
            right: 5px;
            bottom: 0;
            margin-bottom: -5px;
            border-width: 5px 5px 0;
            border-top-color: #4a148c !important;
        }

        .tooltip.top-right .tooltip-arrow {
            bottom: 0;
            left: 5px;
            margin-bottom: -5px;
            border-width: 5px 5px 0;
            border-top-color: #4a148c !important;
        }

        .tooltip.right .tooltip-arrow {
            top: 50%;
            left: 0;
            margin-top: -5px;
            border-width: 5px 5px 5px 0;
            border-right-color: #4a148c !important;
        }

        .tooltip.left .tooltip-arrow {
            top: 50%;
            right: 0;
            margin-top: -5px;
            border-width: 5px 0 5px 5px;
            border-left-color: #4a148c !important;
        }

        .tooltip.bottom .tooltip-arrow {
            top: 0;
            left: 50%;
            margin-left: -5px;
            border-width: 0 5px 5px;
            border-bottom-color: #4a148c !important;
        }

        .tooltip.bottom-left .tooltip-arrow {
            top: 0;
            right: 5px;
            margin-top: -5px;
            border-width: 0 5px 5px;
            border-bottom-color: #4a148c !important;
        }

        .tooltip.bottom-right .tooltip-arrow {
            top: 0;
            left: 5px;
            margin-top: -5px;
            border-width: 0 5px 5px;
            border-bottom-color: #4a148c !important;
        }

        /*DEFAULT LOAD*/
.ajax_load {
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 2000;
}

.ajax_load_box {
    margin: auto;
    text-align: center;
    color: #ffffff;
    font-weight: bold;
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.5);
}

.ajax_load_box_circle {
    border: 16px solid #e3e3e3;
    border-top: 16px solid #4e73df;
    border-radius: 50%;
    margin: auto;
    width: 80px;
    height: 80px;

    -webkit-animation: spin 1.2s linear infinite;
    -o-animation: spin 1.2s linear infinite;
    animation: spin 1.2s linear infinite;
}

.ajax_load_box_title {
    margin-top: 15px;
    font-weight: bold;
}

@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
    }
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.timeline-1 {
border-left: 3px solid #2962FF;
border-bottom-right-radius: 4px;
border-top-right-radius: 4px;
background: #eef5f9;
margin: 0 auto;
position: relative;

list-style: none;
text-align: left;
max-width: 40%;
}

@media (max-width: 767px) {
.timeline-1 {
max-width: 98%;

}
}

.event {
    padding: 50px;
    cursor: pointer;
    transition: 0.5s;
}

.event:hover {
    background: #90caf9;
}


.timeline-1 .event {
border-bottom: 1px dashed #000;
padding-bottom: 25px;
position: relative;
}

@media (max-width: 767px) {
.timeline-1 .event {
padding-top: 30px;
}
}

.timeline-1 .event:first-of-type {
padding-top: 66px;
}

.timeline-1 .event:last-of-type {
padding-bottom: 50px;
margin-bottom: 0;
border: none;
}

.timeline-1 .event:before,
.timeline-1 .event:after {
position: absolute;
display: block;
top: 0;
}

.timeline-1 .event:before {
left: -145px;
top: 67px;
content: attr(data-date);
text-align: right;
font-weight: bold;
font-size: 0.9em;
color: #000;
min-width: 120px;
}

@media (max-width: 767px) {
.timeline-1 .event:before {
display: none;
}
}

.timeline-1 .event:after {
-webkit-box-shadow: 0 0 0 3px #b565a7;
box-shadow: 0 0 0 3px #2962FF;
left: -5.8px;
background: #fff;
border-radius: 50%;
height: 9px;
width: 9px;
content: "";
top: 71px;
}

@media (max-width: 767px) {
.timeline-1 .event:after {
left: -5.8px;
}
}

    </style>
    <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
    <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="inicio.php">
                        <b class="logo-icon">

                            <img src="../layout/assets/images/logo-2.png" alt="homepage" class="dark-logo"
                                width="110px" />

                            <img src="../layout/assets/images/logo-icon.png" alt="homepage" class="light-logo"
                                width="50px" />
                        </b>

                    </a>

                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>


                    </ul>

                    <ul class="navbar-nav float-right">


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>" alt="user"
                                    class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img
                                            src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"
                                            alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h5 class="m-b-0"><?php echo $vetor_cadastro['nome']; ?></h5>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="sair.php"><i class="fa fa-power-off m-r-5 m-l-5"></i>
                                    Sair</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include "includes/menu.php"; ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h5 class="page-title">Arquivos de Convites</h5>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dados do Convite</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

            <div id="loader" class="ajax_load">
                <div class="ajax_load_box">
                    <div class="ajax_load_box_circle"></div>
                    <div class="ajax_load_box_title">Aguarde, carrengando...</div>
                </div>
            </div>
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                            <div class="container py-5">
                                <h3 class="text-center mb-5"><strong>Instrução para Preenchimento dos Arquivos de Convite</strong></h5>
  <div class="row">
    <div class="col-md-12">
      <div id="content">
        <ul class="timeline-1 text-black" id="guide">
          <li class="event" data-date="Etapa 1" data-move="#etapa1">
            <h4 class="mb-3">Confirme o seu Nome</h4>
            <p>Confirme seu nome completo (para altera-lo, vá para a página de cadastro).</p>
          </li>
          <li class="event" data-date="Etapa 2" data-move="#etapa2">
            <h4 class="mb-3 pt-3">Confirme e/ou Inclua o nome dos seus Pais e/ou Responsáveis</h4>
            <p>Confirme o nome dos seus pais e caso queira adicione responsáveis que aparecerão em seu convite.</p>
          </li>
          <li class="event" data-date="Etapa 3" data-move="#etapa3">
            <h4 class="mb-3 pt-3">Inclua seu(s) texto(s) Personalizado(s)</h4>
            <p>Redija o(s) texto(s) que estarão presente em seu convite.</p>
          </li>
          <li class="event" data-date="Etapa 4" data-move="#etapa4">
            <h4 class="mb-3 pt-3">Inclua suas Fotos</h4>
            <p class="mb-0">Insira as fotos que comparecerão em seu convite (inserir foto de acordo com a orientação descrita em seu título).</p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<hr id="etapa1">

                                <div class="my-5">
                                    <h4 class="card-title my-5"><strong>Etapa 1 - Confirmação do Seu Nome</strong></h4>

                                    <?php
                                $sql_consulta_nome = mysqli_query($con, "select * from dadosconvite_nomes where id_formando = '$_SESSION[id_formando]' and tipo = '1'");
                                $vetor_consulta_nome = mysqli_fetch_array($sql_consulta_nome);
                                ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <fieldset class="form-group">
                                                    <input type="text"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Para alterar seu nome entre na página de cadastro" value="<?php 
                                                           echo $vetor_cadastro['nome'];
                                                       ?>" class="form-control" id="exampleInput"
                                                        readonly="readonly">
                                            </div>
                                            </fieldset>
                                        </div>
                                </div>
                                        <hr id="etapa2">
                                <?php
                                    if(1==1) {
                                        ?>

                                <!-- <button type="submit" class="btn btn-primary" style="    float: left;">Salvar
                                </button>

                                <br>

                                <br> -->

                                <?php } ?>

                                

                                <h4 class="card-title my-5"><strong>Etapa 2 - Confirmação/Inclusão do nome dos Pais e Responsáveis</strong></h4>

                                <form id="form-convidados" action="https://www.studiomfotografia.com.br/api/convites/save-dados-convite" method="post">

                                    <?php

                                    $sql_pais = mysqli_fetch_array(mysqli_query($con, "SELECT f.pai, f.mae, f.inmemorianpai, f.inmemorianmae, f.nao_mostrar_pai_convite, f.nao_mostrar_mae_convite FROM formandos f WHERE f.id_formando = '$_SESSION[id_formando]'"));


                                        ?>

                                    <div id="origem">
                                        <div class="row my-3">
                                            <div class="col-lg-5">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="nome_pai">Nome do Pai</label>
                                                    <input type="text" name="nome_pai"
                                                        value="<?= $sql_pais['nao_mostrar_pai_convite'] ? '' : $sql_pais['pai'] ?>" class="form-control"
                                                        id="nome_pai" <?= $sql_pais['nao_mostrar_pai_convite'] ? 'disabled' : ''?> >
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label>In Memoriam (Pai Falecido)</label>
                                                    <select name="inememorian_pai" class="select-inmemorian form-control" <?= $sql_pais['nao_mostrar_pai_convite'] ? 'disabled' : ''?>>
                                                        <?php if($sql_pais['nao_mostrar_pai_convite']) { echo "<option></option>"; } ?>
                                                        <option value="0" <?php if ($sql_pais['inmemorianpai'] == 0 && $sql_pais['nao_mostrar_pai_convite'] == 0) {
                                                                    echo "selected";
                                                                } ?>>N&atilde;o
                                                        </option>
                                                        <option value="1" <?php if ($sql_pais['inmemorianpai'] != 0 && $sql_pais['nao_mostrar_pai_convite'] == 0) {
                                                                    echo "selected";
                                                                } ?>>Sim
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-2" style="margin-top: 28px">
                                                <div class="form-group">
                                                    <input type="button" value="<?= $sql_pais['nao_mostrar_pai_convite'] ? "Exibir" : "Não Exibir" ?>"
                                                        onclick="exibirPais(this)"
                                                        class="btn btn-<?= $sql_pais['nao_mostrar_pai_convite'] ? 'success' : 'danger' ?>" data-show="<?= $sql_pais['nao_mostrar_pai_convite'] ? "false"  : "true"?>">
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div id="origem">
                                        <div class="row my-3">
                                            
                                            <div class="col-lg-5">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="nome_mae">Nome da Mãe</label>
                                                    <input type="text" name="nome_mae"
                                                        value="<?= $sql_pais['nao_mostrar_mae_convite'] ? '' : $sql_pais['mae'] ?>" class="form-control"
                                                        id="nome_mae" <?= $sql_pais['nao_mostrar_mae_convite'] ? 'disabled' : ''?>>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label>In Memoriam (Mãe Falecida)</label>
                                                    <select name="inememorian_mae" class="select-inmemorian form-control" <?= $sql_pais['nao_mostrar_mae_convite'] ? 'disabled' : ''?>>
                                                    <?php if($sql_pais['nao_mostrar_mae_convite']) { echo "<option></option>"; } ?>
                                                        <option value="0" <?php if ($sql_pais['inmemorianmae'] == 0 && $sql_pais['nao_mostrar_mae_convite'] == 0) {
                                                                    echo "selected";
                                                                } ?>>N&atilde;o
                                                        </option>
                                                        <option value="1" <?php if ($sql_pais['inmemorianmae'] != 0 && $sql_pais['nao_mostrar_mae_convite'] == 0) {
                                                                    echo "selected";
                                                                } ?>>Sim
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-2" style="margin-top: 28px">
                                                <div class="form-group">
                                                    <input type="button" value="<?= $sql_pais['nao_mostrar_mae_convite'] ? "Exibir" : "Não Exibir" ?>" data-show="<?= $sql_pais['nao_mostrar_mae_convite'] ? "false"  : "true"?>"
                                                        onclick="exibirPais(this)"
                                                        class="btn btn-<?= $sql_pais['nao_mostrar_mae_convite'] ? 'success' : 'danger' ?>">
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    
                                    <div id="origemPessoa" hidden>
                                        <div class="row my-3">
                                            <div class="col-lg-5">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="nome_pessoas">Nome</label>
                                                    <input type="text" name="nome_pessoas[]"
                                                        value="" class="form-control"
                                                        id="nome_pessoas">
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label>In Memoriam - Falecido(a)</label>
                                                    <select name="inmemoriam_pessoas[]" class="select-inmemorian form-control">
                                                        <option value="0">Não
                                                        </option>
                                                        <option value="1">Sim</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if ( 1 == 1) { ?>
                                            <div class="col-lg-2" style="margin-top: 28px">
                                                <div class="form-group">
                                                    <input type="button" value="Excluir"
                                                        onclick="excluirPessoa(this)"
                                                        class="btn btn-danger">
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                        <?php
                                    $sql = mysqli_query($con, "select * from dadosconvite_nomes where id_formando = '$_SESSION[id_formando]'");
                                    if (mysqli_num_rows($sql) > 0) {
                                        while ($dado = mysqli_fetch_array($sql)) {
                                            ?>
                                    <div id="origemPessoa">
                                        <div class="row my-3">
                                            <div class="col-lg-5">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold" for="exampleInput">Nome</label>
                                                    <input type="text" name="nome_pessoas[]"
                                                        value="<?php echo $dado['nome']; ?>" class="form-control"
                                                        id="exampleInput">
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label>In Memoriam - Falecido(a)</label>
                                                    <select name="inmemoriam_pessoas[]" class="select-inmemorian form-control">
                                                        <option value="0" <?php if ($dado['inmemoriam'] == 0) {
                                                                    echo "selected=''";
                                                                } ?>>N&atilde;o
                                                        </option>
                                                        <option value="1" <?php if ($dado['inmemoriam'] == 1) {
                                                                    echo "selected=''";
                                                                } ?>>Sim
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if ( 1 == 1) { ?>
                                            <div class="col-lg-2" style="margin-top: 28px">
                                                <div class="form-group">
                                                    <input type="button" value="Excluir"
                                                        onclick="excluirPessoa(this)"
                                                        class="btn btn-danger">
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    } 
                                    if (1 == 1) { ?>
                                    <div id="destino"></div>
                                    <input type="button" value="Adicionar Responsável" onclick="duplicarCampos();"
                                        class="btn btn-info">
                                    
                                    <br>
                                    <br>
                                    <button type="submit" class="btn btn-primary mt-3 mb-5" style="">
                                        Salvar
                                    </button>
                                    <hr id="etapa3">
                                    

                                    
                                    <?php } ?>

</form>

                            <h4 class="card-title my-5"><strong>Etapa 3 - Inclusão do(s) texto(s) Personalizado(s)</strong></h4>

                                        <?php
                                            if($vetor_turma['datafinal'] >= $dataatual || 1 == 1) {
                                        ?>
                                        
                                            <form id="form-textos" method="post" action="https://www.studiomfotografia.com.br/api/convites/save-textos-convite">

                                        <?php } ?>

                                    <?php
                                    $sql_itens = mysqli_query($con, "select * from tipos_arquivos_turma where id_tipo IN ('1', '2') AND id_turma = '$vetor_cadastro[turma]' order by id_tipo_formando ASC");
                                    while ($vetor_itens = mysqli_fetch_array($sql_itens)) {
                                        $sql_tipo = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '$vetor_itens[id_tipo]'");
                                        $vetor_tipo = mysqli_fetch_array($sql_tipo);
                                        ?>
                                    <div class="borda">
                                        <h5 class="mt-4"><?php echo $vetor_tipo['nome']; ?></h5>

                                        <?php
                                            $sql_consulta = mysqli_query($con, "select * from dadosconvite where id_formando = '$vetor_cadastro[id_formando]' and id_tipo = '$vetor_itens[id_tipo]'");
                                            
                                                $vetor_consulta = mysqli_fetch_array($sql_consulta);
                                                
                                                if ($vetor_itens['id_tipo'] == 1) {
                                                    echo "<textarea id='texto_convite_individual' name='texto_convite_individual' class='mt-1' style='width: 100%; height: 120px'>" . @$vetor_consulta['texto'] . "</textarea>";
                                                    if ($vetor_turma['datafinal'] >= $dataatual || 1 == 1) {
                                                        echo "<br>";
                                                        echo "<br>";
                                                        ?>

                                                        <div class="row">
                                                                <small class="texto_individual_caracteres"></small>
                                                        </div>



                                                        <script>
                                                        

                                                        $(window).load(function () {
    
                                                            document.querySelector("#texto_convite_individual").addEventListener("keyup", ((e) => {
    
                                                                
                                                                var limite = <?php echo $vetor_itens['qtd']; ?>;
                                                                var informativo = "caracteres restantes.";
                                                                var caracteresDigitados = e.target.value.length;
                                                                var caracteresRestantes = limite - caracteresDigitados;
    
                                                                if (caracteresRestantes <= 0) {
                                                                    var comentario = $("#texto_convite_individual").val();
                                                                    $("#texto_convite_individual").val(comentario.substr(0, limite));
                                                                    $(".texto_individual_caracteres").text("0 " + informativo);
                                                                } else {
                                                                    $(".texto_individual_caracteres").text(caracteresRestantes + " " + informativo);
                                                                }
    
                                                            }))
                                                            
    
                                                        });
    
                                                        </script>


                                                        <?php
                                                    }
                                                }
                                                if ($vetor_itens['id_tipo'] == 2) {
                                                    echo "<textarea class='mt-1' id='texto_convite_familia' name='texto_convite_familia' style='width: 100%; height: 120px'>" . @$vetor_consulta['texto'] . "</textarea>";
                                                    if ($vetor_turma['datafinal'] >= $dataatual || 1 == 1) {
                                                        ?>

                                                        <br>
                                                        <br>

                                                        <div class="row">
                                                                <small class="texto_familia_caracteres"></small>
                                                        </div>

                                                    <script>
                                                        

                                                    $(window).load(function () {

                                                        document.querySelector("#texto_convite_familia").addEventListener("keyup", ((e) => {

                                                            

                                                            var limite = <?php echo $vetor_itens['qtd']; ?>;
                                                            var informativo = "caracteres restantes.";
                                                            var caracteresDigitados = e.target.value.length;
                                                            var caracteresRestantes = limite - caracteresDigitados;

                                                            if (caracteresRestantes <= 0) {
                                                                var comentario = $("#texto_convite_familia").val();
                                                                $("#texto_convite_familia").val(comentario.substr(0, limite));
                                                                $(".texto_familia_caracteres").text("0 " + informativo);
                                                            } else {
                                                                $(".texto_familia_caracteres").text(caracteresRestantes + " " + informativo);
                                                            }

                                                        }))
                                                        

                                                    });

                                                    </script>


                                                                                                               

                                                    <?php }
                                                }

                                                if ($vetor_itens['id_tipo'] == 3) { ?>

                                                    <br>

                                                    <div class="thumbnail">

                                                        <a href="<?php echo '../sistema/arquivos/' . $vetor_consulta['imagem']; ?>"
                                                           class="b-link-stripe b-animate-go  swipebox"><img alt=""
                                                                                                             src="<?php echo '../sistema/arquivos/' . $vetor_consulta['imagem']; ?>"/></a>


                                                    </div>

                                                    <?php
                                                }

                                                if ($vetor_itens['id_tipo'] == 4) {
                                                    ?>

                                                    <div class="row">

                                                        <?php
                                                        $sql_fotos_4 = mysqli_query($con, "select * from dadosconvite where id_formando = '$vetor_cadastro[id_formando]' and id_tipo = '4'");
                                                        while ($vetor_fotos_4 = mysqli_fetch_array($sql_fotos_4)) {
                                                            ?>

                                                            <br>

                                                            <div class="col-md-4">

                                                                <div class="thumbnail">

                                                                    <a href="<?php if ($vetor_fotos_4['upload'] == 1) {
                                                                        echo $vetor_fotos_4['imagem'];
                                                                    } else {
                                                                        echo '../sistema/arquivos/' . $vetor_fotos_4['imagem'];
                                                                    } ?>"
                                                                       class="b-link-stripe b-animate-go  swipebox"><img
                                                                                alt=""
                                                                                src="<?php if ($vetor_fotos_4['upload'] == 1) {
                                                                                    echo $vetor_fotos_4['imagem'];
                                                                                } else {
                                                                                    echo '../sistema/arquivos/' . $vetor_fotos_4['imagem'];
                                                                                } ?>"/></a>

                                                                </div>

                                                            </div>

                                                        <?php } ?>

                                                    </div>


                                                    <?php
                                                }

                                                if ($vetor_itens['id_tipo'] == 5) {
                                                    ?>

                                                    <div class="row">

                                                        <?php
                                                        $sql_fotos_5 = mysqli_query($con, "select * from dadosconvite where id_formando = '$vetor_cadastro[id_formando]' and id_tipo = '5'");
                                                        while ($vetor_fotos_5 = mysqli_fetch_array($sql_fotos_5)) {
                                                            ?>

                                                            <br>

                                                            <div class="col-md-4">

                                                                <div class="thumbnail">

                                                                    <a href="<?php echo $vetor_fotos_5['imagem']; ?>"
                                                                       class="b-link-stripe b-animate-go  swipebox"><img
                                                                                alt=""
                                                                                src="<?php echo $vetor_fotos_5['imagem']; ?>"/></a>

                                                                </div>

                                                            </div>

                                                        <?php } ?>

                                                    </div>

                                                <?php }
                                                if ($vetor_itens['id_tipo'] == 6) { ?>

                                                    <br>

                                                    <div class="thumbnail">

                                                        <a href="<?php echo $vetor_consulta['imagem']; ?>"
                                                           class="b-link-stripe b-animate-go  swipebox"><img alt=""
                                                                                                             src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                                    </div>

                                                <?php }
                                                if ($vetor_itens['id_tipo'] == 7) { ?>

                                                    <br>

                                                    <div class="thumbnail">

                                                        <a href="<?php echo $vetor_consulta['imagem']; ?>"
                                                           class="b-link-stripe b-animate-go  swipebox"><img alt=""
                                                                                                             src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                                    </div>

                                                <?php }
                                                if ($vetor_itens['id_tipo'] == 8) { ?>

                                                    <br>

                                                    <div class="thumbnail">

                                                        <a href="<?php echo $vetor_consulta['imagem']; ?>"
                                                           class="b-link-stripe b-animate-go  swipebox"><img alt=""
                                                                                                             src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                                    </div>

                                                <?php }
                                                if ($vetor_itens['id_tipo'] == 9) { ?>

                                                    <br>

                                                    <div class="thumbnail">

                                                        <a href="<?php echo $vetor_consulta['imagem']; ?>"
                                                           class="b-link-stripe b-animate-go  swipebox"><img alt=""
                                                                                                             src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                                    </div>

                                                <?php }
                                                if ($vetor_itens['id_tipo'] == 10) { ?>

                                                    <br>

                                                    <div class="thumbnail">

                                                        <a href="<?php echo $vetor_consulta['imagem']; ?>"
                                                           class="b-link-stripe b-animate-go  swipebox"><img alt=""
                                                                                                             src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                                    </div>

                                                <?php }
                                                if ($vetor_itens['id_tipo'] == 11) { ?>

                                                    <br>

                                                    <div class="thumbnail">

                                                        <a href="<?php echo $vetor_consulta['imagem']; ?>"
                                                           class="b-link-stripe b-animate-go  swipebox"><img alt=""
                                                                                                             src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                                    </div>

                                                <?php }
                                                if ($vetor_itens['id_tipo'] == 12) { ?>

                                                    <br>

                                                    <div class="thumbnail">

                                                        <a href="<?php echo $vetor_consulta['imagem']; ?>"
                                                           class="b-link-stripe b-animate-go  swipebox"><img alt=""
                                                                                                             src="<?php echo $vetor_consulta['imagem']; ?>"/></a>

                                                    </div>

                                                <?php }
                                             ?>

                                    </div>

                                    <br>

                                    <?php } ?>


                                    <?php
                                    if($vetor_turma['datafinal'] >= $dataatual || 1 == 1) {
                                        ?>
                                    <button type="submit" class="btn btn-primary mt-3 mb-5">
                                        Salvar
                                    </button>

                                    </form>
                                    <?php } ?>

                                            <hr id="etapa4">

                                    <h4 class="card-title my-5"><strong>Etapa 4 -  Inclusão de Fotos</strong></h4>

                                    <?php
                                    $sql_convite_personal = mysqli_query($con, "select * from convite_personal where id_formando = '$_SESSION[id_formando]' order by id_convite DESC");
                                    if (mysqli_num_rows($sql_convite_personal) > 0) {
                                        $convite = mysqli_fetch_array($sql_convite_personal);
                                        $sql_itens = mysqli_query($con, "select * from convite_personal_itens where id_convite = '$convite[id_convite]' order by id_item ASC");
                                        if (mysqli_num_rows($sql_itens) > 0){
                                            while ($vetor_itens = mysqli_fetch_array($sql_itens)) {

                                                $sql_tipo = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '$vetor_itens[id_tipo]'");
                                                $vetor_tipo = mysqli_fetch_array($sql_tipo);
                                                ?>
                                    <h5><?php echo @$vetor_tipo['nome']; ?></h5>

                                    <?php

                                                $sql_fotos = mysqli_query($con, "select * from convite_personal_escolhas where id_item = '$vetor_itens[id_item]'");

                                                if (mysqli_num_rows($sql_fotos) > 0) {

                                                    ?>

                                    <div class="row">

                                        <?php

                                                        while ($vetor_fotos = mysqli_fetch_array($sql_fotos)) {

                                                            ?>

                                        <br>

                                        <div class="col-md-3">

                                            <div class="thumbnails grid">

                                                <a class="image-popup-vertical-fit"
                                                    href="<?php echo $vetor_fotos['imagem']; ?>"><img
                                                        src="<?php echo $vetor_fotos['imagem']; ?>" alt=""></a>

                                            </div>

                                        </div>

                                        <?php } ?>

                                    </div>
                                    <?php if(1==1) { ?>
                                    <br>
                                    <a
                                        href="excluirimagensconvitepersonal.php?id=<?php echo $vetor_itens['id_item']; ?>&id1=<?php echo $convite['id_convite']; ?>">
                                        <button type="button" class="btn btn-danger" style="    float: left;">
                                            Excluir
                                            Escolhas <?php echo $vetor_tipo['nome']; ?></button>
                                    </a>
                                    <?php
                                                    }

                                                } else {

                                                    if(1==1) {
                                                        ?>

                                    <a
                                        href="enviardadosconvitepersonal.php?id=<?php echo @$vetor_itens['id_item']; ?>&id1=<?php echo @$convite['id_convite']; ?>">
                                        <button type="button" class="btn btn-primary" style="    float: left;">
                                            Escolher <?php echo @$vetor_tipo['nome']; ?></button>
                                    </a>

                                    <?php
                                                    }
                                                } ?>

                                    <br>
                                    <br>
                                    <br>
                                    <?php
                                            }
                                        }
                                    }
                                     ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <footer class="footer text-center">
                Todos direitos reservados. <a href="https://studiomfotografia.com.br">Studio M Fotografia</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->

    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->

    <!-- Bootstrap tether Core JavaScript -->
    <script src="../layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="../layout/dist/js/app.min.js"></script>
    <!-- minisidebar -->
    <script>
        $(function () {
            "use strict";
            $("#main-wrapper").AdminSettings({
                Theme: false, // this can be true or false ( true means dark and false means light ),
                Layout: 'vertical',
                LogoBg: 'skin5', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                NavbarBg: 'skin5', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarType: 'mini-sidebar', // You can change it full / mini-sidebar / iconbar / overlay
                SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarPosition: false, // it can be true / false ( true means Fixed and false means absolute )
                HeaderPosition: false, // it can be true / false ( true means Fixed and false means absolute )
                BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid )
            });
        });
    </script>
    <script src="../layout/dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../layout/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../layout/assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../layout/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../layout/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../layout/dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="../layout/assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../layout/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 charts -->
    <script src="../layout/assets/extra-libs/c3/d3.min.js"></script>
    <script src="../layout/assets/extra-libs/c3/c3.min.js"></script>
    <!--chartjs -->
    <script src="../layout/assets/libs/chart.js/dist/Chart.min.js"></script>
    <script src="../layout/dist/js/pages/dashboards/dashboard1.js"></script>
    <script src="../layout/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../layout/dist/js/pages/datatable/datatable-basic.init.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('[data-toggle="tooltip"]').tooltip();


        document.querySelector("#guide").querySelectorAll('li').forEach((item)=> {
            item.addEventListener('click', function (e) {
                
                var hash = this.dataset.move

                $('html, body').animate({
                scrollTop: $(hash).offset().top
                }, 800, function(){

                window.location.hash = hash;
                });
                
            });
        });


 
		
















  // Add smooth scrolling to all links
    
    //   $('html, body').animate({
    //     scrollTop: $(hash).offset().top
    //   }, 800, function(){
   
    //     // Add hash (#) to URL when done scrolling (default click behavior)
    //     window.location.hash = hash;
    //   });
    
  


    </script>

<script>

$(document).delegate('textarea', 'keydown', function(e) {
  var keyCode = e.keyCode || e.which;

  if (keyCode == 9) {
    e.preventDefault();
    var start = this.selectionStart;
    var end = this.selectionEnd;

    $(this).val($(this).val().substring(0, start) + "\t" +
    $(this).val().substring(end));

    this.selectionStart =
    this.selectionEnd = start + 1;
  }
});









    

        function exibirPais(e) {

            let selected_div = e.parentNode.parentNode.parentNode

            let input_name = selected_div.querySelector('input[type="text"]')

            let select_inmemoriam = selected_div.querySelector('select')

            if(e.dataset.show == 'true') {
                
            Swal.fire({
                title: 'Atenção?',
                text: `O nome ${input_name.id != "nome_pai" ? "da sua mãe" : "do seu pai"} não aparecerá em seu convite, deseja continuar?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, desejo continuar!',
                cancelButtonText: 'Não, cancelar!',
                }).then((result) => {

                if (result.isConfirmed) {

                e.dataset.show = 'false';
                input_name.value = '';
                input_name.disabled = true;
                select_inmemoriam.disabled = true;
                select_inmemoriam.value = '';
                e.value = 'Exibir'
                e.classList.remove('btn-danger')
                e.classList.add('btn-success')

            Swal.fire(
                'Ação executada!',
                `O nome ${input_name.id != "nome_pai" ? "da sua mãe" : "do seu pai"} não aparecerá em seu convite.`,
                'success'
            )
            }
            })
                
            } else {

                Swal.fire({
                title: 'Atenção?',
                text: `O nome ${input_name.id != "nome_pai" ? "da sua mãe" : "do seu pai"} aparecerá em seu convite, deseja continuar?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, desejo continuar!',
                cancelButtonText: 'Não, cancelar!',
                }).then((result) => {
                    
                if (result.isConfirmed) {

                    if(select_inmemoriam.getElementsByTagName('option').length > 2){
                    select_inmemoriam.getElementsByTagName('option')[0].remove()
                    }

                    fetch(`https://www.studiomfotografia.com.br/api/convites/get-dados-convite`, {
                        method: 'GET',
                    }).then((response) => {
                    response.json().then((data) => {
                    dados = data
                        }).then(() => {

                    if(dados.pais[0].inmemorianmae == null){
                        dados.pais[0].inmemorianmae = 0;
                    }

                    if(dados.pais[0].inmemorianpai == null){
                        dados.pais[0].inmemorianpai = 0;
                    }


                            
                    e.dataset.show = 'true';
                    input_name.value = input_name.id != "nome_pai" ? dados.pais[0].mae : dados.pais[0].pai;
                    input_name.disabled = false;
                    select_inmemoriam.disabled = false;
                    
                    input_name.id != "nome_pai" ? select_inmemoriam.value = dados.pais[0].inmemorianmae : select_inmemoriam.value = dados.pais[0].inmemorianpai;

                    e.value = 'Não Exibir'
                    e.classList.add('btn-danger')
                    e.classList.remove('btn-success')

            Swal.fire(
                'Ação executada!',
                `O nome ${input_name.id != "nome_pai" ? "da sua mãe" : "do seu pai"} aparecerá em seu convite.`,
                'success'
            )

                        })
                    });

                    

            }
            })

            }

        }


        function excluirPessoa(e) {
            e.parentNode.parentNode.parentNode.remove()
        }


        function duplicarCampos() {
            var clone = document.getElementById('origemPessoa').cloneNode(true);
            var destino = document.getElementById('destino');
            clone.removeAttribute('hidden');
            destino.appendChild(clone);
            var camposClonados = clone.getElementsByTagName('input[type="text"]');
            for (i = 0; i < camposClonados.length; i++) {
                camposClonados[i].value = '';
            }
        }

        function removerCampos(id) {
            var node1 = document.getElementById('destino');
            node1.removeChild(node1.childNodes[0]);
        }


        $(window).on("load", function(){
    $("#form-convidados").submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var action = form.attr("action") + "?id_formando=" + localStorage.id_formando + "&token_jwt_formando=" + localStorage.token_jwt_formando;
        var data = form.serialize();


        $.ajax({
            url: action,
            data: data,
            type: "post",
            dataType: "json",
            beforeSend: function (load) {
                ajax_load("open");
            },
            success: function (su) {
                ajax_load("close");

                setTimeout(function() {

                if (su.message) {

                alert(su.message.icon, su.message.message)           
                    return;
                }

                if (su.redirect) {
                    window.location.href = su.redirect.url;
                }

            
            }, 800)
            }
        });

        function ajax_load(action) {
            ajax_load_div = $(".ajax_load");

            if (action === "open") {
                ajax_load_div.fadeIn(400).css("display", "flex");
            }

            if (action === "close") {
                ajax_load_div.fadeOut(600);
            }
        }

        function alert(icon, message)
{
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: icon,
        title: message
      })    
}
    });
});


$("#form-textos").submit(function (e) {

    e.preventDefault();

    var form = $(this);
    var action = form.attr("action") + "?id_formando=" + localStorage.id_formando + "&token_jwt_formando=" + localStorage.token_jwt_formando;
    var data = form.serialize();

    $.ajax({
        url: action,
        data: data,
        type: "post",
        dataType: "json",
        beforeSend: function (load) {
            ajax_load("open");
        },
        success: function (su) {

            ajax_load("close");


            setTimeout(function() {

            if (su.message) {
                alert(su.message.icon, su.message.message)           
                return;
            }

            if(su.modal_close){
                tableGrid()
                $(`#${su.modal_close.modal}`).modal('hide')    
                setTimeout(function() {  
                alert(su.modal_close.type, su.modal_close.message)
                }, 300)
                return;
            }

            if (su.redirect) {
                window.location.href = su.redirect.url;
            }

        
        }, 800)
        }
    })


    function ajax_load(action) {
        ajax_load_div = $(".ajax_load");

        if (action === "open") {
            ajax_load_div.fadeIn(400).css("display", "flex");
        }

        if (action === "close") {
            ajax_load_div.fadeOut(600);
        }
    }

    function alert(icon, message)
{
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: icon,
        title: message
      })    
}





});

    </script>


</body>

</html>
<?php } ?>