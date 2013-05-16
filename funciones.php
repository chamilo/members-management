<?php
include_once 'clases/class.phpmailer.php';

//ini_set("error_reporting",E_ALL);

function conectar(){
	$link =  mysql_connect('localhost', 'database', 'password');
	if (!$link) {
		die('No pudo conectarse: ' . mysql_error());
	}
		
	$db_selected = mysql_select_db('members', $link);
	mysql_set_charset('utf8',$link);
	if (!$db_selected) {
		die ('Can\'t use jansr : ' . mysql_error());
	}
	return $link;
}

function conectar2(){
	$link =  mysql_connect('localhost', 'database', 'password');
	if (!$link) {
		die('No pudo conectarse: ' . mysql_error());
	}
		
	$db_selected = mysql_select_db('members', $link);
	//mysql_set_charset('utf8',$link);
	if (!$db_selected) {
		die ('Can\'t use jansr : ' . mysql_error());
	}
	return $link;
}

/**
* function obtener (de_la_tabla, donde_este_campo, es_igual_a_esto, este_campo_quiero);
* Obtenemos un campo especifico.
* @$tabla: Tabla donde se realiza la consulta
* @$iden: campo al que se le aplica la condición
* @$id: valor para la comparación
* @$campo: es el campo del que se busca el valor
*
* return mixto
*/
function obtener( $tabla, $iden, $id, $campo )  
{  
    $sql_link = conectar();  
    if( $id == "" || empty($id) )  
        return "";  
          
    // obtener datos del usuario  
    $q = "SELECT * FROM `$tabla` WHERE `$iden` = '$id'";  
    $result = mysql_query($q, $sql_link) or oiError(mysql_error($sql_link));  
    $ret = mysql_fetch_array($result);  
    $segm = $ret[$campo];  
    mysql_free_result($result);  
    return $segm;  
} 

/**
* function obtener (de_la_tabla, donde_este_campo, es_igual_a_esto, este_campo_quiero);
* Obtenemos un campo especifico.
* @$tabla: Tabla donde se realiza la consulta
* @$iden: campo al que se le aplica la condición
* @$id: valor para la comparación
* @$campo: es el campo del que se busca el valor
*
* return mixto
*/
function obtenerarray( $tabla, $iden, $id, $campo )  
{  
    $sql_link = conectar();  
    if( $id == "" || empty($id) )  
        return "";  
          
    // obtener datos del usuario  
    $q = "SELECT * FROM `$tabla` WHERE `$iden` = '$id'";  
    $result = mysql_query($q, $sql_link) or oiError(mysql_error($sql_link));  
    $segm = array();
	while($ret = mysql_fetch_array($result)){
		$segm[] = $ret[$campo];  
	}
    mysql_free_result($result);  
    return $segm;  
}

/**
* function texto_aleatorio (integer $long = 5, boolean $lestras_min = true, boolean $letras_max = true, boolean $num = true))
*
* Permite generar contrasenhas de manera aleatoria.
*
* @$long: Especifica la longitud de la contrasenha
* @$letras_min: Podra usar letas en minusculas
* @$letras_max: Podra usar letas en mayusculas
* @$num: Podra usar numeros
*
* return string
*/
function texto_aleatorio ($long = 6, $letras_min = true, $letras_max = true, $num = true) {
	$salt = $letras_min?'abchefghknpqrstuvwxyz':'';
	$salt .= $letras_max?'ACDEFHKNPRSTUVWXYZ':'';
	$salt .= $num?(strlen($salt)?'2345679':'0123456789'):'';
	 
	if (strlen($salt) == 0) {
		return '';
	}
	 
	$i = 0;
	$str = '';
	 
	srand((double)microtime()*1000000);
	 
	while ($i < $long) {
		$num = rand(0, strlen($salt)-1);
		$str .= substr($salt, $num, 1);
		$i++;
	}
	 
	return $str;
}

/**
* function comillas_inteligentes($valor)
* Limpia una variable con comillas para evitar inyecci�n.
* @valor: es la variable que pasamos no segura
* return string
*/
function comillas_inteligentes($valor)
{
    // Retirar las barras
    if (get_magic_quotes_gpc()) {
        $valor = stripslashes($valor);
    }

    // Colocar comillas si no es entero
    if (!is_numeric($valor)) {
        $valor = "'" . mysql_real_escape_string($valor) . "'";
    }
    return $valor;
}


