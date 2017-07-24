$(function(){
	if($("#email-form").length > 0)
		initEmailForm();
	if($("#reset-password-form").length > 0)
		initResetForm();
})

function initEmailForm() {
	$("#email-form").validate({
		rules:{
			email: {
				required: true,
				email: true,
				remote: {
					url: BASE_URL+"/password/reset/remoteCheck",
						type:"post",
						data: {
							email: function() {
								return $("#email").val();
							},
							type: "email",
							_token: $("#email-form input[name='_token']").val(),
						},
				}
			},
		},
		messages: {
			email: {
				remote: "No user with this email was found"
			}
		},
		submitHandler: function() {
			$("#email-form button[type='submit']").prop('disabled', true);
			$("#loading-gif").removeClass('hidden');
			$.post(BASE_URL+"/password/email", $("#email-form").serializeArray(), function(data){
				if(data != true) {
					$("#loading-gif").addClass('hidden');
					$("#email-form button[type='submit']").prop('disabled', false);
					$("#email-sent").modal('show');
					$("#email-sent").on('hide.bs.modal', function() {
						window.location.href = BASE_URL+"/login";
					});
				}
				else {

				}
			});
			
			
		}
	});
}

function initResetForm() {
	$("#reset-password-form").validate({
		rules:{
			password: {
				required: true,
				minlength: 6,
				// remote: {
				// 	url: "/password/reset/remoteCheck",
				// 		type:"post",
				// 		data: {
				// 			email: function() {
				// 				return $("#email").val();
				// 			},
				// 			type: "email",
				// 			_token: $("#email-form input[name='_token']").val(),
				// 		},
				// }
			},
			password_confirmation: {
				required: true,
				minlength: 6,
				equalTo: "#password"
			}
		},
		submitHandler: function() {

			$.post(BASE_URL+"/password/reset", $("#reset-password-form").serializeArray(), function(data){
				if(data == true) {
					$("#reset-success").modal('show');
					$("#reset-success").on('hide.bs.modal', function() {
						window.location.href = BASE_URL + "/login";
					});
						
				}
				else {

				}
			});
		}
	});
}
