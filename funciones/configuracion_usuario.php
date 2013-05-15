<?php
include ("../funciones.php");
session_start();
/*
if ( $_REQUEST['tab'] == 'buscar'){
	$link = conectar();
	$usuario = $_REQUEST['usuario'];
	$email = $_REQUEST['email'];
	
	$filtro = 'activo="SI" AND cod<>"1" ';
	if($usuario != ''){
		$filtro .= "AND usuario LIKE '%".$usuario."%'";
	}
	
	if($email != ''){
		$filtro .= "AND email='".$email."'";
	}
		
	$presql = "SELECT * FROM seg_usuarios WHERE ".$filtro.";";
	
	$result = mysql_query($presql,$link);
	if (!$result) {
		die('Invalid query: ' . mysql_error());
	}
	
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0){
		$contenido = '<br /><div align="center">';
		$contenido .= '<table border="0" width="90%" id="tbl_buscarusuario">';
    	$contenido .= '<tr>
		<th class="usuario">
		<img class="buscar_usuario_ordenado_desc" src="images/down.png" align="left" width="16" height="16" border="0" title="Ordenar Descendente" />
		Usuario
		<img class="buscar_usuario_ordenado_asc" src="images/up.png" align="right" width="16" height="16" border="0" title="Ordenar Ascendente" />
		</th>
		<th class="email">
		<img class="buscar_usuario_ordenado_desc" src="images/down.png" align="left" width="16" height="16" border="0" title="Ordenar Descendente" />
		Correo electr&oacute;nico
		<img class="buscar_usuario_ordenado_asc" src="images/up.png" align="right" width="16" height="16" border="0" title="Ordenar Ascendente" />
		</th>
		<th>Opciones</th>
		</tr>';
		$i = 0;
		while($row = mysql_fetch_assoc($result)){
			$i += 1;
			if($i%2==0){
				$contenido .= '<tr class="campo2">';
			}else{
				$contenido .= '<tr>';
			}
			$contenido .= '<td>'.$row['usuario'].'</td>';
			$contenido .= '<td>'.$row['email'].'</td>';
			$contenido .= '<td id="'.$row['cod'].'" class="options-width">';
			$contenido .= '<a href="editar-usuario.php?cod='.$row['cod'].'" title="Editar '.$row['usuario'].'" class="icon-1 info-tooltip"></a>';
			$contenido .= '<a href="eliminar-usuario.php?cod='.$row['cod'].'" title="Eliminar '.$row['usuario'].'" class="icon-2 info-tooltip eliminar-usuario"></a>';
			$contenido .= '</td>';
			$contenido .= '</tr>';
			}
		$contenido .= '</table></div>';
				
		mysql_free_result($result);
		//mysql_free_result($result2);
		echo json_encode(array("status"=>"true","contenido"=>$contenido ));		
	}else{
		$contenido = "No hay usuarios activos, cree uno nuevo antes de cerrar la sesion";
		echo json_encode(array("status"=>"false","contenido"=>$contenido ));		
	}
}

if ( $_REQUEST['tab'] == 'eliminar_usuario'){
	$link = conectar();
	$cod = $_REQUEST['cod'];
	
	$presql = "UPDATE seg_usuarios SET activo='NO' WHERE cod = $cod";

	$result = mysql_query($presql,$link);
	if (!$result) {
		die('Invalid query: ' . mysql_error());
	}
	echo json_encode(array("status"=>"true"));

	mysql_close($link);
}


if ( $_REQUEST['tab'] == 'buscar_ordenado'){
	$link = conectar();
	$usuario = $_REQUEST['usuario'];
	$email = $_REQUEST['email'];
	$orden = "ORDER BY ".$_REQUEST['campo']." ".$_REQUEST['orden'];
	
	$filtro = 'activo="SI" AND a.cod<>"1" ';
	if($usuario != ''){
		$filtro .= " AND usuario LIKE '%".$usuario."%' ";
	}
	
	if($perfil != ''){
		$filtro .= " AND email='".$email."' ";
	}
	
	$presql = "SELECT * FROM seg_usuarios AS a WHERE ".$filtro." ".$orden.";";
	
	//echo $presql;
	$result = mysql_query($presql,$link);
	if (!$result) {
		die('Invalid query: ' . mysql_error());
	}
	
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0){
		$contenido = '<br /><div align="center">';
		$contenido .= '<table border="0" width="90%" id="tbl_buscarusuario">';
    	$contenido .= '<tr>
		<th class="usuario">
		<img class="buscar_usuario_ordenado_desc" src="images/down.png" align="left" width="16" height="16" border="0" title="Ordenar Descendente" />
		Usuario
		<img class="buscar_usuario_ordenado_asc" src="images/up.png" align="right" width="16" height="16" border="0" title="Ordenar Ascendente" />
		</th>
		<th class="email">
		<img class="buscar_usuario_ordenado_desc" src="images/down.png" align="left" width="16" height="16" border="0" title="Ordenar Descendente" />
		Correo electr&oacute;nico
		<img class="buscar_usuario_ordenado_asc" src="images/up.png" align="right" width="16" height="16" border="0" title="Ordenar Ascendente" />
		</th>
		<th>Opciones</th>
		</tr>';
		$i = 0;
		while($row = mysql_fetch_assoc($result)){
			$i += 1;
			if($i%2==0){
				$contenido .= '<tr class="campo2">';
			}else{
				$contenido .= '<tr>';
			}
			$contenido .= '<td>'.$row['usuario'].'</td>';
			$contenido .= '<td>'.$row['email'].'</td>';
			$contenido .= '<td id="'.$row['cod'].'" class="options-width">';
			$contenido .= '<a href="editar-usuario.php?cod='.$row['cod'].'" title="Editar '.$row['usuario'].'" class="icon-1 info-tooltip"></a>';
			$contenido .= '<a href="eliminar-usuario.php?cod='.$row['cod'].'" title="Eliminar '.$row['usuario'].'" class="icon-2 info-tooltip eliminar-usuario"></a>';
			$contenido .= '</td>';
			$contenido .= '</tr>';
			}
		$contenido .= '</table></div>';
				
		mysql_free_result($result);
		//mysql_free_result($result2);
		echo json_encode(array("status"=>"true","contenido"=>$contenido ));		
	}else{
		$contenido = "No hay usuarios activos, cree uno nuevo antes de cerrar la sesion";
		echo json_encode(array("status"=>"false","contenido"=>$contenido ));		
	}
}
*/

if ( $_REQUEST['tab'] == 'recordar_correo'){
	$link = conectar();
	$correo = $_REQUEST['email'];
	$pass = texto_aleatorio(5);
	global $saltt;
	
	$sql = "UPDATE users SET pass='".sha1($saltt.md5($pass))."' WHERE email='".$correo."';";
	$result2 = mysql_query($sql,$link);
	if (!$result2) {
		die('Invalid query: ' . mysql_error());
		$contenido = "Error update password";
		echo json_encode(array("status"=>"false","contenido"=>$contenido ));	
	}
	
	$presql = "SELECT * FROM users WHERE email='".$correo."'";
	$result = mysql_query($presql,$link);
	if (!$result) {
		die('Invalid query: ' . mysql_error());
	}
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0){
		$row = mysql_fetch_assoc($result);
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