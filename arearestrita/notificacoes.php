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
        <?php include"includes/menu.php"; ?>
        <div class="page-wrapper">
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="app-vue">
                                    <div class="card-body">
                                        <ul class="timeline mt-3">
                                        <li class="timeline-item" :class="index % 2 != 0 ? 'timeline-inverted' : ''" v-for="(allNotification, index) in allNotifications">
                                            <div class="timeline-badge success"><i :class="allNotification.icon"></i></div>
                                            <div class="timeline-panel" style="cursor: pointer">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">{{allNotification.titulo}}</h4>
                                                    <p><small class="text-muted"><i class="fa fa-clock-o"></i>{{new Date(allNotification.momento).toLocaleDateString('pt-BR', {timeZone: 'UTC'}) + 1}}</small> </p>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>{{allNotification.mensagem}}</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    </div>
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
    <script>

        Main = {
            data() {
                return {
                    allNotifications: [],
                }
            },
            mounted() {
                requestApp.get(`/mensagens/get-mensagens?total=1`).then(response => {
                    this.allNotifications = response.data;
                });
            },
            methods: {
                setNotificationReaded(id_notificacao, is_notificao_turma, link, status) {
                    if(!parseInt(status)){
                        window.location.href = link;
                        return;
                    }
                    this.allNotifications.forEach(notification => {
                        if(notification.id_notificacao == id_notificacao){
                            notification.status = 0;
                        }
                    });
                    requestApp.post("/mensagens/update-mensagem-status", JSON.stringify({
                        id_notificacao: id_notificacao,
                        is_notificao_turma: is_notificao_turma,
                    })).then(response => {
                        this.notifications = response.data;
                        if (link) {
                            window.location.href = link;
                        }
                    });

                }     
            }
        }

    </script>
</body>

</html>
<?php } ?>