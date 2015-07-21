<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\Models;

/**
 * Class TextDomain
 *
 * @package tf\DefaultPostDate\Models
 */
class TextDomain {

	/**
	 * @var string
	 */
	private $domain = 'default-post-date';

	/**
	 * @var string
	 */
	private $path;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->path = plugin_basename( $file );
		$this->path = dirname( $this->path ) . '/languages';
	}

	/**
	 * Load the text domain.
	 *
	 * @return bool
	 */
	public function load() {

		return load_plugin_textdomain( $this->domain, FALSE, $this->path );
	}

}
