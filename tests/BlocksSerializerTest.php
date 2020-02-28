<?php

namespace Tests\Beapi\Gutenberg;

use Beapi\Gutenberg\BlocksSerializer;
use PHPUnit\Framework\TestCase;

class BlocksSerializerTest extends TestCase {
	public function test_simple_block() {
		$bloc = [
			0 =>
				[
					'blockName'    => 'core/paragraph',
					'attrs'        =>
						[
							'blockSyncId' => '15b3ab34-1b17-495d-93c6-39975ca66522',
						],
					'innerBlocks'  =>
						[],
					'innerHTML'    => '
<p>This is a content</p>
',
					'innerContent' =>
						[
							0 => '
<p>This is a content</p>
',
						],
				],
			1 =>
				[
					'blockName'    => null,
					'attrs'        =>
						[],
					'innerBlocks'  =>
						[],
					'innerHTML'    => '

',
					'innerContent' =>
						[
							0 => '

',
						],
				],
			2 =>
				[
					'blockName'    => 'core/image',
					'attrs'        =>
						[
							'id'          => 8,
							'sizeSlug'    => 'large',
							'blockSyncId' => '2507718b-934b-4ac4-9d04-35495a018d22',
						],
					'innerBlocks'  =>
						[],
					'innerHTML'    => '
<figure class="wp-block-image size-large"><img src="https://dev.local/site1/wp-content/uploads/2020/01/image-test.jpg" alt="" class="wp-image-8"/></figure>
',
					'innerContent' =>
						[
							0 => '
<figure class="wp-block-image size-large"><img src="https://dev.local/site1/wp-content/uploads/2020/01/image-test.jpg" alt="" class="wp-image-8"/></figure>
',
						],
				],
		];

		$html = <<<BLOC
<!-- wp:paragraph {"blockSyncId":"15b3ab34-1b17-495d-93c6-39975ca66522"} -->
<p>This is a content</p>
<!-- /wp:paragraph -->

<!-- wp:image {"id":8,"sizeSlug":"large","blockSyncId":"2507718b-934b-4ac4-9d04-35495a018d22"} -->
<figure class="wp-block-image size-large"><img src="https://dev.local/site1/wp-content/uploads/2020/01/image-test.jpg" alt="" class="wp-image-8"/></figure>
<!-- /wp:image -->
BLOC;
		$this->assertEquals( $html, BlocksSerializer::from_array( $bloc ) );
	}

