jQuery(function($){
	$(document).on("click",".wcd-quick-view-wrap button",function(e){
		e.preventDefault();

		$('.wcd-quick-view-modal-wrapper').hide();
		$('.wcd-quick-view-loader').show();

		var product_id 	= $(this).data('product_id');
		var template_id = $(this).data('template_id');

		$.ajax({
			url: WOOLEMENTOR_PRO.ajaxurl,
			data: { 'action':'quick-view', 'product_id' : product_id, 'template_id' : template_id, '_nonce' : WOOLEMENTOR_PRO._nonce },
			type: 'POST',
			dataType: 'JSON',
			success: function(resp){
				$('.wcd-quick-view-loader').hide();
				$('.wcd-quick-view-modal').addClass('is-visible');
				$('.wcd-quick-view-modal').show();
				$('.wcd-quick-view-modal-wrapper').show();
				$('.wcd-quick-view-modal-heading').html( resp.title );
				$('.wcd-quick-view-modal-content').html( resp.html );
			}
		});
	});

	$('.wcd-quick-view-modal-close').on( 'click', function () {
		$('.wcd-quick-view-modal').removeClass('is-visible');
	} );

	$(document).on("click",".wl-filter-clear-btn",function(e) {
		e.preventDefault();
		$('.wl-ajax-filter-form input[name="paged"]').val('');
		$('.wl-ajax-filter-form').trigger('reset').submit();
	} );

	$('.wl-ajax-filter-form').submit(function(e){
		e.preventDefault()

		$('.wcd-loader-wrapper').show();

		var $form 		= $(this);
		var $data 		= $form.serializeArray();
		var widget_id 	= $(this).find('input[name="widget_id"]').val();
		var settings 	= $('.wl-shop.wl-' + widget_id).data('settings');

		$data.push( { name : 'settings', value:settings } );

		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: $data,
			type: 'POST',
			dataType: 'JSON',
			success: function(resp) {
				if( resp.status == 1 ) {
					$('.wl-shop.wl-' + widget_id ).html( resp.html );
					$('.wcd-loader-wrapper').hide();
				}
			}
		})
	})

	$(document).on("click",".wl-ajax-filter-pagination .page-numbers",function(e) {
		e.preventDefault();
		var link = $(this).attr('href');
		$('.wl-ajax-filter-form').append('<input type="hidden" name="paged" value="'+ link +'" />').submit();
	} );
})