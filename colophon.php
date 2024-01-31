<?php
/*
Plugin Name: Colophon
Plugin URI: https://github.com/a8cteam51/colophon
Description: Sets Team 51 footer links to WordPress.com and Pressable.
Version: 1.3.0
Author: WordPress.com Special Projects
Author URI: https://wpspecialprojects.wordpress.com/
License: GPLv3
*/

if ( ! function_exists( 'team51_credits' ) ) :


	/**
	 * A wrapper to the colophon generating method for WordPress Special Projects Sites.
	 * Echoes a the resulting credit links
	 *
	 * Usage: team51_credits( 'separator= | ' );
	 *
	 * @param array{separator?: string, wpcom?: string, pressable?: string} $args The Args passed to the function.
	 *
	 * @return void
	 */
	function team51_credits( $args = array() ) {
		echo apply_filters( 'team51_credits_filter', '', $args ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * A colophon-generating method for WordPress Special Projects Sites.
	 *
	 * Usage: team51_credits( 'separator= | ' );
	 *
	 * @param string $str The string that will be used for the filter. Will be overriden
	 * @param array{separator?: string, wpcom?: string, pressable?: string} $args The Args passed to the function.
	 *
	 * @return string the resulting credits link
	 */
	function team51_credits_filter( $str = '', $args = array() ) {
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

		$credit_links   = array();
		$parsed_url     = wp_parse_url( get_site_url(), PHP_URL_HOST );
		$partner_domain = $parsed_url ? $parsed_url : 'wpspecialprojects.com';

		if ( $args['wpcom'] ) {
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
				'<a href="%1$s" class="imprint" target="_blank" rel="nofollow">%2$s</a>',
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
						'utm_term'     => $partner_domain,
					),
					'https://pressable.com/'
				)
			);
			$credit_links['pressable'] = sprintf(
				'<a href="%1$s" class="imprint" target="_blank" rel="nofollow">%2$s</a>',
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

		return implode(
			esc_html( $args['separator'] ),
			$credit_links //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, this cant be escaped as it runs through a filter
		);
	}

	add_action( 'team51_credits', 'team51_credits', 10, 1 );
	add_filter( 'team51_credits_filter', 'team51_credits_filter', 10, 2 );
endif;

if ( ! function_exists( 'team51_credits_shortcode' ) ) :

	/**
	 * The Shortcode for `[team51-credits /]` or `[team51-credits separator=" | " /]` or the like.
	 *
	 * Can also be used in the Shortcode block.
	 *
	 * @param array{separator?: string, wpcom?: string, pressable?: string} $atts The Args passed to the function.
	 *
	 * @return string
	 */
	function team51_credits_shortcode( $atts ) {
		$pairs = array(
			'separator' => ' ',
			/* translators: %s: WordPress. */
			'wpcom'     => sprintf( __( 'Proudly powered by %s.', 'team51' ), 'WordPress' ),
			/* translators: %s: Pressable. */
			'pressable' => sprintf( __( 'Hosted by %s.', 'team51' ), 'Pressable' ),
		);

		$atts = shortcode_atts( $pairs, $atts, 'team51-credits' );

		ob_start();
		team51_credits( $atts );
		return ob_get_clean();
	}
	add_action(
		'init',
		function () {
			add_shortcode( 'team51-credits', 'team51_credits_shortcode' );
		}
	);
endif;

if ( ! function_exists( 'team51_current_year_shortcode' ) ) :

	/**
	 * The Shortcode for `[team51-current-year]`.
	 *
	 * Can also be used in the Shortcode block.
	 *
	 * @param array{format?: string} $atts The Args passed to the function.
	 *
	 * @return string
	 */
	function team51_current_year_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'format' => 'Y',
			),
			$atts,
			'team51-current-year'
		);

		$current_year = gmdate( $atts['format'] );
		return esc_html( $current_year );
	}
	add_action(
		'init',
		function () {
			add_shortcode( 'team51-current-year', 'team51_current_year_shortcode' );
		}
	);
endif;
