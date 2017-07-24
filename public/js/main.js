$(function() {	
	// var header_height  = $(".header-top").outerHeight(); 
	// var footer_height  = $("#footer").outerHeight(); 
	// var browser_height = $(window).height(); //browser page height
	// var menu_height    = $("#main-menu").outerHeight();	
	// //set content page height	
	// if(menu_height != undefined){
	// 	menu_height +=25;
	// 	$('.content').outerHeight(browser_height - header_height - footer_height - menu_height);
	// }
	// else
	// 	$('.content').outerHeight(browser_height - header_height - footer_height);


	if($('#header-login-form').length > 0)
		initHeaderLoginForm();
})

function initHeaderLoginForm() {
	$('#header-login-form').validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: {
				required: true
			}
		},
		submitHandler: function(){
			$.post(BASE_URL+'/login', $('#header-login-form').serializeArray(), function(data) {
				if (data == true) {
					window.location.href = BASE_URL+"/home";
				} else if (data == false) {
					$("#header-login-error").removeClass('hidden');
				} else if (data == "unconfirmed") {
					$("#header-login-unconfirmed").removeClass('hidden');
				}
			});

		}
	});
	 $("#header-login-form input.form-control").on('focus', function() {
 		if(!$("#header-login-error").hasClass('hidden')) {
 			$("#header-login-error").addClass('hidden');
 		}
 		if(!$("#header-login-unconfirmed").hasClass('hidden')) {
 			$("#header-login-unconfirmed").addClass('hidden');
 		}
 	})
}