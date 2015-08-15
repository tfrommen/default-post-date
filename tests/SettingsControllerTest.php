<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Controllers\Settings as Testee;
use WP_Mock\Tools\TestCase;

class SettingsControllerTest extends TestCase {

	public function test_initialize() {

		$model = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );

		$view = Mockery::mock( 'tf\DefaultPostDate\Views\SettingsField' );

		/** @var tf\DefaultPostDate\Models\Settings $model */
		/** @var tf\DefaultPostDate\Views\SettingsField $view */
		$testee = new Testee( $model, $view );

		WP_Mock::expectActionAdded( 'admin_init', array( $model, 'register' ) );

		WP_Mock::expectActionAdded( 'admin_init', array( $view, 'add' ) );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
