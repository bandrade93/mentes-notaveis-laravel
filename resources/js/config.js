(function(cash) {
	"use strict";

	if (!localStorage.getItem('menuState')) {
		localStorage.setItem('menuState', 'show');
	}

	if (localStorage.getItem('menuState') === 'show') {
		cash('body').removeClass('sidenav-toggled');
	} else {
		cash('body').addClass('sidenav-toggled');
	};

	$('[data-toggle="tooltip"]').tooltip();

	window.config = {
		loadPopover: () => {
			$('[data-toggle="popover"]')
				.not('.lazy')
				.popover({
					trigger: 'hover',
					placement: 'bottom',
					html: true
				});
		},
		getProgressColor(val) {
			let color = 'danger';

			if (val >= 55 && val < 65) {
	            color = 'attention';
	        } else if (val >= 65 && val < 80) {
				color = 'warning';
	        } else if (val >= 80) {
	            color = 'success';
	        }

	        return color;
		}
	};

	window.config.loadPopover();
})(cash);