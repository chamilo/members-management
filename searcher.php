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
<title>Chamilo - Searcher</title>
<meta content="Chamilo - Members Management" name="description">
<!-- We need to emulate IE7 only when we are to use excanvas -->
<!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <![endif]-->
<!-- Favicons -->

<!-- Main Stylesheet -->
<link type="text/css" href="css/style4.css" rel="stylesheet">
<!-- <link type="text/css" href="css/green.css" rel="stylesheet">-->
<!-- Your Custom Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.17.custom.css" media="screen">
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



<!-- jQuery popup box -->
<script src="js/jquery.nyroModal.pack.js" type="text/javascript"></script>
<!-- jQuery graph plugins -->
<!--[if IE]><script type="text/javascript" src="js/flot/excanvas.min.js"></script><![endif]-->
<script src="js/flot/jquery.flot.min.js" type="text/javascript"></script>
<!-- Internet Explorer Fixes -->
<!--[if IE]> <link rel="stylesheet" type="text/css" media="all" href="css/ie.css"/> <script src="js/html5.js"></script> <![endif]-->
<!--Upgrade MSIE5.5-7 to be compatible with MSIE8: http://ie7-js.googlecode.com/svn/version/2.1(beta3)/IE8.js -->
<!--[if lt IE 8]> <script src="js/IE8.js"></script> <![endif]-->
<script type="text/javascript">
	$(document).ready(function(){
	/* setup navigation, content boxes, etc... */
	Administry.setup();
	}); 
</script>

<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#renewal_ini, #renewal_fin, #arrival_ini, #arrival_fin").datepicker({
  	    dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true
	});
		
});
</script>
<script src="js/conf_searcher.js" type="text/javascript"></script>
</head>
<body>
<!-- Header -->
<header id="top">
<div class="wrapper">
<!-- Title/Logo - can use text instead of image -->
<div id="title">
<img alt="Members Management" src="img/logo.png">
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
        <h1>Searcher</h1>
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
<form action="#" id="form_searcher" method="post" >
	<div align="center">
    <table border="0" width="100%" id="tbl_estilo1">
    <tr><th>Form searcher</th></tr>
    <tr>
    	<td>
    	Name: <input type="text" name="name" id="name" size="23" />
        Surname: <input type="text" name="surname" id="surname" size="23" />
        Email: <input type="text" name="email" id="email" size="23" />
        <br /><br />
        Country
        <select name="country" id="country" style="width:200px">
        	<?php
			$link = conectar();
			$sql = "SELECT * FROM country";
			echo '<option value=""></option>';
			$result = $link->query($sql);
			if(!$result){
				die('Invalid query: ' . $link->error);
			}
			while($row = $result->fetch_assoc()){
				echo '<option value="'.$row['iso'].'" style="max-width:200px">'.$row['name'].'</option>';
			}
			$result->free_result();
			$result->close();
			?>
        </select>
        Phone: <input type="text" name="phone" id="phone" size="17" />
        Quota: <input type="text" name="quota" id="quota" size="10" />
        <br /><br />
		Type member:
   		<select name="type" id="type">
   		<?php
       		$link = conectar();
			$sql = "SELECT * FROM type_member";
			echo '<option value=""></option>';
			$result = $link->query($sql);
			if(!$result){
				die('Invalid query: ' . $link->error);
			}
			while($row = $result->fetch_assoc()){
				echo '<option value="'.$row['cod'].'" style="max-width:200px">'.$row['name'].'</option>';
			}
			$result->free_result();
			$result->close();
    	?>
        </select>
        Status: 
        <select name="status" id="status">
        <?php 
		$link = conectar();
		$sql = "SELECT * FROM status";
		$result = $link->query($sql);	
		if (!$result) {									
			die('Invalid query2: ' . $link->error);	
		}
		echo '<option value="" selected="selected"></option>';
		while($row = $result->fetch_assoc()){
			echo '<option value="'.$row['cod'].'">'.$row['status'].'</option>';
		}
   	 	$result->free_result();
    	$result->close();
    	?>
        </select>
    	Language:
        <select name="language" id="language">
    	<?php
		echo '<option value="" selected="selected"></option>';
		$link = conectar();
		$sql = "SELECT * FROM language WHERE active='1' ORDER BY language ASC";
		$result = $link->query($sql);	
		if (!$result) {									
			die('Invalid query2: ' . $link->error);	
		}
		while($row = $result->fetch_assoc()){
			echo '<option value="'.$row['cod'].'">'.$row['language'].'</option>';
		}
		$result->free_result();
		$result->close();
   		?>
        </select>
        <br /><br />
        Date renewal between:
        <input type="text" name="renewal_ini" id="renewal_ini" placeholder="dd/mm/yyyy" />
        &nbsp;&nbsp; to &nbsp;&nbsp;
        <input type="text" name="renewal_fin" id="renewal_fin" placeholder="dd/mm/yyyy" />
        <?php
        if(Comprobariexplorer($_SERVER['HTTP_USER_AGENT'])){
        	echo '&nbsp;&nbsp;(dd/mm/yyyy)';
        }
		?>
        <br /><br />
        &nbsp;&nbsp;Date arrival between: &nbsp;
        <input type="text" name="arrival_ini" id="arrival_ini" placeholder="dd/mm/yyyy" />
        &nbsp;&nbsp; to &nbsp;&nbsp;
        <input type="text" name="arrival_fin" id="arrival_fin" placeholder="dd/mm/yyyy" />
         <?php
        if(Comprobariexplorer($_SERVER['HTTP_USER_AGENT'])){
        	echo '&nbsp;&nbsp;(dd/mm/yyyy)';
        }
		?>
        </td>
    </tr>
    <tr><td class="center">
    <div class="center">
    <input type="button" class="btn btn-green big" id="buscar" name="enviar" value="Search" />
    <input type="button" class="btn btn-red big" id="reset" name="reset" value="Reset" />
    </div>
    </td></tr>
    </table>
    </div>
</form>

<div id="result_searcher"></div>
<div id="result_edit"></div>
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
