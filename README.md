# gutenberg-serializer
Package to transform Gutenberg block array to a Gutenberg firendly string

# Purpose
This package allows you to use a block array from "parse_blocs" for example, and serialize it into Gutenberg compatible content.
This can be used to migrate content from blocs or programmatically generate content for Gutenberg.
The library supports innerBlocs.

# Example
```php
$bloc = [
		[
			'blockName'    => 'core/paragraph',
			'attrs'        =>
				[
					'id' => 4
				],
			'innerBlocks'  => [],
			'innerHTML'    => '
				<p>This is a content</p>
			',
			'innerContent' => [
				0 => '
				<p>This is a content</p>
				',
			],
		]
];
$content = BlocksSerializer::from_array( $bloc );
```

Will become :
```
<!-- wp:paragraph {"id":"4"} -->
<p>This is a content</p>
<!-- /wp:paragraph -->
```

# Commands
You have commands into the project :
- `composer cs` : Check the coding standards
- `composer cbf` : Beautify automatically all the files of the project
- `composer test` : Launch the tests 
- `composer psalm`: Launch psalm on the files
