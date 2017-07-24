var page;
var ShapesList = function() {
	return {
		init : init
	}

	function init() {
		table = $('#shapesTable').DataTable({
			"dom": "<'dt-toolbar'<'col-xs-12 col-sm-4 tableSearchBar'f><'col-xs-12 col-sm-3'l><'#category-select.col-xs-12 col-sm-3'><'col-xs-12 col-sm-2 pull-right'B><'col-sm-6 col-xs-6 hidden-xs'T>r>"
					+ "t" +	"<'dt-toolbar-footer'<'col-xs-12 col-sm-6 pull-right'p>>",
			"oLanguage": {
				"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
			},
			"buttons": [
	            {
                    extend: 'excelFlash',
                    filename: 'Shapes',
                }
	        ]
		});
		$('[data-toggle="tooltip"]').tooltip();
	}
}

$(function() {
 	page = new ShapesList();
 	page.init();
 	$("#deleteConfirmationModal #deleteShapeConfirmed").on('click', function() {
 		var id = $("#deleteConfirmationModal #shapeId").val();
 		$("#deleteShapeForm-"+id).submit();
 	});
});

function showDeleteModal(shapeName, shapeId) {
	$("#deleteConfirmationModal #shapeName").html(shapeName);
	$("#deleteConfirmationModal #shapeId").val(shapeId);
	$("#deleteConfirmationModal").modal('show');
}