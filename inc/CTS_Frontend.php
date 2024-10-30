<?php
/**
 * This is in charge for the button representation
 *
 * Uses global instance of the CTS_Backend class to get options
 *
 * @version 1.0.0
 * @since 1.0.0
 * @uses CTS_Backend
 */

if( ! class_exists('CTS_Frontend') ) {
	class CTS_Frontend {
		private $options;

		public function __construct() {
			global $cts_backend;
			$this->options = $cts_backend->cts_get_options();


			add_action( 'wp_head', array( $this, 'print_buttons_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'cts_enqueue_scripts' ) );
			add_action('wp_footer', array($this, 'show_button'));
			add_action('wp_footer', array($this, 'js_settings_field'));

			if( ! empty($this->options['show_on_admin']) ) {
				add_action( 'admin_head', array( $this, 'print_buttons_styles' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'cts_enqueue_scripts' ) );
				add_action('admin_footer', array($this, 'show_button'));
			}
		}

		public function print_buttons_styles() {
			$options = $this->options;

			$uses_image = ( isset($this->options['use_image']) && $this->options['use_image'] == 1 && ! empty($this->options['image_url']) ) ? true : false;

			if( ! $uses_image ) {
				// need to check it here as well because the default values may be not saved
				$button_width  = ( ! empty( $options['button_width'] ) ) ? $options['button_width'] : 40;
				$button_height = ( ! empty( $options['button_height'] ) ) ? $options['button_height'] : 40;

				$arrow_width       = ( ! empty( $options['arrow_width'] ) ) ? $options['arrow_width'] : 20;
				$arrow_width_half  = round( $arrow_width / 2 );
				$arrow_height      = ( ! empty( $options['arrow_height'] ) ) ? $options['arrow_height'] : 15;
				$arrow_height_half = round( $arrow_height / 2 );

				$button_bg_color          = ( ! empty( $options['button_bg_color'] ) ) ? $options['button_bg_color'] : '#333333';
				$button_arrow_color       = ( ! empty( $options['button_arrow_color'] ) ) ? $options['button_arrow_color'] : '#ffffff';
				$button_bg_hover_color    = ( ! empty( $options['button_bg_hover_color'] ) ) ? $options['button_bg_hover_color'] : '#6D6D6D';
				$button_arrow_hover_color = ( ! empty( $options['button_arrow_hover_color'] ) ) ? $options['button_arrow_hover_color'] : '#ffffff';

				$button_border_radius = ( isset( $options['button_border_radius'] ) ) ? $options['button_border_radius'] : 50;
			}

			$button_opacity       = ( ! empty( $options['button_opacity'] ) ) ? $options['button_opacity'] : 1;
			$button_hover_opacity = ( ! empty( $options['button_hover_opacity'] ) ) ? $options['button_hover_opacity'] : 1;
			?>
			<style>
				.cts-button-css {
					width: <?php echo $button_width; ?>px;
					height: <?php echo $button_height; ?>px;
					border-radius: <?php echo $button_border_radius; ?>%;
					background-color: <?php echo $button_bg_color; ?>;
				}

				.cts-button.active {
					opacity: <?php echo $button_opacity; ?>;
				}

				.cts-button.active:hover {
					opacity: <?php echo $button_hover_opacity; ?>;
				}

				.cts-button-css .cts-button-icon {
					margin-left: -<?php echo $arrow_width_half; ?>px;
					margin-top: -<?php echo $arrow_height_half; ?>px;
					border-left: <?php echo $arrow_width_half; ?>px solid transparent;
					border-right: <?php echo $arrow_width_half; ?>px solid transparent;
					border-bottom: <?php echo $arrow_height; ?>px solid #ffffff;
					border-bottom-color: <?php echo $button_arrow_color; ?>;
				}

				.cts-button-css:hover {
					background-color: <?php echo $button_bg_hover_color; ?>;
				}

				.cts-button-css:hover .cts-button-icon {
					border-bottom-color: <?php echo $button_arrow_hover_color; ?>;
				}
			</style>
		<?php }

		public function cts_enqueue_scripts() {
			$suffix = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_style( 'cts_styles', CTS_URL . '/assets/css/style.min.css', null, '1.3.0' );
			wp_enqueue_script( 'cts_scripts', CTS_URL . '/assets/js/front'.$suffix.'.js', array( 'jquery' ), '1.2.0', true );
		}

		public function show_button() {
			if( isset($this->options['use_image']) && $this->options['use_image'] == 1 && ! empty($this->options['image_url']) ) {
				echo "<a href='#' class='cts-button cts-button-image'><img src='{$this->options['image_url']}' alt='Scroll to Top Button'/></a>";
			} else {
				echo "<a href='#' class='cts-button cts-button-css'><span class='cts-button-icon'></span></a>";
			}
		}

		// todo: add JS settings to backend
		public function js_settings_field() {
			// add to this array only options which will be needed in JS functions
			$options = ['scroll_to_anchor', 'global_offset', 'animation_speed'];

			$js_settings = $this->options_to_js( $options );

			if( empty($js_settings) ) {
				return;
			}

			$encoded_settings = json_encode($js_settings);

			echo "<input type='hidden' value='$encoded_settings' class='js_settings'>";
		}

		private function options_to_js( $options ) {
			// keeps settings in a hidden field to get with JS with DOM manipulation
			// it allows to avoid making http requests with AJAX
			$js_settings = [];

			foreach( $options as $option_name ) {
				if( isset($this->options[$option_name]) ) {
					$js_settings[$option_name] = $this->options[$option_name];
				}
			}

			return $js_settings;
		}
	}
}

$cts_frontend = new CTS_Frontend();