<div class="form">
	<div class="form-panel one forlogo">
	    <div class="admin-header-logo">
	        <img class="logo" src="<?php echo esc_url( TMLCP_DIR_URL.'admin/images/livecomm-logo.png' ); ?>" alt="LiveComm" />
	    </div>
		<div class="form-header">
		  	<h1><?php esc_html_e( 'Login to Livecomm' , 'text-message-lead-collection-pro' );?></h1>
		  	<?php
				if( $this->tmlcp_is_user_logged_in() )
				{
					$this->tmlcp_get_logged_in_message();
					echo sprintf(
						'<p><strong>%1$s <a href="//beta.livecomm.com/user.php?action=login" target="_blank">%2$s</a></strong></p>',
						esc_html__( 'Livecomm.com is a communication tool. Setup virtual phone numbers, call and send mass text messages using our platform.', 'text-message-lead-collection-pro' ),
						esc_html__( 'Manage my livecomm account.', 'text-message-lead-collection-pro' )
					);
				}
				else
				{
					echo sprintf(
						'<p><strong>%1$s <a href="//www.livecomm.com/signup-new/" target="_blank">www.livecomm.com</a></strong></p>',
						esc_html__( 'Livecomm.com is a communication tool. Setup virtual phone numbers, call and send mass text messages using our platform. Don’t have an account? Create an account at', 'text-message-lead-collection-pro' )
					);
				}
			?>	
		</div>
		<?php
			if ( ! $this->tmlcp_is_user_logged_in() ) {
				?>
				<div class="form-content">
							<form class="tmlcp-form" name="tmlcp_login" id="tmlcp_login">
								<div class="form-group">
								  <label for="username"><?php esc_html_e( 'Username' , 'text-message-lead-collection-pro' );?></label>
								  <input type="text" name="tmlcp_username" placeholder="<?php esc_attr_e( 'Livecomm Username' , 'text-message-lead-collection-pro' );?>" required>
								</div>
								<div class="form-group">
								  <label for="password"><?php esc_html_e( 'Password' , 'text-message-lead-collection-pro' );?></label>
								  <input type="password" name="tmlcp_password" placeholder="<?php esc_attr_e( 'Livecomm Password' , 'text-message-lead-collection-pro' );?>" required>
								</div>
								<div class="form-group">
									<input type="submit" name="tmlcp_submit" value="Login" class="button button-primary">
								</div>
								<div class="form-group">
									<input type="hidden" name="tmlcp_login_nonce" value="<?php echo esc_attr( wp_create_nonce('tmlcp-login-nonce') ); ?>">
									<input type="hidden" name="action" value="tmlcp_livecomm_login">
								</div>
								<p class="response-message"></p>
							</form>
				</div>
				<?php
			}
		?>
		<div class="form-footer">
        	<p>
	    	©<?php echo date('Y'); ?> <a href="//beta.livecomm.com/" target="_blank"><?php esc_html_e( 'LiveComm', 'text-message-lead-collection-pro' );?></a><?php esc_html_e( ', All rights reserved.', 'text-message-lead-collection-pro' );?>
	    	</p>
	    </div>
  	</div>
</div>