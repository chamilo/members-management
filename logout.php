<?php
	session_start();
	session_destroy();
	setCookie("identificado",$cookie,time()-3600,'/'); //cookie 6min
	header('Location: http://'.$_SERVER['SERVER_NAME']);
?>