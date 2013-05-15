<?php
class factPDF extends PDF {

function factura_pdf($cod, $salida='F'){

$this->SetMargins(20,24);
$this->AliasNbPages();
$datos=mysql_query("select facturas.*, UNIX_TIMESTAMP(fechafra) as fecha, clientes.rsocial, clientes.contacto, clientes.domicilio, clientes.localidad, clientes.cp, clientes.provincia, clientes.telefono, clientes.cif, clientes.pais, clientes.entidad as entidad_c, clientes.oficina as oficina_c, clientes.dc as dc_c, clientes.cuenta as cuenta_c from facturas inner join clientes on clientes.cod=facturas.codcliente where facturas.cod='".$cod."';");
$filtro2="select * from detallefras where codfra = '".$cod."'";
$regpag=11;
$datosi=mysql_query($filtro2);
$nregs=mysql_num_rows($datosi);
if($nregs>0){

		$n=ceil($nregs/$regpag);
		//$n=paginacion($cod, $regpag);
	
}
else { $n=1; }
$x=0;

for($i=0 ; $i<$n ; $i++){

while ($fila = mysql_fetch_array($datos, MYSQL_ASSOC)) {
					foreach ($fila as $campo=>$valor) {
						$asignacion = "\$" . $campo . "='" . $valor . "';";
						eval($asignacion);
					}
	}
	
$this->AddPage();
$this->SetFont('arial','B',9);
$this->SetAutoPageBreak('',2);

//$this->image('imagenes/nosolored_fraSL.jpg',20,10);
$this->Image('../images/nsr-proyectos.jpg',20,12,90);
$txtreg=datosreg($serie,"series_facturas", "registro","serie");
$this->SetFont('','',7);
$this->TextWithDirection(12,200,$txtreg,'U');

// RECUADRO BANCOS

$this->SetLineWidth(0.3);
$this->SetDrawColor(0,0,150);
$this->RoundedRect(115,22, 80, 25, 3, '1234');

$this->SetFont('','B',9);
$this->SetLineWidth(0.4);
$this->SetTextColor(0,0,0);
$this->Cell(100,4,'');
$this->Cell(0,4,'DATOS BANCARIOS','B','1','C');

$this->Ln(4);
$this->Cell(114,4,'');
$this->SetFont('','','8');
$this->Cell(0,4,'            Entidad  Oficina  DC     Cuenta','','1','');
$querybancos=mysql_query("select * from datos_bancarios where activa='SI'");
while($rowb=mysql_fetch_array($querybancos)){
	$bc+=1;
	$cuenta[$bc]=$rowb["banco"]."        ".$rowb["entidad"]."     ".$rowb["oficina"]."      ".$rowb["dc"]."    ".$rowb["cuenta"]."    ";
	}
$this->SetFont('','B','7');
$this->Cell(20,4,datosreg($serie,"series_facturas", "rsocial","serie"));
$this->Cell(80,4,'');
$this->SetFont('','','7');
$this->Cell(0,4,$cuenta[1],0,0,"R");

$this->Ln(4);
$this->Cell(20,4,'CIF/ NºIVA: ES'.datosreg($serie,"series_facturas", "cif","serie"));
$this->Cell(80,4,'');
$this->Cell(0,4,$cuenta[2],0,0,"R");

$this->Ln(4);
$this->Cell(20,4,datosreg($serie,"series_facturas", "domicilio","serie"));

$this->Ln(4);
$this->Cell(60,4,datosreg($serie,"series_facturas", "localidad","serie")." - ".datosreg($serie,"series_facturas", "cp","serie")." (".datosreg($serie,"series_facturas", "provincia","serie")."- España)");

// FIN RECUADRO BANCOS

// RECUADROS FECHA Y CLIENTE

$x=$this->GetX();
$y=$this->GetY();

$this->SetLineWidth(0.3);
$this->SetDrawColor(0,0,150);
$this->RoundedRect(18,$y+6, 62, 28, 3, '1234');
$this->RoundedRect(82,$y+6, 113, 28, 3, '1234');

$this->Ln(8);
$this->SetFont('','B','10');
$this->Cell(70,4,'');
$this->Cell(20,4,'Emitida a:');

$this->Ln(4);
$this->SetFont('','','8');
$this->Cell(0,4,$rsocial,'','','R');// Variable

$this->Ln(2);
$this->SetFont('','B','10');
$this->Cell(5,4,'');
$this->Cell(25,4,'Factura Nº:');// Variable
if($serie!=''){
$this->Cell(22,4,$serie."-".completar($nfra,4)."/".$ejercicio,'','','R');// Variable
} else {
	
$this->Cell(22,4,completar($nfra,4)."/".$ejercicio,'','','R');// Variable
}

$this->Ln(2);
$this->SetFont('','','8');
$this->Cell(0,4,$domicilio,'','','R');// Variable

$this->Ln(4);
$this->Cell(0,4,$cp.' - '. $localidad,'','','R');// Variable

if($fechavencimiento=='0000-00-00'){
	$this->Ln(2);
	$this->SetFont('','B','10');
	$this->Cell(5,4,'');
	$this->Cell(25,4,'Fecha:');
	$this->Cell(22,4,fechanormal($fechafra),'','','R');// Variable
	
	$this->Ln(2);
	$this->SetFont('','','8');
	$this->Cell(0,4,'CIF: '.$cif,'','','R');// Variable
	$this->Ln(4);
	$this->SetFont('','','8');
	$this->Cell(0,4,'Teléfono: '.$telefono,'','','R');// Variable
} else {
	$this->Ln(2);
	$this->SetFont('','B','10');
	$this->Cell(5,4,'');
	$this->Cell(25,4,'Fecha:');
	$this->Cell(22,4,fechanormal($fechafra),'','','R');// Variable
	
	$this->Ln(2);
	$this->SetFont('','','8');
	$this->Cell(0,4,'CIF: '.$cif,'','','R');// Variable
	
	$this->Ln(4);
	$this->SetFont('','B','10');
	$this->Cell(5,4,'');
	$this->Cell(25,4,'Vencimiento:');
	$this->Cell(22,4,fechanormal($fechavencimiento),'','','R');// Variable
	$this->SetFont('','','8');
	$this->Cell(0,4,'Teléfono: '.$telefono,'','','R');// Variable
}

// FIN RECUADROS FECHA Y CLIENTE

// RECUADRO CONCEPTO E IMPORTE

$x=$this->GetX();
$y=$this->GetY();

$this->SetLineWidth(0.3);
$this->SetDrawColor(0,0,150);
$this->RoundedRect(18,$y+8, 177, 115, 3, '1234');

$this->Line(18,$y+19,195,$y+19);
$this->Line(165,$y+8,165,$y+123);

$this->Ln(12);
$this->SetFont('','I','10');
$this->SetTextColor(0,50,100);
$this->Write(4,'CONCEPTO');
$this->Cell(0,4,'IMPORTE','','','R');

$this->Ln(10);
$this->SetFont('','','10');
$this->SetTextColor(0,0,0);

	// DATOS DETALLE
$datosdet=mysql_query($filtro2. " limit ".$i*$regpag.", ".$regpag.";");
	while($filas=mysql_fetch_array($datosdet)){
	
$this->MultiCell(135,4,$filas["concepto"],0,'L',0);// Variable
$y=$this->GetY();
$this->SetY($y-4);
$this->SetX(165);
$this->Cell(0,4,number_format($filas["importe"],2 , "," ,".").' €','','1','R');// Variable
$this->Ln(4);
$subtotal+=$filas["importe"];
}
if($i==$n-1){  //sólo en última página

// FIN RECUADRO CONCEPTO E IMPORTE
$x=135;
$y=202;
$this->SetXY($x,$y);
$this->SetFont('','B','');
$this->Cell(20,4,'SUBTOTAL:','','','R');

if($canarias!='SI' && $siniva!='SI'){
		$txt='';
} else if($canarias=='SI'){
		$tipoiva=0;
		$txt="Operación exenta de IVA. Art.70, UNO, 4º Ley 37/1992, del IVA.".chr(13).chr(10);
} else {
		$tipoiva=0;
		$txt='';

}

// RECUADRO SUBTOTAL

$this->RoundedRect($x+30,$y-2, 30, 8, 1.5, '1234');
$this->Cell(15,4,'');
$this->SetFont('','','');
$this->Cell(0,4,number_format($subtotal,2 , "," ,".").' €','','','R');// Variable

// FIN RECUADRO SUBTOTAL

$this->SetXY($x,$y+9);
$this->SetFont('','B','');
$this->Cell(20,4,'IVA('.$tipoiva.'%):','','','R');

// RECUADRO IVA

$this->RoundedRect($x+30,$y+7, 30, 8, 1.5, '1234');
$this->Cell(15,4,'');
$this->SetFont('','','');
$this->Cell(0,4,number_format($subtotal*$tipoiva/100,2 , "," ,".").' €','','','R');// Variable

// FIN RECUADRO IVA

$this->SetXY($x,$y+18);
$this->SetFont('','B','');
$this->Cell(20,4,'TOTAL:','','','R');

// RECUADRO TOTAL

$this->SetFillColor(240,240,240);
$this->RoundedRect($x+30,$y+16, 30, 8, 1.5, '1234','FD');
$this->Cell(15,4,'');
$this->SetFont('','','');
$this->Cell(0,4,number_format($subtotal*(1+$tipoiva/100),2 , "," ,".").' €','','','R');// Variable

// FIN RECUADRO TOTAL

// RECUADRO FORMA DE PAGO
//if($sello!=true){
$this->Image('../images/sello_nosolored.jpg',130,$y+48,60);
//}

$this->RoundedRect($x-117,$y+26, 177, 15, 3, '1234');
$this->Ln(11);
$this->SetFont('','','8');
if($formapago==2){ //domiciliacion
	$txtcuenta=" CC cliente: ".$entidad_c."-".$oficina_c."-".$dc_c."-".$cuenta_c;
} else {
	$txtcuenta='';
}
if($pagada=='SI'){
	$txpago=" --- PAGADA ".fechanormal($fechapago)." ---";
}
$this->MultiCell(0,4,$txt."Forma de pago: ".datosreg($formapago, "formaspago","forma").$txtcuenta.$txpago);
if($observaciones!=''){
$this->MultiCell(0,4,$observaciones);
}
// FIN RECUADRO FORMA DE PAGO
$this->Ln(9);
$this->SetFont('','B','8');
$this->Cell(0,4,'Expedida en Churriana de la Vega a '.date("j",$fecha).' de '.meses(date('n',$fecha)).' de '.date('Y',$fecha),'','','R');

} // condicion ultima pagina

$this->SetY(-20);
$this->SetFont('','','7');

$this->SetTextColor(0,0,0);
if($fechavencimiento!='0000-00-00'){
$this->MultiCell(0,3,'La posesión de este documento no acredita el pago. Nosolored, S.L. se reserva el derecho a suspender los servicios contratados en caso de no efectuarse el pago tras la fecha de vencimiento de esta factura.','','C');
} else {
$this->MultiCell(0,3,'La posesión de este documento no acredita el pago. Nosolored, S.L. se reserva el derecho a suspender los servicios contratados en caso de no efectuarse el pago una vez transcurridos 15 días desde la fecha de emisión de esta factura.','','C');
}
$this->SetTextColor(0, 106, 157);
$this->Cell(0,4,"Teléfono: 958 57 88 27     Fax: 958 35 62 62",0,1,'C');
$this->SetTextColor(0,0,0);
	$this->Cell(0,4,'Página '.$this->PageNo().'/{nb}',0,0,'R');
	
}
$file="factura".completar($nfra,4)."-".$ejercicio.".pdf";
$this->Output("docs/".$file, $salida);
return $file;
}
}
?>
