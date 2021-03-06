<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sejoli.co.id
 * @since             1.0.0
 * @package           Sejowoo_Tutorlms
 *
 * @wordpress-plugin
 * Plugin Name:       Sejowoo Tutor LMS
 * Plugin URI:        https://sejoli.co.id
 * Description:       Integrates Tutor LMS, an courses plugin with Sejoli WooCommerce, a premium WordPress membership plugin.
 * Version:           1.0.0
 * Author:            Sejoli Team
 * Author URI:        https://sejoli.co.id
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sejowoo-tutorlms
 * Domain Path:       /languages
 */

 global $sejowootutor;

 $sejowootutor = array(
     'course'   => null
 );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SEJOWOO_TUTORLMS_VERSION', '1.0.0' );
define( 'SEJOWOO_TUTORLMS_DIR',	plugin_dir_path(__FILE__));
define( 'SEJOWOO_TUTORLMS_URL',	plugin_dir_url(__FILE__));
define( 'TLMS_COURSE_CPT', 'courses');
define( 'TLMS_COURSE_ENROLLED_CPT', 'tutor_enrolled');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sejowoo-tutorlms-activator.php
 */
function activate_sejowoo_tutorlms() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sejowoo-tutorlms-activator.php';
	Sejowoo_Tutorlms_Activator::activate();

}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sejowoo-tutorlms-deactivator.php
 */
function deactivate_sejowoo_tutorlms() {
	
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sejowoo-tutorlms-deactivator.php';
	Sejowoo_Tutorlms_Deactivator::deactivate();

}

register_activation_hook( __FILE__, 'activate_sejowoo_tutorlms' );
register_deactivation_hook( __FILE__, 'deactivate_sejowoo_tutorlms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sejowoo-tutorlms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sejowoo_tutorlms() {

	$plugin = new Sejowoo_Tutorlms();
	$plugin->run();

}

require_once(SEJOWOO_TUTORLMS_DIR . 'third-parties/yahnis-elsts/plugin-update-checker/plugin-update-checker.php');

$update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/orangerdev/sejowoo-tutorlms',
	__FILE__,
	'sejowoo-tutorlms'
);

$update_checker->setBranch('master');

run_sejowoo_tutorlms();