	public function test_nested_block() {

		$block = [
			0 =>
				[
					'blockName'    => 'core/paragraph',
					'attrs'        =>
						[
							'blockSyncId' => '15b3ab34-1b17-495d-93c6-39975ca66522',
						],
					'innerBlocks'  =>
						[],
					'innerHTML'    => '
<p>This is a content</p>
',
					'innerContent' =>
						[
							0 => '
<p>This is a content</p>
',
						],
				],
			1 =>
				[
					'blockName'    => null,
					'attrs'        =>
						[],
					'innerBlocks'  =>
						[],
					'innerHTML'    => '

',
					'innerContent' =>
						[
							0 => '

',
						],
				],
			2 =>
				[
					'blockName'    => 'core/image',
					'attrs'        =>
						[
							'id'          => 8,
							'sizeSlug'    => 'large',
							'blockSyncId' => '2507718b-934b-4ac4-9d04-35495a018d22',
						],
					'innerBlocks'  =>
						[],
					'innerHTML'    => '
<figure class="wp-block-image size-large"><img src="https://dev.local/site1/wp-content/uploads/2020/01/image-test.jpg" alt="" class="wp-image-8"/></figure>
',
					'innerContent' =>
						[
							0 => '
<figure class="wp-block-image size-large"><img src="https://dev.local/site1/wp-content/uploads/2020/01/image-test.jpg" alt="" class="wp-image-8"/></figure>
',
						],
				],
			3 =>
				[
					'blockName'    => null,
					'attrs'        =>
						[],
					'innerBlocks'  =>
						[],
					'innerHTML'    => '

',
					'innerContent' =>
						[
							0 => '

',
						],
				],
			4 =>
				[
					'blockName'    => 'core/cover',
					'attrs'        =>
						[
							'url'         => 'https://dev.local/site1/wp-content/uploads/2020/02/WordPress9.jpg',
							'id'          => 40,
							'blockSyncId' => '0726b4ee-fe12-4cbc-b733-da54c24d80ea',
						],
					'innerBlocks'  =>
						[
							0 =>
								[
									'blockName'    => 'core/paragraph',
									'attrs'        =>
										[
											'align'       => 'center',
											'placeholder' => 'Rédigez le titre…',
											'fontSize'    => 'large',
											'blockSyncId' => 'd3275f73-d634-481e-bf97-1bb1394650dc',
										],
									'innerBlocks'  =>
										[],
									'innerHTML'    => '
<p class="has-text-align-center has-large-font-size">This is a content</p>
',
									'innerContent' =>
										[
											0 => '
<p class="has-text-align-center has-large-font-size">This is a content</p>
',
										],
								],
						],
					'innerHTML'    => '
<div class="wp-block-cover has-background-dim" style="background-image:url(https://dev.local/site1/wp-content/uploads/2020/02/WordPress9.jpg)"><div class="wp-block-cover__inner-container"></div></div>
',
					'innerContent' =>
						[
							0 => '
<div class="wp-block-cover has-background-dim" style="background-image:url(https://dev.local/site1/wp-content/uploads/2020/02/WordPress9.jpg)"><div class="wp-block-cover__inner-container">',
							1 => null,
							2 => '</div></div>
',
						],
				],
		];

		$html = <<<BLOC
<!-- wp:paragraph {"blockSyncId":"15b3ab34-1b17-495d-93c6-39975ca66522"} -->
<p>This is a content</p>
<!-- /wp:paragraph -->

<!-- wp:image {"id":8,"sizeSlug":"large","blockSyncId":"2507718b-934b-4ac4-9d04-35495a018d22"} -->
<figure class="wp-block-image size-large"><img src="https://dev.local/site1/wp-content/uploads/2020/01/image-test.jpg" alt="" class="wp-image-8"/></figure>
<!-- /wp:image -->

<!-- wp:cover {"url":"https://dev.local/site1/wp-content/uploads/2020/02/WordPress9.jpg","id":40,"blockSyncId":"0726b4ee-fe12-4cbc-b733-da54c24d80ea"} -->
<div class="wp-block-cover has-background-dim" style="background-image:url(https://dev.local/site1/wp-content/uploads/2020/02/WordPress9.jpg)"><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Rédigez le titre…","fontSize":"large","blockSyncId":"d3275f73-d634-481e-bf97-1bb1394650dc"} -->
<p class="has-text-align-center has-large-font-size">This is a content</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->
BLOC;
		$this->assertEquals( $html, BlocksSerializer::from_array( $block ) );
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

		$this->assertEquals( $html, BlocksSerializer::from_array( $block ) );
	}

