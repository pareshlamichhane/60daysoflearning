<?php
defined( 'ABSPATH' ) || exit;

spl_autoload_register( function( $class ) {
    $relative_class = substr( $class, strlen( 'LearningPlugin\\' ) );
    $file = plugin_dir_path( __DIR__ ) . 'includes/' . str_replace( '\\', '/', $relative_class ) . '.php';
    if ( file_exists( $file ) ) {
        require_once $file;
    }
} );
