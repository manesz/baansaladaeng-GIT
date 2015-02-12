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
define('DB_NAME', 'id3ac0rn3r_demobaansaladaeng');

/** MySQL database username */
define('DB_USER', 'id3ac0rn3r_ddemo');

/** MySQL database password */
define('DB_PASSWORD', 'p@ssw0rd');

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
define('AUTH_KEY',         '-3Wca#X!QG;lM4IMN)9b|2u|Kk!iIJj+zHP>Z28ctZ;5oQ`Lac.-uDSh/A;A]-ec');
define('SECURE_AUTH_KEY',  '+,Ta[vuxZuUczrn19sh9nWGgk87$+N(Fe{#%I7Wf$zA)qztd`G3 isaLnA+L^|LP');
define('LOGGED_IN_KEY',    '@[1,3`{5S): }1?N-@|TmAOb{`^D!}S.9aP:(8_ji$f:aRWg#[]/Z.g$md ^~-F]');
define('NONCE_KEY',        'ptd]s{qg]KI@$TF%:}g[. GWD}O9c8$UFq{,HO)pN5o/@z+J2I};)&a}]R^Vq2x:');
define('AUTH_SALT',        'B~EM7ay6 A`LLSIPb(MT%}/|99HK6=-F(9{h3A.zX7>OE7Uy;[Ua,pgIYuC#~y2|');
define('SECURE_AUTH_SALT', '}x{BZ:(hL7o>cV#|{>xYfN#>+4%,lG+(MCy|UdRW^d_P-)>IfI)b-qaGKnyKS62I');
define('LOGGED_IN_SALT',   '7+7Oqeo-YPC*oz?r|<q!Ytd?+~XS3iLYv4cO~:,vKV.!{sqK)H-qXP%8t34z9q9q');
define('NONCE_SALT',       'M6w%g8+M}28fPwBm+0k.08zF;TcCfRD}:U)8RbqP}xaLKlDe%}2w!BO{IZIJG}[B');

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
