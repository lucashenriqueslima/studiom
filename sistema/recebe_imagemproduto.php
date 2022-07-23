<?php

include "../includes/conexao.php";
session_start();

if(isset($_GET['id_evento'])){
    $id = $_GET['id'];
    $id_pacote = $_GET['id_pacote'];
    $id_evento = $_GET['id_evento'];
    if (isset($_GET['add'])) {
        $imagens = $_FILES;
        $posicao_existente = (isset($_POST['posicao_existente']) ? $_POST['posicao_existente'] : '');
        $diretorio = "../sistema/arquivos/imagens_produtos/";
        $sql_chave_produto = mysqli_query($con, "select * from eventos_pacote where id_pacote='$id' and id_evento='$id_evento' and chave_imagem is not null");
        $chave_imagem = 0;
        if (mysqli_num_rows($sql_chave_produto) == 0) {
            $sql_maximo = mysqli_fetch_array(mysqli_query($con, "select MAX(chave_imagem) as chave_imagem from imagens_produtos"));
            $chave_imagem = (int)$sql_maximo['chave_imagem'] + 1;
            $sql = mysqli_query($con, "update eventos_pacote SET chave_imagem='$chave_imagem' where id_evento = '$id_evento' and id_pacote in (select id_item from pacotes_itens_album where id_pacote = '$id_pacote')");
        } else {
            $chave_produto = mysqli_fetch_array($sql_chave_produto);
            $chave_imagem = $chave_produto['chave_imagem'];
        }
        $i = 0;
        if(isset($_FILES)){
            foreach ($imagens['imagem']['name'] as $key) {
                $imagem_up = $imagens['imagem']['name'][$i];
                $tmp = $imagens['imagem']['tmp_name'][$i];
                $posicao = $_POST['posicao'][$i];
                $ext = strrchr($imagem_up, '.');
                $imagem_up = time() . uniqid(md5()) . $ext;
                $upload_final = $diretorio . $imagem_up;
                move_uploaded_file($tmp, $upload_final);

                $sql = mysqli_query($con, "insert into imagens_produtos (id_evento,posicao,chave_imagem,imagem)values('$id_evento','$posicao','$chave_imagem','$upload_final')");
                $i++;
            }
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
        echo "<script language=\"JavaScript\">
location.href=\"alterarimagemevento.php?id_pacote=$id_pacote&id=$id&id_evento=$id_evento\";
</script>";
    } elseif(isset($_GET['remove'])) {
        $produtos = mysqli_fetch_array(mysqli_query($con, "select * from eventos_pacote where id_pacote = '$id' and id_evento='$id_evento'"));
        $imagens = mysqli_query($con, "select * from imagens_produtos where chave_imagem = '$produtos[chave_imagem]'");
        while($vet_imagem = mysqli_fetch_array($imagens)){
            $imagem = explode('/',$vet_imagem['imagem']);
            $unlink = $SERVER_ROOT . '/sistema/arquivos/imagens_produtos/' . $imagem[4];
            @unlink($unlink);
        }
        mysqli_query($con, "DELETE from imagens_produtos where chave_imagem = '$produtos[chave_imagem]'");
        mysqli_query($con, "UPDATE eventos_pacote SET chave_imagem=null where chave_imagem='$produtos[chave_imagem]'");
        echo "<script language=\"JavaScript\">
location.href=\"alterarpacote.php?id=$id_pacote\";
</script>";
    }elseif(isset($_GET['id_imagem'])){
        $id_imagem = $_GET['id_imagem'];
        $vet_imagem = mysqli_fetch_array(mysqli_query($con, "select * from imagens_produtos where id_imagem = '$id_imagem'"));
        $imagem = explode('/',$vet_imagem['imagem']);
        $unlink = $SERVER_ROOT . '/sistema/arquivos/imagens_produtos/' . $imagem[4];
        @unlink($unlink);
        mysqli_query($con, "DELETE from imagens_produtos where id_imagem = '$id_imagem'");
        $produtos = mysqli_fetch_array(mysqli_query($con, "select * from eventos_pacote where id_pacote = '$id' and id_evento='$id_evento'"));
        $sql = mysqli_query($con, "SELECT * from imagens_produtos where chave_imagem = '$produtos[chave_imagem]'");
        if(mysqli_num_rows($sql) == 0){
            mysqli_query($con, "update eventos_pacote set chave_imagem=null where id_evento='$id_evento' and id_pacote in ((select id_item from pacotes_itens_album where id_pacote = '$id_pacote'))");
        }
        echo "<script language=\"JavaScript\">
location.href=\"alterarimagemevento.php?id_pacote=$id_pacote&id=$id&id_evento=$id_evento\";
</script>";
    }
}else{
    $id = $_GET['id'];
    $id_produto = $_GET['id_produto'];
    $id_pacote = $_GET['id_pacote'];
    if (isset($_GET['add'])) {
        $imagens = $_FILES;
        $posicao_existente = (isset($_POST['posicao_existente']) ? $_POST['posicao_existente'] : '');
        $diretorio = "../sistema/arquivos/imagens_produtos/";
        $sql_chave_produto = mysqli_query($con, "select chave_imagem from pacotes_itens_produtos where id_produto = '$id_produto' and id_pacote='$id' and chave_imagem is not NULL");
        $chave_imagem = 0;
        if (mysqli_num_rows($sql_chave_produto) == 0) {
            $sql_maximo = mysqli_fetch_array(mysqli_query($con, "select MAX(chave_imagem) as chave_imagem from imagens_produtos"));
            $chave_imagem = (int)$sql_maximo['chave_imagem'] + 1;
            $sql = mysqli_query($con, "update pacotes_itens_produtos SET chave_imagem='$chave_imagem' where id_produto = '$id_produto' and id_pacote in (select id_item from pacotes_itens_album where id_pacote = '$id_pacote')");
        } else {
            $chave_produto = mysqli_fetch_array($sql_chave_produto);
            $chave_imagem = $chave_produto['chave_imagem'];
        }
        $i = 0;
        if(isset($_FILES)){
                    foreach ($imagens['imagem']['name'] as $key) {
                        $imagem_up = $imagens['imagem']['name'][$i];
                $tmp = $imagens['imagem']['tmp_name'][$i];
                $posicao = $_POST['posicao'][$i];
                $ext = strrchr($imagem_up, '.');
                $imagem_up = time() . uniqid(md5()) . $ext;
                $upload_final = $diretorio . $imagem_up;
                move_uploaded_file($tmp, $upload_final);

                $sql = mysqli_query($con, "insert into imagens_produtos (id_produto,posicao,chave_imagem,imagem)values('$id_produto','$posicao','$chave_imagem','$upload_final')");
                $i++;
            }
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
        echo "<script language=\"JavaScript\">
location.href=\"alterarimagemproduto.php?id_pacote=$id_pacote&id=$id&id_produto=$id_produto\";
</script>";
    } elseif(isset($_GET['remove'])) {
        $produtos = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_itens_produtos where id_pacote = '$id' and id_produto='$id_produto'"));
        $imagens = mysqli_query($con, "select * from imagens_produtos where chave_imagem = '$produtos[chave_imagem]'");
        while($vet_imagem = mysqli_fetch_array($imagens)){
            $imagem = explode('/',$vet_imagem['imagem']);
            $unlink = $SERVER_ROOT . '/sistema/arquivos/imagens_produtos/' . $imagem[4];
            @unlink($unlink);
        }
        mysqli_query($con, "DELETE from imagens_produtos where chave_imagem = '$produtos[chave_imagem]'");
        mysqli_query($con, "UPDATE pacotes_itens_produtos SET chave_imagem=null where id_produto='$id_produto' and id_pacote in ((select id_item from pacotes_itens_album where id_pacote = '$id_pacote'))");

        echo "<script language=\"JavaScript\">
location.href=\"alterarpacote.php?id=$id_pacote\";
</script>";
    }elseif(isset($_GET['id_imagem'])){
        $id_imagem = $_GET['id_imagem'];
        $vet_imagem = mysqli_fetch_array(mysqli_query($con, "select * from imagens_produtos where id_imagem = '$id_imagem'"));
        $imagem = explode('/',$vet_imagem['imagem']);
        $unlink = $SERVER_ROOT . '/sistema/arquivos/imagens_produtos/' . $imagem[4];
        @unlink($unlink);
        mysqli_query($con, "DELETE from imagens_produtos where id_imagem = '$id_imagem'");
        $produtos = mysqli_fetch_array(mysqli_query($con, "select * from pacotes_itens_produtos where id_pacote = '$id' and id_produto='$id_produto'"));
        $sql = mysqli_query($con, "SELECT * from imagens_produtos where chave_imagem = '$produtos[chave_imagem]'");
        if(mysqli_num_rows($sql) == 0){
            mysqli_query($con, "update pacotes_itens_produtos set chave_imagem=null where id_produto='$id_produto' and id_pacote in ((select id_item from pacotes_itens_album where id_pacote = '$id_pacote'))");
        }
        echo "<script language=\"JavaScript\">
location.href=\"alterarimagemproduto.php?id_pacote=$id_pacote&id=$id&id_produto=$id_produto\";
</script>";
    }
}

?>