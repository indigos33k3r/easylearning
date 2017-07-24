var LoginPage = function() {
	return {
		init : init
	}

	function init() {
		$('#resetPasswordForm').validate({
			rules : {
				'email': {
					required: true,
					email: true
				}
			},
			submitHandler: function() {
				$('#resetPasswordForm [type=submit]').attr('disabled', 'disabled');
				$("#loading-gif").removeClass('hidden');
				$.post(BASE_URL + '/admin/askResetPassword', $('#resetPasswordForm').serializeArray(), function(data) {
					console.log(data);
					if (data == "true") {
						// $('#infoMessage').removeClass('hidden');
						$("#email-sent").modal('show');
					} else if (data == "false") {
						$('#errorMessage').removeClass('hidden');
					}
					$("#loading-gif").addClass('hidden');
					$("#resetPasswordForm").find("button[type=reset]").click();
					$('#resetPasswordForm [type=submit]').removeAttr('disabled');
				});

			}
		});
	}
}

$(function($) {
 	var page = new LoginPage();
 	page.init();
});
