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
    <script>
        window.onload = function () {
            arrumaData(1);
        };

        function arrumaData(col) {
            var contaHora = 0;
            var contaMinuto = 0;
            var next = document.getElementById('ajuste01');
            var dias = 0;
            var data = new Date();
            while (next.nextElementSibling && next.nextElementSibling.id != 'ajusteMax1') {
                var tempHora = next.nextElementSibling.getElementsByTagName('span').namedItem('hora').innerHTML;
                if (tempHora.length > 4) {
                    contaMinuto = parseInt(tempHora.substring(4, 2)) + contaMinuto;
                }
                contaHora = parseInt(tempHora.substring(0, 2)) + contaHora;
                if (contaMinuto > 60) {
                    contaHora = contaHora + 1;
                }
                var date = data.toLocaleString("pt-BR").split(' ');
                next.nextElementSibling.getElementsByTagName('span').namedItem('data').innerHTML = date[0];
                if (contaHora > 8) {
                    contaHora = contaHora - 8;
                    if (data.getDay() == 0 || data.getDay() == 5) {
                        dias = dias + 3
                        data.setDate(data.getDate() + 3);
                    } else {
                        dias = dias + 1;
                        data.setDate(data.getDate() + 1);
                    }
                }

                date = data.toLocaleString("pt-BR").split(' ');
                next.nextElementSibling.getElementsByTagName('span').namedItem('data_termino').innerHTML = date[0];
                next = document.getElementById(next.nextElementSibling.nextElementSibling.id);
            }
            var maxData = new Date();
            maxData.setDate(maxData.getDate() + dias);
            var maxDate = maxData.toLocaleString("pt-BR").split(' ');
            document.getElementById('data_prevista').innerHTML = maxDate[0];
        }

        function moveVertical(caixa, direction, col) {
            var id;
            if (direction == 'up') {
                $.ajax({
                    type: "POST",
                    url: "recebe_suporte.php?id=" + caixa + "&muda=cima", // linkar para seu script aqui,
                    success: function () {
                    }
                });
                id = document.getElementById(document.getElementById(document.getElementById("btnU" + caixa).parentNode.id).previousElementSibling.id); //AJUSTE <BR>
            } else {
                $.ajax({
                    type: "POST",
                    url: "recebe_suporte.php?id=" + caixa + "&muda=baixo", // linkar para seu script aqui,
                    success: function () {
                    }
                });
                id = document.getElementById(document.getElementById(document.getElementById("btnD" + caixa).parentNode.id).nextElementSibling.id); //AJUSTE <BR>
            }
            if (id.previousElementSibling.previousElementSibling.id == ('ajuste0' + (col))) {
                $('#' + id.nextElementSibling.firstElementChild.id).attr('hidden', 'hidden');
                $('#' + id.previousElementSibling.firstElementChild.id).removeAttr('hidden');
            }
            if (id.nextElementSibling.nextElementSibling.id == ('ajusteMax' + (col))) {
                $('#' + id.nextElementSibling.lastElementChild.id).removeAttr('hidden');
                $('#' + id.previousElementSibling.lastElementChild.id).attr('hidden', 'hidden');
            }
            var upper = id.previousElementSibling;
            var bottom = id.nextElementSibling;
            id.insertAdjacentElement('beforebegin', bottom);
            id.insertAdjacentElement('afterend', upper);
            if (col == 1) {
                arrumaData(col);
            }
        }

        //Função para mover-se na horizontal
        function moveHorizontal(caixa, direction, col) {
            var id = document.getElementById(document.getElementById("btnU" + caixa).parentNode.id);
            var weel = 0;

            // Verifica os elementos de cima e de baixo na coluna atual
            if (id.previousElementSibling.id == 'ajuste0' + col && id.nextElementSibling.id == 'ajusteMax' + col) {
                weel = 1;//NÃO RETIRAR
            } else {
                if (id.previousElementSibling.id == 'ajuste0' + col) {
                    $('#' + id.nextElementSibling.nextElementSibling.firstElementChild.id).attr('hidden', 'hidden');
                    weel = 3;
                } else {
                    if (id.nextElementSibling.id == 'ajusteMax' + col) {
                        $('#' + id.previousElementSibling.previousElementSibling.lastElementChild.id).attr('hidden', 'hidden');
                        weel = 2;
                    } else {
                        if (id.nextElementSibling.nextElementSibling.id == 'ajusteMax' + col) {
                            $('#' + id.nextElementSibling.lastElementChild.id).attr('hidden', 'hidden');
                            weel = 2;//RETIRAR O DE CIMA
                        } else {
                            if (id.previousElementSibling.previousElementSibling.id == 'ajuste0' + col) {
                                $('#' + id.previousElementSibling.firstElementChild.id).attr('hidden', 'hidden');
                                weel = 3;// RETIRAR O DE BAIXO
                            }
                        }
                    }
                }
            }

            //Move-se para a esquerda
            if (direction == "left") { //LEFT
                var ajuste = document.getElementById('ajuste0' + (col - 1));

                $.ajax({
                    type: "POST",
                    url: "recebe_suporte.php?id=" + caixa + "&lado=left", // linkar para seu script aqui,
                    success: function () {
                    }
                });

                // Botões que deve possuir
                if (col == 2) {
                    $('#btnL' + caixa).attr('hidden', 'hidden');
                    var tempoEstimado = document.getElementById('previsao' + caixa).getElementsByTagName('span').namedItem('hora').innerHTML;
                    var validadosAux = parseInt($('#itens_validados').html());
                    validadosAux = validadosAux - 1;
                    $('#itens_validados').html(validadosAux);
                    var tempoTotal = parseInt($('#tempo_total').html());
                    tempoTotal = tempoTotal + parseInt(tempoEstimado.substr(0, 2));
                    $('#tempo_total').html(tempoTotal);
                    $('#previsao' + caixa).html(
                        '<center>Previsão de Inicio<br><span name="data"><?php echo date('d/m/Y'); ?></span><br><div style="height: 3px"></div>Tempo Estimado<br><span name="hora">' + tempoEstimado + '</span></center>');

                    $('#real' + caixa).html(
                        '<center>Previsão de Término<br><span name="data_termino"><?php echo date('d/m/Y'); ?></span><br><div style="height: 3px"></div>Tempo Realizado<br><span name="hora_termino">' + tempoEstimado + '</span></center>');

                }
                $('#btnU' + caixa).attr('hidden', 'hidden');
                $('#btnR' + caixa).removeAttr('hidden');

                //Atualiza botões
                var onclickAuxL = "moveHorizontal(" + caixa + ",'left'," + (col - 1) + ")";
                var onclickAuxR = "moveHorizontal(" + caixa + ",'right'," + (col - 1) + ")";
                var onclickAuxU = "moveVertical(" + caixa + ",'up'," + (col - 1) + ")";
                var onclickAuxD = "moveVertical(" + caixa + ",'down'," + (col - 1) + ")";
                $('#btnL' + caixa).attr("onclick", onclickAuxL);
                $('#btnR' + caixa).attr("onclick", onclickAuxR);
                $('#btnU' + caixa).attr("onclick", onclickAuxU);
                $('#btnD' + caixa).attr("onclick", onclickAuxD);

                //Verifica se é o unico da coluna
                var chave;
                if (ajuste.nextElementSibling.id == ('ajusteMax' + (col - 1))) {
                    $('#btnD' + caixa).attr('hidden', 'hidden');
                    chave = 1;
                } else {
                    $('#btnD' + caixa).removeAttr('hidden');
                    //Libera botão da caixa abaixo na coluna destino
                    var old = ajuste.nextElementSibling.firstElementChild.id;
                    old = old.split("U");
                    $('#btnU' + old[1]).removeAttr('hidden');
                }

                //Qual <br> deve retirar para manter a estrutura
                var randomResult = (Math.floor(Math.random() * 1000) + 250);
                var retiraBr;
                if (weel == 1) {
                    if (chave != 1) {
                        ajuste.insertAdjacentHTML('afterend', '<br id="ajuste' + randomResult + '">');
                    }
                } else {
                    if (weel == 2) {
                        if (chave != 1) {
                            ajuste.insertAdjacentElement('afterend', id.previousElementSibling);
                        } else {
                            id.previousElementSibling.remove();
                        }

                    } else {
                        if (chave != 1) {
                            ajuste.insertAdjacentElement('afterend', id.nextElementSibling);
                        } else {
                            id.nextElementSibling.remove();
                        }
                    }
                }

                //Insere a caixa na posição
                ajuste.insertAdjacentElement('afterend', id);
                if (col == 2) {
                    arrumaData(col);
                }
            } else {
                // Move-se para a direita
                var ajuste = document.getElementById('ajusteMax' + (col + 1));

                $.ajax({
                    type: "POST",
                    url: "recebe_suporte.php?id=" + caixa + "&lado=right",
                    success: function () {
                    }
                });

                // Botões que deve possuir
                if (col == 1) {
                    var tempoEstimado = document.getElementById('previsao' + caixa).getElementsByTagName('span').namedItem('hora').innerHTML;
                    var validadosAux = parseInt($('#itens_validados').html());
                    validadosAux = validadosAux + 1;
                    $('#itens_validados').html(validadosAux);
                    var tempoTotal = parseInt($('#tempo_total').html());
                    tempoTotal = tempoTotal - parseInt(tempoEstimado);
                    $('#tempo_total').html(tempoTotal);
                    $('#previsao' + caixa).html(
                        'Data Entregue<br><span name="data"><?php echo date('d/m/Y'); ?></span><br><div style="height: 3px"></div>Tempo Total<br><span name="hora">' + tempoEstimado + '</span>');
                    $('#real' + caixa).html('');
                }
                if (col == 2) $('#btnR' + caixa).attr('hidden', 'hidden');
                $('#btnD' + caixa).attr('hidden', 'hidden');
                $('#btnR' + caixa).attr('hidden', 'hidden');
                $('#btnL' + caixa).removeAttr('hidden');

                //Atualiza botões
                var onclickAuxL = "moveHorizontal(" + caixa + ",'left'," + (col + 1) + ")";
                var onclickAuxR = "moveHorizontal(" + caixa + ",'right'," + (col + 1) + ")";
                var onclickAuxU = "moveVertical(" + caixa + ",'up'," + (col + 1) + ")";
                var onclickAuxD = "moveVertical(" + caixa + ",'down'," + (col + 1) + ")";
                $('#btnL' + caixa).attr("onclick", onclickAuxL);
                $('#btnR' + caixa).attr("onclick", onclickAuxR);
                $('#btnU' + caixa).attr("onclick", onclickAuxU);
                $('#btnD' + caixa).attr("onclick", onclickAuxD);

                //Verifica se é o unico da coluna
                var chave;
                if (ajuste.previousElementSibling.id == ('ajuste0' + (col + 1))) {
                    $('#btnU' + caixa).attr('hidden', 'hidden');
                    chave = 1;
                } else {
                    $('#btnU' + caixa).removeAttr('hidden');
                    //Libera botão da caixa Acima na coluna destino
                    var old = ajuste.previousElementSibling.lastElementChild.id;
                    old = old.split("D");
                    $('#btnD' + old[1]).removeAttr('hidden');
                }

                //Qual <br> deve retirar para manter a estrutura
                var randomResult = (Math.floor(Math.random() * 1000) + 25);
                var retiraBr;
                if (weel == 1) {
                    if (chave != 1) {
                        ajuste.insertAdjacentHTML('beforebegin', '<br id="ajuste' + randomResult + '">');
                    }
                } else {
                    if (weel == 2) {
                        if (chave != 1) {
                            ajuste.insertAdjacentElement('beforebegin', id.previousElementSibling);
                        } else {
                            id.previousElementSibling.remove();
                        }

                    } else {
                        if (chave != 1) {
                            ajuste.insertAdjacentElement('beforebegin', id.nextElementSibling);
                        } else {
                            id.nextElementSibling.remove();
                        }
                    }
                }

                //Insere a caixa na posição
                ajuste.insertAdjacentElement('beforebegin', id);
                if (col == 1) {
                    arrumaData(col);
                }
            }
        }

        function imprimirRelatorio() {
            var xhr = new XMLHttpRequest();
            var arquivo = "ti_imprimirRelatorio.php?data=" + $('#relatorioMes').val();
            xhr.open('GET', arquivo, true);
            xhr.onreadystatechange = function () {
                if (this.readyState !== 4) return;
                if (this.status !== 200) return; // or whatever error handling you want
                document.getElementById('importaRelatorio').innerHTML = this.responseText;
            };
            xhr.send();
            $('#modalRelatorio').modal('show');
            // window.open("ti_imprimirRelatorio.php?data=" + $('#relatorioMes').val());
        }

        function enviaHora(id_suporte) {
            var tempoAux = $('#tempo'+id_suporte).val();
            $.ajax({
                method: "POST",
                url: "ajustes_evolucoes.php",
                data: {tempo: tempoAux, id_suporte: id_suporte}
            })
        }

        function estimaTempo(id_suporte) {
            alert(id_suporte);
            var tempoAux = $("#tempoestimado"+id_suporte).val();
            $.ajax({
                method: "POST",
                url: "ajustes_evolucoes.php",
                data: {estimaTempo: tempoAux, id_suporte: id_suporte}
            })
        }
    </script>
    <style type="text/css">

        .seta-1 {
            border-left: 18px solid #E8E8E8;
            border-top: 18px solid transparent;
            border-bottom: 18px solid transparent;
            float: left;
        }

    </style>

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
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Ajustes e Evoluções</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Ajustes e Evoluções
                                </li>
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
                            <a href="cadastrosuporte.php">
                                <button type="button" class="btn waves-effect waves-light btn-warning">Novo
                                    Cadastro
                                </button>
                            </a>
                            <div class="col-lg-3" style="float:right;">
                                <?php if($_SESSION['id'] == 1 || $_SESSION['id'] == 100) { ?>

                                <label for="imprimirRel">Imprimir Relatório:</label>
                                <button type="button" class="btn waves-effect waves-light btn-info" data-toggle="modal" data-target="#ModalRel" class="model_img img-fluid" title="Imprimir Cadastros"><i class="fa fa-print"></i>
                                </button>

                                <?php } ?>

                                <br>
                                <br>

                                <div id="ModalRel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Relatório Horas</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="gera_relhoras.php" method="post" name="horas">


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Colaborador</label>
                                                        <select name="id_programador" class="form-control" id="produto" required>
                                                            <option value="" selected>Selecione...</option>
                                                            <?php 

                                                            $sql_colaboradores = mysqli_query($con, "select * from usuarios WHERE departamento = '14' order by nome ASC");

                                                            while($vetor_colaborador = mysqli_fetch_array($sql_colaboradores)) {

                                                            ?>
                                                            <option value="<?php echo $vetor_colaborador['id_usuario']; ?>"><?php echo $vetor_colaborador['nome']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Data Início</label>
                                                        <input type="date" name="datainicio" class="form-control"
                                                               required>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputPassword1">Data Fim</label>
                                                        <input type="date" name="datafim" class="form-control" required>
                                                    </fieldset>
                                                </div>
                                            </div><!--.row-->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" style="    float: left;">Gerar Relatório</button>
                                            </form>
                                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>

                            </div>
                            <!--                                <div style="position: absolute;z-index: 3;bottom: -3px;right: -3px">-->
                            <!--                                    <button type="button"-->
                            <!--                                            class="btn btn-md"-->
                            <!--                                            data-toggle="modal"-->
                            <!--                                            style="color: white"-->
                            <!--                                            data-target="#enviar_hora"><span-->
                            <!--                                                class="far fa-md fa-clock"></span>-->
                            <!--                                    </button>-->
                            <!--                                </div>-->
                            <div id="modalRelatorio" class="modal fade"
                                 role="dialog" aria-hidden="true" tabindex="-1">
                                <div class="modal-dialog" role="document" style=";display:table;">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Relatorio</h4>
                                        </div>
                                        <div class="modal-body" id="importaRelatorio"
                                             style="display:table-cell; vertical-align:middle; text-align:center;width: 1200px">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                    class="btn btn-default"
                                                    data-dismiss="modal">Fechar
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="tab-content tabcontent-border">
                                <table class="table table-bordered">
                                    <tr align="center">
                                        <td valign="top" width="33%">
                                            <div style="width:200px;"><strong><h4>Desenvolvimento</h4></strong>
                                            </div>
                                        </td>
                                        <td valign="top" width="33%">
                                            <div style="width:200px;"><strong><h4>Validação</h4></strong></div>
                                        </td>
                                        <td valign="top" width="33%">
                                            <div style="width:200px;"><strong><h4>Finalizados</h4></strong></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <?php
                                        for ($i = 1;
                                             $i < 4;
                                             $i++) {
                                            if ($i == 1) {
                                                $dia = 0;
                                                $hora = 0;
                                                $minuto = 0;
                                            }
                                            $pr = 0;
                                            ?>
                                            <td>
                                                <center>
                                                    <?php
                                                    //                                                $date = date("Y-m-d");
                                                    //                                                echo date("d/m/Y", strtotime($date . '+ ' . $dia . ' days'));
                                                    $date = date("Y-m-d");
                                                    if ($i == 1) echo "<strong>Data Prevista de Término<br></strong><span id='data_prevista'>" . date("d/m/Y", strtotime($date . '+ ' . $tempo_total[0] . ' days'))
                                                        . "</span><br><strong>Tempo Total Estimado<br> </strong><span id='tempo_total'>"
                                                        . ((int)$tempo_total[1] < 10 ? '0'.$tempo_total[1]:$tempo_total[1]) . "</span> h "
                                                        . ($tempo_total[2] == 0?'':($tempo_total[2] < 10?'e 0'.$tempo_total[2].' min':'e '.$tempo_total[2].' min')) . " <hr>";
                                                    else {
                                                        if ($i == 2) echo "<br><strong>Itens a serem validados<br></strong><span id='itens_validados'>" . $validados . "</span><br><br><hr>";
                                                        else
                                                            if ($i == 3) echo "<br><strong>Itens finalizados<br></strong><span id='itens_finalizados'>" . $finalizados . "</span><br><br><hr>";
                                                    }
                                                    ?>
                                                </center>
                                                <div align="center">
                                                    <?php if ($pr == 0) { ?>
                                                        <br id="ajuste0<?php echo $i; ?>">
                                                    <?php } ?>
                                                    <?php while (($dado = array_pop($dados)) and (int)$dado['status'] == $i) {
                                                        if ($i == 1) {
                                                            $auxPrevisao = explode(':', substr($dado['tempo_estimado'], 1, 5));
                                                            $minuto = $auxPrevisao[1] + $minuto;
                                                            if ($minuto > 60) {
                                                                $minuto = $minuto - 60;
                                                                $hora++;
                                                            }
                                                            $hora = $auxPrevisao[0] + $hora;
                                                            if ($hora > 8) {
                                                                $hora = $hora - 8;
                                                                $dia++;
                                                            }
                                                        }
                                                        ?>
                                                        <?php if ($pr == 0) {
                                                        } else { ?>
                                                            <br id="ajuste<?php echo $dado['id']; ?>">
                                                        <?php } ?>
                                                        <div id="box<?php echo $dado['id']; ?>"
                                                             style="background-color: <?php echo $departamento[$dado['id_departamento']]['cor'] ?>;
                                                                     border-radius: 20px;
                                                                     color: white;
                                                                     margin: auto;
                                                                     width: 400px;
                                                                     height: 200px;
                                                                     align-content: center;
                                                                     justify-content: center;
                                                                     position: relative;">
                                                            <?php
                                                            if ($_SESSION['id'] == 100 || $_SESSION['id'] == 1) {
                                                                if ($pr == 0) {
                                                                    $pr = 1;
                                                                    $pr = 1; ?>
                                                                    <button id="btnU<?php echo $dado['id']; ?>"
                                                                            onclick="moveVertical(<?php echo $dado['id']; ?>,'up',<?php echo $i; ?>)"
                                                                            class="btn btn-md"
                                                                            style="color: white;position: absolute;top: 0;left: 44%;z-index: 1"
                                                                            hidden="hidden"><span
                                                                                class="far fa-lg fa-arrow-alt-circle-up"></span>
                                                                    </button>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <button id="btnU<?php echo $dado['id']; ?>"
                                                                            onclick="moveVertical(<?php echo $dado['id']; ?>,'up',<?php echo $i; ?>)"
                                                                            class="btn btn-md"
                                                                            style="color: white;position: absolute;top: 0;left: 44%;z-index: 1"><span
                                                                                class="far fa-lg fa-arrow-alt-circle-up"></span>
                                                                    </button>
                                                                <?php }
                                                            } ?>
                                                            <h4>
                                                                <strong style="float: left;margin-left: 3%;margin-top: 3%;"><?php echo $departamento[$dado['id_departamento']]['nome']; ?></strong>
                                                            </h4>
                                                            <h6  style="position: absolute;left: 3%;top:18%;">
                                                                Cod: <?php echo ((int)$dado['id'] < 100 ?'0'.((int)$dado['id'] < 10 ?'0'.$dado['id']:$dado['id']):$dado['id']); ?>
                                                            </h6>
                                                            <i class="mdi mdi-36px mdi-checkbox-blank-circle-outline"
                                                               style="position: absolute;right: 7px;top: -4px"></i>
                                                            <?php if ($dado['tipo'] == 'ajuste') { ?>
                                                                <span class="fas fa-lg fas fa-cog"
                                                                      style="float: right;margin-right: 4%;margin-top: 4%"></span>
                                                                <!--                                                                <i class="mdi mdi-18px mdi-wrench"-->
                                                                <!--                                                                   style="float: right;margin-right: 4%;margin-top: 2%"></i>-->
                                                            <?php } elseif ($dado['tipo'] == 'desenv') { ?>
                                                                <span class="fas fa-lg fa-chart-line"
                                                                      style="float: right;margin-right: 4%;margin-top: 4%"></span>
                                                                <!--                                                                <i class="mdi mdi-18px mdi-lightbulb-on-outline"-->
                                                                <!--                                                                   style="float: right;margin-right: 4%;margin-top: 2%"></i>-->
                                                            <?php } else { ?>
                                                                <i class="mdi mdi-18px mdi-wrench"
                                                                   style="float: right;margin-right: 4%;margin-top: 2%"></i>
                                                            <?php } ?>
                                                            <?php if ($i == 1 and $_SESSION['id'] == 100 || $_SESSION['id'] == 1) { ?>
                                                                <div style="position: absolute;z-index: 3;bottom: -3px;right: -3px">
                                                                    <button type="button"
                                                                            class="btn btn-md"
                                                                            data-toggle="modal"
                                                                            style="color: white"
                                                                            data-target="#enviar_hora"><span
                                                                                class="far fa-md fa-clock"></span>
                                                                    </button>
                                                                </div>
                                                                <div id="enviar_hora" class="modal fade"
                                                                     role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <!-- Modal content-->
                                                                        <div class="modal-content" style="color: black">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Enviar Hora</h4>
                                                                            </div>
                                                                            <form action="recebe_tempogasto.php?id=<?php echo $dado['id']; ?>" method="post" name="Tempo">
                                                                            <div class="modal-body">
                                                                                <input name="tempo" type="time" size="4" required>
                                                                                <button type="submit" class="btn btn-sm btn-success">
                                                                                    Enviar
                                                                                </button>
                                                                            </form>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit"
                                                                                        class="btn btn-default"
                                                                                        data-dismiss="modal">Fechar
                                                                                </button>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <div style="display: block;position: absolute;width: 400px;height:200px;align-content: center;">
                                                                <br>
                                                                <br>

                                                                <div style="width: 305px;height: 95px;margin-top: 4%">

                                                                    <h5>
                                                                        <strong><?php echo $dado['assunto'] ?></strong>
                                                                    </h5>

                                                                    <?php if($dado['id_responsavel'] == NULL) { 

                                                                    if($_SESSION['id'] == 1 || $_SESSION['id'] == 100) {

                                                                    ?>

                                                                    <button class="btn btn-md"><a style="color: white" href="#" data-toggle="modal" data-target=".ModalPrestador-<?php echo $dado['id']; ?>" class="model_img img-fluid"><i
                                                                                        class="fas fa-code"></i></a>
                                                                    </button>

                                    

                                                                    <?php 

                                                                    } 

                                                                    } else {

                                                                        if($dado['nomedesenvolvedor'] == '') {

                                                                            $sql_desenvolvedor = mysqli_query($con, "select * from usuarios WHERE id_usuario = '$dado[id_responsavel]'");
                                                                            $vetor_desenvolvedor = mysqli_fetch_array($sql_desenvolvedor);

                                                                            $nomedesenvolvedor = explode(' ', $vetor_desenvolvedor['nome']);

                                                                            if($dado['id_responsavel'] == 100) { echo 'Conte Tecnologia: '.$nomedesenvolvedor[0]; } else { echo 'StudioM: '.$nomedesenvolvedor[0]; }

                                                                            
                                                                        } else {

                                                                            $nomedesenvolvedor = explode(' ', $dado['nomedesenvolvedor']);


                                                                            if($dado['id_responsavel'] == 100) { echo 'Conte Tecnologia: '.$nomedesenvolvedor[0]; } else { echo 'StudioM: '.$nomedesenvolvedor[0]; }

                                                                        }

                                                                    }

                                                                    ?>
                                                                    <h6 id="previsao<?php echo $dado['id']; ?>"
                                                                        class="tempoEstimado" align="left"
                                                                        style="position: absolute;bottom: -2px;left: 13px;">
                                                                        <center>
                                                                            <?php if ($i == 1) { ?>

                                                                                Previsão de Inicio <br>

                                                                                <span name="data">
                                                                                <?php
                                                                                $date = date("Y-m-d");
                                                                                --$dia;
                                                                                if ($dia > 0) {
                                                                                    echo date("d/m/Y", strtotime($date . '+ ' . $dia . ' days'));
                                                                                } else {
                                                                                    echo date("d/m/Y");
                                                                                }
                                                                                ?>
                                                                                </span>

                                                                                <br>
                                                                                <div style="height: 3px"></div>
                                                                                Tempo Estimado <br>
                                                                                <?php
                                                                                if ($dado['tempo_estimado'] != '00:00:00') {
                                                                                    echo '<span name="hora">' . substr($dado['tempo_estimado'], 0, 2) . 'h ' . (substr($dado['tempo_estimado'], 3, 2) != '00' ? substr($dado['tempo_estimado'], 3, 2) . 'min' : '') . '</span>';
                                                                                } elseif($_SESSION['id'] == 100 || $_SESSION['id'] == 1){
                                                                                    echo '<br><button type="button" class="btn btn-md" data-toggle="modal" style="position: absolute;bottom: -10px;left: 35px;color: #ffffff" data-target="#tempo_estimado"><span class="far fa-md fa-clock"></span></button>';
                                                                                }else{
                                                                                    echo 'A Definir';
                                                                                }?>
                                                                                <div id="tempo_estimado"
                                                                                     class="modal fade" role="dialog">
                                                                                    <div class="modal-dialog">
                                                                                        <!-- Modal content-->
                                                                                        <div class="modal-content"
                                                                                             style="color: black">
                                                                                            <div class="modal-header">
                                                                                                <h4 class="modal-title">
                                                                                                    Definir Tempo
                                                                                                    Estimado</h4>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <form action="recebe_tempoagastar.php?id=<?php echo $dado['id']; ?>" method="post" name="tempo">

                                                                                                <input type="time" name="tempo">
                                                                                                <button type="submit"
                                                                                                        class="btn btn-success btn-sm">
                                                                                                    Enviar
                                                                                                </button>
                                                                                                </form>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button type="button"
                                                                                                        class="btn btn-default"
                                                                                                        data-dismiss="modal">
                                                                                                    Fechar
                                                                                                </button>
                                                                                            </form>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </center>
                                                                    </h6>
                                                                    <h6 id="real<?php echo $dado['id']; ?>"
                                                                        class="tempoEstimado" align="left"
                                                                        style="position: absolute;bottom: -2px;right: 13px;">
                                                                        <center>
                                                                            <?php if ($i == 1) { ?>

                                                                                Previsão de Término <br>

                                                                                <span name="data_termino">
                                                                                <?php
                                                                                $date = date("Y-m-d");
                                                                                echo date("d/m/Y", strtotime($date . '+ ' . ++$dia . ' days'));
                                                                                ?>
                                                                                </span>

                                                                                <br>

                                                                                <div style="height: 3px"></div>


                                                                                Tempo Realizado <br>
                                                                                <?php
                                                                                if ($dado['tempo_total'] != null) {
                                                                                    echo '<span name="hora_termino">' . substr($dado['tempo_total'], 0, 2) . 'h ' . (substr($dado['tempo_total'], 3, 2) != '00' ? substr($dado['tempo_total'], 3, 2) . 'min' : '') . '</span>';
                                                                                }
                                                                                ?>

                                                                            <?php } else {
                                                                                if ($i == 2) { ?>
                                                                                    Data Entregue <br>
                                                                                    <?php echo date("d/m/Y", strtotime($dado['data_entregue'])); ?>
                                                                                    <br>
                                                                                    <div style="height: 3px"></div>
                                                                                    Tempo Realizado <br>
                                                                                    <?php
                                                                                    echo '<span name="hora">' . substr($dado['tempo_total'], 0, 2) . 'h ' . (substr($dado['tempo_total'], 3, 2) != '00' ? substr($dado['tempo_total'], 3, 2) . 'min' : '') . '</span>';
                                                                                } elseif ($i == 3) { ?>
                                                                                    Finalizado<br>
                                                                                    <?php echo date("d/m/Y", strtotime($dado['data_entregue'])); ?>
                                                                                    <br>
                                                                                    <div style="height: 3px"></div>
                                                                                    Tempo Total <br>
                                                                                    <?php
                                                                                    echo '<span name="hora_termino">' . substr($dado['tempo_total'], 0, 2) . 'h ' . (substr($dado['tempo_total'], 3, 2) != '00' ? substr($dado['tempo_total'], 3, 2) . 'min' : '') . '</span>';
                                                                                }
                                                                            } ?>
                                                                        </center>
                                                                    </h6>
                                                                        <button style="width: 90px;height:auto;position:absolute;bottom: 30px;left: 39%"
                                                                                class="btn btn-md"><a
                                                                                    style="color: white"
                                                                                    href="versuporte.php?id=<?php echo $dado['id']; ?>" target="_blank"><i
                                                                                        class="far fa-lg fa-edit"></i></a>
                                                                        </button>
                                                                </div>
                                                            </div>


                                                            <br>

                                                            <?php
                                                            if ($_SESSION['id'] == 100) {
                                                                if ($i == 1) { ?>
                                                                    <button id="btnR<?php echo $dado['id']; ?>"
                                                                            onclick="moveHorizontal(<?php echo $dado['id']; ?>,'right',<?php echo $i; ?>)"
                                                                            class="btn btn-md"
                                                                            style="color: white;position: absolute;top: 44%;right: -1%;"><span
                                                                                class="far fa-lg fa-arrow-alt-circle-right"></span>
                                                                    </button>
                                                                <?php } else { ?>
                                                                    <button id="btnR<?php echo $dado['id']; ?>"
                                                                            onclick="moveHorizontal(<?php echo $dado['id']; ?>,'right',<?php echo $i; ?>)"
                                                                            class="btn btn-md"
                                                                            style="color: white;position: absolute;top: 44%;right: -1%;"
                                                                            hidden><span
                                                                                class="far fa-lg fa-arrow-alt-circle-right"></span>
                                                                    </button>
                                                                <?php }
                                                                if ($i > 1) { ?>
                                                                    <button id="btnL<?php echo $dado['id']; ?>"
                                                                            onclick="moveHorizontal(<?php echo $dado['id']; ?>,'left',<?php echo $i; ?>)"
                                                                            class="btn btn-md"
                                                                            style="color: white;position: absolute;top: 44%;left: -1%;"><span
                                                                                class="far fa-lg fa-arrow-alt-circle-left"></span>
                                                                    </button>
                                                                <?php } else { ?>
                                                                    <button id="btnL<?php echo $dado['id']; ?>"
                                                                            onclick="moveHorizontal(<?php echo $dado['id']; ?>,'left',<?php echo $i; ?>)"
                                                                            class="btn btn-md"
                                                                            style="color: white;position: absolute;top: 44%;left: -1%;"
                                                                            hidden><span
                                                                                class="far fa-lg fa-arrow-alt-circle-left"></span>
                                                                    </button>
                                                                <?php } ?>
                                                                <br>
                                                                <?php if (count($dados) > 0 and !($dados[count($dados) - 1]['status'] != $i)) { ?>
                                                                    <button id="btnD<?php echo $dado['id']; ?>"
                                                                            onclick="moveVertical(<?php echo $dado['id']; ?>,'down',<?php echo $i; ?>)"
                                                                            class="btn btn-md"
                                                                            style="color: white;position:absolute;bottom: 0;left: 44%;"><span
                                                                                class="far fa-lg fa-arrow-alt-circle-down"></span>
                                                                    </button>
                                                                <?php } else { ?>
                                                                    <button id="btnD<?php echo $dado['id']; ?>"
                                                                            onclick="moveVertical(<?php echo $dado['id']; ?>,'down',<?php echo $i; ?>)"
                                                                            class="btn btn-md"
                                                                            style="color: white;position:absolute;bottom: 0;left: 44%;"
                                                                            hidden><span
                                                                                class="far fa-lg fa-arrow-alt-circle-down"></span>
                                                                    </button>
                                                                <?php }
                                                            } ?>
                                                        </div>
                                                    <div class="modal fade ModalPrestador-<?php echo $dado['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel">Selecionar Desenvolvedor</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="recebe_desenvolvedordemanda.php?id=<?php echo $dado['id']; ?>" method="post" name="demanda">

                                                <div class="row">
                                                <div class="col-lg-6">
                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputEmail1">Colaborador</label>
                                                        <select name="id_programador" class="form-control" id="produto" required>
                                                            <option value="" selected>Selecione...</option>
                                                            <?php 

                                                            $sql_colaboradores = mysqli_query($con, "select * from usuarios WHERE departamento = '14' order by nome ASC");

                                                            while($vetor_colaborador = mysqli_fetch_array($sql_colaboradores)) {

                                                            ?>
                                                            <option value="<?php echo $vetor_colaborador['id_usuario']; ?>"><?php echo $vetor_colaborador['nome']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </fieldset>
                                                </div>

                                                <div class="col-lg-6">

                                                    <div id="palco">

                                                    <div id="1">

                                                    <div class="col-md-12">

                                                    <fieldset class="form-group">
                                                        <label class="form-label" for="exampleInputPassword1">Desenvolvedor</label>
                                                        <input type="text" name="nomedesenvolvedor" class="form-control">
                                                    </fieldset>

                                                </div>

                                                </div>

                                                </div>
                                                </div>

                                            </div><!--.row-->

                                            </div>
                                            <div class="modal-footer">

                                                <button type="submit" class="btn btn-primary" style="    float: left;">Cadastrar</button>
                                                </form>

                                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                                    <?php }
                                                    array_push($dados, $dado);
                                                    ?>
                                                    <br id="ajusteMax<?php echo $i; ?>">
                                                </div>

                                            </td>

                                        <?php } ?>
                                    </tr>
                                </table>
                            </div>

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