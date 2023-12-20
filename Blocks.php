<?php

namespace Team51\Colophon;

defined( 'ABSPATH' ) || exit;

/**
 * Handles the registration of blocks.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Blocks {
	private const BLOCKS_PATH = __DIR__ . \DIRECTORY_SEPARATOR . 'blocks' . \DIRECTORY_SEPARATOR;

	// region METHODS

	/**
	 * Initializes the blocks.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  void
	 */
	public function initialize(): void {
		\add_action( 'init', array( $this, 'register_blocks' ) );
		\add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
	}

	// endregion

	// region HOOKS

	/**
	 * Registers the blocks with Gutenberg.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  void
	 */
	public function register_blocks(): void {
		\register_block_type(
			self::BLOCKS_PATH . 'build/colophon',
			array( 'render_callback' => array( $this, 'render_colophon_block' ) )
		);
	}

	/**
	 * Registers a plugin-level script for the block editor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  void
	 */
	public function enqueue_block_editor_assets(): void {
		// do nothing for now.
	}

	/**
	 * Renders the colophon block.
	 *
	 * @since   1.0.0
	 *
	 * @param   array<string, mixed> $attributes The block attributes.
	 * @param   string               $content    The block content.
	 * @param   \WP_Block            $block      The block object.
	 *
	 * @return  string
	 */
	public function render_colophon_block( array $attributes, string $content, \WP_Block $block ): string { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		// Define the args.
		$args = array(
			'separator' => \esc_attr( $attributes['separator'] ),
			'wpcom'     => \esc_html( $attributes['wpComLink'] ),
			'pressable' => \esc_html( $attributes['pressableLink'] ),
		);

		if ( true === (bool) $attributes['hasWrapper'] ) {
			$args['wrapper'] = \esc_attr( $attributes['wrapperClassName'] );
		}
		return team51_credits_shortcode( $args );
	}

	// endregion
}
