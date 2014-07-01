<?php	
// Funciones de conexión con la base de dato
require 'funciones.php';
//error_reporting(E_ALL);
$link = conectar();

//ENVIO DE E-MAIL QUE ESTÁN PROXIMOS A LA FECHA DE RENOVACIÓN
$sql = "SELECT notice_renewal,sender FROM parametros";
$result = $link->query($sql);
$row = $result->fetch_assoc();
$dias = $row['notice_renewal'];
$sender = $row['sender'];

$result->free();

$limite = $dias*24*60*60;

$sql = "SELECT * FROM members WHERE (UNIX_TIMESTAMP(renewal) - UNIX_TIMESTAMP(NOW())) < ".$limite." AND email_renewal='0';";
//echo $sql;
//echo $limite;
$result = $link->query($sql);
echo "<br><br>Begin of renewal notice";
while($fila = $result->fetch_assoc()){
	$candado = false;
	$mensaje = '';
	$subject = '';
	echo "<br>Renewal notice for: ".$fila['email'];
	$language = obtener("language","cod",$fila['language'],"language");
	//Buscamos la plantilla que le corresponda
	$sql = "SELECT message, subject FROM messages WHERE type='renewal' AND language='".$language."'";
	$r_tmp = $link->query($sql);
	
	if($r_tmp->num_rows>0){
		$f_tmp = $r_tmp->fetch_assoc();
		$message = $f_tmp['message'];
		$subject = $f_tmp['subject'];
		if(trim($message) == ''){
			$default_language = obtener("language","vdefault","1","language");
			$sql = "SELECT message, subject FROM messages WHERE type='renewal' AND language='".$default_language."'";
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
		$default_language = obtener("language","vdefault","1","language");
		$sql = "SELECT message, subject FROM messages WHERE type='renewal' AND language='".$default_language."'";
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
	
	if($candado){
		$sql = "DESCRIBE members";
		$r_campos = $link->query($sql);
		while($aux = $r_campos->fetch_assoc()){
			if($aux['Field']=="renewal"){
				$message = str_replace("{{".$aux['Field']."}}", date("d/m/Y",strtotime($fila[$aux['Field']])), $message);
			}elseif($aux['Field']=="quota"){
			  $message = str_replace("{{".$aux['Field']."}}", (number_format($fila[$aux['Field']],2 , "," ,".")), $message);
			}elseif($aux['Field']=="date_arrival"){
				$message = str_replace("{{".$aux['Field']."}}", date("d/m/Y",strtotime($fila[$aux['Field']])), $message);
			}elseif($aux['Field']=="language"){
				$tmp_language = obtener("language","cod",$fila[$aux['Field']],"language");
				$message = str_replace("{{".$aux['Field']."}}", $tmp_language, $message);
			}elseif($aux['Field']=="type"){
				$tmp_type = obtener("type_member","cod",$fila[$aux['Field']],"name");
				$message = str_replace("{{".$aux['Field']."}}", $tmp_type, $message);
			}elseif($aux['Field']=="status"){
				$tmp_status = obtener("status","cod",$fila[$aux['Field']],"status");
				$message = str_replace("{{".$aux['Field']."}}", $tmp_status, $message);
			}elseif($aux['Field']=="country"){
				$tmp_country = obtener("country","iso",$fila[$aux['Field']],"printable_name");
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
		$mail->AddAddress($fila['email']);
		$sql = "SELECT responsible FROM responsible WHERE area='renewal';";
		$r_resp = $link->query($sql);
		while($aux = $r_resp->fetch_assoc()){
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
		$link->query($sql);
				
	}else{
		//Notificamos al responsable
		$idioma = obtener("language","cod",$fila['language'],"language");
		echo " ---> Problem template - ".$idioma;
		$mail = new PHPMailer();
		$mail->Host = "localhost";
		//$mail->From = "";
		$mail->FromName = "Administration Chamilo members";
		$mail->Subject = "Problem to send renewal notice e-mail";
		
		$sql = "SELECT responsible FROM responsible WHERE area='renewal';";
		$r_resp = $link->query($sql);
		while($aux = $r_resp->fetch_assoc()){
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
$result->free();
echo "<br>End of renewal notice";
echo "<br><br>Begin of expiration notice";
// ENVIO DE E-MAIL QUE HAN SIDO EXPIRADOS

$sql = "SELECT * FROM members WHERE (UNIX_TIMESTAMP(renewal) - UNIX_TIMESTAMP(NOW())) < 0 AND email_expired='0';";
$result = $link->query($sql);
while($fila = $result->fetch_assoc()){
	$candado = false;
	$mensaje = '';
	$subject = '';
	echo "<br>Expiration notice for: ".$fila['email'];
	$language = obtener("language","cod",$fila['language'],"language");
	//Buscamos la plantilla que le corresponda
	$sql = "SELECT message, subject FROM messages WHERE type='expired' AND language='".$language."'";
	$r_tmp = $link->query($sql);
	
	if($r_tmp->num_rows>0){
		$f_tmp = $r_tmp->fetch_assoc();
		$message = $f_tmp['message'];
		$subject = $f_tmp['subject'];
		if(trim($message) == ''){
			$default_language = obtener("language","vdefault","1","language");
			$sql = "SELECT message, subject FROM messages WHERE type='expired' AND language='".$default_language."'";
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
		$default_language = obtener("language","vdefault","1","language");
		$sql = "SELECT message, subject FROM messages WHERE type='expired' AND language='".$default_language."'";
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
	
	if($candado){
		$sql = "DESCRIBE members";
		$r_campos = $link->query($sql);
		while($aux = $r_campos->fetch_assoc()){
			if($aux['Field']=="renewal"){
				$message = str_replace("{{".$aux['Field']."}}", date("d/m/Y",strtotime($fila[$aux['Field']])), $message);
			}elseif($aux['Field']=="quota"){
				$message = str_replace("{{".$aux['Field']."}}", (number_format($fila[$aux['Field']],2 , "," ,".")), $message);
			}elseif($aux['Field']=="date_arrival"){
				$message = str_replace("{{".$aux['Field']."}}", date("d/m/Y",strtotime($fila[$aux['Field']])), $message);
			}elseif($aux['Field']=="language"){
				$tmp_language = obtener("language","cod",$fila[$aux['Field']],"language");
				$message = str_replace("{{".$aux['Field']."}}", $tmp_language, $message);
			}elseif($aux['Field']=="type"){
				$tmp_type = obtener("type_member","cod",$fila[$aux['Field']],"name");
				$message = str_replace("{{".$aux['Field']."}}", $tmp_type, $message);
			}elseif($aux['Field']=="status"){
				$tmp_status = obtener("status","cod",$fila[$aux['Field']],"status");
				$message = str_replace("{{".$aux['Field']."}}", $tmp_status, $message);
			}elseif($aux['Field']=="country"){
				$tmp_country = obtener("country","iso",$fila[$aux['Field']],"printable_name");
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
		$mail->AddAddress($fila['email']);
		$sql = "SELECT responsible FROM responsible WHERE area='expired';";
		$r_resp = $link->query($sql);
		while($aux = $r_resp->fetch_assoc()){
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
		$link->query($sql);
				
	}else{
		//Notificamos al responsable
		$idioma = obtener("language","cod",$fila['language'],"language");
		echo " ---> Problem template - ".$idioma;
		$mail = new PHPMailer();
		$mail->Host = "localhost";
		//$mail->From = "";
		$mail->FromName = "Administration Chamilo members";
		$mail->Subject = "Problem to send expiration notice e-mail";
		
		$sql = "SELECT responsible FROM responsible WHERE area='renewal';";
		$r_resp = $link->query($sql);
		while($aux = $r_resp->fetch_assoc()){
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
$result->free();
$link->close();

?>
