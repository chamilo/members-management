<?php
include ("../funciones.php");
session_start();

if ( $_REQUEST['tab'] == 'buscar_user'){
	$link = conectar();
	reset ($_REQUEST);
	while (list ($param, $val) = each ($_REQUEST)) {
	    $asignacion = "\$" . $param . "=$link->real_escape_string(\$_REQUEST['" . $param . "']);";
    	eval($asignacion);
	}
	
	$filtro = '';
	
	if($campo != ''){
		$filtro .= "user LIKE '%".$campo."%' OR name LIKE '%".$campo."%' OR email LIKE '%".$campo."%'";
	}
		
	if($filtro == ''){
		$filtro .= " 1 ";
	}
	
	$presql = "SELECT * FROM users WHERE ".$filtro.";";
	//echo $presql;
	
	$result = $link->query($presql);
	if (!$result) {
		die('Invalid query: ' . $link->error);
	}
	
	$num_rows = $result->num_rows;
	if($num_rows > 0){
		$contenido = '<br /><div align="center">';
		$contenido .= '<table class="stylized"  width="100%">';
    	$contenido .= '<tr>
        <th>N</th>
		<th class="user">
		<img class="buscar_campo_ordenado_desc" src="images/down.png" width="16" height="16" border="0" title="Sort Descending" />
		User
		<img class="buscar_campo_ordenado_asc" src="images/up.png" width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="name">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Name
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="email">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		E-mail
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="option">Options</th>
		</tr>';
		$i = 0;
		while($row = $result->fetch_assoc()){
			$i += 1;
			if($i%2==0){
				$contenido .= '<tr class="campo2">';
			}else{
				$contenido .= '<tr>';
			}
            $contenido .= '<td>'.$i.'</td>';
			$contenido .= '<td>'.htmlspecialchars($row['user']).'</td>';
			$contenido .= '<td>'.htmlspecialchars($row['name']).'</td>';
			$contenido .= '<td>'.htmlspecialchars($row['email']).'</td>';
			$contenido .= '<td id="user'.$row['cod'].'" class="options-width">';
			$contenido .= '<a href="edit-user.php?cod='.$row['cod'].'" title="Edit '.htmlspecialchars($row['usuario']).'" class="icon-1 info-tooltip"><img src="images/note_edit.png" /></a>';
			$contenido .= '<a href="delete-user.php?cod='.$row['cod'].'" title="Delete" '.htmlspecialchars($row['usuario']).'" class="eliminar-usuario"><img src="images/delete.png" /></a>';
			$contenido .= '</td>';
			$contenido .= '</tr>';
			}
		$contenido .= '</table></div>';
				
		$result->free();
		
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
	
	if($campo != ''){
		$filtro .= "user LIKE '%".$bcampo."%' OR name LIKE '%".$bcampo."%' OR email LIKE '%".$bcampo."%'";
	}
		
	if($filtro == ''){
		$filtro .= " 1 ";
	}
	
	$presql = "SELECT * FROM users WHERE ".$filtro." ORDER BY ".$campo." ".$orden.";";
	//echo $presql;
	
	$result = $link->query($presql);
	if (!$result) {
		die('Invalid query: ' . $link->error);
	}
	
	$num_rows = $result->num_rows;
	if($num_rows > 0){
		$contenido = '<br /><div align="center">';
		$contenido .= '<table class="stylized"  width="100%">';
    	$contenido .= '<tr>
		<th class="user">
		<img class="buscar_campo_ordenado_desc" src="images/down.png" width="16" height="16" border="0" title="Sort Descending" />
		User
		<img class="buscar_campo_ordenado_asc" src="images/up.png" width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="name">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Name
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="email">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		E-mail
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="option">Options</th>
		</tr>';
		$i = 0;
		while($row = $result->fetch_assoc()){
			$i += 1;
			if($i%2==0){
				$contenido .= '<tr class="campo2">';
			}else{
				$contenido .= '<tr>';
			}
			$contenido .= '<td>'.htmlspecialchars($row['user']).'</td>';
			$contenido .= '<td>'.htmlspecialchars($row['name']).'</td>';
			$contenido .= '<td>'.htmlspecialchars($row['email']).'</td>';
			$contenido .= '<td id="user'.$row['cod'].'" class="options-width">';
			$contenido .= '<a href="edit-user.php?cod='.$row['cod'].'" title="Edit '.htmlspecialchars($row['usuario']).'" class="icon-1 info-tooltip"><img src="images/note_edit.png" /></a>';
			$contenido .= '<a href="delete-user.php?cod='.$row['cod'].'" title="Delete" '.htmlspecialchars($row['usuario']).'" class="eliminar-usuario"><img src="images/delete.png" /></a>';
			$contenido .= '</td>';
			$contenido .= '</tr>';
			}
		$contenido .= '</table></div>';
				
		$result->free();
		
		echo json_encode(array("status"=>"true","contenido"=>$contenido ));		
	}else{
		echo json_encode(array("status"=>"false" ));		
	}
}

if ( $_REQUEST['tab'] == 'edit_member'){
	$link = conectar();
	$cod = substr($_REQUEST['cod'],4);
	
	$sql = "SELECT * FROM users WHERE cod='".$cod."';";
	$result = $link->query($sql);
	if (!$result) {
		die('Invalid query: ' . $link->error);
	}
	if($result->num_rows > 0 ){
		$row = $result->fetch_assoc();
		$contenido = '';
		$contenido .= '<h3>Form edit user</h3>';
		$contenido .= '<div class="box box-info">If the password is blank, will not change the current password</div>';
		$contenido .= '<form id="user_edit" action="#" method="post"><fieldset>';
		$contenido .= '<input type="hidden" id="cod" value="'.$cod.'" />';
		$contenido .= '<p><label class="required" for="user">User:</label><br>';
		$contenido .= '<input id="user" class="half" type="text" name="user" value="'.htmlspecialchars($row['user']).'"></p>';
		$contenido .= '<p><label for="password">Password:</label><br>';
		$contenido .= '<input id="password" class="half" type="password" name="password" value=""></p>';
		$contenido .= '<p><label class="required" for="name">Name:</label><br>';
		$contenido .= '<input id="name" class="half" type="text" name="name" value="'.htmlspecialchars($row['name']).'"></p>';
		$contenido .= '<p><label class="required" for="email">Email address:</label><br>';
		$contenido .= '<input id="email" class="half" type="text" name="email" value="'.htmlspecialchars($row['email']).'"></p>';
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
	if($password==''){
		$sql = "UPDATE users SET user='".$user."',name='".$name."',email='".$email."' WHERE cod='".$cod."'";
	}else{
		global $saltt;
		$pass = sha1($saltt.md5($password));
		$sql = "UPDATE users SET user='".$user."',name='".$name."',pass='".$pass."',email='".$email."' WHERE cod='".$cod."'";
	}
	//echo $sql;
	$result = $link->query($sql);
	if (!$result) {									
		die('Invalid query: Problems to insert data into the member table ' . $link->error);	
	}
	echo json_encode(array("status"=>"true","user"=>$user,"name"=>$name,"email"=>$email,"cod"=>"user".$cod));	
}

if ( $_REQUEST['tab'] == 'eliminar_usuario'){
	$link = conectar();
	$cod = substr($_REQUEST['cod'],4);
	
	$presql = "DELETE FROM users WHERE cod ='".$cod."';";

	$result = $link->query($presql);
	if (!$result) {
		echo json_encode(array("status"=>"false"));
		die('Invalid query: ' . $link->error);
	}
	echo json_encode(array("status"=>"true","cod"=>"user".$cod));

	$link->close();
}


if ( $_REQUEST['tab'] == 'new_user'){
	$contenido = '';
	$contenido .= '<h3>Form new user</h3>';
	$contenido .= '<div class="box box-info">All fields are required</div>';
	$contenido .= '<form id="user_new" action="#" method="post"><fieldset>';
	$contenido .= '<p><label class="required" for="user">User:</label><br>';
	$contenido .= '<input id="user" class="half" type="text" name="user" value=""></p>';
	$contenido .= '<p><label class="required" for="password">Password:</label><br>';
	$contenido .= '<input id="password" class="half" type="password" name="password" value=""></p>';
	$contenido .= '<p><label class="required" for="name">Name:</label><br>';
	$contenido .= '<input id="name" class="half" type="text" name="name" value=""></p>';
	$contenido .= '<p><label class="required" for="email">Email address:</label><br>';
	$contenido .= '<input id="email" class="half" type="text" name="email" value=""></p>';
	$contenido .= '<p class="box"><input class="btn btn-green big" type="submit" id="save_new" name="sendform" value="Add User">';
	echo json_encode(array("status"=>"true","contenido"=>$contenido ));
}

if ( $_REQUEST['tab'] == 'add_user'){
	$link = conectar();
	reset ($_REQUEST);
	while (list ($param, $val) = each ($_REQUEST)) {
	    $asignacion = "\$" . $param . "=$link->real_escape_string(\$_REQUEST['" . $param . "']);";
    	eval($asignacion);
	}
	
	$seguir_nombre = "SI";
	$seguir_email = "SI";
	
	$sql = "SELECT 1 FROM users WHERE user='".$user."';";
	$result = $link->query($sql);
	if($result->num_rows>0){
		$seguir_nombre = "NO";	
	}
	
	$sql = "SELECT 1 FROM users WHERE email='".$email."';";
	$result = $link->query($sql);
	if($result->num_rows>0){
		$seguir_email = "NO";	
	}
	
	if($seguir_nombre == "NO" && $seguir_email=="NO"){
		echo json_encode(array("status"=>"false","contenido"=>"User and e-mail are busy"));
	}elseif($seguir_nombre == "NO"){
		echo json_encode(array("status"=>"false","contenido"=>"User is busy"));
	}elseif($seguir_email=="NO"){
		echo json_encode(array("status"=>"false","contenido"=>"E-mail is busy"));
	}else{	
		global $saltt;
		$pass = sha1($saltt.md5($password));
		$sql = "INSERT INTO users (user,pass,name,email) VALUES ('".$user."','".$pass."','".$name."','".$email."')";
		//echo $sql;
		$result = $link->query($sql);
		if (!$result) {									
			die('Invalid query: Problems to insert data into the member table ' . $link->error);	
		}
		echo json_encode(array("status"=>"true"));	
	}
}

if ( $_REQUEST['tab'] == 'buscar_message'){
	$link = conectar();
	$type = $_REQUEST['type'];
	$lang = $_REQUEST['lang'];
	$contenido = '<br><div style="width:80%;float:left;">';
	$sql = "SELECT * FROM messages WHERE type='".$type."' AND language='".$lang."';";
	//echo $sql;
	$result = $link->query($sql);
	if($result->num_rows>0){
		$row = $result->fetch_assoc();
		$contenido .= 'Subject: <input type="text" class="half" id="subject" value="'.htmlspecialchars($row['subject']).'"><br><br>';
		$contenido .= '<textarea class="large tinymce" id="message'.$row['cod'].'" name="message">'.htmlspecialchars($row['message']).'</textarea>';
	}else{
		$contenido .= 'Subject: <input type="text" class="half" id="subject" value=""><br><br>';
		$contenido .= '<textarea class="large tinymce" id="vacio" name="message"></textarea>';
	}
	$contenido .= '</div>';
	$contenido .= '<div style="float:left;width:20%;text-align:center;">';
	$sql = "DESCRIBE members";
	$rs = $link->query($sql);
	$contenido .= "<br><br><br><select id='field' size='".($rs->num_rows-4)."'>";
	while($fila = $rs->fetch_assoc()){
		if($fila['Field']!='cod' && $fila['Field']!='mark_renewal' && $fila['Field']!='email_renewal' && $fila['Field']!='email_expired'){
			$contenido .= "<option value='".$fila['Field']."'>".$fila['Field']."</option>";
		}
	}
	$contenido .= "</select>";
	$contenido .= '<br><br><input class="btn btn-green big" type="submit" id="save_message" value="Save message">';
	$contenido .= "</div>";
	$contenido .= "<div class='cleared'></div>";
	$contenido .= "<input type='hidden' id='typem' value='".$type."'>";
	$contenido .= "<input type='hidden' id='langm' value='".$lang."'>";
	$contenido .= "<br><br><div class='box box-info'>Double-click the field you want to insert into the textarea to include member information</div>";
	$rs->free();
	
	echo json_encode($contenido);
}

if ( $_REQUEST['tab'] == 'guardar_message' ){
	$link = conectar();
	$type = $_REQUEST['type'];
	$lang = $_REQUEST['lang'];
	$message = $_REQUEST['message'];
	$id = $_REQUEST['id'];
	$subject = $_REQUEST['subject'];
	if($id == "vacio"){
		//procedemos a insertar
		$sql = "INSERT INTO messages (type,language,message,subject) VALUES ('".$type."','".$lang."','".$message."','".$subject."')";
		//echo $sql;
		$result = $link->query($sql);
		if (!$result) {	
			echo json_encode(array("status"=>"false","contenido"=>"Error"));
			die('Invalid query: Problems to insert data into the member table ' . $link->error);	
		}
		$contenido = '<br><div class="box box-info closeable">Successfully saved</div>';
	}else{
		//actualizamos
		$cod = substr($id,7);
		$sql = "UPDATE messages SET message='".$message."', subject='".$subject."' WHERE cod='".$cod."'";
		$result = $link->query($sql);
		if (!$result) {	
			echo json_encode(array("status"=>"false","contenido"=>"Error"));
			die('Invalid query: Problems to insert data into the member table ' . $link->error);	
		}
		$contenido = '<br><div class="box box-info closeable">Successfully saved</div>';
	}
	echo json_encode(array("status"=>"true","contenido"=>$contenido));	
}

if ( $_REQUEST['tab'] == 'set_invoice' ){
	$link = conectar();
	$text = $_REQUEST['text'];
	$lang = $_REQUEST['lang'];
	$campo = $_REQUEST['campo'];
	$sql = "UPDATE invoice SET ".$campo."='".$text."' WHERE cod='1'";
	$result = $link->query($sql);
	if (!$result) {	
		echo json_encode(array("status"=>"false","contenido"=>$link->error));
		die('Invalid query: Problems to insert data into the member table ' . $link->error);	
	}else{
		echo json_encode(array("status"=>"true"));	
	}
}

if ( $_REQUEST['tab'] == 'set_language' ){
	$link = conectar();
	$lang = $_REQUEST['lang'];
	$valor = $_REQUEST['valor'];
	$sql = "UPDATE language SET active='".$valor."' WHERE cod='".$lang."';";
	//echo $sql;
	$result = $link->query($sql);
	if (!$result) {	
		echo json_encode(array("status"=>"false","contenido"=>"Error"));
		die('Invalid query: Problems to insert data into the member table ' . $link->error);	
	}
	echo json_encode(array("status"=>"true"));	
}

if ( $_REQUEST['tab'] == 'set_default' ){
	$link = conectar();
	$lang = $_REQUEST['lang'];
	$sql = "SELECT cod FROM language WHERE vdefault='1';";
	$result = $link->query($sql);
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$sql = "UPDATE language SET vdefault='0' WHERE cod='".$row['cod']."';";
		$result2 = $link->query($sql);
	}
	$sql = "UPDATE language SET vdefault='1' WHERE cod='".$lang."';";
	$result3 = $link->query($sql);
	if(!$result3){
		echo json_encode(array("status"=>"false","contenido"=>$link->error));
	}else{
		echo json_encode(array("status"=>"true"));	
	}
}

if ( $_REQUEST['tab'] == 'set_notice_renewal' ){
	$link = conectar();
	$valor = $_REQUEST['valor'];
	$sql = "UPDATE parametros SET notice_renewal='".$valor."' WHERE cod='1'";
	$result = $link->query($sql);
	if(!$result){
		echo json_encode(array("status"=>"false","contenido"=>$link->error));
	}else{
		echo json_encode(array("status"=>"true"));	
	}
}

if ( $_REQUEST['tab'] == 'set_sender' ){
	$link = conectar();
	$valor = $_REQUEST['valor'];
	$sql = "UPDATE parametros SET sender='".$valor."' WHERE cod='1'";
	$result = $link->query($sql);
	if(!$result){
		echo json_encode(array("status"=>"false","contenido"=>$link->error));
	}else{
		echo json_encode(array("status"=>"true"));	
	}
}

if ( $_REQUEST['tab'] == 'add_email_renewal' ){
	$link = conectar();
	$email = $_REQUEST['email'];
	$sql = "INSERT INTO responsible (responsible,area) VALUES ('".$email."','renewal');";
	$result = $link->query($sql);
	
	$sql = "SELECT * FROM responsible WHERE area='renewal'";
	$result = $link->query($sql);
	if($link->affected_rows<=0){
		//No hay registros
		echo json_encode(array("status"=>"false","contenido"=>"Error"));
	}else{
		$contenido = '<table class="stylized" id="resp_renewal_email" width="60%">';
		$contenido .= '<tr><th>E-mail</th><th class="ta-center">Options</th></tr>';
		while($row = $result->fetch_assoc()){
			$contenido .= '<tr><td>'.$row['responsible'].'</td>';
			$contenido .= '<td id="resp'.$row['cod'].'" class="ta-center">';
			$contenido .= '<a href="#" title="Delete" class="icon-elim"><img src="images/delete.png" /></a>';
			$contenido .= '</td>';
			$contenido .= '</tr>';
		}
		$contenido .= '<tr><td colspan="2" class="ta-center">';
		$contenido .= '<input type="text" id="emailresponsible_ren" > &nbsp;&nbsp;';
		$contenido .= '<input type="button" class="btn btn-blue" id="add_email_responsible_ren" value="Add e-mail">';
		$contenido .= '</td></tr>';
		$contenido .= '</table>';
		echo json_encode(array("status"=>"true","contenido"=>$contenido));
	}
}

if ( $_REQUEST['tab'] == 'add_email_expired' ){
	$link = conectar();
	$email = $_REQUEST['email'];
	$sql = "INSERT INTO responsible (responsible,area) VALUES ('".$email."','expired');";
	$result = $link->query($sql);
	
	$sql = "SELECT * FROM responsible WHERE area='expired'";
	$result = $link->query($sql);
	if($link->affected_rows<=0){
		//No hay registros
		echo json_encode(array("status"=>"false","contenido"=>"Error"));
	}else{
		$contenido = '<table class="stylized" id="resp_expired_email" width="60%">';
		$contenido .= '<tr><th>E-mail</th><th class="ta-center">Options</th></tr>';
		while($row = $result->fetch_assoc()){
			$contenido .= '<tr><td>'.$row['responsible'].'</td>';
			$contenido .= '<td id="resp'.$row['cod'].'" class="ta-center">';
			$contenido .= '<a href="#" title="Delete" class="icon-elim"><img src="images/delete.png" /></a>';
			$contenido .= '</td>';
			$contenido .= '</tr>';
		}
		$contenido .= '<tr><td colspan="2" class="ta-center">';
		$contenido .= '<input type="text" id="emailresponsible_exp" > &nbsp;&nbsp;';
		$contenido .= '<input type="button" class="btn btn-blue" id="add_email_responsible_exp" value="Add e-mail">';
		$contenido .= '</td></tr>';
		$contenido .= '</table>';
		echo json_encode(array("status"=>"true","contenido"=>$contenido));
	}
}

if ( $_REQUEST['tab'] == 'eliminar_correo'){
	$link = conectar();
	$cod = substr($_REQUEST['cod'],4);
	
	$presql = "DELETE FROM responsible WHERE cod ='".$cod."';";

	$result = $link->query($presql);
	if (!$result) {
		echo json_encode(array("status"=>"false"));
		die('Invalid query: ' . $link->error);
	}
	echo json_encode(array("status"=>"true","cod"=>"resp".$cod));

	$link->close();
}

if ( $_REQUEST['tab'] == 'add_type' ){
	$link = conectar();
	$tipo = $_REQUEST['tipo'];
	$sql = "INSERT INTO type_member (name) VALUES ('".$tipo."');";
	$result = $link->query($sql);
	
	$sql = "SELECT * FROM type_member;";
	$result = $link->query($sql);
	if($link->affected_rows<=0){
		//No hay registros
		echo json_encode(array("status"=>"false","contenido"=>"Error"));
	}else{
		$contenido = '<table class="stylized" id="resp_type" width="60%">';
		$contenido .= '<tr><th>E-mail</th><th class="ta-center">Options</th></tr>';
		while($row = $result->fetch_assoc()){
			$contenido .= '<tr><td>'.$row['name'].'</td>';
			$contenido .= '<td id="type'.$row['cod'].'" class="ta-center">';
			$contenido .= '<a href="#" title="Delete" class="icon-elim-type"><img src="images/delete.png" /></a>';
			$contenido .= '</td>';
			$contenido .= '</tr>';
		}
		$contenido .= '<tr><td colspan="2" class="ta-center">';
		$contenido .= '<input type="text" id="typemembervalue" > &nbsp;&nbsp;';
		$contenido .= '<input type="button" class="btn btn-blue" id="add_new_type" value="Add type">';
		$contenido .= '</td></tr>';
		$contenido .= '</table>';
		echo json_encode(array("status"=>"true","contenido"=>$contenido));
	}
}

if ( $_REQUEST['tab'] == 'eliminar_tipo'){
	$link = conectar();
	$cod = substr($_REQUEST['cod'],4);
	
	$presql = "DELETE FROM type_member WHERE cod ='".$cod."';";

	$result = $link->query($presql);
	if (!$result) {
		echo json_encode(array("status"=>"false"));
		die('Invalid query: ' . $link->error);
	}
	echo json_encode(array("status"=>"true","cod"=>"type".$cod));

	$link->close();
}

if ( $_REQUEST['tab'] == 'formulario_add'){
	$contenido = '';
	$contenido .= '<h3>Form new link</h3>';
	$contenido .= '<div class="box box-info">All fields are required</div>';
	$contenido .= '<form id="link_new" action="#" method="post"><fieldset>';
	$contenido .= '<p><label class="required" for="description">Description:</label><br>';
	$contenido .= '<input id="description" class="half" type="text" name="description" value=""></p>';
	$contenido .= '<p><label class="required" for="title">Title link:</label><br>';
	$contenido .= '<input id="title_link" class="half" type="text" name="title" value=""></p>';
	$contenido .= '<p><label class="required" for="link">Link:</label><br>';
	$contenido .= '<input id="link" class="half" type="text" name="link" value=""></p>';
	$contenido .= '<p class="box"><input class="btn btn-green big" type="submit" id="save_new_link" value="Add new link">';
	echo json_encode($contenido);
}

if ( $_REQUEST['tab'] == 'add_link'){
	$link = conectar();
	reset ($_REQUEST);
	while (list ($param, $val) = each ($_REQUEST)) {
	    $asignacion = "\$" . $param . "=$link->real_escape_string(\$_REQUEST['" . $param . "']);";
    	eval($asignacion);
	}
	
	$sql = "INSERT INTO links (description, title, enlace) VALUES ('".$description."','".$title."','".$enlace."')";
	//echo $sql;
	$result = $link->query($sql);
	if (!$result) {									
		die('Invalid query: Problems to insert data into the member table ' . $link->error);	
	}
	
	$sql = "SELECT * FROM links;";
	$result = $link->query($sql);
	if($link->affected_rows<=0){
		//No hay registros
		$contenido = 'No links';
	}else{
		//Mostrar la tabla
		$contenido = '<table class="stylized" id="tbl_links" width="100%">';
		$contenido .= '<tr><th>Title</th><th>Description</th><th class="ta-center">Options</th></tr>';
		while($row = $result->fetch_assoc()){
			$contenido .= '<tr><td>'.$row['title'].'</td>';
			$contenido .= '<td>'.$row['description'].'</td>';
			$contenido .= '<td id="link'.$row['cod'].'" class="ta-center">';
			$contenido .= '<a href="#" title="Edit" class="edit-link"><img src="images/note_edit.png" /></a>&nbsp;';
			$contenido .= '<a href="#" title="Delete" class="icon-elim-link"><img src="images/delete.png" /></a>';
			$contenido .= '</td>';
			$contenido .= '</tr>';
		}
		$contenido .= '</table>';
	}
	echo json_encode($contenido);	
	
}

if ( $_REQUEST['tab'] == 'eliminar_link'){
	$link = conectar();
	$cod = substr($_REQUEST['cod'],4);
	
	$presql = "DELETE FROM links WHERE cod ='".$cod."';";

	$result = $link->query($presql);
	if (!$result) {
		echo json_encode(array("status"=>"false"));
		die('Invalid query: ' . $link->error);
	}
	echo json_encode(array("status"=>"true","cod"=>"link".$cod));

	$link->close();
}

if ( $_REQUEST['tab'] == 'edit_link'){
	$link = conectar();
	$cod = substr($_REQUEST['cod'],4);
	
	$sql = "SELECT * FROM links WHERE cod='".$cod."';";
	$result = $link->query($sql);
	if (!$result) {
		die('Invalid query: ' . $link->error);
	}
	if($result->num_rows > 0 ){
		$row = $result->fetch_assoc();
		$contenido = '';
		$contenido .= '<h3>Form edit link</h3>';
		$contenido .= '<form id="link_edit" action="#" method="post"><fieldset>';
		$contenido .= '<input type="hidden" id="cod" value="'.$cod.'" />';
		$contenido .= '<p><label class="required" for="description">Description:</label><br>';
		$contenido .= '<input id="description" class="half" type="text" name="description" value="'.htmlspecialchars($row['description']).'"></p>';
		$contenido .= '<p><label class="required" for="title_link">Title link:</label><br>';
		$contenido .= '<input id="title_link" class="half" type="text" name="title_link" value="'.htmlspecialchars($row['title']).'"></p>';
		$contenido .= '<p><label class="required" for="enlace">Link:</label><br>';
		$contenido .= '<input id="enlace" class="half" type="text" name="enlace" value="'.htmlspecialchars($row['enlace']).'"></p>';
		$contenido .= '<p class="box"><input class="btn btn-green big" type="submit" id="save_edit_link" name="sendform" value="Save">';
		
		echo json_encode(array("status"=>"true","contenido"=>$contenido ));		
	}else{
		echo json_encode(array("status"=>"false" ));		
	}
}

if ( $_REQUEST['tab'] == 'save_edit_link'){
	$link = conectar();
	reset ($_REQUEST);
	while (list ($param, $val) = each ($_REQUEST)) {
	    $asignacion = "\$" . $param . "=$link->real_escape_string(\$_REQUEST['" . $param . "']);";
    	eval($asignacion);
	}
	$sql = "UPDATE links SET description='".$description."',title='".$title."',enlace='".$enlace."' WHERE cod='".$cod."'";
	//echo $sql;
	$result = $link->query($sql);
	if (!$result) {									
		die('Invalid query: Problems update link ' . $link->error);	
	}
	echo json_encode(array("status"=>"true","description"=>$description,"title"=>$title,"cod"=>"link".$cod));	
}
?>