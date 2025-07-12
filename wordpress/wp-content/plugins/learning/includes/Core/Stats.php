<?php
namespace LearningPlugin\Core;

class Stats {
    public static function get_log_counts_by_topic() {
        $cache_key = 'learning_log_topic_counts';
        $counts = wp_cache_get($cache_key, 'learning_plugin');

        if ($counts !== false) {
            return $counts;
        }

        $terms = get_terms([
            'taxonomy' => 'learning_topic',
            'hide_empty' => false,
        ]);

        $counts = [];

        foreach ($terms as $term) {
            $posts = get_posts([
                'post_type' => 'learning_snippet',
                'tax_query' => [[
                    'taxonomy' => 'learning_topic',
                    'field' => 'term_id',
                    'terms' => $term->term_id
                ]],
                'fields' => 'ids',
                'posts_per_page' => -1,
            ]);
            $counts[$term->name] = count($posts);
        }

        wp_cache_set($cache_key, $counts, 'learning_plugin', 12 * HOUR_IN_SECONDS);
        return $counts;
    }

    public static function invalidate_cache() {
        wp_cache_delete('learning_log_topic_counts', 'learning_plugin');
    }
}
