<?php
// If uninstall not called from WP, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

$posts = get_posts([
    'post_type' => 'learning_snippet',
    'numberposts' => -1,
    'post_status' => 'any',
]);

foreach ($posts as $post) {
    wp_delete_post($post->ID, true);
}

delete_option('learning_logs');
delete_option('learning_plugin_api_key');
delete_option('learning_style');

// Remove custom transients
delete_transient('learning_plugin_admin_notices');