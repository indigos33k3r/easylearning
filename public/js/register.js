var LoginPage = function() {
	return {
		init : init
	}

	function init() {
		$('#accountCreated').on('hidden.bs.modal', function () {
	    	window.location.href = BASE_URL + "/login";
		})
		$('#register-form').validate({
			rules: {				
				name: {
					required: true,
					minlength: 3,
				},
				email: {
					required: true,
					email: true,
					remote: {
						url: BASE_URL+"/register/remoteCheck",
						type:"post",
						data: {
							email: function() {
								return $("#email").val();
							},
							type: "email",
							_token: $("#register-form input[name='_token']").val(),
						},

					}
				},
				phone: {
					required: true
				},
				password: {
					required: true,
					minlength: 6,
				},
				password_confirmation: {
					required: true,
					minlength: 6,
					equalTo: "#password"
				}
			},
			messages: {
				email: {
					remote: "This email is already registered",
				},
			},
			submitHandler: function(){

				$.post(BASE_URL+'/register', $('#register-form').serializeArray(), function(data) {
					$("#register-form")[0].reset();
					if (data != null) {
						$('#accountCreated').modal('show');
						// window.location.href = BASE_URL+"/login";
					} else if (data == false) {
						// $("#register-error").removeClass('hidden');
					}
				});

			}
		});
	}
}

$(function($) {
 	var page = new LoginPage();
 	page.init();
 	$("input.form-control").on('focus', function() {
 		if(!$("#login-error").hasClass('hidden')) {
 			$("#login-error").addClass('hidden');
 		}
 		// $('label.error').each(function(el){
 		// 	if($(el).css('display') !== "none") {
 		// 		$(el).css('display', 'none');
 		// 	}
 		// })
 	})
});