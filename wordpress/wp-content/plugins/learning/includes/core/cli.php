<?php

defined( 'ABSPATH' ) || exit;

class Learning_CLI {
    public static function init() {
        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            WP_CLI::add_command( 'learning logs', function() {
                $logs = get_option('learning_logs', []);
                if (empty($logs)) {
                    WP_CLI::success("No learning logs found.");
                    return;
                }
                foreach ($logs as $log) {
                    WP_CLI::log("Day {$log['day']}: {$log['summary']}");
                }
            });
        }
    }
}
