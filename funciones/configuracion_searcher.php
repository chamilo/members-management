<?php
require('../funciones.php');
require('../clases/fpdf.php');
session_start();
define('FPDF_FONTPATH','../font/');
require('../clases/rpdf.php');
require('../funciones/rounded_rect2.php');
session_start();

if ( $_REQUEST['tab'] == 'buscar'){
	$link = conectar();
	reset ($_REQUEST);
	while (list ($param, $val) = each ($_REQUEST)) {
	    $asignacion = "\$" . $param . "=$link->real_escape_string(\$_REQUEST['" . $param . "']);";
    	eval($asignacion);
	}
	
	$filtro = '';
	
	if($name != ''){
		$filtro .= "(name LIKE '%".$name."%' OR surname LIKE '%".$name."%')";
	}
	/*
	if($surname != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "surname LIKE '%".$surname."%'";
	}
	*/
	if($institution != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "institution LIKE '%".$institution."%'";
	}
	
	
	if($email != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "email='".$email."'";
	}
	
	if($country != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "country='".$country."'";
	}
	
	if($phone != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "phone LIKE '%".$phone."%'";
	}
	
	if($quota != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "quota='".$quota."'";
	}
	
	if($type != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "type='".$type."'";
	}
	
	if($status != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "status='".$status."'";
	}
	
	if($language != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "language='".$language."'";
	}
	
	if($renewal_ini != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "UNIX_TIMESTAMP(renewal) >= '".strtotime($renewal_ini)."'";
	}
	
	if($renewal_fin != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "UNIX_TIMESTAMP(renewal) <= '".strtotime($renewal_fin)."'";
	}
	
	if($arrival_ini != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "UNIX_TIMESTAMP(date_arrival) >= '".strtotime($arrival_ini)."'";
	}
	
	if($arrival_fin != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "UNIX_TIMESTAMP(date_arrival) <= '".strtotime($arrival_fin)."'";
	}
	
	if($filtro == ''){
		$filtro .= " 1 ";
	}
	
	$presql = "SELECT * FROM members WHERE ".$filtro.";";

	
	$result = $link->query($presql);
	if (!$result) {
		die('Invalid query: ' . $link->error);
	}
	
	$num_rows = $result->num_rows;
	if($num_rows > 0){
		$contenido = '';
		//$contenido .= '<input type="hidden" id="query_sql" value="'.encriptar($presql).'">';
		$contenido .= '<div class="num_reg">Number of records: <strong>'.$num_rows.'</strong></div>';
		$contenido .= '<a class="btn btn-special" href="exportar-excel.php?query='.urlencode(encriptar($presql)).'" style="float: right; padding: 2px 5px; text-align: center;">Exportar a Excel</a>';
		$contenido .= '<br /><div align="center">';
		$contenido .= '<table class="stylized"  width="100%">';
    	$contenido .= '<tr>
		<th class="name">
		<img class="buscar_campo_ordenado_desc" src="images/down.png" width="16" height="16" border="0" title="Sort Descending" />
		Name
		<img class="buscar_campo_ordenado_asc" src="images/up.png" width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="surname">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Surname
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="email">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		E-mail
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="renewal">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Renewal
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="type">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Member type
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th>Status</th>
		<th>Quota</th>
		<th class="option">Options</th>
		</tr>';
		$sql = "SELECT cod,name FROM type_member;";
		$result_tmp = $link->query($sql);
		$tipos = array();
		while($aux = $result_tmp->fetch_assoc()){
			$tipos[$aux['cod']] = $aux['name'];
		}
		$i = 0;
		while($row = $result->fetch_assoc()){
			$i += 1;
			if($i%2==0){
				$contenido .= '<tr class="campo2">';
			}else{
				$contenido .= '<tr>';
			}
			$contenido .= '<td>'.htmlspecialchars($row['name']).'</td>';
			$contenido .= '<td>'.htmlspecialchars($row['surname']).'</td>';
			$contenido .= '<td>'.htmlspecialchars($row['email']).'</td>';
			$contenido .= '<td class="ta-center">'.date("d/m/Y",strtotime($row['renewal'])).'</td>';
			$contenido .= '<td>'.htmlspecialchars($tipos[$row['type']]).'</td>';
			$contenido .= '<td>'.obtener("status","cod",$row['status'],"status").'</td>';
			$contenido .= '<td>'.htmlspecialchars($row['quota']).' &euro;</td>';
			$contenido .= '<td id="member'.$row['cod'].'" class="options-width">';
			$contenido .= '<a href="renovar-user.php?cod='.$row['cod'].'" title="Renewal" class="renovar"><img src="images/update.png" /></a>&nbsp;';
			$contenido .= '<a href="edit-user.php?cod='.$row['cod'].'" title="Edit '.$row['usuario'].'" class="icon-1 info-tooltip"><img src="images/note_edit.png" /></a>&nbsp;';
			$contenido .= '<a href="delete-user.php?cod='.$row['cod'].'" title="Delete" '.$row['usuario'].'" class="eliminar-usuario"><img src="images/delete.png" /></a>';
			$contenido .= '</td>';
			$contenido .= '</tr>';
			}
		$contenido .= '</table></div>';
				
		$result->free_result();
		//$result2->free_result();
		echo json_encode(array("status"=>"true","contenido"=>$contenido ));		
	}else{
		echo json_encode(array("status"=>"false" ));		
	}
}

