
$(function() {
	var current_page 	= 1;
	var total_page 		= 0;
	var is_ajax_fire 	= 0;
	var perPage 		= 50;
	var searchInput 	= "";
	var pagination 		= $("#pagination");

	var filters = {
		searchInput: "",
		page: 1,
		perPage: 50,
		category: ""
	}
	var url = BASE_URL + '/getFilteredProducts';

	if (selectedCategory) {
		$("#selectCategoryFilter").val(selectedCategory);
		filters.category = selectedCategory;
	} 
	getPageData(true);

	function getPageData(refreshPagination) {
		$("#noResults").addClass('hidden');
		$.ajax({
	    	dataType: 'json',
	    	url: url,
	    	data: filters
		}).done(function(results) {
			$("#productsList").empty();
			if (results.total == 0) {
				pagination.twbsPagination('destroy');
				$("#noResults").removeClass('hidden');
				return;
			}
           	last_page 		= results.last_page;
   	    	current_page 	= results.current_page;

   	    	if (refreshPagination) {
	   	    	if (pagination) pagination.twbsPagination('destroy');
	   	    	pagination = $('.pagination').twbsPagination({
	   		        startPage: current_page,
	   		        totalPages: last_page,
	   		        onPageClick: function (event, pageL) {
	   		        	console.log('page cliked')
	   		        	filters.page = pageL;
	   		        	  	getPageData(false);
	   		        }
	   		    });
   	    	}

		    $("#productsList").append(results.data);
		});
	}

	$("#search").keyup(function() {
		filters.page = 1;
		filters.category = "";
		filters.searchInput = $(this).val();
		$("#selectCategoryFilter").val("");
		getPageData(true);
	});

	$("#selectCategoryFilter").change(function() {
		filters.searchInput = "";

		filters.category = $(this).val();
		filters.page = 1;
		getPageData(true);
	});
});
