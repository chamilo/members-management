$(document).ready(function(){
    $("#buscar_user").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var usuario = $("#user").attr("value");
		$("#result_searcher").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
		$("#result_edit").html('');
		$.post("funciones/configuracion_setting.php",{tab:"buscar_user",campo:usuario}, mostrarBusqueda, "json"); 
		return false;  
	});
	
	$("#reset").click(function(e) {
		$("#result_searcher").html('');
		$("#result_edit").html('');
		limpiaForm("#form_searcher");
		e.preventDefault();
	  	e.stopPropagation();
	});
  
  	$("#new_user").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		$.post("funciones/configuracion_setting.php",{tab:"new_user"}, mostrarBusqueda, "json"); 
		return false;  
	});
	
	$("#type_message").change(function(e) {
		var vtype = $(this).attr("value");
		var vlang = $("#language").attr("value");
		if(vtype != '' && vlang != ''){
			$("#result_message").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
			$.post("funciones/configuracion_setting.php",{tab:"buscar_message",type:vtype,lang:vlang}, 
				   function(data){
						$("#result_message").html(data);   
						$(document).ready(Cargareditor);
				   }, "json"); 
		}
		e.preventDefault();
	  	e.stopPropagation();
	});
	
	$("#language").change(function(e) {
		var vtype = $("#type_message").attr("value");
		var vlang = $(this).attr("value");
		if(vtype != '' && vlang != ''){
			$("#result_message").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
			$.post("funciones/configuracion_setting.php",{tab:"buscar_message",type:vtype,lang:vlang}, 
				   function(data){
						$("#result_message").html(data);
						$(document).ready(Cargareditor);
				   }, "json"); 
		}
		e.preventDefault();
	  	e.stopPropagation();
	});
	
	$('textarea.tinymce').tinymce({
		// Location of TinyMCE script
		script_url : 'js/tiny_mce/tiny_mce.js',
		width : "100%",
		height: "300",
		// General options
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
	
		// Theme options
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
		theme_advanced_buttons3 : "insertdate,inserttime,preview,|,forecolor,backcolor",

		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
	
		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",
	
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
	});
	
	$("#field_invoice").dblclick(function(e){
		e.preventDefault();
	  	e.stopPropagation();
		var etiq = $(this).attr("value");
		var id = $("textarea[name='mbody']").attr("id");
		tinyMCE.execInstanceCommand( id, 'mceInsertContent', '', '{{'+etiq+'}}');
	});
	
	$(".guardar_invoice").click(function(){
		var id = $(this).attr("id");
		if(id == 'eheader'){
			
		}
		if(id=='ebody'){
			var mbody = $("#mbody").attr("value");
			$.post("funciones/configuracion_setting.php",{tab:"set_invoice",text:mbody,campo:'body'}, 
				   function(data){
					   if(data.status=="false"){
						   alert(date.contenido);
					   }else{
							alert("Body update");
						}
					}, "json");
		}
		if(id=='esignature'){
			
		}
		if(id=='efooter'){
			var mfooter = $("#footer").attr("value");
			$.post("funciones/configuracion_setting.php",{tab:"set_invoice",text:mfooter,campo:'footer'}, 
				   function(data){
					   if(data.status=="false"){
						   alert(date.contenido);
					   }else{
							alert("Footer update");
						}
					}, "json");
		}
	});
	
	$("#add_lang").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var selec = $("#lang_disp").attr("value");
		var valor = $("#lang_disp option:selected").text();
		var active = '1';
		$.post("funciones/configuracion_setting.php",{tab:"set_language",lang:selec,valor:active}, 
				   function(data){
					   if(data.status=="false"){
						   alert(date.contenido);
					   }else{
					    //quitar de una lista
					    $("#lang_disp option:selected").remove();
					    //poner en otra lista
						$("#lang_acti").append('<option value="'+selec+'">'+valor+'</option>');
						//actualizar por defecto
						$("#slang").append('<option value="'+selec+'">'+valor+'</option>');
						$("#language").append('<option value="'+selec+'">'+valor+'</option>');
					   }
					}, "json"); 
	});
	
	$("#del_lang").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var selec = $("#lang_acti").attr("value");
		var valor = $("#lang_acti option:selected").text();
		var active = '0';
		$.post("funciones/configuracion_setting.php",{tab:"set_language",lang:selec,valor:active}, 
				   function(data){
					   if(data.status=="false"){
						   alert(date.contenido);
					   }else{
					    //quitar de una lista
					    $("#lang_acti option:selected").remove();
					    //poner en otra lista
						$("#lang_disp").append('<option value="'+selec+'">'+valor+'</option>');
						//actualizar por defecto
						$("#slang option[value='"+selec+"']").remove();
						$("#language option[value='"+selec+"']").remove();
					   }
					}, "json"); 
	});
	
	$("#slang").change(function(){
		var vcod = $(this).attr("value");
		$("#mslang").html('');
		$.post("funciones/configuracion_setting.php",{tab:"set_default",lang:vcod}, 
				   function(data){
					   if(data.status=="false"){
						   alert(data.contenido);
					   }else{
					    //mensaje indicando que se ha actualizado
					    $("#mslang").html('<div class="box box-info closeable">Changed default language</div>');
					   }
					}, "json"); 
	});
	
	$("#avisorenovacion").change(function(){
		var cant = $(this).attr("value");
		$.post("funciones/configuracion_setting.php",{tab:"set_notice_renewal",valor:cant}, 
			function(data){
			   if(data.status=="false"){
				   alert(data.contenido);
			   }
			}, "json"); 
	});
	
	$("#senderemail").change(function(){
		var remitente = $(this).attr("value");
		$.post("funciones/configuracion_setting.php",{tab:"set_sender",valor:remitente}, 
			function(data){
			   if(data.status=="false"){
				   alert(data.contenido);
			   }
			}, "json"); 
	});
	
	$("#add_email_responsible_ren").click(function(){
		var correo = $("#emailresponsible_ren").attr("value");
		$.post("funciones/configuracion_setting.php",{tab:"add_email_renewal",email:correo},
			   function(data){
				   if(data.status=="false"){
						alert(data.contenido);
				   }else{
					    //mensaje indicando que se ha actualizado
					    $("#result_renewal").html(data.contenido);
						$(document).ready(iconosTablas);
				   }
			   }, "json");
	});
	
	$("#add_email_responsible_exp").click(function(){
		var correo = $("#emailresponsible_exp").attr("value");
		$.post("funciones/configuracion_setting.php",{tab:"add_email_expired",email:correo},
			   function(data){
				   if(data.status=="false"){
						alert(data.contenido);
				   }else{
					    //mensaje indicando que se ha actualizado
					    $("#result_expired").html(data.contenido);
						$(document).ready(iconosTablas);
				   }
			   }, "json");
	});
	
	$(".icon-elim").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Erase email?")){
			$.post("funciones/configuracion_setting.php",{tab:"eliminar_correo",cod:vcod},
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
	
	$("#add_new_type").click(function(){
		var vtipo = $("#typemembervalue").attr("value");
		$.post("funciones/configuracion_setting.php",{tab:"add_type",tipo:vtipo},
			   function(data){
				   if(data.status=="false"){
						alert(data.contenido);
				   }else{
					    //mensaje indicando que se ha actualizado
					    $("#result_type").html(data.contenido);
						$(document).ready(iconosTablas);
				   }
			   }, "json");
	});
	
	$(".icon-elim-type").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Erase member type?")){
			$.post("funciones/configuracion_setting.php",{tab:"eliminar_tipo",cod:vcod},
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
	
	$("#add_link").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		$.post("funciones/configuracion_setting.php",{tab:"formulario_add"},
			function(data){
				$("#edit_link").html(data);	
				$("#save_new_link").click(function(e){
					e.preventDefault();
	  				e.stopPropagation();
					var desc = $("#description").attr("value");
					var titl = $("#title_link").attr("value");
					var venlace = $("#link").attr("value");
					if( desc == '' || titl == '' || venlace == '' ){
						alert("Complete all fields");
					}else{
						$.post("funciones/configuracion_setting.php",{tab:"add_link",description:desc,title:titl,enlace:venlace},
							   function(data){
									$("#result_links").html(data);
									$("#edit_link").html('');
									$(document).ready(funcionlink);
							   }, "json"); 
					}					
				});
			}, "json"); 
	});
	
	$(".edit-link").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		$("#edit_link").html('<div class="center"><br /><img src="images/nyro/ajaxLoader.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_setting.php",{tab:"edit_link",cod:vcod},
			   function(data){
				   if(data.status == "false"){
					   	alert("Problem for edit");
				 		$("#edit_link").html('');
				   }else{
					   	$("#edit_link").html(data.contenido);
						$("#save_edit_link").click(function(e) {
							e.preventDefault();
							e.stopPropagation();
							var vcod = $("#link_edit #cod").attr("value");
							var desc = $("#link_edit #description").attr("value");
							var titl = $("#link_edit #title_link").attr("value");
							var enla = $("#link_edit #enlace").attr("value");
							if(desc == '' || titl == '' || enla == ''){
								alert("Complete all required fields");
							}else{
								$.post("funciones/configuracion_setting.php",{tab:"save_edit_link",cod:vcod,description:desc,title:titl,enlace:enla},
								function(data){
									if(data.status == "false"){
										alert("Error while editing");
									}else{
										$("#edit_link").html('');
										//Actualizar los 3 campos de la tabla que se ha editado
										alert("updated correctly");
										$("#"+data.cod).prev().prev().html(data.title);
										$("#"+data.cod).prev().html(data.description);
									}
								}, "json"); 
							}							
							return false;  
						});
				   }
			   },"json");
	
	});
	
	$(".icon-elim-link").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Erase link?")){
			$.post("funciones/configuracion_setting.php",{tab:"eliminar_link",cod:vcod},
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
});

