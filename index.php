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
/*
echo "<pre>";	
echo var_dump($_POST);	
echo "</pre>";
*/
/*
if(!isset($_SESSION['tipo'])){
	$_SESSION['id']= session_id();
	$_SESSION['tipo']= 'invitado';
	header('Location: http://'.$_SERVER['SERVER_NAME'].'/login');
}

$candado = explode(':',desencriptar($_SESSION['tipo']));
if($candado[0]!='registrado'){
	$_SESSION['tipo']= 'invitado';
	header('Location: http://'.$_SERVER['SERVER_NAME'].'/login');
}else{
	$link = conectar();
	$sql =  "SELECT * FROM users WHERE cod='".$candado[1]."';";
	$result = $link->query($sql);
	if($result->num_rows==0){
		$_SESSION['tipo']= 'invitado';
		header('Location: http://'.$_SERVER['SERVER_NAME'].'/login');
	}
}
*/
/* echo "<pre>".var_dump($_SESSION)."</pre>"; */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Chamilo - Members Management</title>
<meta content="Chamilo - Members Management" name="description">
<!-- We need to emulate IE7 only when we are to use excanvas -->
<!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <![endif]-->
<!-- Favicons -->
<link href="http://chamilo.nosolored.me/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<!-- Main Stylesheet -->
<link type="text/css" href="css/style4.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/custom.css" media="screen">
<!-- <link type="text/css" href="css/green.css" rel="stylesheet">-->
<!-- Your Custom Stylesheet -->

<!--swfobject - needed only if you require <video> tag support for older browsers -->
<script src="js/swfobject.js" type="text/javascript"></script>
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
<!-- jQuery form validation -->
<script src="js/jquery.validate_pack.js" type="text/javascript"></script>
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
	
	$(".icon-1").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		$("#result_edit").html('<div class="center"><br /><img src="img/nyro/ajaxLoader.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_searcher.php",{tab:"edit_member",cod:vcod},
			   function(data){
				   if(data.status == "false"){
					   	alert("Problem for edit");
				 		$("#result_edit").html('');
				   }else{
					   	$("#result_edit").html(data.contenido);
						$("#save_edit").click(function(e) {
							e.preventDefault();
							e.stopPropagation();
							var vcod = $("#member_edit #cod").attr("value");
							var nombre = $("#member_edit #name").attr("value");
							var apellidos = $("#member_edit #surname").attr("value");
							var vemail = $("#member_edit #email").attr("value");
							var pais = $("#member_edit #country").attr("value");
							var telefono = $("#member_edit #phone").attr("value");
							var vquota = $("#member_edit #quota").attr("value");
							var tipo = $("#member_edit #type").attr("value");
							var institucion = $("#member_edit #institution").attr("value");
							var direccion = $("#member_edit #address").attr("value");
							var cpostal = $("#member_edit #postal_code").attr("value");
							var nvat = $("#member_edit #vat").attr("value");
							var estado = $("#member_edit #status").attr("value");
							var lenguaje = $("#member_edit #language").attr("value");
							var renovacion = $("#member_edit #renewal").attr("value").replace(/\//g, '-');
							var comentarios = $("#member_edit #comment").attr("value");
							
							$.post("funciones/configuracion_searcher.php",{tab:"editar",cod:vcod,name:nombre,surname:apellidos,email:vemail,country:pais,phone:telefono,quota:vquota,type:tipo,institution:institucion,address:direccion,postal_code:cpostal,vat:nvat,status:estado,language:lenguaje,renewal:renovacion,comment:comentarios},
								function(data){
									if(data.status == "false"){
										alert("Error while editing");
									}else{
										$("#result_edit").html('');
										//Actualizar los 3 campos de la tabla que se ha editado
										alert("updated correctly");
										$("#"+data.cod).prev().prev().prev().prev().html(data.name);
										$("#"+data.cod).prev().prev().prev().html(data.surname);
										$("#"+data.cod).prev().prev().html(data.email);
										$("#"+data.cod).prev().html(data.renewal);
									}
								}, "json"); 
							
							return false;  
						});
						
						$("#member_edit #type").change(function(){
							var tipo = $(this).attr("value");
							if(tipo=='2' || tipo=='5'){
								$("#company").show();
								$("#institution").removeAttr('disabled');
					
							}else{
								$("#company").hide();
								$("#institution").attr("disabled","disabled");
							}						  
						});
				   }
			   },"json");
	});
	
	$(".renovar").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Update member?")){
			$.post("funciones/configuracion_searcher.php",{tab:"renovar_miembro",cod:vcod},
				   function(data){
					  if(data.status=="false"){
						  alert("Error update");
					  }else{
						  window.location.href="index.php";
					  }
				   }, "json"); 
		}
		return false;  
	});
	
	$(".eliminar-usuario").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Erase member?")){
			$.post("funciones/configuracion_searcher.php",{tab:"eliminar_usuario",cod:vcod},
				   function(data){
					  if(data.status=="false"){
						  alert("Error erase");
					  }else{
						  $("#"+data.cod).parent().remove();					 		  
					  }
				   }, "json"); 
		}
		return false;  
	});
	

	}); 
