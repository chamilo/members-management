<?php	
// Funciones de conexión con la base de dato
require 'funciones.php';
//error_reporting(E_ALL);
session_start();
/*
echo "<pre>";	
echo var_dump($_SESSION);	
echo "</pre>";

echo "<pre>";	
echo var_dump($_POST);	
echo "</pre>";
*/
/*
if(!isset($_SESSION['tipo'])){
	$_SESSION['id']= session_id();
	$_SESSION['tipo']= 'invitado';
}
*/
//echo $_SERVER['SERVER_NAME'];
if(isset($_POST['username']) && isset($_POST['password'])){
	if(login($_POST['username'],$_POST['password'],isset($_POST['loginkeeping']))==1){
		header('Location: http://'.$_SERVER['SERVER_NAME'].'/index.php');	  
	}else{
		$_SESSION['error'] = "Username and/or password, try again or request new password";
		session_write_close();
		header('Location: http://'.$_SERVER['SERVER_NAME'].'/login');
	}
	/*
	$link = conectar();
	$usuario = comillas_inteligentes($_POST['username']);
	
	$presql = "SELECT * FROM users WHERE user=".$usuario.";";
	$result = mysql_query($presql,$link);
	if (!$result) {
		die('Invalid query: ' . mysql_error());
	}
	$num_rows = mysql_num_rows($result);

	if ($num_rows == "0"){
		$_SESSION['error'] = "Usuario y/o clave incorrecta, pruebe de nuevo o solicite nueva contrase&ntilde;a";
		session_write_close();
		header('Location: http://'.$_SERVER['SERVER_NAME'].'/login');
	}else{
	$row = mysql_fetch_assoc($result);
	
	if( $row['pass'] == sha1($_POST['password']) ){
		$array = array('registrado',$row['cod']);
		$sql = "UPDATE users SET last_login='".$row['actual_login']."', actual_login=FROM_UNIXTIME(".time()."), last_ip='".$row['ip']."', ip='".$_SERVER['REMOTE_ADDR']."' WHERE cod='".$row['cod']."';";
		$result2 = mysql_query($sql,$link);
		if (!$result2) {
			die('Invalid query: ' . mysql_error());
		}
		$result_tmp = mysql_query("SELECT * FROM users WHERE cod='".$row['cod']."';",$link);
		$row = mysql_fetch_assoc($result_tmp);
		$_SESSION['tipo'] = encriptar(implode(':',$array));
		$_SESSION['codusuario'] = $row['cod'];
		$_SESSION['usuario'] = $row['user'];
		$_SESSION['name'] = $row['name'];
		$_SESSION['last_login'] = strtotime($row['last_login']);
		$_SESSION['actual_login'] = strtotime($row['actual_login']);
		$_SESSION['last_ip'] = $row['last_ip'];
		$_SESSION['ip'] = $row['ip'];
		$_SESSION['email'] = $row['email'];
		session_write_close();
		header('Location: http://'.$_SERVER['SERVER_NAME'].'/index.php');
	}else{
		$_SESSION['error'] = "Usuario y/o clave incorrecta, pruebe de nuevo o solicite nueva contrase&ntilde;a";
		session_write_close();
		header('Location: http://'.$_SERVER['SERVER_NAME'].'/login');
	}
	mysql_free_result($result);
	mysql_close($link);
	}
	*/
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
    <title>Administration Chamilo members</title>
    <meta name="author" content="Nosolored" />
    <link rel="shortcut icon" href="../favicon.ico"> 
    <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
    <link rel="stylesheet" type="text/css" href="css/cupertino/jquery-ui-1.9.1.custom.css" />

	<script src="js/jquery-1.8.2.js"></script>
	<script src="js/jquery-ui-1.9.1.custom.js"></script>
    <script src="js/configuracion_usuario.js" type="text/javascript"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			$("#ir_recordar").click(function() {
				$("#caja_login").hide();
				$("#caja_register").show();
			});
								   
			$("#ir_login").click(function() {
				$("#caja_login").show();
				$("#caja_register").hide();
			});					   
		});
	</script>
</head>
<body>
<div class="container">
<?php 

if(isset($_SESSION['error']) && $_SESSION['error']!=''){
	echo '<div class="ui-state-error">'.$_SESSION['error'].'</div>';
	unset($_SESSION['error']);
}

