<?php
include "../includes/conexao.php";
date_default_timezone_set('America/Sao_Paulo');
session_start();
$id_pagina = 47;
if ($_SESSION['id'] == null) {
    echo "<script language=\"JavaScript\">
     location.href=\"index.php\";
     </script>";
} else {
    $sql_permissao = mysqli_query($con, "select listar from paginas_permissoes where id_pagina = '$id_pagina' and id_usuario = '$_SESSION[id]'");
    $vetor_permissao = mysqli_fetch_array($sql_permissao);
    if ($vetor_permissao['listar'] != 2) {
        echo "<script language=\"JavaScript\">
     location.href=\"sempermissao.php\";
     </script>";
    }
    $vetor_banco = mysqli_fetch_array(mysqli_query($con, "select ambiente, urlhomologacao, urlproducao from banco where id_banco = '1'"));
    if ($vetor_banco['ambiente'] == 1) {
        $urlbase = $vetor_banco['urlhomologacao'];
    }
    if ($vetor_banco['ambiente'] == 2) {
        $urlbase = $vetor_banco['urlproducao'];
    }
    if ($vetor_permissao['listar'] == 2) {
        ?>
        <!DOCTYPE html>
        <html dir="ltr" lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
            <!-- Tell the browser to be responsive to screen width -->
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
            <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
            <!-- Favicon icon -->
            <link rel="icon" type="image/png" sizes="16x16" href="../layout/assets/images/favicon.png">
            <title>Studio M Fotografia</title>
            <!-- Custom CSS -->
            <link href="../layout/dist/css/style.min.css" rel="stylesheet">
           
            <script type="text/javascript" src="../aplicacoes/aplicjava.js"></script>
            <script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>

            <style>
                        .wrapper {
            max-width: 450px !important;
            margin: 80px auto;
        }

        .wrapper .search-input {
            background: #fff;
            width: 100%;
            border-radius: 5px;
            position: relative;
            box-shadow: 0px 1px 5px 3px rgba(0, 0, 0, 0.12);
        }

        .search-input input {
            height: 55px;
            width: 100%;
            outline: none;
            border: none;
            border-radius: 5px;
            padding: 0 60px 0 20px;
            font-size: 18px;
            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.2);
        }

        .search-input.active-box input {
            border-radius: 5px 5px 0 0;
        }

        .search-input .autocom-box {
            padding: 0;
            opacity: 0;
            pointer-events: none;
            max-height: 280px;
            overflow-y: auto;
            border-radius: 5px;
            border: #efefef 1px solid;
           
        }

        .search-input.active-box .autocom-box {
            opacity: 1;
            pointer-events: auto;
        }

        .autocom-box li {
            list-style: none;
            padding: 15px;
            display: none;
            width: 100%;
            cursor: pointer;
            border-radius: 3px;
            font-size: 20px;
            text-transform: uppercase;

        }

        .autocom-box li:hover {
            background: #e0e0e0 !important;
        }

        a {
            text-decoration: none;
            color: #000;
        }

        .search-input.active-box .autocom-box li {
            display: block;
        }

        .autocom-box li:hover {
            background: #efefef;
        }

        .search-input .icon {
            position: absolute;
            right: 0px;
            top: 0px;
            height: 55px;
            width: 55px;
            text-align: center;
            line-height: 55px;
            font-size: 20px;
            color: #644bff;
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
            <?php include "includes/header.php" ?>
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
                                        <li class="breadcrumb-item">Financeiro</a></li>
                                        <li class="breadcrumb-item">Cobrança</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Relatório de Cobrança</li>
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
                                <div id="app-vue">
                                    <div class="card-body p-5">
                                        <div v-bind="classSearchBar.attributes">
                                            <h4 class="mt-4">Selecione uma turma:</h4>
                                            <div class="search-input" :class="classBoxIsActivated">
                                                <a href="" target="_blank" hidden></a>
                                                    <input type="text" placeholder="Digite para pesquisar..." v-model="classSearchBar.inputText" @keyup="searchSuggestions('class')">
                                                    <div class="autocom-box">
                                                    <li v-for="(selectedSuggestion) in classSearchBar.selectedSuggestions" @click="classSelectLi(selectedSuggestion.id, selectedSuggestion.descricao)">
                                                        {{selectedSuggestion.descricao}}
                                                    </li>
                                                    <li style="pointer-events: none" v-if="classSearchBar.isActivated && !classSearchBar.selectedSuggestions.length">Nenhum resultado encontrado...</li>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-bind="eventSearchBar.attributes" class="mt-5">
                                            <h4 class="mt-4">Selecione um evento:</h4>
                                            <div class="search-input" :class="eventBoxIsActivated">
                                                <a href="" target="_blank" hidden></a>
                                                    <input type="text" placeholder="Digite para pesquisar..." v-model="eventSearchBar.inputText" @keyup="searchSuggestions()">
                                                    <div class="autocom-box">
                                                    <li v-for="(selectedSuggestion) in eventSearchBar.selectedSuggestions" @click="eventSelectLi(selectedSuggestion.id_evento, selectedSuggestion.descricao)">
                                                        {{selectedSuggestion.descricao}}
                                                    </li>
                                                    <li style="pointer-events: none" v-if="eventSearchBar.isActivated && !eventSearchBar.selectedSuggestions.length || !eventSearchBar.suggestions.length">Nenhum resultado encontrado...</li>
                                                </div>
                                            </div>
                                        </div>                                        
                                            <div class="d-flex flex-row bd-highlight my-5">
                                                <input class="btn btn-secondary" @change="setSelectedPhotos($event)" v-bind="selectPhotosButton.attributes" type="file" multiple="multiple">
                                                <button class="btn btn-success ml-3" @click="" v-bind="upploadPhotosButton.attributes">Fazer Upload Das Fotos</button>
                                            </div>

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
        <script src="../layout/assets/libs/select2/dist/js/select2.min.js"></script>
        <script>
            Main = {
                data() {
                    return {
                        classSearchBar: {
                            inputText: "",
                            attributes: {
                                hidden: false,
                                disabled: false,
                            },
                            isActivated: false,
                            suggestions: [],
                            selectedSuggestions: [],
                        },

                        eventSearchBar: {
                            inputText: "",
                            attributes: {
                                hidden: true,
                                disabled: false,
                            },
                            isActivated: false,
                            suggestions: [],
                            selectedSuggestions: [],
                        },

                        selectPhotosButton: {
                            attributes: {
                                hidden: true,
                                disabled: false,
                            },
                            selectedPhotos: [],
                        },

                        upploadPhotosButton: {
                            attributes: {
                                hidden: true,
                                disabled: false,
                            },
                        },
                    }
                },
                computed:{
                    classBoxIsActivated(){
                        return this.classSearchBar.inputText.length > 0 ? 'active-box' : '';
                    },

                    eventBoxIsActivated(){
                        return this.eventSearchBar.inputText.length > 0 ? 'active-box' : '';
                    }
                    

                },
                mounted() {

                    requestSys.get("/turmas/get-turmas").then(response => {
                        this.classSearchBar.suggestions = response.data;
                    }).then(() => {
                            if(typeof localStorage.id_turma != "undefined"){
                            this.classSearchBar.inputText = this.classSearchBar.suggestions.filter((suggestion) => {
                                return suggestion.id == localStorage.id_turma;
                            })[0].descricao;

                            this.eventSearchBar.attributes.hidden = false;

                            requestSys.get(`/eventos/get-eventos-by-turma?id_turma=${localStorage.id_turma}`).then(response => {
                                this.eventSearchBar.suggestions = response.data;
                            }).then(() => {
                                if(typeof localStorage.id_evento != "undefined"){
                                    this.eventSearchBar.inputText = this.eventSearchBar.suggestions.filter((suggestion) => {
                                    return suggestion.id_evento == localStorage.id_evento;
                                    })[0].descricao;

                                    this.selectPhotosButton.attributes.hidden = false;
                                }
                            })

                        }
                    });

                },                
                methods: {
                    searchSuggestions(type = null) {

                        if(type == 'class'){
                            if (this.classSearchBar.inputText) {
                                
                            this.classSearchBar.selectedSuggestions = this.classSearchBar.suggestions.filter((data) => {
                                return data.descricao.toLocaleLowerCase().includes(this.classSearchBar.inputText.toLocaleLowerCase());
                            });
                            this.classSearchBar.selectedSuggestions = this.classSearchBar.selectedSuggestions.map((data) => {
                                return data = {
                                    id: data.id,
                                    descricao: data.descricao,
                                };
                            });
                                this.classSearchBar.isActivated = true                            
                            } else {
                                this.classSearchBar.isActivated = false  
                            }
                            return
                        }

                            if (this.eventSearchBar.inputText) {
                                
                            this.eventSearchBar.selectedSuggestions = this.eventSearchBar.suggestions.filter((data) => {
                                return data.descricao.toLocaleLowerCase().includes(this.eventSearchBar.inputText.toLocaleLowerCase());
                            });
                            this.eventSearchBar.selectedSuggestions = this.eventSearchBar.selectedSuggestions.map((data) => {
                                return data = {
                                    id_evento: data.id_evento,
                                    descricao: data.descricao,
                                };
                            });
                                this.eventSearchBar.isActivated = true                            
                            } else {
                                this.eventSearchBar.isActivated = false  
                            }
                        
                    },

                    classSelectLi(id, descricao) {
                        this.classSearchBar.inputText = descricao;
                        this.classSearchBar.selectedSuggestions = [];
                        this.classSearchBar.isActivated = false;
                        this.eventSearchBar.attributes.hidden = false;

                        localStorage.id_turma = id;
                        localStorage.removeItem('id_evento')

                        requestSys.get(`/eventos/get-eventos-by-turma?id_turma=${localStorage.id_turma}`).then(response => {
                            this.eventSearchBar.suggestions = response.data;
                        })

                        this.eventSearchBar.selectedSuggestions = [];
                        this.eventSearchBar.inputText = "";
                        this.selectPhotosButton.attributes.hidden = true;

                    },

                    eventSelectLi(id, descricao) {
                        this.eventSearchBar.inputText = descricao;
                        this.eventSearchBar.selectedSuggestions = [];
                        this.eventSearchBar.isActivated = false;
                        localStorage.id_evento = id;

                        this.selectPhotosButton.attributes.hidden = false;

                    },

                    setSelectedPhotos(e) {
                        this.selectPhotosButton.selectedPhotos = e.target.files;
                        
                        if(this.selectPhotosButton.selectedPhotos.length){
                            this.upploadPhotosButton.attributes.hidden = false;
                            return
                        }

                        this.upploadPhotosButton.attributes.hidden = true;
                    }


                    },
                

            }
        </script>



        </body>
        </html>


    <?php }
} ?>        





