<?php

include "../includes/conexao.php";

session_start();

if ($_SESSION['id_formando'] == NULL || $_SESSION['id_formando'] == '') {

    echo "<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";

} else {
    function calculaParcelas($valor,$dataentrega, $max_parcela)
    {
        $data_final_parcelamento = date('Y-m', strtotime('+6 months', strtotime(substr($dataentrega, 0, 7))));
        $dataatual = date('Y-m', strtotime('+1 month')); // Montando a data do 1 boletos
        $calcula_parcelas = strtotime($data_final_parcelamento) - strtotime($dataatual);
        $parcelas = (int)floor($calcula_parcelas / (60 * 60 * 24 * 30));
        if ($parcelas >= $max_parcela) {
            $parcelas = $max_parcela;
        } else {
            $parcelas += 1;
        }
        while (floor($valor/$parcelas) < 50){
            $parcelas--;
        }
        return $parcelas;
    }

    $vetor_cadastro = mysqli_fetch_array(mysqli_query($con, "select * from formandos where id_formando = '{$_SESSION['id_formando']}'"));

    $dataatual = date('Y-m-d');
    $data_limite = date('Y-m-d', strtotime("+5 days", strtotime($dataatual)));
    $produto = $_GET['produto'];

    $sql_pacotes = mysqli_query($con, "select * from pacotes_itens_album where id_pacote = '{$produto}' and id_item not in (
    select id_pacote from vendas where id_formando = '{$_SESSION['id_formando']}' and (tipo = '2' or tipo = '4') and produto = '{$produto}' and status = '3'
) and (data_limite >= '{$data_limite}' or data_limite is NULL) order by id_item ASC");
    $pacotes = mysqli_fetch_array(mysqli_query($con, "select * from pacotes where id_pacote = '{$produto}'"));

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

        <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript">
            $(window).load(function () {

                function id(el) {
                    //return document.getElementById( el );
                    return $(el);
                }

                function calcTotal(un01, qnt01) {
                    return un01 * qnt01;
                }

                function getElementParent(event) {
                    return event.srcElement.parentNode.parentNode.getAttribute('id');
                }

                function getValorUnitario(elParent) {
                    return $('#' + elParent + ' .class_unit input').val();
                }

                function getQuantidade(elParent) {
                    return $('#' + elParent + ' .class_quant input').val();
                }

                function setFieldTotal(elParent, valueUnit, valueQuant) {
                    id('#' + elParent + ' .class_total input').val(calcTotal(valueUnit, valueQuant).toFixed(2));
                    setTotalFinal();
                }

                function setTotalFinal() {

                    var total = 0;
                    $('#table-shop tr .class_total input').each(function () {
                        if (this.value != '') {
                            var valor = this.value;
                            total += parseFloat(valor);
                        }
                    });
                    $('#total .value_total').html(total.toFixed(2));
                    $('#total .value_total').val(total.toFixed(2));
                }

                $(document).ready(function () {
                    id('#table-shop tr .class_unit').keyup(function (event) {
                        var elemenPai = getElementParent(event);
                        var valueUnit = getValorUnitario(elemenPai);
                        var valueQuant = getQuantidade(elemenPai);

                        setFieldTotal(elemenPai, valueUnit, valueQuant);
                    });

                    id('#table-shop tr .class_quant').keyup(function (event) {
                        var elemenPai = getElementParent(event);
                        var valueUnit = getValorUnitario(elemenPai);
                        var valueQuant = getQuantidade(elemenPai);

                        setFieldTotal(elemenPai, valueUnit, valueQuant);
                    });
                });


            });

        </script>
        <style>
            .pinta {
                background-color: #f2f2f2;
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
                    <a class="navbar-brand" href="inicio.php">
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
                                        src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>" alt="user"
                                        class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img
                                                src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"
                                                alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?php echo $vetor_cadastro['nome']; ?></h4>
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
                        <h4 class="page-title">Minhas Compras</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Minhas Compras</li>
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
                                <div class="row">
                                    <div class="container-fluid">
                                        <!-- ============================================================== -->
                                        <!-- Start Page Content -->
                                        <!-- ============================================================== -->
                                        <div class="row">
                                            <!-- Column -->
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table product-overview">
                                                                <thead align="center">
                                                                <tr>
                                                                    <th style="background-color: #f2f2f2;border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;"><h5><strong>Pacote(s)</strong>
                                                                        </h5></th>
                                                                    <th style="border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;"><h5><strong>Item(s) do Pacote</strong></h5></th>
                                                                    <th style="background-color: #f2f2f2;border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;"><h5><strong>Evento(s)</strong>
                                                                        </h5></th>
                                                                    <th style="border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;"><h5><strong>Forma(s) de Pagamento</strong></h5>
                                                                    </th>
                                                                    <th style="background-color: #f2f2f2;border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;"><h5><strong>Valor</strong>
                                                                        </h5></th>
                                                                    <th style="border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;"><h5><strong>Ação</strong></h5></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $pinta = 1;
                                                                while ($vetor_pacotes = mysqli_fetch_array($sql_pacotes)) {
                                                                    $pagamentos = 1;
                                                                    if($vetor_pacotes['pacote_especial'] == '3'){
                                                                        $data_final_parcelamento = strtotime($vetor_pacotes['data_limite']);
                                                                        $dataatual = strtotime(date('Y-m-d',strtotime('+1 month',strtotime(date('Y-m-d')))));
                                                                        $libera = (int)floor(($data_final_parcelamento - $dataatual)/(60*60*24*30));
                                                                        if($libera < 1){
                                                                            $pagamentos = 2;
                                                                        }
                                                                    }
                                                                    $formapag_pacote = mysqli_query($con, "select * from formaspag_pacote WHERE id_pacote = '{$vetor_pacotes['id_item']}'");
                                                                    $formapag = mysqli_query($con, "select * from formaspag");
                                                                    $formas = array();
                                                                    while ($forma = mysqli_fetch_array($formapag)) {
                                                                        $formas[$forma['id_forma']]['ativo'] = 0;
                                                                    }
                                                                    while ($forma = mysqli_fetch_array($formapag_pacote)) {
                                                                        $formas[$forma['id_forma']]['ativo'] = 1;
                                                                        $formas[$forma['id_forma']]['qtdparcelas'] = $forma['qtdparcelas'];
                                                                    }
                                                                    if ($vetor_cadastro['comissao'] == 2) {
                                                                        $valorinicial = $vetor_pacotes['valorcomissao'];
                                                                    } else {
                                                                        $valorinicial = $vetor_pacotes['valor'];
                                                                    }
                                                                    $datadesconto = $pacotes['dataabertura'];
                                                                    $dataatual = date('Y-m-d');
                                                                    $calcula_dias = strtotime($dataatual) - strtotime($datadesconto);
                                                                    $diferenca_dias = (int)floor($calcula_dias / (60 * 60 * 24));
                                                                    if ($diferenca_dias <= 30 && ($vetor_pacotes['pacote_especial'] == 2 || $vetor_pacotes['pacote_especial'] == 1)) {
                                                                        $valor_avista = $valorinicial - ($valorinicial * $pacotes['desconto'] / 100);
                                                                    } else {
                                                                        $valor_avista = $valorinicial;
                                                                    }
                                                                    if($vetor_pacotes['pacote_especial'] != 2){
                                                                        $max_parcela = ($formas['3']['qtdparcelas'] > 0?$formas['3']['qtdparcelas']:((int)$vetor_pacotes['qtdparcelas'] == 0?'1':(int)$vetor_pacotes['qtdparcelas']));
                                                                        $parcela_credito = $max_parcela;
                                                                        $max_parcela = ($formas['2']['qtdparcelas'] > 0?$formas['2']['qtdparcelas']:((int)$vetor_pacotes['qtdparcelas'] == 0?'1':(int)$vetor_pacotes['qtdparcelas']));
                                                                        $parcela_antecipado = $max_parcela;
                                                                        $valor_credito = number_format(($valorinicial / $parcela_credito), 2, ',', '.');
                                                                        $valor_avista = number_format($valor_avista, 2, ',', '.');
                                                                        $valor_antecipado = number_format(($valorinicial / $parcela_antecipado), 2, ',', '.');
                                                                        $valor_pos = number_format(($valorinicial / ((int)$vetor_pacotes['qtdparcelas'] == 0?'1':(int)$vetor_pacotes['qtdparcelas'])), 2, ',', '.');
                                                                    }else {
                                                                        $max_parcela = ($formas['3']['qtdparcelas'] > 0?$formas['3']['qtdparcelas']:12);
                                                                        $parcela_credito = calculaParcelas($valorinicial,$pacotes['dataentrega'], $max_parcela);
                                                                        $max_parcela = ($formas['2']['qtdparcelas'] > 0?$formas['2']['qtdparcelas']:90);
                                                                        $parcela_antecipado = calculaParcelas($valorinicial,$pacotes['dataentrega'], $max_parcela);
                                                                        $valor_credito = number_format(($valorinicial / $parcela_credito), 2, ',', '.');
                                                                        $valor_avista = number_format($valor_avista, 2, ',', '.');
                                                                        $valor_antecipado = number_format(($valorinicial / $parcela_antecipado), 2, ',', '.');
                                                                        $valor_pos = number_format(($valorinicial / 6), 2, ',', '.');
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td style="border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;vertical-align: middle;line-height: normal;<?php if ($pinta == 1) {
                                                                            echo "background-color:#f2f2f2;";
                                                                            $pinta = 0;
                                                                        } else {
                                                                            $pinta = 1;
                                                                        } ?>">
                                                                            <h6><?php echo ucfirst($vetor_pacotes['titulo']); ?></h6>
                                                                        </td>
                                                                        <td style="border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;vertical-align: middle;<?php if ($pinta == 1) {
                                                                            echo "background-color:#f2f2f2;";
                                                                            $pinta = 0;
                                                                        } else {
                                                                            $pinta = 1;
                                                                        } ?>">
                                                                            <?php
                                                                            $sql_itens = mysqli_query($con, "select * from pacotes_itens_produtos WHERE id_pacote = '{$vetor_pacotes['id_item']}' order by id_produto_item ASC");
                                                                            if (mysqli_num_rows($sql_itens) > 0) {
                                                                                while ($vetor_item = mysqli_fetch_array($sql_itens)) {
                                                                                    $sql_produto = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '{$vetor_item['id_produto']}'");
                                                                                    $vetor_produto = mysqli_fetch_array($sql_produto);
                                                                                    echo ($vetor_item['id_produto'] == 13 || $vetor_item['id_produto'] == 15 || $vetor_item['id_produto'] == 19 || $vetor_item['id_produto'] == 12 || $vetor_item['id_produto'] == 11 || $vetor_item['id_produto'] == 10 || $vetor_item['id_produto'] == 20 ? '01 ' : ($vetor_item['qtdpaginas'] > 9 ? $vetor_item['qtdpaginas'] : '0' . $vetor_item['qtdpaginas'])) . " - " . $vetor_produto['nome'] . ($vetor_item['id_produto'] == 13 || $vetor_item['id_produto'] == 15 || $vetor_item['id_produto'] == 19 || $vetor_item['id_produto'] == 12 || $vetor_item['id_produto'] == 11 || $vetor_item['id_produto'] == 10 || $vetor_item['id_produto'] == 20 ? ' - ' . $vetor_item['qtdpaginas'] . ' pág(s)' : '') . "<br>";
                                                                                } ?>

                                                                            <?php } ?>
                                                                        </td>
                                                                        <td style="border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;vertical-align: middle;<?php if ($pinta == 1) {
                                                                            echo "background-color:#f2f2f2;";
                                                                            $pinta = 0;
                                                                        } else {
                                                                            $pinta = 1;
                                                                        } ?>">
                                                                            <?php

                                                                            $sql_eventos = mysqli_query($con, "select * from eventos_pacote WHERE id_pacote = '{$vetor_pacotes['id_item']}' order by id_evento_pacote ASC");
                                                                            $i = 0;
                                                                            while ($vetor_eventos = mysqli_fetch_array($sql_eventos)) {

                                                                                $sql_evento = mysqli_query($con, "select * from eventos_turma_lista where id_evento_turma = '{$vetor_eventos['id_evento']}'");
                                                                                $vetor_evento = mysqli_fetch_array($sql_evento);

                                                                                $sql_evento_nome = mysqli_query($con, "select * from categoriaevento where id_categoria = '{$vetor_evento['id_evento']}'");
                                                                                $vetor_evento_nome = mysqli_fetch_array($sql_evento_nome);
                                                                                echo $vetor_evento_nome['nome'].' '.$vetor_evento['preevento']."<br>";  
                                                                            }

                                                                            ?>
                                                                        </td>
                                                                        <td style="border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;<?php if ($pinta == 1) {
                                                                            echo "background-color:#f2f2f2;";
                                                                            $pinta = 0;
                                                                        } else {
                                                                            $pinta = 1;
                                                                        } ?>">
                                                                            <?php if ($formas['8']['ativo'] == 1 || $formas['2']['ativo'] == 1 || $formas['18']['ativo'] == 1) { ?>
                                                                                <strong>Boleto Bancário</strong>
                                                                                <br>
                                                                                <?php if ($formas['18']['ativo'] == 1) { ?>
                                                                                    <div style="margin-left: 20px">
                                                                                    <strong>À vista:</strong>
                                                                                    R$<?php echo $valor_avista; ?>
                                                                                    </div><?php } ?>
                                                                                <?php if ($formas['22']['ativo'] == 1) { ?>
                                                                                    <div style="margin-left: 20px">
                                                                                        <strong>Data Limite:</strong>em
                                                                                        (1x)
                                                                                        R$<?php echo $valor_avista; ?>
                                                                                    </div>
                                                                                <?php } ?>
                                                                                <?php if ($formas['2']['ativo'] == 1 && $pagamentos == 1) { ?>
                                                                                    <div style="margin-left: 20px">
                                                                                        <strong>Antecipado:</strong> até
                                                                                        (<?php echo $parcela_antecipado; ?>x)
                                                                                        R$<?php echo $valor_antecipado; ?>
                                                                                    </div>
                                                                                <?php } ?>
                                                                                <?php if ($formas['8']['ativo'] == 1 && $pagamentos == 1) { ?>
                                                                                    <div style="margin-left: 20px">
                                                                                    <strong>Pós Formatura:</strong> até
                                                                                    (6x) R$<?php echo $valor_pos; ?>
                                                                                    </div><?php } ?>
                                                                            <?php }
                                                                            if ($formas['3']['ativo'] == 1 && $pagamentos == 1) {
                                                                                ?>
                                                                                <br>
                                                                                <strong>Cartão de
                                                                                    Crédito</strong> até (<?php echo $parcela_credito; ?>x) R$<?php echo $valor_credito; ?>
                                                                            <?php } ?>
                                                                        </td>
                                                                        <td style="border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;vertical-align: middle;<?php if ($pinta == 1) {
                                                                            echo "background-color:#f2f2f2;";
                                                                            $pinta = 0;
                                                                        } else {
                                                                            $pinta = 1;
                                                                        } ?>" align="center">
                                                                            R$ <?php if ($vetor_cadastro['comissao'] == 2) {
                                                                                echo $num1 = number_format($vetor_pacotes['valorcomissao'], 2, ',', '.');
                                                                            } else {
                                                                                echo $num1 = number_format($vetor_pacotes['valor'], 2, ',', '.');
                                                                            } ?>
                                                                        </td>
                                                                        <td style="border-bottom: 2px solid #1066bb4a;border-top: 2px solid #1066bb4a;vertical-align: middle;<?php if ($pinta == 1) {
                                                                            echo "background-color:#f2f2f2;";
                                                                            $pinta = 0;
                                                                        } else {
                                                                            $pinta = 1;
                                                                        } ?>">
                                                                            <div class="col-sm-12">
                                                                                <a href="compra_album_pagamento.php?id_pacote=<?php echo $vetor_pacotes['id_item']; ?>">
                                                                                    <button type="button"
                                                                                            class="btn btn-block btn-primary">
                                                                                        Comprar Pacote
                                                                                    </button>
                                                                                </a>
                                                                                <br>
                                                                                <a href="detalhes_pacote.php?id=<?php echo $vetor_pacotes['id_item']; ?>">
                                                                                    <button type="button"
                                                                                            class="btn btn-block btn-warning"
                                                                                            style="margin-top: -15px">
                                                                                        Ver Detalhes
                                                                                    </button>
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Column -->
                                        </div>
                                        <!-- ============================================================== -->
                                        <!-- End PAge Content -->
                                        <!-- ============================================================== -->
                                        <!-- ============================================================== -->
                                        <!-- Right sidebar -->
                                        <!-- ============================================================== -->
                                        <!-- .right-sidebar -->
                                        <!-- ============================================================== -->
                                        <!-- End Right sidebar -->
                                        <!-- ============================================================== -->
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
    </body>

    </html>
<?php } ?>