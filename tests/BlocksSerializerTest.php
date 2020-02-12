<?php

namespace Tests\Beapi\Gutenberg;

use Beapi\Gutenberg\BlocksSerializer;
use PHPUnit\Framework\TestCase;

class BlocksSerializerTest extends TestCase {
	public function test_simple_block() {
		$bloc = [
			[
				'blockName'    => 'core/image',
				'attrs'        =>
					[
						'id'          => 13,
						'sizeSlug'    => 'large',
						'className'   => 'is-style-default',
						'blockSyncId' => '055f9c65-3966-4a7b-ad7a-3c83154a9861',
					],
				'innerBlocks'  =>
					[],
				'innerHTML'    => '
<figure class="wp-block-image size-large is-style-default"><img src="http://dev.local/wp-content/uploads/2020/02/WordPress9.jpg" alt="" class="wp-image-13"/></figure>
',
				'innerContent' =>
					[
						0 => '
<figure class="wp-block-image size-large is-style-default"><img src="http://dev.local/wp-content/uploads/2020/02/WordPress9.jpg" alt="" class="wp-image-13"/></figure>
',
					],
			],
		];

		$html = '<!-- wp:image {"id":13,"sizeSlug":"large","className":"is-style-default","blockSyncId":"055f9c65-3966-4a7b-ad7a-3c83154a9861"} -->
<figure class="wp-block-image size-large is-style-default"><img src="http://dev.local/wp-content/uploads/2020/02/WordPress9.jpg" alt="" class="wp-image-13"/></figure>
<!-- /wp:image -->

';
		$this->assertEquals( BlocksSerializer::from_array( $bloc ), $html );
	}

	public function test_nested_block() {

		$block = [
			[
				'blockName'    => 'core/cover',
				'attrs'        =>
					[
						'url'         => 'http://dev.local/wp-content/uploads/2020/02/WordPress2.jpg',
						'id'          => 6,
						'blockSyncId' => 'd6e476b4-1002-4e99-8a5a-85bc7ad6bfe5',
					],
				'innerBlocks'  =>
					[
						0 =>
							[
								'blockName'    => 'core/paragraph',
								'attrs'        =>
									[
										'align'       => 'center',
										'placeholder' => 'Write title…',
										'fontSize'    => 'large',
										'blockSyncId' => '601ab9a6-60b2-47d4-a4bf-95732eb7f59c',
									],
								'innerBlocks'  =>
									[],
								'innerHTML'    => '
<p class="has-text-align-center has-large-font-size">LE TITRE</p>
',
								'innerContent' =>
									[
										0 => '
<p class="has-text-align-center has-large-font-size">LE TITRE</p>
',
									],
							],
					],
				'innerHTML'    => '
<div class="wp-block-cover has-background-dim" style="background-image:url(http://dev.local/wp-content/uploads/2020/02/WordPress2.jpg)"><div class="wp-block-cover__inner-container"></div></div>
',
				'innerContent' =>
					[
						0 => '
<div class="wp-block-cover has-background-dim" style="background-image:url(http://dev.local/wp-content/uploads/2020/02/WordPress2.jpg)"><div class="wp-block-cover__inner-container">',
						1 => null,
						2 => '</div></div>
',
					],
			],
		];

		$html = '<!-- wp:cover {"url":"http://dev.local/wp-content/uploads/2020/02/WordPress2.jpg","id":6,"blockSyncId":"d6e476b4-1002-4e99-8a5a-85bc7ad6bfe5"} -->
<div class="wp-block-cover has-background-dim" style="background-image:url(http://dev.local/wp-content/uploads/2020/02/WordPress2.jpg)"><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…","fontSize":"large","blockSyncId":"601ab9a6-60b2-47d4-a4bf-95732eb7f59c"} -->
<p class="has-text-align-center has-large-font-size">LE TITRE</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->

';
		$this->assertEquals( BlocksSerializer::from_array( $block ), $html );
	}

