<?php
/**
 * Development Environment
 *
 * @package Jacomedia
 */

declare( strict_types = 1 );

// Directory containing all of the site's files.
$root_dir = dirname( __DIR__ );

// Document Root.
$webroot_dir = $root_dir . '/public';

/**
 * Get env variable.
 *
 * @param string $key Variable key.
 * @return string
 */
function env( string $key ) : string {
	return $_ENV[ $key ] ?: '';
}

/**
 * Load environment variables
 */
$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load( $root_dir . '/.env' );

/**
 * Set up our global environment constant and load its config first
 * Default: production
 */
define( 'WP_ENV', env( 'WP_ENV' ) ?: 'production' );

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if ( file_exists( $env_config ) ) {
	require_once $env_config;
}

/**
 * URLs
 */
define( 'WP_HOME', env( 'WP_HOME' ) );
define( 'WP_SITEURL', env( 'WP_SITEURL' ) );

/**
 * Custom Content Directory
 */
define( 'CONTENT_DIR', '/content' );
define( 'WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR );
define( 'WP_CONTENT_URL', WP_HOME . CONTENT_DIR );

/**
 * DB settings
 */
define( 'DB_NAME', env( 'DB_NAME' ) );
define( 'DB_USER', env( 'DB_USER' ) );
define( 'DB_PASSWORD', env( 'DB_PASSWORD' ) );
define( 'DB_HOST', env( 'DB_HOST' ) ?: 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
$table_prefix = env( 'DB_PREFIX' ) ?: 'wp_'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

/**
 * Authentication Unique Keys and Salts
 */
define( 'AUTH_KEY', env( 'AUTH_KEY' ) );
define( 'SECURE_AUTH_KEY', env( 'SECURE_AUTH_KEY' ) );
define( 'LOGGED_IN_KEY', env( 'LOGGED_IN_KEY' ) );
define( 'NONCE_KEY', env( 'NONCE_KEY' ) );
define( 'AUTH_SALT', env( 'AUTH_SALT' ) );
define( 'SECURE_AUTH_SALT', env( 'SECURE_AUTH_SALT' ) );
define( 'LOGGED_IN_SALT', env( 'LOGGED_IN_SALT' ) );
define( 'NONCE_SALT', env( 'NONCE_SALT' ) );

/**
 * Multisite setup
 */
if ( env( 'IS_MULTISITE' ) ) {
	define( 'WP_ALLOW_MULTISITE', true );
	define( 'MULTISITE', true );
	define( 'SUBDOMAIN_INSTALL', env( 'SUBDOMAIN_INSTALL' ) ?: false );
	define( 'DOMAIN_CURRENT_SITE', env( 'DOMAIN_CURRENT_SITE' ) ?: parse_url( WP_HOME, PHP_URL_HOST ) );
	define( 'PATH_CURRENT_SITE', '/' );
	define( 'SITE_ID_CURRENT_SITE', 1 );
	define( 'BLOG_ID_CURRENT_SITE', 1 );
}

/**
 * Custom Settings
 */
define( 'AUTOMATIC_UPDATER_DISABLED', true );
define( 'DISABLE_WP_CRON', env( 'DISABLE_WP_CRON' ) ?: false );
define( 'DISALLOW_FILE_EDIT', true );

/**
 * To make WP load each script on the administration page individually; protects against CVE-2018-6389 DoS attacks
 */
define( 'CONCATENATE_SCRIPTS', false );

/**
 * Bootstrap WordPress
 */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', $webroot_dir . '/wp/' );
}
