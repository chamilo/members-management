<?php
require 'funciones.php';
session_start();
if(isset($_SESSION['codusuario'])){
	session_unset($_SESSION['codusuario']);
	session_unset($_SESSION['usuario']);
	session_unset($_SESSION['name']);
	session_unset($_SESSION['last_login']);
	session_unset($_SESSION['actual_login']);
	session_unset($_SESSION['last_ip']);
	session_unset($_SESSION['ip']);
	session_unset($_SESSION['email']);
	session_destroy();
}
setCookie("identificado",0,time()-2592000,'/'); //cookie 60min
session_write_close();
header('Location: http://'.$_SERVER['SERVER_NAME']);
?>