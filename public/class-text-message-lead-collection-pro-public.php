<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.livecomm.com
 * @since      1.0
 *
 * @package    Text_Message_Lead_Collection_Pro
 * @subpackage Text_Message_Lead_Collection_Pro/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Text_Message_Lead_Collection_Pro
 * @subpackage Text_Message_Lead_Collection_Pro/public
 * @author     Text Comm, LLC <info@vndx.com>
 */
class Text_Message_Lead_Collection_Pro_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->plugin_admin = new Text_Message_Lead_Collection_Pro_Admin( $plugin_name, $version );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Text_Message_Lead_Collection_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Text_Message_Lead_Collection_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/text-message-lead-collection-pro-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Text_Message_Lead_Collection_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Text_Message_Lead_Collection_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/text-message-lead-collection-pro-public.js', array( 'jquery' ), time(), false );

		wp_localize_script( 
							$this->plugin_name, 
							'tmlcpFrontVars',
							array('admin_url' => TMLCP_AJAX_URL )
						);

	}

	/**
	 * Fetching whether plugin is Enable/Disable from Settings
	 *
	 * @since    1.0
	 */
	public function tmlcp_is_plugin_enabled() {

		$plugin_enabled = get_option('tmlcp_enable_plugin');

		if( $plugin_enabled == 'yes' )
			return true;
		else
			return false;
	}

	/**
	 * Registering Custom Shortcode
	 *
	 * @since    1.0
	 */
	public function tmlcp_register_shortcode() {

		add_shortcode('tmlcp-livecomm-form', array( $this, 'tmlcp_livecomm_form_shortcode_callback') );
	}

	
	/**
	 * Sending Form Data to Livecomm via API
	 *
	 * @since    1.0
	 */
	public function tmlcp_send_contact_data_livecomm( $cf7 ) {

		// get the contact form object

	    $wpcf 				= WPCF7_ContactForm::get_current();

		$submission 		= WPCF7_Submission::get_instance();

		$contact_form_id 	= $wpcf->id();

		$tmlcp_contact_forms = get_option('tmlcp_contact_forms');

		if( $submission ) {

			// Checking if submitted form has been mapped or not
			if( !empty( $tmlcp_contact_forms ) && is_array( $tmlcp_contact_forms ) && count( $tmlcp_contact_forms ) > 0 && in_array( $contact_form_id, $tmlcp_contact_forms ) ) {

				$tmlcp_form_mapping 	= get_option( 'tmlcp_form_mapping_' . $contact_form_id );

				// Checking if mapping fields exist in Database
				if( !empty( $tmlcp_form_mapping ) && is_array( $tmlcp_form_mapping ) ) {

					$data = $submission->get_posted_data();

					$mapped_fields['livecomm_field_fname'] 			= 'name';
					$mapped_fields['livecomm_field_lname'] 			= 'last_name';
					$mapped_fields['livecomm_field_email'] 			= 'email';
					$mapped_fields['livecomm_field_phone_number'] 	= 'phone_number';
					$mapped_fields['livecomm_field_company'] 		= 'company';
					$mapped_fields['livecomm_field_message'] 		= 'message';

					foreach ($mapped_fields as $key => $value) {
						
						$livecomm_key 			= array_search( $key , $tmlcp_form_mapping );
						$livecomm_data[$value] 	=  isset( $data[$livecomm_key] ) ? $data[$livecomm_key] : '';
					}
					
					if ( ! empty( $tmlcp_form_mapping['livecomm_form_default_phone_number'] ) ) {
						$livecomm_data['livecomm_form_default_phone_number'] = $tmlcp_form_mapping['livecomm_form_default_phone_number'];
					}

					if ( ! empty( $tmlcp_form_mapping['livecomm_form_default_contact_list'] ) ) {
						$livecomm_data['livecomm_form_default_contact_list'] = $tmlcp_form_mapping['livecomm_form_default_contact_list'];
					}
					// Sending submitted data to Livecomm API
					$api_output = $this->tmlcp_submit_contact_data( $livecomm_data );

				}
			}
		}
	}

	/**
	 * Livecomm Custom Form Shortcode
	 *
	 * @since    1.0
	 */
	public function tmlcp_livecomm_form_shortcode_callback( $atts = [], $content = null) { 

		ob_start();
		
		?>

		<div class="tmlcp-wrapper">
			<h3><?php esc_html_e( 'Livecomm Form' , 'text-message-lead-collection-pro' );?></h3>
			<form class="tmlcp-livecomm-form" name="tmlcp_livecomm_form" id="tmlcp_livecomm_form">
				<table cellpadding="10" cellspacing="0" border="1" align="center">
					<tbody>
						<tr>
							<td><?php esc_html_e( 'Name' , 'text-message-lead-collection-pro' );?></td>
							<td><input type="text" name="tmlcp_name" placeholder="Your Name" required></td>
						</tr>
						<tr>
							<td><?php esc_html_e( 'Last name' , 'text-message-lead-collection-pro' );?></td>
							<td><input type="text" name="tmlcp_last_name" placeholder="Your last name" required></td>
						</tr>
						<tr>
							<td><?php esc_html_e( 'Enter your phone number' , 'text-message-lead-collection-pro' );?></td>
							<td><input type="text" name="tmlcp_phone_number" placeholder="Your phone number" required></td>
						</tr>
						<tr>
							<td><?php esc_html_e( 'Message' , 'text-message-lead-collection-pro' );?></td>
							<td><textarea name="tmlcp_message" placeholder="Type your message here" required></textarea></td>
						</tr>
						
						<tr>
							<td align="center" colspan="2"><input type="submit" name="tmlcp_livecomm_form_submit" value="Send" class="button button-primary"></td>
						</tr>
					</tbody>
				</table>
				
				<input type="hidden" name="tmlcp_livecomm_form_nonce" value="<?php echo esc_attr( wp_create_nonce('tmlcp-livecomm-form-nonce') ); ?>">
				
				<input type="hidden" name="action" value="tmlcp_livecomm_lead_create_form">
				
				<p class="response-message"></p>
			
			</form>
			
		</div>

		<?php

		return ob_get_clean();
	}

	/**
	 * Floating Button Form
	 *
	 * @since    1.0
	 */
	public function tmlcp_floating_button_form() {
		?>
			<div class="tmlcp-wrapper">
				<form class="tmlcp-livecomm-form" name="tmlcp_livecomm_form" id="tmlcp_livecomm_form">
				    <div class="form-row">
                        <div class="form-group">
                            <label><?php esc_html_e( 'First Name' , 'text-message-lead-collection-pro' );?></label>
                            <input type="text" name="tmlcp_name" placeholder="Your first name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label><?php esc_html_e( 'Last name' , 'text-message-lead-collection-pro' );?></label>
                            <input type="text" name="tmlcp_last_name" placeholder="Your last name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label><?php esc_html_e( 'Enter your phone number' , 'text-message-lead-collection-pro' );?></label>
                            <input type="text" name="tmlcp_phone_number" placeholder="Your phone number" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label><?php esc_html_e( 'Message' , 'text-message-lead-collection-pro' );?></label>
                            <textarea name="tmlcp_message" placeholder="Type your message here" required></textarea>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <input type="submit" name="tmlcp_livecomm_form_submit" value="Send" class="button button-primary">
					    </div>
					</div>

					<input type="hidden" name="tmlcp_livecomm_form_nonce" value="<?php echo esc_attr( wp_create_nonce('tmlcp-livecomm-form-nonce') ); ?>">
					
					<input type="hidden" name="action" value="tmlcp_livecomm_lead_create_form">
					
					<p class="response-message"></p>
				
				</form>
				
				<div class="tmlcp-floating-button">
					<a class="tmlcp-message-icon active" href="javascript:void(0)">
						<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ).'images/message-icon.svg' ); ?>" alt="Message Icon">
					</a>
					<a class="tmlcp-close-icon" href="javascript:void(0)">
						<img  src="<?php echo esc_url( plugin_dir_url( __FILE__ ).'images/close-icon.svg' ); ?>" alt="Close Icon">
					</a>
		    	</div>
			</div>
		<?php
	}

	public function tmlcp_livecomm_lead_create_form_callback() {
		
		$status = false;
		$response = [];

		$name  					= sanitize_text_field( $_POST[ 'tmlcp_name' ] );
		$last_name  			= sanitize_text_field( $_POST[ 'tmlcp_last_name' ] );
		$phone_number 			= sanitize_text_field( $_POST[ 'tmlcp_phone_number' ] );
		$message  				= sanitize_textarea_field( $_POST[ 'tmlcp_message' ] );
		
		$livecomm_form_nonce   	= $_POST[ 'tmlcp_livecomm_form_nonce' ]; // phpcs:ignore 

		// Authentication about Nonce to prevent from attackers
		if ( ! wp_verify_nonce( $livecomm_form_nonce, 'tmlcp-livecomm-form-nonce' ) )
		{
			$message = __("Error: Something went wrong.",'text-message-lead-collection-pro');
		}
		else if( empty( $name ) )
		{
			$message = __('Name is required','text-message-lead-collection-pro');
		}
		else if( empty( $last_name ) )
		{
			$message = __('Last Name is required','text-message-lead-collection-pro');
		}
		else if( empty( $phone_number ) )
		{
			$message = __('Phone number is required','text-message-lead-collection-pro');
		}
		else if( empty( $message ) )
		{
			$message = __('Message is required','text-message-lead-collection-pro');
		}
		else
		{
			$data['name'] 			= $name;
			$data['last_name'] 		= $last_name;
			$data['phone_number'] 	= $phone_number;
			$data['message'] 		= $message;	

			$api_output = $this->tmlcp_submit_contact_data( $data );
			$code 		= $api_output['code'];
			$status 	= $api_output['status'];
			$message 	= $api_output['message'];
		}
		

		$response['status'] = $status;
		$response['message'] = $message;
		
		echo wp_json_encode( $response );
		wp_die();
    
	}

	public function tmlcp_submit_contact_data( $data ) {

		$status 			= false;
		$message 			= '';
		$code 				= 0;
		$bearer_token 		= $this->plugin_admin->tmlcp_get_bearer_token();
		
		$body['action'] 	= 'submitMessage';
		$body['personid'] 	= $this->plugin_admin->tmlcp_get_user_id();
		$body['name']		= $data['name'];
		$body['last_name']	= $data['last_name'];
		$body['email']		= isset( $data['email'] ) ? $data['email'] : '';
		$body['company']	= isset( $data['company'] ) ? $data['company'] : '';

		// Checked if default form number otherwise get data from default phone number
		if ( ! empty( $data['livecomm_form_default_phone_number'] ) ) {
			$body['lc_number'] 	= $data['livecomm_form_default_phone_number'];
		} else{
			$body['lc_number'] 	= get_option('livecomm_default_phone_number');
		}

		// Check if default form contact list otherwise get data from default contact list
		if ( ! empty( $data['livecomm_form_default_contact_list'] ) ) {
			$body['listid'] 	= $data['livecomm_form_default_contact_list'];
		} else{
			$body['listid'] 	= get_option('livecomm_default_contact_list');
		}

		$body['from_number'] = $data['phone_number'];
		$body['message']	= $data['message'];
		$body['website']	= get_site_url();

		$authorization 		= 'Bearer '. $bearer_token;

		$headers 			= array( 'Authorization' => $authorization);

		$options 			= ['body' => $body, 'headers' => $headers, 'sslverify'   => false ];

		print_r( $options );
		wp_die();
		//return($options);
		//exit();

		// Executing GetUserData API Call to Livecomm Site
		$api_response = wp_remote_post( TMLCP_API_BASE_URL, $options );

		//print_r( $api_response ); exit;

		if( is_wp_error( $api_response ) )
		{
			 $message = $api_response->get_error_message();
		}
		else
		{		  
			$api_response_body = wp_remote_retrieve_body( $api_response );
			$api_response_body = json_decode( $api_response_body );
			
			if( ($api_response_body->code == 200 || $api_response_body->code == 201) && $api_response_body->success == true )
			{
				$status = true;
				$message = __('Message sent successfully','text-message-lead-collection-pro');
			}
			// If token is expired, then regenerate new token by calling Login API again
			else if( $api_response_body->code == 426 )
			{
				$bearer_token = $this->plugin_admin->tmlcp_refresh_api_token();
				if( !empty( $bearer_token ) )
				{
					return $this->tmlcp_submit_contact_data( $data );
				}
			}
			else
			{
				if( isset( $api_response_body->message ) && !empty( $api_response_body->message ) )
				{
					$message = $api_response_body->message;
				}
				else
				{
					$message = __('Error while sending message','text-message-lead-collection-pro');
				}
			}
			$code = $api_response_body->code;
		}
		$api_output['status'] 	= $status;
		$api_output['code'] 	= $code;
		$api_output['message'] 	= $message;
		$api_output['api_response'] = $api_response;
		return $api_output;

	}
	public function tmlcp_call_to_action() {
		echo '<div class="tmlcp-container">Call Action</div>';
	}
}
