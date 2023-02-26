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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u349494272_taymac' );
/* define( 'DB_NAME', 'u349494272_taymac' ); */

/** Database username */
/* define( 'DB_USER', 'u349494272_root' ); */
define( 'DB_USER', 'root' );

/** Database password */
/* define( 'DB_PASSWORD', 'Is0205737464' ); */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
/* define( 'DB_HOST', 'localhost' ); */
define( 'DB_HOST', 'localhost:3308' ); 

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
define( 'AUTH_KEY',         '+Tq%M04){P@@s#|*}EZvELs=SAKeueq}eB^%g,=usiU(e`[j1FN3]F54~([ox%<&' );
define( 'SECURE_AUTH_KEY',  'H]wn8MMBZm,/{N.eXd`Gaw4S4u>0~;G>K8@~NI*Cu+*HhN;t/<AEUZ !G,xB+$2q' );
define( 'LOGGED_IN_KEY',    'Y5rD^B+58ZCC9SuT(W>a 6!gKH<4A/ ()Gcz|IhM&1~tEYlZ9y:Q^!=7<qS_20aD' );
define( 'NONCE_KEY',        'N8_R>OPUa3^*A)n74-l`_}(Cp&dp{nx.&%+#a{HA@[YMC^k.cD3%w]uoPvj1CL?e' );
define( 'AUTH_SALT',        'N:gdNLTq8eQ!?R%/<_3>?rlV2BrBC+0)<iivfdol<KWME5Ph,-v;-g&gKLVEd0o9' );
define( 'SECURE_AUTH_SALT', '_a!ywU!Y_g2@v++LoHh 3 4vf1,u3-CwT6xT_zSlVNF8QmP:i)TTc|C0*IOS*OCH' );
define( 'LOGGED_IN_SALT',   '!Hex+7{98X;D),9[mCepv#&pkeNh*xn[@#Q<axyvicX_*[MLGFKdbu7w/K%imdH8' );
define( 'NONCE_SALT',       ' &n1(yhN[JbsqGRU>+smvj@k/[[8i!Y4V.hDLYaCMJbtC9<(n!LgkFw5Cw;cFsk&' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
