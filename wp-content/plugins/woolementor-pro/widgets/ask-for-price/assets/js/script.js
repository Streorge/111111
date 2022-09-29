jQuery(function($){
	$(document).on('submit', '.wl-afp-form', function(e){
		e.preventDefault();
		var data = $(this).serializeArray();
		var this_form = $(this);

		$.ajax({
			url: AFP.ajaxurl,
			data: data,
			type: 'POST',
			dataType: 'JSON',
			success: function( resp ) {
				if ( resp.redirect ) {
					window.location.href = resp.redirect.url
				}
				if ( resp.res_msg ) {
					$('.wl-afp-submit-message', this_form ).html( resp.res_msg );
				}
				console.log(resp);
			},
			error: function( resp ) {
				console.log(resp);
			}
		});
	});
});