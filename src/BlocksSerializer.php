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
	public static function from_array( array $content ) : string {
		$processed_content = '';
		foreach ( $content as $block ) {
			$processed_content .= self::process_block( $block );
		}
		return $processed_content;
	}

	private static function process_block( array $bloc, $is_inner = false ): string {
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

		if ( 1 === count( $bloc['innerContent'] ) ) {
			$inner_content = $bloc['innerHTML'];
		} else {
			$inner_content = \reset( $bloc['innerContent'] ) . \implode( '', $inner_blocks ) . \end( $bloc['innerContent'] );
		}

		/**
		 * Core needs to be without core/ to be wp:image
		 * Eveyrthing else have wp:block_name
		 */
		$block_name = 'wp:' . ( false !== \strpos( $bloc['blockName'], 'core/' )
				?
				\str_replace( 'core/', '', $bloc['blockName'] )
				:
				$bloc['blockName'] );
		$attributes = \json_encode( $bloc['attrs'], \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE );

		/**
		 * Add line breaks as Gutenberg do.
		 */
		$after = false === $is_inner ? "\n\n" : '';

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
		$text_return .= \sprintf( '<!-- /%1$s -->' . $after, $block_name );

		return $text_return;
	}
}
