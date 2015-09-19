<?php # -*- coding: utf-8 -*-

use tfrommen\DefaultPostDate\Controllers\Update as Testee;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the UpdateController class.
 */
class UpdateControllerTest extends TestCase {

	/**
	 * @covers       tfrommen\DefaultPostDate\Controllers\Update::update
	 * @dataProvider provide_update_data
	 *
	 * @param bool   $expected
	 * @param string $version
	 * @param string $old_version
	 * @param bool   $is_current_version
	 * @param string $default_post_date
	 *
	 * @return void
	 */
	public function test_update(
		$expected,
		$version,
		$old_version,
		$is_current_version,
		$default_post_date
	) {

		$testee = new Testee( $version );

		WP_Mock::wpFunction(
			'get_option',
			array(
				'times'  => 1,
				'args'   => array(
					Mockery::type( 'string' ),
				),
				'return' => $old_version,
			)
		);

		if ( ! $is_current_version ) {
			if ( version_compare( $old_version, '1.4.1' ) ) {
				WP_Mock::wpFunction(
					'get_option',
					array(
						'times'  => 1,
						'args'   => array(
							Mockery::type( 'string' ),
						),
						'return' => $default_post_date,
					)
				);

				if ( $default_post_date ) {
					WP_Mock::wpFunction(
						'update_option',
						array(
							'times' => 1,
							'args'  => array(
								Mockery::type( 'string' ),
								$default_post_date,
							),
						)
					);

					WP_Mock::wpFunction(
						'delete_option',
						array(
							'times' => 1,
							'args'  => array(
								Mockery::type( 'string' ),
							),
						)
					);
				}
			}

			WP_Mock::wpFunction(
				'update_option',
				array(
					'times' => 1,
					'args'  => array(
						Mockery::type( 'string' ),
						$version,
					),
				)
			);
		}

		$this->assertSame( $expected, $testee->update() );

		$this->assertConditionsMet();
	}

	/**
	 * Provider for the test_update() method.
	 *
	 * @return array
	 */
	public function provide_update_data() {

		$version = '9.9.9';

		$default_post_date = '1984-05-02';

		return array(
			'no_version'                       => array(
				'expected'           => TRUE,
				'version'            => $version,
				'old_version'        => '',
				'is_current_version' => FALSE,
				'default_post_date'  => '',
			),
			'old_version_no_default_post_date' => array(
				'expected'           => TRUE,
				'version'            => $version,
				'old_version'        => '0',
				'is_current_version' => FALSE,
				'default_post_date'  => '',
			),
			'old_version'                      => array(
				'expected'           => TRUE,
				'version'            => $version,
				'old_version'        => '0',
				'is_current_version' => FALSE,
				'default_post_date'  => $default_post_date,
			),
			'current_version'                  => array(
				'expected'           => FALSE,
				'version'            => $version,
				'old_version'        => $version,
				'is_current_version' => TRUE,
				'default_post_date'  => $default_post_date,
			),
		);
	}

}
