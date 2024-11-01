<div class="form">
    <div class="form-panel forlogo">
	    <div class="admin-header-logo">
	        <img class="logo" src="<?php echo esc_url( TMLCP_DIR_URL.'admin/images/livecomm-logo.png' ); ?>" alt="LiveComm" />
	    </div>
        <div class="form-header">
            <h1><?php esc_html_e( 'My Livecomm Phone Numbers', 'text-message-lead-collection-pro' ); ?></h1>
            <?php
            	if( $this->tmlcp_is_user_logged_in() )
				{
					$api_response_body = $this->tmlcp_get_userdata_api();
					if( !empty( $api_response_body ) )
					{
						if( $api_response_body->code == 200 && $api_response_body->success == true )
						{
							$this->tmlcp_get_logged_in_message();
							if( isset( $api_response_body->user->phones ) && count( $api_response_body->user->phones ) > 0 )
							{
								echo sprintf(
									'<p><strong>%1$s <a href="//beta.livecomm.com/user.php?action=login" target="_blank">%2$s</a></strong></p>',
									esc_html__( 'Select the Livecomm phone number used to receive calls and text messages from web visitors of this site.', 'text-message-lead-collection-pro' ),
									esc_html__( 'Manage my livecomm account.', 'text-message-lead-collection-pro' )
								);
							}
						}
						else
						{
							$this->tmlcp_print_api_error_message( $api_response_body );
						}
					}
					else
					{
						_e( 'Unable to fetch data', 'text-message-lead-collection-pro' );
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
					if( !empty( $api_response_body ) )
					{
						if( $api_response_body->code == 200 && $api_response_body->success == true )
						{
			        		echo '<form class="tmlcp-form" name="tmlcp_phone_list" id="tmlcp_phone_list">';
								echo '<table id="customers">';
									echo '<tr>';
										echo '<th>'	. __( 'Set as Default' , 'text-message-lead-collection-pro' ) . '</th>';
										echo '<th>' . __( 'Contact List' , 'text-message-lead-collection-pro' ) . '</th>';
										echo '<th>' . __( 'Livecomm Number' , 'text-message-lead-collection-pro' ) . '</th>';
									echo '</tr>';
									
									$livecomm_default_phone_number = get_option('livecomm_default_phone_number');

									$count = 1;
									foreach( $api_response_body->user->phones as $phoneDetails )
									{
										echo '<tr>';
											echo '<td>
						                            <div class="redio-custom">
						                                <input type="radio" id="livecomm_default_phone_number_' . esc_attr( $count ) . '" value="'. esc_attr( $phoneDetails->number ) . '" name="livecomm_default_phone_number" '. checked( $phoneDetails->number , $livecomm_default_phone_number , false ) .'>
						                                <label for="livecomm_default_phone_number_' . $count . '">livecomm_default_phone_number_' . $count . '</label>
						                                <div class="check"></div>
						                            </div>
						                        </td>';
											echo '<td><strong>'. esc_html( $phoneDetails->name ) .'</strong></td>';
											echo '<td><strong>'. esc_html( $phoneDetails->number ) .'</strong></td>';
										echo '</tr>';
										$count++;
									}
									echo '<tr>';
										echo '<td colspan="3"><input type="submit" name="tmlcp_submit" value="Save" class="button button-primary"></td>';
									echo '</tr>';

								echo '</table>';
								echo '<input type="hidden" name="tmlcp_phone_list_nonce" value="'. esc_attr( wp_create_nonce('tmlcp-phone-list-nonce') ) . '">';
								echo '<input type="hidden" name="action" value="tmlcp_livecomm_phone_list">';
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