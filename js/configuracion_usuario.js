$(document).ready(inicializarEventos);

function inicializarEventos()
{
	$("#mostrarclave").click(function() {
		// $("#usuarioclave").attr("type","text");
		var $oldPassword = $("#clave");
		var $newPassword = $("<input type='text' size='30' name='clave' />")
								  .val($oldPassword.val())
								  .prependTo($oldPassword.parent());
		$oldPassword.remove();
		$newPassword.attr('id','clave');
		$("#mostrarclave").css({display:"none"});
		$("#ocultarclave").css({display:"inline"});
	});
	
	$("#ocultarclave").click(function() {
		// $("#usuarioclave").attr("type","text");
		var $oldPassword = $("#clave");
		var $newPassword = $("<input type='password' size='30' name='clave' />")
								  .val($oldPassword.val())
								  .prependTo($oldPassword.parent());
		$oldPassword.remove();
		$newPassword.attr('id','clave');
		$("#mostrarclave").css({display:"inline"});
		$("#ocultarclave").css({display:"none"});
	});
	
	$("#buscar_usuario").click(function(e) {
		// $("#usuarioclave").attr("type","text");
		var vusuario = $("#usuario").attr("value");
		var vemail = $("#email").attr("value");
				
		$("#contenido_buscar").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
	  	$.post("funciones/configuracion_usuario.php",{tab:"buscar",usuario:vusuario,email:vemail},mostrarResultado, "json"); 
	  
	  e.preventDefault();
	  e.stopPropagation();
	});
	
	$("#volverbuscar").click(function(e) {
		window.location = 'buscar-usuario.php'
	});
	
	$("#generaclave").click(function(e) {
		var vemail = $("#emailsignup").attr("value");
		//alert(vemail);
		$.post("funciones/configuracion_usuario.php",{tab:"recordar_correo",email:vemail},mostrarAviso, "json");
		e.preventDefault();
	  	e.stopPropagation();
	});
	
}

function Editarusuario()
{
	$('a.info-tooltip ').tooltip({
		track: true,
		delay: 0,
		fixPNG: true, 
		showURL: false,
		showBody: " - ",
		top: -35,
		left: 5
	});
	
	$(".eliminar-usuario").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Va a proceder a eliminar a un usuario")){
			$.post("funciones/configuracion_usuario.php",{tab:"eliminar_usuario",cod:vcod},mostrarRecarga, "json"); 
		}
		return false;  
	});
	
	$(".buscar_usuario_ordenado_asc").click(function(e) {
		// $("#usuarioclave").attr("type","text");
		var vusuario = $("#rusuario").attr("value");
		var vemail = $("#email").attr("value");
		var vorden = "ASC";
		var vcampo = $(this).parent().attr("class");
				
		$("#contenido_buscar").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_usuario.php",{tab:"buscar_ordenado",usuario:vusuario,email:vemail,orden:vorden,campo:vcampo},mostrarResultado, "json"); 
	  
	  e.preventDefault();
	  e.stopPropagation();
	});
	
	$(".buscar_usuario_ordenado_desc").click(function(e) {
		// $("#usuarioclave").attr("type","text");
		var vusuario = $("#rusuario").attr("value");
		var vemail = $("#email").attr("value");
		var vorden = "DESC";
		var vcampo = $(this).parent().attr("class");
				
		$("#contenido_buscar").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_usuario.php",{tab:"buscar_ordenado",usuario:vusuario,email:vemail,orden:vorden,campo:vcampo},mostrarResultado, "json");
	  
	  e.preventDefault();
	  e.stopPropagation();
	});
}

function mostrarResultado(datos)
{
	if(datos.status == 'false'){
		alert(datos.contenido);
		$("#contenido_buscar").html('');
	}else{
		$("#contenido_buscar").html(datos.contenido);
	}
	$(document).ready(Editarusuario);
	
}


function mostrarRecarga(datos)
{
	var pagina = "buscar-usuario.php?eliminar=SI";
	window.location = pagina;
}

function mostrarAviso(datos)
{
	alert(datos.contenido);
}