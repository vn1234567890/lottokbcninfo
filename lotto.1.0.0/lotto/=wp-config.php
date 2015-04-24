<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


define('FS_METHOD', 'direct');

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
define('WP_MEMORY_LIMIT', '256M');
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'lottoexp_1');

/** MySQL database username */
define('DB_USER', 'lottoexp_1');

/** MySQL database password */
define('DB_PASSWORD', 'offoff123');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('WP_HOME','http://lotto.kbcn.info/');
define('WP_SITEURL','http://lotto.kbcn.info/');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'z5W&wTV4H3NM~+cLKQ-]7mQW{:L}q1&G||jmc%*B|6qCgeW*z(!=DtF W`+c]EEs');
define('SECURE_AUTH_KEY',  'Y=[A*SsRA[bonsLY:yXGl&`ajeL_)b:E7uWF>-K~n/o$-<}9:^RX>_c%Y#~,=~4%');
define('LOGGED_IN_KEY',    '0w(*1{{uNgI+-Gj6`?wTJtA<|B--!i9Eg~?Q|]C`1$&dzS}~$[?lO~Xo)G4S,x!h');
define('NONCE_KEY',        '33;Ql>RBC9v,umM)dG |Y2J?sqR}nQTG}ohn--|*zgDX5zW:( ^<x&gW3n6ylQn/');
define('AUTH_SALT',        '<sEDLxgB4K$6H7T]W0n>YO-kZ|%?]yJsr:}JDF-M0;`.ciC`ieO!3l@CIcg&[-td');
define('SECURE_AUTH_SALT', 'xD[%u(|9@RGMMjRs@Nz2BbQMZcYE^Iq!/3dn-a.?6QU^!^I!|gx]/+|5U;8B268Z');
define('LOGGED_IN_SALT',   'z&9)C0i>lAM@4E?9({c gIN65Xmt+g}+j@f,w@U-Ja0n3Pb~BT+r/bTfEVL`/YS4');
define('NONCE_SALT',       'B-P}R<?1ZHuWsUsb:QUK+4V<4ch@/]M4mdFBc&Ic]bJ6fmr6b-2h.LGaIp7/Dj0s');

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

define('FS_METHOD', 'direct');


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
