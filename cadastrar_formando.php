<?php

include "includes/conexao.php";
$ncontrato = $_POST['ncontrato'];
$sql_turma = mysqli_query($con, "select * from turmas where ncontrato = '$ncontrato'");
$vetor = mysqli_fetch_array($sql_turma);
$vetor['id_turma'];
if (mysqli_num_rows($sql_turma) == 0) {
    echo "<script> alert('Turma nao encontrada, favor digitar novamente o numero da turma!')</script>";
    echo "<script> window.location.href='efetuarcadastro.html'</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>StudioM Fotografia</title>
</head>
<link href="layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
<link href="layout/dist/css/style.min.css" rel="stylesheet">
<link rel="icon" type="image/png" sizes="32x32" href="imgs/logo1.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="cropper.min.css">

<script type="text/javascript" src="aplicacoes/aplicjava.js"></script>
<style>

    body {
        background-image: url("imgs/fundo.png");
        font-family: "Nunito Sans",sans-serif !important;
        font-size: .875rem;
        font-weight: 400;
        line-height: 1.5;
        text-align: left;
    }

    .btn-primary {
    background-color: #7460ee !important;
    border-color: #7460ee !important;
}
    #box {
        width: 240px;
        height: 100%;
        border-radius: 10px;
        margin: auto;
        padding: 10px;
        margin-bottom: 20px;
    }

    #logo {
        width: 80%;
        height: auto;
    }

    .tooltip-inner {
    background-color: #4a148c !important;
    box-shadow: 0px 0px 4px black !important;
    padding: 10px !important;
}

    .tooltip-arrow {
        border-right-color: #4a148c !important;
    }

    .tooltip{position:absolute;z-index:1070;display:block;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:12px;font-style:normal;font-weight:400;line-height:1.42857143;text-align:left;text-align:start;text-decoration:none;text-shadow:none;text-transform:none;letter-spacing:normal;word-break:normal;word-spacing:normal;word-wrap:normal;white-space:normal;filter:alpha(opacity=0);opacity:0;line-break:auto}.tooltip.in{filter:alpha(opacity=90);opacity:.9}.tooltip.top{padding:5px 0;margin-top:-3px}.tooltip.right{padding:0 5px;margin-left:3px}.tooltip.bottom{padding:5px 0;margin-top:3px}.tooltip.left{padding:0 5px;margin-left:-3px}.tooltip-inner{max-width:200px;padding:3px 8px;color:#fff;text-align:center;background-color:#000;border-radius:4px}.tooltip-arrow{position:absolute;width:0;height:0;border-color:transparent;border-style:solid}.tooltip.top .tooltip-arrow{bottom:0;left:50%;margin-left:-5px;border-width:5px 5px 0;border-top-color:#000}.tooltip.top-left .tooltip-arrow{right:5px;bottom:0;margin-bottom:-5px;border-width:5px 5px 0;border-top-color:#000}.tooltip.top-right .tooltip-arrow{bottom:0;left:5px;margin-bottom:-5px;border-width:5px 5px 0;border-top-color:#000}.tooltip.right .tooltip-arrow{top:50%;left:0;margin-top:-5px;border-width:5px 5px 5px 0;border-right-color:#000}.tooltip.left .tooltip-arrow{top:50%;right:0;margin-top:-5px;border-width:5px 0 5px 5px;border-left-color:#000}.tooltip.bottom .tooltip-arrow{top:0;left:50%;margin-left:-5px;border-width:0 5px 5px;border-bottom-color:#000}.tooltip.bottom-left .tooltip-arrow{top:0;right:5px;margin-top:-5px;border-width:0 5px 5px;border-bottom-color:#000}.tooltip.bottom-right .tooltip-arrow{top:0;left:5px;margin-top:-5px;border-width:0 5px 5px;border-bottom-color:#000}


</style>
<script type="text/javascript" src="aplicacoes/aplicjava.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#telefone").mask("(00) 00000-0000");
        $("#telefone2").mask("(00) 0000-0000");
        $("#celularpai").mask("(00) 00000-0000");
        $("#telefone5").mask("(00) 0000-0000");
        $("#telefone4").mask("(00) 00000-0000");
        $("#telefone6").mask("(00) 0000-0000");
        $("#telefone7").mask("(00) 00000-0000");
        $("#cpf").mask("000.000.000-00");
        $("#cpfC").mask("000.000.000-00");
        $("#cep").mask("00000-000");
        $("#palco1 > div").hide();
        $("#tipobusca").change(function () {
            $("#palco1 > div").hide();
            $('#' + $(this).val()).show('fast');
        });
        $("#palco2 > div").hide();
        $("#tiporesponsavel").change(function () {
            $("#palco2 > div").hide();
            $('#' + $(this).val()).show('fast');
        });
        $("input[name='rd-sexo']").click(function () {
            $("#palco > div").hide();
            $('#' + $(this).val()).show('fast');
        });
    });
