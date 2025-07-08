<?php
namespace LearningPlugin\Core;

defined( 'ABSPATH' ) || exit;

class Taxonomies {
    public static function init() {
        add_action( 'init', [ self::class, 'register_learning_taxonomies' ] );
    }
    
    public static function register_learning_taxonomies() {
        register_taxonomy(
            'learning_topic',
            'learning_snippet',
            [
                'label' => 'Learning Topics',
                'public' => true,
                'hierarchical' => false,
                'show_in_rest' => true,
                'rewrite' => [ 'slug' => 'topic' ],
            ]
        );
    }
}
