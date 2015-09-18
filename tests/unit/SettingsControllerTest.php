<?php # -*- coding: utf-8 -*-

use tfrommen\DefaultPostDate\Controllers\Settings as Testee;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the SettingsController class.
 */
class SettingsControllerTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\Controllers\Settings::initialize
	 *
	 * @return void
	 */
	public function test_initialize() {

		/** @var tfrommen\DefaultPostDate\Models\Settings $model */
		$model = Mockery::mock( 'tfrommen\DefaultPostDate\Models\Settings' );

		/** @var tfrommen\DefaultPostDate\Views\SettingsField $view */
		$view = Mockery::mock( 'tfrommen\DefaultPostDate\Views\SettingsField' );

		$testee = new Testee( $model, $view );

		WP_Mock::expectActionAdded( 'admin_init', array( $model, 'register' ) );

		WP_Mock::expectActionAdded( 'admin_init', array( $view, 'add' ) );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
