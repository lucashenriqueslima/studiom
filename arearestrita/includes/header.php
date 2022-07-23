<header class="topbar">
    <div id="notifications-vue">
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

                        <img src="../layout/assets/images/logo-2.png" alt="homepage" class="dark-logo" width="110px" />

                        <img src="../layout/assets/images/logo-icon.png" alt="homepage" class="light-logo"
                            width="50px" />
                    </b>

                </a>

                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                    data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
            </div>

            <div class="navbar-collapse collapse" id="navbarSupportedContent">

                <ul class="navbar-nav float-left mr-auto">
                    <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light"
                            href="javascript:void(0)" data-sidebartype="mini-sidebar"><i
                                class="mdi mdi-menu font-24"></i></a></li>


                </ul>

                <ul class="navbar-nav float-right">

                    <li class="nav-item dropdown text-center">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark text-center"
                            href="" :style="getNumberOfUnreadNotifications ? 'padding: 0px 3px 0px 14px !important' : ''" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="mdi mdi-bell font-22"><span v-show="getNumberOfUnreadNotifications" style="position: relative;
                                        top: -13px;
                                        left: -9px;
                                        border-radius: 50%;
                                        background-color: red;
                                        font-size: 10.4px;
                                        padding: 1.3px 4px;
                                        font-weight: bold;
                                        font-family: Arial, Helvetica, sans-serif;">{{getNumberOfUnreadNotifications}}</span></i>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                            <span class="with-arrow"><span class="bg-primary"></span></span>
                            <ul class="list-style-none">
                                <li>
                                    <div class="drop-title bg-primary text-white">
                                        <h4 class="m-b-0 m-t-5">{{getNumberOfUnreadNotifications != 1 ? getNumberOfUnreadNotifications : 'Uma'}} {{getNumberOfUnreadNotifications != 1 ? 'Novas Notificações' : 'Nova Notificação'}}</h4>
                                        <span class="font-light">Veja Abaixo</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="message-center notifications ps-container ps-theme-default"
                                        data-ps-id="c15e363f-c8db-df10-a0e6-3918dd0f3a8d">
                                        <!-- Message -->
                                        <a v-for="(notification) in notifications" 
                                        @click="setNotificationReaded(notification.id_notificacao, notification.is_notificao_turma, notification.link, notification.status)" style="cursor: pointer;" class="message-item" >
                                            <div v-if="parseInt(notification.status)" style="width: 4px;
                                                        padding: 0px;
                                                        height: 4px;
                                                        border-radius: 2px;
                                                        background-color: #065fd4;
                                                        position: relative;
                                                        top: 33.5px;
                                                        left: -6px;">
                                            </div>
                                            <span class="btn btn-danger btn-circle ml-1"><i :class="notification.icone"></i></span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">{{notification.titulo}}</h5> <span class="mail-desc">{{notification.mensagem}}</span> <span class="time">{{new Date(notification.momento).toLocaleDateString('pt-BR', {timeZone: 'UTC'}) + 1}}</span>
                                            </div>
                                        </a>                                        
                                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                            <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;">
                                            </div>
                                        </div>
                                        <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
                                            <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center m-b-5 text-dark" href="javascript:void(0);">
                                        <strong>Ver Todas Notificações</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>" alt="user"
                                class="rounded-circle" width="31"></a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                            <span class="with-arrow"><span class="bg-primary"></span></span>
                            <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                <div class=""><img src="../sistema/arquivos/<?php echo $vetor_cadastro['imagem']; ?>"
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
    </div>
</header>
<script defer src="../js/utils/App.js"></script>
        <script>

            Notifications = {
                data() {
                    return {
                        notifications: [],
                    }
                },
                mounted() {
                    requestApp.get("/mensagens/get-mensagens").then(response => {
                            this.notifications = response.data;
                        });
                    
                },
                computed: {
                    getNumberOfUnreadNotifications() {
                        return this.notifications.filter(notification => parseInt(notification.status)).length;
                    }
                },
                methods: {
                    setNotificationReaded(id_notificacao, is_notificao_turma, link, status) {

                        if(!parseInt(status)){
                            // window.location.href = link;
                            return;
                        }

                        this.notifications.forEach(notification => {
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
                },
            }
            
        </script>
