<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\Setting;

/**
 * Setting sanitizer.
 *
 * @package tfrommen\DefaultPostDate\Setting
 */
class Sanitizer {

	/**
	 * Sanitizes the setting data.
	 *
	 * @param string $data Setting data.
	 *
	 * @return string
	 */
	public function sanitize( $data ) {

		$time = strtotime( $data );
		if ( false === $time ) {
			return '';
		}

		$data = (string) date( 'Y-m-d', $time );

		return $data;
	}
}
