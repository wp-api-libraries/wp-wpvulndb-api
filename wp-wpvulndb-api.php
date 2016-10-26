<?php
/**
 * WP-WPVULNDB-API (https://www.zillow.com/howto/api/APIOverview.htm)
 *
 * @package WP-WPVULNDB-API
 */

/*
* Plugin Name: WP Vulnerabilities DB API
* Plugin URI: https://github.com/wp-api-libraries/wp-wpvulndb-api
* Description: Perform API requests to WP Vulnerabilities DB in WordPress.
* Author: imFORZA
* Version: 1.0.0
* Author URI: https://www.imforza.com
* GitHub Plugin URI: https://github.com/wp-api-libraries/wp-wpvulndb-api
* GitHub Branch: master
*/

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Check if class exists. */
if ( ! class_exists( 'WpVulndbAPI' ) ) {

	/**
	 * WpVulndbAPI API Class.
	 */
	class WpVulndbAPI {

		/**
		 * BaseAPI Endpoint
		 *
		 * @var string
		 * @access protected
		 */
		protected $base_uri = 'https://wpvulndb.com/api/v2/';


		/**
		 * __construct function.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
		}

		/**
		 * Fetch the request from the API.
		 *
		 * @access private
		 * @param mixed $request Request URL.
		 * @return $body Body.
		 */
		private function fetch( $request ) {

			$response = wp_remote_get( $request );
			$code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'text-domain' ), $code ) );
			}

			$body = wp_remote_retrieve_body( $response );

			return json_decode( $body );

		}


		/**
		 * Get WordPress Vulnerabilities
		 *
		 * @access public
		 * @param mixed $wp_version WordPress Version.
		 * @return Request.
		 */
		function get_wordpress_vuln( $wp_version ) {

			$request = $this->base_uri . 'wordpresses/' . str_replace( array( '.' ), '' , $wp_version );

			return $this->fetch( $request );

		}

		/**
		 * Get Plugin Vulnerabilities
		 *
		 * @access public
		 * @param mixed $plugin_slug Plugin Slug.
		 * @return Request.
		 */
		function get_plugin_vuln( $plugin_slug ) {

			$request = $this->base_uri . 'plugins/' . $plugin_slug;

			return $this->fetch( $request );

		}

		/**
		 * Get Theme Vulnerabilities
		 *
		 * @access public
		 * @param mixed $theme_slug Theme Slug.
		 * @return Request.
		 */
		function get_theme_vuln( $theme_slug ) {

			$request = $this->base_uri . 'themes/' . $theme_slug;

			return $this->fetch( $request );

		}
	}
}
