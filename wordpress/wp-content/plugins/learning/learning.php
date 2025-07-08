<?php /*
 * Plugin Name: 60 Days of Learning Plugin
 * Plugin URI:        https://chiyabytes.wordpress.com/plugins/learning/
 * Description:       Made for 60 Days of Learning Practise
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Paresh Lamichhane
 * Author URI:        https://pareshlamichhane.com.np/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://chiyabytes.wordpress.com/plugins/learning/
 */
 
defined( 'ABSPATH' ) || exit;

define( 'LEARNING_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'LEARNING_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LEARNING_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );


// Admin Notice
add_action( 'admin_notices', function () {
    echo '<div class="notice notice-info"><p>60 Days of Learning Plugin is active.</p></div>';
});

// Include autoloader
require_once LEARNING_PLUGIN_PATH . 'includes/autoload.php';
// require_once LEARNING_PLUGIN_PATH . 'includes/Logger.php';

// Init plugin
use LearningPlugin\Logger;
add_action( 'plugins_loaded', function () {
    LearningPlugin\Logger::init();
});