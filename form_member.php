<?php	
// Funciones de conexión con la base de dato
require 'funciones.php';
require('clases/fpdf.php');
define('FPDF_FONTPATH','font/');
require('clases/rpdf.php');
require('funciones/rounded_rect2.php');
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

if(isset($_POST) && $_POST['sendform']!=''){
	$link = conectar();	
	reset ($_POST);
	while (list ($param, $val) = each ($_POST)) {
	    $asignacion = "\$" . $param . "=$link->real_escape_string(\$_POST['" . $param . "']);";
    	eval($asignacion);
	}
	$renewal = str_replace('/','-',$renewal);
	if($type != '2' && $type != '5'){
		$intitution = '';
		$address = '';
		$postal_code = '';
		$vat = '';
	}
	$sql = "INSERT INTO members (name,surname,country,language,phone,email,renewal,quota,type,comment,status,date_arrival,institution,address,postal_code,vat) VALUES ('".$name."','".$surname."','".$country."','".$language."','".$phone."','".$email."','".date("Y-m-d",strtotime($renewal))."','".$quota."','".$type."','".$comment."','".$status."','".date("Y-m-d")."','".$institution."','".$address."','".$postal_code."','".$vat."');";
	$result = $link->query($sql);
	if (!$result) {									
		die('Invalid query: Problems to insert data into the member table ' . $link->error);	
	}
	
	$sql = "SELECT max(cod) FROM members;";
	$result = $link->query($sql);
	$tmp_result = $result->fetch_assoc();
	$cod_max = $tmp_result['max(cod)'];
	
	/********************************************************************************************************/
	/*										GENERAR PDF PARA ADJUNTAR 										*/
	/********************************************************************************************************/
if($send_invoice =="YES"){	
	$link = conectar2();
	$sql = "SELECT body, footer, show_signature FROM invoice WHERE cod='1';";
	$result_pdf = $link->query($sql);
	$aux = $result_pdf->fetch_assoc();
	$message = $aux['body'];
	$footer = quitar_html($aux['footer']);
	$show_signature = ($aux['show_signature']=="YES")?(true):(false);
	$sql = "SELECT * FROM members WHERE cod='".$cod_max."';";
	$result_pdf = $link->query($sql);
	$fila = $result_pdf->fetch_assoc();
	$sql = "DESCRIBE members";
	$r_campos = $link->query($sql);
	$message = quitar_html($message);
	while($aux = $r_campos->fetch_assoc()){
		if($aux['Field']=="renewal"){
			$message = str_replace("{{".$aux['Field']."}}", date("d/m/Y",strtotime($fila[$aux['Field']])), $message);
		}elseif($aux['Field']=="quota"){
			$message = str_replace("{{".$aux['Field']."}}", (number_format($fila[$aux['Field']],2 , "," ,".").' €'), $message);
		}elseif($aux['Field']=="date_arrival"){
			$message = str_replace("{{".$aux['Field']."}}", date("d/m/Y",strtotime($fila[$aux['Field']])), $message);
		}elseif($aux['Field']=="language"){
			$tmp_language = datosreg($fila[$aux['Field']],'language','language','cod');
			$message = str_replace("{{".$aux['Field']."}}", $tmp_language, $message);
		}elseif($aux['Field']=="type"){
			$tmp_type = datosreg($fila[$aux['Field']],'type_member','name','cod');
			$message = str_replace("{{".$aux['Field']."}}", $tmp_type, $message);
		}elseif($aux['Field']=="status"){
			$tmp_status = datosreg($fila[$aux['Field']],'status','status','cod');
			$message = str_replace("{{".$aux['Field']."}}", $tmp_status, $message);
		}elseif($aux['Field']=="country"){
			$tmp_country = datosreg($fila[$aux['Field']],'country','printable_name','iso');
			$message = str_replace("{{".$aux['Field']."}}", $tmp_country, $message);
		}else{
			$message = str_replace("{{".$aux['Field']."}}", $fila[$aux['Field']], $message);
		}
	}
	//echo $message;
	$year = date("Y");
	$sql = "SELECT max(num_invoice) AS num_invoice FROM invoices WHERE year='".$year."';";
	$result = $link->query($sql);
	$aux_invoice = $result->fetch_assoc();
	$num_invoice = ($aux_invoice['num_invoice']=='NULL')?('1'):($aux_invoice['num_invoice']+1);
	//$num_invoice = datosreg('1','parametros','num_invoice','cod');
	
	$sql = "INSERT INTO invoices (num_invoice,year,cod_member,message,quota,date) VALUES ('".$num_invoice."','".$year."','".$cod_max."','".$link->real_escape_string($message)."','".$fila['quota']."','".date("Y-m-d")."');";
	$result = $link->query($sql);
	if (!$result) {	
		die('Invalid query 1: ' . $link->error);	
	}
	
	//Crear el pdf que se enviará.
	class NPDF extends PDF{
		//Cabecera de página
		function Header(){
			//Logo
			//$this->Image('imagenes/nsr-proyectos.jpg',20,12,90);
		}
		//Pie de página
		function Footer(){
			$this->SetY(-20);
			$this->SetTextColor(0, 106, 157);
			$this->Ln(3);
			$this->SetFont('helvetica','',8);
			$this->Cell(170,4,$footer,0,1,'C');
			$this->Cell(0,4,'P'.html_entity_decode("&aacute;").'gina '.$this->PageNo().'/{nb}',0,0,'R');
		}
	}
	
	$pdf=new NPDF('P','mm','A4');
	$pdf->SetMargins(20,24);
	$pdf->AliasNbPages();
	
	
	$pdf->AddPage();
	$pdf->SetFont('arial','B',9);
	$pdf->SetAutoPageBreak(35,2);
	
	//$pdf->image('imagenes/nosolored_fraSL.jpg',20,10);
	$pdf->Image('images/pdf_invoices/logo.png',20,12,90);
		
	$pdf->Ln(2);
	$pdf->SetFont('','B','10');
	$pdf->Cell(0,4,'N'. html_entity_decode("&deg;").' invoice: '.completar($num_invoice,4)."/".$year,0,0,'R');// Variable
			
	$pdf->SetTextColor(0, 106, 157);
	$pdf->Ln(20);
	$pdf->SetFont('helvetica','',8);
	$pdf->MultiCell(0,4,iconv('UTF-8', 'windows-1252', $message));
	
	if($show_signature){
		$pdf->Image('images/pdf_invoices/firma.png');
		$pdf->SetFont('','',7);
		$pdf->TextWithDirection(12,200,$txtreg,'U');
	}
	
	$pdf->Ln(10);
	$pdf->MultiCell(0,4,$footer);
	
	$file="invoice".$year."-".completar($num_invoice,4).".pdf";
	$pdf->Output("invoices/".$file,"F");		
	// Fin de generar pdf
}
		

	
	/********************************************************************************************************/
	/*										ENVIAR E-MAIL AL USUARIO 										*/
	/********************************************************************************************************/
	$link = conectar();
	$sql = "SELECT * FROM members WHERE cod='".$cod_max."';";
	//echo $sql;
	$result_tmp = $link->query($sql);
	$fila = $result_tmp->fetch_assoc();
	
	//ENVIAR E-MAIL
	$cod_language = $language;
	$language = datosreg($cod_language,'language','language','cod');
	//Buscamos la plantilla que le corresponda
	$sql = "SELECT message, subject FROM messages WHERE type='welcome' AND language='".$language."'";
	$r_tmp = $link->query($sql);
	
	if($r_tmp->num_rows>0){
		$f_tmp = $r_tmp->fetch_assoc();
		$message = $f_tmp['message'];
		$subject = $f_tmp['subject'];
		if(trim($message) == ''){
			$default_language = datosreg('1','language','language','vdefault');
			$sql = "SELECT message, subject FROM messages WHERE type='welcome' AND language='".$default_language."'";
			$r2_tmp = $link->query($sql);
			if($r2_tmp->num_rows>0){
				$f2_tmp = $r2_tmp->fetch_assoc();
				$message = $f2_tmp['message'];
				$subject = $f2_tmp['subject'];
				if(trim($message) == ''){
					//Problemas - No hay ninguna plantilla del mensaje - notificamos al administrador 
					$candado = false;					
				}else{
					$candado = true;	
				}
			}else{
				//Problemas - No hay ninguna plantilla del mensaje - notificamos al administrador 
				$candado = false;
			}
		}else{
			//Si hay mensaje en este punto - pasamos a completarlo
			$candado = true;		
		}
	}else{
		//buscamos mensaje por defecto	
		$default_language = datosreg('1','language','language','vdefault');
		$sql = "SELECT message, subject FROM messages WHERE type='welcome' AND language='".$default_language."'";
		$r2_tmp = $link->query($sql);
		if($r2_tmp->num_rows>0){
			$f2_tmp = $r2_tmp->fetch_assoc();
			$message = $f2_tmp['message'];
			$subject = $f2_tmp['subject'];
			if(trim($message) == ''){
				//Problemas - No hay ninguna plantilla del mensaje - notificamos al administrador 
				$candado = false;					
			}else{
				$candado = true;
			}
		}else{
			//Problemas - No hay ninguna plantilla del mensaje - notificamos al administrador 
			$candado = false;
		}
	}
	
	$sql = "SELECT sender FROM parametros";
	$result = $link->query($sql);
	$row_sender = $result->fetch_assoc();
	$sender = $row_sender['sender'];
	

	if($candado){
		$sql = "DESCRIBE members";
		$r_campos = $link->query($sql);
		while($aux = $r_campos->fetch_assoc()){
			if($aux['Field']=="renewal"){
				$message = str_replace("{{".$aux['Field']."}}", date("d/m/Y",strtotime($fila[$aux['Field']])), $message);
			}elseif($aux['Field']=="quota"){
				$message = str_replace("{{".$aux['Field']."}}", (number_format($fila[$aux['Field']],2 , "," ,".").' €'), $message);
			}elseif($aux['Field']=="date_arrival"){
				$message = str_replace("{{".$aux['Field']."}}", date("d/m/Y",strtotime($fila[$aux['Field']])), $message);
			}elseif($aux['Field']=="language"){
				$tmp_language = datosreg($fila[$aux['Field']],'language','language','cod');
				$message = str_replace("{{".$aux['Field']."}}", $tmp_language, $message);
			}elseif($aux['Field']=="type"){
				$tmp_type = datosreg($fila[$aux['Field']],'type_member','name','cod');
				$message = str_replace("{{".$aux['Field']."}}", $tmp_type, $message);
			}elseif($aux['Field']=="status"){
				$tmp_status = datosreg($fila[$aux['Field']],'status','status','cod');
				$message = str_replace("{{".$aux['Field']."}}", $tmp_status, $message);
			}elseif($aux['Field']=="country"){
				$tmp_country = datosreg($fila[$aux['Field']],'country','printable_name','iso');
				$message = str_replace("{{".$aux['Field']."}}", $tmp_country, $message);
			}else{
				$message = str_replace("{{".$aux['Field']."}}", $fila[$aux['Field']], $message);
			}
		}
		$mail = new PHPMailer();
		$mail->Host = "localhost";
		//Estaría bien seleccionar un remitente para que no se pierdan los correos
		$mail->From = $sender;
		$mail->FromName = "Administration Chamilo members";
		$mail->Subject = $subject;
		$mail->AddAddress($email);
		/*$sql = "SELECT responsible FROM responsible WHERE area='renewal';";
		$r_resp = $link->query($sql);
		while($aux = $r_resp->fetch_assoc()){
			//Copia a responsables
			$mail->AddBCC($aux['responsible']);
		}
		*/
		if($send_invoice=="YES"){
			$mail->AddAttachment ("invoices/".$file, $file);
		}
		$mail->CharSet = "UTF-8";
		$body = $message;
		$mail->Body = $body;
		$mail->AltBody = quitar_html($message);
		$mail->Send();
	}else{
		//Notificamos al responsable
		$idioma = datosreg($cod_language,'language','language','cod');
		$mail = new PHPMailer();
		$mail->Host = "localhost";
		//$mail->From = "";
		$mail->FromName = "Administration Chamilo members";
		$mail->Subject = "Problem to send welcome message e-mail";
		
		$sql = "SELECT responsible FROM responsible WHERE area='renewal';";
		$r_resp = $link->query($sql);
		while($aux = $r_resp->fetch_assoc()){
			//Copia a responsables
			$mail->AddAddress($aux['responsible']);
		}
				
		$mail->CharSet = "UTF-8";
		
		
		$body = "The template for the welcome of the ".$idioma." language is not available, and the default template is not available.<br><br>Enter the platform in \"Settings\" section and select \"Message\" tabs to edit the corresponding message.<br><br>Regards";
		$mail->Body = $body;
		$mail->AltBody = quitar_html($message);
		$mail->Send();
	}
	
	
	
	
	
	$_SESSION['info']="Added a new member";
	session_write_close();
	header('Location: http://'.$_SERVER['SERVER_NAME'].'/form_member.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Chamilo - New Members</title>
<meta content="Chamilo - Members Management" name="description">
<!-- We need to emulate IE7 only when we are to use excanvas -->
<!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <![endif]-->
<!-- Favicons -->

<!-- Main Stylesheet -->
<link type="text/css" href="css/style4.css" rel="stylesheet">
<!-- Your Custom Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.17.custom.css" media="screen">

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


<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#renewal").datepicker({
  	    dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true
	});
		
});
</script>


