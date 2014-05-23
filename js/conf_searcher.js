$(document).ready(function(){
    $("#buscar").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var nombre = $("#name").attr("value");
		var vinstitution = $("#institution").attr("value");
		//var apellidos = $("#surname").attr("value");
		var vemail = $("#email").attr("value");
		var pais = $("#country").attr("value");
		var telefono = $("#phone").attr("value");
		var vquota = $("#quota").attr("value");
		var tipo = $("#type").attr("value");
		var estado = $("#status").attr("value");
		var lenguaje = $("#language").attr("value");
		var renovacion_ini = $("#renewal_ini").attr("value").replace(/\//g, '-');
		var renovacion_fin = $("#renewal_fin").attr("value").replace(/\//g, '-');
		var alta_ini = $("#arrival_ini").attr("value").replace(/\//g, '-');
		var alta_fin = $("#arrival_fin").attr("value").replace(/\//g, '-');
		$("#result_searcher").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
		$("#result_edit").html('');
		$.post("funciones/configuracion_searcher.php",{tab:"buscar",name:nombre,institution:vinstitution,email:vemail,country:pais,phone:telefono,quota:vquota,type:tipo,status:estado,language:lenguaje,renewal_ini:renovacion_ini,renewal_fin:renovacion_fin,arrival_ini:alta_ini,arrival_fin:alta_fin},mostrarBusqueda, "json"); 
		
		return false;  
	});
	
	$("#reset").click(function(e) {
		$("#result_searcher").html('');
		$("#result_edit").html('');
		limpiaForm("#form_searcher");
		e.preventDefault();
	  	e.stopPropagation();
	});
  
});

function Editarusuario()
{
	$("#renewal").datepicker({
  	    dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true
	});
	
	$(".icon-1").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		$("#result_edit").html('<div class="center"><br /><img src="img/nyro/ajaxLoader.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_searcher.php",{tab:"edit_member",cod:vcod},
			   function(data){
				   if(data.status == "false"){
					   	alert("Problem for edit");
				 		$("#result_edit").html('');
				   }else{
					   	$("#result_edit").html(data.contenido);
						$("#save_edit").click(function(e) {
							e.preventDefault();
							e.stopPropagation();
							var vcod = $("#member_edit #cod").attr("value");
							var nombre = $("#member_edit #name").attr("value");
							var apellidos = $("#member_edit #surname").attr("value");
							var vemail = $("#member_edit #email").attr("value");
							var pais = $("#member_edit #country").attr("value");
							var telefono = $("#member_edit #phone").attr("value");
							var vquota = $("#member_edit #quota").attr("value");
							var tipo = $("#member_edit #type").attr("value");
							var institucion = $("#member_edit #institution").attr("value");
							var direccion = $("#member_edit #address").attr("value");
							var cpostal = $("#member_edit #postal_code").attr("value");
							var nvat = $("#member_edit #vat").attr("value");
							var estado = $("#member_edit #status").attr("value");
							var lenguaje = $("#member_edit #language").attr("value");
							var renovacion = $("#member_edit #renewal").attr("value").replace(/\//g, '-');
							var comentarios = $("#member_edit #comment").attr("value");
							
							$.post("funciones/configuracion_searcher.php",{tab:"editar",cod:vcod,name:nombre,surname:apellidos,email:vemail,country:pais,phone:telefono,quota:vquota,type:tipo,institution:institucion,address:direccion,postal_code:cpostal,vat:nvat,status:estado,language:lenguaje,renewal:renovacion,comment:comentarios},
								function(data){
									if(data.status == "false"){
										alert("Error while editing");
									}else{
										$("#result_edit").html('');
										//Actualizar los 3 campos de la tabla que se ha editado
										alert("updated correctly");
										$("#"+data.cod).prev().prev().prev().prev().prev().prev().html(data.name);
										$("#"+data.cod).prev().prev().prev().prev().prev().html(data.surname);
										$("#"+data.cod).prev().prev().prev().prev().html(data.email);
										$("#"+data.cod).prev().prev().prev().html(data.renewal);
										$("#"+data.cod).prev().prev().html(data.type);
										$("#"+data.cod).prev().html(data.quota+' &euro;');
									}
								}, "json"); 
							
							return false;  
						});
						$("#member_edit #type").change(function(){
							var tipo = $(this).attr("value");
							if(tipo=='2' || tipo=='5'){
								$("#company").show();
								$("#institution").removeAttr('disabled');
					
							}else{
								$("#company").hide();
								$("#institution").attr("disabled","disabled");
							}						  
						});
						
						$("#renewal").datepicker({
							dateFormat: 'dd/mm/yy',
							changeMonth: true,
							changeYear: true
						});
				   }
			   },"json");
	});
	
	$(".renovar").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Update member?")){
			$.post("funciones/configuracion_searcher.php",{tab:"renovar_miembro",cod:vcod},
				   function(data){
					  if(data.status=="false"){
						  alert("Error update");
					  }else{
						  alert("updated correctly");
						  $("#"+data.cod).prev().prev().prev().html(data.renewal);					 		  
					  }
				   }, "json"); 
		}
		return false;  
	});
	
	$(".eliminar-usuario").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Erase member?")){
			$.post("funciones/configuracion_searcher.php",{tab:"eliminar_usuario",cod:vcod},
				   function(data){
					  if(data.status=="false"){
						  alert("Error erase");
					  }else{
						  $("#"+data.cod).parent().remove();					 		  
					  }
				   }, "json"); 
		}
		return false;  
	});
	
	$(".buscar_campo_ordenado_asc").click(function(e) {
		var nombre = $("#name").attr("value");
		var apellidos = $("#surname").attr("value");
		var vemail = $("#email").attr("value");
		var pais = $("#country").attr("value");
		var telefono = $("#phone").attr("value");
		var vquota = $("#quota").attr("value");
		var tipo = $("#type").attr("value");
		var estado = $("#status").attr("value");
		var lenguaje = $("#language").attr("value");
		var renovacion_ini = $("#renewal_ini").attr("value").replace(/\//g, '-');
		var renovacion_fin = $("#renewal_fin").attr("value").replace(/\//g, '-');
		var alta_ini = $("#arrival_ini").attr("value").replace(/\//g, '-');
		var alta_fin = $("#arrival_fin").attr("value").replace(/\//g, '-');
		var vorden = "ASC";
		var vcampo = $(this).parent().attr("class");
		$("#result_searcher").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
		$("#result_edit").html('');
		$.post("funciones/configuracion_searcher.php",{tab:"buscar_ordenado",name:nombre,surname:apellidos,email:vemail,country:pais,phone:telefono,quota:vquota,type:tipo,status:estado,language:lenguaje,renewal_ini:renovacion_ini,renewal_fin:renovacion_fin,arrival_ini:alta_ini,arrival_fin:alta_fin,orden:vorden,campo:vcampo},mostrarBusqueda, "json"); 
		e.preventDefault();
	  	e.stopPropagation();
	});
	
	$(".buscar_campo_ordenado_desc").click(function(e) {
		var nombre = $("#name").attr("value");
		var apellidos = $("#surname").attr("value");
		var vemail = $("#email").attr("value");
		var pais = $("#country").attr("value");
		var telefono = $("#phone").attr("value");
		var vquota = $("#quota").attr("value");
		var tipo = $("#type").attr("value");
		var estado = $("#status").attr("value");
		var lenguaje = $("#language").attr("value");
		var renovacion_ini = $("#renewal_ini").attr("value").replace(/\//g, '-');
		var renovacion_fin = $("#renewal_fin").attr("value").replace(/\//g, '-');
		var alta_ini = $("#arrival_ini").attr("value").replace(/\//g, '-');
		var alta_fin = $("#arrival_fin").attr("value").replace(/\//g, '-');
		var vorden = "DESC";
		var vcampo = $(this).parent().attr("class");
		$("#result_searcher").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
		$("#result_edit").html('');
		$.post("funciones/configuracion_searcher.php",{tab:"buscar_ordenado",name:nombre,surname:apellidos,email:vemail,country:pais,phone:telefono,quota:vquota,type:tipo,status:estado,language:lenguaje,renewal_ini:renovacion_ini,renewal_fin:renovacion_fin,arrival_ini:alta_ini,arrival_fin:alta_fin,orden:vorden,campo:vcampo},mostrarBusqueda, "json");
		e.preventDefault();
	  	e.stopPropagation();
	});
}

function limpiaForm(miForm) {
	// recorremos todos los campos que tiene el formulario
	$(':input', miForm).each(function() {
	var type = this.type;
	var tag = this.tagName.toLowerCase();
	//limpiamos los valores de los campos…
	if (type == 'text' || type == 'password' || tag == 'textarea')
	this.value = "";
	// excepto de los checkboxes y radios, le quitamos el checked
	// pero su valor no debe ser cambiado
	else if (type == 'checkbox' || type == 'radio')
	this.checked = false;
	// los selects le ponesmos el indice a -
	else if (tag == 'select')
	this.selectedIndex = -1;
	});
}

function mostrarBusqueda(data){
	if(data.status == "false"){
		alert("No result");
		$("#result_searcher").html('');
	}else{
		$("#result_searcher").html(data.contenido);
		$(document).ready(Editarusuario);
		$("#renewal").datepicker({
			dateFormat: 'dd/mm/yy',
			changeMonth: true,
			changeYear: true
		});
	}
}