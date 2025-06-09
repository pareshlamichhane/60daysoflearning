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
 
add_action( 'admin_notices', 'learning_pluigin_success' );
function learning_pluigin_success() {
	$class = 'notice notice-success';
	$message = __( 'Succesfully created the learning plugin', 'sample-text-domain' );

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}
