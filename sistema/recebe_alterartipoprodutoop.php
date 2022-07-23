<?php

include "../includes/conexao.php";

if (isset($_GET['remover'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        mysqli_query($con, "select * from imagens_produtos where id_imagem = '$id'");
        $imagem = explode('/',$vet_imagem['imagem']);
        $unlink = $SERVER_ROOT . '/sistema/arquivos/imagens_produtos/' . $imagem[4];
        @unlink($unlink);
        mysqli_query($con, "delete from imagens_produtos where id_imagem = '$id'");
        die();
    } else {
        $id_especificacao = $_GET['id_spec'];
        mysqli_query($con, "delete from produtos_especificacoes where id_especificacao = '$id_especificacao'");
        die();
    }

} else {

    $id = $_GET['id'];
    $nome_produto = $_POST['nome_produto'];
    $aprovacao = $_POST['aprovacao'];
    $imagens = $_FILES;
    $posicao_existente = (isset($_POST['posicao_existente']) ? $_POST['posicao_existente'] : '');
    $informacoes = (isset($_POST['esquerda']) ? $_POST['esquerda'] : '');
    $diretorio = "../sistema/arquivos/imagens_produtos/";
    $sql_chave_produto = mysqli_query($con, "select chave_imagem from tipo_opcionais where id_tipo = '$id' and chave_imagem is not NULL");
    $chave_imagem = 0;
    if (mysqli_num_rows($sql_chave_produto) == 0) {
        $sql_maximo = mysqli_fetch_array(mysqli_query($con, "select MAX(chave_imagem) as chave_imagem from imagens_produtos"));
        $chave_imagem = (int)$sql_maximo['chave_imagem'] + 1;
        $sql = mysqli_query($con, "update tipo_opcionais SET chave_imagem='$chave_imagem',nome='$nome_produto', aprovacao='$aprovacao' where id_tipo = '$id'");
    } else {
        $sql = mysqli_query($con, "update tipo_opcionais SET nome='$nome_produto', aprovacao='$aprovacao' where id_tipo = '$id'");
        $chave_produto = mysqli_fetch_array($sql_chave_produto);
        $chave_imagem = $chave_produto['chave_imagem'];
    }

    $i = 0;
    foreach ($imagens['imagem']['name'] as $key) {
        $imagem_up = $imagens['imagem']['name'][$i];
        $tmp = $imagens['imagem']['tmp_name'][$i];
        $posicao = $_POST['posicao'][$i];
        $ext = strrchr($imagem_up, '.');
        $imagem_up = time() . uniqid(md5()) . $ext;
        $upload_final = $diretorio . $imagem_up;
        move_uploaded_file($tmp, $upload_final);
        $sql = mysqli_query($con, "insert into imagens_produtos (id_produto,posicao,chave_imagem,imagem)values('$id','$posicao','$chave_imagem','$upload_final')");
        $i++;
    }
    $i = 0;
    if (isset($_POST['posicao_existente'])) {
        foreach ($posicao_existente as $key) {
            $posicao = $_POST['posicao_existente'][$i];
            $id_imagem_existente = $_POST['id_imagem_existente'][$i];
            $sql = mysqli_query($con, "update imagens_produtos set posicao='$posicao' where id_imagem='$id_imagem_existente'");
            $i++;
        }
    }
    $i = 0;
    if (isset($_POST['esquerda'])) {
        foreach ($informacoes as $info) {
            $esquerda = $_POST['esquerda'][$i];
            $direita = $_POST['direita'][$i];
            $id_especificacao = $_POST['id_especificacao'][$i];
            if ($id_especificacao == '') {
                $sql = mysqli_query($con, "insert into produtos_especificacoes (id_tipo_produto,esquerda,direita)VALUES('$id','$esquerda','$direita')");
            } else {
                $sql = mysqli_query($con, "UPDATE produtos_especificacoes SET esquerda='$esquerda', direita='$direita' where id_especificacao = '$id_especificacao'");
            }

            $i++;
        }
    }

    echo "<script language=\"JavaScript\">
location.href=\"alterartipoprodutoop.php?id=$id\";
</script>";
}
?>