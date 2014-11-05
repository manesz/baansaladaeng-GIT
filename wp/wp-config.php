<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'baansaladaeng');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '>~|n7BT=)(|FYC<7RNj_acm)Tjy>y6KcDn.x+j[r|-}<.Lg+II&yt!@20nGSAn=Q');
define('SECURE_AUTH_KEY',  'P, Jy-w{<Z&Crg<@/NPwoy!DlC@n-t MzdSmgAkYj3h;pR_Qnfp[f?<]QvGb/MPJ');
define('LOGGED_IN_KEY',    'L=D-^N/*Z1l|lj/h^0_gxDt#@uJJ(YZ-J$oz-}_.#:<@@ywKU,%4zw{Ec9go4uZ#');
define('NONCE_KEY',        '&Yv|I|QStnWJjj-(=G|nhpnWPt7HEe*qjtn&7q+!G!)t]Or+[0i|(|CS43=9&/U]');
define('AUTH_SALT',        'e[$18tZ|^0_W-wbW+-,e(OJRFac#f+h6sgw+HGf<xcnqM#U(sN3b=,WS+{v-ETDD');
define('SECURE_AUTH_SALT', 'nSOc0r,[ h}:t| q[[;V@NA=O`}*B-jwOOsyOUlmcs]s[G1!BV]374~Mbfdgv6_v');
define('LOGGED_IN_SALT',   '[2YU7gzKF$`{[_13<*g9SR`k1&2qN*K;(QE`ulg7b-j 8A(Q?;P~AbIq0pI<K1Rx');
define('NONCE_SALT',       'oI*~Pa3f|)|HHv]%K,Km5:N%=$wg7weF*JWuA}c+kP_<C]_GK2(!LqG_8V}wJN8}');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
