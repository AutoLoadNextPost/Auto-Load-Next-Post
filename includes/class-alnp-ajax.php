<?php
/**
 * Auto Load Next Post - AJAX Events.
 *
 * @since    1.6.0
 * @author   Sébastien Dumont
 * @category Classes
 * @package  Auto Load Next Post/Classes/AJAX
 * @license  GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ALNP_AJAX' ) ) {

	class ALNP_AJAX {

		/**
		 * Constructor.
		 *
		 * @access public
		 */
		public function __construct() {
			self::add_ajax_events();
		} // END __construct()

		/**
		 * Hook in methods - uses WordPress Ajax handlers (admin-ajax).
		 *
		 * @access public
		 * @static
		 */
		public static function add_ajax_events() {
			$ajax_events = array(
				'find_template_location'        => true,
				'get_container_selectors'       => true,
				'get_title_selectors'           => true,
				'get_post_navigation_selectors' => true,
				'get_comment_selectors'         => true,
				'set_setting'                   => true,
			);

			foreach ( $ajax_events as $ajax_event => $nopriv ) {
				add_action( 'wp_ajax_alnp_' . $ajax_event, array( __CLASS__, $ajax_event ) );

				if ( $nopriv ) {
					add_action( 'wp_ajax_nopriv_alnp_' . $ajax_event, array( __CLASS__, $ajax_event ) );
				}
			}
		} // END add_ajax_events()

		/**
		 * Find template location.
		 *
		 * @access public
		 * @static
		 * @return string|int
		 */
		public static function find_template_location() {
			$post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : 'post';

			if ( empty( $post_type ) ) {
				wp_send_json( -1 );
				wp_die();
			}

			// Scan directories and saves the location.
			alnp_scan_directories( $post_type );

			// Get directory location.
			$directory = alnp_get_template_directory( $post_type );

			// Return if directory was saved.
			if ( ! empty( $directory ) || $directory == null ) {
				wp_send_json( $directory );
			} else {
				wp_send_json( -1 );
			}

			wp_die();
		} // END find_template_location()

		/**
		 * Return container theme selectors.
		 *
		 * @access public
		 * @static
		 * @return json $selectors
		 */
		public static function get_container_selectors() {
			$selectors = array(
				'main.site-main',
				'main#main',
				'main.post-wrap',
				'div#main',
				'div.site-content',
				'div#content',
				'div.content-container'
			);

			wp_send_json( $selectors );
			wp_die();
		} // END get_container_selectors()

		/**
		 * Return title theme selectors.
		 *
		 * @access public
		 * @static
		 * @return json $selectors
		 */
		public static function get_title_selectors() {
			$selectors = array(
				'h1.entry-title',
				'h1.post-title',
				'h1.page-title',
				'h1.title-single',
				'h1'
			);

			wp_send_json( $selectors );
			wp_die();
		} // END get_title_selectors()

		/**
		 * Return post navigation theme selectors.
		 *
		 * @access public
		 * @static
		 * @return json $selectors
		 */
		public static function get_post_navigation_selectors() {
			$selectors = array(
				'nav.post-navigation',
				'nav.navigation-post',
				'nav.navigation',
				'div.navigation',
				'nav#nav-below',
				'#nav-single',
				'div.next-prev',
				'nav.prev-next-nav'
			);

			wp_send_json( $selectors );
			wp_die();
		} // END get_post_navigation_selectors()

		/**
		 * Return comments container theme selectors.
		 *
		 * @access public
		 * @static
		 * @return json $selectors
		 */
		public static function get_comment_selectors() {
			$selectors = array(
				'div#comments',
				'section#comments'
			);

			wp_send_json( $selectors );
			wp_die();
		} // END get_comment_selectors()

		/**
		 * Sets an Auto Load Next Post Setting.
		 *
		 * @access public
		 * @static
		 * @return bool
		 */
		public static function set_setting() {
			$setting = isset( $_POST['setting'] ) ? $_POST['setting'] : '';
			$value   = isset( $_POST['value'] ) ? $_POST['value'] : '';

			if ( empty( $setting ) && empty( $value ) ) {
				wp_send_json( -1 );
				wp_die();
			}

			update_option( 'auto_load_next_post_' . $setting, $value );

			wp_send_json( 1 );
			wp_die();
		} // END set_setting()

	} // END class

} // END if class exists

return new ALNP_AJAX();