</script>
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
<b><?php echo htmlspecialchars($_SESSION['usuario']); ?></b>
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
<!-- Future Proyect -- Aside links 
<aside>
<b>English</b>
·
<a href="#">Spanish</a>
·
<a href="#">German</a>
</aside>
-->
<!-- End of Aside links -->
</div>
</header>
<!-- End of Header -->
<!-- Page title -->
<div id="pagetitle">
<div class="wrapper">
<h1>Dashboard</h1>
<!-- Quick search box -->
<form method="get" action="">
<input id="q" class="" type="text" name="q">
</form>
</div>
</div>
<!-- End of Page title -->
<!-- Page content -->
<div id="page">
<!-- Wrapper -->
<div class="wrapper">
<!-- Left column/section -->
<section class="column width6 first">
<div class="colgroup leading">
<div class="column width3 first">
<h3>
Welcome back,
<a href="profile.php"><?php echo htmlspecialchars($_SESSION['name']); ?></a>
</h3>
<p>You are in the management platform Chamilo members</p>
</div>
<div class="column width3">
<h4>Last login</h4>
<p>
<?php echo date("l F d\\t\h, Y \\a\\t h:ia",$_SESSION['last_login']).' from '. $_SESSION['last_ip']; ?>
</p>
</div>
</div>
<div class="colgroup leading">
<div class="column width3 first">
<h4>Members Status</h4>
<hr>
<table class="no-style full">
<tbody>
<?php
$link = conectar();
$result_num = $link->query("SELECT count('cod') AS num FROM members");
$tmp = $result_num->fetch_assoc();
$num_members = $tmp['num'];
$estilo = array("progress-green","progress-blue","progress-red");
$sql = "SELECT * FROM status";
$result = $link->query($sql);
$i = 0;
while ($tmp_status = $result->fetch_assoc()){
	$result_num = $link->query("SELECT count('cod') AS num FROM members WHERE status='".$tmp_status['cod']."'");
	$tmp = $result_num->fetch_assoc();
	$num_status = $tmp['num'];
	echo '<tr>';
	echo '<td>'.$tmp_status['status'].'</td>';
	echo '<td class="ta-right">'. $num_status .'/'.$num_members.'</td>';
	echo '<td>';
	echo '<div id="progress1" class="progress full '.$estilo[($i%3)].'" value="'.$num_status.'">';
	if($num_members > 0 ){
		echo '<span style="width: '.round((($num_status/$num_members)*100)).'%; display: block;">';
		echo '<b style="display: inline;">'.round((($num_status/$num_members)*100)).'%</b>';
	}else{
		echo '<span style="width:0%; display: block;">';
		echo '<b style="display: inline;">0%</b>';
	}
	echo '</span>';
	echo '</div>';
	echo '</td>';
	echo '</tr>';
	$i++;
}
?>
</tbody>
</table>
</div>


