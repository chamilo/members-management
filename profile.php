<?php	
// Funciones de conexión con la base de dato
require 'funciones.php';
//error_reporting(E_ALL);
$link = conectar();
session_start();
seguridad();
/*
echo "<pre>";	
echo var_dump($_SESSION);	
echo "</pre>";
*/
/*
echo "<pre>";	
echo var_dump($_POST);	
echo "</pre>";
*/


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Chamilo - Setting</title>
<meta content="Chamilo - Members Management" name="description">
<!-- We need to emulate IE7 only when we are to use excanvas -->
<!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <![endif]-->
<!-- Favicons -->

<!-- Main Stylesheet -->
<link type="text/css" href="css/style4.css" rel="stylesheet">
<!-- <link type="text/css" href="css/green.css" rel="stylesheet">-->
<!-- Your Custom Stylesheet -->
<!--<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.17.custom.css" media="screen">-->
<link rel="stylesheet" type="text/css" href="css/custom.css" media="screen">

<!-- jQuery with plugins -->
<script src="js/jquery-1.8.2.js" type="text/javascript"></script>
<!-- Could be loaded remotely from Google CDN : <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> -->
<script src="js/jquery.ui.core.min.js" type="text/javascript"></script>
<script src="js/jquery.ui.widget.min.js" type="text/javascript"></script>
<script src="js/jquery.ui.tabs.min.js" type="text/javascript"></script>
<!-- jQuery tooltips -->
<script src="js/jquery.tipTip.min.js" type="text/javascript"></script>
<!-- Superfish navigation -->
<script src="js/jquery.superfish.min.js" type="text/javascript"></script>
<script src="js/jquery.supersubs.min.js" type="text/javascript"></script>

<!-- Load TinyMCE -->
<script type="text/javascript" src="js/tiny_mce/jquery.tinymce.js"></script>

<!-- jQuery popup box -->
<script src="js/jquery.nyroModal.pack.js" type="text/javascript"></script>

<!-- Internet Explorer Fixes -->
<!--[if IE]> <link rel="stylesheet" type="text/css" media="all" href="css/ie.css"/> <script src="js/html5.js"></script> <![endif]-->
<!--Upgrade MSIE5.5-7 to be compatible with MSIE8: http://ie7-js.googlecode.com/svn/version/2.1(beta3)/IE8.js -->
<!--[if lt IE 8]> <script src="js/IE8.js"></script> <![endif]-->
<script type="text/javascript">
	$(document).ready(function(){
	/* setup navigation, content boxes, etc... */
	Administry.setup();
	
	$("#save_edit").click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		var vcod = $("#user_edit #cod").attr("value");
		var usuario = $("#user_edit #user").attr("value");
		var clave = $("#user_edit #password").attr("value");
		var correo = $("#user_edit #email").attr("value");
		var nombre = $("#user_edit #name").attr("value");
		$.post("funciones/configuracion_setting.php",{tab:"editar",cod:vcod,name:nombre,user:usuario,email:correo,password:clave},
			function(data){
				if(data.status == "false"){
					alert("Error while editing");
				}else{
					alert("updated correctly");
				}
			}, "json"); 
		
		return false;  
	});
	}); 
</script>
<script src="js/conf_setting.js" type="text/javascript"></script>
</head>
<body>
<!-- Header -->
<header id="top">
<div class="wrapper">
<!-- Title/Logo - can use text instead of image -->
<div id="title">
<img alt="Setting" src="img/logo.png">
<!--<span>Administry</span> demo-->
</div>
<!-- Top navigation -->
<div id="topnav">
Logged in as
<b><?php echo $_SESSION['usuario']; ?></b>
<span>|</span>
<a href="setting.php">Settings</a>
<span>|</span>
<a href="logout.php">Logout</a>
<br>
</div>
<!-- End of Top navigation -->
<!-- Main navigation -->
<?php include_once 'menu/top-menu.php'; ?>
<!-- End of Main navigation -->
</div>
</header>
<!-- End of Header -->
<!-- Page title -->
<div id="pagetitle">
    <div class="wrapper">
        <h1>Profile</h1>
    </div>
</div>
<!-- End of Page title -->
<!-- Page content -->
<div id="page">
<?php 
if(isset($_SESSION['info']) && $_SESSION['info']!=''){
	echo '<div class="box box-success closeable">'.$_SESSION['info'].'</div>';
	unset($_SESSION['info']);
}
?>

<!-- Wrapper -->
<div class="wrapper">
<!-- Left column/section -->
<section class="column width6 first">
		<?php 
		$sql = "SELECT * FROM users WHERE cod='".$_SESSION['codusuario']."';";
		$result = mysql_query($sql,$link);
		$row = mysql_fetch_assoc($result);
        echo '<h3>Form edit user</h3>';
		echo '<div class="box box-info">If the password is blank, will not change the current password</div>';
		echo '<form id="user_edit" action="#" method="post"><fieldset>';
		echo '<input type="hidden" id="cod" value="'.$_SESSION['codusuario'].'" />';
		echo '<p><label class="required" for="user">User:</label><br>';
		echo '<input id="user" class="half" type="text" name="user" value="'.htmlspecialchars($row['user']).'"></p>';
		echo '<p><label for="password">Password:</label><br>';
		echo '<input id="password" class="half" type="password" name="password" value=""></p>';
		echo '<p><label class="required" for="name">Name:</label><br>';
		echo '<input id="name" class="half" type="text" name="name" value="'.htmlspecialchars($row['name']).'"></p>';
		echo '<p><label class="required" for="email">Email address:</label><br>';
		echo '<input id="email" class="half" type="text" name="email" value="'.htmlspecialchars($row['email']).'"></p>';
		echo '<p class="box"><input class="btn btn-green big" type="submit" id="save_edit" name="sendform" value="Save">';
		?>

</section> 
<!-- End of Left column/section -->
<!-- Right column/section -->
<?php include_once 'menu/right-menu.php'; ?>
<!-- End of Right column/section -->
</div>
<!-- End of Wrapper -->



</div>
<!-- End of Page content -->
<!-- Page footer -->
<?php include_once 'menu/footer-menu.php'; ?>
<!-- End of Animated footer -->
<!-- Scroll to top link -->
<a id="totop" style="display: block;">^ scroll to top</a>
<!-- Admin template javascript load -->
<script src="js/administry.js" type="text/javascript"></script>
<div id="tiptip_holder" style="max-width:200px;">
<div id="tiptip_arrow">
<div id="tiptip_arrow_inner"></div>
</div>
<div id="tiptip_content"></div>
</div>
</body>
</html>
