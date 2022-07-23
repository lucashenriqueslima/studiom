<?php
include "../includes/conexao.php";
session_start();

if(isset($_POST['relatorio'])){
    $id = $_GET['id'];
    $relatorio = $_POST['relatorio'];
    mysqli_query($con, "UPDATE eventos_turma set relatorio='$relatorio',status='1' where id_evento='$id'");
    die();
}

if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
} else {
    $id = $_GET['id'];
    $sql = mysqli_query($con, "select * from eventos_turma where id_evento = '$id'");
    $vetor = mysqli_fetch_array($sql);
    $sql_cadastro = "select * from usuarios where id_usuario = '$_SESSION[id]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);
    $id_pagina = 25;
    $sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
    $vetor_permissao = mysqli_fetch_array($sql_permissao);
    ?>
    <!DOCTYPE html>
    <html dir="ltr" lang="en">

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

        <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

        <script type="text/javascript">
            function eventoRealizado(){
                var relatorioE = $('#relatorio').val();
                $.ajax({
                    url: "alterarevento.php?id=<?php echo $_GET['id']; ?>",
                    type: "POST",
                    data: {relatorio:relatorioE},
                    success: function (rep) {
                        alert('Foi alterado com sucesso!!!');
                    }
                });
                window.location.href='fotografia_eventos.php';
            }
            $(document).ready(function () {
                $('#turmas').change(function () {
                    $('#solicitante').load('formandos.php?id_turma=' + $('#turmas').val());

                });

            });
        </script>

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
                    <a class="navbar-brand" href="dashboard.php">
                        <b class="logo-icon">

                            <img src="../layout/assets/images/logo-2.png" alt="homepage" class="dark-logo"
                                 width="110px"/>

                            <img src="../layout/assets/images/logo-icon.png" alt="homepage" class="light-logo"
                                 width="50px"/>
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
                                        src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>" alt="user"
                                        class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img
                                                src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>"
                                                alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $_SESSION['nome']; ?></h4>
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
                        <!--                        <h4 class="page-title">Administrativo</h4>-->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Fotografia</a></li>
                                    <li class="breadcrumb-item">Gestão de Eventos</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Alterar Evento</li>
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
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!--                                <h4 class="card-title">Cadastro de Evento</h4>-->

                                <form action="recebe_alterarevento.php?id=<?php echo $id; ?>" method="post"
                                      name="cliente" enctype="multipart/form-data" onSubmit="return verificarCPF()"
                                      id="formID">

                                    <div class="row">

                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Contrato</label>
                                                <select name="id_turma" id="turmas" class="form-control select2">
                                                    <option value="" selected="selected">Selecione...</option>
                                                    <?php
                                                    $sql_cursos = mysqli_query($con, "select * from turmas order by nome ASC");
                                                    while ($vetor_curso = mysqli_fetch_array($sql_cursos)) {
                                                        $sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '$vetor_curso[id_instituicao]'");
                                                        $vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
                                                        $sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '$vetor_curso[curso]'");
                                                        $vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
                                                        ?>
                                                        <option value="<?php echo $vetor_curso['id_turma']; ?>"
                                                                <?php if (strcasecmp($vetor['id_turma'], $vetor_curso['id_turma']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_curso['ncontrato'] ?>
                                                            - <?php echo $vetor_curso['nome'] ?> <?php echo $vetor_curso['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label>Solicitante</label>
                                                <select name="solicitante" id="solicitante" class="form-control select2"
                                                        required="">
                                                    <?php
                                                    $sql_solicitantes = mysqli_query($con, "select * from formandos where turma = '$vetor[id_turma]' AND comissao = '2' order by nome ASC");
                                                    while ($vetor_solicitante = mysqli_fetch_array($sql_solicitantes)) {
                                                        ?>

                                                        <option value="<?php echo $vetor_solicitante['id_formando']; ?>"
                                                                <?php if (strcasecmp($vetor['solicitante'], $vetor_solicitante['id_formando']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_solicitante['nome']; ?></option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Categoria</label>
                                                <select name="id_categoria" id="categorias"
                                                        class="form-control select2">
                                                    <option value="" selected="selected">Selecione...</option>
                                                    <?php     
                                                    $vetor_eventos_turma = mysqli_fetch_array(mysqli_query($con, "select * from eventos_turma WHERE id_evento = '$id' "));                                          
                                                    $selected = "selected=selected";
                                                    $sql_eventos = mysqli_query($con, "select * from eventos_turma_lista WHERE id_turma = '$vetor[id_turma]' ");
                                                    $i = 0;
                                                    echo "<option value=\"\" selected=\"selected\">Eventos </option>";
                                                    while ($vetor_eventos = mysqli_fetch_array($sql_eventos)) {
                                                        $sql_evento = mysqli_query($con, "select * from categoriaevento where id_categoria = '$vetor_eventos[id_evento]' ");
                                                        $vetor_evento = mysqli_fetch_array($sql_evento);

                                                        if ($vetor_eventos_turma['id_eventos_turma_lista'] == $vetor_eventos['id_evento_turma']) {
                                                            if ($vetor_evento['nome'] == 'Pré-evento'){
                                                            
                                                                echo "<option value='{$vetor_eventos['id_evento_turma']}' selected='selected'> {$vetor_evento['nome']} {$vetor_eventos['preevento']} </option>";
                                                            }else { 
                                                                echo "<option value='{$vetor_eventos['id_evento_turma']}' selected='selected'> {$vetor_evento['nome']} </option>";
                                                            }
                                                        }else {
                                                            if ($vetor_evento['nome'] == 'Pré-evento'){
                                                            
                                                                echo "<option value='{$vetor_eventos['id_evento_turma']}'> {$vetor_evento['nome']} {$vetor_eventos['preevento']} </option>";
                                                            }else { 
                                                                echo "<option value='{$vetor_eventos['id_evento_turma']}'> {$vetor_evento['nome']} </option>";
                                                            }
                                                        }
                                                       
                                                        
                                                    // echo "<option value='$reg->id_cidade'>$reg->nome_cidade</option>";
                                                    }?>

                                                    
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Título</label>
                                                <input type="text" name="titulo" value="<?php echo $vetor['titulo']; ?>"
                                                       class="form-control" required="">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Local</label>
                                                <select name="id_local" id="categorias" class="form-control select2">
                                                    <option value="" selected="selected">Selecione...</option>
                                                    <?php
                                                    $sql_local = mysqli_query($con, "select * from locais order by nome ASC");
                                                    while ($vetor_local = mysqli_fetch_array($sql_local)) { ?>
                                                        <option value="<?php echo $vetor_local['id_local']; ?>"
                                                                <?php if (strcasecmp($vetor['id_local'], $vetor_local['id_local']) == 0) : ?>selected="selected"<?php endif; ?>>
                                                            Local: <?php echo $vetor_local['nome'] ?> /
                                                            Endereço: <?php echo $vetor_local['endereco']; ?> <?php echo $vetor_local['numero']; ?> <?php echo $vetor_local['complemento']; ?> <?php echo $vetor_local['bairro']; ?> <?php echo $vetor_local['cidade']; ?> <?php echo $vetor_local['estado']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Data</label>
                                                <input type="date" name="data" value="<?php echo $vetor['data']; ?>"
                                                       class="form-control" id="exampleInput" placeholder="Data">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Hora de início do
                                                    evento</label>
                                                <input type="time" name="horainicio"
                                                       value="<?php echo $vetor['horainicio']; ?>" class="form-control"
                                                       id="exampleInput" placeholder="Data">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Hora de Término do
                                                    Evento (previsão)</label>
                                                <input type="time" name="horafim"
                                                       value="<?php echo $vetor['horafim']; ?>" class="form-control"
                                                       id="exampleInput" placeholder="Data">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Quantidade de
                                                    Alunos</label>
                                                <input type="number" name="qtdalunos"
                                                       value="<?php echo $vetor['qtdalunos']; ?>" class="form-control"
                                                       id="exampleInput" placeholder="Quantidade de Alunos">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Quantidade de
                                                    Pessoas</label>
                                                <input type="number" name="qtdpessoas"
                                                       value="<?php echo $vetor['qtdpessoas']; ?>" class="form-control"
                                                       id="exampleInput" placeholder="Quantidade de Pessoas">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Cerimonial</label>
                                                <input type="text" name="responsavel"
                                                       value="<?php echo $vetor['responsavel']; ?>" class="form-control"
                                                       id="exampleInput" placeholder="Cerimonial">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Telefone
                                                    Cerimonial</label>
                                                <input type="text" name="telefone" id="telefone"
                                                       value="<?php echo $vetor['telefone']; ?>" class="form-control"
                                                       id="exampleInput" placeholder="Telefone Cerimonial">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Responsável
                                                    Cerimonial</label>
                                                <input type="text" name="nomeresponsavel"
                                                       value="<?php echo $vetor['nomeresponsavel']; ?>"
                                                       class="form-control" id="exampleInput"
                                                       placeholder="Responsável Cerimonial">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Telefone
                                                    Responsável Cerimonial</label>
                                                <input type="text" name="telefoneresponsavel" id="telefone2"
                                                       value="<?php echo $vetor['telefoneresponsavel']; ?>"
                                                       class="form-control" id="exampleInput"
                                                       placeholder="Telefone Responsável Cerimonial">
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold" for="exampleInput">Tarefa</label>
                                                <select name="tarefa" id="tipobusca" class="form-control">
                                                    <option value="" selected="selected">Selecione...</option>
                                                    <option value="1"
                                                            <?php if (strcasecmp($vetor['tarefa'], '1') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Não
                                                    </option>
                                                    <option value="2"
                                                            <?php if (strcasecmp($vetor['tarefa'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                        Sim
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <?php if ($vetor['tarefa'] == '2') { ?>

                                            <div class="col-lg-6">
                                                <fieldset class="form-group">
                                                    <label class="form-label semibold"
                                                           for="exampleInput">Departamento</label>
                                                    <select name="departamento" id="categorias"
                                                            class="form-control select2">
                                                        <option value="" selected="selected">Selecione...</option>
                                                        <?php
                                                        $sql_departamento = mysqli_query($con, "select * from departamentos order by nome ASC");
                                                        while ($vetor_departamento = mysqli_fetch_array($sql_departamento)) { ?>
                                                            <option value="<?php echo $vetor_departamento['id_departamento']; ?>"
                                                                    <?php if (strcasecmp($vetor['departamento'], $vetor_departamento['id_departamento']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_departamento['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </fieldset>
                                            </div>

                                        <?php } ?>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold"
                                                       for="exampleInput">Observações</label>
                                                <textarea name="observacoes"
                                                          class="form-control"><?php echo $vetor['observacoes']; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div><!--.row-->


                                    <?php if ($vetor_permissao['alteracao'] == 1) {
                                    } else { ?>
                                        <button type="submit" class="btn btn-primary" style="    float: left;">Salvar
                                        </button><?php } ?>
                                    <button type="button" data-toggle="modal" data-target="#modal" class="btn btn-success"
                                            style="float: left;margin-left: 20px">Evento Realizado
                                    </button>

                                    <div id="modal" class="modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Relatorio do Evento</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <textarea id="relatorio" class="form-control" rows="3" placeholder="Text Here..."></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="eventoRealizado()" class="btn btn-success">Salvar</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
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
    </body>

    </html>
<?php } ?>