<?php
/**
 * The main class
 *
 * Gathers everything together
 *
 * @since             1.0.0
 * @package           Click to Scroll
 * @uses CTS_Backend
 * @uses CTS_Frontend
 *
 * @wordpress-plugin
 * Plugin Name:       Click to Scroll
 * Description:       Add a customizable scroll-to-top button to your site and the admin area
 * Version:           1.3.3
 * Author:            Igor Skoldin
 * Author URI:        https://profiles.wordpress.org/skoldin/
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! class_exists('CTS_Click_To_Scroll') ) {
	class CTS_Click_To_Scroll {
		public function __construct() {
			$this->cts_includes();

			register_activation_hook( __FILE__, array($this, 'cts_activate') );
			register_deactivation_hook( __FILE__, array($this, 'cts_deactivate') );

			define('CTS_URL', plugins_url('', __FILE__));
		}

		public function cts_includes() {
			// todo: maybe replace to autoloader
			include_once 'inc/CTS_Backend.php';
			include_once 'inc/CTS_Frontend.php';
		}

		public function cts_activate() {
			$options = get_option('cts_options');

			if( empty( $options ) ) {
				$default_options = [
					'button_width' => 35,
					'button_height' => 35,
					'arrow_width' => 14,
					'arrow_height' => 10,
					'button_bg_color' => '#333333',
					'button_arrow_color' => '#ffffff',
					'button_opacity' => 0.5,
					'button_bg_hover_color' => '#333333',
					'button_hover_opacity' => 0.7,
					'button_border_radius' => 50,
					'animation_speed' => 400,
					'show_on_admin' => 1,
					'scroll_to_anchor' => 1,
					'global_offset' => 0
				];

				update_option('cts_options', $default_options);
			}
		}

		public function cts_deactivate() {
			delete_option('cts_options');
		}
	}
}

$cts = new CTS_Click_To_Scroll();
