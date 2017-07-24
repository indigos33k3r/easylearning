var EditShapePage = function() {
	return {
		init : init
	}

	function init(){
		var shapeId =  $("#shape-id").val();
		var myDropzone = new Dropzone("#editShapeForm #image", {
			url: BASE_URL+"/admin/shapes/"+shapeId,
			autoProcessQueue: false,
			paramName: "images",
			previewsContainer: "#preview-template",
			addRemoveLinks: true,
			maxFiles: 1,
			maxFilesize: 2, //MB
			// previewTemplate: document.getElementById('preview-template').innerHTML,
			accept:function(file, done) {
				if(file.type !== 'image/svg+xml'){
					done('File type not allowed. Only the .svg format is accepted.');
				}
				else{
					done();
				}
			}
		});
		myDropzone.on("maxfilesreached", function(file){
			// myDropzone.disable();
		});
		myDropzone.on("addedfile", function(file) {
			$("#preview-template").removeClass('hidden');
			$("#editShapeForm input[name='image']").val(file.name);
			$("#image").prop('disabled', true);
			$("#edit-preview").addClass('hidden');
		});
		myDropzone.on("sending", function(file, xhr, formData) {
			var fileNr = this.files.length;
			if(this.files[fileNr - 1] == file){
					var categoryIds = [];
					$("#editShapeForm select option:selected").each(function(el) {
						categoryIds.push($(this).val());	
					});
				formData.append('_token', $("#editShapeForm input[name='_token']").val());
				formData.append('_method', $("#editShapeForm input[name='_method']").val());
				formData.append('category_id', JSON.stringify(categoryIds));
				var active = $("#editShapeForm input[name='active']").prop('checked') == true ? "on" : "off";
				formData.append('active', $("#editShapeForm input[name='active']").val());
			}
		});
		myDropzone.on('success', function(file, response) {
			if(response !== false) {
				$("#shape-added").modal('show');
			}
			else {
				$("#shape-add-error").modal('show');
			}
		});
		myDropzone.on('removedfile', function(file) {
			$("#image").val("");
			$("#image").prop('disabled', false);
		});
		$("#editShapeForm").validate({
			onkeyup: false,
			rules: {
				name: {
					required: true,
					// remote: {
					// 	url: BASE_URL+"/admin/shapes/remoteCheck",
					// 	type:"post",
					// 	data: {
					// 		name: function() {
					// 			return $("input[name='name']").val();
					// 		},
					// 		id: function() {
					// 			return $("#shape-id").val();
					// 		},
					// 		_token: $("#editShapeForm input[name='_token']").val(),
					// 	},
					// }
				},
			},
			submitHandler: function() {
				if(myDropzone.files.length > 0 && myDropzone.files[0].status !== "success")
					myDropzone.processQueue();
				else {
					if($("#image").val() == "")
						$("#chooseFileError").removeClass('hidden');
					else{
						var formData	= [];
						var categoryIds = [];
						$("#editShapeForm select option:selected").each(function(el) {
							categoryIds.push($(this).val());	
						});
						formData.push({"name": '_token', 		"value": $("#editShapeForm input[name='_token']").val()});
						formData.push({"name": '_method', 		"value": $("#editShapeForm input[name='_method']").val()});
						formData.push({"name": 'category_id',	"value": JSON.stringify(categoryIds)});
						var active = $("#editShapeForm input[name='active']").prop('checked') == true ? "on" : "off";
						formData.push({name: 'active', 			value: active});
						$.post(BASE_URL+'/admin/shapes/'+shapeId, formData, function(data) {
							if(data !== false)
								$("#shape-added").modal('show');
							else {
								$("#shape-add-error").modal('show');	
							}
						});
					}
				}
			}	
		});
	}
}

function remoteValidation() {
	$.post( BASE_URL+"/admin/shapes/remoteCheck", {_token: $("#editShapeForm input[name='_token']").val(), image: $("#editShapeForm input[name='image']").val(),id: $("#shape-id").val()}, function(response){
		if(response.status !== true) {
			if (response.status == "duplicate file_names") {
				$("#overwriteModal .modal-body p").html("A shape already has a file with this name assigned to it. Do you want to overwrite it?");
				$("#overwriteModal").modal('show');
			}
	
		}
		else {
			if(!$("#remote-error").hasClass('hidden')) $("#remote-error").addClass('hidden');
			$("#editShapeForm").submit();
		}
	})
}

$(function() {
 	var page = new EditShapePage();
 	page.init();
 	$("#shape-add-error").on('hide.bs.modal', function() {
		window.location.reload();
	});
	$("#overwriteModal #overwriteConfirmed").on('click', function() {
		$("#editShapeForm").submit();		
	});
	$("#image").on('click', function() {
		if(!$("#chooseFileError").hasClass('hidden')) $("#chooseFileError").addClass('hidden');;
	});
});