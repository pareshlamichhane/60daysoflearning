<?php
namespace LearningPlugin\Core;

defined( 'ABSPATH' ) || exit;
use LearningPlugin\Core\Stats;

class DashboardWidget {
    public static function init() {
        add_action( 'wp_dashboard_setup', [ self::class, 'add_learning_dashboard_widget' ] );
    }

    public static function add_learning_dashboard_widget() {
        wp_add_dashboard_widget(
            'learning_dashboard_widget',
            '60 Days of Learning – Tip of the Day',
            [ self::class, 'render_learning_widget' ]
        );
    }
    private static function get_tip_pool(): array {
        return [
            "Keep functions short — if it does more than one thing, split it.",
            "Write comments for why, not what.",
            "Use `wp_nonce_field()` for every POST form to prevent CSRF.",
            "Avoid querying all posts with `-1` unless you cache the result.",
            "Use `wp_localize_script()` to safely pass PHP data to JS.",
            "Learn how the WordPress hook system actually works under the hood.",
            "Don’t mix business logic inside shortcode callbacks.",
            "Flush rewrite rules only on activation, never on every load.",
            "Debug slow plugins with Query Monitor.",
            "Custom post types aren’t just for content — they can be used for structured data too.",
        ];
    }

    public static function render_learning_widget() {
            $counts = Stats::get_log_counts_by_topic();

            echo '<div class="learning-plugin-dashboard">';
            echo '<p><strong>Learning Logs by Topic (cached):</strong></p>';

            if (!empty($counts)) {
                echo '<ul>';
                foreach ($counts as $topic => $count) {
                    echo '<li>' . esc_html($topic) . ': ' . esc_html($count) . ' logs</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No logs found yet. Start logging today!</p>';
            }

            echo '</div>';
        $tip = get_transient('learning_plugin_daily_tip');

        if (!$tip) {
            $tips = self::get_tip_pool();

            if (!empty($tips)) {
                $tip = $tips[array_rand($tips)];
                set_transient('learning_plugin_daily_tip', $tip, DAY_IN_SECONDS);
            } else {
                $tip = 'No tips available.';
            }
        }

        echo '<div class="learning-tip" style="padding: 8px; font-style: italic;">' . esc_html($tip) . '</div>';
    
        $logs = get_option( 'learning_logs', [] );

        if ( empty( $logs ) ) {
            echo '<p>No learning logs yet. Add one from the plugin menu!</p>';
            return;
        }

        $logs = array_reverse( $logs );
        $recent_logs = array_slice( $logs, 0, 3 );
        echo '<h4 style="margin-top: 0; margin-bottom: 6px;">📚 Recent Learning Logs</h4>';
        foreach ($recent_logs as $log) {
            echo '<hr><div style="background: #f8f8f8; border-left: 4px solid #00a0d2; padding: 10px; margin-bottom: 10px; border-radius: 4px;">';
            echo '<p style="margin: 0;"><strong> Day '. esc_html( $log['day']) . '</strong></p>';
            echo '<p style="margin: 6px 0;">' . esc_html( $log['summary']) . '</p>';
            echo '<p style="margin: 0; font-size: 11px; color: #666;"><em>' .esc_html( $log['timestamp'] ).'</em></p>';
            echo '</div><hr>';
        }   
    }
}
