
var AddShapePage = function() {
	return {
		init : init
	}

	function init() {
		var myDropzone = new Dropzone("#addShapeForm #image", {
			url: BASE_URL+"/admin/shapes",
			init: function() {
				this.on("error", function(file, response, xhr) {
					if(file.type == 'image/svg+xml' && typeof xhr !== "undefined"){
						$(".dz-error-message").empty();
						$("#shape-add-error").modal('show');
					}

				});
			},
			uploadMultiple: true,
			autoProcessQueue: false,
			paramName: "images",
			previewsContainer: "#preview-template",
			addRemoveLinks: true,
			maxFiles: 15,
			parallelUploads: 15,
			maxFilesize: 2, // MB
			accept:function(file, done) {
				if (file.type !== 'image/svg+xml') {
					done('File type not allowed. Only the .svg format is accepted.');
				} else {
					done();
				}
			}
		});
		myDropzone.on("addedfile", function(file) {
			$("#preview-template").removeClass('hidden');
		});
		myDropzone.on("sending", function(file, xhr, formData) {
			var fileNr = this.files.length;
			if (this.files[fileNr - 1] == file){
				var categoryIds = [];
				$("#addShapeForm select option:selected").each(function(el) {
					categoryIds.push($(this).val());	
				});
				formData.append('_token', $("#addShapeForm input[name='_token']").val());
			}
		});
		myDropzone.on('success', function(file, response) {
			// window.location.reload();
			if(response !== false) {
				$("#shape-added").modal('show');
				$("input[name='name']").val('');
				$("input[name='active']").prop('checked', true);
				$('.selectpicker option:selected').each(function() {
					$(this).prop('selected', false);
				});
				$('.selectpicker').selectpicker('render');
				myDropzone.removeFile(file);
			}
			else {
				$("#shape-add-error").modal('show');

			}
		});
		myDropzone.on('removedfile', function(file) {
			$("#image").val("");
			$("#image").prop('disabled', false);
		});
		$("#addShapeForm").validate({
			onkeyup: false,
			rules: {
				category_id: {
					required: true,
				},
			},
			submitHandler: function(){
				if(myDropzone.getQueuedFiles().length > 0)
					myDropzone.processQueue();
				else {
					$("#chooseFileError").removeClass('hidden');
				}
			}	
		});

	}

}

function remoteValidation() {
	var images = [];
	$("#preview-template .dz-image-preview .dz-filename span").each(function() {
		images.push($(this).html());
	});

	$.post( BASE_URL+"/admin/shapes/remoteCheck", { images: images,_token: $("#addShapeForm input[name='_token']").val(), id: $("#shape-id").val()}, function(response){
		if (response.status !== true) {
			if (response.status == "duplicate file_names") {
				alert('file exists already');
			}	
		} else {
			if(!$("#remote-error").hasClass('hidden')) $("#remote-error").addClass('hidden');
			if(!$("#chooseFileError").hasClass('hidden')) $("#chooseFileError").addClass('hidden');
			$("#addShapeForm").submit();
		}
	})
}

$(function() {
 	var page = new AddShapePage();
 	page.init();
 	$("#shape-add-error").on('hide.bs.modal', function() {
		window.location.reload();
	})
});
