var LoginPage = function() {
	return {
		init : init
	}

	function init() {
		$('#loginForm').validate({
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
				$('#loginForm [type=submit]').attr('disabled', 'disabled');

				$.post('login', $('#loginForm').serializeArray(), function(data) {
					if (data == true) {
						window.location.href = "home";
					} else if (data == "false") {
						$('#login-error').removeClass('hidden');
						$('#loginForm [type=submit]').removeAttr('disabled');
						$("#loginForm").find("button[type=reset]").click();
					}
				});

			}
		});
	}
		
}

$(function($) {
 	var page = new LoginPage();
 	page.init();
 	$("#loginForm input").change(function() {
 		$('#login-error').addClass('hidden');
 	})
});