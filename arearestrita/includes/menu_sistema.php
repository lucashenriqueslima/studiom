<?php

$sql_permissoes_cadastros = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '1' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_marketing = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '2' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_comercial = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '3' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_crm = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '4' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_administrativo = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '5' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_gestaodecontratos = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '6' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_calendario = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '7' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_fotografia = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '8' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_criacao = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '9' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_financeiro = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '10' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_vendas = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '11' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_album = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '12' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_juridico = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '13' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_rh = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '14' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_convite = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '16' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_pcp = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '17' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_affotografia = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '18' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_impressao = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '19' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_permissoes_producao = mysqli_query($con, "select * from paginas a, paginas_permissoes b where a.id_pagina = b.id_pagina and a.id_modulo = '20' and listar = '2' or cadastro = '2' or alteracao = '2' or exclusao = '2'");

$sql_departamentos_comercial = mysqli_query($con, "select * from departamentos where id_departamento = '1'");
$vetor_departamento_comercial = mysqli_fetch_array($sql_departamentos_comercial);

$sql_departamentos_fotografia = mysqli_query($con, "select * from departamentos where id_departamento = '2'");
$vetor_departamento_fotografia = mysqli_fetch_array($sql_departamentos_fotografia);

$sql_departamentos_gestao = mysqli_query($con, "select * from departamentos where id_departamento = '3'");
$vetor_departamento_gestao = mysqli_fetch_array($sql_departamentos_gestao);

$sql_departamentos_financeiro = mysqli_query($con, "select * from departamentos where id_departamento = '4'");
$vetor_departamento_financeiro = mysqli_fetch_array($sql_departamentos_financeiro);

$sql_departamentos_vendas = mysqli_query($con, "select * from departamentos where id_departamento = '5'");
$vetor_departamento_vendas = mysqli_fetch_array($sql_departamentos_vendas);

$sql_departamentos_marketing = mysqli_query($con, "select * from departamentos where id_departamento = '7'");
$vetor_departamento_marketing = mysqli_fetch_array($sql_departamentos_marketing);

$sql_departamentos_administrativo = mysqli_query($con, "select * from departamentos where id_departamento = '8'");
$vetor_departamento_administrativo = mysqli_fetch_array($sql_departamentos_administrativo);

$sql_departamentos_criacao = mysqli_query($con, "select * from departamentos where id_departamento = '9'");
$vetor_departamento_criacao = mysqli_fetch_array($sql_departamentos_criacao);

$sql_departamentos_album = mysqli_query($con, "select * from departamentos where id_departamento = '10'");
$vetor_departamento_album = mysqli_fetch_array($sql_departamentos_album);

$sql_departamentos_juridico = mysqli_query($con, "select * from departamentos where id_departamento = '11'");
$vetor_departamento_juridico = mysqli_fetch_array($sql_departamentos_juridico);

$sql_departamentos_rh = mysqli_query($con, "select * from departamentos where id_departamento = '12'");
$vetor_departamento_rh = mysqli_fetch_array($sql_departamentos_rh);

$sql_departamentos_pcp = mysqli_query($con, "select * from departamentos where id_departamento = '14'");
$vetor_departamento_pcp = mysqli_fetch_array($sql_departamentos_pcp);

$sql_permissoes_convite = mysqli_query($con, "select * from departamentos where id_departamento = '13'");
$vetor_departamento_convite = mysqli_fetch_array($sql_permissoes_convite);

$sql_tarefas = mysqli_query($con, "select * from responsaveis_calendario where id_usuario = '$_SESSION[id]' and lido = '1'");

