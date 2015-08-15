<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Models\Settings as Testee;
use WP_Mock\Tools\TestCase;

class SettingsModelTest extends TestCase {

	public function test_register() {

		$testee = new Testee();

		WP_Mock::wpFunction(
			'register_setting',
			array(
				'args'  => array(
					'general',
					'_default_post_date',
					array( $testee, 'sanitize' ),
				),
				'times' => 1,
			)
		);

		$testee->register();
	}

	public function test_sanitize_empty_string() {

		$testee = new Testee();

		$this->assertSame( '', $testee->sanitize( '' ) );
	}

	public function test_sanitize_invalid_date() {

		$testee = new Testee();

		$this->assertSame( '', $testee->sanitize( '' ) );
	}

	public function test_sanitize_invalid_day() {

		$testee = new Testee();

		$this->assertSame( '', $testee->sanitize( '1984-05-32' ) );
	}

	public function test_sanitize_invalid_month() {

		$testee = new Testee();

		$this->assertSame( '', $testee->sanitize( '1984-13-02' ) );
	}

	public function test_sanitize() {

		$testee = new Testee();

		$this->assertSame( $value = '1984-05-02', $testee->sanitize( $value ) );
	}

	public function test_get() {

		$testee = new Testee();

		WP_Mock::wpFunction(
			'get_option',
			array(
				'args'  => array(
					'_default_post_date',
					'',
				),
				'times' => 1,
			)
		);

		$testee->get();
	}

	public function test_get_option_name() {

		$testee = new Testee();

		$this->assertSame( '_default_post_date', $testee->get_option_name() );
	}

}
