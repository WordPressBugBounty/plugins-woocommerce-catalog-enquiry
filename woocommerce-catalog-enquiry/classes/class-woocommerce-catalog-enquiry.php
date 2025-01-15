<?php
class Woocommerce_Catalog_Enquiry {

	public $plugin_url;

	public $plugin_path;

	public $version;

	public $token;
	
	public $text_domain;
	
	public $library;

	public $shortcode;

	public $admin;

	public $frontend;

	public $template;

	public $ajax;

	private $file;
	
	public $settings;
		
	public $options;
	
	public $options_exclusion_settings ;
	
	public $options_button_appearence_settings;
	public $options_general_settings ;
	public $options_form_settings ;

	public function __construct($file) {

		$this->file = $file;
		$this->plugin_url = trailingslashit(plugins_url('', $plugin = $file));
		$this->plugin_path = trailingslashit(dirname($file));
		$this->token = WOOCOMMERCE_CATALOG_ENQUIRY_PLUGIN_TOKEN;
		$this->text_domain = WOOCOMMERCE_CATALOG_ENQUIRY_TEXT_DOMAIN;
		$this->version = WOOCOMMERCE_CATALOG_ENQUIRY_PLUGIN_VERSION;
		// default general setting
		$this->options_general_settings = get_option('mvx_catalog_general_tab_settings');	
		// from_setting
		$this->options_form_settings = get_option('mvx_catalog_enquiry_form_tab_settings');
		// exclusion setting
		$this->options_exclusion_settings = get_option('mvx_catalog_exclusion_tab_settings');
		// button appearence
		$this->options_button_appearence_settings = get_option('mvx_catalog_button_appearance_tab_settings');
		add_action('init', array(&$this, 'init'), 0);
		// Catalog Email setup
		add_filter('woocommerce_email_classes', array(&$this, 'woocommerce_catalog_enquiry_email_setup' ));
		add_action('admin_notices', array($this, 'admin_service_page_notice'));
	}

	public function admin_service_page_notice() {
        global $Woocommerce_Catalog_Enquiry;
        ?>
        <div class="mvx_admin_new_banner" id="mvx_service_banner">
            <div class="mvx-banner-content">
					<h1 class="mvx-banner-title">
						<img src="<?php echo esc_url( $Woocommerce_Catalog_Enquiry->plugin_url . 'assets/images/img-1.png' ); ?>">
						Something Extraordinary is Brewing at CatalogX
						<img src="<?php echo esc_url( $Woocommerce_Catalog_Enquiry->plugin_url . 'assets/images/rocket.png' ); ?>">
					</h1>
					<p class="mvx-banner-description">
						Hold onto your seats! We're about to unveil a game-changing CatalogX that'll revolutionize your experience!
						<img src="<?php echo esc_url( $Woocommerce_Catalog_Enquiry->plugin_url . 'assets/images/img-2.png' ); ?>">
					</p>                
            </div>
			<div class="button-section">
				<a target="__blank" href="https://catalogx.com/latest-release/">Sneak Peek</a> 
			</div>
        </div>
        <style>
        .mvx_admin_new_banner{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:1rem;
            padding:1rem;
            border:.063rem solid #d4d1d9;
            margin:3rem auto 1.5rem 0;
            border-radius:.25rem;
            width:95%;
            background:url('<?php echo $Woocommerce_Catalog_Enquiry->plugin_url . 'assets/images/banner-back-color.jpg'; ?>') center/100% 100% no-repeat;
            position:relative
        } 
		.mvx-banner-content h1,
		.mvx-banner-content p{
			color:white;
		}
		.mvx_admin_new_banner a{
			background: white;
			padding: 7px 15px 9px 15px;
			font-size: 16px;
			line-height: 16px;
			color: black;
			border-radius: 10px;
			text-decoration:none;
		}
        
        </style>
        <?php
    }
	
