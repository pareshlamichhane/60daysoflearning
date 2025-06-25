<?php
defined( 'ABSPATH' ) || exit;

class Learning_Logger {
    public static function init() {
        add_action( 'admin_init', [ self::class, 'register_settings' ] );
        add_action( 'admin_menu', [ self::class, 'add_admin_menu' ] );
        add_filter( 'plugin_action_links_' . LEARNING_PLUGIN_BASENAME, [ self::class, 'add_settings_link' ] );
        add_action( 'admin_enqueue_scripts', [ self::class, 'enqueue_admin_assets' ] );
        add_shortcode( 'show_learning_logs', [ self::class, 'display_logs' ] );
        add_shortcode( 'show_snippets', [ self::class, 'display_snippets_shortcode' ] );
        add_action( 'init', [ self::class, 'register_learning_snippets_cpt' ] );
        add_action( 'add_meta_boxes', [ self::class, 'add_snippet_meta_box' ] );
        add_action( 'save_post_learning_snippet', [ self::class, 'save_snippet_meta_box' ] );


    }

    public static function add_admin_menu() {
        add_menu_page(
            '60 Days of Learning',
            '60 Days of Learning',
            'manage_options',
            'learning-plugin-dashboard',
            [ self::class, 'dashboard_page' ],
            'dashicons-lightbulb',
            50
        );
        add_submenu_page(
            'learning-plugin-dashboard',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'learning-plugin-dashboard',
            [self::class,'dashboard_page']
        );
        add_submenu_page(
            'learning-plugin-dashboard',
            'Learning Logs',
            'Learning Logs',
            'manage_options',
            'learning-logs',
            [ self::class, 'logs_page' ]
        );
        add_submenu_page(
            'learning-plugin-dashboard',
            'Settings',
            'Settings',
            'manage_options',
            'learning-settings',
            [ self::class, 'settings_page' ]
        );
    }

        public static function register_settings() {
        register_setting( 'learning_plugin_options', 'learning_style' );

        add_settings_section(
            'learning_plugin_main',
            'Learning Preferences',
            null,
            'learning-plugin-settings'
        );

        add_settings_field(
            'learning_style',
            'Preferred Learning Style',
            [ self::class, 'learning_style_field' ],
            'learning-plugin-settings',
            'learning_plugin_main'
        );
    }

    public static function learning_style_field() {
        $value = get_option( 'learning_style', 'Both' );
        ?>
        <select name="learning_style">
            <option value="Reading" <?php selected( $value, 'Reading' ); ?>>Reading</option>
            <option value="Coding" <?php selected( $value, 'Coding' ); ?>>Coding</option>
            <option value="Both" <?php selected( $value, 'Both' ); ?>>Both</option>
        </select>
        <?php
    }

    public static function dashboard_page() {
        echo '<div class="wrap"><h1>Welcome to 60 Days of Learning Plugin Dashboard</h1><p>Track your learning progress here.</p></div>';
    }

    public static function add_settings_link( $links ) {
        $settings_link = '<a href="admin.php?page=learning-plugin-dashboard">Dashboard</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    public static function settings_page() {
        if ( isset( $_POST['api_key'] ) ) {
            update_option( 'learning_plugin_api_key', sanitize_text_field( $_POST['api_key'] ) );
            echo '<div class="notice notice-success"><p>Settings saved!</p></div>';
        }

        $api_key = get_option( 'learning_plugin_api_key', '' );
        ?>
        <div class="wrap">
            <h2>Learning Plugin Settings</h2>
            <form method="post">
                <label for="api_key">Sample API Key (for future use):</label><br>
                <input type="text" name="api_key" value="<?php echo esc_attr( $api_key ); ?>" style="width:300px;"><br><br>
                <input type="submit" class="button button-primary" value="Save Settings">
            </form>
        </div>
        <div class="wrap">
            <form method="post" action="options.php">
                <?php
                settings_fields( 'learning_plugin_options' );
                do_settings_sections( 'learning-plugin-settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public static function enqueue_admin_assets( $hook ) {
        if ( strpos($hook, 'learning-plugin-dashboard') === false && strpos($hook, 'learning-logs') === false ) {
            return;
        }

        wp_enqueue_style(
            'learning-plugin-style',
            LEARNING_PLUGIN_URL . 'assets/admin-style.css',
            [],
            '1.0'
        );

        wp_enqueue_script(
            'learning-plugin-script',
            LEARNING_PLUGIN_URL . 'assets/admin-script.js',
            ['jquery'],
            '1.0',
            true
        );

        wp_enqueue_script(
            'learning-tips-script',
            LEARNING_PLUGIN_URL . 'assets/learning-tips.js',
            [],
            '1.0',
            true
        );
        
         wp_localize_script( 'learning-tips-script', 'LearningTips', [
        'tips' => [
            'Write before you code.',
            '10 minutes daily beats 2 hours weekly.',
            'Break tasks into smaller actions.',
            'Celebrate consistency, not perfection.',
            'Use dev tools to inspect before debugging.',
            ],
         ]);
    }

    public static function logs_page() {
        if ( isset( $_POST['day'] ) && isset( $_POST['summary'] ) ) {
            $logs = get_option( 'learning_logs', [] );
            $logs[] = [
                'day' => sanitize_text_field( $_POST['day'] ),
                'summary' => sanitize_textarea_field( $_POST['summary'] ),
                'timestamp' => current_time( 'mysql' ),
            ];
            update_option( 'learning_logs', $logs );
            echo '<div class="notice notice-success"><p>Log added!</p></div>';
        }
        ?>
        <div class="wrap">
            <h2>Add Learning Log</h2>
            <form method="post">
                <label for="day">Day:</label><br>
                <input type="text" name="day" required><br><br>
                <label for="summary">What you learned:</label><br>
                <textarea name="summary" rows="5" cols="50" required></textarea><br><br>
                <input type="submit" value="Add Log" class="button button-primary">
            </form>
        </div>
        <?php
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
        public static function add_snippet_meta_box() {
            add_meta_box(
                'learning_snippet_source',
                'Learning Source',
                [ self::class, 'render_snippet_meta_box' ],
                'learning_snippet',
                'normal',
                'default'
            );
        }
        public static function render_snippet_meta_box( $post ) {
            $value = get_post_meta( $post->ID, '_learning_source', true );
            wp_nonce_field( 'learning_source_nonce_action', 'learning_source_nonce' );
            echo '<label for="learning_source">Source (URL, book, etc.):</label>';
            echo '<input type="text" id="learning_source" name="learning_source" value="' . esc_attr( $value ) . '" style="width:100%;"/>';
        }
        public static function save_snippet_meta_box( $post_id ) {
            if (
                ! isset( $_POST['learning_source_nonce'] ) ||
                ! wp_verify_nonce( $_POST['learning_source_nonce'], 'learning_source_nonce_action' )
            ) {
                return;
            }

            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

            if ( ! current_user_can( 'edit_post', $post_id ) ) return;

            if ( isset( $_POST['learning_source'] ) ) {
                update_post_meta(
                    $post_id,
                    '_learning_source',
                    sanitize_text_field( $_POST['learning_source'] )
                );
            }
        }


}