<?php
$file = $_GET['file'];
$fp = fopen($file, "r");
$nomebanco = 'BANCO'.date('dmY').'.sql';
header("Content-Type:text/plain");
header("Content-Disposition:attachment; filename=".$nomebanco);
header("Content-Transfer-Encoding:binary");
fpassthru($fp);

function ApagaArq($dir) {
if($objs = glob($dir."/*")){
foreach($objs as $obj) {
is_dir($obj)? ApagaArq($obj) : unlink($obj);
}
}
//rmdir($dir);
}

ApagaArq($file);

?>