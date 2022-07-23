<?php

include "../includes/conexao.php";



$dispositivo = $_POST['dispositivo']; 
$tipoDispositivo = $_POST['tipodispositivo']; 
$marca = $_POST['marca']; 
$nserie = $_POST['nserie']; 
$tamanho = $_POST['tamanho']; 
$id_usuario = $_POST['id_usuario']; 
$tipoCadastro = $_POST['tipocadastro']; 




//altera cadastro de dispositivo
if ($tipoCadastro == 2) {
    $id_dispositivo = $_GET['id']; 
    $sql = mysqli_query($con, "update dispositivos set dispositivo = '$dispositivo', tipoDispositivo = '$tipoDispositivo', marcaDispositivo = '$marca', nserieDispositivo = '$nserie', tamanhoDispositivo = '$tamanho', id_usuario_fk = $id_usuario where id_dispositivo = $id_dispositivo");

    echo"<script language=\"JavaScript\">
    alert(\"Dispositivo alterado com sucesso\");
    location.href=\"cadastro_dispositivo.php\";
    </script>";
}else{
//cadastro de dispositivo
    $sql_verifica =  mysqli_query($con, "select * from dispositivos where nserieDispositivo = '$nserie'");
    
    
    if (mysqli_num_rows($sql_verifica) == 0) {
    
        $sql = mysqli_query($con, "insert into dispositivos (dispositivo, tipoDispositivo, marcaDispositivo, nserieDispositivo, tamanhoDispositivo, id_usuario_fk) VALUES ('$dispositivo', '$tipoDispositivo', '$marca', '$nserie', '$tamanho', '$id_usuario')");

        echo"<script language=\"JavaScript\">
        alert(\"Dispositivo cadastrado com sucesso\");
        location.href=\"cadastro_dispositivo.php\";
        </script>";
    }else{
    
        echo"<script language=\"JavaScript\">
        alert(\"Dispositivo já cadastrado\");
        location.href=\"cadastro_dispositivo.php\";
        </script>";
    }

}
?>