<script src="js/form_member.js" type="text/javascript"></script>

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
</head>
<body>
<!-- Header -->
<header id="top">
<div class="wrapper">
<!-- Title/Logo - can use text instead of image -->
<div id="title">
<img alt="Members Management" src="images/logo.png">
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
<h1>Add new member</h1>
<!-- Quick search box -->
<form method="get" action="">
<input id="q" class="" type="text" name="q">
</form>
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
<h3>Form new member</h3>
<div class="box box-info">All fields are required</div>
<form id="memberform" action="#" method="post">
<fieldset>
<p>
<label class="required" for="name">Name:</label>
<br>
<input id="name" class="half" type="text" name="name" value="">
</p>
<p>
<label class="required" for="surname">Surname:</label>
<br>
<input id="surname" class="half" type="text" name="surname" value="">
</p>
<p>
<label class="required" for="country">Country:</label>
<br>
<select id="country" class="half" name="country">
<option value="">Select country</option>
<?php
$link = conectar();
$sql = "SELECT * FROM country";
$result = $link->query($sql);
while($row = $result->fetch_assoc()){
	echo '<option value="'.$row['iso'].'">'.$row['printable_name'].'</option>';
}
$result->free();
?>
</select>
</p>
<p>
<label class="required" for="language">Language:</label>
<br>
<select id="language" class="half" name="language">
<option value="">Select language</option>
<?php
$link = conectar();
$sql = "SELECT * FROM language WHERE active='1'";
$result = $link->query($sql);
while($row = $result->fetch_assoc()){
	echo '<option value="'.$row['cod'].'">'.$row['language'].'</option>';
}
$result->free();
?>
</select>
</p>
<p>
<label class="required" for="phone">Phone:</label>
<br>
<input id="phone" class="half" type="text" name="phone" value="">
<small>e.g. +34 999 666 333</small>
</p>
<p>
<label class="required" for="email">Email address:</label>
<br>
<input id="email" class="half" type="text" name="email" value="">
</p>
<p>
<label class="required" for="renewal">Renewal Date: (dd/mm/yyyy)</label>
<br>
<input id="renewal" type="text" name="renewal" value="" placeholder="dd/mm/yyyy">
</p>
<p>
<label class="required" for="quota">Quota:</label>
<br>
<input id="quota" class="small" type="text" name="quota" value="" >
</p>
<p>
<label for="send_invoice">Send invoice: </label>
<input id="send_invoice" class="small" type="checkbox" name="send_invoice" value="YES" checked="checked" >
</p>
<p>
<label class="required" for="type">Type of member:</label>
<br>
<select id="type" class="half" name="type">
<option value="">Select type of member</option>
<?php
$link = conectar();
$sql = "SELECT * FROM type_member";
$result = $link->query($sql);
while($row = $result->fetch_assoc()){
	echo '<option value="'.$row['cod'].'">'.$row['name'].'</option>';
}
$result->free();
?>
</select>
</p>
<div id="company" style="display:none">
<p>
<label class="required" for="institution">Institution or company:</label>
<br>
<input id="institution" class="half" type="text" name="institution" disabled="disabled" value="">
</p>
<p>
<label for="address">Address:</label>
<br>
<input id="address" class="half" type="text" name="address" value="">
</p>
<p>
<label  for="postal_code">Postal Code:</label>
<br>
<input id="postal_code" class="half" type="text" name="postal_code" value="">
</p>
<p>
<label for="vat">Vat or ID number:</label>
<br>
<input id="vat" class="half" type="text" name="vat" value="">
</p>
</div>
<p>
<label class="required" for="status">Status:</label>
<br>
<select id="status" class="half" name="status">
<option value="">Select status</option>
<?php
$link = conectar();
$sql = "SELECT * FROM status";
$result = $link->query($sql);
while($row = $result->fetch_assoc()){
	echo '<option value="'.$row['cod'].'">'.$row['status'].'</option>';
}
$result->free();
?>
</select>
</p>
<p>
<label for="area2">Comment:</label>
<br>
<textarea id="comment" class="medium full" name="comment"></textarea>
</p>
<p class="box">
<input class="btn btn-green big" type="submit" name="sendform" value="Validate">
or
<input class="btn" type="reset" value="Reset">
</p>
</fieldset>
</form>

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
