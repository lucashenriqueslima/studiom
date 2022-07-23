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
                <a class="navbar-brand" href="dashboard.php">
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
                    <!-- Comment -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown text-center">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark text-center"
                            style="padding-left: 26px !important" href="" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> <i class="mdi mdi-bell font-22"><span style="position: relative;
                                        top: -13px;
                                        left: -9px;
                                        border-radius: 50%;
                                        background-color: red;
                                        font-size: 10.4px;
                                        padding: 1.3px 4px;
                                        font-weight: bold;
                                        font-family: Arial, Helvetica, sans-serif;">5</span></i>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                            <span class="with-arrow"><span class="bg-primary"></span></span>
                            <ul class="list-style-none">
                                <li>
                                    <div class="drop-title bg-primary text-white">
                                        <h4 class="m-b-0 m-t-5"></h4>
                                        <span class="font-light">Notifications</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="message-center notifications ps-container ps-theme-default"
                                        data-ps-id="c15e363f-c8db-df10-a0e6-3918dd0f3a8d">
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                            <span class="btn btn-danger btn-circle"><i class="fa fa-link"></i></span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Luanch Admin</h5> <span class="mail-desc">Just
                                                    see the my new admin!</span> <span class="time">9:30 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                            <span class="btn btn-success btn-circle"><i class="ti-calendar"></i></span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Event today</h5> <span class="mail-desc">Just
                                                    a reminder that you have event</span> <span class="time">9:10
                                                    AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                            <span class="btn btn-info btn-circle"><i class="ti-settings"></i></span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Settings</h5> <span class="mail-desc">You can
                                                    customize this template as you want</span> <span class="time">9:08
                                                    AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                            <span class="btn btn-primary btn-circle"><i class="ti-user"></i></span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Pavan kumar</h5> <span class="mail-desc">Just
                                                    see the my admin!</span> <span class="time">9:02 AM</span>
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
                                        <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- End Comment -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>" alt="user"
                                class="rounded-circle" width="31"></a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                            <span class="with-arrow"><span class="bg-primary"></span></span>
                            <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                <div class=""><img src="../sistema/arquivos/<?php echo $_SESSION['imagem']; ?>"
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
    </div>
</header>
<script defer src="../js/utils/App.js"></script>
        <script>

            Notifications = {
                data() {
                    return {
                       
                    }
                },
            }
            
        </script>