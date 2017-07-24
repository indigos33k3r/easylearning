$(function() {
	$("#addEventForm").validate({
		rules:{
			title: {
				required: true,
			},
			start: {
				required: true,
			},
			end: {
				required: true
			}
		},
		submitHandler: function() {
			var data = $("#addEventForm").serializeArray();
			data[1].value = moment.utc($("#start input").val()).valueOf();
			$.post(BASE_URL + "/schedules", data, function(data) {
				$('#ModalAdd').modal('hide');
				$("#calendar").fullCalendar( 'refetchEvents' );
			});
		}
	});

	$("#start").datetimepicker();
	$("#calendar").fullCalendar({
		events: BASE_URL + "/schedules/getJSON",
		selectable: true,
		editable: true,
		select: function(start, end) {
			var time = $('#start').data("DateTimePicker");
			time.date(new Date(start));
			$('#ModalAdd').modal('show');
		},
		eventRender: function(event, element) {
			console.log("rendered");
			element.bind('dblclick', function() {
				$('#ModalEdit #id').val(event.id);
				$('#ModalEdit #title').val(event.title);
				$('#ModalEdit #color').val(event.color);
				$('#ModalEdit').modal('show');
			});
		},
		eventClick: function(calendarEvent, jsEvent, view) {
			window.location = BASE_URL + '/editor/' + calendarEvent.id;
		},
		color: 'yellow',   // a non-ajax option
        textColor: 'black', // a non-ajax option
		eventDrop: function(event, delta, revertFunc) { // si changement de position
			edit(event);
		},
		eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur
			edit(event);
		},
	});

	function edit(event){
		start = event.start.format('YYYY-MM-DD HH:mm:ss');
		if(event.end){
			end = event.end.format('YYYY-MM-DD HH:mm:ss');
		}else{
			end = start;
		}
		
		id =  event.id;
		
		var event = {id: id, start: start, end: end};
		
		$.ajax({
		 	url: BASE_URL + '/schedules',
		 	type: "POST",
		 	data: {event:event},
		 	success: function(rep) {
				if (rep == 'OK'){
					alert('Saved');
				} else{
					alert('Could not be saved. try again.'); 
				}
			}
		});
	}

})