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
		$filtro .= " (name LIKE '%".$name."%' OR surname LIKE '%".$name."%' OR institution LIKE '%".$name."%')";
	}
	
	
	if($num != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= " num_invoice='".$num."'";
	}
	
	
	if($year != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= " year='".$year."'";
	}
	
	if($invoice_ini != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= " UNIX_TIMESTAMP(date) >= '".strtotime($invoice_ini)."'";
	}
	
	if($invoice_fin != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= " UNIX_TIMESTAMP(date) <= '".strtotime($invoice_fin)."'";
	}
	
	if($filtro == ''){
		$filtro .= " 1 ";
	}
	
	$presql = "SELECT a.cod, a.num_invoice, a.year, a.date, b.name, b.surname, b.institution FROM invoices AS a, members AS b WHERE a.cod_member=b.cod AND".$filtro.";";
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
		<th class="name">
		<img class="buscar_campo_ordenado_desc" src="images/down.png" width="16" height="16" border="0" title="Sort Descending" />
		Name
		<img class="buscar_campo_ordenado_asc" src="images/up.png" width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="num_invoice" style="width:12%">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Num
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="year" style="width:12%">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Year
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="date" style="width:12%">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Date
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
			$contenido .= '<td>';
			if($row['institution']!=''){
				$contenido .= htmlspecialchars($row['institution']);
			}else{
				$contenido .= htmlspecialchars($row['name']).' '.htmlspecialchars($row['surname']);
			}
			$conteniod .= '</td>';
			$contenido .= '<td class="ta-center">'.completar($row['num_invoice'],4).'</td>';
			$contenido .= '<td class="ta-center">'.$row['year'].'</td>';
			$contenido .= '<td class="ta-center">'.date("d/m/Y",strtotime($row['date'])).'</td>';
			$contenido .= '<td id="invoice'.$row['cod'].'" class="options-width">';
			$contenido .= '<a href="#" title="Forward" class="forward"><img src="images/forward.png" /></a>&nbsp;';
			$contenido .= '<a href="#" title="Download" class="download"><img src="images/download.png" /></a>&nbsp;';
			$contenido .= '<a href="#" title="Delete" class="eliminar-invoice"><img src="images/trash.png" /></a>';
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
	
	if($name != ''){
		$filtro .= " (name LIKE '%".$name."%' OR surname LIKE '%".$name."%' OR institution LIKE '%".$name."%')";
	}
	
	
	if($num != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= " num_invoice='".$num."'";
	}
	
	
	if($year != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= " year='".$year."'";
	}
	
	if($invoice_ini != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= " UNIX_TIMESTAMP(date) >= '".strtotime($invoice_ini)."'";
	}
	
	if($invoice_fin != ''){
		if($filtro != ''){
			$filtro .= " AND ";
		}
		$filtro .= " UNIX_TIMESTAMP(date) <= '".strtotime($invoice_fin)."'";
	}
	
	if($filtro == ''){
		$filtro .= " 1 ";
	}
	
	$presql = "SELECT a.cod, a.num_invoice, a.year, a.date, b.name, b.surname, b.institution FROM invoices AS a, members AS b WHERE a.cod_member=b.cod AND".$filtro." ORDER BY ".$campo." ".$orden.";";
	
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
		<th class="name">
		<img class="buscar_campo_ordenado_desc" src="images/down.png" width="16" height="16" border="0" title="Sort Descending" />
		Name
		<img class="buscar_campo_ordenado_asc" src="images/up.png" width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="num_invoice" style="width:12%">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Num
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="year" style="width:12%">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Year
		<img class="buscar_campo_ordenado_asc" src="images/up.png"  width="16" height="16" border="0" title="Sort ascending" />
		</th>
		<th class="date" style="width:12%">
		<img class="buscar_campo_ordenado_desc" src="images/down.png"  width="16" height="16" border="0" title="Sort Descending" />
		Date
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
			$contenido .= '<td>';
			if($row['institution']!=''){
				$contenido .= htmlspecialchars($row['institution']);
			}else{
				$contenido .= htmlspecialchars($row['name']).' '.htmlspecialchars($row['surname']);
			}
			$conteniod .= '</td>';
			$contenido .= '<td class="ta-center">'.completar($row['num_invoice'],4).'</td>';
			$contenido .= '<td class="ta-center">'.$row['year'].'</td>';
			$contenido .= '<td class="ta-center">'.date("d/m/Y",strtotime($row['date'])).'</td>';
			$contenido .= '<td id="invoice'.$row['cod'].'" class="options-width">';
			$contenido .= '<a href="#" title="Forward" class="forward"><img src="images/forward.png" /></a>&nbsp;';
			$contenido .= '<a href="#" title="Download" class="download"><img src="images/download.png" /></a>&nbsp;';
			$contenido .= '<a href="#" title="Delete" class="eliminar-invoice"><img src="images/trash.png" /></a>';
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