if ( $_REQUEST['tab'] == 'buscar_ordenado'){
	$link = conectar();
	reset ($_REQUEST);
	while (list ($param, $val) = each ($_REQUEST)) {
	    $asignacion = "\$" . $param . "=$link->real_escape_string(\$_REQUEST['" . $param . "']);";
    	eval($asignacion);
	}
	
	$filtro = '';
	
	if($name != ''){
		$filtro .= "name LIKE '%".$name."%'";
	}
	
	
	if($surname != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "surname LIKE '%".$surname."%'";
	}
	
	
	if($email != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "email='".$email."'";
	}
	
	if($country != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "country='".$country."'";
	}
	
	if($phone != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "phone LIKE '%".$phone."%'";
	}
	
	if($quota != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "quota='".$quota."'";
	}
	
	if($type != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "type='".$type."'";
	}
	
	if($status != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "status='".$status."'";
	}
	
	if($language != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "language='".$language."'";
	}
	
	if($renewal_ini != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "UNIX_TIMESTAMP(renewal) > '".strtotime($renewal_ini)."'";
	}
	
	if($renewal_fin != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "UNIX_TIMESTAMP(renewal) < '".strtotime($renewal_fin)."'";
	}
	
	if($arrival_ini != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "UNIX_TIMESTAMP(date_arrival) > '".strtotime($arrival_ini)."'";
	}
	
	if($arrival_fin != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= "UNIX_TIMESTAMP(date_arrival) < '".strtotime($arrival_fin)."'";
	}
	
	if($filtro == ''){
		$filtro .= " 1 ";
	}
	
	$presql = "SELECT * FROM members WHERE ".$filtro." ORDER BY ".$campo." ".$orden.";";
	//echo $presql;
	
	$result = $link->query($presql);
	if (!$result) {
		die('Invalid query: ' . $link->error);
	}
	
	$num_rows = $result->num_rows;
	if($num_rows > 0){
		$contenido = '';
		$contenido .= '<div class="num_reg">Number of records: <strong>'.$num_rows.'</strong></div>';
		$contenido .= '<a class="btn btn-special" href="exportar-excel.php?query='.urlencode(encriptar($presql)).'" style="float: right; padding: 2px 5px; text-align: center;">Exportar a Excel</a>';
		$contenido .= '<br /><div align="center">';
		$contenido .= '<table class="stylized"  width="100%">';
    	$contenido .= '<tr>
		<th class="name">
		<img class="buscar_campo_ordenado_desc" src="images/down.png" width="16" height="16" border="0" title="Sort Descending" />
		Name
		<img class="buscar_campo_ordenado_asc" src="images/up.png" width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="surname">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Surname
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="email">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		E-mail
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="renewal">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Renewal
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="type">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Member type
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th>Status</th>
		<th>Quota</th>
		<th class="option">Options</th>
		</tr>';
		$sql = "SELECT cod,name FROM type_member;";
		$result_tmp = $link->query($sql);
		$tipos = array();
		while($aux = $result_tmp->fetch_assoc()){
			$tipos[$aux['cod']] = $aux['name'];
		}
		$i = 0;
		while($row = $result->fetch_assoc()){
			$i += 1;
			if($i%2==0){
				$contenido .= '<tr class="campo2">';
			}else{
				$contenido .= '<tr>';
			}
			$contenido .= '<td>'.htmlspecialchars($row['name']).'</td>';
			$contenido .= '<td>'.htmlspecialchars($row['surname']).'</td>';
			$contenido .= '<td>'.htmlspecialchars($row['email']).'</td>';
			$contenido .= '<td class="ta-center">'.date("d/m/Y",strtotime($row['renewal'])).'</td>';
			$contenido .= '<td>'.htmlspecialchars($tipos[$row['type']]).'</td>';
			$contenido .= '<td>'.obtener("status","cod",$row['status'],"status").'</td>';
			$contenido .= '<td>'.htmlspecialchars($row['quota']).' &euro;</td>';
			$contenido .= '<td id="member'.$row['cod'].'" class="options-width">';
			$contenido .= '<a href="renovar-user.php?cod='.$row['cod'].'" title="Renewal" class="renovar"><img src="images/update.png" /></a>&nbsp;';
			$contenido .= '<a href="edit-user.php?cod='.$row['cod'].'" title="Edit '.$row['usuario'].'" class="icon-1 info-tooltip"><img src="images/note_edit.png" /></a>';
			$contenido .= '<a href="delete-user.php?cod='.$row['cod'].'" title="Delete" '.$row['usuario'].'" class="eliminar-usuario"><img src="images/delete.png" /></a>';
			$contenido .= '</td>';
			$contenido .= '</tr>';
			}
		$contenido .= '</table></div>';
				
		$result->free_result();
		//$result2->free_result();
		echo json_encode(array("status"=>"true","contenido"=>$contenido ));		
	}else{
		echo json_encode(array("status"=>"false" ));		
	}
}

