var ProfilePage = function() {
	return {
		init : init
	}

	function init() {

		$('#changePasswordForm').validate({
			rules : {
				oldPassword: {
					required: true,
					minlength: 4
				},
				newPassword: {
					required: true,
					minlength: 4
				},
				cpassword: {
					required: true,
					equalTo: '#newPassword'
				}
			},
			submitHandler: function() {
				$('#changePasswordForm [type=submit]').attr('disabled', 'disabled');
				$.post(BASE_URL + '/admin/changePassword', $('#changePasswordForm').serializeArray(), function(data) {
					if (data == "true") {
						// $('#successMessage').removeClass('hidden');
						$("#change-success").modal('show');

					} else if (data == "false") {
						$('#errorMessage').removeClass('hidden');
					}

					$("#changePasswordForm").find("button[type=reset]").click();
					$('#changePasswordForm [type=submit]').removeAttr('disabled');
				});

			}
		});
	}
}

$(function($) {
 	var page = new ProfilePage();
 	page.init();
 	$("#changePasswordForm input[name='oldPassword']").on('focus', function() {
 		if(!$("#errorMessage").hasClass('hidden'))	$("#errorMessage").addClass('hidden');
 	})
});