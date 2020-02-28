<?php

namespace Beapi\Gutenberg;

class BlocksSerializer {

	/**
	 * Transform parsed blocks into HTML for Gutenberg.
	 * Supports nesting and classic.
	 *
	 * @param array $content : The content from \parse_blocks function structure.
	 *
	 * @return string : HTML content from block array.
	 * @author Nicolas JUEN
	 */
	public static function from_array( array $content ): string {
		$processed_content = '';
		foreach ( $content as $block ) {
			$processed_content .= self::process_block( $block );
		}

		return $processed_content;
	}

	private static function process_block( array $bloc, bool $is_inner = false ): string {
		$inner_content = '';

		/**
		 * Handle the classic 'block'
		 */
		if ( empty( $bloc['blockName'] ) && ! empty( $bloc['innerHTML'] ) ) {
			return $bloc['innerHTML'];
		}

		/**
		 * Handle empty lines
		 */
		if ( empty( $bloc['blockName'] ) ) {
			return $inner_content;
		}

		/**
		 * Process the inner blocks
		 */
		$inner_blocks = [];
		if ( ! empty( $bloc['innerBlocks'] ) ) {
			foreach ( $bloc['innerBlocks'] as $inner_block ) {
				$inner_blocks[] = self::process_block( $inner_block, true );
			}
		}

		$inner_content_count = count( $bloc['innerContent'] );
		if ( 1 === $inner_content_count ) {
			$inner_content = reset( $bloc['innerContent'] );
		} else {
			/**
			 * Following the spec for the innerContent :
			 *  @example array(
			 *   'innerHTML'    => 'BeforeInnerAfter',
			 *   'innerBlocks'  => array( block, block ),
			 *   'innerContent' => array( 'Before', null, 'Inner', null, 'After' ),
			 * )
			 * Gluing the innerBlocks between them with the Inner entry if needed
			 *
			 */
			$glue = $inner_content_count > 3 ? $bloc['innerContent'][2] : '';
			$inner_content = reset( $bloc['innerContent'] ) . implode( $glue, $inner_blocks ) . end( $bloc['innerContent'] );
		}

		/**
		 * Core needs to be without core/ to be wp:image
		 * Eveyrthing else have wp:block_name
		 */
		$block_name = 'wp:' . ( false !== \strpos( $bloc['blockName'], 'core/' )
				? \str_replace( 'core/', '', $bloc['blockName'] )
				: $bloc['blockName'] );

		$attributes = ! empty( $bloc['attrs'] )
			? \json_encode( $bloc['attrs'], \ JSON_FORCE_OBJECT | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE )
			: '';

		/**
		 * Handle the single blocks without innerHTML.
		 */
		if ( empty( $bloc['innerHTML'] ) ) {
			return \sprintf( '<!-- %1$s %2$s /-->', $block_name, $attributes );
		}

		/**
		 * We need
		 * <!-- block attributes -->
		 * innercontent
		 * <!-- /block -->
		 */
		$text_return = \sprintf( '<!-- %1$s %2$s -->', $block_name, $attributes );
		$text_return .= $inner_content;
		$text_return .= \sprintf( '<!-- /%1$s -->', $block_name );

		return $text_return;
	}
}
