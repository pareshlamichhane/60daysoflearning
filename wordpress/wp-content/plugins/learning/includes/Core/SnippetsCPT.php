<?php
namespace LearningPlugin\Core;

defined( 'ABSPATH' ) || exit;

class SnippetsCPT {

    public static function init() {
        add_action( 'manage_learning_snippet_posts_custom_column', [ self::class, 'render_snippet_columns' ], 10, 2 );
          add_action( 'save_post_learning_snippet', [ self::class, 'save_snippet_meta_box' ] );
        add_action( 'init', [ self::class, 'register_learning_snippets_cpt' ] );

    }

    public static function render_snippet_columns( $column, $post_id ) {
        if ( $column === 'learning_source' ) {
            $source = get_post_meta( $post_id, '_learning_source', true );
            echo esc_html( $source );
        }

        if ( $column === 'learning_topic' ) {
            $terms = get_the_term_list( $post_id, 'learning_topic', '', ', ' );
            echo $terms ? $terms : '—';
        }
    }

    public static function register_learning_snippets_cpt() {
        $labels = [
            'name' => 'Learning Snippets',
            'singular_name' => 'Learning Snippet',
            'add_new' => 'Add New Snippet',
            'add_new_item' => 'Add New Learning Snippet',
            'edit_item' => 'Edit Snippet',
            'new_item' => 'New Snippet',
            'view_item' => 'View Snippet',
            'search_items' => 'Search Snippets',
            'not_found' => 'No snippets found',
            'not_found_in_trash' => 'No snippets in trash',
            'all_items' => 'All Learning Snippets',
            'menu_name' => 'Snippets',
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-welcome-learn-more',
            'supports' => [ 'title', 'editor' ],
            'show_in_rest' => true,
        ];

        register_post_type( 'learning_snippet', $args );
    }
}
