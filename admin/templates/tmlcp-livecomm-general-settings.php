<div class="form">
  	<div class="form-panel forlogo">
	    <div class="admin-header-logo">
	        <img class="logo" src="<?php echo esc_url( TMLCP_DIR_URL.'admin/images/livecomm-logo.png' ); ?>" alt="LiveComm" />
	    </div>
		<div class="form-header">
			<h1><?php esc_html_e( 'General Settings', 'text-message-lead-collection-pro' ); ?></h1>
		</div>
		<div class="form-content">
			<form name="tmlcp_general_settings" class="tmlcp-form1 tmlcp-form" id="tmlcp_general_settings">
				<div class="form-group">
					<h4><?php esc_html_e( 'Enable plugin functionality on front site','text-message-lead-collection-pro');?></h4>
		            <fieldset>
					    <label for="tmlcp_enable_plugin">
					        <input name="tmlcp_enable_plugin" type="checkbox" id="tmlcp_enable_plugin" value="<?php echo esc_attr( 'yes','text-message-lead-collection-pro'); ?>" <?php echo checked( 'yes', get_option( 'tmlcp_enable_plugin'), false ); ?> ><?php esc_html_e( 'To temporary disable this plugin, uncheck this checkbox','text-message-lead-collection-pro');?>
					    </label>
				    </fieldset>
				</div>
				<div class="form-group">
					<h4><?php esc_html_e( 'Enable floating button functionality on site','text-message-lead-collection-pro');?> </h4>
					<fieldset>
						<label for="tmlcp_enable_floating_plugin">
					    	<input name="tmlcp_enable_floating_plugin" type="checkbox" id="tmlcp_enable_floating_plugin" value="<?php echo esc_attr( 'yes','text-message-lead-collection-pro'); ?>" <?php echo checked( 'yes', get_option( 'tmlcp_enable_floating_plugin'), false ); ?> ><?php esc_html_e( 'To disable floating button on site, uncheck this checkbox','text-message-lead-collection-pro');?>
						</label>
					</fieldset>
				</div>
				<div class="form-group">
					<div class="btns">
		    			<input type="hidden" name="tmlcp_general_setting_nonce" value="<?php echo esc_attr( wp_create_nonce('tmlcp-general-setting-nonce') ); ?>" >
		    			<input type="hidden" name="action" value="tmlcp_save_general_setting">
		    			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_attr( 'Save Changes','text-message-lead-collection-pro'); ?>">
		    		</div>
				    <p class="response-message"></p>
				</div>
			</form>
		</div>
		<div class="form-footer">
        	<p>
	    	©<?php echo date('Y'); ?> <a href="//beta.livecomm.com/" target="_blank"><?php esc_html_e( 'LiveComm', 'text-message-lead-collection-pro' );?></a><?php esc_html_e( ', All rights reserved.', 'text-message-lead-collection-pro' );?>
	    	</p>
	    </div>
	</div>
</div>
