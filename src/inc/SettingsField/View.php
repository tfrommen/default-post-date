<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\SettingsField;

use tfrommen\DefaultPostDate\Setting\Option;

/**
 * Settings field view.
 *
 * @package tfrommen\DefaultPostDate\SettingsField
 */
class View {

	/**
	 * @var string
	 */
	private $id = 'default-post-date';

	/**
	 * @var Option
	 */
	private $option;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Option $option Option model.
	 */
	public function __construct( Option $option ) {

		$this->option = $option;
	}

	/**
	 * Adds the settings field to the Writing Settings.
	 *
	 * @wp-hook admin_init
	 *
	 * @return void
	 */
	public function add() {

		$title = esc_html_x( 'Default Post Date', 'Settings field title', 'default-post-date' );
		$title = sprintf(
			'<label for="%2$s">%1$s</label>',
			$title,
			$this->id
		);

		add_settings_field(
			$this->option->get_name(),
			$title,
			array( $this, 'render' ),
			$this->option->get_group()
		);
	}

	/**
	 * Renders the HTML.
	 *
	 * @return void
	 */
	public function render() {

		/* translators: %s = date format */
		$description = esc_html__(
			'Please enter the default post date according to the %s date format.',
			'default-post-date'
		);

		$date_format = 'YYYY-MM-DD';
		?>
		<input type="text" id="<?php echo $this->id; ?>" name="<?php echo $this->option->get_name(); ?>"
			value="<?php echo esc_attr( $this->option->get() ); ?>" maxlength="10"
			placeholder="<?php echo $date_format; ?>">
		<p class="description">
			<?php printf( $description, "<code>$date_format</code>" ); ?>
		</p>
		<?php
	}
}
