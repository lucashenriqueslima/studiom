<?php

$id = $_GET['id'];

echo "<script> alert('Ainda restam produtos a serem aprovados. Informamos que seus produtos entrarão em nosso cronograma de produção apenas quando finalizar a aprovação de todos eles, pois serão produzidos de uma só vez devido a logística da entrega.')</script>";
echo "<script> window.location.href='meualbum.php?id=$id'</script>";

?>