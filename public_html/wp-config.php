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
define('DB_NAME', 'a7941796_1');

/** MySQL database username */
define('DB_USER', 'a7941796_1');

/** MySQL database password */
define('DB_PASSWORD', 'boston2');

/** MySQL hostname */
define('DB_HOST', 'mysql16.000webhost.com');

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
define('AUTH_KEY',         'D9[TA_A9opsX}Nel+Athv(P=!&8a|(+G:2Bj@7W>u4S`g8#h$-Uaq}(AW,--MtKf');
define('SECURE_AUTH_KEY',  '?yZj*Dpgg+k9[/b -HM3n}aDT%+S|]KC{us8~ah_-gn4+*p4z,=5Eqz^3J3%d|1j');
define('LOGGED_IN_KEY',    '9+<0@IHYRie1,zURF*>edGgh![,!cOW!l${M}S?UFj>fus=3G_!K!uQ+U?vyA)i>');
define('NONCE_KEY',        '2O{c~*Qx]x7k_8*BzSaA@K-^xOqc4Zo+O@-.R>WYQ}D_f^K:e#vuMkQM-t^47.4#');
define('AUTH_SALT',        '(8u_~Mw;b`i@Qm256>F$s0Sxhv}oiAZ?:`e~+`,nL7:%-6sq=w`=|.y18!v l.os');
define('SECURE_AUTH_SALT', '?<@V{;A=fRqvnf[To3&KJvlRIp.3KC#nE|47:wcz<.!Wj1s&rNmu_e<sqy`>iD}-');
define('LOGGED_IN_SALT',   'MXmv}q?oKCUvUOar9R-W]%FuM!Hx8;`rTQ,s5tmW=hTBOSZX$i#aQ*~jyqqh#8t]');
define('NONCE_SALT',       '@bXn$@dBUv#<r3|Y;%ah75|<!!JZll0E_%DZXLX,3tf:*igN]Uf)&waEraZcI?fc');

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
define('WP_ALLOW_REPAIR', true);