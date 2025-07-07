<?php
// File: includes/class-learning-logger.php

defined('ABSPATH') || exit;

class Learning_Logger {
    public static function init() {
        require_once LEARNING_PLUGIN_PATH . 'includes/core/ajax-handlers.php';
        require_once LEARNING_PLUGIN_PATH . 'includes/core/cli.php';
        require_once LEARNING_PLUGIN_PATH . 'includes/core/dashboard-widget.php';
        require_once LEARNING_PLUGIN_PATH . 'includes/core/rest-endpoints.php';
        require_once LEARNING_PLUGIN_PATH . 'includes/core/shortcodes.php';
        require_once LEARNING_PLUGIN_PATH . 'includes/core/snippets-cpt.php';
        require_once LEARNING_PLUGIN_PATH . 'includes/core/taxonomies.php';

        // Initialize individual modules
        Learning_AJAX::init();
        Learning_CLI::init();
        Learning_DashboardWidget::init();
        Learning_RestEndPoints::init();
        Learning_Shortcodes::init();
        Learning_SnippetsCPT::init();
        Learning_Taxonomies::init();

        // Assets
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_admin_assets']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_frontend_assets']);

    }

    public static function enqueue_admin_assets($hook) {
        if (strpos($hook, 'learning-plugin-dashboard') === false && strpos($hook, 'learning-logs') === false) {
            return;
        }

        wp_enqueue_style('learning-plugin-style', LEARNING_PLUGIN_URL . 'assets/admin-style.css', [], '1.0');
        wp_enqueue_script('learning-plugin-script', LEARNING_PLUGIN_URL . 'assets/admin-script.js', ['jquery'], '1.0', true);
        wp_enqueue_script('learning-tips-script', LEARNING_PLUGIN_URL . 'assets/learning-tips.js', [], '1.0', true);

        wp_localize_script('learning-tips-script', 'LearningTips', [
            'tips' => [
                'Write before you code.',
                '10 minutes daily beats 2 hours weekly.',
                'Break tasks into smaller actions.',
                'Celebrate consistency, not perfection.',
                'Use dev tools to inspect before debugging.',
            ],
        ]);
    }

    public static function enqueue_frontend_assets() {
        wp_enqueue_script('learning-frontend-log', LEARNING_PLUGIN_URL . 'assets/frontend-log.js', ['jquery'], '1.0', true);
        wp_localize_script('learning-frontend-log', 'LearningAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('log_entry_nonce')
        ]);
    }
}
