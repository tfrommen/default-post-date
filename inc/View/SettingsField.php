<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\View;

use tf\DefaultPostDate\Model;

/**
 * Class SettingsField
 *
 * @package tf\DefaultPostDate\View
 */
class SettingsField {

	/**
	 * @var string
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * Constructor. Set up properties.
	 *
	 * @see tf\DefaultPostDate\Model\Settings::add()
	 *
	 * @param string $id   Settings field ID
	 * @param string $name Settings field name
	 */
	public function __construct( $id, $name ) {

		$this->id = $id;
		$this->name = $name;
	}

	/**
	 * Render HTML.
	 *
	 * @see tf\DefaultPostDate\Model\Settings::add()
	 *
	 * @return void
	 */
	public function render() {

		$description = _x(
			'Please enter the default post date according to the %s date format.',
			'Settings field description, %s = date format',
			'default-post-date'
		);
		$description = sprintf(
			$description,
			'<code>YYYY-MM-DD</code>'
		);

		$value = Model\Option::get();

		printf(
			'<input type="text" id="%s" name="%s" value="%s"><p class="description">%s</p>',
			$this->id,
			$this->name,
			$value,
			$description
		);
	}

}
