(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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
		$('#tmlcp_login').submit(function(e){
			
			jQuery.ajax({
				url: 	tmlcpAdminVars.admin_url,
				type: 	'POST',
				dataType:"json",
				data: 	jQuery("#tmlcp_login").serialize(),

				success: function(response)
				{
					jQuery('#tmlcp_login p.response-message').html(response.message);
					if(response.status)
					{
						jQuery('#tmlcp_login p.response-message').addClass('response-success');
						setTimeout(function(){
							window.location = window.location.href;
						}, 500);
					}
					else
					{
						jQuery('#tmlcp_login p.response-message').addClass('response-error');	
					}

				},
				beforeSend:function()
				{
					jQuery('#tmlcp_login p.response-message').show();
					jQuery('#tmlcp_login p.response-message').text('Loading...');
					jQuery('#tmlcp_login').find(":submit").prop('disabled', true);
					jQuery('#tmlcp_login p.response-message').removeClass('response-success');
					jQuery('#tmlcp_login p.response-message').removeClass('response-error');
				},
				complete:function()
				{
					jQuery("#tmlcp_login").trigger('reset');
					jQuery('#tmlcp_login').find(":submit").prop('disabled', false);
				},
				error:function(xhr,rrr,error)
				{

				}
			});
		    return false;
		});

		// Field Mapping submit
		$('#tmlcp_field_mapping').submit(function(e){
			
			jQuery.ajax({
				url: 	tmlcpAdminVars.admin_url,
				type: 	'POST',
				dataType:"json",
				data: 	jQuery("#tmlcp_field_mapping").serialize(),

				success: function(response)
				{
					jQuery('#tmlcp_field_mapping p.response-message').html(response.message);
					if(response.status)
					{
						jQuery('#tmlcp_field_mapping p.response-message').addClass('response-success');
					}
					else
					{
						jQuery('#tmlcp_field_mapping p.response-message').addClass('response-error');	
					}

				},
				beforeSend:function()
				{
					jQuery('#tmlcp_field_mapping p.response-message').show();
					jQuery('#tmlcp_field_mapping p.response-message').text('Loading...');
					jQuery('#tmlcp_field_mapping').find(":submit").prop('disabled', true);
					jQuery('#tmlcp_field_mapping p.response-message').removeClass('response-success');
					jQuery('#tmlcp_field_mapping p.response-message').removeClass('response-error');
				},
				complete:function()
				{
					jQuery('#tmlcp_field_mapping').find(":submit").prop('disabled', false);
				},
				error:function(xhr,rrr,error)
				{

				}
			});
		    return false;
		});

		// Field Mapping submit
		$('table a.tmlcp-delete-form-map').click(function(e){
			
			if( confirm( tmlcpAdminVars.form_map_delete_text ) )
			{
				var contact_form_id = $(this).data('form-id');
				var unmap_form_nonce = $(this).data('unmap-form-nonce');

				var formThis = $(this);

				jQuery.ajax({
					url: 	tmlcpAdminVars.admin_url,
					type: 	'POST',
					dataType:"json",
					data: 
					{
						'contact_form_id': contact_form_id,
						'unmap_form_nonce': unmap_form_nonce,
						'action':'tmlcp_unmap_form'
					},

					success: function(response)
					{
						jQuery('.tmlcp-form-mapped-list p.response-message').text(response.message);
						if(response.status)
						{
							jQuery('.tmlcp-form-mapped-list p.response-message').addClass('response-success');
							formThis.closest('tr').fadeOut(1500, function() {
								formThis.closest('tr').remove();
							});
						}
						else
						{
							jQuery('.tmlcp-form-mapped-list p.response-message').addClass('response-error');
						}
					},
					beforeSend:function()
					{
						jQuery('.tmlcp-form-mapped-list p.response-message').remove();
						
						$('<p class="response-message">Please wait...</p>').insertAfter(formThis);
					},
					complete:function()
					{

					},
					error:function(xhr,rrr,error)
					{

					}
				});	
			}
		});

		// Set Default Phone Number
		$('#tmlcp_phone_list').submit(function(e){
			
			jQuery.ajax({
				url: 	tmlcpAdminVars.admin_url,
				type: 	'POST',
				dataType:"json",
				data: 	jQuery("#tmlcp_phone_list").serialize(),

				success: function(response)
				{
					jQuery('#tmlcp_phone_list p.response-message').html(response.message);
					if(response.status)
					{
						jQuery('#tmlcp_phone_list p.response-message').addClass('response-success');
					}
					else
					{
						jQuery('#tmlcp_phone_list p.response-message').addClass('response-error');	
					}

				},
				beforeSend:function()
				{
					jQuery('#tmlcp_phone_list p.response-message').show();
					jQuery('#tmlcp_phone_list p.response-message').text('Loading...');
					jQuery('#tmlcp_phone_list').find(":submit").prop('disabled', true);
					jQuery('#tmlcp_phone_list p.response-message').removeClass('response-success');
					jQuery('#tmlcp_phone_list p.response-message').removeClass('response-error');
				},
				complete:function()
				{
					jQuery('#tmlcp_phone_list').find(":submit").prop('disabled', false);
				},
				error:function(xhr,rrr,error)
				{

				}
			});
		    return false;
		});

		// Set Default Contact List
		$('#tmlcp_contact_list').submit(function(e){
			
			jQuery.ajax({
				url: 	tmlcpAdminVars.admin_url,
				type: 	'POST',
				dataType:"json",
				data: 	jQuery("#tmlcp_contact_list").serialize(),

				success: function(response)
				{
					jQuery('#tmlcp_contact_list p.response-message').html(response.message);
					if(response.status)
					{
						jQuery('#tmlcp_contact_list p.response-message').addClass('response-success');
					}
					else
					{
						jQuery('#tmlcp_contact_list p.response-message').addClass('response-error');	
					}

				},
				beforeSend:function()
				{
					jQuery('#tmlcp_contact_list p.response-message').show();
					jQuery('#tmlcp_contact_list p.response-message').text('Loading...');
					jQuery('#tmlcp_contact_list').find(":submit").prop('disabled', true);
					jQuery('#tmlcp_contact_list p.response-message').removeClass('response-success');
					jQuery('#tmlcp_contact_list p.response-message').removeClass('response-error');
				},
				complete:function()
				{
					jQuery('#tmlcp_contact_list').find(":submit").prop('disabled', false);
				},
				error:function(xhr,rrr,error)
				{

				}
			});
		    return false;
		});

		// General Settings form submit
		$('#tmlcp_general_settings').submit(function(e){
			
			jQuery.ajax({
				url: 	tmlcpAdminVars.admin_url,
				type: 	'POST',
				dataType:"json",
				data: 	jQuery("#tmlcp_general_settings").serialize(),

				success: function(response)
				{
					jQuery('#tmlcp_general_settings p.response-message').html(response.message);
					if(response.status)
					{
						jQuery('#tmlcp_general_settings p.response-message').addClass('response-success');
					}
					else
					{
						jQuery('#tmlcp_general_settings p.response-message').addClass('response-error');	
					}

				},
				beforeSend:function()
				{
					jQuery('#tmlcp_general_settings p.response-message').show();
					jQuery('#tmlcp_general_settings p.response-message').text('Loading...');
					jQuery('#tmlcp_general_settings').find(":submit").prop('disabled', true);
					jQuery('#tmlcp_general_settings p.response-message').removeClass('response-success');
					jQuery('#tmlcp_general_settings p.response-message').removeClass('response-error');
				},
				complete:function()
				{
					jQuery('#tmlcp_general_settings').find(":submit").prop('disabled', false);
				},
				error:function(xhr,rrr,error)
				{

				}
			});
		    return false;
		});
	});

})( jQuery );
