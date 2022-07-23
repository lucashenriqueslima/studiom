<?php

include "../includes/conexao.php";

if (isset($_GET['remover'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $vet_imagem = mysqli_fetch_array(mysqli_query($con, "select * from imagens_produtos where id_imagem = '$id'"));
        $imagem = explode('/',$vet_imagem['imagem']);
        $unlink = $SERVER_ROOT . '/sistema/arquivos/imagens_produtos/' . $imagem[4];
        @unlink($unlink);
        mysqli_query($con, "delete from imagens_produtos where id_imagem = '$id'");
        die();
    }
} else {
    $id = $_GET['id'];
    $nome = ucwords(strtolower($_POST['nome']));
    $sigla = $_POST['sigla'];
    $tipo = $_POST['tipo'];
    $posicao_album = $_POST['posicao_album'];

    $imagens = $_FILES;
    $posicao_existente = (isset($_POST['posicao_existente']) ? $_POST['posicao_existente'] : '');
    $diretorio = "../sistema/arquivos/imagens_produtos/";
    $sql_chave_produto = mysqli_query($con, "select chave_imagem from categoriaevento where id_categoria = '$id' and chave_imagem is not NULL");
    $chave_imagem = 0;
    if (mysqli_num_rows($sql_chave_produto) == 0) {
        $sql_maximo = mysqli_fetch_array(mysqli_query($con, "select MAX(chave_imagem) as chave_imagem from imagens_produtos"));
        $chave_imagem = (int)$sql_maximo['chave_imagem'] + 1;
        $sql = mysqli_query($con, "update categoriaevento SET posicao='$posicao_album',chave_imagem='$chave_imagem',nome='$nome', sigla='$sigla', tipo='$tipo' where id_categoria = '$id'");
    } else {
        $sql = mysqli_query($con, "update categoriaevento SET posicao='$posicao_album',nome='$nome', sigla='$sigla', tipo='$tipo' where id_categoria = '$id'");
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

        $sql = mysqli_query($con, "insert into imagens_produtos (id_evento,posicao,chave_imagem,imagem)values('$id','$posicao','$chave_imagem','$upload_final')");
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
    echo"<script language=\"JavaScript\">
location.href=\"alterarcategoriaevento.php?id=$id\";
</script>";
}
?>