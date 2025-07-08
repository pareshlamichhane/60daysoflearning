<?php
namespace LearningPlugin\Core;

defined( 'ABSPATH' ) || exit;

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

    public static function render_learning_widget() {
        $tips = [
            'Write before you code.',
            'Debug using echo and die when stuck.',
            'Keep your functions short and focused.',
            'Think in inputs/outputs.',
            'Build first, optimize later.'
        ];

        $tip = $tips[ array_rand( $tips ) ];

        echo "<p><strong>Today's Tip:</strong></p><blockquote style='margin:10px 0;font-style:italic;'>{$tip}</blockquote>";

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
