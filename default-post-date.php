<?php # -*- coding: utf-8 -*-
/**
 * Plugin Name: Default Post Date
 * Plugin URI:  https://wordpress.org/plugins/default-post-date/
 * Description: Define an individual default post date that is to be used when adding a new post.
 * Author:      Thorsten Frommen
 * Author URI:  http://ipm-frommen.de/wordpress
 * Version:     1.3.1
 * Text Domain: default-post-date
 * Domain Path: /languages
 * License:     GPLv3
 */

namespace tf\DefaultPostDate;

use tf\Autoloader;

if ( ! function_exists( 'add_action' ) ) {
	return;
}

require_once __DIR__ . '/inc/Autoloader/bootstrap.php';

add_action( 'plugins_loaded', __NAMESPACE__ . '\initialize' );

/**
 * Initialize the plugin.
 *
 * @wp-hook plugins_loaded
 *
 * @return void
 */
function initialize() {

	$autoloader = new Autoloader\Autoloader();
	$autoloader->add_rule( new Autoloader\NamespaceRule( __DIR__ . '/inc', __NAMESPACE__ ) );

	$plugin = new Plugin( __FILE__ );
	$plugin->initialize();
}
