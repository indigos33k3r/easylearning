var AddClipartPage = function() {
	var allowedFileTypes = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];

	return {
		init : init
	}

	function init() {
		var myDropzone = new Dropzone("#addClipartForm #image", {
			url: BASE_URL + "/admin/cliparts",
			init: function() {
				this.on("error", function(file, response, xhr) {
					if (allowedFileTypes.indexOf(file.type) == -1) {
						$(".dz-error-message").empty();
						$("#clipart-add-error").modal('show');
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
			accept: function(file, done) {
				if (allowedFileTypes.indexOf(file.type) == -1) {
					done('File type not allowed. PNG, JPG, GIF are the allowed types.');
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
			if(this.files[fileNr - 1] == file){
				var categoryIds = [];
				$("#addClipartForm select option:selected").each(function(el) {
					categoryIds.push($(this).val());	
				});
				formData.append('_token', $("#addClipartForm input[name='_token']").val());
				formData.append('category_id', JSON.stringify(categoryIds));
				var active = $("#addClipartForm input[name='active']").prop('checked') == true ? "on" : "off";
				formData.append('active', active);
			}
		});

		myDropzone.on('success', function(file, response) {
			if (response !== false) {
				$("#clipart-added").modal('show');
				$("input[name='name']").val('');
				$('.selectpicker option:selected').each(function() {
					$(this).prop('selected', false);
				});
				$('.selectpicker').selectpicker('render');
				myDropzone.removeFile(file);
			} else {
				console.log('iinn')
				$("#clipart-add-error").modal('show');
			}
		});

		myDropzone.on('removedfile', function(file) {
			$("#image").val("");
			$("#image").prop('disabled', false);
		});

		$("#addClipartForm").validate({
			onkeyup: false,
			rules: {
				category_id: {
					required: true,
				},
			},
			submitHandler: function(){
				if (myDropzone.getQueuedFiles().length > 0) {
					myDropzone.processQueue();
				} else {
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

	$.post( BASE_URL+"/admin/cliparts/remoteCheck", { images: images,_token: $("#addClipartForm input[name='_token']").val(), id: $("#clipart-id").val()}, function(response){
		if (response.status !== true) {
			if (response.status == "duplicate file_names") {
				alert('file already exists');
			}	
		} else {
			if (!$("#remote-error").hasClass('hidden')) {
				$("#remote-error").addClass('hidden');
			}
			if (!$("#chooseFileError").hasClass('hidden')) {
				$("#chooseFileError").addClass('hidden');
			}
			$("#addClipartForm").submit();
		}
	})
}

$(function() {
 	var page = new AddClipartPage();
 	page.init();
 	$("#clipart-add-error").on('hide.bs.modal', function() {
		window.location.reload();
	})
	$("#overwriteModal #overwriteConfirmed").on('click', function() {
		$("#addClipartForm").submit();		
	})
});
