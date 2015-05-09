<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\Model;

/**
 * Class TextDomain
 *
 * @package tf\DefaultPostDate\Model
 */
class TextDomain {

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
	 * @return void
	 */
	public function load() {

		load_plugin_textdomain( 'default-post-date', FALSE, $this->path );
	}

}
