<?php
namespace LearningPlugin\Core;

class Notice {
    public static function success($msg) {
        self::add_notice($msg, 'success');
    }

    public static function error($msg) {
        self::add_notice($msg, 'error');
    }

    public static function warning($msg) {
        self::add_notice($msg, 'warning');
    }

    protected static function add_notice($msg, $type) {
        $notices = get_transient('learning_plugin_admin_notices') ?: [];
        $notices[] = ['message' => $msg, 'type' => $type];
        set_transient('learning_plugin_admin_notices', $notices, 60);
    }

    public static function render() {
        $notices = get_transient('learning_plugin_admin_notices');
        if (!$notices) return;

        foreach ($notices as $notice) {
            $class = match ($notice['type']) {
                'success' => 'notice-success',
                'error' => 'notice-error',
                'warning' => 'notice-warning',
                default => 'notice-info'
            };

            echo '<div class="notice ' . esc_attr($class) . ' is-dismissible">';
            echo '<p>' . esc_html($notice['message']) . '</p>';
            echo '</div>';
        }

        delete_transient('learning_plugin_admin_notices');
    }
}
