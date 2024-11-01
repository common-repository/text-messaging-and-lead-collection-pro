<?php
	$contact_form_id = '';
	if( isset( $_GET['contact_form_id'] ) && !empty( $_GET['contact_form_id'] ) ) {
			
		$contact_form_id = sanitize_text_field( $_GET['contact_form_id'] );
	}

	if ( ! isset( $_GET['contact_form_edit'] ) || $_GET['contact_form_edit'] != true ) {
	
		?>
		<div class="form form-map">
			<div class="form-panel forlogo">
        	    <div class="admin-header-logo">
        	        <img class="logo" src="<?php echo esc_url( TMLCP_DIR_URL.'admin/images/livecomm-logo.png' ); ?>" alt="LiveComm" />
        	    </div>
				<div class="form-header">
					<h1><?php esc_html_e( 'Form Mapping', 'text-message-lead-collection-pro' ); ?></h1>
				</div>
				<div class="form-content">
			    	<form name="lcwp_form" method="GET" class="tmlcp-form">
			    		<input type="hidden" name="page" value="tmlcp-form-mapping">
			    		<div class="form-group">
				    		<label><?php esc_html_e( 'Select Contact Form', 'text-message-lead-collection-pro' ); ?></label>
					    	<select name="contact_form_id"> 
							    <option value=""><?php esc_html_e( '--Select Contact Form--', 'text-message-lead-collection-pro' ); ?></option>
								<?php
								    
								    $lcwp_contact_args['post_type'] 	= 'wpcf7_contact_form';
								    $lcwp_contact_args['posts_per_page'] = -1;
								    
								    $lcwp_contact_loop = new WP_Query( $lcwp_contact_args );

								    if( $lcwp_contact_loop->have_posts() ) {
								    	
								    	while( $lcwp_contact_loop->have_posts() ) {
								    		
								    		$lcwp_contact_loop->the_post();

								    		$contact_id = get_the_ID();
								    		
								    		echo '<option value="' . esc_attr( $contact_id ) . '" ' . selected( $contact_id , $contact_form_id , false ) . '>' . get_the_title() . '</option>';
								    	}
								    	
								    	wp_reset_postdata();
								    }
								?>
							</select>
						</div>
						<input type="submit" name="tmlcp_contact_submit" class="button button-primary" value="Submit">
					</form>
				</div>
				<div class="form-footer">
		        	<p>
			    	©<?php echo date('Y'); ?> <a href="//beta.livecomm.com/" target="_blank"><?php esc_html_e( 'LiveComm', 'text-message-lead-collection-pro' ); ?></a><?php esc_html_e( ', All rights reserved.', 'text-message-lead-collection-pro' ); ?>
			    	</p>
			    </div>
			</div>
		</div>
		<?php
	}
?>