function funcionlink(){
	$(".edit-link").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		$("#edit_link").html('<div class="center"><br /><img src="images/nyro/ajaxLoader.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_setting.php",{tab:"edit_link",cod:vcod},
			   function(data){
				   if(data.status == "false"){
					   	alert("Problem for edit");
				 		$("#edit_link").html('');
				   }else{
					   	$("#edit_link").html(data.contenido);
						$("#save_edit_link").click(function(e) {
							e.preventDefault();
							e.stopPropagation();
							var vcod = $("#link_edit #cod").attr("value");
							var desc = $("#link_edit #description").attr("value");
							var titl = $("#link_edit #title_link").attr("value");
							var enla = $("#link_edit #enlace").attr("value");
							if(desc == '' || titl == '' || enla == ''){
								alert("Complete all required fields");
							}else{
								$.post("funciones/configuracion_setting.php",{tab:"save_edit_link",cod:vcod,description:desc,title:titl,enlace:enla},
								function(data){
									if(data.status == "false"){
										alert("Error while editing");
									}else{
										$("#edit_link").html('');
										//Actualizar los 3 campos de la tabla que se ha editado
										alert("updated correctly");
										$("#"+data.cod).prev().prev().html(data.title);
										$("#"+data.cod).prev().html(data.description);
									}
								}, "json"); 
							}							
							return false;  
						});
				   }
			   },"json");
	
	});
	
	$(".icon-elim-link").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Erase link?")){
			$.post("funciones/configuracion_setting.php",{tab:"eliminar_link",cod:vcod},
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
}

