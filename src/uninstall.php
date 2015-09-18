<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate;

use tfrommen\Autoloader;

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	return;
}

require_once __DIR__ . '/inc/Autoloader/bootstrap.php';

$autoloader = new Autoloader\Autoloader();
$autoloader->add_rule( new Autoloader\NamespaceRule( __DIR__ . '/inc', __NAMESPACE__ ) );

$settings = new Models\Settings();
delete_option( $settings->get_option_name() );
