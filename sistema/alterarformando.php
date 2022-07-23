<?php
include "../includes/conexao.php";
session_start();
if ($_SESSION['id'] == null) {
	echo "<script language=\"JavaScript\">
    location.href=\"index.php\";
    </script>";
}else {
	$id = $_GET['id'];
	$vetor = mysqli_fetch_array(mysqli_query($con, "select f.*,t.ncontrato from formandos f left join turmas t on t.id_turma = f.turma where id_formando = '{$id}'"));
	$telefone = preg_replace("/[^0-9]/", "", $vetor['telefone']);
	$id_pagina = 5;
	$sql_permissao = mysqli_query($con, "select * from paginas_permissoes where id_pagina = '{$id_pagina}' and id_usuario = '{$_SESSION['id']}'");
	$vetor_permissao = mysqli_fetch_array($sql_permissao);
	if ($vetor_permissao['listar'] != 2) {
		echo "<script language=\"JavaScript\">
    location.href=\"sempermissao.php\";
    </script>";
	}
	if ($vetor_permissao['listar'] == 2) {
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

          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
          <script type="text/javascript">

              function removeEvento(id) {
                  $.post('recebe_arquivodigital.php?id_digital=' + id + '&id=<?php echo $id; ?>', function () {
                      window.location.reload(true);
                  });

              }
              
              $(document).ready(function () {

                  function limpa_formulário_cep() {
                      // Limpa valores do formulário de cep.
                      $("#rua").val("");
                      $("#bairro").val("");
                      $("#cidade").val("");
                      $("#uf").val("");
                      $("#ibge").val("");
                  }

                  //Quando o campo cep perde o foco.
                  $("#cep").blur(function () {

                      //Nova variável "cep" somente com dígitos.
                      var cep = $(this).val().replace(/\D/g, '');

                      //Verifica se campo cep possui valor informado.
                      if (cep != "") {

                          //Expressão regular para validar o CEP.
                          var validacep = /^[0-9]{8}$/;

                          //Valida o formato do CEP.
                          if (validacep.test(cep)) {

                              //Preenche os campos com "..." enquanto consulta webservice.
                              $("#rua").val("...")
                              $("#bairro").val("...")
                              $("#cidade").val("...")
                              $("#uf").val("...")
                              $("#ibge").val("...")

                              //Consulta o webservice viacep.com.br/
                              $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                                  if (!("erro" in dados)) {
                                      //Atualiza os campos com os valores da consulta.
                                      $("#rua").val(dados.logradouro);
                                      $("#bairro").val(dados.bairro);
                                      $("#cidade").val(dados.localidade);
                                      $("#uf").val(dados.uf);
                                      $("#ibge").val(dados.ibge);
                                  } //end if.
                                  else {
                                      //CEP pesquisado não foi encontrado.
                                      limpa_formulário_cep();
                                      alert("CEP não encontrado.");
                                  }
                              });
                          } //end if.
                          else {
                              //cep é inválido.
                              limpa_formulário_cep();
                              alert("Formato de CEP inválido.");
                          }
                      } //end if.
                      else {
                          //cep sem valor, limpa formulário.
                          limpa_formulário_cep();
                      }
                  });
              });
          </script>
          <script type="text/javascript">
              /* MÃ¡scaras ER */
              function mascara(o, f) {
                  v_obj = o
                  v_fun = f
                  setTimeout("execmascara()", 1)
              }

              function execmascara() {
                  v_obj.value = v_fun(v_obj.value)
              }

              function mtel(v) {
                  v = v.replace(/\D/g, ""); //Remove tudo o que nÃ£o Ã© dÃ­gito
                  v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
                  v = v.replace(/(\d)(\d{4})$/, "$1-$2"); //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
                  return v;
              }

              function id(el) {
                  return document.getElementById(el);
              }

              window.onload = function () {
                  id('telefone').onkeypress = function () {
                      mascara(this, mtel);
                  }
                  id('telefone2').onkeypress = function () {
                      mascara(this, mtel);
                  }
              }

              $(document).ready(function () {
                  $("#palco > div").hide();
                  $("#produto").change(function () {
                      $("#palco > div").hide();
                      $('#' + $(this).val()).show('fast');
                  });
                  $("#palco1 > div").hide();
                  $("#tipobusca").change(function () {
                      $("#palco1 > div").hide();
                      $('#' + $(this).val()).show('fast');
                  });
                  $("#palco2 > div").hide();
                  $("#tipobusca1").change(function () {
                      $("#palco2 > div").hide();
                      $('#' + $(this).val()).show('fast');
                  });
                  $("#palco3 > div").hide();
                  $("#tipobusca2").change(function () {
                      $("#palco3 > div").hide();
                      $('#' + $(this).val()).show('fast');
                  });
                  $("input[name='rd-sexo']").click(function () {
                      $("#palco > div").hide();
                      $('#' + $(this).val()).show('fast');
                  });
              });

              function duplicarCampos() {
                  var clone = document.getElementById('origem').cloneNode(true);
                  var destino = document.getElementById('destino');
                  clone.removeAttribute('hidden');
                  destino.appendChild(clone);
                  var camposClonados = clone.getElementsByTagName('input');
                  for (i = 0; i < camposClonados.length; i++) {
                      camposClonados[i].value = '';
                  }
              }

              function removerCampos(id) {
                  var node1 = document.getElementById('destino');
                  node1.removeChild(node1.childNodes[0]);
              }
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
                         aria-controls="navbarSupportedContent" aria-expanded="false"
                         aria-label="Toggle navigation"><i
                                  class="ti-more"></i></a>
                  </div>

                  <div class="navbar-collapse collapse" id="navbarSupportedContent">

                      <ul class="navbar-nav float-left mr-auto">
                          <li class="nav-item d-none d-md-block"><a
                                      class="nav-link sidebartoggler waves-effect waves-light"
                                      href="javascript:void(0)"
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
                          <!--                            <h4 class="page-title">Alterar Formando</h4>-->
                          <div class="d-flex align-items-center">
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item">Cadastros</a></li>
                                      <li class="breadcrumb-item">Formandos</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Alterar Formando</li>
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
                                  <h4 class="card-title">Formando</h4>

                                  <ul class="nav nav-tabs" role="tablist">

                                      <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#dados"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Dados do Formando</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#interacoes"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Interações</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#financeiro"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Financeiro</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#minhascompras"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Minhas Compras</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fotografia"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Fotografia</span></a>
                                      </li>
                                      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#convite"
                                                              role="tab"><span class="hidden-sm-up"><i
                                                          class="ti-email"></i></span> <span class="hidden-xs-down">Convite</span></a>
                                      </li>

                                  </ul>

                                  <div class="tab-content tabcontent-border">

                                      <div class="tab-pane active" id="dados" role="tabpanel">

                                          <br>
                                          <br>

                                          <table width="100%">

                                              <tr>
                                                  <td width="15%"><a
                                                              href="acessarareanova.php?email=<?php echo $vetor['email']; ?>&senha=<?php echo $vetor['senha']; ?>">
                                                          <button type="button" class="btn btn-success"
                                                                  style="    float: left;">Área do Formando
                                                          </button>
                                                      </a>
																										<?php if ($vetor['topfotos'] == null) { ?>

                                                      <a style="margin-left: 5px"
                                                         href="gerartopfotos.php?id=<?php echo $vetor['id_formando']; ?>">
                                                          <button type="button" class="btn btn-success"
                                                                  style="">Gerar Pasta Top Fotos
                                                          </button>
																												
																												<?php } ?>
                                                  </td>
                                              </tr>

                                          </table>

                                          <br>
                                          <br>

                                          <form action="recebe_alterarformando.php?id=<?php echo $id; ?>"
                                                method="post"
                                                name="cliente" enctype="multipart/form-data"
                                                onSubmit="return verificarCPF()" id="formID">

                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <div class="form-group">
                                                          <label>Foto</label>
                                                          <br>
                                                          <img src="arquivos/<?php echo $vetor['imagem']; ?>"
                                                               width="180px"> Alterar imagem?
                                                          <input type="file" name="imagem">
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="row">

                                                  <div class="col-lg-6">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Conclusão</label>
                                                          <input type="text" name="conclusao"
                                                                 value="<?php echo $vetor['conclusao']; ?>"
                                                                 class="form-control" id="exampleInput"
                                                                 placeholder="Digite o nome" required>
                                                      </fieldset>
                                                  </div>

                                                  <div class="col-lg-6">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Contrato</label>
                                                          <select name="turma" id="turmas" class="form-control">
                                                              <option value="" selected="selected">Selecione...
                                                              </option>
																														<?php
																														$sql_cursos = mysqli_query($con, "select * from turmas order by nome ASC");
																														while ($vetor_curso = mysqli_fetch_array($sql_cursos)) {
																															$sql_instituicao_inicio = mysqli_query($con, "select * from instituicoes where id_instituicao = '{$vetor_curso['id_instituicao']}'");
																															$vetor_instituicao_inicio = mysqli_fetch_array($sql_instituicao_inicio);
																															$sql_curso_inicio = mysqli_query($con, "select * from cursos where id_curso = '{$vetor_curso['curso']}'");
																															$vetor_curso_inicio = mysqli_fetch_array($sql_curso_inicio);
																															?>
                                                                <option value="<?php echo $vetor_curso['id_turma']; ?>"
																																        <?php if (strcasecmp($vetor['turma'], $vetor_curso['id_turma']) == 0) : ?>selected="selected" <?php endif; ?>><?php echo $vetor_curso['ncontrato'] ?>
                                                                    - <?php echo $vetor_curso['nome'] ?> <?php echo $vetor_curso['ano']; ?> <?php echo $vetor_instituicao_inicio['sigla']; ?></option>
																														<?php } ?>
                                                          </select>
                                                      </fieldset>
                                                  </div>

                                              </div>

                                              <div class="row">

                                                  <div class="col-md-2">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Cód.</label>
                                                          <input type="text" name="id_formando"
                                                                 value="<?php echo $vetor['ncontrato'] . '-' . $vetor['id_cadastro'] ?>"
                                                                 class="form-control" id="exampleInput"
                                                                 placeholder="Digite o nome" disabled>
                                                      </fieldset>

                                                  </div>
                                                  <div class="col-md-5">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Nome</label>
                                                          <input type="text" name="nome"
                                                                 value="<?php echo $vetor['nome']; ?>"
                                                                 class="form-control" id="exampleInput"
                                                                 placeholder="Digite o nome" required>
                                                      </fieldset>
                                                  </div>

                                                  <div class="col-md-3">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">Estado Civil</label>
                                                          <select name="estadocivil" class="form-control" required="">
                                                              <option value="<?php echo $vetor['estadocivil']; ?>"
                                                                      selected><?php echo $vetor['estadocivil']; ?></option>
                                                              <option value="Casado(a)">Casado(a)</option>
                                                              <option value="Solteiro(a)">Solteiro(a)</option>
                                                              <option value="Divorciado(a)">Divorciado(a)</option>
                                                              <option value="Viúvo(a)">Viúvo(a)</option>
                                                              <option value="Amasiado(a)">Amasiado(a)</option>
                                                          </select>
                                                      </fieldset>
                                                  </div>
                                                  <fieldset class="form-group">
                                                      <label class="form-label semibold" for="exampleInput">Sexo /
                                                          Genero</label>
                                                      <select name="sexo" class="form-control">
                                                          <option value="" selected="">Selecione...</option>
                                                          <option value="Masculino"
																													        <?php if (strcasecmp($vetor['sexo'], 'Masculino') == 0) : ?>selected="selected" <?php endif; ?>>
                                                              Masculino
                                                          </option>
                                                          <option value="Feminino"
																													        <?php if (strcasecmp($vetor['sexo'], 'Feminino') == 0) : ?>selected="selected" <?php endif; ?>>
                                                              Feminino
                                                          </option>
                                                      </select>
                                                  </fieldset>

                                              </div>

                                              <div class="row">

                                                  <div class="col-md-6">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Est.
                                                              Civil</label>
                                                          <select name="estadocivil" class="form-control">
                                                              <option value="" selected="">Selecione...</option>
                                                              <option value="Casado(a)"
																															        <?php if (strcasecmp($vetor['estadocivil'], 'Casado(a)') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                  Casado(a)
                                                              </option>
                                                              <option value="Solteiro(a)"
																															        <?php if (strcasecmp($vetor['estadocivil'], 'Solteiro(a)') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                  Solteiro(a)
                                                              </option>
                                                              <option value="Divorciado(a)"
																															        <?php if (strcasecmp($vetor['estadocivil'], 'Divorciado(a)') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                  Divorciado(a)
                                                              </option>
                                                              <option value="Viúvo(a)"
																															        <?php if (strcasecmp($vetor['estadocivil'], 'Viúvo(a)') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                  Viúvo(a)
                                                              </option>
                                                              <option value="Amasiado(a)"
																															        <?php if (strcasecmp($vetor['estadocivil'], 'Amasiado(a)') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                  Amasiado(a)
                                                              </option>
                                                          </select>
                                                      </fieldset>
                                                  </div>

                                                  <div class="col-md-6">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Data
                                                              de
                                                              Nasc.</label>
                                                          <input type="date" value="<?php echo $vetor['datanasc']; ?>"
                                                                 name="datanasc" class="form-control"
                                                                 id="exampleInput">
                                                      </fieldset>
                                                  </div>

                                              </div>
                                              <!--.row-->

                                              <div class="row">


                                                  <div class="col-md-6">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">RG</label>
                                                          <input type="number" name="rg"
                                                                 value="<?php echo $vetor['rg']; ?>"
                                                                 class="form-control" placeholder="RG">
                                                      </fieldset>
                                                  </div>

                                                  <div class="col-md-6">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold"
                                                                 for="exampleInput">CPF</label>
                                                          <input type="number" name="cpf"
                                                                 value="<?php echo $vetor['cpf']; ?>"
                                                                 class="form-control" placeholder="CPF">
                                                      </fieldset>
                                                  </div>

                                              </div>
                                              <!--.row-->


                                              <div class="row">

                                                  <div class="col-md-4">

                                                      <div class="row">

                                                          <div class="col-md-12">

                                                              <div class="row">
                                                                  <div class="col-lg-4">
                                                                      <fieldset class="form-group">
                                                                          <label class="form-label"
                                                                                 for="exampleInputEmail1">CEP</label>
                                                                          <input type="text" name="cep"
                                                                                 value="<?php echo $vetor['cep']; ?>"
                                                                                 id="cep"
                                                                                 class="form-control"
                                                                                 placeholder="CEP"
                                                                                 required>
                                                                      </fieldset>
                                                                  </div>
                                                                  <div class="col-lg-8">
                                                                      <fieldset class="form-group">
                                                                          <label class="form-label"
                                                                                 for="exampleInputPassword1">Bairro</label>
                                                                          <input type="text" name="bairro"
                                                                                 value="<?php echo $vetor['bairro']; ?>"
                                                                                 id="bairro" class="form-control"
                                                                                 placeholder="Bairro" required>
                                                                      </fieldset>
                                                                  </div>
                                                              </div>
                                                              <!--.row-->

                                                          </div>

                                                      </div>

                                                  </div>

                                                  <div class="col-md-4">

                                                      <div class="row">

                                                          <div class="col-lg-8">
                                                              <fieldset class="form-group">
                                                                  <label class="form-label"
                                                                         for="exampleInputPassword1">Rua</label>
                                                                  <input type="text" name="endereco"
                                                                         value="<?php echo $vetor['endereco']; ?>"
                                                                         id="rua"
                                                                         class="form-control" placeholder="Endereço"
                                                                         required>
                                                              </fieldset>
                                                          </div>

                                                          <div class="col-lg-4">
                                                              <fieldset class="form-group">
                                                                  <label class="form-label"
                                                                         for="exampleInputPassword1">Complemento</label>
                                                                  <input type="text" name="complemento"
                                                                         value="<?php echo $vetor['complemento']; ?>"
                                                                         class="form-control"
                                                                         placeholder="Complemento"
                                                                         required>
                                                              </fieldset>
                                                          </div>

                                                      </div>

                                                  </div>


                                                  <div class="col-md-4">

                                                      <div class="row">
                                                          <div class="col-lg-4">
                                                              <fieldset class="form-group">
                                                                  <label class="form-label semibold"
                                                                         for="exampleInput">Número</label>
                                                                  <input type="number" name="numero"
                                                                         value="<?php echo $vetor['numero']; ?>"
                                                                         class="form-control" id="exampleInput"
                                                                         placeholder="Número">
                                                              </fieldset>
                                                          </div>

                                                          <div class="col-lg-4">
                                                              <fieldset class="form-group">
                                                                  <label class="form-label semibold"
                                                                         for="exampleInput">Cidade</label>
                                                                  <input type="text" name="cidade"
                                                                         value="<?php echo $vetor['cidade']; ?>"
                                                                         id="cidade"
                                                                         class="form-control" placeholder="Cidade"
                                                                         required>
                                                              </fieldset>
                                                          </div>
                                                          <div class="col-lg-4">
                                                              <fieldset class="form-group">
                                                                  <label class="form-label"
                                                                         for="exampleInputEmail1">Estado</label>
                                                                  <input type="text" name="estado"
                                                                         value="<?php echo $vetor['estado']; ?>"
                                                                         id="uf"
                                                                         class="form-control" placeholder="Estado"
                                                                         required>
                                                              </fieldset>
                                                          </div>

                                                      </div>
                                                      <!--.row-->

                                                  </div>

                                              </div>

                                              <div class="row">
                                                  <div class="col-lg-3">
                                                      <fieldset class="form-group">
                                                          <label class="form-label semibold" for="exampleInput">Telefone
                                                              com
                                                              DDD</label>
                                                          <input type="text" name="celular" id="telefone"
                                                                 value="<?php echo $vetor['celular']; ?>"
                                                                 class="form-control"
                                                                 placeholder="telefone">
                                                      </fieldset>
                                                  </div>
                                                  <div class="col-lg-3">
                                                      <fieldset class="form-group">
                                                          <label class="form-label" for="exampleInputEmail1">Celular
                                                              com
                                                              DDD</label>
                                                          <table width="100%">
                                                              <tr>
                                                                  <td>
                                                                      <a href="https://api.whatsapp.com/send?phone=55<?php echo $telefone; ?>"
                                                                         target="_blank"><img src="imgs/whatsapp.png"
                                                                                              width="30px"></a></td>
                                                                  <td width="2%"></td>
                                                                  <td><input type="text" name="telefone"
                                                                             id="telefone2"
                                                                             value="<?php echo $vetor['telefone']; ?>"
                                                                             class="form-control"
                                                                             placeholder="Celular"
                                                                             required></td>
                                                              </tr>
                                                          </table>

                                                      </fieldset>
                                                  </div>
                                                  <div class="col-lg-3">
                                                      <fieldset class="form-group">
                                                          <label class="form-label"
                                                                 for="exampleInputEmail1">E-mail</label>
                                                          <input type="email" name="email"
                                                                 value="<?php echo $vetor['email']; ?>"
                                                                 class="form-control"
                                                                 placeholder="Estado" required>
                                                      </fieldset>
                                                  </div>
                                              </div>
                                              <!--.row-->

                                              <div class="row">

                                                  <div class="col-md-12">
                                                      <div class="form-group">
                                                          <label>Comissão de Formatura</label>
                                                          <select name="comissao" id="tipobusca" class="form-control"
                                                                  required>
                                                              <option value="1"
																															        <?php if (strcasecmp($vetor['comissao'], '1') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                  Não
                                                              </option>
                                                              <option value="2"
																															        <?php if (strcasecmp($vetor['comissao'], '2') == 0) : ?>selected="selected" <?php endif; ?>>
                                                                  Sim
                                                              </option>
                                                          </select>
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <div class="form-group">
                                                          <label>Cargo</label>

                                                          <input type="text" name="cargo"
                                                                 value="<?php echo $vetor['cargo']; ?>"
                                                                 class="form-control" placeholder="Digite o Cargo">

                                                      </div>
                                                  </div>

                                              </div>


                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <div class="form-group">
                                                          <label>Observações</label>
                                                          <textarea name="observacoes"
                                                                    class="form-control"><?php echo $vetor['observacoes']; ?></textarea>
                                                      </div>
                                                  </div>
                                              </div>
                                              <br>

                                              <table width="100%">
                                                  <tr>
                                                      <td><strong>Pai</strong></td>
                                                  </tr>
                                              </table>
                                              <br>

                                              <div class="row">

                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label>Nome Completo</label>
                                                          <input type="text" name="pai" id="pai"
                                                                 value="<?php echo $vetor['pai']; ?>"
                                                                 class="form-control nomepais" placeholder="Pai">
                                                      </div>
                                                  </div>

                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label>In Memoriam</label>
                                                          <select id="inmemorianpai" name="inmemorianpai"
                                                                  onchange="inMemorianPai(this.value)"
                                                                  class="form-control">
                                                              <option value="1"
																															        <?php if ($vetor['inmemorianpai'] == 1) { ?>selected="selected" <?php } ?>>
                                                                  Sim
                                                              </option>
                                                              <option value="0"
																															        <?php if ($vetor['inmemorianpai'] == 0) { ?>selected="selected" <?php } ?>>
                                                                  Não
                                                              </option>
                                                          </select>
                                                      </div>
                                                  </div>

                                              </div>

                                              <div id="paiOptions">
                                                  <table width="100%">
                                                      <tr>
                                                          <td width="32%"><strong>Celular com DDD:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="32%"><strong>Telefone residêncial com
                                                                  DDD:</strong>
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="32%"><strong>Email:</strong></td>
                                                      </tr>
                                                      <tr>
                                                          <td width="32%"><input type="text" name="celularpai"
                                                                                 id="celularpai" required="true"
                                                                                 value="<?php echo $vetor['celularpai']; ?>"
                                                                                 class="form-control"
                                                                                 placeholder="Celular"></td>
                                                          <td width="2%"></td>
                                                          <td width="32%"><input type="text" name="telresidencial"
                                                                                 id="telefone5" class="form-control"
                                                                                 value="<?php echo $vetor['telresidencial']; ?>"
                                                                                 placeholder="Telefone"
                                                                                 required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="32%"><input type="email" name="emailpai"
                                                                                 class="form-control" id="emailpai"
                                                                                 required="true"
                                                                                 value="<?php echo $vetor['emailpai']; ?>"
                                                                                 placeholder="exemplo@exemplo.com.br">
                                                          </td>
                                                      </tr>
                                                  </table>
                                                  <br>
                                                  <table width="100%">
                                                      <tr>
                                                          <td width="10%"><strong>CEP:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="20%"><strong>Bairro:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="21%"><strong>Endereço:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="8%"><strong>Complemento:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="7%"><strong>Número:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="15%"><strong>Cidade:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="7%"><strong>UF:</strong></td>
                                                      </tr>
                                                      <tr>
                                                          <td width="10%"><input type="text" name="cep1" id="cep1"
                                                                                 class="form-control"
                                                                                 value="<?php echo $vetor['cep1']; ?>"
                                                                                 placeholder="CEP" required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="20%"><input type="text" name="bairro1"
                                                                                 id="bairro1"
                                                                                 class="form-control"
                                                                                 value="<?php echo $vetor['bairro1']; ?>"
                                                                                 placeholder="Bairro" required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="21%"><input type="text" name="endereco1"
                                                                                 id="rua1"
                                                                                 class="form-control"
                                                                                 value="<?php echo $vetor['endereco1']; ?>"
                                                                                 placeholder="Endereço"
                                                                                 required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="8%"><input type="text" name="complemento1"
                                                                                class="form-control"
                                                                                value="<?php echo $vetor['complemento1']; ?>"
                                                                                placeholder="Complemento"
                                                                                required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="7%"><input type="number" name="numero1"
                                                                                class="form-control" id="numero1"
                                                                                value="<?php echo $vetor['numero1']; ?>"
                                                                                placeholder="Numero" required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="15%"><input type="text" name="cidade1"
                                                                                 id="cidade1"
                                                                                 class="form-control"
                                                                                 value="<?php echo $vetor['cidade1']; ?>"
                                                                                 placeholder="Cidade" required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="7%"><input type="text" name="estado1" id="uf1"
                                                                                class="form-control"
                                                                                value="<?php echo $vetor['estado1']; ?>"
                                                                                placeholder="Estado" required="true">
                                                          </td>
                                                      </tr>
                                                  </table>
                                              </div>
                                              <br>

                                              <table width="100%">
                                                  <tr>
                                                      <td><strong>Mãe</strong></td>
                                                  </tr>
                                              </table>
                                              <br>

                                              <div class="row">

                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label>Nome Completo</label>
                                                          <input type="text" name="mae" id="mae"
                                                                 value="<?php echo $vetor['mae']; ?>"
                                                                 class="form-control nomepais" placeholder="Mãe">
                                                      </div>
                                                  </div>

                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label>In Memoriam</label>
                                                          <select id="inmemorianmae" name="inmemorianmae"
                                                                  class="select-inmemorianmae form-control"
                                                                  onchange="inMemorianMae(this.value)">
                                                              <option value="1"
																															        <?php if ($vetor['inmemorianmae'] == 1) : ?>selected="selected" <?php endif; ?>>
                                                                  Sim
                                                              </option>
                                                              <option value="0"
																															        <?php if ($vetor['inmemorianmae'] == 0) : ?>selected="selected" <?php endif; ?>>
                                                                  Não
                                                              </option>
                                                          </select>
                                                      </div>
                                                  </div>

                                              </div>

                                              <div id="maeOptions">
                                                  <table width="100%">
                                                      <tr>
                                                          <td width="32%"><strong>Celular com DDD:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="32%"><strong>Telefone residêncial com
                                                                  DDD:</strong>
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="32%"><strong>Email:</strong></td>
                                                      </tr>
                                                      <tr>
                                                          <td width="32%"><input type="text" name="celularmae"
                                                                                 id="telefone4" class="form-control"
                                                                                 value="<?php echo $vetor['celularmae']; ?>"
                                                                                 placeholder="Celular"
                                                                                 required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="32%"><input type="text" name="telresidencial1"
                                                                                 id="telefone6"
                                                                                 value="<?php echo $vetor['telresidencial1']; ?>"
                                                                                 class="form-control"
                                                                                 placeholder="Telefone"
                                                                                 required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="32%"><input type="email" name="emailmae"
                                                                                 class="form-control"
                                                                                 value="<?php echo $vetor['emailmae']; ?>"
                                                                                 placeholder="exemplo@exemplo.com.br"
                                                                                 required="true"></td>
                                                      </tr>
                                                  </table>
                                                  <br>
                                                  <table width="100%">
                                                      <tr>
                                                          <td width="10%"><strong>CEP:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="20%"><strong>Bairro:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="21%"><strong>Endereço:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="8%"><strong>Complemento:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="7%"><strong>Número:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="15%"><strong>Cidade:</strong></td>
                                                          <td width="2%"></td>
                                                          <td width="7%"><strong>UF:</strong></td>
                                                      </tr>
                                                      <tr>
                                                          <td width="10%"><input type="text" name="cep2" id="cep2"
                                                                                 class="form-control"
                                                                                 value="<?php echo $vetor['cep2']; ?>"
                                                                                 placeholder="CEP" required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="20%"><input type="text" name="bairro2"
                                                                                 id="bairro2"
                                                                                 class="form-control"
                                                                                 value="<?php echo $vetor['bairro2']; ?>"
                                                                                 placeholder="Bairro" required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="21%"><input type="text" name="endereco2"
                                                                                 id="rua2"
                                                                                 class="form-control"
                                                                                 value="<?php echo $vetor['endereco2']; ?>"
                                                                                 placeholder="Endereço"
                                                                                 required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="8%"><input type="text" name="complemento2"
                                                                                class="form-control"
                                                                                value="<?php echo $vetor['complemento2']; ?>"
                                                                                placeholder="Complemento"
                                                                                required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="7%"><input type="number" name="numero2"
                                                                                class="form-control" id="exampleInput"
                                                                                value="<?php echo $vetor['numero2']; ?>"
                                                                                placeholder="Numero" required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="15%"><input type="text" name="cidade2"
                                                                                 id="cidade2"
                                                                                 class="form-control"
                                                                                 value="<?php echo $vetor['cidade2']; ?>"
                                                                                 placeholder="Cidade" required="true">
                                                          </td>
                                                          <td width="2%"></td>
                                                          <td width="7%"><input type="text" name="estado2" id="uf2"
                                                                                class="form-control"
                                                                                value="<?php echo $vetor['estado2']; ?>"
                                                                                placeholder="Estado" required="true">
                                                          </td>
                                                      </tr>
                                                  </table>

                                              </div>

                                              <h3>Outro Responsavel</h3>

                                              <div class="row">

                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label>Nome</label>
                                                          <input type="text" name="nomeresponsavel"
                                                                 id="nomeresponsavel"
                                                                 value="<?php echo $vetor['nomeresponsavel']; ?>"
                                                                 class="form-control" required>
                                                      </div>
                                                  </div>

                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label>Telefone</label>
                                                          <input type="text" name="telefoneresponsavel"
                                                                 id="telefoneresponsavel"
                                                                 value="<?php echo $vetor['telefoneresponsavel']; ?>"
                                                                 class="form-control" required>
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="row">

                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label>Tipo Responsável</label>
                                                          <select name="tiporesponsavel" id="tiporesponsavel"
                                                                  class="form-control">
                                                              <option value="<?php echo $vetor['tiporesponsavel']; ?>"
                                                                      selected><?php echo $vetor['tiporesponsavel']; ?></option>
                                                              <option value="Pai">Pai</option>
                                                              <option value="Mãe">Mãe</option>
                                                              <option value="Cônjuge">Cônjuge</option>
                                                              <option value="Tio">Tio</option>
                                                              <option value="Tia">Tia</option>
                                                              <option value="Padrinho">Padrinho</option>
                                                              <option value="Madrinha">Madrinha</option>
                                                              <option value="Irmã">Irmã</option>
                                                              <option value="Irmão">Irmão</option>
                                                              <option value="Avô">Avô</option>
                                                              <option value="Avó">Avó</option>
                                                              <option value="Outros">Outros</option>
                                                          </select>
                                                      </div>
                                                  </div>

                                                  <div class="col-md-6">
                                                      <div class="form-group">

                                                          <div id="palco2">
                                                              <div id="Outros">


                                                                  <label>Tipo Responsável</label>
                                                                  <input type="text" name="outroresponsavel"
                                                                         id="outroresponsavel"
                                                                         disabled required="true"
                                                                         class="form-control">

                                                              </div>
                                                          </div>

                                                      </div>
                                                  </div>

                                              </div>

                                              <div class="row">

                                                  <div class="col-lg-12">
                                                      <fieldset class="form-group">
                                                          <label class="form-label" for="exampleInputEmail1">Este pode
                                                              ser
                                                              um
                                                              meio pelo qual suas fotografias poderão ser enviadas
                                                              futuramente,
                                                              portanto, é muito importante que nos deixe o endereço da
                                                              sua
                                                              rede
                                                              social.</label>
                                                          <input type="text" name="instagram"
                                                                 value="<?php echo $vetor['instagram']; ?>"
                                                                 class="form-control"
                                                                 placeholder="Instagram">
                                                      </fieldset>
                                                  </div>

                                              </div>
                                              <div class="row">

                                                  <div class="col-lg-12">
                                                      <fieldset class="form-group">
                                                          <label class="form-label"
                                                                 for="exampleInputEmail1">Facebook:</label>
                                                          <input type="text" name="facebook"
                                                                 value="<?php echo $vetor['facebook']; ?>"
                                                                 class="form-control"
                                                                 placeholder="Facebook">
                                                      </fieldset>
                                                  </div>

                                              </div>
                                              <!--.row-->
																						
																						<?php if ($vetor_permissao['alteracao'] == 1) {
																						}else { ?>
                                                <button type="submit" class="btn btn-primary"
                                                        style="    float: left;">
                                                    Salvar
                                                </button><?php } ?>

                                          </form>

                                      </div>

                                      <div class="tab-pane" id="interacoes" role="tabpanel">

                                          <br>

                                          <a href="cadastrointeracao.php?id=<?php echo $id; ?>" target="_blank">
                                              <button type="button" class="btn btn-primary"
                                                      style="    float: left;">
                                                  Cadastrar Interação
                                              </button>
                                          </a>

                                          <br>
                                          <br>
                                          <br>

                                          <table id="lang_opt" class="table table-bordered table-striped">
                                              <thead>
                                              <tr>
                                                  <th>Data</th>
                                                  <th>Hora</th>
                                                  <th>Meio</th>
                                                  <th>Assunto</th>
                                                  <th width="80%">Ocorrência</th>
                                              </tr>
                                              </thead>
                                              <tbody>
																							<?php
																							$sql_interacoes = mysqli_query($con, "select * from interacao where id_cliente = '{$id}' order by id_interacao DESC");
																							while ($vetor_interacao = mysqli_fetch_array($sql_interacoes)) {
																								$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '{$vetor_interacao['id_usuario']}'");
																								$vetor_formando = mysqli_fetch_array($sql_formando);
																								$sql_tipo = mysqli_query($con, "select * from tipo_interacao where id_tipo = '{$vetor_interacao['tipo']}'");
																								$vetor_tipo = mysqli_fetch_array($sql_tipo);
																								$sql_assunto = mysqli_query($con, "select * from assuntos where id_assunto = '{$vetor_interacao['assunto']}'");
																								$vetor_assunto = mysqli_fetch_array($sql_assunto);
																								?>
                                                  <tr>
                                                      <td><?php echo date('d/m/Y', strtotime($vetor_interacao['data'])); ?></td>
                                                      <td><?php echo $vetor_interacao['hora']; ?></td>
                                                      <td><?php echo $vetor_tipo['nome']; ?></td>
                                                      <td><?php echo $vetor_assunto['nome']; ?></td>
                                                      <td><?php echo $vetor_interacao['ocorrencia']; ?></td>
                                                  </tr>
																							<?php } ?>
                                              </tbody>
                                              <tfoot>
                                              <tr>
                                                  <th>Data</th>
                                                  <th>Hora</th>
                                                  <th>Tipo</th>
                                                  <th>Assunto</th>
                                                  <th>Ocorrência</th>
                                              </tr>
                                              </tfoot>
                                          </table>

                                      </div>

                                      <div class="tab-pane" id="financeiro" role="tabpanel">

                                          <br>

                                          <table id="lang_opt1" class="table table-bordered table-striped">
                                              <thead>
                                              <tr>
                                                  <th>Formando</th>
                                                  <th>Parcela</th>
                                                  <th>Data de Vencimento</th>
                                                  <th>Forma de Pagamento</th>
                                                  <th>Valor</th>
                                                  <th>Status</th>
                                              </tr>
                                              </thead>
                                              <tbody>
																							<?php
																							$sql_atual1 = mysqli_query($con, "select * from duplicatas_faturas order by data ASC");
																							while ($vetor1 = mysqli_fetch_array($sql_atual1)) {
																								$sql_duplicata = mysqli_query($con, "select * from duplicatas where id_duplicata = '{$vetor1['id_duplicata']}'");
																								$vetor_duplicata = mysqli_fetch_array($sql_duplicata);
																								$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '{$vetor_duplicata['id_formando']}'");
																								$vetor_formando = mysqli_fetch_array($sql_formando);
																								$sql_venda_duplicata = mysqli_query($con, "select * from vendas where id_venda = '{$vetor_duplicata['id_venda']}'");
																								$vetor_venda_duplicata = mysqli_fetch_array($sql_venda_duplicata);
																								$sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '{$vetor1['formapag']}'");
																								$vetor_forma = mysqli_fetch_array($sql_forma);
																								if ($vetor_duplicata['id_formando'] == $id) {
																									?>
                                                    <tr>
                                                        <td><?php echo $vetor_formando['nome']; ?></td>
                                                        <td><?php echo $vetor1['posicao']; ?>
                                                            /<?php echo $vetor_venda_duplicata['qtdparcelas']; ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($vetor1['data'])); ?></td>
                                                        <td><?php echo $vetor_forma['nome']; ?></td>
                                                        <td><?php echo $num = number_format($vetor1['valor'], 2, ',', '.'); ?></td>
                                                        <td><?php if ((int)$vetor1['status'] == 1 || ((int)$vetor1['status'] == 2 && (int)$vetor1['pagamento'] != 1)) {
				                                                    echo "Em Aberto";
			                                                    }
			                                                    if ((int)$vetor1['status'] == 2 && (int)$vetor1['pagamento'] == 1) {
				                                                    echo "Recebido";
			                                                    }
			                                                    if ((int)$vetor1['status'] == 3) {
				                                                    echo "Cancelado";
			                                                    }
			                                                    if ((int)$vetor1['status'] == 4) {
				                                                    echo "Negado";
			                                                    } ?>
                                                        </td>
                                                    </tr>
																								<?php }
																							} ?>
                                              </tbody>
                                          </table>

                                      </div>

                                      <div class="tab-pane" id="minhascompras" role="tabpanel">

                                          <br>

                                          <table id="lang_opt2" class="table table-bordered table-striped">
                                              <thead>
                                              <tr>
                                                  <th width="10%">Código</th>
                                                  <th>Formando</th>
                                                  <th>Tipo da Venda</th>
                                                  <th>Data da Venda</th>
                                                  <th>Data de Vencimento</th>
                                                  <th>Data 1° Vencimento</th>
                                                  <th>Parcelas</th>
                                                  <th>Forma de Pagamento</th>
                                                  <th>Valor da Venda</th>
                                                  <th>Status</th>
                                                  <th width="4%">Ação</th>
                                              </tr>
                                              </thead>
                                              <tbody>
																							<?php
																							$sql_atual = mysqli_query($con, "select * from vendas where id_formando = '{$id}' and iniciada = '2'");
																							while ($vetor_venda = mysqli_fetch_array($sql_atual)) {
																								$sql_formando = mysqli_query($con, "select * from formandos where id_formando = '{$vetor['id_formando']}'");
																								$vetor_formando = mysqli_fetch_array($sql_formando);
																								$sql_forma = mysqli_query($con, "select * from formaspag where id_forma = '{$vetor_venda['formapag']}'");
																								$vetor_forma = mysqli_fetch_array($sql_forma);
																								$sql_vencimentos = mysqli_query($con, "select a.id_duplicata, a.id_venda, b.id_duplicata, b.data, b.posicao from duplicatas a, duplicatas_faturas b where a.id_duplicata = b.id_duplicata and a.id_venda = '{$vetor_venda['id_venda']}' order by b.posicao ASC limit 0,1");
																								$vetor_vencimento = mysqli_fetch_array($sql_vencimentos);
																								?>
                                                  <tr>
                                                      <td><?php echo $vetor_venda['id_venda']; ?></td>
                                                      <td><?php echo $vetor_formando['nome']; ?></td>
                                                      <td><?php if ($vetor_venda['tipo'] == 1) {
																													echo "Convites";
																												}
																												if ($vetor_venda['tipo'] == 2) {
																													echo "Fotografias";
																												} ?></td>
                                                      <td><?php echo date('d/m/Y', strtotime($vetor_venda['data'])); ?></td>
                                                      <td><?php echo $vetor_venda['diavencimento']; ?></td>
                                                      <td><?php if ($vetor_vencimento['data'] == null) {
																												}else {
																													echo date('d/m/Y', strtotime($vetor_vencimento['data']));
																												} ?></td>
                                                      <td><?php echo $vetor_venda['qtdparcelas']; ?></td>
                                                      <td><?php echo $vetor_forma['nome']; ?></td>
                                                      <td><?php echo $num = number_format($vetor_venda['valorvenda'], 2, ',', '.'); ?></td>
                                                      <td><?php if($vetor_venda['status'] == '4'){
                                                              echo "Cancelado";
                                                          }elseif(($vetor_venda['formapag'] == '3' && $vetor_venda['pagamento'] == '1') || $vetor_venda['formapag'] != '3'){
                                                              echo "Compra Finalizada";
                                                          }else{
                                                              echo "Aguardando Pagamento";
                                                          }?>
                                                      </td>
                                                      <td>
                                                          <a href="vervenda.php?id=<?php echo $vetor_venda['id_venda']; ?>">
                                                              <button type="button"
                                                                      class="btn btn-success mesmo-tamanho"
                                                                      title="Ver Cadastro"><i
                                                                          class="fa fa-edit"></i>
                                                              </button>
                                                          </a></td>
                                                  </tr>
																							<?php } ?>
                                              </tbody>
                                          </table>
                                      </div>

                                      <div class="tab-pane" id="fotografia" role="tabpanel">

                                          <br>
                                          <br>

                                          <ul class="nav nav-tabs" role="tablist">

                                              <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                      href="#documentosfotografia" role="tab"><span
                                                              class="hidden-sm-up"><i class="ti-email"></i></span>
                                                      <span
                                                              class="hidden-xs-down">Documentos</span></a></li>
                                              <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                      href="#produtosfotografia" role="tab"><span
                                                              class="hidden-sm-up"><i class="ti-email"></i></span>
                                                      <span
                                                              class="hidden-xs-down">Produtos</span></a></li>
                                              <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                      href="#minhasfotosfotografia" role="tab"><span
                                                              class="hidden-sm-up"><i class="ti-email"></i></span>
                                                      <span
                                                              class="hidden-xs-down">Minhas Fotos</span></a></li>
                                              <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                      href="#arquivosdeimpressaofotografia"
                                                                      role="tab"><span
                                                              class="hidden-sm-up"><i class="ti-email"></i></span>
                                                      <span
                                                              class="hidden-xs-down">Arquivos de Impressão</span></a>
                                              </li>
                                              <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                      href="#arquivodigitalfotografia"
                                                                      role="tab"><span
                                                              class="hidden-sm-up"><i class="ti-email"></i></span>
                                                      <span
                                                              class="hidden-xs-down">Arquivo Digital</span></a></li>
                                              <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                      href="#albumvirtualfotografia"
                                                                      role="tab"><span
                                                              class="hidden-sm-up"><i class="ti-email"></i></span>
                                                      <span
                                                              class="hidden-xs-down">Álbum Virtual</span></a></li>

                                          </ul>

                                          <div class="tab-content tabcontent-border">

                                              <div class="tab-pane active" id="documentosfotografia"
                                                   role="tabpanel">

                                                  <br>
                                                  <br>

                                                  <a href="cadastroarquivo.php?id=<?php echo $id; ?>">
                                                      <button type="button" class="btn btn-primary"
                                                              style="    float: left;">Cadastrar Arquivo
                                                      </button>
                                                  </a>

                                                  <br>
                                                  <br>
                                                  <br>

                                                  <table id="lang_opt3" class="table table-bordered table-striped">
                                                      <thead>
                                                      <tr>
                                                          <th>Titulo</th>
                                                          <th>Data</th>
                                                          <th>Hora</th>
                                                          <th>Arquivo</th>
                                                      </tr>
                                                      </thead>
                                                      <tbody>
																											<?php
																											$sql_arquivos = mysqli_query($con, "select * from arquivos where id_cliente = '{$id}' and tipo = '1' order by id_arquivo DESC");
																											while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
																												$sql_formando = mysqli_query($con, "select * from formando where id_formando = '{$vetor_arquivo['id_cliente']}'");
																												$vetor_formando = mysqli_fetch_array($sql_formando);
																												?>
                                                          <tr>
                                                              <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                              <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?></td>
                                                              <td><?php echo $vetor_arquivo['hora']; ?></td>
                                                              <td>
                                                                  <a href="arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                                     target="_blank">
                                                                      <button type="button" class="btn btn-default">
                                                                          Arquivo
                                                                      </button>
                                                                  </a> <?php if ($vetor_permissao['exclusao'] == 1) {
																																}else { ?><a
                                                                      href="excluirarquivo.php?id=<?php echo $vetor_arquivo['id_arquivo']; ?>&id1=<?php echo $id; ?>"
                                                                      target="_blank">
                                                                          <button type="button"
                                                                                  class="btn btn-danger">
                                                                              Excluir
                                                                          </button></a><?php } ?></td>
                                                          </tr>
																											<?php } ?>
                                                      </tbody>
                                                      <tfoot>
                                                      <tr>
                                                          <th>Titulo</th>
                                                          <th>Data</th>
                                                          <th>Hora</th>
                                                          <th>Arquivo</th>
                                                      </tr>
                                                      </tfoot>
                                                  </table>

                                              </div>

                                              <div class="tab-pane" id="produtosfotografia" role="tabpanel">

                                                  <br>
                                                  <br>

                                                  <table id="lang_opt4" class="table table-bordered table-striped">
                                                      <thead>
                                                      <tr>
                                                          <th>Produtos</th>
                                                          <th>Ação</th>
                                                      </tr>
                                                      </thead>
                                                      <tbody>
																											<?php
																											$sql_produtos_contrato = mysqli_query($con, "select * from vendas where id_formando = '$id' and tipo = '2'");
																											while ($vetor_produtos_contrato = mysqli_fetch_array($sql_produtos_contrato)) {
																												$sql_pacotes = mysqli_query($con, "select * from pacotes_itens_album where id_item = '{$vetor_produtos_contrato['id_pacote']}'");
																												$vetor_pacotes = mysqli_fetch_array($sql_pacotes);
																												if ($vetor_produtos_contrato['tipo'] == 2) {
																													$sql_produtos = mysqli_query($con, "select * from pacotes_itens_produtos where id_pacote = '{$vetor_pacotes['id_item']}'");
																												}
																												if ($vetor_produtos_contrato['tipo'] == 3) {
																													$sql_produtos = mysqli_query($con, "select * from venda_avulsa_produtos where id_avulsa = '{$vetor_produtos_contrato['produto']}'");
																												}
																												while ($vetor_produto_final = mysqli_fetch_array($sql_produtos)) {
																													if ($vetor_produtos_contrato['tipo'] == 2) {
																														$sql_produto_item = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '{$vetor_produto_final['id_produto']}'");
																														$vetor_produto_item = mysqli_fetch_array($sql_produto_item);
																													}
																													if ($vetor_produtos_contrato['tipo'] == 3) {
																														$sql_produto_item = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '{$vetor_produto_final['id_item']}'");
																														$vetor_produto_item = mysqli_fetch_array($sql_produto_item);
																													}
																													?>
                                                            <tr>
                                                                <td><?php echo $vetor_produto_item['nome']; ?></td>
                                                                <td>
																																	<?php if ($vetor_produto_item['aprovacao'] == 2) { ?>
                                                                      <a href="listaraprovacoesformando.php?id=<?php echo $vetor_produto_item['id_tipo']; ?>&id_formando=<?php echo $id; ?>">
                                                                          <button type="button"
                                                                                  class="btn btn-info mesmo-tamanho"
                                                                                  title="Aprovações Formando"><i
                                                                                      class="fa fa-edit"></i>
                                                                          </button>
                                                                      </a>
																																	<?php } ?>
                                                                </td>
                                                            </tr>
																												<?php }
																											} ?>
																											<?php
																											$sql_produtos_contrato = mysqli_query($con, "select * from vendas where id_formando = '{$id}' and tipo = '3'");
																											while ($vetor_produtos_contrato = mysqli_fetch_array($sql_produtos_contrato)) {
																												$sql_pacotes = mysqli_query($con, "select * from pacotes_itens_album where id_item = '{$vetor_produtos_contrato['id_pacote']}'");
																												$vetor_pacotes = mysqli_fetch_array($sql_pacotes);
																												if ($vetor_produtos_contrato['tipo'] == 2) {
																													$sql_produtos = mysqli_query($con, "select * from pacotes_itens_produtos where id_pacote = '{$vetor_pacotes['id_item']}'");
																												}
																												if ($vetor_produtos_contrato['tipo'] == 3) {
																													$sql_produtos = mysqli_query($con, "select * from venda_avulsa_produtos where id_avulsa = '{$vetor_produtos_contrato['produto']}'");
																												}
																												while ($vetor_produto_final = mysqli_fetch_array($sql_produtos)) {
																													if ($vetor_produtos_contrato['tipo'] == 2) {
																														$sql_produto_item = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '{$vetor_produto_final['id_produto']}'");
																														$vetor_produto_item = mysqli_fetch_array($sql_produto_item);
																													}
																													if ($vetor_produtos_contrato['tipo'] == 3) {
																														$sql_produto_item = mysqli_query($con, "select * from tipo_opcionais where id_tipo = '{$vetor_produto_final['id_item']}'");
																														$vetor_produto_item = mysqli_fetch_array($sql_produto_item);
																													}
																													?>
                                                            <tr>
                                                                <td><?php echo $vetor_produto_item['nome']; ?></td>
                                                                <td>
																																	<?php if ($vetor_produto_item['aprovacao'] == 2) { ?>
                                                                      <a href="listaraprovacoesformando.php?id=<?php echo $vetor_produto_item['id_tipo']; ?>&id_formando=<?php echo $id; ?>">
                                                                          <button type="button"
                                                                                  class="btn btn-info mesmo-tamanho"
                                                                                  title="Aprovações Formando"><i
                                                                                      class="fa fa-edit"></i>
                                                                          </button>
                                                                      </a>
																																	<?php } ?>
                                                                </td>
                                                            </tr>
																												<?php }
																											} ?>
                                                      </tbody>
                                                      <tfoot>
                                                      <tr>
                                                          <th>Produtos</th>
                                                          <th>Ação</th>
                                                      </tr>
                                                      </tfoot>
                                                  </table>

                                              </div>

                                              <div class="tab-pane" id="minhasfotosfotografia" role="tabpanel">

                                                  <br>
                                                  <br>

                                                  <a href="cadastrofotoformando.php?id=<?php echo $id; ?>">
                                                      <button type="button" class="btn btn-primary"
                                                              style="    float: left;">Cadastrar Evento
                                                      </button>
                                                  </a>

                                                  <br>
                                                  <br>
                                                  <br>

                                                  <table id="lang_opt5" class="table table-bordered table-striped">
                                                      <thead>
                                                      <tr>
                                                          <th width="5%">Cód</th>
                                                          <th>Titulo</th>
                                                          <th>Tipo</th>
                                                          <th></th>
                                                      </tr>
                                                      </thead>
                                                      <tbody>
																											<?php
																											$sql_eventos = mysqli_query($con, "select * from eventosformando where id_formando = '{$id}' order by id_evento DESC");
																											while ($vetor_evento = mysqli_fetch_array($sql_eventos)) {
																												?>
                                                          <tr>
                                                              <td><?php echo $vetor_evento['id_evento']; ?></td>
                                                              <td><?php echo $vetor_evento['titulo']; ?></td>
                                                              <td><?php if ($vetor_evento['tipo'] == 1) {
																																	echo "Pré-Evento";
																																}
																																if ($vetor_evento['tipo'] == 2) {
																																	echo "Evento";
																																} ?></td>
                                                              <td>
                                                                  <a href="verfotosformando.php?id=<?php echo $vetor_evento['id_evento']; ?>">
                                                                      <button type="button"
                                                                              class="btn btn-success mesmo-tamanho"
                                                                              title="Ver Cadastro"><i
                                                                                  class="fa fa-edit"></i></button>
                                                                  </a> <?php if ($vetor_permissao['exclusao'] == 1) {
																																}else { ?><a
                                                                      href="excluireventoformando.php?id=<?php echo $vetor_evento['id_evento']; ?>&id1=<?php echo $id; ?>"
                                                                      target="_blank">
                                                                          <button type="button"
                                                                                  class="btn btn-danger mesmo-tamanho"
                                                                                  title="Excluir Cadastro"><i
                                                                                      class="mdi mdi-window-close"></i>
                                                                          </button><?php } ?></td>
                                                          </tr>
																											<?php } ?>
                                                      </tbody>
                                                      <tfoot>
                                                      <tr>
                                                          <th width="5%">Cód</th>
                                                          <th>Titulo</th>
                                                          <th>Tipo</th>
                                                          <th></th>
                                                      </tr>
                                                      </tfoot>
                                                  </table>

                                              </div>

                                              <div class="tab-pane" id="arquivosdeimpressaofotografia"
                                                   role="tabpanel">

                                                  <br>
                                                  <br>

                                                  <a href="cadastroarquivoimpressaoformando.php?id=<?php echo $id; ?>">
                                                      <button type="button" class="btn btn-primary"
                                                              style="    float: left;">Cadastrar Arquivo de
                                                          Impressão
                                                      </button>
                                                  </a>

                                                  <br>
                                                  <br>
                                                  <br>

                                                  <table id="lang_opt7" class="table table-bordered table-striped">
                                                      <thead>
                                                      <tr>
                                                          <th>Ação</th>
                                                      </tr>
                                                      </thead>
                                                      <tbody>
																											<?php
																											$sql_separacao = mysqli_query($con, "select * from arquivoimpressao_formando where id_formando = '{$id}' order by id_arquivo DESC");
																											while ($vetor_separacao = mysqli_fetch_array($sql_separacao)) {
																												?>
                                                          <tr>
                                                              <td>
                                                                  <a href="arquivos/<?php echo $vetor_separacao['arquivo']; ?>"
                                                                     target="_blank">
                                                                      <button type="button" class="btn btn-default">
                                                                          Arquivo
                                                                      </button>
                                                                  </a> <?php if ($vetor_permissao['exclusao'] == 1) {
																																}else { ?><a
                                                                      href="excluirarquivoimpressaoformando.php?id=<?php echo $vetor_evento['id_arquivo']; ?>&id1=<?php echo $id; ?>"
                                                                      target="_blank">
                                                                          <button type="button"
                                                                                  class="btn btn-danger mesmo-tamanho"
                                                                                  title="Excluir Cadastro"><i
                                                                                      class="mdi mdi-window-close"></i>
                                                                          </button><?php } ?></td>
                                                          </tr>
																											<?php } ?>
                                                      </tbody>
                                                      <tfoot>
                                                      <tr>
                                                          <th>Ação</th>
                                                      </tr>
                                                      </tfoot>
                                                  </table>

                                              </div>

                                              <div class="tab-pane" id="arquivodigitalfotografia" role="tabpanel">
                                                  <div id="origem" hidden>
                                                      <div class="row">
                                                          <input type="text" name="id_digital[]" value="" hidden>
                                                          <div class="col-lg-4">
                                                              <fieldset class="form-group">
                                                                  <label class="form-label semibold"
                                                                         for="exampleInput">Eventos</label>
                                                                  <select name="evento_lista[]" class="form-control">
                                                                      <option value="" selected="selected">Selecione...
                                                                      </option>
																																		<?php
																																		$sql_eventos_lista = mysqli_query($con, "select * from eventos_turma_lista where id_turma='{$vetor['turma']}' and id_evento not in (select id_evento from arquivos_digitais where id_formando='{$vetor['id_formando']}') order by id_evento");
																																		while ($vetor_eventos_lista = mysqli_fetch_array($sql_eventos_lista)) {
																																			$nome_evento = mysqli_fetch_array(mysqli_query($con, "select * from categoriaevento where id_categoria = '{$vetor_eventos_lista['id_evento']}'"))
																																			?>
                                                                        <option value="<?php echo $nome_evento['id_categoria'] ?>"><?php echo $nome_evento['nome']; ?>
                                                                        </option>
																																		<?php } ?>
                                                                  </select>
                                                              </fieldset>
                                                          </div>
                                                          <div class="col-lg-6">
                                                              <fieldset class="form-group">
                                                                  <label class="form-label semibold"
                                                                         for="linkarquivodigital">Link para o Arquivo
                                                                      Digital</label>
                                                                  <input class="form-control"
                                                                         name="linkarquivodigital[]" type="text"
                                                                         value="">
                                                              </fieldset>
                                                          </div>
                                                      </div>
                                                  </div>
																								<?php if ($vetor['arquivodigital'] == 1) { ?>
                                                    <a href="<?php echo $vetor['link_arquivo_digital']; ?>"
                                                       target="_blank">
                                                        <button type="button" class="btn btn-info">Abrir Arquivo Digital
                                                        </button>
                                                    </a>
																								<?php } ?>
                                                  <br>
                                                  <form action="recebe_arquivodigital.php?id=<?php echo $id; ?>"
                                                        method="post">
                                                      <br>
																										<?php
																										$sql_digital = mysqli_query($con, "select * from arquivos_digitais where id_formando = '{$id}'");
																										while ($dados = mysqli_fetch_array($sql_digital)) {
																											$nome_evento = mysqli_fetch_array(mysqli_query($con, "select * from categoriaevento where id_categoria = '{$dados['id_evento']}'"));
																											?>
                                                        <br>
                                                        <div class="row">
                                                            <input type="text" name="id_digital[]"
                                                                   value="<?php echo $dados['id_arquivo_digital'] ?>"
                                                                   hidden>
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="exampleInput">Evento</label>
                                                                    <select name="evento_lista[]" class="form-control">
                                                                        <option value="<?php echo $nome_evento['id_categoria']; ?>"
                                                                                selected><?php echo $nome_evento['nome'] ?></option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <fieldset class="form-group">
                                                                    <label class="form-label semibold"
                                                                           for="linkarquivodigital">Link para o Arquivo
                                                                        Digital</label>
                                                                    <input class="form-control"
                                                                           name="linkarquivodigital[]" type="text"
                                                                           value="<?php echo $dados['link_arquivo_digital']; ?>">
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <button type="button" class="btn btn-danger"
                                                                        onclick="removeEvento(<?php echo $dados['id_arquivo_digital']; ?>)"
                                                                        style="margin-top: 30px;">Excluir Evento
                                                                </button>
                                                            </div>
                                                        </div>
																											<?php } ?>
                                                      <div id="destino"></div>
                                                      <br>
                                                      <br>
                                                      <input type="button" value="Adicionar" onclick="duplicarCampos();"
                                                             class="btn btn-warning">
                                                      <input type="button" value="Remover"
                                                             onclick="removerCampos(this);"
                                                             class="btn btn-danger">
                                                      <br>
                                                      <br>
                                                      <button type="submit" class="btn btn-primary"
                                                              style="float: left;">
                                                          Salvar
                                                      </button>
                                                  </form>
                                              </div>
                                          <div class="tab-pane" id="albumvirtualfotografia" role="tabpanel">

                                              <br>
                                              <br>
																						
																						<?php
																						$sql_album_virtual = mysqli_query($con, "select * from album_virutal where id_formando = '{$id}'");
																						if (mysqli_num_rows($sql_album_virtual) == 0) {
																							?>
                                                <div id="addfile">
                                                    <input id="arquivo" type="file" accept="application/pdf"
                                                           name="arquivo"/>
                                                    <br>
                                                    <img id="loading"
                                                         style="visibility:hidden;width: 50px;height: auto;"
                                                         src="../imgs/loading.gif">
                                                    <button id="addFileButton"
                                                            class="btn btn-success"><i
                                                                class="mdi mdi-upload"></i>
                                                        Enviar Arquivo
                                                    </button>
                                                </div>

                                                <div id="filedownload" hidden>
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>Arquivo</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <a id="filelink" href=""
                                                                   target="_blank">
                                                                    <button type="button"
                                                                            class="btn btn-default">
                                                                        Abrir Album Virtual
                                                                    </button>
                                                                </a></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
																							
																							<?php
																						}else {
																							$vetor_album_virtual = mysqli_fetch_array($sql_album_virtual);
																							?>

                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Arquivo</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="arquivos/album_virtual/<?php echo $vetor_album_virtual['arquivo']; ?>"
                                                               target="_blank">
                                                                <button type="button" class="btn btn-default">
                                                                    Abrir Album Virtual
                                                                </button>
                                                            </a></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
																						
																						<?php } ?>

                                          </div>

                                      </div>

                                  </div>

                                  <div class="tab-pane" id="convite" role="tabpanel">

                                      <br>
                                      <br>

                                      <ul class="nav nav-tabs" role="tablist">

                                          <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                  href="#documentosconvite" role="tab"><span
                                                          class="hidden-sm-up"><i class="ti-email"></i></span>
                                                  <span
                                                          class="hidden-xs-down">Documentos</span></a></li>
                                          <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                  href="#produtosconvite" role="tab"><span
                                                          class="hidden-sm-up"><i class="ti-email"></i></span>
                                                  <span
                                                          class="hidden-xs-down">Produtos</span></a></li>
                                          <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                  href="#convitevirtualconvite" role="tab"><span
                                                          class="hidden-sm-up"><i class="ti-email"></i></span>
                                                  <span
                                                          class="hidden-xs-down">Convite Virtual</span></a></li>
                                          <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                  href="#fotosdeconvite" role="tab"><span
                                                          class="hidden-sm-up"><i class="ti-email"></i></span>
                                                  <span
                                                          class="hidden-xs-down">Fotos de Convite</span></a>
                                          </li>

                                      </ul>

                                      <div class="tab-content tabcontent-border">

                                          <div class="tab-pane active" id="documentosconvite" role="tabpanel">

                                              <br>
                                              <br>

                                              <a href="cadastroarquivo.php?id=<?php echo $id; ?>">
                                                  <button type="button" class="btn btn-primary"
                                                          style="    float: left;">Cadastrar Arquivo
                                                  </button>
                                              </a>

                                              <a href="arruma_contratos.php?id=<?php echo $id; ?>">
                                                  <button type="button" class="btn btn-danger"
                                                          style="float:right;">Arrumar Contrato
                                                  </button>
                                              </a>

                                              <br>
                                              <br>
                                              <br>

                                              <table id="lang_opt9" class="table table-bordered table-striped">
                                                  <thead>
                                                  <tr>
                                                      <th>Titulo</th>
                                                      <th>Data</th>
                                                      <th>Hora</th>
                                                      <th>Arquivo</th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
																									<?php
																									$sql_arquivos = mysqli_query($con, "select * from arquivos where id_cliente = '{$id}' and tipo = '2' order by id_arquivo DESC");
																									while ($vetor_arquivo = mysqli_fetch_array($sql_arquivos)) {
																										$sql_formando = mysqli_query($con, "select * from formando where id_formando = '{$vetor_arquivo['id_cliente']}'");
																										$vetor_formando = mysqli_fetch_array($sql_formando);
																										?>
                                                      <tr>
                                                          <td><?php echo $vetor_arquivo['titulo']; ?></td>
                                                          <td><?php echo date('d/m/Y', strtotime($vetor_arquivo['data'])); ?></td>
                                                          <td><?php echo $vetor_arquivo['hora']; ?></td>
                                                          <td>
                                                              <a href="arquivos/<?php echo $vetor_arquivo['arquivo']; ?>"
                                                                 target="_blank">
                                                                  <button type="button" class="btn btn-default">
                                                                      Arquivo
                                                                  </button>
                                                              </a> <?php if ($vetor_permissao['exclusao'] == 1) {
																														}else { ?><a
                                                                  href="excluirarquivo.php?id=<?php echo $vetor_arquivo['id_arquivo']; ?>&id1=<?php echo $id; ?>"
                                                                  target="_blank">
                                                                      <button type="button"
                                                                              class="btn btn-danger">
                                                                          Excluir
                                                                      </button></a><?php } ?></td>
                                                      </tr>
																									<?php } ?>
                                                  </tbody>
                                                  <tfoot>
                                                  <tr>
                                                      <th>Titulo</th>
                                                      <th>Data</th>
                                                      <th>Hora</th>
                                                      <th>Arquivo</th>
                                                  </tr>
                                                  </tfoot>
                                              </table>

                                          </div>

                                          <div class="tab-pane" id="produtosconvite" role="tabpanel">

                                              <br>
                                              <br>

                                              <table id="lang_opt10" class="table table-bordered table-striped">
                                                  <thead>
                                                  <tr>
                                                      <th>Produtos</th>
                                                      <th>Qtd</th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
																									<?php
																									$sql_produtos_contrato_conv = mysqli_query($con, "select * from vendas where id_formando = '{$id}' and tipo = '1'");
																									$vetor_produtos_contrato_conv = mysqli_fetch_array($sql_produtos_contrato_conv);
																									$sql_itens_venda_conv = mysqli_query($con, "select * from itens_venda_individual where id_venda = '{$vetor_produtos_contrato_conv['id_venda']}'");
																									while ($vetor_produto_final = mysqli_fetch_array($sql_itens_venda_conv)) {
																										if ($vetor_produto_final['tipo'] == 1) {
																											$sql_produto = mysqli_query($con, "select * from produtos_turma_item where id_item = '{$vetor_produto_final['id_item']}'");
																											$vetor_produto = mysqli_fetch_array($sql_produto);
																										}
																										if ($vetor_produto_final['tipo'] == 2) {
																											$sql_produto = mysqli_query($con, "select * from pacotes_itens where id_item = '{$vetor_produto_final['id_item']}'");
																											$vetor_produto = mysqli_fetch_array($sql_produto);
																										}
																										$sql_produto_nome = mysqli_query($con, "select * from tipos_produtos where id_tipo = '{$vetor_produto['id_tipo']}'");
																										$vetor_produto_nome = mysqli_fetch_array($sql_produto_nome);
																										?>
                                                      <tr>
                                                          <td><?php echo $vetor_produto_nome['nome']; ?></td>
                                                          <td><?php echo $vetor_produto_final['qtd']; ?></td>
                                                      </tr>
																									<?php } ?>
                                                  </tbody>
                                                  <tfoot>
                                                  <tr>
                                                      <th>Produtos</th>
                                                  </tr>
                                                  </tfoot>
                                              </table>

                                          </div>

                                          <div class="tab-pane" id="convitevirtualconvite" role="tabpanel">

                                              <br>
                                              <br>

                                          </div>

                                          <div class="tab-pane" id="fotosdeconvite" role="tabpanel">

                                              <br>
                                              <br>

                                              <a href="cadastrofotoarquivo_formando.php?id=<?php echo $id; ?>">
                                                  <button type="button" class="btn btn-primary"
                                                          style="    float: left;">Cadastrar Arquivos
                                                  </button>
                                              </a>

                                              <br>
                                              <br>
                                              <br>

                                              <table id="lang_opt11" class="table table-bordered table-striped">
                                                  <thead>
                                                  <tr>
                                                      <th>Tipo Arquivo</th>
                                                      <th>Qtd Caracteres</th>
                                                      <th>Ação</th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
																									<?php
																									$sql_tipoarquivo = mysqli_query($con, "select * from tipos_arquivos_formando where id_formando = '{$id}'");
																									while ($vetor_tipoarquivo = mysqli_fetch_array($sql_tipoarquivo)) {
																										$sql_tipo_nome = mysqli_query($con, "select * from tipos_arquivos where id_tipo = '{$vetor_tipoarquivo['id_tipo']}'");
																										$vetor_tipo_nome = mysqli_fetch_array($sql_tipo_nome);
																										$sql_tipo_qtd = mysqli_query($con, "select * from tipos_arquivos_turma where id_tipo = '{$vetor_tipoarquivo['id_tipo']}' and id_turma = '{$vetor['turma']}'");
																										$vetor_tipo_qtd = mysqli_fetch_array($sql_tipo_qtd);
																										?>
                                                      <tr>
                                                          <td><?php echo $vetor_tipo_nome['nome']; ?></td>
                                                          <td><?php echo $vetor_tipo_qtd['qtd']; ?></td>
                                                          <td><?php if ($vetor_permissao['exclusao'] == 1) {
																														}else { ?><a
                                                                  href="confexcluirtipoarquivo_formando.php?id=<?php echo $vetor['id_tipo_formando']; ?>&id1=<?php echo $id; ?>">
                                                                      <button type="button"
                                                                              class="btn btn-danger mesmo-tamanho"
                                                                              title="Excluir Cadastro"><i
                                                                                  class="mdi mdi-window-close"></i>
                                                                      </button>
                                                                  </a><?php } ?></td>
                                                      </tr>
																									<?php } ?>
                                                  </tbody>
                                                  <tfoot>
                                                  <tr>
                                                      <th>Tipo Arquivo</th>
                                                      <th>Qtd Caracteres</th>
                                                      <th>Ação</th>
                                                  </tr>
                                                  </tfoot>
                                              </table>

                                          </div>

                                      </div>

                                  </div>

                              </div>

                          </div>
                      </div>
                  </div>
              </div>

          </div>

          <div class="modal fade" id="modal-default">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Anexos</h4>
                      </div>
                      <div class="modal-body">
                          <p>Carregando...</p>
                      </div>
                  </div>
                  <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
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
      <script type="text/javascript">
          function inMemorianPai(valor) {
              if (valor == "1") {
                  $('#paiOptions').hide();
                  $("#paiOptions :input").attr('required', false);
              }
              if (valor == "0") {
                  $('#paiOptions').show()
                  $("#paiOptions :input").attr('required', true);

              }
          }

          function inMemorianMae(valor) {
              if (valor == "1") {
                  $('#maeOptions').hide()
                  $("#maeOptions :input").attr('required', false);
              }
              if (valor == "0") {
                  $('#maeOptions').show()
                  $("#maeOptions :input").attr('required', true);

              }
          }

          function showLoading() {
              document.getElementById("loading").style = "visibility: visible";
          }

          function hideLoading() {
              document.getElementById("loading").style = "visibility: hidden";
          }

          var addFileButton = document.getElementById('addFileButton');
          addFileButton.addEventListener('click', function () {
              var input = document.getElementById('arquivo');
              var file = input.files[0];
              var fd = new FormData();
              fd.append('arquivo', file);

              var xhr = new XMLHttpRequest();

              xhr.upload.addEventListener('loadstart', function (e) {
                  showLoading();
              });
              xhr.onreadystatechange = function (e) {
                  if (xhr.readyState == 4) {
                      hideLoading();
                  }
              };
              xhr.open('POST', 'controllers/addFile.php?id=<?php echo $id; ?>', true);
              xhr.send(fd);

              $('#filelink').attr('href', "arquivos/album_virtual/<?php echo md5($id.'albumvirtual');?>.pdf");
              $('#filedownload').removeAttr('hidden');
              $('#addfile').attr('hidden', 'hidden');
          })


          $(document).ready(function () {
              var activeTab = location.hash;
              if (activeTab != "") {
                  var splitted = activeTab.split('#');
                  $('.nav-link[href="#' + splitted[1] + '"]').click();
                  $('.nav-link[href="#' + splitted[2] + '"]').click();
              }
              
              inMemorianPai($("#inmemorianpai").val());
              inMemorianMae($("#inmemorianmae").val());
          });

      </script>
      </body>

      </html>
	<?php }
} ?>
