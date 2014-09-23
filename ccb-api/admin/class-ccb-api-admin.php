<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Ccb_Api
 * @subpackage Ccb_Api/admin
 * @author     Laura Haverkamp <laura@haverkamp.us>
 */
class Ccb_Api_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
    
    /**
     * Constant for defining the name of the section.
     *
     * @since 1.0.0
     */
    const PAGE_SECTION = 'ccb_settings_section';
    
    /**
     * Constant used for array keys in the $args array.
     *
     * @since 1.0.0
     * @const LABEL_FOR
     */
    const LABEL_FOR = 'label_for';

    /**
     * Constant used for array keys in the $args array.
     *
     * @since 1.0.0
     * @const TYPE
     */
    const TYPE = 'type';

    /**
     * Constant used for array keys in the $args array.
     *
     * @since 1.0.0
     * @const SIZE
     */
    const SIZE = 'size';

    /**
     * Constant used for array keys in the $args array.
     *
     * @since 1.0.0
     * @const DESCRIPTION
     */
    const DESCRIPTION = 'description';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {
		$this->name = $name;
		$this->version = $version;

	}

    /**
     * Register the options page for the dashboard.
     *
     * @since 1.0.0
     */
    public function add_plugins_page() {
        add_plugins_page(
            'CCB',
            'CCB Plugin',
            'administrator',
            Ccb_Api::OPTIONS,
            array($this, 'ccb_plugin_display')
        );
    }
    
    /**
     * Callback for add_plugins_page
     *
     * @since 1.0.0
     */
    public function ccb_plugin_display() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/ccb-api-admin-display.php';
    }
    
    /**
     * Initialize the options page for the dashboard.
     *
     * @since 1.0.0
     */
    public function ccb_initialize_plugin_options() {
        add_settings_section(
            self::PAGE_SECTION,
            'CCB Options',
            array($this, 'ccb_general_options_callback'),
            Ccb_Api::OPTIONS
        );
        
        // see http://codex.wordpress.org/Function_Reference/add_settings_field for
        // information on the key's used in the args array
        add_settings_field(
            Ccb_Api::URL, 
            'URL', 
            array($this, 'add_input_field'),
            Ccb_Api::OPTIONS,
            self::PAGE_SECTION,
            array(
                self::LABEL_FOR => Ccb_Api::URL,
                self::TYPE => 'url',
                self::SIZE => 40,
                self::DESCRIPTION => "The value of 'Your API URL' as found in Settings -> API in your CCB installation." 
            )
        );
        add_settings_field(
            Ccb_Api::USERNAME,
            'Username',
            array($this, 'add_input_field'),
            Ccb_Api::OPTIONS,
            self::PAGE_SECTION,
            array(
                self::LABEL_FOR => Ccb_Api::USERNAME,
                self::DESCRIPTION => 'The username for your assigned API user.'
            )
        );
        add_settings_field(
            Ccb_Api::PASSWORD,
            'Password',
            array($this, 'add_input_field'),
            Ccb_Api::OPTIONS,
            self::PAGE_SECTION,
            array(
                self::LABEL_FOR => Ccb_Api::PASSWORD,
                self::TYPE => 'password',
                self::DESCRIPTION => 'The password for your assigned API user.'
            )
        );
    
        // register settings as a group; this requires that we use the syntax 
        // group[value] when setting the name attribute on the input elements
        register_setting(
            Ccb_Api::OPTIONS,
            Ccb_Api::OPTIONS,
            array($this, 'sanitize')
        );
    }

    /**
     * Callback for add_settings_section
     *
     * @since 1.0.0
     */
    public function ccb_general_options_callback() {
        // TODO -- nothing exciting to display here
    }
    
    /**
     * Callback for add_settings_field
     *
     * @since 1.0.0
     * @param array $args
     */
    public function add_input_field( $args ) {
        $options = get_option( Ccb_Api::OPTIONS );
        
        // TODO should be some type of validation on # of arguments
        $option = isset( $args[self::LABEL_FOR] ) ? $args[self::LABEL_FOR] : '';
        $type = isset( $args[self::TYPE] ) ? $args[self::TYPE] : 'text';
        $size = isset( $args[self::SIZE] ) ? $args[self::SIZE] : '20';
        $description = $args[self::DESCRIPTION];
        
        printf(
            '<input type="%s" id="%s" name="%s[%s]" value="%s" size="%s" />',
            $type,
            $option,
            Ccb_Api::OPTIONS,
            $option,
            isset( $options[$option] ) ? esc_attr( $options[$option] ) : '',
            $size
        );
        printf('<p class="description">%s</p>', $description);
    }
    
    /**
     * Callback that is used to sanitize the input before it's saved to the database.
     *
     * @since 1.0.0
     * @param array $input
     */
    public function sanitize( $input ) {
        $output = array();
        
        foreach( $input as $key => $value ) {
            if( isset( $input[$key] ) ) {
                if( Ccb_Api::URL == $key ) {
                    $output[$key] = esc_url_raw( strip_tags( stripslashes( $value ) ) );
                } else {
                    $output[$key] = sanitize_text_field( $value );
                }
            }
        }
        
        return apply_filters( 'sanitize', $output );
    }
}
