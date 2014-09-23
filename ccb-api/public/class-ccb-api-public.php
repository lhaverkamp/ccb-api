<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Ccb_Api
 * @subpackage Ccb_Api/admin
 * @author     Laura Haverkamp <laura@haverkamp.us>
 */
class Ccb_Api_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {
		$this->name = $name;
		$this->version = $version;
	}
    
    public function current_events( $atts ) {        
        // pull options
        $options = get_option(Ccb_Api::OPTIONS);
        $url = $options[Ccb_Api::URL];
        $username = $options[Ccb_Api::USERNAME];
        $password = $options[Ccb_Api::PASSWORD];
        
        if( empty( $url ) || empty( $username ) || empty( $password ) ) {
            return new WP_Error( 500, 'Please configure your plugin.');
        }
        
        // pull attributes
        $days = isset( $atts['days'] ) ? intval( $atts['days'] ) : 7;
        
        $date = new DateTime();
        $date_start = $date->format('Y-m-d');
        $date_end = date_modify($date, '+' . $days . ' day')->format('Y-m-d');
        
        $uri = $url . "?srv=public_calendar_listing&date_start=$date_start&date_end=$date_end";
        
        // set headers
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password )
            )
        );
        
        $response = wp_remote_get($uri, $args);
        $code = wp_remote_retrieve_response_code( $response );
        $message = wp_remote_retrieve_response_message( $response );
        
        if ( 200 != $code && ! empty( $message ) ) {
           return new WP_Error( $code, $message );
        } else if ( 200 != $code ) {
            return new WP_Error( $code, 'Unknown error occurred' );
        } else {
            $xml = simplexml_load_string( wp_remote_retrieve_body( $response ) );
            
            $html = $this->parse_public_calendar_listing( $xml );
        }
            
        return $html;
    }
    
    /**
     * This method parses the XML returned by the public_calendar_listing API call.
     */
    private function parse_public_calendar_listing( $xml ) {
        $header = null;

        if( $xml->response->items['count'] ) {
            foreach( $xml->response->items->item as $item ) {
                $date = DateTime::createFromFormat(
                    'Y-m-d H:i:s', 
                    $item->date . ' ' . $item->start_time
                );

                if( $header != (string) $item->date ) {
                    if( ! empty( $header ) ) {
                        $html .= '</div><div class="ccb-calendar">';
                    }

                    $html .= '<h3 class="ccb-event-title">' . $date->format('l - F j') . '</h3>';
                    $header = $item->date;
                }

                if( false ) {
                } else {
                    $html .= '<div class="ccb-event">';
                    $html .= $date->format('g:i') . ' ' . $item->event_name;
                    $html .= '<span class="ccb-event-location">';
                    $html .= $item->location;
                    $html .= '</span>';
                    $html .= '</div>';
                }
            }

            $html = '<div class="ccb-calendar">' . $html . '</div>';
        } else {
            $html = '<div class="ccb-calendar">No events found.</div>';
        }
        
        return $html;
    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ccb_Api_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ccb_Api_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/ccb-api-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ccb_Api_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ccb_Api_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/ccb-api-public.js', array( 'jquery' ), $this->version, false );

	}

}
