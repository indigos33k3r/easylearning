var AdminsPage = function() {
	return {
		init : init
	}

	function init() {
		
		$('#adminsTable').dataTable({
			dom: "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-xs-12 col-sm-6'B><'col-sm-6 col-xs-6 hidden-xs'T>r>",
			"oLanguage": {
				"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
			},		
	        buttons: [
	            {
                    extend: 'excelFlash',
                    filename: 'Admins'
                },
	        ],
	        "columns": [
	            null,
	            null,
	            null,
	            { "orderable": false, width: 100 }
	        ]
		});
		

		$('#addAdminForm').validate({
			rules : {
				email: {
					required: true,
					email: true
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
				$('#addAdminForm [type=submit]').attr('disabled', 'disabled');
				$.post(BASE_URL + '/admin/admins', $('#addAdminForm').serializeArray(), function(data) {
					if (data == "true") {
						location.reload();
					} else if (data == "false") {
						alert('error');
					}

					$("#addAdminForm").find("button[type=reset]").click();
					$('#addAdminForm [type=submit]').removeAttr('disabled');
				});

			}
		});
	}
}

$(function() {
 	var page = new AdminsPage();
 	page.init();
});
