<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\Controller;

use tf\DefaultPostDate\Model;
use tf\DefaultPostDate\View;

/**
 * Class Admin
 *
 * @package tf\DefaultPostDate\Controller
 */
class Admin {

	/**
	 * @var Model\TextDomain
	 */
	private $text_domain;

	/**
	 * Constructor. Set up properties.
	 *
	 * @see tf\DefaultPostDate\Plugin::init()
	 *
	 * @param Model\TextDomain $text_domain Text domain model
	 */
	public function __construct( Model\TextDomain $text_domain ) {

		$this->text_domain = $text_domain;
	}

	/**
	 * Wire backend-specific functions up.
	 *
	 * @see tf\DefaultPostDate\Plugin::init()
	 *
	 * @return void
	 */
	public function init() {

		global $pagenow;

		$settings = new Model\Settings();
		add_action( 'admin_init', array( $settings, 'add' ) );

		if ( basename( $pagenow, '.php' ) === 'options-' . $settings->get_page() ) {
			$this->text_domain->load();
		}

		add_action( 'admin_footer-post-new.php', array( new View\Script(), 'render' ) );
	}

}
