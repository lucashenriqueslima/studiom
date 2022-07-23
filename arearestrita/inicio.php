<?php

include"../includes/conexao.php";


session_start();

if($_SESSION['id_formando'] == NULL || $_SESSION['id_formando'] == '') {

echo"<script language=\"JavaScript\">
location.href=\"index.php\";
</script>";

} else {

$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
$res_cadastro = mysqli_query($con, $sql_cadastro);
$vetor_cadastro = mysqli_fetch_array($res_cadastro);

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
    <!-- Custom CSS -->
    <link href="../layout/dist/css/style.min.css" rel="stylesheet">

    <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>

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
          <?php include "includes/header.php" ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include"includes/menu.php"; ?>
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
                        <h4 class="page-title">Plataforma Digital</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Início</li>
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
                                <div class="card-body">
                                    <h4 class="card-title">Olá, <?php echo $vetor_cadastro['nome']; ?>. Seja bem vindo (a) a sua plataforma digital Studio M.</h4>
                                    <ul class="timeline mt-3">
                                    <li class="timeline-item">
                                        <div class="timeline-badge success"><img alt="user" src="../../assets/images/users/1.jpg" alt="img" class="img-fluid"> </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Genelia</h4>
                                                <p><small class="text-muted"><i class="fa fa-clock-o"></i> 11 hours ago via Twitter</small> </p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero laboriosam dolor perspiciatis omnis exercitationem. Beatae, officia pariatur? Est cum veniam excepturi. Maiores praesentium, porro voluptas suscipit facere rem dicta, debitis.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted timeline-item">
                                        <div class="timeline-badge warning"><img class="img-fluid" alt="user" src="../../assets/images/users/2.jpg" alt="img"> </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Ritesh Deshmukh</h4>
                                            </div>
                                            <div class="timeline-body">
                                                <object data="../sistema/arquivos/165106394862693c8c84b3b.pdf" type="application/pdf" w>
                                                    <p>Seu navegador não tem um plugin pra PDF</p>
                                                </object>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium maiores odit qui est tempora eos, nostrum provident explicabo dignissimos debitis vel! Adipisci eius voluptates, ad aut recusandae minus eaque facere.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <div class="timeline-badge danger"><span class="font-12">2018</span></div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus numquam facilis enim eaque, tenetur nam id qui vel velit similique nihil iure molestias aliquam, voluptatem totam quaerat, magni commodi quisquam.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted timeline-item">
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates est quaerat asperiores sapiente, eligendi, nihil. Itaque quos, alias sapiente rerum quas odit! Aperiam officiis quidem delectus libero, omnis ut debitis!</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <div class="timeline-badge info"><i class="fa fa-save"></i> </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis minus modi quam ipsum alias at est molestiae excepturi delectus nesciunt, quibusdam debitis amet, beatae consequuntur impedit nulla qui! Laborum, atque.</p>
                                                <hr>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-cog"></i> <span class="caret"></span> </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="javascript:void(0)">Action</a>
                                                        <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                                                        <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="javascript:void(0)">Separated link</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted timeline-item">
                                        <div class="timeline-badge success"><i class="fa fa-graduation-cap"></i> </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt obcaecati, quaerat tempore officia voluptas debitis consectetur culpa amet, accusamus dolorum fugiat, animi dicta aperiam, enim incidunt quisquam maxime neque eaque.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                </div>
                                <hr>
                                
                                </div>
                            

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
    <script>

 


    </script>
    <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="../layout/dist/js/app.min.js"></script>
    <!-- minisidebar -->
    <script>
    $(function() {
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
    <script src="../layout/dist/js/pages/dashboards/dashboard1.js"></script>
</body>

</html>
<?php } ?>