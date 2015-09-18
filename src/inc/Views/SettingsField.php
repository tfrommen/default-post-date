<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\Views;

use tfrommen\DefaultPostDate\Models\Settings;

/**
 * Settings field view.
 *
 * @package tfrommen\DefaultPostDate\Views
 */
class SettingsField {

	/**
	 * @var string
	 */
	private $id = 'default-post-date';

	/**
	 * @var Settings
	 */
	private $settings;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Settings $settings Settings model.
	 */
	public function __construct( Settings $settings ) {

		$this->settings = $settings;
	}

	/**
	 * Add the settings field to the general options.
	 *
	 * @wp-hook admin_init
	 *
	 * @return void
	 */
	public function add() {

		$title = esc_html_x( 'Default Post Date', 'Settings field title', 'default-post-date' );
		$title = sprintf(
			'<label for="%s">%s</label>',
			$this->id,
			$title
		);

		add_settings_field(
			$this->settings->get_option_name(),
			$title,
			array( $this, 'render' ),
			'general'
		);
	}

	/**
	 * Render the HTML.
	 *
	 * @return void
	 */
	public function render() {

		$description = esc_html_x(
			'Please enter the default post date according to the %s date format.',
			'Settings field description, %s = date format',
			'default-post-date'
		);

		$date_format = 'YYYY-MM-DD';
		?>
		<input type="text" id="<?php echo $this->id; ?>" name="<?php echo $this->settings->get_option_name(); ?>"
			value="<?php echo esc_attr( $this->settings->get() ); ?>" maxlength="10"
			placeholder="<?php echo $date_format; ?>">
		<p class="description">
			<?php printf( $description, "<code>$date_format</code>" ); ?>
		</p>
		<?php
	}

}
