(function(cash) {
	"use strict";

	window.Flash = (type, text) => {
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		Toast.fire({
			type: type,
			text: text
		});
	};
})(cash);