if ( $_REQUEST['tab'] == 'edit_member'){
	$link = conectar();
	$cod = substr($_REQUEST['cod'],6);
	
	$sql = "SELECT * FROM members WHERE cod='".$cod."';";
	$result = $link->query($sql);
	if (!$result) {
		die('Invalid query: ' . $link->error);
	}
	if($result->num_rows > 0 ){
		$row = $result->fetch_assoc();
		$contenido = '';
		$contenido .= '<h3>Form edit member</h3>';
		$contenido .= '<div class="box box-info">All fields are required</div>';
		$contenido .= '<form id="member_edit" action="#" method="post"><fieldset>';
		$contenido .= '<input type="hidden" id="cod" value="'.$cod.'" />';
		$contenido .= '<p><label class="required" for="name">Name:</label><br>';
		$contenido .= '<input id="name" class="half" type="text" name="name" value="'.htmlspecialchars($row['name']).'"></p>';
		$contenido .= '<p><label class="required" for="surname">Surname:</label><br>';
		$contenido .= '<input id="surname" class="half" type="text" name="surname" value="'.htmlspecialchars($row['surname']).'"></p>';
		$contenido .= '<p><label class="required" for="country">Country:</label><br>';
		$contenido .= '<select id="country" class="half" name="country"><option value="">Select country</option>';
		
		$sql = "SELECT * FROM country";
		$result_fila = $link->query($sql);
		while($fila = $result_fila->fetch_assoc()){
			if($fila['iso'] == $row['country']){
				$contenido .= '<option value="'.$fila['iso'].'" selected="selected">'.$fila['printable_name'].'</option>';
			}else{
				$contenido .= '<option value="'.$fila['iso'].'">'.$fila['printable_name'].'</option>';
			}
		}
		$result_fila->free_result();
	
		$contenido .= '</select></p>';
		$contenido .= '<p><label class="required" for="language">Language:</label><br>';
		$contenido .= '<select id="language" class="half" name="language"><option value="">Select language</option>';
		
		$sql = "SELECT * FROM language WHERE active='1'";
		$result_fila = $link->query($sql);
		while($fila = $result_fila->fetch_assoc()){
			if($fila['cod'] == $row['language']){
				$contenido .= '<option value="'.$fila['cod'].'" selected="selected">'.$fila['language'].'</option>';
			}else{
				$contenido .= '<option value="'.$fila['cod'].'">'.$fila['language'].'</option>';
			}
		}
		$result_fila->free_result();
	
		$contenido .= '</select></p>';
		$contenido .= '<p><label class="required" for="phone">Phone:</label><br>';
		$contenido .= '<input id="phone" class="half" type="text" name="phone" value="'.htmlspecialchars($row['phone']).'">';
		$contenido .= '<small>e.g. +34 999 666 333</small></p>';
		$contenido .= '<p><label class="required" for="email">Email address:</label><br>';
		$contenido .= '<input id="email" class="half" type="text" name="email" value="'.htmlspecialchars($row['email']).'"></p>';
		$contenido .= '<p><label class="required" for="renewal2">Renewal Date:</label><br>';
		$contenido .= '<input type="text" name="renewal" id="renewal" value="'.date("d/m/Y",strtotime($row['renewal'])).'" /></p>';
		$contenido .= '<p><label class="required" for="quota">Quota:</label><br>';
		$contenido .= '<input id="quota" class="small" type="text" name="quota" value="'.htmlspecialchars($row['quota']).'"></p>';
		$contenido .= '<p><label class="required" for="type">Type of member:</label><br>';
		
		$contenido .= '<select id="type" class="half" name="type"><option value="">Select type of member</option>';
		$sql = "SELECT * FROM type_member";
		$result_fila = $link->query($sql);
		while($fila = $result_fila->fetch_assoc()){
			if($fila['cod']==$row['type']){
				$contenido .= '<option value="'.$fila['cod'].'" selected="selected">'.$fila['name'].'</option>';
			}else{
				$contenido .= '<option value="'.$fila['cod'].'">'.$fila['name'].'</option>';
			}
		}
		$result_fila->free_result();
		$contenido .= '</select></p>';
		if($row['type']!='2' && $row['type']!='5'){
			$contenido .= '<div id="company" style="display:none">';
		}else{
			$contenido .= '<div id="company">';
		}
		$contenido .= '<p><label class="required" for="institution">Institution or company:</label><br>';
		$contenido .= '<input id="institution" class="half" type="text" name="institution" value="'.htmlspecialchars($row['institution']).'"></p>';
		$contenido .= '<p><label class="required" for="address">Address:</label><br>';
		$contenido .= '<input id="address" class="half" type="text" name="address" value="'.htmlspecialchars($row['address']).'"></p>';
		$contenido .= '<p><label class="required" for="postal_code">Postal Code:</label><br>';
		$contenido .= '<input id="postal_code" class="half" type="text" name="postal_code" value="'.htmlspecialchars($row['postal_code']).'"></p>';
		$contenido .= '<p><label class="required" for="vat">Vat or ID number:</label><br>';
		$contenido .= '<input id="vat" class="half" type="text" name="vat" value="'.htmlspecialchars($row['vat']).'"></p>';
		$contenido .= '</div>';
		$contenido .= '<p><label class="required" for="status">Status:</label><br>';
		$contenido .= '<select id="status" class="half" name="status"><option value="">Select status</option>';
		$sql = "SELECT * FROM status";
		$result_fila = $link->query($sql);
		while($fila = $result_fila->fetch_assoc()){
			if($fila['cod']==$row['status']){
				$contenido .= '<option value="'.$fila['cod'].'" selected="selected">'.$fila['status'].'</option>';
			}else{
				$contenido .= '<option value="'.$fila['cod'].'">'.$fila['status'].'</option>';
			}
		}
		$result_fila->free_result();
	
		$contenido .= '</select></p>';
		$contenido .= '<p><label for="area2">Comment:</label><br>';
		$contenido .= '<textarea id="comment" class="medium full" name="comment">'.htmlspecialchars($row['comment']).'</textarea></p>';
		$contenido .= '<p class="box"><input class="btn btn-green big" type="submit" id="save_edit" name="sendform" value="Save">';
		
		echo json_encode(array("status"=>"true","contenido"=>$contenido ));		
	}else{
		echo json_encode(array("status"=>"false" ));		
	}
}

