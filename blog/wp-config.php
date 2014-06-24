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
define('DB_NAME', 'trew_wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'm/t O3zc-Qxo#} ,Y_HO>a+5D@6@{u;*f v^.B?N5{A!+(~V<RSF(XwJiO=b=w}m');
define('SECURE_AUTH_KEY',  'PKuj&q7gB#2z~bZp.}A67utWTj%3X30U![u=2]S_nSZbn*BsQQ(P-OG(WGC4Eb)u');
define('LOGGED_IN_KEY',    'x{.AG qt<=R&[,ir,X}C2yP]szrjsbin7&d~&__AX;h_zB!>7g#KYC6;F& ^EDSV');
define('NONCE_KEY',        'NWS m3aG?Y|4(=f[ohTp3)4-B_u$=|!Z(Q7>+oz&T<qmEG|MzG-Ke8-Ahf)<?A10');
define('AUTH_SALT',        '2B.^Z)i4x/aMN[Vk%=qpZ;xT@=E{):zBELk2-M1Yy# BY((fkA>MPG]Hx]^pWr%J');
define('SECURE_AUTH_SALT', 'G7*M1-,sBfvowN]12|b<Y|rjLQUVnvV/10VDR3ME8nL9l$Lj>5adjMI=AhU2kV9P');
define('LOGGED_IN_SALT',   '@&6HlO{`Rfrx*q)Ym4SQ!3PkaK[B/1 -/edDaMt6caDj`7RnJ;3S%v})w(>~2eAa');
define('NONCE_SALT',       '1LAwo+=9#[en0q(S/E_!yj{:b|,Ovi]5]hm+3vi;zZ4&(qYSF)5)b;P]t]:L;0wA');

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
