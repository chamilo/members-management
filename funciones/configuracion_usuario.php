<?php
include ("../funciones.php");
session_start();

if ( $_REQUEST['tab'] == 'recordar_correo'){
	$link = conectar();
	$correo = $_REQUEST['email'];
	$pass = texto_aleatorio(5);
	global $saltt;
	
	$sql = "UPDATE users SET pass='".sha1($saltt.md5($pass))."' WHERE email='".$correo."';";
	$result2 = $link->query($sql);
	if (!$result2) {
		die('Invalid query: ' . $link->error);
		$contenido = "Error update password";
		echo json_encode(array("status"=>"false","contenido"=>$contenido ));	
	}
	
	$presql = "SELECT * FROM users WHERE email='".$correo."'";
	$result = $link->query($presql);
	if (!$result) {
		die('Invalid query: ' . $link->error);
	}
	$num_rows = $result->num_rows;
	if($num_rows > 0){
		$row = $result->fetch_assoc();
		//Mandar correo con nueva clave
		//Email para el usuario de confirmación de pedido
		$mail = new PHPMailer();
		$mail->Host = "localhost";
		//$mail->From = "";
		$mail->FromName = "Administration Chamilo members";
		$mail->Subject = "Send new password";
		$mail->AddAddress($correo);
		$mail->CharSet = "UTF-8";
		
		$body = "<h1>Administration Chamilo members</h1>";
		$body .= "Access data are: <br />";
		$body .= "User: <strong>".htmlspecialchars($row['user'])."</strong><br />";
		$body .= "Password: <strong>".htmlspecialchars($pass)."</strong><br />";
		$mail->Body = $body;
		$mail->AltBody = "User: <strong>".htmlspecialchars($row['user'])."</strong> Password: <strong>".htmlspecialchars($pass)."</strong>";
		$mail->Send();
		//Notificar en $_SESSION['info']
		$contenido = "Sent new passwords to your email ".$row['email'];
	}else{
		$contenido = "Error sending mail: the mail is not in the database";	
	}
	echo json_encode(array("contenido"=>$contenido ));
}
	
?>