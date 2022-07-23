<?php
session_start();
include "includes/conexao.php";
$id_formando = $_GET['id'];
$sql = mysqli_query($con, "select * from formandos where id_formando = '$id_formando'");
$vetor = mysqli_fetch_array($sql);
$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor[turma]'");
$vetor_turma = mysqli_fetch_array($sql_turma);
$sql_preeventos = mysqli_query($con, "select * from eventos_turma where id_turma = '$vetor[turma]' and id_categoria = '2'");
while ($vetor_preeventos = mysqli_fetch_array($sql_preeventos)) {
	$sql_consulta_eventos = mysqli_query($con, "select * from eventosformando where titulo = '$vetor_preeventos[nome]' and id_formando = '$vetor[id_formando]'");
	if (mysqli_num_rows($sql_consulta_eventos) == 0) {
		$nomedapastaeventos = $vetor_turma['ncontrato'].' '.$vetor['id_cadastro'].' '.$vetor['nome'].' '.$vetor_preeventos['nome'].date('d/m/Y');
		$pastaeventos = strtolower(preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomedapastaeventos)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
		mkdir("/home/studioms/public_html/sistema/arquivos/formandos/$pastaeventos", 0755);
		$sql_grava_pasta = mysqli_query($con, "insert into eventosformando (id_formando, id_evento_turma, tipo, titulo, pasta) VALUES ('$vetor[id_formando]', '$vetor_preeventos[id_evento]', '1', '$vetor_preeventos[nome]', '$pastaeventos')");
	}
}
/**if ($vetor['comissao'] != "") {
	if ($vetor_turma['contrato'] == 1) {
		echo "<script language=\"JavaScript\">
		location.href=\"areadacomissao\";
		</script>";
	}
}*/
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>StudioM Fotografia</title>
</head>
<link href="layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
<link href="layout/dist/css/style.min.css" rel="stylesheet">
<style>

    body {
        background-image: url("imgs/fundo.png");
    }

    #box {
        width: 500px;
        height: 100%;
        border-radius: 10px;
        margin: auto;
        padding: 10px;
        margin-bottom: 20px;
    }

</style>
<body>
<br>
<br>
<br>
<br>
<div class="container">
    <div id="box" align="center">

        <img src="imgs/LOGOS-LOGIN.png">

        <br>
        <br>
        <h4><strong>Cadastro realizado com sucesso!</strong></h4>
        <p><h4><strong><?php echo $vetor['nome']; ?></strong></h4></p>
        <strong>Seu número de identificação é:
            <br>
            <br>
            <font size="4px" style="background-color:#FF6600" color="#000000"><?php echo $vetor_turma['ncontrato']; ?>
                /<?php echo $vetor['id_cadastro']; ?></font>
            <br>
            <br>
            Enviamos para seu e-mail a confirmação de cadastro em nosso sistema. Caso não o localize na sua caixa de
            entrada, favor verificar na sua caixa de Spam.
            <br>
            <br>
            Para confirmar seu cadastro, acesse seu e-mail.</strong>

        <br>
        <br>

        <table width="100%">
            <tr>
                <td width="100%"><a href="arearestrita">
                        <button type="button" class="btn btn-primary btn-block btn-flat">Acessar Área do Formando
                        </button>
                </a></td>
            </tr>
            <?php if ($vetor['comissao'] == 2) {
                    ?>
            <tr>
                <td width="100%"><a href="areadacomissao">
                        <button type="button" class="btn btn-primary btn-block btn-flat">Acessar Área da Comissão
                        </button>
                </a></td>
            </tr>
            <?php }?>
        </table>


    </div>
</div>
</body>
</html>