function urls_amigables($url) {
	$url = utf8_decode($url);
	// Tranformamos todo a minusculas
	$url = strtolower($url);
	
	//Rememplazamos caracteres especiales latinos
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
	$repl = array('a', 'e', 'i', 'o', 'u', 'n');
	$url = str_replace ($find, $repl, $url);

	// Añaadimos los guiones
	$find = array(' ', '&', '\r\n', '\n', '+');
	$url = str_replace ($find, '-', $url);

	// Eliminamos y Reemplazamos demás caracteres especiales
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);

	return $url;

}

function comprobar_correo($email){
	$mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminaci�n del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return 1;
    else
       return 0; 	
}

function Comprobariexplorer($user_agent) {
     $navegadores = array(
		  'Internet Explorer 9' => '(MSIE 9\.[0-9]+)',
          'Internet Explorer 8' => '(MSIE 8\.[0-9]+)',
          'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
          'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
          'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
          'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
	);
	foreach($navegadores as $navegador=>$pattern){
		   if (preg_match($pattern, $user_agent))
		   return true;
		}
	return false;
}

function Comprobariexplorer2($user_agent) {
     $navegadores = array(
		  'Internet Explorer 9' => '(MSIE 9\.[0-9]+)',			  
          'Internet Explorer 8' => '(MSIE 8\.[0-9]+)',
          'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
          'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
          'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
          'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
	);
	foreach($navegadores as $navegador=>$pattern){
		   if (preg_match($pattern, $user_agent))
		   return true;
		}
	return false;
}

 // ENCRIPTAR

function encriptar($cad){ 
 $cc = base64_encode($cad); 
 $key = 'rnvoxjnj'; 
 $iv = '12345678'; 
 $cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc',''); 
 mcrypt_generic_init($cipher, $key, $iv); 
 $encrypted = mcrypt_generic($cipher,$cc); 
 mcrypt_generic_deinit($cipher); 
 return base64_encode($encrypted); 
}

function desencriptar($cad)
{
   $cc = base64_decode($cad);
   $key = 'rnvoxjnj';
   $iv = '12345678';
   $ciph = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');
   mcrypt_generic_init($ciph, $key, $iv);
   $decrypted = mdecrypt_generic($ciph,$cc);
   mcrypt_generic_deinit($ciph);
   return base64_decode($decrypted);
}

// COMPLETAR CON CEROS A LA IZQUIERDA
/////////////////////////////////////
function completar($valor, $digitos){
	$resultado='';
	if(strlen($valor)<$digitos){
		
		$ceros=$digitos-strlen(ceil($valor));
		for($i=0;$i<$ceros;$i++){
			$resultado.='0';
		}
	}
$resultado.=$valor;
return $resultado;
}

////////////////////////////////////////////////////

//Convierte fecha de mysql a normal

////////////////////////////////////////////////////

function fechanormal($fecha){
	if($fecha>0){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);

    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
	}
	else {
	$lafecha="";
	}
    return $lafecha;

}

// MESES EN ESPAÑOL DE ESPAÑA
/////////////////////////////////
function meses($valor){
	if($valor==1){
		$resultado="Enero";
	}
	if($valor==2){
		$resultado="Febrero";
	}
	if($valor==3){
		$resultado="Marzo";
	}
	if($valor==4){
		$resultado="Abril";
	}
	if($valor==5){
		$resultado="Mayo";
	}
	if($valor==6){
		$resultado="Junio";
	}
	if($valor==7){
		$resultado="Julio";
	}
	if($valor==8){
		$resultado="Agosto";
	}
	if($valor==9){
		$resultado="Septiembre";
	}
	if($valor==10){
		$resultado="Octubre";
	}
	if($valor==11){
		$resultado="Noviembre";
	}
	if($valor==12){
		$resultado="Diciembre";
	}
	return $resultado;
}

// DATOS TABLA POR COD
/////////////////////
function datosreg($codigo, $tabla, $campo, $campocod='cod'){
	$query=mysql_query("select ".$campo." as valor from ".$tabla." where ".$campocod."='".$codigo."';" );
	if(mysql_errno()!=0){
	$resultado=mysql_error();
	} else {
	while($rows=mysql_fetch_array($query)){
		$resultado=$rows["valor"];
	}
	}
	return $resultado;
}

//QUITAR CODIFICACION HTML ACENTOS, EÑES...

