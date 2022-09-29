
$ = new jQuery.noConflict();

$('#elementor-panel-state-loading').hide();

$(document).on( 'submit', '#wcd-test-email-form', function(e) {
	e.preventDefault();


	var $form = $(this);
	$('#wcd-send-email').val('Sending..').attr('disabled',true);

	var $data = $form.serialize();

	$.ajax({
		url: WOOLEMENTOR_PRO.ajaxurl,
		data: $data,
		type: 'POST',
		dataType: 'JSON',
		success: function(resp){
			// console.log(resp);
			$('#wcd-send-email').val('Send Email').attr('disabled',false);
			$('#wcd-email-notification').html('Mail Sent').slideDown()
			setTimeout(function() {
				$('#wcd-email-notification').slideUp()
			},2500)
		},
		error: function( $xhr, $sts, $err ) {
			// console.log($err);
			$('#wcd-send-email').val('Send Email').attr('disabled',false);
			$('#wcd-email-notification').css({ 'color': '#c36', 'border-color':'#c36'}).html('Sending Faild!').slideDown()
			setTimeout(function() {
				$('#wcd-email-notification').slideUp()
			},2500)
		}
	})
})

$(document).on("click",".wcd-quick-view-modal-close",function(e){
	$('.wcd-quick-checkout-wrapper').removeClass('is-visible').hide();
} );