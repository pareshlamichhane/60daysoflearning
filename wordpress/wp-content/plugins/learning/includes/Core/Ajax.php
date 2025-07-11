<?php
namespace LearningPlugin\Core;

defined( 'ABSPATH' ) || exit;

class Ajax {
    public static function init() {
        add_action( 'wp_ajax_log_learning_entry', [ self::class, 'handle_log' ] );
    }

    public static function handle_log() {
        if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'log_entry_nonce') ) {
            wp_send_json_error('Invalid nonce');
        }

        $day = sanitize_text_field($_POST['day'] ?? '');
        $summary = sanitize_textarea_field($_POST['summary'] ?? '');

        if (empty($day) || empty($summary)) {
            wp_send_json_error('Day and summary are required.');
        }

        $logs = get_option('learning_logs', []);
        $logs[] = [
            'day' => $day,
            'summary' => $summary,
            'timestamp' => current_time('mysql'),
        ];
        update_option('learning_logs', $logs);

        wp_send_json_success('Log saved successfully!');
    }
}
