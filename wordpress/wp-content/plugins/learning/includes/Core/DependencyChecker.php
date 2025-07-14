<?php
namespace LearningPlugin\Core;

class DependencyChecker {
    public static function init(): void {
        add_action('admin_init', [self::class, 'check_dependencies']);
        add_action('admin_notices', [self::class, 'show_admin_notice']);
    }

    protected static bool $dependencies_met = true;

    public static function check_dependencies(): void {
        // Example: Requires ACF plugin
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
        if (!is_plugin_active('advanced-custom-fields/acf.php')) {
            self::$dependencies_met = false;
        }

        // Example: Requires PHP 8.1+
        if (version_compare(PHP_VERSION, '8.1', '<')) {
            self::$dependencies_met = false;
        }

        // Optional: auto-disable your plugin if deps are critical
        // deactivate_plugins(plugin_basename(__FILE__));
    }

    public static function show_admin_notice(): void {
        if (self::$dependencies_met) return;

        echo '<div class="notice notice-error"><p>';
        echo '⚠️ <strong>60 Days of Learning Plugin</strong> requires:';
        echo '<ul style="margin:0;"><li>PHP ≥ 8.1</li><li>Advanced Custom Fields plugin</li></ul>';
        echo 'Please install/activate these before continuing.';
        echo '</p></div>';
    }

    public static function all_clear(): bool {
        return self::$dependencies_met;
    }
}