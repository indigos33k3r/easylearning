var table;
var TemplatesList = function() {
	return {
		init : init
	}

	function init() {
		$('#templatesTable').DataTable({
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
 	var page = new TemplatesList();
 	page.init();
 	$("#deleteConfirmationModal #deleteTemplateConfirmed").on('click', function() {
 		var id = $("#deleteConfirmationModal #templateId").val();
 		$("#deleteTemplateForm-" + id).submit();
 	}); 	
});

function showDeleteModal(templateName, templateId) {
	$("#deleteConfirmationModal #templateName").html(templateName);
	$("#deleteConfirmationModal #templateId").val(templateId);
	$("#deleteConfirmationModal").modal('show');
}
