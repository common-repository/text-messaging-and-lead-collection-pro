<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.livecomm.com
 * @since      1.0
 *
 * @package    Text_Message_Lead_Collection_Pro
 * @subpackage Text_Message_Lead_Collection_Pro/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Text_Message_Lead_Collection_Pro
 * @subpackage Text_Message_Lead_Collection_Pro/admin
 * @author     Text Comm, LLC <info@vndx.com>
 */
class Text_Message_Lead_Collection_Pro_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0
	 */
	public function enqueue_styles( $hook ) {

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
		
		// Include script only for plugin admin page
		if( $hook == 'toplevel_page_tmlcp-setup-configure' || 
			$hook == 'text-message-lead-collection-pro_page_tmlcp-livecomm-phone-numbers' ||
			$hook == 'text-message-lead-collection-pro_page_tmlcp-livecomm-contact-list' ||
			$hook == 'text-message-lead-collection-pro_page_tmlcp-form-mapping' ||
			$hook == 'text-message-lead-collection-pro_page_tmlcp-my-mapped-forms' ||
			$hook == 'text-message-lead-collection-pro_page_tmlcp-general-settings' )
		{
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/text-message-lead-collection-pro-admin.css', array(), $this->version, 'all' );	
		}
		

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0
	 */
	public function enqueue_scripts( $hook ) {

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

		// Include script only for plugin admin page
		if( $hook == 'toplevel_page_tmlcp-setup-configure' || 
			$hook == 'text-message-lead-collection-pro_page_tmlcp-livecomm-phone-numbers' ||
			$hook == 'text-message-lead-collection-pro_page_tmlcp-livecomm-contact-list' ||
			$hook == 'text-message-lead-collection-pro_page_tmlcp-form-mapping' ||
			$hook == 'text-message-lead-collection-pro_page_tmlcp-my-mapped-forms' ||
			$hook == 'text-message-lead-collection-pro_page_tmlcp-general-settings' )
		{
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/text-message-lead-collection-pro-admin.js', array( 'jquery' ), $this->version, false );

			wp_localize_script( 
							$this->plugin_name, 
							'tmlcpAdminVars',
							array(
								'admin_url' => TMLCP_AJAX_URL, 
								'form_map_delete_text' => __( 'Are you sure you want to unmap this form ?', 'text-message-lead-collection-pro') 
							)
						);
		}

	}


	/**
     * Menu item will allow us to load the settings page of plugin
     * @since    1.0
     */
    public function tmlcp_admin_menu() {

		// Fallback: Make sure only admin has access
		$tmlcp_cap = 'manage_options';

        add_menu_page(
        	 __( 'Text Message Lead Collection Pro', 'text-message-lead-collection-pro' ), 
        	 __( 'Text Message Lead Collection Pro', 'text-message-lead-collection-pro' ), 
        	 $tmlcp_cap, 
        	 'tmlcp-setup-configure', 
        	 array($this, 'tmlcp_setup_configure'), 
        	 'dashicons-buddicons-pm' 
        );

        add_submenu_page( 
    		'tmlcp-setup-configure', 
    		__( 'Setup/Configure',  'text-message-lead-collection-pro' ), 
    		__( 'Setup/Configure',  'text-message-lead-collection-pro' ),
    		$tmlcp_cap , 
    		'tmlcp-setup-configure', 
    		array($this, 'tmlcp_setup_configure')
    	);

        add_submenu_page( 
        	'tmlcp-setup-configure', 
        	__( 'Livecomm Phone Numbers',  'text-message-lead-collection-pro' ), 
        	__( 'Livecomm Phone Numbers',  'text-message-lead-collection-pro' ), 
        	$tmlcp_cap , 
        	'tmlcp-livecomm-phone-numbers', 
        	array($this, 'tmlcp_phone_number_list')
        );

		add_submenu_page( 
        	'tmlcp-setup-configure', 
        	__( 'Livecomm Contact List',  'text-message-lead-collection-pro' ), 
        	__( 'Livecomm Contact List',  'text-message-lead-collection-pro' ), 
        	$tmlcp_cap , 
        	'tmlcp-livecomm-contact-list', 
        	array($this, 'tmlcp_contact_list')
        );

        add_submenu_page( 
        	'tmlcp-setup-configure', 
        	__( 'Form Mapping',  'text-message-lead-collection-pro' ), 
        	__( 'Form Mapping',  'text-message-lead-collection-pro' ), 
        	$tmlcp_cap , 
        	'tmlcp-form-mapping', 
        	array($this, 'tmlcp_form_mapping')
        );

        add_submenu_page( 
        	'tmlcp-setup-configure', 
        	__( 'My Mapped Forms',  'text-message-lead-collection-pro' ), 
        	__( 'My Mapped Forms',  'text-message-lead-collection-pro' ), 
        	$tmlcp_cap , 
        	'tmlcp-my-mapped-forms', 
        	array($this, 'tmlcp_my_mapped_forms')
        );

		add_submenu_page( 
        	'tmlcp-setup-configure', 
        	__( 'General Settings',  'text-message-lead-collection-pro' ), 
        	__( 'General Settings',  'text-message-lead-collection-pro' ), 
        	$tmlcp_cap , 
        	'tmlcp-general-settings', 
        	array($this, 'tmlcp_general_settings')
        );


    }

    /**
     * Display the list table page
     *
     * @return Void
     */
    public function tmlcp_setup_configure() {
    	
    	$this->tmlcp_refresh_api_token();
    	require_once TMLCP_DIR_PATH . 'admin/templates/tmlcp-livecomm-login.php';

    }

	/**
     * Display the phone number list page
     *
     * @return Void
     */
    public function tmlcp_phone_number_list() {

    	require_once TMLCP_DIR_PATH . 'admin/templates/tmlcp-livecomm-phone-number-list.php';

    }

    /**
     * Display the contact list page
     *
     * @return Void
     */
    public function tmlcp_contact_list() {

    	require_once TMLCP_DIR_PATH . 'admin/templates/tmlcp-livecomm-contact-list.php';

    }

    /**
     * Form Mapping with Livecomm Fields
     *
     * @return Void
     */
    public function tmlcp_form_mapping()
    {
		require_once TMLCP_DIR_PATH . 'admin/templates/tmlcp-livecomm-form-mapping.php';
		if ( ! isset( $_GET['contact_form_edit'] ) || $_GET['contact_form_edit'] != true ) {
			require_once TMLCP_DIR_PATH . 'admin/templates/tmlcp-list-mapped-forms.php';
		}
    }

    /**
     * Display all mapped forms
     *
     * @return Void
     */
    public function tmlcp_my_mapped_forms()
    {
    	require_once TMLCP_DIR_PATH . 'admin/templates/tmlcp-list-mapped-forms.php';
    	
    }

	/**
     * Display general settings page
     *
     * @return Void
     */
    public function tmlcp_general_settings()
    {
    	require_once TMLCP_DIR_PATH . 'admin/templates/tmlcp-livecomm-general-settings.php';
    	
    }
	

    // Login AJAX Callback
    public function tmlcp_livecomm_login_callback()
    {
    	$status = false;
		$response = [];
		$secret_detail = [];
		$user_detail = [];

		if( isset( $_POST[ 'tmlcp_username' ] ) && 
			isset( $_POST[ 'tmlcp_password' ] ) )
		{
			$user_name  		= sanitize_user( $_POST[ 'tmlcp_username' ] );
			$user_password  	= $_POST[ 'tmlcp_password' ]; // phpcs:ignore
			$user_login_nonce   = $_POST[ 'tmlcp_login_nonce' ]; // phpcs:ignore 

			// Authentication about Nonce to prevent from attackers
			if ( ! wp_verify_nonce( $user_login_nonce, 'tmlcp-login-nonce' ) )
			{
				$message = __("Error: Something went wrong.",'text-message-lead-collection-pro');
			}
			// Username and Password should not be empty
			else if( empty( $user_name ) || empty( $user_password ) )
			{
				$message = __('Username and password is required','text-message-lead-collection-pro');
			}
			else
			{
				$body['action'] 		= 'loginUser';
				$body['username'] 		= $user_name;
				$body['userpassword'] 	= $user_password;
				
				$options = ['body' => $body,'sslverify'   => false ];
        	
        		// Executing Login API Call to Livecomm Site
		        $api_response = wp_remote_post( TMLCP_API_BASE_URL.'login.php', $options );

		        if( is_wp_error( $api_response ) )
		        {
		            $message  = $api_response->get_error_message();
		        }
		        else
		        {		        	
		            $api_response_body = wp_remote_retrieve_body( $api_response );
        			$api_response_body = json_decode( $api_response_body );

					// Check if user active or not
					if ( $api_response_body->code == '200' && isset( $api_response_body->user->user_active ) && $api_response_body->user->user_active == '1' ) 
					{

						// If user is logged in successfully
						if( isset( $api_response_body->isauthenticated ) && 
							$api_response_body->isauthenticated &&
							isset( $api_response_body->code ) && 
							$api_response_body->code == 200 )
						{
							// Check for livecomm user id
							if( isset( $api_response_body->user->id ))
							{
								$livecomm_user_id = $api_response_body->user->id;
								//update_option('tmlcp_livecomm_user_id', $livecomm_user_id);
								$user_detail['user_id'] = $livecomm_user_id;
							}
							// Check for livecomm User Name
							if( isset( $api_response_body->user->names ))
							{
								$livecomm_user_name = $api_response_body->user->names;
								//update_option('tmlcp_livecomm_user_name', $livecomm_user_name);
								$user_detail['name'] = $livecomm_user_name;
							}
							
							// Check for bearer token for logged-in user
							if( isset( $api_response_body->bearer_token ) && !empty( $api_response_body->bearer_token ) )
							{
								$livecomm_bearer_token = $api_response_body->bearer_token;

								// encrypt bearer token and store it in Database
								$livecomm_bearer_token = $this->tmlcp_encrypt_data( $livecomm_bearer_token );
								
								update_option('tmlcp_livecomm_bearer_token', $livecomm_bearer_token);
							}

							$secret_detail['secret_name'] 	= $this->tmlcp_encrypt_data( $user_name );
							$secret_detail['secret_key'] 	= $this->tmlcp_encrypt_data( $user_password );

							update_option('tmlcp_livecomm_secret_detail', $secret_detail);
							update_option('tmlcp_livecomm_user_detail', $user_detail);
							

							$status = true;
							$message = __( 'Login Success', 'text-message-lead-collection-pro' );
						}
						else
						{
							//If user is not logged in or does not exist in the system
							$message = $api_response_body->errmessage;
						}
        			}
        			else
					{
						//If user is not logged in or does not exist in the system
						$message = $api_response_body->errmessage;
					}
		        }
			}
		}
		else
		{
			$message = __('Username and password is required','text-message-lead-collection-pro');
		}

		$response['status'] = $status;
		$response['message'] = $message;
		
		echo wp_json_encode( $response );
		wp_die();
    }

    // AJAX for Form Mapping callback
    public function tmlcp_livecomm_field_mapping_callback()
    {
    	$status = false;
		$response = [];

		$contact_fields 	= $this->tmlcp_sanitize_array( $_POST['contact_fields'] ); 
		$tmlcp_fields		= $this->tmlcp_sanitize_array( $_POST['tmlcp_fields'] );
		$contact_form_id 	= sanitize_text_field( $_POST['contact_form_id'] );
		$form_map_nonce 	= $_POST['tmlcp_form_map_nonce']; // phpcs:ignore 

		$livecomm_required_fields	= ['livecomm_field_fname','livecomm_field_lname', 'livecomm_field_phone_number', 'livecomm_field_message'];
		
		// Authentication about Nonce to prevent from attackers
		if ( ! wp_verify_nonce( $form_map_nonce, 'tmlcp-form-map-nonce' ) )
		{
			$message = __("Error: Something went wrong.",'text-message-lead-collection-pro');
		}
		else if( !isset( $_POST['contact_fields'] ) || count( $_POST['contact_fields'] ) < 0 )
		{
			$message = __('Please select atleast one contact fields ','text-message-lead-collection-pro');
		}
		// Make sure that required livecomm fields has been mapped with contact form
		else if( !array_filter( $tmlcp_fields ) )
		{
			$message = __('Please select atleast one livecomm fields','text-message-lead-collection-pro');
		}
		else if( array_diff( $livecomm_required_fields, $tmlcp_fields ) )
		{
			$message = __('First Name, Last Name, Phone Number and Message field is required','text-message-lead-collection-pro');
		}
		else if( get_post_type( $contact_form_id ) != 'wpcf7_contact_form' )
		{
			$message = __('Invalid Contact Form ID','text-message-lead-collection-pro');
		}
		else
		{
			$mapping_fields 		= array_combine( $contact_fields, $tmlcp_fields);
			$tmlcp_contact_forms 	= get_option('tmlcp_contact_forms');

			if( empty( $tmlcp_contact_forms ) )
			{
				$tmlcp_contact_forms = [];	
			}
			if( !in_array( $contact_form_id, $tmlcp_contact_forms ) )
			{
				$tmlcp_contact_forms[] = $contact_form_id;
				update_option('tmlcp_contact_forms', $tmlcp_contact_forms );
			}

			update_option('tmlcp_form_mapping_' . $contact_form_id, $mapping_fields );
			
			$status = true;
			$message = __('Field mapping saved','text-message-lead-collection-pro');
		}
		
		$response['status'] = $status;
		$response['message'] = $message;
		
		echo wp_json_encode( $response );
		wp_die();
    }

    // AJAX to Unmap specific form
    public function tmlcp_unmap_form_callback()
    {
    	$status = false;
		$response = [];
		
		$contact_form_id 		= sanitize_text_field( $_POST['contact_form_id'] );
		$unmap_form_nonce 		= $_POST['unmap_form_nonce']; // phpcs:ignore
		$tmlcp_contact_forms 	= get_option('tmlcp_contact_forms');
		
		// Authentication about Nonce to prevent from attackers
		if ( ! wp_verify_nonce( $unmap_form_nonce, 'unmap-form-nonce' ) )
		{
			$message = __("Error: Something went wrong.",'text-message-lead-collection-pro');
		}
		else if( get_post_type( $contact_form_id ) != 'wpcf7_contact_form' )
		{
			$message = __('Invalid Contact Form ID','text-message-lead-collection-pro');
		}
		else if( empty( $tmlcp_contact_forms ) || !is_array( $tmlcp_contact_forms ) || !in_array( $contact_form_id, $tmlcp_contact_forms ) )
		{
			$message = __('Contact form not mapped','text-message-lead-collection-pro');
		}
		else
		{
			if( delete_option( 'tmlcp_form_mapping_' . $contact_form_id ) )
			{
				if ( ( $key = array_search( $contact_form_id, $tmlcp_contact_forms) ) !== false)
				{

					unset( $tmlcp_contact_forms[$key]);

					$tmlcp_contact_forms = array_values( $tmlcp_contact_forms );
				}
			
				update_option('tmlcp_contact_forms', $tmlcp_contact_forms );

				$status = true;
				
				$message = __('Form mapping successfully removed','text-message-lead-collection-pro');
			}
			else
			{
				$message = __('Unable to delete mapped form','text-message-lead-collection-pro');
			}
		}
		
		$response['status'] = $status;
		$response['message'] = $message;
		
		echo wp_json_encode( $response );
		wp_die();
    }

	// Encrypt Data which is used to store specific data of user in Database
	public function tmlcp_encrypt_data( $data ) {

		$ciphering 			= "AES-128-CTR";
		$options 			= 0;
		$encryption_iv 		= '5165184684684684';
		$encryption_key 	= "LivecommTextMessageLead";
		$encryption 		= openssl_encrypt(
								$data,
								$ciphering,
								$encryption_key,
								$options,
								$encryption_iv
							);
		
		return $encryption;
	}

	// Decrypt Data
	public function tmlcp_decrypt_data( $data ) {

		$ciphering 		= "AES-128-CTR";
		$options 		= 0;
		$decryption_iv 	= '5165184684684684';
		$decryption_key = "LivecommTextMessageLead";

		$decryption 	= openssl_decrypt(
								$data,
								$ciphering,
								$decryption_key,
								$options,
								$decryption_iv
							);

		return $decryption;
	}

	// Get Bearer Token of Logged-in User
	public function tmlcp_get_bearer_token() {
		$bearer_token = get_option('tmlcp_livecomm_bearer_token');

		if( !empty( $bearer_token ) )
			$bearer_token = $this->tmlcp_decrypt_data( $bearer_token );
		
		return $bearer_token;
	}

	// Check if user is logged in or not by fetching user detail information
	public function tmlcp_is_user_logged_in() {

		$tmlcp_user_detail = get_option('tmlcp_livecomm_user_detail');

		if( !empty( $tmlcp_user_detail ) && is_array( $tmlcp_user_detail ) ) {
			return true;
		}
		else {
			return false;
		}
    }

	// Fetch User ID of currently logged-in livecomm user
	public function tmlcp_get_user_id() {
		$user_id = '';
		$tmlcp_user_detail = get_option('tmlcp_livecomm_user_detail');

		if( !empty( $tmlcp_user_detail ) && 
			is_array( $tmlcp_user_detail ) && 
			isset( $tmlcp_user_detail['user_id'] ) &&
			!empty( $tmlcp_user_detail['user_id'] ) ) {

				$user_id = $tmlcp_user_detail['user_id'];
		}
		return $user_id;
	}

	// Fetch name of currently logged-in livecomm user
	public function tmlcp_get_userdata() {
		$user_name = '';
		$tmlcp_user_detail = get_option('tmlcp_livecomm_user_detail');

		if( !empty( $tmlcp_user_detail ) && 
			is_array( $tmlcp_user_detail ) && 
			isset( $tmlcp_user_detail['name'] ) &&
			!empty( $tmlcp_user_detail['name'] ) ) {

				$user_name = $tmlcp_user_detail['name'];
		}
		return $user_name;
	}

	public function tmlcp_logout_user() {
		if ( ! empty( $_GET['livecomm_logout']  ) && $_GET['livecomm_logout'] == true ) {
			update_option( 'tmlcp_livecomm_user_detail', '' );
			wp_redirect( menu_page_url( 'tmlcp-setup-configure', false ) );
        	die;
		}		
	}

	public function tmlcp_get_logged_in_message() {

		$logout_url = add_query_arg( 'livecomm_logout', true, menu_page_url( 'tmlcp-setup-configure', false ) );
		echo '<p>' . __( 'You are currently logged-in as', 'text-message-lead-collection-pro' ) . ' ' . $this->tmlcp_get_userdata() . '. <a href="' . esc_url( $logout_url ) . '">' . __( 'Click here to logout', 'text-message-lead-collection-pro' ) . '</a></p>';
	}

	public function tmlcp_get_not_logged_in_message() {

		echo '<p>' . __( 'You are not logged-in.', 'text-message-lead-collection-pro' ) . ' <a href="' . esc_url( menu_page_url( 'tmlcp-setup-configure', false ) ) . '">' . __( 'Click here to login', 'text-message-lead-collection-pro' ) . '</a></p>';
	}

	public function tmlcp_print_api_error_message( $api_response_body ) {

		$this->tmlcp_reset_logged_in_data();

		if( isset( $api_response_body->message ) && !empty( $api_response_body->message ) ) {

			$error_message = $api_response_body->message;
		}
		else if( isset( $api_response_body->status ) && !empty( $api_response_body->status ) ) {
			$error_message = $api_response_body->status;
		}
		else {
			$error_message = __('Error : Something went wrong','text-message-lead-collection-pro');
		}
		
		echo '<p>'. esc_html( $error_message ) .' <a href="' . esc_url( menu_page_url( 'tmlcp-setup-configure', false ) ) . '">Click here to login</a></p>';
	}

	public function tmlcp_reset_logged_in_data() {

		update_option('tmlcp_livecomm_user_detail','');

	}

	// Set Default Phone Number
	public function tmlcp_set_default_phonenumber_callback() {

		$status = false;
		$response = [];
		
		$tmlcp_phone_list_nonce = $_POST['tmlcp_phone_list_nonce']; // phpcs:ignore 
		
		// Authentication about Nonce to prevent from attackers
		if ( ! wp_verify_nonce( $tmlcp_phone_list_nonce, 'tmlcp-phone-list-nonce' ) )
		{
			$message = __("Error: Something went wrong.",'text-message-lead-collection-pro');
		}
		else if( ! isset( $_POST['livecomm_default_phone_number'] ) || empty( $_POST['livecomm_default_phone_number']) )
		{
			$message = __('Select atleast one phone number','text-message-lead-collection-pro');
		}
		else
		{
			update_option('livecomm_default_phone_number', sanitize_text_field( $_POST['livecomm_default_phone_number'] ));
			
			$status = true;
			$message = __('Default phone number saved','text-message-lead-collection-pro');

		}

		$response['status'] = $status;
		$response['message'] = $message;
		echo wp_json_encode( $response );
		wp_die();

	}

	// Set Default Contact List
	public function tmlcp_set_default_contact_list_callback() {

		$status = false;
		$response = [];
		
		$tmlcp_contact_list_nonce = $_POST['tmlcp_contact_list_nonce']; // phpcs:ignore 
		
		// Authentication about Nonce to prevent from attackers
		if ( ! wp_verify_nonce( $tmlcp_contact_list_nonce, 'tmlcp-contact-list-nonce' ) )
		{
			$message = __("Error: Something went wrong.",'text-message-lead-collection-pro');
		}
		else if( ! isset( $_POST['livecomm_default_contact_list'] ) || empty( $_POST['livecomm_default_contact_list']) )
		{
			$message = __('Select atleast one contact list','text-message-lead-collection-pro');
		}
		else
		{
			update_option('livecomm_default_contact_list', sanitize_text_field( $_POST['livecomm_default_contact_list'] ) );
			
			$status = true;
			$message = __('Default contact list saved','text-message-lead-collection-pro');

		}

		$response['status'] = $status;
		$response['message'] = $message;
		echo wp_json_encode( $response );
		wp_die();

	}

	// Set General Settings
	public function tmlcp_save_general_setting_callback() {

		$status = false;
		$response = [];
		$tmlcp_general_setting_nonce = $_POST['tmlcp_general_setting_nonce']; // phpcs:ignore 
		
		// Authentication about Nonce to prevent from attackers
		if ( ! wp_verify_nonce( $tmlcp_general_setting_nonce, 'tmlcp-general-setting-nonce' ) )
		{
			$message = __("Error: Something went wrong.",'text-message-lead-collection-pro');
		}
		
		else
		{
			$tmlcp_enable_plugin = ( isset( $_POST['tmlcp_enable_plugin'] ) && $_POST['tmlcp_enable_plugin'] == 'yes') ? 'yes' : 'no';
			
			update_option('tmlcp_enable_plugin', $tmlcp_enable_plugin);

			if( isset( $_POST['tmlcp_enable_floating_plugin'] ) && $_POST['tmlcp_enable_floating_plugin'] == 'yes')
			{
				$tmlcp_enable_floating_plugin = sanitize_text_field( $_POST['tmlcp_enable_floating_plugin'] );
			}
			
			update_option('tmlcp_enable_floating_plugin', $tmlcp_enable_floating_plugin);
			
			$status = true;
			$message = __('Setting saved','text-message-lead-collection-pro');

		}

		$response['status'] = $status;
		$response['message'] = $message;
		echo wp_json_encode( $response );
		wp_die();

	}

	public function tmlcp_refresh_api_token() {

		$bearer_token = '';
		$secret_detail = get_option('tmlcp_livecomm_secret_detail');
		if( !empty( $secret_detail ) && 
			is_array( $secret_detail ) && 
			isset( $secret_detail['secret_name'] ) && 
			!empty( $secret_detail['secret_name'] ) &&
			isset( $secret_detail['secret_key'] ) && 
			!empty( $secret_detail['secret_key'] ) )
		{

			$body['action'] 		= 'loginUser';
			$body['username'] 		= $this->tmlcp_decrypt_data( $secret_detail['secret_name'] );
			$body['userpassword'] 	= $this->tmlcp_decrypt_data( $secret_detail['secret_key'] );

			$options = ['body' => $body,'sslverify'   => false ];
	
			// Executing Login API Call to Livecomm Site
	        $api_response = wp_remote_post( TMLCP_API_BASE_URL.'login.php', $options );
	        
	        if( is_wp_error( $api_response ) )
	        {
	            $message  = $api_response->get_error_message();
	        }
	        else
	        {		        	
	            $api_response_body = wp_remote_retrieve_body( $api_response );
				$api_response_body = json_decode( $api_response_body );

				// Check if user active or not
				if ( $api_response_body->code == '200' && isset( $api_response_body->user->user_active ) && $api_response_body->user->user_active == '1' ) 
				{
					// If user is logged in successfully
					if( isset( $api_response_body->isauthenticated ) && 
						$api_response_body->isauthenticated &&
						isset( $api_response_body->code ) && 
						$api_response_body->code == 200 )
					{
						// Check for bearer token for logged-in user
						if( isset( $api_response_body->bearer_token ) && !empty( $api_response_body->bearer_token ) )
						{
							$bearer_token = $api_response_body->bearer_token;

							// encrypt bearer token and store it in Database
							$livecomm_bearer_token = $this->tmlcp_encrypt_data( $bearer_token );
							
							update_option('tmlcp_livecomm_bearer_token', $livecomm_bearer_token);
						}
					}
				}
				else
				{
					//If user is not logged in or does not exist in the system
					$message = $api_response_body->errmessage;
				}
			}
		}
		return $bearer_token;
	}

	public function tmlcp_get_userdata_api() {

		$api_response_body 	= '';		
		$bearer_token 		= $this->tmlcp_get_bearer_token();
		
		$body['action'] 	= 'getUserData';
		$body['personid'] 	= $this->tmlcp_get_user_id();

		$authorization 		= 'Bearer '. $bearer_token;

		$headers 			= array( 'Authorization' => $authorization);

		$options 			= ['body' => $body, 'headers' => $headers, 'sslverify'   => false ];

	
		// Executing GetUserData API Call to Livecomm Site
		$api_response = wp_remote_post( TMLCP_API_BASE_URL, $options );

		if( is_wp_error( $api_response ) )
		{
			echo esc_html( $api_response->get_error_message() );
		}
		else
		{		        	
			$api_response_body = wp_remote_retrieve_body( $api_response );
			$api_response_body = json_decode( $api_response_body );

			if( $api_response_body->code == 426 )
			{
				$bearer_token = $this->tmlcp_refresh_api_token();
				if( !empty( $bearer_token ) )
				{
					return $this->tmlcp_get_userdata_api();
				}
			}
		}

		return $api_response_body;
		
	}

	public function tmlcp_sanitize_array( $array ) {
	    foreach ( $array as $key => &$value ) {
	        if ( is_array( $value ) ) {
	            $value = $this->tmlcp_sanitize_array( $value );
	        }
	        else {
	            $value = sanitize_text_field( $value );
	        }
	    }

	    return $array;
	} 
}

