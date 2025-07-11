<?php 
namespace LearningPlugin\Core;

class SiteHealth {
    public static function init() {
        add_filter('site_status_tests', [self::class, 'register_check']);
    }

    public static function register_check($tests) {
        $tests['direct']['learning_logs'] = [
            'label' => 'Learning Logs Activity',
            'test'  => [self::class, 'run_check'],
        ];
        return $tests;
    }

    public static function run_check() {
        $recent_logs = get_posts([
            'post_type' => 'learning_snippet',
            'date_query' => [
                ['after' => '7 days ago']
            ],
            'posts_per_page' => 1,
            'fields' => 'ids',
        ]);

        if (!empty($recent_logs)) {
            return [
                'label'       => 'Recent learning logs found',
                'status'      => 'good',
                'badge'       => [ 'label' => '60 Days Plugin', 'color' => 'blue' ],
                'description' => 'You’ve logged a learning snippet in the past 7 days.',
                'actions'     => '',
                'test'        => 'learning_logs',
            ];
        }

        return [
            'label'       => 'No learning logs recently',
            'status'      => 'critical',
            'badge'       => [ 'label' => '60 Days Plugin', 'color' => 'red' ],
            'description' => 'You haven’t logged a learning snippet in the past 7 days. Time to add one!',
            'actions'     => '',
            'test'        => 'learning_logs',
        ];
    }
}
