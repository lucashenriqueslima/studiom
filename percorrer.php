<?php


$dir = opendir('https://sistema.studiomfotografia.com.br/imagem/348-mais-um-teste-123-456-789');
if ($dir) {
    while (($item = readdir($dir)) !== false) {
        echo $item.'<br />';
    }
    closedir($dir);
}


?>