if ( $_REQUEST['tab'] == 'download'){
	
	$link = conectar2();
	$cod = substr($_REQUEST['cod'],7);
	
	$sql = "SELECT * FROM invoices WHERE cod='".$cod."';";
	$result = $link->query($sql);
	if (!$result) {	
		echo json_encode(array("status"=>"false"));
		die('Invalid query: ' . $link->error);	
	}else{
		$aux = $result->fetch_assoc();
		$link = conectar2();
		$sql = "SELECT footer, show_signature FROM invoice WHERE cod='1';";
		$result = $link->query($sql);
		$tmp_invoice = $result->fetch_assoc();
		
		$num_invoice = $aux['num_invoice'];
		$year = $aux['year'];
		$cod_member = $aux['cod_member'];
		$message = $aux['message'];
		$footer = quitar_html($tmp_invoice['footer']);
		$show_signature = ($tmp_invoice['show_signature']=="YES")?(true):(false);
		
		
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
	echo json_encode(array("status"=>"true","invoice"=>$file));	
	}
	
}


if ( $_REQUEST['tab'] == 'forward'){
	$link = conectar2();
	$cod = substr($_REQUEST['cod'],7);
	
	$sql = "SELECT * FROM invoices WHERE cod='".$cod."';";
	$result = $link->query($sql);
	if (!$result) {	
		echo json_encode(array("status"=>"false"));
		die('Invalid query: ' . $link->error);	
	}else{
		$aux = $result->fetch_assoc();
		$link = conectar2();
		$sql = "SELECT footer, show_signature FROM invoice WHERE cod='1';";
		$result = $link->query($sql);
		$tmp_invoice = $result->fetch_assoc();
		
		$num_invoice = $aux['num_invoice'];
		$year = $aux['year'];
		$cod_member = $aux['cod_member'];
		$message = $aux['message'];
		$footer = quitar_html($tmp_invoice['footer']);
		$show_signature = ($tmp_invoice['show_signature']=="YES")?(true):(false);
		
		
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
				$this->Cell(0,4,'Página '.$this->PageNo().'/{nb}',0,0,'R');
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
		$pdf->Cell(0,4,'Nº invoice: '.completar($num_invoice,4)."/".$year,0,0,'R');// Variable
				
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
	$link = conectar();
	$sql = "SELECT * FROM members WHERE cod='".$cod_member."';";
	$result = $link->query($sql);
	if (!$result) {	
		echo json_encode(array("status"=>"false"));
		die('Invalid query: ' . $link->error);	
	}
	$fila = $result->fetch_assoc();
	$language = datosreg($fila['language'],'language','language','cod');
	//Buscamos la plantilla que le corresponda
	$sql = "SELECT message, subject FROM messages WHERE type='invoice_forward' AND language='".$language."'";
	$r_tmp = $link->query($sql);
	
	if($r_tmp->num_rows>0){
		$f_tmp = $r_tmp->fetch_assoc();
		$message = $f_tmp['message'];
		$subject = $f_tmp['subject'];
		if(trim($message) == ''){
			$default_language = datosreg('1','language','language','vdefault');
			$sql = "SELECT message, subject FROM messages WHERE type='invoice_forward' AND language='".$default_language."'";
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
		$sql = "SELECT message, subject FROM messages WHERE type='invoice_forward' AND language='".$default_language."'";
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
		$mail->AddAddress($fila['email']);
		
		$mail->AddAttachment ("../invoices/".$file, $file);
		
		$mail->CharSet = "UTF-8";
		
		$body = $message;
		$mail->Body = $body;
		$mail->AltBody = quitar_html($message);
		$mail->Send();
	}else{
		//Notificamos al responsable
		$idioma = datosreg($fila['language'],'language','language','cod');
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
		
		
		$body = "The template for the invoice forward of the ".$idioma." language is not available, and the default template is not available.<br><br>Enter the platform in \"Settings\" section and select \"Message\" tabs to edit the corresponding message.<br><br>Regards";
		$mail->Body = $body;
		$mail->AltBody = quitar_html($message);
		$mail->Send();
	}
	//FIN ENVIAR E-MAIL
		echo json_encode(array("status"=>"true"));	
	}
}

if ( $_REQUEST['tab'] == 'eliminar_factura'){
	$link = conectar();
	$cod = substr($_REQUEST['cod'],7);
	
	$presql = "DELETE FROM invoices WHERE cod ='".$cod."';";

	$result = $link->query($presql);
	if (!$result) {
		echo json_encode(array("status"=>"false"));
		die('Invalid query: ' . $link->error);
	}
	echo json_encode(array("status"=>"true","cod"=>"invoice".$cod));

	$link->close();
}
	
?>