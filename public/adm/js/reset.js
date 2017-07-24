var ProfilePage = function() {
	return {
		init : init
	}

	function init() {

		$('#resetPasswordForm').validate({
			rules : {
				email: {
					required: true,
					minlength: 4
				},
				password: {
					required: true,
					minlength: 4
				},
				cpassword: {
					required: true,
					equalTo: '#password'
				}
			},
			submitHandler: function() {
				$('#resetPasswordForm [type=submit]').attr('disabled', 'disabled');
				$.post(BASE_URL + '/admin/resetPassword', $('#resetPasswordForm').serializeArray(), function(data) {
					if (data == "true") {
						window.location.href = "home";
					} else if (data == "false") {
						alert('error');
					}

					$("#resetPasswordForm").find("button[type=reset]").click();
					$('#resetPasswordForm [type=submit]').removeAttr('disabled');
				});

			}
		});
	}
}

$(function($) {
 	var page = new ProfilePage();
 	page.init();
});