<?php
/*
Plugin Name: Colophon
Plugin URI: https://github.com/a8cteam51/colophon
Description: Sets Team 51 footer links to WordPress.com and Pressable.
Version: 1.0.0
Author: WordPress.com Special Projects
Author URI: https://wpspecialprojects.wordpress.com/
License: GPLv3
*/

if ( ! function_exists( 'team51_credits' ) ) :

	/**
	 * A colophon-generating method for WordPress Special Projects Sites.
	 *
	 *     team51_credits( 'separator= | ' );
	 *
	 * @param array $args {
	 *     Optional. An array of arguments.
	 *
	 *     @type string $separator The separator to inject between links.
	 *                             Default ' '
	 *     @type string $wpcom     The link text to use for WordPress.com.
	 *                             Default 'Proudly powered by WordPress.'
	 *     @type string $pressable The link text to use for Pressable.
	 *                             Default 'Hosted by Pressable.'
	 * }
	 */
	function team51_credits( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'separator' => ' ',
				/* translators: %s: WordPress. */
				'wpcom'     => sprintf( __( 'Proudly powered by %s.', 'team51' ), 'WordPress' ),
				/* translators: %s: Pressable. */
				'pressable' => sprintf( __( 'Hosted by %s.', 'team51' ), 'Pressable' ),
			)
		);

		$credit_links = array();

		if ( $args['wpcom'] ) {
			$partner_domain        = wp_parse_url( get_site_url(), PHP_URL_HOST );
			$wpcom_link            = apply_filters(
				'team51_credits_link_wpcom',
				add_query_arg(
					array(
						'partner_domain' => $partner_domain,
						'utm_source'     => 'Automattic',
						'utm_medium'     => 'colophon',
						'utm_campaign'   => 'Concierge Referral',
						'utm_term'       => $partner_domain,
					),
					'https://wordpress.com/wp/'
				)
			);
			$credit_links['wpcom'] = sprintf(
				'<a href="%1$s" class="imprint" target="_blank">%2$s</a>',
				esc_url( $wpcom_link ),
				esc_html( $args['wpcom'] )
			);
		}

		if ( $args['pressable'] ) {
			$pressable_link            = apply_filters(
				'team51_credits_link_pressable',
				add_query_arg(
					array(
						'utm_source'   => 'Automattic',
						'utm_medium'   => 'rpc',
						'utm_campaign' => 'Concierge Referral',
						'utm_term'     => 'concierge',
					),
					'https://pressable.com/'
				)
			);
			$credit_links['pressable'] = sprintf(
				'<a href="%1$s" class="imprint" target="_blank">%2$s</a>',
				esc_url( $pressable_link ),
				esc_html( $args['pressable'] )
			);
		}

		/**
		 * Filter the output links.
		 *
		 * This will enable folks to add additional links, remove links, or
		 * reroute links to internationalized versions if needed.
		 *
		 * @param array $credit_links The associative array of credit links.
		 * @param array $args         The parsed arguments used by `team51_credits()`.
		 */
		$credit_links = apply_filters( 'team51_credit_links', $credit_links, $args );

		$string = implode( esc_html( $args['separator'] ), $credit_links );

		// If we have an args['wrapper'] set, wrap the output in that.
		$has_wrapper = array_key_exists( 'wrapper', $args );
		if ( $has_wrapper ) {
			// Set the class, based on the passed wrapper.
			$wrapper_class = '' !== $args['wrapper'] ? esc_attr( $args['wrapper'] ) : 'colophon__wrapper';
			$string        = sprintf( '<span class="%1$s">%2$s</span>', $wrapper_class, $string );
		}

		/**
		 * Filters the output string.
		 *
		 * @param string $string The output string.
		 * @param array  $args   The parsed arguments used by `team51_credits()`.
		 * @return string The filtered output string.
		 */
		$string = apply_filters( 'team51_credits_render', $string, $args );

		echo $string;
	}
	add_action( 'team51_credits', 'team51_credits', 10, 1 );

endif;

if ( ! function_exists( 'team51_credits_shortcode' ) ) :

	/**
	 * The Shortcode for `[team51-credits /]` or `[team51-credits separator=" | " /]` or the like.
	 *
	 * Can also be used in the Shortcode block.
	 */
	function team51_credits_shortcode( $atts ) {
		$pairs = array(
			'separator' => ' ',
			/* translators: %s: WordPress. */
			'wpcom'     => sprintf( __( 'Proudly powered by %s.', 'team51' ), 'WordPress' ),
			/* translators: %s: Pressable. */
			'pressable' => sprintf( __( 'Hosted by %s.', 'team51' ), 'Pressable' ),
		);

		// Add the wrapper if set.
		if ( is_array( $atts ) && array_key_exists( 'wrapper', $atts ) ) {
			$pairs['wrapper'] = '' !== $atts['wrapper'] ? esc_attr( $atts['wrapper'] ) : 'colophon__wrapper';
		}

		$atts = shortcode_atts( $pairs, $atts, 'team51-credits' );
		ob_start();
		team51_credits( $atts );
		return ob_get_clean();
	}
	add_action(
		'init',
		function() {
			add_shortcode( 'team51-credits', 'team51_credits_shortcode' );
		}
	);

endif;
