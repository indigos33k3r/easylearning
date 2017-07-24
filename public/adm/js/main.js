$(function() {
	$("#menu-" + menuHighlightId).addClass('active');
	if (submenuHighlightId) {
		$("#menu-" + menuHighlightId + " a").click();
		$("#submenu-" + submenuHighlightId).addClass('active');
	}
})