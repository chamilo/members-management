$(document).ready(function(){
    // validate form on keyup and submit
    var validator = $("#memberform").validate({
    rules: {
    name: "required",
    surname: "required",
    email: {
    required: true,
    email: true
    },
    country: "required",
    language: "required",
	phone: "required",
	renewal: "required",
	cuota: "required",
	type: "required",
	status: "required",
	institution: "required"
    },
    messages: {
    name: "Enter name",
    lastname: "Enter surname",
    email: {
    required: "Please enter a valid email address",
    minlength: "Please enter a valid email address"
    },
	country: "Choose country",
	language: "Choose language",
	phone: "Enter phone",
	renewal: "Enter renewal date",
	couta: "Enter cuota",
    type: "Choose type of member",
	status: "Choose status",
	institution: "Enter institution or company"
    },
    // the errorPlacement has to take the layout into account
    errorPlacement: function(error, element) {
    error.insertAfter(element.parent().find('label:first'));
    },
    // specifying a submitHandler prevents the default submit, good for the demo
    //submitHandler: function() {
    //alert("Data submitted!");
    //},
    // set new class to error-labels to indicate valid fields
    success: function(label) {
    // set &nbsp; as text for IE
    label.html("&nbsp;").addClass("ok");
    }
    });
  
  	$("#type").change(function(){
		var tipo = $(this).attr("value");
		if(tipo=='2' || tipo=='5'){
			$("#company").show();
			$("#institution").removeAttr('disabled');

		}else{
			$("#company").hide();
			$("#institution").attr("disabled","disabled");
		}						  
	});
  
});
