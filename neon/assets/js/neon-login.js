var neonLogin = neonLogin || {};
(function($, window, undefined) {"use strict";
	$(document).ready(function() {
		neonLogin.$container = $("#form_login");
		

		neonLogin.$body = $(".login-page");
		if (neonLogin.$body.hasClass('login-form-fall')) {
			var focus_set = false;
			setTimeout(function() {
				neonLogin.$body.addClass('login-form-fall-init');
				setTimeout(function() {
					if (!focus_set) {
						neonLogin.$container.find('input:first').focus();
						focus_set = true;
					}
				}, 550);
			}, 0);
		}
		
	});

})(jQuery, window);