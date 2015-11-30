<?php # -*- coding: utf-8 -*-
/**
 * Plugin Name: Default Post Date
 * Plugin URI:  https://wordpress.org/plugins/default-post-date/
 * Description: Define an individual default post date that is to be used when adding a new post.
 * Author:      Thorsten Frommen
 * Author URI:  http://tfrommen.de
 * Version:     1.5.0
 * Text Domain: default-post-date
 * Domain Path: /languages
 * License:     GPLv3
 */

namespace tfrommen\DefaultPostDate;

if ( ! function_exists( 'add_action' ) ) {
	return;
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\initialize' );

/**
 * Initializes the plugin.
 *
 * @wp-hook plugins_loaded
 *
 * @return void
 */
function initialize() {

	if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
		require_once __DIR__ . '/vendor/autoload.php';
	}

	$plugin = new Plugin( __FILE__ );
	$plugin->initialize();
}
