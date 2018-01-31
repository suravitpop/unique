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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'unique');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Spiral29');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'j%9Uo[Dx?b[NpCuRY`y FPmZ1Mb+|Zo_^J9}&XqC2 >hJW,ZQ+RBrMjD56KBvUU*');
define('SECURE_AUTH_KEY',  'i+eRI2S0tpeG`Jw#RYrjU!*QeSwgTq:PwFg*f4Ta&R$-K~*+00)^)Pa5*G~NE*!]');
define('LOGGED_IN_KEY',    'IDCth(Gu?~@+#H$i9);#_Yi+t+inwI/66.f11DQK`?zERB>Hn>&Qq^9v.IV!dDnK');
define('NONCE_KEY',        ';,lg+;KRj5Vw8Rbu93;U%]I0^)@gf)-M3qG/,=-KIz+*(tH^$emG2R@Iggw,L KD');
define('AUTH_SALT',        'Fm.@GJQojz9ydVVlC3rSF6m8.{c*yqAEK$-q.RfY-[r<`F{#N_.#~n7Nr+.>$,Q.');
define('SECURE_AUTH_SALT', 'a?5_v6f%oMCS .p3?e?p1auI;{l,K<66u-C%hu_O#N9$A<JhP*.4#3u;{O/?5U:6');
define('LOGGED_IN_SALT',   'u2VRXj~m@1D%T$xaH$}!)t:4#;zI,8#36HJOWp%z~=FaJ;[mHRU+k_V+v6<Yd5V7');
define('NONCE_SALT',       '&kId3fEskn,aSS;j:Ua-4m9DmA5MkZ7{0?T?2C`JhV-D.~Pu$;xN/E07-R@+|.LS');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