	public function test_multi_nested() {
		$block = [
			0 =>
				[
					'blockName'    => 'core/paragraph',
					'attrs'        =>
						[
							'blockSyncId' => '15b3ab34-1b17-495d-93c6-39975ca66522',
						],
					'innerBlocks'  =>
						[],
					'innerHTML'    => '
<p>This is a content</p>
',
					'innerContent' =>
						[
							0 => '
<p>This is a content</p>
',
						],
				],
			1 =>
				[
					'blockName'    => null,
					'attrs'        =>
						[],
					'innerBlocks'  =>
						[],
					'innerHTML'    => '

',
					'innerContent' =>
						[
							0 => '

',
						],
				],
			2 =>
				[
					'blockName'    => 'core/columns',
					'attrs'        =>
						[
							'blockSyncId' => 'c2ec1ef1-aed9-4f86-81cc-4686f50c61d8',
						],
					'innerBlocks'  =>
						[
							0 =>
								[
									'blockName'    => 'core/column',
									'attrs'        =>
										[
											'blockSyncId' => '0d1fc6dd-f3e7-4a77-80fa-0b2db1876ab9',
										],
									'innerBlocks'  =>
										[
											0 =>
												[
													'blockName'    => 'core/cover',
													'attrs'        =>
														[
															'url'         => 'https://dev.local/site1/wp-content/uploads/2020/01/pexels-photo-492934.jpeg',
															'id'          => 22,
															'blockSyncId' => '4f8440cf-704c-410a-b5b3-265cfb94e402',
														],
													'innerBlocks'  =>
														[
															0 =>
																[
																	'blockName'    => 'core/paragraph',
																	'attrs'        =>
																		[
																			'align'       => 'center',
																			'placeholder' => 'Rédigez le titre…',
																			'fontSize'    => 'large',
																			'blockSyncId' => '80eac88f-9884-4eb7-b047-f830c1d55839',
																		],
																	'innerBlocks'  =>
																		[],
																	'innerHTML'    => '
<p class="has-text-align-center has-large-font-size">Content</p>
',
																	'innerContent' =>
																		[
																			0 => '
<p class="has-text-align-center has-large-font-size">Content</p>
',
																		],
																],
														],
													'innerHTML'    => '
<div class="wp-block-cover has-background-dim" style="background-image:url(https://dev.local/site1/wp-content/uploads/2020/01/pexels-photo-492934.jpeg)"><div class="wp-block-cover__inner-container"></div></div>
',
													'innerContent' =>
														[
															0 => '
<div class="wp-block-cover has-background-dim" style="background-image:url(https://dev.local/site1/wp-content/uploads/2020/01/pexels-photo-492934.jpeg)"><div class="wp-block-cover__inner-container">',
															1 => null,
															2 => '</div></div>
',
														],
												],
										],
									'innerHTML'    => '
<div class="wp-block-column"></div>
',
									'innerContent' =>
										[
											0 => '
<div class="wp-block-column">',
											1 => null,
											2 => '</div>
',
										],
								],
							1 =>
								[
									'blockName'    => 'core/column',
									'attrs'        =>
										[
											'blockSyncId' => '08b56e77-db13-4e47-82d6-5a2b0d53fdb9',
										],
									'innerBlocks'  =>
										[
											0 =>
												[
													'blockName'    => 'core/image',
													'attrs'        =>
														[
															'id'          => 54,
															'sizeSlug'    => 'large',
															'blockSyncId' => '482efd6c-50f9-46c4-902d-3dbbe7c5f9b8',
														],
													'innerBlocks'  =>
														[],
													'innerHTML'    => '
<figure class="wp-block-image size-large"><img src="https://dev.local/site1/wp-content/uploads/2020/01/WordPress6.jpg" alt="" class="wp-image-54"/></figure>
',
													'innerContent' =>
														[
															0 => '
<figure class="wp-block-image size-large"><img src="https://dev.local/site1/wp-content/uploads/2020/01/WordPress6.jpg" alt="" class="wp-image-54"/></figure>
',
														],
												],
										],
									'innerHTML'    => '
<div class="wp-block-column"></div>
',
									'innerContent' =>
										[
											0 => '
<div class="wp-block-column">',
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

		$html = <<<BLOC
<!-- wp:paragraph {"blockSyncId":"15b3ab34-1b17-495d-93c6-39975ca66522"} -->
<p>This is a content</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"blockSyncId":"c2ec1ef1-aed9-4f86-81cc-4686f50c61d8"} -->
<div class="wp-block-columns"><!-- wp:column {"blockSyncId":"0d1fc6dd-f3e7-4a77-80fa-0b2db1876ab9"} -->
<div class="wp-block-column"><!-- wp:cover {"url":"https://dev.local/site1/wp-content/uploads/2020/01/pexels-photo-492934.jpeg","id":22,"blockSyncId":"4f8440cf-704c-410a-b5b3-265cfb94e402"} -->
<div class="wp-block-cover has-background-dim" style="background-image:url(https://dev.local/site1/wp-content/uploads/2020/01/pexels-photo-492934.jpeg)"><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Rédigez le titre…","fontSize":"large","blockSyncId":"80eac88f-9884-4eb7-b047-f830c1d55839"} -->
<p class="has-text-align-center has-large-font-size">Content</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column {"blockSyncId":"08b56e77-db13-4e47-82d6-5a2b0d53fdb9"} -->
<div class="wp-block-column"><!-- wp:image {"id":54,"sizeSlug":"large","blockSyncId":"482efd6c-50f9-46c4-902d-3dbbe7c5f9b8"} -->
<figure class="wp-block-image size-large"><img src="https://dev.local/site1/wp-content/uploads/2020/01/WordPress6.jpg" alt="" class="wp-image-54"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
BLOC;

		$this->assertEquals( $html, BlocksSerializer::from_array( $block ) );
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

		$this->assertEquals( $html, BlocksSerializer::from_array( $block ) );
	}

}
