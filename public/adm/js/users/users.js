var CustomersPage = function() {
	return {
		init : init
	}

	function init() {
		

		$('#usersTable').dataTable({
			dom: "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-xs-12 col-sm-6'B><'col-sm-6 col-xs-6 hidden-xs'T>r>",
			"oLanguage": {
				"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
			},		
	        buttons: [
	            {
                    extend: 'excelFlash',
                    filename: 'Customers'
                },
	        ]
		});
	}
}

$(function() {
 	var page = new CustomersPage();
 	page.init();
});
