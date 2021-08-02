<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'gulfworl_wp550' );

/** MySQL database username */
define( 'DB_USER', 'gulfworl_wp550' );

/** MySQL database password */
define( 'DB_PASSWORD', 'j.pS!98su0' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'snlnu0espfbketxl5rqbbrtatsotpvclhwkkkqxnzjq596lby0ujgbdazw4ogwjt' );
define( 'SECURE_AUTH_KEY',  'w2xsoqzuscepkyghjefflh64zqowskqxxwmvsnkduhkwgq3qyy6gofn5lho3zs6t' );
define( 'LOGGED_IN_KEY',    '0mxjel5khtlfkb3peqnd53j00fwxxbbvseldvudlao9wly9vhyruaz7rwrjomqza' );
define( 'NONCE_KEY',        'hop3xq2hkenmujb0i7zrjanonrlhv6fqmgxybbw0yluvlo0hfgtxzac68khrdxmp' );
define( 'AUTH_SALT',        'uh4dl9laip2l3hfxncbgy55dw0juph1y2xihik0kgzkif7wspwmamdjjwq95bu9a' );
define( 'SECURE_AUTH_SALT', 'w9jo6oozbqecncb6fwbly2qbsls43f1raqrg77ljmj7bo70dusks9euase9pydxk' );
define( 'LOGGED_IN_SALT',   'xeaklqdymjnnwspbxixftwyharee8ywjuu9lqhauoxtzujns4y363quqlzqek1ca' );
define( 'NONCE_SALT',       'qmwajbsaj8hv8sxd2rzchj9kkohmodwo2li4ytdg8v4vaylslgepy45tjcdk0wpt' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpun_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define ('WP_MEMORY_LIMIT','2048M');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
