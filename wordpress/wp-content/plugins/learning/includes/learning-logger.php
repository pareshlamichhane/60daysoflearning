<?php
defined( 'ABSPATH' ) || exit;

class Learning_Logger {
    public static function init() {
        add_action( 'admin_init', [ self::class, 'register_settings' ] );
        add_action( 'admin_menu', [ self::class, 'add_admin_menu' ] );
        add_filter( 'plugin_action_links_' . LEARNING_PLUGIN_BASENAME, [ self::class, 'add_settings_link' ] );
        add_action( 'admin_enqueue_scripts', [ self::class, 'enqueue_admin_assets' ] );
        add_shortcode( 'show_learning_logs', [ self::class, 'display_logs' ] );
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
}