<?php
    		
	$livcomm_fields['livecomm_field_fname']  		= 'Plugin Fields - First Name';
	$livcomm_fields['livecomm_field_lname']  		= 'Plugin Fields - Last Name';
	$livcomm_fields['livecomm_field_email']  		= 'Plugin Fields - Email';
	$livcomm_fields['livecomm_field_phone_number']  = 'Plugin Fields - Phone Number';
	$livcomm_fields['livecomm_field_company']  		= 'Plugin Fields - Company';
	$livcomm_fields['livecomm_field_message']  		= 'Plugin Fields - Message';
	
	if( !empty( $contact_form_id ) ) {

		if( get_post_type( $contact_form_id ) == 'wpcf7_contact_form') {

			$field_map 				= 0;

			$tmlcp_contact_forms 	= get_option( 'tmlcp_contact_forms' );
			$tmlcp_form_mapping 	= get_option( 'tmlcp_form_mapping_' . $contact_form_id );

			if( !empty( $tmlcp_form_mapping ) && is_array( $tmlcp_form_mapping ) ) {

				$field_map = 1;
			}

			echo '<div class="form form-map">';
    			echo '<div class="form-panel forlogo">';
    				echo '<div class="admin-header-logo">';
		        	    echo '<img class="logo" src="' . esc_url( TMLCP_DIR_URL.'admin/images/livecomm-logo.png' ) . '" alt="LiveComm" />';
		        	echo '</div>';
    				echo '<div class="form-header">';
    					if ( ! isset( $_GET['contact_form_edit'] ) || $_GET['contact_form_edit'] != true ) {
							echo '<h1>'. get_the_title( $contact_form_id ) .'</h1>';
						} else{
							echo '<h1>Edit Form Fields For '. get_the_title( $contact_form_id ) .'</h1>';
						}
					echo '</div>';

					$ContactForm = WPCF7_ContactForm::get_instance( $contact_form_id );
					
					$form_fields = $ContactForm->scan_form_tags();

					if( !empty( $form_fields ) && is_array( $form_fields ) && count( $form_fields ) > 0 ) { 
						?>
						<div class="form-content">
							<form name="tmlcp_field_mapping" id="tmlcp_field_mapping" class="tmlcp-form">
								<input type="hidden" name="page" value="tmlcp-form-mapping">
								<input type="hidden" name="action" value="tmlcp_livecomm_field_mapping">
								<input type="hidden" name="tmlcp_form_map_nonce" value="<?php echo esc_attr( wp_create_nonce('tmlcp-form-map-nonce') ); ?>">
								<input type="hidden" name="contact_form_id" value="<?php echo esc_attr( $contact_form_id ); ?>">
								<?php
									$i = 1;
									$selected = '';
									foreach ( $form_fields as $form_object ) {

										if( !empty( $form_object['name'] ) ) { 
											?>
											<div class="form-group">
												<label><?php echo esc_html( $form_object['name'] ); ?></label>
												<input type="hidden" name="contact_fields[]" value="<?php echo esc_attr( $form_object['name'] ); ?>">
												<select name="tmlcp_fields[]">
													<option value=""><?php esc_html_e( '-- Plugin Fields --', 'text-message-lead-collection-pro' ); ?></option>
													<?php
														foreach( $livcomm_fields as $value => $label ) {

															if( $field_map ) {

																$selected = selected( $value , $tmlcp_form_mapping[ $form_object['name'] ] , false );
																
															}
															?>
																<option value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_html( $label ); ?></option>
															<?php
														}
													?>
												</select>
											</div>
											<?php
										}
									}
								?>
								<?php $api_response_body = $this->tmlcp_get_userdata_api(); ?>
								<div class="form-group">
									<label><?php esc_html_e( 'Default Form Livecomm Number', 'text-message-lead-collection-pro' );?></label>
									<input type="hidden" name="contact_fields[]" value="livecomm_form_default_phone_number">
										<select name="tmlcp_fields[]">
											<option value=""><?php esc_html_e( '-- Select --', 'text-message-lead-collection-pro' ) ?></option>
											<?php
												if( !empty( $api_response_body ) ) {
													if( isset( $api_response_body->user->phones ) && count( $api_response_body->user->phones ) > 0 )
													{
														foreach( $api_response_body->user->phones as $phoneDetails )
														{
															$option_value = $phoneDetails->name .' ( '.$phoneDetails->number.' )';
															?>
																<option value="<?php echo esc_attr( $phoneDetails->number ); ?>" <?php selected( $phoneDetails->number , $tmlcp_form_mapping['livecomm_form_default_phone_number'], true ); ?>><?php echo esc_html( $option_value ); ?></option>
															<?php
														}
													}
												}
											?>
										</select>
								</div>
								<div class="form-group">
									<label><?php esc_html_e( 'Default Form Livecomm Contact List', 'text-message-lead-collection-pro' ); ?></label>
									<input type="hidden" name="contact_fields[]" value="livecomm_form_default_contact_list">
									<select name="tmlcp_fields[]">
										<option value=""><?php esc_html_e( '-- Select --', 'text-message-lead-collection-pro' ); ?></option>
										<?php
											if( !empty( $api_response_body ) ) {
												if( isset( $api_response_body->user->phones ) && count( $api_response_body->user->phones ) > 0 )
												{
													foreach( $api_response_body->user->lists as $listsDetail )
													{
														?>
															<option value="<?php echo esc_attr( $listsDetail->listid ); ?>" <?php selected( $listsDetail->listid , $tmlcp_form_mapping['livecomm_form_default_contact_list'], true ); ?>><?php echo esc_html( $listsDetail->listname ); ?></option>
														<?php
													}
												}
											}
										?>
									</select>
								</div>
								<div class="form-group">
									<input type="submit" name="tmlcp_submit" value="Save" class="button button-primary">
									<p class="response-message"></p>
								</div>
							</form>
							<p><b><?php esc_html_e( 'NOTE: In-order to send contact form data to Livecomm through API, below are the list of fields which should not be empty and should be marked as required in Contact Form 7 plugin.', 'text-message-lead-collection-pro' ); ?> </b><a href="<?php echo esc_url( TMLCP_DIR_URL.'admin/images/contact_form_7_required_field.png' ); ?>" target="_blank"><?php esc_html_e( 'Click here for more info', 'text-message-lead-collection-pro' ); ?></a></p>
							<ol>
								<li><?php esc_html_e( 'Name', 'text-message-lead-collection-pro' ); ?></li>
								<li><?php esc_html_e( 'Last Name', 'text-message-lead-collection-pro' ); ?></li>
								<li><?php esc_html_e( 'Phone Number', 'text-message-lead-collection-pro' ); ?></li>
								<li><?php esc_html_e( 'Message', 'text-message-lead-collection-pro' ); ?></li>
							</ol>
						</div>
						<?php
					}
					echo '<div class="form-footer">';
			        	echo '<p>';
				    	echo '©' . date('Y') . ' <a href="//beta.livecomm.com/" target="_blank">'. __( 'LiveComm', 'text-message-lead-collection-pro' ) .'</a>'. __( ', All rights reserved.', 'text-message-lead-collection-pro' );
				    	echo '</p>';
				    echo '</div>';
				echo '</div>';
			echo '</div>';
		} else {
			_e('Invalid Contact Form ID', 'text-message-lead-collection-pro');
		}
	}