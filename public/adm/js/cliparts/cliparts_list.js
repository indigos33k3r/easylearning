var table;
var page;
var ClipartsList = function() {
	return {
		init : init
	}

	function init() {
		table = $('#clipartsTable').DataTable({
			"dom": "<'dt-toolbar'<'col-xs-12 col-sm-4 tableSearchBar'f><'col-xs-12 col-sm-3'l><'#category-select.col-xs-12 col-sm-3'><'col-xs-12 col-sm-2 pull-right'B><'col-sm-6 col-xs-6 hidden-xs'T>r>"
					+ "t" +	"<'dt-toolbar-footer'<'col-xs-12 col-sm-6 pull-right'p>>",
			"oLanguage": {
				"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
			},
			"buttons": [
	            {
                    extend: 'excelFlash',
                    filename: 'Clip_Arts',
                }
	        ]
		});
	}
}

$(function() {
 	page = new ClipartsList();
 	page.init();

 	$("#deleteConfirmationModal #deleteClipartConfirmed").on('click', function() {
 		var id = $("#deleteConfirmationModal #clipartId").val();
 		$("#deleteClipartForm-" + id).submit();
 	});
});

function showDeleteModal(clipartName, clipartId) {
	$("#deleteConfirmationModal #clipartName").html(clipartName);
	$("#deleteConfirmationModal #clipartId").val(clipartId);
	$("#deleteConfirmationModal").modal('show');
}
