$(function() {
	$('#accountActivated').modal('show');
	$('#accountActivated').on('hidden.bs.modal', function () {
    	window.location.href = BASE_URL + "/home";
	})
});