function iconosTablas(){
	$("#add_email_responsible_ren").click(function(){
		var correo = $("#emailresponsible_ren").attr("value");
		$.post("funciones/configuracion_setting.php",{tab:"add_email_renewal",email:correo},
			   function(data){
				   if(data.status=="false"){
						alert(data.contenido);
				   }else{
					    //mensaje indicando que se ha actualizado
					    $("#result_renewal").html(data.contenido);
						$(document).ready(iconosTablas);
				   }
			   }, "json");
	});
	
	$("#add_email_responsible_exp").click(function(){
		var correo = $("#emailresponsible_exp").attr("value");
		$.post("funciones/configuracion_setting.php",{tab:"add_email_expired",email:correo},
			   function(data){
				   if(data.status=="false"){
						alert(data.contenido);
				   }else{
					    //mensaje indicando que se ha actualizado
					    $("#result_expired").html(data.contenido);
						$(document).ready(iconosTablas);
				   }
			   }, "json");
	});
	
	$(".icon-elim").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Erase email?")){
			$.post("funciones/configuracion_setting.php",{tab:"eliminar_correo",cod:vcod},
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
	
	$("#add_new_type").click(function(){
		var vtipo = $("#typemembervalue").attr("value");
		$.post("funciones/configuracion_setting.php",{tab:"add_type",tipo:vtipo},
			   function(data){
				   if(data.status=="false"){
						alert(data.contenido);
				   }else{
					    //mensaje indicando que se ha actualizado
					    $("#result_type").html(data.contenido);
						$(document).ready(iconosTablas);
				   }
			   }, "json");
	});
	
	$(".icon-elim-type").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Erase member type?")){
			$.post("funciones/configuracion_setting.php",{tab:"eliminar_tipo",cod:vcod},
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
}

function Cargareditor(){
	$('textarea.tinymce').tinymce({
		// Location of TinyMCE script
		script_url : 'js/tiny_mce/tiny_mce.js',
		width : "200",
		// General options
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
	
		// Theme options
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
		theme_advanced_buttons3 : "insertdate,inserttime,preview,|,forecolor,backcolor",

		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
	
		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",
	
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
	});
	
	$("#save_message").click(function(e) {
		var vmessage = $("textarea[name='message']").attr("value");
		var vsubject = $("#subject").attr("value");
		var identi = $("textarea[name='message']").attr("id");
		var vtype = $("#typem").attr("value");
		var vlang = $("#langm").attr("value");
		$.post("funciones/configuracion_setting.php",{tab:"guardar_message",type:vtype,lang:vlang,message:vmessage,id:identi,subject:vsubject}, 
				   function(data){
					   if(data.status=="false"){
						   alert(data.contenido);
					   }else{
						$("#result_message").html(data.contenido);
					   }
					}, "json");
		e.preventDefault();
	  	e.stopPropagation();
		});
	
	$("#field").dblclick(function(e){
		e.preventDefault();
	  	e.stopPropagation();
		var etiq = $(this).attr("value");
		var id = $("textarea[name='message']").attr("id");
		tinyMCE.execInstanceCommand( id, 'mceInsertContent', '', '{{'+etiq+'}}');
	});
}

function Editarusuario()
{
	$(".icon-1").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		$("#result_edit").html('<div class="center"><br /><img src="images/nyro/ajaxLoader.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_setting.php",{tab:"edit_member",cod:vcod},
			   function(data){
				   if(data.status == "false"){
					   	alert("Problem for edit");
				 		$("#result_edit").html('');
				   }else{
					   	$("#result_edit").html(data.contenido);
						$("#save_edit").click(function(e) {
							e.preventDefault();
							e.stopPropagation();
							var vcod = $("#user_edit #cod").attr("value");
							var usuario = $("#user_edit #user").attr("value");
							var clave = $("#user_edit #password").attr("value");
							var correo = $("#user_edit #email").attr("value");
							var nombre = $("#user_edit #name").attr("value");
							if(usuario == '' || correo == '' || nombre == ''){
								alert("Complete all required fields");
							}else{
								$.post("funciones/configuracion_setting.php",{tab:"editar",cod:vcod,name:nombre,user:usuario,email:correo,password:clave},
								function(data){
									if(data.status == "false"){
										alert("Error while editing");
									}else{
										$("#result_edit").html('');
										//Actualizar los 3 campos de la tabla que se ha editado
										alert("updated correctly");
										$("#"+data.cod).prev().prev().prev().html(data.user);
										$("#"+data.cod).prev().prev().html(data.name);
										$("#"+data.cod).prev().html(data.email);
									}
								}, "json"); 
							}							
							return false;  
						});
				   }
			   },"json");
	});
	
	$(".eliminar-usuario").click(function(e) {
		e.preventDefault();
	  	e.stopPropagation();
		var vcod = $(this).parent().attr("id");
		if(confirm("Erase user?")){
			$.post("funciones/configuracion_setting.php",{tab:"eliminar_usuario",cod:vcod},
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
		var usuario = $("#user").attr("value");
		var vorden = "ASC";
		var vcampo = $(this).parent().attr("class");
		$("#result_searcher").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_setting.php",{tab:"buscar_ordenado",bcampo:usuario,orden:vorden,campo:vcampo},mostrarBusqueda, "json"); 
		e.preventDefault();
	  	e.stopPropagation();
	});
	
	$(".buscar_campo_ordenado_desc").click(function(e) {
		var usuario = $("#user").attr("value");
		var vorden = "DESC";
		var vcampo = $(this).parent().attr("class");
		$("#result_searcher").html('<div class="center"><br /><img src="images/loadingAnimation.gif" alt="cargando" /></div>');
		$.post("funciones/configuracion_setting.php",{tab:"buscar_ordenado",bcampo:usuario,orden:vorden,campo:vcampo},mostrarBusqueda, "json");
		e.preventDefault();
	  	e.stopPropagation();
	});
	
	$("#save_new").click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		var usuario = $("#user_new #user").attr("value");
		var clave = $("#user_new #password").attr("value");
		var correo = $("#user_new #email").attr("value");
		var nombre = $("#user_new #name").attr("value");
		if(usuario == '' || clave == '' || correo == '' || nombre == ''){
			alert("Complete all fields");
		}else{
			$.post("funciones/configuracion_setting.php",{tab:"add_user",name:nombre,user:usuario,email:correo,password:clave},
				function(data){
					if(data.status == "false"){
						alert(data.contenido);
					}else{
						$("#result_edit").html('');
						$("#result_searcher").html('');
						//Actualizar los 3 campos de la tabla que se ha editado
						alert("Added correctly");
					}
				}, "json"); 
		}
		return false;  
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