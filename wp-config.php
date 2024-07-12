<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
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
define( 'DB_NAME', 'eshopper' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'hMqj|*z7C$v9@6?5SpYR&7J vAR@eEIF6?XjB}iJ:lqdYs<7*p-kV9{pX.>[cRyY' );
define( 'SECURE_AUTH_KEY',  '4xH-fzZO8&bM%lu@!@En)YJp)x+X`/7/Xv79rl3~D+QEZY>k14-B.1%Q1@A~D`jU' );
define( 'LOGGED_IN_KEY',    '6PZk:Q<2WM5/]2qS-/RaNfw;(8W8l1@Eg D_Cul`dDgR-%[Y%WvH&VGPs#U)TSq]' );
define( 'NONCE_KEY',        'tM=l8^i7gW#at0gRr5.7bTm*za1-9O-U!?JW(kc~W) ,6(Uz(ebjiqj=v}|<TvFC' );
define( 'AUTH_SALT',        ')-Sxt.$ge>plbT0%Z_H]Be%bE~u;x}?D_k78X6R#{UDA;CDTL]}6tOa(7x8v_8o_' );
define( 'SECURE_AUTH_SALT', '[HbCwDDtiz81{V.n}8SY9yJ*E`2j%eZ1:6yKY,{!osShpog3f| }A]<NS|C~E1R4' );
define( 'LOGGED_IN_SALT',   'Ba`(~Wjs$Las#L8{sSlm/VhALF5<e$/*}&tG?,/k+G7LH?dva2:{1Q|IrpSv~`_B' );
define( 'NONCE_SALT',       ':k|8H`M/i/Hq@`Ajv/i|o@h#WASTQPhYD+7_z aXHZ_8/Ea`0W::m:VVXOa+9%Yw' );

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
define('JWT_AUTH_SECRET_KEY', 'your-secret-key');
define('JWT_AUTH_CORS_ENABLE', true);


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
