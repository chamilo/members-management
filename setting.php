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
echo "<pre>";	
echo var_dump($_FILES);	
echo "</pre>";
*/
if(isset($_POST['sendform'])){
	$link = conectar();
	$mbody = $link->real_escape_string($_POST['mbody']);
	$mfooter = $link->real_escape_string($_POST['footer']);
	$show = ($_POST['show_signature']=="YES")?("YES"):("NO");
	
	$sql = "UPDATE invoice SET body='".$mbody."', footer='".$mfooter."', show_signature='".$show."' WHERE cod='1';";
	$result = $link->query($sql);
	
	//Gestion de imagenes
	/* =========================== Procedemos a subir los archivos =========================== */
	/*echo "<pre>";	
	echo var_dump($_FILES);	
	echo "</pre>";
	*/
	if($_FILES['imglogo']['size'] > '0'){
		echo "entro en file logo";
		$file_name = $_FILES["imglogo"]["name"];
		$file_size = $_FILES["imglogo"]["size"];
		$file_type = $_FILES["imglogo"]["type"];
		$path="images/pdf_invoices"; 
		$aux = copy($_FILES["imglogo"]['tmp_name'], $path.'/logo.png');
		echo "<pre>".var_dump($aux)."</pre>";
	}
	
	if($_FILES['imgsignature']['size'] > '0'){
		echo "entro en file signature";
		$file_name = $_FILES["imgsignature"]["name"];
		$file_size = $_FILES["imgsignature"]["size"];
		$file_type = $_FILES["imgsignature"]["type"];
		$path="images/pdf_invoices";  
		copy($_FILES["imgsignature"]['tmp_name'], $path.'/firma.png');
	}
	/* ==================== Fin de subir los archivos ====================================== */
	header("Location: setting.php");
	header("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada 
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora 
	header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
	header("Pragma: no-cache");
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Chamilo - Setting</title>
<meta content="Chamilo - Members Management" name="description">
<meta http-equiv="last-modified" content="0">
<meta http-equiv="expires" content="0">
<meta http-equiv="cache-control" content="no-cache, mustrevalidate">
<meta http-equiv="pragma" content="no-cache">

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
	
	/* tabs */
	$("#tabs").tabs(); 
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
<img alt="Setting" src="images/logo.png">
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
        <h1>Setting</h1>
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
<div id="tabs">
<ul>
<li>
<a href="#tabs-1" class="corner-tl">Users</a>
</li>
<li>
<a href="#tabs-2">Messages</a>
</li>
<li>
<a href="#tabs-3">Template Invoices</a>
</li>
<li>
<a href="#tabs-4">Links Chamilo Community</a>
</li>
<li>
<a href="#tabs-5" class="corner-tr">Others configurations</a>
</li>
</ul>
<div id="tabs-1">
<br>
Search user: 
<input id="user" class="half" type="text" name="user" value=""> 
<input type="button" class="btn btn-green" id="buscar_user" name="enviar" value="Search">
<input type="button" class="btn btn-blue" id="new_user" name="enviar" value="New User">
<br><br>
<div id="result_searcher"></div>
<div id="result_edit"></div>
</div>
<div id="tabs-2">
<br>
Customize the message that members receive for each situation:
<select id="type_message">
	<option value="">Select a type of message</option>
    <option value="welcome">Welcome</option>
    <option value="renewal">Renewal notice</option>
    <option value="expired">Expired</option>
    <option value="renewed">Renewed</option>
    <option value="invoice_forward">Invoice Forward</option>
</select>
<select id="language">
	<option value="">Selected a language</option>
    <?php
	$link = conectar();
	$sql = "SELECT * FROM language WHERE active='1'";
	$result = $link->query($sql);
	while($row = $result->fetch_assoc()){
		echo "<option id='".$row['cod']."'>".$row['language']."</option>";
	}
	$result->free_result();
	?>
</select>
<div id="result_message"></div>
</div>
<div id="tabs-3">
<br>
<h3>Customize invoice template:</h3>
<form id="form_invoice" method="post" action="setting" enctype="multipart/form-data">
<?php
$sql = "SELECT * FROM invoice;";
$result = $link->query($sql);
$row = $result->fetch_assoc();
echo '<h4>Header:</h4>';
echo '<img src="images/pdf_invoices/logo.png" alt="logo header" /><br><br>';
echo 'If you want to change the logo, select a new image: ';

echo '<input type="file" name="imglogo" id="imglogo" size="50" accept="image/png"><br>';

echo '<hr>';
echo '<h4>Body: </h4>';
echo '<div style="width:80%;float:left;">';
echo '<textarea class="large tinymce" id="mbody" name="mbody" name="mbdody">'.$row['body'].'</textarea><br>';
echo "<div class='box box-info'>Double-click the field you want to insert into the textarea to include member information</div>";
echo '</div>';
echo '<div style="float:left;width:20%;text-align:center;">';
$sql = "DESCRIBE members";
$rs = $link->query($sql);
echo "<br>";
echo "<select id='field_invoice' size='".($rs->num_rows-4)."'>";
while($fila = $rs->fetch_assoc()){
	if($fila['Field']!='cod' && $fila['Field']!='mark_renewal' && $fila['Field']!='email_renewal' && $fila['Field']!='email_expired'){
		echo "<option value='".$fila['Field']."'>".$fila['Field']."</option>";
	}
}
echo "</select>";
echo "</div>";
echo "<div class='cleared'></div>";
echo "<hr>";
echo '<h4>Signature: </h4>';
echo 'Do you want to show the signature? ';
echo '<input type="checkbox" id="show_signature" name="show_signature" value="YES"';
echo ($row['show_signature']=="YES")?('checked="checked"'):('');
echo ' >';
echo '<div class="cleared"></div>';
echo '<img src="images/pdf_invoices/firma.png" alt="signature footer" /><br><br>';
echo 'If you want to change the signature, select a new image: ';
echo '<input type="file" name="imgsignature" id="imgsignature" size="50" accept="image/png"><br>';
echo '<hr>';
echo '<h4>Footer: </h4>';
echo '<textarea class="large tinymce" id="footer" name="footer">'.$row['footer'].'</textarea>';
echo '<br><br><div class="ta-center"><input class="btn btn-green big" type="submit" name="sendform" value="Save"></div>';
?>
</div>
<div id="tabs-4">
<br>
<h4>Module Links chamilo community</h4>
<div id="result_links" align="center">
<?php
$link = conectar();
$sql = "SELECT * FROM links;";
$result = $link->query($sql);
if($link->affected_rows<=0){
	//No hay registros
	echo 'No links';
}else{
	//Mostrar la tabla
	echo '<table class="stylized" id="tbl_links" width="100%">';
	echo '<tr><th>Title</th><th>Description</th><th class="ta-center">Options</th></tr>';
	while($row = $result->fetch_assoc()){
		echo '<tr><td>'.$row['title'].'</td>';
		echo '<td>'.$row['description'].'</td>';
		echo '<td id="link'.$row['cod'].'" class="ta-center">';
		echo '<a href="#" title="Edit" class="edit-link"><img src="images/note_edit.png" /></a>&nbsp;';
		echo '<a href="#" title="Delete" class="icon-elim-link"><img src="images/delete.png" /></a>';
		echo '</td>';
		echo '</tr>';
	}
	echo '</table>';
}
?>
</div>
<input type="button" class="btn btn-blue" id="add_link" value="Add link">
<br>
<div id="edit_link"></div>
</div>
<div id="tabs-5">
<br>
<h4>Language Manager:</h4>
<div id="manager_language">
<table id="tbl_estilo1" width="100%" align="center">
<tr><th>Available languages</th><th></th><th>Active languages</th></tr>
<tr>
<td style='width:45%'>
<?php
$link = conectar();
$sql = "SELECT * FROM language WHERE active='0';";
$result = $link->query($sql);
echo "<select id='lang_disp' size='10' style='width:100%'>";
while($fila = $result->fetch_assoc()){
	echo "<option value='".$fila['cod']."'>".$fila['language']."</option>";
}
$result->free_result();
echo "</select>";
?>
</td>
<td style='width:10%'>
<img src="images/right.png" alt="activar idioma" id="add_lang" class="puntero" > <br>
<img src="images/left.png" alt="desactivar idioma" id="del_lang" class="puntero" >
</td>
<td style='width:45%'>
<?php
$link = conectar();
$sql = "SELECT * FROM language WHERE active='1';";
$result = $link->query($sql);
echo "<select id='lang_acti' size='10' style='width:100%'>";
while($fila = $result->fetch_assoc()){
	echo "<option value='".$fila['cod']."'>".$fila['language']."</option>";
}
$result->free_result();
echo "</select>";
?>
</td>
</tr>
</table>
</div>
<br>
<h4>Default language:</h4> 
<select id="slang">
<?php 
$link = conectar();
$sql = "SELECT * FROM language WHERE active='1';";
$result = $link->query($sql);
while($fila = $result->fetch_assoc()){
	if($fila['vdefault'] == '1'){
		echo "<option value='".$fila['cod']."' selected='selected'>".$fila['language']."</option>";
	}else{
		echo "<option value='".$fila['cod']."'>".$fila['language']."</option>";
	}
}
$result->free_result();
?>
</select>
<div id="mslang" style="display:inline-block; margin: 0 0 0 15px;"></div>
<br>
<h4>Renewal Notice:</h4>
<?php 
$sql = "SELECT notice_renewal FROM parametros;";
$result = $link->query($sql);
$tmp_aux = $result->fetch_assoc();
$valor = $tmp_aux['notice_renewal'];

echo '<input type="number" id="avisorenovacion" value="'.$valor.'" class="ta-center" style="width: 50px;"> days to send notification by e-mail.';
$result->free_result();
?>
<br>

<h4>Sender's e-mail:</h4>
<?php 
$sql = "SELECT sender FROM parametros;";
$result = $link->query($sql);
$tmp_aux = $result->fetch_assoc();
$valor = $tmp_aux['sender'];
echo 'E-mail sender automated mails: <input type="text" id="senderemail" value="'.$valor.'" class="half">';
$result->free_result();
?>
<br>

<h4>E-mail of the person responsible for receiving mail copy of renewal notice</h4>

<?php
$link = conectar();
$sql = "SELECT * FROM responsible WHERE area='renewal'";
$result = $link->query($sql);
echo '<div id="result_renewal" align="center">';
if($link->affected_rows<=0){
	//No hay registros
	echo '<input type="text" id="emailresponsible_ren" > &nbsp;&nbsp;';
	echo '<input type="button" class="btn btn-blue" id="add_email_responsible_ren" value="Add e-mail">';
}else{
	//Mostrar la tabla
	echo '<table class="stylized" id="resp_renewal_email" width="60%">';
	echo '<tr><th>E-mail</th><th class="ta-center">Options</th></tr>';
	while($row = $result->fetch_assoc()){
		echo '<tr><td>'.$row['responsible'].'</td>';
		echo '<td id="resp'.$row['cod'].'" class="ta-center">';
		echo '<a href="#" title="Delete" class="icon-elim"><img src="images/delete.png" /></a>';
		echo '</td>';
		echo '</tr>';
	}
	echo '<tr><td colspan="2" class="ta-center">';
	echo '<input type="text" id="emailresponsible_ren" > &nbsp;&nbsp;';
	echo '<input type="button" class="btn btn-blue" id="add_email_responsible_ren" value="Add e-mail">';
	echo '</td></tr>';
	echo '</table>';
}
echo '</div>';
?>
<br>
<h4>E-mail of the person responsible for receiving mail copy of notice of expiration</h4>
<?php
$link = conectar();
$sql = "SELECT * FROM responsible WHERE area='expired'";
$result = $link->query($sql);
echo '<div id="result_expired" align="center">';
if($link->affected_rows<=0){
	//No hay registros
	echo '<input type="text" id="emailresponsible_exp" > &nbsp;&nbsp;';
	echo '<input type="button" class="btn btn-blue" id="add_email_responsible_exp" value="Add e-mail">';
}else{
	//Mostrar la tabla
	echo '<table class="stylized" id="resp_expired_email" width="60%">';
	echo '<tr><th>E-mail</th><th class="ta-center">Options</th></tr>';
	while($row = $result->fetch_assoc()){
		echo '<tr><td>'.$row['responsible'].'</td>';
		echo '<td id="resp'.$row['cod'].'" class="ta-center">';
		echo '<a href="#" title="Delete" class="icon-elim"><img src="images/delete.png" /></a>';
		echo '</td></tr>';
	}
	echo '<tr><td colspan="2" class="ta-center">';
	echo '<input type="text" id="emailresponsible_exp" > &nbsp;&nbsp;';
	echo '<input type="button" class="btn btn-blue" id="add_email_responsible_exp" value="Add e-mail">';
	echo '</td></tr>';
	echo '</table>';
	}
echo '</div>';
?>
<br>
<h4>Member type</h4>
<?php
$link = conectar();
$sql = "SELECT * FROM type_member;";
$result = $link->query($sql);
echo '<div id="result_type" align="center">';
if($link->affected_rows<=0){
	//No hay registros
	echo '<input type="text" id="typemembervalue" > &nbsp;&nbsp;';
	echo '<input type="button" class="btn btn-blue" id="add_new_type" value="Add type">';
}else{
	//Mostrar la tabla
	echo '<table class="stylized" id="resp_type" width="60%">';
	echo '<tr><th>E-mail</th><th class="ta-center">Options</th></tr>';
	while($row = $result->fetch_assoc()){
		echo '<tr><td>'.$row['name'].'</td>';
		echo '<td id="type'.$row['cod'].'" class="ta-center">';
		echo '<a href="#" title="Delete" class="icon-elim-type"><img src="images/delete.png" /></a>';
		echo '</td></tr>';
	}
	echo '<tr><td colspan="2" class="ta-center">';
	echo '<input type="text" id="typemembervalue" > &nbsp;&nbsp;';
	echo '<input type="button" class="btn btn-blue" id="add_new_type" value="Add type">';
	echo '</td></tr>';
	echo '</table>';
	}
echo '</div>';
?>
<br>

</div>
</div>


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
