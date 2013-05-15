$(document).ready(function(){
    $("#buscar_invoice").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var nombre = $("#name").attr("value");
		var numero = $("#num").attr("value");
		var anio = $("#year").attr("value");
		var factura_ini = $("#invoice_ini").attr("value").replace(/\//g, '-');
		var factura_fin = $("#invoice_fin").attr("value").replace(/\//g, '-');
		$("#result_searcher").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_invoice.php",{tab:"buscar",name:nombre,num:numero,year:anio,invoice_ini:factura_ini,invoice_fin:factura_fin},mostrarBusqueda, "json"); 
		
		return false;  
	});
	
	$("#reset").click(function(e) {
		$("#result_searcher").html('');
		$("#result_edit").html('');
		limpiaForm("#form_invoice");
		e.preventDefault();
	  	e.stopPropagation();
	});
  
});

function Editarusuario()
{
	$(".download").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		$.post("funciones/configuracion_invoice.php",{tab:"download",cod:vcod},
		   function(data){
			  if(data.status=="false"){
				  alert("Error download");
			  }else{
				  window.open('invoices/' + data.invoice);
			  }
		   }, "json"); 
		
		return false;  
	});
	
	$(".forward").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Invoice forwarded to member?")){
			$.post("funciones/configuracion_invoice.php",{tab:"forward",cod:vcod},
				   function(data){
					  if(data.status=="false"){
						  alert("Error forward");
					  }else{
						  alert("Invoice sent successfully");
					  }
				   }, "json"); 
		}
		return false;  
	});
	
	$(".eliminar-invoice").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Erase invoice?")){
			$.post("funciones/configuracion_invoice.php",{tab:"eliminar_factura",cod:vcod},
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
		var numero = $("#num").attr("value");
		var anio = $("#year").attr("value");
		var factura_ini = $("#invoice_ini").attr("value").replace(/\//g, '-');
		var factura_fin = $("#invoice_fin").attr("value").replace(/\//g, '-');
		var vorden = "ASC";
		var vcampo = $(this).parent().attr("class");
		$("#result_searcher").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_invoice.php",{tab:"buscar_ordenado",name:nombre,num:numero,year:anio,invoice_ini:factura_ini,invoice_fin:factura_fin,orden:vorden,campo:vcampo},mostrarBusqueda, "json"); 
		e.preventDefault();
	  	e.stopPropagation();
	});
	
	$(".buscar_campo_ordenado_desc").click(function(e) {
		var nombre = $("#name").attr("value");
		var numero = $("#num").attr("value");
		var anio = $("#year").attr("value");
		var factura_ini = $("#invoice_ini").attr("value").replace(/\//g, '-');
		var factura_fin = $("#invoice_fin").attr("value").replace(/\//g, '-');
		var vorden = "DESC";
		var vcampo = $(this).parent().attr("class");
		$("#result_searcher").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_invoice.php",{tab:"buscar_ordenado",name:nombre,num:numero,year:anio,invoice_ini:factura_ini,invoice_fin:factura_fin,orden:vorden,campo:vcampo},mostrarBusqueda, "json");
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
	}
}