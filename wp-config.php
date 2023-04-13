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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'kFOW)mE*ZWk!-%P7^SpA5#9$2iv|wwm/?#Ql*!`^^D;tT_]0%P5i5RHh()d(]9Lb' );
define( 'SECURE_AUTH_KEY',  'Cj@nQnP] u=a6I49EIMXm<,+,,]G ]JxE4 -5@-td**S)hh,-PPzb F6RS`wxzQj' );
define( 'LOGGED_IN_KEY',    'Jl,$lxG)4/0GJ0~Ys-gqM)z>9m$p`;QndZ90Hg~x2+N~KY:3h*Hui$Y LaS?@^-l' );
define( 'NONCE_KEY',        '02Po02^+ZHZ,Sr*H1f)F/CcJ-gvVxQSnuT!b9+=foN5;s~kmKlB^B5T[ }^V^ElQ' );
define( 'AUTH_SALT',        'Td(7e[/|+v/9.3L,7.o(`jCg,(`5s$W*_f4tknBvrQU*%4)RF8x.rT#M@9)y*y)S' );
define( 'SECURE_AUTH_SALT', 'z>MS83wDsOU-$O)QQ)NhT9PQ)~*q}}hf7(9rX+KTKFK@WRNuP;WH<zUvRR;;F[O.' );
define( 'LOGGED_IN_SALT',   '>^GG>/oY[<}Pb}*]N-n_/:}ekZZ?$W$=J#v@LK+-]zBfV<f3.XiaMY) &{J;{)z0' );
define( 'NONCE_SALT',       'L<Wm|j3zlZ3V32f6*)h)[*%oc~)B(O<i[,<xRS+8d/@8<fOISoCs4eXnv@B!K,N}' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