	/**
	 * initilize plugin on WP init
	 */
	function init() {
		
		// Init Text Domain
		$this->load_plugin_textdomain();

		// Init ajax
		if(defined('DOING_AJAX')) {
			$this->load_class('ajax');
			$this->ajax = new  Woocommerce_Catalog_Enquiry_Ajax();
		}

		if (!is_admin() || defined('DOING_AJAX')) {
			$this->load_class('template');
			$this->template = new Woocommerce_Catalog_Enquiry_Template();
		}

		if (is_admin()) {
			$this->load_class('admin');
			$this->admin = new Woocommerce_Catalog_Enquiry_Admin();
		}

		if (!is_admin() || defined('DOING_AJAX')) {
			$this->load_class('frontend');
			$this->frontend = new Woocommerce_Catalog_Enquiry_Frontend();
		}

		if (current_user_can('manage_options')) {
			add_action( 'rest_api_init', array( $this, 'catalog_rest_routes_react_module' ) );
		}
	}

	function catalog_rest_routes_react_module() {
		// list of vendors on vendor tab section
        register_rest_route( 'mvx_catalog/v1', '/fetch_admin_tabs', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $this, 'mvx_catalog_fetch_admin_tabs' ),
            'permission_callback' => array( $this, 'catalog_permission' )
        ] );

        register_rest_route( 'mvx_catalog/v1', '/save_enquiry', [
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => array( $this, 'mvx_catalog_save_enquiry' ),
            'permission_callback' => array( $this, 'catalog_permission' )
        ] );
	}

	public function mvx_catalog_fetch_admin_tabs() {
		$mvx_catalog_tabs_data = mvx_catalog_admin_tabs() ? mvx_catalog_admin_tabs() : [];
        return rest_ensure_response( $mvx_catalog_tabs_data );
	}

	public function mvx_catalog_save_enquiry($request) {
        $all_details = [];
        $modulename = $request->get_param('modulename');
        $modulename = str_replace("-", "_", $modulename);
        $get_managements_data = $request->get_param( 'model' );
        $optionname = 'mvx_catalog_'.$modulename.'_tab_settings';
        update_option($optionname, $get_managements_data);
        $all_details['error'] = __('Settings Saved', 'woocommerce-catalog-enquiry');
        return $all_details;
        die;
	}
	
	public function catalog_permission() {
		return current_user_can('manage_options');
	}

	/**
   * Load Localisation files.
   *
   * Note: the first-loaded translation file overrides any following ones if the same translation is present
   *
   * @access public
   * @return void
   */
  	public function load_plugin_textdomain() {
		$locale = is_admin() && function_exists('get_user_locale') ? get_user_locale() : get_locale();
		$locale = apply_filters('woocommerce_catalog_enquiry_plugin_locale', $locale, 'woocommerce-catalog-enquiry');
		load_textdomain('woocommerce-catalog-enquiry', WP_LANG_DIR . '/woocommerce-catalog-enquiry/woocommerce-catalog-enquiry-' . $locale . '.mo');
		load_plugin_textdomain('woocommerce-catalog-enquiry', false, plugin_basename(dirname(dirname(__FILE__))) . '/languages');
  	}

	public function load_class($class_name = '') {
		if ('' != $class_name && '' != $this->token) {
			require_once ('class-' . esc_attr($this->token) . '-' . esc_attr($class_name) . '.php');
		} // End If Statement
	}// End load_class()

	/**
	 * Add WC Catalog Email
	 *
	 * @param emails     default email classes
	 * @return modified email classes
	 */ 
	function woocommerce_catalog_enquiry_email_setup( $emails ) {
		require_once( 'emails/class-woocommerce-catalog-enquiry-email.php' );
		$emails['Woocommerce_Catalog_Enquiry_Email'] = new Woocommerce_Catalog_Enquiry_Email();
		
		return $emails;
	}
	
	/************************* Cache Helpers ****************************/

	/**
	 * Sets a constant preventing some caching plugins from caching a page. Used on dynamic pages
	 *
	 * @access public
	 * @return void
	 */
	function nocache() {
		if (!defined('DONOTCACHEPAGE'))
			define("DONOTCACHEPAGE", "true");
		// WP Super Cache constant
	}
}
