<?php

$dbhost = 'localhost';
$dbuser = 'studioms_sistema';
$dbpass = ')^JG[W3Wr[gg';
$dbname   = 'studioms_sistema';



$backupfile = 'Autobackup_' . date("Ymd") . '.sql';
$backupzip = $backupfile . '.tar.gz';
system("mysqldump -h $dbhost -u $dbuser -p$dbpass --lock-tables $dbname > $backupfile");


move_uploaded_file($backupfile, __DIR__);

echo __DIR__;