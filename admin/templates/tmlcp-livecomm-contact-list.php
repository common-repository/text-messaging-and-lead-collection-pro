<div class="form">
    <div class="form-panel forlogo">
	    <div class="admin-header-logo">
	        <img class="logo" src="<?php echo esc_url( TMLCP_DIR_URL.'admin/images/livecomm-logo.png' ); ?>" alt="LiveComm" />
	    </div>
        <div class="form-header">
            <h1><?php esc_html_e( 'My Livecomm Contact list', 'text-message-lead-collection-pro' );?></h1>
            <?php
				if( $this->tmlcp_is_user_logged_in() )
				{
					$api_response_body = $this->tmlcp_get_userdata_api();
					if( !empty( $api_response_body ) )
					{
						if( $api_response_body->code == 200 && $api_response_body->success == true )
						{
							$this->tmlcp_get_logged_in_message();
							if( isset( $api_response_body->user->lists ) && count( $api_response_body->user->lists ) > 0 )
							{
								?>
									<p><strong><?php esc_html_e( 'Select the Livecomm contact list use when mapping forms on your website. Contacts will directly be stored on your livecomm account.', 'text-message-lead-collection-pro' );?> <a href="//beta.livecomm.com/user.php?action=login" target="_blank"><?php esc_html_e( 'Manage my livecomm account.', 'text-message-lead-collection-pro' );?></a></strong></p>
								<?php
							}
						}
						else
						{
							$this->tmlcp_print_api_error_message( $api_response_body );
						}
					}
					else
					{
						_e('Unable to fetch data','text-message-lead-collection-pro');
					}
				}
				else
				{
					$this->tmlcp_get_not_logged_in_message();
				}
			?>
        </div>
        
        <div class="form-content">
            <?php
            	if( $this->tmlcp_is_user_logged_in() )
				{
					$api_response_body = $this->tmlcp_get_userdata_api();
					if( ! empty( $api_response_body ) )
					{
						if( $api_response_body->code == 200 && $api_response_body->success == true )
						{
			            	$livecomm_default_contact_list = get_option('livecomm_default_contact_list');
							echo '<form class="tmlcp-form" name="tmlcp_contact_list" id="tmlcp_contact_list">';
								echo '<table id="customers">';
									echo '<tr>';
										echo '<th>'	. __( 'Set as Default' , 'text-message-lead-collection-pro' ) . '</th>';
										echo '<th>' . __( 'List Name' , 'text-message-lead-collection-pro' ) . '</th>';
									echo '</tr>';
									
									$count = 1;
									foreach( $api_response_body->user->lists as $listsDetails )
									{
										echo '<tr>';
											echo '<td>
												<div class="redio-custom">
					                                <input type="radio" id="livecomm_default_contact_list_' . esc_attr( $count ) . '" name="livecomm_default_contact_list" value="'. esc_attr( $listsDetails->listid ) . '" '. checked( $listsDetails->listid , $livecomm_default_contact_list , false ) .'>
					                                <label for="livecomm_default_contact_list_' . esc_attr( $count ) . '">for="livecomm_default_contact_list_' . esc_attr( $count ) . '"</label>
					                                <div class="check"></div>
					                            </div>
												</td>';
											echo '<td><strong>'. esc_html( $listsDetails->listname ) .'</strong></td>';
										echo '</tr>';
										$count++;
									}
									echo '<tr>';
										echo '<td align="center" colspan="2"><input type="submit" name="tmlcp_submit" value="Save" class="button button-primary"></td>';
									echo '</tr>';
								echo '</table>';
								
								echo '<input type="hidden" name="tmlcp_contact_list_nonce" value="'. esc_attr( wp_create_nonce('tmlcp-contact-list-nonce') ) . '">';
								echo '<input type="hidden" name="action" value="tmlcp_livecomm_contact_list">';
								echo '<p class="response-message"></p>';
							echo '</form>';
						}
					}
				}
            ?>
        </div>

        <div class="form-footer">
        	<p>
	    	©<?php echo date('Y'); ?> <a href="//beta.livecomm.com/" target="_blank"><?php esc_html_e( 'LiveComm', 'text-message-lead-collection-pro' );?></a><?php esc_html_e( ', All rights reserved.', 'text-message-lead-collection-pro' );?>
	    	</p>
	    </div>
    </div>
</div>