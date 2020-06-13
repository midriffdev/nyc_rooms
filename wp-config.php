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
define( 'DB_NAME', 'dbs451995' );
/** MySQL database username */
define( 'DB_USER', 'dbu784734' );
/** MySQL database password */
define( 'DB_PASSWORD', 'Livefor2020@#' );
/** MySQL hostname */
define( 'DB_HOST', 'db5000471707.hosting-data.io' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
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
define( 'AUTH_KEY',         'GLnh!^0Cls8LG,L)CP7.}Jtvm87BBNwMGr%X1mUPR0-[WHwLOqVh?>Iv,gRid |m' );
define( 'SECURE_AUTH_KEY',  'Ib1<`p|^(.m!No!^Uq8PSp5U0^@oI3`zMqVoc%e6v|v]:?2=4XVg8iv~z!R1}[S@' );
define( 'LOGGED_IN_KEY',    'QOLJVz<r4F9iZ.yPy&)h/8[%xZ;kYtI>}U7z&2yh:Ov]YaVX`g)e$j@wRk3LHkK;' );
define( 'NONCE_KEY',        'R1,17=~mLR{WJ6<xQ|6G?+<PD;vdJgdD]m`8MfX*hiY>+]v##7x%2c_D49.*9sqK' );
define( 'AUTH_SALT',        '+,/@#rz}%WTUf)d_*C1<U@oo=cKeUiUbRk.X0(EXMHvg-q2Wy-sTX;#LA/XH|ZOG' );
define( 'SECURE_AUTH_SALT', 'i^)!]-bRyl2Z_5!x Dw]ri>PN]U&vgz#o<{2T;x7m38cG+ yV^HRS`-3 6f7Pwz`' );
define( 'LOGGED_IN_SALT',   'l1I0u[6O@.S2 1Y]1(|t:^^g[cdU^}j_N~aq+Igi=4-nqsTuBD)yOGfKqcS&d=1[' );
define( 'NONCE_SALT',       'RLRQX|Pr{4)InWbuwZqMu~P`l-{/u)Ei=G|V%.Qk9f@N&OMfu~sR`ccV?&o.Ji$L' );
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'nyc_';
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
define( 'WP_MEMORY_LIMIT', '256M' );
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
