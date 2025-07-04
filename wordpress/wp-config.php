<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', '60daysoflearning' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '9845hello' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '0H6>Nc1^.@r^@a[<Z#SP#&d9)I15~dx|{P^*f!4W^GoayS3pWWn}h9RW/q*Tu:8`' );
define( 'SECURE_AUTH_KEY',  'Hf(OgErJ3/Xq@;8?8`8~x79og%tW.BEeAq?+N?+sX,vS+(/mbR@<OJ_cC#bFgd4_' );
define( 'LOGGED_IN_KEY',    'tNkFX@:@6(P7jo1gUe:h-{eH&L83j&$lMo<!}FP^k?wf$)Am}zOTW6|RVjk9BLxO' );
define( 'NONCE_KEY',        ':ToDuR9~I`|fV6rCQ~f+P#6%<ne{e+4R;;8wra;L]aApRIF!g?9@>#QIFw+i0H~x' );
define( 'AUTH_SALT',        '3lW#ES9A:])o4uLwQCFsba|L~U3u0i|LL>BXb5!@=: M/CB|%0*vV&mC,GUx=,=p' );
define( 'SECURE_AUTH_SALT', 'Vmgl%G]Oko329C8T.vfP+akRQnH~a Y!#^~}f?8y}(PHc7gPaloN(QwbBlx8/jae' );
define( 'LOGGED_IN_SALT',   'vtyrajtJ9U,:m,p`}8R|O#d$F?R9((2C=,:-7!BL}sgGKP;6_1W@8cr8(q*[,Ok3' );
define( 'NONCE_SALT',       '4|OT]msU!0|e8:3=t!qVi*jn)0#6JhkJV:}43%I+d=GXh:axVU~/{(F-:w]R-J+}' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

