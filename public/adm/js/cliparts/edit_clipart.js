var EditClipartPage = function() {
	var allowedFileTypes = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
	
	return {
		init : init
	}

	function init(){
		var clipartId =  $("#clipart-id").val();
		var myDropzone = new Dropzone("#editClipartForm #image", {
			url: BASE_URL + "/admin/cliparts/" + clipartId,
			autoProcessQueue: false,
			paramName: "images",
			previewsContainer: "#preview-template",
			addRemoveLinks: true,
			maxFiles: 1,
			maxFilesize: 2, //MB
			accept:function(file, done) {
				if (allowedFileTypes.indexOf(file.type) == -1) {
					done('File type not allowed. PNG, JPG, GIF are the allowed types.');
				} else {
					done();
				}
			}
		});

		myDropzone.on("addedfile", function(file) {
			$("#preview-template").removeClass('hidden');
			$("#editClipartForm input[name='image']").val(file.name);
			$("#image").prop('disabled', true);
			$("#edit-preview").addClass('hidden');
		});

		myDropzone.on("sending", function(file, xhr, formData) {
			var fileNr = this.files.length;
			if (this.files[fileNr - 1] == file) {
				var categoryIds = [];
				$("#editClipartForm select option:selected").each(function(el) {
					categoryIds.push($(this).val());	
				});
				formData.append('_token', $("#editClipartForm input[name='_token']").val());
				formData.append('_method', $("#editClipartForm input[name='_method']").val());
				formData.append('category_id', JSON.stringify(categoryIds));
			}
		});

		myDropzone.on('success', function(file, response) {
			if (response !== false) {
				$("#clipart-added").modal('show');
			} else {
				$("#clipart-add-error").modal('show');
			}
		});

		myDropzone.on('removedfile', function(file) {
			$("#image").val("");
			$("#image").prop('disabled', false);
		});

		$("#editClipartForm").validate({
			onkeyup: false,
			rules: {
				category_id: {
					required: true
				},
			},
			submitHandler: function() {
				if (myDropzone.files.length > 0 && myDropzone.files[0].status !== "success") {
					myDropzone.processQueue();
				} else {
					if ($("#image").val() == "") {
						$("#chooseFileError").removeClass('hidden');
					} else {
						var formData	= [];
						var categoryIds = [];
						$("#editClipartForm select option:selected").each(function(el) {
							categoryIds.push($(this).val());	
						});
						formData.push({name: '_token', 		value: $("#editClipartForm input[name='_token']").val()});
						formData.push({name: '_method', 	value: $("#editClipartForm input[name='_method']").val()});
						formData.push({name: 'category_id',	value: JSON.stringify(categoryIds)});
						var active = $("#editClipartForm input[name='active']").prop('checked') == true ? "on" : "off";
						formData.push({name: 'active',		value: active});
						$.post(BASE_URL+'/admin/cliparts/'+clipartId, formData, function(data) {
							if (data !== false) {
								$("#clipart-added").modal('show');
							} else {
								$("#clipart-add-error").modal('show');	
							}
						});
					}
				}
			}	
		});
	}
}

function remoteValidation() {
	$.post( BASE_URL+"/admin/cliparts/remoteCheck", {_token: $("#editClipartForm input[name='_token']").val(), image: $("#editClipartForm input[name='image']").val(),id: $("#clipart-id").val()}, function(response){
		if (response.status !== true) {
			if (response.status == "duplicate file_names") {
				$("#overwriteModal .modal-body p").html("A clipart already has a file with this name assigned to it. Do you want to overwrite it?");
				$("#overwriteModal").modal('show');
			}
		} else {
			if(!$("#remote-error").hasClass('hidden')) $("#remote-error").addClass('hidden');
			$("#editClipartForm").submit();
		}
	})
}

$(function() {
 	var page = new EditClipartPage();
 	page.init();
 	$("#clipart-add-error").on('hide.bs.modal', function() {
		window.location.reload();
	});
	$("#overwriteModal #overwriteConfirmed").on('click', function() {
		$("#editClipartForm").submit();		
	});
	$("#image").on('click', function() {
		if(!$("#chooseFileError").hasClass('hidden')) $("#chooseFileError").addClass('hidden');;
	});
});