function quitar_html($cadena){
	$txt=str_replace("<br />",chr(13).chr(10),$cadena);
	$txt=str_replace("<br>",chr(13).chr(10),$txt);
	$txt=str_replace("<li>&nbsp;",chr(13).chr(10)."    • ",$txt);
	$txt=str_replace("<li>",chr(13).chr(10)."• ",$txt);
	$txt=str_replace("<br/>",chr(13).chr(10),$txt);
	$txt=str_replace("</p>",chr(13).chr(10),$txt);
	$txt=str_replace("<p>","",$txt);
	$txt=str_replace("</tr>",chr(13).chr(10),$txt);
	$txt=str_replace("</td>","  algo      ",$txt);
	$txt=str_replace("</table>",chr(13).chr(10),$txt);
	$txt=strip_tags($txt);
	$txt=str_replace("&nbsp;"," ",$txt);
	$txt=str_replace("&Aacute;","Á",$txt);
	$txt=str_replace("&aacute;","á",$txt);
	$txt=str_replace("&Eacute;","É",$txt);
	$txt=str_replace("&eacute;","é",$txt);
	$txt=str_replace("&Iacute;","Í",$txt);
	$txt=str_replace("&iacute;","í",$txt);
	$txt=str_replace("&Oacute;","Ó",$txt);
	$txt=str_replace("&oacute;","ó",$txt);
	$txt=str_replace("&Uacute;","Ú",$txt);
	$txt=str_replace("&uacute;","ú",$txt);
	$txt=str_replace("&Ntilde;","Ñ",$txt);
	$txt=str_replace("&ntilde;","ñ",$txt);
	$txt=str_replace("&quot;",'"',$txt);
	$txt=str_replace("&ordf;",'ª',$txt);
	$txt=str_replace("&ordm;",'º',$txt);
	$txt=str_replace("&amp;",'&',$txt);
	$txt=str_replace("&bull;",'•',$txt);
	$txt=str_replace("&euro;",'€',$txt);
	
	return $txt;
}

