<?php
namespace LearningPlugin;


defined('ABSPATH') || exit;
use LearningPlugin\Core\Ajax;
use LearningPlugin\Core\CLI;
use LearningPlugin\Core\DashboardWidget;
use LearningPlugin\Core\RestEndPoints;
use LearningPlugin\Core\Shortcodes;
use LearningPlugin\Core\SnippetsCPT;
use LearningPlugin\Core\Taxonomies;
use LearningPlugin\Core\SiteHealth;

class Logger {
    public static function init() {

        // Initialize individual modules
        Ajax::init();
        CLI::init();
        DashboardWidget::init();
        RestEndPoints::init();
        Shortcodes::init();
        SnippetsCPT::init();
        Taxonomies::init();
        SiteHealth::init();

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
