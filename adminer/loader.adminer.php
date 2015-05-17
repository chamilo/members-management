<?php
require '../funciones.php';
session_start();
seguridad();
if(isset($_POST['logout'])){
	header('Location: '.$_SESSION['url_main']);
}
      
function adminer_object() {
	class AdminerSoftware extends Adminer {
    	function credentials() {
			require '../config.php';
        	// server, username and password for connecting to database
            return array($config['db']['host'], $config['db']['user'], $config['db']['pass']);
        }

        function database() {
            require '../config.php';
			// database name, will be escaped by Adminer
			return $config['db']['name'];
        }
	}
    return new AdminerSoftware;
}
require_once 'adminer.php';