//CONVERSOR A MAYUSCULAS INCLUYENDO LETRAS CON ACENTOS
function fullUpper($string){
  return strtr(strtoupper($string), "àáâãäåæçèéêëìíîïðñòóôõöøùúüº-_", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÜº-_");
} 

function titulos($cadena){
	for($i=0;$i<strlen($cadena);$i++){
	 $letra=substr($cadena,$i,1);
	 if($letra=='á'){ $letra='Á';}
	 if($letra=='é'){ $letra='É';}
	 if($letra=='í'){ $letra='Í';}
	 if($letra=='ó'){ $letra='Ó';}
	 if($letra=='ú'){ $letra='Ú';}
	 if($letra=='ñ'){ $letra='Ñ';}
	 $texto.=$letra;
	}
	$resultado=strtoupper($texto);
	return $resultado;
}


$saltt = "|#€7`¬23ads4ook26";
$saltCookie = "|@#26e+ç´|@#d";
 
/**
 * Comprueba que exista una sesion o una cookie en la página de login
 *
 *
 */
function seguridadIndex()
{
	 
	if (isset($_SESSION['codusuario']))
	{
	 
	header("Location: correcto.php");
	exit();
	}
	else if( isset($_COOKIE['identificado']))
	{
	$cookie = limpiar($_COOKIE['identificado']);
	$idusuario = comprobarCookie($cookie);
	if(!$idusuario)
	{
	header("Location: correcto.php");
	exit();
	}
	}
}
 
/**
 * Comprueba que exista una sesion o una cookie, sino redirige al login
 *
 * @return int estado
 */
function seguridad(){
	if (isset($_SESSION['codusuario'])){
		return;
	}else if( isset($_COOKIE['identificado'])){
		$cookie = limpiar($_COOKIE['identificado']);
		$idusuario = comprobarCookie($cookie);
		if(!$idusuario)	{
			echo "<script language='javascript'> document.location.href='login.php' </script>";
			exit();
		}
	}else{
		echo "<script language='javascript'> document.location.href='login.php' </script>";
		exit();
	}
}
 
/**
 * Comprueba que la cookie sea validad en nuestra BD
 *
 * @param string $cookie
 * @return int idUsuario
 */
function comprobarCookie($cookie)
{
	$conexion=conectar();
	$sql = "select * from users where cookie='".mysql_escape_string($cookie)."' and validez>'".date("Y-m-d h:i:s")."'";
	$result = mysql_query($sql,$conexion);
	 
	if(!$result || mysql_affected_rows()<1){
		return false;
	}else{
		$row = mysql_fetch_array($result);
		$_SESSION['codusuario']=$row['cod'];
		$_SESSION['usuario'] = $row['user'];
		$_SESSION['name'] = $row['name'];
		$_SESSION['last_login'] = strtotime($row['last_login']);
		$_SESSION['actual_login'] = strtotime($row['actual_login']);
		$_SESSION['last_ip'] = $row['last_ip'];
		$_SESSION['ip'] = $row['ip'];
		$_SESSION['email'] = $row['email'];
		return $row['cod'];
	}
}
 
/**
 * Registra un usuario con seguridad
 *
 * @global string $saltt
 * @param string $user
 * @param string $pass
 * @return int
 */
function registrarUsuario($user,$pass)
{
	$user = mysql_escape_string($user);
	$pass = mysql_escape_string($pass);
	if(strlen($user)<4 || strlen($pass)<4) return -3;
	 
	global $saltt;
	$pass = sha1($saltt.md5($pass));
	 
	$conexion=conectar();
	$sql1 = "select cod from users where UPPER(user)='".strtoupper($user)."'";
	$result1 = mysql_query($sql1,$conexion);
	if(mysql_affected_rows()>0) return -2; //user repetido
	 
	$sql = "insert into users (user,pass) values ('".$user."','".$pass."')";
	$result = mysql_query($sql,$conexion);
	 
	if($result) return 1; //registro correcto
	else return -2; //error
}
 
/**
 * Comprueba y el user y pass son correcto. En caso de querer ser recordado en el pc, crea la cookie
 *
 * @global string $saltt
 * @global string $saltCookie
 * @param string $user
 * @param string $pass
 * @param bool $recordarme
 * @return int estado
 */
function login ($user,$pass,$recordarme)
{
	$user = mysql_escape_string($user);
	$pass = mysql_escape_string($pass);
		 
	global $saltt;
	$pass = sha1($saltt.md5($pass));
error_log($sql);
	$conexion=conectar();
	$sql = "select * from users where UPPER(user)='".strtoupper($user)."' and pass='".$pass."'";
error_log($sql);
	$result = mysql_query($sql,$conexion);

	if(mysql_affected_rows()<=0 || !$result) return -1; //user repetido
	 
	$row = mysql_fetch_array($result);
	$cod = $row['cod'];
	$sql = "UPDATE users SET last_login='".$row['actual_login']."', actual_login=FROM_UNIXTIME(".time()."), last_ip='".$row['ip']."', ip='".$_SERVER['REMOTE_ADDR']."' WHERE cod='".$row['cod']."';";
	//echo $sql;
	$result2 = mysql_query($sql,$conexion);
	if (!$result2) {
		die('Invalid query: ' . mysql_error());
	}
	$result_tmp = mysql_query("SELECT * FROM users WHERE cod='".$row['cod']."';",$conexion);
	$row = mysql_fetch_assoc($result_tmp);
	
	$_SESSION['codusuario']=$cod;
	$_SESSION['usuario'] = $row['user'];
	$_SESSION['name'] = $row['name'];
	$_SESSION['last_login'] = strtotime($row['last_login']);
	$_SESSION['actual_login'] = strtotime($row['actual_login']);
	$_SESSION['last_ip'] = $row['last_ip'];
	$_SESSION['ip'] = $row['ip'];
	$_SESSION['email'] = $row['email'];
	 
	if($recordarme){
	global $saltCookie;
	 
	$cookie = sha1($saltCookie.md5($cod.date("Y-d-m h:i:s")));
	 
	$sql2 = "update users set cookie='".$cookie."',validez=DATE_ADD(now(),INTERVAL 1440 MINUTE) where `cod`='".$cod."'";
	$result2 = mysql_query($sql2,$conexion);
	 
	setCookie("identificado",$cookie,time()+86400,'/'); //cookie 60min
	}
	$_SESSION['codusuario']=$cod;
	 
	return true;
}
 
function destruirCookie($cookie)
{
	if(!isset($_SESSION['codusuario'])) return;
	else $idusuario = $_SESSION['codusuario'];
	 
	$conexion=conectar();
	$sql = "update users set validez=DATE_SUB(now(),INTERVAL 60 MINUTE) where `cod`='".$idusuario."'";
	$result = mysql_query($sql2,$conexion);
	if(mysql_affected_rows()>0) return true; //cookie puesta invalida
	else return false;
 
}
 
/**
 *
 * @param string $valor
 * @return string string limpiado de fallos de seguridad
 */
function limpiar($valor){
	$valor = strip_tags($valor);
	$valor = stripslashes($valor);
	$valor = htmlentities($valor);
	return $valor;
}
?>