?>
	

<!-- Codrops top bar -->
<?php 
	if(Comprobariexplorer($_SERVER['HTTP_USER_AGENT'])){
		echo '<br /><br /><div class="ui-state-highlight">';
    	echo 'Para una correcta visualización recomendamos cualquiera de los siguientes navegadores. ';
		echo '<a href="http://www.mozilla.org/es-ES/firefox/fx" target="_blank"><strong> Mozilla Firefox </strong></a> o ';
		echo '<a href="https://www.google.com/chrome?hl=es" target="_blank"><strong> Google Chrome </strong></a>';
		echo '</div>';
		?>
		<br /><br />
        <header>
        <h1>Administration Chamilo members</span></h1>
    	<img src="images/logo_peq.png" />
        </header>
    	<br /><br />
		<div id="container_demo" >
        <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
        <div id="wrapper">
            <div id="caja_login" class="animate form" >
                <form  action="login.php" autocomplete="on" method="post"> 
                    <h1>Identified access</h1> 
                    <p> 
                        <label for="username" class="uname" > User name </label>
                        <input id="username" name="username" required="required" type="text" placeholder="user name"/>
                    </p>
                    <p> 
                        <label for="password" class="youpasswd" > Password </label>
                        <input id="password" name="password" required="required" type="password" placeholder="ej. X8df!90EO" /> 
                    </p>
                    <p class="keeplogin"> 
                        <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
                        <label for="loginkeeping">Keep me logged in</label>
                    </p>
                    <p class="login button"> 
                        <input type="submit" value="Login" /> 
                    </p>
                    <p class="change_link">
                        Remember password?
                        <a href="#toregister" id="ir_recordar" class="to_register">Get password</a>
                    </p>
                </form>
            </div>

            <div id="caja_register" class="animate form" style="display:none">
              <form  action="#" autocomplete="on"> 
                    <h1> Remember password </h1> 
                    <p> 
                        <label for="emailsignup" class="youmail" > E-mail</label>
                        <input id="emailsignup" name="emailsignup" size="30" required="required" type="email" placeholder="mysupermail@mail.com"/> 
                    </p>
                    
                    <p class="signin button"> 
                        <input type="submit" id="generaclave" value="New Password"/> 
                    </p>
                    <p class="change_link">  
                        Remember the data ?
                        <a href="#tologin" id="ir_login" class="to_register"> Go to login </a>
                    </p>
                </form>
            </div>
            
        </div>
    </div>
	<?php
	}else{
	?>
<header>
    <h1>Administration Chamilo members</span></h1>
    <img src="images/logo_peq.png" />
</header>
<section>				
    <div id="container_demo" >
        <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>
        <div id="wrapper">
            <div id="login" class="animate form">
                <form  action="login.php" autocomplete="on" method="post"> 
                    <h1>Identified access</h1> 
                    <p> 
                        <label for="username" class="uname" data-icon="u" > User name </label>
                        <input id="username" name="username" required="required" type="text" placeholder="nombredeusuario"/>
                    </p>
                    <p> 
                        <label for="password" class="youpasswd" data-icon="p"> Password </label>
                        <input id="password" name="password" required="required" type="password" placeholder="ej. X8df!90EO" /> 
                    </p>
                    <p class="keeplogin"> 
                        <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
                        <label for="loginkeeping">Keep me logged in</label>
                    </p>
                    <p class="login button"> 
                        <input type="submit" value="Login" /> 
                    </p>
                    <p class="change_link">
                        Remember the data ?
                        <a href="#toregister" class="to_register">Get password</a>
                    </p>
                </form>
            </div>

            <div id="register" class="animate form">
                <form  action="#" autocomplete="on"> 
                    <h1> Remember password </h1> 
                    <p> 
                        <label for="emailsignup" class="youmail" data-icon="e" > E-mail</label>
                        <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="mysupermail@mail.com"/> 
                    </p>
                    
                    <p class="signin button"> 
                        <input type="submit" id="generaclave" value="New Password"/> 
                    </p>
                    <p class="change_link">  
                        Remember the data ?
                        <a href="#tologin" class="to_register"> Go to login </a>
                    </p>
                </form>
            </div>
            
        </div>
    </div>  
</section>
<?php } ?>
</div>
</body>
</html>
