$(function() {
	
	$(".action-buttons").on('click', function() {
		$("#preview-profile").toggleClass('hidden');
		if($(this).hasClass('edit-p') )
			$("#edit-profile").toggleClass('hidden');
		else {
			if($(this).hasClass("change-p")) 
				$("#change-password").toggleClass('hidden');
			else {
				if(!$("#edit-profile").hasClass('hidden')) 		$("#edit-profile").toggleClass('hidden');
				if(!$("#change-password").hasClass('hidden'))	$("#change-password").toggleClass('hidden');
			}
		}
	})
	$("#update-profile-form");

	initForms();
	if($("#session-message").length > 0) {
		initFadeMessage();
	}
})

function initForms() {
	// update profile form
	$('#update-profile-form').validate({
		rules: {				
			name: {
				required: true,
				minlength: 3,
			},
			phone: {
				required: true,
			},
		},
		messages: {
			name: {
				remote: "This username is taken"
			},
		},
		submitHandler: function(){
			var userId = $("#user-id").val();
			$.post(BASE_URL+'/profile/'+userId, $('#update-profile-form').serializeArray(), function(data) {
				if (data != null) {
					window.location.reload();
				} else if (data == false) {
						// $("#register-error").removeClass('hidden');
					}
				});

		}
	});
	//change password form 
	$('#change-password-form').validate({
		rules: {				
			opassword: {
				required: true,
				minlength: 6,
			},
			password: {
				required: true,
				minlength: 6,
			},
			cpassword: {
				required: true,
				minlength: 6,
				equalTo: "#password"
			}
		},
		submitHandler: function(){
			var userId = $("#user-id").val();
			$.post(BASE_URL+'/profile/'+userId, $('#change-password-form').serializeArray(), function(data) {
				if (data == true) {
					window.location.reload();
				} else if (data == "wrong_password") {
						// $("#register-error").removeClass('hidden');
						$("#old-password-error").toggleClass('hidden');
					}
				});

		}
	});

}


function initFadeMessage() {
	setTimeout(function(){
		$("#session-message").fadeOut("slow");
	}, 5000)
}