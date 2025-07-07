<?php

defined( 'ABSPATH' ) || exit;

class Learning_RestEndPoints {
    public static function init() {
        add_action('rest_api_init', function () {
            register_rest_route('learning/v1', '/snippets', [
                'methods' => 'GET',
                'callback' => function () {
                    $query = new WP_Query([
                        'post_type' => 'learning_snippet',
                        'posts_per_page' => 5,
                        'post_status' => 'publish',
                    ]);
                    
                    $snippets = [];
                    while ($query->have_posts()) {
                        $query->the_post();
                        $snippets[] = [
                            'title' => get_the_title(),
                            'excerpt' => get_the_excerpt(),
                            'source' => get_post_meta(get_the_ID(), '_learning_source', true),
                        ];
                    }
                    wp_reset_postdata();
                    return $snippets;
                },
                'permission_callback' => '__return_true'
            ]);
        });
    }

}
