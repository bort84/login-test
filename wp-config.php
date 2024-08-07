<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'login_test' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',         '{WvK[MnL1jomrU@}IEujLf=mHNo=2M_7?R%4+#Mma)L,72^+7+X!>3 q/^0[oYQ<');
define('SECURE_AUTH_KEY',  'C#%Ma|<^2PC|j@G-oXOrj-Y,Wlot*:8i@yufbi~]e)/;fCM*-Xv,Dr-/8QHvPXL~');
define('LOGGED_IN_KEY',    'XFa.Vt2hJR)XFPh9Cp{/~p_cu5Nj4_VlRl&f0`om0L-4_RazFSVG8k4ira7.xx.~');
define('NONCE_KEY',        '{]F>tKo<#?m&5]e5B-%weP;S}%|i=Na+^r<Q8(EoIj(H#lqTfE]49CfHIGq8?y$o');
define('AUTH_SALT',        'z2m!:79XMsg],&[[jrut*^?l)1zll7v(=w;kA_+J-(%?/rT%*uB K=kj~<XLnT|g');
define('SECURE_AUTH_SALT', '8%U.@h..(z9?WYuN&nH.Mgzn|#4*X.-VV6|,whKbR+k<r~h_ukQ,&z.Svmf|rAB6');
define('LOGGED_IN_SALT',   'bYF+981h[<$1}|.pe8>5GJY7]LT](|(6_F[kxzR+6h+@@1~1JXTw*_h.fhaUHsyL');
define('NONCE_SALT',       '@|wkOy.rEy$QS06+]f}n4!=9Vy]XuVJ`o&_]{d<|:G%zpS+aTjX9)UQY6^{6g]h.');

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', true);

/* Add any custom values between this line and the "stop editing" line. */

define('COOKIE_DOMAIN', $_SERVER['HTTP_HOST']);
define('COOKIEPATH', '/');
if ( ! defined( 'COOKIE_SECURE' ) ) {
    define( 'COOKIE_SECURE', isset( $_SERVER['HTTPS'] ) );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';