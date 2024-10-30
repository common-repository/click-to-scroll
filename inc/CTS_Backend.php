<?php

/**
 * This is in charge for the Click to Scroll settings page
 *
 * @version 1.0.0
 * @since 1.0.0
 */

if( ! class_exists('CTS_Backend') ) {
	class CTS_Backend {
		private $options;

		public function cts_get_options() {
			return $this->options;
		}

		function __construct() {
			$this->options = get_option( 'cts_options' );

			add_action( 'admin_menu', array( $this, 'cts_add_settings_page' ) );
			add_action( 'admin_init', array( $this, 'cts_settings_init' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'cts_enqueue_backend_scripts' ) );
		}

		public function cts_add_settings_page() {
			add_submenu_page(
				'options-general.php',
				__( 'Click to Scroll Options', 'cts' ),
				__( 'Click to Scroll', 'cts' ),
				'manage_options',
				'cts-options',
				array( $this, 'cts_settings_page' )
			);
		}

		public function cts_settings_page() { ?>
			<div class="wrap">
				<form action="options.php" name="cts-options-form" method="post">
					<?php settings_fields( 'cts_options_group' );
					do_settings_sections( 'cts-options' ); ?>
					<p class="submit-buttons">
						<?php submit_button( 'Save Changes', 'primary', 'submit', false ); ?>
					</p>
				</form>
			</div>
		<?php }

		public function cts_button_image_field() {
			$this->show_field('image', 'image_url');
		}

		public function cts_button_width_field() {
			$this->show_field('size', 'button_width', 35);
		}

		public function cts_button_use_image_field() {
			$this->show_field('checkbox', 'use_image', 0);
		}

		public function cts_button_height_field() {
			$this->show_field('size', 'button_height', 35);
		}

		public function cts_arrow_width_field() {
			$this->show_field('size', 'arrow_width', 14);
		}

		public function cts_arrow_height_field() {
			$this->show_field('size', 'arrow_height', 10);
		}

		public function cts_button_bg_color_field() {
			$this->show_field('color', 'button_bg_color', '#333333');
		}

		public function cts_button_arrow_color_field() {
			$this->show_field('color', 'button_arrow_color', '#ffffff');
		}

		public function cts_button_bg_hover_color_field() {
			$this->show_field('color', 'button_bg_hover_color', '#333333');
		}

		public function cts_button_arrow_hover_color_field() {
			$this->show_field('color', 'button_arrow_hover_color', '#ffffff');
		}

		public function cts_button_opacity_field() {
			$this->show_field('opacity', 'button_opacity', 0.7);
		}

		public function cts_button_hover_opacity_field() {
			$this->show_field('opacity', 'button_hover_opacity', 1);
		}

		public function cts_button_border_radius_field() {
			$this->show_field('bdrs', 'button_border_radius', 50);
		}

		public function cts_animation_speed_field() {
			$this->show_field('number', 'animation_speed', 400);
		}

		public function cts_show_on_admin_field() {
			$this->show_field('checkbox', 'show_on_admin', 0);
		}

		public function cts_scroll_to_anchor_field() {
			$this->show_field('checkbox', 'scroll_to_anchor', 0);
		}

		public function cts_offset_field() {
			$this->show_field('offset', 'global_offset', 0);
		}

		public function cts_settings_display_content() {

		}

		public function cts_settings_init() {
			register_setting( 'cts_options_group', 'cts_options' );

			add_settings_section(
				'style',
				__( 'Button Style Settings', 'cts' ),
				array( $this, 'cts_settings_display_content' ),
				'cts-options'
			);

			add_settings_section(
				'scroll_to_anchor',
				__( 'Scrolling to Anchor', 'cts' ),
				array( $this, 'cts_settings_display_content' ),
				'cts-options'
			);

			add_settings_section(
				'advanced',
				__( 'Advanced Settings', 'cts' ),
				array( $this, 'cts_settings_display_content' ),
				'cts-options'
			);

			// todo: maybe show the fields with a loop

			add_settings_field(
				'use-image',
				__( 'I would like to use an image', 'cts' ),
				array( $this, 'cts_button_use_image_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'image-url',
				__( 'Upload the button image', 'cts' ),
				array( $this, 'cts_button_image_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'button-width',
				__( 'Button Width', 'cts' ),
				array( $this, 'cts_button_width_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'button-height',
				__( 'Button Height', 'cts' ),
				array( $this, 'cts_button_height_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'arrow-width',
				__( 'Arrow Width', 'cts' ),
				array( $this, 'cts_arrow_width_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'arrow-height',
				__( 'Arrow Height', 'cts' ),
				array( $this, 'cts_arrow_height_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'button-bg-color',
				__( 'Button Background Color', 'cts' ),
				array( $this, 'cts_button_bg_color_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'button-arrow-color',
				__( 'Arrow Color', 'cts' ),
				array( $this, 'cts_button_arrow_color_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'button-opacity',
				__( 'Button Opacity', 'cts' ),
				array( $this, 'cts_button_opacity_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'button-bg-hover-color',
				__( 'Button Background Hover Color', 'cts' ),
				array( $this, 'cts_button_bg_hover_color_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'button-arrow-hover-color',
				__( 'Arrow Hover Color', 'cts' ),
				array( $this, 'cts_button_arrow_color_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'button-hover-opacity',
				__( 'Button Hover Opacity', 'cts' ),
				array( $this, 'cts_button_hover_opacity_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'button-border-radius',
				__( 'Button Border Radius', 'cts' ),
				array( $this, 'cts_button_border_radius_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'animation-speed',
				__( 'Animation Speed', 'cts' ),
				array( $this, 'cts_animation_speed_field' ),
				'cts-options',
				'style'
			);

			add_settings_field(
				'show-on-admin',
				__( 'Add the Button to the Admin Area', 'cts' ),
				array( $this, 'cts_show_on_admin_field' ),
				'cts-options',
				'advanced'
			);
			add_settings_field(
				'scroll-to-anchor',
				__( 'Enable Scrolling to Anchor Feature', 'cts' ),
				array( $this, 'cts_scroll_to_anchor_field' ),
				'cts-options',
				'scroll_to_anchor'
			);
			add_settings_field(
				'global_offset',
				__( 'Offset', 'cts' ) . '<span class="cts-instructions">' . __('Can be negative. Another way to add offset is to use data-offset attribute on the element you want to scroll to, e.g. &lt;div id="my-anchor" data-offset="80"&gt;&lt;/div&gt;') . '</span>',
				array( $this, 'cts_offset_field' ),
				'cts-options',
				'scroll_to_anchor'
			);
		}

		public function cts_enqueue_backend_scripts() {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker');
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-widget' );
			wp_enqueue_script( 'jquery-ui-mouse' );
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_style( 'jquery-ui-smoothness', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css' );
			wp_enqueue_script( 'cts_admin_scripts', CTS_URL . '/assets/js/back.js', array( 'jquery' ), '1.3.0', true );
			wp_enqueue_style( 'cts_admin_styles', CTS_URL . '/assets/css/back.css', null, '1.3.0' );

			wp_enqueue_media();
		}


		// todo: maybe move to CTS_Fields
		public function show_field( $type, $name, $default_val = null ) {
			if ( ! isset( $type ) || ! isset( $name ) ) {
				return;
			}

			global $cts_backend;
			$options = $cts_backend->cts_get_options();

			// do not check for empty because for some fields the 0 value is valid
			$val = ( isset( $options[ $name ] ) ) ? esc_attr( $options[ $name ] ) : $default_val;

			// assign to 0 empty values of the field types for which the 0 value is valid
			if( ($type === 'offset') && empty($options[ $name ]) ) {
				$val = 0;
			}

			if ( $type === 'image' ) {
				$this->show_image_field( $val, $name );
			}
			if ( $type === 'size' ) {
				$this->show_number_field( $val, $name, 1, 0, null, 'px' );
			}
			if ( $type === 'offset' ) {
				$this->show_number_field( $val, $name, 1, null, null, 'px' );
			}
			if ( $type === 'number' ) {
				$this->show_number_field( $val, $name, 1, 0, null, 'ms' );
			}
			if ( $type === 'color' ) {
				$this->show_color_field( $val, $name );
			}
			if ( $type === 'opacity' ) {
				$this->show_opacity_field( $val, $name );
			}
			if ( $type === 'bdrs' ) {
				$this->show_bdrs_field( $val, $name );
			}
			if ( $type === 'checkbox' ) {
				$this->show_checkbox_field( $val, $name );
			}
		}

		private function show_number_field( $val, $name, $step = 1, $min = null, $max = null, $after = '' ) {
			$min_val = ( isset($min) ) ? $min : null;
			$max_val = ( isset($ax) ) ? $max : null;

			echo "<input type='number' step='$step' $min_val $max_val value='$val' id='cts-$name' name='cts_options[$name]'>$after";
		}

		private function show_image_field( $val, $name ) {
			?>
			<div class="cts-upload-field">
				<input type='url' value='<?php echo $val; ?>' id='cts-<?php echo $name; ?>' class='image_url' name='cts_options[<?php echo $name; ?>]'>
				<input type='button' name='upload-btn' class='upload-btn button-secondary' value='Upload Image'>
			</div>
			<?php
		}

		private function show_color_field( $val, $name ) {
			echo "<input type='text' value='$val' id='cts-$name'  name='cts_options[$name]' class='cts-datepicker'>";
		}

		private function show_opacity_field( $val, $name ) { ?>
			<div class="cts-slider-wrapper">
				<div class="cts-slider-inner">
					<div class="cts-td cts-size-20">
						<div class="cts-label"><?php _e( 'Transparent', 'cts' ); ?></div>
					</div>
					<div class="cts-td cts-size-60">
						<div class="cts-opacity-slider cts-slider"></div>
					</div>
					<div class="cts-td cts-size-20">
						<div class="cts-label"><?php _e( 'Opaque', 'cts' ); ?></div>
					</div>
				</div>
				<input type="hidden" value="<?php echo $val; ?>" class="cts-slider-field" id="cts-<?php echo $name; ?>"
				       name="cts_options[<?php echo $name; ?>]">
			</div>
		<?php }

		private function show_bdrs_field( $val, $name ) { ?>
			<div class="cts-slider-wrapper">
				<div class="cts-slider-inner">
					<div class="cts-td cts-size-20">
						<div class="cts-label"><?php _e( 'Square', 'cts' ); ?></div>
					</div>
					<div class="cts-td cts-size-60">
						<div class="cts-bdrs-slider cts-slider"></div>
					</div>
					<div class="cts-td cts-size-20">
						<div class="cts-label"><?php _e( 'Circle', 'cts' ); ?></div>
					</div>
				</div>
				<input type="hidden" value="<?php echo $val; ?>" class="cts-slider-field" id="cts-<?php echo $name; ?>"
				       name="cts_options[<?php echo $name; ?>]">
			</div>
		<?php }

		private function show_checkbox_field( $val, $name ) { ?>
			<input type="checkbox" value="1" name="cts_options[<?php echo $name; ?>]" <?php checked( $val, 1 ); ?>>
		<?php }
	}
}

global $cts_backend;

$cts_backend = new CTS_Backend();