</script>
<script type="text/javascript">

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

    $(document).ready(function () {

        function limpa_formulário_cep1() {
// Limpa valores do formulário de cep.
            $("#rua1").val("");
            $("#bairro1").val("");
            $("#cidade1").val("");
            $("#uf1").val("");
            $("#ibge1").val("");
        }

//Quando o campo cep perde o foco.
        $("#cep1").blur(function () {

//Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

//Verifica se campo cep possui valor informado.
            if (cep != "") {

//Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

//Valida o formato do CEP.
                if (validacep.test(cep)) {

//Preenche os campos com "..." enquanto consulta webservice.
                    $("#rua1").val("...")
                    $("#bairro1").val("...")
                    $("#cidade1").val("...")
                    $("#uf1").val("...")
                    $("#ibge1").val("...")

//Consulta o webservice viacep.com.br/
                    $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {
//Atualiza os campos com os valores da consulta.
                            $("#rua1").val(dados.logradouro);
                            $("#bairro1").val(dados.bairro);
                            $("#cidade1").val(dados.localidade);
                            $("#uf1").val(dados.uf);
                            $("#ibge1").val(dados.ibge);
                        } //end if.
                        else {
//CEP pesquisado não foi encontrado.
                            limpa_formulário_cep1();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
//cep é inválido.
                    limpa_formulário_cep1();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
//cep sem valor, limpa formulário.
                limpa_formulário_cep1();
            }
        });
    });

    $(document).ready(function () {

        function limpa_formulário_cep2() {
// Limpa valores do formulário de cep.
            $("#rua2").val("");
            $("#bairro2").val("");
            $("#cidade2").val("");
            $("#uf2").val("");
            $("#ibge2").val("");
        }

//Quando o campo cep perde o foco.
        $("#cep2").blur(function () {

//Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

//Verifica se campo cep possui valor informado.
            if (cep != "") {

//Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

//Valida o formato do CEP.
                if (validacep.test(cep)) {

//Preenche os campos com "..." enquanto consulta webservice.
                    $("#rua2").val("...")
                    $("#bairro2").val("...")
                    $("#cidade2").val("...")
                    $("#uf2").val("...")
                    $("#ibge2").val("...")

//Consulta o webservice viacep.com.br/
                    $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {
//Atualiza os campos com os valores da consulta.
                            $("#rua2").val(dados.logradouro);
                            $("#bairro2").val(dados.bairro);
                            $("#cidade2").val(dados.localidade);
                            $("#uf2").val(dados.uf);
                            $("#ibge2").val(dados.ibge);
                        } //end if.
                        else {
//CEP pesquisado não foi encontrado.
                            limpa_formulário_cep2();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
//cep é inválido.
                    limpa_formulário_cep2();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
//cep sem valor, limpa formulário.
                limpa_formulário_cep2();
            }
        });
    });

</script>
<script type="text/javascript">

    function validaEmail(input) {
        if (input.value != document.getElementById('txtEmail').value) {
            input.setCustomValidity('Repita e-mail corretamente');
        } else {
            input.setCustomValidity('');
        }
    }

    function validaCPF(input) {
        cpf = cpf.replace(/[^\d]+/g,'');	
	if(cpf == '') return false;	
	// Elimina CPFs invalidos conhecidos	
	if (cpf.length != 11 || 
		cpf == "00000000000" || 
		cpf == "11111111111" || 
		cpf == "22222222222" || 
		cpf == "33333333333" || 
		cpf == "44444444444" || 
		cpf == "55555555555" || 
		cpf == "66666666666" || 
		cpf == "77777777777" || 
		cpf == "88888888888" || 
		cpf == "99999999999")
			return false;		
	// Valida 1o digito	
	add = 0;	
	for (i=0; i < 9; i ++)		
		add += parseInt(cpf.charAt(i)) * (10 - i);	
		rev = 11 - (add % 11);	
		if (rev == 10 || rev == 11)		
			rev = 0;	
		if (rev != parseInt(cpf.charAt(9)))		
			return false;		
	// Valida 2o digito	
	add = 0;	
	for (i = 0; i < 10; i ++)		
		add += parseInt(cpf.charAt(i)) * (11 - i);	
	rev = 11 - (add % 11);	
	if (rev == 10 || rev == 11)	
		rev = 0;	
	if (rev != parseInt(cpf.charAt(10)))
		return false;		
	return true;   
  
    }

    var input = document.getElementById("emailpai");
    if (lista.value == "1_2") {
        input.disabled = true;
        input.required = false;
    } else {
        input.disabled = false;
        input.required = true;
    }

    function ativarInputDataContrato() {
        var lista = document.getElementById("tipobusca");

        var input = document.getElementById("cargo");
        if (lista.value == "2_1") {
            input.disabled = false;
            input.required = true;
        } else {
            input.disabled = true;
            input.required = false;
        }
    }

    function ativarInputOutrosContrato() {
        var lista = document.getElementById("tiporesponsavel");

        var input = document.getElementById("outrosresp");
        if (lista.value == "Outros") {
            input.disabled = false;
            input.required = true;
        } else {
            input.disabled = true;
            input.required = false;
        }
    }

    function verifica(value) {
        var input = document.getElementById("input");

        if (value == 1_2) {
            input.disabled = false;
            input.required = true;
        } else if (value == 2_2) {
            input.disabled = true;
            input.required = false;
        }
    }

</script>
<body>
<br>
<br>
<br>
<br>
<div class="container">

    <table width="100%">
        <tr>
            <td width="15%"><img id="logo" src="imgs/Studio%20M%20-%20Logo-01.png"></td>
            <td>Cadastro de formando<br>
                Preencha os dados a seguir
            </td>
        </tr>
    </table>

    <br>
    <br>
    <br>

    <form action="recebe_formando_site.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="turma" value="<?php echo $vetor['id_turma']; ?>">

        <table width="100%">
            <tr>
                <td width="30%"><strong>Nome / Nome Composto</strong></td>
                <td width="2%"></td>
                <td width="30%"><strong>Sobrenome Completo</strong></td>
                <td width="2%"></td>
                <td width="20%"><strong>Sexo</strong></td>
                <td width="2%"></td>
                <td width="20%"><strong>Est. Civil</strong></td>
                <td width="2%"></td>
               
            </tr>
            <tr>
                <td width="15%"><input type="text" name="nome" class="form-control" placeholder="Digite o seu primeiro nome"
                oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" data-toggle="tooltip" title="Se atente a grafia correta do nome, pois ele poderá ser utilizado tanto no seu álbum de fotografia, quanto no seu convite de formatura e/ou outros produtos contratados." required></td>
                <td width="2%"></td>
                <td width="15%"><input type="text" name="sobrenome" class="form-control" placeholder="Digite o seu sobrenome"
                oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" data-toggle="tooltip" title="Se atente a grafia correta do nome, pois ele poderá ser utilizado tanto no seu álbum de fotografia, quanto no seu convite de formatura e/ou outros produtos contratados." required></td>
                <td width="2%"></td>
                <td width="10%"><select name="sexo" class="form-control" required="">
                        <option value="" selected="">Selecione...</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                    </select>
                </td>
                <td width="2%"></td>
                <td width="10%"><select name="estadocivil" class="form-control" required="">
                        <option value="" selected="">Selecione...</option>
                        <option value="Casado(a)">Casado(a)</option>
                        <option value="Solteiro(a)">Solteiro(a)</option>
                        <option value="Divorciado(a)">Divorciado(a)</option>
                        <option value="Viúvo(a)">Viúvo(a)</option>
                        <option value="Amasiado(a)">Amasiado(a)</option>
                    </select></td>
                <td width="2%"></td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
            <td width="8%"><strong>Data Nascimento</strong></td>
                <td width="2%"></td>
                <td width="10%"><strong>RG</strong></td>
                <td width="2%"></td>
                <td width="12%"><strong>CPF</strong></td>
                <td width="2%"></td>
                <td width="12%"><strong>Confirmar CPF</strong></td>
            </tr>
            <tr>
            <td width="10%"><input type="date" name="datanasc" class="form-control" id="datanasc" required></td>
                <td width="2%"></td>
                <td width="10%"><input type="text" name="rg" class="form-control" placeholder="RG" id="rg"
                                       required=""></td>
                <td width="2%"></td>
                <td width="12%"><input type="text" name="cpf" class="form-control" id="cpf" placeholder="CPF"
                                       required=""> </td>
                <td width="2%"></td>
                <td width="12%"><input type="text" name="confirmarcpf" class="form-control" id="cpfC"
                                       placeholder="Confirmar CPF" onkeydown="BloqueiaComando(event)"
                                       oninput="validaCPF(this)" onpaste="return OnPaste();" required></td>
            </tr>
        </table>    
        <br>
        <table width="100%">
            <tr>
                <td width="10%"><strong>CEP</strong></td>
                <td width="2%"></td>
                <td width="20%"><strong>Bairro</strong></td>
                <td width="2%"></td>
                <td width="21%"><strong>Endereço</strong></td>
                <td width="2%"></td>
                <td width="8%"><strong>Complemento</strong></td>
                <td width="2%"></td>
                <td width="7%"><strong>Número</strong></td>
                <td width="2%"></td>
                <td width="15%"><strong>Cidade</strong></td>
                <td width="2%"></td>
                <td width="7%"><strong>UF</strong></td>
            </tr>
            <tr>
                <td width="10%"><input type="text" name="cep" id="cep" class="form-control" placeholder="CEP" required>
                </td>
                <td width="2%"></td>
                <td width="20%"><input type="text" name="bairro" id="bairro" class="form-control" placeholder="Bairro"
                                       required></td>
                <td width="2%"></td>
                <td width="21%"><input type="text" name="endereco" id="rua" class="form-control" placeholder="Endereço"
                                       required></td>
                <td width="2%"></td>
                <td width="8%"><input type="text" name="complemento" class="form-control" placeholder="Complemento">
                </td>
                <td width="2%"></td>
                <td width="7%"><input type="number" name="numero" class="form-control" id="exampleInput"
                                      placeholder="Numero"></td>
                <td width="2%"></td>
                <td width="15%"><input type="text" name="cidade" id="cidade" class="form-control" placeholder="Cidade"
                                       required></td>
                <td width="2%"></td>
                <td width="7%"><input type="text" name="estado" id="uf" class="form-control" placeholder="Estado"
                                      required></td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td width="20%"><strong>Celular com DDD</strong></td>
                <td width="2%"></td>
                <td width="20%"><strong>Telefone residêncial com DDD</strong></td>
                <td width="2%"></td>
                <td width="27%"><strong>E-mail</strong></td>
                <td width="2%"></td>
                <td width="27%"><strong>Confirmar E-mail</strong></td>
            </tr>
            <tr>
                <td width="20%"><input type="text" name="telefone" id="telefone" class="form-control"
                                       placeholder="Celular" required></td>
                <td width="2%"></td>
                <td width="20%"><input type="text" name="celular" id="telefone2" class="form-control"
                                       placeholder="Telefone"></td>
                <td width="2%"></td>
                <td width="27%"><input type="email" name="email" id="txtEmail" class="form-control"
                                       placeholder="exemplo@exemplo.com.br" required></td>
                <td width="2%"></td>
                <td width="27%"><input type="email" name="email1" id="repetir_email" onkeydown="BloqueiaComando(event)"
                                       oninput="validaEmail(this)" onpaste="return OnPaste ();" class="form-control"
                                       placeholder="exemplo@exemplo.com.br" required></td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td><strong>Você gostaria que o nome dos seu pais fizessem parte do seu convite de formatura?</strong>
                </td>
            </tr>
            <tr>
                <td>
                    <select name="mostrarpai" class="form-control" onchange="ativarInputpais(this.value)"
                            id="tipobusca1">
                        <option value="" selected="">Selecione</option>
                        <option value="true">Sim</option>
                        <option value="false">Não</option>
                    </select>
                </td>
            </tr>
        </table>
        <br>

        <div id="palco">
            <div id="1" style="display: none;">

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
                            <input type="text" name="pai" id="pai" class="form-control nomepais" placeholder="Pai" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>In Memoriam (Pai Falecido)</label>
                            <select id="inmemoria" name="inmemorianpai" onchange="inMemoPai(this.value)"
                                    class="select-inmemorian form-control">
                                <option value="0">Não</option>
                                <option value="1">Sim</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="target" id="paiOps">

                    <table width="100%">
                        <tr>
                            <td width="32%"><strong>Celular com DDD:</strong></td>
                            <td width="2%"></td>
                            <td width="32%"><strong>Telefone residêncial com DDD:</strong></td>
                            <td width="2%"></td>
                            <td width="32%"><strong>E-mail:</strong></td>
                        </tr>
                        <tr>
                            <td width="32%"><input type="text" name="celularpai" id="celularpai" required="true"
                                                   class="form-control" placeholder="Celular"></td>
                            <td width="2%"></td>
                            <td width="32%"><input type="text" name="telresidencial" id="telefone5" class="form-control"
                                                   placeholder="Telefone" required="true"></td>
                            <td width="2%"></td>
                            <td width="32%"><input type="email" name="emailpai" class="form-control" id="emailpai"
                                                   required="true" placeholder="exemplo@exemplo.com.br"></td>
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
                            <td width="10%"><input type="text" name="cep1" id="cep1" class="form-control"
                                                   placeholder="CEP" required="true"></td>
                            <td width="2%"></td>
                            <td width="20%"><input type="text" name="bairro1" id="bairro1" class="form-control"
                                                   placeholder="Bairro" required="true"></td>
                            <td width="2%"></td>
                            <td width="21%"><input type="text" name="endereco1" id="rua1" class="form-control"
                                                   placeholder="Endereço" required="true"></td>
                            <td width="2%"></td>
                            <td width="8%"><input type="text" name="complemento1" class="form-control"
                                                  placeholder="Complemento" required="true"></td>
                            <td width="2%"></td>
                            <td width="7%"><input type="number" name="numero1" class="form-control" id="exampleInput"
                                                  placeholder="Numero" required="true"></td>
                            <td width="2%"></td>
                            <td width="15%"><input type="text" name="cidade1" id="cidade1" class="form-control"
                                                   placeholder="Cidade" required="true"></td>
                            <td width="2%"></td>
                            <td width="7%"><input type="text" name="estado1" id="uf1" class="form-control"
                                                  placeholder="Estado" required="true"></td>
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
                            <input type="text" name="mae" id="mae" class="form-control nomepais" placeholder="Mãe" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>In Memoriam (Mãe Falecida)</label>
                            <select id="inmemoria1" name="inmemorianmae" class="select-inmemorianmae form-control"
                                    onchange="inMemoMae(this.value)">
                                <option value="0">Não</option>
                                <option value="1">Sim</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="target1" id="maeOps">

                    <table width="100%">
                        <tr>
                            <td width="32%"><strong>Celular com DDD:</strong></td>
                            <td width="2%"></td>
                            <td width="32%"><strong>Telefone residêncial com DDD:</strong></td>
                            <td width="2%"></td>
                            <td width="32%"><strong>E-mail:</strong></td>
                        </tr>
                        <tr>
                            <td width="32%"><input type="text" name="celularmae" id="telefone4" class="form-control"
                                                   placeholder="Celular" required="true"></td>
                            <td width="2%"></td>
                            <td width="32%"><input type="text" name="telresidencial1" id="telefone6"
                                                   class="form-control" placeholder="Telefone" required="true"></td>
                            <td width="2%"></td>
                            <td width="32%"><input type="email" name="emailmae" class="form-control"
                                                   placeholder="exemplo@exemplo.com.br" required="true"></td>
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
                            <td width="10%"><input type="text" name="cep2" id="cep2" class="form-control"
                                                   placeholder="CEP" required="true"></td>
                            <td width="2%"></td>
                            <td width="20%"><input type="text" name="bairro2" id="bairro2" class="form-control"
                                                   placeholder="Bairro" required="true"></td>
                            <td width="2%"></td>
                            <td width="21%"><input type="text" name="endereco2" id="rua2" class="form-control"
                                                   placeholder="Endereço" required="true"></td>
                            <td width="2%"></td>
                            <td width="8%"><input type="text" name="complemento2" class="form-control"
                                                  placeholder="Complemento" required="true"></td>
                            <td width="2%"></td>
                            <td width="7%"><input type="number" name="numero2" class="form-control" id="exampleInput"
                                                  placeholder="Numero" required="true"></td>
                            <td width="2%"></td>
                            <td width="15%"><input type="text" name="cidade2" id="cidade2" class="form-control"
                                                   placeholder="Cidade" required="true"></td>
                            <td width="2%"></td>
                            <td width="7%"><input type="text" name="estado2" id="uf2" class="form-control"
                                                  placeholder="Estado" required="true"></td>
                        </tr>
                    </table>

                </div>

                <br>
                <br>
            </div>
        </div>

        <strong>
            <div align="justify">Se o Studio M precisar falar contigo e não conseguir por algum motivo, você pode nos
                deixar o contato de algum responsável?
            </div>
        </strong>

        <br>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nomeresponsavel" class="form-control" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" name="telefoneresponsavel" id="telefone7" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label>Tipo Responsável</label>
                    <select name="tiporesponsavel" id="tiporesponsavel" onchange="ativarInputOutrosContrato()"
                            class="form-control" required>
                        <option value="">Selecione...</option>
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
                        <option value="Outros">Outros</option>r
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">

                    <div id="palco2">
                        <div id="Outros">


                            <label>Tipo Responsável</label>
                            <input type="text" name="outroresponsavel" id="outrosresp" disabled required="true"
                                   class="form-control">

                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label><strong>Comissão de Formatura</strong></label>
                    <select name="comissao" id="tipobusca" class="form-control" onchange="ativarInputDataContrato()"
                            required>
                        <option value="" selected="selected">Selecione a Opção</option>
                        <option value="1_1">Não</option>
                        <option value="2_1">Sim</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="palco1">

            <div id="2_1">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><strong>Cargo</strong></label>

                            <select name="cargo" id="cargo" class="form-control" disabled required="true">
                                <option value="">Selecione...</option>
                                <option value="Presidente">Presidente</option>
                                <option value="Vice-Presidente">Vice-Presidente</option>
                                <option value="Tesoureiro (a)">Tesoureiro (a)</option>
                                <option value="Secretário (a)">Secretário (a)</option>
                                <option value="Coordenador de Eventos">Coordenador de Eventos</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <strong>
            <div align="justify">Este pode ser um meio pelo qual suas fotografias poderão ser enviadas futuramente,
                portanto, é muito importante que nos deixe o endereço da sua rede social.
            </div>
        </strong>

        <br>

        <table width="100%">
            <tr>
                <td width="100%"><strong>Instagram:</strong></td>
            </tr>
            <tr>
                <td width="100%"><input type="text" name="instagram" class="form-control"
                                        placeholder="Digite seu Instagram"></td>
            </tr>
            <tr>
                <td width="100%" class="pt-2"><strong>Facebook:</strong></td>
            </tr>
            <tr>
                <td width="100%"><input type="text" name="facebook" class="form-control"
                                        placeholder="Cole o link de seu facebook"></td>
            </tr>
        </table>

        <br>
        <br>

        <div id="box" style="width: 100% !important;" align="center">

<br>
<br>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Escolher Foto de Perfil</h4>

                <div class="row">
                    <div class="col-md-6 offset-md-3" style="min-height: 500px !important;">
                        <div class="img-container">

                            <div id="divCorpo"></div>

                              <img id="image" 
                                   alt="">

                        </div>
                    </div>
                </div>

                <div class="row" id="actions">
                    <div class="col-md-8 offset-md-2 text-center docs-buttons">
                        <br>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-md" data-method="setDragMode"
                                    data-option="move" title="Move">
                                <span class="docs-tooltip" data-toggle="tooltip"
                                      title="cropper.setDragMode(&quot;move&quot;)">
                                  <span class="fa fa-arrows-alt"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary btn-md" data-method="setDragMode"
                                    data-option="crop" title="Crop">
                                <span class="docs-tooltip" data-toggle="tooltip"
                                      title="cropper.setDragMode(&quot;crop&quot;)">
                                  <span class="fa fa-crop-alt"></span>
                                </span>
                            </button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-md" data-method="zoom"
                                    data-option="0.1" title="Zoom In">
                                <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
                                  <span class="fa fa-search-plus"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary btn-md" data-method="zoom"
                                    data-option="-0.1" title="Zoom Out">
                                <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
                                  <span class="fa fa-search-minus"></span>
                                </span>
                            </button>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-md" data-method="rotate"
                                    data-option="-45" title="Rotate Left">
                                <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
                                  <span class="fa fa-undo-alt"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary btn-md" data-method="rotate"
                                    data-option="45" title="Rotate Right">
                                <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
                                  <span class="fa fa-redo-alt"></span>
                                </span>
                            </button>
                        </div>
                        <div class="btn-group">
                            <label class="btn btn-primary btn-upload"
                                   for="inputImage" title="Upload image file">
                                <input type="file" class="sr-only" id="inputImage" name="file"
                                       accept="image/*">
                                <span class="docs-tooltip" data-toggle="tooltip">
                                <span class="fa fa-upload"></span> Escolher Foto
                              </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

        <table width="100%">
            <tr>
                <td width="100%">
                    <button type="submit" id="submit_form" class="btn btn-primary btn-block btn-flat">Finalizar Cadastro</button>
                </td>
            </tr>
        </table>

    </form>

    <br>
    <br>
    <br>
    <br>

</div>

 
<script src="layout/dist/js/app.min.js"></script>
<script src="cropper.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">

    function alert (message) {
            const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 6000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

Toast.fire({
  icon: 'error',
  title: message
})
    }

    document.getElementById('submit_form').onclick = (e) => {

        document.querySelector('#cpf').style.borderColor = '#ced4da';
        document.querySelector('#telefone').style.borderColor = '#ced4da';
        document.querySelector('#telefone2').style.borderColor = '#ced4da';

        let cpf = document.getElementById('cpf').value.replace(/[^\d]+/g,'');	
            
	// Elimina CPFs invalidos conhecidos	
	if (cpf.length != 11 || 
		cpf == "00000000000" || 
		cpf == "11111111111" || 
		cpf == "22222222222" || 
		cpf == "33333333333" || 
		cpf == "44444444444" || 
		cpf == "55555555555" || 
		cpf == "66666666666" || 
		cpf == "77777777777" || 
		cpf == "88888888888" || 
		cpf == "99999999999"){
            

            e.preventDefault();
            alert('CPF inválido');
            document.getElementById('cpf').style.borderColor = "#dc3545"; 
            return
        }

        if(document.querySelector("#telefone").value.length != 15){
            e.preventDefault();
            alert('Formato de número de celular inválido, favor insira conforme o exemplo: (00) 00000-0000');
            document.getElementById('telefone').style.borderColor = "#dc3545"; 
            return
        }

        if(document.querySelector("#telefone2").value.length != 14){
            e.preventDefault();
            alert('Formato de número de telefone inválido, favor insira conforme o exemplo: (00) 0000-0000');
            document.getElementById('telefone2').style.borderColor = "#dc3545"; 
            return
        }

        if(!document.querySelector("#inputImage").value){
            e.preventDefault();
            alert('Favor inserir uma foto de perfil');
            
            return
        }
        	
	// Valida 1o digito	
	add = 0;	
	for (i=0; i < 9; i ++)		
		add += parseInt(cpf.charAt(i)) * (10 - i);	
		rev = 11 - (add % 11);	
		if (rev == 10 || rev == 11)		
			rev = 0;	
		if (rev != parseInt(cpf.charAt(9))){
            e.preventDefault();
            alert('CPF inválido');
            document.getElementById('cpf').style.borderColor = "#dc3545"; 
            return
        }		
	// Valida 2o digito	
	add = 0;	
	for (i = 0; i < 10; i ++)		
		add += parseInt(cpf.charAt(i)) * (11 - i);	
	rev = 11 - (add % 11);	
	if (rev == 10 || rev == 11)	
		rev = 0;	
	if (rev != parseInt(cpf.charAt(10))){
            e.preventDefault();
            alert('CPF inválido');
            document.getElementById('cpf').style.borderColor = "#dc3545"; 
            
            return
        }

    if(cpf != document.getElementById('cpfC').value.replace(/[^\d]+/g,'')){
        e.preventDefault();
        alert('CPF e Confimar CPF não conferem');
        document.getElementById('cpfC').style.borderColor = "#dc3545"; 

        return
    }

    document.getElementById('cpf').style.borderColor = "#ced4da"; 
    document.getElementById('cpfC').style.borderColor = "#ced4da"; 

    };
    

$('[data-toggle="tooltip"]').tooltip({
    placement: "right",
    trigger: "focus"
});

    function ativarInputpais(a) {
        if (a == "true") {
            $('div#1').css('display', 'block')
            $('div#1 :input').attr('required', true)
        } else {
            $('div#1').css('display', 'none')
            $('div#1 :input').attr('required', false)
        }
    }

    function inMemoPai(a) {
        if (a == "1") {
            $('#paiOps').hide()
            $("#paiOps :input").attr('required', false);
        }
        if (a == "0") {
            $('#paiOps').show()
            $("#paiOps :input").attr('required', true);

        }
    }

    function inMemoMae(a) {
        if (a == "1") {
            $('#maeOps').hide()
            $("#maeOps :input").attr('required', false);
        }
        if (a == "0") {
            $('#maeOps').show()
            $("#maeOps :input").attr('required', true);
        }
    }

    // $('.select-inmemorian').change(function(event){
    //    var inmemorian = event.currentTarget.value;

    //    if(inmemorian == 1_2) {

    //     $('.target').show(0,function() {
    //     });

    //    } else {

    //     $('.target').hide(0,function() {
    //     });

    //    }
    //  });

    // $('.select-inmemorianmae').change(function(event){
    //    var inmemorian1 = event.currentTarget.value;

    //    if(inmemorian1 == 1_3) {

    //     $('.target1').show(0,function() {
    //     });

    //    } else {

    //     $('.target1').hide(0,function() {
    //     });

    //    }
    //  });
</script>

<script src="cropperconfigcadastro.js"></script>
</body>
</html>
