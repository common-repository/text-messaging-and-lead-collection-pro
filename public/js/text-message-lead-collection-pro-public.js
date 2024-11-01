(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function() {

		// Login form submit
		$('#tmlcp_livecomm_form').submit(function(e){
			
			jQuery.ajax({
				url: 	tmlcpFrontVars.admin_url,
				type: 	'POST',
				dataType:"json",
				data: 	jQuery("#tmlcp_livecomm_form").serialize(),

				success: function(response)
				{
					jQuery('#tmlcp_livecomm_form p.response-message').html(response.message);
					if(response.status)
					{
						jQuery("#tmlcp_livecomm_form").trigger('reset');
						jQuery('#tmlcp_livecomm_form p.response-message').addClass('response-success');
					}
					else
					{
						jQuery('#tmlcp_livecomm_form p.response-message').addClass('response-error');	
					}

				},
				beforeSend:function()
				{
					jQuery('#tmlcp_livecomm_form p.response-message').show();
					jQuery('#tmlcp_livecomm_form p.response-message').text('Loading...');
					jQuery('#tmlcp_livecomm_form').find(":submit").prop('disabled', true);
					jQuery('#tmlcp_livecomm_form p.response-message').removeClass('response-success');
					jQuery('#tmlcp_livecomm_form p.response-message').removeClass('response-error');
				},
				complete:function()
				{
					
					jQuery('#tmlcp_livecomm_form').find(":submit").prop('disabled', false);
				},
				error:function(xhr,rrr,error)
				{

				}
			});
		    return false;
		});

		// Floting button
		$(document).on('click', '.tmlcp-floating-button', function () {
			var $parent = $('.tmlcp-message-icon').parents('.tmlcp-wrapper');
			$parent.find('.tmlcp-message-icon').toggleClass('active');
			$parent.find('.tmlcp-close-icon').toggleClass('active');
			$parent.find('.tmlcp-livecomm-form').toggleClass('active');
		});
	});
})( jQuery );
