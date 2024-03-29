<?php

namespace bornfight\wpHelpers\optimization\defaults;

class WPEmoji {
	public function deactivate( array $settings = array() ): void {
		/**
		 * Remove emoji preconnect
		 */
		add_filter( 'emoji_svg_url', '__return_false' );

		// Disable emoji
		add_action( 'init', array( $this, 'disable_emoji' ) );
		add_filter( 'tiny_mce_plugins', array( $this, 'disable_emoji_tinymce' ) );
	}

	/**
	 * Disable the emoji's
	 */
	public function disable_emoji() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}

	/**
	 * Filter function used to remove the tinymce emoji plugin.
	 *
	 * @param array $plugins
	 *
	 * @return   array             Difference betwen the two arrays
	 */
	public function disable_emoji_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}
}