?>
<style type="text/css">
    .comercial{
         
        color: <?php echo $vetor_departamento_comercial[corcalendario]; ?>;
         
    }
    .fotografia{
         
        color: <?php echo $vetor_departamento_fotografia[corcalendario]; ?>;
         
    }
    .gestaocontratos{
         
        color: <?php echo $vetor_departamento_gestao[corcalendario]; ?>;
         
    }

    .financeiro{
         
        color: <?php echo $vetor_departamento_financeiro[corcalendario]; ?>;
         
    }
    .vendas{
         
        color: <?php echo $vetor_departamento_vendas[corcalendario]; ?>;
         
    }
    .marketing{
         
        color: <?php echo $vetor_departamento_marketing[corcalendario]; ?>;
         
    }
    .administrativo{
         
        color: <?php echo $vetor_departamento_administrativo[corcalendario]; ?>;
         
    }
    .criacao{
         
        color: <?php echo $vetor_departamento_criacao[corcalendario]; ?>;
         
    }
    .album{
         
        color: <?php echo $vetor_departamento_album[corcalendario]; ?>;
         
    }
    .juridico{
         
        color: <?php echo $vetor_departamento_juridico[corcalendario]; ?>;
         
    }
    .rh{
         
        color: <?php echo $vetor_departamento_rh[corcalendario]; ?>;
         
    }

    .convite{
         
        color: <?php echo $vetor_departamento_convite[corcalendario]; ?>;
         
    }

    .pcp{
         
        color: <?php echo $vetor_departamento_pcp[corcalendario]; ?>;
         
    }
     
    </style>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="arquivos/<?php echo $vetor_cadastro['imagem']; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $vetor_usuario['nome']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU NAVEGAÇÃO</li>
        <li>
          <a href="tarefas.php">
            <i class="fa fa-calendar"></i> <span>Minhas Tarefas</span>
            <span class="pull-right-container">
              <?php if(mysqli_num_rows($sql_tarefas) == 0) { } else { ?><small class="label pull-right bg-red"><?php echo mysqli_num_rows($sql_tarefas); ?></small><?php } ?>
            </span>
          </a>
        </li>
        <?php if(mysqli_num_rows($sql_permissoes_cadastros) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart cadastrosgerais"></i>
            <span>Cadastros Gerais</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_1 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '1' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_1) > 0) {
            ?>
            <li><a href="listarfornecedores.php"><i class="fa fa-circle-o"></i> Fornecedores</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_2 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '2' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_2) > 0) {
            ?>
            <li><a href="listarinstituicao.php"><i class="fa fa-circle-o"></i> Instituição</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_3 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '3' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_3) > 0) {
            ?>
            <li><a href="listarcursos.php"><i class="fa fa-circle-o"></i> Cursos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_102 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '102' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_102) > 0) {
            ?>
            <li><a href="cadastros_turmasmkt.php"><i class="fa fa-circle-o"></i> Turmas</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_5 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '5' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_5) > 0) {
            ?>
            <li><a href="listarformandos.php"><i class="fa fa-circle-o"></i> Formandos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_6 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '6' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_6) > 0) {
            ?>
            <li><a href="cadastros_categorias.php"><i class="fa fa-circle-o"></i> Categorias CRM</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_7 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '7' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_7) > 0) {
            ?>
            <li><a href="listarstatus.php"><i class="fa fa-circle-o"></i> Status Categorias CRM</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_8 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '8' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_8) > 0) {
            ?>
            <li><a href="listardepartamentos.php"><i class="fa fa-circle-o"></i> Departamentos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_9 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '9' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_9) > 0) {
            ?>
            <li><a href="listarlocaiseventos.php"><i class="fa fa-circle-o"></i> Locais de Eventos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_10 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '10' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_10) > 0) {
            ?>
            <li><a href="listarcategoriaseventos.php"><i class="fa fa-circle-o"></i> Categoria de Eventos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_55 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '55' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_55) > 0) {
            ?>
            <li><a href="listarcategoriasfornecedores.php"><i class="fa fa-circle-o"></i> Categoria de Fornecedores</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_11 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '11' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_11) > 0) {
            ?>
            <li><a href="listartiposinteracao.php"><i class="fa fa-circle-o"></i> Meio Interação</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_15 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '15' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_15) > 0) {
            ?>
            <li><a href="listarassuntos.php"><i class="fa fa-circle-o"></i> Assuntos Interação</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_43 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '43' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_43) > 0) {
            ?>
            <li><a href="listarcadbancos.php"><i class="fa fa-circle-o"></i> Bancos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_98 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '98' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_43) > 0) {
            ?>
            <li><a href="listartiposarquivos.php"><i class="fa fa-circle-o"></i> Tipos de Arquivos</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_marketing) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-rocket marketing"></i>
            <span>Marketing</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right "></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_104 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '104' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_104) > 0) {
            ?>
            <li><a href="listarprospeccao.php"><i class="fa fa-circle-o"></i> Prospecção</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_16 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '16' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_16) > 0) {
            ?>
            <li><a href="listartarefasmarketing.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_comercial) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-handshake-o comercial"></i>
            <span>Comercial</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_17 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '17' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_17) > 0) {
            ?>
            <li><a href="listartarefascomercial.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Fotografia
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="listarorcfotografia.php"><i class="fa fa-circle-o"></i> Orçamento</a></li>
                <li><a href="listarpropfotografia.php"><i class="fa fa-circle-o"></i> Proposta</a></li>
                <li><a href="listarcontratofotografia.php"><i class="fa fa-circle-o"></i> Contrato</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Convite
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="listarorcconvite.php"><i class="fa fa-circle-o"></i> Orçamento</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Cadastros Gerais
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <?php 
                    $sql_permissao_item_107 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '107' and id_usuario = '$_SESSION[id]' and listar = '2'");
                    if(mysqli_num_rows($sql_permissao_item_107) > 0) {
                    ?>
                    <li><a href="listaritenstabelaconvite.php"><i class="fa fa-circle-o"></i> Itens Tabela</a></li>
                    <?php } ?>
                    <?php 
                    $sql_permissao_item_109 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '109' and id_usuario = '$_SESSION[id]' and listar = '2'");
                    if(mysqli_num_rows($sql_permissao_item_109) > 0) {
                    ?>
                    <li><a href="listardadosbasico.php"><i class="fa fa-circle-o"></i> Dados Básicos</a></li>
                    <?php } ?>
                     <?php 
                    $sql_permissao_item_110 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '110' and id_usuario = '$_SESSION[id]' and listar = '2'");
                    if(mysqli_num_rows($sql_permissao_item_110) > 0) {
                    ?>
                    <li><a href="listartabelaacabamentos.php"><i class="fa fa-circle-o"></i> Tabela Acabamentos</a></li>
                    <?php } ?>
                    <?php 
                    $sql_permissao_item_106 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '106' and id_usuario = '$_SESSION[id]' and listar = '2'");
                    if(mysqli_num_rows($sql_permissao_item_106) > 0) {
                    ?>
                    <li><a href="listartabelatribconvite.php"><i class="fa fa-circle-o"></i> Tributos</a></li>
                    <?php } ?>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="treeview">
            <a href="#"><i class="fa fa-circle-o"></i> CRM
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_18 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '18' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_18) > 0) {
            ?>
            <li><a href="listaroportunidades.php"><i class="fa fa-circle-o"></i> Oportunidades</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_19 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '19' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_19) > 0) {
            ?>
            <li><a href="listarpipe.php"><i class="fa fa-circle-o"></i> PIPE</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_20 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '20' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_20) > 0) {
            ?>
            <li><a href="listarfunil.php"><i class="fa fa-circle-o"></i> Funil CRM</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_21 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '21' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_21) > 0) {
            ?>
            <li><a href="listardashboard.php"><i class="fa fa-circle-o"></i> Dashboard CRM</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_22 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '22' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_22) > 0) {
            ?>
            <li><a href="listarcampanhas.php"><i class="fa fa-circle-o"></i> Campanhas</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_23 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '23' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_23) > 0) {
            ?>
            <li><a href="listarcases.php"><i class="fa fa-circle-o"></i> Cases</a></li>
            <?php } ?>
          </ul>
        </li>
          </ul>
        </li>
        <?php if(mysqli_num_rows($sql_permissoes_vendas) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cart-plus vendas"></i>
            <span>Vendas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Fotografia
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">

                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Pós
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">

                    <?php 
                    $sql_permissao_item_50 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '50' and id_usuario = '$_SESSION[id]' and listar = '2'");
                    if(mysqli_num_rows($sql_permissao_item_50) > 0) {
                    ?>
                    <li><a href="listarremessas.php"><i class="fa fa-circle-o"></i> Remessas</a></li>
                    <?php } ?>
                    <?php 
                    $sql_permissao_item_48 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '48' and id_usuario = '$_SESSION[id]' and listar = '2'");
                    if(mysqli_num_rows($sql_permissao_item_48) > 0) {
                    ?>
                    <li><a href="listarprodutosformando.php"><i class="fa fa-circle-o"></i> Produtos Formando</a></li>
                    <?php } ?>

                  </ul>

                </li>

                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Pré
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">

                    <?php 
                    $sql_permissao_item_51 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '51' and id_usuario = '$_SESSION[id]' and listar = '2'");
                    if(mysqli_num_rows($sql_permissao_item_51) > 0) {
                    ?>
                    <li><a href="listarpacotes.php"><i class="fa fa-circle-o"></i> Produtos Álbum</a></li>
                    <?php } ?>

                  </ul>

                </li>

                <?php 
                $sql_permissao_item_96 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '96' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_96) > 0) {
                ?>
                <li><a href="listarvendasavulsas.php"><i class="fa fa-circle-o"></i> Avulsa</a></li>
                <?php } ?>

                <?php 
                $sql_permissao_item_97 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '97' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_97) > 0) {
                ?>
                <li><a href="listarliberarfotos.php"><i class="fa fa-circle-o"></i> Liberar Fotos</a></li>
                <?php } ?>

              </ul>

          </li>

          <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Convite
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">

                <?php 
                $sql_permissao_item_14 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '14' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_14) > 0) {
                ?>
                <li><a href="listarprodutos.php"><i class="fa fa-circle-o"></i> Produtos</a></li>
                <?php } ?>

              </ul>

          </li>

            
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Gestor de Vendas
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">

                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Convite
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">

                    <?php 
                    $sql_permissao_item_31 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '31' and id_usuario = '$_SESSION[id]' and listar = '2'");
                    if(mysqli_num_rows($sql_permissao_item_31) > 0) {
                    ?>
                    <li><a href="listargestaodeconvites.php"><i class="fa fa-circle-o"></i> Gestão Parcial da Venda</a></li>
                    <li><a href="listargestaodeconvitestodos.php"><i class="fa fa-circle-o"></i> Gestão Total da Venda</a></li>
                    <?php } ?>
                    <?php 
                    $sql_permissao_item_31 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '31' and id_usuario = '$_SESSION[id]' and listar = '2'");
                    if(mysqli_num_rows($sql_permissao_item_31) > 0) {
                    ?>
                    <li><a href="listaraceitesgerar.php"><i class="fa fa-circle-o"></i> Gerar Aceite de Convites</a></li>
                    <li><a href="listaraceites.php"><i class="fa fa-circle-o"></i> Impressão de Aceite</a></li>
                    <?php } ?>

                  </ul>
                </li>

                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Fotografia
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">

                    <?php 
                    $sql_permissao_item_32 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '32' and id_usuario = '$_SESSION[id]' and listar = '2'");
                    if(mysqli_num_rows($sql_permissao_item_32) > 0) {
                    ?>
                    <li><a href="listargestaodealbuns.php"><i class="fa fa-circle-o"></i> Gestão de Álbuns e Fotografias</a></li>
                    <?php } ?>
                    <?php 
                    $sql_permissao_item_31 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '31' and id_usuario = '$_SESSION[id]' and listar = '2'");
                    if(mysqli_num_rows($sql_permissao_item_31) > 0) {
                    ?>
                    <li><a href="listaraceitesalbuns.php"><i class="fa fa-circle-o"></i> Impressão de Aceite</a></li>
                    <?php } ?>

                  </ul>
                </li>

              </ul>
            </li>
            <li><a href="listarrelvendas.php"><i class="fa fa-circle-o"></i> Relatório de Vendas</a></li>
            <?php 
            $sql_permissao_item_52 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '52' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_52) > 0) {
            ?>
            <li><a href="listarvendasexclusao.php"><i class="fa fa-circle-o"></i> Excluir Vendas</a></li>
            <?php } ?>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Cadastros Gerais
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php 
                $sql_permissao_item_13 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '13' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_13) > 0) {
                ?>
                <li><a href="listarformas.php"><i class="fa fa-circle-o"></i> Formas de Pagamento</a></li>
                <?php } ?>
                <?php 
                $sql_permissao_item_49 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '49' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_49) > 0) {
                ?>
                <li><a href="listartiposprodutosop.php"><i class="fa fa-circle-o"></i> Produtos Fotografia</a></li>
                <?php } ?>
                <?php 
                $sql_permissao_item_12 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '12' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_12) > 0) {
                ?>
                <li><a href="listartiposprodutos.php"><i class="fa fa-circle-o"></i> Produtos Convite</a></li>
                <?php } ?>
              </ul>
            </li>
            <?php 
            $sql_permissao_item_36 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '36' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_36) > 0) {
            ?>
            <li><a href="listartarefasvendas.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_administrativo) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cog administrativo"></i>
            <span>Administrativo</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_4 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '4' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_4) > 0) {
            ?>
            <li><a href="listarturmas.php"><i class="fa fa-circle-o"></i> Gestão de Contratos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_25 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '25' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_25) > 0) {
            ?>
            <li><a href="listareventos.php"><i class="fa fa-circle-o"></i> Gestão de Eventos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_111 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '111' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_111) > 0) {
            ?>
            <li><a href="listarhds.php"><i class="fa fa-circle-o"></i> HDS</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_26 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '26' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_26) > 0) {
            ?>
            <li><a href="listartarefasgestaodecontratos.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_juridico) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gavel juridico"></i>
            <span>Jurídico</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_67 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '6' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_67) > 0) {
            ?>
            <li><a href="listarjuridico.php"><i class="fa fa-circle-o"></i> Processos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_38 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '38' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_38) > 0) {
            ?>
            <li><a href="listartarefasjuridico.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_rh) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-address-book rh"></i>
            <span>RH</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_39 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '39' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_39) > 0) {
            ?>
            <li><a href="listarcolaboradores.php"><i class="fa fa-circle-o"></i> Colaboradores</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_40 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '40' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_40) > 0) {
            ?>
            <li><a href="listartarefasrh.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_financeiro) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-money financeiro"></i>
            <span>Financeiro</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <?php 
            $sql_permissao_item_101 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '101' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_101) > 0) {
            ?>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> C. Receber
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="listarcontasareceber.php"><i class="fa fa-circle-o"></i> Em Aberto</a></li>
                <li><a href="listarcontasareceberfim.php"><i class="fa fa-circle-o"></i> Finalizados</a></li>
              </ul>
            </li>
            <?php } ?>
            <?php 
            $sql_permissao_item_47 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '47' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_47) > 0) {
            ?>
            <li><a href="listarboletos.php"><i class="fa fa-circle-o"></i> Boletos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_33 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '33' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_33) > 0) {
            ?>
            <li><a href="listarduplicatas.php"><i class="fa fa-circle-o"></i> Duplicatas</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_34 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '34' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_34) > 0) {
            ?>
            <li><a href="listarcobranca.php"><i class="fa fa-circle-o"></i> Cobrança</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_35 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '35' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_35) > 0) {
            ?>
            <li><a href="listartarefasfinanceiro.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Cadastros Gerais
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php 
                $sql_permissao_item_44 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '44' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_44) > 0) {
                ?>
                <li><a href="listarcontasbancos.php"><i class="fa fa-circle-o"></i> Contas Bancárias</a></li>
                <?php } ?>
                <?php 
                $sql_permissao_item_45 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '45' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_45) > 0) {
                ?>
                <li><a href="listarfactorings.php"><i class="fa fa-circle-o"></i> Factorings</a></li>
                <?php } ?>
                <?php 
                $sql_permissao_item_46 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '46' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_46) > 0) {
                ?>
                <li><a href="listarmaquinascartao.php"><i class="fa fa-circle-o"></i> Maquinas de Cartão</a></li>
                <?php } ?>
              </ul>
            </li>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_calendario) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-calendar-minus-o"></i>
            <span>Interatividades</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="listarcalendario.php"><i class="fa fa-circle-o"></i> Calendário</a></li>
            <li><a href="cadastrocalendario.php"><i class="fa fa-circle-o"></i> Nova Tarefa</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Fotografia
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php 
                $sql_permissao_item_58 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '58' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_58) > 0) {
                ?>
                <li><a href="listareventosbkp.php" title="arquivosdefotosfotografia@studiomfotografia.com.br"><i class="fa fa-circle-o"></i> Arquivos de Fotos</a></li>
                <?php } ?>
                <?php 
                $sql_permissao_item_59 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '59' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_59) > 0) {
                ?>
                <li><a href="listareventosproducao.php" title="arquivosdeproducaofotografia@studiomfotografia.com.br"><i class="fa fa-circle-o"></i> Arquivos de Produção</a></li>
                <?php } ?>
                <?php 
                $sql_permissao_item_60 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '60' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_60) > 0) {
                ?>
                <li><a href="listarmostruario.php" title="mostruario@studiomfotografia.com.br"><i class="fa fa-circle-o"></i> Mostruário</a></li>
                <?php } ?>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Convite
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php 
                $sql_permissao_item_61 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '61' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_61) > 0) {
                ?>
                <li><a href="listararquivosdeconvites.php"><i class="fa fa-circle-o"></i> Arquivo de Convites</a></li>
                <li><a href="listararquivosdeproducao.php" title="arquivosdeproducaoconvite@studiomfotografia.com.br"><i class="fa fa-circle-o"></i> Arquivo de Produção</a></li>
                <li><a href="listararquivosdeimpressao.php" title="arquivosdeimpressao@studiomfotografia.com.br"><i class="fa fa-circle-o"></i> Arquivos de Impressão</a></li>
                <?php } ?>
              </ul>
            </li>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_pcp) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cogs pcp"></i>
            <span>PCP</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_65 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '65' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_65) > 0) {
            ?>
            <li><a href="listartipojob.php"><i class="fa fa-circle-o"></i> Tipos de Jobs</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_68 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '68' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_68) > 0) {
            ?>
            <li><a href="cadastrojob.php"><i class="fa fa-circle-o"></i> Cadastro de Job</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_69 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '69' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_69) > 0) {
            ?>
            <li><a href="listarproducaopcp.php"><i class="fa fa-circle-o"></i> Produção</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_67 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '67' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_67) > 0) {
            ?>
            <li><a href="listarprocessos.php"><i class="fa fa-circle-o"></i> Processos</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_fotografia) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-camera-retro fotografia"></i>
            <span>Fotografia</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_29 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '29' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_29) > 0) {
            ?>
            <li><a href="listartarefasfotografia.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
            <li><a href="listaridentificacao.php"><i class="fa fa-circle-o"></i> Indentificação de Formandos</a></li>
            <?php 
            $sql_permissao_item_71 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '71' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_71) > 0) {
            ?>
            <li><a href="listarpcpfotografia.php"><i class="fa fa-circle-o"></i> PCP</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_criacao) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-paint-brush criacao"></i>
            <span>Criação</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_76 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '76' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_76) > 0) {
            ?>
            <li><a href="listartiposervicocriacao.php"><i class="fa fa-circle-o"></i> Tipo de Serviço</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_77 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '77' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_77) > 0) {
            ?>
            <li><a href="cadastroservicocriacao.php"><i class="fa fa-circle-o"></i> Cadastro de Serviço</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_70 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '70' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_70) > 0) {
            ?>
            <li><a href="listarpcpcriacao.php"><i class="fa fa-circle-o"></i> PCP</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_78 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '78' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_78) > 0) {
            ?>
            <li><a href="listarapontamentoscriacao.php"><i class="fa fa-circle-o"></i> Apontamentos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_30 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '30' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_30) > 0) {
            ?>
            <li><a href="listartarefascriacao.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_affotografia) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-inbox album"></i>
            <span>Arte Final - Fotografia</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_79 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '79' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_79) > 0) {
            ?>
            <li><a href="listartiposervicoaffotografia.php"><i class="fa fa-circle-o"></i> Tipo de Serviço</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_80 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '80' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_80) > 0) {
            ?>
            <li><a href="cadastroservicoaffotografia.php"><i class="fa fa-circle-o"></i> Cadastro de Serviço</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_72 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '72' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_72) > 0) {
            ?>
            <li><a href="listarpcpaffotografia.php"><i class="fa fa-circle-o"></i> PCP</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_81 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '81' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_81) > 0) {
            ?>
            <li><a href="listarapontamentosaffotografia.php"><i class="fa fa-circle-o"></i> Apontamentos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_56 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '56' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_56) > 0) {
            ?>
            <li><a href="listaralbumturma.php"><i class="fa fa-circle-o"></i> Produtos Turma</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_57 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '57' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_57) > 0) {
            ?>
            <li><a href="listaralbumformando.php"><i class="fa fa-circle-o"></i> Produtos Formando</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_37 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '37' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_37) > 0) {
            ?>
            <li><a href="listartarefasalbum.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_54 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '54' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_54) > 0) {
            ?>
            <li><a href="listarpreeventos.php"><i class="fa fa-circle-o"></i> Pré-Eventos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_94 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '94' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_94) > 0) {
            ?>
            <li><a href="listartarefasaffotografia.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_convite) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-drivers-license-o convite"></i>
            <span>Arte Final - Convite</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
                $sql_permissao_item_112 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '112' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_112) > 0) {
            ?>
            <li><a href="listardadosconvite.php"><i class="fa fa-circle-o"></i> Dados Convite Comissão</a></li>
            <?php } ?>
            <?php 
                $sql_permissao_item_99 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '99' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_99) > 0) {
            ?>
            <li><a href="listararquivosconvite.php"><i class="fa fa-circle-o"></i> Arquivos de Convite</a></li>
            <?php } ?>
            <?php 
                $sql_permissao_item_94 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '94' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_94) > 0) {
            ?>
            <li><a href="listarconvitescontrato.php"><i class="fa fa-circle-o"></i> Convites Contrato</a></li>
            <?php } ?>
            <?php 
                $sql_permissao_item_64 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '64' and id_usuario = '$_SESSION[id]' and listar = '2'");
                if(mysqli_num_rows($sql_permissao_item_64) > 0) {
            ?>
            <li><a href="listarconvitesformandos.php"><i class="fa fa-circle-o"></i> Convites Formandos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_82 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '82' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_82) > 0) {
            ?>
            <li><a href="listartiposervicoafconvite.php"><i class="fa fa-circle-o"></i> Tipo de Serviço</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_83 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '83' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_83) > 0) {
            ?>
            <li><a href="cadastroservicoafconvite.php"><i class="fa fa-circle-o"></i> Cadastro de Serviço</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_73 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '73' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_73) > 0) {
            ?>
            <li><a href="listarpcpafconvite.php"><i class="fa fa-circle-o"></i> PCP</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_84 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '84' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_84) > 0) {
            ?>
            <li><a href="listarapontamentosafconvite.php"><i class="fa fa-circle-o"></i> Apontamentos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_93 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '93' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_93) > 0) {
            ?>
            <li><a href="listartarefasafconvite.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_impressao) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-print"></i>
            <span>Impressão</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_85 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '85' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_85) > 0) {
            ?>
            <li><a href="listartiposervicoimpressao.php"><i class="fa fa-circle-o"></i> Tipo de Serviço</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_86 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '86' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_86) > 0) {
            ?>
            <li><a href="cadastroservicoimpressao.php"><i class="fa fa-circle-o"></i> Cadastro de Serviço</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_74 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '74' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_74) > 0) {
            ?>
            <li><a href="listarpcpimpressao.php"><i class="fa fa-circle-o"></i> PCP</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_87 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '87' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_87) > 0) {
            ?>
            <li><a href="listarapontamentosimpressao.php"><i class="fa fa-circle-o"></i> Apontamentos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_91 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '91' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_91) > 0) {
            ?>
            <li><a href="listartarefasimpressao.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(mysqli_num_rows($sql_permissoes_producao) > 0) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-print"></i>
            <span>Produção</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
            $sql_permissao_item_88 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '88' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_88) > 0) {
            ?>
            <li><a href="listartiposervicoproducao.php"><i class="fa fa-circle-o"></i> Tipo de Serviço</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_89 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '89' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_89) > 0) {
            ?>
            <li><a href="cadastroservicoproducao.php"><i class="fa fa-circle-o"></i> Cadastro de Serviço</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_75 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '75' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_75) > 0) {
            ?>
            <li><a href="listarpcpproducao.php"><i class="fa fa-circle-o"></i> PCP</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_90 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '90' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_90) > 0) {
            ?>
            <li><a href="listarapontamentosproducao.php"><i class="fa fa-circle-o"></i> Apontamentos</a></li>
            <?php } ?>
            <?php 
            $sql_permissao_item_92 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '92' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_92) > 0) {
            ?>
            <li><a href="listartarefasproducao.php"><i class="fa fa-circle-o"></i> Tarefas</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php 
            $sql_permissao_item_105 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '105' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_105) > 0) {
        ?>
        <li>
          <a href="listarfaq.php">
            <i class="fa fa-question-circle"></i>
            <span>FAQ</span>
          </a>
        </li>
        <?php } ?>
        <?php 
            $sql_permissao_item_41 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '41' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_41) > 0) {
        ?>
        <li>
          <a href="listarusuarios.php">
            <i class="fa fa-user-plus"></i>
            <span>Usuários</span>
          </a>
        </li>
        <?php } ?>
        <?php 
            $sql_permissao_item_95 = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '95' and id_usuario = '$_SESSION[id]' and listar = '2'");
            if(mysqli_num_rows($sql_permissao_item_95) > 0) {
        ?>
        <li>
          <a href="backup.php" target="_blank">
            <i class="fa fa-cog"></i>
            <span>Backup</span>
          </a>
        </li>
        <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>