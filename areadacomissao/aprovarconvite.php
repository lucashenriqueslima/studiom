<?php

include "../includes/conexao.php";

session_start();

if ($_SESSION['id_formando'] == NULL) {

    echo "<script language=\"JavaScript\">
	location.href=\"inicio.php\";
	</script>";

} else {

    if ($_SESSION['comissao'] != 2) {

        echo "<script language=\"JavaScript\">
	location.href=\"inicio.php\";
	</script>";

    }
    $id = $_GET['id'];
    $sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
    $res_cadastro = mysqli_query($con, $sql_cadastro);
    $vetor_cadastro = mysqli_fetch_array($res_cadastro);

    $sql_aprovacao = mysqli_query($con, "select * from meu_convite_turma where id_meuconvite = '$id' AND id_turma = '$vetor_cadastro[turma]'");
    $vetor_aprovacao = mysqli_fetch_array($sql_aprovacao);

    $sql_itens = mysqli_query($con, "select * from meu_convite_paginas_turma where id_meuconvite = '$id' order by npagina ASC");


    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <title>Studio M Fotografia</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="keywords" content="Studiom Fotografia"/>
        <script type="application/x-javascript"> addEventListener("load", function () {
                setTimeout(hideURLbar, 0);
            }, false);

            function hideURLbar() {
                window.scrollTo(0, 1);
            } </script>
        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css'/>
        <!-- Custom Theme files -->
        <link href="css/style.css" rel='stylesheet' type='text/css'/>
        <link href="css/font-awesome.css" rel="stylesheet">
        <script src="../layout/assets/libs/tinymce/tinymce.min.js"></script>

        <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
        <!-- Mainly scripts -->
        <script>
            $(document).ready(function () {
                $(".mymce").each(function () {
                    if ($(this).length > 0) {
                        tinymce.init({
                            selector: "textarea.mymce",
                            theme: "modern",
                            height: 300,
                            plugins: [
                                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                                "save table contextmenu directionality emoticons template paste textcolor"
                            ],
                            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

                        });
                    }
                    // ==============================================================
                    // Our Visitor
                    // ==============================================================

                    var chart = c3.generate({
                        bindto: '#visitor',
                        data: {
                            columns: [
                                ['Open', 4],
                                ['Closed', 2],
                                ['In progress', 2],
                                ['Other', 0],
                            ],

                            type: 'donut',
                            tooltip: {
                                show: true
                            }
                        },
                        donut: {
                            label: {
                                show: false
                            },
                            title: "Tickets",
                            width: 35,

                        },

                        legend: {
                            hide: true
                            //or hide: 'data1'
                            //or hide: ['data1', 'data2']

                        },
                        color: {
                            pattern: ['#40c4ff', '#2961ff', '#ff821c', '#7e74fb']
                        }
                    });
                });
            });
            function removeEscrita(id) {
                switch ($("#aprovado"+id).val()) {
                    case '1':
                        $('#escrita'+id).attr('hidden','hidden');
                        break;
                    case '2':
                        $('#escrita'+id).attr('hidden','hidden');
                        break;
                    case '3':
                        $('#escrita'+id).removeAttr('hidden');
                        break;
                }
            }
            $(function () {
                $('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

                if (!screenfull.enabled) {
                    return false;
                }


                $('#toggle').click(function () {
                    screenfull.toggle($('#container')[0]);
                });


            });

        </script>
        <!----->

        <!--pie-chart--->
        <link rel="stylesheet" href="../layout/dist/css/lightbox.min.css">

        <script src="../js/lightbox-plus-jquery.min.js"></script>

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <!--//skycons-icons-->

        <style type="text/css">
            .img-circle {
                border-radius: 50%;
            }

            .main iframe {
                border: none;
                width: 100%;
                height: auto;
            }

        </style>
        <!--//skycons-icons-->
    </head>
    <body>
    <div id="wrapper">

        <!----->
        <nav class="navbar-default navbar-static-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <h1><a class="navbar-brand" href="index.php">Área do Formando</a></h1>
            </div>
            <div class=" border-bottom">
                <div class="full-left">
                    Seja Bem Vindo, <?php echo $vetor_cadastro['nome']; ?>. <a href="index.php">Voltar para o
                        sistema.</a>
                    <div class="clearfix"></div>
                </div>


                <!-- Brand and toggle get grouped for better mobile display -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="drop-men">
                    <ul class=" nav_1">


                        <li class="dropdown">

                        </li>

                    </ul>
                </div><!-- /.navbar-collapse -->
                <div class="clearfix">

                </div>


        </nav>
    </div>

    </div>

    <div class="main">
        <div align="center" style="width: 100%; background-color: #fff;">

            <form action="recebe_aprovacao_convite.php" method="post">

                <input type="hidden" name="id_convite" value="<?php echo $id; ?>">

                <?php while ($vetor_item = mysqli_fetch_array($sql_itens)) { ?>

                    <input type="hidden" name="id_item[]" value="<?php echo $vetor_item['id_pagina']; ?>">

                    <table width="96%">
                        <tr>
                            <td width="40%" valign="top">

                                <img src="../sistema/arquivos/<?php echo $vetor_item['imagem']; ?>" height="360px">

                            </td>
                            <td width="2%"></td>
                            <td width="58%" valign="top">
                            <div id="escrita<?php echo $vetor_item['id_pagina']; ?>" <?php if($vetor_item['status'] != '3'){echo "hidden";} ?>>
                            <textarea id="mymce" name="descricao[]" class="form-control mymce" rows="10"
                                      placeholder="Indique sua (s) foto (s) preferida (s) e adicione suas observações."><?php echo $vetor_item['descricao']; ?></textarea>
                            </div>
                                <br>

                                <strong>Legenda:</strong> <?php echo $vetor_item['legenda']; ?>

                                <br>
                                <br>

                                <div class="row">

                                    <div class="col-lg-6">
                                        <fieldset class="form-group">
                                            <label class="form-label semibold" for="exampleInput">Aprovado?</label>
                                            <select id="aprovado<?php echo $vetor_item['id_pagina']; ?>" name="status[]" class="form-control" onchange="removeEscrita(<?php echo $vetor_item['id_pagina']; ?>)">
                                                <option value="1" selected="">Selecione...</option>
                                                <option value="2"
                                                        <?php if (strcasecmp($vetor_item['status'], '2') == 0) : ?>selected="selected"<?php endif; ?>>
                                                    Sim
                                                </option>
                                                <option value="3"
                                                        <?php if (strcasecmp($vetor_item['status'], '3') == 0) : ?>selected="selected"<?php endif; ?>>
                                                    Com Resssalva
                                                </option>
                                            </select>
                                    </div>
                                </div>
                                <br><br>

                                <br>
                                <br>


                            </td>
                        </tr>
                    </table>

                    <br>
                    <br>
                    <br>

                <?php } ?>

                <br>

                <?php if ($vetor_aprovacao['status'] != 4) { ?>

                    <table width="96%">

                        <tr>
                            <td>
                                <button type="submit" class="btn btn-primary" style="    float: left;">Finalizar
                                </button>
                            </td>
                        </tr>

                    </table>

                <?php } ?>

                <br>

            </form>

        </div>
    </div>

    <table width="100%">

        <tr>

            <td width="2%"></td>
            <td>

            </td>

        </tr>

    </table>


    </div>

    <!---->
    <!--scrolling js-->
    <script src="js/scripts.js"></script>
    <!--//scrolling js-->
    <script src="js/bootstrap.min.js"></script>


    </body>
    </html>
<?php } ?>