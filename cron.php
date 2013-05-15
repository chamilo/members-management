<?php	
// Funciones de conexión con la base de dato
require 'funciones.php';
//error_reporting(E_ALL);
$link = conectar();

//ENVIO DE E-MAIL QUE ESTÁN PROXIMOS A LA FECHA DE RENOVACIÓN
$sql = "SELECT notice_renewal,sender FROM parametros";
$result = mysql_query($sql,$link);
$row = mysql_fetch_assoc($result);
$dias = $row['notice_renewal'];
$sender = $row['sender'];

mysql_free_result($result);

$limite = $dias*24*60*60;

$sql = "SELECT * FROM members WHERE (UNIX_TIMESTAMP(renewal) - UNIX_TIMESTAMP(NOW())) < ".$limite." AND email_renewal='0';";
//echo $sql;
//echo $limite;
$result = mysql_query($sql,$link);
echo "<br><br>Begin of renewal notice";
while($fila = mysql_fetch_assoc($result)){
	$candado = false;
	$mensaje = '';
	$subject = '';
	echo "<br>Renewal notice for: ".$fila['email'];
	$language = datosreg($fila['language'],'language','language','cod');
	//Buscamos la plantilla que le corresponda
	$sql = "SELECT message, subject FROM messages WHERE type='renewal' AND language='".$language."'";
	$r_tmp = mysql_query($sql,$link);
	
	if(mysql_num_rows($r_tmp)>0){
		$f_tmp = mysql_fetch_assoc($r_tmp);
		$message = $f_tmp['message'];
		$subject = $f_tmp['subject'];
		if(trim($message) == ''){
			$default_language = datosreg('1','language','language','vdefault');
			$sql = "SELECT message, subject FROM messages WHERE type='renewal' AND language='".$default_language."'";
			$r2_tmp = mysql_query($sql,$link);
			if(mysql_num_rows($r2_tmp)>0){
				$f2_tmp = mysql_fetch_assoc($r2_tmp);
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
		$sql = "SELECT message, subject FROM messages WHERE type='renewal' AND language='".$default_language."'";
		$r2_tmp = mysql_query($sql,$link);
		if(mysql_num_rows($r2_tmp)>0){
			$f2_tmp = mysql_fetch_assoc($r2_tmp);
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
	
	if($candado){
		$sql = "DESCRIBE members";
		$r_campos = mysql_query($sql,$link);
		while($aux = mysql_fetch_assoc($r_campos)){
			if($aux['Field']=="renewal"){
				$message = str_replace("{{".$aux['Field']."}}", date("d/m/Y",strtotime($fila[$aux['Field']])), $message);
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
		$mail->AddAddress($fila['email']);
		$sql = "SELECT responsible FROM responsible WHERE area='renewal';";
		$r_resp = mysql_query($sql,$link);
		while($aux = mysql_fetch_assoc($r_resp)){
			//Copia a responsables
			$mail->AddBCC($aux['responsible']);
		}
		
		$mail->CharSet = "UTF-8";
		
		$body = $message;
		$mail->Body = $body;
		$mail->AltBody = quitar_html($message);
		$mail->Send();
		//Actualizamos la tabla de miembros
		$sql = "UPDATE members SET email_renewal='1' WHERE cod='".$fila['cod']."';";
		mysql_query($sql,$link);
				
	}else{
		//Notificamos al responsable
		$idioma = datosreg($fila['language'],'language','language','cod');
		echo " ---> Problem template - ".$idioma;
		$mail = new PHPMailer();
		$mail->Host = "localhost";
		//$mail->From = "";
		$mail->FromName = "Administration Chamilo members";
		$mail->Subject = "Problem to send renewal notice e-mail";
		
		$sql = "SELECT responsible FROM responsible WHERE area='renewal';";
		$r_resp = mysql_query($sql,$link);
		while($aux = mysql_fetch_assoc($r_resp)){
			//Copia a responsables
			$mail->AddAddress($aux['responsible']);
		}
		
		$mail->CharSet = "UTF-8";
		
		
		$body = "The template for the renewal of the ".$idioma." language is not available, and the default template is not available.<br><br>Enter the platform in \"Settings\" section and select \"Message\" tabs to edit the corresponding message.<br><br>Regards";
		$mail->Body = $body;
		$mail->AltBody = quitar_html($message);
		$mail->Send();
	}	
	
}
mysql_free_result($result);
echo "<br>End of renewal notice";
echo "<br><br>Begin of expiration notice";
// ENVIO DE E-MAIL QUE HAN SIDO EXPIRADOS

$sql = "SELECT * FROM members WHERE (UNIX_TIMESTAMP(renewal) - UNIX_TIMESTAMP(NOW())) < 0 AND email_expired='0';";
$result = mysql_query($sql,$link);
while($fila = mysql_fetch_assoc($result)){
	$candado = false;
	$mensaje = '';
	$subject = '';
	echo "<br>Expiration notice for: ".$fila['email'];
	$language = datosreg($fila['language'],'language','language','cod');
	//Buscamos la plantilla que le corresponda
	$sql = "SELECT message, subject FROM messages WHERE type='expired' AND language='".$language."'";
	$r_tmp = mysql_query($sql,$link);
	
	if(mysql_num_rows($r_tmp)>0){
		$f_tmp = mysql_fetch_assoc($r_tmp);
		$message = $f_tmp['message'];
		$subject = $f_tmp['subject'];
		if(trim($message) == ''){
			$default_language = datosreg('1','language','language','vdefault');
			$sql = "SELECT message, subject FROM messages WHERE type='expired' AND language='".$default_language."'";
			$r2_tmp = mysql_query($sql,$link);
			if(mysql_num_rows($r2_tmp)>0){
				$f2_tmp = mysql_fetch_assoc($r2_tmp);
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
		$sql = "SELECT message, subject FROM messages WHERE type='expired' AND language='".$default_language."'";
		$r2_tmp = mysql_query($sql,$link);
		if(mysql_num_rows($r2_tmp)>0){
			$f2_tmp = mysql_fetch_assoc($r2_tmp);
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
	
	if($candado){
		$sql = "DESCRIBE members";
		$r_campos = mysql_query($sql,$link);
		while($aux = mysql_fetch_assoc($r_campos)){
			if($aux['Field']=="renewal"){
				$message = str_replace("{{".$aux['Field']."}}", date("d/m/Y",strtotime($fila[$aux['Field']])), $message);
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
		$mail->AddAddress($fila['email']);
		$sql = "SELECT responsible FROM responsible WHERE area='expired';";
		$r_resp = mysql_query($sql,$link);
		while($aux = mysql_fetch_assoc($r_resp)){
			//Copia a responsables
			$mail->AddBCC($aux['responsible']);
		}
		
		$mail->CharSet = "UTF-8";
		
		$body = $message;
		$mail->Body = $body;
		$mail->AltBody = quitar_html($message);
		$mail->Send();
		//Actualizamos la tabla de miembros
		$sql = "UPDATE members SET email_expired='1', status='2' WHERE cod='".$fila['cod']."';";
		mysql_query($sql,$link);
				
	}else{
		//Notificamos al responsable
		$idioma = datosreg($fila['language'],'language','language','cod');
		echo " ---> Problem template - ".$idioma;
		$mail = new PHPMailer();
		$mail->Host = "localhost";
		//$mail->From = "";
		$mail->FromName = "Administration Chamilo members";
		$mail->Subject = "Problem to send expiration notice e-mail";
		
		$sql = "SELECT responsible FROM responsible WHERE area='renewal';";
		$r_resp = mysql_query($sql,$link);
		while($aux = mysql_fetch_assoc($r_resp)){
			//Copia a responsables
			$mail->AddAddress($aux['responsible']);
		}
		
		$mail->CharSet = "UTF-8";
		
		
		$body = "The template for the expiration notice of the ".$idioma." language is not available, and the default template is not available.<br><br>Enter the platform in \"Settings\" section and select \"Message\" tabs to edit the corresponding message.<br><br>Regards";
		$mail->Body = $body;
		$mail->AltBody = quitar_html($message);
		$mail->Send();
	}	
}
echo "<br>End of expiration notice";
mysql_free_result($result);
mysql_close($link);

?>