	public function test_classic() {
		$block = [
			array(
				'blockName'    => null,
				'attrs'        =>
					array(),
				'innerBlocks'  =>
					array(),
				'innerHTML'    => '<p>test</p> <ul><li>test</li></ul>',
				'innerContent' =>
					array(
						0 => '<p>test</p> <ul><li>test</li></ul>',
					),
			),
		];
		$html = '<p>test</p> <ul><li>test</li></ul>';

		$this->assertEquals( BlocksSerializer::from_array( $block ), $html );
	}

	public function test_multi_nested() {
		$block = [
			[
				'blockName'    => 'core/columns',
				'attrs'        =>
					[
						'blockSyncId' => 'ec01dd34-a64a-44e6-88ca-ae7485b61453',
					],
				'innerBlocks'  =>
					[
						0 =>
							[
								'blockName'    => 'core/column',
								'attrs'        =>
									[
										'width'       => 66.66,
										'blockSyncId' => '311104a8-b058-4c09-8e6b-001712541414',
									],
								'innerBlocks'  =>
									[
										0 =>
											[
												'blockName'    => 'core/image',
												'attrs'        =>
													[
														'id'          => 11,
														'sizeSlug'    => 'large',
														'className'   => 'is-style-default',
														'blockSyncId' => 'bf6caa6b-c89b-4a3f-89cb-9b85ba453249',
													],
												'innerBlocks'  =>
													[],
												'innerHTML'    => '
<figure class="wp-block-image size-large is-style-default"><img src="http://dev.local/wp-content/uploads/2020/02/WordPress7.jpg" alt="" class="wp-image-11"/></figure>
',
												'innerContent' =>
													[
														0 => '
<figure class="wp-block-image size-large is-style-default"><img src="http://dev.local/wp-content/uploads/2020/02/WordPress7.jpg" alt="" class="wp-image-11"/></figure>
',
													],
											],
										1 =>
											[
												'blockName'    => 'core/list',
												'attrs'        =>
													[
														'blockSyncId' => '6f8c4cb7-f3ca-43ca-b569-2aeb7d9183ce',
													],
												'innerBlocks'  =>
													[],
												'innerHTML'    => '
<ul><li>1er element</li><li>2ème element</li><li>3ème élément</li></ul>
',
												'innerContent' =>
													[
														0 => '
<ul><li>1er element</li><li>2ème element</li><li>3ème élément</li></ul>
',
													],
											],
										2 =>
											[
												'blockName'    => 'core/paragraph',
												'attrs'        =>
													[
														'blockSyncId' => 'cba8cc44-a74e-4c1e-beef-4d4e8067b705',
													],
												'innerBlocks'  =>
													[],
												'innerHTML'    => '
<p>Paragraphe</p>
',
												'innerContent' =>
													[
														0 => '
<p>Paragraphe</p>
',
													],
											],
									],
								'innerHTML'    => '
<div class="wp-block-column" style="flex-basis:66.66%">



</div>
',
								'innerContent' =>
									[
										0 => '
<div class="wp-block-column" style="flex-basis:66.66%">',
										1 => null,
										2 => '

',
										3 => null,
										4 => '

',
										5 => null,
										6 => '</div>
',
									],
							],
						1 =>
							[
								'blockName'    => 'core/column',
								'attrs'        =>
									[
										'width'       => 33.33,
										'blockSyncId' => 'c8da17d3-144e-4219-a12e-45052a9c1aac',
									],
								'innerBlocks'  =>
									[
										0 =>
											[
												'blockName'    => 'core/cover',
												'attrs'        =>
													[
														'url'         => 'http://dev.local/wp-content/uploads/2020/02/WordPress2.jpg',
														'id'          => 6,
														'blockSyncId' => 'd6e476b4-1002-4e99-8a5a-85bc7ad6bfe5',
													],
												'innerBlocks'  =>
													[
														0 =>
															[
																'blockName'    => 'core/paragraph',
																'attrs'        =>
																	[
																		'align'       => 'center',
																		'placeholder' => 'Write title…',
																		'fontSize'    => 'large',
																		'blockSyncId' => '601ab9a6-60b2-47d4-a4bf-95732eb7f59c',
																	],
																'innerBlocks'  =>
																	[],
																'innerHTML'    => '
<p class="has-text-align-center has-large-font-size">LE TITRE</p>
',
																'innerContent' =>
																	[
																		0 => '
<p class="has-text-align-center has-large-font-size">LE TITRE</p>
',
																	],
															],
													],
												'innerHTML'    => '
<div class="wp-block-cover has-background-dim" style="background-image:url(http://dev.local/wp-content/uploads/2020/02/WordPress2.jpg)"><div class="wp-block-cover__inner-container"></div></div>
',
												'innerContent' =>
													[
														0 => '
<div class="wp-block-cover has-background-dim" style="background-image:url(http://dev.local/wp-content/uploads/2020/02/WordPress2.jpg)"><div class="wp-block-cover__inner-container">',
														1 => null,
														2 => '</div></div>
',
													],
											],
									],
								'innerHTML'    => '
<div class="wp-block-column" style="flex-basis:33.33%"></div>
',
								'innerContent' =>
									[
										0 => '
<div class="wp-block-column" style="flex-basis:33.33%">',
										1 => null,
										2 => '</div>
',
									],
							],
					],
				'innerHTML'    => '
<div class="wp-block-columns">

</div>
',
				'innerContent' =>
					[
						0 => '
<div class="wp-block-columns">',
						1 => null,
						2 => '

',
						3 => null,
						4 => '</div>
',
					],
			],
		];

		$html = '<!-- wp:columns {"blockSyncId":"ec01dd34-a64a-44e6-88ca-ae7485b61453"} -->
<div class="wp-block-columns"><!-- wp:column {"width":66.66,"blockSyncId":"311104a8-b058-4c09-8e6b-001712541414"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:image {"id":11,"sizeSlug":"large","className":"is-style-default","blockSyncId":"bf6caa6b-c89b-4a3f-89cb-9b85ba453249"} -->
<figure class="wp-block-image size-large is-style-default"><img src="http://dev.local/wp-content/uploads/2020/02/WordPress7.jpg" alt="" class="wp-image-11"/></figure>
<!-- /wp:image --><!-- wp:list {"blockSyncId":"6f8c4cb7-f3ca-43ca-b569-2aeb7d9183ce"} -->
<ul><li>1er element</li><li>2ème element</li><li>3ème élément</li></ul>
<!-- /wp:list --><!-- wp:paragraph {"blockSyncId":"cba8cc44-a74e-4c1e-beef-4d4e8067b705"} -->
<p>Paragraphe</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --><!-- wp:column {"width":33.33,"blockSyncId":"c8da17d3-144e-4219-a12e-45052a9c1aac"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:cover {"url":"http://dev.local/wp-content/uploads/2020/02/WordPress2.jpg","id":6,"blockSyncId":"d6e476b4-1002-4e99-8a5a-85bc7ad6bfe5"} -->
<div class="wp-block-cover has-background-dim" style="background-image:url(http://dev.local/wp-content/uploads/2020/02/WordPress2.jpg)"><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…","fontSize":"large","blockSyncId":"601ab9a6-60b2-47d4-a4bf-95732eb7f59c"} -->
<p class="has-text-align-center has-large-font-size">LE TITRE</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

';

		$this->assertEquals( BlocksSerializer::from_array( $block ), $html );
	}

	public function test_not_core() {
		$block = [
			[
				'blockName'    => 'acf/testimonial',
				'attrs'        =>
					[
						'id'          => 'block_5e42af13de3e5',
						'name'        => 'acf/testimonial',
						'data'        =>
							[
								'field_5e42addec035a' => 'J\'aime pas les endives',
								'field_5e42ade8c035b' => '28',
							],
						'align'       => '',
						'mode'        => 'edit',
						'blockSyncId' => '0570decc-6db7-4bed-9fac-a8ca20ba8e6f',
					],
				'innerBlocks'  =>
					[],
				'innerHTML'    => '',
				'innerContent' =>
					[],
			],
		];

		$html = '<!-- wp:acf/testimonial {"id":"block_5e42af13de3e5","name":"acf/testimonial","data":{"field_5e42addec035a":"J\'aime pas les endives","field_5e42ade8c035b":"28"},"align":"","mode":"edit","blockSyncId":"0570decc-6db7-4bed-9fac-a8ca20ba8e6f"} /-->';

		$this->assertEquals( BlocksSerializer::from_array( $block ), $html );
	}

}