if ( $_REQUEST['tab'] == 'editar'){
	$link = conectar();
	reset ($_REQUEST);
	while (list ($param, $val) = each ($_REQUEST)) {
	    $asignacion = "\$" . $param . "=$link->real_escape_string(\$_REQUEST['" . $param . "']);";
    	eval($asignacion);
	}
	if($type != '2' && $type != '5'){
		$institution = '';
		$address = '';
		$postal_code = '';
		$vat = '';
	}
	
	$sql = "SELECT renewal,email_renewal,email_expired FROM members WHERE cod='".$cod."'";
	$result = $link->query($sql);
	$row = $result->fetch_assoc();
	if( $row['renewal'] == date("Y-m-d",strtotime($renewal))){
		$email_renewal = $row['email_renewal'];
		$email_expired = $row['email_expired'];
		if($row['email_renewal'] == '1'){
			$notice_email = "Yes";
		}else{
			$notice_email = "No";
		}
	}else{
		$email_renewal = 0;
		$email_expired = 0;
		$notice_email = "No";
	}
	
	$sql = "UPDATE members SET 
			name='".$name."',
			surname='".$surname."',
			country='".$country."',
			language='".$language."',
			phone='".$phone."',
			email='".$email."',
			renewal='".date("Y-m-d",strtotime($renewal))."',
			email_renewal='".$email_renewal."',
			email_expired='".$email_expired."',
			quota='".$quota."',
			type='".$type."',
			comment='".$comment."',
			status='".$status."', 
			institution='".$institution."', 
			address='".$address."', 
			postal_code='".$postal_code."', 
			vat='".$vat."' 
			WHERE cod='".$cod."'";
	//echo $sql;
	$result = $link->query($sql);
	if (!$result) {									
		die('Invalid query: Problems to insert data into the member table ' . $link->error);	
	}
	$sql = "SELECT name FROM type_member WHERE cod='".$type."'";
	$result = $link->query($sql);
	$aux = $result->fetch_assoc();
	
	$status_name = obtener("status","cod",$status,"status");
	echo json_encode(array("status"=>"true","name"=>$name,"surname"=>$surname,"email"=>$email,"cod"=>"member".$cod,"renewal"=>date("d/m/Y",strtotime($renewal)),"type"=>$aux['name'],"quota"=>$quota,"status"=>$status_name,"notice_email"=>$notice_email));	
}

