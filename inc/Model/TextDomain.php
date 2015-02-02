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
	 * Constructor. Set up properties.
	 *
	 * @see tf\DefaultPostDate\Plugin::init()
	 *
	 * @param string $file Main plugin file
	 */
	public function __construct( $file ) {

		$this->path = plugin_basename( $file );
		$this->path = dirname( $this->path ) . '/languages';
	}

	/**
	 * Load text domain.
	 *
	 * @see tf\DefaultPostDate\Controller\Admin::init()
	 *
	 * @return void
	 */
	public function load() {

		load_plugin_textdomain( 'default-post-date', FALSE, $this->path );
	}

}
