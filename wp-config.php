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
define('DB_NAME', 'energyga_egw-web');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         ' hsY_T-Huu1=3DH,FSC]B~dCu6A~h[0cd}J^6;vwIwqF:+|rBADhjv>ZLE+ dW|H');
define('SECURE_AUTH_KEY',  'w3^@i:@,u;~WDSq*Js^>/K{OV<!/}s{3ei|Kq*OH. ^*_{_:={#>D@PUz]8Z0k)L');
define('LOGGED_IN_KEY',    '_7,WX7QoZK&|<D5CG2Be5jnlZR{;i3ja;9pZ}Q-e^}4@r;J5T#%7,qf}xC^rVMZ:');
define('NONCE_KEY',        'o~ue?mqt6$`CbVBa)6N5J0LL!t{h1qCKQO,@<h)shMbN*q?D% R.nBk,;N s6~6O');
define('AUTH_SALT',        'hqGPy.!F)G<0o<cuQ a6O}8lWl<V:^A!i_U#.4Iiknyk5]5as@7o_jayd|7W:bz>');
define('SECURE_AUTH_SALT', '{w?(vPg$|WW~R~l2378LYn+jt+5?<RMkR_rPk{^0dAd^qNL*)v#3AsOL+P&3wNG+');
define('LOGGED_IN_SALT',   '!%%(_>E_zpjzfG[FmjGJK}aZ)l7K+c|s.*xDdptN{Ef1o8kyhi4M!8Vp}On~IG|?');
define('NONCE_SALT',       'd;e|zJ2S.,S^,  >|bno d%93Q=DBn?*zx(OA^Q^S#o8P}@)!HdE2+?G=,Y|q}o@');

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
