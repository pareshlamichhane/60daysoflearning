<?php
namespace LearningPlugin\Core;

defined( 'ABSPATH' ) || exit;

class Shortcodes {
    
    public static function init() {
        add_shortcode( 'learning_log_form', [ self::class, 'render_frontend_form' ] );
        add_shortcode( 'show_learning_logs', [ self::class, 'display_logs' ] );
        add_shortcode( 'show_snippets', [ self::class, 'display_snippets_shortcode' ] );
        add_shortcode( 'filter_snippets', [ self::class, 'filtered_snippets_shortcode' ] );
    }

    public static function render_frontend_form() {
        ob_start();
        ?>
        <form id="learning-log-form">
            <input type="text" name="day" placeholder="Day number" required><br><br>
            <textarea name="summary" placeholder="What did you learn?" rows="5" required></textarea><br><br>
            <button type="submit">Submit</button>
            <p id="form-status"></p>
        </form>
        <?php
        return ob_get_clean();
    }   

    public static function display_logs($atts) {
        $atts = shortcode_atts([
            'day' => '',
        ], $atts);

        $logs = get_option('learning_logs', []);
        if (!$logs) return "<p>No logs yet.</p>";

        $output = "<div class='learning-logs'>";
        foreach (array_reverse($logs) as $log) {
            if ($atts['day'] && $log['day'] != $atts['day']) continue;

            $output .= "<div class='log-entry' style='border:1px solid #ddd;padding:15px;margin-bottom:15px;border-radius:8px;'>";
            $output .= "<h3 style='margin-bottom:5px;'>Day {$log['day']}</h3>";
            $output .= "<small><em>{$log['timestamp']}</em></small>";
            $output .= "<p style='margin-top:10px;'>{$log['summary']}</p>";
            $output .= "</div>";
        }
        $output .= "</div>";

        return $output;
    }

    public static function display_snippets_shortcode( $atts ) {
        $atts = shortcode_atts([
            'posts_per_page' => 5,
        ], $atts );

        $query = new WP_Query([
            'post_type' => 'learning_snippet',
            'posts_per_page' => intval( $atts['posts_per_page'] ),
            'post_status' => 'publish',
        ]);

        if ( ! $query->have_posts() ) return '<p>No learning snippets yet.</p>';

        $output = '<div class="learning-snippets">';
        while ( $query->have_posts() ) {
            $query->the_post();
            $output .= '<div style="border:1px solid #ccc;padding:10px;margin-bottom:15px;border-radius:6px;">';
            $output .= '<h3>' . esc_html( get_the_title() ) . '</h3>';
            $output .= '<p>' . wp_kses_post( get_the_excerpt() ) . '</p>';
            $source = get_post_meta( get_the_ID(), '_learning_source', true );
            if ( $source ) {
                $output .= '<p><em>Source:</em> ' . esc_html( $source ) . '</p>';
            }
            $output .= '</div>';

        }
        wp_reset_postdata();

        $output .= '</div>';
        return $output;
    }

    public static function filtered_snippets_shortcode( $atts ) {
        $atts = shortcode_atts([
            'topic' => '',
            'source_keyword' => '',
        ], $atts );

        $meta_query = [];
        if ( $atts['source_keyword'] ) {
            $meta_query[] = [
                'key'     => '_learning_source',
                'value'   => sanitize_text_field( $atts['source_keyword'] ),
                'compare' => 'LIKE',
            ];
        }

        $tax_query = [];
        if ( $atts['topic'] ) {
            $tax_query[] = [
                'taxonomy' => 'learning_topic',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( $atts['topic'] ),
            ];
        }

        $query = new WP_Query([
            'post_type' => 'learning_snippet',
            'posts_per_page' => 10,
            'meta_query' => $meta_query,
            'tax_query'  => $tax_query,
        ]);

        if ( ! $query->have_posts() ) return '<p>No matching snippets found.</p>';

        $output = '<div class="learning-snippets" style="margin: 30px 0;">';

        while ( $query->have_posts() ) {
            $query->the_post();

            $source = get_post_meta( get_the_ID(), '_learning_source', true );
            $topics = get_the_term_list( get_the_ID(), 'learning_topic', '', ', ' );

            $output .= '<div style="border-left: 4px solid #2d9cdb; background: #f9f9f9; padding: 16px 20px; margin-bottom: 16px; border-radius: 4px;">';
            $output .= '<h3 style="margin: 0 0 8px; font-size: 18px;">' . esc_html( get_the_title() ) . '</h3>';

            if ( $source ) {
                $output .= '<p style="margin: 0 0 4px; color: #555;"><strong>Source:</strong> ' . esc_html( $source ) . '</p>';
            }

            if ( $topics ) {
                $output .= '<p style="margin: 0; color: #666;"><strong>Topics:</strong> ' . wp_kses_post( $topics ) . '</p>';
            }

            $output .= '</div>';
        }

        $output .= '</div>';

        return $output;
    }
}
