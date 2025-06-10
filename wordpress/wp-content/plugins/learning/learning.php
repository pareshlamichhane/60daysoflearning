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
 
add_action( 'admin_notices', 'learning_plugin_success' );
function learning_plugin_success() {
    $class = 'notice notice-info';
    $message = __( '60 Days of Learning Plugin active and running smoothly!', 'sample-text-domain' );
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}

add_action( 'admin_menu', 'learning_plugin_menu' );
function learning_plugin_menu() {
    add_menu_page(
        '60 Days of Learning',
        '60 Days of Learning',
        'manage_options',
        'learning-plugin-dashboard',
        'learning_plugin_dashboard_page',
        'dashicons-lightbulb',
        50
    );
}

function learning_plugin_dashboard_page() {
    echo '<div class="wrap"><h1>Welcome to 60 Days of Learning Plugin Dashboard</h1><p>This page is where we put the things we have learn in the 60 days.</p></div>';
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'learning_plugin_add_settings_link' );
function learning_plugin_add_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=learning-plugin-dashboard">Dashboard</a>';
    array_unshift( $links, $settings_link );
    return $links;
}

add_action( 'admin_enqueue_scripts', 'learning_plugin_admin_styles' );
function learning_plugin_admin_styles( $hook ) {
    if ( $hook != 'toplevel_page_learning-plugin-dashboard' ) {
        return;
    }
    wp_enqueue_style( 'learning-plugin-admin-css', plugin_dir_url( __FILE__ ) . 'admin-style.css' );
}