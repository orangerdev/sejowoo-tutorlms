<?php
namespace Sejowoo_Tutorlms;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://sejoli.co.id
 * @since      1.0.0
 *
 * @package    Sejowoo_Tutorlms
 * @subpackage Sejowoo_Tutorlms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sejowoo_Tutorlms
 * @subpackage Sejowoo_Tutorlms/public
 * @author     Sejoli Team <admin@sejoli.co.id>
 */
class Front {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

    /**
     * @param $html
     * @return string
     *
     * Removed course price at single course
     *
     * @since 1.0.0
     */
	public function remove_price($html){
	
	    $should_removed = apply_filters('should_remove_price_if_enrolled', true);

	    if ($should_removed){
        
	        $html = '';

        }
	    
	    return $html;
    
    }

    /**
	 * Enqueue needed CSS files
	 * @uses 	wp_enqueue_scripts, action, 194
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function enqueue_styles() {

		wp_register_style( 'semantic-ui', 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css', [], '2.4.1', 'all' );
		wp_enqueue_style( 'semantic-ui');
		
		if( is_singular( TLMS_COURSE_CPT ) ) :
		
			wp_enqueue_style( $this->plugin_name, SEJOWOO_TUTORLMS_URL . 'public/css/sejowoo-tutorlms-public.css', $this->version, 'all' );
		
		endif;

	}

	/**
	 * Enqueue needed JS files
	 * @uses 	wp_enqueue_scripts, action, 194
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function enqueue_scripts() {

		wp_register_script( 'semantic-ui', 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js', array( 'jquery' ), '2.4.1', true );
		wp_enqueue_script( 'semantic-ui');
		
		if( is_singular( TLMS_COURSE_CPT ) ) :
		
			wp_enqueue_script( $this->plugin_name, SEJOWOO_TUTORLMS_URL . 'public/js/sejowoo-tutorlms-public.js', array( 'jquery' ), $this->version, false );
		
		endif;

	}

}
