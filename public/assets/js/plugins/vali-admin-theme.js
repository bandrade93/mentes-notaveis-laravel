$(document).ready(() => {
	$('[data-toggle="sidebar"]')
		.click(function(e) {
			e.preventDefault();
			$('.app').toggleClass('sidenav-toggled');
		});

	var treeviewMenu = $('.app-menu');

	$("[data-toggle='treeview']").click(function(e) {
		e.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu
				.find("[data-toggle='treeview']")
				.parent()
				.removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	$("[data-toggle='treeview.'].is-expanded")
		.parent()
		.toggleClass('is-expanded');
	
	$("[data-toggle='tooltip']").tooltip();
});