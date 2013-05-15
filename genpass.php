<?php
include 'funciones.php';
global $saltt;
echo "Received ".$argv[1]."\n";
echo sha1($saltt.md5($argv[1]))."\n";
