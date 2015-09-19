<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\Controllers;

/**
 * Update controller.
 *
 * @package tfrommen\DefaultPostDate\Controllers
 */
class Update {

	/**
	 * @var string
	 */
	private $version;

	/**
	 * @var string
	 */
	private $version_option_name = 'default_post_date_version';

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param string $version Current plugin version.
	 */
	public function __construct( $version ) {

		$this->version = $version;
	}

	/**
	 * Update the plugin.
	 *
	 * @return bool
	 */
	public function update() {

		$old_version = (string) get_option( $this->version_option_name );
		if ( $old_version === $this->version ) {
			return FALSE;
		}

		if ( version_compare( $old_version, '1.4.1' ) ) {
			$this->rename_option();
		}

		update_option( $this->version_option_name, $this->version );

		return TRUE;
	}

	/**
	 * Rename the plugin option.
	 *
	 * @return void
	 */
	private function rename_option() {

		$old_option_name = '_default_post_date';

		$new_option_name = 'default_post_date';

		$value = get_option( $old_option_name );
		if ( ! $value ) {
			return;
		}

		update_option( $new_option_name, $value );

		delete_option( $old_option_name );
	}

}