if ( $_REQUEST['tab'] == 'renovar_miembro'){
	$link = conectar();
	$cod = substr($_REQUEST['cod'],6);
	$fecha_renovacion = strtotime(obtener("members","cod",$cod,"renewal"));
	if($fecha_renovacion > time()){
		// a la fecha se le suma 1 año
		$sql = "SELECT DATE_ADD(renewal,INTERVAL 1 YEAR) AS renewal FROM members WHERE cod='".$cod."';";
		$result = $link->query($sql);
		$aux = $result->fetch_assoc();
		$fecha = $aux['renewal'];
	}else{
		// la fecha actual mas un año
		$fecha = date('Y-m-d', strtotime('+1 year')) ; // suma 1 año
	}
	
	
	
	$sql = "UPDATE members SET renewal='".$fecha."', mark_renewal='".date("Y-m-d")."', email_renewal='0', email_expired='0', status='1' WHERE cod='".$cod."'";
	$result = $link->query($sql);
	if (!$result) {	
		echo json_encode(array("status"=>"false"));
		die('Invalid query: Problems to insert data into the member table ' . $link->error);	
	}else{
		$link = conectar();
		$sql = "SELECT body, footer, show_signature FROM invoice WHERE cod='1';";
		$result = $link->query($sql);
		$aux = $result->fetch_assoc();
		$message = $aux['body'];
		$footer = quitar_html($aux['footer']);
		$show_signature = ($aux['show_signature']=="YES")?(true):(false);
		$sql = "SELECT * FROM members WHERE cod='".$cod."';";
		$result = $link->query($sql);
		$fila = $result->fetch_assoc();
		$sql = "DESCRIBE members";
		$r_campos = $link->query($sql);
		$message = quitar_html($message);
		while($aux = $r_campos->fetch_assoc()){
			if($aux['Field']=="renewal"){
				$message = str_replace("{{".$aux['Field']."}}", date("d/m/Y",strtotime($fila[$aux['Field']])), $message);
			}elseif($aux['Field']=="quota"){
				$message = str_replace("{{".$aux['Field']."}}", (number_format($fila[$aux['Field']],2 , "," ,".").' €'), $message);
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
		
		$sql = "INSERT INTO invoices (num_invoice,year,cod_member,message,quota,date) VALUES ('".$num_invoice."','".$year."','".$cod."','".$link->real_escape_string($message)."','".$fila['quota']."','".date("Y-m-d")."');";
		$result = $link->query($sql);
		if (!$result) {	
			die('Invalid query 1: ' . $link->error);	
		}
		
		/*
		$sql = "UPDATE parametros SET num_invoice = (num_invoice + 1) WHERE cod='1';";
		$result = $link->query($sql);
		if (!$result) {	
			die('Invalid query 2: ' . $link->error);	
		}
		*/
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
				$this->Cell(0,4,'Page '.$this->PageNo().'/{nb}',0,0,'R');
			}
		}
		
		$pdf=new NPDF('P','mm','A4');
		$pdf->SetMargins(20,24);
		$pdf->AliasNbPages();
		
		
		$pdf->AddPage();
		$pdf->SetFont('arial','B',9);
		$pdf->SetAutoPageBreak(35,2);
		
		//$pdf->image('imagenes/nosolored_fraSL.jpg',20,10);
		$pdf->Image('../images/pdf_invoices/logo.png',20,12,90);
			
		$pdf->Ln(2);
		$pdf->SetFont('','B','10');
		$pdf->Cell(0,4,'Num. invoice: '.completar($num_invoice,4)."/".$year,0,0,'R');// Variable
				
		$pdf->SetTextColor(0, 106, 157);
		$pdf->Ln(20);
		$pdf->SetFont('helvetica','',8);
		$pdf->MultiCell(0,4,$message);
		
		if($show_signature){
			$pdf->Image('../images/pdf_invoices/firma.png');
			$pdf->SetFont('','',7);
			$pdf->TextWithDirection(12,200,$txtreg,'U');
		}
		
		$pdf->Ln(10);
		$pdf->MultiCell(0,4,$footer);
		
		$file="invoice".$year."-".completar($num_invoice,4).".pdf";
		$pdf->Output("../invoices/".$file,"F");		
		// Fin de generar pdf
		
		
		
	//ENVIAR E-MAIL
	$language = obtener("language","cod",$fila['language'],"language");
		//Buscamos la plantilla que le corresponda
	$sql = "SELECT message, subject FROM messages WHERE type='renewed' AND language='".$language."'";
	$r_tmp = $link->query($sql);
	if($r_tmp->num_rows>0){
		$f_tmp = $r_tmp->fetch_assoc();
		$message = $f_tmp['message'];
		$subject = $f_tmp['subject'];
		if(trim($message) == ''){
			
			$default_language = obtener("language","vdefault","1","language");
			$sql = "SELECT message, subject FROM messages WHERE type='renewed' AND language='".$default_language."'";
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
		$sql = "SELECT message, subject FROM messages WHERE type='renewed' AND language='".$default_language."'";
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
		$mail->AddAttachment ("../invoices/".$file, $file);
		
		$mail->CharSet = "UTF-8";
		
		$body = $message;
		$mail->Body = $body;
		$mail->AltBody = quitar_html($message);
		$mail->Send();
	}else{
		//Notificamos al responsable
		$idioma = obtener("language","cod",$fila['language'],"language");
		$mail = new PHPMailer();
		$mail->Host = "localhost";
		//$mail->From = "";
		$mail->FromName = "Administration Chamilo members";
		$mail->Subject = "Problem to send renewed notice e-mail";
		
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
	//FIN ENVIAR E-MAIL
		echo json_encode(array("status"=>"true","cod"=>"member".$cod,"renewal"=>date("d/m/Y",strtotime($fecha))));	
	}
}

if ( $_REQUEST['tab'] == 'eliminar_usuario'){
	$link = conectar();
	$cod = substr($_REQUEST['cod'],6);
	
	$presql = "DELETE FROM members WHERE cod ='".$cod."';";

	$result = $link->query($presql);
	if (!$result) {
		echo json_encode(array("status"=>"false"));
		die('Invalid query: ' . $link->error);
	}
	echo json_encode(array("status"=>"true","cod"=>"member".$cod));

	$link->close();
}


if ( $_REQUEST['tab'] == 'recordar_correo'){
	$link = conectar();
	$correo = $_REQUEST['email'];
	$pass = texto_aleatorio(5);
	global $saltt;
				
	$sql = "UPDATE users SET pass='".sha1($saltt.md5($pass))."' WHERE email='".$correo."';";
	$result2 = $link->query($sql);
	if (!$result2) {
		die('Invalid query: ' . $link->error);
		$contenido = "Error al actualizar las claves";
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
		$contenido = "Sent new passwords to your email ".htmlspecialchars($row['email']);
	}else{
		$contenido = "Error sending mail: the mail is not in the database";	
	}
	echo json_encode(array("contenido"=>$contenido ));
}
	
?>