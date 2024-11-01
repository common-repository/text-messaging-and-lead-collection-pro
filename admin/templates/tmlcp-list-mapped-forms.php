<?php $i = 1; ?>

<?php $tmlcp_contact_forms 	= get_option('tmlcp_contact_forms'); ?>

<?php $admin_page 			= menu_page_url('tmlcp-form-mapping', false); ?>

<?php $current_admin_page 	= menu_page_url('tmlcp-my-forms', false); ?>

<div class="form form-map">
    <div class="form-panel forlogo">
		<div class="admin-header-logo">
			<img class="logo" src="<?php echo esc_url( TMLCP_DIR_URL.'admin/images/livecomm-logo.png' ); ?>" alt="LiveComm" />
		</div>
        <div class="form-header">
            <h1><?php esc_html_e( 'My Mapped Forms', 'text-message-lead-collection-pro' );?></h1>
        </div>
        <div class="form-content">
        	<?php if( !empty( $tmlcp_contact_forms ) && is_array( $tmlcp_contact_forms ) && count( $tmlcp_contact_forms ) > 0 ) : ?>

				<?php $unmap_form_nonce = wp_create_nonce('unmap-form-nonce'); ?>
	            <table id="customers">
	                <tr>
			
						<th><?php esc_html_e( 'Sr. No.', 'text-message-lead-collection-pro' );?></th>

						<th><?php esc_html_e( 'Form Name', 'text-message-lead-collection-pro' );?></th>

						<th colspan="2"><?php esc_html_e( 'Action', 'text-message-lead-collection-pro' );?></th>
					</tr>

					<?php foreach( $tmlcp_contact_forms as $contact_form_id ) : ?>
					
						<tr>
						
							<td><?php echo esc_html( $i ); ?></td>
						
							<td><?php echo get_the_title( $contact_form_id ); ?></td>
						
							<td>
								<div class="action-btn">
									<a href="<?php echo esc_url( add_query_arg( array('contact_form_id' => $contact_form_id, 'contact_form_edit' => true), $admin_page) ); ?>"><?php esc_html_e( 'Edit', 'text-message-lead-collection-pro' );?></a>
									<a href="javascript:void(0);" class="tmlcp-delete-form-map" data-form-id="<?php echo esc_attr( $contact_form_id ); ?>" data-unmap-form-nonce="<?php echo esc_attr( $unmap_form_nonce ); ?>"><?php esc_html_e( 'Unmap', 'text-message-lead-collection-pro' );?></a>
								</div>
							</td>						
						</tr>

					<?php $i++; ?>
					
					<?php endforeach; ?>
	            </table>
	        <?php else : ?>

				<p><?php esc_html_e( "You don't have mapped any form", 'text-message-lead-collection-pro' );?></p>

			<?php endif; ?>
        </div>
        <div class="form-footer">
        	<p>
	    	©<?php echo date('Y'); ?> <a href="//beta.livecomm.com/" target="_blank"><?php esc_html_e( 'LiveComm', 'text-message-lead-collection-pro' );?></a><?php esc_html_e( ', All rights reserved.', 'text-message-lead-collection-pro' );?>
	    	</p>
	    </div>
    </div>
</div>
