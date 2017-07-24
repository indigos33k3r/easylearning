var LoginPage = function() {
	return {
		init : init
	}

	function init() {
		$('#login-form').validate({
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
				$.post(BASE_URL+'/login', $('#login-form').serializeArray(), function(data) {
					console.log(data);
					if (data == true) {
						window.location.href = BASE_URL+"/home";
					} else if (data == false) {
						$("#login-error").removeClass('hidden');
					} else if (data == "unconfirmed") {
						$("#login-unconfirmed").removeClass('hidden');
					}
				});

			}
		});

		// $('#resetPasswordForm').validate({
		// 	rules : {
		// 		'email': {
		// 			required: true,
		// 			email: true
		// 		}
		// 	},
		// 	submitHandler: function() {
		// 		$('#resetPasswordForm [type=submit]').attr('disabled', 'disabled');
		// 		$.post(BASE_URL + '/admin/resetPassword', $('#resetPasswordForm').serializeArray(), function(data) {
		// 			if (data == true) {
		// 				$('#passwordResetedModal').modal();
		// 			} else if (data == "false") {
		// 				alert('email not found');
		// 			}

		// 			$("#resetPasswordForm").find("button[type=reset]").click();
		// 			$('#resetPasswordForm [type=submit]').removeAttr('disabled');
		// 		});

		// 	}
		// });
	}
}

$(function($) {
 	var page = new LoginPage();
 	page.init();
 	$("input.form-control").on('focus', function() {
 		if(!$("#login-error").hasClass('hidden')) {
 			$("#login-error").addClass('hidden');
 		}
 		if(!$("#login-unconfirmed").hasClass('hidden')) {
 			$("#login-unconfirmed").addClass('hidden');
 		}
 	})
});