<div class="column width3">
<h4>
Statistics:
</h4>
<hr>
<table class="no-style full">
<tbody>
<?php
$sql = "SELECT COUNT(*) AS cuenta, SUM(quota) AS suma FROM members WHERE date_arrival > '".date("Y-m")."-01'";
$result = $link->query($sql);
$aux = $result->fetch_assoc();
?>
<tr>
<td>New inscriptions this month</td>
<td class="ta-right">
<a href="#"><?php echo $aux['cuenta']; ?></a>
</td>
<td class="ta-right"><?php echo number_format($aux['suma'],2,'.',' '); ?> €</td>
</tr>
<?php
$sql = "SELECT COUNT(*) AS cuenta, SUM(quota) AS suma FROM members WHERE date_arrival > '".date("Y")."-01-01'";
$result = $link->query($sql);
$aux = $result->fetch_assoc();
?>
<tr>
<td>New inscriptions this year</td>
<td class="ta-right">
<a href="#"><?php echo $aux['cuenta']; ?></a>
</td>
<td class="ta-right"><?php echo number_format($aux['suma'],2,'.',' '); ?> €</td>
</tr>
<?php
$sql = "SELECT COUNT(*) AS cuenta, SUM(quota) AS suma FROM members WHERE mark_renewal > '".date("Y-m")."-01'";
$result = $link->query($sql);
$aux = $result->fetch_assoc();
?>
<tr>
<td>Renovations this month</td>
<td class="ta-right">
<a href="#"><?php echo $aux['cuenta']; ?></a>
</td>
<td class="ta-right"><?php echo number_format($aux['suma'],2,'.',' '); ?> €</td>
</tr>
<?php
$sql = "SELECT COUNT(*) AS cuenta, SUM(quota) AS suma FROM members WHERE mark_renewal > '".date("Y")."-01-01'";
$result = $link->query($sql);
$aux = $result->fetch_assoc();
?>
<tr>
<td>Renovations this year</td>
<td class="ta-right">
<a href="#"><?php echo $aux['cuenta']; ?></a>
</td>
<td class="ta-right"><?php echo number_format($aux['suma'],2,'.',' '); ?> €</td>
</tr>
</tbody>
</table>
</div>
</div>


<?php 
$sql = "SELECT * FROM members WHERE email_renewal='1' ORDER BY renewal ASC;";
$result = $link->query($sql);
?>
<div class="colgroup leading">
<div class="width6">
<h4>
Member renewal notice:
<a href="#"><?php echo $result->num_rows; ?></a>
</h4>
<hr>
<?php 
if($result->num_rows>0){
	echo '<div id="result_searcher" align="center">';
	echo '<table class="stylized"  width="100%">';
	echo '<tr><th>N</th><th class="name">Name</th><th class="surname">Surname</th><th class="email">E-mail</th><th class="renewal">Renewal</th><th class="option">Options</th></tr>';
	$i = 0;
	while($row = $result->fetch_assoc()){
		$i += 1;
		if($i%2==0){
			echo '<tr class="campo2">';
		}else{
			echo '<tr>';
		}
        echo '<td>'.$i.'</td>';
		echo '<td>'.htmlspecialchars($row['name']).'</td>';
		echo '<td>'.htmlspecialchars($row['surname']).'</td>';
		echo '<td>'.htmlspecialchars($row['email']).'</td>';
		echo '<td class="ta-center">'.date("d/m/Y",strtotime($row['renewal'])).'</td>';
		echo '<td id="member'.$row['cod'].'" class="options-width">';
		echo '<a href="renovar-user.php?cod='.$row['cod'].'" title="Renewal" class="renovar"><img src="images/update.png" /></a>&nbsp;';
		echo '<a href="edit-user.php?cod='.$row['cod'].'" title="Edit '.$row['usuario'].'" class="icon-1 info-tooltip"><img src="images/note_edit.png" /></a>&nbsp;';
		echo '<a href="delete-user.php?cod='.$row['cod'].'" title="Delete" '.$row['usuario'].'" class="eliminar-usuario"><img src="images/delete.png" /></a>';
		echo '</td>';
		echo '</tr>';
		}
	echo '</table></div>';
	$result->free_result();
}
?>
</div>
<div id="result_edit"></div>
</div>
<div class="clear"> </div>
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

